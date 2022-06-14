<?php

require '../../../login/verifycation.php';
require '../../../login/config.php';

$stmt = $con->prepare('SELECT id, app_id, login, password FROM apps_credentials WHERE app_id = "radaris"');
$stmt->execute();
$stmt->store_result();
$parser_login = $_POST['login'];
$parser_pass = $_POST['password'];

if ($stmt->num_rows > 0) {
    if ($parser_login && $parser_pass) {
        $stmt = $con->prepare("UPDATE apps_credentials SET login=?, password=? WHERE app_id = 'radaris'; ");
        if($stmt == false) die("Secured");
        $result = $stmt->bind_param("ss", $parser_login, $parser_pass);
        if($result == false) die("Secured");
        $result = $stmt->execute();
        if($result == false) die("Secured");
    }
    $stmt->bind_result($id, $app_id, $parser_login, $parser_pass);
    $stmt->fetch();
} else {
    if ($parser_login && $parser_pass) {
        $stmt = $con->prepare("INSERT INTO apps_credentials (app_id, login, password) VALUES ('radaris', ? , ? ); ");
        if($stmt == false) die("Secured");
        $result = $stmt->bind_param("ss", $parser_login, $parser_pass);
        if($result == false) die("Secured");
        $result = $stmt->execute();
        if($result == false) die("Secured");
    }
}
$stmt->close();
$con->close();

header('Location: '. $_SERVER["HTTPS"].'/data/parse.php');
?>