<?php
if (!defined('ABSPATH')) {
    exit;
}

/** Private knowledge entries, managed using the WordPress classic editor. */
class Jinni_Jr_Knowledge {
    const POST_TYPE = 'jinni_knowledge';

    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_filter('use_block_editor_for_post_type', array($this, 'classic_editor'), 10, 2);
        add_action('media_buttons', array($this, 'import_button'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_jinni_jr_import_docx', array($this, 'import_docx'));
    }

    public function register_post_type() {
        register_post_type(self::POST_TYPE, array(
            'labels' => array(
                'name' => __('Knowledge', 'jinni-jr'),
                'singular_name' => __('Knowledge', 'jinni-jr'),
                'add_new_item' => __('Add New Knowledge', 'jinni-jr'),
                'edit_item' => __('Edit Knowledge', 'jinni-jr'),
                'all_items' => __('Knowledge', 'jinni-jr'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'supports' => array('title', 'editor', 'author'),
            'capability_type' => 'post',
            'capabilities' => array('create_posts' => 'manage_options', 'edit_posts' => 'manage_options', 'edit_others_posts' => 'manage_options', 'publish_posts' => 'manage_options', 'read_private_posts' => 'manage_options', 'delete_posts' => 'manage_options', 'delete_others_posts' => 'manage_options'),
            'map_meta_cap' => true,
        ));
    }

    public function classic_editor($enabled, $post_type) {
        return self::POST_TYPE === $post_type ? false : $enabled;
    }

    public function import_button($editor_id) {
        $screen = get_current_screen();
        if (!$screen || self::POST_TYPE !== $screen->post_type || 'content' !== $editor_id || !current_user_can('manage_options')) {
            return;
        }
        echo '<button type="button" class="button" id="jinni-import-docx">' . esc_html__('Import DOCX', 'jinni-jr') . '</button> ';
        echo '<input type="file" id="jinni-docx-file" accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document" hidden />';
        echo '<span id="jinni-import-status" role="status" aria-live="polite"></span>';
    }

    public function enqueue_scripts($hook) {
        $screen = get_current_screen();
        if (!in_array($hook, array('post.php', 'post-new.php'), true) || !$screen || self::POST_TYPE !== $screen->post_type) {
            return;
        }
        wp_enqueue_script('jinni-jr-knowledge', JINNI_JR_PLUGIN_URL . 'admin/assets/knowledge.js', array(), JINNI_JR_VERSION, true);
        wp_localize_script('jinni-jr-knowledge', 'jinniKnowledge', array('nonce' => wp_create_nonce('jinni_jr_import_docx')));
    }

    public function import_docx() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('You are not allowed to import documents.', 'jinni-jr')), 403);
        }
        check_ajax_referer('jinni_jr_import_docx', 'nonce');
        if (empty($_FILES['document']) || !isset($_FILES['document']['error']) || UPLOAD_ERR_OK !== $_FILES['document']['error'] || !is_uploaded_file($_FILES['document']['tmp_name'])) {
            wp_send_json_error(array('message' => __('Upload failed. Please try again.', 'jinni-jr')), 400);
        }
        $file = $_FILES['document'];
        if (strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) !== 'docx' || $file['size'] > 5 * MB_IN_BYTES) {
            wp_send_json_error(array('message' => __('Choose a DOCX file smaller than 5 MB.', 'jinni-jr')), 400);
        }
        require_once ABSPATH . 'wp-admin/includes/class-pclzip.php';
        $archive = new PclZip($file['tmp_name']);
        $entries = $archive->listContent();
        $valid = false;
        if (is_array($entries)) {
            foreach ($entries as $entry) {
                if ($entry['filename'] === 'word/document.xml' && $entry['size'] <= 10 * MB_IN_BYTES) {
                    $valid = true;
                    break;
                }
            }
        }
        if (!$valid || !class_exists('DOMDocument')) {
            wp_send_json_error(array('message' => __('The document could not be read. Please upload a valid DOCX file.', 'jinni-jr')), 400);
        }
        $extracted = $archive->extract(PCLZIP_OPT_BY_NAME, 'word/document.xml', PCLZIP_OPT_EXTRACT_AS_STRING);
        if (empty($extracted[0]['content'])) {
            wp_send_json_error(array('message' => __('The DOCX document is empty or damaged.', 'jinni-jr')), 400);
        }
        $xml = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $loaded = $xml->loadXML($extracted[0]['content'], LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        if (!$loaded || $xml->doctype) {
            wp_send_json_error(array('message' => __('The document contains invalid XML.', 'jinni-jr')), 400);
        }
        $xpath = new DOMXPath($xml);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $paragraphs = array();
        foreach ($xpath->query('//w:body//w:p') as $paragraph) {
            $text = '';
            foreach ($xpath->query('.//w:t | .//w:tab | .//w:br', $paragraph) as $node) {
                $text .= 'tab' === $node->localName ? "\t" : ('br' === $node->localName ? "\n" : $node->textContent);
            }
            $paragraphs[] = $text;
        }
        wp_send_json_success(array('text' => implode("\n\n", $paragraphs)));
    }
}
