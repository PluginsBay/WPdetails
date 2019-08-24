<?php
function wpde_db_install() {
	global $wpdb;
	global $wpde_db_version;

	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . "wpde_page_speed_insights";
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		strategy int(2) NOT NULL,
		measure_date  datetime, 
		performance_score int,
		first_contentful_paint decimal(5,2),
		speed_index decimal(5,2),
		interactive decimal(5,2),
		PRIMARY KEY  (id)
	  ) $charset_collate;";
	  
	  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  dbDelta( $sql );    

	  update_option( "wpde_db_version", $wpde_db_version );
}
function wpde_update_db_check() {
	global $wpde_db_version;
	if ( get_site_option( 'wpde_db_version' ) != $wpde_db_version ) {
		wpde_db_install();
	}
}
function wpde_get_color($performance_score) {
	$color = "#c7221f";

	switch($performance_score) {
		case $performance_score >= 90:
			$color = "#178239"; 
			break;
		case $performance_score >= 50 &&  $performance_score < 90:
			$color = "#e67700"; 
			break;  
		default:
			$color = "#c7221f";    
			break;      
	}

	return $color;
}
function wpde_is_localhost() {
	if (substr($_SERVER['REMOTE_ADDR'], 0, 4) == '127.' || $_SERVER['REMOTE_ADDR'] == '::1') return 1;
	else return 0;
}