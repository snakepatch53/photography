<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/UserDao.php';
include './../../../config.php';
$userDao = new UserDao($proyect);
if (isset(
    $_POST['user_name'],
    $_POST['user_user'],
    $_POST['user_pass'],
    $_POST['user_type']
)) {
    $user_name = $_POST['user_name'];
    $user_user = $_POST['user_user'];
    $user_pass = $_POST['user_pass'];
    $user_type = $_POST['user_type'];

    $userDao->insert(
        $user_name,
        $user_user,
        $user_pass,
        $user_type
    );

    echo json_encode(true);
} else {
    echo json_encode(false);
}
