<?php
// header('Content-Type:text/plain; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
include './../../library/images.php';
include './../../../config.php';
if (isset(
    $_GET['photo_name'],
    $_GET['photo_quality'],
    $_GET['photo_size'],
)) {
    $photo_name = $_GET['photo_name'];
    $photo_quality = $_GET['photo_quality'];
    $photo_size = $_GET['photo_size'];
    $path = "./../../../view/img/photo/" . $photo_name;
    if (file_exists($path)) {
        $photo_mime = getMimeFromPath($path);
        list($width, $height, $type, $attr) = getimagesize($path);
        $base64 = getBase64($path);
        $base64 = qualityBase64img($base64, $photo_mime, $photo_quality);
        if ($width >= $height) {
            $base64 = resizeBase64andScaleHeight($base64, $photo_mime, $photo_size);
        } else {
            $base64 = resizeBase64andScaleWidth($base64, $photo_mime, $photo_size);
        }
        ob_start();
        header("Content-type: $photo_mime");
        echo base64_decode($base64);
    } else {
        ob_start();
        header("Content-type: $photo_mime");
        readfile($path);
    }
} else {
    ob_start();
    header("Content-type: image/gif");
    readfile($proyect['url'] . "view/img/notfound.gif");
}
