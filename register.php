<?php
session_start();
?>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <script src="./main.js"></script>
</head>
<body>
    <form action="" method="post">
        <h3 id="login2">Create an Account</h3>
        <div class="loginPage">
            <label for="username">Username</label>
            <input class="usrNpas" type="text" name="username" id="username"/>
            <br />
            <label for="password">Password</label>
            <input class="usrNpas" type="password" name="password" id="password"/>
            <input class="loginSubmit" type="submit" name="registerSubmit" value="Register" onclick="return loginCheck();"/>
            <br />
        </div>

    </form>

    	<?php

            // When the user hits register.
            if (isset($_POST["registerSubmit"]))
            {
                // Grab credentials.
                $inputUser = $_POST["username"];
                $inputPass = $_POST["password"];
                require_once("connect-db.php");
                $sanitizedUser = strip_tags($inputUser);
                if ($sanitizedUser != $inputUser)
                {
                    echo "<p>Your username had to be sanitized. Your registered username is $sanitizedUser</p>";
                } 

                // Ensures username not taken.
                $sql = "SELECT `username` FROM `users` WHERE `username`='$sanitizedUser' UNION SELECT `username` FROM `anonymoususers` WHERE `username`='$sanitizedUser'";

                if ($result = mysqli_query($dbLocalhost, $sql))
                {
                    $arrResult = mysqli_fetch_array($result);
                    if (sizeof($arrResult) > 0)
                    {
                        echo "<p>There is already a user with this username. Try something else.</p>";
                    }
                    else
                    {
                        // Adds credentials to database, thus registering user.
                        $sql = "INSERT INTO `users` VALUES ('$sanitizedUser', '$inputPass')";
                        if ($result = mysqli_query($dbLocalhost, $sql))
                        {
                            echo "<p>You have been registered in the system.</p>";

                        }
                        else
                        {
                            echo "<p>Error, you haven't been added.</p>";
                            echo mysqli_error($dbLocalhost);
                        }
                    }
                }
                else
                {
                    echo mysqli_error($dbLocalhost);
                }

            }

        ?>

        <hr class="line">
        <a href="./login.php"><button class="loginSubmit">Login</button></a>
        <br/>
        <a href="./index.php"><button class="loginSubmit">Back to Main Page</button></a>
</body>
</html>