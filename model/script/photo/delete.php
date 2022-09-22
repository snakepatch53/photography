<?php
include './../../dao/Mysql.php';
include './../../dao/PhotoDao.php';
include './../../../config.php';
$photoDao = new PhotoDao($proyect);
if (isset($_POST['photo_id'])) {
    $photo_id = $_POST['photo_id'];
    $photo_r = mysqli_fetch_assoc($photoDao->selectById($photo_id));
    if ($photo_r['photo_name'] != "" and $photo_r['photo_name'] != null) {
        $url = '../../../view/img/photo/' . $photo_r['photo_name'];
        if (file_exists($url)) unlink($url);
    }
    $photoDao->delete($photo_id);
    echo json_encode(true);
} else {
    echo json_encode(false);
}
