<?php
class Paper{
	public $questions = array();
	public $index = array();
	public $pos = 0;
	
	function addQuestion($obj){
		if(!$obj->constructed) return;
		array_push($this->index, $obj->uniqueid);
		$this->questions[] = $obj;
	}
	
	function setCurrentPosition($pos){
		$this->pos = 0;
		
		foreach($this->index as $k=>$v){
			if($pos == $v){
				$this->pos = $k;
				return ;
			}
		}
	}
	
	function getCurrentQuestion(){
		return $this->questions[$this->pos];
	}
	
	function getCurrentPosition(){
		$obj = $this->getCurrentQuestion();
		return $obj->uniqueid;
	}
	
	function nextQuestion(){
		$this->pos ++;
	}
	
	function isFinal(){
		if(!isset($this->questions[$this->pos])) return TRUE;
		else return FALSE;
	}
	
	function answer($answer){
		global $result;
		
		$curq = $this->getCurrentQuestion();
		
		
		$curname = $curq->uniqueid;
		
		if(isset($answer[$curname])){
			$newresult = $result;
			$newresult[$curname] = $answer[$curname];
			$chkresult = $curq->checkanswer($newresult);
			
			if(empty($chkresult)){		
				$result = $newresult;
				$_SESSION['result'] = $result;
				
				$qlist = array();
				$ilist = array();
				foreach($this->questions as $v){
					$insert = TRUE;
					if($v->conditionInsert){
						$func = $v->conditionInsert;
						$insert = $func($result);
					}
					if($insert == TRUE){
						array_push($ilist, $v->uniqueid);
						$qlist[] = $v;
					}
				}
				$this->questions = $qlist;
				$this->index = $ilist;
				
				$this->nextQuestion();

				return array();
			}else{
				return $chkresult;
			}
		}

	}
}

class Question{
	public $constructed = FALSE;
	public $uniqueid;
	public $title;
	public $type;
	public $details;
	public $conditionInsert;
	public $conditionValid;
	
	function __construct($uniqueid, $title, $type, $details, $conditionInsert, $conditionValid){
		global $result;
		
		$insert = TRUE;
		
		if($conditionInsert){
			$insert = $conditionInsert($result);
		}
		
		if($insert == FALSE)
			return;
		
		$this->constructed = TRUE;
		
		$this->uniqueid = $uniqueid;
		$this->title = $title;
		$this->type = $type;
		$this->details = $details;
		$this->conditionInsert = $conditionInsert;
		$this->conditionValid = $conditionValid;
	}
	
	function showForm(){
		$ret = '';
		
		if($this->type == 'select'){
			$ret = '<br/><div class="input-group">
			  <span class="input-group-addon">回答:</span>
			  <select name="answer['.$this->uniqueid.']" class="form-control">';
			
			$options = explode('/', $this->details);
			
			foreach($options as $option){
				list($val, $name) = explode('=', $option);
				$ret .= '<option value="'.$val.'">'.$name.'</option>';
			}

			$ret .= '  </select></div>';
			
		}
		
		if($this->type == 'text'){
			$ret = '<br/><div class="input-group">
			  <span class="input-group-addon">回答:</span>
			  ';
			  
			$ret .= '<input type="text" name="answer['.$this->uniqueid.']" class="form-control" placeholder="'.$this->details.'"></div>';
		}
		
		return $ret;
	}

	function checkanswer(&$input){
		if($this->type == 'select'){
			$available = array();
			
			$options = explode('/', $this->details);
			foreach($options as $option){
				list($val, $name) = explode('=', $option);
				$available [] = $val;
			}
			
			if(!in_array($input[$this->uniqueid], $available)){
				return array('warning', '<p>您选择的选项不正确！</p><br/><p>The option you selected is not in the list. </p>');
			}
		}
		
		if(!empty($this->conditionValid)){
			$func = $this->conditionValid;
			return $func($input);
		}
				
		return array();
	}
}

$Paper = new Paper;

$Paper->addQuestion(new Question('OfferAdCommitment', '<p>为了保证数据的准确性，帮助下一届学生了解录取信息。请确定您的通知是否符合下列条件。<ul><li>我已经收到来自学校、院系的通知，而不仅仅是教授告知的消息。</li><li>了解这一信息的过程是正式的，公开这一信息不会让对方学校和教授造成困扰。</li><li>我能感觉到舒服和放松，愿意提供这一信息。</li></ul></p>', 'select', 'yes=是的，我满足上述条件，我要报信息。/no=否，我不完全符合这些信息。', '', 'OfferAdCommitmentFunc'));

