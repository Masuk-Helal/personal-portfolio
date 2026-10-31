<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Settings management for Jinni Jr.
 */
class Jinni_Jr_Settings {

    const OPTION_GROUP = 'jinni_jr_settings';
    const OPTION_NAME = 'jinni_jr_options';

    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_jinni-jr' !== $hook) {
            return;
        }
        wp_enqueue_script('jinni-jr-models', JINNI_JR_PLUGIN_URL . 'admin/assets/models.js', array(), filemtime(JINNI_JR_PLUGIN_PATH . 'admin/assets/models.js'), true);
        wp_localize_script('jinni-jr-models', 'jinniJrModels', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('jinni_jr_models'),
            'loading' => __('Loading models…', 'jinni-jr'),
            'failed' => __('Could not load models. Please reload the page to try again.', 'jinni-jr'),
            'connector' => __('Install and configure this provider under Settings → Connectors to load its models.', 'jinni-jr'),
            'ready' => __('Select a model or use the provider default.', 'jinni-jr'),
            'noResults' => __('No models match your search.', 'jinni-jr'),
            'verifying' => __('Checking API key…', 'jinni-jr'),
            'verifyFailed' => __('Unable to verify the connection. Please try again.', 'jinni-jr'),
        ));
    }

    public function ajax_verify_openrouter() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('You are not allowed to check this connection.', 'jinni-jr')), 403);
        }
        check_ajax_referer('jinni_jr_models', 'nonce');
        $provider = isset($_POST['provider']) ? sanitize_key(wp_unslash($_POST['provider'])) : 'openrouter';
        if (!in_array($provider, array('openrouter', 'openai', 'anthropic'), true)) {
            wp_send_json_error(array('message' => __('Choose a supported provider.', 'jinni-jr')));
        }
        $key = isset($_POST['api_key']) ? sanitize_text_field(wp_unslash($_POST['api_key'])) : '';
        if ('' === $key) {
            $key = $this->get_provider_key($provider);
        }
        if ('' === $key) {
            wp_send_json_error(array('message' => __('Enter an API key first.', 'jinni-jr')));
        }
        $urls = array('openrouter' => 'https://openrouter.ai/api/v1/key', 'openai' => 'https://api.openai.com/v1/models', 'anthropic' => 'https://api.anthropic.com/v1/models?limit=1');
        $headers = 'anthropic' === $provider ? array('x-api-key' => $key, 'anthropic-version' => '2023-06-01') : array('Authorization' => 'Bearer ' . $key);
        $response = wp_remote_get($urls[$provider], array(
            'timeout' => 20,
            'headers' => $headers,
        ));
        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => __('Could not reach the provider. Check your server connection and try again.', 'jinni-jr')));
        }
        $code = wp_remote_retrieve_response_code($response);
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (200 === $code && isset($body['data']) && is_array($body['data'])) {
            wp_send_json_success(array('message' => __('API key verified. Save changes to use it. Model access and billing are checked separately.', 'jinni-jr')));
        }
        $message = in_array($code, array(401, 403), true)
            ? __('The provider rejected this API key or its permissions. Check the key and try again.', 'jinni-jr')
            : __('The provider could not verify the key. Check your account or try again later.', 'jinni-jr');
        wp_send_json_error(array('message' => $message));
    }

    public function ajax_models() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Forbidden'), 403);
        }
        check_ajax_referer('jinni_jr_models', 'nonce');
        $provider = isset($_POST['provider']) ? sanitize_key(wp_unslash($_POST['provider'])) : 'openrouter';
        if (in_array($provider, array('anthropic', 'openai'), true)) {
            $key = isset($_POST['api_key']) ? sanitize_text_field(wp_unslash($_POST['api_key'])) : '';
            if (!$key) $key = $this->get_provider_key($provider);
            if (!$key) wp_send_json_error(array('message' => __('Enter an API key, then click Load models.', 'jinni-jr')));
            $headers = 'anthropic' === $provider ? array('x-api-key' => $key, 'anthropic-version' => '2023-06-01') : array('Authorization' => 'Bearer ' . $key);
            $url = 'anthropic' === $provider ? 'https://api.anthropic.com/v1/models?limit=100' : 'https://api.openai.com/v1/models';
            $response = wp_remote_get($url, array('timeout' => 20, 'headers' => $headers));
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
                wp_send_json_error(array('message' => __('Could not load models. Check the API key and try again.', 'jinni-jr')));
            }
            $body = json_decode(wp_remote_retrieve_body($response), true);
            $models = array();
            foreach (isset($body['data']) && is_array($body['data']) ? $body['data'] : array() as $model) {
                if (empty($model['id']) || !is_string($model['id'])) continue;
                if ('openai' === $provider && !preg_match('/^(gpt-|chatgpt-|o[1-9])/', $model['id'])) continue;
                $models[] = array('id' => $model['id'], 'name' => !empty($model['display_name']) ? $model['display_name'] : $model['id']);
            }
            if (!$models) wp_send_json_error(array('message' => __('No models were returned for this API key.', 'jinni-jr')));
            wp_send_json_success($models);
        }
        if ('openrouter' !== $provider) {
            wp_send_json_error(array('message' => __('Choose a specific provider to load models.', 'jinni-jr')));
        }
        $models = get_transient('jinni_jr_openrouter_models');
        if (false === $models) {
            $response = wp_remote_get('https://openrouter.ai/api/v1/models', array('timeout' => 20));
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
                wp_send_json_error(array('message' => 'Unable to load models.'), 502);
            }
            $body = json_decode(wp_remote_retrieve_body($response), true);
            if (empty($body['data']) || !is_array($body['data'])) {
                wp_send_json_error(array('message' => 'Invalid model list.'), 502);
            }
            $models = array();
            foreach ($body['data'] as $model) {
                if (!empty($model['id']) && is_string($model['id'])) {
                    $models[] = array('id' => $model['id'], 'name' => !empty($model['name']) && is_string($model['name']) ? $model['name'] : $model['id']);
                }
            }
            if (empty($models)) {
                wp_send_json_error(array('message' => 'No models available.'), 502);
            }
            set_transient('jinni_jr_openrouter_models', $models, HOUR_IN_SECONDS);
        }
        wp_send_json_success($models);
    }

    public function register_settings() {
        register_setting(
            self::OPTION_GROUP,
            self::OPTION_NAME,
            array(
                'show_in_rest' => false,
                'type'         => 'string',
                'description'  => 'Jinni Jr plugin settings',
                'sanitize_callback' => array($this, 'sanitize_options'),
            )
        );

        add_settings_section(
            'jinni_jr_section_llm',
            __('LLM Provider', 'jinni-jr'),
            array($this, 'render_section_llm'),
            self::OPTION_GROUP
        );

        add_settings_field(
            'jinni_jr_provider',
            __('Provider', 'jinni-jr'),
            array($this, 'render_field_provider'),
            self::OPTION_GROUP,
            'jinni_jr_section_llm'
        );

        add_settings_field(
            'jinni_jr_model',
            __('Model', 'jinni-jr'),
            array($this, 'render_field_model'),
            self::OPTION_GROUP,
            'jinni_jr_section_llm'
        );

        add_settings_field(
            'jinni_jr_api_key',
            __('API Key', 'jinni-jr'),
            array($this, 'render_field_api_key'),
            self::OPTION_GROUP,
            'jinni_jr_section_llm'
        );

        add_settings_section(
            'jinni_jr_section_prompt',
            __('System Prompt', 'jinni-jr'),
            array($this, 'render_section_prompt'),
            self::OPTION_GROUP
        );

        add_settings_field(
            'jinni_jr_system_prompt',
            __('Talking Instructions / System Prompt', 'jinni-jr'),
            array($this, 'render_field_system_prompt'),
            self::OPTION_GROUP,
            'jinni_jr_section_prompt'
        );
    }

    public function sanitize_options($input) {
        if (!is_array($input)) {
            $input = array();
        }

        $output = array();

        $output['provider'] = sanitize_text_field(isset($input['provider']) ? $input['provider'] : 'openrouter');
        $output['model'] = sanitize_text_field(isset($input['model']) ? $input['model'] : '');
        $existing = $this->get_options();
        $provider = $output['provider'];
        $key = '';
        if (in_array($provider, array('openrouter', 'openai', 'anthropic'), true)) {
            $key = !empty($input['provider_keys'][$provider]) ? sanitize_text_field($input['provider_keys'][$provider]) : $this->get_provider_key($provider);
        }
        $output['api_key'] = '';
        $output['provider_keys'] = $key ? array($provider => $key) : array();
        $output['system_prompt'] = wp_kses_post(isset($input['system_prompt']) ? $input['system_prompt'] : $this->default_system_prompt());

        return $output;
    }

    public function get_options() {
        $options = get_option(self::OPTION_NAME);
        if (false === $options || !is_array($options)) {
            $options = array(
                'provider'       => 'openrouter',
                'model'          => '',
                'api_key'        => '',
                'system_prompt'  => $this->default_system_prompt(),
            );
        }
        return wp_parse_args($options, array(
            'provider'       => 'openrouter',
            'model'          => '',
            'api_key'        => '',
            'system_prompt'  => $this->default_system_prompt(),
        ));
    }

    public function get_option($key, $default = null) {
        $options = $this->get_options();
        return isset($options[$key]) ? $options[$key] : $default;
    }

    public function get_provider_key($provider) {
        $options = $this->get_options();
        if (!empty($options['provider_keys'][$provider])) return $options['provider_keys'][$provider];
        return 'openrouter' === $provider ? $options['api_key'] : '';
    }

    public function prompt_with_placeholders($prompt) {
        $missing = array();
        if (strpos($prompt, '{{user message}}') === false) {
            $missing[] = "User message:\n{{user message}}";
        }
        if (strpos($prompt, '{{knowledge}}') === false) {
            $missing[] = "Knowledge:\n{{knowledge}}";
        }
        if (!$missing) {
            return $prompt;
        }
        $addition = implode("\n\n", $missing) . "\n\n";
        $position = strpos($prompt, 'Communication:');
        return false === $position ? $addition . $prompt : substr_replace($prompt, $addition, $position, 0);
    }

    public function default_system_prompt() {
        return __(
            "You are the website's friendly AI assistant.

Communication:
- Speak politely, naturally, and helpfully.
- Keep answers clear and relevant.
- Do not claim to know a visitor's identity unless they have provided it.

Visitor recognition:
- When appropriate, politely ask for the visitor's name and email.
- Explain that sharing these details can help personalize future assistance.
- Do not pressure the visitor if they decline.
- If the visitor provides a name, use it naturally in the conversation.
- If the visitor does not provide a name, you may use a friendly temporary nickname.
- Never present a temporary nickname as the visitor's real name.

Memory:
- Use the supplied conversation summary only when relevant.
- Do not invent previous conversations or personal details.
- If information is missing or uncertain, ask the visitor.",
            'jinni-jr'
        );
    }

    public function render_section_llm() {
        echo '<p>' . __('Configure the LLM provider for the chatbot.', 'jinni-jr') . '</p>';
    }

    public function render_field_provider() {
        $options = $this->get_options();
        $provider = isset($options['provider']) ? $options['provider'] : 'openrouter';
        ?>
        <select id="jinni-jr-provider" name="<?php echo esc_attr(self::OPTION_NAME); ?>[provider]">
            <option value="openrouter"<?php selected($provider, 'openrouter'); ?>><?php _e('OpenRouter', 'jinni-jr'); ?></option>
            <option value="anthropic"<?php selected($provider, 'anthropic'); ?>><?php esc_html_e('Anthropic', 'jinni-jr'); ?></option>
            <option value="openai"<?php selected($provider, 'openai'); ?>><?php esc_html_e('OpenAI', 'jinni-jr'); ?></option>
        </select>
        <p class="description"><?php _e('Select the LLM provider. Credentials are stored server-side only.', 'jinni-jr'); ?></p>
        <?php
    }

    public function render_field_model() {
        $options = $this->get_options();
        $model = isset($options['model']) ? $options['model'] : '';
        ?>
        <select id="jinni-jr-model" name="<?php echo esc_attr(self::OPTION_NAME); ?>[model]" class="regular-text" data-saved-model="<?php echo esc_attr($model); ?>">
            <option value=""><?php esc_html_e('Provider default', 'jinni-jr'); ?></option>
            <?php if ($model !== '') : ?>
                <option value="<?php echo esc_attr($model); ?>" selected><?php echo esc_html($model); ?></option>
            <?php endif; ?>
        </select>
        <div id="jinni-jr-model-picker" style="display:none; position:relative; max-width:400px;">
            <button type="button" id="jinni-jr-model-toggle" class="button" aria-haspopup="listbox" aria-expanded="false" style="width:100%; text-align:left;"></button>
            <div id="jinni-jr-model-popup" hidden style="position:absolute; z-index:100; top:100%; left:0; width:100%; box-sizing:border-box; background:#fff; border:1px solid #8c8f94; box-shadow:0 3px 6px rgba(0,0,0,.15); padding:8px;">
                <input type="search" id="jinni-jr-model-search" placeholder="<?php esc_attr_e('Search models, e.g. free or GPT', 'jinni-jr'); ?>" aria-label="<?php esc_attr_e('Search models', 'jinni-jr'); ?>" aria-controls="jinni-jr-model-results" style="width:100%;" />
                <div id="jinni-jr-model-results" role="listbox" aria-label="<?php esc_attr_e('Models', 'jinni-jr'); ?>" style="max-height:280px; overflow-y:auto; margin-top:6px;"></div>
            </div>
        </div>
        <p id="jinni-jr-model-status" class="description" role="status"><?php esc_html_e('Select a model or use the provider default.', 'jinni-jr'); ?></p>
        <?php
    }

    public function render_field_api_key() {
        ?>
        <?php foreach (array('openrouter', 'anthropic', 'openai') as $provider) : ?>
            <input type="password" id="jinni-jr-api-key-<?php echo esc_attr($provider); ?>" data-provider-key="<?php echo esc_attr($provider); ?>" name="<?php echo esc_attr(self::OPTION_NAME); ?>[provider_keys][<?php echo esc_attr($provider); ?>]" value="<?php echo esc_attr($this->get_provider_key($provider)); ?>" class="regular-text" autocomplete="new-password" <?php echo $provider !== $this->get_option('provider') ? 'hidden' : ''; ?> />
        <?php endforeach; ?>
        <button type="button" id="jinni-jr-load-models" class="button"><?php esc_html_e('Load models', 'jinni-jr'); ?></button>
        <button type="button" id="jinni-jr-verify" class="button"><?php esc_html_e('Verify API key', 'jinni-jr'); ?></button>
        <p id="jinni-jr-verify-status" class="description" role="status"></p>
        <p class="description"><?php esc_html_e('Enter the selected provider’s API key, load and select a model, then save. Saving removes the previous provider’s key. A blank field keeps the selected provider’s saved key, if any.', 'jinni-jr'); ?></p>
        <?php
    }

    public function render_section_prompt() {
        echo '<p>' . __('Edit the bot behavior. The saved prompt is used for every LLM request.', 'jinni-jr') . '</p>';
    }

    public function render_field_system_prompt() {
        $options = $this->get_options();
        $prompt = $this->prompt_with_placeholders(isset($options['system_prompt']) ? $options['system_prompt'] : $this->default_system_prompt());
        ?>
        <textarea name="<?php echo esc_attr(self::OPTION_NAME); ?>[system_prompt]" rows="12" class="large-text code"><?php echo esc_textarea($prompt); ?></textarea>
        <p class="description"><?php esc_html_e('Use {{user message}} for the visitor’s message and {{knowledge}} for published knowledge entries.', 'jinni-jr'); ?></p>
        <?php
    }
}
