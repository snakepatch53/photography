<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/UserDao.php';
include './../../../config.php';
$userDao = new UserDao($proyect);
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $user_rs = $userDao->selectById($user_id);
    $array = array();
    $user_r = mysqli_fetch_assoc($user_rs);
    echo json_encode($user_r);
} else {
    echo json_encode(false);
}
