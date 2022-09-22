<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/InfoDao.php';
include './../../../config.php';
$infoDao = new InfoDao($proyect);
if (isset(
    $_POST['info_name'],
    $_POST['info_email'],
    $_POST['info_services']
)) {
    $info_name = $_POST['info_name'];
    $info_email = $_POST['info_email'];
    $info_services = $_POST['info_services'];
    $infoDao->update(
        $info_name,
        $info_email,
        $info_services
    );


    if (isset($_FILES['info_logo'])) {
        $infoLogo = $_FILES['info_logo'];
        if ($infoLogo['tmp_name'] != "" or $infoLogo['tmp_name'] != null) {
            $desde = $infoLogo['tmp_name'];
            $hasta = "./../../../view/img/logo.png";
            copy($desde, $hasta);
        }
    }

    echo json_encode(true);
} else {
    echo json_encode(false);
}
