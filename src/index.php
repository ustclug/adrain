<?php
define('IN_ADRAIN', 1);
error_reporting(E_ALL ^ E_NOTICE);

require './global.php';

template('header');

if (login()) {
	db::init();
?>
	<div class="alert alert-warning" role="alert" style="white-space: pre-wrap;">
		Adrain 已不再维护，并将于 2026 年 1 月 1 日后下线。您无法新增新的申请记录。
		请收藏 USTC 飞跃编辑部的新网站：<a href="https://ustcflyer.com" class="alert-link">https://ustcflyer.com</a>。
		Adrain 的公开数据由 USTC 飞跃编辑部转移至新网站，您可以在新网站上继续查阅和分享申请经验。
		如果希望删除位于 USTC 飞跃编辑部网站的数据，请联系我们或 USTC 飞跃编辑部（flyers_ustc@163.com）。
	</div>
	<div class="alert alert-info" role="alert" style="white-space: pre-wrap;">
		中科大飞跃手册，涵盖各学科申请经验，欢迎下载：
		计算机科学：<a href="attachments/cs-2020.php" class="alert-link">2020年版</a>， <a href="attachments/cs-2019.php" class="alert-link">2019年版</a>
		化学：<a href="attachments/chem-2020.php" class="alert-link">2020年版</a>， <a href="attachments/chem-2019.php" class="alert-link">2019年版</a>
		物理：<a href="attachments/phy-2019.php" class="alert-link">2019年版</a>， <a href="attachments/phy-2018.php" class="alert-link">2018年版</a>
		电子信息：<a href="attachments/ee-2019.php" class="alert-link">2019年版</a>
		地空：<a href="attachments/ess-2017.php" class="alert-link">2017年版</a>
		精密机械与精密仪器：<a href="attachments/pmpi-2014.php" class="alert-link">2014年版</a>
	</div>
	<table class="table">
		<tr>
			<th colspan="4">学科大类</th>
		</tr>
		<tr>
			<?php
			$counter = 0;
			$sub = $_ENV['subject'];
			$sub['all'] = '全部';
			foreach ($sub as $k => $v) :
				$counter++;
			?>
				<td><a href=<?php
							if ($k != 'all') :
							?> "list.php?y=<?php echo $k; ?>" <?php
										else :
											?> "listall.php" <?php endif; ?>><?php echo $v; ?></a></td>
				<?php
				if ($counter % 4 == 0) :
				?>
		</tr>
	<?php endif; ?>
<?php endforeach; ?>
	</table>
<?php
} else {
?>
	<div class="jumbotron">
		<h3>必须通过科大的统一登录系统，才能访问 ADRain</h3>
		<p>如果出现异常账户，请删除 cookie 里的 passport.ustc.edu.cn 的 laravel_session。</p>
		<p><a class="btn btn-primary btn-lg" href="plogin.php" role="button">登录</a></p>
	</div>
<?php
}

template('footer');
