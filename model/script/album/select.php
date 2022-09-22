<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/AlbumDao.php';
include './../../../config.php';
$albumDao = new AlbumDao($proyect);
$album_rs = $albumDao->select();
$array = array();
while ($album_r = mysqli_fetch_assoc($album_rs)) {
    $array[] = $album_r;
}
echo json_encode($array);
