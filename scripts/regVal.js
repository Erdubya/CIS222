function formValidate() {
	var valid = true;
	var validationMessage = "Please correct the errors:\n";

	var x = document.getElementById('email').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tEmail is missing\n";
		valid = false;
	}
	x = document.getElementById('emailconf').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tEmail conformation is missing\n";
		valid = false;
	}
	x = document.getElementById('pass').value
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tpassword is missing\n";
		valid = false;
	}
	x = document.getElementById('passconf').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tpassword conformation is missing\n";
		valid = false;
	}
	x = document.getElementById('phone').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tPhone number is missing\n";
		valid = false;
	}
	x = document.getElementById('addr1').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tAddress is missing\n";
		valid = false;
	}
	x = document.getElementById('city').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tCity is missing\n";
		valid = false;
	}
	x = document.getElementById('state').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tState is missing\n";
		valid = false;
	}
	x = document.getElementById('zip').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tZip code is missing\n";
		valid = false;
	}
	x = document.getElementById('lname').value;
	if(x == null || x == ""){
		validationMessage = validationMessage + "\tLast name is missing\n";
		valid = false;
	}

	if(!valid) {
		window.alert(validationMessage);
	}

	return valid;
}
