<?php

session_start();

header('Content-Type: application/json');

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode([
            "id" => $user["id"],
            "name" => $user["name"],
            "email" => $user["email"]
        ]);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}

?>