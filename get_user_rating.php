<?php

session_start();

if (isset($_SESSION["user_id"]) && isset($_GET["movie_id"])) {
    $movie_id = $_GET["movie_id"];
    $user_id = $_SESSION["user_id"];
    
    // Query the database for the user's rating for this movie
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT rating FROM user_ratings
            WHERE user_id = $user_id AND movie_id = '$movie_id'";
    $result = $mysqli->query($sql);
    
    // Return the rating as JSON
    $rating = null;
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rating = $row["rating"];
    }
    echo json_encode(["rating" => $rating]);
}

?>
