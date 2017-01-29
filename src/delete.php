<?php
define('IN_ADRAIN', 1);
require './global.php';


if($_GET['cid'] && in_array($_GET['cid'], $sca->cookielist)){
	db::init();
	
	db::query("UPDATE `case` SET hidden = 1 WHERE cid = %d", $_GET['cid']);
	
	$msgtype = 'success';
	$msgcontent = '<p>这个报告已经顺利删除。如属于误操作需要恢复，请联系管理员。</p>';
}else{
	$msgtype = 'warning';
	$msgcontent = '<p>您不能编辑这个报告。</p>';
}

template('header');
?>

		<div class="alert alert-<?php echo $msgtype?>" role="alert">
		  <p><?php echo $msgcontent;?></p>
		</div>
		
		<br/>
		 <a href="index.php" class="btn btn-success">回到首页</a>
<?php 

template('footer');
