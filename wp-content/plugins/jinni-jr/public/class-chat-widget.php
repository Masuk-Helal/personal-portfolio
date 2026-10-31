<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Frontend chat widget for Jinni Jr.
 */
class Jinni_Jr_Chat_Widget {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_footer', array($this, 'render_widget'));
        add_action('init', array($this, 'register_rest_routes'));
    }

    public function enqueue_assets() {
        wp_enqueue_style(
            'jinni-jr-chat-widget',
            JINNI_JR_PLUGIN_URL . 'public/assets/css/chat-widget.css',
            array(),
            filemtime(JINNI_JR_PLUGIN_PATH . 'public/assets/css/chat-widget.css')
        );

        wp_enqueue_script(
            'jinni-jr-chat-widget',
            JINNI_JR_PLUGIN_URL . 'public/assets/js/chat-widget.js',
            array(),
            filemtime(JINNI_JR_PLUGIN_PATH . 'public/assets/js/chat-widget.js'),
            true
        );

        $config = array(
            'restUrl'   => esc_url_raw(rest_url('jinni-jr/v1/messages')),
            'configUrl' => esc_url_raw(rest_url('jinni-jr/v1/config')),
            'nonce'     => wp_create_nonce('wp_rest'),
        );

        wp_add_inline_script(
            'jinni-jr-chat-widget',
            'window.jinniJrConfig = ' . json_encode($config) . ';',
            'before'
        );
    }

    public function render_widget() {
        require JINNI_JR_PLUGIN_PATH . 'public/views/chat-widget.php';
    }

    public function register_rest_routes() {
        // REST routes are registered in the REST controller class.
    }
}
