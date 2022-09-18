<?php
session_start();

// Проверка пришел ли ajax-запрос
if (
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    )
{    
    exit;   
}

require_once(__DIR__ . '/autoloader.php');

$userdata = 
[
    'login' => htmlentities($_POST['login']),
    'password' => $_POST['password'],
];

$loginStatus = Validator::tryLogin($userdata); // Вызов статического метода валидатора

if ($loginStatus === true)
{
    setcookie('ManaoUser', $userdata['login'], time() + 3600);
    echo json_encode('Success');
    $_SESSION['auth'] = true;
    $_SESSION['user'] = $userdata['login'];
}
else
{
    echo json_encode($loginStatus);
}




