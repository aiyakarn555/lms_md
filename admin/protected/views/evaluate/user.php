<?php
$formNameModel = 'User';
$titleName = 'รายชื่อผู้ตอบแบบความพึงพอใจ';

$this->breadcrumbs=array(
	'ระบบแบบสอบถามความพึงพอใจ'=>array('index'),
	$titleName
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#User-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	$('#export').click(function(){
	    window.location = '". $this->createUrl('//EvalAns/ReportUserAll')  . "?' + $(this).parents('form').serialize() + '&export=true&ans=".$id."';
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
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("User[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">

	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-left">
					<label class="strong"><h4><?php echo $modelCourseOnline->course_title; ?></h4></label>
					<?php echo CHtml::tag('button',array(
						'class' => 'btn btn-primary btn-icon glyphicons print',
						'id'=> 'export',
					),'<i></i>ออกรายงาน'); ?>
				</span>	
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'htmlOptions' => array( 'style'=> "margin-top: -1px;" ),
	 				'afterAjaxUpdate'=>'function(id, data){
	 					$.appendFilter("User[news_per_page]");	
	 					InitialSortTable();
	 				}',
					'columns'=>array(
						array(
							'name' => 'username',
							'type'=>'raw',
							'value' => 'UHtml::markSearch($data,"username")',
							'htmlOptions'=>array( 'style'=>'width:120px;' ),
						),
						array(
							'name'=>'email',
							'type'=>'raw',
							'value'=>'UHtml::markSearch($data,"email")',
						),
					    array(
					    	'header'=>'ดูผลคำตอบ',
					        'value'=>'$data->getEvalansUser('.$id.')',
					        'type'=>'raw',
					        'htmlOptions'=>array('width'=>'120px','style'=>'text-align:center;'),
				            'headerHtmlOptions'=>array(
				            	'style'=>'text-align:center;'
				            ),
					    ),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>