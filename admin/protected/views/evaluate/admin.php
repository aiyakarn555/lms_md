<?php
$titleName = 'ระบบแบบสอบถามความพึงพอใจ';
$formNameModel = 'Evaluate';

$this->breadcrumbs=array(
	$titleName=>array('index'),
	'ตรวจสอบคำถามความพึงพอใจ',
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#Evaluate-grid').yiiGridView('update', {
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
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("Evaluate[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);

?>

<div class="innerLR">

	<div class="widget" data-toggle="collapse-widget" data-collapse-closed="true">
		<div class="widget-head">
			<h4 class="heading  glyphicons search"><i></i>ค้นหาขั้นสูง</h4>
		</div>
		<div class="widget-body collapse" style="height: 0px;">
			<div class="search-form">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
			</div>
		</div>
	</div>

	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>'Evaluate-grid',
					'dataProvider'=>$model->search($id),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Evaluate[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Evaluate.*", "Evaluate.Delete", "Evaluate.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'eva_title',
							'type'=>'raw',
							'value'=>'UHtml::markSearch($data,"eva_title")',
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Evaluate.*", "Evaluate.View", "Evaluate.Update", "Evaluate.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Evaluate.*", "Evaluate.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Evaluate.*", "Evaluate.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Evaluate.*", "Evaluate.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
