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
    <style>
        table {
        border-collapse: collapse;
        width: 60%;
        }

        th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        width: calc(100% / 4); /* Divide the table width by the number of columns */
        }

        th {
        background-color: #f2f2f2;
        color: #333;
        }

        tr:hover {
        background-color: #f5f5f5;
        }

        .table-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        }

        .table-container h1 {
        margin: 0;
        margin-bottom: 10px;
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
  <br>
  
  <main id="home">

    <section class="table-container">
        <h1>Ratings Table</h1>

        <!-- this is when the user loggin only, if not the message "Please log in to view the ratings table" will display -->
        <?php if (isset($user)): ?> 

        <?php
        // Establish a connection to the database
        $conn = mysqli_connect("localhost", "root", "", "login_db");

        // Check if the connection was successful
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }
        
        // Retrieve the data from the "ratings" table
        $sql_ratings = "SELECT * FROM ratings WHERE user_id = {$_SESSION["user_id"]}";
        $result = mysqli_query($conn, $sql_ratings);

        // Display the data on the webpage
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>User ID</th><th>Movie ID</th><th>Rating</th><th>Setting</th></tr>";
            while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["user_id"] . "</td>";
            echo "<td>" . $row["movie_id"] . "</td>";
            echo "<td>" . $row["rating"] . "</td>";
            echo "<td><form method='post' action='delete_rating.php'><input type='hidden' name='id' value='" . $row["id"] . "'><button type='submit'>Delete</button></form></td>";
            echo "</tr>";
            }
            echo "</table>";
            } else {
            echo "No data found";
            }
            
            // Close the database connection
            mysqli_close($conn);
        ?>
        
        <?php else: ?>
            <p>Please log in to view your ratings history</p>
        <?php endif; ?>


    </section>
    <br>
  </main>  
  
    </body>
  <footer>
    <p>&copy; 2023 CinemaCitizen.
  </footer>  
</html>
