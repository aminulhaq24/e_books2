<?php

function getUserData() {
    global $con;

    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    $id = (int) $_SESSION['user_id'];
    $res = mysqli_query($con, "SELECT * FROM users WHERE id = $id");

    return mysqli_fetch_assoc($res);
}
?>