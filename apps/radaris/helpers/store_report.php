<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/login/verifycation.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/login/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/apps/radaris/helpers/requests.php';
require_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";

use PHPHtmlParser\Dom;

if (!$_POST['url'] || !$_POST['cookie']) {
    header('Location: '.$_POST['back_url']  . '&status=error_params');
    exit;
};
$opts = array(
    'http'=>array(
        'method'=>"GET",
        'header'=>"Accept-language: en\r\n" .
            $_POST['cookie']."; _pgt=B23A; session=f141ad4141572674660553b9ce5f865a\r\n"
    )
);
$context = stream_context_create($opts);
$response = file_get_contents($_POST['url'], false, $context);

//$response = get_request($_POST['url'], null, Array($_POST['cookie']));
$response = json_decode($response, true);
preg_match('/i-(.*?)\?/', $response['/Rdf.go'], $match);

if (!$match[1]) {
    header('Location: '.$_POST['back_url'] . '&status=error');
    exit;
}
$response = get_request('https://radaris.com/ng/report/a.report_body?i='.$match[1], null, Array($_POST['cookie']));

$dom = new Dom;
$dom = $dom->loadStr($response);

$data = [];
// get name
$data['name'] = $dom->find('.summary-title .name')->text;
// get address
$last_knon_address = [];
foreach ($dom->find('.addr-cont')[0]->find('span') as $span) {
    $last_known_address[] = $span->text;
}
$data['last_known_address'] = implode(' ', $last_known_address);
// get date of birth
$data['date_of_birth'] = $dom->find('.fs_ph')[1]->text;
// age
$data['age'] = $dom->find('.fs_ph')[2]->text;
// social security numbers
//echo $response;
$nums = $dom->find('.block-ssn')->find('.content-item_title');
if ($nums) {
    $social_security_numbers = [];
    foreach ($nums as $num) {
        $social_security_numbers[] = $num->text;
    }
    $data['social_security_numbers'] = implode(', ', $social_security_numbers);
}

$stmt = $con->prepare("INSERT INTO radaris_data (lead_id, name, last_known_address, date_of_birth, age, social_security_numbers) VALUES (?, ?, ?, ?, ?, ?); ");
if($stmt == false) die("Secured prepare");
$result = $stmt->bind_param("ssssss", $match[1], $data['name'], $data['last_known_address'], $data['date_of_birth'], $data['age'], $data['social_security_numbers']);
if($result == false) die("Secured bind");
$result = $stmt->execute();
if($result == false) die("Secured execute");

header('Location: '.$_POST['back_url'] . '&status=success');

$con->close();
?>