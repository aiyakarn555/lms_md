<!-- Bootstrap styles -->
<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> -->
<!-- Generic page styles -->
<!-- <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/css/style.css"> -->
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/css/jquery.fileupload-ui-noscript.css"></noscript>

<script src="<?php echo Yii::app()->baseUrl; ?>/../js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="MOvEyr0DQm0f2juUUgZ+oi7ciSsIU3Ekd7MDgQ==";</script>
<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>เพิ่มชื่อวิดีโอ
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">

				<?php $form=$this->beginWidget('AActiveForm', array(
					'id'=>'file-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>

					<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

					<?php //echo $form->errorSummary($model); ?>


					<div class="row">
						<!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>
    <!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jQueryFileUpload/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
						<?php echo $form->labelEx($model,'file_name'); ?>
						<?php echo $form->textField($model,'file_name',array('size'=>60,'maxlength'=>80, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'file_name'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'pp_file'); ?>
						<?php echo $form->fileField($model,'pp_file'); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'pp_file'); ?>
					</div>

<?php
$imageSlide = ImageSlide::model()->findAll('file_id=:file_id', array(':file_id'=>$model->id));
if(!empty($imageSlide)){
?>

					<div class="row">
						<div class="span8">
							<?php 
							echo $model->FileVdo;
							?>

							<script type="text/javascript">

								var playerInstance = jwplayer('vdo<?php echo $model->id; ?>').setup({
									abouttext: "E-learning",
									file: "<?php echo Yii::app()->request->getBaseUrl(true); ?>/../uploads/lesson/<?php echo $model->filename; ?>",
								});
								playerInstance.onReady(function() {
									if(typeof $("#"+this.id).find("button").attr("onclick") == "undefined"){
										$("#"+this.id).find("button").attr("onclick","return false");
									}
									playerInstance.onPlay(function(callback) {
									    console.log(callback);
									});
								});
							</script>
						</div>
						<div class="span4"><?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','type'=>'button','id'=>'addCurrentTime'),'<i></i>เพิ่มเวลาปัจจุบันให้ slide <span id="numberAdd"></span>');?></div>
					</div>

					<div class="row">
						<ul class="thumbnails">
						<?php
						foreach ($imageSlide as $key => $imageSlideItem) {
						?>
						  <li class="span3">
						    <div class="thumbnail">
						      <img src="<?php echo Yii::app()->baseUrl."/../uploads/ppt/".$model->id."/ภาพนิ่ง".$imageSlideItem->image_slide_name.".JPG"; ?>" alt="<?php echo $imageSlideItem->image_slide_name; ?>">
						      <h3 class="numberHeader"><?php echo $imageSlideItem->image_slide_name; ?></h3>
						      <p>เวลา (วินาที)<input type="text" class="time" name="time[<?php echo $imageSlideItem->image_slide_id; ?>]" value="<?php echo $imageSlideItem->image_slide_time; ?>"></p>
						    </div>
						  </li>
						<?php
						}
						?>
						</ul>
  					</div>


<script type="text/javascript">
	$(function(){
		$('.time').each(function(index, el) {
			if($(this).val() == ''){
				$('#addCurrentTime').attr('data-time-index',index);
				$('#numberAdd').text($('.numberHeader').eq(index).text());
				return false;
			}
		});

		$('#addCurrentTime').click(function(event) {
			var index = $(this).attr('data-time-index');
			$('.time').eq(index).val(playerInstance.getPosition());
			$('.time').each(function(index, el) {
			if($(this).val() == ''){
				$('#addCurrentTime').attr('data-time-index',index);
				$('#numberAdd').text($('.numberHeader').eq(index).text());
				return false;
			}
		});
		});

	});
</script>
<?php
}
?>
					<div class="row buttons">
						<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
					</div>

				<?php $this->endWidget(); ?>

			</div><!-- form -->
		</div>
	</div>
</div>
<!-- END innerLR -->
