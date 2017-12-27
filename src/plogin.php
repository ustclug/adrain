<?php

$cas_host="passport.ustc.edu.cn";
$cas_port=443;
$cas_context="";

require_once './cas-client/CAS.php';

phpCAS::proxy(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
//$url="http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
$url="http://sso-proxy.lug.ustc.edu.cn/plogin.php";
phpCAS::setFixedServiceURL($url);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
$user = phpCAS::getUser();
$attributes = phpCAS::getAttributes();

$studentnumber = addslashes($user);
$userid = $studentnumber;

$expire = time()+900;
require './config2.php';
;
header('location: https://adrain.ustclug.org/login.php?userid='.sha1($key . '|' . $expire).'&expire='.$expire);
?>
