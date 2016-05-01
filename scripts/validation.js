//Validation for Create Account form
function registerAccount() {
	var valid = true;
	var validationMessage = "Please correct the errors:\n";

	var x = document.getElementById('email').value;
	if(x == null || x == ""){
		validationMessage += "- Email is missing\n";
		valid = false;
	}
	x = document.getElementById('emailconf').value;
	if(x == null || x == ""){
		validationMessage += "- Email conformation is missing\n";
		valid = false;
	}
	x = document.getElementById('pass').value
	if(x == null || x == ""){
		validationMessage += "- password is missing\n";
		valid = false;
	}
	x = document.getElementById('passconf').value;
	if(x == null || x == ""){
		validationMessage += "- password conformation is missing\n";
		valid = false;
	}
	x = document.getElementById('phone').value;
	if(x == null || x == ""){
		validationMessage += "- Phone number is missing\n";
		valid = false;
	}
	x = document.getElementById('addr1').value;
	if(x == null || x == ""){
		validationMessage += "- Address is missing\n";
		valid = false;
	}
	x = document.getElementById('city').value;
	if(x == null || x == ""){
		validationMessage += "- City is missing\n";
		valid = false;
	}
	x = document.getElementById('state').value;
	if(x == null || x == ""){
		validationMessage += "- State is missing\n";
		valid = false;
	}
	x = document.getElementById('zip').value;
	if(x == null || x == ""){
		validationMessage += "- Zip code is missing\n";
		valid = false;
	}
	x = document.getElementById('lname').value;
	if(x == null || x == ""){
		validationMessage += "- Last name is missing\n";
		valid = false;
	}

	//Checks for correct input of confirm fields
	if (valid) {
		var y;
		x = document.getElementById('email').value;
		y = document.getElementById('emailconf').value;
		if (x != y) {
			validationMessage += "Emails do not match!\n";
			valid = false;
		}

		x = document.getElementById('pass').value;
		y = document.getElementById('passconf').value;
		if (x != y) {
			validationMessage += "Passwords do not match!\n";
			valid = false;
		}
	}

	if(!valid) {
		window.alert(validationMessage);
	}

	return valid;
}

//Validation for Edit Account form
function updateAccount() {
	var valid = true;
	var y;
	var x = document.getElementById('oldPass').value;
	var validationMessage;
	
	if(x == null || x == ""){
		validationMessage = "Enter current password!";
		valid = false;
	}

	//Checks for correct input of confirm fields
	if (valid) {
		x = document.getElementById('email').value;
		y = document.getElementById('emailconf').value;
		if (x != y) {
			validationMessage = "Emails do not match!\n";
			valid = false;
		}
		
		x = document.getElementById('pass').value;
		y = document.getElementById('passconf').value;
		if (x != y) {
			validationMessage = validationMessage + "Passwords do not match!\n";
			valid = false;
		}
	}
	
	if (!valid) {
		window.alert(validationMessage);
	}
	
	return valid;
}

//Validation for Inventory Editor
function updateInventory() {
	var valid = true;
	var validationMessage = "The following errors occurred:\n"
	var y = new RegExp("[\'\"@#$&\\\/\*]+");
	var x;
	
	//Check name input of submitted form
	x = $("#updateID input[name='Name']").val();
	if (x == null || x == "") {
		valid = false;
		validationMessage += "- Name cannot be empty\n"
	} else if (x.length > 20) {
		valid = false;
		validationMessage += "- Name is too long (20)\n"
	} else if (y.test(x)) {
		valid = false;
		validationMessage += "- Name contains invalid characters\n"
	}

	//Check description input of submitted form
	x = $("#updateID input[name='Description']").val();
	if (x == null || x == "") {
		valid = false;
		validationMessage += "- Description cannot be empty\n"
	} else if (x.length > 80) {
		valid = false;
		validationMessage += "- Description is too long (80)\n"
	} else if (y.test(x)) {
		valid = false;
		validationMessage += "- Description contains invalid characters\n"
	}

	//Check price input of submitted form
	x = $("#updateID input[name='Price']").val();
	if (x == null || x == "") {
		valid = false;
		validationMessage += "- Price cannot be empty\n"
	} else if (x.length > 6) {
		valid = false;
		validationMessage += "- Price is too high (999.99)\n"
	} else if (y.test(x)) {
		valid = false;
		validationMessage += "- Price contains invalid characters\n"
	} else {
		//If the price passes the above test, check for valid formatting
		var z = x.split(".");
		if (z.length == 2) {
			//With single decimal
			if (z[0].length > 3 || z[1].length > 2) {
				console.log("INside!");
				valid = false;
				validationMessage += "- Invalid price"
			}
		} else if (z.length > 2){
			//With multiple decimals
			console.log("ELSE");
			valid = false;
			validationMessage += "- Invalid price"
		} else {
			//With no decimals
			if (z[0].length > 3) {
				valid = false;
				validationMessage += "- Invalid price"
			}
		}
	}

	if (!valid) {
		window.alert(validationMessage);
	}

	return valid;
}
