
<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>เพิ่มประเภทแกลลอรี่
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'imgslide-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<?php  
				$lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
				$parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
				$modelLang = Language::model()->findByPk($lang_id);
				?>
				<?php if ($lang_id != 1){ ?>
					<p class="note"><span style="color:red;font-size: 20px;">เพิ่มเนื้อหาของภาษา <?= $modelLang->language; ?></span></p>
					<?php 
				}
				?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				<div class="row">
					<?php echo $form->labelEx($model,'name_gallery_type'); ?>
					<?php echo $form->textField($model,'name_gallery_type',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'name_gallery_type'); ?>
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
<script>
	$(function () {
		init_tinymce();
	});
</script>

