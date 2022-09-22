<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/InfoDao.php';
include './../../../config.php';
$infoDao = new InfoDao($proyect);
$info_rs = $infoDao->select();
$info_r = mysqli_fetch_assoc($info_rs);
echo json_encode($info_r);
