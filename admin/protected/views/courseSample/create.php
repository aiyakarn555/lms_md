<?php
/* @var $this CourseSampleController */
/* @var $model CourseSample */

$this->breadcrumbs=array(
	'ตัวอย่างบทเรียน'=>array('index'),
	'สร้าง',
);

$this->menu=array(
	array('label'=>'ย้อนกลับ', 'url'=>array('index')),
	array('label'=>'จัดการตัวอย่างบทเรียน', 'url'=>array('admin')),
);
?>

<h1>สร้าง ตัวอย่างบทเรียน</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>