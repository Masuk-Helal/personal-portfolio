<?php
/**
 * Demo import helper.
 *
 * The demo content package (content.xml) is imported with the standard
 * WordPress Importer. Two things do not survive a plain import, so this class
 * handles them:
 *
 * 1. Media. content.xml points its attachments at a placeholder host
 *    (https://demo.heliolisk.invalid/media/…). While the importer downloads
 *    them, this class answers those requests from the plugin's demo-media/
 *    folder, so the import works offline and needs no demo server.
 * 2. Links between imported items. Elementor stores image URLs and the Home page
 *    stores its header and footer by post ID. After the import these are
 *    pointed at the new attachments and posts, the Home page becomes the front
 *    page and the demo menu is assigned to the Primary Menu location.
 *
 * Nothing here runs unless content.xml from the demo package was imported.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Heliolisk_Demo_Import {

	/**
	 * Placeholder media host used inside content.xml.
	 */
	const MEDIA_PREFIX = 'https://demo.heliolisk.invalid/media/';

	/**
	 * Post meta that marks imported demo items (value: home, header, footer, …).
	 */
	const ROLE_META = '_heliolisk_demo';

	/**
	 * Post meta on imported attachments holding the original demo file name.
	 */
	const FILE_META = '_heliolisk_demo_file';

	/**
	 * Name of the nav menu created by the demo content.
	 */
	const MENU_NAME = 'Heliolisk Demo Menu';

	/**
	 * Hooks the importer integration.
	 */
	public static function init() {
		add_filter( 'pre_http_request', array( __CLASS__, 'serve_demo_media' ), 10, 3 );
		add_action( 'import_end', array( __CLASS__, 'finish_import' ) );
	}

	/**
	 * Answers requests for the placeholder media host from demo-media/.
	 *
	 * @param false|array|WP_Error $pre  Preempted response.
	 * @param array                $args HTTP request arguments.
	 * @param string               $url  Request URL.
	 * @return false|array|WP_Error
	 */
	public static function serve_demo_media( $pre, $args, $url ) {
		if ( 0 !== strpos( $url, self::MEDIA_PREFIX ) ) {
			return $pre;
		}

		$name = sanitize_file_name( wp_basename( (string) wp_parse_url( $url, PHP_URL_PATH ) ) );
		$file = HELIOLISK_PLUGIN_DIR . 'demo-media/' . $name;

		if ( '' === $name || ! is_readable( $file ) ) {
			return new WP_Error( 'heliolisk_demo_media_missing', __( 'Demo image not found in the Heliolisk plugin.', 'heliolisk' ) );
		}

		$type = wp_check_filetype( $name );
		$body = '';

		if ( ! empty( $args['filename'] ) ) {
			// The importer streams the download straight into a file.
			if ( ! copy( $file, $args['filename'] ) ) {
				return new WP_Error( 'heliolisk_demo_media_copy', __( 'Could not copy the demo image.', 'heliolisk' ) );
			}
		} else {
			$body = (string) file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local plugin file.
		}

		return array(
			'headers'  => array(
				'content-length' => (string) filesize( $file ),
				'content-type'   => $type['type'] ? $type['type'] : 'application/octet-stream',
			),
			'body'     => $body,
			'response' => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'cookies'  => array(),
			'filename' => ! empty( $args['filename'] ) ? $args['filename'] : null,
		);
	}

	/**
	 * Runs after WordPress Importer has finished.
	 */
	public static function finish_import() {
		$roles = self::get_imported_roles();

		if ( empty( $roles ) ) {
			return; // Not the Heliolisk demo.
		}

		self::relink_media();

		if ( ! empty( $roles['home'] ) ) {
			$home_id = $roles['home'];

			if ( ! empty( $roles['header'] ) ) {
				update_post_meta( $home_id, 'heliolisk_page_header', $roles['header'] );
			}
			if ( ! empty( $roles['footer'] ) ) {
				update_post_meta( $home_id, 'heliolisk_page_footer', $roles['footer'] );
			}

			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home_id );
		}

		$menu = get_term_by( 'name', self::MENU_NAME, 'nav_menu' );
		if ( $menu ) {
			$locations            = get_theme_mod( 'nav_menu_locations', array() );
			$locations            = is_array( $locations ) ? $locations : array();
			$locations['primary'] = (int) $menu->term_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}

		flush_rewrite_rules();
	}

	/**
	 * Returns imported demo items by role.
	 *
	 * @return array<string,int> Role => post ID.
	 */
	private static function get_imported_roles() {
		$ids = get_posts(
			array(
				'post_type'      => 'any',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_key'       => self::ROLE_META, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'no_found_rows'  => true,
			)
		);

		$roles = array();
		foreach ( $ids as $id ) {
			$role = (string) get_post_meta( $id, self::ROLE_META, true );
			if ( '' !== $role ) {
				$roles[ $role ] = (int) $id;
			}
		}

		return $roles;
	}

	/**
	 * Replaces placeholder image URLs in imported Elementor data with the
	 * URLs (and IDs) of the attachments created by the import.
	 */
	private static function relink_media() {
		$attachments = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_key'       => self::FILE_META, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'no_found_rows'  => true,
			)
		);

		$map = array();
		foreach ( $attachments as $attachment_id ) {
			$file = (string) get_post_meta( $attachment_id, self::FILE_META, true );
			$url  = wp_get_attachment_url( $attachment_id );
			if ( '' !== $file && $url ) {
				$map[ self::MEDIA_PREFIX . $file ] = array(
					'id'  => (int) $attachment_id,
					'url' => $url,
				);
			}
		}

		if ( empty( $map ) ) {
			return;
		}

		$posts = get_posts(
			array(
				'post_type'      => 'any',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_key'       => '_elementor_data', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'no_found_rows'  => true,
			)
		);

		foreach ( $posts as $post_id ) {
			$raw = get_post_meta( $post_id, '_elementor_data', true );
			if ( ! is_string( $raw ) || false === strpos( $raw, 'demo.heliolisk.invalid' ) ) {
				continue;
			}

			$data = json_decode( $raw, true );
			if ( ! is_array( $data ) ) {
				continue;
			}

			self::replace_urls( $data, $map );
			update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
		}
	}

	/**
	 * Walks Elementor data and swaps placeholder media for imported media.
	 *
	 * @param mixed $node Data node (modified in place).
	 * @param array $map  Placeholder URL => array( id, url ).
	 */
	private static function replace_urls( &$node, $map ) {
		if ( ! is_array( $node ) ) {
			return;
		}

		if ( isset( $node['url'] ) && is_string( $node['url'] ) && isset( $map[ $node['url'] ] ) ) {
			$target      = $map[ $node['url'] ];
			$node['url'] = $target['url'];
			$node['id']  = $target['id'];
		}

		foreach ( $node as &$child ) {
			self::replace_urls( $child, $map );
		}
	}
}

Heliolisk_Demo_Import::init();
