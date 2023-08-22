<?php
/* @var $this OrgDepartmentController */
/* @var $model OrgDepartment */
/* @var $form CActiveForm */
?>

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
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'OrgDepartment-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				<?php if(count($Validation) > 0){ ?>
					<p class="note">ใช้ Code นี้เเล้ว</p>
				<?php } ?>
				<div class="row">
						<?php echo $form->labelEx($model, 'bu_id'); ?>
						<?php echo $this->listBuShow($model, 'bu_id','span3'); ?>
						<?php echo $this->NotEmpty(); ?>
						<?php echo $form->error($model, 'bu_id'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'code'); ?>
					<?php echo $form->textField($model,'code'); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'code'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'name'); ?>
					<?php echo $form->textField($model,'name'); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'name'); ?>
				</div>

				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div><!-- form -->