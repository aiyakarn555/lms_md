<script src="<?php echo $this->assetsBase;; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<!-- innerLR -->
<style type="text/css">
	#queue {
        border: 1px solid rgba(26, 26, 26, 0.14901960784313725);
        height: 200px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 40%;
        border-radius: 4px;
    }
</style>
<script type="text/javascript">
	function upload()
{
         var file = $('#queue').val();
         var exts = ['jpg','png','jpeg'];
         if ( file ) {
            var get_ext = file.split('.');
            get_ext = get_ext.reverse();

            if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){

                if($('#queue .uploadifive-queue-item').length == 0){
                    return true;
                }else{
                    if($('#queue .uploadifive-queue-item').length > 0 ) {
                        $('#image').uploadifive('upload');
                        return false;
                    }
                } 
            }
        }else{
           if($('#queue .uploadifive-queue-item').length == 0 ){
            return true;
        }else{
          if($('#queue .uploadifive-queue-item').length > 0){
            $('#image').uploadifive('upload');
            return false;

        }


    }
}
}

function deletes(filedoc_id,file_id){
	// console.log(file_id);
    $.get("<?php echo $this->createUrl('GalleryGroup/DeleteFile'); ?>",{id:file_id},function(data){
    	console.log(data);
        if($.trim(data)==1){
           var success_file = 'ลบไฟล์สำเร็จ';
           swal(success_file);
           location.reload();
           // $('#'+filedoc_id).parent().hide('fast');
       }else{
        var Unable_file = 'ลบไฟล์สำเร็จ';
        swal(Unable_file);
        location.reload();
    }
});
}
</script>
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
					'id'=>'gallerygroup-form',
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

					<?php echo $form->dropDownList($model, 'gallery_type_id', CHtml::listData(GalleryType::model()->findAll(array(
        'condition' => 'active=:active',
        'params' => array(':active'=>'y'))), 'id', 'name_gallery_type'),array('class'=>'span5')); ?>

					<?php //echo $form->dropDownList($model,'gallery_type_name',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'gallery_type_id'); ?>
				</div>
				<div class="row">
					<!-- <?php
					if(isset($imageShow)){
					?>
					<h6>รูปภาพเดิม</h6>
					<?php
						 echo CHtml::image(yii::app()->baseUrl.'../../uploads/gallery/images/'.$model->image);
					}
					?> -->
				</div>
				<br>

				<div class="row">
					<!-- <?php
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
					<?php } ?> -->
					<div id="queue"></div>
            <?php echo $form->fileField($gallery,'image',array('id'=>'image','multiple'=>'true')); ?>
            <script type="text/javascript">
                <?php $timestamp = time();?>
                $(function() {
                    $('#image').uploadifive({
                        'auto'             : false,

                        'formData'         : {
                            'timestamp' : '<?php echo $timestamp;?>',
                            'token'     : '<?php echo md5("unique_salt" . $timestamp);?>',
                            'updateid' :'<?php echo $model->id; ?>'
                        },
                        'queueID'          : 'queue',
                        'uploadScript'     : '<?php echo $this->createUrl("GalleryGroup/UploadifiveImages"); ?>',
                        'onAddQueueItem' : function(file){
                            var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'png':
                                                        case 'jpg':
                                                        case 'jpeg':
                                                        break;
                                                        default:
                                                        var filetype = "ประเภทไฟล์ไม่ถูกต้อง";
                                                        swal(filetype);
                                                        $('#image').uploadifive('cancel', file);
                                                        break;
                                                    }
                                                },
                                                'onQueueComplete' : function(file, data) {
                                                   console.log(data);
                                                    $('#gallerygroup-form').submit();
                                               }
                                           });
                });
            </script>
            <?php echo $form->error($gallery,'image'); ?>
				</div>
				<div class="row">
					<?php
                        $idx = 1;
                        $uploadFolder = Yii::app()->getUploadUrl('gallery');
                        $criteria = new CDbCriteria;
                        $criteria->addCondition('gallery_type_id ="'.$model->gallery_type_id.'"');
                        $criteria->addCondition("active ='y'");
                        $Gallery = Gallery::model()->findAll($criteria);
              
                        if (isset($Gallery)) {
                        	 $confirm_del  = 'คุณต้องการลบรูปภาพใช่หรือไม่';
                        foreach ($Gallery as $key ) {
                           echo CHtml::image(Yii::app()->baseUrl.'/../uploads/gallery/'.$key->image, 'No Image',array('width'=>'400px','height'=>'400px'));
                           echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                        'id'=>'btnSaveNametrain'.$key->id,
                        'class'=>'btn-action glyphicons btn-danger remove_2',
                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deletes("filedoc'.$idx.'","'.$key->id.'"); }'));?><br><br><?php 

                            $idx++;
                        }
                    }
					?>
				</div>

				<div class="row">
					<font color="#990000">
						<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 750X416 Pixel
					</font>
				</div>
				<?php if ($notsave == 1) { ?>
					<p class="note"><font color="red">*ขนาดของรูปภาพไม่ถูกต้อง </font></p>
				<?php }else{} ?> 
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
