
jQuery(document).ready(function()
	{




      var hook = true;
      window.onbeforeunload = function() {
        if (hook) {
			
		  document.cookie="knp_landing=0; path=/";
		  
				var knp_online_count = -1;
				jQuery.ajax(
					{
				type: 'POST',
				url: wpdwid_ajax.wpdwid_ajaxurl,
				data: {"action": "wpdwid_offline_visitors", "knp_online_count":knp_online_count},
				success: function(data)
						{
							
						}
					});	
		  
		  
		  
		  
		  
        }
      }

		
		
		
		
	
	});	







