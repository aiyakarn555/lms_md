<script src="<?php echo Yii::app()->baseUrl; ?>/js/tinymce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('textarea.tinymce').tinymce({
            // Location of TinyMCE script
            script_url: '<?php echo Yii::app()->baseUrl; ?>/js/tinymce/tiny_mce.js',
            // General options
            mode: "textareas",
            theme: "advanced",
            plugins: "youtubeIframe,openmanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

            // Theme options
            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,youtubeIframe,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true,

            relative_urls: false,

            //FILE UPLOAD MODS
            file_browser_callback: "openmanager",
            open_manager_upload_path: '../../../../../uploads/',

            // Example content CSS (should be your site CSS)
            content_css: "<?php echo Yii::app()->baseUrl; ?>/css/content.css",

            // Drop lists for link/image/media/template dialogs
            template_external_list_url: "lists/template_list.js",
            external_link_list_url: "lists/link_list.js",
            external_image_list_url: "lists/image_list.js",
            media_external_list_url: "lists/media_list.js",

            theme_advanced_resizing: true,
            theme_advanced_resize_horizontal: true,
            theme_advanced_resizing_max_width: '500',
            theme_advanced_resizing_min_height: '600',
            width: '500',
            height: '600',
            // Style formats
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ],
            // Replace values for the template plugin
            template_replace_values: {
                username: "Some User",
                staffid: "991234"
            }
        });
    });
</script>
<!-- innerLR -->
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i><?php echo $formtext; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <?php $form = $this->beginWidget('AActiveForm', array(
                    'id' => 'maildetail-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                )); ?>
                <p class="note">ค่าที่มี <?php echo $this->NotEmpty(); ?> จำเป็นต้องใส่ให้ครบ</p>
                <div class="row">
                    <?php echo $form->labelEx($model, 'mail_title'); ?>
                    <?php echo $form->textField($model, 'mail_title', array('size' => 60, 'maxlength' => 250, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'mail_title'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'mail_detail'); ?>
                    <?php echo $form->textArea($model, 'mail_detail', array('rows' => 6, 'cols' => 50, 'class' => 'span8 tinymce')); ?>
                    <?php echo $form->error($model, 'mail_detail'); ?>
                </div>
                <div class="row">
                    <label class="span12 control-label">ไฟล์แนบ</label>
                    <?php
                    $path = Yii::app()->request->baseUrl . '/../uploads/filemail/';
                    $i=0;
                    foreach ($model->mailfile as $key => $value) {
                        $i++;
                        ?>
                        <div class="span2" align="center" id="req_res<?=$i?>">
                            <a href="<?=$path.$value->file_name;?>" class="btn">
                                <?= Helpers::lib()->chk_type_img($path . $value->file_name, $value->file_type); ?>
                            </a>
                            <a href="<?=$path.$value->file_name;?>" class="btn btn-primary btn-mini" download="<?=$path.$value->file_name;?>">Download</a>
                            <?php
                            echo CHtml::ajaxLink(
                                'Delete',          // the link body (it will NOT be HTML-encoded.)
                                array('maildetail/delete_file'), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
                                array(
                                    'type'=>'POST',
                                    'data'=>array('fid'=>$value->id),
                                    'success'=>'function(html){
                                                 $("#req_res'.$i.'").toggle();
                                    }'
                                ),
                                array('class'=>'btn btn-danger btn-mini','confirm'=>'Are you sure?' //Confirmation)
                            );
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="span12">
                        <?php
                        $this->widget('CMultiFileUpload', array(
                            //'model'=>$model_DbFileLab,
                            'name' => 'file_name',
                            'accept' => 'jpg|gif|png|doc|xls|docx|xlsx|pdf|ppt|pptx',
                            'denied' => 'File is not allowed',
                            'max' => 10, // max 10 files
                        ));
                        ?>
                        <div>แนบไฟล์ละไม่เกิน 5 MB สูงสุดไม่เกิน 10 ไฟล์</div>
                    </div>
                </div>

                <br>
                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2'), '<i></i>บันทึกข้อมูล'); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>
<!-- END innerLR -->
