<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Auth Helpers */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
