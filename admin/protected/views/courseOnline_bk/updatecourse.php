
<?php
$this->breadcrumbs=array(
    'ระบบบทเรียน'=>array('index'),
    'เลือกชุดข้อสอบ'=>array('//CourseOnline/Formcourse','id'=>Yii::app()->user->getState('getCourse')),
    'แก้ไขการแสดงจำนวนข้อสอบ',
);
?>
<!-- innerLR -->
<div class="innerLR">

    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i>แก้ไขการแสดงจำนวนข้อสอบ
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'manage-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true
                    ),
                )); ?>
                <div class="row">
                    <?php echo $form->labelEx($Coursemanage,'manage_row'); ?>
                    <?php echo $form->textField($Coursemanage,'manage_row',array('class'=>'span8')); ?>
                    <?php echo ClassFunction::CircleQuestionMark();?>
                    <?php echo $form->error($Coursemanage,'manage_row'); ?>
                </div>
                <div class="row buttons">
                    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                </div>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>
<!-- END innerLR -->
