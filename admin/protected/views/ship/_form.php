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
					'id'=>'about-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>

	            <div class="row">
                    <?php echo $form->labelEx($model, 'ship_name'); ?>
                    <?php echo $form->textField($model, 'ship_name', array('size' => 60, 'maxlength' => 255, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'ship_name'); ?>
                </div>
				<div class="row">
                    <?php echo $form->labelEx($model, 'ship_name_en'); ?>
                    <?php echo $form->textField($model, 'ship_name_en', array('size' => 60, 'maxlength' => 255, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'ship_name_en'); ?>
                </div>

				<br/>

				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>

				<?php $this->endWidget(); ?>

			</div><!-- form -->
		</div>
	</div>
</div>
<!-- END innerLR -->
<script>
	$(function () {
		init_tinymce();
	});
</script>