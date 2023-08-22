<?php
/* @var $this CoursePeriodController */
/* @var $model CoursePeriod */
/* @var $form CActiveForm */
?>

<script>
	$(document).ready(function(){
	    $("#CoursePeriod_startdate").datepicker({
	        // numberOfMonths: 2,
	        onSelect: function(selected) {
	          $("#CoursePeriod_enddate").datepicker("option","minDate", selected)
	        }
	    });
	    $("#CoursePeriod_enddate").datepicker({
	        // numberOfMonths: 2,
	        onSelect: function(selected) {
	           $("#CoursePeriod_startdate").datepicker("option","maxDate", selected)
	        }
	    }); 
});

</script>
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
	'id'=>'course-period-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

	<?php echo $form->errorSummary($model); ?>
	<?php
		$course = CourseOnline::model()->findAll(array(
			'condition' =>'active="y"', 
			));
		$course = CHtml::listData($course,'course_id','course_title');
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'id_course'); ?>
		<?php echo $form->dropDownList($model,'id_course',$course,array('empty'=>'---หลักสูตร---')); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'id_course'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code'); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startdate'); ?>
		<?php echo $form->textField($model,'startdate'); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'startdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'enddate'); ?>
		<?php echo $form->textField($model,'enddate'); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'enddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hour_accounting'); ?>
		<?php echo $form->textField($model,'hour_accounting',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'hour_accounting'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hour_etc'); ?>
		<?php echo $form->textField($model,'hour_etc',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'hour_etc'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
		</div>
		</div>