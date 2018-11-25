<?php
session_start();
if (!isset($_SESSION["username"]))
{
    echo "<script type='text/javascript'> location.href='./index.html'; </script>";
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
    <div class="loginPage">
    <a href="./menu.php"><button class="annoLeave">Back To Menu</button></a>
    <form action="" method="POST">
        <div class="annoMainPage">
        <label for="to">To </label>
        <br />
        <input type="text" class="annoInput" name="to" id="to">
        </div>

        <br />
        <div class="annoMainPage">
        <label for="message">Message </label>
        <br />
        <input type="text" name="message" class="annoInput" id="message">
       <br />
        <input type="submit" name="submit" class="annoSubmit" id="submit" value="Send" onclick="return messageCheck();">
       </div>
    </form>

    <?php

        if (isset($_POST["submit"]))
        {
            $to = $_POST["to"];
            $message = $_POST["message"];
            $from = $_SESSION["username"];

            require_once("connect-db.php");
            $sql = "SELECT `username` FROM `users` WHERE `username`='$to' UNION SELECT `username` FROM `anonymoususers` WHERE `username`='$to'";
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
    </div>
</body>
</html>