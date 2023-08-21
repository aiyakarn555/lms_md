<?php
class survey_include
{
	public function survey($model){
		for ($i=0,$a=0,$b=0; $i < count($model) ; $i++) { 
			if($i==0){
				if($model[$i]['Tan_nID']!=3){
					$this->openDivHead($model[$i]['Tit_cNameTH']);
				}
				switch ($model[$i]['Tan_nID']) {
					case 1:
						$this->openDivSingleChoiceHead($model[$i]['Que_cNameTH'],++$a);
						$this->addDivSingleChoice($model[$i]['Que_nID']
							,$model[$i]['Cho_nID'],$i,$model[$i]['Cho_cNameTH']);
						break;
					case 2:
						$this->openDivMultiQuestion($model[$i]['Que_cNameTH'],++$a);
						if($model[$i]['Sch_nID']!=null){
							$this->openDivMultiChoice($model[$i]['Cho_nID']
								,$model[$i]['Cho_cNameTH'],0);
						}else{
							$this->openDivMultiChoice($model[$i]['Cho_nID']
								,$model[$i]['Cho_cNameTH'],$model[$i]['stat_choice']);
						}
						$this->openDivMultiChoice($model[$i]['Cho_nID']
							,$model[$i]['Cho_cNameTH'],$model[$i]['stat_choice']);
						if($model[$i]['Sch_nID']!=null){
							++$b;
							if($model[$i]['stat_subchoice']){
								$this->openDivMultiSubChoicetxt($model[$i]['Sch_nID'],$model[$i]['Sch_cNameTH']);
							}else{
								$this->openDivMultiSubChoice($model[$i]['Sch_nID'],$model[$i]['Sch_cNameTH']);
							}
						}
						break;
					case 3:
						$this->openDivGrading();
						$this->openTagGrading($model[$i]['Tit_cNameTH']);
						$this->addGrading($model[$i]['Que_cNameTH'],$model[$i]['Que_nID']);
						break;
					case 4:
						$this->openDivDescribe($model[$i]['Que_cNameTH'],$model[$i]['Que_nID'],++$a);
						break;
					case 5:
						# code...
						break;
				}
			}else{
				if($model[$i-1]['Tit_nID']!=$model[$i]['Tit_nID']){
					$a = 0;
					switch ($model[$i-1]['Tan_nID']) {
						case 1:
							$this->closeDivSingleChoiceEnd();
							break;
						case 2:
							if($model[$i-1]['Sch_nID']!=null){
								if($model[$i-1]['stat_subchoice']){
									$this->closeDivMultiSubChoiceEnd();
								}
							}
							break;
						case 3:
							$this->closeTagGrading();
					    	$this->closeDivGrading();
							break;
					}
					if($model[$i-1]['Tan_nID']!=3){
						$this->closeDivHead();
					}
					if($model[$i]['Tan_nID']!=3){
						$this->openDivHead($model[$i]['Tit_cNameTH']);
					}
					switch ($model[$i]['Tan_nID']) {
						case 1:
							$this->openDivSingleChoiceHead($model[$i]['Que_cNameTH'],++$a);
							$this->addDivSingleChoice($model[$i]['Que_nID']
								,$model[$i]['Cho_nID'],$i,$model[$i]['Cho_cNameTH']);
							break;
						case 2:
							if($model[$i-1]['Cho_nID']!=$model[$i]['Cho_nID']){
								$this->openDivMultiQuestion($model[$i]['Que_cNameTH'],++$a);
							}
							if($model[$i]['Sch_nID']!=null){
								$this->openDivMultiChoice($model[$i]['Cho_nID']
									,$model[$i]['Cho_cNameTH'],0);
							}else{
								$this->openDivMultiChoice($model[$i]['Cho_nID']
									,$model[$i]['Cho_cNameTH'],$model[$i]['stat_choice']);
							}
							if($model[$i]['Sch_nID']!=null){
								$this->openDivMultiSubChoiceHead();
								$b=0;
								if($model[$i]['stat_subchoice']){
									$this->openDivMultiSubChoicetxt($model[$i]['Sch_nID'],$model[$i]['Sch_cNameTH']);
								}else{
									$this->openDivMultiSubChoice($model[$i]['Sch_nID'],$model[$i]['Sch_cNameTH']);
								}
							}
							break;
						case 3:
							$this->openDivGrading();
							$this->openTagGrading($model[$i]['Tit_cNameTH']);
					    	$this->addGrading($model[$i]['Que_cNameTH'],$model[$i]['Que_nID']);
							break;
						case 4:
							$this->openDivDescribe($model[$i]['Que_cNameTH'],$model[$i]['Que_nID'],++$a);
							break;
						case 5:
							# code...
							break;
					}
				}else{
					if($model[$i-1]['Tan_nID']!=$model[$i]['Tan_nID']){
						switch ($model[$i-1]['Tan_nID']) {
						case 1:
							$this->closeDivSingleChoiceEnd();
							break;
						case 2:
							if($model[$i-1]['stat_subchoice']||$model[$i-1]['Sch_nID']!=null){
								$this->closeDivMultiSubChoiceEnd();
								$b = 0;
							}
							break;
						case 3:
							$this->closeTagGrading();
						    $this->closeDivGrading();
							break;
						default:
							break;
						}
						if($model[$i]['Tan_nID']==3){
							$this->closeDivHead();
							$a = 0;
						}
						switch ($model[$i]['Tan_nID']) {
							case 1:
								$this->openDivSingleChoiceHead($model[$i]['Que_cNameTH'],++$a);
								break;
							case 2:
								$this->openDivMultiQuestion($model[$i]['Que_cNameTH'],++$a);
								break;
							case 4:
								break;
						}
					}
					switch ($model[$i]['Tan_nID']) {
						case 1:
							$this->addDivSingleChoice($model[$i]['Que_nID']
								,$model[$i]['Cho_nID'],$i,$model[$i]['Cho_cNameTH']);
							break;
						case 2:
							if($model[$i]['Cho_nID']!=$model[$i-1]['Cho_nID']){
								/*$this->openDivMultiChoice($model[$i]['Cho_nID']
									,$model[$i]['Cho_cNameTH'],$model[$i]['stat_choice']);*/
								if($model[$i]['Sch_nID']!=null){
									$this->openDivMultiChoice($model[$i]['Cho_nID']
										,$model[$i]['Cho_cNameTH'],0);
								}else{
									$this->openDivMultiChoice($model[$i]['Cho_nID']
										,$model[$i]['Cho_cNameTH'],$model[$i]['stat_choice']);
								}
							}
							if($model[$i]['Sch_nID']!=null){
								if($model[$i-1]['Sch_nID']==null){
									$this->openDivMultiSubChoiceHead();
									$b = 0;
								}else{
									if(!($b%3)){
										$this->closeDivMultiSubChoiceEnd();
										$this->openDivMultiSubChoiceHead();
									}
								}
								++$b;
								if($model[$i]['stat_subchoice']){
									$this->closeDivMultiSubChoiceEnd();
									$this->openDivMultiSubChoiceHead();
									$this->openDivMultiSubChoicetxt($model[$i]['Sch_nID'],$model[$i]['Sch_cNameTH']);
									$this->closeDivMultiSubChoiceEnd();
									$this->openDivMultiSubChoiceHead();
									$b = 0;
								}else{
									$this->openDivMultiSubChoice($model[$i]['Sch_nID'],$model[$i]['Sch_cNameTH']);
								}
							}
							break;
						case 3:
							$this->addGrading($model[$i]['Que_cNameTH'],$model[$i]['Que_nID']);
							break;
						case 4:
							$this->openDivDescribe($model[$i]['Que_cNameTH'],$model[$i]['Que_nID'],++$a);
							break;
						case 5:
							# code...
							break;
					}
					
				}
			}
			if($i==count($model)-1){
				switch ($model[$i]['Tan_nID']) {
				case 1:
					$this->closeDivHead();
					$a = 0;
					break;
				case 2:
					if($model[$i]['stat_subchoice']){
						$this->closeDivMultiSubChoiceEnd();
					}
					//$this->closeDivMultiSubChoiceEnd();
					break;
				case 3:
					$this->closeTagGrading();
					$this->closeDivGrading();
					break;
				case 4:
					$this->closeDivHead();
					$a = 0;
					break;
				case 5:
					break;
				}
				$this->buttonSubmit();
				if($model[$i]['Tan_nID']!=3){
					$this->closeDivHead();
					$a = 0;
				}
			}
		}

	}
	private function addGrading($question,$idPK){
		echo CHtml::openTag('tr');
	    echo CHtml::tag('td',array(),$question);

	    echo CHtml::openTag('td',array('class'=>'text-center'));
	    echo CHtml::tag('div',array('class'=>'radio radio-info'));
	    echo CHtml::radioButton('rdo'.$idPK,false,array('id'=>'radio5'.$idPK,'value'=>'5'
	    	,'class'=>'UnChecked','onclick'=>'rdoCheck(this)'));
	    echo CHtml::label('','radio5'.$idPK);
	    echo CHtml::tag('div');
		echo CHtml::closeTag('td');

		echo CHtml::openTag('td',array('class'=>'text-center'));
		echo CHtml::tag('div',array('class'=>'radio radio-info'));
		echo CHtml::radioButton('rdo'.$idPK,false,array('id'=>'radio4'.$idPK,'value'=>'4'
			,'class'=>'UnChecked','onclick'=>'rdoCheck(this)'));
		echo CHtml::label('','radio4'.$idPK);
		echo CHtml::tag('div');
		echo CHtml::closeTag('td');

		echo CHtml::openTag('td',array('class'=>'text-center'));
		echo CHtml::tag('div',array('class'=>'radio radio-info'));
		echo CHtml::radioButton('rdo'.$idPK,false,array('id'=>'radio3'.$idPK,'value'=>'3'
			,'class'=>'UnChecked','onclick'=>'rdoCheck(this)'));
		echo CHtml::label('','radio3'.$idPK);
		echo CHtml::tag('div');
		echo CHtml::closeTag('td');

		echo CHtml::openTag('td',array('class'=>'text-center'));
		echo CHtml::tag('div',array('class'=>'radio radio-info'));
		echo CHtml::radioButton('rdo'.$idPK,false,array('id'=>'radio2'.$idPK,'value'=>'2'
			,'class'=>'UnChecked','onclick'=>'rdoCheck(this)'));
		echo CHtml::label('','radio2'.$idPK);
		echo CHtml::tag('div');
		echo CHtml::closeTag('td');

		echo CHtml::openTag('td',array('class'=>'text-center'));
		echo CHtml::tag('div',array('class'=>'radio radio-info'));
		echo CHtml::radioButton('rdo'.$idPK,false,array('id'=>'radio1'.$idPK,'value'=>'1'
			,'class'=>'UnChecked','onclick'=>'rdoCheck(this)'));
		echo CHtml::label('','radio1'.$idPK);
		echo CHtml::tag('div');
		echo CHtml::closeTag('td');

		echo CHtml::openTag('td',array('class'=>'text-center'));
		echo CHtml::textField('txtrdo'.$idPK,''
			,array('placeholder'=>'ความคิดเห็นเพิ่มเติม...','class'=>'form-control'));
		echo CHtml::tag('span',array('class'=>'ma-form-highlight'));
		echo CHtml::tag('span',array('class'=>'ma-form-bar'));
		echo CHtml::closeTag('td');
	}
	private function openTagGrading($title){
		echo CHtml::openTag('table',array('class'=>'table v-middle table-bordered'));
	    echo CHtml::openTag('thead');
	    echo CHtml::openTag('tr');
	    echo CHtml::tag('th', array('class'=>'text-center','width'=>'40%'), $title);
	    echo CHtml::tag('th', array('class'=>'text-center','width'=>'5%'), 5);
	    echo CHtml::tag('th', array('class'=>'text-center','width'=>'5%'), 4);
	    echo CHtml::tag('th', array('class'=>'text-center','width'=>'5%'), 3);
	    echo CHtml::tag('th', array('class'=>'text-center','width'=>'5%'), 2);
	    echo CHtml::tag('th', array('class'=>'text-center','width'=>'5%'), 1);
	    echo CHtml::tag('th', array('class'=>'text-center','width'=>'35%'), 'ความคิดเห็นเพิ่มเติม');
	    echo CHtml::closeTag('tr');
	   	echo CHtml::closeTag('thead');
	    echo CHtml::openTag('tbody',array('id'=>'responsive-table-body'));
	}
	private function openDivGrading(){
		echo CHtml::openTag('div',array('class'=>'row'));
	   	echo CHtml::openTag('div',array('class'=>'col-md-12 col-lg-12'));
		echo CHtml::openTag('div',array('class'=>'panel panel-default'));
		echo CHtml::openTag('div',array('class'=>'table-responsive'));
	}
	private function closeTagGrading(){
		echo CHtml::closeTag('tbody');
		echo CHtml::closeTag('table');
	}
	private function closeDivGrading(){
		echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');
	}




