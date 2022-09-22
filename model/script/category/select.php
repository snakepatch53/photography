<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/CategoryDao.php';
include './../../../config.php';
$categoryDao = new CategoryDao($proyect);
$category_rs = $categoryDao->select();
$array = array();
while ($category_r = mysqli_fetch_assoc($category_rs)) {
    $array[] = $category_r;
}
echo json_encode($array);
