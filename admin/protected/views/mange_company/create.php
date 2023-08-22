<?php
/* @var $this Mange_companyController */
/* @var $model TblCompany */

$this->breadcrumbs=array(
	'Tbl Companies'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List TblCompany', 'url'=>array('index')),
	array('label'=>'Manage TblCompany', 'url'=>array('admin')),
);*/
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "สร้างหน่วยงาน"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>

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
			<?php echo CHtml::link("<i></i> จัดการหน่วยงาน",array('admin'),array(
					"class"=>"btn btn-primary"
			)); ?>
		</div>
			<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
</div>