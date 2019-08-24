<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define ('WPDE_PLUGIN_PATH', plugin_dir_path( __FILE__));
include (WPDE_PLUGIN_PATH . 'settings/admin.php');
include (WPDE_PLUGIN_PATH . 'includes/functions.php');
include (WPDE_PLUGIN_PATH . 'includes/googlePageSpeedAPI.php');
$wpde_db_version = "1.0";
function wpde_activate() {
	wpde_db_install();
	if (! wp_next_scheduled ( 'wpde_fetchPageSpeedData' )) {
		wp_schedule_event(time(), 'daily', 'wpde_fetchPageSpeedData');
	}
}
register_activation_hook( __FILE__, 'wpde_activate' );
add_action('wpde_fetchPageSpeedData', 'wpde_fetchPageSpeedData');
add_action('plugins_loaded', 'wpde_update_db_check' );
function wpde_deactivate() {
	wp_clear_scheduled_hook('wpde_fetchPageSpeedData');
}
register_deactivation_hook( __FILE__, 'wpde_deactivate' );
?>