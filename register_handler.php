<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{    
    exit;
}

require_once(__DIR__ . '/autoloader.php');

$userdata = 
[
    'login' => htmlentities($_POST['login']),
    'password' => $_POST['password'],
    'confirm_password' => $_POST['confirm_password'],
    'email' => $_POST['email'],
    'name' => trim($_POST['name']),
];

$errors = Validator::hasErrors($userdata); // Вызов статического метода валидатора

if ($errors === false)
{
    $user = new User($userdata); // создание экземпляра класса User
    $db = new Database(); // создание экземпляра класса Database
    if ($db && $db->addUser($user)) echo json_encode('Success');
}
else
{
    echo json_encode($errors);
}




