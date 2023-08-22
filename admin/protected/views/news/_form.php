<!-- innerLR -->
<?php
$width = 760;
$height = 500;
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
					'id'=>'news-form',
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
                 ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
					<!-- <div class="row">
						<?php echo $form->labelEx($model, 'cms_type_id'); ?>
						<?php echo $this->listTypeNewsShow($model, 'cms_type_id','span8',$lang_id,$parent_id); ?>
						<?php echo $this->NotEmpty(); ?>
						<?php echo $form->error($model, 'cms_type_id'); ?>
					</div> -->

					<div class="row">
						<?php echo $form->labelEx($model,'cms_title'); ?>
						<?php echo $form->textField($model,'cms_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'cms_title'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'cms_short_title'); ?>
						<?php echo $form->textArea($model,'cms_short_title',array('rows'=>4, 'cols'=>40,'class'=>'span8','maxlength'=>255)); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'cms_short_title'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'cms_url'); ?>
						<?php echo $form->textField($model,'cms_url',array('size'=>60,'maxlength'=>250, 'class'=>'span8','onchange'=>'search(this)')); ?>
						<?php echo $form->error($model,'cms_url'); ?>
					</div>

					<div class="row urllink">
						<?php echo $form->labelEx($model,'cms_tab'); ?>
						<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
								<?php echo $form->checkBox($model,'cms_tab',array(
									'value'=>1, 'uncheckValue'=>0 ,
                                                        'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
								)); ?>
							<!--</div>-->
						<?php echo $form->error($model,'cms_tab'); ?>
					</div>

					<div class="row urllink">
						<?php echo $form->labelEx($model,'cms_type_display'); ?>
						<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
								<?php echo $form->checkBox($model,'cms_type_display',array(
									'value'=>1, 'uncheckValue'=>0,'onchange'=>'dotextbox(this)',
                                                        'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
								)); ?>
							<!--</div>-->
						<?php echo $form->error($model,'cms_type_display'); ?>
					</div>
                                

					<div class="row textarea">
						<?php echo $form->labelEx($model,'cms_detail'); ?>
						<?php echo $form->textArea($model,'cms_detail',array('class'=>'tinymce')); ?>
						<?php echo $form->error($model,'cms_detail'); ?>
					</div>

					<br>
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
						<?php echo $form->labelEx($model,'picture'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'picture'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						  	</div>
						</div>
						<?php echo $form->error($model,'picture'); ?>
					</div> -->

					<div class="row ">
						<div class="col-xs-12" style="padding-left: 15px; margin-bottom: 5px;">

							<label class="cabinet center-block">
								<p>อัปโหลดรูปภาพ </p>
								<figure>
									<?php 
									$url_pic = "";
									if (isset($imageShow)) {
										$url_pic = Yii::app()->theme->baseUrl . '/../../../uploads/news/' . $model->id . '/' . $imageShow;
									}
									?>
									<img src="<?=$url_pic?>" class="gambar img-responsive img-thumbnail" id="item-img-output" />
									<figcaption><i class="fa fa-camera"></i></figcaption>
								</figure>
								<input type="hidden" name="url_pro_pic" id="url_pro_pic">
								<input type="file" id="picture_input" class="item-img file center-block" name="picture" />
							</label>
						</div>
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
						<div class="col-xs-12">
							<font color="#990000">
								<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด <?=$width?> x <?=$height?> px
							</font>
						</div>
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

	<?php if(!isset($imageShow) || !file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/news/' . $model->cms_id . '/' . $imageShow)){ ?>
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

	
	<?php 
	if(!empty($model->cms_url)){
		?>
		$(document).ready(function(){
			$('.urllink').show();
		});
		<?php
	}else{
            ?>
		$(document).ready(function(){
			$('.urllink').hide();
		});
		<?php
        }
	?>
	function dotextbox(checkboxElem) {
	  if (checkboxElem.checked) {
        $('.textarea').hide();
	  } else {
	  	$('.textarea').show();
	  }
	}
	function search(ele) {
		var val = document.getElementById("News_cms_url").value;
        if(val != ''){
        	$('.urllink').show();  
        } else {
        	$('.urllink').hide();
        }
	}
</script>