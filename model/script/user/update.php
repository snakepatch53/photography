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
    $_POST['user_type'],
    $_POST['user_id']
)) {
    $user_name = $_POST['user_name'];
    $user_user = $_POST['user_user'];
    $user_pass = $_POST['user_pass'];
    $user_type = $_POST['user_type'];
    $user_id = $_POST['user_id'];
    $userDao->update(
        $user_name,
        $user_user,
        $user_pass,
        $user_type,
        $user_id
    );

    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_id'] == $_user_id) {

            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_user'] = $user_user;
            $_SESSION['user_pass'] = $user_pass;
            $_SESSION['user_type'] = $user_type;
        }
    }

    echo json_encode(true);
} else {
    echo json_encode(false);
}
