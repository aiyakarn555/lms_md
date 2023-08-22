
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

					<?php $form=$this->beginWidget('AActiveForm', array(
						'id'=>'evaluate-form',
				        'enableClientValidation'=>true,
				        'clientOptions'=>array(
				            'validateOnSubmit'=>true
				        ),
				        'errorMessageCssClass' => 'label label-important',
				        'htmlOptions' => array('enctype' => 'multipart/form-data')
					)); ?>

					<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

					<?php //echo $form->errorSummary($model); ?>

					<div class="row">
						<?php echo $form->labelEx($model,'course_id'); ?>
						<?php echo $form->dropDownList($model,'course_id', CHtml::listData(
							CourseOnline::model()->findAll(), 'course_id', 'course_title'
						), array('empty'=>'-- กรุณาเลือกหลักสูตรอบรมออนไลน์ --','class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'course_id'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'eva_title'); ?>
						<?php echo $form->textField($model,'eva_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'eva_title'); ?>
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
