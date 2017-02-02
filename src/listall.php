<?php
define('IN_ADRAIN', 1);
require './global.php';

if(!login()){
	header('location:index.php');
}

template('header');
?>
<br/>
	  <table class="table">
		<tr><th>通知日期</th><th>细分方向</th><th>学校名称</th><th>项目名称</th><th>标签</th><th>具体信息</th></tr>
	   <?php
			db::init();
			
			$query = db::query("SELECT cid, dateofad, univname, funding, gpa, label, languagescore, subject, noteforchoose, schoolname, subsubject, noteforad FROM `case` WHERE hidden = 0 ORDER BY dateofad", addslashes($_GET['y']));
			
			$displabel_a = array('SLOR', 'TPUB', 'HPUB', 'CSC','MITACS','NIV','ITV','CDN','INTERN','FPOI','REJ','CONTACT',',');
			$displabel_b = array('<span class="label label-success" title="获得一份较强推荐信，可以是能评价你的科研工作的教授的依据强烈的推荐信，或者是了解你的科研工作的知名学者的推荐信。">强推</span>', '<span class="label label-success"  title="有一个发表、或者尚在发表但拿得出手的工作在申请过程中做了介绍，在该工作中该生能讲清楚自己的贡献（不必一作），而且贡献比较充分。">代表性工作</span>', '<span class="label label-success" title="该生有论文或者合著论文，并且发表在该行业的正规刊物，不包括普遍不认可的会议期刊。">论文</span>', '<span class="label label-info" title="该生申请了CSC的资助，并且在申请阶段中表明了自己将会使用CSC的资助就读。">CSC</span>', '<span class="label label-info" title="该生是Mitacs Globalink项目的学生，毕业后申请的是和Mitacs有合作关系的学校，并且在申请阶段表明自己有Mitacs的资助。">MITACS</span>', '<span class="label label-info" title="未接受到和教授的面试，注意这在硕士招生是普遍现象。">无面试</span>', '<span class="label label-info" title="接到和教授的面试。">有面试</span>', '<span class="label label-info" title="这是一个有条件的录取资格，注意形式上的录取条件不在此列。">有条件</span>', '<span class="label label-success" title="有海外交流经历并平安归来。">交流</span>','<span class="label label-success" title="你曾经通过访问学者、暑期实习的方法直接或者间接认识到这位教授，有高于套词的联系。">互相认识</span>','<span class="label label-success" title="这是一个被拒绝的申请。">被拒</span>','<span class="label label-info" title="学生已经主动联系有意向的导师，而不是有意向的导师在得到申请后主动联系导师。">套词</span>', '&nbsp;');
		
			while($data = db::fetch($query)):
				$label = $data['label'];
				$labelhtml = str_replace($displabel_a, $displabel_b, $label);	
		?>
		<tr<?php echo (strpos($data['label'], 'REJ')!==FALSE?" class=\"warning\"":"")?>><td><?php echo $data['dateofad']?><?php if(in_array($data['cid'], $sca->cookielist)):?><p><a href="delete.php?cid=<?php echo $data['cid'];?>">删除</a></p><?php endif;?></td><td><?php echo $_ENV['subject'][$data['subject']].'-'.$data['subsubject']?></td><td><?php echo $data['univname']?></td><td><?php echo $data['schoolname']?></td><td><?php echo $labelhtml?></td><td>
			<?php echo $data['funding']?'<p><b>奖助学金额:</b>'.strip_tags($data['funding']).'</p>':'';?>
			<?php echo $data['languagescore']?'<p><b>语言成绩:</b>'.strip_tags($data['languagescore']).'</p>':'';?>
			<?php echo $data['gpa']?'<p><b>课业成绩:</b>'.strip_tags($data['gpa']).'</p>':'';?>			
			<?php echo $data['noteforchoose']?'<p><b>选校原因:</b>'.strip_tags($data['noteforchoose']).'</p>':'';?>		
			<?php echo $data['noteforad']?'<p><b>录取备注:</b>'.strip_tags($data['noteforad']).'</p>':'';?>				
		</td></tr>
	  <?php endwhile;?>
	  </table>
<?php
template('footer');
