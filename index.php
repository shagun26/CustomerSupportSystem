<?php
if (!is_dir("./uploads"))
{
    mkdir('./uploads', 0777, true);
}
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <title>Main Page</title>
</head>
<body>
    <form action="" method="post">
        <h3 id="login2">Cyber Warriors' Help Desk System</h3>

        <div class="loginPage">
            <h4 class="question">

                <a class="userType" id="asHelp" href="./login.php">Help Desk User</a>
                <p>OR</p>
                <a class="userType" id="asAnon" href="./anonSetup.php">Anonymous User</a>
            </h4>
        </div>
    </form>

</body>
</html>