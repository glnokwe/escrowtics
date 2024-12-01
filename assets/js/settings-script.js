jQuery(document).ready(function($) {
    // Update settings
    $("body").on("click", "#escrot-submit-settings", function() {
        $('#SpinLoaderText').html("Saving..Please Wait!");
    });

    $('#escrot-options-form').submit(function() {
        $(this).ajaxSubmit({
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Settings updated successfully',
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
	$("body").on("click", "#expSett", function () {
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
					title: response.data,
				});
			} else {
				// Show error message if the export fails
				Swal.fire({
					icon: "error",
					title: "Error",
					text: response.data || "An error occurred while exporting options.",
				});
			}
		}).fail(function (jqXHR, textStatus, errorThrown) {
			// Handle AJAX failure
			Swal.fire({
				icon: "error",
				title: "Request Failed",
				text: `Error: ${textStatus}. ${errorThrown}`,
			});
		});
	});


    // Import settings
    $("body").on("click", "#imp_options_btn", function() {
        $('#SpinLoaderText').html("<strong>Importing Options..Please Wait!</strong>");
    });

    $("#escrot-options-imp-form").on('submit', function(e) {
        e.preventDefault();
        swal.fire({
            title: 'Are you sure?',
            text: "Please make sure you choose the right file (use only export files that were generated here). Importing a wrong file will lead to complete loss of data. Cancel if you're not sure!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, import options!',
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
                                title: response.data.message,
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
                                title: 'Options File Corrupted or Incompatible!',
                            });
                        }
                    }
                });
            }
        });
    });

    // Restore settings defaults
    $("body").on("click", "#resetSett", function() {
        swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to reset all settings to default? Cancel if you're not sure!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, restore defaults!',
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
					title: "Error",
					text: response.data || "An error occurred while exporting options.",
				});
			}
        });
    });

    // Generate REST API Key & URL
    const ids = ["rest_api_key", "rest_api_enpoint_url"];
    ids.forEach(ID => {
        $("body").on("click", "#escrot_" + ID + "_generator", function(e) {
            e.preventDefault();
            var data = { 'action': 'generate_escrot_' + ID };

            $.post(ajaxurl, data, function(response) {
                if (response.success) {
                    if (ID === 'rest_api_enpoint_url') {
                        let api_key = $('#rest_api_key').val();
                        $('#' + ID).val(response.data.url + api_key); // Append API key to the URL
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
                        title: 'Error',
                        text: response.data ? response.data.message : 'An error occurred while processing your request.',
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
        var image_path = response.company_logo;

        // If company logo, replace default avatar with it, then add "Change" & "Remove" buttons
        if (image_path !== "") {
            $(".company_logo-FilePrv").attr("class", "fileinput-new thumbnail");
            $(".company_logo-PrevUpload").attr("src", image_path);
            $(".company_logo-AddFile").css("display", "none");
            $(".company_logo-ChangeFile").css("display", "inline");
            $(".company_logo-dismissPic").css("display", "inline");
        }

        // Check if setting is "ON" and perform other actions
        if (response.smtp_protocol === 1) {
            $('#smtp_protocol').prop('checked', true);
            $('#SmtpSetup').slideDown(); // Disable SMTP Setup Options
        } else {
            $('#smtp_protocol').prop('checked', false);
            $('#SmtpSetup').slideUp(); // Enable/Show SMTP Setup Options
        }

        if (response.auto_dbackup === 1) {
            $('#auto_dbackup').prop('checked', true);
            $('.auto_db_freq').slideDown();
        } else {
            $('#auto_dbackup').prop('checked', false);
            $('.auto_db_freq').slideUp();
        }

        if (response.auto_trkgcode === 1) {
            $('#auto_trkgcode').prop('checked', true);
            $('.trkgcode_length').slideDown();
            $('.trkgcode_xter_type').slideDown();
            $('.auto_tcode_with_prefix').slideDown();
            $('.auto_tcode_with_suffix').slideDown();
        } else {
            $('#auto_trkgcode').prop('checked', false);
            $('.trkgcode_length').slideUp();
            $('.trkgcode_xter_type').slideUp();
            $('.auto_tcode_with_prefix').slideUp();
            $('.auto_tcode_with_suffix').slideUp();
        }
    });

    // Bootstrap Choices - Multiple Select Input
    var multipleCancelButton = new Choices('#rest_api_data', {
        removeItemButton: true,
        renderChoiceLimit: 15
    });
    var selectedValues = escrot.rest_api_data; // Get REST API Data Options
    selectedValues.forEach(function(value) {
        multipleCancelButton.setChoiceByValue(value);
    });

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
            $('#enable_bitcoin_payment_on_off').html('<b class="toggleOff">OFF</b>');
        } else {
            if ($('#enable_bitcoin_payment')[0].checked === true) {
                $('#enable_bitcoin_payment_on_off').html('<b class="toggleOn">ON</b>');
            } else {
                $('#enable_bitcoin_payment_on_off').html('<b class="toggleOff">OFF</b>');
            }
        }
    });

    $('#blockonomics_api_key').on('blur', function() {
        if ($('#blockonomics_api_key').val() === '' && $('#enable_bitcoin_payment')[0].checked === true) {
            $('#enable_bitcoin_payment').prop('checked', false);
            $('#enable_bitcoin_payment_on_off').html('<b class="toggleOff">OFF</b>');
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
        "user_new_escrow_email", "user_new_milestone_email", "admin_new_escrow_email", "admin_new_milestone_email", "notify_admin_by_email", "fold_wp_menu", "fold_escrot_menu", "theme_class", "dbackup_log", "enable_paypal_payment", "enable_rest_api", "enable_rest_api_key"
    ];

    for (var i = 0; i < options.length; i++) {
        $("#escrot-settings-panel").bind("click", { msg: options[i] }, function(e) {
            if ($("#" + e.data.msg)[0].checked === true) {
                $("#" + e.data.msg + "_on_off").html('<b class="toggleOn">ON</b>');
            } else {
                $("#" + e.data.msg + "_on_off").html('<b class="toggleOff">OFF</b>');
            }
        });
    }

    $("body").on("click", "#smtp_protocol", function() {
        if ($("#smtp_protocol")[0].checked === true) {
            $("#smtp_protocol_on_off").html('<b class="toggleOn">ON</b>');
            $('#SmtpSetup').slideDown();
        } else {
            $("#smtp_protocol_on_off").html('<b class="toggleOff">OFF</b>');
            $('#SmtpSetup').slideUp();
        }
    });

    $("body").on("click", "#auto_dbackup", function() {
        if ($("#auto_dbackup")[0].checked === true) {
            $("#auto_dbackup_on_off").html('<b class="toggleOn">ON</b>');
            $('.auto_db_freq').slideDown();
        } else {
            $("#auto_dbackup_on_off").html('<b class="toggleOff">OFF</b>');
            $('.auto_db_freq').slideUp();
        }
    });

    // Company Logo File uploader
    $(document).on('click', '.company_logo', function(e) {
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
            $(".company_logo-FileInput").val(attachment.url);
            $(".company_logo-FilePrv").removeClass("img-circle");
            $(".company_logo-PrevUpload").attr("src", "" + attachment.url + "");
            $(".company_logo-AddFile").css("display", "none");
            $(".company_logo-ChangeFile").css("display", "inline");
            $(".company_logo-dismissPic").css("display", "inline");
        });

        file_frame.open();
    });

    // Reset upload field
    $("body").on("click", ".company_logo-dismissPic", function() {
        $(".company_logo-ChangeFile").css("display", "none");
        $(".company_logo-AddFile").css("display", "inline");
        $(".company_logo-dismissPic").css("display", "none");
        $(".company_logo-PrevUpload").attr("src", '');
    });

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
