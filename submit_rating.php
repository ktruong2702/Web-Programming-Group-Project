<?php
session_start();

// connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'login_db';
$conn = mysqli_connect($host, $username, $password, $dbname);
if (mysqli_connect_errno()) {
  die('Failed to connect to database: ' . mysqli_connect_error());
}

try {
  // check if the user is logged in
  if (!isset($_SESSION['user_id'])) {
    throw new Exception('User not logged in');
  }

  // get the user id from the session and movie id from the form data
  $user_id = $_SESSION['user_id'];
  $movie_id = $_POST['movie_id']; // This line will now accept the movie_id from user's input

  // check if the movie ID is provided
  if (empty($movie_id)) {
    throw new Exception('Movie ID is missing');
  }

  var_dump($_POST); // Add this line to output the contents of the $_POST array
  echo "user ID: " . $user_id . "<br>"; // Add this line to output the movie ID
  echo "Movie ID: " . $movie_id . "<br>"; // Add this line to output the movie ID

  // check if the user exists
  $user_query = "SELECT * FROM user WHERE id=?";
  $stmt = mysqli_prepare($conn, $user_query);
  mysqli_stmt_bind_param($stmt, 'i', $user_id);
  mysqli_stmt_execute($stmt);
  $user_result = mysqli_stmt_get_result($stmt);
  if (mysqli_num_rows($user_result) == 0) {
    throw new Exception('User does not exist');
  }

  // check if the user has already rated the movie
  $check_query = "SELECT * FROM ratings WHERE user_id=? AND movie_id=?";
  $stmt = mysqli_prepare($conn, $check_query);
  mysqli_stmt_bind_param($stmt, 'is', $user_id, $movie_id);
  mysqli_stmt_execute($stmt);
  $check_result = mysqli_stmt_get_result($stmt);
  $rating = $_POST['rating']; // Moved this line up to avoid repetition

  if (mysqli_num_rows($check_result) > 0) {
    // update the existing rating
    $update_query = "UPDATE ratings SET rating=? WHERE user_id=? AND movie_id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 'dis', $rating, $user_id, $movie_id);
  } else {
    // insert a new rating
    $insert_query = "INSERT INTO ratings (user_id, movie_id, rating) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, 'isd', $user_id, $movie_id, $rating);
    mysqli_stmt_execute($stmt);
  }

  // close the database connection
  mysqli_close($conn);

  // redirect back to the movie details page
  header("Location: " . $_SERVER['HTTP_REFERER']);
  exit();
} catch (Exception $e) {
  // handle the error
  echo '<body style="background-color: black;">
          <div style="color: white; font-size: 24px; padding: 20px; text-align: center; margin: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div style="color: #e74c3c; font-size: 30px; margin-bottom: 20px;">Error Occurs</div>
            ' . $e->getMessage() . '<br><br>
            <a href="login.php" style="color: #e74c3c; text-decoration: none;">Login</a> or 
            <a href="signup.php" style="color: #e74c3c; text-decoration: none;">Sign up</a> here<br><br>
            <a href="javascript:history.go(-1)" style="color: #e74c3c; text-decoration: none;">Go to previous page</a>
          </div>
      </body>';
}
?>
