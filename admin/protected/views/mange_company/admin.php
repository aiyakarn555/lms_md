<?php
/* @var $this Mange_companyController */
/* @var $model TblCompany */

$this->breadcrumbs=array(
	'Tbl Companies'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List TblCompany', 'url'=>array('index')),
	array('label'=>'Create TblCompany', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbl-company-grid').yiiGridView('update', {
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
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "ระบบจัดการหน่วยงาน"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>
			<div class="overflow-table">

				<?php $this->widget('AGridView', array(
					'id'=>'tbl-company-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(slash, care) { 
						$.appendFilter("Teacher[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'header'=>'No.',
							'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
						),
						'company_title',
						'create_date',
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
			<?php echo CHtml::link("<i></i> ลิสต์หน่วยงาน",array('index'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> สร้างหน่วยงาน",array('create'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
			<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
</div>
