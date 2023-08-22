<script src="<?php echo $this->assetsBase;; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase;; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="MOvEyr0DQm0f2juUUgZ+oi7ciSsIU3Ekd7MDgQ==";</script>

<!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
<!-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->
<style>
.checkbox label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.checkbox label {
    display: inline-block;
}

.checkbox label input[type="checkbox"]{
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon{
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon{
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr{
    opacity: .5;
}
</style>
<script type="text/javascript">
    function upload()
    {
        tinymce.triggerSave();
        var file = $('#Lesson_image').val();
        var exts = ['jpg','gif','png'];
        if ( file ) {
            var get_ext = file.split('.');
            get_ext = get_ext.reverse();
            if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){

                if($('#queue .uploadifive-queue-item').length == 0 && $('#docqueue .uploadifive-queue-item').length == 0){
                    return true;
                }else{
                    if($('#queue .uploadifive-queue-item').length > 0) {
                        $('#filename').uploadifive('upload');
                        return false;
                    }else if($('#docqueue .uploadifive-queue-item').length > 0){
                        $('#doc').uploadifive('upload');
                        return false;
                    }
                }

            } else {
                $('#Lesson_image_em_').removeAttr('style').html("<p class='error help-block'><span class='label label-important'> ไม่สามารถอัพโหลดได้ ไฟล์ที่สามารถอัพโหลดได้จะต้องเป็น: jpg, gif, png.</span></p>");
                return false;
            }
        }
        else
        {
            if($('#queue .uploadifive-queue-item').length == 0 && $('#docqueue .uploadifive-queue-item').length == 0 && $('#pdfqueue .uploadifive-queue-item').length == 0 && $('#scormqueue .uploadifive-queue-item').length == 0 && $('#ebookqueue .uploadifive-queue-item').length == 0 && $('#audioqueue .uploadifive-queue-item').length == 0){
                return true;
            }else{
                if($('#queue .uploadifive-queue-item').length > 0) {
                    $('#filename').uploadifive('upload');
                    return false;
                }else if($('#pdfqueue .uploadifive-queue-item').length > 0){
                    $('#pdf').uploadifive('upload');
                    return false;
                }else if($('#scormqueue .uploadifive-queue-item').length > 0){
                    $('#scorm').uploadifive('upload');
                    return false;
                }else if($('#ebookqueue .uploadifive-queue-item').length > 0){
                    $('#ebook').uploadifive('upload');
                    return false;
                }else if($('#audioqueue .uploadifive-queue-item').length > 0){
                    $('#audio').uploadifive('upload');
                    return false;
                }else if($('#docqueue .uploadifive-queue-item').length > 0){
                    $('#doc').uploadifive('upload');
                    return false;
                }
            }
        }
    }

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

    function deleteFileDoc(filedoc_id,file_id){
        $.get("<?php echo $this->createUrl('lesson/deleteFileDoc'); ?>",{id:file_id},function(data){
            if($.trim(data)==1){
                notyfy({dismissQueue: false,text: "ลบไฟล์เรียบร้อย",type: 'success'});
                $('#'+filedoc_id).parent().hide('fast');
            }else{
                alert('ไม่สามารถลบไฟล์ได้');
            }
        });
    }

    function deleteFilepdf(filedoc_id,file_id){
        $.get("<?php echo $this->createUrl('lesson/deleteFilePdf'); ?>",{id:file_id},function(data){
            if($.trim(data)==1){
                notyfy({dismissQueue: false,text: "ลบไฟล์เรียบร้อย",type: 'success'});
                $('#'+filedoc_id).parent().hide('fast');
            }else{
                alert('ไม่สามารถลบไฟล์ได้');
            }
        });
    }

    function editName(filedoc_id){

        var name = $('#filenamedoc'+filedoc_id).val();

        $.get("<?php echo $this->createUrl('lesson/editName'); ?>",{id:filedoc_id,name:name},function(data){

        // if($.trim(data)==1){
        //     notyfy({dismissQueue: false,text: "เปลี่ยนชื่อไฟล์เรียบร้อย",type: 'success'});
        //     $('#'+filedoc_id).parent().hide('fast');
        // }else{
        //     alert('ไม่สามารถเปลี่ยนชื่อไฟล์ได้');
        // }
        $('#filenamedoc'+filedoc_id).hide();
        $('#filenamedoctext'+filedoc_id).text(name);
        $('#filenamedoctext'+filedoc_id).show();
        $('#btnEditName'+filedoc_id).show();
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
#pdfqueue {
    border: 1px solid #E5E5E5;
    height: 177px;
    overflow: auto;
    margin-bottom: 10px;
    padding: 0 3px 3px;
    width: 600px;
}

#docqueue {
    border: 1px solid #E5E5E5;
    height: 177px;
    overflow: auto;
    margin-bottom: 10px;
    padding: 0 3px 3px;
    width: 600px;
}

#scormqueue {
    border: 1px solid #E5E5E5;
    height: 177px;
    overflow: auto;
    margin-bottom: 10px;
    padding: 0 3px 3px;
    width: 600px;
}

#ebookqueue {
    border: 1px solid #E5E5E5;
    height: 177px;
    overflow: auto;
    margin-bottom: 10px;
    padding: 0 3px 3px;
    width: 600px;
}

#audioqueue {
    border: 1px solid #E5E5E5;
    height: 177px;
    overflow: auto;
    margin-bottom: 10px;
    padding: 0 3px 3px;
    width: 600px;
}
</style>
<!-- innerLR -->
<?php //echo "<pre>"; var_dump($fileDoc->fileDocs); exit(); ?>
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

                    <?php $form=$this->beginWidget('AActiveForm', array(
                        'id'=>'lesson-form',
                        'enableClientValidation'=>false,
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true
                        ),
                        'errorMessageCssClass' => 'label label-important',
                        'htmlOptions' => array('enctype' => 'multipart/form-data'),
                        )); ?>

                        
                        <?php
                        $lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
                        $parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
                        $modelLang = Language::model()->findByPk($lang_id);

                        // $courseAll = CHtml::listData(CourseOnline::model()->findAll('active="y" and lang_id = '.$lang_id), 'course_id', 'CoursetitleConcat');

                        // ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
                        // $check_user = User::model()->findByPk(Yii::app()->user->id);
                        // $group = $check_user->group;
                        // $group_arr = json_decode($group);
                        // $see_all = 2;
                        // if(in_array("1", $group_arr) || in_array("7", $group_arr)){
                        //     $see_all = 1;
                        // }
                        // //////////////////
                        // if($see_all != 1){
                        //     $courseAll = CHtml::listData(CourseOnline::model()->findAll('active="y" and lang_id = '.$lang_id.' and create_by="'.Yii::app()->user->id.'"'), 'course_id', 'CoursetitleConcat');
                        // }else{
                        //     $courseAll = CHtml::listData(CourseOnline::model()->findAll('active="y" and lang_id = '.$lang_id), 'course_id', 'CoursetitleConcat');
                        // }


                           //แสดงตาม Group
                            $criteria = new CDbCriteria;
                            $criteria->compare("active","y");
                            $criteria->compare("lang_id",$lang_id);
                            $modelUser = Users::model()->findByPk(Yii::app()->user->id);
                            $group = json_decode($modelUser->group);
                            if (!in_array(1, $group)){
                                $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
                                $criteria->addInCondition('create_by', $groupUser);    
                            }
                            $courseAll = CHtml::listData(CourseOnline::model()->findAll($criteria), 'course_id', 'CoursetitleConcat');
                            $courseAll = array('' =>'-- กรุณาเลือกหลักสูตร --') + $courseAll;
                        ?>

                        <?php if ($lang_id != 1){ ?>
                        <p class="note"><span style="color:red;font-size: 20px;">เพิ่มเนื้อหาของภาษา <?= $modelLang->language; ?></span></p>
                        <?php 
                            }
                        ?>
                        <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
                        <?php    
                        if($lang_id == 1){ 
                            $flag = true;
                            $att = array("class"=>"span8");
                            $attCateAmount = array('size'=>60,'maxlength'=>255,'min'=>'0','oninput'=>"this.value = Math.abs(this.value)",'class'=>'span8');
                            $attTime = array('class' => 'default_datetimepicker');
                            $dayCheck = 'onclick="return true;"';
                            $state = false;
                            $attSearch = array("class"=>"span8",'disable_search' => false);
                        }else{ 
                            $flag = false;
                        $lessonChildren = $lesson; //Lesson parent_id not 0
                        $lesson = Lesson::model()->FindByPk($parent_id);
                        $rootLesson = $lesson;
                        $conditions = "course_id = ".$lesson->courseonlines->course_id;
                        $courseCh = CourseOnline::model()->find("course_id = '".$lesson->courseonlines->course_id."'");
                        $courseAll = CHtml::listData(CourseOnline::model()->findAll("course_id = ".$courseCh->course_id), 'course_id', 'CoursetitleConcat');
                        // $courseAll = CHtml::listData(CourseOnline::model()->findAll("course_id = ".$lesson->courseonlines->course_id), 'course_id', 'CoursetitleConcat');
                        $lesson->title = "";
                        $lesson->description = "";
                        $lesson->content = "";
                        $att = array("class"=>"span8",'readonly' => true);
                        $attCateAmount = array('size'=>60,'maxlength'=>255,'class'=>'span8','readonly' => true);
                        $attTime = array('class' => 'default_datetimepicker','readonly' => true);
                        $dayCheck = 'onclick="return false;"';
                        $state = true;
                        $attSearch = array("class"=>"span8",'disable_search' => true);
                    } ?>
                    <!-- <div class="row"> -->
                        <!-- <?php echo $form->labelEx($lesson,'course_id'); ?> -->
                        <!-- <?php echo $form->dropDownList($lesson,'course_id', $courseAll, array('empty'=>'-- กรุณาเลือกหลักสูตร --','class'=>'span8')); ?> -->
                        <!-- <?php echo $form->dropDownList($lesson,'course_id', $courseAll,$att); ?> -->
                        <!-- <?php echo $this->NotEmpty();?> -->
                        <!-- <?php echo $form->error($lesson,'course_id'); ?> -->
                    <!-- </div> -->
                    <?php (empty($model->course_id)? $select = '' : $select = $model->course_id); ?>
                    <div class="row">
                        <?php echo $form->labelEx($lesson,'course_id'); ?>
                        <!-- <?php echo Chosen::dropDownList('course_id', $select, $courseAll, $attSearch); ?> -->
                        <?php echo Chosen::activeDropDownList($lesson, 'course_id', $courseAll, $attSearch); ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($lesson,'course_id'); ?>
                    </div>
                    <?php if($lessonChildren){
                        $lesson = $lessonChildren;
                    }
                    ?>

                    <div class="row">
                        <!-- <div class="col-md-12"> -->
                        <?php echo $form->labelEx($lesson,'title'); ?>
                        <?php echo $form->textField($lesson,'title',array('size'=>60,'maxlength'=>80,'class'=>'span8')); ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($lesson,'title'); ?>
                        <!-- </div> -->
                    </div>




                    <!-- <div class="row"> -->
                        <!-- <div class="col-md-12"> -->
                        <?php //echo $form->labelEx($lesson,'description'); ?>
                        <?php //echo $form->textArea($lesson,'description',array('size'=>60,'class'=>'span8')); ?>
                        <?php //echo $this->NotEmpty();?>
                        <?php //echo $form->error($lesson,'description'); ?>
                        <!-- </div> -->
                    <!-- </div> -->


                    <div class="row" style="display:none;">
                        <!-- <div class="col-md-12"> -->
                        <?php echo $form->labelEx($lesson,'view_all'); ?>
                        <?php
                        echo $form->dropDownList($lesson,'view_all', array(
                            'y' => 'ดูได้ทั้งหมด',
                            'n' => 'ดูได้เฉพาะกลุ่ม'),
                        array('class'=>'span8'));
        // echo $form->radioButtonList($lesson, 'view_all',
        //     array(  'y' => 'ดูได้ทั้งหมด',
        //             'n' => 'ดูได้เฉพาะกลุ่ม')
        // ); // choose your own separator text
                        ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($lesson,'view_all'); ?>
                        <!-- </div> -->
                    </div>

                     <?php if($state){
                        $lesson = Lesson::model()->findByPk($parent_id);
                       } ?>

            <div class="row">
                <!-- <div class="col-md-12"> -->
                <?php echo $form->labelEx($lesson,'cate_percent'); ?>
                <?php echo $form->numberField($lesson,'cate_percent',$attCateAmount); ?> %
                <?php echo $this->NotEmpty();?>
                <?php echo $form->error($lesson,'cate_percent'); ?>
                <!-- </div> -->
            </div>

            <div class="row">
                <!-- <div class="col-md-12"> -->
                <?php echo $form->labelEx($lesson,'cate_amount'); ?>
                <?php echo $form->numberField($lesson,'cate_amount',$attCateAmount); ?> ครั้ง
                <?php echo $this->NotEmpty();?>
                <?php echo $form->error($lesson,'cate_amount'); ?>
                <!-- </div> -->
            </div>
            <div class="row">
                <!-- <div class="col-md-12"> -->
                <?php echo $form->labelEx($lesson,'time_test'); ?>
                <?php echo $form->numberField($lesson,'time_test',$attCateAmount); ?> นาที
                <?php echo $this->NotEmpty();?>
                <?php echo $form->error($lesson,'time_test'); ?>
                <!-- </div> -->
            </div>

                <div class="row">
                   <!--  <div class="col-md-12"> -->
                    <?php echo $form->labelEx($lesson,'content'); ?>
                    <?php echo $form->textArea($lesson,'content',array('class'=>'tinymce')); ?>
                    <?php echo $form->error($lesson,'content'); ?>
                    <?php //$this->widget('application.extensions.tinymce.ETinyMce', array('name'=>'html')); ?>
                    <!-- </div> -->
                </div>
                
                <?php if($flag ){ ?>
                <div class="row">
                    <!-- <div class="col-md-12"> -->
                        <!-- ,'scorm'=>'SCORM' -->
                        <!-- , 'ebook'=>'Ebook' -->
                    <?php echo $form->labelEx($lesson,'type'); ?>
                    <?php echo $form->dropDownList($lesson, 'type', array('vdo'=>'VDO','pdf'=>'PDF','audio'=>'AUDIO', 'youtube'=>'Youtube')) ?>
                    <?php echo $form->error($lesson,'type'); ?>
                    <!-- </div> -->
                </div>
                <br>
                <div class="vdo_upload">
                    <div class="row">
                        <?php echo $form->labelEx($file,'filename'); ?>
                        <div id="queue"></div>
                        <?php echo $form->fileField($file,'filename',array('id'=>'filename','multiple'=>'true')); ?>
                        <!-- <input id="file_upload" name="file_upload" type="file" multiple="true" > -->
                        <!-- <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a> -->
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {
                                $('#filename').uploadifive({
                                    'auto'             : false,
                                                //'checkScript'      : 'check-exists.php',
                                                'checkScript'      : '<?php echo $this->createUrl("lesson/checkExists"); ?>',
                                                'formData'         : {
                                                   'timestamp' : '<?php echo $timestamp;?>',
                                                   'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                                               },
                                               'queueID'          : 'queue',
                                               'uploadScript'     : '<?php echo $this->createUrl("lesson/uploadifive"); ?>',
                                               'onAddQueueItem' : function(file){
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
                                                        $('#filename').uploadifive('cancel', file);
                                                        break;
                                                    }
                                                },
                                               'onQueueComplete' : function(file, data) {
                                                console.log(file);
                                                //                        exit();
                                                if($('#docqueue .uploadifive-queue-item').length == 0) {
                                                    $('#lesson-form').submit();
                                                }else{
                                                    $('#doc').uploadifive('upload');
                                                }
                                            }
                                        });
                            });
                        </script>
                        <?php echo $form->error($file,'filename'); ?>
                    </div>
                    <div class="row">
                        <?php
    //var_dump($file->files);
                        $idx = 1;
                        $uploadFolder = Yii::app()->getUploadUrl(null);
                        if(isset($file->files)){
                            foreach($file->files as $fileData){
                                ?>

                                <div style="padding-top:20px;">
                                    <?php
                                    if($fileData->file_name == '')
                                    {
                                        echo $fileData->filename.' <font color="#990000"><b>( ยังไม่ได้เปลี่ยนชื่อ )</b></font>';
                                    }
                                    else
                                    {
                                        echo '<b>'.$fileData->file_name.'</b>';
                                    }
                                    ?>
                                </div>

                                <div class="row" style="padding-top:20px; width:480px;">
                                    <?php echo CHtml::link('<i></i>','', array('title'=>'ลบวิดีโอ','class'=>'btn-action glyphicons pencil btn-danger remove_2','style'=>'float:right; z-index:1; background-color:white; cursor:pointer;','onclick'=>'if(confirm("คุณต้องการลบวิด๊โอใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบวิธีโอออกจากระบบแบบถาวร")){ deleteVdo("vdo'.$idx.'","'.$fileData->id.'"); }')); ?>
                                    <div id="vdo<?php echo $idx; ?>">Loading the player...</div>
                                </div>
                                <script type="text/javascript">
                                   var playerInstance<?php echo $idx; ?> = jwplayer("vdo<?php echo $idx; ?>").setup({
                                       file: '<?php echo $uploadFolder.$fileData->filename; ?>'
                                   });

                                   playerInstance<?php echo $idx; ?>.onReady(function() {
                                    if(typeof $("#vdo<?php echo $idx; ?>").find("button").attr('onclick') == "undefined"){
                                        $("#vdo<?php echo $idx; ?>").find("button").attr('onclick','return false');
                                    }
                                    playerInstance<?php echo $idx; ?>.onPlay(function(callback) {
                                        console.log(callback);
                                    });
                                });

                            </script>
                            <!-- <button onclick='console.log(playerInstance<?php echo $idx; ?>.getState()); return false;'>getState()</button> -->
                            <?php
                            $idx++;
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="audio_upload">
                    <div class="row">
                        <label>ไฟล์ประกอบบทเรียน (mp3)</label>
                        <?php //echo $form->labelEx($fileAudio,'filename'); ?>
                        <div id="audioqueue"></div>
                        <?php echo $form->fileField($fileAudio,'filename',array('id'=>'audio','multiple'=>'true')); ?>
                        <!-- <input id="file_upload" name="file_upload" type="file" multiple="true" > -->
                        <!-- <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a> -->
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {
                                $('#audio').uploadifive({
                                    'auto'             : false,
                                                //'checkScript'      : 'check-exists.php',
                                                // 'checkScript'      : '<?php //echo $this->createUrl("lesson/checkExists"); ?>',
                                                'formData'         : {
                                                   'timestamp' : '<?php echo $timestamp;?>',
                                                   'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                                               },
                                               'queueID'          : 'audioqueue',
                                               'uploadScript'     : '<?php echo $this->createUrl("lesson/uploadifiveAudio"); ?>',
                                               'onAddQueueItem' : function(file){
                                                var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'mp3':
                                                        case 'mp4':
                                                        case 'mkv':
                                                        break;
                                                        default:
                                                        alert('Wrong filetype');
                                                        $('#audio').uploadifive('cancel', file);
                                                        break;
                                                    }
                                                },
                                               'onQueueComplete' : function(file, data) {
                                                //                        exit();
                                                if($('#docqueue .uploadifive-queue-item').length == 0) {
                                                    $('#lesson-form').submit();
                                                }else{
                                                    $('#doc').uploadifive('upload');
                                                }
                                            }
                                        });
                            });
                        </script>
                        <?php echo $form->error($fileAudio,'filename'); ?>
                    </div>
                    <div class="row">
                        <?php
                        $idx = 1;
                        $uploadFolder = Yii::app()->getUploadUrl(null);//Yii::app()->getUploadUrl(null);
                        if(isset($file->fileAudio)){
                            foreach($file->fileAudio as $fileData){
                                ?>

                                <div style="padding-top:20px;">
                                    <?php
                                    if($fileData->file_name == '')
                                    {
                                        echo $fileData->filename.' <font color="#990000"><b>( ยังไม่ได้เปลี่ยนชื่อ )</b></font>';
                                    }
                                    else
                                    {
                                        echo '<b>'.$fileData->file_name.'</b>';
                                    }
                                    ?>
                                </div>

                                <div class="row" style="padding-top:20px; width:480px;">
                                    <?php echo CHtml::link('<i></i>','', array('title'=>'ลบวิดีโอ','class'=>'btn-action glyphicons pencil btn-danger remove_2','style'=>'float:right; z-index:1; background-color:white; cursor:pointer;','onclick'=>'if(confirm("คุณต้องการลบวิด๊โอใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบวิธีโอออกจากระบบแบบถาวร")){ deleteVdo("vdo'.$idx.'","'.$fileData->id.'"); }')); ?>
                                    <div id="vdo<?php echo $idx; ?>">Loading the player...</div>
                                </div>
                                <script type="text/javascript">
                                   var playerInstance<?php echo $idx; ?> = jwplayer("vdo<?php echo $idx; ?>").setup({
                                       file: '<?php echo $uploadFolder.$fileData->filename; ?>'
                                   });

                                   playerInstance<?php echo $idx; ?>.onReady(function() {
                                    if(typeof $("#vdo<?php echo $idx; ?>").find("button").attr('onclick') == "undefined"){
                                        $("#vdo<?php echo $idx; ?>").find("button").attr('onclick','return false');
                                    }
                                    playerInstance<?php echo $idx; ?>.onPlay(function(callback) {
                                        console.log(callback);
                                    });
                                });

                            </script>
                            <!-- <button onclick='console.log(playerInstance<?php echo $idx; ?>.getState()); return false;'>getState()</button> -->
                            <?php
                            $idx++;
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="pdf_upload">
                <div class="row">
                    <?php //echo $form->labelEx($filePdf,'pdf'); ?>
                    <label>ไฟล์ประกอบบทเรียน (pdf)</label>
                    <div id="pdfqueue"></div>
                    <?php echo $form->fileField($filePdf,'pdf',array('id'=>'pdf','multiple'=>'true')); ?>
                    <!-- <input id="file_upload" name="file_upload" type="file" multiple="true" > -->
                    <!-- <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a> -->
                    <script type="text/javascript">
                        <?php $timestamp = time();?>
                        $(function() {
                            $('#pdf').uploadifive({
                                'auto'             : false,
                                    //'checkScript'      : 'check-exists.php',
                                    //                    'checkScript'      : '<?php //echo $this->createUrl("lesson/checkExists"); ?>//',
                                    'formData'         : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                                    },
                                    'queueID'          : 'pdfqueue',
                                    'uploadScript'     : '<?php echo $this->createUrl("lesson/uploadifivepdf"); ?>',
                                    'onAddQueueItem' : function(file){
                                                var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'pdf':
                                                        break;
                                                        default:
                                                        alert('Wrong filetype');
                                                        $('#pdf').uploadifive('cancel', file);
                                                        break;
                                                    }
                                    },
                                    'onQueueComplete' : function(file, data) {
                                                            //console.log(data);
                                                            $('#lesson-form').submit();
                                                            // if($('#docqueue .uploadifive-queue-item').length == 0) {
                                                            //     $('#lesson-form').submit();
                                                            // }else{
                                                            //     $('#doc').uploadifive('upload');
                                                            // }
                                                        }
                                                    });
                        });
                    </script>
                    <?php echo $form->error($filePdf,'pdf'); ?>
                </div>

                <div class="row">
                    <?php
                    $idx = 1;
                    $uploadFolder = Yii::app()->getUploadUrl('filepdf');
                    if(isset($file->filePdf)){
                        foreach($file->filePdf as $fileData){
                            ?>
                            <div class="row" style="padding-top:20px;">

                                <div id="filepdf<?php echo $idx; ?>">
                                    <a href="<?php echo $this->createUrl('downloadPdf',array('id' => $fileData->id)); ?>" target="_blank">
                                        <?php
                                        echo '<strong id="filenamepdftext'.$fileData->id.'">'.$fileData->file_name.'</strong>';
                                        ?>
                                    </a>
                                    <?php echo '<input id="filenamepdf'.$fileData->id.'" type="text" value="'.$fileData->file_name.'" style="display:none;" onblur="editNamePdf('.$fileData->id.');">'; ?>
                                    <?php //echo CHtml::link('<i></i>','', array('title'=>'แก้ไขชื่อ','id'=>'btnEditNamePdf'.$fileData->id,'class'=>'btn-action fa fa-pencil-square-o btn-danger','style'=>'z-index:1; background-color:black; cursor:pointer;','onclick'=>'$("#filenamepdftext'.$fileData->id.'").hide(); $("#filenamepdf'.$fileData->id.'").show(); $("#filenamepdf'.$fileData->id.'").focus(); $("#btnEditNamePdf'.$fileData->id.'").hide(); ')); ?>
                                    <?php echo CHtml::link('<i></i>','', array('title'=>'แก้ไขชื่อ','class'=>'btn-action fa fa-pencil-square-o btn-danger','style'=>'z-index:1; background-color:black; cursor:pointer;','href'=>$this->createUrl('filepdf/update',array('id'=>$fileData->id)),'target'=>'_blank')); ?>
                                    <?php //echo CHtml::link('<i></i>','', array('title'=>'ลบไฟล์','id'=>'btnSaveName'.$fileData->id,'class'=>'btn-action glyphicons ok_2 btn-danger','style'=>'z-index:1; background-color:black; cursor:pointer;','onclick'=>'$("#filenamepdftext'.$fileData->id.'").hide(); $("#filenamepdf'.$fileData->id.'").show();')); ?>
                                    <?php echo CHtml::link('<i></i>','', array('title'=>'ลบไฟล์','id'=>'btnSaveName'.$fileData->id,'class'=>'btn-action fa fa-times btn-danger remove_2','style'=>'z-index:1; background-color:black; cursor:pointer;','onclick'=>'if(confirm("คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร")){ deleteFilepdf("filepdf'.$idx.'","'.$fileData->id.'"); }')); ?>
                                </div>
                            </div>
                            <?php
                            $idx++;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="scorm_upload">
                    <div class="row">
                    <label>ไฟล์ประกอบบทเรียน (zip)</label>
                    <div id="scormqueue"></div>
                    <?php echo $form->fileField($fileScorm,'filename',array('id'=>'scorm','multiple'=>'true')); ?>
                    <!-- <input id="file_upload" name="file_upload" type="file" multiple="true" > -->
                    <!-- <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a> -->
                    <script type="text/javascript">
                        <?php $timestamp = time();?>
                        $(function() {
                            $('#scorm').uploadifive({
                                'auto'             : false,
                                    //'checkScript'      : 'check-exists.php',
                                    //                    'checkScript'      : '<?php //echo $this->createUrl("lesson/checkExists"); ?>//',
                                    'formData'         : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                                    },
                                    'queueID'          : 'scormqueue',
                                    'uploadScript'     : '<?php echo $this->createUrl("lesson/uploadifivescorm"); ?>',
                                    'onAddQueueItem' : function(file){
                                                var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'zip':
                                                        break;
                                                        default:
                                                        alert('Wrong filetype');
                                                        $('#scorm').uploadifive('cancel', file);
                                                        break;
                                                    }
                                    },
                                    'onQueueComplete' : function(file, data) {
                                                            // console.log(data);
                                                            // console.log(file);
                                                            if($('#docqueue .uploadifive-queue-item').length == 0) {
                                                                $('#lesson-form').submit();
                                                            }else{
                                                                $('#doc').uploadifive('upload');
                                                            }
                                                        }
                                                    });
                        });
                    </script>
                    <?php echo $form->error($fileScorm,'filename'); ?>
                </div>
                </div>

                <div class="ebook_upload">
                    <div class="row">
                    <label>ไฟล์ประกอบบทเรียน (zip)</label>
                    <div id="ebookqueue"></div>
                    <?php echo $form->fileField($fileebook,'filename',array('id'=>'ebook','multiple'=>'true')); ?>
                    <!-- <input id="file_upload" name="file_upload" type="file" multiple="true" > -->
                    <!-- <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a> -->
                    <script type="text/javascript">
                        <?php $timestamp = time();?>
                        $(function() {
                            $('#ebook').uploadifive({
                                'auto'             : false,
                                    //'checkScript'      : 'check-exists.php',
                                    //                    'checkScript'      : '<?php //echo $this->createUrl("lesson/checkExists"); ?>//',
                                    'formData'         : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                                    },
                                    'queueID'          : 'ebookqueue',
                                    'uploadScript'     : '<?php echo $this->createUrl("lesson/uploadifiveebook"); ?>',
                                    'onAddQueueItem' : function(file){
                                                var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'zip':
                                                        break;
                                                        default:
                                                        alert('Wrong filetype');
                                                        $('#ebook').uploadifive('cancel', file);
                                                        break;
                                                    }
                                    },
                                    'onQueueComplete' : function(file, data) {
                                                            // console.log(data);
                                                            // console.log(file);
                                                            if($('#docqueue .uploadifive-queue-item').length == 0) {
                                                                $('#lesson-form').submit();
                                                            }else{
                                                                $('#doc').uploadifive('upload');
                                                            }
                                                        }
                                                    });
                        });
                    </script>
                    <?php echo $form->error($fileebook,'filename'); ?>
                </div>
                </div>

                <div class="youtube_vdo">
                    <div class="row">
                        <p>Link Youtube (link เต็ม ไม่ใช่รูปย่อ)</p>
                    </div>
                    <?php if($lesson->isNewRecord){ ?>
                    <div id="div_youtube_0">
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="link_youtube[0]" onkeypress="check_key(this)" onblur="check_blur(this)">
                            </div>
                            <div class="col-md-5">
                                <input class="form-control" type="text" name="encredit_youtube[0]" placeholder="End credits">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-danger" onclick="del_youtube(0)"> ลบ</button>
                            </div>
                        </div>
                    </div>
                     <?php
                    }else{
                        foreach ($lesson->files as $key => $value) {
                            ?>
                            <div id="div_youtube_<?= $value->id ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="link_youtube_old[<?= $value->id ?>]" onkeypress="check_key(this)" onblur="check_blur(this)" value="<?= $value->filename ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" placeholder="End credits" name="encredit_youtube_old[<?= $value->id ?>]" value="<?= $value->encredit ?>">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger" onclick="del_youtube(<?= $value->id ?>)"> ลบ</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                     ?>
                    <div class="row" id="btn_add">
                        <button type="button" class="btn btn-primary" onclick="add_youtube()" style="background: #1676ec; border: 1px solid #2265ca;"> เพิ่ม Youtube</button>
                    </div>
                    <script type="text/javascript">
                        var run_num = 1;

                        function del_youtube(num){
                            $("#div_youtube_"+num).remove();
                        }
                        
                        function add_youtube(){
                            var text_append = '<div id="div_youtube_'+run_num+'">';
                            text_append += '<div class="row">';
                            text_append += '<div class="col-md-6">';
                            text_append += '<input class="form-control" type="text" name="link_youtube['+run_num+']">';
                            text_append += '</div>';
                            text_append += '<div class="col-md-5">';
                            text_append += '<input class="form-control" type="text" name="encredit_youtube['+run_num+']" placeholder="End credits">';
                            text_append += '</div>';
                            text_append += '<div class="col-md-1">';
                            text_append += '<button class="btn btn-danger" onclick="del_youtube('+run_num+')"> ลบ</button>';
                            text_append += '</div>';
                            text_append += '</div>';
                            text_append += '</div>';
                            $(text_append).insertBefore($('#btn_add'));
                            run_num++;
                        }

                        function check_key(val){
                            var input_val = $(val).val();
                            var check = input_val.search("v=");
                            if(check < 0 && input_val != ""){
                                alert("Link Youtube ไม่ถูกต้อง");
                                $(val).val("");
                            }
                        }

                        function check_blur(val){
                            var input_val = $(val).val();
                            var check = input_val.search("v=");
                            if(check < 0 && input_val != ""){
                                alert("Link Youtube ไม่ถูกต้อง");
                                $(val).val("");
                            }
                        }


                    </script>
                </div>





                <br>
                <br>

            <div class="row" id="file_doc">
                <?php echo $form->labelEx($fileDoc,'doc'); ?>
                <div id="docqueue"></div>
                <?php echo $form->fileField($fileDoc,'doc',array('id'=>'doc','multiple'=>'true')); ?>
                <!-- <input id="file_upload" name="file_upload" type="file" multiple="true" > -->
                <!-- <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a> -->
                <script type="text/javascript">
                    <?php $timestamp = time();?>
                    $(function() {
                        $('#doc').uploadifive({
                            'auto'             : false,
                                    //'checkScript'      : 'check-exists.php',
                                    //                    'checkScript'      : '<?php //echo $this->createUrl("lesson/checkExists"); ?>//',
                                    'formData'         : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                                    },
                                    'queueID'          : 'docqueue',
                                    'uploadScript'     : '<?php echo $this->createUrl("lesson/uploadifivedoc"); ?>',
                                    'onAddQueueItem' : function(file){
                                                var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'pdf':
                                                        case 'docx':
                                                        case 'pptx':
                                                        break;
                                                        default:
                                                        alert('Wrong filetype');
                                                        $('#doc').uploadifive('cancel', file);
                                                        break;
                                                    }
                                    },
                                    'onQueueComplete' : function(file, data) {
                                                            //console.log(data);
                                                            if($('#pdfqueue .uploadifive-queue-item').length == 0) {
                                                                $('#lesson-form').submit();
                                                            }else{
                                                                $('#pdf').uploadifive('upload');
                                                            }
                                                            // if($('#scormqueue .uploadifive-queue-item').length == 0) {
                                                            //     $('#lesson-form').submit();
                                                            // }else{
                                                            //     $('#scorm').uploadifive('upload');
                                                            // }
                                                            // if($('#queue .uploadifive-queue-item').length == 0) {
                                                            //     $('#lesson-form').submit();
                                                            // }else{
                                                            //     $('#filename').uploadifive('upload');
                                                            // }
                                                            // $('#lesson-form').submit();
                                                        }
                                                    });
                    });
                </script>
                <?php echo $form->error($fileDoc,'doc'); ?>
            </div>

            <br>
            <?php
    //var_dump($file->files);
            $idx = 1;
            $uploadFolder = Yii::app()->getUploadUrl('filedoc');
            if(isset($file->fileDocs)){
                foreach($file->fileDocs as $fileData){
                    ?>
                    <div class="row" style="padding-top:20px;">

                        <div id="filedoc<?php echo $idx; ?>">
                            <a href="<?php echo $this->createUrl('download',array('id' => $fileData->id)); ?>" target="_blank">
                                <?php
                                echo '<strong id="filenamedoctext'.$fileData->id.'">'.$fileData->file_name.'</strong>';
                                ?>
                            </a>
                            <?php echo '<input id="filenamedoc'.$fileData->id.'" type="text" value="'.$fileData->file_name.'" style="display:none;" onblur="editName('.$fileData->id.');">'; ?>
                            <?php echo CHtml::link('<i></i>','', array('title'=>'แก้ไขชื่อ','id'=>'btnEditName'.$fileData->id,'class'=>'btn-action glyphicons pencil btn-danger','style'=>'z-index:1; background-color:white; cursor:pointer;','onclick'=>'$("#filenamedoctext'.$fileData->id.'").hide(); $("#filenamedoc'.$fileData->id.'").show(); $("#filenamedoc'.$fileData->id.'").focus(); $("#btnEditName'.$fileData->id.'").hide(); ')); ?>
                            <?php //echo CHtml::link('<i></i>','', array('title'=>'ลบไฟล์','id'=>'btnSaveName'.$fileData->id,'class'=>'btn-action glyphicons ok_2 btn-danger','style'=>'z-index:1; background-color:white; cursor:pointer;','onclick'=>'$("#filenamedoctext'.$fileData->id.'").hide(); $("#filenamedoc'.$fileData->id.'").show();')); ?>
                            <?php echo CHtml::link('<i></i>','', array('title'=>'ลบไฟล์','id'=>'btnSaveName'.$fileData->id,'class'=>'btn-action glyphicons btn-danger remove_2','style'=>'z-index:1; background-color:white; cursor:pointer;','onclick'=>'if(confirm("คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร")){ deleteFileDoc("filedoc'.$idx.'","'.$fileData->id.'"); }')); ?>
                        </div>
                    </div>
                    <?php
                    $idx++;
                }
            }
            ?>
            <br>
            <?php } ?>

            <?php 
            if($state){
            $lesson = $lessonChildren; 
                }
            ?>


            <div class="row">
            <?php echo $form->labelEx($lesson,'status'); ?>
            <?php echo $form->checkBox($lesson,'status',array(
                'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n",'disabled' => $lang_id == 1 ? '':'disabled'
            )); ?>
            <?php echo $form->error($lesson,'status'); ?>
            </div>

            <div class="row">
            <?php echo $form->labelEx($lesson,'enablefacedetect'); ?>
            <?php echo $form->checkBox($lesson,'enablefacedetect',array(
                'id'=>"enableface",'data-toggle'=> 'toggle','value'=>1, 'uncheckValue'=>0,'disabled' => $lang_id == 1 ? '':'disabled'
            )); ?>
            <?php echo $form->error($lesson,'enablefacedetect'); ?>
            </div>

             <div class="row" id="intervalFacedetect" style="display: none;">
            <?php echo $form->labelEx($lesson,'intervalfacedetect'); ?>
            <?php echo $form->numberField($lesson, 'intervalfacedetect') ?> นาที
            <?php echo $form->error($lesson,'intervalfacedetect'); ?>
            </div>

            <div class="row" id="verifyFaceperiod" style="display: none;">
            <?php echo $form->labelEx($lesson,'verifyfaceperiod'); ?>
            <?php echo $form->numberField($lesson, 'verifyfaceperiod',array('min'=>"2",'maxlength'=>255,'oninput'=>"this.value = Math.abs(this.value)")) ?> นาที
            <?php echo $form->error($lesson,'verifyfaceperiod'); ?>
            </div>

             <div class="row" id="popup_detail" style="display: none;">
            <?php echo $form->labelEx($lesson,'popup_detail'); ?>
            <?php echo $form->textArea($lesson,'popup_detail',array('maxlength' => 500,'rows'=>6, 'cols'=>100,'style'=>"width: 600px; height: 150px;")); ?>
            <?php echo $form->error($lesson,'popup_detail'); ?>
            </div>




            <div class="row">
                <!-- <div class="col-md-12"> -->
                <?php
                if(isset($imageShow)){
                    echo CHtml::image(Yush::getUrl($lesson, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
                        "class"=>"thumbnail"
                    ));
                }
                ?>
                <!-- </div> -->
            </div>
            <br>
            <div class="row">
                <?php echo $form->labelEx($lesson,'image'); ?>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($lesson, 'image'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
                <?php echo $form->error($lesson,'image'); ?>
            </div>

            <div class="row">
                <font color="#990000">
                    <?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 175x130(แนวนอน) หรือ ขนาด 175x(xxx) (แนวยาว)
                </font>
            </div>
            <br><br>

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

<script>
    $(function () {
       <?php if($lesson->enablefacedetect == 1 ){ ?>
          $('#popup_detail').show();
          $('#intervalFacedetect').show();
          $('#verifyFaceperiod').show();
       <?php } ?>

        $('#enableface').change(function(){
            var chk = $(this).is(":checked");
            checkswitch(chk);
        });


        function checkswitch(chk){
            if (chk == true) {
                $('#popup_detail').show();
                $('#intervalFacedetect').show();
                $('#verifyFaceperiod').show();
            }else{
                $('#intervalFacedetect').hide();
                $('#popup_detail').hide();
                $('#verifyFaceperiod').hide();
            }
        }

        init_tinymce();
        <?php

        if($lesson->isNewRecord){
            ?>
            $('.pdf_upload').hide();
            $('.audio_upload').hide();
            $('.scorm_upload').hide();
            $('.youtube_vdo').hide();
            $('.ebook_upload').hide();

            <?php
        } else {
            if($lesson->type == 'vdo'){
                ?>
                $('.pdf_upload').hide();
                $('.scorm_upload').hide();
                $('.audio_upload').hide();
                $('.youtube_vdo').hide();
                $('.ebook_upload').hide();

                <?php
            } else if($lesson->type == 'pdf'){
                ?>
                $('.scorm_upload').hide();
                $('.vdo_upload').hide();
                $('.audio_upload').hide();
                $('.youtube_vdo').hide();
                $('.ebook_upload').hide();

                <?php
            } else if($lesson->type == 'scorm'){
                ?>
                $('.pdf_upload').hide();
                $('.vdo_upload').hide();
                $('.audio_upload').hide();
                $('.youtube_vdo').hide();
                $('.ebook_upload').hide();

                <?php
            } else if($lesson->type == 'audio'){
                ?>
                $('.pdf_upload').hide();
                $('.vdo_upload').hide();
                $('.scorm_upload').hide();
                $('.youtube_vdo').hide();
                $('.ebook_upload').hide();

                <?php
            }   else if($lesson->type == 'youtube'){
                ?>
                $('.pdf_upload').hide();
                $('.vdo_upload').hide();
                $('.scorm_upload').hide();
                $('.audio_upload').hide();
                $('#file_doc').hide();
                $('.youtube_vdo').show();
                $('.ebook_upload').hide();

                <?php
            } else if($lesson->type == 'ebook'){
                ?>
                $('.pdf_upload').hide();
                $('.vdo_upload').hide();
                $('.scorm_upload').hide();
                $('.audio_upload').hide();
                $('.youtube_vdo').hide();
                $('.ebook_upload').show();
                <?php
            }   
        }
        ?>
    });

    $('#Lesson_type').on('change', function() {
      if(this.value == 'vdo'){
        $('.pdf_upload').hide();
        $('.scorm_upload').hide();
        $('.audio_upload').hide();
        $('.vdo_upload').show();
        $('.youtube_vdo').hide();
        $('.ebook_upload').hide();

    } else if(this.value == 'pdf'){
        $('.vdo_upload').hide();
        $('.scorm_upload').hide();
        $('.audio_upload').hide();
        $('.pdf_upload').show();
        $('.youtube_vdo').hide();
        $('.ebook_upload').hide();

    } else if(this.value == 'scorm'){
        $('.pdf_upload').hide();
        $('.vdo_upload').hide();
        $('.audio_upload').hide();
        $('.scorm_upload').show();
        $('.youtube_vdo').hide();
        $('.ebook_upload').hide();

    } else if(this.value == 'audio'){
        $('.pdf_upload').hide();
        $('.vdo_upload').hide();
        $('.scorm_upload').hide();
        $('.audio_upload').show();
        $('.youtube_vdo').hide();
        $('.ebook_upload').hide();

    } else if(this.value == 'youtube'){
        $('.pdf_upload').hide();
        $('.vdo_upload').hide();
        $('.scorm_upload').hide();
        $('.audio_upload').hide();
        $('#file_doc').hide();
        $('.youtube_vdo').show();
        $('.ebook_upload').hide();

    } else if(this.value == 'ebook'){
        $('.pdf_upload').hide();
        $('.vdo_upload').hide();
        $('.scorm_upload').hide();
        $('.audio_upload').hide();
        $('.youtube_vdo').hide();
        $('.ebook_upload').show();

    } 
});

</script>
<script type="text/javascript">
   $('.default_datetimepicker').datetimepicker({
    datepicker:false,
    format:'H:i'
});
   // $('#default_datetimepicker').datetimepicker({step:10});
</script>  