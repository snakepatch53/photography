<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/PhotoDao.php';
include './../../../config.php';
$photoDao = new PhotoDao($proyect);
$photo_rs = $photoDao->select();
$array = array();
while ($photo_r = mysqli_fetch_assoc($photo_rs)) {
    $array[] = $photo_r;
}
echo json_encode($array);
