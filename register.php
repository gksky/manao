<?php

$pageTitle = 'Registration - Users';
require(__DIR__ . '/usercheck.php');

if (!isset($user))
{
    require(__DIR__ . '/src/views/register.php');
}