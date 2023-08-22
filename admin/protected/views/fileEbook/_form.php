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

                $imageSlide = ImageSlide::model()->findAll('file_id=:file_id', array(':file_id'=>$model->id));
                if(!empty($imageSlide)){
                    ?>

                    <div class="row">
                        <div class="span7">
                            <?php
                            echo $model->FileVdo;
                            ?>

                            <script type="text/javascript">

                                var playerInstance = jwplayer('vdo<?php echo $model->id; ?>').setup({
                                    abouttext: "E-learning",
                                    file: "<?php echo Yii::app()->request->getBaseUrl(true); ?>/../uploads/lesson/<?php echo $model->filename; ?>",
                                });
                                playerInstance.onReady(function() {
                                    if(typeof $("#"+this.id).find("button").attr("onclick") == "undefined"){
                                        $("#"+this.id).find("button").attr("onclick","return false");
                                    }
                                    playerInstance.onPlay(function(callback) {
                                        console.log(callback);
                                    });
                                });
                            </script>
                        </div>
                        <div class="span5">
                            <div class="span4" style="padding-left:50px;">
                                <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','type'=>'button','id'=>'addCurrentTime'),'<i></i>เพิ่มเวลาปัจจุบันให้ slide <span id="numberAdd"></span>'); ?>
                            </div>
                            <div class="span4 thumbnail" id="slideImgShow"></div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <ul class="thumbnails">
                            <?php
                            foreach ($imageSlide as $key => $imageSlideItem) {
                                ?>
                                <li class="span3">
                                    <div class="thumbnail timepicker">
                                        <a href="<?php echo Yii::app()->baseUrl."/../uploads/ppt/".$model->id."/slide-".$imageSlideItem->image_slide_name.".jpg?time=".time(); ?>" rel="prettyPhoto"><img class="slide" src="<?php echo Yii::app()->baseUrl."/../uploads/ppt/".$model->id."/slide-".$imageSlideItem->image_slide_name.".jpg?time=".time(); ?>" alt="<?php echo $imageSlideItem->image_slide_name; ?>"></a>
                                        <h3 class="numberHeader"><?php echo $imageSlideItem->image_slide_name+1; ?></h3>
                                        <p>เวลา (ชั่วโมง : นาที : วินาที)</p><div class="input-append">
                                            <input data-format="hh:mm:ss" type="text" class="time" name="time[<?php echo $imageSlideItem->image_slide_id; ?>]" value="<?php echo gmdate("H:i:s",$imageSlideItem->image_slide_time);?>" style="width: auto !important;"><span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span></div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>

                    <?php
                }
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




