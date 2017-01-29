<?php
define('IN_ADRAIN', 1);
require './global.php';

db::init();
db::query("INSERT INTO `case` (`cid`, `dateofad`, `univname`, `funding`, `label`, `languagescore`, `gpa`, `subject`, `noteforchoose`, `schoolname`, `subsubject`, `noteforad`) VALUES
(1, '2017-01-28', '美国德克萨斯大学奥斯汀分校', 'RA', 'SLOR,NIV,INTERN,FPOI', '', '', 'computer-science', '', 'Computer Science PhD', '图形学，机器学习', ''),
(2, '2016-12-24', '澳大利亚墨尔本大学', '有', 'HPUB,ITV', '97', '中等偏上', 'computer-science', '', 'Machine Learning PhD', '机器学习', '面试的时候回答的比较好'),
(3, '2017-01-28', '美国加州大学戴维斯分校', '33575.28美元/年', 'ITV,INTERN', 'T102 (R26+L28+S20+W28), G156+168+3.5', 'GPA3.73', 'electronic-engineering', '地点：靠近硅谷', 'Electrical and Computer Engineering, PhD', '信息论、统计信号处理、机器学习', '意料之中。方向与本科学习虽然不匹配，但导师更看重数学基础，本科专业相对不是那么重要。'),
(4, '2017-01-04', '加拿大英属哥伦比亚大学', 'RA/TA', 'SLOR,TPUB,MITACS,ITV,INTERN', 'T103(S24)', 'Top 5%', 'computer-science', '工作，家庭，移民', 'Computer Science Master (PhD Track)', 'Computer graphics', '意料之中'),
(5, '2017-01-20', '美国纽约州立大学宾汉姆顿大学', '系里还没开始发funding，等待着', 'SLOR,TPUB,NIV', 'T99 (S 19)', 'Undergraduate：2.8; Graduate：3.6', 'management', '位置和综排还可以，有老师的方向也挺有趣', 'Industrial Engineering', '', '意料之外，提交材料10天后就给结果了');");

exit;



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