$subjectinfo = array();
foreach($_ENV['subject'] as $k=>$v) $subjectinfo[]=$k.'='.$v;

$Paper->addQuestion(new Question('SubjectInformation', '<p>请选择您的录取信息所属的学科，如果您没有找到您的大类学科，请联系QQ群616513207。</p>', 'select', join($subjectinfo, '/'), '', ''));

function OfferAdCommitmentFunc($input){
	if($input['OfferAdCommitment']=='no'){ 
		return array('exit', '<p>如果您不完全满足这些信息，您可以稍等确定的消息到达，或者适当放松自己后再报告。科大的学生非常需要您的信息，希望您有机会向我们提供。如果您的申请有一些特殊情况，例如教授给了选择，您实际有机会就读，但您根据自己的考虑，选择放弃这个机会，可以在后面补充信息。这些对于科大的学生也非常有帮助。</p>');
	}else return array();
}

$Paper->addQuestion(new Question('DateOfInformation', '<p>请提供您收到通知的日期。考虑到中美两国时差，我们建议一律使用中国的日期。</p>', 'text', 'e.g. 2017-01-10', '', 'DateOfInformationFunc'));

function DateOfInformationFunc($input){
	if(!preg_match('/^[0-9]{4,4}\-[0-9]{2,2}\-[0-9]{2,2}$/i', $input['DateOfInformation'])){
		return array('warning', '<p>抱歉，您输入的日期不正确。</p>');
	}else return array();
}

$Paper->addQuestion(new Question('UniversityName', '<p>请提供对方大学的名称。为了避免产生误解，我们建议您使用“国家+大学名”的格式，例如中国东北大学，中国中国科学技术大学，日本京都大学。</p>', 'text', 'e.g. 中国中国科学技术大学', '', ''));

$Paper->addQuestion(new Question('SchoolName', '<p>请提供对方项目的名称。例如 Computer Science Master，Machine Learning PhD， Information Networking Institute - Master of Science of Information Security。为了防止学科歧义，尽量不要缩写。</p>', 'text', 'e.g. Therotical Physics PhD', '', ''));

$Paper->addQuestion(new Question('SubsubjectName', '<p>请提供你的项目的细分学科，例如计算宇宙学、密码学系统、机器学习、微电子线路。</p>', 'text', 'e.g. 计算宇宙学', '', ''));

$Paper->addQuestion(new Question('RejOrNot', '<p>为了避免无关问题的出现，请问这一次是婉拒还是录取？以官方的通知为准，其他细节（例如和教授表明已有选择）可以忽略。</p>', 'select', 'rej=这是拒绝。/adm=这是录取通知。', '', ''));

function NoIfRej($input){
	if($input['RejOrNot']=='rej'){ 
		return FALSE;
	}else return TRUE;
}

$Paper->addQuestion(new Question('FundingStatement', '<p>请提供你的录取的资助情况。<b>考虑到各种各样不同的计算方式的存在，我们请您用越详细越好的介绍来描述资助，包括有没有算医保啊，有没有算暑假工啊，学费在不在里面啊。特别表明“可以用来买牙膏的钱是多少”。</b>如果您是硕士，通常没有奖学金，但也有例外。如果无奖学金，可以留空。</p>', 'text', 'e.g. 无奖学金', 'NoIfRej', ''));

$Paper->addQuestion(new Question('LanguageStatement', '<p>请提供你的本人的英语成绩。这是一个选择性的问题，您可以不回答，也可以回答。您如果回答，可以详细提供小分，也可以不提供小分。</p>', 'text', 'e.g. T100(R25+L25+S25+W25) G150+170+3', '', ''));

$Paper->addQuestion(new Question('GpaStatement', '<p>请提供你的本人的在校学业表现（例如GPA）。这是一个<b>非常选择性</b>的问题，您可以不回答，也可以回答。您如果回答，可以详细提供排名，也可以不提供。您可以保留一位小数，或者给出两位小数。您可以说中等偏上，也可以说比较一般。</p>', 'text', 'e.g. GPA3.0', '', ''));

