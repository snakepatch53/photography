<?php

/**
 * If the user is not logged in, redirect them to the login page
 */
function middlewareSessionLogin()
{
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . $_ENV['HTTP_DOMAIN'] . 'panel/login');
        exit();
    }
}

/**
 * If the user is logged in, redirect them to the panel
 */
function middlewareSessionLogout()
{
    if (isset($_SESSION['user_id'])) {
        header('Location: ' . $_ENV['HTTP_DOMAIN'] . 'panel/home');
        exit();
    }
}

/**
 * If the user is not logged in, redirect to the login page. If the user is logged in, but is not a user, redirect to the panel page.
 */
function middlewareSessionTipoUser_login()
{
    // middlewareSessionLogin();
    // if ($_SESSION['user_tipo'] != 'user') {
    //     header('Location: ' . $_ENV['HTTP_DOMAIN'] . 'panel');
    //     exit();
    // }
}


/**
 * If the user is not logged in, return a JSON object with the key 'autorized' set to false. If the user is logged in, return a JSON
 * object with the key 'autorized' set to true.
 * 
 * @return An array with a key of 'autorized' and a value of true or false.
 */
function middlewareSessionServicesLogin()
{
    if (!isset($_SESSION['user_id'])) {
        return [
            'autorized' => false,
        ];
    }
}
