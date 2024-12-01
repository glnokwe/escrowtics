
	jQuery(document).ready(function($){

       //Toggle Escrow Screen options
        var screen_options = [ "escrot_so_payer", "escrot_so_earner", "escrot_so_created"];
		
		for(i=0;i<screen_options.length;i++){ 
		    $("body").bind("click", {so: screen_options[i]}, function(e) {
                if ($("#"+e.data.so+"")[0].checked == true){
                    $("."+e.data.so+"").show();
                } else {
                    $("."+e.data.so+"").hide();
                }
            });
        }
		
		
		function setDataTable(){
			
			/* dataTable options */
			
			var tbl_ids = [ "escrot-escrow-table", "escrot-escrow-meta-table", "escrot-data-table", "escrot-earning-table", "escrot-log-table", "escrot-invoices-table"];
			
			
			for(i=0;i<tbl_ids.length;i++){ 
				if(escrot.is_front_user == 'true' || tbl_ids[i] == "escrot-log-table" || tbl_ids[i] == "escrot-invoices-table"){ 
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
		
		
		
		function initMaterialWizard() {

			// Wizard Initialization
			$('.card-wizard').bootstrapWizard({
			  'tabClass': 'nav nav-pills',
			  'nextSelector': '.btn-next',
			  'previousSelector': '.btn-previous',

			   onInit: function(tab, navigation, index) {
				//check number of tabs and fill the entire row
				var $total = navigation.find('li').length;
				var $wizard = navigation.closest('.card-wizard');

				$first_li = navigation.find('li:first-child a').html();
				$moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
				$('.card-wizard .wizard-navigation').append($moving_div);

				refreshAnimation($wizard, index);

				$('.moving-tab').css('transition', 'transform 0s');
			  },

			onTabClick: function(tab, navigation, index) {
			  var $valid = $('.card-wizard form').valid();

			  if (!$valid) {
				return false;
			} else {
				return true;
			  }
			},

			onTabShow: function(tab, navigation, index) {
				var $total = navigation.find('li').length;
				var $current = index + 1;

				var $wizard = navigation.closest('.card-wizard');

				// If it's the last tab then hide the last button and show the finish instead
				if ($current >= $total) {
				  $($wizard).find('.btn-next').hide();
				  $($wizard).find('.btn-finish').show();
				} else {
				  $($wizard).find('.btn-next').show();
				  $($wizard).find('.btn-finish').hide();
				}

				button_text = navigation.find('li:nth-child(' + $current + ') a').html();

				setTimeout(function() {
				  $('.moving-tab').text(button_text);
				}, 150);

				var checkbox = $('.footer-checkbox');

				if (!index == 0) {
				  $(checkbox).css({
					'opacity': '0',
					'visibility': 'hidden',
					'position': 'absolute'
				  });
				} else {
				  $(checkbox).css({
					'opacity': '1',
					'visibility': 'visible'
				  });
				}

				refreshAnimation($wizard, index);
			  }
			});
		
			$(window).resize(function() {
			  $('.card-wizard').each(function() {
				$wizard = $(this);

				index = $wizard.bootstrapWizard('currentIndex');
				refreshAnimation($wizard, index);

				$('.moving-tab').css({
				  'transition': 'transform 0s'
				});
			  });
			});

			function refreshAnimation($wizard, index) {
				$total = $wizard.find('.nav li').length;
				$li_width = 100 / $total;

				total_steps = $wizard.find('.nav li').length;
				move_distance = $wizard.width() / total_steps;
				index_temp = index;
				vertical_level = 0;

				mobile_device = $(document).width() < 600 && $total > 3;

				if (mobile_device) {
				  move_distance = $wizard.width() / 2;
				  index_temp = index % 2;
				  $li_width = 50;
				}

				$wizard.find('.nav li').css('width', $li_width + '%');

				step_width = move_distance;
				move_distance = move_distance * index_temp;

				$current = index + 1;

				if ($current == 1 || (mobile_device == true && (index % 2 == 0))) {
				  move_distance -= 8;
				} else if ($current == total_steps || (mobile_device == true && (index % 2 == 1))) {
				  move_distance += 8;
				}

				if (mobile_device) {
				  vertical_level = parseInt(index / 2);
				  vertical_level = vertical_level * 38;
				}

				$wizard.find('.moving-tab').css('width', step_width);
				$('.moving-tab').css({
				  'transform': 'translate3d(' + move_distance + 'px, ' + vertical_level + 'px, 0)',
				  'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

				});
			}
        }
		
		
		if(escrot.is_front_user == 'true'){ setDataTable(); initMaterialWizard();}
		
		//Get URL Token value for GET Response 
		var urlParams = new URLSearchParams(window.location.search); 
		
		if(urlParams.get('page') == "escrowtics-view-escrow"){ setDataTable(); }

		//Display Dashboard Escrows
		if(urlParams.get('page') == "escrowtics-dashboard"){ displayDashEscrows(); }
		function displayDashEscrows(){
			var data = {'action':'escrot_dash_escrows',};
			$.post(escrot.ajaxurl, data, function(response) {
				 $("#tableDataDB").html(response);
				 initMaterialWizard();
				 setTimeout(function() {$('.card.card-wizard').addClass('active');}, 600); 
			});
		}
		
		
		
			   
		//Display Escrows	
		if(urlParams.get('page') == "escrowtics-escrows"){ displayEscrows(); }
		function displayEscrows(){ 
		    var data = {
				'action':'escrot_escrows',
			};
			$.post(escrot.ajaxurl, data, function(response) {
			    $("#escrot-admin-container").html(response);
			  setDataTable();
			  initMaterialWizard();
			  setTimeout(function() {$('.card.card-wizard').addClass('active');}, 600); 
			});
		} 
		
		
		//Display Admin Deposit invoices	
		if(urlParams.get('page') == "escrowtics-deposits"){ displayDeposits(); }
		function displayDeposits(){ 
		    var data = {
				'action':'escrot_deposits',
			};
			$.post(escrot.ajaxurl, data, function(response) {
			    $("#escrot-admin-container").html(response);
			  setDataTable();
			});
		}
		
		
		//Display Admin Withdrawal invoices	
		if(urlParams.get('page') == "escrowtics-withdrawals"){ displayWithdrawals(); }
		function displayWithdrawals(){ 
		    var data = {
				'action':'escrot_withdrawals',
			};
			$.post(escrot.ajaxurl, data, function(response) {
			    $("#escrot-admin-container").html(response);
			  setDataTable();
			});
		}
		
		function reloadWithdrawals(){ 
		    var data = {
				'action':'escrot_reload_withdrawals',
			};
			$.post(escrot.ajaxurl, data, function(response) {
			    $("#escrot-withdrawals-table-wrapper").html(response);
				setDataTable();
			});
		}
		
		
		
		
		//Display Log	
		if(urlParams.get('page') == "escrowtics-transaction-log"){ displayTransactionLog(); }
		function displayTransactionLog(){ 
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
				initMaterialWizard();
			});
		} 
		
		//Reload Escrows Meta	   
		function reloadEscrowMeta(){
			var escrow_id = $('#escrot-escrow-meta-table').data('escrow-id'); 
			var data = {'action':'escrot_reload_escrow_meta_tbl', 'escrow_id':escrow_id,};
			$.post(escrot.ajaxurl, data, function(response) {
			    $("#escrot-view-escrow-table-wrapper").html(response);
			    setDataTable();
			});
		}
		
		//Display User Escrows
		function userEscrows(){
			 	 
			var user_id = urlParams.get('user_id');
			var data = {'action':'escrot_user_escrows', 'userid':user_id,};
				
			$.post(escrot.ajaxurl, data, function(response) {
				$(".escrot-user-escrows-wrap").html(response);
				setDataTable();
				initMaterialWizard();
				setTimeout(function() {$('.card.card-wizard').addClass('active');}, 600); 
			});
		} 	
		
	   
		
		//Reload Escrow Table
		$("body").on("click", "#reloadTable", function(e){  
			reloadEscrows();
			Swal.fire({
				icon: 'success', 
				title: 'Table Reloaded successfully!',
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
				  $('#EscrotEscrowUser_notice').html('<span class="text-danger">User <b>'+User+'</b> Not Found</span>');
				  
				}
			});
		  } else {
			$("#EscrotEscrowUser_notice").html("");
		  }
		  
		});
		
		
		
		//Generate Random Password
		$("body").on("click", ".escrotAutoPassTrigger", function(e){
		  e.preventDefault();
		  var data = {'action':'escrot_get_rand_pass',};
			$.post(escrot.ajaxurl, data, function(response) {
			    $("#EscrotEscrowPass").val(response.data);
			});
		});
		
		
		
		//Release escrow payment
		$("body").on("click", ".escrot-release-pay", function(e){
			e.preventDefault();
			var MetaID = $(this).attr('id');
				  swal.fire({
				  title: 'Are you sure?',
					text: "Choose Cancel if you're not sure!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, release payment!',
				}).then((result) => {
				  if (result.value){
					var data = {'action':'escrot_release_payment', 'meta_id':MetaID};
					$.post(escrot.ajaxurl, data, function(response) {
			  
						if(response.status == "success"){
							Swal.fire({
							   icon: 'success',
							   title: response.message,
							   showConfirmButton: false, 
							   timer: 1500,
							});
							reloadEscrowMeta();
						} else {
							Swal.fire({
							   icon: 'warning',
							   title: response.status,
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
				  title: 'Are you sure?',
					text: "Choose Cancel if you're not sure!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, reject this amount!',
				}).then((result) => {
				  if (result.value){
					var data = {'action':'escrot_reject_amount', 'meta_id':MetaID};
					$.post(escrot.ajaxurl, data, function(response) {
			  
						if(response.status == "success"){
							Swal.fire({
							   icon: 'success',
							   title: response.message,
							   showConfirmButton: false, 
							   timer: 1500,
							});
							reloadEscrowMeta();
						}	   
			  
				    });//ajax
				}
			});//then
		});
		
		
        //Move to top of dashboard add escrow form.
		$("body").on("click", "#addEscrowDash", function(e){
			$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
		})

		
		//Add escrow
		$("body").on("submit", "#AddEscrowForm", function(e){
			e.preventDefault();
			if (UserAvailable == false) {
			   $('.add_error_mge').html('<p style="color: white; text-align: center;" class="alert alert-danger"> Please fix the errors in the form first (User does not exist )</p>');
			} else{
				swal.fire({
					title: 'Really want to add escrow?',
					text: "Choose Cancel if you're not sure!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, add escrow!',
				}).then((result) => {
				  if (result.value){
				
					var form_data = $(this).serialize();   
					$.post(escrot.ajaxurl, form_data, function(response) { 
					    if(response.status == "success"){
						Swal.fire({
						   icon: 'success',
						   title: 'Escrow Added successfully',
						   showConfirmButton: false, 
						   timer: 1500,
						});
						$("#escrot-add-escrow-modal").modal('hide');
						$("#AddEscrowForm")[0].reset();
						$("#escrot-add-escrow-form-dialog").collapse('hide');
						if(urlParams.get('page') == "escrowtics-dashboard"){
							displayDashEscrows();
						} else { 
							reloadEscrows(); 
						}
						$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
						$('#escrot-escrow-error').html('');
					  } else{
						 $('#escrot-escrow-error').html('<p style="color: white; text-align: center;" class="alert alert-danger">'+response.status+'</p>');
						 $("html, #escrot-escrow-error").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
					  }    
		  
					});//ajax
				  }
				});//then  
			} 
		});
		
		
		//Create Escrow Milestone
		$("body").on("submit", "#escrot-milestone-form", function(e){
			e.preventDefault();
			swal.fire({
				title: 'Really want to add milestone?',
				text: "Choose Cancel if you're not sure!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, add milestone!',
			}).then((result) => {
			  if (result.value){
			
				var form_data = $(this).serialize();   
				$.post(escrot.ajaxurl, form_data, function(response) { 
					if(response.status == "success"){
					Swal.fire({
					   icon: 'success',
					   title: 'Milestone Added successfully',
					   showConfirmButton: false, 
					   timer: 1500,
					});
					$("#escrot-milestone-form-modal").modal('hide');
					$("#escrot-milestone-form")[0].reset();
					$("#escrot-milestone-form-dialog").collapse('hide');
					reloadEscrowMeta(); 
					
					$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
					$('.escrot-milestone-error').html('');
				  } else{
					 $('#escrot-milestone-error').html('<p style="color: white; text-align: center;" class="alert alert-danger">'+response.status+'</p>');
					 $("html, #escrot-milestone-error").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
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
				
				if(response.mode == 'modal'){
				   $('#escrot-view-milestone-modal-body').html(response.data);  
				   $('#escrot-view-milestone-modal').modal("show");
				}else {
				   $('#escrot-milestone-details').html(response.data); 
                   $("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');				   
				}
			});//ajax
		});
		
	


		//Delete Single data
		$("body").on("click", ".escrot-delete-btn", function(e){
				
			 e.preventDefault();
				 var tr = $(this).closest('tr');
				 var delID = $(this).attr('id');
				 var action = $(this).data('action');
		 
				swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'Yes',
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
							   title: response.label+' deleted successfully',
							   showConfirmButton: false, 
							   timer: 1500,
							});
							var urlParams = new URLSearchParams(window.location.search);
							if(urlParams.get('user_id') !== null){
								userEscrows();
							} else { 
							    if(urlParams.get('page') == "escrowtics-dashboard"){ 
									displayDashEscrows(); 
								} else if(urlParams.get('page') == "escrowtics-view-escrow"){ 
									reloadEscrowMeta();
								} else { 
									reloadEscrows(); 
									reloadSearchResults();
								}
								$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
							}
					});
					   
				}
		 
			})
		 
		});


		//Delete Multiple Data
		$(document).on('click', '.escrot-mult-delete-btn', function() {
			var action = $(this).data('action');
			var selectedRows = [];
			$(".escrot-checkbox:checked").each(function() {
				selectedRows.push($(this).data('escrot-row-id'));
			});
			if(selectedRows.length <=0) {
				 Swal.fire({
						 icon: 'warning',
						 title: 'No Record Selected.',
						 text: "Please select atleast 1 record to continue!",
					   });
			} 
			else { 
				swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'Yes, delete '+(selectedRows.length>1?'records':'record')+'!',
				}).then((result) => {
					if (result.value){	
					
					var selected_values = selectedRows.join(",");
					
					  var data = {
							'action':action,
							'multID':selected_values,
						};
			
						$.post(escrot.ajaxurl, data, function(response) {
							var multIDs = selected_values.split(",");
		  
							for (var i=0; i < multIDs.length; i++ ) {	
								$("#"+multIDs[i]).css('background-color','#ff6565'); 
								Swal.fire({
								   icon: 'success',
								   title: ''+(selectedRows.length>1? response.label+'s': response.label)+' deleted successfully',
								   text: ''+(selectedRows.length)+' '+(selectedRows.length>1? response.label+'s':response.label)+' Deleted!',
								   showConfirmButton: false, 
								   timer: 1500,
								});
								
								var urlParams = new URLSearchParams(window.location.search);
								if(urlParams.get('user_id')){
								   userEscrows();
								} else { 
									if(urlParams.get('page') == "escrowtics-view-escrow"){ 
										reloadEscrowMeta();
									} else { 
										reloadEscrows(); 
									}
								}
							}	
					  });
					   
				 } 
			}) //swal.fire end
		  }
		});	
		
		//Reload Escrow Table
		$("body").on("click", "#reloadTable", function(e){  
			reloadEscrows();
			Swal.fire({
				icon: 'success', 
				title: 'Table Reloaded successfully!',
				showConfirmButton: false, 
				timer: 1500, 
			});
		});
		
		//Set Invoice Code
		$("body").on("click", ".escrot-update-invoice-btn", function(e){
			e.preventDefault();
			var code = $(this).attr('id');
			$('#escrot-status-update-code').val(code); 
		});
		
		
		//Create Escrow Milestone
		$("body").on("submit", "#escrot-invoice-status-form", function(e){
			e.preventDefault();
			swal.fire({
				title: 'Really want to update invoice?',
				text: "Choose Cancel if you're not sure!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, update invoice!',
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
						$("#escrot-withdrawal-status-modal").modal('hide');
					    $("#escrot-invoice-status-form")[0].reset();
					    $("#escrot-withdrawal-status-dialog").collapse('hide');
						reloadWithdrawals(); 
						$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow');
				    }   
				});//ajax
			  }
			});//then  
			
		});
		
		
		
		
        /******************************* Escrow Serach ***********************************/
		
		//Animate Escrow Search Input
		$("body").on('focus', '#escrot-escrow-search-input', function(e){
			if($("#escrot-escrow-search-input").val() == ""){ $("#escrot-escrow-search-input").animate({width: '+=100px'}, 1000); }
		});
		$("body").on('blur', '#escrot-escrow-search-input', function(e){
			if($("#escrot-escrow-search-input").val() == ""){ $("#escrot-escrow-search-input").animate({width: '-=100px'}, 1000); }
		});
		
		
		//Display Escrow Search Results
		$("body").on('submit', '#escrot-escrow-search-form', function(e){
			e.preventDefault();
            var form_data = $(this).serialize();
		
		    $.post(escrot.ajaxurl, form_data, function(response) { 
			
			    if(response.mode == 'modal'){
				  $('#escrot-escrow-search-results-modal-body').html(response.data); //modal  
				  $('#escrot-escrow-search-modal').modal("show"); 
			    }else {
				  $('#escrot-escrow-search-results-dialog-wrap').html(response.data); 
				  $("#escrot-search-results-dialog").collapse('show');
				  $('#escrot-search-results-dialog').animate({scrollTop: $('#escrot-search-results-dialog')[0].scrollHeight}, "1000");
			    }
				$("#escrot-escrow-search-phrase").val(response.search_text);
			    $("#escrot-escrow-search-form")[0].reset();
				   
		    });
        });
		
		
		//Reload Escrow Search Results (escrows table)	   
		function reloadSearchResults(){
			
			var search_text = $("#escrot-escrow-search-phrase").val();
			var data = {'action':'escrot_reload_escrow_search', 'search_text':search_text };
			$.post(escrot.ajaxurl, data, function(response) {
			    if(response.mode == 'modal'){
				  $('#escrot-escrow-search-results-modal-body').html(response.data); //modal
			    }else {
				  $('#escrot-escrow-search-results-dialog-wrap').html(response.data); 
				}
			});
		}
		
		
	    //Delete Search Escrow
		$("body").on("click", ".escrot-escrow-search-del-btn", function(e){
				
			 e.preventDefault();
				 var tr = $(this).closest('tr');
				 var delID = $(this).attr('id');
		 
				swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'Yes, delete escrow!',
				}).then((result) => {
					if (result.value){
				  
					var data = {'action':'escrot_del_escrow', 'delID':delID,};
						$.post(escrot.ajaxurl, data, function(response) {
							tr.css('background-color','#ff6565');
							Swal.fire({
							   icon: 'success',
							   title: 'Escrow deleted successfully',
							   showConfirmButton: false, 
							   timer: 1500,
							});
							reloadSearchResults();
					});
					   
				}
		 
			})
		 
		});


        //Download Escrow Waybill
	    $("body").on("click", "#download-waybill", function() {
	        $('#displayEscrowWaybill').modal("hide");
            $("#escrot-loader").show(); 
            $("#SpinLoaderText").html("Downloading.."); 	
            var HTML_Width = $("#escrot-escrow-waybill").width();
            var HTML_Height = $("#escrot-escrow-waybill").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas($("#escrot-escrow-waybill")[0]).then(function (canvas) {
              var imgData = canvas.toDataURL("image/jpeg", 1.0);
              var pdf = new jsPDF("p", "pt", [PDF_Width, PDF_Height]);
              pdf.addImage(imgData, "JPG", top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
              for (var i = 1; i <= totalPDFPages; i++) { 
                  pdf.addPage(PDF_Width, PDF_Height);
                  pdf.addImage(imgData, "JPG", top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,      canvas_image_height);
              }
              pdf.save("Tracking-Waybill.pdf");
		      $("#SpinLoaderText").html(""); 
		      $("#escrot-loader").hide();
            });
        });      

 
        //Download Escrow Invoice
	    $("body").on("click", "#download-invoice", function() {
	        $('#displayEscrowInvoice').modal("hide");
            $("#escrot-loader").show(); 
            $("#SpinLoaderText").html("Downloading.."); 	
            var HTML_Width = $("#admin-print-invoice").width();
            var HTML_Height = $("#admin-print-invoice").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas($("#admin-print-invoice")[0]).then(function (canvas) {
              var imgData = canvas.toDataURL("image/jpeg", 1.0);
              var pdf = new jsPDF("p", "pt", [PDF_Width, PDF_Height]);
              pdf.addImage(imgData, "JPG", top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
              for (var i = 1; i <= totalPDFPages; i++) { 
                  pdf.addPage(PDF_Width, PDF_Height);
                  pdf.addImage(imgData, "JPG", top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,      canvas_image_height);
              }
              pdf.save("Tracking-Invoice.pdf");
		      $("#SpinLoaderText").html(""); 	
		      $("#escrot-loader").hide();
            });
        });
		
		
		

	});
		
		

