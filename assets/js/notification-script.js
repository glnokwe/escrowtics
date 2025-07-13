
jQuery(document).ready(function($){
 
    function load_unseen_notification(view = '') { 
	    var dispute_url = $('#escrot-front-user-noty').data('escrot-dispute-url');
	    var data = {'action':'escrot_notifications', 'escrot_dispute_url':dispute_url, 'noty-action':view,};
	
	    jQuery.post(escrot.ajaxurl, data, function(response) {   
	   
           $('.notif-content').html(response.noty);
           if(response.unseen_noty > 0){
	          $('.escrot-notification').addClass(response.noty_bg_class);	 
              $('.escrot-notification').html(response.unseen_noty);
            }
     
        });
	
   }
 
   load_unseen_notification();
 
   $('body').on('click', '.escrot-view-notif', function(){
      $('.escrot-notification').removeClass('bg-secondary bg-primary');		  
      $('.escrot-notification').html('');
      load_unseen_notification('viewed');
   });
 
 
});