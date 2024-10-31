<?php
namespace ystp;
use \YstpOptionsConfig;

class Installer {

	public static function uninstall() {

		if (!get_option('ystp-delete-data')) {
			return false;
		}

		self::deleteScrolls();
		return true;
	}

	/**
	 * Delete all Scroll post types posts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 *
	 */
	private static function deleteScrolls()
	{
		$scrolls = get_posts(
			array(
				'post_type' => YSTP_POST_TYPE,
				'post_status' => array(
					'publish',
					'pending',
					'draft',
					'auto-draft',
					'future',
					'private',
					'inherit',
					'trash'
				)
			)
		);

		foreach ($scrolls as $scroll) {
			if (empty($scroll)) {
				continue;
			}
			wp_delete_post($scroll->ID, true);
		}
	}

	public static function install() {
		self::createTables();
        YstpShowReviewNotice::setInitialDates();

		if(is_multisite() && get_current_blog_id() == 1) {
			global $wp_version;

			if($wp_version > '4.6.0') {
				$sites = get_sites();
			}
			else {
				$sites = wp_get_sites();
			}

			foreach($sites as $site) {

				if($wp_version > '4.6.0') {
					$blogId = $site->blog_id.'_';
				}
				else {
					$blogId = $site['blog_id'].'_';
				}
				if($blogId != 1) {
					self::createTables($blogId);
				}
			}
		}
		self::insertDefaultData();
	}
	
	private static function insertDefaultData() {
		$isInserted = get_option('YstpInserted');
		
		if ($isInserted) {
			return false;
		}
		
		$defaultPost = array(
			'post_title'    => __('Default', YSTP_TEXT_DOMAIN),
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_type'=> YSTP_POST_TYPE,
			'post_category' => array()
		);

		// Insert the post into the database
		wp_insert_post($defaultPost);
		global $wpdb;
		$lastid = $wpdb->insert_id;
		
		$options = YstpOptionsConfig::getDefaultInsertData();
		$options['ystp-type'] = 'text';
		$options['ystp-post-id'] = $lastid;
		update_post_meta($lastid, 'ystp_options', $options);
		update_option('YstpInserted', 1);
		
		return false;
	}

	public static function createTables($blogId = '') {
	
	}
}