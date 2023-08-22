<style>
	input[type="radio"] { /* Change width and height */
		width:3em;
		height:3em;
	}
	input[type="checkbox"] { /* Change width and height */
		width:3em;
		height:3em;
	}
	hr.soften {
		height: 1px;
		background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		border: 0;
	}
</style>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.js"></script>
<?php
$this->breadcrumbs=array(
	'จัดการชุดข้อสอบหลักสูตร'=>array('//Coursegrouptesting/Index'),
	'จัดการข้อสอบ'=>array('//Coursequestion/index','id'=>Yii::app()->user->getState('getReturn')),
    strip_tags(CHtml::decode($modelQues->ques_title)),
);
?>
<style type="text/css">
.block { display: block; }
label.error { display: none; }
</style>
<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>แก้ไขข้อสอบ
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<!--<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>-->
			<!-- FORM -->
			<?php
			/*
			$old = array(1, 3, 4);
			$new = array(3, 4, 5, 6);
			echo '$old = array(1, 3, 4)<br>';
			echo '$new = array(3, 4, 5, 6)<br>';
			echo 'Case Insert : '.implode(",",array_diff($new,$old))."<br>";
			echo 'Case Update : '.implode(",",array_intersect($new,$old))."<br>";
			echo 'Case Delete : '.implode(",",array_diff($old,$new))."<br>";
			*/
			?>
			<div class="form">
				<?php echo CHtml::beginForm(Yii::app()->request->requestUri,'POST',array(
					'id'=>'Question',
					'name'=>'Question',
					'enableAjaxValidation'=>false,
				));?>
				<div id="question-list">
					<div class="question-group" data-index="<?php echo $modelQues->ques_id; ?>">
						<div class="row question">
							<?php
							$questionTypeArray = array(1 => 'checkbox', 2 => 'radio', 3 => 'textarea', 4 => 'dropdown', 6 => 'hidden');
							?>
							<label><h3>โจทย์ <input type="hidden" name="Question_type[<?php echo $modelQues->ques_id; ?>]" value="<?php echo $questionTypeArray[$modelQues->ques_type]; ?>"> <!--ข้อที่ <span class="question-numbers" style="color:green; font-size: 20px;">'+question_total+'</span>--></h3>
								</label>
								<?php if($modelQues->ques_type == 3){ ?>
								<div class="span11">
									<label><h3> คะแนนเต็ม</h3>
										<input type="number" name="Question_score[<?php echo $modelQues->ques_id; ?>]" min=0 pattern="[0-9]" value="<?php echo $modelQues->max_score; ?>">
									</label>
								</div>
							<?php } ?>
							<div class="span12">
								<textarea name="Question[<?php echo $modelQues->ques_id; ?>]" class="question-title tinymce" id="question-<?php echo $modelQues->ques_id; ?>-title" cols="30" rows="10"><?php echo $modelQues->ques_title; ?></textarea>
								</div>
							</div>
                        <div class="row question">
                            <label><h3>อธิบายคำตอบ</h3></label>
                            <div class="span12">
                                <textarea name="Explain[<?php echo $modelQues->ques_id; ?>]" class="question-explain" id="question-<?php echo $modelQues->ques_id; ?>-explain" cols="30" rows="10"><?php echo $modelQues->ques_explain; ?></textarea>
                            </div>
                        </div>
						<?php if(($modelQues->ques_type != 3) && ($modelQues->ques_type != 4)){ ?>
							<div class="row choice-list<?php if($modelQues->ques_type == 6){ echo "-sort"; } ?>" style="margin-top:20px;">
							<label><h3>ตัวเลือก <a class="btn btn-icon btn-success add-chocie<?php if($modelQues->ques_type == 6){ echo "-sort"; } ?>" data-question-id="<?php echo $modelQues->ques_id; ?>">
										<i class="icon-book"></i> เพิ่มตัวเลือก</a></h3></label>
							<?php
							$modelChoice = $modelQues->choices;
							if(count($modelChoice) > 0){
								foreach($modelChoice as $key => $choice){
							?>

								<div class="row choice" style="margin-top:20px;">
									<div class="span1">
										<input type="<?php echo $questionTypeArray[$modelQues->ques_type]; ?>" name="Choice[<?php echo $modelQues->ques_id; ?>][]"
											   class="choice-<?php echo $modelQues->ques_id; ?>-input pull-right" value="<?php echo $choice->choice_id; ?>" <?php echo ($choice->choice_answer == 1)?'checked':''; ?>>
									</div>
									<div class="span8">
										<textarea name="ChoiceTitle[<?php echo $modelQues->ques_id; ?>][<?php echo $choice->choice_id; ?>]"
												  class="choice-tilte-input tinymce"
												  id="choice-<?php echo $modelQues->ques_id; ?>-<?php echo $choice->choice_id; ?>-tilte-input" cols="30"
												  rows="10"><?php echo $choice->choice_detail; ?></textarea>
										<a class="btn btn-icon btn-danger circle_ok choice-remove">
											<i class="icon-remove"></i> ลบตัวเลือก</a>
									</div>
								</div>

							<?php
								}
							}
							?>
							</div>
						<?php } ?>

						<?php if($modelQues->ques_type == 4){ ?>
							   	<div class="row choice-list1" style="margin-top:20px;">
							    	<label>
							    		<h3>เพิ่มส่วนที่ 1 เพิ่มคำถามและคำตอบ
							    			<a class="btn btn-icon btn-success add-chocie-part1" data-question-id="<?= $modelQues->ques_id ?>">
							        				<i class="icon-book"></i> เพิ่มตัวเลือก
							    			</a>
							    		</h3>
							    	</label>

							<?php
							$modelChoice = $modelQues->choices;
							$count_choice_element1 = 0;

							if(count($modelChoice) > 0){
								foreach($modelChoice as $key => $choice){

							?>


								<?php if($choice->choice_answer == 1) { ?>

							     

									<div class="widget widget-tabs border-bottom-none choice1<?= $modelQues->ques_id ?>-<?= $count_choice_element1?>">


							        <script>
							        $(function(){
								        tinyMCE.init({
								       		height:'100px',
								        });
							        });
							        </script>


							        <div class="widget-body">

								        <div class="row" style="margin-top:20px;">
									        <div class="span1">
									        คำถาม
									        	<input type="hidden" name="Choice[quest][<?= $modelQues->ques_id ?>][]" class="choiceQ-<?= $modelQues->ques_id ?>-input pull-right" value="<?php echo $choice->choice_id; ?>">
									        </div>
									        <div class="span8">
									        	<textarea name="ChoiceTitle[quest][<?= $modelQues->ques_id ?>][<?php echo $choice->choice_id; ?>]" class="choiceQ-<?= $modelQues->ques_id ?>-tilte-input" id="choice-q<?= $modelQues->ques_id ?>-<?php echo $choice->choice_id; ?>-tilte-input" cols="30" rows="10"><?= $choice->choice_detail ?></textarea>
									        </div>
								        </div>

							        <?php 
							        	foreach($modelChoice as $key => $choice2){ 
							        		if($choice2->reference == $choice->choice_id) {
							        ?>
									        <div class="row" style="margin-top:20px;">
										        <div class="span1">
										        คำตอบ
										        	<input type="hidden" name="Choice[ans][<?= $modelQues->ques_id ?>][]" class="choiceA-<?= $modelQues->ques_id ?>-input pull-right" value="<?php echo $choice2->choice_id; ?>">
										        </div>
										        <div class="span8">
										       		<textarea name="ChoiceTitle[ans][<?= $modelQues->ques_id ?>][<?php echo $choice2->choice_id; ?>]" class="choiceA-<?= $modelQues->ques_id ?>-tilte-input" id="choice-a<?= $modelQues->ques_id ?>-<?php echo $choice2->choice_id; ?>-tilte-input" cols="30" rows="10"><?= $choice2->choice_detail ?></textarea>
										        	<a class="btn btn-icon btn-danger circle_ok choice-remove1" data-question="<?= $modelQues->ques_id ?>" data-new_index="<?php echo $choice2->choice_id; ?>">
										        		<i class="icon-remove"></i> ลบตัวเลือก
										        	</a>
										        </div>
								        	</div>


									<?php 
										$count_choice_element1++;

											}
										}
									 ?> 
							    	</div>
									</div>

								<?php } ?> 


								
							<?php 
								}
							?>
							    </div>
							<?php 
							} 
							?> 

							<div class="row choice-list2" style="margin-top:20px;">
						       <label><h3>เพิ่มส่วนที่ 2 เพิ่มคำตอบหลอก<a class="btn btn-icon btn-success add-chocie-part2" data-question-id="<?= $modelQues->ques_id ?>"><i class="icon-book"></i> เพิ่มตัวเลือก</a></h3></label>
							<?php
								$count_choice_element2 = $count_choice_element1;
								foreach($modelChoice as $key => $choice){
							?>
								<?php if(($choice->choice_answer == 2) && ($choice->reference == null)) { ?>
								

								<div class="row choice1<?= $modelQues->ques_id ?>-<?php echo $choice->choice_id; ?>" style="margin-top:20px;">


								<div class="row" style="margin-top:20px;">
							        <div class="span1">
							        คำตอบ
							        	<input type="hidden" name="Choice[ans][<?= $modelQues->ques_id ?>][]" class="choiceA-<?= $modelQues->ques_id ?>-input pull-right" value="<?php echo $choice->choice_id; ?>">
							        </div>

							        <div class="span8">
							        	<textarea name="ChoiceTitle[ans][<?= $modelQues->ques_id ?>][<?php echo $choice->choice_id; ?>]" class="choiceA-<?= $modelQues->ques_id ?>-tilte-input" id="choice-a<?= $modelQues->ques_id ?>-<?php echo $choice->choice_id; ?>-tilte-input" cols="30" rows="10"><?= $choice->choice_detail ?></textarea>
							        	<a class="btn btn-icon btn-danger circle_ok choice-remove1" data-question="<?= $modelQues->ques_id ?>" data-new_index="<?php echo $choice->choice_id; ?>">
							        		<i class="icon-remove"></i> ลบตัวเลือก
							        	</a>
							        </div>
						        </div>
						        </div>


								<?php 
										$count_choice_element2++;
									} 
								?> 

							<?php 
								}	
							?> 
						    </div>


						<?php }	?> 
						</div>
				</div>
				<div class="row buttons" style="padding-top: 26px;">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','onclick'=>'tinyMCE.triggerSave();'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
			<!-- END form -->
		</div>
	</div>
</div>
<script>
    $(function () {
        init_tinymce_question();
    });
</script>
<!-- END innerLR -->
