<?php
    // Opens the session, ensures that the user is signed in, also refreshed the page every minute for new messages.
    session_start();
    if (!isset($_SESSION["username"]))
    {
        echo "<script type='text/javascript'> location.href='./mainPage.html'; </script>";
        exit;
    }
    header("Refresh: 60;"); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
    
<a href="./menu.php"><button class="annoLeave">Back To Menu</button></a>
<br />
<div class="loginPage">
<?php

    echo "<br /><h1 class='listF'>Help Desk Users </h1>";

    require_once("connect-db.php");

    // Grab all help desk users from list.
    $sql = "SELECT `username` FROM `users`";

    if ($result = mysqli_query($dbLocalhost, $sql))
    {
        while ($row = mysqli_fetch_row($result))
        {
            echo "<p>$row[0]</p>";
        }
    }
    else
    {
        echo mysqli_error($dbLocalhost);
    }

    echo "<h1 class='listF'>Anonymous Users </h1>";

    $sql = "SELECT * FROM `anonymoususers`";

    if ($result = mysqli_query($dbLocalhost, $sql))
    {
        while ($row = mysqli_fetch_row($result))
        {
            echo "<p>User: $row[1]</p>";
            echo "<p>Helper: $row[2]</p>";
            echo "<br>";
        }
    }
    else
    {
        echo mysqli_error($dbLocalhost);
    }


?>
</div>
</body>
</html>