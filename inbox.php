<?php
    // Opens the session, ensures that the user is signed in, also refreshed the page every 5 seconds for new messages.
    session_start();
    if (!isset($_SESSION["username"]))
    {
        echo "<script type='text/javascript'> location.href='./index.php'; </script>";
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

    <form action="" method="POST">
        <label for="deleteID">Delete File #</label>
        <br />
        <input type="number" class="annoInput" name="deletefileID" pattern="[0-9]">
        <input type="submit" class="annoSubmit" name="deletefile" value="Delete">

    </form>

    

    <?php

    $username = $_SESSION["username"];
    require_once("connect-db.php");

    // If user hits delete for a message.
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

    // If user hits delete for a file.
    if (isset($_POST["deletefile"]))
    {
        // Look at the file ID that will be deleted.
        $id = $_POST["deletefileID"];

        // Grab the file name.
        $sql = "SELECT `name`, `from` FROM `files` WHERE `fid`='$id' AND `to`='$username'";

        if ($result = mysqli_query($dbLocalhost, $sql))
        {
            // Delete the file from server with matching name.
            $row = mysqli_fetch_row($result);
            $sender = $row[1];
            $fileName = $row[0];
            unlink("./uploads/" . $sender . "/" . $fileName);
            // Delete file from database.
            $sql = "DELETE FROM `files` WHERE `fid`='$id' AND `to`='$username'";
            mysqli_query($dbLocalhost, $sql);
        }
        else
        {
            echo mysqli_error($dbLocalhost);
        }



    }


    echo "<h3>Files</h3>";

    // Select all the files to this user.
    $sql = "SELECT * FROM `files` WHERE `to`='$username'";
    
    if ($result = mysqli_query($dbLocalhost, $sql))
    {
        // List the files.
        while ($row = mysqli_fetch_row($result))
        {
            echo "<p class='annoSetup'>ID: $row[0]  <br />  From: $row[1]  <br />  To: $row[2]</p>";
            echo "<p class='annoSetup'>Name: $row[3]</p>";
            echo "<a href='./uploads/$row[1]/$row[3]' download>Download</a>";
            echo "<br>";
        }
    }
    else
    {
        echo mysqli_error($dbLocalhost);
    }

    echo "<h3>Messages</h3>";

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