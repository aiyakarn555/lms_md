<?php
$this->breadcrumbs=array(
	'จัดการแจ้งชำระเงินสั่งซื้อของ'=>array('index'),
	$model->order_cost,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'checkcolspan'=>3,
	'checkItemShop'=>array(
		'table' => 'OrderDetailonline',
		'condition' => " order_id = '$model->order_id' ",
		'Fimage'=>'courseonline',
		'with' => 'courses',
		'text' => 'สินค้าที่สั่ง'
	),
	'attributes'=>array(
		array(
			'name'=>'order_file',
			'type'=>'raw',
			'value'=> ($model->order_file)?CHtml::link(CHtml::image(Yush::getUrl($model, Yush::SIZE_ORIGINAL, $model->order_file),'',array("class"=>"thumbnail")),Yush::getUrl($model, Yush::SIZE_ORIGINAL, $model->order_file),array("rel"=>"prettyPhoto")):'<font color="red">ยังไม่ได้ยืนยันการโอนเงิน</font>',
		),
		// array(
		// 	'name'=>'order_id',
		// 	'value'=>sprintf("%06d",$model->order_id),
		// ),
		// array(
		// 	'name'=>'order_countnum',
		// 	'value'=>number_format($model->order_countnum).' หลักสูตร',
		// ),
		// array(
		// 	'name'=>'order_countall',
		// 	'value'=>number_format($model->order_countall).' ที่นั่ง',
		// ),
		array(
			'name'=>'user_id',
			'value'=>$model->NameUser,
		),
		array(
			'name'=>'order_bank',
			'type'=>'raw',
			'value'=>$model->NameBankCheck
		),
		array(
			'name'=>'order_cost',
			'value'=>number_format($model->order_cost),
		),
		array(
			'name'=>'order_date_add',
			'value'=>ClassFunction::datethai($model->order_date_add)
		),
		'order_date_time',
		// array(
		// 	'name'=>'update_date',
		// 	'value'=>ClassFunction::datethaitime($model->update_date)
		// ),
		// array(
		// 	'name'=>'order_point',
		// 	'value'=>number_format($model->order_point),
		// ),
	),
));?>