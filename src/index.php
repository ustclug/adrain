<?php
define('IN_ADRAIN', 1);
error_reporting(E_ALL ^ E_NOTICE);

require './global.php';

template('header');

if(login()){
	db::init();
?>
	  <table class="table">
		<tr><th colspan="4">学科大类</th></tr><tr>
		<?php 
		$counter = 0;
		foreach($_ENV['subject'] as $k=>$v):
		$counter ++;
		?>
		<td><a href="list.php?y=<?php echo $k;?>"><?php echo $v;?></a></td>
		<?php
		if($counter % 4 == 0):
		?></tr>
		<?php endif;?>
		<?php endforeach;?>
	  </table>
<?php
}else{
?>
	<div class="jumbotron">
	  <h3>必须通过科大的统一登录系统，才能访问 ADRain</h3>
	  <p>如果出现异常账户，请删除cookie里的passport.ustc.edu.cn的laravel_session。</p>
	  <p><a class="btn btn-primary btn-lg" href="http://sec.ustc.edu.cn/adrain/plogin.php" role="button">登录</a></p>
	</div>
<?php	
}

template('footer');
