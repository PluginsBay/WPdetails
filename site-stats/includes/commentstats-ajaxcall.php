<div class="wpd-wid-admin">
<script>		
	jQuery(document).ready(function(){

			function comment_stats_by_year(){
				jQuery.ajax(
						{
					type: 'POST',
					url: wpdwid_ajax.wpdwid_ajaxurl,
					data: {"action": "wpdwid_commentstats"},
					success: function(data)
							{
								jQuery(".wpd_commentstats").html(data);
							}
						});	
			}
			comment_stats_by_year();
			setInterval(function(){
				comment_stats_by_year();
			}, 300000)
			
	        jQuery(document).on('click', "#commentstats_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpd_commentstats").html("Loading...");
						comment_stats_by_year();
						//console.log("recall");
	                            }
	        });
	});
			
</script>
<div class="wpd_commentstats">	
</div>
</div>