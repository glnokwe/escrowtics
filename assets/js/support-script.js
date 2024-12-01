
jQuery(document).ready(function($){



function setDataTable(){
		
	/* dataTable options */
	var tbl_ids = ["escrot-ticket-table"];
	for(i=0;i<tbl_ids.length;i++){ 
	    if(escrot.is_front_user == 'true'){ 
			var target_row = 0; 
		} else {
			var target_row = 1; 
		}
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
		   t.column(target_row, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		   } );
		} ).draw();
	}	
	/*Table options Button*/
	//unhides first option content
	$('#escrot-option1').show();
	$('#escrot-option1b').show();
	//listen to dropdown for change
	$('#escrot-list-actions').change(function(){
	  $('.escrot-apply-btn').hide();//rehide content on change
	  $('#'+$(this).val()).show(); //unhides current item
	});
	 $('#escrot-list-actions2').change(function(){
	  $('.escrot-apply-btn2').hide();
	  $('#'+$(this).val()).show();
	});
		
}
 
 
//Get URL Token value for ticket_id (GET Response) 
var urlParams = new URLSearchParams(window.location.search); 
 

//Display Tickets Table
displayTickets();
function displayTickets(){
	var data = {'action':'escrot_tickets',};
	$.post(escrot.ajaxurl, data, function(response) {
		$("#escrot-admin-container").html(response);
		setDataTable();
	});
}


//Reload Tickets Table
function reloadTickets(){
	var ticket_url= $('#escrot-ticket-table').data('ticket-url'); 
	var data = {'action':'escrot_tickets_tbl', 'ticket_url':ticket_url}; 
	$.post(escrot.ajaxurl, data, function(response) {
		$("#escrot-ticket-table-wrapper").html(response);
		setDataTable();
	});
}



//Vitw Ticket
if(urlParams.get('ticket_id')){//if get token show profile
   showTicketProfile();
} 
function showTicketProfile(){
	var ticket_id = urlParams.get('ticket_id');
	var data = {
		'action':'escrot_ticket_profile',
		'ticket_id':ticket_id, //Post the token value to php (ticket-profile.php)
	};
	
	jQuery.post(escrot.ajaxurl, data, function(response) {
		   $("#escrot-profile-container").html(response); 
		   setDataTable();
	});
}


//insert/add Ticket 		
$("body").on('submit', '#escrot-add-ticket-form', function(e){
	e.preventDefault();
		swal.fire({
			title: 'Really want to add Ticket?',
			text: "Choose Cancel if you're not sure!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, add Ticket!',
		}).then((result) => {
			if (result.value){
				var form_data = $(this).serialize();
			
				$.post(escrot.ajaxurl, form_data, function(response) { 
			  
					if(response.status == "success"){
					  Swal.fire({
						 icon: 'success',
						 title: 'Ticket Added successfully',
						 showConfirmButton: false, 
						 timer: 1500,
					  });
					  $("#escrot-add-ticket-modal").modal('hide');
					  $("#escrot-add-ticket-form-dialog").collapse('hide');
					  $("#escrot-add-ticket-form")[0].reset();
					  reloadTickets();
					  $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
					} 
			 
				});
	
			}
	 });//then
});


//Edit Ticket Record (pull existing data into form)
$("body").on("click", ".escrot-ticket-edit-btn", function(e){
	
	e.preventDefault();
	var TicketId = $(this).attr('id');
	var data = {
		'action':'escrot_ticket_data',
		'TicketId':TicketId,
	};
	
	$.post(escrot.ajaxurl, data, function(response) {
	  
	  $("#EditEscrotTicketID").val(response.data.ticket_id);
	  $("#EditEscrotTicketRefID").val(response.data.ref_id);
	  $("#EditEscrotTicketLastName").val(response.data.lastname);
	  $("#EditEscrotTicketUserID").val(response.data.user_id);
	  $("#EditEscrotTicketDepartment").val(response.data.department);
	  $("#EditEscrotTicketSubject").val(response.data.subject);
	  $("#EditEscrotTicketStatus").val(response.data.status);
	  $("#EditEscrotTicketPriority").val(response.data.priority);
	  
  });
  $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-admin-forms').offset().top}, 'slow'); 
  
});



//update Ticket Status
$("body").on('click', '.escrot-update-ticket-status', function(e){
	e.preventDefault();
	var ticket_id = $(this).attr('id');
	$("#escrot-ticket-id-input").val(ticket_id);
});
$("body").on('submit', '#escrot-ticket-status-form', function(e){
	e.preventDefault();
	swal.fire({
	    title: 'Are you sure?',
		text: "Choose Cancel if you're not sure!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, update status!',
	}).then((result) => {
	   if (result.value){
		   
			var form_data = $(this).serialize();
			
			$.post(escrot.ajaxurl, form_data, function(response) { 
				if(response.status == "success"){
					Swal.fire({
					   icon: 'success',
					   title: response.message,
					   showConfirmButton: false, 
					   timer: 1500,
					});
					$("#escrot-ticket-status-modal").modal('hide');
					$("#escrot-ticket-status-dialog").collapse('hide');
					$("#escrot-ticket-status-form")[0].reset();
					if(urlParams.get('ticket_id') !== null){
						  location.reload();
					} else { 
						reloadTickets();
					}
			  } 
		   });
		}
	});//then
});


