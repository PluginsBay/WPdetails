<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if(is_admin()) {
	add_action('init', 'wpde_admin_init');
	add_action( 'admin_enqueue_scripts', 'wpde_admin_enqueue_styles' );
	add_action( 'admin_enqueue_scripts', 'wpde_admin_enqueue_scripts' );
	add_action( 'admin_print_scripts-settings_page_wpde-page-speed-insights', 'wpde_load_dyn_script' );
	include (WPDE_PLUGIN_PATH . 'includes/dashboardWidget.php');
	wpde_load_widget_data();
}

function wpde_admin_init() {

	add_action( 'admin_menu', 'wpde_admin_menu' );
}
function wpde_admin_enqueue_styles() {
	wp_enqueue_style('Page Speed Insights', plugin_dir_url( __FILE__ ) . '../css/wpde-page-speed-admin.css', array(),'1.0.3', 'all' );	
}

function wpde_admin_enqueue_scripts() {
	wp_register_script('googlecharts', 'https://www.gstatic.com/charts/loader.js', array(), null );
	wp_enqueue_script('googlecharts');
    wp_enqueue_script('Page Speed Insights JS', plugin_dir_url( __FILE__ ) . '../js/wpde-page-speed-admin.js', array(),'1.0.0', 'all' );
}
function wpde_admin_menu() {}
function wpde_settings_page() {
	include (WPDE_PLUGIN_PATH . "settings/settings-page.php");
}
function wpde_load_dyn_script() {

	global $wpdb;

	$table_name = $wpdb->prefix . "wpde_page_speed_insights"; 

	$page_speed_history = $wpdb->get_results("
		SELECT measure_date as measure_date,
		SUM(ROUND(performance_score,0)*(1-abs(sign(strategy-1)))) as desktop,
		SUM(ROUND(performance_score,0)*(1-abs(sign(strategy-2)))) as mobile
		FROM
		(
		SELECT DATE(measure_date) AS measure_date, strategy, AVG(performance_score) AS performance_score FROM " . $table_name . "
		GROUP BY DATE(measure_date), strategy
		) AS T
		group by measure_date
		LIMIT 90
	");

	$chart_data = array();

	foreach ($page_speed_history as $row) {
		$chart_data[] = [$row->measure_date,intval($row->desktop),intval($row->mobile),90,50,0];
	}
if (count($page_speed_history) < 3) {
		$chart_data[] = [date('Y-m-d', strtotime('-1 day', strtotime($row->measure_date))),intval($row->desktop),intval($row->mobile),90,50,0];
		$chart_data[] = [date('Y-m-d', strtotime('-2 day', strtotime($row->measure_date))),intval($row->desktop),intval($row->mobile),90,50,0];
	}
	
	$inline_script = "
	var chart_data = " . json_encode($chart_data) . ";
	
	//Convert JSON string to date
	for (var i=0; i<chart_data.length; i++ ) {
		chart_data[i][0] = new Date(chart_data[i][0] + ' 00:00:00 GMT+0" . get_option( 'gmt_offset' ) . "00');
	}

	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(function() { drawChart(chart_data); });
	";

	wp_add_inline_script( 'Page Speed Insights JS', $inline_script);

}

