 jQuery(document).ready(function($) {

    // Function - Setup DataTable
    function setDataTable(extraData = []) {
        const columns = [
            { data: 0, orderable: false, render: (data, type, row) => row[0].check_box },
            { data: null, orderable: false, render: (data, type, row, meta) => meta.row + 1 + meta.settings._iDisplayStart },
            { data: 2 },
            { data: 3 },
            { data: 4 },
            { data: 5 },
            { data: 6, orderable: false, className: 'dt-center', render: (data, type, row) => row[6].actions }
        ];
        EscrotInitDataTable('#escrot-dbbackup-table', 'escrot_dbbackup_datatable', 5, columns, 2, escrot.dbbackup_log_state, extraData);
        EscrotSetDataTableOptionsBtn();
    }

    // Display Backups
	if (new URLSearchParams(window.location.search).get('page') === "escrowtics-db-backups") {
        displayBackups();
    }
	// Function - Display Backups
    function displayBackups() {
        const data = { action: 'escrot_display_dbbackups' };
        $.post(ajaxurl, data, function(response) {
            $("#escrot-admin-container").html(response);
            setDataTable();
        });
    }

    // Function - Reload Backups Table
    function reloadDbBackups() {
        const data = { action: 'escrot_dbbackups_tbl' };
        $.post(ajaxurl, data, function(response) {
            $("#tableDataDBBackup").html(response);
            setDataTable();
        });
    }


    // Event - Backup Database
    $("body").on("click", "#BackupDB", function(e) {
        e.preventDefault();
        EscrotShowAlert({
            title: escrot.swal.warning.title,
            text: escrot.swal.dbbackup.backup_text,
            icon: 'success',
            confirmButtonText: escrot.swal.dbbackup.backup_confirm,
            confirmCallback: function() {
                const data = { action: 'escrot_dbbackup' };
                $.post(ajaxurl, data, function(response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: response.data.message, showConfirmButton: false, timer: 1500 });
                        reloadDbBackups();
                    }
                });
            }
        });
    });
	
	
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
						console.error( escrot.swal.dbbackup.restore_fail_title, response);
					}
				},
				error: function () {
					console.error(escrot.swal.dbbackup.restore_poll_fail_text);
				},
			});
		}

		requestAnimationFrame(update);
	}
	

    // Event - Restore Database
	$("body").on("click", ".restoreDB", function (e) {
		e.preventDefault();
		var BkUpFile = $(this).attr("id");

		swal.fire({
			title: escrot.swal.warning.title,
			text: escrot.swal.warning.db_restore_text,
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: escrot.swal.dbbackup.restore_confirm,
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: escrot.ajaxurl,
					data: { action: "escrot_dbrestore", BkupfileName: BkUpFile },
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




    // Event - Delete Single Backup
    $("body").on("click", ".deleteDB", function(e) {
        e.preventDefault();
        const backupId = $(this).attr('id');
        const backupPath = $(this).data('bkup-path');
        const row = $(this).closest('tr');

        EscrotShowAlert({
            title: escrot.swal.warning.title,
            text: escrot.swal.warning.text,
            icon: 'warning',
            confirmButtonText: escrot.swal.dbbackup.delete_confirm,
            confirmCallback: function() {
                const data = { action: 'escrot_del_dbbackup', deleteDBid: backupId, DBpath: backupPath };
                $.post(ajaxurl, data, function(response) {
                    row.css('background-color', '#ff6565');
                    Swal.fire({ icon: 'success', title: response.data.message, showConfirmButton: false, timer: 1500 });
                    reloadDbBackups();
                });
            }
        });
    });

    // Event - Delete Multiple Backups
    $(document).on('click', '.escrot-mult-delete-btn', function() {
        const selectedBackups = $(".escrot-checkbox:checked").map((_, el) => $(el).data('escrot-row-id')).get();
        const selectedPaths = $(".escrot-checkbox:checked").map((_, el) => $(el).data('bkup-path')).get();

        if (selectedBackups.length === 0) {
            Swal.fire({ icon: 'warning', title: escrot.swal.warning.no_records_title, text: escrot.swal.warning.no_records_text });
        } else {
            EscrotShowAlert({
                title: escrot.swal.warning.title,
                text: escrot.swal.warning.text,
                icon: 'warning',
                confirmButtonText: `${selectedBackups.length > 1 ? escrot.swal.warning.delete_records_confirm : escrot.swal.warning.delete_record_confirm}`,
                confirmCallback: function() {
                    const data = { action: 'escrot_del_dbbackups', multDBid: selectedBackups.join(","), multDBpath: selectedPaths.join(",") };
                    $.post(ajaxurl, data, function() {
                        selectedBackups.forEach(id => $(`#${id}`).css('background-color', '#ff6565'));
                        Swal.fire({ 
						icon: 'success', 
						title: `${selectedBackups.length > 1 ? escrot.swal.dbbackup.backup_plural : escrot.swal.dbbackup.backup_singular} `+escrot.swal.success.delete_success,
						text: `${selectedBackups.length > 1 ? escrot.swal.dbbackup.backup_plural_deleted : escrot.swal.dbbackup.backup_singular_deleted} `,
						showConfirmButton: false, timer: 1500 });
                        reloadDbBackups();
                    });
                }
            });
        }
    });
    
	
});
