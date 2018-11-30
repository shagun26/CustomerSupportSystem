<?php
if (!is_dir("./uploads"))
{
    mkdir('./uploads', 0777, true);
}
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <title>Main Page</title>
</head>
<body>
    <form action="" method="post">
        <h3 id="login2">Cyber Warriors' Help Desk System</h3>

        <div class="search-container">
                <form action="" method="POST">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit" name="submitsearch">Submit</button>
            </form>
        </div>

        <div class="loginPage">
            <h4 class="question">

                <a class="userType" id="asHelp" href="./login.php">Help Desk User</a>
                <p>OR</p>
                <a class="userType" id="asAnon" href="./anonSetup.php">Anonymous User</a>
            </h4>
        </div>
    </form>

    <?php

        if (isset($_POST["submitsearch"]) && isset($_POST["search"]))
        { 
            $search = $_POST["search"];

            if ($search == "login")
            {
                echo "<script type='text/javascript'> location.href='./login.php'; </script>";
            }
            else if ($search == "register")
            {
                echo "<script type='text/javascript'> location.href='./register.php'; </script>";
            }
            else if ( strpos($search, 'anonymous') !== false || strpos($search, 'anon') !== false)
            {
                echo "<script type='text/javascript'> location.href='./anonSetup.php'; </script>";
            }
            else if ( strpos($search, 'help desk') !== false)
            {
                echo "<script type='text/javascript'> location.href='./login.php'; </script>";
            }
            else if (  strpos($search, 'main') !== false)
            {
                echo "<script type='text/javascript'> location.href='./index.php'; </script>";
            }
            else
            {
                echo "Sorry, not sure what you are searching. Please message Group B if you think it should be searchable.";
            }
        }

    ?>


</body>
</html>