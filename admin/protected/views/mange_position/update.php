<?php
/* @var $this Mange_positionController */
/* @var $model TblPosition */

$this->breadcrumbs=array(
	'Tbl Positions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List TblPosition', 'url'=>array('index')),
	array('label'=>'Create TblPosition', 'url'=>array('create')),
	array('label'=>'View TblPosition', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TblPosition', 'url'=>array('admin')),
);*/
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "แก้ไขตำแหน่ง"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>

			<h4>แก้ไขตำแหน่ง รหัส : <?php echo $model->id; ?></h4>

			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

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
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> ดูรายละเอียดตำแหน่ง",array('view', 'id'=>$model->id),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> จัดการตำแหน่ง",array('admin'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
			<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
</div>