<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/login/verifycation.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/login/config.php';

$stmt = $con->prepare('SELECT * FROM radaris_data');
$stmt->execute();
//$stmt->store_result();
$result = $stmt->get_result();
$fields = [];
while ($fetch = $result->fetch_assoc()) {
    $fetch['last_known_address'] = str_replace('&nbsp;', ' ', $fetch['last_known_address']);
    $fields[] = $fetch;
}
$fields = json_encode($fields);
echo "var fields ='$fields';";
$stmt->close();
$con->close();

?>