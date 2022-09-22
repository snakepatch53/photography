<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/ContactDao.php';
include './../../../config.php';
$contactDao = new ContactDao($proyect);
if (isset(
    $_POST['contact_name'],
    $_POST['contact_link'],
    $_POST['contact_icon'],
    $_POST['contact_color']
)) {
    $contact_name = $_POST['contact_name'];
    $contact_link = $_POST['contact_link'];
    $contact_icon = $_POST['contact_icon'];
    $contact_color = $_POST['contact_color'];

    $contactDao->insert(
        $contact_name,
        $contact_link,
        $contact_icon,
        $contact_color
    );

    echo json_encode(true);
} else {
    echo json_encode(false);
}
