<?php
function wpde_fetchPageSpeedData() {
if (wpde_is_localhost()) return 0;
$strategy_arr = array(1 => 'desktop',2 => 'mobile');

	foreach($strategy_arr as $strategy_id => $strategy_text) {

		$site_url = get_home_url();

		$google_page_speed_call = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=" .  $site_url . "&strategy=" . $strategy_text;
		$response = wp_remote_get($google_page_speed_call, array('timeout' => 30));
		$google_ps = json_decode($response['body'], true);
		global $wpdb;
		$table_name = $wpdb->prefix . "wpde_page_speed_insights";

		$wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO $table_name
				(strategy, measure_date, performance_score,first_contentful_paint,speed_index,interactive)
				VALUES ( %s, %s, %f, %f, %f, %f)
			", 
			$strategy_id, 
			current_time("Y-m-d H:i:s"), 
			($google_ps['lighthouseResult']['categories']['performance']['score']*100),
			$google_ps['lighthouseResult']['audits']['first-contentful-paint']['displayValue'],
			$google_ps['lighthouseResult']['audits']['speed-index']['displayValue'],
			$google_ps['lighthouseResult']['audits']['interactive']['displayValue']
		) );
	}
}