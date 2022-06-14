<?php
session_start();
$DATABASE_HOST = "************";
$DATABASE_USER = "************";
$DATABASE_PASS = "************";
$DATABASE_NAME = "************";

$con = new mysqli("$DATABASE_HOST", "$DATABASE_USER", "$DATABASE_PASS", "$DATABASE_NAME");
if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

?>