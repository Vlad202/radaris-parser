<?php
session_start();
?>
<div class="alert alert-danger" role="alert">
    <?php
        if ($_GET['e'] == 'auth_incorrect') {
            echo 'Неверный логин или пароль';
        }
    ?>
</div>