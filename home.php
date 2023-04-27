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
  <title>Cinema Citizen</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style2.css">
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

  <main id="home">
    <section class="box">
      <h2>Welcome to Cinema Citizen</h2>
      <p>Your go-to destination for movie ratings.</p>
      <p>Here, you can discover the ratings for all the lastest and greatest films.</p>
      <p>By creating an account, you can rate and modify movie information to contribute to our growing community.</p>
      <p>Stay tuned for the latest movie rating updates and become a part of our community today!</p>
    </section>
  </main>
  <br>
  <h1 style="text-align: center;">Popular Marvel Movies</h1>
  <div class = "movies"></div>
  <script src="movies.js"></script>


  </body>
  <footer>
    <p>&copy; 2023 CinemaCitizen
  </footer>  

</html>