<script src="<?php echo $this->assetsBase;; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase;; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="MOvEyr0DQm0f2juUUgZ+oi7ciSsIU3Ekd7MDgQ==";</script>

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

#docqueue {
    border: 1px solid #E5E5E5;
    height: 177px;
    overflow: auto;
    margin-bottom: 10px;
    padding: 0 3px 3px;
    width: 600px;
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

   

    function deleteFileDoc(filedoc_id,file_id){
        $.get("<?php echo $this->createUrl('LessonMsTeams/deleteFileDoc'); ?>",{id:file_id},function(data){
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

        $.get("<?php echo $this->createUrl('LessonMsTeams/editName'); ?>",{id:filedoc_id,name:name},function(data){

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

                        // $courseAll = CHtml::listData(MsTeams::model()->findAll('active="y" and lang_id = '.$lang_id), 'ms_teams_id', 'name_ms_teams');

                        ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
                        // $check_user = User::model()->findByPk(Yii::app()->user->id);
                        // $group = $check_user->group;
                        // $group_arr = json_decode($group);
                        // $see_all = 2;
                        // if(in_array("1", $group_arr) || in_array("7", $group_arr)){
                        //     $see_all = 1;
                        // }
                        //////////////////
                        $criteria = new CDbCriteria;
                        $criteria->compare('active','y');
                        // if($see_all != 1){
                        //     $criteria->compare('create_by',Yii::app()->user->id);
                        // }
                        // else{
                        //     $courseAll = CHtml::listData(MsTeams::model()->findAll('active="y" '), 'id', 'name_ms_teams');
                        // }
                        $modelUser = Users::model()->findByPk(Yii::app()->user->id);
                        $group = json_decode($modelUser->group);
                        if (!in_array(1, $group)){
                            $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
                            $criteria->addInCondition('create_by', $groupUser);	
                        }
                        $criteria->compare('type_ms_teams',1);
                        $criteria->order = 'create_date DESC';
                        $courseAll = CHtml::listData(MsTeams::model()->findAll($criteria), 'id', 'name_ms_teams');

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
                            $attCateAmount = array('size'=>60,'min'=>"0",'maxlength'=>255,'class'=>'span8','oninput'=>"this.value = Math.abs(this.value)");
                            $attTime = array('class' => 'default_datetimepicker');
                            $dayCheck = 'onclick="return true;"';
                            $state = false;
                            $attSearch = array("class"=>"span8",'disable_search' => false);
                        }else{ 
                            $flag = false;
                        $lessonChildren = $lesson; //Lesson parent_id not 0
                        $lesson = LessonMsTeams::model()->FindByPk($parent_id);
                        $rootLesson = $lesson;
                        $conditions = "ms_teams_id = ".$lesson->msteams->id;
                        $courseCh = MsTeams::model()->find("id = '".$lesson->msteams->id."'");
                        $courseAll = CHtml::listData(MsTeams::model()->findAll("id = ".$courseCh->id), 'id', 'name_ms_teams');
                        // $courseAll = CHtml::listData(MsTeams::model()->findAll("ms_teams_id = ".$lesson->msteams->id), 'ms_teams_id', 'name_ms_teams');
                        $lesson->title = "";
                        $lesson->description = "";
                        $lesson->content = "";
                        $att = array("class"=>"span8",'readonly' => true);
                        $attCateAmount = array('size'=>60,'maxlength'=>255,'class'=>'span8','readonly' => true);
                        $attTime = array('class' => 'default_datetimepicker','readonly' => true);
                        $dayCheck = 'onclick="return false;"';
                        $state = true;
                        $attSearch = array("class"=>"span8",'disable_search' => true);
                    } 
                    foreach ($courseAll as $keyCourse => $course) {
                        $courseModel = MsTeams::model()->findByPk($keyCourse);
                        if($courseModel){
                            $courseAll[$keyCourse] = $courseModel->name_ms_teams." ( ".Helpers::lib()->DateThaiNewNoTime($courseModel->start_date)." - ".Helpers::lib()->DateThaiNewNoTime($courseModel->end_date)." )";
                        }
                    }
                    ?>
                   
                    <?php (empty($model->ms_teams_id)? $select = '' : $select = $model->ms_teams_id); ?>
                    <div class="row">
                        <?php echo $form->labelEx($lesson,'ms_teams_id'); ?>
                        <!-- <?php echo Chosen::dropDownList('ms_teams_id', $select, $courseAll, $attSearch); ?> -->
                        <?php echo Chosen::activeDropDownList($lesson, 'ms_teams_id', $courseAll, $attSearch); ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($lesson,'ms_teams_id'); ?>
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

                     <?php if($state){
                        $lesson = LessonMsTeams::model()->findByPk($parent_id);
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

            <br>

            <?php 
            if($state){
            $lesson = $lessonChildren; 
                }
            ?>
            <div class="row">
            <?php echo $form->labelEx($lesson,'status'); ?>
            <?php echo $form->checkBox($lesson,'status',array(
                'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
            )); ?>
            <?php echo $form->error($lesson,'status'); ?>
            </div>
            
            <div class="row">
            <?php echo $form->labelEx($lesson,'enablefacedetect'); ?>
            <?php //echo $form->checkBox($lesson,'enablefacedetect',array(
                //'id'=>"enableface",'data-toggle'=> 'toggle','value'=>1, 'uncheckValue'=>0
            //)); ?>
            <?php //echo $form->error($lesson,'enablefacedetect'); ?>
            </div>


            <br>


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
                                    'uploadScript'     : '<?php echo $this->createUrl("LessonMsTeams/uploadifivedoc"); ?>',
                                    'onAddQueueItem' : function(file){
                                                var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'pdf':
                                                        case 'doc':
                                                        case 'docx':
                                                        case 'ppt':
                                                        case 'pptx':
                                                        case 'xlsx':
                                                        case 'xls':
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
            $uploadFolder = Yii::app()->getUploadUrl('filedoc_msteams');
            if($lesson->id != null){
                $filedoc_old = FileDocMsTeams::model()->findAll('active="y" and lesson_teams_id = '.$lesson->id);
            }
            if(isset($filedoc_old)){
                foreach($filedoc_old as $fileData){
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

            <div class="row buttons">
                <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','onclick'=>"return upload();"),'<i></i>บันทึกข้อมูล');?>
            </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>
</div>
<!-- END innerLR -->
<script type="text/javascript">
   $('.default_datetimepicker').datetimepicker({
    datepicker:false,
    format:'H:i'
});
   // $('#default_datetimepicker').datetimepicker({step:10});
</script>  