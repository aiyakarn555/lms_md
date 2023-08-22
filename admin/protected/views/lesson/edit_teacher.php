
<?php
$this->breadcrumbs=array(
	'จัดการหลักสูตร'=>array('index'),
	'เลือกผู้สอน',
);
?>
<!-- innerLR -->
<div class="innerLR">

	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>เลือกผู้สอน
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
			<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'lessonteacher-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					  	'validateOnSubmit'=>true
				),
			)); ?>


			<div class="row">
				<?php echo $form->labelEx($teacher,'title'); ?>
				<?php echo $form->textField($teacher,'title',array('class'=>'span8'));?>
				<?php echo $this->NotEmpty();?>
				<?php echo $form->error($teacher,'title'); ?>
			</div>


			<div class="row">
				<?php echo $form->labelEx($teacher,'teacher_id'); ?>
				<?php echo $this->listTeacher_new($teacher,'span8','teacher_id');?>
				<?php echo $this->NotEmpty();?>
				<?php echo $form->error($teacher,'teacher_id'); ?>
			</div>



			<div class="row">
				<?php echo $form->labelEx($teacher,'survey_header_id'); ?>
				<?php echo $this->listQHeader_new($teacher,'span8','survey_header_id');?>
				<?php echo $this->NotEmpty();?>
				<?php echo $form->error($teacher,'survey_header_id'); ?>
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
