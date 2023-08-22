<?php
/* @var $this ManageController */
/* @var $model Manage */
/* @var $form CActiveForm */
?>
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

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'manage-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		  	'validateOnSubmit'=>true
	),
)); ?>

	<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $this->listLessonShow($model,'','span8');?>
		<?php echo ClassFunction::CircleQuestionMark();?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $this->listGroupShow($model,'span8');?>
		<?php echo ClassFunction::CircleQuestionMark();?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manage_row'); ?>
		<?php echo $form->textField($model,'manage_row'); ?>
		<?php echo ClassFunction::CircleQuestionMark();?>
		<?php echo $form->error($model,'manage_row'); ?>
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