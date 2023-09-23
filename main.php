<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

if (isset($_POST["post"])) {
    $status = 'error';
    $user_input = $_POST["user_input"];
    $updated = $mysqli->query("UPDATE user SET post='$user_input' WHERE id = {$_SESSION["user_id"]}");

    if ($updated) {
        $status = 'success';
    } else {
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Xwitter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
        .upper{
            margin-top: 50px;
            margin-right: 3%;
        }

        input[type=text] {
        margin-top: 3%;
        margin-bottom: 1%;
        width: 80%;
        margin-left: 3%;
        border: 1px solid #05314c;
        }   

        input[type=submit] {
            color: #05314c;
            background-color: aliceblue;
            border-radius: 15px;
            margin-right: 3%;
            width: 5%;
        }

        #output {
        color: aliceblue;
        list-style-type: none;
        flex-direction: column-reverse;
        margin: 5px;
        background-color: #232323;
        padding: 15px;
        border: 2px solid aliceblue;
        border-radius: 15px;
        width: 70%;
        margin-left: 25%;
        }
        #output:before {
            content: "";
            display: inline-block;
            background-size: cover;
            margin-right: 10px;
            background-image: url('<?php echo isset($user['profile_pic']) ? 'data:image/jpeg;base64,' . base64_encode($user['profile_pic']) : '/img/default-profile-pic.jpg'; ?>');
            border: 2px solid aliceblue;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            
        }
        #output:after {
            position: absolute;
            font-weight: bold;
            content: "<?php echo htmlspecialchars($user['name']); ?>";
        }

        .profileContiner{
            margin-left: 3%;
            padding: 2%;
            width: 15%;
            background-color: aliceblue;
            text-align: center;
            border: 1px solid #05314c;
            border-radius: 25px;
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

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="user_input" placeholder="write your thoughts">
        <input type="submit" onclick="displayInput()" name="post" value="POST">
    </form>

    <p id="output"><?= htmlspecialchars($user["post"]) ?></p>

    <div class="profileContiner">
        <img src="<?php echo isset($user['profile_pic']) ? 'data:image/jpeg;base64,' . base64_encode($user['profile_pic']) : '/img/icon.jpg'; ?>" id="profilePic">
        <p><strong>Name: </strong><?= htmlspecialchars($user["name"]) ?></p>
        <p><strong>Email: </strong><?= htmlspecialchars($user["email"]) ?></p>
        <a href="edit_profile.php" class="button" style="text-decoration: underline; color:#05314c;"><strong>Edit Profile</strong></a>
    </div>

</body>
<script src="script.js"></script>
</html>