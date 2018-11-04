<?php
session_start();
if (!isset($_SESSION["username"]))
{
    echo "<script type='text/javascript'> location.href='./mainPage.html'; </script>";
    exit;
}
?>
<html>
<head>
    <title>Menu Page</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
    <h3 id="login2">Menu</h3>
    <?php
    $username = $_SESSION["username"];
    echo "<p>Welcome back, $username!";
    ?>
    <form action="" method="POST">
    <div class="loginPage">
        <input class="loginSubmit" id ="mainPageBut" type="submit" name="list" value="User List"/>
        <input class="loginSubmit" id ="mainPageBut" type="submit" name="newMessage" value="New Message"/>
        <input class="loginSubmit" id ="mainPageBut" type="submit" name="inbox" value="Inbox"/>
        <input class="loginSubmit" id ="mainPageBut" type="submit" name="transfer" value="Transfer"/>
        <input class="loginSubmit" id ="mainPageBut" type="submit" name="logout" value="Log Out"/>

    </div>
    </form>

    <?php
    // If the user is logging out, delete all the session information and move to main page.
    if (isset($_POST["logout"]))
    {
        session_unset();
        session_destroy();
        echo "<script type='text/javascript'> location.href='./mainPage.html'; </script>";
		exit;
    }
    // If checking inbox, move to inbox.
    else if(isset($_POST["inbox"]))
    {
        echo "<script type='text/javascript'> location.href='./inbox.php'; </script>";
		exit;
    }
    // If making new message, move to new message page.
    else if(isset($_POST["newMessage"]))
    {
        echo "<script type='text/javascript'> location.href='./newMessage.php'; </script>";
		exit;
    }
    // If transferring users, move to transfer page.
    else if (isset($_POST["transfer"]))
    {
        echo "<script type='text/javascript'> location.href='./transfer.php'; </script>";
		exit;
    }
    else if (isset($_POST["list"]))
    {
        echo "<script type='text/javascript'> location.href='./list.php'; </script>";
		exit;
    }


    ?>
</body>
</html>