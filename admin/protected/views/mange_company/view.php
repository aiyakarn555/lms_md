<?php
/* @var $this Mange_companyController */
/* @var $model TblCompany */

$this->breadcrumbs=array(
	'Tbl Companies'=>array('index'),
	$model->company_id,
);

/*$this->menu=array(
	array('label'=>'List TblCompany', 'url'=>array('index')),
	array('label'=>'Create TblCompany', 'url'=>array('create')),
	array('label'=>'Update TblCompany', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TblCompany', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TblCompany', 'url'=>array('admin')),
);*/
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "ดูรายละเอียด"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>

			<h4>ดูรายละเอียดหน่วยงาน : <?php echo $model->company_title; ?></h4>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					'company_id',
					'company_title',
					'create_date',
				),
			)); ?>

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
			<?php echo CHtml::link("<i></i> แก้ไขหน่วยงาน",array('update', 'id'=>$model->company_id),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
		<div class="buttons pull-left" style="margin-left: 10px;">
			<?php echo CHtml::link("<i></i> ลบหน่วยงาน",'#',array('submit'=>array('delete','id'=>$model->company_id),'confirm'=>'Are you sure you want to delete this item?',"class"=>"btn btn-primary"
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

