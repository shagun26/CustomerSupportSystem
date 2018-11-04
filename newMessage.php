<?php
session_start();
if (!isset($_SESSION["username"]))
{
    echo "<script type='text/javascript'> location.href='./mainPage.html'; </script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>New Message</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
    <h3 id="login2">New Message</h3>
    <a href="./menu.php">Back To Menu</a>
    <form action="" method="POST">
        <label for="to">To: </label>
        <input type="text" name="to" id="to">
        <label for="message">Message: </label>
        <input type="text" name="message" id="message">
        <input type="submit" name="submit" id="submit" onclick="return messageCheck();">
    </form>

    <?php

        if (isset($_POST["submit"]))
        {
            $to = $_POST["to"];
            $message = $_POST["message"];
            $from = $_SESSION["username"];

            require_once("connect-db.php");
            $sql = "SELECT * FROM `users` WHERE `username`='$to'";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {
                if (mysqli_num_rows($result) == 0)
                {
                    echo "<p>That user does not exist!</p>";
                }
                else
                {

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
    ?>
</body>
</html>