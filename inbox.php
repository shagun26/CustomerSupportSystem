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
<html>
<head>
    <title>Inbox</title>
</head>
<body>
    <h3 id="login2">Inbox</h3>
    <a href="./menu.php">Back To Menu</a>
    
    <form action="" method="POST">
        <label for="deleteID">Delete Message #: </label>
        <input type="number" name="deleteID" pattern="[0-9]">

        <input type="submit" name="delete" value="Delete">
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
            echo "<p>ID: $row[0]    From: $row[1]   To: $row[2]</p>";
            echo "<p>Message: $row[3]</p>";
            echo "<br>";
        }
    }
    else
    {
        echo mysqli_error($dbLocalhost);
    }

    ?>

</body>
</html>