//Reply Ticket
$("body").on('submit', '#escrot-ticket-reply-form', function(e){
	e.preventDefault();
	var form_data = $(this).serialize();

	$.post(escrot.ajaxurl, form_data, function(response) { 
		   $('#escrot-chat-message').animate("background-color", "green"); 
		   $('#escrot-ticket-chat-wrapper').html(response); 
		   $("#escrot-ticket-reply-form")[0].reset();
		   $('#escrot-ticket-chat-wrapper').animate({scrollTop: $('#escrot-ticket-chat-wrapper')[0].scrollHeight}, "1000");
		   $(".escrot-preview-chat-attach").html("");
		   $(".escrot-preview-chat-attach").css({"border": "none", "padding": "0", "border-radius": "0", "margin-top": "0"});
		   $(".escrot-chat-attachment").val("");
	});
});




//Delete Ticket Record
$("body").on("click", ".escrot-delete-ticket-btn", function(e){
	 e.preventDefault();
		 var tr = $(this).closest('tr');
		 var TicketID = $(this).attr('id');
		 
		swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this! All chats linked to this Ticket will also be deleted. Still want to continue?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Yes, delete Ticket!',
		}).then((result) => {
		  if (result.value){
		  
				var data = {
					'action':'escrot_del_ticket',
					'TicketID':TicketID,
				};
	
				$.post(escrot.ajaxurl, data, function(response) {
					
					tr.css('background-color','#ff6565');
					Swal.fire({
					   icon: 'success',
					   title: 'Ticket Deleted Successfully',
					   showConfirmButton: false, 
					   timer: 1500,
					});
					reloadTickets();
					
				});
		}
 
	})
 
});



//Delete Multiple Assigned Tickets
$(document).on('click', '.escrot-ticket-mult-delete-btn', function(e) {
	var Tickets = [];
	$(".escrot-checkbox:checked").each(function() {
		Tickets.push($(this).data('escrot-row-id'));
	});
	if(Tickets.length <=0) {
		 Swal.fire({
				 icon: 'warning',
				 title: 'No Record Selected.',
				 text: "Please select atleast 1 Ticket to continue!",
			   });
	} 
	else { 
		
		swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this! All chats linked to these Tickets will also be deleted. Still want to continue?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Yes, delete '+(Tickets.length>1?'Tickets':'Ticket')+'!',
		}).then((result) => {
		  if (result.value){	
			
			var selected_values = Tickets.join(",");
			
			var data = {
				'action':'escrot_del_tickets',
				'multTicketid':selected_values,
			};
	
			$.post(escrot.ajaxurl, data, function(response) {
				var multTicketids = selected_values.split(",");
  
				for (var i=0; i < multTicketids.length; i++ ) {	
				$("#"+multTicketids[i]).css('background-color','#ff6565'); 
				Swal.fire({
					icon: 'success',
					title: ''+(Tickets.length>1?'Tickets':'Ticket')+' deleted successfully',
					text: ''+(Tickets.length)+' '+(Tickets.length>1?'Records':'Record')+' Deleted!',
					showConfirmButton: false, 
					timer: 1500,
				});
					reloadTickets();
				}	
			});
			
		} 
	}) //swal.fire end
	}
});	


//Add Product Image File uploader
$(document).on('click', '.EscrotAttachment', function (e) {
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
		$(".EscrotAttachment-FileInput").val(attachment.url);
		$(".EscrotAttachment-FilePrv").removeClass("img-circle"); 
		$(".EscrotAttachment-PrevUpload").attr("src", ""+attachment.url+"");
		$(".EscrotAttachment-AddFile").css("display", "none");			
		$(".EscrotAttachment-ChangeFile").css("display", "inline");
		$(".EscrotAttachment-dismissPic").css("display", "inline");
	});

	file_frame.open();
});
//Reset upload field
$("body").on("click", ".EscrotAttachment-dismissPic", function(e){
	$(".EscrotAttachment-ChangeFile").css("display", "none");
	$(".EscrotAttachment-AddFile").css("display", "inline");
	$(".EscrotAttachment-dismissPic").css("display", "none");
	$(".EscrotAttachment-FileInput").val("");
	$(".EscrotAttachment-FilePrv").addClass("img-circle"); 
	$(".EscrotAttachment-PrevUpload").attr("src", $(this).data('avatar-url'));
});


	
//Chat File Uploader
$(document).on('click', '.escrot-chat-attachment', function (e) {
	e.preventDefault();
	var $button = $(this);

	var file_frame = wp.media.frames.file_frame = wp.media({
		title: 'Select or Upload an Image',
		library: {
		type: 'image, application/pdf' // mime type
		},
		button: {
			text: 'Select Image'
		},
		multiple: false
	});
	file_frame.on('select', function() {
		var attachment = file_frame.state().get('selection').first().toJSON();
		$(".escrot-chat-attachment").val(attachment.url);
		if(attachment.type == "image"){
			$(".escrot-preview-chat-attach").html("<img width='30' src='"+attachment.url+"'/> "+attachment.url.split('/').pop()+"<button id='escrot-reset-attachment' type='button' class='text-danger'>X</button>");
		} else {
			$(".escrot-preview-chat-attach").html("<img width='30' src='"+$(location).attr('origin')+"/wp-content/plugins/escrowtics/assets/img/file-icon.png'/> "+attachment.url.split('/').pop()+"<button id='escrot-reset-attachment' type='button' class='text-danger'>X</button>");
		}
		$(".escrot-preview-chat-attach").css({"border": "1px solid", "padding": "10px", "border-radius": "15px", "margin-top": "10px"});
	});

	file_frame.open();
});


$(document).on('click', '#escrot-reset-attachment', function (e) {
   $(".escrot-chat-attachment").val('');
   $(".escrot-preview-chat-attach").html('');
   $(".escrot-preview-chat-attach").css({"border": "none", "padding": "0", "border-radius": "none", "margin-top": "0"});
});




});


