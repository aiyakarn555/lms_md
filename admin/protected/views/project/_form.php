<?php
/* @var $this ProjectController */
/* @var $model Project */
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
					'id'=>'project-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				<div class="row">
					<?php echo $form->labelEx($model,'name'); ?>
					<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'name'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'university_ids'); ?>
					<?php
					$universityOptions = TbUniversity::getUniversityOptions();
					?>
					<style>
						input[type='checkbox'] {
							float: left;
						}
					</style>
					<?php echo $form->checkBoxList($model,'university_ids', $universityOptions); ?>
					<?php echo $form->error($model,'university_ids'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'start_date'); ?>
					<?php echo $form->textField($model,'start_date',array('size'=>60,'maxlength'=>250, 'class'=>'span8 datepicker')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'start_date'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'expire_date'); ?>
					<?php echo $form->textField($model,'expire_date',array('size'=>60,'maxlength'=>250, 'class'=>'span8 datepicker')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'expire_date'); ?>
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/datepicker/js/bootstrap-datepicker.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/datepicker/js/locales/bootstrap-datepicker.th.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/datepicker/css/datepicker3.css');
?>
<script type="text/javascript">
	$('.datepicker').datepicker({
		language: "th",
		format: "yyyy-mm-dd",
	});
</script>