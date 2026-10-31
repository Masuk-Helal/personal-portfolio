<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin page for Jinni Jr settings.
 */
class Jinni_Jr_Admin_Page {

    private $settings;
    private $menu_slug = 'jinni-jr';

    public function __construct($settings) {
        $this->settings = $settings;
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Jinni Jr', 'jinni-jr'),
            __('Jinni Jr', 'jinni-jr'),
            'manage_options',
            $this->menu_slug,
            array($this, 'render_page'),
            'dashicons-format-chat',
            24
        );

        add_submenu_page($this->menu_slug, __('System Prompt', 'jinni-jr'), __('System Prompt', 'jinni-jr'), 'manage_options', $this->menu_slug, array($this, 'render_page'));
        add_submenu_page($this->menu_slug, __('Memory', 'jinni-jr'), __('Memory', 'jinni-jr'), 'manage_options', 'jinni-jr-memory', array($this, 'render_memory'));
        add_submenu_page($this->menu_slug, __('Knowledge', 'jinni-jr'), __('Knowledge', 'jinni-jr'), 'manage_options', 'edit.php?post_type=jinni_knowledge');
    }

    public function render_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields(Jinni_Jr_Settings::OPTION_GROUP);
                do_settings_sections(Jinni_Jr_Settings::OPTION_GROUP);
                submit_button(__('Save Changes', 'jinni-jr'));
                ?>
            </form>
        </div>
        <?php
    }

    public function render_memory() {
        if (!current_user_can('manage_options')) {
            return;
        }
        global $wpdb;
        $visitors = $wpdb->get_results("SELECT id, ip_address, name, email, approximate_location, first_seen_at, last_seen_at FROM " . JINNI_JR_TABLE_VISITORS . " ORDER BY last_seen_at DESC LIMIT 100");
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Memory', 'jinni-jr'); ?></h1>
            <table class="widefat striped">
                <thead><tr><th><?php esc_html_e('Name', 'jinni-jr'); ?></th><th><?php esc_html_e('Email', 'jinni-jr'); ?></th><th><?php esc_html_e('IP address', 'jinni-jr'); ?></th><th><?php esc_html_e('Location', 'jinni-jr'); ?></th><th><?php esc_html_e('First seen', 'jinni-jr'); ?></th><th><?php esc_html_e('Last seen', 'jinni-jr'); ?></th></tr></thead>
                <tbody>
                <?php if (empty($visitors)) : ?>
                    <tr><td colspan="6"><?php esc_html_e('No visitors recorded yet.', 'jinni-jr'); ?></td></tr>
                <?php else : foreach ($visitors as $visitor) : ?>
                    <tr><td><?php echo esc_html($visitor->name); ?></td><td><?php echo esc_html($visitor->email); ?></td><td><?php echo esc_html($visitor->ip_address); ?></td><td><?php echo esc_html($visitor->approximate_location); ?></td><td><?php echo esc_html($visitor->first_seen_at); ?></td><td><?php echo esc_html($visitor->last_seen_at); ?></td></tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_knowledge() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Knowledge', 'jinni-jr'); ?></h1>
            <p><?php esc_html_e('Knowledge document uploads are not available yet.', 'jinni-jr'); ?></p>
        </div>
        <?php
    }
}
