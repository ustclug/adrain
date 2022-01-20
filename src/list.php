<?php
define('IN_ADRAIN', 1);
require './global.php';

if (!login()) {
	header('location:index.php');
}

template('header');
?>
<br />
<table class="table">
	<tr>
		<th>通知日期</th>
		<th>细分方向</th>
		<th>学校名称</th>
		<th>项目名称</th>
		<th width="100">标签</th>
		<th width="400">具体信息</th>
	</tr>
	<?php
	db::init();

	$query = db::query("SELECT cid, dateofad, univname, funding, gpa, label, languagescore, subject, noteforchoose, schoolname, subsubject, noteforad FROM `case` WHERE `subject`='%s' AND hidden = 0 ORDER BY dateofad DESC", db::$con->real_escape_string($_GET['y']));

	require './include/list_displabel.php';

	while ($data = db::fetch($query)) :
		$label = $data['label'];
		$labelhtml = str_replace($displabel_a, $displabel_b, $label);
	?>
		<tr<?php echo (strpos($data['label'], 'REJ') !== false ? " class=\"warning\"" : "") ?>>
			<td><?php echo $data['dateofad'] ?><?php if (in_array($data['cid'], $sca->cookielist)) : ?><p><a href="delete.php?cid=<?php echo $data['cid']; ?>">删除</a></p><?php endif; ?></td>
			<td><?php echo $data['subsubject'] ?></td>
			<td><?php echo $data['univname'] ?></td>
			<td><?php echo $data['schoolname'] ?></td>
			<td><?php echo $labelhtml ?></td>
			<td>
				<?php echo $data['funding'] ? '<p><b>奖助学金额:</b>' . strip_tags($data['funding']) . '</p>' : ''; ?>
				<?php echo $data['languagescore'] ? '<p><b>语言成绩:</b>' . strip_tags($data['languagescore']) . '</p>' : ''; ?>
				<?php echo $data['gpa'] ? '<p><b>课业成绩:</b>' . strip_tags($data['gpa']) . '</p>' : ''; ?>
				<?php echo $data['noteforchoose'] ? '<p><b>选校原因:</b>' . strip_tags($data['noteforchoose']) . '</p>' : ''; ?>
				<?php echo $data['noteforad'] ? '<p><b>录取备注:</b>' . strip_tags($data['noteforad']) . '</p>' : ''; ?>
			</td>
			</tr>
		<?php endwhile; ?>
</table>
<?php
template('footer');
