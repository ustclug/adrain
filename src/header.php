<?php
if(!defined('IN_ADRAIN')) exit('Access Denied');
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

    <title>中国科学技术大学 申请海外大学研究生的录取情况报告系统</title>

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
      <div class="container"><img src="images/aplogo.gif" style="float:right;" />
  <ul class="nav nav-pills" role="tablist">
  <li role="presentation"<?php echo !defined('IN_ADD')?" class=\"active\"":'';?>><a href="index.php">不同学科进展</a></li>
  <li role="presentation"<?php echo defined('IN_ADD')?" class=\"active\"":'';?>><a href="add.php">报告我的录取案例（通过和拒绝）</a></li>
  <?php
  if(0 && login()):?>
  <li role="presentation"><a href="logout.php">退出当前账号</a></li>
  <?php endif;?>
</ul></div>

	  <div class="bs-docs-header" id="content" style="padding-top: 20px; padding-bottom: 20px; margin-top: 20px; margin-bottom: 20px;background-color:  #6f5499; color: #fff; position: relative;">
      <div class="container">
        <h2>作为科大人，你要自信！</h2>
        <p>科大校友不仅不仅从事高科技行业的众多，而且很团结，经常活动聚会，有互相帮助的优良传统。</p>
      </div>
    </div>

    <div class="container">
<br/>