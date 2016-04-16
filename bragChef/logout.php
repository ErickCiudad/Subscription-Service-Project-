<?php
    // if the user is logged in, delete the cookie
    if (isset($_COOKIE['email'])) {
        setcookie('email', '', time() - 3600);
        setcookie('email', '', time() - 3600);
    }
    // Redirect to the home page
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ' ';
    header('Location: ' . $home_url);
?>