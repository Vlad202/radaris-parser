<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/login/verifycation.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/login/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/apps/radaris/helpers/requests.php';
require_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";

use PHPHtmlParser\Dom;

if (!$parser_login || !$parser_pass) exit;
$resp = post_request('https://radaris.com/login/a.login', ['email' => $parser_login, 'password' => $parser_pass, 'remember_me' => 'on']);
if (!$resp) {
    ?>
    <div class="alert alert-danger" role="alert">
        Ошибка авторизации на сервисе Radaris, код ошибки: <?php echo $resp ?>
    </div>
    <?php
    exit;
}
$cookie = $resp['headers']['set-cookie'][1];
if (preg_match('/user_auth=(.*?);/', $cookie, $match) == 1) {
    $COOKIE = Array('Cookie: user_auth='.$match[1]);
}

$name = explode(' ', $_GET['search_name']);
$location = explode(', ', $_GET['search_location']);

$data = [];
$response = get_request('https://radaris.com/ng/search', ['ff' => $name[0], 'fl' => $name[1], 'fs' => $location[1], 'fc' => $location[0]], $COOKIE);
if (!strpos($response, 'No people found') || !strpos($response, 'PAGE NOT FOUND')) {
    $dom = new Dom;
    $dom->loadStr(($response));
    $cards = $dom->find('.teaser-card');
    foreach ($cards as $card) {
        $card_data = [];
        $name = $card->find('.card-title strong');
        $card_data['name'] = $name[0]->text . ' ' . $name[1]->text;
        $card_data['age'] = $card->find('.age')[0]->text . $card->find('.age span')[0]->text;
        $card_data['addr'] = $card->find('.many-links-item')->text;
        $also_known_as_list = $card->find('dl')[0];
        if ($also_known_as_list) {
            $also_known_as_list = $also_known_as_list->find('dd');
            foreach ($also_known_as_list as $also_known_as) {
                $card_data['also_known_as'][] = $also_known_as->text;
            }
        }
        $has_lived_in_block = $card->find('dl')[2];
        if ($has_lived_in_block) {
            $has_lived_in_list = $has_lived_in_block->find('dd');
            foreach($has_lived_in_list as $has_lived_in) {
                $card_data['has_lived_in'][] = $has_lived_in->text;
            }
        }
        $href = $card->find('.actions a')[1];
        if ($href) $card_data['href'] = $href->getAttribute('href');
        $data[] = $card_data;
    }
}

$con->close();
?>