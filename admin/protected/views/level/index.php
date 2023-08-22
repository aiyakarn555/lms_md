<?php
/* @var $this LevelController */
/* @var $dataProvider CActiveDataProvider */

$formNameModel = 'level';
$titleName = 'กำหนดการเปิดใช้กลุ่ม + Login';

$this->breadcrumbs=array(
	$titleName
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#level-grid').yiiGridView('update', {
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
	$.appendFilter("Level[news_per_page]", "news_per_page");
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
				<span class="pull-left">
					<span class="label label-primary">หมายเหตุ</span>
					กลุ่ม Member จะไม่สามารถ Login และ กำหนดการตั้งค่า backend (หลังบ้าน) ได้
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
					'dataProvider'=>$model->checkdelete()->groupuser()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array( 'style'=> "margin-top: -1px;" ),
	 				'afterAjaxUpdate'=>'function(id, data){
	 					$.appendFilter("Level[news_per_page]");	
	 					InitialSortTable();
	 				}',
					'columns'=>array(
						array(
							'header'=>'No.',
							'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
							'htmlOptions'=>array( 'style'=>'text-align:center;width:5%;' ),
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
						array(
							'name'=>'level_name',
							'type'=>'raw',
							'value'=>'UHtml::markSearch($data,"level_name")',
						),
			            array(
			                'class'=>'JToggleColumn',
			                'header' => 'เปิดการใช้งานกลุ่ม',
			                'name'=>'level_show', // boolean model attribute (tinyint(1) with values 0 or 1)
			                'filter' => array('0' => 'ปิด', '1' => 'เปิด'), // filter
			                'action'=>'toggle', // other action, default is 'toggle' action
			                'checkedButtonLabel'=>Yii::app()->request->baseUrl.'/images/checked.png',  // Image,text-label or Html
			                'uncheckedButtonLabel'=>Yii::app()->request->baseUrl.'/images/unchecked.png', // Image,text-label or Html
			                'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
			                'htmlOptions'=>array('style'=>'text-align:center;width:15%;'),
			                'headerHtmlOptions'=>array( 'style'=>'text-align:center;' ),
			            ),
			            array(
			                'class'=>'JToggleColumn',
			                'header' => 'อนุญาติให้เข้าสู่ระบบ backend',
			                'name'=>'level_login', // boolean model attribute (tinyint(1) with values 0 or 1)
			                'filter' => array('0' => 'ไม่', '1' => 'อนุญาต'), // filter
			                'action'=>'toggle', // other action, default is 'toggle' action
			                'checkedButtonLabel'=>Yii::app()->request->baseUrl.'/images/checked.png',  // Image,text-label or Html
			                'uncheckedButtonLabel'=>Yii::app()->request->baseUrl.'/images/unchecked.png', // Image,text-label or Html
			                'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
			                'htmlOptions'=>array('style'=>'text-align:center;width:23%;'),
			                'headerHtmlOptions'=>array( 'style'=>'text-align:center;' ),
			            ),
						array(
							'class'=>'AButtonColumn',
							'template'=>'{view}'
						),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>

