<!DOCTYPE html>
<html>

<head>
  <title>Cinema Citizen</title>
  <link rel="stylesheet" href="style.css">
    <style>
        .msg {
        font-size: 50px;
        font-weight: bold;
        text-align: center;
        margin: 0 auto;
        max-width: 80%; /* Set a maximum width to limit the message width */
        }
    </style>
</head>

<body>

  <header>
    <h1>CinemaCitizen</h1>
    <a href="#" class="user-icon"> <img src="user-icon.png" alt="Sign Up"></a>
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

    <br>
    <br>

    <body>
    <?php
    // Establish a connection to the database
    $conn = mysqli_connect("localhost", "root", "", "login_db");

    // Retrieve the user ID from the form data
    $name = $_POST["name"];
    // Delete the associated ratings data from the database
    $sql_ratings = "DELETE FROM ratings WHERE user_id = (SELECT id FROM user WHERE name = '$name')";
    if (mysqli_query($conn, $sql_ratings)) {
        echo "<p class='msg'> Ratings associated with username '$name' has been deleted</p>";
    } else {
        echo "<p class='msg'> Error deleting ratings data: </p>" . mysqli_error($conn);
    }

    echo "<br>";
    echo "<br>";


    // Delete the user data from the database
    $sql = "DELETE FROM user WHERE name ='$name'";
    if (mysqli_query($conn, $sql)) {
        echo "<p class='msg'> Username '$name' deleted successfully </p>";
    } else {
        echo "<p class='msg'> Error deleting user data: </p>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
    </body>

    <br>
    <br>

    <footer>
        <p>&copy; 2023 CinemaCitizen.
    </footer>  
</html>