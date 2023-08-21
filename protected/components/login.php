<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

/*$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);*/

$model = new LoginForm;
$model->unsetAttributes();
$model->attributes = array();
if(isset($_POST['LoginForm']))
    $model->attributes = $_POST['LoginForm'];

?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'action' => array('/member/login'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


<div id="text-2" class="widget-container widget_text widget_login">
    <div class="textwidget">
        <div class="builder-title-wrapper clearfix">
            <h3 class="builder-item-title" style="background:url(
                '<?php echo Yii::app()->theme->baseUrl; ?>/images/icon_member.png') scroll no-repeat;padding-left:40px;">มุมสมาชิก</h3>
        </div>

        <div class="form-row field_text">
        	<?php echo $form->labelEx($model,'mem_username'); ?>
        	<?php echo $form->textField($model,'mem_username',array('class'=>'input_text required')); ?>
        	<?php echo $form->error($model,'mem_username',array('style'=>'color: red;')); ?>
        </div>
        <div class="form-row field_text">
        	<?php echo $form->labelEx($model,'mem_password'); ?>
        	<?php echo $form->passwordField($model,'mem_password',array('class'=>'input_text required')); ?>
        	<?php echo $form->error($model,'mem_password',array('style'=>'color: red;')); ?>
        </div>

        <div class="form-row field_text">
        	<?php echo $form->checkBox($model,'rememberMe'); ?>
        	<?php echo $form->label($model,'rememberMe'); ?>
        	<?php echo $form->error($model,'rememberMe'); ?>
        </div>
        <div class="form-row field_submit" align="center">
        	<?php echo CHtml::submitButton('Login',array('class'=>'btn')); ?>
        </div>
        <div align="center">
            <?php echo CHtml::link('ลืมรหัสผ่าน',array('/member/forget')); ?>
            &nbsp;::||::&nbsp;
            <?php echo CHtml::link('สมัครสมาชิก', array('/member/create')); ?>
        </div>

    </div>
</div>


<?php $this->endWidget(); ?>
</div><!-- form -->
