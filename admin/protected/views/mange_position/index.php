<?php
/* @var $this Mange_positionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbl Positions',
);

/*$this->menu=array(
	array('label'=>'Create TblPosition', 'url'=>array('create')),
	array('label'=>'Manage TblPosition', 'url'=>array('admin')),
);*/
?>
<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo "ลิสต์ตำแหน่ง"; ?></h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$dataProvider,
					'itemView'=>'_view',
				)); ?>
			</div>
		</div>
	</div>
	<div class="separator top form-inline small">
			<!-- With selected actions -->
		<div class="buttons pull-left">
			<?php echo CHtml::link("<i></i> สร้างตำแหน่ง",array('create'),array(
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


