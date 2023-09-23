<?php

session_start();

$status = $statusMsg = '';

if (isset($_SESSION["user_id"])) {
    $mysqli = require_once __DIR__ . "/database.php";

    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();


if (isset($_POST["submit"])) {
    $status = 'error';
    if (!empty($_FILES["image"]["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            // Update the user table with the image content
            $update = $mysqli->query("UPDATE user SET profile_pic = '$imgContent' WHERE id = {$_SESSION["user_id"]}");

            if ($update) {
                $status = 'success';
                header("Location: profile.php");
            } else {
                $statusMsg = "File upload failed, please try again.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select an image file to upload.';
    }


$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$updated = $mysqli->query("UPDATE user SET name='$user_name', email='$user_email' WHERE id = {$_SESSION["user_id"]}");

        if ($updated) {
            $status = 'success';
            header("Location: main.php");
    } else if (empty($_POST["user_name"])) {
        $user_name = $name;
    }

}

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        .upper{
            margin-top: 50px;
            margin-right: 3%;
        }
    </style>
    <div class="container">
        <a href="main.php"><img src="img/Xwitter.png"></a>
        <div class="upper">
            <?php if (isset($user)): ?>
                <p><a href="logout.php">Log out</a></p>
            <?php else: ?>
                <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="form">
        <form action="" method="POST" enctype="multipart/form-data">
            <img src="<?php echo isset($user['profile_pic']) ? 'data:image/jpeg;base64,' . base64_encode($user['profile_pic']) : ''; ?>" id="profilePic">          
            <div>
            <input type="file" id="fileInput" name="image" accept="image/*" onchange="changeProfilePic(event)">
            </div>
            <div>
               <input type="text" name="user_name" placeholder="new name">
            </div>
            <div>
              <input type="text" name="user_email" placeholder="new email">
            </div>
            <div>
             <input type="submit" name="submit" value="Upload">  
            </div>
        </form>           
    </div>
</body>
<script src="script.js"></script>
</html>