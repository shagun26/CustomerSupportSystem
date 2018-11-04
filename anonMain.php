<?php
    // Open existing session. Refreshes every minute for new messages.
    session_start();
    $helper = $_SESSION["helper"];
    header("Refresh: 60;"); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Anonymous User Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1>Anonymous User Chat</h1>
    
    <form action="" method="POST">
        <input type="submit" name="leave" id="leave" value="Leave">
    </form>


    <form action="" method="POST">
        <p>To: <?php echo "$helper"; ?>.</p>
        <label for="message">Message: </label>
        <input type="text" name="message" id="message">
        <input type="submit" name="submit" id="submit" onclick="return messageCheckAnon();">
    </form>

    <form action="" method="POST">
        <label for="deleteID">Delete Message #: </label>
        <input type="number" name="deleteID" pattern="[0-9]">

        <input type="submit" name="delete" value="Delete">
    </form>

    

    
    <?php 

  
$username = $_SESSION["anonName"];
require_once("connect-db.php");

    // If delete button was clicked.

    if (isset($_POST["delete"]))
    {
        // Look at the message ID that will be deleted.
        $id = $_POST["deleteID"];

        // Find that message ID, ensure the person has the privileges to delete it, then delete.
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

    // Look at all messages sent to this user.
    $sql = "SELECT * FROM `messages` WHERE `to`='$username'";

    if ($result = mysqli_query($dbLocalhost, $sql))
    {
        // List the messages.
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




    // If they submitted a message.
if (isset($_POST["submit"]))
{
    // Set the parameters: from, to, message contents.
    $to = $helper;
    $message = $_POST["message"];
    $from = $_SESSION["anonName"];

    // Make sure user exists.
    $sql = "SELECT * FROM `users` WHERE `username`='$to'";
    if ($result = mysqli_query($dbLocalhost, $sql))
    {
        if (mysqli_num_rows($result) == 0)
        {
            echo "<p>That user does not exist!</p>";
        }
        else
        {
            // Add the message to the messages database.
            $sql = "INSERT INTO `messages` (`from`, `to`, `message`) VALUES ('$from', '$to', '$message')";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {
                echo "<p>Message sent!</p>";

            }
            else
            {
                echo "<p>Message not sent.</p>";
                echo mysqli_error($dbLocalhost);
            }

        }
    }
    else
    {
        echo "<p>Message not sent.</p>";
        echo mysqli_error($dbLocalhost);
    }


}

        // If the anonymous user exits.

        if (isset($_POST["leave"]))
        {
            require_once("connect-db.php");
            $anonName = $_SESSION["anonName"];
            
            // Delete the user from the anonymous user list.
            $sql = "DELETE FROM `anonymoususers` WHERE `username` = '$anonName'";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {
                // Delete their session data and exit to main page.
                session_unset();
                session_destroy();
                echo "<script type='text/javascript'> location.href='./mainPage.html'; </script>";
                exit;
            }
            else
            {
                echo mysqli_error($dbLocalhost);
            }
        }
    ?>
</body>
</html>