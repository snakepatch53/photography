<?php
$_TEMPLATE_PUBLIC_PATH = './src/templates/public.pages/';
$radapter = new RAdapter($router, $_TEMPLATE_PUBLIC_PATH, $_ENV['HTTP_DOMAIN']);

//  TEST
$radapter->getHTML('/test', 'test',);

// HOME
$radapter->getHTML('/', 'home', function ($DATA) {
    return [
        'info' => (new InfoDao($DATA['mysqlAdapter']))->select(),
        'contact' => (new ContactDao($DATA['mysqlAdapter']))->select(),
    ];
});

$radapter->getHTML('/index.php', 'home', function ($DATA) {
    return [
        'info' => (new InfoDao($DATA['mysqlAdapter']))->select(),
        'contact' => (new ContactDao($DATA['mysqlAdapter']))->select(),
    ];
});


// CATEGORY
$radapter->getHTML('/category/{category_id}', 'album', function ($DATA, $category_id) {
    return [
        'info' => (new InfoDao($DATA['mysqlAdapter']))->select(),
        'contact' => (new ContactDao($DATA['mysqlAdapter']))->select(),
        'category_id' => $category_id,
    ];
});

$radapter->getHTML('/category', 'home', function ($DATA) {
    return [
        'info' => (new InfoDao($DATA['mysqlAdapter']))->select(),
        'contact' => (new ContactDao($DATA['mysqlAdapter']))->select(),
        'album_id' => 0,
        'title' => 'Categorias',
    ];
});

// ALBUM
$radapter->getHTML('/album/{album_id}', 'photo', function ($DATA, $album_id) {
    return [
        'info' => (new InfoDao($DATA['mysqlAdapter']))->select(),
        'contact' => (new ContactDao($DATA['mysqlAdapter']))->select(),
        'album_id' => $album_id,
    ];
});

$radapter->getHTML('/album', 'album', function ($DATA) {
    return [
        'info' => (new InfoDao($DATA['mysqlAdapter']))->select(),
        'contact' => (new ContactDao($DATA['mysqlAdapter']))->select(),
        'album_id' => 0,
    ];
});


// SERVICE
$radapter->getHTML('/service', 'service', function ($DATA) {
    return [
        'info' => (new InfoDao($DATA['mysqlAdapter']))->select(),
        'contact' => (new ContactDao($DATA['mysqlAdapter']))->select(),
    ];
});

// CONTACT
$radapter->getHTML('/contact', 'contact', function ($DATA) {
    return [
        'info' => (new InfoDao($DATA['mysqlAdapter']))->select(),
        'contact' => (new ContactDao($DATA['mysqlAdapter']))->select(),
    ];
});
