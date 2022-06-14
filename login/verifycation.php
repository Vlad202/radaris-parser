<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: '. $_SERVER["HTTPS"].'/index.php');
    exit;
}

function is_active($path) {
    $current_path = explode('?', $_SERVER['REQUEST_URI'])[0];
    return $path == $current_path ? 'active' : '';
}
?>