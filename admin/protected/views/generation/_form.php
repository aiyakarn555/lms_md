<?php
/* @var $this GenerationController */
/* @var $model Generation */
/* @var $form CActiveForm */
?>

<script>
	$(document).ready(function(){
	    $("#Generation_start_date").datepicker({
	        // numberOfMonths: 2,
	        onSelect: function(selected) {
	          $("#Generation_end_date").datepicker("option","minDate", selected)
	        }
	    });
	    $("#Generation_end_date").datepicker({
	        // numberOfMonths: 2,
	        onSelect: function(selected) {
	           $("#Generation_start_date").datepicker("option","maxDate", selected)
	        }
	    }); 
});

</script>
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
	'id'=>'generation-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

	<?php echo $form->errorSummary($model); ?>

	<!-- <div class="row"> -->
		<?php //echo $form->labelEx($model,'id_gen'); ?>
		<?php //echo $form->textField($model,'id_gen'); ?>
		<?php //echo $form->error($model,'id_gen'); ?>
	<!-- </div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php echo $form->textField($model,'start_date'); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php echo $form->textField($model,'end_date'); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>
	<?php
	    $active = array('0' => 'ระงับการใช้งาน',
	    '1' => 'เปิดการใช้งาน');
    ?>
	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model, 'active', $active, array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

		</div>
	</div>
</div>