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
                <p class="note">ค่าที่มี <?php echo $this->NotEmpty(); ?> จำเป็นต้องใส่ให้ครบ</p>

                <div class="row">
                	<div class="col-md-8">
                    <?php echo $form->labelEx($model, 'library_type_name'); ?>
                    <?php echo $form->textField($model, 'library_type_name', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'library_type_name'); ?>
                    </div>
                </div>

                <div class="row">
                	<div class="col-md-8">
                    <?php echo $form->labelEx($model, 'library_type_name_en'); ?>
                    <?php echo $form->textField($model, 'library_type_name_en', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'library_type_name_en'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <?php $arr_cate = array('1'=>'Media', '2'=>'Document'); ?>
                        <?php echo $form->labelEx($model, 'library_cate'); ?>
                        <?php echo $form->radioButtonList($model,'library_cate',$arr_cate, array('separator'=>' ', 'labelOptions'=>array('style'=>'display:inline; padding-right: 40px;'))); ?>
                        <?php echo $form->error($model, 'library_cate'); ?>
                    </div>
                </div>

               <div class="row">
                	<div class="col-md-8">
                    <?php echo $form->labelEx($model, 'library_type'); ?>
                    <?php echo $form->textField($model, 'library_type', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'library_type'); ?>
                    </div>
                </div> 
                
                
                <br>
                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2', 'onclick' => "return upload();"), '<i></i>บันทึกข้อมูล'); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        init_tinymce();
    });
</script>

