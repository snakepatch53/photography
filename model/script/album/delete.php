<?php
include './../../dao/Mysql.php';
include './../../dao/AlbumDao.php';
include './../../../config.php';
$albumDao = new AlbumDao($proyect);
if (isset($_POST['album_id'])) {
    $album_id = $_POST['album_id'];
    $albumDao->delete($album_id);
    echo json_encode(true);
} else {
    echo json_encode(false);
}
