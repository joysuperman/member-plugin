<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://joymojumder.com/
 * @since             1.0.0
 * @package           Team_Member
 *
 * @wordpress-plugin
 * Plugin Name:       Team Member
 * Plugin URI:        https://joymojumder.com/team-bember/
 * Description:       Team Member Test Plugin
 * Version:           1.0.0
 * Author:            joySuperman
 * Author URI:        https://joymojumder.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       team-member
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TEAM_MEMBER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-team-member-activator.php
 */
function activate_team_member() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-team-member-activator.php';
	Team_Member_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-team-member-deactivator.php
 */
function deactivate_team_member() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-team-member-deactivator.php';
	Team_Member_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_team_member' );
register_deactivation_hook( __FILE__, 'deactivate_team_member' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-team-member.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_team_member() {

	$plugin = new Team_Member();
	$plugin->run();

}
run_team_member();
