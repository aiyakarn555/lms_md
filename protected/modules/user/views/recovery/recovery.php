<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
	<div class="container">
        <div class="page-section">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-body">

<div class="success">
	<div class="card wizard-card ct-wizard-orange" id="wizard">
		<div class="row">
			<div class="col-xs-12">
			<p>
				<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
			</p>
				</div>
		</div>
	</div>
</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>


<div class="container">
        <div class="page-section">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <div class="col-xs-12" align="center"><h1>ลืมรหัสผ่าน</h1></div>
<div class="form">
<?php echo CHtml::beginForm('', 'post', array('class'=>'form-horizontal')); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<!-- <div class="row">
		<p class="hint"><?php //echo UserModule::t("Please enter your login or email addres."); ?></p>
	</div> -->
	<div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label"><?php echo CHtml::activeLabel($form,'usernameiden'); ?></label>
        <div class="col-sm-9">
            <?php echo CHtml::activeTextField($form,'usernameiden',array(
                                            'class'=>'form-control',
                                            'placeholder'=>'Username'
                                        )) ?>
        </div>
    </div>
	
	<div class="form-group">
		    <div class="col-sm-6 col-sm-offset-3" style="padding: 0;">
		<?php echo CHtml::submitButton(UserModule::t("Restore"),array('class' => 'btn btn-primary')); ?>
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
<?php endif; ?>