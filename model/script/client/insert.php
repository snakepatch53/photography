<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/ClientDao.php';
include './../../../config.php';
$clientDao = new ClientDao($proyect);
if (isset(
    $_POST['client_name'],
    $_POST['client_phone'],
    $_POST['client_fb'],
    $_POST['client_mail'],
    $_POST['client_descr']
)) {
    $client_name = $_POST['client_name'];
    $client_phone = $_POST['client_phone'];
    $client_fb = $_POST['client_fb'];
    $client_mail = $_POST['client_mail'];
    $client_descr = $_POST['client_descr'];

    $clientDao->insert(
        $client_name,
        $client_phone,
        $client_fb,
        $client_mail,
        $client_descr
    );

    echo json_encode(true);
} else {
    echo json_encode(false);
}
