<?php
include './../../dao/Mysql.php';
include './../../dao/AlbumDao.php';
include './../../dao/PhotoDao.php';
include './../../../config.php';
$albumDao = new AlbumDao($proyect);
$photoDao = new PhotoDao($proyect);
if (isset($_POST['album_id'])) {
    $album_id = $_POST['album_id'];
    $photo_rs = $photoDao->selectByAlbum_id($album_id);
    while ($photo_r = mysqli_fetch_assoc($photo_rs)) {
        $url = '../../../view/img/photo/' . $photo_r['photo_name'];
        if (file_exists($url)) unlink($url);
    }
    $albumDao->delete($album_id);
    echo json_encode(true);
} else {
    echo json_encode(false);
}
