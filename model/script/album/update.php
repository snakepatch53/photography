<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/AlbumDao.php';
include './../../../config.php';
$albumDao = new AlbumDao($proyect);
if (isset(
    $_POST['album_id'],
    $_POST['album_name'],
    $_POST['album_descr'],
    $_POST['category_id'],
    $_POST['client_id']
)) {
    $album_id = $_POST['album_id'];
    $album_name = $_POST['album_name'];
    $album_descr = $_POST['album_descr'];
    $category_id = $_POST['category_id'];
    $client_id = $_POST['client_id'];
    $albumDao->update(
        $album_name,
        $album_descr,
        $category_id,
        $client_id,
        $album_id
    );

    echo json_encode(true);
} else {
    echo json_encode(false);
}
