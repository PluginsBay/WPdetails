<?php
/*
Plugin Name: WP Details
Plugin URI: https://pluginsbay.com/plugins/wp-details/
Description: Collection of WordPress dashboard widgets
Version: 1.0.5
Author: Plugins Bay
Author URI: https://pluginsbay.com/
*/

require_once( trailingslashit(dirname( __FILE__ )) . 'settings/settings.php' );
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpd-functions.php' );
//if (defined('DOING_AJAX') && DOING_AJAX) { //} else {
require_once( trailingslashit(dirname( __FILE__ )) . 'visitor-stats/index.php' );
//}
require_once( trailingslashit(dirname( __FILE__ )) . 'site-stats/index.php' );
add_action('plugins_loaded', 'wpd_core', 12);
//add_action('admin_menu', 'wpd_panel_settings', 12);
require_once( trailingslashit(dirname(__FILE__)) . 'lib/wpd-register-hook.php' );
register_activation_hook(__FILE__, 'wpd_admin_activation');
register_deactivation_hook(__FILE__, 'wpd_admin_deactivation');
/*
Server info
*/
class Site_Info_Dashboard_Widget {
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
		add_action( 'plugins_loaded',     array( $this, 'load_textdomain' )      );
	}
	public function load_textdomain() {
		load_plugin_textdomain( 'site-info-dashboard-widget' ); 
	}
	public function add_dashboard_widget() {
		wp_add_dashboard_widget(
			'site_info_dashboard_widget',
			__( 'Server Info', 'site-info-dashboard-widget' ),
			array( $this, 'render_dashboard_widget' )
		);
	}
	public function render_dashboard_widget() {
		global $wpdb;
		$info = array(
			__( 'PHP Version',            'site-info-dashboard-widget') => PHP_VERSION,
			__( 'MySQL Version',          'site-info-dashboard-widget') => $wpdb->db_version(),
			__( 'Web Server Info',        'site-info-dashboard-widget') => esc_html( $_SERVER['SERVER_SOFTWARE'] ),
			__( 'WP Memory Limit', 'site-info-dashboard-widget') => size_format( WP_MEMORY_LIMIT ),
		);
		echo '<table>';
		foreach ( $info as $key => $value ) {
			echo '<tr><td><strong>' . $key . ' :</strong></td><td>' . $value . '</td></tr>';
		}
		echo '</table>';
	}
}

new Site_Info_Dashboard_Widget;
/*
function wpd_dashboard_columns() {
    add_screen_option(
        'layout_columns',
        array(
            'max'     => 3,
            'default' => 2
        )
    );
}*/
//add_action( 'admin_head-index.php', 'wpd_dashboard_columns' );
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

