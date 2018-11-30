<?php
    // Opens the session and ensures that the user is signed in.
    session_start();
    if (!isset($_SESSION["anonName"]))
    {
        echo "<script type='text/javascript'> location.href='./anonSetup.html'; </script>";
        exit;
    }
    $helper = $_SESSION["helper"];
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
    <h1 id="login2">Anonymous User Chat: File Upload</h1>
    <div class="loginPage">

    <a href="./anonMain.php"><button class="annoLeave">Back To Chat</button></a>


    <form action="" method="POST" enctype="multipart/form-data">
        <p class="annoSetup">To: <?php echo "$helper"; ?></p>
        <div class="annoMainPage">
        <input type="file" class="annoInput" name="file" id="file">
        <input type="submit" class="annoSubmit" name="submit" id="submit" value = "Send" >
        </div>
    </form>
    <br />
    <form action="" method="POST">
        <div class="annoMainPage">
        <label for="deleteID">Delete File #</label>
        <br />
        <input type="number" class="annoInput" name="deleteID" pattern="[0-9]">
        <input type="submit" class="annoSubmit" name="delete" value="Delete">
        </div>
    </form>

    

    
    <?php 

  
$username = $_SESSION["anonName"];
require_once("connect-db.php");

    // If delete button was clicked.

    if (isset($_POST["delete"]))
    {
        // Look at the file ID that will be deleted.
        $id = $_POST["deleteID"];

        // Grab the file name.
        $sql = "SELECT `name` FROM `files` WHERE `fid`='$id' AND `from`='$username'";

        if ($result = mysqli_query($dbLocalhost, $sql))
        {
            // Delete the file from server with matching name.
            $row = mysqli_fetch_row($result);
            $fileName = $row[0];
            unlink("./uploads/" . $username . "/" . $fileName);
            // Delete file from database.
            $sql = "DELETE FROM `files` WHERE `fid`='$id' AND `from`='$username'";
            mysqli_query($dbLocalhost, $sql);
        }
        else
        {
            echo mysqli_error($dbLocalhost);
        }



    }

    // Look at all files sent from this user.
    $sql = "SELECT * FROM `files` WHERE `from`='$username'";
    
    if ($result = mysqli_query($dbLocalhost, $sql))
    {
        // List the files.
        while ($row = mysqli_fetch_row($result))
        {
            echo "<p class='annoSetup'>ID: $row[0]  <br />  From: $row[1]  <br />  To: $row[2]</p>";
            echo "<p class='annoSetup'>Name: $row[3]</p>";
            echo "<br>";
        }
    }
    else
    {
        echo mysqli_error($dbLocalhost);
    }




    // If they submitted a file. The tutorial at https://www.w3schools.com/php/php_file_upload.asp was referenced.
if (isset($_POST["submit"]))
{
    // File details
    $target_dir = "./uploads/" . $username . "/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $uploaded = 0;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // If file is uploaded, check if image.
    if ($_FILES["file"]["tmp_name"] != null)
    {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
    }
    // If no file selected, warn.
    else
    {
        echo "<p>You did not select a file.</p>";
    }

    if (isset($check))
    {
        // If file is not an image.
        if ($check == false)
        {
            echo "<p>That file is not an image. Only images are supported.</p>";
            $uploadOk = 0;
        }
        // If file is already in system.
        if (file_exists($target_file))
        {
            echo "<p>That file already exists!</p>";
            $uploadOk = 0;
        }
        // If file is too big.
        if ($_FILES["file"]["size"] > 5000000) {
            echo "<p>That file is too large. Please provide a file smaller than 5MB./p>";
            $uploadOk = 0;
        }
        // If file is not jpg, png, or jpeg.
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
        {
            echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
            $uploadOk = 0;
        }
        // If everything so far is okay, then upload.
        if ($uploadOk == 1)
        {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) 
            {
                echo "<p>The file ". basename( $_FILES["file"]["name"]). " has been uploaded.</p>";
                $uploaded = 1;
            } else 
            {
                echo "<p>There was an error uploading your file.</p>";
            }
        }

    }

    // Set the parameters: from, to, file name.
    $from = $_SESSION["anonName"];
    $to = $helper;
    $name = $_FILES["file"]["name"];

    // If the file was successfully uploaded to the server add a reference to database.
    if ($uploaded == 1)
    {
        // Add the file to the messages database if the file was uploaded.
        $sql = "INSERT INTO `files` (`from`, `to`, `name`) VALUES ('$from', '$to', '$name')";
        if ($result = mysqli_query($dbLocalhost, $sql))
        {
            echo "<p>Success.</p>";

        }
        else
        {
            echo mysqli_error($dbLocalhost);
        }

        echo "<meta http-equiv='refresh' content='0'>";
    }

}

    ?>
    </div>
</body>
</html>