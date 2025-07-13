
jQuery(document).ready(function($){
	
	
	//Function - Users DataTable Setup & Initialization
	function setDataTable(extraData = []){
		
		const Columns = [
			{
				data: 0, // Checkbox column
				orderable: false,
				render: function (data, type, row) {
					return row[0].check_box;
				},
			},
			{
				data: null, // Continuous row index
				orderable: false,
				render: function (data, type, row, meta) {
					return meta.row + 1 + meta.settings._iDisplayStart;
				},
			},
			{ data: 2 },
			{ data: 3 }, 
			{ data: 4 },
			{ data: 5 }, 
			{ data: 6 }, 
			{ data: 7 }, 
			{ data: 8, orderable: false, className: 'dt-center' },
		];
		
		// Initialize tables
		EscrotInitDataTable('#escrot-dispute-table','escrot_dispute_datatable', 7, Columns, 0, !escrot.is_front_user, extraData);
		
		//table options buttons
        EscrotSetDataTableOptionsBtn();	
	
	}
	 
	 
	//Get URL Token value for dispute_id (GET Response) 
	var urlParams = new URLSearchParams(window.location.search); 
	 

	//Display Disputes Table
	getAllDisputes();
	function getAllDisputes(){
		var data = {'action':'escrot_disputes',};
		var disputeUrl = $('#escrot-dispute-table').data('dispute-url');
		$.post(escrot.ajaxurl, data, function(response) {
			if(response.success){
				$("#escrot-admin-container").html(response.data.data);
				setDataTable([{dispute_url: disputeUrl}]);
			}
		});
	}


	//Reload Disputes Table
	function reloadDisputes(){
		var dispute_url= $('#escrot-dispute-table').data('dispute-url'); 
		var data = {'action':'escrot_disputes_tbl', 'dispute_url':dispute_url}; 
		$.post(escrot.ajaxurl, data, function(response) {
			if(response.success){
				$("#escrot-dispute-table-wrapper").html(response.data.data);
				setDataTable();
			}
		});
	}



	//Add Dispute 
	$("body").on('click', '.escrot-add-dispute-btn', function(e){
		e.preventDefault();
		var escrow_ref = $(this).attr('id');
		$("#EscrotDisputeEscrowRefID").val(escrow_ref);
		$('#EscrotDisputeEscrowRefID').prop('readonly', true);
		$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-admin-forms').offset().top}, 'slow'); 
	});		
	$("body").on('submit', '#escrot-add-dispute-form', function(e){
		e.preventDefault();
		swal.fire({
			title:escrot.swal.dispute.add_dispute_title,
			text: escrot.swal.dispute.add_dispute_text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, add Dispute!',
		}).then((result) => {
			if (result.value){
				$.ajax({
					url: escrot.ajaxurl,
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(response) {
						if(response.success){
							Swal.fire({
								icon: 'success',
								title: response.data.message,
								showConfirmButton: false, 
								timer: 1500,
							});
						   $("#escrot-add-dispute-modal").modal('hide');
						   $("#escrot-add-dispute-form-dialog").collapse('hide');
						   $("#escrot-add-dispute-form")[0].reset();
						   reloadDisputes();
						   $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
						} else {
							Swal.fire({
								icon: 'error',
								title: response.data.message,
								showConfirmButton: true,
							});
						}
					}	
				});
			}
		});//then
	});


	//Edit Dispute Record (pull existing data into form)
	$("body").on("click", ".escrot-dispute-edit-btn", function(e){
		
		e.preventDefault();
		var DisputeId = $(this).attr('id');
		var data = {
			'action':'escrot_dispute_data',
			'DisputeId':DisputeId,
		};
		
		$.post(escrot.ajaxurl, data, function(response) {
			if(response.success){
				$("#EditEscrotDisputeID").val(response.data.dispute_id);
				$("#EditEscrotDisputeRefID").val(response.data.ref_id);
				$("#EditEscrotDisputeLastName").val(response.data.lastname);
				$("#EditEscrotDisputeUserID").val(response.data.user_id);
				$("#EditEscrotDisputeDepartment").val(response.data.department);
				$("#EditEscrotDisputeSubject").val(response.data.subject);
				$("#EditEscrotDisputeStatus").val(response.data.status);
				$("#EditEscrotDisputePriority").val(response.data.priority);
			} 
	  });
	  $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-admin-forms').offset().top}, 'slow'); 
	  
	});



	//update Dispute Status
	$("body").on('click', '.escrot-update-dispute-status', function(e){
		e.preventDefault();
		var dispute_id = $(this).attr('id');
		$("#escrot-dispute-id-input").val(dispute_id);
		$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-admin-forms').offset().top}, 'slow'); 
	});
	$("body").on("change", '#escrot-dispute-status-select', function () {
		const selectedValue = $(this).val();
		if (selectedValue === '1') {
			$('#escrot-dispute-priority-select').prop('disabled', true);
		} else {
			$('#escrot-dispute-priority-select').prop('disabled', false);
		}
	});		
	$("body").on('submit', '#escrot-dispute-status-form', function(e){
		e.preventDefault();
		swal.fire({
			title: escrot.swal.warning.title,
			text: escrot.swal.warning.text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, update status!',
		}).then((result) => {
		   if (result.value){
				var form_data = $(this).serialize();
				$.post(escrot.ajaxurl, form_data, function(response) { 
					if(response.success){ 
						Swal.fire({
						   icon: 'success',
						   title: response.data.message,
						   showConfirmButton: false, 
						   timer: 1500,
						});
						$("#escrot-dispute-status-modal").modal('hide');
						$("#escrot-dispute-status-dialog").collapse('hide');
						$("#escrot-dispute-status-form")[0].reset();
						if(urlParams.get('dispute_id') !== null){
							  location.reload();
						} else { 
							reloadDisputes();
						}
					}   
			   }).fail(function (jqXHR, textStatus, errorThrown) {
					// Handle AJAX failure
					Swal.fire({
						icon: "error",
						title: "Request Failed",
						text: `Error: ${textStatus}. ${errorThrown}`,
					});
				});
			}
		});//then
	});


	//Reply Dispute admin
	$("body").on('submit', '#escrot-dispute-reply-form', function(e){
		e.preventDefault();
		var form_data = $(this).serialize();
		$.post(escrot.ajaxurl, form_data, function(response) { 
			if(response.success){
			   $('#escrot-chat-message').animate("background-color", "green"); 
			   $('#escrot-dispute-chat-wrapper').html(response.data.data); 
			   $("#escrot-dispute-reply-form")[0].reset();
			   $('#escrot-dispute-chat-wrapper').animate({scrollTop: $('#escrot-dispute-chat-wrapper')[0].scrollHeight}, "1000");
			   $(".escrot-preview-chat-attach").html("");
			   $(".escrot-preview-chat-attach").css({"border": "none", "padding": "0", "border-radius": "0", "margin-top": "0"});
			   $(".escrot-chat-attachment").val("");
			}   
		});

	});

	//Reply Dispute frontend
	$("body").on('submit', '#escrot-user-dispute-reply-form', function(e){
		e.preventDefault();
		$.ajax({
			url: escrot.ajaxurl,
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(response) { 
				if(response.success){
					$('#escrot-chat-message').animate("background-color", "green"); 
					$('#escrot-dispute-chat-wrapper').html(response.data.data); 
					$("#escrot-user-dispute-reply-form")[0].reset();
					$('#escrot-dispute-chat-wrapper').animate({scrollTop: $('#escrot-dispute-chat-wrapper')[0].scrollHeight}, "1000");
				} else{
					Swal.fire({
					   icon: 'error',
					   text: response.data.message,
					   showConfirmButton: true,
					});
				}
			}	
	   });
	});

	//Delete Dispute Record
	$("body").on("click", ".escrot-delete-dispute-btn", function(e){
		 e.preventDefault();
			 var tr = $(this).closest('tr');
			 var DisputeID = $(this).attr('id');
			 
			swal.fire({
				title: escrot.swal.warning.title,
				text: "You won't be able to revert this! All chats linked to this Dispute will also be deleted. Still want to continue?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Yes, delete Dispute!',
			}).then((result) => {
			  if (result.value){
			  
					var data = {
						'action':'escrot_del_dispute',
						'DisputeID':DisputeID,
					};
		
					$.post(escrot.ajaxurl, data, function(response) {
						
						tr.css('background-color','#ff6565');
						Swal.fire({
						   icon: 'success',
						   title: 'Dispute Deleted Successfully',
						   showConfirmButton: false, 
						   timer: 1500,
						});
						reloadDisputes();
						
					});
			}
	 
		})
	 
	});



	//Delete Multiple Disputes
	$(document).on('click', '.escrot-dispute-mult-delete-btn', function(e) {
		var Disputes = [];
		$(".escrot-checkbox:checked").each(function() {
			Disputes.push($(this).data('escrot-row-id'));
		});
		if(Disputes.length <= 0) {
			 Swal.fire({
					 icon: 'warning',
					 title: escrot.swal.warning.no_records_title,
					 text: "Please select atleast 1 Dispute to continue!",
				   });
		} 
		else { 
			
			swal.fire({
				title: escrot.swal.warning.title,
				text: "You won't be able to revert this! All chats linked to these Disputes will also be deleted. Still want to continue?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Yes, delete '+(Disputes.length>1?'Disputes':'Dispute')+'!',
			}).then((result) => {
			  if (result.value){	
				
				var selected_values = Disputes.join(",");
				
				var data = {
					'action':'escrot_del_disputes',
					'multDisputeid':selected_values,
				};
		
				$.post(escrot.ajaxurl, data, function(response) {
					var multDisputeids = selected_values.split(",");
	  
					for (var i=0; i < multDisputeids.length; i++ ) {	
						$("#"+multDisputeids[i]).css('background-color','#ff6565'); 
					}
					Swal.fire({
						icon: 'success',
						title: ''+(Disputes.length>1?'Disputes':'Dispute')+' deleted successfully',
						text: ''+(Disputes.length)+' '+(Disputes.length>1?'Records':'Record')+' Deleted!',
						showConfirmButton: false, 
						timer: 1500,
					});
					reloadDisputes();
						
				});
				
			} 
		}) //swal.fire end
		}
	});	

		
	//Chat File Uploader
	$(document).on('click', '.escrot-chat-attachment', function (e) {
		e.preventDefault();
		var $button = $(this);

		var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an File',
			library: {
			type: 'image, application/pdf' // mime type
			},
			button: {
				text: 'Select File'
			},
			multiple: false
		});
		file_frame.on('select', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$(".escrot-chat-attachment").val(attachment.url);
			if(attachment.type == "image"){
				$(".escrot-preview-chat-attach").html("<img width='50' src='"+attachment.url+"'/> "+attachment.url.split('/').pop()+"<button id='escrot-reset-attachment' type='button' class='close text-danger float-right'>X</button>");
			} else {
				$(".escrot-preview-chat-attach").html("<img width='50' src='"+escrot.home_url+"/wp-content/plugins/escrowtics/assets/img/file-icon.png'/> "+attachment.url.split('/').pop()+"<button id='escrot-reset-attachment' type='button' class='close text-danger float-right'>X</button>");
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


