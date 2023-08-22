<?php
/* @var $this TestController */
/* @var $model User */

$formNameModel = 'User';
$titleName = 'Reset ข้อมูลหลักสูตร';
$this->headerText = $titleName;
$this->breadcrumbs=array(
    'Reset รายบุคคล'=>array('LearnReset/reset_user'),
    'Reset ข้อมูลหลักสูตร'
);

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("User[per_page]", "per_page");
EOD
    , CClientScript::POS_READY);


?>

<div class="innerLR">

    <div class="widget" style="margin-top: -1px;">
<!--        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>

              <span class="pull-left" style="color:#000;">
                Reset ข้อมูลหลักสูตร :
                <span class="strong"><?php echo $user->first_name." ".$user->last_name; ?></span>
              </span>
        </div>-->
        <div class="widget-body">
            <div class="separator bottom form-inline small">
            </div>
            <div class="clear-div"></div>
            <div class="overflow-table">
                <?php
                $this->widget('booster.widgets.TbGridView', array(
//                    'loadProcessing' => true,
                    'id'=>$formNameModel.'-grid',
                    'selectableRows' => 2,
                    'dataProvider'=>$dataProvider,
                    'filter'=>$model,
                    'summaryText' => false, // 1st way
                    'columns'=>array(
                        // array(
                        //     'visible'=>Controller::DeleteAll(
                        //         array("LearnReset.*", "LearnReset.Delete", "LearnReset.MultiDelete")
                        //     ),
                        //     'class'=>'CCheckBoxColumn',
                        //     'id'=>'chk',
                        //     'value'=> function($data){
                        //         return $data->lesson->courseonlines->course_id;
                        //     },
                        // ),
                        array(
                            'header' => 'หลักสูตรที่มีการเรียน',
                            // 'value' => '$data->course_title',
                            'value' => function($data){
                                return $data->lesson->courseonlines->course_title;
                            },
                            // 'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header' => 'หมวดหลักสูตร',
                            // 'value' => '$data->course_title',
                            'value' => function($data){
                                return $data->lesson->courseonlines->cates->cate_title;
                            },
                            // 'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header' => 'ลบการเรียนหลักสูตร',
                            'type' => 'raw',
                            // 'value' => '$data->learn_id',
                            'value' => function($data){
                                return CHtml::link('Reset','#'.$data->user_id,array(
                                  'class'=>'btn btn-primary learn_reset',
                                  'data-course-id'=> $data->lesson->courseonlines->course_id,
                                ));
                            },
                            'htmlOptions'=>array( 'style'=>'text-align:center;'),
                            'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
                        ),
                    ),
                )); ?>

            </div>
            <br>
            <!-- <div class="buttons">
                <?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
                    "class"=>"btn btn-danger btn-icon glyphicons circle_minus",
                    "onclick"=>"return multipleDeleteNews('".$this->createUrl('LearnReset/MultiResetAllCourse')."','$formNameModel-grid');"
                )); ?>
            </div> -->

        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        $('body').on('click','.learn_reset',function(){
            if(!confirm("คุณต้องการ Reset การเรียน ใช่หรือไม่ ?")) return false;
            var val = $(this).attr('href');
            var stdID = val.substr(1);
            var courseID = $(this).attr('data-course-id');
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('LearnReset/resetLearnCourse');?>",
                data:{ stdID:stdID,courseID:courseID },
                success: function(data) {
                    alert("Reset การเรียน เรียบร้อยแล้ว");
                    window.location.href="<?= $this->createUrl('LearnReset/showResetCourse?userID='); ?>"+stdID;
                }
            })
        });
    });
</script>
