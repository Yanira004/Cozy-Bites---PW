<?php
session_start();

$_SESSION = array();

session_destroy();

if (isset($_COOKIE['user_login'])) {
    setcookie("user_login", "", time() - 3600, "/");
}

header("Location: login.php");
exit();
?>