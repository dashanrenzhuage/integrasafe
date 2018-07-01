// jscs:disable validateIndentation

//  Attach the CSRF Token to the submitted form via the meta tag
$.ajaxSetup({
	headers: {
		"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
	}
});

// Hide loading bar, error and sucess messages
$("#newsletter-error").hide();
$("#newsletter-success").hide();
$("#newsletter-loading").hide();

//  Listen for newsletter submit
$(document).on("submit", "#newsletter-form", function (event) {
	event.preventDefault();
	$("#newsletter-loading").show();

//      Ensure user entered an email address
	if ($("input#email").val() === "") {
		$("#newsletter-loading").hide();
		$("#newsletter-error").show();
		$("#email").focus();
		return false;
	}

	if ($("input#newsletter-interest").is(":checked")) {
		newsInterest = "on";
	} else {
		newsInterest = "off";
	}

	if ($("input#beta-interest").is(":checked")) {
		betaInterest = "on";
	} else {
		betaInterest = "off";
	}

//      Get the POST route for submitting newsletter emails
	let url = window.location.origin + "/newsletter";

//      Send Ajax request to POST route
	$.ajax({
		type: "POST",
		url: url,
		data: {email: $("input#email").val(), beta: betaInterest, newsletter: newsInterest},
		success: function (data) {
			$("#newsletter-loading").hide();
//              Show response
			document.getElementById("newsletter-success").innerHTML = data;
			$("#newsletter-success").show();
		}
	});

//      Don"t let the actual HTML form submit
	return false;
});
