<div class="wpd-wid-admin">
<script>		
	jQuery(document).ready(function(){
		function post_registrations_by_year(){
			jQuery.ajax(
						{
					type: 'POST',
					url: wpdwid_ajax.wpdwid_ajaxurl,
					data: {"action": "wpdwid_poststats"},
					success: function(data)
							{
								jQuery(".wpd_poststats").html(data);
							}
						});
		}
		post_registrations_by_year();
			setInterval(function(){
					post_registrations_by_year();
			}, 300000)
			
	        jQuery(document).on('click', "#poststats_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpd_poststats").html("Loading...");
						post_registrations_by_year();
						//console.log("recall");
	                            }
	        });
	});
			
</script>
<div class="wpd_poststats">	
</div>
</div>