<?php
// Uninstall script for Jinni Jr.
// Not called directly; registered via register_uninstall_hook.

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;

$visitors_table = $wpdb->prefix . 'bot_visitors';
$conversations_table = $wpdb->prefix . 'bot_conversations';
$messages_table = $wpdb->prefix . 'bot_messages';

$wpdb->query("DROP TABLE IF EXISTS {$visitors_table}");
$wpdb->query("DROP TABLE IF EXISTS {$conversations_table}");
$wpdb->query("DROP TABLE IF EXISTS {$messages_table}");

delete_option('jinni_jr_options');
