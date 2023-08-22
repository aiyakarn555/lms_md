<?php
/* @var $this Mange_companyController */
/* @var $model TblCompany */

$this->breadcrumbs=array(
	'Tbl Companies'=>array('index'),
	$model->company_id=>array('view','id'=>$model->company_id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List TblCompany', 'url'=>array('index')),
	array('label'=>'Create TblCompany', 'url'=>array('create')),
	array('label'=>'View TblCompany', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TblCompany', 'url'=>array('admin')),
);*/
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "แก้ไขตำแหน่ง"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>

			<h4>แก้ไขหน่วยงาน : <?php echo $model->company_title; ?></h4>

			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
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
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> ดูรายละเอียดหน่วยงาน",array('view', 'id'=>$model->company_id),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> จัดการหน่วยงาน",array('admin'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
			<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
</div>