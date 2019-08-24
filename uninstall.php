<?php
/*
 * Fired when the plugin is uninstalled.
*/

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit; }

	global $wpdb;

	$table_name = $wpdb->prefix . "wpde_page_speed_insights";
	$wpdb->query( "DROP TABLE IF EXISTS " .  $table_name); //Drop plugin table

	delete_option("wpde_db_version");
