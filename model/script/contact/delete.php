<?php
include './../../dao/Mysql.php';
include './../../dao/ContactDao.php';
include './../../../config.php';
$contactDao = new ContactDao($proyect);
if (isset($_POST['contact_id'])) {
    $contact_id = $_POST['contact_id'];
    $contactDao->delete($contact_id);
    echo json_encode(true);
} else {
    echo json_encode(false);
}