	private function openDivHead($title){
		echo CHtml::openTag('div',array('class'=>'row panel panel-default'));
	   	echo CHtml::openTag('div',array('class'=>'col-md-12'));
		echo CHtml::openTag('div',array('class'=>'panel panel-default'));
		echo CHtml::openTag('div',array('class'=>'col-md-12 col-sm-12'));
		echo CHtml::tag('h3',array(),$title);
		echo CHtml::closeTag('div');
	}
	private function closeDivHead(){
		echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');
	}



	private function openDivMultiQuestion($question,$counter){
		echo CHtml::tag('div',array('class'=>'col-md-12 col-sm-12 mb-assessment')
			,$counter.") ".$question);
	}
	private function openDivMultiChoice($idPK,$Choice,$stat_txt){
		echo CHtml::openTag('div',array('class'=>'col-md-12 col-sm-12 mb-assessment'));
		echo CHtml::openTag('div',array('class'=>'col-sm-3','style'=>'width: 20%'));
		echo CHtml::openTag('div',array('class'=>'checkbox checkbox-info'));
		echo CHtml::checkbox('chk'.$idPK,false,array('id'=>'chk'.$idPK));
		echo CHtml::label($Choice,'chk'.$idPK);
		echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');
		if($stat_txt){
			echo CHtml::openTag('div',array('class'=>'col-sm-4'));
			echo CHtml::textField('txtChoice'.$idPK,''
				,array('placeholder'=>'ความคิดเห็นเพิ่มเติม...','class'=>'form-control'));
			echo CHtml::tag('span',array('class'=>'ma-form-highlight'));
			echo CHtml::tag('span',array('class'=>'ma-form-bar'));
			echo CHtml::closeTag('div');
		}
		echo CHtml::closeTag('div');
	}
	private function openDivMultiSubChoiceHead(){
		echo CHtml::openTag('div',array('class'=>'col-md-11 col-md-offset-1 col-sm-12 mb-assessment'));
	}
	private function closeDivMultiSubChoiceEnd(){
		echo CHtml::closeTag('div');
	}
	private function openDivMultiSubChoice($idPK,$subChoice){
		echo CHtml::openTag('div',array('class'=>'checkbox checkbox-info checkbox-inline'));
		echo CHtml::checkbox('chkSub'.$idPK,false,array('id'=>'chkSub'.$idPK));
		echo CHtml::label($subChoice,'chkSub'.$idPK);
		echo CHtml::closeTag('div');
	}
	private function openDivMultiSubChoicetxt($idPK,$subChoice){
		echo CHtml::openTag('div',array('class'=>'col-sm-3','style'=>'width: 10%;padding-left: 0;'));

		echo CHtml::openTag('div',array('class'=>'checkbox checkbox-info'));
		echo CHtml::checkbox('chkSub'.$idPK,false,array('id'=>'chkSub'.$idPK));
		echo CHtml::label($subChoice,'chkSub'.$idPK);
		echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');

		echo CHtml::openTag('div',array('class'=>'col-sm-4'));
		echo CHtml::textField('txtSubChoice'.$idPK,''
			,array('placeholder'=>'ความคิดเห็นเพิ่มเติม...','class'=>'form-control'));
		echo CHtml::openTag('span',array('class'=>'ma-form-highlight'));
		echo CHtml::closeTag('span');
		echo CHtml::openTag('span',array('class'=>'ma-form-bar'));
		echo CHtml::closeTag('span');


		echo CHtml::closeTag('div');
	}




