<?php
/* @var $this Mange_divisionController */
/* @var $model TblDivision */

$this->breadcrumbs=array(
	'Tbl Divisions'=>array('index'),
	$model->id,
);

/*$this->menu=array(
	array('label'=>'List TblDivision', 'url'=>array('index')),
	array('label'=>'Create TblDivision', 'url'=>array('create')),
	array('label'=>'Update TblDivision', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TblDivision', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TblDivision', 'url'=>array('admin')),
);*/
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "ดูรายละเอียด"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>

<h4>ดูรายละเอียดแผนก  รหัส : <?php echo $model->company_id; ?></h4>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'div_title',
		'create_date',
	),
)); ?>

		</div>
	</div>
	<div class="separator top form-inline small">
			<!-- With selected actions -->
		<div class="buttons pull-left">
			<?php echo CHtml::link("<i></i> ลิสต์แผนก",array('index'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> สร้างแผนก",array('create'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> แก้ไขแผนก",array('update', 'id'=>$model->id),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> ลบแผนก",'#',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?',"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> จัดการแผนก",array('admin'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
			<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
</div>