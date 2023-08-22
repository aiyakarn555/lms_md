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
					'id'=>'featured-links-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

				<?php echo $form->errorSummary($model); ?>

				<div class="row">
					<?php echo $form->labelEx($model,'link_name'); ?>
					<?php echo $form->textField($model,'link_name',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'link_name'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'link_url'); ?>
					<?php echo $form->textField($model,'link_url',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'link_url'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'link_image'); ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
					  	<div class="input-append">
					    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 
					    	'link_image'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					  	</div>
					</div>
					<?php echo $form->error($model,'link_image'); ?>
					<div class="row">
						<font color="#990000">
							<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 205X82
						</font>
					</div>
					<?php if ($notsave == 1) { ?>
						<p class="note"><font color="red">*ขนาดของรูปภาพไม่ถูกต้อง </font></p>
						 <?php }else{} ?> 
				</div>
				
				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>

			<?php $this->endWidget(); ?>

			</div><!-- form -->

		</div>
	</div>
</div>

<!-- <script>
$('')
</script> -->