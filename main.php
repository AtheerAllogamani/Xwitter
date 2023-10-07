<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();

    if (isset($_POST["submit"])) {
        $status = '';
        $user_input = $_POST["user_input"]; 
        if (empty($user_input)) {
            $status = "You have to write something";
        } else {
            $user_id = $_SESSION["user_id"];
            $updated = $mysqli->query("INSERT INTO posts (content, user_id) VALUES ('$user_input', {$_SESSION["user_id"]})");
            header("Location: main.php");
            exit;
        }
    }
    
    $posts = $mysqli->query("SELECT * FROM posts ORDER BY post_id DESC");
    
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
        .container {
        display: flex;
        justify-content: space-around;
        text-align: center;
        background-color: #05314c;
        margin: 0 auto;
        }

        .upper{
            margin-top: 50px;
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
        display: inline-flexbox;
        color: aliceblue;
        list-style-type: none;
        background-color: #232323;
        padding: 15px;
        border: 2px solid aliceblue;
        border-radius: 15px;
        width: 70%;
        }

        #output:before {
            content: "";
            display: inline-flex;
            background-size: cover;
            margin-right: 10px;
            background-image: url('<?php echo isset($user['profile_pic']) && !empty($user['profile_pic']) ? 'data:image/jpeg;base64,' . base64_encode($user['profile_pic']) : '/img/default-profile-pic.png'; ?>');
            border: 2px solid aliceblue;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            
        }
        .name {
            position: absolute;
            font-weight: bold;
            content: "";
        }

        .profileContiner{
            display: inline-flexbox;
            flex-direction: row;  
            margin-left: 3%;
            margin-right: 3%;
            padding: 2%;
            width: 15%;
            background-color: aliceblue;
            text-align: center;
            border: 1px solid #05314c;
            border-radius: 25px;
        }

        .outer-container{
        display: flex;  
        flex-direction: row;    
        }
        .inner-container{
            display: flex;  
            flex-direction: column;   
            width: 70%;
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
        <input type="submit" name="submit" value="POST">
    </form>
    <div class="outer-container">
        <div class="profileContiner">
            <img src="<?php echo isset($user['profile_pic']) ? 'data:image/jpeg;base64,' . base64_encode($user['profile_pic']) : '/img/icon.jpg'; ?>" id="profilePic">
            <p><strong>Name: </strong><?= htmlspecialchars($user["name"]) ?></p>
            <p><strong>Email: </strong><?= htmlspecialchars($user["email"]) ?></p>
            <a href="edit_profile.php" class="button" style="text-decoration: underline; color:#05314c;"><strong>Edit Profile</strong></a>
        </div>
        <div class="inner-container">
            <?php while ($row = $posts->fetch_assoc()) { ?>
                <p id="output">
                    <span class="name"><?php echo htmlspecialchars($user['name']); ?></span>
                    <?php echo htmlspecialchars($row["content"]); ?>
                </p>
            <?php } ?>
        </div>
    </div>
</body>
<script src="script.js"></script>
</html>
