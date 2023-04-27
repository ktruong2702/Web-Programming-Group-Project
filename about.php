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
  <main id="about">
    <section class="about">
      <h2>About Us</h2>
      <p>Cinema Citizen is a comprehensive online movie and TV show database, providing information about movies, TV
        shows, actors, and more. Our mission is to help movie and TV show enthusiasts discover and explore new content,
        read reviews, and engage with other users in a community-driven platform.</p>
    </section>
  </main>



  <main id="contact-us">
    <section class="contact">
        <h2>Contact Us</h2>
        <p>If you have any questions, feedback, or inquiries, please feel free to get in touch with us using the contact form below:</p>
        <form>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
          
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
          
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
          
            <input type="submit" value="Submit">
        </form>
    </section>
  </main>

  <!-- HTML code for social media section with online image URLs -->
    <section class="social-media">
        <h3 style = "margin-left: 10px">Follow us on social media:</h3>
        <ul class= "social-media-icons">
        <li class="discord-icon"><a href="https://discord.gg/gaRbFHDg" target="_blank"><img src="discord-mark-white.png" alt="Discord"></a></li>
        <li class="twitter-icon"><a href="https://twitter.com/" target="_blank"><img src="twitter.png" alt="Twitter"></a></li>
        <li class="facebook-icon"><a href="https://www.facebook.com/" target="_blank"><img src="facebook.png" alt="Facebook"></a></li>
        </ul>
    </section>
  
  
  <footer>
    <p>&copy; 2023 CinemaCitizen.
  </footer>  
</html>