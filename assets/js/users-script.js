
jQuery(document).ready(function($){

	//Function - Users DataTable Setup & Initialization
	function setUsersDataTable(){
		
		const usersColumns = [
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
			{
				data: 2, 
				orderable: false,
				render: function (data, type, row) {
					return row[2].user_img;
				},
			}, 
			{ data: 3 }, 
			{
				data: 4, 
				orderable: false,
				render: function (data, type, row) {
					return row[4].escrow_count;
				},
			},
			{
				data: 5, 
				orderable: false,
				render: function (data, type, row) {
					return row[5].earnings_count;
				},
			}, 
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
		
		// Initialize tables
		EscrotInitDataTable('#escrot-user-table','escrot_users_datatable', 7, usersColumns, 0, !escrot.is_front_user);
		
		//table options buttons
        EscrotSetDataTableOptionsBtn();		
	}
	
	 
	//Get URL Token value for user_id (GET Response) 
	var urlParams = new URLSearchParams(window.location.search); 
	 
	
	//Display Users Table
    getAllUsers();
    function getAllUsers(){
	    var data = {'action':'escrot_users',};
		$.post(escrot.ajaxurl, data, function(response) {
		    $("#escrot-admin-container").html(response.data);
		    setUsersDataTable();
		});
    }
	
	
	//Reload Users Table
    function reloadUsers(){
	    if(escrot.is_user == 'true'){ 
			var data = {'action':'escrot_reload_user_account',};
			$.post(escrot.ajaxurl, data, function(response) {
				$("#escrot-edit-account").html(response.data); 
			});
		} else { 
			var data = {'action':'escrot_users_tbl',}; 
			$.post(escrot.ajaxurl, data, function(response) {
				$("#escrot-user-table-wrapper").html(response.data);
				setUsersDataTable();
			});
		}
		
    }
	
	//Display User Profile
	if(urlParams.get('user_id')){ showUserProfile(); } 
    function showUserProfile(){
		var user_id = urlParams.get('user_id');
	    var data = {
			'action':'escrot_user_profile',
			'user_id':user_id, 
		};
		jQuery.post(escrot.ajaxurl, data, function(response) {
		   $("#escrot-profile-container").html(response.data); 
		});
    }
	//Show User Profile Title
	$("body").on("click", ".escrot-user-profile-btn", function(e){ 
	    $(".escrot-user-profile-title").show();
		$(".escrot-user-escrow-tbl-title").hide();
		$(".escrot-user-earnings-tbl-title").hide();
	});



   
	/**
	 * Reusable function to verify input fields for uniqueness
	 * @param {string} fieldSelector - The selector for the input field to watch
	 * @param {string} action - The AJAX action to trigger
	 * @param {string} warningText - The warning text to display if the value is taken
	 */
	function escrotVerifyUserField(fieldSelector, warningText) {
		$("body").on("blur", fieldSelector, function () {
			const fieldValue = $(this).val().trim();
			const data = {
				'action': 'escrot_verify_user',
				'user_field': fieldValue, // Generalized key
			};

			$.post(escrot.ajaxurl, data, function (response) {
				if (response === "taken") {
					Swal.fire({
						icon: "error",
						title: escrot.swal.warning.error_title,
						text: warningText,
						showConfirmButton: true,
					});
				}
			});
		});
	}

	// Check if username & email already exist
	escrotVerifyUserField("#EscrotUserEmail", escrot.swal.user.email_already_exist);
	escrotVerifyUserField("#EscrotUserUsername", escrot.swal.user.user_already_exist);

	

	// Insert/Add User
	$("body").on("submit", "#UserAddForm", function (e) {
		e.preventDefault();

		swal
			.fire({
				title: escrot.swal.warning.title,
				text: escrot.swal.warning.text,
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: escrot.swal.user.add_user_confirm,
			})
			.then((result) => {
				if (result.value) {
					
					const formData = $(this).serialize();

					// Submit the form data
					$.post(escrot.ajaxurl, formData, function (response) {
						if (response.success) {
							Swal.fire({
								icon: "success",
								title: response.data.message,
								showConfirmButton: false,
								timer: 1500,
							});
							$("#escrot-add-user-modal").modal("hide");
							$("#escrot-add-user-form-dialog").collapse("hide");
							$("#UserAddForm")[0].reset();
							reloadUsers();
							$("html, .escrot-main-panel").animate({ scrollTop: $(".escrot-main-panel").offset().top }, "slow" );
						} else {
							Swal.fire({
								icon: "error",
								title: escrot.swal.warning.error_title,
								text: response.data.message,
								showConfirmButton: true,
							});
						}
					});
				}
			});
	});

	

    // Edit User Record (pull existing data into form)
	$("body").on("click", ".escrot-user-edit-btn", function (e) {
		e.preventDefault();

		let userId = $(this).attr("id");
		let data = {
			action: "escrot_user_data",
			UserId: userId,
		};

		$.post(escrot.ajaxurl, data, function (response) {
			const fields = {
				"#EditEscrotUserID": "ID",
				"#EditEscrotUserFirstName": "first_name",
				"#EditEscrotUserLastName": "last_name",
				"#EditEscrotUserEmail": "user_email",
				"#EditEscrotUserPhone": "phone",
				"#EditEscrotUserCountry": "country",
				"#EditEscrotUserCompany": "company",
				"#EditEscrotUserSA": "sa_id",
				"#EditEscrotUserUsername": "user_login",
				"#EditEscrotUserBio": "bio",
				"#EditEscrotUserAddress": "address",
				"#EditEscrotUserUrl": "user_url",
				"#EditEscrotUserImg": "user_image",
				"#EditEscrotStatus": "status"
			};

			// Dynamically populate the fields
			for (const [fieldSelector, key] of Object.entries(fields)) {
				$(fieldSelector).val(response.data[key]);
			}

			// Update the form title with the current user email
			$("#CrtEditUserID").html(response.data.user_login);

			// Handle user image logic
			let imagePath = response.data.user_image;
			if (imagePath) {
				$(".EditEscrotUserImg-FilePrv").html("<img src='"+imagePath+"' alt='...'>");
				$(".EditEscrotUserImg-FilePrv").addClass("thumbnail");
				$(".EditEscrotUserImg-AddFile").hide();
				$(".EditEscrotUserImg-ChangeFile, .EditEscrotUserImg-dismissPic").show();
			}
		});

		// Scroll to the form
		$("html, .escrot-main-panel").animate(
			{ scrollTop: $(".escrot-admin-forms").offset().top },
			"slow"
		);
	});



  	//update User
	$("body").on('submit', '#escrot-edit-user-form', function(e){
        e.preventDefault();
		swal.fire({
		    title: escrot.swal.warning.title,
			text: escrot.swal.warning.text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: escrot.swal.user.update_confirm,
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
			title: escrot.swal.warning.title,
			text: escrot.swal.user.delete_user_text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: escrot.swal.user.delete_user_confirm,
		}).then((result) => {
		   if (result.value){
			   
				var data = {
					'action':'escrot_del_user',
					'UserID':UserID,
				};
				$.post(escrot.ajaxurl, data, function(response) {
					if(response.success){
						tr.css('background-color','#ff6565');
						Swal.fire({
						   icon: 'success',
						   title: response.data.message,
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
					}
				});
			}
     
    	})
     
    });
	
	
  
	// Delete Multiple Assigned Users
	$(document).on("click", ".escrot-mult-delete-user-btn", function (e) {
		e.preventDefault();

		let users = $(".escrot-checkbox:checked")
			.map(function () {
				return $(this).data("escrot-row-id");
			})
			.get();

		if (users.length <= 0) {
			Swal.fire({
				icon: "warning",
				title: escrot.swal.warning.no_records_title,
				text: escrot.swal.warning.no_records_text,
			});
		} else {
			const userText = users.length > 1 ? "Users" : "User";
			swal.fire({
				title: escrot.swal.warning.title,
				text: escrot.swal.user.delete_user_text,
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d33",
				cancelButtonColor: "#3085d6",
				confirmButtonText: `${users.length > 1 ? escrot.swal.warning.delete_records_confirm : escrot.swal.warning.delete_record_confirm}`,
			})
			.then((result) => {
				if (result.value) {
					let selectedValues = users.join(",");

					let data = {
						action: "escrot_del_users",
						multUserid: selectedValues,
					};

					$.post(escrot.ajaxurl, data, function (response) {
						// Highlight deleted rows
						users.forEach((userId) => {
							$(`#${userId}`).css("background-color", "#ff6565");
						});
						Swal.fire({
							icon: "success",
							title: `${users.length > 1 ? escrot.swal.user.user_plural : escrot.swal.user.user_singular} `+escrot.swal.success.delete_success,
							text: `${users.length > 1 ? escrot.swal.user.user_plural_deleted : escrot.swal.user.backup_singular_deleted} `,
							showConfirmButton: false,
							timer: 1500,
						});
						reloadUsers();
					});
				}
			});
		}
	});



    // Initialize upload functionality for Add and Edit User Image
	EscrotWPFileUpload("EscrotUserImg");
	EscrotWPFileUpload("EditEscrotUserImg");


    //Scroll to Users Orders
	$("body").on('click', '#viewtrkgs', function() {	
	      $("html, .escrot-main-panel").animate({scrollTop: $('#UserOrders').offset().top}, 'slow'); 
    });
	

});
	

