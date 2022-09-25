<?php
ini_set('memory_limit', '600M');
ini_set('upload_max_filesize', '600M');
ini_set('post_max_size', '600M');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/PhotoDao.php';
include './../../../config.php';
$photoDao = new PhotoDao($proyect);
if (isset(
    $_FILES['file'],
    $_POST['album_id']
)) {
    $album_id = $_POST['album_id'];
    $file = $_FILES['file'];
    if ($file['tmp_name'] != "" or $file['tmp_name'] != null) {
        //insert
        $photoDao->insert('', $album_id);
        $photo_id = $photoDao->getLastId();
        //copy
        $url = '../../../view/img/photo/';
        $desde = $file['tmp_name'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $photo_name = $photo_id . '.' . $extension;
        $hasta = $url . $photo_name;
        move_uploaded_file($desde, $hasta);
        // update
        $photoDao->update($photo_name, $album_id, $photo_id);
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}
