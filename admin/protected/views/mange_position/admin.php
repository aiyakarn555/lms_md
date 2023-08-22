<?php
/* @var $this Mange_positionController */
/* @var $model TblPosition */

$this->breadcrumbs=array(
	'Tbl Positions'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List TblPosition', 'url'=>array('index')),
	array('label'=>'Create TblPosition', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbl-position-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		
	));?>

	<?php /*echo CHtml::link('Advanced Search','#',array('class'=>'search-button'));*/ ?>

	<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->

	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "ระบบจัดการตำแหน่ง"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					//'loadProcessing' => true,
					'id'=>'tbl-position-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(slash, care) { 
						$.appendFilter("Teacher[news_per_page]");
						InitialSortTable();	
					}',

						/*$this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'tbl-position-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,*/
					'columns'=>array(
						array(
							'header'=>'No.',
							'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
						),
						'position_title',
						array(               // related city displayed as a link
							'name'=>'company_id',
							'value'=>'$data->company->company_title',
						),
//						'create_date',
						/*array(
							'class'=>'CButtonColumn',
						),*/
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("mange_position.*", "mange_position.View", "mange_position.Update", "mange_position.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("mange_position.*", "mange_position.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("mange_position.*", "mange_position.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("mange_position.*", "mange_position.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>
	<div class="separator top form-inline small">
			<!-- With selected actions -->
		<div class="buttons pull-left">
			<?php echo CHtml::link("<i></i> ลิสต์ตำแหน่ง",array('index'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> สร้างตำแหน่ง",array('create'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
			<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
</div>