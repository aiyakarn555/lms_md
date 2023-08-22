
<script src="<?php echo $this->assetsBase; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<script type="text/javascript">
function upload()
{
	var file = $('#Category_cate_image').val();
	var exts = ['jpg','gif','png'];
	if ( file ) {
	var get_ext = file.split('.');
	get_ext = get_ext.reverse();
		if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){

			if($('#queue .uploadifive-queue-item').length == 0){
				return true;
			}else{
				$('#filename').uploadifive('upload');
				return false;
			}

		} else {
			$('#Category_cate_image_em_').removeAttr('style').html("<p class='error help-block'><span class='label label-important'> ไม่สามารถอัพโหลดได้ ไฟล์ที่สามารถอัพโหลดได้จะต้องเป็น: jpg, gif, png.</span></p>");
			return false;
		}
	}
	else
	{
		if($('#queue .uploadifive-queue-item').length == 0){
			return true;
		}else{
			$('#filename').uploadifive('upload');
			return false;
		}
	}
}

function deleteVdo(vdo_id,file_id){
	$.get("<?php echo $this->createUrl('Category/deleteVdo'); ?>",{id:file_id},function(data){
		if($.trim(data)==1){
			notyfy({dismissQueue: false,text: "ลบข้อมูลเรียบร้อย",type: 'success'});
			$('#'+vdo_id).parent().hide('fast');
		}else{
			alert('ไม่สามารถลบวิดีโอได้');
		}
	});
}
</script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
.uploadifive-button {
	float: left;
	margin-right: 10px;
}
#queue {
	border: 1px solid #E5E5E5;
	height: 177px;
	overflow: auto;
	margin-bottom: 10px;
	padding: 0 3px 3px;
	width: 600px;
}
</style>

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
					'id'=>'Category-form',
					'enableClientValidation'=>false,
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
				$state = false;
                ?>
				<?php if ($lang_id != 1){ 
				
				$state = true; 
				$att = array("class"=>"span8",'readonly' => true);
				?>
				<p class="note"><span style="color:red;font-size: 20px;">เพิ่มเนื้อหาของภาษา <?= $modelLang->language; ?></span></p>
				<?php 
					}
				?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
					<div class="row">
						<?php $model->cate_type = 1; ?>
					</div>

					<div class="row">
						<?php //echo $form->labelEx($model,'coursetype_id'); ?>
						<?php //echo $this->listCourseTypeShow($model,'span8');?>
						<?php //echo $this->NotEmpty();?>
						<?php //echo $form->error($model,'coursetype_id'); ?>
					</div>

					<!-- <div class="row">
                    	<div class="col-md-12">
                    	<?php echo $form->labelEx($model,'type_id'); ?>
                    	<?php echo $this->listCourseTypeShow2($model,'type_id','span8',$readonly,$lang_id,$parent_id);?>
                    	<?php echo $this->NotEmpty();?>
                    	<?php echo $form->error($model,'type_id'); ?>
	                    </div>
                    </div> -->

					<div class="row">
						<div class="col-md-12">
						<?php echo $form->labelEx($model,'cate_title'); ?>
						<?php echo $form->textField($model,'cate_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'cate_title'); ?>
						</div>
					</div>
<!-- 
					<div class="row">
						<div class="col-md-12">
						<?php echo $form->labelEx($model,'cate_short_detail'); ?>
						<?php echo $form->textArea($model,'cate_short_detail',array('rows'=>4, 'cols'=>40,'class'=>'span8','maxlength'=>255)); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'cate_short_detail'); ?>
						</div>
					</div> -->

					<!-- <div class="row">
						<div class="col-md-12">
						<?php //echo $form->labelEx($model,'cate_detail'); ?>
						<?php //echo $form->textArea($model,'cate_detail',array('rows'=>6, 'cols'=>50, 'class'=>'span8 tinymce')); ?>
						<?php //echo $form->error($model,'cate_detail'); ?>
						</div>
					</div> -->

					<br>

               <!--  <div class="row">
                    <?php echo $form->labelEx($model,'special_category'); ?>
                    <div class="toggle-button" data-toggleButton-style-enabled="success">
                        <?php echo $form->checkBox($model,'special_category',array(
                            'value'=>"y", 'uncheckValue'=>"n"
                        )); ?>
                    </div>
                    <?php echo $form->error($model,'recommend'); ?>
                </div>
                <br> -->

					<div class="row">
					<?php
					if(isset($imageShow) && $imageShow != ""){
						echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
							"class"=>"thumbnail"
						));
					}
					?>
					</div>
					<br>

					<div class="row">
						<?php echo $form->labelEx($model,'cate_image'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'cate_image'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						  	</div>
						</div>
						<?php echo $form->error($model,'cate_image'); ?>
					</div>

					<div class="row">
						<font color="#990000">
							<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 250x180(แนวนอน) หรือ ขนาด 250x(xxx) (แนวยาว)
						</font>
					</div>
					<br>

					<div class="row buttons">
						<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','onclick'=>"return upload();"),'<i></i>บันทึกข้อมูล');?>
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
