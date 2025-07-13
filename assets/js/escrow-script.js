
jQuery(document).ready(function($){

   //Toggle Escrow Screen options
	var screen_options = [ "escrot_so_payer", "escrot_so_earner", "escrot_so_created", "escrot_so_ref"];
	
	for(i=0;i<screen_options.length;i++){ 
		$("body").bind("click", {so: screen_options[i]}, function(e) {
			if ($("#"+e.data.so+"")[0].checked == true){
				$("."+e.data.so+"").show();
			} else {
				$("."+e.data.so+"").hide();
			}
		});
	}
	
	
	// Table Columns
	const defaultDTColumns = [
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
		{ data: 2, className: 'escrot_so_ref' },
		{ data: 3, className: 'escrot_so_payer' },
		{ data: 4, className: 'escrot_so_earner' },
		{ data: 5, className: 'escrot_so_created' },
		{
			data: 6, // Action column
			orderable: false,
			className: 'dt-center',
			render: function (data, type, row) {
				return row[6].actions;
			},
		},
	];
		
	//Function - DataTable Setup & Initialization
	function setDataTable(extraData = []){
		// dataTables
		var tbls = [ "escrot-escrow-table", "escrot-escrow-meta-table", "escrot-data-table", "escrot-earning-table", "escrot-log-table"];
		
		// Initialize tables
		for(i=0; i<tbls.length; i++){ 
		    var ajax_action = $('#'+tbls[i]+'').data('ajax-action');
			var orderCol =  $('#'+tbls[i]+'').data('order-col');
			var frontHiddenCol = $('#'+tbls[i]+'').data('front-hidden-col');
			EscrotInitDataTable(
				'#'+tbls[i]+'',
				ajax_action, // Action name for server-side data
				orderCol,
				defaultDTColumns,
				frontHiddenCol,
				!escrot.is_front_user,
				extraData
			);
		} 
		//table options buttons
        EscrotSetDataTableOptionsBtn();		
	}
	
	
	//Function - Invoice DataTable Setup & Initialization
	function setInvoiceDataTable(extraData = []){
		
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
			{
				data: 3, 
				orderable: false,
				render: function (data, type, row) {
					return row[3].username;
				},
			}, 
			{ data: 4 },
			{ data: 5 }, 
			{ data: 6 }, 
			{ data: 7 }, 
			{
				data: 8, // Action column
				orderable: false,
				className: 'dt-center',
				render: function (data, type, row) {
					return row[8].actions;
				},
			},
		];
		
		// Initialize invoice table
		EscrotInitDataTable('#escrot-invoice-table', 'escrot_invoice_datatable', 7, Columns, [0, 3, 4], !escrot.is_front_user, extraData);
		
		//EscrotInitDataTable("#" + tableId, ajax_action, orderCol, defaultDTColumns, frontHiddenCol, !fnehd.is_front_user, extraData);
			
		// table options buttons
        EscrotSetDataTableOptionsBtn();		
	}
	
	
	//Get URL Token value for GET Response 
	var urlParams = new URLSearchParams(window.location.search); 
	
	
	let escrowID = $('#escrot-escrow-meta-table').data('escrow-id');
	
	//Load frontend datatables
	if(escrot.is_front_user){ 
	    //get & send invoice data to frontend users
		var escrowUrl = $('#escrot-escrow-table').data('escrow-url');
		var earnUrl = $('#escrot-earning-table').data('earn-url');
	    var invoiceType = $('#escrot-invoice-table').data('invoice-type');
		var invoiceUrls = $('#escrot-invoice-table').data('invoice-url'); 
	
	    
		//Initialize frontend DataTables
		setDataTable([{escrow_url: escrowUrl, earn_url: earnUrl, escrow_id: escrowID}]); 
		setInvoiceDataTable([{invoice: invoiceType, invoice_url: invoiceUrls}]);
		EscrotInitMaterialWizard(); 
		setTimeout(function() {$('.card.card-wizard').addClass('active');}, 600); 
	}
	
	
	
	if(urlParams.get('page') == "escrowtics-view-escrow"){ setDataTable([{escrow_id: escrowID}]); }

	//Display Dashboard Escrows
	if(urlParams.get('page') == "escrowtics-dashboard"){ fetchRecentEscrows(); }
	function fetchRecentEscrows(){
		var data = {'action':'escrot_dash_escrows',};
		$.post(escrot.ajaxurl, data, function(response) {
			 $("#tableDataDB").html(response);
			 EscrotInitMaterialWizard();
			 setTimeout(function() {$('.card.card-wizard').addClass('active');}, 600); 
		});
	}
	
		   
	//Display Escrows	
	if(urlParams.get('page') == "escrowtics-escrows"){ fetchAllEscrows(); }
	function fetchAllEscrows(){ 
		var data = {'action':'escrot_escrows',};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-admin-container").html(response);
		  setDataTable();
		  EscrotInitMaterialWizard();
		  setTimeout(function() {$('.card.card-wizard').addClass('active');}, 600); 
		});
	} 
	
	
	//Display Deposit invoices	
	if(urlParams.get('page') == "escrowtics-deposits"){ displayDeposits(); }
	function displayDeposits(){ 
		var data = {'action':'escrot_deposits',};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-admin-container").html(response);
			setInvoiceDataTable([{invoice: 'deposit'}]);
		});
	}
	//Reload Deposits
	function reloadDeposits(){ 
		var data = {'action':'escrot_reload_deposits',};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-deposits-table-wrapper").html(response);
			setInvoiceDataTable([{invoice: 'deposit'}]);
		});
	}
	
	
	//Display Withdrawal invoices	
	if(urlParams.get('page') == "escrowtics-withdrawals"){ displayWithdrawals(); }
	function displayWithdrawals(){ 
		var data = {'action':'escrot_withdrawals',};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-admin-container").html(response);
			setInvoiceDataTable([{invoice: 'withdrawal'}]);
		});
	}
	//Reload Withdrawals
	function reloadWithdrawals(){ 
		var data = {'action':'escrot_reload_withdrawals',};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-withdrawals-table-wrapper").html(response);
			setInvoiceDataTable([{invoice: 'withdrawal'}]);
		});
	}
	
	
	//Display Log	
	if(urlParams.get('page') == "escrowtics-transaction-log"){ loadTransactionLogs(); }
	function loadTransactionLogs(){ 
		var data = {
			'action':'escrot_transaction_log',
		};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-admin-container").html(response);
		  setDataTable();
		});
	}


	//Reload Escrows (escrows table)	   
	function reloadEscrows(){
		var escrow_url= $('#escrot-escrow-table').data('escrow-url'); 
		var data = {'action':'escrot_reload_escrow_tbl', 'escrow_url':escrow_url};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-escrow-table-wrapper").html(response);
			setDataTable();
			EscrotInitMaterialWizard();
		});
	} 
	
	//Reload Escrows Meta	   
	function reloadEscrowMeta(){
		var escrowID = $('#escrot-escrow-meta-table').data('escrow-id'); 
		var data = {'action':'escrot_reload_escrow_meta_tbl', 'escrow_id':escrowID,};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-view-escrow-table-wrapper").html(response);
			setDataTable([{escrow_id: escrowID}]);
		});
	}
	
	//Reload Escrows Meta after Adding Milestone	   
	function reloadEscrowMetMilestone(escrowID){
		var data = {'action':'escrot_reload_escrow_meta_tbl', 'escrow_id':escrowID,};
		$.post(escrot.ajaxurl, data, function(response) {
			$("#escrot-view-escrow-table-wrapper").html(response);
			setDataTable([{escrow_id: escrowID}]);
		});
	}
	
	//Reload User Escrows
	function reloadUserEscrows(){
		var userID = urlParams.get('user_id');
		var data = {'action':'escrot_reload_user_escrow_tbl', 'user_id':userID,};
		$.post(escrot.ajaxurl, data, function(response) {
			$(".escrot-user-escrow-tbl").html(response.data);
			setDataTable([{user_id: userID}]);
		});
	} 


	//Reload User Earnings
	function reloadUserEarnings(){
		var userID = urlParams.get('user_id');
		var data = {'action':'escrot_reload_user_earnings_tbl', 'user_id':userID,};
		$.post(escrot.ajaxurl, data, function(response) {
			$(".escrot-user-escrow-tbl").html(response.data);
			setDataTable([{user_id: userID}]);
		});
	} 
	
	
	//Load User Escrow Table
	$("body").on("click", "#escrot-user-escrows-btn", function(e){ 
		$(".escrot-user-escrow-tbl-title").show();
		$(".escrot-user-earnings-tbl-title").hide();
		$(".escrot-user-profile-title").hide();
		reloadUserEscrows();
	});
	//Load User Earnings Table
	$("body").on("click", "#escrot-user-earnings-btn", function(e){  
	    $(".escrot-user-earnings-tbl-title").show();
		$(".escrot-user-escrow-tbl-title").hide();
		$(".escrot-user-profile-title").hide();
		reloadUserEarnings();
	});
	
	//Reload Escrow Table
	$("body").on("click", "#reloadTable", function(e){  
		reloadEscrows();
		Swal.fire({
			icon: 'success', 
			title: escrot.swal.escrow.table_reload_success,
			showConfirmButton: false, 
			timer: 1500, 
		});
	});  
		
	   
	//Check if User Exist
	var UserAvailable = true;
	$('body').on('change', '#EscrotEscrowUser', function () {
	  var TCode = $(this).val().trim();
	  if (User == '') {
		  UserAvailable = false;
		  return;
	  }
	  if (User != '') {
		var data = {
			'action':'escrot_verify_user',
			'User':User,
		};
		$.post(escrot.ajaxurl, data, function(response) {
		   if (response == 1 ) {
			  UserAvailable  = true;
			  $('#EscrotEscrowUser_notice').html('');
			}
			else if (response == "not_taken") {
			  UserAvailable  = false;
			  $('#EscrotEscrowUser_notice').html('<span class="text-danger"><b>'+User+'</b> '+escrot.swal.escrow.user_not_found+'</span>');
			  
			}
		});
	  } else {
		$("#EscrotEscrowUser_notice").html("");
	  }
	  
	});

	
	//Release escrow payment
	$("body").on("click", ".escrot-release-pay", function(e){
		e.preventDefault();
		var MetaID = $(this).attr('id');
			  swal.fire({
			  title: escrot.swal.warning.title,
				text: escrot.swal.warning.text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: escrot.swal.escrow.release_confirm,
			}).then((result) => {
			  if (result.value){
				var data = {'action':'escrot_release_payment', 'meta_id':MetaID};
				$.post(escrot.ajaxurl, data, function(response) {
		  
					if(response.success){
						Swal.fire({
						   icon: 'success',
						   title: response.data.message,
						   showConfirmButton: false, 
						   timer: 1500,
						});
						reloadEscrowMeta();
					} else {
						Swal.fire({
						   icon: 'error',
						   title: response.data.message,
						   showConfirmButton: false, 
						   timer: 1500,
						});
					}	   
		  
				});//ajax
			}
		});//then
	});
	
	
	//Reject Amount
	$("body").on("click", ".escrot-reject-amount", function(e){
		e.preventDefault();
		var MetaID = $(this).attr('id');
			  swal.fire({
			  title: escrot.swal.warning.title,
				text: escrot.swal.warning.text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: escrot.swal.escrow.reject_confirm,
			}).then((result) => {
			  if (result.value){
				var data = {'action':'escrot_reject_amount', 'meta_id':MetaID};
				$.post(escrot.ajaxurl, data, function(response) {
		  
					if(response.success){
						Swal.fire({
						   icon: 'success',
						   title: response.data.message,
						   showConfirmButton: false, 
						   timer: 1500,
						});
						reloadEscrowMeta();
					}	else {
						Swal.fire({
						   icon: 'error',
						   title: response.data.message,
						   showConfirmButton: false, 
						   timer: 1500,
						});
					}	   
		  
				});//ajax
			}
		});//then
	});
	
	
	//Move to top of dashboard add escrow form.
	$("body").on("click", "#addEscrowDash", function(e){
		$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
	})
	
	
	//Check if Escrow users are different.
	$("body").on("click", ".escrot-form-next-btn", function(e){
		var earner = $('#EscrotEscrowEarner').val();
		var payer = $('#EscrotEscrowPayer').val();
		if(earner == payer){
			e.preventDefault();
			Swal.fire({
			   icon: 'error',
			   title: escrot.checkUsersMessage,
			   showConfirmButton: true,
			});
		}
	})
	

	
	//Add escrow
	$("body").on("submit", "#AddEscrowForm", function(e){
		e.preventDefault();
		if (UserAvailable == false) {
		   $('.add_error_mge').html(
					'<p style="color: white; text-align: center;" class="alert alert-danger">' +escrot.swal.escrow.form_error+'</p>'
				);
		} else{
			swal.fire({
				title: escrot.swal.warning.title,
				text: escrot.swal.warning.text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: escrot.swal.escrow.add_escrow_confirm,
			}).then((result) => {
			  if (result.value){
			
				var form_data = $(this).serialize(); 
				
				var view_escrow_url = 'admin.php?page=escrowtics-view-escrow';
                if(escrot.is_front_user){				
				  var view_escrow_url = $('#escrot-front-user-noty').data('escrot-escrow-url');
				}
				
				$.post(escrot.ajaxurl, form_data, function(response) { 
					if(response.success){
					Swal.fire({
					   icon: 'success',
					   title: response.data.message,
					   html: response.data.fees+
							'<br><br><a class="btn btn-outline-info" href="'+view_escrow_url+'&escrow_id='+response.data.escrow_id+'">'+response.data.redirect_text+'</a>',
					   showConfirmButton: true,
					});
					$("#escrot-add-escrow-modal").modal('hide');
					$("#AddEscrowForm")[0].reset();
					$("#escrot-add-escrow-form-dialog").collapse('hide');
					if(urlParams.get('page') == "escrowtics-dashboard"){
						fetchRecentEscrows();
					} else { 
						reloadEscrows(); 
					}
					$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
				  } else{
					Swal.fire({
					   icon: 'error',
					   title: response.data.message,
					   showConfirmButton: true,
					});
				  }    
	  
				});//ajax
			  }
			});//then  
		} 
	});
	
	
	//Add Escrow Milestone
	$("body").on("submit", "#escrot-milestone-form", function(e){
		e.preventDefault();
		swal.fire({
			title: escrot.swal.warning.title,
			text: escrot.swal.warning.text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: escrot.swal.escrow.add_milestone_confirm,
		}).then((result) => {
		  if (result.value){
		
			var form_data = $(this).serialize();   
			$.post(escrot.ajaxurl, form_data, function(response) { 
				if(response.success){
					Swal.fire({
					   icon: 'success',
					   title: response.data.message,
					   html: response.data.fees,
					   showConfirmButton: true,
					});
					$("#escrot-milestone-form-modal").modal('hide');
					$("#escrot-milestone-form")[0].reset();
					$("#escrot-milestone-form-dialog").collapse('hide');
					reloadEscrowMetMilestone(response.data.escrow_id);
					
					$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
					
			  } else{
				Swal.fire({
				   icon: 'error',
				   title: response.data.message,
				   showConfirmButton: false, 
				   timer: 1500,
				});
			  }    
  
			});//ajax
		  }
		});//then  
		
	});
	
	
	//View Escrow Milestone Details
	$("body").on("click", ".escrot-view-milestone-detail", function(e){
		e.preventDefault();
		var meta_id = $(this).attr('id');
			 
		var data = {'action':'escrot_view_milestone_detail', 'meta_id':meta_id};
		$.post(escrot.ajaxurl, data, function(response) {
			
			if(escrot.interaction_mode == 'modal'){
			   $('#escrot-view-milestone-modal-body').html(response.data);  
			   $('#escrot-view-milestone-modal').modal("show");
			}else {
			   $('#escrot-milestone-details').html(response.data); 
			   $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');				   
			}
		});
	});
	
	
    // Define an array of page-function mappings
	const pageFunctionMap = [
		{ page: 'escrowtics-dashboard', fn: fetchRecentEscrows       },
		{ page: 'escrowtics-user-profile', fn: reloadUserEscrows      },
		{ page: 'escrowtics-escrows',  fn: reloadEscrows              },
		{ page: 'escrowtics-view-escrow',  fn: reloadEscrowMeta       },
		{ page: 'escrowtics-transaction-log', fn: loadTransactionLogs },
		{ page: 'escrowtics-deposits', fn: reloadDeposits             },
		{ page: 'escrowtics-withdrawals', fn: reloadWithdrawals       },
	];
	
	// Function to execute based on the current page
	function escrotExecutePageFunction() {
		const urlParams = new URLSearchParams(window.location.search);
		const currentPage = urlParams.get('page');

		// Loop through the array and check for a matching page
		pageFunctionMap.forEach((mapping) => {
			if (currentPage === mapping.page) {
				mapping.fn(); // Call the associated function
			}
		});
	}


	//Delete Single data
	$("body").on("click", ".escrot-delete-btn", function(e){
		 e.preventDefault();
			 var tr = $(this).closest('tr');
			 var delID = $(this).attr('id');
			 var action = $(this).data('action');
			 
			swal.fire({
				title: escrot.swal.warning.title,
				text: escrot.swal.warning.text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: escrot.swal.escrow.delete_confirm,
			}).then((result) => {
				if (result.value){
			  
				var data = {
						'action':action,
						'delID':delID,
					};
					$.post(escrot.ajaxurl, data, function(response) {
						tr.css('background-color','#ff6565');
						Swal.fire({
						   icon: 'success',
						   title: response.label+' '+escrot.swal.success.delete_success,
						   showConfirmButton: false, 
						   timer: 1500,
						});
						escrotExecutePageFunction();
				});
				   
			}
		})
	});


	/**
	 * Handle batch actions for selected rows.
	 *
	 * @param {string} checkboxClass - The class of checkboxes for selecting rows.
	 * @param {string} action - The action to perform (passed to the AJAX request).
	 * @param {function} callback - A callback function to handle additional logic after a successful action.
	 */
	function escrotHandleBatchAction(checkboxClass, action, callback) {
		const selectedRows = [];

		$(`${checkboxClass}:checked`).each(function () {
			selectedRows.push($(this).data('escrot-row-id'));
		});
		if (selectedRows.length <= 0) {
			Swal.fire({
				icon: 'warning',
				title: escrot.swal.warning.no_records_title,
				text: escrot.swal.warning.no_records_text,
			});
		} else {
			Swal.fire({
				title: escrot.swal.warning.title,
				text: escrot.swal.warning.text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: `${selectedRows.length > 1 ? escrot.swal.warning.delete_records_confirm : escrot.swal.warning.delete_record_confirm}`,
			}).then((result) => {
				if (result.value) {
					const selectedValues = selectedRows.join(',');

					const data = {
						action,
						multID: selectedValues,
					};
					$.post(escrot.ajaxurl, data, function (response) {
						// Highlight deleted rows
						selectedRows.forEach((id) => {
							$(`#${id}`).css('background-color', '#ff6565');
						});
						Swal.fire({
							icon: 'success',
							title: `${selectedRows.length > 1 ? response.label + 's' : response.label} `+escrot.swal.success.delete_success,
							text: `${selectedRows.length} ${selectedRows.length > 1 ? response.label + 's' : response.label} Deleted!`,
							showConfirmButton: false,
							timer: 1500,
						});
						// Execute the callback function if provided
						if (typeof callback === 'function') {
							callback(selectedRows, response);
						}
						$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
					});
				}
			});
		}
	}
	
	
	// mult delete escrow, escrow meta & logs
	$(document).on('click', '.escrot-mult-delete-btn', function () {
		const action = $(this).data('action');
		escrotHandleBatchAction('.escrot-checkbox', action, function (selectedRows, response) {
			escrotExecutePageFunction();
		});
	});
	//mult delete user earnings
	$(document).on('click', '.escrot-earnings-mult-delete-btn', function () {
		const action = $(this).data('action');
		escrotHandleBatchAction('.escrot-checkbox', action, function (selectedRows, response) {
			reloadUserEarnings();
		});
	});
	// mult delete escrow search data
	$(document).on('click', '.escrot-search-mult-delete-btn', function () {
		const action = $(this).data('action');
		escrotHandleBatchAction('.escrot-checkbox2', action, function (selectedRows, response) {
			reloadSearchResults();
		});
	});

	
	//Set Invoice Code
	$("body").on("click", ".escrot-update-invoice-btn", function(e){
		e.preventDefault();
		var code = $(this).attr('id');
		$('#escrot-status-update-code').val(code); 
	});
	
	
	//Update Invoice Status
	$("body").on("submit", "#escrot-invoice-status-form", function(e){
		e.preventDefault();
		swal.fire({
			title: escrot.swal.warning.title,
			text: escrot.swal.warning.text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: escrot.swal.escrow.invoice_status_confirm,
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
					$("#escrot-invoice-status-modal").modal('hide');
					$("#escrot-invoice-status-form")[0].reset();
					$("#escrot-invoice-status-dialog").collapse('hide');
					if(urlParams.get('page') == "escrowtics-deposits"){ reloadDeposits();}
					if(urlParams.get('page') == "escrowtics-withdrawals"){ reloadWithdrawals(); }
					$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
				}   
			});//ajax
		  }
		});//then  
		
	});
	
	
	//View Deposit Invoice
	$("body").on("click", ".escrot-view-invoice-btn", function(e){
		e.preventDefault();
		var code = $(this).attr('id');
		var ajaxAction = $(this).data('view-invoice-ajax-action');	 
		var data = {'action':ajaxAction, 'invoice_code':code};
		$.post(escrot.ajaxurl, data, function(response) {
			if(escrot.interaction_mode == 'modal'){
			   $('#escrot-view-invoice-modal-body').html(response.data);  
			   $('#escrot-view-invoice-modal').modal("show");
			}else {
			   $('#escrot-invoice-wrapper').html(response.data); 
			   $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');				   
			}
		});
	});
	
	
	
	
	/*******************************    Escrow Search   ***********************************/
	
	
	//Escrow Initialize Search DataTable
	function setSearchDataTable(extraData=[]){
		EscrotInitDataTable('#escrot-escrow-search-table', 'escrot_escrow_search_datatable', 5, defaultDTColumns, 0, !escrot.is_front_user, extraData);
        EscrotSetDataTableOptionsBtn();
	}
	
	//Animate Escrow Search Input
	$("body").on('focus', '#escrot-escrow-search-input', function(e){
		if($("#escrot-escrow-search-input").val() == ""){ $("#escrot-escrow-search-input").animate({width: '+=100px'}, 1000); }
	});
	$("body").on('blur', '#escrot-escrow-search-input', function(e){
		if($("#escrot-escrow-search-input").val() == ""){ $("#escrot-escrow-search-input").animate({width: '-=100px'}, 1000); }
	});
	
	
	// Display Escrow Search Results
	$("body").on('submit', '#escrot-escrow-search-form', function (e) {
		e.preventDefault();

		// Retrieve the search text
		let search_text = $("#escrot-escrow-search-input").val();

		// Serialize the form data
		var form_data = $(this).serialize();

		// Post the data
		$.post(escrot.ajaxurl, form_data, function (response) {
			if (escrot.interaction_mode == 'modal') {
				$('#escrot-escrow-search-results-modal-body').html(response); //modal  
				$('#escrot-escrow-search-modal').modal("show");
			} else {
				$('#escrot-escrow-search-results-dialog-wrap').html(response);
				$("#escrot-search-results-dialog").collapse('show');
				$('#escrot-search-results-dialog').animate({
					scrollTop: $('#escrot-search-results-dialog')[0].scrollHeight
				}, "1000");
			}
			// Initialize DataTable
			setSearchDataTable([{search: search_text}]);
		});
	});

	
	
	//Reload Escrow Search Results (escrows table)	   
	function reloadSearchResults(){
		var search_text = $("#escrot-escrow-search-input").val();
		var data = {'action':'escrot_reload_escrow_search', 'search_text':search_text };
		$.post(escrot.ajaxurl, data, function(response) {
			if(escrot.interaction_mode == 'modal'){
			  $('#escrot-escrow-search-results-modal-body').html(response); //modal
			}else {
			  $('#escrot-escrow-search-results-dialog-wrap').html(response); 
			}
			setSearchDataTable([{search: search_text}]);
		});
	}
	
	
	//Delete Search Escrow
	$("body").on("click", ".escrot-escrow-search-del-btn", function(e){
			
		 e.preventDefault();
			 var tr = $(this).closest('tr');
			 var delID = $(this).attr('id');
	 
			swal.fire({
				title: escrot.swal.warning.title,
				text: escrot.swal.warning.text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: escrot.swal.escrow.delete_confirm,
			}).then((result) => {
				if (result.value){
			  
				var data = {'action':'escrot_del_escrow', 'delID':delID,};
					$.post(escrot.ajaxurl, data, function(response) {
						tr.css('background-color','#ff6565');
						Swal.fire({
						   icon: 'success',
						   title: response.label+escrot.swal.success.delete_success,
						   showConfirmButton: false, 
						   timer: 1500,
						});
						reloadSearchResults();
				});
				   
			}
	 
		})
	 
	});


});