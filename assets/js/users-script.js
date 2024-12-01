
jQuery(document).ready(function($){
	
	
	
	function setDataTable(){
			
		/* dataTable options */
		var tbl_ids = [ "escrot-escrow-table", "escrot-earning-table", "escrot-user-table"];
		
		for(i=0;i<tbl_ids.length;i++){ 
			
			var t = $('#'+tbl_ids[i]+'').DataTable( {
				retrieve: true,
				'columnDefs': [ {
					'searchable': true,
					'orderable': false,
					'targets': 1
				} ],
				'order': [[ 1, 'asc' ]]
			} );
			t.on( 'order.dt search.dt', function () {//DataTable Numbering
			   t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			   } );
			} ).draw();
		}	
	
	
		/*Table options Button*/
		
		//unhides first option content
		$('#escrot-option1').show();
		$('#escrot-option1b').show();
		$('#escrot-option3').show();
		$('#escrot-option3b').show();
		
		//listen to dropdown for change
		$('#escrot-list-actions').change(function(){
		  $('.escrot-apply-btn').hide();//rehide content on change
		  $('#'+$(this).val()).show(); //unhides current item
		});
		 $('#escrot-list-actions2').change(function(){
		  $('.escrot-apply-btn2').hide();
		  $('#'+$(this).val()).show();
		});
		$('#escrot-list-actions3').change(function(){
		  $('.escrot-apply-btn3').hide(); 
		  $('#'+$(this).val()).show();
		});
		 $('#escrot-list-actions4').change(function(){
		  $('.escrot-apply-btn4').hide();
		  $('#'+$(this).val()).show();
		});
			
	}
	 
	 
	//Get URL Token value for user_id (GET Response) 
	var urlParams = new URLSearchParams(window.location.search); 
	 
	
	//Display Users Table
    displayUsers();
    function displayUsers(){
	    var data = {'action':'escrot_users',};
		$.post(escrot.ajaxurl, data, function(response) {
		    $("#escrot-admin-container").html(response);
		    setDataTable();
		});
    }
	
	
	//Reload Users Table
    function reloadUsers(){
	    if(escrot.is_user == 'true'){ 
			var data = {'action':'escrot_reload_user_account',};
			$.post(escrot.ajaxurl, data, function(response) {
				$("#escrot-edit-account").html(response); 
			});
		} else { 
			var data = {'action':'escrot_users_tbl',}; 
			$.post(escrot.ajaxurl, data, function(response) {
				$("#escrot-user-table-wrapper").html(response);
				setDataTable();
			});
		}
		
    }
	
	
	
	//Display User Profile
	if(urlParams.get('user_id')){//if get token show profile
       showUserProfile();
	} 
    function showUserProfile(){
		var user_id = urlParams.get('user_id');
	    var data = {
			'action':'escrot_user_profile',
			'user_id':user_id, //Post the token value to php (user-profile.php)
		};
		
		jQuery.post(escrot.ajaxurl, data, function(response) {
		       $("#escrot-profile-container").html(response); 
		       setDataTable();
		});
    }



    //Check if User Email Already Exist (Verify User Email) 
	var UserEmailState = false;
    $('body').on('blur', '#EscrotUserEmail', function () {
      var UserEmail = $(this).val().trim();
	  if (UserEmail == '') {
  	  UserEmailState = false;
  	   return;
     }
      if (UserEmail != '') {
		
		var data = {
			'action':'escrot_verify_useremail',
		    'UserEmail':UserEmail,
		};
		$.post(escrot.ajaxurl, data, function(response) {
		   if (response == "taken" ) {
		      UserEmailState  = false;
              $('#EscrotUserEmail_notice').html('<span class="text-danger">User with email <b>'+UserEmail+'</b> Already Exist!</span>');
            }
	        else if (response == "not_taken") {
			  UserEmailState  = true;
      	      $('#EscrotUserEmail_notice').html('');
            }
		});
		
      } else {
        $("#EscrotUserEmail_notice").html("");
      }
	  
    });


	//insert/add User 		
	$("body").on('submit', '#UserAddForm', function(e){
        e.preventDefault();
			  swal.fire({
    		  	title: 'Really want to add User?',
    		  	text: "Choose Cancel if you're not sure!",
    		  	icon: 'warning',
    		  	showCancelButton: true,
    		  	confirmButtonColor: '#3085d6',
    		  	cancelButtonColor: '#d33',
    		  	confirmButtonText: 'Yes, add User!',
    		}).then((result) => {
    		  	if (result.value){
					
					
	if ( UserEmailState == false) {
	  $('#escrot-add-user-error').html('<p style="color: white; text-align: center;" class="alert alert-danger">Please fix the errors in the form first</p>');
	}
		else{	
			
            var form_data = $(this).serialize();
		
		    $.post(escrot.ajaxurl, form_data, function(response) { 
		  
                if(response.status == "success"){
                  Swal.fire({
                     icon: 'success',
                     title: 'User Added successfully',
					 showConfirmButton: false, 
		             timer: 1500,
                  });
                  $("#escrot-add-user-modal").modal('hide');
				  $("#escrot-add-user-form-dialog").collapse('hide');
                  $("#UserAddForm")[0].reset();
                  reloadUsers();
				  $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
                } 
		 
		    });
			
			
			}//else
		
		   }
		 });//then
    });
	

    //Edit User Record (pull existing data into form)
    $("body").on("click", ".escrot-user-edit-btn", function(e){
        
		e.preventDefault();
        
		var UserId = $(this).attr('id');
		
	    var data = {
			'action':'escrot_user_data',
		    'UserId':UserId,
		};
		
		$.post(escrot.ajaxurl, data, function(response) {
		  
          $("#EditEscrotUserID").val(response.data.user_id);
          $("#EditEscrotUserFirstName").val(response.data.firstname);
          $("#EditEscrotUserLastName").val(response.data.lastname);
		  $("#EditEscrotUserEmail").val(response.data.email);
          $("#EditEscrotUserPhone").val(response.data.phone);
		  $("#EditEscrotUserCountry").val(response.data.country);
		  $("#EditEscrotUserCompany").val(response.data.company);
          $("#EditEscrotUserSA").val(response.data.sa_id);
		  $("#EditEscrotUserUsername").val(response.data.username);
		  $("#EditEscrotUserBio").val(response.data.bio);
		  $("#EditEscrotUserAddress").val(response.data.address);
		  $("#EditEscrotUserUrl").val(response.data.website);
		  $("#EditEscrotUserImg").val(response.data.user_image);
		  $("#CrtEditUserID").html(response.data.email);//populate edit user form title with current cutomer email
		   
		   //set variable for current User image
		   var image_path =  response.data.user_image;  
		   
		  //if user_image column (in database) is not empty, replace default avatar with availble image, then add "Change" & "Remove" btns
		  if (image_path != "")
		   {
			  $(".EditEscrotUserImg-FilePrv").attr("class", "fileinput-new thumbnail"); 
			  $(".EditEscrotUserImg-PrevUpload").attr("src", ""+image_path+""); 
			  $(".EditEscrotUserImg-AddFile").css("display", "none");
			  $(".EditEscrotUserImg-ChangeFile").css("display", "inline");
			  $(".EditEscrotUserImg-dismissPic").css("display", "inline");
			  
	       }
      });
	  $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-admin-forms').offset().top}, 'slow'); 
	  
    });


  	//update User
	$("body").on('submit', '#escrot-edit-user-form', function(e){
        e.preventDefault();
			  swal.fire({
    		  title: 'Are you sure?',
    		  	text: "Choose Cancel if you're not sure!",
    		  	icon: 'warning',
    		  	showCancelButton: true,
    		  	confirmButtonColor: '#3085d6',
    		  	cancelButtonColor: '#d33',
    		  	confirmButtonText: 'Yes, update User!',
    		}).then((result) => {
    		   if (result.value){
		   
		       var form_data = $(this).serialize();
		
		       $.post(escrot.ajaxurl, form_data, function(response) { 
		  
                  if(response.success){
					
						Swal.fire({
						   icon: 'success',
						   title:response.data.message,
						   showConfirmButton: false, 
						   timer: 1500,
						});
						$("#escrot-edit-user-modal").modal('hide');
						$("#escrot-edit-user-form-dialog").collapse('hide');
						$("#escrot-edit-user-form")[0].reset();
						if(urlParams.get('user_id') !== null){
							  location.reload();
						} else { 
							reloadUsers();
							$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
						}
						
				    }
		       });
			}
	    });//then
      });


    

    //Delete User Record
    $("body").on("click", ".escrot-delete-user-btn", function(e){
         e.preventDefault();
    		 var tr = $(this).closest('tr');
             var UserID = $(this).attr('id');
			 
    		swal.fire({
    		  	title: 'Are you sure?',
    		  	text: "You won't be able to revert this! All data linked to this User (escrows, notifications..etc) will also be deleted. Do you still want to continue?",
    		  	icon: 'warning',
    		  	showCancelButton: true,
    		  	confirmButtonColor: '#d33',
    		  	cancelButtonColor: '#3085d6',
    		  	confirmButtonText: 'Yes, delete User!',
    		}).then((result) => {
    		  if (result.value){
			       
			        var data = {
			            'action':'escrot_del_user',
		                'UserID':UserID,
		            };
		
		            $.post(escrot.ajaxurl, data, function(response) {
                        
						tr.css('background-color','#ff6565');
                        Swal.fire({
                           icon: 'success',
                           title: 'User Deleted Successfully',
						   showConfirmButton: false, 
		                   timer: 1500,
                        });
						if(urlParams.get('user_id') !== null){
						      var url = $('#escrot-user-account').data('users-url');
							  window.location = url;
						} else { 
							reloadUsers();
							$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
						}
						
		            });
    		}
     
    	})
     
    });
	
	
  
    // Delete Multiple Assigned Users
    $(document).on('click', '.escrot-mult-delete-user-btn', function(e) {
		var Users = [];
		$(".escrot-checkbox:checked").each(function() {
			Users.push($(this).data('escrot-row-id'));
		});
		if(Users.length <=0) {
			 Swal.fire({
                     icon: 'warning',
                     title: 'No Record Selected.',
					 text: "Please select atleast 1 User to continue!",
                   });
		} 
		else { 
			
			swal.fire({
    		  	title: 'Are you sure?',
    		  	text: "You won't be able to revert this! All data linked to these Users (escrows, notifications..etc) will also be deleted. Do you still want to continue?",
    		  	icon: 'warning',
    		  	showCancelButton: true,
    		  	confirmButtonColor: '#d33',
    		  	cancelButtonColor: '#3085d6',
    		  	confirmButtonText: 'Yes, delete '+(Users.length>1?'Users':'User')+'!',
    		}).then((result) => {
    		  if (result.value){	
				
				var selected_values = Users.join(",");
				
				var data = {
			        'action':'escrot_del_users',
		            'multUserid':selected_values,
		        };
		
		        $.post(escrot.ajaxurl, data, function(response) {
                    var multUserids = selected_values.split(",");
	  
		            for (var i=0; i < multUserids.length; i++ ) {	
			        $("#"+multUserids[i]).css('background-color','#ff6565'); 
			        Swal.fire({
                        icon: 'success',
                        title: ''+(Users.length>1?'Users':'User')+' deleted successfully',
			            text: ''+(Users.length)+' '+(Users.length>1?'Records':'Record')+' Deleted!',
						showConfirmButton: false, 
		                timer: 1500,
                    });
                        reloadUsers();
		            }	
		        });
				
			} 
		}) //swal.fire end
		}
    });	


    //Add Product Image File uploader
	$(document).on('click', '.EscrotUserImg', function (e) {
		e.preventDefault();
		var $button = $(this);

		var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image' // mime type
			},
			button: {
				text: 'Select Image'
			},
			multiple: false
		});

		file_frame.on('select', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$(".EscrotUserImg-FileInput").val(attachment.url);
			$(".EscrotUserImg-FilePrv").removeClass("img-circle"); 
			$(".EscrotUserImg-PrevUpload").attr("src", ""+attachment.url+"");
            $(".EscrotUserImg-AddFile").css("display", "none");			
			$(".EscrotUserImg-ChangeFile").css("display", "inline");
			$(".EscrotUserImg-dismissPic").css("display", "inline");
		});

		file_frame.open();
	});
	//Reset upload field
    $("body").on("click", ".EscrotUserImg-dismissPic", function(e){
        $(".EscrotUserImg-ChangeFile").css("display", "none");
	    $(".EscrotUserImg-AddFile").css("display", "inline");
	    $(".EscrotUserImg-dismissPic").css("display", "none");EditEscrotUserImg-
        $(".EscrotUserImg-FileInput").val("");
		$(".EscrotUserImg-FilePrv").addClass("img-circle"); 
		$(".EscrotUserImg-PrevUpload").attr("src", $(this).data('avatar-url'));
    });
	

    //Edit User Image File uploader
	$(document).on('click', '.EditEscrotUserImg', function (e) {
		e.preventDefault();
		var $button = $(this);

		var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image' // mime type
			},
			button: {
				text: 'Select Image'
			},
			multiple: false
		});

		file_frame.on('select', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$(".EditEscrotUserImg-FileInput").val(attachment.url);
			$(".EditEscrotUserImg-FilePrv").removeClass("img-circle"); 
			$(".EditEscrotUserImg-PrevUpload").attr("src", ""+attachment.url+"");
            $(".EditEscrotUserImg-AddFile").css("display", "none");			
			$(".EditEscrotUserImg-ChangeFile").css("display", "inline");
			$(".EditEscrotUserImg-dismissPic").css("display", "inline");
		});

		file_frame.open();
	});
	//Reset upload field
    $("body").on("click", ".EditEscrotUserImg-dismissPic", function(e){
        $(".EditEscrotUserImg-ChangeFile").css("display", "none");
	    $(".EditEscrotUserImg-AddFile").css("display", "inline");
	    $(".EditEscrotUserImg-dismissPic").css("display", "none");
        $(".EditEscrotUserImg-FileInput").val("");
		$(".EditEscrotUserImg-FilePrv").addClass("img-circle"); 
		$(".EditEscrotUserImg-PrevUpload").attr("src", '');
    });


    
   
    //Scroll to Users Orders
	$("body").on('click', '#viewtrkgs', function() {	
	      $("html, .escrot-main-panel").animate({scrollTop: $('#UserOrders').offset().top}, 'slow'); 
    });
	

});
	

