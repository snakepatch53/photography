<?php
include './../../dao/Mysql.php';
include './../../dao/ClientDao.php';
include './../../../config.php';
$clientDao = new ClientDao($proyect);
if (isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];
    $clientDao->delete($client_id);
    echo json_encode(true);
} else {
    echo json_encode(false);
}
