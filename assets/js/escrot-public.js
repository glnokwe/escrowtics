jQuery(document).ready(function($){
	
	//Ajax Loader
	$(document).ajaxStart(function() {
	  $("#escrot-loader").show();
	});
	$(document).ajaxStop(function() {
	  $("#escrot-loader").hide();
	});
	
	
	//Point to collapsable dialogs
	var dialogs = ['escrot-bitcoin-deposit-form-dialog', 'escrot-bitcoin-withdraw-form-dialog'];

	$("body").on("click", "#escrot-bitcoin-pay", function(e) {
		e.preventDefault();
		for(i=0;i<dialogs.length;i++){ 
			$("html, #escot_front_wrapper").animate({scrollTop: $('#'+dialogs[i]).offset().top}, 'slow');   
		}
	});
  
	
	
	
	/************************************** USER PROFILE*************************************/
	
	
	//User Signin
	$("#escrot-user-login-form").on('submit', function(e){
		e.preventDefault();
		var datatopost = $(this).serializeArray();
		$.ajax({
			url: escrot.ajaxurl,
			type: "POST",
			data: datatopost,
			success: function(response) {
				if (response.status === "success") {
					Swal.fire({
					  icon: 'success',
					  title: response.message,
					  showConfirmButton: false,
					  timer: 1500
					});
					window.location.replace(response.redirect);
				} else {
				  $("#escrot_user_login_error").html('<div class="alert alert-danger">'+response.status+'</div>');
				}
			}
		});
	});
	
	
	
	//User Signup
	$("#escrot-user-signup-form").on('submit', function(e){
		e.preventDefault();
		var datatopost = $(this).serializeArray();

		$.ajax({
			url: escrot.ajaxurl,
			type: "POST",
			data: datatopost,
			success: function(response) {
				if (response.status === "success") {
					Swal.fire({
					  icon: 'success',
					  title: response.message,
					  showConfirmButton: false,
					  timer: 1500
					});
					window.location.replace(response.redirect);
				} else {
				  $("#escrot_signup_error").html('<div class="alert alert-danger">'+response.status+'</div>');
				}
			}
		});
	});
	
	
	//User Logout
	$("#EscrotLogOutFrontNavItem").on("click", function(e){	
		e.preventDefault();
		swal.fire({
		  title: 'Really want to logout?',
			text: "Cancel if you're not sure!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Logout',
		}).then((result) => {
			if (result.value){
				$.ajax({
					url: escrot.ajaxurl,
					type: "POST",
					data: {'action':'escrot_user_logout',},
					success: function(response) {
						if (response.status === "success") {
							Swal.fire({
								icon: 'success',
								title: 'Logout Successful',
							});
							location.reload();
						}
					}	
				});
			}
		});//then
	});
	
	
	//Reload User Account
	function reloadUser(){
		$.ajax({	
			url: escrot.ajaxurl,
			type: "POST",
			data: {'action':'escrot_reload_user_account',},
			success: function(response) {
				$("#escrot-edit-account").html(response);
			}
		});
	}
	
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
			   var form_data = new FormData( this );
				 $.ajax({
					url: escrot.ajaxurl,
					type: "POST",
					data: form_data,
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
							reloadUser();
							$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-main-panel').offset().top}, 'slow'); 
						} else{
							$('#escrot_user_error').html('<p style="color: white; text-align: center;" class="alert alert-danger">'+response.status+'</p>');
						}
					}	
			   });
			}
		});//then
	});
	
	
	//Reply Ticket
	$("body").on('submit', '#escrot-user-ticket-reply-form', function(e){
		e.preventDefault();
		$.ajax({
			url: escrot.ajaxurl,
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(response) { 
				$('#escrot-chat-message').animate("background-color", "green"); 
				$('#escrot-ticket-chat-wrapper').html(response); 
				$("#escrot-user-ticket-reply-form")[0].reset();
				$('#escrot-ticket-chat-wrapper').animate({scrollTop: $('#escrot-ticket-chat-wrapper')[0].scrollHeight}, "1000");
			}	
	   });
	});

	
	
	//update user password	
	$("body").on('submit', '#EditEscrotUserPassForm', function(e){
		e.preventDefault();
			  swal.fire({
			  title: 'Are you sure?',
				text: "You will need to login again.",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, update password',
			}).then((result) => {
			   if (result.value){
		   
			   var form_data = $(this).serialize();
				 $.ajax({
					url: escrot.ajaxurl,
					type: "POST",
					data: form_data,
					success: function(response) { 
						if(response.status == "success"){
							Swal.fire({
							   icon: 'success',
							   title: 'Password updated successfully',
							   showConfirmButton: false, 
							   timer: 1500,
							});
							location.reload();
						} else{
							$('#escrot_user_pass_error').html('<p style="color: white; text-align: center;" class="alert alert-danger">'+response.status+'</p>');
						}
					}	
			   });
			}
		});//then
	});
	
	
	/************************************** PAYMENTS *************************************/
	
	//Generate Bitcoin Deposit Invoice
	$("body").on('submit', '#escrot-bitcoin-deposit-form', function(e){
		e.preventDefault();
			  swal.fire({
			  title: 'Are you sure?',
				text: "Cancel if you're not ready to pay now",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, generate invoice',
			}).then((result) => {
			   if (result.value){
		   
			   var form_data = $(this).serialize();
				 $.ajax({
					url: escrot.ajaxurl,
					type: "POST",
					data: form_data,
					success: function(response) { 
						if(response.status == "success"){
							Swal.fire({
							   icon: 'success',
							   title: 'Deposit invoice gerated successfully',
							   showConfirmButton: false, 
							   timer: 1500,
							});
							var url= $('#escrot-bitcoin-deposit-form').data('invoice-url'); 
							window.location = url+'?endpoint=bitcoin_deposit_invoice&code='+response.code;
						} else{
							$('#escrot-bitcoin-deposit-error').html('<p style="color: white; text-align: center;" class="alert alert-danger">'+response.status+'</p>');
						}
					}	
			   });
			}
		});//then
	})
	
	
	
	//Generate Bitcoin Withdraw Invoice
	$("body").on('submit', '#escrot-bitcoin-withdraw-form', function(e){
		e.preventDefault();
			  swal.fire({
			  title: 'Are you sure?',
				text: "Cancel if you're not ready to pay now",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, generate invoice',
			}).then((result) => {
			   if (result.value){
		   
			   var form_data = $(this).serialize();
				 $.ajax({
					url: escrot.ajaxurl,
					type: "POST",
					data: form_data,
					success: function(response) { 
						if(response.status == "success"){
							Swal.fire({
							   icon: 'success',
							   title: 'Withdrawal invoice gerated successfully',
							   showConfirmButton: false, 
							   timer: 1500,
							});
							var url= $('#escrot-bitcoin-withdraw-form').data('invoice-url'); 
							window.location = url+'?endpoint=bitcoin_withdraw_invoice&code='+response.code;
						} else{
							$('#escrot-bitcoin-withdraw-error').html('<p style="color: white; text-align: center;" class="alert alert-danger">'+response.status+'</p>');
						}
					}	
			   });
			}
		});//then
	})
	
	
	//Show other option input for manual deposits/withdrawals
	const transactions = ["deposit", "withdraw"];
	transactions.forEach(transaction => {
		$('#escrot-manual-'+transaction+'-payment-select').on("change", function () {
			const selectedValue = $(this).val();
			if (selectedValue === 'Other') {
				$('#escrot-manual-' +transaction+'-other-payment').slideDown();
			} else {
				$('#escrot-manual-'+transaction+'-other-payment').slideUp();
			}
		});
	});
	
	

});



//General print function
function printDiv(divName){
	document.getElementById('escrot-print-title').innerHTML = '<center>Escrowtics Tracking Results</center>';
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents; 
}


//print function for Modals
function printModal(divName){
	var toPrint;
	toPrint = window.open();
	toPrint.document.write(document.getElementById(divName).innerHTML);
	toPrint.print();
	toPrint.close();
}