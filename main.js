function loginCheck(){
	var ok = true;
	
	//check user name
	var p = document.getElementById("username").value;
	
	if(!p|| 0 === p.length) {
		alert("Please enter a username!");
		ok = false;
	}
    if(!ok) return false;

	//check password
	p = document.getElementById("password").value;

	if (!p|| 0 === p.length){
		alert("Please enter a password");
		ok = false;
	}
	if (p.length > 10)
	{
		alert("Password cannot be more than 10 characters.");
		ok = false;
	}
	if (!ok) return false;
	return ok;
}

function messageCheck() {
	var ok = true;

	var p = document.getElementById("to").value;

	if (!p || p.length === 0)
	{
		alert("Please indicate the user to send the message to.");
		ok = false;
	}
	if (!ok) return false;

	p = document.getElementById("message").value;

	if (!p || p.length === 0)
	{
		alert("Please do not send empty messages.");
		ok = false;
	}

	if (p.length > 8000)
	{
		alert("Any characters above 8000th will be truncated.");
	}
	if (!ok) return false;
	return ok;
}

function messageCheckAnon()
{
	var ok = true;

	p = document.getElementById("message").value;

	if (!p || p.length === 0)
	{
		alert("Please do not send empty messages.");
		ok = false;
	}

	if (p.length > 8000)
	{
		alert("Any characters above 8000th will be truncated.");
	}
	if (!ok) return false;
	return ok;
}

function checkName() {
	var ok = true;

	var p = document.getElementById("name").value;

	if (!p || p.length === 0)
	{
		alert("Please enter a name. It does not have to be real!");
		ok = false;
	}
	if (!ok) return false;
	return ok;
}