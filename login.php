<?php

$pageTitle = 'Login - Users';
require(__DIR__ . '/usercheck.php');

if (!$user)
{
    require(__DIR__ . '/src/views/login.php');
}
