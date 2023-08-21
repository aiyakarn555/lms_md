<!-- <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script> -->
<?php
$path_theme = Yii::app()->theme->baseUrl . '/';
?>

<?php Yii::app()->clientScript->registerCssFile($path_theme . "css/form-elements.css") ?>
<?php Yii::app()->clientScript->registerCssFile($path_theme . "css/style.css") ?>

<!-- <style>
    #content ul {
        list-style: none;
    }
    #content {
        padding: 0;
    }
    .quiz {
        list-style-type: none;
        margin-bottom: 40px;
    }

    .quiz li {
        float: left;
        margin-right: 20px;
    }

    .head-quiz {
        padding-left: 20px;
        padding-right: 20px;
    }

    thead {
        background-color: #94CFFF;
    }

    .mb-quiz {
        margin-bottom: 10px;
    }
    .form-control{
        border: 1px solid #D1D1D1;
    }
    .radio label::before {
        border: 1px solid #4193D0;
    }
    .checkbox label::before {
        border: 1px solid #4193D0;
    }
    .ml-15{
        margin-left: 15px;
    }
    .mb-10{
        margin-bottom: 15px;;
    }
    .span5 {
        width: 500px;
    }
</style> -->
<!-- <div class="page-banner">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <h2 class="text-white">แบบสอบถามบทเรียน</h2>
                <p class="grey lighten-1">We Are Professional</p>
              </div>
              <div class="col-md-6">
                <ul class="breadcrumbs">
                  <li><a href="<.?= $this->createUrl('/site/index/'); ?>">หน้าแรก</a></li>
                  <li><a href="<.?= $this->createUrl('/category/index/'); ?>">หลักสูตร DBD Academy</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div> -->

                <!-- Header page -->
        <div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
            <div class="container">
                <h1>แบบสอบถาม 
                    <small class="pull-right">
                        <ul class="list-inline list-unstyled">
                            <li><a href="#">หน้าแรก</a></li>/
                            <li><a href="#">แบบสอบถาม</a></li>
                        </ul>
                    </small>
                </h1>
            </div>
            <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
        </div>

        <section class="content" id="questionnaire">
<div class="container">
    <div class="well bg-greendark">
                    <div class="well">
