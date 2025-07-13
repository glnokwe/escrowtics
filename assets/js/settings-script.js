jQuery(document).ready(function($) {
    // Update settings
    $("body").on("click", ".escrot-submit-settings", function() {
		$("#escrot-loader").css("background-color", "#010e31d1");
        $('#SpinLoaderText').html(escrot.swal.warning.save_sett_loader_text);
    });

    $('#escrot-options-form').submit(function() {
        $(this).ajaxSubmit({
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: escrot.swal.success.save_sett_success,
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#SpinLoaderText').html("");
                $("#escrot-sett-modal").modal('hide');
                location.reload();
            },
            timeout: 5000
        });
        return false;
    });

	// Export settings
	$("body").on("click", "#escrot-export-settings", function () {
		var data = { action: "escrot_exp_options" };

		// Send AJAX request to export options
		$.post(ajaxurl, data, function (response) {
			if (response.success) {
				// Create a downloadable JSON file
				var blob = new Blob([response.data.options], { type: "application/json" });
				var downloadUrl = URL.createObjectURL(blob);
				var a = document.createElement("a");
				a.href = downloadUrl;
				a.download = "escrowtics-options-" + Date.now() + ".json";
				document.body.appendChild(a);
				a.click();

				// Show success message
				Swal.fire({
					icon: "success",
					title: response.data.message,
				});
			} else {
				// Show error message if the export fails
				Swal.fire({
					icon: "error",
					title: escrot.swal.warning.error_title,
					text: response.data.message,
				});
			}
		}).fail(function (jqXHR, textStatus, errorThrown) {
			// Handle AJAX failure
			Swal.fire({
				icon: "error",
				title: escrot.swal.warning.error_title,
				text: `Error: ${textStatus}. ${errorThrown}`,
			});
		});
	});


    // Import settings
    $("body").on("click", "#imp_options_btn", function() {
        $('#SpinLoaderText').html("<strong>"+escrot.swal.warning.import_sett_loader_text+"</strong>");
    });

    $("#escrot-options-imp-form").on('submit', function(e) {
        e.preventDefault();
        swal.fire({
            title: escrot.swal.warning.title,
            text: escrot.swal.warning.import_sett_text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: escrot.swal.warning.import_sett_confirm,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: response.data,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            $('#SpinLoaderText').html("");
                            $("#DisplayOptionsImportForm").collapse('hide');
                            $("#escrot-options-import-modal").modal('hide');
                            $("#escrot-options-imp-form")[0].reset();
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: response.data,
                            });
                        }
                    }
                });
            }
        });
    });

    // Restore settings defaults
    $("body").on("click", ".escrot-reset-settings", function() {
        swal.fire({
            title: escrot.swal.warning.title,
			text: escrot.swal.warning.text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: escrot.swal.warning.reset_sett_confirm,
        }).then((result) => {
            if (result.value) {
                var data = { 'action': 'escrot_reset_options' };
                $.post(ajaxurl, data, function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.data,
                        });
                        location.reload();
                    }
                });
            } else {
				// Show error message if the export fails
				Swal.fire({
					icon: "error",
					title: escrot.swal.warning.error_title,
					text: response.data,
				});
			}
        });
    });

    // Generate REST API Key & URL
    const ids = ["rest_api_key", "rest_api_endpoint_urls"];
    ids.forEach(ID => {
        $("body").on("click", "#escrot_" + ID + "_generator", function(e) {
            e.preventDefault();
            var data = { 'action': 'escrot_generate_' + ID };

            $.post(ajaxurl, data, function(response) {
                if (response.success) {
                    if (ID === 'rest_api_endpoint_urls') {
                        let api_key = $('#rest_api_key').val();
                        $('#' + ID).val(response.data.url); // Append API key to the URL
                    } else {
                        $('#' + ID).val(response.data.key); // Set the generated API key
                    }
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    // Handle server-side errors
                    Swal.fire({
                        icon: 'error',
                        title: escrot.swal.warning.error_title,
                        text: response.data.message,
                        showConfirmButton: true
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                // Handle AJAX request failures
                Swal.fire({
                    icon: 'error',
                    title: 'Request Failed',
                    text: `Error: ${textStatus}. ${errorThrown}`,
                    showConfirmButton: true
                });
            });
        });
    });
	


    // Special settings options
    var data = { 'action': 'escrot_options' };
    $.post(ajaxurl, data, function(response) { 
        // Set variable for current Company Logo
        var imagePath = response.company_logo;

        // If company logo, replace default avatar with it, then add "Change" & "Remove" buttons
        if (imagePath !== "") {
			
			$(".company_logo-FilePrv").html("<img src='"+imagePath+"' alt='...'>");
			$(".company_logo-FilePrv").addClass("thumbnail");
			$(".company_logo-AddFile").hide();
			$(".company_logo-ChangeFile, .company_logo-dismissPic").show();
        }

        // Check if setting is "ON" and perform other actions
		escrotUpdateToggle(response.smtp_protocol, 'smtp_protocol', 'escrot-smtp-settings-options');
		escrotUpdateToggle(response.auto_dbackup, 'auto_dbackup', 'escrot_auto_dbackup_freq_option');
		escrotUpdateToggle(response.enable_rest_api_key, 'enable_rest_api_key', 'escrot_rest_api_key_option');
		
    });
	
	 // Checkbox settings update toggle function
	function escrotUpdateToggle(responseValue, inputId, optionsContainer) {
		const toggleTextId = `${inputId}_on_off`; // Derive toggleTextId from inputId

		if (responseValue === true) {
			$(`#${inputId}`).prop('checked', true);
			$(`#${toggleTextId}`).html('<b class="toggleOn">'+escrot.swal.success.checkbox_on_text+'</b>');
			$(`#${optionsContainer}`).slideDown(); // Show the options
		} else {
			$(`#${inputId}`).prop('checked', false);
			$(`#${toggleTextId}`).html('<b class="toggleOff">'+escrot.swal.success.checkbox_off_text+'</b>');
			$(`#${optionsContainer}`).slideUp(); // Hide the options
		}
	}
	
	// Bootstrap Choices - Multiple Select Input ( multChoiceSelect() is defined in fnehd-admin.js )
	EscrotMultChoiceSelect({ selectID: 'rest_api_data', data: escrot.rest_api_data});
	EscrotMultChoiceSelect({ selectID: 'dispute_evidence_file_types', data: escrot.dispute_evidence_file_types});
	
	
    // Validate Email
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    // Validate Company Email
    $('body').on('blur', '#company_email', function() {
        var email = $('#company_email').val();
        if (email !== "" && !isEmail(email)) {
            $('#company_email').val("");
            $('#company_email_notice').html("Please Enter a valid email");
        } else {
            $('#company_email_notice').html("");
        }
    });

    // Force "Bitcoin Payment option to false if no API Key is Provided
    $('body').on('click', '#enable_bitcoin_payment', function() {
        if ($('#blockonomics_api_key').val() === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Blockonomics API Key Required!',
                text: "Blockonomics API Key is Required to Enable this feature. Please fill in the Required Field to Continue",
            });
            $('#enable_bitcoin_payment').prop('checked', false);
            $('#enable_bitcoin_payment_on_off').html('<b class="toggleOff">'+escrot.swal.success.checkbox_off_text+'</b>');
        } else {
            if ($('#enable_bitcoin_payment')[0].checked === true) {
                $('#enable_bitcoin_payment_on_off').html('<b class="toggleOn">'+escrot.swal.success.checkbox_on_text+'</b>');
            } else {
                $('#enable_bitcoin_payment_on_off').html('<b class="toggleOff">'+escrot.swal.success.checkbox_off_text+'</b>');
            }
        }
    });

    $('#blockonomics_api_key').on('blur', function() {
        if ($('#blockonomics_api_key').val() === '' && $('#enable_bitcoin_payment')[0].checked === true) {
            $('#enable_bitcoin_payment').prop('checked', false);
            $('#enable_bitcoin_payment_on_off').html('<b class="toggleOff">'+escrot.swal.success.checkbox_off_text+'</b>');
        }
    });

    // Show/hide SMTP password
    $('#toggleSmtpPass').on('click', function() {
        var passInput = $("#SMTPPass");

        if (passInput.attr('type') === 'password') {
            passInput.attr('type', 'text');
            $("#toggleSmtpPass").attr("class", "fas fa-eye sett-icon");
        } else {
            passInput.attr('type', 'password');
            $("#toggleSmtpPass").attr("class", "fas fa-eye-slash sett-icon");
        }
    });

    // If switch is on (On click), add toggleOn class, else add toggleOff class
    var options = [
        'user_new_escrow_email', 'user_new_milestone_email', 'admin_new_escrow_email', 'admin_new_milestone_email', 'notify_admin_by_email', 'fold_wp_menu', 'hide_wp_menu', 'hide_wp_admin_bar', 'hide_wp_footer', 'fold_escrot_menu', 'theme_class', 'dbackup_log', 'enable_paypal_payment', 'enable_rest_api', 'enable_rest_api_key', 'enable_dispute_evidence', 'enable_commissions_tax', 'enable_max_commission', 'enable_min_commission', 'enable_commissions_transparency', 'enable_commissions', 'enable_invoice_logo'
    ];

    for (var i = 0; i < options.length; i++) {
        $("#escrot-settings-panel").bind("click", { msg: options[i] }, function(e) {
            if ($("#" + e.data.msg)[0].checked === true) {
                $("#" + e.data.msg + "_on_off").html('<b class="toggleOn">'+escrot.swal.success.checkbox_on_text+'</b>');
            } else {
                $("#" + e.data.msg + "_on_off").html('<b class="toggleOff">'+escrot.swal.success.checkbox_off_text+'</b>');
            }
        });
    }

    // Checkbox toggle function
	function escrotCheckToggle({inputId, optionsContainerId}) {
		$("body").on("click", `#${inputId}`, function() {	
			const toggleTextId = `${inputId}_on_off`; // Derive toggleTextId from inputId

			if ($(`#${inputId}`)[0].checked === true) {
				$(`#${toggleTextId}`).html('<b class="toggleOn">'+escrot.swal.success.checkbox_on_text+'</b>');
				$(`#${optionsContainerId}`).slideDown(); // Show the options
			} else {
				$(`#${toggleTextId}`).html('<b class="toggleOff">'+escrot.swal.success.checkbox_off_text+'</b>');
				$(`#${optionsContainerId}`).slideUp(); // Hide the options
			}
		});
	}
	
	//show auto backup settings if on
	escrotCheckToggle({inputId: 'smtp_protocol', optionsContainerId: 'escrot-smtp-settings-options'});
	//show smtp protocol settings if on
	escrotCheckToggle({inputId: 'auto_dbackup', optionsContainerId: 'escrot_auto_dbackup_freq_option'});
	//show rest api key settings if on
	escrotCheckToggle({inputId: 'enable_rest_api_key', optionsContainerId: 'escrot_rest_api_key_option'});
	
	
	//show amount/percentage field depending selection
	function escrotFeeChange({ dropdownId, fixedFeeId, percentageId}) {
		$(`#${dropdownId}`).on("change", function () {
			const selectedValue = $(this).val();
			if (selectedValue === 'fixed_fee') {
				$(`#${fixedFeeId}`).show();
				$(`#${percentageId}`).hide();
			}
			if (selectedValue === 'percentage') {
				$(`#${percentageId}`).show();
				$(`#${fixedFeeId}`).hide();
			}
			if (selectedValue === 'percentage_amount') {
				$(`#${fixedFeeId}`).show();
				$(`#${percentageId}`).show();
			}
			if (selectedValue === 'no_fee') {
				$(`#${fixedFeeId}`).hide();
				$(`#${percentageId}`).hide();
			}
		});
		
		const selectedValue = $(`#${dropdownId}`).val();
		if (selectedValue === 'fixed_fee') {
			$(`#${fixedFeeId}`).show();
		}
		if (selectedValue === 'percentage') {
			$(`#${percentageId}`).show();
		}
		if (selectedValue === 'percentage_amount') {
			$(`#${percentageId}`).show();
			$(`#${fixedFeeId}`).show();
		}
	}
	escrotFeeChange({
		dropdownId: 'dispute_fees',
		fixedFeeId: 'escrot_dispute_fee_amount_option',
		percentageId: 'escrot_dispute_fee_percentage_option',
	});
	escrotFeeChange({
		dropdownId: 'commission_fees',
		fixedFeeId: 'escrot_commission_amount_option',
		percentageId: 'escrot_commission_percentage_option',
	});
	escrotFeeChange({
		dropdownId: 'commission_tax_fees',
		fixedFeeId: 'escrot_commission_tax_amount_option',
		percentageId: 'escrot_commission_tax_percentage_option',
	});
	escrotFeeChange({
		dropdownId: 'escrow_fees',
		fixedFeeId: 'escrot_escrow_fee_amount_option',
		percentageId: 'escrot_escrow_fee_percentage_option',
	});
	

   
    // Company Logo File uploader
	EscrotWPFileUpload("company_logo");

    // Color Picker
    const IDs = ["primary_color", "secondary_color"];

    IDs.forEach(id => {
        const colorPicker = document.getElementById(id);
        const textInput = document.getElementById(id + '_val');

        // Sync text input with color picker
        colorPicker.addEventListener('input', function() {
            textInput.value = colorPicker.value;
        });

        // Update color picker when text input changes
        textInput.addEventListener('input', function() {
            const color = textInput.value;
            if (/^#([0-9A-F]{3}){1,2}$/i.test(color)) { // Validate hex color code
                colorPicker.value = color;
            }
        });
    });

});
