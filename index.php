<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="home">
        <div>
            <img src="img/Xwitter.png">
        </div>

        <div>
            <p><a href="login.php">Log in</a>
        </div>

        <div>
            <a href="signup.html">sign up</a></p>
        </div>
    </div>
</body>
</html>
    
    
    
    
    
    
    
    
    
    
    