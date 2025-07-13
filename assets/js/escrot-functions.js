// Plugin-wide JS functions
// @since 1.0.0
// @package Fnehousing

let customerID;

// Helper for AJAX requests
async function ajaxFetch(action, payload = {}) {
	const res = await fetch(`${escrot.ajaxurl}?action=${action}`, {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify(payload)
	});
	const json = await res.json();
	if (!res.ok) throw new Error(json.message || 'Request failed');
	return json;
}

// DataTable initializer
function EscrotInitDataTable(selector, action, orderCol, columns, hiddenCols, hiddenLogic, extraData = []) {
	const extras = Array.isArray(extraData) ? extraData : [extraData];
	const table = jQuery(selector).DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		ajax: {
			url: escrot.ajaxurl,
			type: 'POST',
			data: d => Object.assign(d, { action, extraData: extras }),
			dataSrc: json => {
				table.settings()[0].oLanguage.sZeroRecords =
					json.no_records_message || escrot.swal.warning.datatable_no_data_text;
				return json.data;
			}
		},
		rowId: row => `${row[0].row_id}`,
		columns,
		columnDefs: [{ targets: hiddenCols, visible: hiddenLogic, searchable: false }],
		order: [[orderCol, 'desc']]
	});
	return table;
}

// Toggle DataTable option buttons
function EscrotSetDataTableOptionsBtn(triggerBtn = '#escrot-option1', select = '#escrot-list-actions') {
	jQuery(triggerBtn).show();
	jQuery(select).on('change', function() {
		jQuery('.escrot-apply-btn').hide();
		jQuery(`#${this.value}`).show();
	});
}

// Generic SweetAlert prompt
function EscrotShowAlert({ title, text, icon, confirmButtonText, confirmCallback }) {
	Swal.fire({
		title,
		text,
		icon,
		showCancelButton: true,
		confirmButtonColor: icon === 'warning' ? '#d33' : '#4caf50',
		cancelButtonColor: '#3085d6',
		confirmButtonText
	}).then(({ value }) => {
		if (value && typeof confirmCallback === 'function') confirmCallback();
	});
}

// Choices.js multi-select initializer
function EscrotMultChoiceSelect({ selectID, data = [] }) {
	const el = document.getElementById(selectID);
	if (!el || el.dataset.choicesInitialized) return;
	const choices = new Choices(el, { removeItemButton: true, renderChoiceLimit: 15 });
	el.dataset.choicesInitialized = 'true';
	data.forEach(val => choices.setChoiceByValue(val));
}

// WordPress media uploader handler
function EscrotWPFileUpload(id) {
	const sel = {
		trigger: `.${id}-AddFile, .${id}-ChangeFile`,
		input: `.${id}-FileInput`,
		preview: `.${id}-FilePrv`,
		addBtn: `.${id}-AddFile`,
		changeBtn: `.${id}-ChangeFile`,
		dismiss: `.${id}-dismissPic`
	};

	jQuery('body')
		.on('click', sel.trigger, e => {
			e.preventDefault();
			const frame = wp.media({
				title: 'Select or Upload an Image',
				library: { type: 'image' },
				button: { text: 'Select Image' },
				multiple: false
			});
			frame.on('select', () => {
				const { url } = frame.state().get('selection').first().toJSON();
				jQuery(sel.input).val(url);
				jQuery(sel.preview).addClass('thumbnail').html(`<img src="${url}" alt="Selected Image">`);
				jQuery(sel.addBtn).hide();
				jQuery(sel.changeBtn).show();
				jQuery(sel.dismiss).show();
			});
			frame.open();
		})
		.on('click', sel.dismiss, () => {
			jQuery(sel.changeBtn).hide();
			jQuery(sel.addBtn).show();
			jQuery(sel.dismiss).hide();
			jQuery(sel.input).val('');
			jQuery(sel.preview).removeClass('thumbnail').empty();
		});
}

// Print a page section
function EscrotPrintDiv(divName) {
	const win = window.open();
	win.document.write(document.getElementById(divName).innerHTML);
	win.print();
	win.close();
}

// PayPal button loader
function EscrotLoadPaypalButton(Amount) {
	paypal.Buttons({
		createOrder: async () => {
			try {
				const { data } = await ajaxFetch('escrot_create_paypal_order', { amount: Amount });
				customerID = data.user_id;
				return data.orderID;
			} catch (err) {
				EscrotShowAlert({ title: escrot.swal.warning.error_title, text: err.message, icon: 'error', confirmButtonText: 'OK' });
				throw err;
			}
		},
		onApprove: async data => {
			try {
				const { data: resp } = await ajaxFetch('escrot_capture_paypal_order', { orderID: data.orderID, user_id: customerID });
				const { title, message, prev_balance, new_balance, prev_bal_tag, new_bal_tag } = resp;
				Swal.fire({
					icon: 'success',
					title,
					html: `${message}<br><br>${prev_bal_tag}<b>${escrot.currency}${prev_balance.toFixed(2)}</b><br>${new_bal_tag}<b>${escrot.currency}${new_balance.toFixed(2)}</b>`
				});
				jQuery('#escrot-paypal-deposit-form')[0].reset();
				jQuery('#escrot-paypal-deposit-form-modal').modal('hide');
				jQuery('#escrot-paypal-deposit-form-dialog').collapse('hide');
			} catch (err) {
				console.error(err);
				EscrotShowAlert({ title: escrot.swal.warning.error_title, text: err.message || 'Payment capture failed', icon: 'error', confirmButtonText: 'OK' });
			}
		}
	}).render('#paypal-button-container');
}

