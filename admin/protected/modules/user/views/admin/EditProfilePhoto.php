<?php
$width = 150;
$height = 200;
$re_width = $width;
$re_height = $height;
$formtext = "แก้ไขรูปภาพ Profile";
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
					'id'=>'EditProfilePhoto-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<div class="row ">
					<label class="cabinet center-block">
						<p>อัปโหลดรูปภาพ </p>
						<figure>
							<?php 
							$url_pic = Yii::app()->theme->baseUrl . '/../../../uploads/users/' . $users->id . '/' . $profiles->profile_picture;
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

		<?php if(!file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/users/' . $users->id . '/' . $profiles->profile_picture)){ ?>
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

