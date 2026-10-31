<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Database table management for Jinni Jr.
 */
class Jinni_Jr_Database {

    private $wpdb;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function maybe_create_tables() {
        $this->create_tables();
    }

    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $visitors_table = JINNI_JR_TABLE_VISITORS;
        $visitors_sql = "CREATE TABLE IF NOT EXISTS {$visitors_table} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            visitor_token VARCHAR(100) NOT NULL DEFAULT '',
            ip_address VARCHAR(45) DEFAULT NULL,
            name VARCHAR(190) DEFAULT NULL,
            email VARCHAR(190) DEFAULT NULL,
            approximate_location VARCHAR(255) DEFAULT NULL,
            first_seen_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            last_seen_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY visitor_token (visitor_token)
        ) {$charset_collate};";

        $conversations_table = JINNI_JR_TABLE_CONVERSATIONS;
        $conversations_sql = "CREATE TABLE IF NOT EXISTS {$conversations_table} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            visitor_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
            conversation_summary LONGTEXT DEFAULT NULL,
            started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            last_message_at DATETIME DEFAULT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY visitor_id (visitor_id)
        ) {$charset_collate};";

        $messages_table = JINNI_JR_TABLE_MESSAGES;
        $messages_sql = "CREATE TABLE IF NOT EXISTS {$messages_table} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            conversation_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
            role VARCHAR(20) NOT NULL DEFAULT '',
            message LONGTEXT NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY conversation_id (conversation_id)
        ) {$charset_collate};";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($visitors_sql);
        dbDelta($conversations_sql);
        dbDelta($messages_sql);
    }
}