<!--     <div class="text-center bg-transparent margin-none">

    </div> -->
    <!-- <div class="page-section"> -->
        <!-- <div class="panel panel-default head-quiz" style="padding-left:30px;"> -->
            <!-- <div class="row"> -->
                <!-- <div class="col-md-12  col-sm-12" style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><img src="<.?php echo Yii::app()->theme->baseUrl; ?>/images/head-subject/quiz.png" alt="person"/></div> -->
                
                <!-- <div class="bs-example"> -->

    <?php $form=$this->beginWidget('AActiveForm', array(
        'id'=>'questionnaire-form',
        'errorMessageCssClass' => 'label label-important',
    )); ?>
        
    <?php
        if(isset($lesson->header)){
            $header = $lesson->header;
    ?>
                        <div class="form-group">

            <h2><?php echo $header->survey_name; ?></h2>
            <input type="hidden" name="header_id" value="<?php echo $header->survey_header_id; ?>">
            <?php echo CHtml::decode($header->instructions); ?>
        </div>
            <!-- <hr> -->
    <?php
            if(count($header->sections) > 0){
                $sections = $header->sections;
                foreach ($sections as $sectionKey => $sectionValue) {
    ?>
                 <h4><?php echo $sectionValue->section_title; ?></h4>
                 <!-- <hr> -->
                 <?php
                 if(count($sectionValue->questions) > 0){
                    foreach ($sectionValue->questions as $questionKey => $questionValue) {
                        //input text
                        if($questionValue->input_type_id == '1'){
?>
                <div class="form-group">
                        <label style="font-size:20px;">
                            <div><strong>

                                <?php echo $questionValue->question_name; ?>
                                    
                                </strong>
                                <label for="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                            <input type="text"  class="form-control input-lg" name="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" data-rule-required="true" data-msg-required="กรุณาตอบ" size="80">
                        </label>
                 </div>
<?php
                        //radio
                        }else if($questionValue->input_type_id == '2'){

?>
                    <div class="form-group">
                        <div style="font-size:20px;"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[radio][<?php echo $questionValue->question_id; ?>]" class="error"></label>
                        </div>
                        <div>
                        <?php
                        if(count($questionValue->choices) > 0){
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                        ?>
                    <div class="radio radio-success">
                        <!-- <label style="font-size:20px;"> -->
                            <input style="margin:0px;" 
                            type="radio" 
                            name="choice[radio][<?php echo $questionValue->question_id; ?>]" 
                            id="choiceradio<?php echo $choiceValue->option_choice_id; ?>"
                            value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                        <label for="choiceradio<?php echo $choiceValue->option_choice_id; ?>">

                            <?php echo $choiceValue->option_choice_name; ?>
                            <?php
                            if($choiceValue->option_choice_type == 'specify'){
                            ?>
                            <input type="text" style="margin-left:10px;" name="choice[radioOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                            <?php
                            }
                            ?>
                        </label>
                    </div>

                        <?php
                            }
                        }
                        ?>
                        </div>
                    </div>
                        <!-- <br> -->
<?php
                        //checkbox
                        }else if($questionValue->input_type_id == '3'){
?>
                    <div class="form-group">
                        <div style="font-size:20px;"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" class="error"></label></div>
                        <div>
                        <?php
                        if(count($questionValue->choices) > 0){
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                        ?>
                        <div class="checkbox checkbox-success">

                        <!-- <label style="font-size:20px;"> -->
                            <input style="margin:0px;" 
                            type="checkbox"
                            name="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" 
                            id="choicecheckbox<?php echo $choiceKey; ?>"
                            value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                        <label for="choicecheckbox<?php echo $choiceKey; ?>">

                            <?php echo $choiceValue->option_choice_name; ?>
                            <?php
                            if($choiceValue->option_choice_type == 'specify'){
                            ?>
                            <input type="text" style="margin-left:10px;" name="choice[checkboxOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                            <?php
                            }
                            ?>
                        </label>
                        <br>
                    </div>
                        <?php

                            }
                        }
                        ?>
                        </div>
                    </div>
                        <!-- <br> -->
<?php
                        //contentment
                        }else if($questionValue->input_type_id == '4'){
?>
                    <div class="form-group">
                        <div style="font-size:20px;">
                            <div class="panel panel-default">
                                <div class="panel-body">
                        <table class="table table-bordered">
                        <thead>
                                <tr>
                                    <th style="width:45%"><strong><?php echo $questionValue->question_name; ?></strong></th>
                                    <?php
                                    if($questionValue->question_range == "" || $questionValue->question_range == "5"){
                                        $range = "5";
                                        // $scoreDetails = array('5' => 'มากที่สุด', '4' => 'มาก', '3' => 'ปานกลาง', '2' => 'น้อย', '1' => 'น้อยที่สุด');
                                        $scoreDetails = array('5' => 'มากที่สุด', '4' => 'มาก', '3' => 'ปานกลาง', '2' => 'น้อย', '1' => 'น้อยที่สุด');
                                    }else{
                                        $range = "10";
                                        // $scoreDetails = array('10' => 'มากที่สุด', '9' => '', '8' => '', '7' => '', '6' => '', '5' => 'ปานกลาง', '4' => '', '3' => '', '2' => '', '1' => 'น้อยที่สุด');
                                        $scoreDetails = array('10' => '', '9' => '', '8' => '', '7' => '', '6' => '', '5' => '', '4' => '', '3' => '', '2' => '', '1' => '');
                                    }
                                    for($i=$range;$i>=1;$i--){
                                    ?>
                                    <th class="text-center" width="80"><strong><?php echo $i." ".$scoreDetails[$i]; ?></strong></th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                        </thead>
                        <?php
                        if(count($questionValue->choices) > 0){
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                        ?>
                                <tr>
                                    <td <?php echo ($choiceKey%2==0)?'style="background-color:#d8d8d8"':''; ?>><?php echo $choiceValue->option_choice_name; ?>

                                        <label for="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" class="error"></label></td>
                                    <?php
                                    for($i=$range;$i>=1;$i--){
                                    ?>
                                    <td class="text-center" <?php echo ($choiceKey%2==0)?'style="background-color:#d8d8d8"':''; ?> >
                                    <div class="radio radio-success">
                                        <input style="margin:0px;" 
                                                id="choicecontentment<?php echo $choiceValue->option_choice_id.$i; ?>"
                                                type="radio" name="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" value="<?php echo $i; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                                         <label for="choicecontentment<?php echo $choiceValue->option_choice_id.$i; ?>">
                                                                                </label>
                                    </div>

                                    </td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                        </table>
                    </div>
                    </div>
                    </div>
                </div>
                        <!-- <br> -->
<?php
                        //text
                        }else if($questionValue->input_type_id == '5'){
?>
                    <div class="form-group">
                        <!-- <label style="font-size:20px;"> -->
                            <div><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                            <textarea data-rule-required="true" data-msg-required="กรุณาตอบ" name="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" rows="5" cols="100%" class="form-control" style="width:100% !important;"></textarea>
                        <!-- </label> -->
                    </div>
                        <!-- <br><br> -->
<?php
                        }
                    }
                 }
                 ?>
                 <!-- <hr> -->
    <?php
                }
            }

        }
    ?>
    <center>
        
    <?php echo CHtml::tag('button',array('class' => 'btn btn-icon btn-primary'),'บันทึกข้อมูล'); ?>
    <!-- <a href="<.?=Yii::app()->createUrl('course/lesson',array('lesson_id'=>$_GET['id'],'id'=>$lesson->course_id))?>" class="navbar-btn btn btn-primary">ยกเลิก</a> -->
           
    </center>
    
    <?php $this->endWidget(); ?>
<!-- </div> -->

<script type="text/javascript">
    $(document).ready(function() {
        $("#questionnaire-form").validate();
    });
</script>

<script type="text/javascript">
    $(function(){ // document ready

     
    });
</script>

               <!--  <div class="col-md-12 col-sm-12">1)
                    เอาอะไรไปคูณกับจำนวนเต็ม ผลลัพธ์จะน้อยลงกว่าเดิม
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ml-15">
                    <div class="radio radio-info">
                        <input name="radio2" id="radio1" value="option2" type="radio">
                        <label for="radio1">จำนวนเต็ม</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio2" id="radio2" value="option2" type="radio">
                        <label for="radio2">เศษส่วนแท้</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio2" id="radio3" value="option2" type="radio">
                        <label for="radio3">เศษส่วนเกิน</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-12 col-sm-12">2)
                    เขาขอยืมเงินกองกลาง..............จ่ายไปก่อน
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ml-15">
                    <div class="radio radio-info">
                        <input name="radio21" id="radio11" value="option2" type="radio">
                        <label for="radio11">ทดลอง</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio21" id="radio21" value="option2" type="radio">
                        <label for="radio21">ทดหนี้</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio21" id="radio31" value="option2" type="radio">
                        <label for="radio31">ทดรอง</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-12 col-sm-12">3)
                    ท่านได้รับทราบข้อมูลเดี่ยวกับตัวสินค้าบราเดอร์จากที่ใด
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ml-15">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox41" name="ccc" type="checkbox">
                        <label for="checkbox41">วิทยุ</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox42" name="ccc" type="checkbox">
                        <label for="checkbox42">หนังสือพิมพ์</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox43" name="ccc" type="checkbox">
                        <label for="checkbox43">นิตยสาร</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-12 col-sm-12">4)
                    คุณภาพที่ไดรับจากการใช้สินค้าบราเดอร์
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ml-15">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox51" name="ccc" type="checkbox">
                        <label for="checkbox51">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox52" name="ccc" type="checkbox">
                        <label for="checkbox52">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox53" name="ccc" type="checkbox">
                        <label for="checkbox53">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ">5)
                    ท่านได้รับทราบข้อมูลเดี่ยวกับตัวสินค้าบราเดอร์จากที่ใด
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 mb-quiz">
                    <div class="form-group" style="margin-top: 15px;">
                        <textarea class="form-control span5" rows="3" placeholder="ที่อยู่"></textarea>
                    </div>
                </div> -->
   
            <!-- </div> -->
        <!-- </div> -->

        </div>
        </div>
    <!-- </div> -->
</div>
</section>
