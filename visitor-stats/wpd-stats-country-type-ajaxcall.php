<div class="wpd-stats">

<script>		
	jQuery(document).ready(function(){
		function countrys_used_by_visitors(){
			jQuery.ajax({
					type: 'POST',
					url: wpdwid_ajax.wpdwid_ajaxurl,
					data: {"action": "wpdwid_country_type"},
					success: function(data)
							{
								jQuery(".wpd_country_type").html(data);
							}
				});
		}
			countrys_used_by_visitors();
	
			setInterval(function(){
					countrys_used_by_visitors();
			}, 300000)


	        jQuery(document).on('click', "#wpd_country_type_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpd_country_type").html("Loading...");
						countrys_used_by_visitors();
						//console.log("recall");
	                            }
	        });


	});
			
</script>

<div class="wpd_country_type"><?php echo __("Loading...","wpdlang"); ?></div>


</div>