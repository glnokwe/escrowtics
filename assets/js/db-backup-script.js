

jQuery(document).ready(function($){

    function setDataTable(){
		
		/* dataTable options */
	    var t = $('#escrot-db-backup-table').DataTable( {
			retrieve: true,
            'columnDefs': [ {
                'searchable': true,
                'orderable': false,
                'targets': 1
            } ],
            'order': [[ 1, 'asc' ]]
        } );
		
        //DataTable Numbering
        t.on( 'order.dt search.dt', function () {
           t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
           } );
        } ).draw();
    
       /*Table options Button*/
       $('.btndiv').hide(); //hides dropdown content
       $('#option1').show(); //unhides first option content
	   
       $('#track-list-actions').change(function(){ //listen to dropdown for change
          $('.btndiv').hide();//rehide content on change
          $('#'+$(this).val()).show();//unhides current item
       });
  
       $('.btndiv2').hide(); //hides dropdown content
       $('#option1a').show(); //unhides first option content
    
       $('#track-list-actions2').change(function(){ //listen to dropdown for change
         $('.btndiv2').hide(); //rehide content on change
         $('#'+$(this).val()).show(); //unhides current item
       });
		
		
	}
	
	
	
	
	//Display All Available Backups  
    displayBackups();
 
    function displayBackups(){
	    var data = {
			'action':'escrot_display_dbbackups',
		};
		$.post(ajaxurl, data, function(response) {
			 $("#escrot-admin-container").html(response);
			 setDataTable();
		});
    }  
	
	
	
	//Display All Available Backups 
    function reloadDbBs(){
	    var data = {
			'action':'escrot_dbbackups_tbl',
		};
		$.post(ajaxurl, data, function(response) {
			 $("#tableDataDbBackup").html(response);
			 setDataTable();
		});
    } 
	
	
	//Backup Database 
    $("body").on("click", "#BackupDB", function(e){
         e.preventDefault();
    		swal.fire({
    		  	title: 'Backup Database?',
    		  	text: "A Backup copy of your database will be created. Note: only escrowtics tables will be included into this backup not the whole database",
    		  	icon: 'success',
    		  	showCancelButton: true,
    		  	confirmButtonColor: '#4caf50',
    		  	cancelButtonColor: '#3085d6',
    		  	confirmButtonText: 'Yes, Create Backup!',
    		}).then((result) => {
    		  	if (result.value){
					
		          var data = {'action':'escrot_dbbackup',};
	
		          $.post(ajaxurl, data, function(response) {
		            if(response == "success"){ 
                        Swal.fire({
						  icon: 'success', 
						  title: 'Database Backup Created Successfully!', 
						  showConfirmButton: false, 
		                  timer: 1500,
						});
					  reloadDbBs();
					}
	  	         
				 });	
    		}
    	})
    });	
	
	
	
	//Restore Database (Server-side File, No File Upload)
    $("body").on("click", ".restoreDB", function(e){
            e.preventDefault();
		    var BkUpFile = $(this).attr('id');
    		swal.fire({
    		  title: 'Are you sure?',
    		  	text: "Make sure you have a backup copy of the current database before proceeding. Please note that already existing database tables (Escrowtics Plugin tables) will be dropped and replaced. Cancel if you're not sure!",
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
                   data: {action: 'escrot_dbrestore', BkupfileName:BkUpFile},
           
		           beforeSend: function () {
					  $("#escrot-loader").css("background-color", "#010e31d1");
				      $("#escrot-loader").html('<h4 class="text-center text-success" id="progress-tle"></h4><div class="progress"   id="progressAjax"><div class="progress-bar progress-bar-success" id="ProgressBar"></div> <div   class="percent">0%</div> </div>');				
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
                        	           $("#progress-tle").html('Upload Complete, Finalizing Restore <span class="spinner-grow spinner-grow-sm" role="status" style="color: white;" aria-hidden="true">');
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
						   $("#escrot-loader").html('<span class="spinner-border text-success h4" id="progress"></span><span  id="SpinLoaderText" class="text-success h4"></span>');
					       $("#ProgressBar").animate({width: 0}, {duration: 1})//reset ProgressBar
						  
                           location.reload();
                        } 					
			        }   
			 
                });
		   
    		}
    	})
    });	
	
	
	
	 //Delete DB Backup Record
    $("body").on("click", ".deleteDB", function(e){
			
         e.preventDefault();
    		 var tr = $(this).closest('tr');
             var deleteDBid = $(this).attr('id');
			 var bkup_path = $(this).data('bkup-path');
     
    		swal.fire({
    		  	title: 'Are you sure?',
    		  	text: "You won't be able to revert this!",
    		  	icon: 'warning',
    		  	showCancelButton: true,
    		  	confirmButtonColor: '#d33',
    		  	cancelButtonColor: '#3085d6',
    		  	confirmButtonText: 'Yes, delete Backkup!',
    		}).then((result) => {
    		  	if (result.value){
			  
			        var data = {
			            'action':'escrot_del_dbbackup',
		                'deleteDBid':deleteDBid,
						'DBpath':bkup_path,
		            };
		
		            $.post(ajaxurl, data, function(response) {
                        tr.css('background-color','#ff6565');
                        Swal.fire({
                           icon: 'success',
                           title: 'DB Backup deleted successfully', 
						   showConfirmButton: false, 
		                   timer: 1500,
                        });
                        reloadDbBs();
		            });
    		    }
     
    	   })
    });
	
	
  
    //Delete Multiple DB Backups
    $(document).on('click', '#delete_db_records', function() {
		
		var DBBackup = [];
		$(".escrot-checkbox:checked").each(function() {
			DBBackup.push($(this).data('escrot-row-id'));
		});
		
		var DBBackupPath = [];
		$(".escrot-checkbox:checked").each(function() {
			DBBackupPath.push($(this).data('bkup-path'));
		});
		
		if(DBBackup.length <=0) {
			 Swal.fire({
                     icon: 'warning',
                     title: 'No Record Selected.',
					 text: "Please select atleast 1 DB Backup to continue!",
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
    		  	confirmButtonText: 'Yes, delete '+(DBBackup.length>1?'custom fields':'custom field')+'!',
    		}).then((result) => {
    		  	if (result.value){	
				
				var selected_backups = DBBackup.join(",");
				var selected_bkup_paths = DBBackupPath.join(",");
				
				var data = {
			            'action':'escrot_del_dbbackups',
		                'multDBid':selected_backups,
						'multDBpath':selected_bkup_paths,
		            };
		
		            jQuery.post(ajaxurl, data, function(response) {
                        var multDBids = selected_backups.split(",");
	  
						for (var i=0; i < multDBids.length; i++ ) {	
							$("#"+multDBids[i]).css('background-color','#ff6565'); 
							Swal.fire({
                               icon: 'success',
                               title: ''+(DBBackup.length>1?'DB Backups':'DB Backup')+' deleted successfully',
							   text: ''+(DBBackup.length)+' '+(DBBackup.length>1?'Records':'Record')+' Deleted!',
							   showConfirmButton: false, 
		                       timer: 1500,
                            });
                            reloadDbBs();
						}	
		            });
				
			} 
		}) //swal.fire end
		}
    });
	
	
	
	/*********************** Multiple selection scripts ****************************/
	
	//If check_all is checked, then check all and count
    $('body').on('click', '#select_all', function() {
	    $(".escrot-checkbox").prop("checked", this.checked);
	    $("#select_all2").prop("checked", this.checked);
	    $(".escrot-selected").html($("input.escrot-checkbox:checked").length+" Selected");
    });

    //If check_all is checked, then check all and count
    $('body').on('click', '#select_all2', function() {
	    $(".escrot-checkbox").prop("checked", this.checked);
	    $("#select_all").prop("checked", this.checked);
	    $(".escrot-selected").html($("input.escrot-checkbox:checked").length+" Selected");
    });

    //If all individual check boxes are checked, then also check check_all and count
    $('body').on('click', '.escrot-checkbox', function() {
	    if ($('.escrot-checkbox:checked').length == $('.escrot-checkbox').length) {
	    $('#select_all').prop('checked', true);
	    $('#select_all2').prop('checked', true);
	    } else {
	    $('#select_all').prop('checked', false);
	    $('#select_all2').prop('checked', false);
	    }
	    $(".escrot-selected").html($("input.escrot-checkbox:checked").length+" Selected");
    });
	
	
	
	
	
	
	
	
   });