<?php
/* @var $this MailgroupController */
/* @var $model Mailgroup */
/* @var $form CActiveForm */

?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/distbootstrap/css/bootstrap.css">

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
                    'id' => 'mailgroup-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                )); ?>

                <p class="note">ค่าที่มี <?php echo $this->NotEmpty(); ?> จำเป็นต้องใส่ให้ครบ</p>

                <?php echo $form->errorSummary($model); ?>

                <div>
                    <?php echo $form->labelEx($model, 'group_name'); ?>
                    <?php echo $form->textField($model, 'group_name', array('maxlength' => 255, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'group_name'); ?>
                </div>

                <div>

                    <?php
                    $this->widget('ext.DualListBox.DualListBox', array(
                        'model' => $mailuser,
                        'attribute' => 'user_id',
                        'nametitle' => 'Email',
                        'data' => $personlist,  // it will be displyed in available side
                        'selecteddata' => $paidpersons, // it will be displayed in selected side
                        'data_id' => 'id',
                        'data_value' => 'email',
                        'lngOptions' => array(
                            'search_placeholder' => 'ค้นหา',
                            'showing' => ' - Showing',
                            'available' => 'All',
                            'selected' => 'Selected'
                        )
                    ));
                    ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'mail_title'); ?>
                    <?php echo $form->textField($model, 'mail_title', array('size' => 60, 'maxlength' => 250, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'mail_title'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'mail_detail'); ?>
                    <?php echo $form->textArea($model, 'mail_detail', array('rows' => 6, 'cols' => 50, 'class' => 'span8 tinymce')); ?>
                    <?php echo $this->NotEmpty(); ?>
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
                                array(
                                    'class'=>'btn btn-danger btn-mini','confirm'=>'Are you sure?' )
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
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2'), '<i></i>บันทึกข้อมูลและส่งอีเมล์'); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>


<script>
    $(function () {
        init_tinymce();
    });
</script>



