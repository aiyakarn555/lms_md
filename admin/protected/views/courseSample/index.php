<?php
/* @var $this CourseSampleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'ตัวอย่างบทเรียน',
);

$this->menu=array(
	array('label'=>'ตัวอย่างบทเรียน', 'url'=>array('create')),
	array('label'=>'จัดการตัวอย่างบทเรียน', 'url'=>array('admin')),
);
?>

<h1>Course Samples</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
