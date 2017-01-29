<?php
define('IN_ADRAIN', 1);
require './global.php';

echo file_get_contents('./config-session.php');

$msgtype = 'info';

if($_POST['ID']){
	$flag = FALSE;
	if(substr($_POST['ID'],0,2) == 'AA'){
		list($A,$B) = explode('-', substr($_POST['ID'],2),2);
		$sessionkey = '';
		require './config-session.php';
		if($B == sha1($sessionkey .'|sca_'. $A)){
			$flag = TRUE;
			$sca->addCookie($A);
		}
		$sessionkey = '';
	}
	
	if($flag == FALSE){
		$msgtype = 'warning';
		$msgcontent = '<p>您输入的TOKEN不正确。</p>';
	}else{
		$msgtype = 'success';
		$msgcontent = '<p>TOKEN已经成功导入，您可以删除您提交的信息。</p>';
	}
}else{
	$msgtype = 'info';
}

template('header');
?>


<?php if($msgtype == 'info'):?>
	   <form action="update.php" method="post">
			
			<div class="form-group">
				<label for="casenumber">输入报告时提供的编号：</label>
				<input type="text" class="form-control" name="ID" placeholder="Enter number AAxxxx">
			  </div>
			
			<br/>
     	  <button type="submit" class="btn btn-success">恢复我对该报告的删除权</button>
	   </form>
<?php else:?>
		<div class="alert alert-<?php echo $msgtype?>" role="alert">
		  <p><?php echo $msgcontent;?></p>
		</div>
		
		<br/>
		 <a href="index.php" class="btn btn-success">回到首页</a>
<?php endif;

template('footer');
