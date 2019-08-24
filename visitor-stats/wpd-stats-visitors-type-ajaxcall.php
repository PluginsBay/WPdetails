<div class="wpd-stats">

<script>		
	jQuery(document).ready(function(){
		function online_today_visitors(){
			jQuery.ajax({
					type: 'POST',
					url: wpdwid_ajax.wpdwid_ajaxurl,
					data: {"action": "wpdwid_visitors_type"},
					success: function(data)
							{
								jQuery(".wpd_visitors_type").html(data);
							}
				});
		}
			online_today_visitors();
	
			setInterval(function(){
					online_today_visitors();
			}, 300000)


	        jQuery(document).on('click', "#wpd_visitors_type_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpd_visitors_type").html("Loading...");
						online_today_visitors();
						//console.log("recall");
	                            }
	        });			
	});
			
</script>

<div class="wpd_visitors_type"><?php echo __("Loading...","wpdlang"); ?></div>


</div>