<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/CategoryDao.php';
include './../../../config.php';
$categoryDao = new CategoryDao($proyect);
if (isset(
    $_POST['category_name'],
    $_POST['category_descr'],
    $_POST['category_id']
)) {
    $category_name = $_POST['category_name'];
    $category_descr = $_POST['category_descr'];
    $category_id = $_POST['category_id'];
    $categoryDao->update(
        $category_name,
        $category_descr,
        $category_id
    );
    echo json_encode(true);
} else {
    echo json_encode(false);
}
