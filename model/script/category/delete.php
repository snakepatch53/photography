<?php
include './../../dao/Mysql.php';
include './../../dao/CategoryDao.php';
include './../../../config.php';
$categoryDao = new CategoryDao($proyect);
if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $categoryDao->delete($category_id);
    echo json_encode(true);
} else {
    echo json_encode(false);
}
