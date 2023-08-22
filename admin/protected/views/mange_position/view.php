<?php
/* @var $this Mange_positionController */
/* @var $model TblPosition */

$this->breadcrumbs=array(
	'Tbl Positions'=>array('index'),
	$model->id,
);

/*$this->menu=array(
	array('label'=>'List TblPosition', 'url'=>array('index')),
	array('label'=>'Create TblPosition', 'url'=>array('create')),
	array('label'=>'Update TblPosition', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TblPosition', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TblPosition', 'url'=>array('admin')),
);*/
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "ดูรายละเอียด"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>

			<h4>ดูรายละเอียดตำแหน่ง รหัส : <?php echo $model->position_code; ?></h4>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					'id',
					'position_code',
					'position_title',
					'create_date',
				),
			)); ?>

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
			<?php echo CHtml::link("<i></i> แก้ไขตำแหน่ง",array('update', 'id'=>$model->id),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> ลบตำแหน่ง",'#',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?',"class"=>"btn btn-primary"
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
