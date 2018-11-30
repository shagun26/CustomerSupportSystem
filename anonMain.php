<?php
    // Open existing session. Refreshes every 5 seconds for new messages.
    session_start();
    if (!isset($_SESSION["anonName"]))
    {
        echo "<script type='text/javascript'> location.href='./anonSetup.php'; </script>";
        exit;
    }
    $helper = $_SESSION["helper"];
    header("Refresh: 5;"); 
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
    <h1 id="login2">Anonymous User Chat</h1>
    <div class="loginPage">
    <form action="" method="POST">
        <input class="annoLeave" type="submit" name="leave" id="leave" value="Leave">
    </form>


    <form action="" method="POST">
        <p class="annoSetup">To: <?php echo "$helper"; ?></p>
        <div class="annoMainPage">
        <label for="message">Message</label>
        <br />
        <input type="text" class="annoInput" name="message" id="message">
        <input type="submit" class="annoSubmit" name="submit" id="submit" value = "Send" onclick="return messageCheckAnon();">
        </div>
    </form>
    <br />
    <form action="" method="POST">
        <div class="annoMainPage">
        <label for="deleteID">Delete Message # </label>
        <br />
        <input type="number" class="annoInput" name="deleteID" pattern="[0-9]">
        <input type="submit" class="annoSubmit" name="delete" value="Delete">
        </div>
    </form>

    <a href="./anonFile.php"><button class="annoSubmit">Upload A File</button></a>

    
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
            echo "<p class='annoSetup'>Message deleted.</p>";
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
            echo "<p class='annoSetup'>ID: $row[0]  <br />  From: $row[1]  <br />  To: $row[2]</p>";
            echo "<p class='annoSetup'>Message: $row[3]</p>";
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
            mysqli_query($dbLocalhost, $sql);
            $sql = "DELETE FROM `messages` WHERE `from` = '$anonName'";
            mysqli_query($dbLocalhost, $sql);
            $sql = "DELETE FROM `files` WHERE `from` = '$anonName'";


            if ($result = mysqli_query($dbLocalhost, $sql))
            {
                // Delete their session data and exit to main page.
                session_unset();
                session_destroy();
                echo "<script type='text/javascript'> location.href='./index.php'; </script>";
                exit;
            }
            else
            {
                echo mysqli_error($dbLocalhost);
            }

        }
    ?>
    </div>
</body>
</html>