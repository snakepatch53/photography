<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/PhotoDao.php';
include './../../../config.php';
$photoDao = new PhotoDao($proyect);
if (isset(
    $_POST['photo_like'],
    $_POST['photo_id']
)) {
    $photo_like = $_POST['photo_like'];
    $photo_id = $_POST['photo_id'];
    $photoDao->updateLike(
        $photo_like,
        $photo_id
    );

    echo json_encode(true);
} else {
    echo json_encode(false);
}
