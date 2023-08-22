<?php
/* @var $this TestController */
/* @var $model User */

$titleName = 'Reset ข้อมูลบทเรียน';
$this->headerText = $titleName;
$this->breadcrumbs=array(
    'Reset รายบุคคล'=>array('LearnReset/reset_user'),
    'Reset ข้อมูลบทเรียน'
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
<!--        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>

              <span class="pull-left" style="color:#000;">
                Reset ข้อมูลบทเรียน :
                <span class="strong"><?php echo $user->first_name." ".$user->last_name; ?></span>
              </span>
        </div>-->
        <div class="widget-body">
            <!-- <div class="separator bottom form-inline small">
                <div class="buttons pull-left">
                    <?php echo CHtml::link("<i></i> ลบข้อมูลการเรียนที่เลือก","#",array(
                        "class"=>"btn btn-primary btn-icon glyphicons circle_minus",
                        "onclick"=>"return multipleDeleteNews('".$this->createUrl('LearnReset/MultiDelete_learn_user')."','reset-form');"
                    )); ?>
                    <?php echo CHtml::link("<i></i> ลบข้อมูลการสอบที่เลือก","#",array(
                        "class"=>"btn btn-primary btn-icon glyphicons circle_minus",
                        "onclick"=>"return multipleDeleteNews('".$this->createUrl('LearnReset/MultiDelete_score_user')."','reset-form');"
                    )); ?>
                </div>

            </div> -->
            <div class="clear-div"></div>
            <div class="overflow-table">

                <?php $this->widget('booster.widgets.TbGridView', array(
                    'id'=>'reset-form',
                    'selectableRows' => 2,
                    'dataProvider'=>$dataProvider,
                    'filter'=>$model,
                    'summaryText' => false, // 1st way
                    'afterAjaxUpdate'=>'function(id, data){
            $.appendFilter("LearnReset[news_per_page]");
            InitialSortTable();
          }',
                    'columns'=>array(
                        // array(
                        //     'visible'=>Controller::DeleteAll(
                        //         array("LearnReset.*", "LearnReset.Delete", "LearnReset.MultiDelete")
                        //     ),
                        //     'class'=>'CCheckBoxColumn',
                        //     'id'=>'chk',
                        // ),
                        array(
                            'header'=>'ชื่อบทเรียนที่มีการเรียน',
                            'value'=> function($data){
                                return $data->lesson->title;
                            },
                            // 'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header' => 'หลักสูตร',
                            'value' => function($data){
                                return $data->lesson->courseonlines->course_title;
                            },
                            // 'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header' => 'ลบการเรียนบทเรียน',
                            'type'=>'raw',
                            'value' => function($data){
                                return CHtml::link('Resets','#'.$data->user_id,array(
                                  'class'=>'btn btn-primary learn-reset',
                                  'data-lesson-id'=> $data->lesson_id,
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
            var stdID = val.substr(1);
            var lessonID = $(this).attr('data-lesson-id');
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('LearnReset/resetLearnLesson');?>",
                data:{ stdID:stdID,lessonID:lessonID },
                success: function(data) {
                    alert("Reset การเรียน เรียบร้อยแล้ว");
                    window.location.href="<?= $this->createUrl('LearnReset/showResetLesson?userID='); ?>"+stdID;
                }
            })
        });
    });
</script>