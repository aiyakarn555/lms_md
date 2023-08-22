<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/tinymce/jquery.tinymce.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/../js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<script type="text/javascript">
function upload()
{
    var file = $('#Lesson_image').val();
    var exts = ['jpg','gif','png'];
    if ( file ) {
    var get_ext = file.split('.');
    get_ext = get_ext.reverse();
        if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){

            if($('#queue .uploadifive-queue-item').length == 0){
                return true;
            }else{
                $('#filename').uploadifive('upload');
                return false;
            }

        } else {
            $('#Lesson_image_em_').removeAttr('style').html("<p class='error help-block'><span class='label label-important'> ไม่สามารถอัพโหลดได้ ไฟล์ที่สามารถอัพโหลดได้จะต้องเป็น: jpg, gif, png.</span></p>");
            return false;
        }
    }
    else
    {
        if($('#queue .uploadifive-queue-item').length == 0){
            return true;
        }else{
            $('#filename').uploadifive('upload');
            return false;
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

$().ready(function() {
    $('textarea.tinymce').tinymce({
    // Location of TinyMCE script
        script_url : '<?php echo Yii::app()->baseUrl; ?>/js/tinymce/tiny_mce.js',
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "youtubeIframe,openmanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,youtubeIframe,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        relative_urls: false,

        //FILE UPLOAD MODS
        file_browser_callback: "openmanager",
        open_manager_upload_path: '../../../../../uploads/',

        // Example content CSS (should be your site CSS)
        //content_css : "<?php echo Yii::app()->baseUrl; ?>/css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        theme_advanced_resizing : false,
        theme_advanced_resize_horizontal: false,
        theme_advanced_resizing_max_width: '500',
        theme_advanced_resizing_min_height: '500',
        width: '500',
        height: '500',

        // Style formats
        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

        // Replace values for the template plugin
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        }
    });
});
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

    <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
    <?php

        $courseAll = array();
        //$course_personal = array();


        $courseAll = CHtml::listData(CourseOnline::model()->findAll(array('condition'=>'courseonline.active="y"')), 'course_id', 'CoursetitleConcat');



        //$courseAll = CMap::mergeArray($course_student, $course_personal);

    ?>
    <div class="row">
        <?php echo $form->labelEx($lesson,'course_id'); ?>
        <?php echo $form->dropDownList($lesson,'course_id', $courseAll, array('empty'=>'-- กรุณาเลือกหลักสูตร --','class'=>'span8')); ?>
        <?php echo $this->NotEmpty();?>
        <?php echo $form->error($lesson,'course_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($lesson,'title'); ?>
        <?php echo $form->textField($lesson,'title',array('size'=>60,'maxlength'=>80,'class'=>'span8')); ?>
        <?php echo $this->NotEmpty();?>
        <?php echo $form->error($lesson,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($lesson,'description'); ?>
        <?php echo $form->textArea($lesson,'description',array('size'=>60,'maxlength'=>255,'class'=>'span8')); ?>
        <?php echo $this->NotEmpty();?>
        <?php echo $form->error($lesson,'description'); ?>
    </div>
    <div class="row">
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
    </div>
    <div class="row">
        <?php echo $form->labelEx($lesson,'cate_amount'); ?>
        <?php echo $form->textField($lesson,'cate_amount',array('size'=>60,'maxlength'=>255,'class'=>'span8')); ?> ครั้ง
        <?php echo $this->NotEmpty();?>
        <?php echo $form->error($lesson,'cate_amount'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($lesson,'time_test'); ?>
        <?php echo $form->textField($lesson,'time_test',array('size'=>60,'maxlength'=>255,'class'=>'span8')); ?> นาที
        <?php echo $this->NotEmpty();?>
        <?php echo $form->error($lesson,'time_test'); ?>
    </div>
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
                    'onQueueComplete' : function(file, data) {
                        //console.log(data);
                        $('#lesson-form').submit();
                     }
                });
            });
        </script>
        <?php echo $form->error($file,'filename'); ?>
    </div>

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
    <br>
    <div class="row">
        <?php echo $form->labelEx($lesson,'content'); ?>
        <?php echo $form->textArea($lesson,'content',array('class'=>'tinymce')); ?>
        <?php echo $form->error($lesson,'content'); ?>
        <?php //$this->widget('application.extensions.tinymce.ETinyMce', array('name'=>'html')); ?>
    </div>
    <br>
    <div class="row">
    <?php
    if(isset($imageShow)){
        echo CHtml::image(Yush::getUrl($lesson, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
            "class"=>"thumbnail"
        ));
    }
    ?>
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
