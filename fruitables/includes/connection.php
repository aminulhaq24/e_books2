<?php
$con = mysqli_connect("localhost", "root", "", "ebook_system_new");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// // 2. Start Session if not already started
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

// // 3. Helper Functions for Authentication
// function isLoggedIn() {
//     return isset($_SESSION['user_id']);
// }

// function isAdmin() {
//     return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
// }

// function getUserData($con) {
//     if (isLoggedIn()) {
//         $user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
//         $query = "SELECT * FROM users WHERE id = '$user_id'";
//         $result = mysqli_query($con, $query);
//         return mysqli_fetch_assoc($result);
//     }
//     return null;
// }
?>