<?php
    if(isset($forum)) $this->widget('zii.widgets.CBreadcrumbs', array(
    	'homeLink'=>CHtml::link('หน้าแรก', array('/site/index')),
        'links'=>array_merge(
            $forum->getBreadcrumbs(true),
            array('สร้างกระทู้')
        ),
    ));
    else $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>array_merge(
            $thread->getBreadcrumbs(true),
            array('ตอบกระทู้')
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

    <?php if(isset($forum)): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'subject'); ?>
            <?php echo $form->textField($model,'subject',array('style'=>'width:100%;')); ?>
            <?php echo $form->error($model,'subject'); ?>
        </div>
    <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'content'); ?>
            <?php echo $form->textArea($model,'content', array('rows'=>10, 'cols'=>70,'style'=>'width:100%;')); ?>
            <?php echo $form->error($model,'content'); ?>
        </div>

        <?php if(Yii::app()->user->isAdmin()): ?>
            <div class="row rememberMe">
                <?php echo $form->checkBox($model,'lockthread', array('uncheckValue'=>0)); ?>
                <?php echo $form->labelEx($model,'lockthread'); ?>
                <?php // echo $form->error($model,'lockthread'); ?>
            </div>
        <?php endif; ?>

    <div class="row submit">
    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary'),'<i class="icon-check"></i> ยืนยัน');?>
    </div>
    
    <?php $this->endWidget(); ?>
</div><!-- form -->
</div>