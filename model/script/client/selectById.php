<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/ClientDao.php';
include './../../../config.php';
$clientDao = new ClientDao($proyect);
if (isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];
    $client_rs = $clientDao->selectById($client_id);
    $array = array();
    $client_r = mysqli_fetch_assoc($client_rs);
    echo json_encode($client_r);
} else {
    echo json_encode(false);
}
