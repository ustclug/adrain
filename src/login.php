<?php

$cas_host="passport.ustc.edu.cn";
$cas_port=443;
$cas_context="";

require_once './cas-client/CAS.php';

phpCAS::proxy(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
$url="https://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
phpCAS::setFixedServiceURL($url);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
$user = phpCAS::getUser();
$attributes = phpCAS::getAttributes();

$studentnumber = addslashes($user);

$_SESSION['userid'] = $studentnumber;
header('location: https://adrain.ustclug.org/index.php');
?>
