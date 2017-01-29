<?php
define('IN_ADRAIN', 1);
define('IN_ADD', 1);
require './global.php';

if(!login()){
	header('location:index.php');
}

if($_GET['cleansession']){
	$_SESSION['result'] = array();
	$_SESSION['pos'] = 'OfferAdCommitment';
}


if($_SESSION['result'])
	$result = $_SESSION['result'];
else
	$result = array();

if($_SESSION['pos']){
	$pos = $_SESSION['pos'];
}else{
	$pos = 'OfferAdCommitment';
}

require './question.php';

$Paper->setCurrentPosition($pos);

$results = array();
if($_POST['answer']){
	$results = $Paper->answer($_POST['answer']);
}

if($Paper->isfinal()){	
	require './config.php';
	$mysqli = new mysqli($dbserver, $dbuser, $dbpw, $dbname);
	$dbserver = $dbuser = $dbpw = $dbname = '';
	
	$mysqli->query("SET CHARACTER SET 'utf8'");
	$mysqli->query("SET NAMES 'utf8'");
		
	$stmt = $mysqli->prepare("INSERT INTO `case` SET dateofad = ?, univname = ?, funding = ?, label = ?, languagescore =?, gpa =?, subject = ?, noteforchoose =?, schoolname =?, subsubject=?, noteforad =?");
	
	$label = array();
	if($result['StrongRecommendation'] == 'yes'){
		$label[] = 'SLOR';
	}
	if($result['Publication'] == 'tpub'){
		$label[] = 'TPUB';
	}
	if($result['Publication'] == 'hpub'){
		$label[] = 'HPUB';
	}
	if($result['CSCStudent'] == 'yes'){
		$label[] = 'CSC';
	}
	if($result['MitacsStudent'] == 'yes'){
		$label[] = 'MITACS';
	}
	if($result['Interview'] == 'no'){
		$label[] = 'NIV';
	}
	if($result['Interview'] == 'yes'){
		$label[] = 'ITV';
	}
	if($result['ConditionalOffer'] == 'yes'){
		$label[] = 'CDN';
	}
	if($result['Intern'] == 'yes'){
		$label[] = 'INTERN';
	}
	if($result['FamiliarPOI'] == 'yes'){
		$label[] = 'FPOI';
	}
	if($result['RejOrNot'] == 'rej'){
		$label[] = 'REJ';
	}
	if($result['Contact'] > 0){
		$label[] = 'CONTACT';
	}
	
	$stmt->bind_param('sssssssssss', $result['DateOfInformation'], $result['UniversityName'], $result['FundingStatement'], join($label, ','), $result['LanguageStatement'], $result['GpaStatement'], $result['SubjectInformation'], $result['ChooseReason'], $result['SchoolName'], $result['SubsubjectName'], $result['ResultReason']);
	$stmt->execute();
	$stmt->close();
	
	$message_status = ' exit';
	
	$results[0] = 'exit';
	$results[1] = '<p>你的结果已经成功添加到数据库。</p>';
	$_SESSION['result'] = array();
	$_SESSION['pos'] = 'OfferAdCommitment';
}else{
	$message_status = 'info';

	if($results && $results[0] == 'exit'){
		$message_status = 'exit';
		$_SESSION['result'] = array();
		$_SESSION['pos'] = 'OfferAdCommitment';
	}else{
		$q = $Paper->getCurrentQuestion();
		$_SESSION['pos'] = $Paper->getCurrentPosition();
		session_write_close();
	}
}


template('header');
?>

<br/>
<p>数据库不存储任何和用户身份绑定的信息。</p>
<br/>
		<?php if($results && $results[0] == 'warning' ):?>
		<div class="alert alert-danger" role="alert">
		  <?php echo $results[1]?>
		</div>
		<?php endif;?>

		<?php if($results && $results[0] == 'exit' ):?>
		<div class="alert alert-info" role="alert">
		  <?php echo $results[1]?>
		</div>
		
		<br/>
		 <a href="index.php" class="btn btn-success">回到首页</a>
		<?php endif;?>
		
	   <?php if($message_status == 'info'):?>
	   <form action="add.php" method="post">
			
			<?php echo $q->title?>
			
			<?php echo $q->showForm()?>
			
			<br/>
		  <a href="add.php?cleansession=1" class="btn btn-danger" style="float:right;">重新填写</a>
     	  <button type="submit" class="btn btn-success">下一个问题</button>
	   </form>
	   <?php endif;?>
<?php
template('footer');