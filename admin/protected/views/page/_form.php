
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $FormText;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
				<?php $form=$this->beginWidget('AActiveForm', array(
					'id'=>'page-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true,
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>

				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

				<div class="row">
					<?php echo $form->labelEx($model,'page_num'); ?>
					<?php echo $form->textField($model,'page_num',array('class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php if($alert == 'false'){  ?>
					<br/>
						<div class="label label-important" id="Page_page_num_em_">กรุณากรอกตัวเลขไม่เกิน 10 หลักเท่านั้น</div>
					<?php } else {
					 echo $form->error($model,'page_num'); 
					}
					?>
				</div>

				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>

				<?php $this->endWidget(); ?>

			</div><!-- form -->
		</div>
	</div>
</div>
