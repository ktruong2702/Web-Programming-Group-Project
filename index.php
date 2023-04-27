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
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <style>
    .user-icon {
    float: right;
    background-color: white;
    border-radius: 50%;
    padding: 10px;
    }
    .user-icon img {
      width: 20px;
      height:20px;
    }

  </style>
</head>
<body>
<header>
    <h1>CinemaCitizen</h1>
    <a href="user_table.php" class="user-icon"> <img src="user-icon.png" alt="Sign Up"></a>
    <div class="user-info">
      <?php if (isset($user)): ?>
        <div style="background-color: white; padding: 10px; border-radius: 5px;">
            <p style="color:black;">Hello, <?= htmlspecialchars($user["name"]) ?></p>
            <p><a href="logout.php" style="color: red;">Log out</a></p>
        </div>
      <?php else: ?>
        <div style="background-color: white; padding: 10px; border-radius: 5px; color: black">
            <p><a href="login.php" style="color:red;">Log in</a> or <a href="signup.html" style="color:red;">Sign up</a></p>
        </div>
      <?php endif; ?>
    </div>
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="search.php">Search Movies</a></li>
        <li><a href="about.php">About & Contact</a></li>
        <li><a href="ratings_table.php">Your Ratings</a></li>
      </ul>
    </nav>
    </header>
</body>
<br>
<br>
<footer>
    <p>&copy; 2023 CinemaCitizen.
</footer>
</html>