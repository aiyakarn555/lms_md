<?php
$width = 1200;
$height = 600;
$re_width = $width/4;
$re_height = $height/4;
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
					'id'=>'imgslide-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				<div class="row">
					<?php echo $form->labelEx($model,'imgslide_title'); ?>
					<?php echo $form->textField($model,'imgslide_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'imgslide_title'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'imgslide_detail'); ?>
					<?php echo $form->textarea($model,'imgslide_detail',array('rows' => '3', 'class'=>'span8')); ?>
					<?php echo $form->error($model,'imgslide_detail'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'imgslide_link'); ?>
					<?php 
					 ?>
					<input type="checkbox" onchange="checkswitch();" id="swiftLink" data-toggle="toggle" data-onstyle="success" data-offstyle="danger">


				</div>

				<br>
				<div class="row" id="link" style="display: none;">
				    <!-- 	<font color="#990000">
							<?php echo $this->NotEmpty();?> ตัวอย่าง http://www.cpdland.com/
						</font> -->
						<?php //echo $form->labelEx($model,'imgslide_link'); ?>
						<?php echo $form->textField($model,'imgslide_link',array('size'=>60, 'class'=>'span8')); ?>
						<?php echo $form->error($model,'imgslide_link'); ?>
						
					</div>
					<!-- <div class="row" id="typeId">
						<?php echo $form->labelEx($model,'gallery_type_id'); ?>

						<?php echo $form->dropDownList($model, 'gallery_type_id', CHtml::listData(GalleryType::model()->findAll(array(
        'condition' => 'active=:active',
        'params' => array(':active'=>'y'))), 'id', 'name_gallery_type'),array('class'=>'span5','disable_search' => false,'empty' => "--เลือก--")); ?>

						<?php echo $form->error($model,'gallery_type_id'); ?>
					</div> -->
					<!-- <div class="row">
						<?php
						if(isset($imageShow)){
							echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
								"class"=>"thumbnail"
							));
						}
						?>
					</div>
					<br>

					<div class="row">
						<?php echo $form->labelEx($model,'imgslide_picture'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="input-append">
								<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'imgslide_picture'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div>
						<?php echo $form->error($model,'imgslide_picture'); ?>
					</div>

					<div class="row">
						<font color="#990000">
							<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 1985X671 Pixel
						</font>
					</div>
					<?php if ($notsave == 1) { ?>
						<p class="note"><font color="red">*ขนาดของรูปภาพไม่ถูกต้อง </font></p>
					<?php }else{} ?> 
					<br> -->

					<div class="row ">

						<label class="cabinet center-block">
							<p>อัปโหลดรูปภาพ </p>
							<figure>
								<?php 
								$url_pic = "";
								if (isset($imageShow)) {
									$url_pic = Yii::app()->theme->baseUrl . '/../../../uploads/imgslide/' . $model->imgslide_id . '/' . $imageShow;
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
		$( document ).ready(function() {
			checkswitch();
		});

		$('#picture_input').on('change',function(){
			readFile(this);
		});

		<?php if(!isset($imageShow) || !file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/imgslide/' . $model->imgslide_id . '/' . $imageShow)){ ?>
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


		function checkswitch(){
			console.log();
			if ($("#swiftLink").prop('checked') == true) {
				$('#link').show();
			}else{
				$('#link').hide();
				$('#Imgslide_imgslide_link').val("");
			}
			// if (chk == true) {
			// 	$('#link').show();

			// 	$('#typeId').hide();
			// 	$('#Imgslide_gallery_type_id').val("");
			// }else{
			// 	$('#link').hide();
			// 	$('#Imgslide_imgslide_link').val("");

			// 	$('#typeId').show();
			// }
		}
	</script>

