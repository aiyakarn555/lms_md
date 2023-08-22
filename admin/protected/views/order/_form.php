<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
			<?php $form = $this->beginWidget('CActiveForm', array(
				'id'=>'order-form',
		        'enableClientValidation'=>true,
		        'clientOptions'=>array(
		            'validateOnSubmit'=>true
		        ),
		        'htmlOptions' => array('enctype' => 'multipart/form-data')
			)); ?>
				<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>
					<div class="row">
						<?php echo $form->labelEx($model,'order_ems'); ?>
						<?php echo $form->textField($model,'order_ems',array('size'=>60,'maxlength'=>13, 'class'=>'span8')); ?>
						<?php echo ClassFunction::CircleQuestionMark();?>
						<?php echo $form->error($model,'order_ems'); ?>
					</div>
					<div class="row buttons">
						<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
					</div>
			<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
<?php
$this->widget('ADetailView', array(
	'data'=>$model,
	'checkcolspan'=>3,
	'checkItemShop'=>array(
		'table' => 'OrderDetail',
		'condition' => " order_id = '$model->order_id' ",
		'with' => 'shops',
		'text' => 'สินค้าที่สั่ง'
	),
	'attributes'=>array(
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
		array(
			'name'=>'order_ems',
			'type'=>'html',
			'value'=>$model->AddEMS
		),
		array(
			'name'=>'order_file',
			'type'=>'raw',
			'value'=> ($model->order_file)?CHtml::link(CHtml::image(Yush::getUrl($model, Yush::SIZE_ORIGINAL, $model->order_file),'',array("class"=>"thumbnail")),Yush::getUrl($model, Yush::SIZE_ORIGINAL, $model->order_file),array("rel"=>"prettyPhoto")):'<font color="red">ยังไม่ได้ยืนยันการโอนเงิน</font>',
		),
	),
));?>
<!-- END innerLR -->