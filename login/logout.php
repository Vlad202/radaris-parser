<?php

session_start();
unset($_SESSION["id"]);
unset($_SESSION["name"]);
unset($_SESSION["loggedin"]);
header('Location: '. $_SERVER["HTTPS"].'/index.php');
?>