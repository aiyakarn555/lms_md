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
			<?php $form = $this->beginWidget('AActiveForm', array(
				'id'=>'vdo-form',
		        'enableClientValidation'=>true,
		        'clientOptions'=>array(
		            'validateOnSubmit'=>true
		        ),
		        'errorMessageCssClass' => 'label label-important',
		        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        //         'pluginOptions'=>array(
        // 'allowedFileExtensions'=>array('mp4', 'avi', 'mpge'),
        // 'maxFileSize' => 1024 * 1024 * 2,)
			)); 
     
            ?>
                <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

				<div class="row">
					<?php echo $form->labelEx($model,'institution_name'); ?>
					<?php echo $form->textField($model,'institution_name',array('size'=>60,'maxlength'=>255,'class'=>'span7')); ?>
                    <?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'institution_name'); ?>
				</div>
                <div class="row">
                    <?php echo $form->labelEx($model,'code'); ?>
                    <?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>255,'class'=>'span7')); ?>
                    <?php echo $form->error($model,'code'); ?>
                </div>
				
                <!-- upload vdo -->
				<div class="row buttons">
				<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>
			<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
