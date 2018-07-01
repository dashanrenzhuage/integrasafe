$(document).ready(function () {

	// Create Stripe instance with token
	let stripe = Stripe('pk_test_4dT9MXfqEZwokqHSNyd2UoVl');
	let elements = stripe.elements();

	// Create the Card Element within the Form
	let card = elements.create('card', {
		iconStyle: 'solid',
		style: {
			base: {
				iconColor: '#8898AA',
				color: 'black',
				lineHeight: '36px',
				fontWeight: 300,
				fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
				fontSize: '19px',

				'::placeholder': {
					color: '#8898AA',
				},
			},
			invalid: {
				iconColor: '#e85746',
				color: '#e85746',
			}
		},
		classes: {
			focus: 'is-focused',
			empty: 'is-empty',
		},
	});
	card.mount('#card-element');

	// Append the name and email fields to the soon-to-be generated Stripe Token
	let inputs = document.querySelectorAll('input.field');
	Array.prototype.forEach.call(inputs, function (input) {
		input.addEventListener('focus', function () {
			input.classList.add('is-focused');
		});
		input.addEventListener('blur', function () {
			input.classList.remove('is-focused');
		});
		input.addEventListener('keyup', function () {
			if (input.value.length === 0) {
				input.classList.add('is-empty');
			} else {
				input.classList.remove('is-empty');
			}
		});
	});

	// Listen for when the Checkout form is submitted
	document.getElementById('submit-form').addEventListener('click', function (event) {
		event.preventDefault();
		// Append extra details (namely the Customer's name) to the token
		let form = document.querySelector('form');
		let extraDetails = {
			name: form.querySelector('input[name=cardholderName]').value,
			email: form.querySelector('input[name=cardholderEmail]').value,
		};

		// Create a new Stripe token based on the card and extra details
		stripe.createToken(card, extraDetails).then(function (result) {
			if (result.error) {
				// Inform the customer that there was an error
				console.log("Error = " + result.error);
				let errorElement = document.getElementById('error');
				errorElement.textContent = result.error.message;
			} else {
				// Append token to new input element and continue submitting the form
				let form = document.getElementById('payment-form');
				let hiddenInput = document.createElement('input');
				hiddenInput.setAttribute('type', 'hidden');
				hiddenInput.setAttribute('name', 'stripeToken');
				hiddenInput.setAttribute('value', result.token.id);
				form.appendChild(hiddenInput);

				// Display the Loading dialog
				dialog = new mdc.dialog.MDCDialog(document.querySelector('#payment-dialog'));
				document.getElementById('progress-dialog-header').innerText = "Processing Your Order";
				dialog.show();

				// Submit the form
				form.submit();
			}
		});
	});

	// Same as Billing Address
	switcher = document.getElementById('hide-shipping');
	switcher.addEventListener('click', function () {
		if (switcher.checked === true) {
			// hide shipping div
			document.getElementById('shipping-information').style.display = 'none';
		} else {
			// show shipping div
			document.getElementById('shipping-information').style.display = 'block';
		}
	});

	// Listen for updates to the shipping speed/price
	let radioButtons = document.getElementsByName('shipping_group');
	let total = document.getElementById('order-total-price');

	// Set onClick listeners for all radio buttons in shipping_group
	for (let counter = 0; radioButtons[counter]; counter++)
		radioButtons[counter].onclick = changePrice;

	function changePrice() {
		// Get the value of the Radio button
		let shipping = $(this).val();
		// Use that value to get the displayed price of the radio selection
		let price = parseFloat((document.getElementById(shipping).innerText).substring(1));

		// Get the amount of the Products by them selves and the amount of tax on them, then add them together
		let total_before = parseFloat(document.getElementById('product-total').innerText) + parseFloat(document.getElementById('tax-total').innerText);
		// Update the Displayed shipping price
		document.getElementById('current-shipping').innerText = price;
		// Update the Total Order Price
		total.innerText = total_before + price;
	}

	// See if the Customer is at the Review Section
	try {
		// Listen for when the Review form is submitted
		document.getElementById('review-purchase').addEventListener('click', function (event) {
			event.preventDefault();
			// Append extra details (namely the Customer's name) to the token
			let form = document.querySelector('form');

			// Display the Loading dialog
			dialog = new mdc.dialog.MDCDialog(document.querySelector('#payment-dialog'));
			dialog.getElementById('progress-dialog-header').innerText = "Processing Your Transaction";
			dialog.show();

			// Submit the form
			form.submit();
		});
	} catch (error) {
		// do nothing, Customer is not at the Review Section yet
	}
});
