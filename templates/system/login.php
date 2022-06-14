<?php
session_start();
?>
<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-md-10 mx-auto col-lg-5">
            <form method="post" action="/login/authenticate.php" class="p-4 p-md-5 border rounded-3 bg-light">
                <h1 class="display-6">Авторизация</h1>
                <hr class="my-4">
                <div class="form-floating mb-3">
                    <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Логин</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Пароль</label>
                </div>
                <?php
                    if ($_GET['e']) {
                        include 'templates/system/bad_notify.php';
                    }
                ?>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
            </form>
        </div>
    </div>
</div>