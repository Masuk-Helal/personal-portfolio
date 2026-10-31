<?php
/**
 * Plugin Name: Jinni Jr
 * Plugin URI: https://example.com/jinni-jr
 * Description: A lightweight AI chatbot plugin with an animated robot widget.
 * Version: 1.0.0
 * Author: You
 * Text Domain: jinni-jr
 * Requires at least: 5.5
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

define('JINNI_JR_VERSION', '1.0.0');
define('JINNI_JR_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('JINNI_JR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('JINNI_JR_TABLE_VISITORS', $GLOBALS['wpdb']->prefix . 'bot_visitors');
define('JINNI_JR_TABLE_CONVERSATIONS', $GLOBALS['wpdb']->prefix . 'bot_conversations');
define('JINNI_JR_TABLE_MESSAGES', $GLOBALS['wpdb']->prefix . 'bot_messages');

require_once JINNI_JR_PLUGIN_PATH . 'includes/class-plugin.php';

function jinni_jr() {
    return Jinni_Jr_Plugin::get_instance();
}

jinni_jr();

register_activation_hook(__FILE__, 'jinni_jr_activate');
register_deactivation_hook(__FILE__, 'jinni_jr_deactivate');
register_uninstall_hook(__FILE__, JINNI_JR_PLUGIN_PATH . 'uninstall.php');

function jinni_jr_activate() {
    Jinni_Jr_Plugin::activate();
}

function jinni_jr_deactivate() {
    Jinni_Jr_Plugin::deactivate();
}
