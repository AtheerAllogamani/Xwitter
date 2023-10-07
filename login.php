<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: main.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="home">
        <h1 style="color: aliceblue;">Login</h1>

        <?php if ($is_invalid): ?>
            <em>Invalid login</em>
        <?php endif; ?>
        <style>
        input{
            margin-bottom: 7px;
            border: 1px solid #05314c;
            border-radius: 10px;
            height: 30px;
            width: 300px;
        }
    </style>
        <div class="form">
            <form method="post">
                <input type="email" name="email" id="email" placeholder="email"
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"><br>
                <input type="password" name="password" id="password" placeholder="password"><br>
                
                <button>Log in</button>
            </form>
        </div>
    </div>
</body>
</html>
