<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="MOvEyr0DQm0f2juUUgZ+oi7ciSsIU3Ekd7MDgQ==";</script>
<!-- innerLR -->
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i>เพิ่มชื่อวิดีโอ
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">

                <?php $form=$this->beginWidget('AActiveForm', array(
                    'id'=>'file-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                )); ?>

                <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

                <?php //echo $form->errorSummary($model); ?>


                <div class="row">
                    <label for="FileScorm_filename">ชื่อไฟล์ประกอบบทเรียน</label>
                    <!-- <?php echo $form->labelEx($model,'filename'); ?> -->
                    <?php echo $form->textField($model,'filename',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
                    <?php echo $form->fileField($model,'file_scorm'); ?>  (เฉพาะ .zip เท่านั้น)
                    <?php if (isset($error["scorm_file"])) { ?>
                        <?php if ($error["scorm_file"] == "Required") { ?>
                            <span class="text-danger">กรุณาเลือกไฟล์</span>
                        <?php }else{ ?>
                            <span class="text-danger">กรุณาเลือกไฟล์ด้วยนามสกุล 'zip'</span>
                        <?php } ?>
                    <?php } ?>
                    <?php echo $this->NotEmpty();?>
                    <?php echo $form->error($model,'filename'); ?>
                </div>

                <?php

                //Display seconds as hours, minutes and seconds
                function sec2hms ($sec, $padHours = true)
                {

                    // start with a blank string
                    $hms = "";

                    // do the hours first: there are 3600 seconds in an hour, so if we divide
                    // the total number of seconds by 3600 and throw away the remainder, we're
                    // left with the number of hours in those seconds
                    $hours = intval(intval($sec) / 3600);

                    // add hours to $hms (with a leading 0 if asked for)
                    $hms .= ($padHours)
                        ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
                        : $hours. ":";

                    // dividing the total seconds by 60 will give us the number of minutes
                    // in total, but we're interested in *minutes past the hour* and to get
                    // this, we have to divide by 60 again and then use the remainder
                    $minutes = intval(($sec / 60) % 60);

                    // add minutes to $hms (with a leading 0 if needed)
                    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

                    // seconds past the minute are found by dividing the total number of seconds
                    // by 60 and using the remainder
                    $seconds = intval($sec % 60);

                    // add seconds to $hms (with a leading 0 if needed)
                    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

                    // done!
                    return $hms;

                }

                ?>
                <?php
                include(Yii::app()->getBaseUrl(true) . '/../uploads/scorm/' . $model->id . '/content/index.html')
                 ?>
                <div class="row buttons">
                    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</div>
<!-- END innerLR -->




