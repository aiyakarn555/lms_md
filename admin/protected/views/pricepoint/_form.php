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
				'id'=>'pricepoint-form',
		        'enableClientValidation'=>true,
		        'clientOptions'=>array(
		            'validateOnSubmit'=>true
		        ),
		        'htmlOptions' => array('enctype' => 'multipart/form-data')
			)); ?>
				<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>
				<div class="row">
				<?php echo $form->labelEx($model,'pricepoint_money'); ?>
				<?php echo $form->textField($model,'pricepoint_money',array(
				'class'=>'span7','maxlength'=>10
				)); ?>
				<?php echo ClassFunction::CircleQuestionMark(); ?>
				<?php echo $form->error($model,'pricepoint_money'); ?>
				</div>
				<div class="row">
				<?php echo $form->labelEx($model,'pricepoint_point'); ?>
				<?php echo $form->textField($model,'pricepoint_point',array(
				'class'=>'span7','maxlength'=>10
				)); ?>
				<?php echo ClassFunction::CircleQuestionMark(); ?>
				<?php echo $form->error($model,'pricepoint_point'); ?>
				</div>
				<div class="row buttons">
				<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>
			<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
<!-- END innerLR -->