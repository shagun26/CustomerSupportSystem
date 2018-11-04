<html>
<head>
    <title>Menu Page</title>
</head>

<style type="text/css">
#login2{
    font-size: 38px;
    font-family: Sans-serif;
    text-align: center;
}

#mainPageBut{
   width: 50%;
   background-color: #ff8040;
   color: white;
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
    text-align: center;

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

</style>

<body>
<h3 id="login2">Menu</h3>
<div class="loginPage">
<input class="loginSubmit" id ="mainPageBut" type="submit" name="newMessage" value="New Message"/>
<input class="loginSubmit" id ="mainPageBut" type="submit" name="inbox" value="Inbox"/>
<input class="loginSubmit" id ="mainPageBut" type="submit" name="logout" value="Log Out" 
        onclick="document.location.href='mainPage.php'"/>

</div>
</body>
</html>