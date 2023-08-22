<section class="content" id="contact-us">
    <div class="container">
        <?php
        // $form = $this->beginWidget('CActiveForm',array(
        //     'action'=>Yii::app()->createUrl('registration/Repassword'),
        // ));

        ?>
        <div class="well">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="form-group">
                        <label for="">รหัสผ่านใหม่</label><br>
                        <input class="form-control" type="password" name="password" id="password">
                        <!-- <?php// echo $form->passwordField($model, 'password', array('class' => 'form-control input-lg' , 'required' => true)); ?>
                        <?php //echo $form->error($model, 'password'); ?> -->
                        <br>
                         <label for="">ยืนยันรหัสผ่านใหม่</label><br>
                         <input class="form-control" type="password" name="verifyPassword" id="verifyPassword">
                       <!--  <?php //echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control input-lg' , 'required' => true)); ?>
                        <?php //echo $form->error($model, 'verifyPassword'); ?>

                        <?php //echo $form->hiddenField($model, 'id', array('class' => 'form-control input-lg','hidden')); ?> -->
                    </div>
                </div>
            </div>         
            <div class="text-center">

                <button class="btn btn-success btn-icon save_data"><i></i>ยืนยันสร้างรหัสผ่านใหม่</button>                        
       
                <!--<button type="submit" class="btn btn-warning btn-lg">ส่งข้อความ</button>-->
                <?php //echo CHtml::submitButton('ยืนยันสร้างรหัสผ่านใหม่', array('class' => 'btn btn-warning btn-lg')); ?>
            </div>
        </div>
        <?php 
        // $this->endWidget();
        ?>
    </div>
</section>