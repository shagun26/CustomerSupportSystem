<html>
<head>
<title>Login Page</title>
</head>
<script>
    function loginCheck(){
	var ok = true;
	
	//check user name
	var p = document.getElementById("username").value;
	
	if(!p|| 0 === p.length) {
		alert("please enter a username!");
		ok = false;
	}
    if(!ok) return false;
	//check password
	p = document.getElementById("password").value;
	//Question why switch < and > would not working here.
	if (!p|| 0 === p.length){
		alert("please enter a password");
		ok = false;
	}
	if (!ok) return false;
	return ok;
}      
</script>

<style type="text/css">
#login2{
    font-size: 38px;
    font-family: Sans-serif;
    text-align: center;
}
.usrNpas{
    width: 100%;
   padding: 12px 20px;
   margin: 8px 0;
   display: inline-block;
   border: 1px solid #ccc;
   border-radius: 4px;
   box-sizing: border-box;
}
.loginSubmit{
   width: 100%;
   background-color: #ff8040;
   color: white;
   padding: 14px 20px;
   margin: 8px 0;
   border: none;
   border-radius: 4px;
   cursor: pointer;
   font-size: 13px;
}
.loginSubmit :hover {
   background-color: #87cefa;
}
#ls{
   width: 100%;
   background-color: white;
   color: black;
   padding: 14px 20px;
   margin: 8px 0;
   border: 2px solid;
   border-color: black;
   border-radius: 4px;
   cursor: pointer;
   font-size: 13px;
}
.loginPage{
 
    padding: 20px;
    background-color: #81D8D8;
}
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid lightgray;
    margin: 1em 0;
    padding:0;
}
</style>

<body>
<form action="" method="post">

<h3 id="login2">Login</h3>

<div class="loginPage">
<label for="username">Username</label>
<input class="usrNpas" type="text" name="username" id="username"/>
<br />

<label for="password">Password</label>
<input class="usrNpas" type="password" name="password" id="password" ></input>

<br />
<input class="loginSubmit" type="submit" name="loginSubmit" value="Login" onclick="return loginCheck();"></input>
<br />


<hr class="line"></hr>

<input class="loginSubmit" id ="ls" type="submit" name="register" value="Register"/>
<br />
<input class="loginSubmit" id ="ls" type="submit" name="home" value="Back to Main Page"/>
</div>
</form>
</body>

</html>
