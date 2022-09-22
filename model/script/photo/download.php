<?php

// Empaquetar fotos para descargar (de ser posible en .rar)
ob_start();
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
ini_set('memory_limit', '0');
ini_set('upload_max_filesize', '0');
ini_set('post_max_size', '0');
include './../../dao/Mysql.php';
include './../../dao/PhotoDao.php';
include './../../../config.php';
$photoDao = new PhotoDao($proyect);
if (isset(
    $_GET['album_id'],
    $_GET['photo_like']
)) {
    $album_id = $_GET['album_id'];
    $photo_like = $_GET['photo_like'];
    $photo_rs = $photoDao->selectAlbum($album_id);
    $url_tmp_zip = './../../../view/img/tmp_rar/tmp.zip';
    if (file_exists($url_tmp_zip)) unlink($url_tmp_zip);
    $zip = new ZipArchive();
    $zip->open($url_tmp_zip, ZipArchive::CREATE);
    while ($photo_r = mysqli_fetch_assoc($photo_rs)) {
        $photo_name = $photo_r['photo_name'];
        if ($photo_like == 1) {
            if ($photo_r['photo_like'] == 1) {
                $zip->addFile("./../../../view/img/photo/$photo_name", $photo_name);
            }
        } else {
            $zip->addFile("./../../../view/img/photo/$photo_name", $photo_name);
        }
    }
    $zip->close();
    header("location: $url_tmp_zip");
}
