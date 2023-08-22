<?php
/* @var $this OrgCountryDivisionController */
/* @var $dataProvider CActiveDataProvider */

$titleName = 'จัดการ OrgCountryDivision';
$formNameModel = 'OrgCountryDivision';

$this->breadcrumbs=array($titleName);
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
$.appendFilter("OrgCountryDivision[news_per_page]", "news_per_page");
EOD
	, CClientScript::POS_READY);
?>

<div class="innerLR">
<!--	--><?php //$this->widget('AdvanceSearchForm', array(
//		'data'=>$model,
//		'route' => $this->route,
//		'attributes'=>array(
//			array(
//				'name'=>'faq_THtopic',
//				'type'=>'text'
//			),
//		),
//	));?>
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right" style="margin-left: 10px;">
					<a class="btn btn-primary btn-icon glyphicons circle_plus"
					   href="<?php echo Yii::app()->createUrl("/OrgCountryDivision/create")?>"><i></i> เพิ่มOrgCountryDivision</a>
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
					// 'filter'=>$model,
					// 'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'selectableRows' => 2,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("OrgCountryDivision[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("OrgCountryDivision.*", "OrgCountryDivision.Delete", "OrgCountryDivision.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'code',
							'type'=>'html',
							'htmlOptions'=>array('style'=>'text-align: center; width:100px;', 'class'=>'row_move'),	
							'value'=>'UHtml::markSearch($data,"code")',
						),
						array(
							'name'=>'department_id',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center; width:200px;', 'class'=>'row_move'),
							'value'=>'$data->department->name',
							'filter'=>CHtml::activeTextField($model,'department_search'),
						),
						array(
							'name'=>'name',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center; width:200px;', 'class'=>'row_move'),
							'value'=>'UHtml::markSearch($data,"name")',
						),
						array(
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton(
								array("OrgCountryDivision.*", "OrgCountryDivision.View", "OrgCountryDivision.Update", "OrgCountryDivision.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("OrgCountryDivision.*", "OrgCountryDivision.View") )'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("OrgCountryDivision.*", "OrgCountryDivision.Update") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("OrgCountryDivision.*", "OrgCountryDivision.Delete") )'
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("OrgCountryDivision.*", "OrgCountryDivision.Delete", "OrgCountryDivision.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php
				echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด",
					"#",
					array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
						"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"));
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
