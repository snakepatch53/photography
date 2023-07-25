<?php
$_TEMPLATE_SERVICES_PATH = './src/services/';
$radapter = new RAdapter($router, $_TEMPLATE_SERVICES_PATH, $_ENV['HTTP_DOMAIN']);

// CONFIGURATION
$radapter->getHTML('/services/config', 'configuration');

// INFO
$radapter->post('/services/info/select', fn (...$args) => InfoService::select(...$args));
// need to be logged
// $radapter->post('/services/info/update', fn () => middlewareSessionServicesLogin(), fn (...$args) => InfoService::update(...$args));

// USER
$radapter->post('/services/user/login', fn (...$args) => UserService::login(...$args));
$radapter->post('/services/user/logout', fn () => UserService::logout());
// need to be logged
$radapter->post('/services/user/select', fn () => middlewareSessionServicesLogin(), fn (...$args) => UserService::select(...$args));
$radapter->post('/services/user/insert', fn () => middlewareSessionServicesLogin(), fn (...$args) => UserService::insert(...$args));
$radapter->post('/services/user/update', fn () => middlewareSessionServicesLogin(), fn (...$args) => UserService::update(...$args));
$radapter->post('/services/user/delete', fn () => middlewareSessionServicesLogin(), fn (...$args) => UserService::delete(...$args));

// CLIENT
$radapter->post('/services/client/select', fn (...$args) => ClientService::select(...$args));
$radapter->post('/services/client/insert', fn (...$args) => ClientService::insert(...$args));
$radapter->post('/services/client/update', fn (...$args) => ClientService::update(...$args));
$radapter->post('/services/client/delete', fn (...$args) => ClientService::delete(...$args));

// CATEGORY
$radapter->post('/services/category/select', fn (...$args) => CategoryService::select(...$args));
$radapter->post('/services/category/select_by_id', fn (...$args) => CategoryService::selectById(...$args));
// need to be logged
$radapter->post('/services/category/insert', fn () => middlewareSessionServicesLogin(), fn (...$args) => CategoryService::insert(...$args));
$radapter->post('/services/category/update', fn () => middlewareSessionServicesLogin(), fn (...$args) => CategoryService::update(...$args));
$radapter->post('/services/category/delete', fn () => middlewareSessionServicesLogin(), fn (...$args) => CategoryService::delete(...$args));

// ALBUM
$radapter->post('/services/album/select', fn (...$args) => AlbumService::select(...$args));
$radapter->post('/services/album/select_by_id', fn (...$args) => AlbumService::selectById(...$args));
$radapter->post('/services/album/pick_photo', fn (...$args) => AlbumService::pickPhoto(...$args));
// need to be logged
$radapter->post('/services/album/get_folders', fn () => middlewareSessionServicesLogin(), fn (...$args) => AlbumService::getFolders(...$args));
$radapter->getHTML('/services/album/optimize_album/{album_id}', false, fn () => middlewareSessionServicesLogin(), fn (...$args) => AlbumService::optimizeAlbum(...$args), false);
$radapter->post('/services/album/insert', fn () => middlewareSessionServicesLogin(), fn (...$args) => AlbumService::insert(...$args));
$radapter->post('/services/album/update', fn () => middlewareSessionServicesLogin(), fn (...$args) => AlbumService::update(...$args));
$radapter->post('/services/album/delete', fn () => middlewareSessionServicesLogin(), fn (...$args) => AlbumService::delete(...$args));

// PHOTO
$radapter->post('/services/photo/select', fn (...$args) => PhotoService::select(...$args));
$radapter->getHTML('/services/photo/get_photo', false, fn (...$args) => PhotoService::optimizeImage(...$args));
$radapter->post('/services/photo/update_like', fn (...$args) => PhotoService::updateLike(...$args));

// CONTACT
$radapter->post('/services/contact/select', fn (...$args) => ContactService::select(...$args));
