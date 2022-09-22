<?php
include './../../dao/Mysql.php';
include './../../dao/UserDao.php';
include './../../../config.php';
$userDao = new UserDao($proyect);
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $userDao->delete($user_id);
    echo json_encode(true);
} else {
    echo json_encode(false);
}
