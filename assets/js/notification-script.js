
jQuery(document).ready(function($){
	   
 
    function load_unseen_notification(view = '') { 
	    var endpoint_url = $('#escrot-front-user-noty').data('endpoint-url');
	    var data = {'action':'escrot_notifications', 'endpoint_url':endpoint_url, 'noty-action':view,};
	
	    jQuery.post(escrot.ajaxurl, data, function(response) {   
	   
           $('.notif-content').html(response.noty);
           if(response.unseen_noty > 0){
	          $('.notification').addClass(response.noty_bg_class);	 
              $('.notification').html(response.unseen_noty);
            }
     
        });
	
   }
 
   load_unseen_notification();
 
   $('body').on('click', '.escrot-view-notif', function(){
      $('.notification').removeClass('bg-secondary bg-primary');		  
      $('.notification').html('');
      load_unseen_notification('yes');
   });
 
 
});