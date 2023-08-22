<style>
    .tableFixHead          { overflow: auto; height: 500px; }
.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

/* Just common table stuff. Really. */
table  { border-collapse: collapse;
    border: 1px solid rgba(0,0,0,.125);
}
td {      border-right: 1px solid rgba(0,0,0,.125); border-bottom: 1px solid rgba(0,0,0,.125); vertical-align: text-bottom;}
th     { background:#eee;  }

.block {
      display: block;
   }
.bg-wrong {
    background-color: #FFCCCC;
}
.ans-wrong{
    background-color: red;
}

.ans-correct{
    background-color: #28a745!important;
}

</style>
<?php 
    $gen_id = $model->getGenID($model->course_id);
?>
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div>
				<?php $form=$this->beginWidget('AActiveForm', array(
					'id'=>'manage-exam-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
                <div class="row">
                    <div class="col-md-12 ">
                        <label><h4>ชื่อคอร์สเรียน : <?= $model->course_title ?></h4></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <label><h4>ชื่อบทเรียน : <?php $lessonExam = Lesson::model()->findByPk($lesson_id) ; echo $lessonExam->title; ?>
                    
                    </h4></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <label><h4>เปอร์เซ็นการผ่าน : <span><?= $lessonExam->cate_percent." %"; ?></span></h4></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                         <?php 
                         
                            $modelScoreExam = Score::model()->find(array(
                                'condition' => 'user_id=:user_id AND course_id=:course_id AND lesson_id=:lesson_id AND active="y" AND type=:type',
                                'params' => array(':user_id' => $user_id,':course_id' => $model->course_id,':type'=> 'post',':lesson_id'=> $lesson_id),
                                'order' => 'score_id desc'));

                           $logQuesExam = Logques::model()->findAll(array(
                            'condition' => 'score_id=:score_id AND user_id=:user_id',
                            'params' => array(':score_id' => $modelScoreExam->score_id,':user_id'=>$user_id))
                            );

                            $scoreExam = 0;
                            $totalScoreExam = 0;
                            $answerCheck = [];
                            foreach ($logQuesExam as $key => $value) {
                                $totalScoreExam++;
                                if($value->result >= 1){
                                    $scoreExam++;
                                }

                                $answerQuestionExam = Choice::model()->findAll(array(
                                    'condition'=>"ques_id=:ques_id and choice_answer='1'",
                                    'params' => array(':ques_id' => $value->ques_id)
                                ));

                                foreach($answerQuestionExam as $key => $ansquestexam) {
                                    $answerCheck[] = $ansquestexam->choice_id;
                                }
                          
                            }
                         ?>
                        <label><h4>คะแนน : <span id="score-exam"><?= $scoreExam.'/'.$totalScoreExam." (".number_format((float)(($scoreExam/$totalScoreExam)*100), 2, '.', '')." %".")" ?></span></h4></label>
                    </div>
                </div>
                <input type="hidden" name="scoreExam" id="scoreExam" value="<?= $scoreExam ?>"/>
                <input type="hidden" name="statusPass" id="statusPass" value="<?= number_format((float)(($scoreExam/$totalScoreExam)*100), 2, '.', '') >= $lessonExam->cate_percent  ? 'y': 'n'?>"/>
                <input type="hidden" name="checkArticleSame" id="checkArticleSame" value=""/>
                <input type="hidden" name="checkChoiceSame" id="checkChoiceSame" value=""/>
                <br>
                 <div class="tableFixHead">
                        <table style="width:100%">
                            <thead>
                            <tr>
                                <th>โจทย์ข้อสอบ</th>
                                <th>คำตอบ</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                                <?php   
                                  $score = 0;
                                  $modelScore = Score::model()->find(array(
									'condition' => 'user_id=:user_id AND course_id=:course_id AND lesson_id=:lesson_id AND active="y" AND type=:type',
									'params' => array(':user_id' => $user_id,':course_id' => $model->course_id,':type'=> 'post',':lesson_id'=> $lesson_id),
									'order' => 'score_id desc'));
                                    
                                    $logQues = Logques::model()->findAll(array(
                                        'condition' => 'score_id=:score_id AND user_id=:user_id',
                                        'params' => array(':score_id' => $modelScore->score_id,':user_id'=>$user_id)));

                      
                                    
                                    $i = 0;
                                    foreach ($logQues as $key => $value) {
                                        $question = Question::model()->find(array(
                                            'condition' => 'ques_id = '.$value->ques_id
                                        ));
                                        $checked = "";
                                        $modelChoice = $question->choices;

                                        $bg = "";
                                        $bg_ans = "";
                                        if($value->result < 1){
                                            $score++;
                                            $bg = "bg-wrong";
                                            $bg_ans = "ans-wrong";
                                        }
                                        //คำตอบ
                                 
                                        $answer = logchoice::model()->findAll(array( 
                                            'condition'=>"score_id=:score_id and logchoice_answer = 1 and ques_id=:ques_id",
                                            'params' => array(':score_id' =>  $value->score_id,':ques_id' => $value->ques_id)
                                        ));
                                        $answerQuestion = Choice::model()->findAll(array(
                                            'condition'=>"ques_id=:ques_id and choice_answer='1'",
                                            'params' => array(':ques_id' => $value->ques_id)
                                        ));
                                  
                                        $answerUser = "";
                                        foreach($answer as $key => $ans) {
                                            $answerUser = $ans->choice_id;
                                        }

                                        foreach($answerQuestion as $key => $ansquest) {
                                            $answerQuest = $ansquest->choice_id;
                                        }
                                        ?>
                                        <tr >
                                            <td class="<?= $bg ?>"><?= ($i+1)."." ?> <?= strip_tags($question->ques_title) ?></td>
                                            <td class="<?= $bg ?>">
                                                <?php 
                                                    foreach($modelChoice as $key => $choice){
                                                        $checked = "";
                                                        $checkedWrong ="";
                                                       if($answerUser == $choice->choice_id && $answerUser != $answerQuest){
                                                            $checkedWrong=true;
                                                       }
                                                    ?>
                                                    <?php if ($checkedWrong) { ?>
                                                        <label class="block <?=  $answerQuest == $choice->choice_id ? "ans-correct" : "" ?>" >
                                                            <input id="radioWrong-<?= $choice->choice_id ?>" type="radio" <?=  $answerUser == $choice->choice_id ? "checked" : "" ?> disabled value='<?= $choice->choice_id ?>' name="ChoiceWrong[<?= $value->ques_id ?>][]" style="height:25px; width:25px; vertical-align: middle;">
                                                            <input hidden name="ChoiceWrong[<?= $value->ques_id ?>][]" value='<?= $choice->choice_id ?>'/>
                                                            <span style="vertical-align: middle;"><?= strip_tags($choice->choice_detail); ?></span>
                                                        </label> 
                                                    <?php }else{ ?>
                                                        <label class="block <?=  $answerQuest == $choice->choice_id ? "ans-correct" : "" ?>" >
                                                            <input id="radio-<?= $choice->choice_id ?>" type="radio"  value='<?= $choice->choice_id ?>' <?=  $answerQuest == $choice->choice_id && !$bg? "checked" : "" ?> value='<?= $choice->choice_id ?>' name="Choice[<?= $value->ques_id ?>][]" style="height:25px; width:25px; vertical-align: middle;">
                                                            <span style="vertical-align: middle;"><?= strip_tags($choice->choice_detail); ?></span>
                                                         </label> 
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                 <?php     
                                    $i++; 
                                    }
                                ?>
                            </tbody>
                        </table>
                </div>
                <br>
                <br>
                <div class="container-fluid">
                    <div class="row buttons">
                        <span style="display: inline;">
                                <?=  CHtml::link("<i></i> ย้อนกลับ",array("/manageExamResult/ManageLesson",
                                        "type_cou"=>$type_cou,
                                        "course_id"=>$course_id,
                                        "gen_id"=>$gen_id,
                                        "result_status"=>$result_status,
                                        "name_id_search"=>$name_id_search,
                                        "email"=>$email,
										),array("class"=>"btn btn-danger btn-icon glyphicons chevron-left","type"=>"button")); ?>
                            &nbsp;
                            <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2', 'onclick' => "return upload();"), '<i></i>บันทึกข้อมูล'); ?> 
                        </span>
                    </div>
                </div>
                
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>

<script>
    var answerCheck = <?= json_encode($answerCheck) ?>;
    var scoreExam = <?= $scoreExam ?>;
    var scoreExamTotal = <?= $totalScoreExam ?>;
    var percentPass = <?= $lessonExam->cate_percent ?>;
    var arrCheck = [];
    $('input[name*="Choice"]').change(function(){
        var thenum = $(this).attr('name').match(/\d+/)[0];
        if(answerCheck.includes(this.value)){
            if($("#checkArticleSame").val() != $(this).attr('name') || ($("#checkArticleSame").val() == $(this).attr('name') && $("#checkChoiceSame").val() != this.value)){
                delete arrCheck[thenum];
                ++scoreExam;
                $("#score-exam").html(scoreExam+"/"+scoreExamTotal+" ("+((scoreExam/scoreExamTotal)*100).toFixed(2)+" %"+")");
                $("#checkArticleSame").val("");
                $("#checkChoiceSame").val("");
            }
        }else{
            if($("#scoreExam").val() > 0 && $("#checkArticleSame").val() != $(this).attr('name') && arrCheck[thenum] == null){
                arrCheck[thenum] = thenum; 
                --scoreExam;
                $("#score-exam").html(scoreExam+"/"+scoreExamTotal+" ("+((scoreExam/scoreExamTotal)*100).toFixed(2)+" %"+")");
                $("#checkArticleSame").val($(this).attr('name'));
                $("#checkChoiceSame").val(this.value);
            }
        }
        $("#scoreExam").val(scoreExam);
        if(((scoreExam/scoreExamTotal)*100).toFixed(2) >= percentPass){
            $("#statusPass").val('y');
        }else{
            $("#statusPass").val('n');
        }
    });
</script>
</script>