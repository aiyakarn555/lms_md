


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
                    'id' => 'MainMenu-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>
                <!-- <div class="row" style="display: none;">
                    <?php echo $form->labelEx($model, 'lang_id'); ?>
                    <?php echo $this->listlanguageShow($model, 'lang_id','span8'); ?>
                    <?php echo $form->textField($model, 'lang_id'); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'lang_id'); ?>
                </div>
                
                <div class="row" id="parent_id" style="display: none;">
                    <?php echo $form->labelEx($model, 'parent_id'); ?>
                    <?php echo $this->listParentMainmenuShow($model, 'parent_id','span8'); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'parent_id'); ?>
                </div> -->

                <div class="row">
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 250, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <?php if(!isset($_GET['parent_id'])){ ?>
                <div class="row" id="url">
                    <?php echo $form->labelEx($model, 'url'); ?>
                    <?php echo $form->textField($model, 'url', array('size' => 60, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'url'); ?>
                </div>
               <?php } ?>

                <div class="row">
                    <?php echo $form->labelEx($model,'status'); ?>
                    <!-- <div class="toggle-button" data-toggleButton-style-enabled="success"> -->
                        <?php echo $form->checkBox($model,'status',array(
                            'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
                        )); ?>
                    <!-- </div> -->
                    <?php echo $form->error($model,'status'); ?>
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
        // getParentList(1);
    });

    // function getParentList(id){
    //     if(id != '1'){
    //         $("#url").css('display','none');
    //         $("#parent_id").css('display','block');
    //         $("#MainMenu_parent_id").attr('disabled',false);
    //     } else {
    //         $("#url").css('display','block');
    //         $("#parent_id").css('display','none');
    //         $("#MainMenu_parent_id").attr('disabled',true);
    //     }
    // }
</script>
