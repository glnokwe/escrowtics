jQuery(($) => {
    // Cache common elements
    const $loader = $('#escrot-loader');
    const $body = $('body');
    const dialogs = [
        '#escrot-bitcoin-deposit-form-dialog',
        '#escrot-bitcoin-withdraw-form-dialog'
    ];

    // Show/hide global loader
    $(document)
        .ajaxStart(() => $loader.show())
        .ajaxStop(() => $loader.hide());

    // Scroll to both dialogs when “Pay with Bitcoin” clicked
    $body.on('click', '#escrot-bitcoin-pay', (e) => {
        e.preventDefault();
        dialogs.forEach(sel =>
            $('html, #escot_front_wrapper').animate(
                { scrollTop: $(sel).offset().top },
                'slow'
            )
        );
    });

    // Initialize Bootstrap popovers (and re-init after any collapse)
    const initPopovers = () =>
        $('[data-toggle="popover"]').popover({ container: 'body' });
    initPopovers();
    $body.on('shown.bs.collapse', initPopovers);
	
	
	//Reload User Account
	function reloadUser(){
		$.ajax({	
			url: escrot.ajaxurl,
			type: "POST",
			data: {'action':'escrot_reload_user_account',},
			success: function(response) {
				$("#escrot-edit-account").html(response.data);
			}
		});
	}

    // Generic form-submit handler
    const formConfigs = {
        '#escrot-user-login-form': { redirect: true },
        '#escrot-user-signup-form': { redirect: true },
        '#escrot-bitcoin-deposit-form': { invoice: 'bitcoin_deposit' },
        '#escrot-bitcoin-withdraw-form': { invoice: 'bitcoin_withdraw' },
        '#escrot-manual-deposit-form': { invoice: 'manual_deposit' },
        '#escrot-paypal-withdraw-form': { invoice: 'paypal_withdraw' },
        '#escrot-edit-user-form': { confirmText: escrot.swal.user.update_confirm, reloadUser: true },
        '#EditEscrotUserPassForm': { confirmText: escrot.swal.user.update_pass_confirm, reloadPage: true }
    };

    Object.entries(formConfigs).forEach(([sel, opts]) => {
        $body.on('submit', sel, async (e) => {
            e.preventDefault();
            const submit = async () => {
                const data = ($(e.target).attr('enctype') === 'multipart/form-data')
                    ? new FormData(e.target)
                    : $(e.target).serialize();

                try {
                    const res = await $.ajax({
                        url: escrot.ajaxurl,
                        method: 'POST',
                        data,
                        contentType: data instanceof FormData ? false : undefined,
                        processData: data instanceof FormData ? false : undefined
                    });

                    if (!res.success) throw res;

                    Swal.fire({ icon: 'success', title: res.data.message, timer: 1500, showConfirmButton: false });

                    if (opts.redirect) {
                        window.location.href = res.data.redirect;
                    } else if (opts.invoice) {
                        const url = $(`${sel}`).data('invoice-url');
                        window.location = `${url}?endpoint=${opts.invoice}_invoice&code=${res.data.code}`;
                    } else if (opts.reloadUser) {
                        reloadUser();
                    } else if (opts.reloadPage) {
                        location.reload();
                    }
                } catch (err) {
                    Swal.fire({ icon: 'error', title: err.data?.message || err.response?.status || 'Error' });
                }
            };

            if (opts.confirmText) {
                Swal.fire({
                    title: escrot.swal.warning.title,
                    text: escrot.swal.warning.text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: opts.confirmText
                }).then(result => result.value && submit());
            } else {
                submit();
            }
        });
    });

    // Front-nav logout
    $body.on('click', '#EscrotLogOutFrontNavItem', (e) => {
        e.preventDefault();
        Swal.fire({
            title: escrot.swal.warning.title,
            text: escrot.swal.warning.text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: escrot.swal.user.logout_confirm
        }).then(result => {
            if (result.value) {
                $.post(escrot.ajaxurl, { action: 'escrot_user_logout' }, (res) => {
                    if (res.success) {
                        Swal.fire({ icon: 'success', title: res.data.message, timer: 1500, showConfirmButton: false })
                            .then(() => location.reload());
                    }
                });
            }
        });
    });

    // Manual payment “Other” select toggle
    ['deposit', 'withdraw'].forEach(type => {
        $(`#escrot-manual-${type}-payment-select`).on('change', function () {
            $(`#escrot-manual-${type}-other-payment`)[this.value === 'Other' ? 'slideDown' : 'slideUp']();
        });
    });

    // PayPal deposit form logic
    const $depositForm = $('#escrot-paypal-deposit-form');
    const $paypalButton = $('#paypal-button-container');
    const $amtDisplay = $('#escrot-paypal-deposit-amt');
    const $changeAmtBtn = $('#escrot-change-amount-btn');

    if ($depositForm.length) {
        $depositForm.on('submit', (e) => {
            e.preventDefault();
            const val = parseFloat($depositForm.find('[name="amount"]').val()) || 0;
            if (val <= 0) return alert('Please enter a valid amount.');

            // toggle views
            $depositForm.hide();
            $paypalButton.show();
            $amtDisplay.text(escrot.currency + val.toLocaleString());
            $changeAmtBtn.show();

            EscrotLoadPaypalButton(val.toFixed(2));
        });

        $changeAmtBtn.on('click', () => {
            $depositForm.show();
            $paypalButton.empty().hide();
            $amtDisplay.empty();
            $changeAmtBtn.hide();
        });
    }
});


// Show/hide password toggle
document.addEventListener('DOMContentLoaded', EscrotInitShowHidePassword);
