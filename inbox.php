<?php
    // Opens the session, ensures that the user is signed in, also refreshed the page every 5 seconds for new messages.
    session_start();
    if (!isset($_SESSION["username"]))
    {
        echo "<script type='text/javascript'> location.href='./index.html'; </script>";
        exit;
    }
    header("Refresh: 5;"); 
?>
<html>
<head>
    <title>Inbox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
    <h3 id="login2">Inbox</h3>
    <a href="./menu.php"><button class="annoLeave">Back To Menu</button></a>
    <div class="loginPage">
    <form action="" method="POST">
        <label for="deleteID">Delete Message # </label>
        <br />
        <input type="number" name="deleteID" class="annoInput" pattern="[0-9]">

        <input type="submit" name="delete" class="annoSubmit" value="Delete">
    </form>
    <?php

    $username = $_SESSION["username"];
    require_once("connect-db.php");

    // If user hits delete.
    if (isset($_POST["delete"]))
    {
        $id = $_POST["deleteID"];

        // Deletes by message ID if they are the recipient.
        $sql = "DELETE FROM `messages` WHERE `mid`='$id' AND `to`='$username'";
        if ($result = mysqli_query($dbLocalhost, $sql))
        {
            echo "<p>Message deleted.</p>";
        }
        else
        {
            echo mysqli_error($dbLocalhost);
        }

    }

    // Select all the messages to this user.
    $sql = "SELECT * FROM `messages` WHERE `to`='$username'";

    if ($result = mysqli_query($dbLocalhost, $sql))
    {
        // Displays them.
        while ($row = mysqli_fetch_row($result))
        {
            echo "<p class='annoSetup'>ID: $row[0]  <br />  From: $row[1] <br />  To: $row[2]</p>";
            echo "<p class='annoSetup'>Message: $row[3]</p>";
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