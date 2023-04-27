<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE name = '%s'",
                   $mysqli->real_escape_string($_POST["name"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
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
    <style>
    form {
        margin: 50px auto;
        width: 300px;
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 10px;
        color: red;
    }

    input {
        padding: 10px;
        margin-bottom: 20px;
        width: 100%;
        border: none;
        border-radius: 5px;
        background-color: #333;
        color: white;
    }

    button {
        padding: 10px 20px;
        margin-top: 20px;
        border: none;
        border-radius: 5px;
        background-color: red;
        color: white;
        cursor: pointer;
    }

    button:hover {
        background-color: #cc0000;
    }
    </style>
</head>
<body>
    <header>
          <h1>CinemaCitizen</h1>
          <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="search.php">Search Movies</a></li>
                <li><a href="about.php">About & Contact</a></li>
                <li><a href="ratings_table.php">Your Ratings</a></li>
            </ul>
          </nav>
    </header>
    
    <h2>Login</h2>
    
    <?php if ($is_invalid): ?>
        <em style="text-align: center;">Invalid login</em>
    <?php endif; ?>

    
    <form method="post">
        <label for="name">Username</label>
        <input type="name" name="name" id="name"
               value="<?= htmlspecialchars($_POST["name"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button>Log in</button>
    </form>
    <p style="text-align: center;">Do not have an account? <a  href="signup.html" style="color: red">Sign up here</a>.</p>

    </body>
    <footer>
        <p>&copy; 2023 CinemaCitizen.
    </footer> 
</html>