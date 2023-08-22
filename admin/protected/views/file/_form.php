<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase;; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="MOvEyr0DQm0f2juUUgZ+oi7ciSsIU3Ekd7MDgQ==";</script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<style>
    .uploadifive-button {
        float: left;
        margin-right: 10px;
    }
    #queue,#queuePdf {
        border: 1px solid #E5E5E5;
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 616px;
   }
</style>
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

                <div class="vdo_upload">
                    <div class="row">
                        <?php echo $form->labelEx($model,'file_name');  ?>
                        <?php echo $form->textField($model,'file_name',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
                        <div id="queue"></div>
                        <?php echo $form->fileField($model,'file_video',array('id'=>'File_file_video','multiple'=>'false')); ?>
                        <?php //echo $form->fileField($model,'file_video'); ?>
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {
                                function FileListItems (files) { // เพิ่มใส่ FileList
                                    var b = new ClipboardEvent("").clipboardData || new DataTransfer()
                                    // for (var i = 0, len = files.length; i<len; i++) console.log(files)
                                    b.items.add(files);
                                    return b.files
                                }

                                $('#File_file_video').uploadifive({
                                    // 'auto'             : false,
                                    // //'checkScript'      : 'check-exists.php',
                                    // 'checkScript'      : '<?php //echo $this->createUrl("lesson/checkExists"); ?>',
                                    // 'formData'         : {
                                    //     'timestamp' : '<?php //echo $timestamp;?>',
                                    //     'token'     : '<?php //echo md5("unique_salt" . $timestamp);?>'
                                    // },
                                    'queueID'          : 'queue',
                                    'simUploadLimit'    : 0, 
                                    'multi'			   : false,
                                    'uploadScript'     : '<?php echo $this->createUrl("lesson/uploadifive"); ?>',
                                    'onUploadComplete' : function(file, data) {
                                        var fileName = file.name;
                                        var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                        switch (ext) {
                                            case 'mp3':
                                            case 'mp4':
                                            case 'mkv':
                                            case 'MOV':
                                            break;
                                            default:
                                            alert('Wrong filetype');
                                            $('#File_file_video').uploadifive('cancel', file);
                                            return;
                                            break;
                                        }
                                        if($('.uploadifive-queue-item').length < 2){
                                            if(!file.skip){
                                                var files = [
                                                    new File(['content'], file),
                                                ];
                                                $('#File_file_video').prop('files', new FileListItems(file))
                                            }
                                        }else{
                                            alert('จำนวนเกินลิมิต สามารถอัพโหลดได้จำนวน 1 ไฟล์');
                                            $('#File_file_video').uploadifive('cancel', file);
                                        }
                                      
                                     
                                    }
                                });
                            });
                        </script>
                 <?php echo $this->NotEmpty();?>
                <?php echo $form->error($model,'file_name'); ?>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-12">
                    <?php
                        $uploadFolder = Yii::app()->getUploadUrl("lesson");
                        if(isset($model->filename)){
                            if ($model->lang_id == $_GET["lang_id"]) {
                                ?>
                                <div style="padding-bottom:20px;">
                                    <?php
                                        echo '<strong id="filenamepdftext'.$model->id.'">'.$model->filename.'</strong>';
                                    ?>
                                </div>
                                <div class="row" style="padding-bottom:10px;width:480px;">
                                    <div id="vdoshow">Loading the player...</div>
                                </div>
                                <script type="text/javascript">
                                var playerInstanceShow = jwplayer("vdoshow").setup({
                                    file: '<?php echo $uploadFolder.$model->filename; ?>'
                                });
                            </script>
                            <?php
                            $idx++;
                        }
                        }
                    ?>
                    </div>
                </div>
           




                <!-- <div class="row">
                    <?php //echo $form->labelEx($model,'file_name'); ?>
                    <?php //echo $form->textField($model,'file_name',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
                    <?php //echo $form->fileField($model,'file_video'); ?>
                    <?php //if (isset($error["video_file"])) { ?>
                        <?php //if ($error["video_file"] == "Required") { ?>
                            <span class="text-danger">กรุณาเลือกไฟล์วิดีโอ</span>
                        <?php //}else{ ?>
                            <span class="text-danger">กรุณาเลือกไฟล์วิดีโอด้วยนามสกุล 'mp4','mp3','mkv'</span>
                        <?php //} ?>
                    <?php //} ?>
                    <?php //echo $this->NotEmpty();?>
                    <?php //echo $form->error($model,'file_name'); ?>
                </div> -->

                <!-- <div class="row">
                    <div class="col-md-12">
                    <?php
                    // $uploadFolder = Yii::app()->getUploadUrl("lesson");
                    // if(isset($model->filename)){
                    //     if ($model->lang_id == $_GET["lang_id"]) {
                            ?>
                            <div class="row" style="padding-bottom:10px;width:480px;">
                                <div id="vdoshow">Loading the player...</div>
                            </div>
                            <script type="text/javascript">
                             var playerInstanceShow = jwplayer("vdoshow").setup({
                                 file: '<?php //echo $uploadFolder.$model->filename; ?>'
                             });
                         </script>
                         <?php
                //          $idx++;
                //      }
                //  }
                 ?>
                 </div>
             </div> -->

                <?php if($model->lesson->type != "youtube"){ ?>
                <br>
                <div class="row">
                    <?php echo $form->labelEx($model,'pp_file'); ?>
                    <div id="queuePdf"></div>
                    <?php echo $form->fileField($model,'pp_file',array('id'=>'File_pp_file','multiple'=>'false')); ?>
                    <?php //echo $form->fileField($model,'pp_file'); ?>
                    <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {

                                function FileListItems (files) { // เพิ่มใส่ FileList
                                    var b = new ClipboardEvent("").clipboardData || new DataTransfer()
                                    // for (var i = 0, len = files.length; i<len; i++) console.log(files)
                                    b.items.add(files);
                                    return b.files
                                }

                                $('#File_pp_file').uploadifive({
                                    // 'auto'             : false,
                                    // //'checkScript'      : 'check-exists.php',
                                    // 'checkScript'      : '<?php //echo $this->createUrl("lesson/checkExists"); ?>',
                                    // 'formData'         : {
                                    //     'timestamp' : '<?php //echo $timestamp;?>',
                                    //     'token'     : '<?php //echo md5("unique_salt" . $timestamp);?>'
                                    // },
                                    'queueID'          : 'queuePdf',
                                    'simUploadLimit'    : 0, 
                                    'multi'			   : false,
                                    'uploadScript'     : '<?php echo $this->createUrl("lesson/uploadifivepdf"); ?>',
                                    'onUploadComplete' : function(file, data) {
                                        var fileName = file.name;
                                        var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                        switch (ext) {
                                            case 'pdf':
                                            break;
                                            default:
                                            alert('Wrong filetype');
                                            $('#File_pp_file').uploadifive('cancel', file);
                                            return;
                                            break;
                                        }
                                        if($('.uploadifive-queue-item').length < 2){
                                            if(!file.skip){
                                                var files = [
                                                    new File(['content'], file),
                                                ];
                                                $('#File_pp_file').prop('files', new FileListItems(file))
                                            }
                                        }else{
                                            alert('จำนวนเกินลิมิต สามารถอัพโหลดได้จำนวน 1 ไฟล์');
                                            $('#File_pp_file').uploadifive('cancel', file);
                                        }
                                      
                                     
                                    }
                                });
                            });
                        </script>
                    <?php echo $this->NotEmpty();?>
                    <?php echo $form->error($model,'pp_file'); ?>
                </div>
            <?php } ?>

                <?php

                //Display seconds as hours, minutes and seconds
                function sec2hms ($sec, $padHours = true)
                {

                    // start with a blank string
                    $hms = "";

                    // do the hours first: there are 3600 seconds in an hour, so if we divide
                    // the total number of seconds by 3600 and throw away the remainder, we're
                    // left with the number of hours in those seconds
                    $hours = intval(intval($sec) / 3600);

                    // add hours to $hms (with a leading 0 if asked for)
                    $hms .= ($padHours)
                        ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
                        : $hours. ":";

                    // dividing the total seconds by 60 will give us the number of minutes
                    // in total, but we're interested in *minutes past the hour* and to get
                    // this, we have to divide by 60 again and then use the remainder
                    $minutes = intval(($sec / 60) % 60);

                    // add minutes to $hms (with a leading 0 if needed)
                    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

                    // seconds past the minute are found by dividing the total number of seconds
                    // by 60 and using the remainder
                    $seconds = intval($sec % 60);

                    // add seconds to $hms (with a leading 0 if needed)
                    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

                    // done!
                    return $hms;

                }

                $imageSlide = ImageSlide::model()->findAll('file_id=:file_id', array(':file_id'=>$model->id));
                if(!empty($imageSlide)){
                    ?>
                    <div class="row">
                        <button type="button" class="btn btn-danger" onclick="del_slide(<?php echo $model->id; ?>)">ลบ Slide</button>
                    </div>

                    <div class="row">
                        <div class="span7">
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
                        <div class="span5">
                            <div class="span4" style="padding-left:50px;">
                                <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','type'=>'button','id'=>'addCurrentTime'),'<i></i>เพิ่มเวลาปัจจุบันให้ slide <span id="numberAdd"></span>'); ?>
                            </div>
                            <div class="span4 thumbnail" id="slideImgShow"></div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <ul class="thumbnails">
                            <?php
                            foreach ($imageSlide as $key => $imageSlideItem) {
                                ?>
                                <li class="span3">
                                    <div class="thumbnail timepicker">
                                        <a href="<?php echo Yii::app()->baseUrl."/../uploads/ppt/".$model->id."/slide-".$imageSlideItem->image_slide_name.".jpg?time=".time(); ?>" rel="prettyPhoto"><img class="slide" src="<?php echo Yii::app()->baseUrl."/../uploads/ppt/".$model->id."/slide-".$imageSlideItem->image_slide_name.".jpg?time=".time(); ?>" alt="<?php echo $imageSlideItem->image_slide_name; ?>"></a>
                                        <h3 class="numberHeader"><?php echo $imageSlideItem->image_slide_name+1; ?></h3>
                                        <p>เวลา (ชั่วโมง : นาที : วินาที)</p><div class="input-append">
                                            <input data-format="hh:mm:ss" type="text" class="time" name="time[<?php echo $imageSlideItem->image_slide_id; ?>]" value="<?php echo gmdate("H:i:s",$imageSlideItem->image_slide_time);?>" style="width: auto !important;"><span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span></div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>

                    <?php
                }
                ?>
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




<script type="text/javascript">
    function deleteVdo(vdo_id,file_id){
        $.get("<?php echo $this->createUrl('lesson/deleteVdo'); ?>",{id:file_id},function(data){
            if($.trim(data)==1){
                notyfy({dismissQueue: false,text: "ลบข้อมูลเรียบร้อย",type: 'success'});
                $('#'+vdo_id).parent().hide('fast');
            }else{
                alert('ไม่สามารถลบวิดีโอได้');
            }
        });
    }


    function del_slide(id){
        swal({
            title: 'แจ้งเตือน!',
            text: "ยืนยันที่จะลบ Slide",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : '../delslide',
                    data : {
                        id:id,
                    },
                    type : 'GET',
                    success : function(data){
                        if(data == "success"){
                            window.location.reload();                           
                        }else{
                            alert("ทำรายการใหม่");
                        }                 
                    },              
                });
            }
        });
    }
</script>