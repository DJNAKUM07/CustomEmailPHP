<?php
// auth.php

session_start();

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isUserLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
?>
