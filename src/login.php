<?php
session_start();
error_reporting(0);
if ($_GET['userid'] && $_GET['expire']) {
    $expire = $_GET['expire'];

    if ($expire < time()) {
        exit('Timeout');
    }

    require './anonymous_config.php'; //has a variable $key in anonymous_config.php

    if (sha1($key . '|' . $expire) != $_GET['userid']) {
        exit('Wrong');
    }

    $_SESSION['userid'] = 1;
    header('location: ./index.php');
}
