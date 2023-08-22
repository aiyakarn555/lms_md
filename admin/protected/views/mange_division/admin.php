<?php
/* @var $this Mange_divisionController */
/* @var $model TblDivision */

$this->breadcrumbs=array(
	'Tbl Divisions'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List TblDivision', 'url'=>array('index')),
	array('label'=>'Create TblDivision', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbl-division-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php /*echo CHtml::link('Advanced Search','#',array('class'=>'search-button'));*/ ?>
<!-- <div class="search-form" style="display:none"> -->
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */ ?>
<!-- </div> --><!-- search-form -->

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
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "ระบบจัดการแผนก"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>
			<div class="overflow-table">

				<?php $this->widget('AGridView', array(
					//'loadProcessing' => true,
					'id'=>'tbl-division-grid',
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
						'div_title',
						array(               // related city displayed as a link
							'name'=>'company_id',
							'value'=>'$data->company->company_title',
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Teacher.*", "Teacher.View", "Teacher.Update", "Teacher.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("mange_division.*", "mange_division.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("mange_division.*", "mange_division.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("mange_division.*", "mange_division.Delete") )' 
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
			<?php echo CHtml::link("<i></i> ลิสต์ศูนย์/แผนก",'admin',array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> สร้างศูนย์/แผนก",'create',array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
			<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
</div>
