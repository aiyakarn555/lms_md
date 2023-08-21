<?php
$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('หน้าแรก', array('/site/index')),
    'links'=>array_merge(
        $model->getBreadcrumbs(!$model->isNewRecord),
        array($model->isNewRecord?'สร้างหมวดหมู่':'แก้ไข')
    )
));
?>

<div class="bs-example"> 

<div class="form">
<?php $form=$this->beginWidget('CActiveForm'); ?>

    <p class="note"><?php echo UserModule::t('ข้อมูลที่มี <span class="required">*</span> จะต้องกรอกให้ครบ'); ?></p>

    <div class="row">
        <?php echo $form->labelEx($model,'parent_id'); ?>
        <?php echo CHtml::activeDropDownList($model, 'parent_id', CHtml::listData(
                Forum::model()->findAll(),
                'id', 'title'
            ), array('empty'=>'ไม่มีหมวดหมู่','class'=>'span7')); ?>
        <?php echo $form->error($model,'parent_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('class'=>'span7')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>10, 'cols'=>70,'class'=>'span7')); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'listorder'); ?>
        <?php echo $form->textField($model,'listorder',array('class'=>'span7')); ?>
        <?php echo $form->error($model,'listorder'); ?>
    </div>

    <div class="row rememberMe">
        <?php echo $form->checkBox($model,'is_locked',array('uncheckValue'=>0)); ?>
        <?php echo $form->labelEx($model,'is_locked'); ?>
        <?php // echo $form->error($model,'lockthread'); ?>
    </div>


    <div class="row submit">
    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary'),'<i class="icon-check"></i> บันทึกสร้างหมวด');?>
    </div>


<?php $this->endWidget(); ?>
</div><!-- form -->

</div>