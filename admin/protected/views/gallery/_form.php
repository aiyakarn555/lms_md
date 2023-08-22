
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
					'id'=>'gallery-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				<div class="row">
					<?php echo $form->labelEx($model,'gallery_type_id'); ?>

					<?php echo $form->dropDownList($model, 'gallery_type_id', CHtml::listData(GalleryType::model()->findAll(), 'id', 'name_gallery_type'),array('class'=>'span5')); ?>

					<?php //echo $form->dropDownList($model,'gallery_type_id',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'gallery_type_id'); ?>
				</div>
				<div class="row">
					<?php
					if(isset($imageShow)){
					?>
					<h6>รูปภาพเดิม</h6>
					<?php
						 echo CHtml::image(yii::app()->baseUrl.'../../uploads/gallery/images/'.$model->image);
					}
					?>
				</div>
				<br>

				<div class="row">
					<?php
					if(isset($imageShow)){
					?>
						<?php echo $form->labelEx($model,'image'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="input-append">
								<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" id="files" name="files[]" ></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div>
						<?php echo $form->error($model,'image'); ?>

					<?php  }else{ ?>

					<?php echo $form->labelEx($model,'image'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="input-append">
								<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" id="files" name="files[]" multiple></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div>
						<?php echo $form->error($model,'image'); ?>
					<?php } ?>
				</div>

				<div class="row">
					<font color="#990000">
						<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 750X416
					</font>
				</div>
				<?php if ($notsave == 1) { ?>
					<p class="note"><font color="red">*ขนาดของรูปภาพไม่ถูกต้อง </font></p>
				<?php }else{} ?> 
				<br>

				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
<!-- END innerLR -->
