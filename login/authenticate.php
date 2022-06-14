<?php
require_once './config.php';

if (!$_POST['email'] || !$_POST['password'] ) {
    header('Location: '. $_SERVER["HTTPS"].'/index.php?e=auth_incorrect');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['email'];
            $_SESSION['id'] = $id;
            header('Location: '. $_SERVER["HTTPS"].'/index.php');
        } else {
            header('Location: '. $_SERVER["HTTPS"].'/index.php?e=auth_incorrect');
        }
    } else {
        header('Location: '. $_SERVER["HTTPS"].'/index.php?e=auth_incorrect');
    }

    $stmt->close();
}
?>