$Paper->addQuestion(new Question('StrongRecommendation', '<p>您有很强的推荐信吗？获得一份较强推荐信，可以是能评价你的科研工作的教授的依据强烈的推荐信，或者是了解你的科研工作的知名学者的推荐信。</p>', 'select', 'yes=是的，我有。/no=否，我没有。', '', ''));

$Paper->addQuestion(new Question('Publication', '<p>您有一个发表、或者尚在发表但拿得出手的工作在申请过程中做了介绍，在该工作中该生能讲清楚自己的贡献（不必一作），而且贡献比较充分的论文吗？如果没有，您有论文或者合著论文，并且发表在该行业的正规刊物（不包括普遍不认可的会议期刊）？</p>', 'select', 'tpub=是的，我有前面所说的贡献较大的拿得出手的工作。/hpub=我虽然没有到有代表性，但是有论文或者合著论文。/no=否，我没有。', '', ''));

$Paper->addQuestion(new Question('CSCStudent', '<p>您申请了CSC的资助，并且在申请阶段中表明了自己将会使用CSC的资助就读吗？</p>', 'select', 'yes=是的，我使用了CSC申请的途径。/no=否，我没有。', '', ''));

$Paper->addQuestion(new Question('MitacsStudent', '<p>您是Mitacs Globalink项目的学生，毕业后申请的是和Mitacs有合作关系的学校，并且在申请阶段表明自己有Mitacs的资助吗？</p>', 'select', 'yes=是的，我将去加拿大学习，并且使用Mitacs的研究生资助。/no=否，我没有。', '', ''));

$Paper->addQuestion(new Question('Interview', '<p>您在申请的过程中，有收到老师的面试要求吗？</p>', 'select', 'yes=是的，我收到了。/no=否，我没有。', '', ''));

$Paper->addQuestion(new Question('ConditionalOffer', '<p>这是一个有条件的录取资格，而且这个条件并不是形式上的，例如有语言成绩的进一步要求？如果达不到要求，将取消入学资格？</p>', 'select', 'yes=是的，有条件。/no=否，没有额外条件。', 'NoIfRej', ''));

$Paper->addQuestion(new Question('Intern', '<p>您有海外交流经历并平安归来吗？注意不包括课程修读和文化之旅，必须有在导师指导下进行科学性的研究工作。</p>', 'select', 'yes=是的，我有。/no=否，我没有。', '', ''));

$Paper->addQuestion(new Question('FamiliarPOI', '<p>您相中的导师，和您以前有一定的交往吗？即<b>除了套词之外</b>，您是否在他那边做了科研实习，或者您的科大教授有推荐，或者您有意到他那边做毕业设计、访问学者？总之，您有一些特殊的机遇？</p>', 'select', 'yes=是的，我有。/no=否，我没有。', '', ''));

$Paper->addQuestion(new Question('Contact', '<p>您主动和教授套词了吗？注意，这里的套词指的是学生已经主动联系有意向的导师，而不是有意向的导师在得到申请后主动联系导师。</p>', 'select', 'yes=是的，我套词了。/no=否，我没有。', '', ''));

$Paper->addQuestion(new Question('ChooseReason', '<p>能否简单谈谈您选择这个学校的原因？例如地理位置、未来规划，或者是科研上的方向的原因。</p>', 'text', 'e.g. （尽量不要留空）', '', ''));

$Paper->addQuestion(new Question('ResultReason', '<p><u><b>最后一个问题</b></u> 看到这样的结果，您的感觉如何？您觉得是什么因素使得您得到了录取？是否还有什么细节需要补充？</p><p>模板：</p>
<p>意料之中|意料之外，主要是方向匹配|经历有关，喜欢她做的内容，面试的时候回答的比较好。交流阶段做的内容相关。拿到一个交流的老师的推荐信。有比较好的奖学金，例如郭奖，国奖（很可能暴露您的个人信息）。对方是科大校友。希望学弟学妹早点准备英语。</p><p><b>如果您愿意，</b>欢迎提供您的联系方式。最好是您出国后还会使用的联系方式，例如微信、QQ、国外邮箱、facebook帐号。请您放心，只有中科大的同学可以进来。</p>', 'text', 'e.g. （尽量不要留空）', '', ''));
