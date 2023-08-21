<?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
    	'homeLink'=>CHtml::link('หน้าแรก', array('/site/index')),
        'links'=>array_merge(
            $model->getBreadcrumbs(true),
            array('แก้ไข')
        ),
    ));
?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'thread-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
	),
    )); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'subject'); ?>
            <?php echo $form->textField($model,'subject',array('class'=>'span7')); ?>
            <?php echo $form->error($model,'subject'); ?>
        </div>

        <div class="row rememberMe">
            <?php echo $form->checkBox($model,'is_sticky',array('uncheckValue'=>0)); ?>
            <?php echo $form->labelEx($model,'is_sticky'); ?>
            <?php // echo $form->error($model,'lockthread'); ?>
        </div>

        <div class="row rememberMe">
            <?php echo $form->checkBox($model,'is_locked',array('uncheckValue'=>0)); ?>
            <?php echo $form->labelEx($model,'is_locked'); ?>
            <?php // echo $form->error($model,'lockthread'); ?>
        </div>

    <div class="row submit">
    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary'),'<i class="icon-check"></i> ยันยันการเปลี่ยนแปลง');?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
