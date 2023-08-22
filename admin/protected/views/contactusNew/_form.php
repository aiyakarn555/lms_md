<script>
// 	$(document).ready(function(){
// 	    $("#Popup_start_date").datepicker({
// 	        // numberOfMonths: 2,
// 	        onSelect: function(selected) {
// 	          $("#Popup_end_date").datepicker("option","minDate", selected)
// 	        }
// 	    });
// 	    $("#Popup_end_date").datepicker({
// 	        // numberOfMonths: 2,
// 	        onSelect: function(selected) {
// 	           $("#Popup_start_date").datepicker("option","maxDate", selected)
// 	        }
// 	    }); 
// });

</script>
<?php
$width = 266;
$height = 266;
$re_width = $width/3;
$re_height = $height/3;
?>
<style type="text/css">
#upload-demo{
    width: 350px;
    height: 350px;
    padding-bottom:25px;
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
								'id'=>'contactusNew-form',
						        'enableClientValidation'=>true,
						        'clientOptions'=>array(
						            'validateOnSubmit'=>true
						        ),
						        'errorMessageCssClass' => 'label label-important',
						        'htmlOptions' => array('enctype' => 'multipart/form-data')
							)); ?>
				<p class="note">Available values <?php echo $this->NotEmpty();?> need</p>

				<?php echo $form->errorSummary($model); ?>

				<div class="row">
					<?php echo $form->labelEx($model,'con_firstname'); ?>
					<?php echo $form->textField($model,'con_firstname',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'con_firstname'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_lastname'); ?>
					<?php echo $form->textField($model,'con_lastname',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'con_lastname'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_firstname_en'); ?>
					<?php echo $form->textField($model,'con_firstname_en',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'con_firstname_en'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_lastname_en'); ?>
					<?php echo $form->textField($model,'con_lastname_en',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'con_lastname_en'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_position'); ?>
					<?php echo $form->textField($model,'con_position',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'con_position'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_position_en'); ?>
					<?php echo $form->textField($model,'con_position_en',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'con_position_en'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_tel'); ?>
					<?php echo $form->textField($model,'con_tel',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'con_tel'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_email'); ?>
					<?php echo $form->textField($model,'con_email',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'con_email'); ?>
				</div>

				<!-- <div class="row">
				<?php
				if (!$model->isNewRecord) {
                $criteriapopup = new CDbCriteria;
                $criteriapopup->addCondition('id ='.$model->id);
                $contactusnew = contactusnew::model()->findAll($criteriapopup);
                 foreach ($contactusnew as $key => $value) {
                 	if ($value->con_image) {
                 	
                 	?>
                      <img src="<?= Yii::app()->request->baseUrl; ?>/../uploads/contactusnew/<?= $value->id; ?>/thumb/<?= $value->con_image; ?>">                                  
                 <?php } 
                  }
              }?>
              </div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_image'); ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
					  	<div class="input-append">
					    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 
					    	'con_image'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					  	</div>
					</div>
					<?php echo $form->error($model,'con_image'); ?>
					<div class="row">
						<font color="#990000">
							<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 266x266
						</font>
					</div>
					<?php if ($notsave == 1) { ?>
						<p class="note"><font color="red">*ขนาดของรูปภาพไม่ถูกต้อง </font></p>
						 <?php }else{} ?> 
				</div> -->

				<div class="row ">

					<label class="cabinet center-block">
						<p>upload image </p>
						<figure>
							<?php 
							$url_pic = "";
							if (isset($imageShow)) {
								$url_pic = Yii::app()->theme->baseUrl . '/../../../uploads/contactusnew/' . $model->id . '/' . $imageShow;
							}
							?>
							<img src="<?=$url_pic?>" class="gambar img-responsive img-thumbnail" id="item-img-output" />
							<figcaption><i class="fa fa-camera"></i></figcaption>
						</figure>
						<input type="hidden" name="url_pro_pic" id="url_pro_pic">
						<input type="file" id="picture_input" class="item-img file center-block" name="picture" />
					</label>
				</div>

				<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
				aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">
								</div>
								<div class="modal-body">
									<div id="upload-demo" class="center-block"></div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
								</div>
							</div>
						</div>
					</div>

					<div class="row" >
						<font color="#990000">
							<?php echo $this->NotEmpty();?> size <?=$width?> x <?=$height?> px
						</font>
					</div>
					<br>
				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>save');?>
				</div>

			<?php $this->endWidget(); ?>

			</div><!-- form -->
		</div>
	</div>
</div>
<script type="text/javascript">
	
	$('#picture_input').on('change',function(){
		readFile(this);
	});
	
	<?php if(!isset($imageShow) || !file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/contactusnew/' . $model->id . '/' . $imageShow)){ ?>
		$(".gambar").attr("src", "<?php echo Yii::app()->theme->baseUrl; ?>/images/personnel_boy.png");
	<?php } ?>
	var $uploadCrop,
	tempFilename,
	rawImg,
	imageId;
	function readFile(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('.upload-demo').addClass('ready');
				$('#cropImagePop').modal('show');
				rawImg = e.target.result;
			}
			reader.readAsDataURL(input.files[0]);
		}
		else {
			swal("Sorry - you're browser doesn't support the FileReader API");
		}
	}

	$uploadCrop = $('#upload-demo').croppie({
		viewport: {
			width: <?=$re_width?>,
			height: <?=$re_height?>,
		},
		enforceBoundary: true,
		enableExif: true
	});
	$('#cropImagePop').on('shown.bs.modal', function(){
                            // alert('Shown pop');
                            $uploadCrop.croppie('bind', {
                            	url: rawImg
                            }).then(function(){
                            	console.log('jQuery bind complete');
                            });
                       });

	$('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
		$('#cancelCropBtn').data('id', imageId); readFile(this); });
	$('#cropImageBtn').on('click', function (ev) {
		$uploadCrop.croppie('result', {
			type: 'base64',
			format: 'jpeg',
			size: {width: <?=$width?>, height: <?=$height?>}
		}).then(function (resp) {
			$('#item-img-output').attr('src', resp);
			$('#cropImagePop').modal('hide');
			$('#url_pro_pic').val($('#item-img-output').attr('src'));

		});
	});
</script>