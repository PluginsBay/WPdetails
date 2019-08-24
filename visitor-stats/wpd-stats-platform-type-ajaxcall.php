<div class="wpd-stats">

<script>		
	jQuery(document).ready(function(){
		function platforms_used_by_visitors(){
			jQuery.ajax({
					type: 'POST',
					url: wpdwid_ajax.wpdwid_ajaxurl,
					data: {"action": "wpdwid_platform_type"},
					success: function(data)
							{
								jQuery(".wpd_platform_type").html(data);
							}
				});
		}
			platforms_used_by_visitors();
	
			setInterval(function(){
					platforms_used_by_visitors();
			}, 300000)

			
	        jQuery(document).on('click', "#wpd_platform_type_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpd_platform_type").html("Loading...");
						platforms_used_by_visitors();
						//console.log("recall");
	                            }
	        });

	});
			
</script>

<div class="wpd_platform_type"><?php echo __("Loading...","wpdlang"); ?></div>


</div>