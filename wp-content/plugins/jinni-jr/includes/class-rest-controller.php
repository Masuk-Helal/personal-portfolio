<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * REST API controller for Jinni Jr chat.
 */
class Jinni_Jr_REST_Controller {

    private $database;
    private $settings;
    private $namespace = 'jinni-jr/v1';

    public function __construct($database, $settings) {
        $this->database = $database;
        $this->settings = $settings;
    }

    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/messages',
            array(
                array(
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => array($this, 'handle_message'),
                    'permission_callback' => '__return_true',
                    'args'                => array(
                        'visitor_token'   => array(
                            'required'          => true,
                            'type'              => 'string',
                            'sanitize_callback' => 'sanitize_text_field',
                        ),
                        'conversation_id'   => array(
                            'required'          => false,
                            'type'              => 'integer',
                            'sanitize_callback' => 'absint',
                        ),
                        'message'           => array(
                            'required'          => true,
                            'type'              => 'string',
                            'sanitize_callback' => function($val) {
                                return wp_kses_post(trim($val));
                            },
                        ),
                    ),
                ),
            )
        );

        register_rest_route(
            $this->namespace,
            '/config',
            array(
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array($this, 'handle_config'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }

    public function handle_message($request) {
        $visitor_token = $request->get_param('visitor_token');
        $conversation_id = $request->get_param('conversation_id');
        $message = $request->get_param('message');

        if (empty($visitor_token) || empty($message)) {
            return new WP_Error('invalid_input', __('Visitor token and message are required.', 'jinni-jr'), array('status' => 400));
        }

        if (strlen($message) > 4000) {
            return new WP_Error('message_too_long', __('Message is too long.', 'jinni-jr'), array('status' => 400));
        }

        global $wpdb;

        // Find or create visitor
        $visitor_id = $this->find_or_create_visitor($visitor_token);

        // Find or create conversation
        if (empty($conversation_id)) {
            $conversation_id = $this->create_conversation($visitor_id);
        } else {
            $this->update_conversation_timestamp($conversation_id);
        }

        // Save visitor message
        $this->save_message($conversation_id, 'user', $message);

        // Build prompt and get LLM reply
        $system_prompt = $this->settings->get_option('system_prompt');
        $visitor = $this->get_visitor($visitor_id);
        $summary = $this->get_latest_summary($visitor_id);

        $prompt = $this->build_prompt($system_prompt, $visitor, $summary, $message);

        $reply = $this->call_llm($prompt, $message);
        if (is_wp_error($reply)) {
            return $reply;
        }

        // Save assistant reply
        $this->save_message($conversation_id, 'assistant', $reply);

        // Generate summary (simple approach)
        $this->update_summary($visitor_id, $conversation_id, $message, $reply);

        return array(
            'conversation_id' => (int) $conversation_id,
            'reply'           => $reply,
        );
    }

    public function handle_config() {
        return array(
            'widget_enabled' => true,
            'provider'       => $this->settings->get_option('provider'),
        );
    }

    private function find_or_create_visitor($visitor_token) {
        global $wpdb;
        $table = JINNI_JR_TABLE_VISITORS;

        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM {$table} WHERE visitor_token = %s",
            $visitor_token
        ));

        if ($existing) {
            $wpdb->update(
                $table,
                array('last_seen_at' => current_time('mysql')),
                array('id' => $existing->id),
                array('%s'),
                array('%d')
            );
            return (int) $existing->id;
        }

        $ip = $this->get_visitor_ip();
        $now = current_time('mysql');
        $wpdb->insert(
            $table,
            array(
                'visitor_token'   => $visitor_token,
                'ip_address'      => $ip,
                'first_seen_at'   => $now,
                'last_seen_at'    => $now,
                'created_at'      => $now,
                'updated_at'      => $now,
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s')
        );

        return (int) $wpdb->insert_id;
    }

    private function get_visitor($visitor_id) {
        global $wpdb;
        $table = JINNI_JR_TABLE_VISITORS;
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE id = %d",
            $visitor_id
        ));
    }

    private function create_conversation($visitor_id) {
        global $wpdb;
        $table = JINNI_JR_TABLE_CONVERSATIONS;
        $now = current_time('mysql');
        $wpdb->insert(
            $table,
            array(
                'visitor_id'     => $visitor_id,
                'started_at'     => $now,
                'last_message_at'=> $now,
                'created_at'     => $now,
                'updated_at'     => $now,
            ),
            array('%d', '%s', '%s', '%s', '%s')
        );
        return (int) $wpdb->insert_id;
    }

    private function update_conversation_timestamp($conversation_id) {
        global $wpdb;
        $table = JINNI_JR_TABLE_CONVERSATIONS;
        $wpdb->update(
            $table,
            array('last_message_at' => current_time('mysql')),
            array('id' => $conversation_id),
            array('%s'),
            array('%d')
        );
    }

    private function save_message($conversation_id, $role, $message) {
        global $wpdb;
        $table = JINNI_JR_TABLE_MESSAGES;
        $wpdb->insert(
            $table,
            array(
                'conversation_id' => $conversation_id,
                'role'            => $role,
                'message'         => $message,
            ),
            array('%d', '%s', '%s')
        );
    }

    private function get_latest_summary($visitor_id) {
        global $wpdb;
        $table = JINNI_JR_TABLE_CONVERSATIONS;
        return $wpdb->get_var($wpdb->prepare(
            "SELECT conversation_summary FROM {$table} WHERE visitor_id = %d ORDER BY started_at DESC LIMIT 1",
            $visitor_id
        ));
    }

    private function build_prompt($system_prompt, $visitor, $summary, $user_message) {
        $parts = array();

        if (!empty($system_prompt)) {
            $entries = get_posts(array(
                'post_type' => 'jinni_knowledge',
                'post_status' => 'publish',
                'posts_per_page' => 20,
                'orderby' => 'date',
                'order' => 'DESC',
            ));
            $knowledge = array();
            foreach ($entries as $entry) {
                $knowledge[] = wp_strip_all_tags($entry->post_title) . "\n" . wp_strip_all_tags($entry->post_content);
            }
            $knowledge_text = substr(implode("\n\n", $knowledge), 0, 30000);
            $parts[] = strtr($this->settings->prompt_with_placeholders($system_prompt), array(
                '{{user message}}' => $user_message,
                '{{knowledge}}' => $knowledge_text,
            ));
        }

        if ($visitor) {
            $visitor_context = "Visitor details: ";
            if (!empty($visitor->name)) {
                $visitor_context .= "Name: " . esc_html($visitor->name) . ". ";
            } else {
                $visitor_context .= "Name: not provided (use a friendly temporary nickname). ";
            }
            if (!empty($visitor->email)) {
                $visitor_context .= "Email: " . esc_html($visitor->email) . ". ";
            }
            $visitor_context .= "IP: " . esc_html($visitor->ip_address) . ". ";
            $visitor_context .= "First seen: " . esc_html($visitor->first_seen_at) . ". ";
            $parts[] = $visitor_context;
        }

        if ($summary) {
            $parts[] = "Previous conversation summary: " . esc_html($summary);
        }

        if (empty($system_prompt)) {
            $parts[] = "Visitor message: " . $user_message;
        }

        return implode("\n\n", $parts);
    }

    private function call_llm($prompt, $user_message) {
        $provider = $this->settings->get_option('provider');
        $model = $this->settings->get_option('model');
        $api_key = $this->settings->get_provider_key($provider);

        if (in_array($provider, array('anthropic', 'openai'), true)) {
            return $this->call_direct_provider($prompt, $user_message, $provider, $model, $api_key);
        }
        if ('openrouter' !== $provider) {
            return new WP_Error('jinni_provider', __('Select a supported provider in Jinni Jr settings.', 'jinni-jr'), array('status' => 502));
        }

        return $this->call_openrouter($prompt, $model, $api_key, $user_message);
    }

    private function call_direct_provider($prompt, $user_message, $provider, $model, $api_key) {
        if (!$api_key || !$model) {
            return new WP_Error('jinni_ai_config', __('Add an API key and select a model in Jinni Jr settings.', 'jinni-jr'), array('status' => 502));
        }
        $anthropic = 'anthropic' === $provider;
        $url = $anthropic ? 'https://api.anthropic.com/v1/messages' : 'https://api.openai.com/v1/chat/completions';
        $headers = $anthropic ? array('x-api-key' => $api_key, 'anthropic-version' => '2023-06-01') : array('Authorization' => 'Bearer ' . $api_key);
        $headers['Content-Type'] = 'application/json';
        $body = array('model' => $model, 'messages' => array(array('role' => 'user', 'content' => $user_message)));
        if ($anthropic) {
            $body['system'] = $prompt;
            $body['max_tokens'] = 1024;
        } else {
            array_unshift($body['messages'], array('role' => 'system', 'content' => $prompt));
        }
        $response = wp_remote_post($url, array('timeout' => 60, 'headers' => $headers, 'body' => wp_json_encode($body)));
        if (is_wp_error($response)) {
            return new WP_Error('jinni_ai_connection', __('Could not connect to the AI provider. Please try again later.', 'jinni-jr'), array('status' => 502));
        }
        if (200 !== wp_remote_retrieve_response_code($response)) {
            $error_body = json_decode(wp_remote_retrieve_body($response), true);
            $error_code = isset($error_body['error']['code']) && is_string($error_body['error']['code']) ? $error_body['error']['code'] : '';
            $status = wp_remote_retrieve_response_code($response);
            if (in_array($error_code, array('credit_balance_exhausted', 'insufficient_quota', 'billing_hard_limit_reached'), true) || 402 === $status) {
                $message = __('The AI provider reports insufficient API credits or quota. Check the provider’s billing settings.', 'jinni-jr');
            } elseif ('model_not_found' === $error_code || 404 === $status) {
                $message = __('The selected model is unavailable for this API key. Choose another model in Jinni Jr settings.', 'jinni-jr');
            } elseif (401 === $status || 403 === $status) {
                $message = __('The AI provider rejected the API key or access. Check the key and account permissions.', 'jinni-jr');
            } elseif (429 === $status) {
                $message = __('The AI provider’s rate limit was reached. Please try again later.', 'jinni-jr');
            } else {
                $message = __('The AI provider could not process the request. Check the model and account settings.', 'jinni-jr');
            }
            return new WP_Error('jinni_ai_error', $message, array('status' => 502));
        }
        $data = json_decode(wp_remote_retrieve_body($response), true);
        if ($anthropic) {
            $parts = array();
            foreach (isset($data['content']) && is_array($data['content']) ? $data['content'] : array() as $part) {
                if (isset($part['type'], $part['text']) && 'text' === $part['type'] && is_string($part['text'])) $parts[] = $part['text'];
            }
            $reply = implode("\n", $parts);
        } else {
            $reply = isset($data['choices'][0]['message']['content']) ? $data['choices'][0]['message']['content'] : '';
        }
        if (!is_string($reply) || '' === trim($reply)) return new WP_Error('jinni_ai_empty', __('The model returned an empty response. Try another model.', 'jinni-jr'), array('status' => 502));
        return $reply;
    }

    private function call_openrouter($prompt, $model, $api_key, $user_message) {
        if (empty($api_key)) {
            return new WP_Error('jinni_openrouter_key', __('OpenRouter API key is not configured.', 'jinni-jr'), array('status' => 502));
        }

        $url = 'https://openrouter.ai/api/v1/chat/completions';
        $body = array(
            'model'    => !empty($model) ? $model : 'openrouter/auto',
            'messages' => array(
                array('role' => 'system', 'content' => $prompt),
                array('role' => 'user', 'content' => $user_message),
            ),
        );

        $args = array(
            'method'  => 'POST',
            'timeout' => 30,
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
            ),
            'body'    => wp_json_encode($body),
        );

        $response = wp_remote_post($url, $args);

        if (is_wp_error($response)) {
            return new WP_Error('jinni_openrouter_connection', __('Could not connect to OpenRouter. Please try again later.', 'jinni-jr'), array('status' => 502));
        }

        $code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        $error_code = isset($data['error']['code']) && is_numeric($data['error']['code']) ? (int) $data['error']['code'] : $code;
        if ($code !== 200 || !empty($data['error']) || !empty($data['choices'][0]['error'])) {
            if (!empty($data['choices'][0]['error']['code']) && is_numeric($data['choices'][0]['error']['code'])) {
                $error_code = (int) $data['choices'][0]['error']['code'];
            }
            $messages = array(
                400 => __('OpenRouter rejected the request. Check the selected model and prompt.', 'jinni-jr'),
                401 => __('OpenRouter rejected the API key. Check the key in Jinni Jr settings.', 'jinni-jr'),
                402 => __('OpenRouter reports insufficient credits or an account limit.', 'jinni-jr'),
                403 => __('OpenRouter denied this request. Check the API key permissions and account settings.', 'jinni-jr'),
                404 => __('The selected OpenRouter model is unavailable. Choose another model.', 'jinni-jr'),
                429 => __('OpenRouter rate limit reached. Wait a moment or choose another model.', 'jinni-jr'),
                503 => __('The selected model is temporarily unavailable. Try again or choose another model.', 'jinni-jr'),
            );
            $message = isset($messages[$error_code]) ? $messages[$error_code] : __('OpenRouter could not process the request. Please try again or choose another model.', 'jinni-jr');
            return new WP_Error('jinni_openrouter_error', $message, array('status' => 502));
        }
        if (empty($data['choices'][0]['message']['content']) || !is_string($data['choices'][0]['message']['content'])) {
            return new WP_Error('jinni_openrouter_empty', __('The selected model returned an empty response. Try again or choose another model.', 'jinni-jr'), array('status' => 502));
        }

        return $data['choices'][0]['message']['content'];
    }

    private function update_summary($visitor_id, $conversation_id, $user_message, $assistant_reply) {
        global $wpdb;
        $table = JINNI_JR_TABLE_CONVERSATIONS;
        $summary = "Visitor said: " . substr($user_message, 0, 100) . ". Bot replied: " . substr($assistant_reply, 0, 100) . ".";
        $wpdb->update(
            $table,
            array('conversation_summary' => $summary),
            array('id' => $conversation_id),
            array('%s'),
            array('%d')
        );
    }

    private function get_visitor_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($parts[0]);
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        }
        return sanitize_text_field($ip);
    }
}
