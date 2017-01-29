<?php
if(file_exists('./config.php')){
	exit('Access Denied');
}
error_reporting(E_ALL ^ E_NOTICE);

if($_POST['dbserver']){
	$dbserver = $_POST['dbserver'];
	$dbuser = $_POST['dbuser'];
	$dbpw = $_POST['dbpw'];
	$dbname = $_POST['dbname'];
	
	if($_POST['createdb'] == 'no')
		$mysqli = new mysqli($dbserver, $dbuser, $dbpw, $dbname);
	else
		$mysqli = new mysqli($dbserver, $dbuser, $dbpw);
	
	$mysqli->query("SET CHARACTER SET 'utf8'");
	$mysqli->query("SET NAMES 'utf8'");
	
	if($_POST['createdb'] == 'yes'){
		$mysqli->query("CREATE DATABASE IF NOT EXISTS `".addslashes($dbname)."` default charset utf8 COLLATE utf8_general_ci");
		$mysqli->select_db($dbname);
	}
	
	if($_POST['createtable'] == 'yes'){
		$mysqli->query("CREATE TABLE IF NOT EXISTS `case` (
  `cid` int(10) unsigned NOT NULL auto_increment,
  `dateofad` char(10) NOT NULL,
  `univname` varchar(200) NOT NULL,
  `funding` char(50) NOT NULL,
  `label` varchar(200) NOT NULL,
  `languagescore` varchar(200) NOT NULL,
  `gpa` varchar(200) NOT NULL,
  `subject` char(50) NOT NULL,
  `noteforchoose` text NOT NULL,
  `schoolname` varchar(300) NOT NULL,
  `subsubject` char(100) NOT NULL,
  `noteforad` text NOT NULL,
  PRIMARY KEY  (`cid`),
  KEY `subject` (`subject`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	}
	
	file_put_contents('./config.php', '<?php
if(!defined(\'IN_ADRAIN\')) exit(\'Access Denied\');

$dbserver = '.var_export($dbserver, TRUE).';
$dbuser= '.var_export($dbuser, TRUE).';
$dbpw = '.var_export($dbpw, TRUE).';
$dbname  = '.var_export($dbname, TRUE).';');
	
	
	echo 'Successful!';
}else{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>LUG@USTC SEC@USTC ADRAIN PROJECT - THE DOCKER</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style type="text/css">
    body {
      padding-top: 20px;
      padding-bottom: 20px;
    }

    .navbar {
      margin-bottom: 20px;
    }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
  </head>

  <body>  

	  <div class="bs-docs-header" id="content" style="padding-top: 20px; padding-bottom: 20px; margin-top: 20px; margin-bottom: 20px;background-color:  #6f5499; color: #fff; position: relative;">
      <div class="container">
        <h2>作为科大人，你要自信！</h2>
        <p>科大校友不仅不仅从事高科技行业的众多，而且很团结，经常活动聚会，有互相帮助的优良传统。</p>
      </div>
    </div>

    <div class="container">
<br/>
	   <form action="install.php" method="post">
	   <div class="input-group">
			  <span class="input-group-addon">MySQLi的服务器地址:</span>
			  <input type="text" name="dbserver" class="form-control" placeholder="e.g. 127.0.0.1">
		</div><br/>
		
		
	   <div class="input-group">
			  <span class="input-group-addon">MySQLi的账号名称:</span>
			  <input type="text" name="dbuser" class="form-control" placeholder="e.g. adrain">
		</div><br/>
		
		
	   <div class="input-group">
			  <span class="input-group-addon">MySQLi的密码:</span>
			  <input type="text" name="dbpw" class="form-control" placeholder="e.g. 3469r9fasdh0w0t">
		</div><br/>
		
		
	   <div class="input-group">
			  <span class="input-group-addon">MySQLi的数据库名称:</span>
			  <input type="text" name="dbname" class="form-control" placeholder="e.g. 127.0.0.1">
		</div><br/>
		
		
	   <div class="input-group">
			  <span class="input-group-addon">需要我创建数据库吗？:</span>
			  
			  <select name="createdb" class="form-control">
				<option value="yes">是</option>
				<option value="no">否</option>
			  </select>
		</div><br/>
		
		
	   <div class="input-group">
			  <span class="input-group-addon">需要我创建表吗？:</span>
			  
			  <select name="createtable" class="form-control">
				<option value="yes">是</option>
				<option value="no">否</option>
			  </select>
		</div><br/>
		
		<button type="submit" class="btn btn-success">开始安装</button>
	   </form>
    </div> <!-- /container -->

	
	<br/>
	<div class="container" style="color: #444;text-align:center;">
	<p>2017 Admission Rain LUG@USTC, SEC@USTC</p>
	
	<p>The University of Science and Technology of China is going to be a worldwide first-class university. The massive support from us is of great importance.</p>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

  </body>
</html>
<?php
}
