<?php
$this->widget('zii.widgets.CBreadcrumbs', array('links'=>array(
    'Forum'=>array('/forum'),
    $model->name=>array('/forum/user/view', 'id'=>$model->id),
    'Update',
)));
?>
<div class="bs-example">
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'forumuser-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
	),
    )); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'signature'); ?>
            <?php echo $form->textArea($model,'signature', array('rows'=>5, 'cols'=>70,'style'=>'width:100%')); ?>
            <?php echo $form->error($model,'signature'); ?>
        </div>

    <div class="row submit">
    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary'),'<i class="icon-check"></i> บันทึก');?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
</div>