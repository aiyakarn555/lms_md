<?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
    	'homeLink'=>CHtml::link('หน้าแรก', array('/site/index')),
        'links'=>array_merge(
            $model->thread->getBreadcrumbs(true),
            array('แก้ไขกระทู้')
        ),
    ));
?>

<div class="bs-example">

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'post-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
	),
    )); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'content'); ?>
            <?php echo $form->textArea($model,'content', array('rows'=>10, 'cols'=>70,'style'=>'width:100%;')); ?>
            <?php echo $form->error($model,'content'); ?>
        </div>

    <div class="row submit">
    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary'),'<i class="icon-check"></i> ยืนยัน');?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

</div>