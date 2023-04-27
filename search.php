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
<html lang="en">
<head>
    <title>Movie Search Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #rating-form {
        max-width: 400px;
        margin: 0 auto;
        }

        .form-label-bold {
        font-weight: bold;
        color: red;
        }

        .form-group {
        margin-bottom: 1rem;
        }

        .form-control-wrapper {
        display: flex;
        align-items: center;
        }

        .form-control {
        flex: 1;
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 0.5rem;
        font-size: 1rem;
        }

        .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-group-submit {
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .btn-primary {
        color: #fff;
        background-color: red;
        border-color: red;
        }

        .btn-primary:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        }

        .btn-primary:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5);
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

    <section>
        <div class = "search-container">
            <div class = "search-element">
            <h3>Search Movie:</h3>
            <input type = "text" class = "form-control" placeholder="Search Movie Title ..." id = "movie-search-box" onkeyup="findMovies()" onclick = "findMovies()">
                <div class = "search-list" id = "search-list"></div>
            </div>
        </div>
        <div class = "container">
        <div class = "result-container">
            <div class = "result-grid" id = "result-grid"></div>
            <br>
            <br>
            <form id="rating-form" action="submit_rating.php" method="POST">
                <div class="form-group">
                    <label for="movie_id"><span class="form-label-bold">Movie ID:</span></label>
                    <div class="form-control-wrapper">
                        <input type="text" id="movie_id" name="movie_id" class="form-control" value="" readonly>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="rating"><span class="form-label-bold">Rating:</span></label>
                    <div class="form-control-wrapper">
                        <input type="text" id="rating" name="rating" class="form-control" pattern="[0-9]*[.,]?[0-9]+" required>
                        <span class="form-control-after"></span>
                    </div>
                </div>
                <div class="form-group-submit">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
        </div>
    <script src = "search_script.js"></script>
    </section>
</body>
<footer>
<p>&copy; 2023 CinemaCitizen.
</footer>  

</html>
