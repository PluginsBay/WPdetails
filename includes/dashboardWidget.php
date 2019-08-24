<?php
function wpde_load_widget_data() {
	global $wpdb;
	global $desktop_results;
	global $mobile_results;
	$table_name = $wpdb->prefix . "wpde_page_speed_insights";   
	$desktop_results = $wpdb->get_results( "SELECT * FROM $table_name WHERE strategy = 1 ORDER BY measure_date DESC LIMIT 1");
	$mobile_results = $wpdb->get_results( "SELECT * FROM $table_name WHERE strategy = 2 ORDER BY measure_date DESC LIMIT 1");
}
function wpde_add_dashboard_widgets() {
 	wp_add_dashboard_widget( 'wpde_dashboard_widget', __('Google PageSpeed','wpde-page-speed-insights'), 'wpde_dashboard_widget_function' );
	global $wp_meta_boxes;
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
 	$wpde_dashboard_widget_backup = array( 'wpde_dashboard_widget' => $normal_dashboard['wpde_dashboard_widget'] );
 	unset( $normal_dashboard['wpde_dashboard_widget'] );
 	$sorted_dashboard = array_merge( $wpde_dashboard_widget_backup, $normal_dashboard );
 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
} 
add_action( 'wp_dashboard_setup', 'wpde_add_dashboard_widgets' );
function wpde_dashboard_widget_function() {

	global $desktop_results; 
	global $mobile_results;
?>
<div id="widget" style="border: 1px solid #ebebeb;padding: 5px;">
	<?php
		if (wpde_is_localhost()) {
	?>
		<p><?php _e('Google PageSpeed Insights doesnt work on localhost.','wpde-page-speed-insights'); ?></p>

	<?php
		} else {
	?>		

	<div style="text-align: center; padding-top:10px;">    
		<?php
		if(empty($desktop_results))                      
		{
			?>
				<div id="widget" style="border: 1px solid #ebebeb;padding: 5px;">
					<div style="text-align: center;"><?php _e('No desktop data available.','wpde-page-speed-insights'); ?></div>
				</div>
			<?php      
		}			
		if(empty($mobile_results))                      
		{
			?>
				<div id="widget" style="border: 1px solid #ebebeb;padding: 5px;">
					<div style="text-align: center;"><?php _e('No mobile data available.','wpde-page-speed-insights'); ?></div>
				</div>
			<?php      
		}	
		?>
		<div class="wrapper desktop">
			<div style="text-align: center;width: inherit;"><?php _e('Desktop','wpde-page-speed-insights'); ?></div>
			<svg id="meter">
				<circle r="53" cx="50%" cy="50%" stroke="#e8eaed" stroke-width="10" fill="none"></circle>
				<circle r="53" cx="50%" cy="50%" stroke="<?php echo wpde_get_color($desktop_results[0]->performance_score); ?>" stroke-width="10" fill="none" class="frontCircle mobile_mainColor"></circle> <!--  transform="rotate(-90,240,240)" -->
			 </svg>
			 <div class="perf_percentage desktop_mainColor"><?php echo $desktop_results[0]->performance_score; ?></div>
		</div>
		<div class="wrapper mobile">
			<div style="text-align: center;width: inherit;"><?php _e('Mobile','wpde-page-speed-insights'); ?></div>
			<svg id="meter">
				<circle r="53" cx="50%" cy="50%" stroke="#e8eaed" stroke-width="10" fill="none"></circle>
				<circle r="53" cx="50%" cy="50%" stroke="<?php echo wpde_get_color($mobile_results[0]->performance_score); ?>" stroke-width="10" fill="none" class="frontCircle mobile_mainColor"></circle> <!--  transform="rotate(-90,240,240)" -->
			</svg>
			<div class="perf_percentage mobile_mainColor"><?php echo $mobile_results[0]->performance_score; ?></div>
		</div>	
	</div>
	<div style="padding:10px;font-family: Roboto,Helvetica,Arial,sans-serif; font-size: 14px;">
		<div style="border-bottom: 1px solid #ebebeb; display: flex;justify-content: space-between; padding:8px;"><span><?php _e('First Contentful Paint','wpde-page-speed-insights'); ?></span><div style="padding-right: 5px; font-weight:bold;"><span class="desktop_mainColor"><?php echo $desktop_results[0]->first_contentful_paint; ?>&nbsp;s</span>&nbsp;/&nbsp;<span class="mobile_mainColor"><?php echo $mobile_results[0]->first_contentful_paint; ?>&nbsp;s</span></div></div>
		<div style="border-bottom: 1px solid #ebebeb; display: flex;justify-content: space-between; padding:8px;"><span><?php _e('Speed Index','wpde-page-speed-insights'); ?></span><div style="padding-right: 5px; font-weight:bold;"><span class="desktop_mainColor"><?php echo $desktop_results[0]->speed_index; ?>&nbsp;s</span>&nbsp;/&nbsp;<span class="mobile_mainColor"><?php echo $mobile_results[0]->speed_index; ?>&nbsp;s</span></div></div>
		<div style="border-bottom: 1px solid #ebebeb; display: flex;justify-content: space-between; padding:8px;"><span><?php _e('Time to Interactive','wpde-page-speed-insights'); ?></span><div style="padding-right: 5px; font-weight:bold;"><span class="desktop_mainColor"><?php echo $desktop_results[0]->interactive; ?>&nbsp;s</span>&nbsp;/&nbsp;<span class="mobile_mainColor"><?php echo $mobile_results[0]->interactive; ?>&nbsp;s</span></div></div>
		<div style="color: #0000008a; font-size: 10px; text-align:right;"><?php _e('Measured at','wpde-page-speed-insights');?> <?php echo $mobile_results[0]->measure_date . " " . __('By','wpde-page-speed-insights'); ?>: <a href="https://www.itman.sk/en/" target="_blank">ITMan</a></div>	    
		
		<?php
			$site_url = get_home_url();
			$google_page_speed_call = "https://developers.google.com/speed/pagespeed/insights/?url=" .  $site_url;
		?>
</div>

	<?php
		}
	?>		

</div>
<?php
}
function wpde_load_widget_dyn_style() {

	global $desktop_results; 
	global $mobile_results;

	$desktop_main_color = wpde_get_color($desktop_results[0]->performance_score);
	$mobile_main_color = wpde_get_color($mobile_results[0]->performance_score);

	$desktop_style = "
		.desktop .frontCircle{
			stroke-linecap: round;
			-webkit-animation-name: wpde-desktop; /* Safari 4.0 - 8.0 */
			-webkit-animation-duration: 2s; /* Safari 4.0 - 8.0 */
			-webkit-animation-timing-function: ease forwards;
			animation-name: wpde-desktop;
			animation-duration: 2s;
			animation-timing-function: ease forwards;
			stroke-dasharray: " . (($desktop_results[0]->performance_score*329)/100) . ", 329; 
		}	
		.desktop_mainColor {
			color: " . $desktop_main_color . ";
		}	

		@keyframes wpde-desktop {
		  	from {stroke-dasharray:0, 329;}
		  	to {stroke-dasharray:" . (($desktop_results[0]->performance_score*329)/100) . ", 329};
		}
		";
	
	$mobile_style = "	
		.mobile .frontCircle{
			stroke-linecap: round;
			-webkit-animation-name: wpde-mobile; /* Safari 4.0 - 8.0 */
			-webkit-animation-duration: 2s; /* Safari 4.0 - 8.0 */
			-webkit-animation-timing-function: ease forwards;
			animation-name: wpde-mobile;
			animation-duration: 2s;
			animation-timing-function: ease forwards;
			stroke-dasharray: " . (($mobile_results[0]->performance_score*329)/100) . ", 329; 
		}	
		.mobile_mainColor {
			color: " . $mobile_main_color . ";
		}	

		@keyframes wpde-mobile {
			from {stroke-dasharray:0, 329;}
		  	to {stroke-dasharray:" . (($mobile_results[0]->performance_score*329)/100) . ", 329};
		}		
	";	
	wp_add_inline_style( 'Page Speed Insights', $desktop_style . $mobile_style);
}

add_action( 'admin_enqueue_scripts', 'wpde_load_widget_dyn_style' );