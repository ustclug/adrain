<?php
session_start();
error_reporting(0);
if($_GET['userid'] && $_GET['expire']){
	$expire = $_GET['expire'];
	
	if($expire < time())
		exit('Timeout');
	
	require './config2.php'; //has a variable $key in config2.php
	
	if(sha1($key .'|'. $expire) != $_GET['userid']){
		exit('Wrong');
	}
	
	$_SESSION['userid'] = 1;
	header('location: ./index.php');
}
?>

