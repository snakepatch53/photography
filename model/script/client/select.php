<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/ClientDao.php';
include './../../../config.php';
$clientDao = new ClientDao($proyect);
$client_rs = $clientDao->select();
$array = array();
while ($client_r = mysqli_fetch_assoc($client_rs)) {
    $array[] = $client_r;
}
echo json_encode($array);
