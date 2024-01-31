<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://joymojumder.com/
 * @since      1.0.0
 *
 * @package    Team_Member
 * @subpackage Team_Member/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Team_Member
 * @subpackage Team_Member/includes
 * @author     joySuperman <hi@joymojumder.com>
 */
class Team_Member_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public static function deactivate() {
		self::register_post_type();
		self::register_taxonomy();
	}

	private static function register_post_type() {
		$labels = array(
			'name' => 'Team Members',
			'singular_name' => 'Team Member',
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
		);

		register_post_type('team_member', $args);
	}

	private static function register_taxonomy() {
		$labels = array(
			'name' => 'Member Types',
			'singular_name' => 'Member Type',
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);

		register_taxonomy('member_type', 'team_member', $args);
	}

}
