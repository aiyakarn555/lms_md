<?php
/* @var $this TestController */
/* @var $model User */

$this->breadcrumbs=array(
    'Reset รายบุคคล'=>array('LearnReset/reset_user'),
    'Reset ข้อมูลการสอบ'
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
  $('.search-form').toggle();
  return false;
});
$('.search-form form').submit(function(){
  $('#user-grid').yiiGridView('update', {
    data: $(this).serialize()
  });
  return false;
});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
  $.updateGridView = function(gridID, name, value) {
      $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
      $.fn.yiiGridView.update(gridID, {data: $.param(
          $("#"+gridID+" input, #"+gridID+" .filters select")
      )});
  }
  $.appendFilter = function(name, varName) {
      var val = eval("$."+varName);
      $("#reset-form").append('<input type="hidden" name="'+name+'" value="">');
  }
  $.appendFilter("LearnReset[news_per_page]", "news_per_page");
EOD
    , CClientScript::POS_READY);


?>

<div class="innerLR">

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>

              <span class="pull-left" style="color:#000;">
                Reset ข้อมูลการสอบ :
                <span class="strong"><?php echo $user->first_name." ".$user->last_name; ?></span>
              </span>
        </div>
        <div class="widget-body">
            <div class="separator bottom form-inline small">
                <div class="buttons pull-left">
                    <?php echo CHtml::link("<i></i> ลบข้อมูลการสอบที่เลือก","#",array(
                        "class"=>"btn btn-primary btn-icon glyphicons circle_minus",
                        "onclick"=>"return multipleDeleteNews('".$this->createUrl('LearnReset/MultiDelete_exam_lesson')."','reset-form');"
                    )); ?>
                </div>

            </div>
            <div class="clear-div"></div>
            <div class="overflow-table">

                <?php $this->widget('AGridView', array(
                    'id'=>'reset-form',
                    'selectableRows' => 2,
                    'dataProvider'=>$dataProvider,
                    'filter'=>$model,
                    'afterAjaxUpdate'=>'function(id, data){
            $.appendFilter("LearnReset[news_per_page]");
            InitialSortTable();
          }',
                    'columns'=>array(
                        array(
                            'visible'=>Controller::DeleteAll(
                                array("LearnReset.*", "LearnReset.Delete", "LearnReset.MultiDelete")
                            ),
                            'class'=>'CCheckBoxColumn',
                            'id'=>'chk',
                        ),
                        array(
                            'header'=>'ชื่อบทเรียนที่มีการสอบ',
                            'value'=> function($data){
                                return $data->lesson->title;
                            },
                            'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header'=>'จำนวนนักศึกษา',
                            'value'=> function($data){
                                $university_user = User::model()->findAll(array(
                                    'condition' => 'student_house=' . $data->user->university->id,
                                ));
                                $ids = array();
                                if ($university_user) {
                                    foreach ($university_user as $user) {
                                        $ids[] = $user->id;
                                    }
                                }
                                $sum = 0;
                                $text = '';
                                $criteria = new CDbCriteria;
                                $criteria->addCondition('lesson_id='. $data->lesson->id);
                                $criteria->addInCondition('user_id', $ids);
                                $criteria->addCondition('type="pre"');
                                $criteria->group ='user_id';
                                $scorePre = Score::model()->findAll($criteria);
                                if($scorePre){
                                    $sum += count($scorePre);
                                    $text .= 'ก่อนเรียน: '.$sum.'คน / ';
                                }
                                $criteria = new CDbCriteria;
                                $criteria->addCondition('lesson_id='. $data->lesson->id);
                                $criteria->addInCondition('user_id', $ids);
                                $criteria->addCondition('type="post"');
                                $criteria->group ='user_id';
                                $scorePost = Score::model()->findAll($criteria);
                                if($scorePost){
                                    $sum += count($scorePost);
                                    $text .= 'หลังเรียน: '.$sum.'คน';
                                }
                                return $text;
                            },
                            'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header' => 'ลบการสอบ',
                            'type'=>'raw',
                            'value' => function($data){
                                return CHtml::link('Resets','#'.$data->user->university->id,array(
                                  'class'=>'btn btn-primary learn-reset',
                                  'data-lesson-id'=> $data->lesson->id,
                                ));
                            },
                            'htmlOptions'=> array('style'=>'text-align:center;width:100px;'),
                            'headerHtmlOptions'=> array('style'=>'text-align:center;'),
                        ),
                    ),
                )); ?>

            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        $('body').on('click','.learn-reset',function(){
            if(!confirm("คุณต้องการ Reset การเรียน ใช่หรือไม่ ?")) return false;
            var val = $(this).attr('href');
            var uniID = val.substr(1);
            var lessonID = $(this).attr('data-lesson-id');
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('LearnReset/resetScoreLessonUni');?>",
                data:{ uniID:uniID,lessonID:lessonID },
                success: function(data) {
                    alert("Reset การเรียน เรียบร้อยแล้ว");
                    window.location.href="<?= $this->createUrl('LearnReset/showResetExamLessonUni?uniID='); ?>"+uniID;
                }
            })
        });
    });
</script>