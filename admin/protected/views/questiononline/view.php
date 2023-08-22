<?php
$this->breadcrumbs=array(
	'จัดการชุดข้อสอบบทเรียนออนไลน์'=>array('//Grouptestingmsteams/Index'),
	'จัดการข้อสอบ'=>array('//questionmsteams/index','id'=>Yii::app()->user->getState('getReturn')),
    strip_tags(CHtml::decode($model->ques_title)),
);

$this->widget('ADetailView', array(
	'data'=>$model,
	'checkTableSup'=>array(
		'table' => 'Choice',
		'condition' => " ques_id = '$model->ques_id' ",
		'text' => 'ตัวเลือกที่'
	),
	'attributes'=>array(
        array(
            'name'=>'ques_title',
            'type'=>'html',
            'value'=>CHtml::decode($model->ques_title)
        )
	),
)); 
?>
