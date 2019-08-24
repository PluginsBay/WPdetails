<?php
defined('ABSPATH') or die("Silence is golden :)");
function wpd_poststats_add_dashboard() {
  wp_add_dashboard_widget( 'poststats_wp_dashboard', __('Posts', 'wpdlang') , 'wpd_poststats_dashboard_output' );
}
function wpd_poststats_dashboard_output() {
  include('includes/poststats-ajaxcall.php');
}
function wpdwid_poststats(){  
  include('includes/wpd-stats-posts.php');
  wp_show_stats_posts();
  die();
}
add_action('wp_ajax_wpdwid_poststats', 'wpdwid_poststats');
add_action('wp_ajax_nopriv_wpdwid_poststats', 'wpdwid_poststats');
function wpd_commentstats_add_dashboard() {
  wp_add_dashboard_widget( 'commentstats_wp_dashboard', __('Comments', 'wpdlang') , 'wpd_commentstats_dashboard_output' );
}

function wpd_commentstats_dashboard_output() {
  include('includes/commentstats-ajaxcall.php');
}

function wpdwid_commentstats(){  
  include('includes/wpd-stats-comments.php');
  wp_show_stats_comments();
  die();
}

add_action('wp_ajax_wpdwid_commentstats', 'wpdwid_commentstats');
add_action('wp_ajax_nopriv_wpdwid_commentstats', 'wpdwid_commentstats');

?>
