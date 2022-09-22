<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/ContactDao.php';
include './../../../config.php';
$contactDao = new ContactDao($proyect);
if (isset($_POST['contact_id'])) {
    $contact_id = $_POST['contact_id'];
    $contact_rs = $contactDao->selectById($contact_id);
    $array = array();
    $contact_r = mysqli_fetch_assoc($contact_rs);
    echo json_encode($contact_r);
} else {
    echo json_encode(false);
}
