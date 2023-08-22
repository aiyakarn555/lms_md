<?php
/* @var $this SendmailGroupController */
/* @var $model LogSendmailGroup */
/* @var $form CActiveForm */
?>


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
                    'id' => 'log-sendmail-group-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                )); ?>

                <p class="note">Fields with <span class="required">*</span> are required.</p>

                <?php echo $form->errorSummary($model); ?>

                <?php
                $data_group = Mailgroup::model()->findAll();
                $list_group = CHtml::listData($data_group, 'id', 'group_name');

                $data_detail = Maildetail::model()->findAll();
                $list_deatil = CHtml::listData($data_detail, 'id', 'mail_title');
                ?>

                <div class="row">
                    <?php echo $form->labelEx($model, 'group_id'); ?>
                    <?php echo $form->dropDownList($model, 'group_id', $list_group,
                        array('empty' => 'เลือกกลุ่มที่ต้องการ')); ?>
                    <?php echo $form->error($model, 'group_id'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'detail_id'); ?>
                    <?php echo $form->dropDownList($model, 'detail_id', $list_deatil,
                        array('empty' => 'เลือกแบบร่างอีเมล์ที่ต้องการ')); ?>
                    <?php echo $form->error($model, 'detail_id'); ?>
                </div>


                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2'), '<i></i>ส่งอีเมล์'); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</div>


<!-- form -->

