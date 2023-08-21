<?php if (Yii::app()->user->hasFlash('msg')) {  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
            title: "แจ้งเตือน",
            text: "<?= Yii::app()->user->getFlash('msg'); ?>",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
    </script>
<?php
    Yii::app()->user->setFlash('msg', null);
}
?>



<section class="content-page">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage  ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $label->label_Forgot_password  ?></li>
            </ol>
        </nav>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl('/forgot_password/Sendpassword')
        ));
        ?>
        <div class="password-reset form login-section">
            <div class="row">
                <div class="col-sm-9 col-md-6 col-xs-12 col-md-offset-3 col-sm-offset-2">
                    <div class="login-page">
                        <div class="text-center mb-2">
                            <h3 class="mt-1"><?= $langId == 1 ? "Enter your email to request a password reset." : "ใส่อีเมลของท่านเพื่อขอรีเซ็ตรหัสผ่าน" ?></h3>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label><br>
                            <?php echo $form->textField($model, 'email', array('class' => 'form-control input-lg', 'placeholder' => 'example@gmail.com', 'required' => true)); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                        <div class="text-center">
                            <?php echo CHtml::submitButton($label->label_button, array('class' => 'btn btn-warning btn-lg')); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->endWidget();
        ?>
    </div>
</section>