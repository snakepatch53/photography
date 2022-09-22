<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/UserDao.php';
include './../../../config.php';
$userDao = new UserDao($proyect);
if (isset(
    $_POST['user_user'],
    $_POST['user_pass']
)) {
    $user_user = $_POST['user_user'];
    $user_pass = $_POST['user_pass'];
    $user_rs = $userDao->login($user_user, $user_pass);
    $user_r = mysqli_fetch_assoc($user_rs);
    if (mysqli_num_rows($user_rs) > 0) {
        if (
            $user_r['user_user'] == $user_user and
            $user_r['user_pass'] == $user_pass
        ) {
            $_SESSION['user_id'] = $user_r['user_id'];
            $_SESSION['user_name'] = $user_r['user_name'];
            $_SESSION['user_user'] = $user_r['user_user'];
            $_SESSION['user_pass'] = $user_r['user_pass'];
            $_SESSION['user_type'] = $user_r['user_type'];

            echo json_encode($user_r);
        } else {
            echo json_encode(false);
        }
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}
