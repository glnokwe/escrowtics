jQuery(document).ready(function($){
	
	
	if( ("#escrot-settings-panel").length ){
		//remove WP table wrap arround setting options
		$("#escrot-settings-panel tr").not('.escrot-tr').replaceWith(function() { return $(this).contents();});
		$("#escrot-settings-panel td").not('.escrot-td').replaceWith(function() { return $(this).contents();});
		$("#escrot-settings-panel th").not('.escrot-th').replaceWith(function() { return $(this).contents();});
		$("#escrot-settings-panel table").not('.escrot-tbl').replaceWith(function() { return $(this).contents();});
		$("#escrot-settings-panel tbody").not('.escrot-tbody').replaceWith(function() { return $(this).contents();});
		$("#escrot-settings-panel h2").not('.escrot-h2').replaceWith(function() { return $(this).contents();});
	};
	
	//Collapse DIvs Scripts
	$('body').on('shown.bs.collapse', function () {
		$(function () {
			$('[data-toggle="popover"]').popover({
				container: 'body'
			});
		});
	});

	//Ajax Loader
	let activeAjaxCalls = 0;
	let isTabActive = true;// Track page/tab visibility
	document.addEventListener('visibilitychange', function() {//Detect when the tab is active or inactive
		isTabActive = !document.hidden;
	});
	$(document).ajaxStart(function() {
		activeAjaxCalls++;
		if (activeAjaxCalls === 1 && isTabActive) {
			$('#escrot-loader').show();
		}
	});
	$(document).ajaxStop(function() {
		activeAjaxCalls = 0; 
		if (isTabActive) {
			$('#escrot-loader').hide();
		}
	});

	//Optional: Ensure the loader is hidden if the user returns after the event is completed
	document.addEventListener('visibilitychange', function() {
		if (isTabActive && activeAjaxCalls === 0) {
			$('#escrot-loader').hide();
		}
	});
		
	//Focus on DB Restore Form
	$('body').on('click', '#EscrotQuikResDB', function () {
		$("html, .escrot-main-panel").animate({scrollTop: $('.escrot-admin-forms').offset().top}, 'slow'); 
	});	 
	
	

	//Remove Wp Default Form Style
	$("body").removeClass("wp-core-ui select"); 


	//Highlight Active Navbar Link
	$('.escrot-nav-link').each(function(){
		if ($(this).prop('href') == window.location.href) {
			$(this).addClass('active'); 
			$(this).parents('li').addClass('active');
		} else 
		{ 
		  $(this).removeClass('active'); 
		}
	});
	//Get URL Token value for user_id & SA_id (GET Response)
	var urlParams = new URLSearchParams(window.location.search);
	if(urlParams.get('user_id')) { $("#EscrotUserMenuItem").addClass('active'); }
	if(urlParams.get('escrow_id')) { $("#EscrotEscrowMenuItem").addClass('active'); }
	if(urlParams.get('dispute_id')) { $("#EscrotSupportMenuItem").addClass('active'); }
	
	
	//Minimize Sidebar 	
	$("body").on('click', '#minimizeSidebar', function() {
	 $("#bodyWrapper").toggleClass("sidebar-mini"); 
	}); 


	//Minimize Sidebar 	
	$("body").on('click', '.navbar-toggler', function() {	  
	 $("html").toggleClass("nav-open"); 
	}); 

	//Theme toggle button 		
	$("#bodyWrapper").on('click', '#ToggleLightMode', function() {
		$("#bodyWrapper").removeClass("dark-edition");
		$("#ToggleLightMode").attr("id", "ToggleDarkMode");
		$("#ToggleDarkMode").html('<i class="text-dark escrot-nav-icon fa fa-moon"></i>');
	});
	$("#bodyWrapper").on('click', '#ToggleDarkMode', function() {
		$("#bodyWrapper").addClass("dark-edition");
		$("#ToggleDarkMode").attr("id", "ToggleLightMode");
		$("#ToggleLightMode").html('<span class="text-light">'+escrot.light_svg+'</span>');
	});
	
	 $("#bodyWrapper").on('click', '#ToggleLightModeMbl', function() {
		$("#bodyWrapper").removeClass("dark-edition");
		$("#ToggleLightModeMbl").attr("id", "ToggleDarkModeMbl");
		$("#ToggleDarkModeMbl").html('<i class="text-dark escrot-nav-icon fa fa-moon"></i>');
	});
	$("#bodyWrapper").on('click', '#ToggleDarkModeMbl', function() {
		$("#bodyWrapper").addClass("dark-edition");
		$("#ToggleDarkModeMbl").attr("id", "ToggleLightModeMbl");
		$("#ToggleLightModeMbl").html('<span class="text-light">'+escrot.light_svg+'</span>');
	});


	//Initiate Bootstrap Popover
	$(function () {
		$('[data-toggle="popover"]').popover({
			container: 'body'
		});
	});
		
	
	
	//DataTable Checkbox multiselect	
	function escrotMultiSelect({
		checkAllId,
		checkAllAltId,
		checkboxClass,
		selectedCountClass,
	}) {
		// Handle "Select All" checkbox click
		$('body').on('click', `#${checkAllId}, #${checkAllAltId}`, function () {
			const isChecked = this.checked;
			$(`.${checkboxClass}`).prop('checked', isChecked);
			$(`#${checkAllId}, #${checkAllAltId}`).prop('checked', isChecked);
			$(`.${selectedCountClass}`).html($(`input.${checkboxClass}:checked`).length +' '+ escrot.swal.success.checkbox_select_title);
		});

		// Handle individual checkbox click
		$('body').on('click', `.${checkboxClass}`, function () {
			const allChecked = $(`.${checkboxClass}:checked`).length === $(`.${checkboxClass}`).length;
			$(`#${checkAllId}, #${checkAllAltId}`).prop('checked', allChecked);
			$(`.${selectedCountClass}`).html($(`input.${checkboxClass}:checked`).length +' '+ escrot.swal.success.checkbox_select_title);
		});
	}
	escrotMultiSelect({
		checkAllId: 'escrot-select-all',
		checkAllAltId: 'escrot-select-all2',
		checkboxClass: 'escrot-checkbox',
		selectedCountClass: 'escrot-selected',
	});
	escrotMultiSelect({
		checkAllId: 'escrot-select-all3',
		checkAllAltId: 'escrot-select-all4',
		checkboxClass: 'escrot-checkbox2',
		selectedCountClass: 'escrot-selected2',
	});
	
	//fold wp menu
    if(escrot.wpfold){
		document.body.className+=' folded';
	}
	
	
	// Function - Restore Progress Poll
	function escrotRestorePollProgress() {
		function update() {
			$.ajax({
				type: "POST",
				url: escrot.ajaxurl,
				data: { action: "escrot_dbrestore_progress" },
				success: function (response) {
					if (response.success) {
						const { percent_complete, message, completed } = response.data;

						$("#ProgressBar").css("width", `${percent_complete}%`).attr("aria-valuenow", percent_complete);
						$(".percent").text(`${percent_complete}%`);
						$("#progress-tle").text(message);

						if (!completed) {
							requestAnimationFrame(update); // Schedule the next update
						} else {
							Swal.fire({
							   icon: 'success',
							   title: response.data.message,
							   showConfirmButton: false, 
							});
							location.reload();
						}
					} else {
						console.error(escrot.swal.dbbackup.restore_fail_title, response);
					}
				},
				error: function () {
					console.error(escrot.swal.dbbackup.restore_poll_fail_text);
				},
			});
		}

		requestAnimationFrame(update);
	}

    // Event - Restore Database from uploaded file (Quick Restore)
	$("body").on('submit', "#RestoreDBForm", function(e){
		e.preventDefault();
		var BkUpFile = $(this).attr("id");

		swal.fire({
			title: escrot.swal.warning.title,
			text: escrot.swal.warning.db_file_restore_text,
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: escrot.swal.dbbackup.restore_confirm,
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'POST',
					url: escrot.ajaxurl,
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					beforeSend: function () {
						$("#escrot-loader").css("background-color", "#010e31d1");
						$("#escrot-loader").html(`
							<h4 class="text-center text-success" id="progress-tle">`+escrot.swal.dbbackup.restore_init_text+`</h4>
							<div class="progress" id="progressAjax">
								<div class="progress-bar progress-bar-success" id="ProgressBar"></div>
								<div class="percent text-dark">0%</div>
							</div>
						`);
					},
					success: function (response) {
						if (response.success) {
							escrotRestorePollProgress(); // Begin polling for progress
						} else {
							Swal.fire(escrot.swal.warning.error_title, response.data.message, "error");
						}
					},
					error: function () {
						Swal.fire({
							icon: "error",
							title: escrot.swal.dbbackup.restore_fail_title,
							text: escrot.swal.dbbackup.restore_fail_text,
						});
					},
				});
			}
		});
	});
	
	
	//Export to Excel
	$("body").on("click", "#escrot-export-to-excel", function(e){
		e.preventDefault();
		var escrow_id = $('#escrot-admin-area-title').data('escrow-id'); 
		var action = $(this).data('action');
		swal.fire({
			title: escrot.swal.warning.export_excel_title,
			text: escrot.swal.warning.export_excel_text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: escrot.swal.warning.export_excel_confirm,
		}).then((result) => {
			if (result.value){
				
				var data = {'action':action, 'escrow_id':escrow_id,};
	
				$.post(escrot.ajaxurl, data, function(response) {
					var blob = new Blob([response.data], {type: 'application/vnd.ms-excel'});
					var downloadUrl = URL.createObjectURL(blob);
					var a = document.createElement("a");
					a.href = downloadUrl;
					a.download = "escrowtics-"+response.label+"-"+Date.now()+".xls";
					document.body.appendChild(a);
					a.click();
		   
					Swal.fire({
						icon: 'success', 
						title: escrot.swal.success.export_excel_success, 
						showConfirmButton: false, 
						timer: 1500,
					});
				 
				});	
			}
		})
	});
	


});

