<?php
/* @var $this AuthitemAccessController */
/* @var $model AuthitemAccess */

$formNameModel = 'authitem-access';
$titleName = 'ระบบการเข้าถึงสิทธิ';

$this->breadcrumbs=array(
	$titleName
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
	$.appendFilter("AuthitemAccess[news_per_page]", "PerPage");
EOD
, CClientScript::POS_READY);
?>

<script type="text/javascript">
function AccessAjax(name,number){
	$.ajax({
  		url:"<?php echo $this->createUrl('//AuthitemAccess/AccessAjax'); ?>",
		type: 'GET',
		data: {name:name,number:number},
		dataType: 'json',
  		success: function(data) {
  			jQuery('#authitem-access-grid').yiiGridView('update');
		}
	});
}
</script>

<div class="innerLR">

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
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->typecheck()->search(),
					//'filter'=>$model,
					'htmlOptions' => array( 'style'=> "margin-top: -1px;" ),
	 				'afterAjaxUpdate'=>'function(id, data){
	 					$.appendFilter("AuthitemAccess[news_per_page]");	
	 					InitialSortTable();
	 				}',
					'columns'=>array(
						array(
							'name'=>'name',
							'value'=>'$data->NameCheck'
						),
						array(
							'filter'=>false,
							'header'=>'การเข้าถึง',
							'type'=>'raw',
							'value'=>'$data->Access',
			                'htmlOptions'=>array('style'=>'text-align:center;width:130px;'),
			                'headerHtmlOptions'=>array( 'style'=>'text-align:center;' ),
						),
					),
				)); ?>

			</div>
		</div>
	</div>
</div>