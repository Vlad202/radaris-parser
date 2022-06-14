<?php
require_once '../login/verifycation.php';
require_once '../login/config.php';

$stmt = $con->prepare('SELECT id, app_id, login, password FROM apps_credentials WHERE app_id = "radaris"');
$stmt->execute();
//$stmt->store_result();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$parser_login = $data['login'];
$parser_pass = $data['password'];

$stmt->close();
$con->close();

?>
<div class="container">
    <main>
        <div class="py-5 text-center">
            <h2>Парсинг данных Radaris</h2>
        </div>
        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Аккаунт Radaris</span>
                </h4>
                <form method="post" action="/apps/radaris/helpers/change_credentials.php" class="card p-2">
                    <div class="col-12 form-radaris-login">
                        <input type="text" value="<?php echo $parser_login ?>" class="form-control" name="login" id="login" placeholder="Логин" required>
                        <div class="invalid-feedback">
                            Введите логин!
                        </div>
                    </div>
                    <div class="col-12 form-radaris-login">
                        <input type="password" value="<?php echo $parser_pass ?>" class="form-control" name="password" id="password" placeholder="Пароль" required>
                        <div class="invalid-feedback">
                            Введите пароль!
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary form-radaris-login">Обновить данные</button>
                </form>
            </div>
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Поиск запросов Radaris</h4>
                <form class="needs-validation" method="get" action="/data/parse.php">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="search_name" name="search_name" placeholder="Имя и фамилия" value="<?php echo $_GET['search_name'] ?>" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Локация</label>
                            <input type="text" class="form-control" id="search_location" name="search_location" placeholder="Город, штат" value="<?php echo $_GET['search_location'] ?>">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
                    </div>
                    <hr />
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Поиск</button>
                </form>
            </div>
        </div>
    </main>
    <hr />
    <?php
        if ($_GET['status'] == 'success') {
            ?>
            <div class="alert alert-success" role="alert">
                Отчёт успешно сохранён!
            </div>
            <?php
        } else if ($_GET['status'] == 'error_params') {
            ?>
            <div class="alert alert-danger" role="alert">
                Невозможно сохранить отчёт, нехватает параметров. Убедитесь, что вы отправили запрос корректно или перезагрузите страницу.
            </div>
            <?php
        } else if ($_GET['status'] == 'error') {
            ?>
            <div class="alert alert-danger" role="alert">
                Не удалось загрузить страницу! Иногда сервис блокирует запросы на определённые отчёты, попробуйте подождать.
            </div>
            <?php
        }
    ?>
    <main>
        <?php
        if ($_GET['search_name']) {
            require 'helpers/check_auth.php';
            foreach ($data as $card) {
            ?>
                <div class="card" style="margin: 20px 0;">
                    <div class="card-header">
                        <h3><?php echo $card['name'] ?></h3>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title"><?php echo $card['age'] ?></h6>
                        <p class="card-text"><?php echo $card['addr'] ?></p>
                        <p class="card-text"><?php echo implode(' | ', $card['also_known_as']) ?></p>
                        <p class="card-text"><?php echo implode (' | ', $card['has_lived_in']) ?></p>

                        <form method="post" action="/apps/radaris/helpers/store_report.php">
                            <input type="hidden" value="<?php echo 'https://radaris.com' . $card['href'] ?>"  name="url" id="url" required>
                            <input type="hidden" value="<?php echo $COOKIE[0] ?>" class="form-control" name="cookie" id="cookie" required>
                            <input type="hidden" value="<?php echo $_SERVER['REQUEST_URI'] ?>" class="form-control" name="back_url" id="back_url" required>
                            <button type="submit" class="btn btn-primary form-radaris-login">Сохранить отчёт</button>
                        </form>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </main>
</div>