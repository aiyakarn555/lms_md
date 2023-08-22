<script src="<?php echo $this->assetsBase; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key = "J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<script type="text/javascript">

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
                        <i></i><?php echo $formtext; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <?php
                $form = $this->beginWidget('AActiveForm', array(
                    'id' => 'Category-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>
                <?php 
                $lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
                $parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
                 ?>



                <p class="note">ค่าที่มี <?php echo $this->NotEmpty(); ?> จำเป็นต้องใส่ให้ครบ</p>
                
                <div class="row">
                    <?php echo $form->labelEx($model, 'dty_id'); ?>
                    <?php echo $this->listDocShow($model, 'dty_id','span8',$lang_id,$parent_id); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'dty_id'); ?>
                </div>
                
                <div class="row">
                    <?php echo $form->labelEx($model, 'dow_name'); ?>
                    <?php echo $form->textField($model, 'dow_name', array('size' => 60, 'maxlength' => 250, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'dow_name'); ?>
                </div>
                
                <div class="row">
                    <?php echo $form->labelEx($model, 'dow_detail'); ?>
                    <?php echo $form->textArea($model, 'dow_detail', array('rows' => 6, 'cols' => 50, 'class' => 'span8 tinymce')); ?>
                    <?php echo $form->error($model, 'dow_detail'); ?>
                </div>

                <br>

                <div class="row">
                    <?php echo $form->labelEx($model, 'dow_address'); ?>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-append">
                            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span>
                                </div>
                                    <span class="btn btn-default btn-file"><span class="fileupload-new">    Select file</span>
                                            <?php echo $form->fileField($model, 'dow_address', array('id' => 'wizard-picture')); ?>
                                    <span class="fileupload-exists">Change</span>
                                            <?php echo $form->fileField($model, 'dow_address'); ?>
                                    </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'dow_address'); ?>
                </div>
                <br>
                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2', 'onclick' => "return upload();"), '<i></i>บันทึกข้อมูล'); ?>
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
        <?php if(Yii::app()->controller->action->id == 'update' && $lang_id !=2){ ?>
                <?php  $doc = Document::model()->findByAttributes(array('dow_id'=> $parent_id,'active'=>'1'));  ?>
                $('#DocumentType_dty_id').val(<?= $doc->dty_id ?>).trigger('change');
        <?php } ?>


    });

   
   

</script>
