<?php
// include('./model/dao/Mysql.php');
// session_start();

if (str_contains($currentPage, 'panel')) {
        if (empty($_SESSION['user_id'])) header('location: ../login');
        if ($_SESSION['user_type'] != 1 and $currentPage == 'panel/users') header('location: ./home');
} else {
    if (isset($_SESSION['user_id'])) header('location: ./panel/home');
}

// if ($currentPage == "login") {
//     if (isset($_SESSION['user_id'])) header('location: ./');
// } else {
//     if (empty($_SESSION['user_id'])) header('location: ./login');
//     if ($_SESSION['user_type'] != 1 and $currentPage == 'users') header('location: ./');
// }
