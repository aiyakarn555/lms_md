<?php
$titleName = 'จำนวน Point';
$formNameModel = 'Pricepoint';

$this->breadcrumbs=array('จัดการ'.$titleName);

Yii::app()->clientScript->registerScript('search', "
$('#SearchFormAjax').submit(function(){
    $.fn.yiiGridView.update('$formNameModel-grid', {
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
$.appendFilter("Pricepoint[news_per_page]", "newsPerPage");
EOD
, CClientScript::POS_READY);
?>
<!-- Heading -->
<div class="heading-buttons">
	<h3>จัดการ<?php echo $titleName;?></h3>
	<div class="buttons pull-right">
		<?php echo CHtml::link("<i></i> เพิ่ม".$titleName, array("//".$formNameModel."/Create"), array("class"=>"btn btn-primary btn-icon glyphicons circle_plus"));?>
	</div>
</div>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'pricepoint_money','type'=>'text'),
	),
	));?>
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> จัดการ<?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
		<?php $this->widget('GridView', array(
			'id'=>$formNameModel.'-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'selectableRows' => 2,	
			'htmlOptions' => array(
				'style'=> "margin-top: -1px;",
			),
			'afterAjaxUpdate'=>'function(slash, care) { 
				$.appendFilter("Pricepoint[news_per_page]");	
			}',
			'columns'=>array(
				array(
					'class'=>'CCheckBoxColumn',
					'id'=>'chk',
				),
				array(
					'name'=>'pricepoint_money',
					'value'=>'number_format($data->pricepoint_money)'
				),
				array(
					'name'=>'pricepoint_point',
					'value'=>'number_format($data->pricepoint_point)'
				),
				array(            
					'class'=>'AButtonColumn',
				),
			),
		)); 
		
		?>
		</div>
	</div>
	<!-- Options -->
	<div class="separator top form-inline small">
		<!-- With selected actions -->
		<div class="buttons pull-left">
			<?php 
			echo CHtml::link("<i></i> ลบข้อสอบทั้งหมด",
				"#",
				array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');")); 
			?>
		</div>
		<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
	<!-- // Options END -->
</div>