<?php

$cas_host = "passport.ustc.edu.cn";
$cas_port = 443;
$cas_context = "";

require_once './cas-client/CAS.php';

phpCAS::proxy(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
//$url="http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
$url = "https://adrain.ustclug.org/plogin.php";
phpCAS::setFixedServiceURL($url);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
$user = phpCAS::getUser();
$attributes = phpCAS::getAttributes();

$studentnumber = addslashes($user);
$userid = $studentnumber;

$expire = time() + 900;
require './anonymous_config.php';

header('location: https://adrain.ustclug.org/login.php?userid=' . sha1($key . '|' . $expire) . '&expire=' . $expire);