// Material Wizard initializer (unchanged)
function EscrotInitMaterialWizard() {
	jQuery('.card-wizard').bootstrapWizard({
		tabClass: 'nav nav-pills',
		nextSelector: '.btn-next',
		previousSelector: '.btn-previous',
		onInit: function (tab, navigation, index) {
			const total = navigation.find('li').length;
			const jQuerywizard = navigation.closest('.card-wizard');
			const first_li = navigation.find('li:first-child a').html();
			const jQuerymoving_div = jQuery('<div class="moving-tab">' + first_li + '</div>');
			jQuery('.card-wizard .wizard-navigation').append(jQuerymoving_div);
			refreshAnimation(jQuerywizard, index);
			jQuery('.moving-tab').css('transition', 'transform 0s');
		},
		onTabClick: () => jQuery('.card-wizard form').valid(),
		onTabShow: function (tab, navigation, index) {
			const total = navigation.find('li').length;
			const current = index + 1;
			const jQuerywizard = navigation.closest('.card-wizard');
			if (current >= total) {
				jQuerywizard.find('.btn-next').hide();
				jQuerywizard.find('.btn-finish').show();
			} else {
				jQuerywizard.find('.btn-next').show();
				jQuerywizard.find('.btn-finish').hide();
			}
			const button_text = navigation.find('li:nth-child(' + current + ') a').html();
			setTimeout(() => jQuery('.moving-tab').text(button_text), 150);
			const jQuerycheckbox = jQuery('.footer-checkbox');
			index !== 0
				? jQuerycheckbox.css({ opacity: '0', visibility: 'hidden', position: 'absolute' })
				: jQuerycheckbox.css({ opacity: '1', visibility: 'visible' });
			refreshAnimation(jQuerywizard, index);
		}
	});
	jQuery(window).resize(() => {
		jQuery('.card-wizard').each(function () {
			const jQuerywizard = jQuery(this);
			const index = jQuerywizard.bootstrapWizard('currentIndex');
			refreshAnimation(jQuerywizard, index);
			jQuery('.moving-tab').css('transition', 'transform 0s');
		});
	});
	function refreshAnimation(jQuerywizard, index) {
		const total = jQuerywizard.find('.nav li').length;
		let li_width = 100 / total;
		let move_distance = jQuerywizard.width() / total;
		let index_temp = index;
		let vertical_level = 0;
		const mobile_device = jQuery(document).width() < 600 && total > 3;
		if (mobile_device) {
			move_distance = jQuerywizard.width() / 2;
			index_temp = index % 2;
			li_width = 50;
		}
		jQuerywizard.find('.nav li').css('width', li_width + '%');
		const step_width = move_distance;
		move_distance = move_distance * index_temp;
		const current = index + 1;
		if (current === 1 || (mobile_device && index % 2 === 0)) move_distance -= 8;
		else if (current === total || (mobile_device && index % 2 === 1)) move_distance += 8;
		if (mobile_device) vertical_level = parseInt(index / 2, 10) * 38;
		jQuerywizard.find('.moving-tab').css({ width: step_width });
		jQuery('.moving-tab').css({ transform: `translate3d(${move_distance}px, ${vertical_level}px, 0)`, transition: 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)' });
	}
}

//Initializes “show/hide password” toggles on all <input type="password"> fields.
function EscrotInitShowHidePassword() {
	const EYE_SVG = `
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
			 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
			<path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 
					 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
		</svg>
	`;
	const EYE_OFF_SVG = `
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
			 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<path d="M3 3l18 18"/>
			<path d="M9.88 9.88a3 3 0 104.24 4.24"/>
			<path d="M2.458 12C3.732 7.943 7.523 5 12 5c2.316 0 
					 4.446.78 6.125 2.07"/>
			<path d="M14.477 14.477C13.319 15.635 11.715 16.25 10 
					 16.25c-4.478 0-8.269-2.943-9.543-7a9.96 
					 9.96 0 012.134-3.253"/>
		</svg>
	`;
	document.querySelectorAll('input[type="password"]').forEach(input => {
		// 1) Wrap the input in a relative DIV
		const wrapper = document.createElement('div');
		wrapper.style.position = 'relative';
		input.parentNode.insertBefore(wrapper, input);
		wrapper.appendChild(input);

		// 2) Create the toggle button
		const btn = document.createElement('button');
		btn.type = 'button';
		btn.innerHTML = EYE_SVG;
		btn.setAttribute('aria-label', 'Show password');

		// 3) Style the button only—input is not modified
		Object.assign(btn.style, {
			position:   'absolute',
			top:        '50%',
			right:      '1.2em',
			transform:  'translateY(-50%)',
			background: 'none',
			border:     'none',
			padding:    '0',
			margin:     '0',
			cursor:     'pointer',
			lineHeight: '0',
			height:     '1em',
			width:      '1em',
			color:      'rgb(74, 69, 69)'
		});

		wrapper.appendChild(btn);

		// 4) Toggle logic
		btn.addEventListener('click', () => {
			const isPwd = input.type === 'password';
			input.type = isPwd ? 'text' : 'password';
			btn.innerHTML = isPwd ? EYE_OFF_SVG : EYE_SVG;
			btn.setAttribute('aria-label', isPwd ? 'Hide password' : 'Show password');
		});
	});
}
