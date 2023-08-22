<?php
/* @var $this ConfigCaptchaController */
/* @var $model ConfigCaptcha */
// $this->headerText = 'แสดง Captcha';
$this->breadcrumbs=array(
	'Config Captchas'=>array('index'),
	$model->capid,
);

?>

<h1>แสดงแคปช่า #<?php echo $model->capt_name; ?></h1>

<?php 
function getOpenOrClose($val){
    if($val == 1){
        return "<i class=\"fa fa-check\" aria-hidden=\"true\" style=\"color:green\"></i>";
    } else {
        return "<i class=\"fa fa-times\" aria-hidden=\"true\" style=\"color:red\"></i>";
    }
}

	$this->widget(
		'booster.widgets.TbEditableDetailView',
		array(
			'id' => 'region-details',
			'data' => $model,
			'url' => $endpoint,
			'attributes' => array(
				array(
					'label'=>'ชื่อเงื่อนไข',
					'format'=>'raw',
					'value'=> $model->capt_name,
					),
				array(
					'label'=>'ระยะเวลาสุ่ม',
					'format'=>'raw',
					'value'=> $model->capt_time_random." นาที",
					),
				array(
					'label'=>'เวลาย้อนหลัง',
					'format'=>'raw',
					'value'=> $model->capt_time_back." นาที",
					),
				array(
					'label'=>'ระยะเวลารอคอยการตอบ',
					'format'=>'raw',
					'value'=> $model->capt_wait_time." วินาที",
					),
				array(
					'label'=>'จำนวนครั้งตอบผิด',
					'format'=>'raw',
					'value'=> $model->capt_times." ครั้ง",
					),
				// array(
				// 	'label'=>'ครังเดียวก่อนเข้าเรียน',
				// 	'type'=>'html',
				// 	'value'=> getOpenOrClose($model->capt_hide),
				// 	),
				// array(
				// 	'label' => 'สอบวัดผล',
				// 	'type'=>'html',
				// 	'value'=> getOpenOrClose($model->capt_active),
				// 	),
				
				array(
					'label' => 'สร้างโดย',
					'format'=>'raw',
					'value'=> function ($model){
						$user = Users::model()->findByPk($model->created_by);
						return $user->username;
					}
					),
				array(
					'label' => 'สร้างเมื่อ',
					'format'=>'raw',
					'value'=> Helpers::lib()->changeFormatDate($model->created_date),
					),
				array(
					'label' => 'แก้ไขโดย',
					'format'=>'raw',
					'value'=> function ($model){
						$user = Users::model()->findByPk($model->updated_by);
						return $user->username;
					}
					),
				array(
					'label' => 'แก้ไขเมื่อ',
					'format'=>'raw',
					'value'=> Helpers::lib()->changeFormatDate($model->updated_date),
					),
				)
			)
		);

?>
