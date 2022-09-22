<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/ContactDao.php';
include './../../../config.php';
$contactDao = new ContactDao($proyect);
$contact_rs = $contactDao->select();
$array = array();
while ($contact_r = mysqli_fetch_assoc($contact_rs)) {
    $array[] = $contact_r;
}
echo json_encode($array);