	private function openDivSingleChoiceHead($question,$count){
		echo CHtml::tag('div',array('class'=>'col-md-12 col-sm-12 mb-assessment'),$count.") ".$question);
		echo CHtml::openTag('div',array('class'=>'col-md-11 col-md-offset-1 col-sm-12 mb-assessment'));
	}

	private function closeDivSingleChoiceEnd(){
		echo CHtml::closeTag('div');
	}

	private function addDivSingleChoice($question,$idPK,$count,$choice){
		echo CHtml::openTag('div',array('class'=>'radio radio-info radio-inline'));
		echo CHtml::radioButton('rdoChoice'.$question,false,array('id'=>'radio'.$count,'value'=>$idPK
	    	,'class'=>'UnChecked','onclick'=>'rdoCheck(this)'));
		echo CHtml::label($choice,'radio'.$count);
		echo CHtml::closeTag('div');
	}

	private function openDivDescribe($question,$idPK,$count){
		echo CHtml::openTag('div',array('class'=>'col-md-12 col-sm-12 mb-assessment'));
		echo CHtml::tag('span',array(),$count.") ".$question);
		echo CHtml::textField('txt'.$idPK,''
			,array('placeholder'=>'ความคิดเห็นเพิ่มเติม...'
				,'style'=>'width: 50%;margin-top: 10px;'
				,'class'=>'form-control'));
		echo CHtml::closeTag('div');
	}

	private function buttonSubmit(){
		echo CHtml::openTag('div',array('class'=>'col-md-12 col-sm-12 mb-assessment'
			,'style'=>'margin-bottom: 40px;margin-top: 40px;'));
		echo CHtml::button('ส่งแบบประเมิน',array('id'=>'btnCheck'
			,'class'=>'navbar-btn btn btn-primary'));
		echo CHtml::closeTag('div');
	}
}
?>