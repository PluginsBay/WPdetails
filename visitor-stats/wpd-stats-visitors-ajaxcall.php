<div class="wpd-stats">

<script>		
	jQuery(document).ready(function(){
			setInterval(function(){
				jQuery.ajax(
						{
					type: 'POST',
					url: wpdwid_ajax.wpdwid_ajaxurl,
					data: {"action": "wpdwid_visitors2"},
					success: function(data)
							{
								jQuery(".visitors2").html(data);
							}
						});	
			}, 300000)
	});
			
</script>


<div class="visitors2"></div>


</div>