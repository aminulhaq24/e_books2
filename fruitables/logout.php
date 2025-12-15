<?php
// logout.php
session_start();

// Clear session
$_SESSION = [];

// Destroy session
session_destroy();

// Clear remember me cookie
if(isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, "/");
}

// Redirect to home
header("Location: index.php");
exit;
?>