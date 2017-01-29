<?php
if(!defined('IN_ADRAIN')) exit('Access Denied');
@ini_set('magic_quotes_runtime',0);
@ini_set('magic_quotes_sybase',0);

error_reporting(E_ALL ^ E_NOTICE);
define('TIMESTAMP', time());

session_start();

require './subject.php';

function login(){
	return $_SESSION['userid'];
}

function template($str){
	switch($str):
		case 'header':
			require './header.php';
			break;
		case 'footer':
			require './footer.php';
			break;
		case 'showmessage':
			require './showmessage.php';
			break;
		default:
			break;
	endswitch;
}

class db{
	public static $con;
	public static function init(){
		if($con) return;
		
		require './config.php';
		self::$con = mysqli_connect($dbserver, $dbuser, $dbpw, $dbname);
		$dbserver = $dbuser = $dbpw = $dbname = '';

		mysqli_query(self::$con, "SET CHARACTER SET 'utf8'");
		mysqli_query(self::$con,"SET NAMES 'utf8'");
	}
	
	public static function query(){
		$args = func_get_args();
		$string = $args[0];
		array_shift($args);
		
		if(count($args) == 0)
			$sql = $string;
		else
			$sql = vsprintf($string, $args);
		
		$query = mysqli_query(self::$con, $sql);
		
		if(mysqli_error(self::$con))
			echo mysqli_error(self::$con);
		
		return $query;
	}
	
	public static function fetch_first(){
		$args = func_get_args();
		$string = $args[0];
		array_shift($args);
		
		if(count($args) == 0)
			$sql = $string;
		else
			$sql = vsprintf($string, $args);
		
		$query = mysqli_query(self::$con, $sql);
		
		if(mysqli_error(self::$con))
			echo mysqli_error(self::$con);
		
		return self::fetch($query);
	}
	
	public static function fetch($query){
		return mysqli_fetch_array($query, MYSQLI_ASSOC);
	}
}
