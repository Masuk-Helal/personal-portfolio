<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Jinni Jr plugin class.
 */
class Jinni_Jr_Plugin {

    private static $instance = null;

    private $database;
    private $settings;
    private $admin_page;
    private $rest_controller;
    private $chat_widget;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    private function init() {
        require_once JINNI_JR_PLUGIN_PATH . 'includes/class-database.php';
        require_once JINNI_JR_PLUGIN_PATH . 'includes/class-settings.php';
        require_once JINNI_JR_PLUGIN_PATH . 'admin/class-admin-page.php';
        require_once JINNI_JR_PLUGIN_PATH . 'includes/class-rest-controller.php';
        require_once JINNI_JR_PLUGIN_PATH . 'public/class-chat-widget.php';
        require_once JINNI_JR_PLUGIN_PATH . 'admin/class-knowledge.php';

        $this->database    = new Jinni_Jr_Database();
        $this->settings    = new Jinni_Jr_Settings();
        $this->admin_page  = new Jinni_Jr_Admin_Page($this->settings);
        $this->rest_controller = new Jinni_Jr_REST_Controller($this->database, $this->settings);
        $this->chat_widget = new Jinni_Jr_Chat_Widget();
        new Jinni_Jr_Knowledge();

        add_action('plugins_loaded', array($this, 'on_plugins_loaded'));
        add_action('admin_menu', array($this->admin_page, 'add_admin_menu'));
        add_action('admin_init', array($this->settings, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this->settings, 'enqueue_admin_scripts'));
        add_action('wp_ajax_jinni_jr_models', array($this->settings, 'ajax_models'));
        add_action('wp_ajax_jinni_jr_verify_openrouter', array($this->settings, 'ajax_verify_openrouter'));
        add_action('rest_api_init', array($this->rest_controller, 'register_routes'));
    }

    public function on_plugins_loaded() {
        $this->database->maybe_create_tables();
    }

    public static function activate() {
        $database = new Jinni_Jr_Database();
        $database->create_tables();
    }

    public static function deactivate() {
        // Nothing to clean up on deactivate (keep data).
    }

    public function get_database() {
        return $this->database;
    }

    public function get_settings() {
        return $this->settings;
    }
}
