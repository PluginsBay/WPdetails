<div class="wpd-stats">

<script>		
	jQuery(document).ready(function(){
		function browsers_used_by_visitors(){

			jQuery.ajax({
					type: 'POST',
					url: wpdwid_ajax.wpdwid_ajaxurl,
					data: {"action": "wpdwid_browser_type"},
					success: function(data)
							{
								jQuery(".wpd_browser_type").html(data);
							}
				});
		}
			browsers_used_by_visitors();
	
			setInterval(function(){
					browsers_used_by_visitors();
			}, 300000)
	

	        jQuery(document).on('click', "#wpd_browser_type_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpd_browser_type").html("Loading...");
						browsers_used_by_visitors();
						//console.log("recall");
	                            }
	        });

	});




			
</script>

<div class="wpd_browser_type"><?php echo __("Loading...","wpdlang"); ?></div>


</div>