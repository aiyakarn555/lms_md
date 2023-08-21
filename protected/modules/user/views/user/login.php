<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
    UserModule::t("Login"),
);
?>
<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
<div class="success">
    <div class="card wizard-card ct-wizard-orange" id="wizard">
        <div class="row">
            <div class="col-xs-12">
                <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12" align="center"><h1><?php echo UserModule::t("Login"); ?></h1></div>
                        <!-- <p><?php //echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p> -->
                        <div class="form">
                            <?php echo CHtml::beginForm('', 'post', array('class'=>'form-horizontal')); ?>
                            <!-- <p class="note"><?php //echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p> -->
                            
                            <?php echo CHtml::errorSummary($model); ?>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo CHtml::activeLabelEx($model,'username'); ?></label>
                                <div class="col-sm-9">
                                    <?php echo CHtml::activeTextField($model,'username',array(
                                    'class'=>'form-control',
                                    'placeholder'=>'Username'
                                    )) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo CHtml::activeLabelEx($model,'password'); ?></label>
                                <div class="col-sm-9">
                                    <?php echo CHtml::activePasswordField($model,'password',array(
                                                                'class'=>'form-control',
                                                                'placeholder'=>'Password'
                                    )) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-3" style="padding: 0;">
                                    <p class="hint">
                                        <?php
                                        if (Helpers::chkRegister_status() == true) {
                                        echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl);
                                        ?> |
                                        <?php } ?>
                                        <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
                                    </p>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-3" style="padding: 0;">
                                    <div class="checkbox icheck">
                                        <?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
                                        <?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-3" style="padding: 0;">
                                    <?php echo CHtml::submitButton(UserModule::t("Login"),array('class' => 'btn btn-sm')); ?>
                                </div>
                            </div>
                            
                            <?php echo CHtml::endForm(); ?>
                            </div><!-- form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $form = new CForm(array(
    'elements'=>array(
    'username'=>array(
    'type'=>'text',
    'maxlength'=>32,
    ),
    'password'=>array(
    'type'=>'password',
    'maxlength'=>32,
    ),
    'rememberMe'=>array(
    'type'=>'checkbox',
    )
    ),
    'buttons'=>array(
    'login'=>array(
    'type'=>'submit',
    'label'=>'Login',
    ),
    ),
    ), $model);
    ?>