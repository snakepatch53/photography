<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/CategoryDao.php';
include './../../../config.php';
$categoryDao = new CategoryDao($proyect);
if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $category_rs = $categoryDao->selectById($category_id);
    $array = array();
    $category_r = mysqli_fetch_assoc($category_rs);
    echo json_encode($category_r);
} else {
    echo json_encode(false);
}
