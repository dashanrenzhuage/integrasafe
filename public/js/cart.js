// Attach the Laravel CSRF token to an ajax method to allow a POST request to be sent in the background
$.ajaxSetup({
	headers: {
		"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
	}
});

// location.origin is any registered domain's primary URL (no routes attached to the end)
let global_url = window.location.origin + "/cart";

// Setup the Loading Module Dialog in `/integrasafe/modules/loading.blade.php`
progress_dialog = new mdc.dialog.MDCDialog(document.querySelector('#payment-dialog'));
dialog_header = document.getElementById('progress-dialog-header');
dialog_buttons = document.getElementById('dialog-buttons');
progress_bar = document.getElementById('progressbar');

// For showing the Customer what Item they just added to their Cart
selected_sku = document.getElementById('added-sku');
selected_sku.style.visibility = 'hidden';

//  Listen for add-to-cart submit
function addToCart(item) {
	// show Loading dialog
	dialog_header.innerText = "Adding to your Cart...";
	progress_dialog.lastFocusedTarget = event.target;
	progress_dialog.show();

	// Get the POST route for submitting a request to the cart
	let url = global_url + "/add";
	let input = $(item).val();

	// Send Ajax request to POST route
	$.ajax({
		type: "POST",
		url: url,
		// Add the value of the Button that was clicked (Product SKU) to the POST request
		data: "product=" + input,
		success: function (data) {
			if (data[0] === "true") {
				// Item was added to the Cart, ask user if they want to be taken to the Checkout page
				dialog_header.innerText = "Item successfully added to Cart!";
				dialog_buttons.style.visibility = "visible";
				progress_bar.style.visibility = "hidden";
				selected_sku.style.visibility = "visible";

				// Show the Customer what they added
				document.getElementById('sku-name').innerText = data[1][0];
				document.getElementById('sku-price').innerText = data[1][1];
			} else {
				// There was an error adding SKU to Cart (check Sentry.io)
				dialog_header.innerText = "We could not add your product to the cart at this time, please try again.";
				progress_bar.style.visibility = "hidden";
				progress_dialog.show();
			}
		},
		// The POST request failed to send
		fail: function () {
			dialog_header.innerText = "There was an Error processing your request. Please try again.";
			document.getElementById('progressbar').style.visibility = "hidden";
			progress_dialog.show();
		}
	});

	// Don't let the page to be redirected
	return false;
}

//  Listen for remove-from-cart submit
function removeFromCart(item) {
	// show Loading dialog
	dialog_header.innerText = "Removing item from your Cart...";
	dialog_buttons.style.visibility = "hidden";
	progress_dialog.lastFocusedTarget = event.target;
	progress_dialog.show();

	// Get the POST route for submitting to the cart
	let url = global_url + "/remove";
	let input = $(item).val();
	console.log("input = " + input);

	// Send Ajax request to POST route
	$.ajax({
		type: "POST",
		url: url,
		// Remove the value of the button that was clicked (Product SKU) to the POST request
		data: "product=" + input,
		success: function (data) {
			if (data === "true") {
				// Item was removed from the Cart, reload the page
				window.location.reload();
			} else {
				// There was an error adding SKU to Cart (check Sentry.io)
				dialog_header.innerText = "We could not remove your product from the cart at this time, please try again.";
				progress_bar.style.visibility = "hidden";
				progress_dialog.show();
			}
		},
		// The POST request failed to send
		fail: function (data) {
			dialog_header.innerText = "There was an error processing your request. Please try again.";
			progress_bar.style.visibility = "hidden";
			progress_dialog.show();
		}
	});

	// Don't let the page to be redirected
	return false;
}

function getCartContents() {
	let url = global_url + "/get";
	let input = $(item).val();

	// Send Ajax request to POST route
	$.ajax({
		type: "GET",
		url: url,
		success: function (data) {
			console.log(data);
			return data;
		},
		// The POST request failed to send
		fail: function () {
			document.getElementById('progress-dialog-header').innerText = "There was an Error processing your request. Please try again.";
			document.getElementById('progressbar').style.visibility = "hidden";
			progress_dialog.show();
		}
	});
}
