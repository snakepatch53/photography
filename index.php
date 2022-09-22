<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
ob_start();
session_start();
#region imports
include('./config.php');
include('./model/library/initialProcess.php');

// include('./model/library/initialProcess.php');

// if ($_SERVER['HTTPS'] != "on" or strpos($_SERVER['HTTP_HOST'], 'www') !== false) {
//     header("location: " . $proyect['root_absolute']);
// }

include './model/library/Router/Route.php';
include './model/library/Router/Router.php';
include './model/library/Router/RouteNotFoundException.php';
#endregion


$router = new Router\Router($proyect['name']);

#region public
$router->add('/(|inicio|home|index|index.php|category)', function () {
    global $proyect;
    $currentPage = 'category';
    include('./model/library/session.middleware.php');
    include('./view/page.public/category.php');
}, ['GET']);

$router->add('/login', function () {
    global $proyect;
    $currentPage = 'login';
    include('./model/library/session.middleware.php');
    include('./view/page.public/login.php');
}, ['GET']);

$router->add('/category/([0-9]+)', function ($category_id) {
    global $proyect;
    $currentPage = 'category';
    include('./model/library/session.middleware.php');
    include('./view/page.public/album.php');
}, ['GET']);

$router->add('/album', function () {
    global $proyect;
    $currentPage = 'album';
    include('./model/library/session.middleware.php');
    include('./view/page.public/album.php');
}, ['GET']);

$router->add('/album/([0-9]+)', function ($album_id) {
    global $proyect;
    $currentPage = 'album';
    include('./model/library/session.middleware.php');
    include('./view/page.public/photo.php');
}, ['GET']);

$router->add('/contact', function () {
    global $proyect;
    $currentPage = 'contact';
    include('./model/library/session.middleware.php');
    include('./view/page.public/contact.php');
}, ['GET']);

$router->add('/service', function () {
    global $proyect;
    $currentPage = 'category';
    include('./model/library/session.middleware.php');
    include('./view/page.public/service.php');
}, ['GET']);
#endregion


#region panel
// PANEL

$router->add('/panel/(home|inicio)', function () {
    global $proyect;
    $currentPage = 'panel/home';
    include('./model/library/session.middleware.php');
    include('./view/page.panel/inicio.php');
}, ['GET']);

$router->add('/panel/users', function () {
    global $proyect;
    $currentPage = 'panel/users';
    include('./model/library/session.middleware.php');
    include('./view/page.panel/users.php');
}, ['GET']);

$router->add('/panel/clients', function () {
    global $proyect;
    $currentPage = 'panel/clients';
    include('./model/library/session.middleware.php');
    include('./view/page.panel/clients.php');
}, ['GET']);

$router->add('/panel/category', function () {
    global $proyect;
    $currentPage = 'panel/category';
    include('./model/library/session.middleware.php');
    include('./view/page.panel/category.php');
}, ['GET']);

$router->add('/panel/albums', function () {
    global $proyect;
    $currentPage = 'panel/albums';
    include('./model/library/session.middleware.php');
    include('./view/page.panel/albums.php');
}, ['GET']);
#endregion



// ERROR 404
$router->add('/.*', function () {
    global $proyect;
    $url = $proyect['url'];
    echo "
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <h3 style='text-align:center; font-family:consolas'>LUGAR NO ENCONTRADO</h3>
        <br/>
        <a href='$url' style='text-align:center; display:block; font-family:consolas'>Return to home</a>
    ";
});

// EJECUTAR RUTAS
$router->route();
