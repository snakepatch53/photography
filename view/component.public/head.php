<?php
$infoDao = new InfoDao($proyect);
$info_r = mysqli_fetch_assoc($infoDao->select());
$contactDao = new ContactDao($proyect);
$contact_rs = $contactDao->select();
?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
<link rel="shortcut icon" href="<?= $proyect['url'] ?>view/img/logo.png" type="image/x-icon">
<link rel="stylesheet" href="<?= $proyect['url'] ?>view/css.general/bootstrap2.min.css">
<link rel="stylesheet" href="<?= $proyect['url'] ?>view/css.public/general.css">
<link rel="stylesheet" href="<?= $proyect['url'] ?>view/css.public/header.css">