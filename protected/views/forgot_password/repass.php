<section class="content" id="contact-us">
    <div class="container-main">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">เปลื่ยนรหัสผ่าน</li>
            </ol>
        </nav>
        <?php
        $form = $this->beginWidget('CActiveForm',array(
            'action'=>Yii::app()->createUrl('/forgot_password/Repassword')
        ));
        ?>
        <div class="well">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="form-group">
                        <label for="">Reset Password</label><br>
                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control input-lg' , 'required' => true)); ?>
                        <?php echo $form->error($model, 'password'); ?>

                         <label for="">Confirm Reset Password</label><br>
                        <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control input-lg' , 'required' => true)); ?>
                        <?php echo $form->error($model, 'verifyPassword'); ?>

                        <?php echo $form->hiddenField($users, 'id', array('class' => 'form-control input-lg','hidden')); ?>
                    </div>
                </div>
            </div>         
            <div class="text-center">
                <!--<button type="submit" class="btn btn-warning btn-lg">ส่งข้อความ</button>-->
                <?php echo CHtml::submitButton('สร้างรหัสผ่านใหม่', array('class' => 'btn btn-warning btn-lg')); ?>
            </div>
        </div>
        <?php $this->endWidget();
        ?>
    </div>
</section>