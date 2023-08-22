<?php
/* @var $this OrgCountryDepartmentController */
/* @var $dataProvider CActiveDataProvider */

$titleName = 'จัดการ OrgCountryDepartment';
$formNameModel = 'OrgCountryDepartment';

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
$.appendFilter("OrgCountryDepartment[news_per_page]", "news_per_page");
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
					   href="<?php echo Yii::app()->createUrl("/OrgCountryDepartment/create")?>"><i></i> เพิ่มOrgCountryDepartment</a>
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
						$.appendFilter("OrgCountryDepartment[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("OrgCountryDepartment.*", "OrgCountryDepartment.Delete", "OrgCountryDepartment.MultiDelete")
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
							'name'=>'company_id',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center; width:200px;', 'class'=>'row_move'),
							'value'=>'$data->company->name',
							'filter'=>CHtml::activeTextField($model,'company_search'),
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
								array("OrgCountryDepartment.*", "OrgCountryDepartment.View", "OrgCountryDepartment.Update", "OrgCountryDepartment.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("OrgCountryDepartment.*", "OrgCountryDepartment.View") )'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("OrgCountryDepartment.*", "OrgCountryDepartment.Update") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("OrgCountryDepartment.*", "OrgCountryDepartment.Delete") )'
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("OrgCountryDepartment.*", "OrgCountryDepartment.Delete", "OrgCountryDepartment.MultiDelete")) ) : ?>
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
