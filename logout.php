<?php

session_start();
$_SESSION['auth'] = null;
$_SESSION['user'] = null;
setcookie("ManaoUser", "", time() - 3600);

header("Location: /");
