<?php

session_start(); // открытие/восстановление сессии
require_once('autoloader.php'); // автозагрузка классов

/**
 * Пропроверка сессионных переменных. Если если открыта сессия пользователя, 
 * которого нет в базе - его сессия закрывается. Иначе - создается 
 * объект типа User и отображается кнопка выхода.
 */
$userlogin = null;
$userlogin = (!empty($_SESSION['user'])) ? $_SESSION['user'] : $_COOKIE['ManaoUser'];
if ($userlogin)
{
    $db = new Database();
    $user = ($db) ? $db->selectUser('login', $userlogin) : false;
    if ($db && !$user)
    {
        $_SESSION['auth'] = null;
        $_SESSION['user'] = null;
        setcookie("ManaoUser", "", time() - 3600);
    }
}

require_once(__DIR__ . '/src/views/header.php');