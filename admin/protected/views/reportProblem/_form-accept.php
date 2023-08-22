<?php
/* @var $this ReportProblemController */
/* @var $model ReportProblem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'report-problem-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<?php echo $form->errorSummary($model); ?>

	<div class="span6">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255,'disabled'=>'disabled','style'=>'width:80%')); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="span6">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255,'disabled'=>'disabled','style'=>'width:80%')); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="span6">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'disabled'=>'disabled','style'=>'width:80%')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="span6">
		<?php echo $form->labelEx($model,'tel'); ?>
		<?php echo $form->textField($model,'tel',array('size'=>60,'maxlength'=>255,'disabled'=>'disabled','style'=>'width:80%')); ?>
		<?php echo $form->error($model,'tel'); ?>
	</div>

	<div class="span6">
		<?php echo $form->labelEx($model,'report_type'); ?>
		<?php echo $form->textField($model,'report_type',array('size'=>60,'maxlength'=>255,'disabled'=>'disabled','style'=>'width:80%')); ?>
		<?php echo $form->error($model,'report_type'); ?>
	</div>

	<div class="span6">
		<?php echo $form->labelEx($model,'report_title'); ?>
		<?php echo $form->textField($model,'report_title',array('size'=>60,'maxlength'=>255,'disabled'=>'disabled','style'=>'width:80%')); ?>
		<?php echo $form->error($model,'report_title'); ?>
	</div>

	<div class="span12">
		<?php echo $form->labelEx($model,'report_detail'); ?>
		<?php echo $form->textArea($model,'report_detail',array('rows'=>6, 'cols'=>50,'disabled'=>'disabled','style'=>'width:90%')); ?>
		<?php echo $form->error($model,'report_detail'); ?>
	</div>
	<?php
    // if($model->pic_user!=""){
    $user = new RegistrationForm;
    $user->id = $model->id;
    // }
    if($model->report_pic){
	?>
		<div class="span12">
		<label for="">ภาพประกอบ</label>
    <?php echo Controller::ImageShowUser(Yush::SIZE_ORIGINAL, $model, $model->report_pic, $user, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
    </div><br>
	<?php

    }
    ?>

    <div class="span12">
		<?php echo $form->labelEx($model,'answer'); ?>
		<?php echo $form->textArea($model,'answer',array('rows'=>6, 'cols'=>50,'style'=>'width:80%','class'=>'tinymce')); ?>
		<?php echo $form->error($model,'answer'); ?>
	</div>
	<div class="clearfix"></div><br>
	<div class="span6">
		<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','type'=>'submit'),'<i></i>ส่งข้อมูล');?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
	$(function () {
		init_tinymce();
	});
</script>