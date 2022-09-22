<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/clientDao.php';
include './../../../config.php';
$clientDao = new clientDao($proyect);
if (isset(
    $_POST['client_name'],
    $_POST['client_phone'],
    $_POST['client_fb'],
    $_POST['client_mail'],
    $_POST['client_descr'],
    $_POST['client_id']
)) {

    $client_name = $_POST['client_name'];
    $client_phone = $_POST['client_phone'];
    $client_fb = $_POST['client_fb'];
    $client_mail = $_POST['client_mail'];
    $client_descr = $_POST['client_descr'];
    $client_id = $_POST['client_id'];
    $clientDao->update(
        $client_name,
        $client_phone,
        $client_fb,
        $client_mail,
        $client_descr,
        $client_id
    );

    // if (isset($_SESSION['client_id'])) {
    //     if ($_SESSION['client_id'] == $_client_id) {

    //         session_start();
    //         $_SESSION['client_id'] = $client_id;
    //         $_SESSION['client_name'] = $client_name;
    //         $_SESSION['client_client'] = $client_client;
    //         $_SESSION['client_pass'] = $client_pass;
    //         $_SESSION['client_type'] = $client_type;
    //     }
    // }

    echo json_encode(true);
} else {
    echo json_encode(false);
}
