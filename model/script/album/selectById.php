<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/AlbumDao.php';
include './../../../config.php';
$albumDao = new AlbumDao($proyect);
if (isset($_POST['album_id'])) {
    $album_id = $_POST['album_id'];
    $album_rs = $albumDao->selectById($album_id);
    $array = array();
    $album_r = mysqli_fetch_assoc($album_rs);
    echo json_encode($album_r);
} else {
    echo json_encode(false);
}
