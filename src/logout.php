<?php

// Actually logout functionality is disabled in adrain, as we only use CAS to verify user as USTC students/staff.

$cas_host = "passport.ustc.edu.cn";
$cas_port = 443;
$cas_context = "";

require_once './cas-client/CAS.php';

phpCAS::proxy(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

// $url = "http://" . $_SERVER["HTTP_HOST"] . array_shift(explode('?', $_SERVER['PHP_SELF'], 2));
// phpCAS::setFixedServiceURL($url);
phpCAS::setNoCasServerValidation();

// phpCAS::logoutWithUrl($url);
phpCAS::logout(array('url' => 'https://adrain.ustclug.org/'));

$_SESSION['userid'] = 0;

header('location: ./index.php');
