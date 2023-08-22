<?php
$width = 225;
$height = 150;
$re_width = $width/1;
$re_height = $height/1;
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
					'id'=>'usability-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>	

				<div class="row">
					<?php echo $form->labelEx($model,'usa_title'); ?>
					<?php echo $form->textField($model,'usa_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'usa_title'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'usa_detail'); ?>
					<?php echo $form->textArea($model,'usa_detail',array('rows'=>6, 'cols'=>50, 'class'=>'span8 tinymce')); ?>
					<?php echo $form->error($model,'usa_detail'); ?>
				</div>

				<br>
				<!-- <div class="row">
					<div class="col-md-12">
					<?php
					if(isset($imageShow)){
						echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
							"class"=>"thumbnail"
						));
					}
					?>
					</div>
				</div>
				<br>
					<div class="row">
					<?php echo $form->labelEx($model, 'usa_address'); ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-append">
							<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span>
							</div>
							<span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span>
							<?php echo $form->fileField($model, 'usa_address', array('id' => 'wizard-picture')); ?>
							<span class="fileupload-exists">Change</span>
							<?php echo $form->fileField($model, 'usa_address'); ?>
						</span>
						<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					</div>
				</div>
				<?php echo $form->error($model, 'usa_address'); ?>
			</div>
			<div class="row">
					<div class="col-md-12">
					<font color="#990000">
						<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 225x150px(แนวนอน) หรือ ขนาด 255x(xxx)px (แนวยาว)
					</font>
					</div>
				</div>
				<br> -->
				<div class="row ">

					<label class="cabinet center-block">
						<p>อัปโหลดรูปภาพ </p>
						<figure>
							<?php 
							$url_pic = "";
							if (isset($imageShow)) {
								$url_pic = Yii::app()->theme->baseUrl . '/../../../uploads/usability/' . $model->usa_id . '/' . $imageShow;
							}
							?>
							<img src="<?=$url_pic?>" class="gambar img-responsive img-thumbnail" id="item-img-output" />
							<figcaption><i class="fa fa-camera"></i></figcaption>
						</figure>
						<input type="hidden" name="url_pro_pic" id="url_pro_pic">
						<input type="file" id="picture_input" class="item-img file center-block" name="picture" />
					</label>
				</div>

				<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">
										&times;
									</span>
								</button>
								<h4 class="modal-title" id="myModalLabel"></h4>
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
					<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด <?=$width?> x <?=$height?> px
				</font>
			</div>
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


<script>
	$(function () {
		init_tinymce();
	});

	$('#picture_input').on('change',function(){
		readFile(this);
	});
	
	<?php if(!isset($imageShow) || !file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/usability/' . $model->usa_id . '/' . $imageShow)){ ?>
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

	$(document).ready(function(){
		$("#usaMutiLang").hide();
	// console.log($('#Usability_lang_id option:selected').val()); //start value

	$('#Usability_lang_id').on('change', function() {

		if(this.value == 1){
			$("#usaMutiLang").hide();
		}else{
			$("#usaMutiLang").show();
		}
	});



});

</script>


