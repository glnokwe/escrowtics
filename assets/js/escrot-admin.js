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
	
	//Restore DB From External File (Quick Restore)
	$("body").on('submit', "#RestoreDBForm", function(e){
		e.preventDefault();
		swal.fire({
		  title: 'Are you sure?',
			text: "Please make sure you choose the right file (use only backup files that were generated here), restoring a wrong file or interrupting the restore process will completely break things and lead to complete lost of data. Please note that already existing database tables will be destroyed. Cancel if you're not sure!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Yes, restore DB!',
		  }).then((result) => {
			if (result.value){
		  $.ajax({
		   type: 'POST',
		   url: ajaxurl,
		   data: new FormData(this),
		   contentType: false,
		   cache: false,
		   processData:false,
		   beforeSend: function () {
				$("#escrot-db-restore-modal").modal('hide');
				$("#escrot-loader").css("background-color", "#010e31d1");
				$("#escrot-loader").html('<h4 class="text-center text-success" id="progress-tle"></h4><div class="progress" id="progressAjax"><div class="progress-bar progress-bar-success" id="ProgressBar"></div> <div class="percent">0%</div> </div>');				
				$("#progress-tle").html('Uploading Database...');
			},
		   xhr: function() {//percentage loader
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
			if (evt.lengthComputable) {
			 var percentComplete = (evt.loaded / evt.total) * 100;
			var percentValue = percentComplete + '%';
			$("#ProgressBar").animate({
					width: '' + percentValue + ''
				}, {
					easing: "swing",
					step: function (x) {
						percentText = Math.round(x * 100 / percentComplete);
						$(".percent").text(percentText + "%");
						if(percentText == "100") {
						   $("#progress-tle").html('Upload Complete, Finalizing Restore..<span class="spinner-grow spinner-grow-sm" role="status" style="color: white;" aria-hidden="true">');
						}
					}
				});
		   }
		  }, false);
		  return xhr;
		},
		success: function(response) {
					if(response == "success"){
						
					  Swal.fire({icon: 'success', title: 'DB Restored successfully!', showConfirmButton: false, timer: 1500});
					  
					  $("#escrot-loader").css("background-color", "rgba(0, 0, 0, 0.5)");
					  $("#escrot-loader").html('<span class="spinner-border text-success h4" id="progress"></span><span id="SpinLoaderText" class="text-success h4"></span>');
					  $("#RestoreDBForm")[0].reset();
					  $("#ProgressBar").animate({width: 0}, {duration: 1})//reset ProgressBar
					  location.reload();
					} 					
				}   
		 
		 });//ajax
		}
	  });//then
	});


	//Export to Excel
	$("body").on("click", "#escrot-export-to-excel", function(e){
		e.preventDefault();
		var escrow_id = $('#escrot-admin-area-title').data('escrow-id'); 
		var action = $(this).data('action');
		swal.fire({
			title: 'Export to Excel?',
			text: "An Excel Sheet of your table will be created",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Yes, Download Excel!',
		}).then((result) => {
			if (result.value){
				
				var data = {'action':action, 'escrow_id':escrow_id,};
	
				$.post(escrot.ajaxurl, data, function(response) {
					var blob = new Blob([response.data], {type: 'application/vnd.ms-excel'});
					var downloadUrl = URL.createObjectURL(blob);
					var a = document.createElement("a");
					a.href = downloadUrl;
					a.download = "escrowtics-"+response.lable+"-"+Date.now()+".xls";
					document.body.appendChild(a);
					a.click();
		   
					Swal.fire({
						icon: 'success', 
						title: 'Excel Sheet Generated Successfully!', 
						showConfirmButton: false, 
						timer: 1500,
					});
				 
				});	
			}
		})
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
	if(urlParams.get('ticket_id')) { $("#EscrotSupportMenuItem").addClass('active'); }
	
	
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
	  $('[data-toggle="popover"]').popover()
	})
	

		
	/***********************Table 1 Multiple Selection*******************/

	
	$('body').on('click', '#escrot-select-all', function() {//If check-all is checked, then check all and count
		$('.escrot-checkbox').prop('checked', this.checked);
		$('#escrot-select-all2').prop('checked', this.checked);
		$('.escrot-selected').html($('input.escrot-checkbox:checked').length+' Selected');
	});
	
	$('body').on('click', '#escrot-select-all2', function() {//If check-all is checked, then check all and count
		$('.escrot-checkbox').prop('checked', this.checked);
		$('#escrot-select-all').prop('checked', this.checked);
		$('.escrot-selected').html($('input.escrot-checkbox:checked').length+' Selected');
	});
	
	$('body').on('click', '.escrot-checkbox', function() {
		//If all individual check boxes are checked, then also check check-all and count
		if ($('.escrot-checkbox:checked').length == $('.escrot-checkbox').length) {
			$('#escrot-select-all').prop('checked', true);
			$('#escrot-select-all2').prop('checked', true);
		} else {
			$('#escrot-select-all').prop('checked', false);
			$('#escrot-select-all2').prop('checked', false);
		}
		$('.escrot-selected').html($('input.escrot-checkbox:checked').length+' Selected');
	});
	
	
	
	/***********************Table 2 Multiple Selection*******************/
	
	$('body').on('click', '#escrot-select-all3', function() {//If check-all is checked, then check all and count
		$('.escrot-checkbox2').prop('checked', this.checked);
		$('#escrot-select-all4').prop('checked', this.checked);
		$('.escrot-selected2').html($('input.escrot-checkbox2:checked').length+' Selected');
	});

	
	$('body').on('click', '#escrot-select-all4', function() {//If check-all is checked, then check all and count
		$('.escrot-checkbox2').prop('checked', this.checked);
		$('#escrot-select-all3').prop('checked', this.checked);
		$('.escrot-selected2').html($('input.escrot-checkbox2:checked').length+' Selected');
	});
	
	$('body').on('click', '.escrot-checkbox2', function() {
		//If all individual check boxes are checked, then also check check-all and count
		if ($('.escrot-checkbox2:checked').length == $('.escrot-checkbox2').length) {
			$('#escrot-select-all3').prop('checked', true);
			$('#escrot-select-all4').prop('checked', true);
		} else {
			$('#escrot-select-all3').prop('checked', false);
			$('#escrot-select-all4').prop('checked', false);
		}
		$('.escrot-selected2').html($('input.escrot-checkbox2:checked').length+' Selected');
	});	
	
	//fold wp menu
    if(escrot.wpfold){
		document.body.className+=' folded';
	}

});


//Print Function
function printDiv(divName){
	
	var toPrint;
	toPrint = window.open();
	toPrint.document.write(document.getElementById(divName).innerHTML);
	toPrint.print();
	toPrint.close();
}
