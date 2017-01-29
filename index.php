<?php
define('IN_ADRAIN', 1);
error_reporting(E_ALL ^ E_NOTICE);

require './global.php';

template('header');

if(login()){
	db::init();
?>
	  <table class="table">
		<tr><th>学科大类</th></tr>
		<?php foreach($_ENV['subject'] as $k=>$v):?>
		<tr><td><a href="list.php?y=<?php echo $k;?>"><?php echo $v;?></a></td></tr>
		<?php endforeach;?>
	  </table>
<?php
}else{
?>
	<div class="jumbotron">
	  <h3>必须通过科大的统一登录系统，才能访问 ADRain</h3>
	  <p>如果出现异常账户，请删除cookie里的passport.ustc.edu.cn的laravel_session。</p>
	  <p><a class="btn btn-primary btn-lg" href="login.php" role="button">登录</a></p>
	</div>
<?php	
}

template('footer');