/*
Edit Profile
*/
/**
 * @author David Chandra Purnama <david@genbumedia.com>
 * @copyright Copyright (c) 2016, Genbu Media
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
**/
define( 'FX_PDW_VERSION', '9.9.9' );
define( 'FX_PDW_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );
define( 'FX_PDW_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

add_action( 'plugins_loaded', 'fx_pdw_plugins_loaded' );

function fx_pdw_plugins_loaded(){
	/* Load Settings */
	if( is_admin() ){
		require_once( FX_PDW_PATH . 'includes/dashboard-widget.php' );
		$fx_profile_dashboard_widget = new fx_Profile_Dashboard_Widget();
	}
}
/*
WooCommerce
*/
//define('WCDS_PLUGIN_URL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
define('WCDS_PLUGIN_URL', rtrim(plugin_dir_url(__FILE__), "/") ) ;
define('WCDS_PLUGIN_ABS_PATH', dirname( __FILE__ ) );

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ||
     (is_multisite() && array_key_exists( 'woocommerce/woocommerce.php', get_site_option('active_sitewide_plugins') ))	
	)
{

	$wcds_id = 13541759;
	$wcds_name = "WooCommerce Dashboard Widgets";
	$wcds_activator_slug = "wcds-activator";
	
	//com
	include_once( "classes/com/WCDS_Globals.php");
	require_once('classes/admin/WCDS_ActivationPage.php');
	
	
	add_action('admin_init', 'wcds_register_settings');
	add_action('init', 'wcds_init');
	add_action('admin_notices', 'wcds_admin_notices' );
	add_action('admin_menu', 'wcds_init_act');
	if(defined('DOING_AJAX') && DOING_AJAX)
		wcds_init_act();
	//add_action('wp', 'wcds_init');
}
function wcds_init()
{
	//$wcds_html_helper = new WCDS_Html(); 
	/* if(is_admin())
		wcds_init_act(); */
}
function wcds_setup()
{
	global $wcps_option_model, $wcds_customer_model, $wcds_order_model, $wcds_product_model, $wcds_html_helper, $wcps_dashboard_widgets ;
	//com
	if(!class_exists('WCDS_Option'))
		require_once('classes/com/WCDS_Option.php');
	$wcps_option_model = new WCDS_Option();
	
	if(!class_exists('WCDS_Wpml'))
		require_once('classes/com/WCDS_Wpml.php');
	
	if(!class_exists('WCDS_Customer'))
		require_once('classes/com/WCDS_Customer.php');
	$wcds_customer_model = new WCDS_Customer();
	
	if(!class_exists('WCDS_Order'))
		require_once('classes/com/WCDS_Order.php');
	$wcds_order_model = new WCSD_Order();
	
	if(!class_exists('WCDS_Product'))
		require_once('classes/com/WCDS_Product.php');
	$wcds_product_model = new WCDS_Product();
	
	if(!class_exists('WCDS_Html'))
		require_once('classes/com/WCDS_Html.php');
	$wcds_html_helper = new WCDS_Html(); 
	if(!class_exists('WCDS_Dashboard'))
		require_once('classes/admin/WCDS_Dashboard.php');
	$wcps_dashboard_widgets = new WCDS_Dashboard();
	
	add_action('admin_menu', 'wcds_init_admin_panel');	
}
function wcds_admin_notices()
{
	global $wcds_notice, $wcds_name, $wcds_activator_slug;
	if($wcds_notice && (!isset($_GET['page']) || $_GET['page'] != $wcds_activator_slug))
	{
	}
}
function wcds_register_settings()
{
	load_plugin_textdomain('woocommerce-dashboard-stats', false, basename( dirname( __FILE__ ) ) . '/languages' );
	register_setting('wcds_options_group', 'wcds_options');
}
function wcds_init_act()
{
	global $wcds_activator_slug, $wcds_name, $wcds_id;
	new WCDS_ActivationPage($wcds_activator_slug, $wcds_name, 'woocommerce-dashboard-stats', $wcds_id, WCDS_PLUGIN_URL);
}
function wcds_init_admin_panel()
{ 
	$place = wcds_get_free_menu_position(56 , .1);
	$cap = 'manage_woocommerce';
	//add_menu_page( __('Dashboard', 'woocommerce-dashboard-stats'), __('Dashboard', 'woocommerce-dashboard-stats'), 'manage_woocommerce', 'wcps-dashboard-stats', 'wcds_load_bulk_editor_page', 'dashicons-tag', $place);
	//add_submenu_page('wcps-dashboard-stats',  __('Orders/Coupons finder', 'woocommerce-dashboard-stats'), __('Orders finder', 'woocommerce-dashboard-stats'), 'manage_woocommerce', 'woocommerce-dashboard-stats-orders-finder', 'wcds_load_orders_finder_page');
	//add_submenu_page('woocommerce', __('Dashboard Widgets', 'woocommerce-dashboard-stats'), __('Dashboard Widgets', 'woocommerce-dashboard-stats'), $cap, 'woocommerce-dashboard-stats-settings', 'wcds_load_settings_view');
}
function wcds_load_settings_view()
{
	if(!class_exists('WCDS_SettingsPage'))
	require_once('classes/admin/WCDS_SettingsPage.php');
	$wcds_setting_page = new WCDS_SettingsPage();
	$wcds_setting_page->render_page();
}
function wcds_load_orders_finder_page()
{
	/* if(!class_exists('wcds_Finder'))
		require_once('classes/admin/wcds_Finder.php');
	$orders_finder = new wcds_Finder();
	$orders_finder->render_page(); */
}
function wcds_get_free_menu_position($start, $increment = 0.3)
{
	foreach ($GLOBALS['menu'] as $key => $menu) {
		$menus_positions[] = $key;
	}
	if (!in_array($start, $menus_positions)) return $start;

	while (in_array($start, $menus_positions)) {
		$start += $increment;
	}
	return $start;
}
function wcds_var_dump($var)
{
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}
?>