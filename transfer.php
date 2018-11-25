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
    <title>Transfer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1 id="login2">Transfer an Anonymous User</h1>
    <div class="loginPage">
    <a href="./menu.php"><button class="annoLeave">Back To Menu</button></a>

    <form action="" method="POST">
        <label for="transferee" class="annoSetup">Who do you wish to transfer? </label>
        <br />
        <input type="text" name="transferee" class="annoInput" id="transferee">
        <br />
        <input type="submit" value="Transfer" class="annoSubmit" name="transfer">
    </form>

    <?php

        // Grabs details of user to be transferred, and transferer.
        if (isset($_POST["transfer"]))
        {

      
        $anonUser = $_POST["transferee"];
        $username = $_SESSION["username"];

        require_once("connect-db.php");
        // Deletes connection between transferer and transferee in database.
        $sql = "DELETE FROM `anonymoususers` WHERE `username`='$anonUser' AND `assignedto`='$username'";

        if ($result = mysqli_query($dbLocalhost, $sql))
        {
            
            // Deletes current count of anonymous users to help desk users.
            $sql = "DELETE FROM `numassigned`";
            if ($result = mysqli_query($dbLocalhost, $sql))
			{

			}
			else
			{
				echo mysqli_error($dbLocalhost);
			}

            $sql = "INSERT INTO `numassigned` (`username`) SELECT `username` FROM `users`";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {
            
            }
            else
			{
				echo mysqli_error($dbLocalhost);
            }
            
            // Recalculates number of anonymous users to help desk users.
            $sql = "UPDATE `numassigned` SET `number` = (SELECT count(*) FROM `anonymoususers` WHERE `assignedto`=`numassigned`.`username`)";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {

            }
            else
			{
				echo mysqli_error($dbLocalhost);
            }

            // Checks through each one to find the minimum.
            $sql = "SELECT * FROM `numassigned`";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {
                $minimumPerson = "Anon";
                $minimumValue = 1000;
                while ($row = mysqli_fetch_row($result))
                {
                    // Ensures that the user is not transferred back to the same person.
                    if ($row[0] === $username)
                    {
                        $row[1] += 1000;
                    }
                    if ($row[1] < $minimumValue)
                    {
                        $minimumPerson = $row[0];
                        $minimumValue = $row[1];
                    }
                }
                
                // Creates the new pairing.
                $sql = "INSERT INTO `anonymousUsers` (`username`, `assignedto`) VALUES ('$anonUser', '$minimumPerson')";
                if ($result = mysqli_query($dbLocalhost, $sql))
                {
                    // Moves all the old messages to the new user.
                    $sql = "UPDATE `messages` SET `to`='$minimumPerson' WHERE `to`='$username' AND `from`='$anonUser'";
                }
                else
                {
                    echo mysqli_error($dbLocalhost);
                }

        
            }



        }
        else
        {
            echo "Not transferred.";
            echo mysqli_error($dbLocalhost);
        }

    }

    ?>
    </div>
</body>
</html>