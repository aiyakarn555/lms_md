<style type="text/css">
.errorMessage{
    color:red;
}
</style>
<div class="innerLR">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->_titleheader; ?></h4>
        </div>
        <div class="widget-body">
            <div>
                <?php if( $model->scenario==='update' ): ?>

                    <h3><?php echo Rights::getAuthItemTypeName($model->type); ?></h3>

                <?php endif; ?>

                <?php $form=$this->beginWidget('CActiveForm'); ?>

                <div>
                    <?php echo $form->labelEx($model, 'name'); ?>
                    <?php echo $form->textField($model, 'name', array('maxlength'=>255, 'class'=>'text-field')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                    <p class="hint"><?php echo Rights::t('core', 'Do not change the name unless you know what you are doing.'); ?></p>
                </div>

                <div>
                    <?php echo $form->labelEx($model, 'description'); ?>
                    <?php echo $form->textField($model, 'description', array('maxlength'=>255, 'class'=>'text-field')); ?>
                    <?php echo $form->error($model, 'description'); ?>
                    <p class="hint"><?php echo Rights::t('core', 'A descriptive name for this item.'); ?></p>
                </div>

                <?php if( Rights::module()->enableBizRule===true ): ?>

                    <div>
                        <?php echo $form->labelEx($model, 'bizRule'); ?>
                        <?php echo $form->textField($model, 'bizRule', array('maxlength'=>255, 'class'=>'text-field')); ?>
                        <?php echo $form->error($model, 'bizRule'); ?>
                        <p class="hint"><?php echo Rights::t('core', 'Code that will be executed when performing access checking.'); ?></p>
                    </div>

                <?php endif; ?>

                <?php if( Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData ): ?>

                    <div>
                        <?php echo $form->labelEx($model, 'data'); ?>
                        <?php echo $form->textField($model, 'data', array('maxlength'=>255, 'class'=>'text-field')); ?>
                        <?php echo $form->error($model, 'data'); ?>
                        <p class="hint"><?php echo Rights::t('core', 'Additional data available when executing the business rule.'); ?></p>
                    </div>

                <?php endif; ?>

                <div class="buttons">
                    <?php echo CHtml::submitButton(Rights::t('core', 'Save'),array('class'=>'btn btn-primary')); ?> <?php echo CHtml::link(Rights::t('core', 'Cancel'), Yii::app()->user->rightsReturnUrl,array('class'=>'btn btn-primary')); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
            <div class="spacer"></div>
        </div>
    </div>




</div>