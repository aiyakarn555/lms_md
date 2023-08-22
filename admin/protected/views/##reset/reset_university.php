<?php
/* @var $this TestController */
/* @var $model User */
$titleName = 'ระบบ Reset การเรียนและการสอบ';
$this->headerText = $titleName;

$this->breadcrumbs=array('ระบบ Reset การเรียนและการสอบ',
    'Reset รายมหาวิทยาลัย'=>array('LearnReset/Reset_university'),
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

<div class="col-md-12">

    <div class="widget" style="margin-top: -1px;">
<!--        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
        </div>-->
        <div class="widget-body">
            <div class="separator bottom form-inline small">
                <span class="pull-left">
                <?php if( Controller::DeleteAll(array("LearnReset.*", "LearnReset.Delete", "LearnReset.MultiDelete")) ) : ?>
                    <!-- Options -->
                    <div class="separator top form-inline small" style="margin-bottom: 10px">
                        <!-- With selected actions -->
                        <div class="buttons pull-left">
                            <?php echo CHtml::link("<i></i> ลบข้อมูลการเรียนที่เลือก","#",array(
                                "class"=>"btn btn-primary btn-icon glyphicons circle_minus",
                                "onclick"=>"return multipleDeleteNews('".$this->createUrl('LearnReset/MultiDelete_learn')."','reset-form');"
                            )); ?>
                            <?php echo CHtml::link("<i></i> ลบข้อมูลการสอบที่เลือก","#",array(
                                "class"=>"btn btn-primary btn-icon glyphicons circle_minus",
                                "onclick"=>"return multipleDeleteNews('".$this->createUrl('LearnReset/MultiDelete_score')."','reset-form');"
                            )); ?>
                        </div>
                        <!-- // With selected actions END -->
                        <div class="clearfix"></div>
                    </div>
                    <!-- // Options END -->
                <?php endif; ?>
                    </span>


				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
                    <?php echo $this->listPageShow($formNameModel);?>
				</span>
            </div>
            <div class="clear-div"></div>
            <div class="overflow-table">

                <?php $this->widget('booster.widgets.TbGridView', array(
                    'id'=>'reset-form',
                    'selectableRows' => 2,
                    'dataProvider'=>$model->search(),
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
                        'name',
                        array(
                            'header'=>'จำนวนนักศึกษา',
                            'value'=>'count($data->tbl_user)',
                            'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array('class'=>'CButtonColumn',
                            'header'=>'ลบการเรียนทั้งหมด',
                            'template'=>'{learn_reset}',
                            'buttons'=>array (
                                'learn_reset'=>array(
                                    'label'=>'Reset',
                                    'url'=>'"#".$data->id',
                                    'options'=>array(
                                        'class'=>'btn btn-danger learn_reset'
                                    ),
                                ),
                            ),
                        ),
                        array('class'=>'CButtonColumn',
                            'header'=>'ลบการสอบทั้งหมด',
                            'template'=>'{score_reset}',
                            'buttons'=>array (
                                'score_reset'=>array(
                                    'label'=>'Reset',
                                    'url'=>'"#".$data->id',
                                    'options'=>array(
                                        'class'=>'btn btn-danger score_reset',
                                    ),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'ลบ รายหลักสูตร',
                            'type'=>'raw',
                            'value' => function($data){
                                return CHtml::link('Reset',
                                  array('LearnReset/showResetCourseUni','uniID'=>$data->id),
                                  array('class'=>'btn btn-danger')
                                );
                            },
                            'htmlOptions'=> array('style'=>'text-align:center;width:100px;'),
                            'headerHtmlOptions'=> array('style'=>'text-align:center;'),
                        ),
                        array(
                            'header' => 'ลบ รายบทเรียน',
                            'type'=>'raw',
                            'value' => function($data){
                                return CHtml::link('Reset',
                                  array('LearnReset/showResetLessonUni','uniID'=>$data->id),
                                  array('class'=>'btn btn-danger')
                                );
                            },
                            'htmlOptions'=> array('style'=>'text-align:center;width:100px;'),
                            'headerHtmlOptions'=> array('style'=>'text-align:center;'),
                        ),
                        array(
                            'header' => 'ลบรายการสอบ',
                            'type'=>'raw',
                            'value' => function($data){
                                return CHtml::link('Reset',
                                  array('LearnReset/showResetExamLessonUni','uniID'=>$data->id),
                                  array('class'=>'btn btn-danger')
                                );
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
    $('body').on('click','.learn_reset',function(){
        if(!confirm("คุณต้องการ Reset การเรียนทั้งหมด ใช่หรือไม่ ?")) return false;
        var val = $(this).attr('href');
        var fn_id = val.substr(1);
        $.ajax({
            type: 'POST',
            url: "<?=Yii::app()->createUrl('LearnReset/university_reset_learn');?>",
            data:{ del_id:fn_id },
            success: function(data) {
                 alert("Reset การเรียนทั้งหมด เรียบร้อยแล้ว");
            }
        })
    });
    $('body').on('click','.score_reset',function(){
        if(!confirm("คุณต้องการ Reset การสอบทั้งหมด ใช่หรือไม่ ?")) return false;
        var val = $(this).attr('href');
        var fn_id = val.substr(1);
        $.ajax({
            type: 'POST',
            url: "<?=Yii::app()->createUrl('LearnReset/university_reset_score');?>",
            data:{ del_id:fn_id },
            success: function(data) {
                alert("Reset การสอบทั้งหมด เรียบร้อยแล้ว");
            }
        })
    });
});
</script>