<?php
    // Delete old session data.
    session_start();
    session_unset();
    session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Anonymous Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1>Welcome Anonymous User</h1>
    <form action="" method="POST">
        <label for="name">What would you like to be known as? (You do not have to use a real name!): </label>
        <input type="text" name="name" id="name">
        <input type="submit" value="Submit" onclick="return checkName();" name="submit">
        
    </form>

    <?php

        // They have picked their anonymous name.
        if (isset($_POST["submit"]))
        {
            // Save the name to session.
            session_start();
            $anonUser = $_POST["name"];
            $_SESSION["anonName"] = $anonUser;

            require_once("connect-db.php");

            // Delete the running count of anonymous users (as it can fluctuate greatly).
            $sql = "DELETE FROM `numassigned`";
            if ($result = mysqli_query($dbLocalhost, $sql))
			{

			}
			else
			{
				echo mysqli_error($dbLocalhost);
			}

            // Make a list of all the current help desk users.
            $sql = "INSERT INTO `numassigned` (`username`) SELECT `username` FROM `users`";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {
            
            }
            else
			{
				echo mysqli_error($dbLocalhost);
            }
            
            // Count the number of anonymous users each help desk user has.
            $sql = "UPDATE `numassigned` SET `number` = (SELECT count(*) FROM `anonymoususers` WHERE `assignedto`=`numassigned`.`username`)";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {

            }
            else
			{
				echo mysqli_error($dbLocalhost);
            }

            // Now that we have the count, find the help desk user with minimum anonymous users and give them the user.
            $sql = "SELECT * FROM `numassigned`";
            if ($result = mysqli_query($dbLocalhost, $sql))
            {
                $minimumPerson = "Anon";
                $minimumValue = 1000;
                while ($row = mysqli_fetch_row($result))
                {
                    if ($row[1] < $minimumValue)
                    {
                        $minimumPerson = $row[0];
                        $minimumValue = $row[1];
                    }
                }
                
                // Save the pairing to the database and the anonymous user's session.
                $sql = "INSERT INTO `anonymousUsers` (`username`, `assignedto`) VALUES ('$anonUser', '$minimumPerson')";
                if ($result = mysqli_query($dbLocalhost, $sql))
                {
                    $_SESSION["helper"] = $minimumPerson;
                    echo "<script type='text/javascript'> location.href='./anonMain.php'; </script>";
                    exit;
                }
                else
                {
                    echo mysqli_error($dbLocalhost);
                }

        
            }

        }
    ?>
    
</body>
</html>