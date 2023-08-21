<?php
  $path_theme = Yii::app()->theme->baseUrl.'/';
?>
   <title>แบบสอบถาม || MK Restaurant E-learning System</title>
    <!-- meta-->
 <?php Yii::app()->clientScript->registerCssFile($path_theme . "assets/css/form-elements.css") ?>
 <?php Yii::app()->clientScript->registerCssFile($path_theme . "assets/css/style.css") ?>
 <?php Yii::app()->clientScript->registerCssFile($path_theme . "assets/dist/sweetalert.css") ?>
    <style>
        .form-top {
            padding: 15px 25px 5px 25px;
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

        .form-control {
            border: 1px solid #D1D1D1;
        }

        .radio label::before {
            border: 1px solid #4193D0;
        }

        .checkbox label::before {
            border: 1px solid #4193D0;
        }

        .ml-15 {
            margin-left: 30px;
        }

        .mb-10 {
            margin-bottom: 15px;;
        }

        label {
            font-weight: normal;
        }

        .asesst {
            list-style-type: none;
            margin-bottom: 40px;
        }

        .asesst li {
            float: left;
            margin-right: 20px;
        }

        .head-assessment {
            padding-left: 20px;
            padding-right: 20px;
        }

        thead {
            background-color: #ED1C24;
            color: #FFF;
        }

        .mb-assessment {
            margin-bottom: 10px;
        }

        .form-control {
            border: 1px solid #D1D1D1;
        }

        .radio label::before {
            border: 1px solid #4193D0;
        }

        .checkbox label::before {
            border: 1px solid #4193D0;
        }

        .radio {
            padding-left: 30px;
        }

        .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"], .radio input[type="radio"], .radio-inline input[type="radio"] {
            position: absolute;
            margin-left: -10px;
        }
    </style>

    <?php
        if(isset($questionnaire->q_header)) {

            $header = $questionnaire->q_header;
            if (count($header->sections) > 0) {
                $sections = $header->sections;
                ?>
                <!-- end top script -->
                <div id="main-content" class="main-content">
                    <div class="page-header">
                        <figure class="post-thumbnail">
                            <img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/about/about.jpg">
                        </figure>
                        <h1 class="title"><span class="line-title">แบบสอบถาม<i class="fa">&#xf111;</i></span></h1>
                    </div>
                    <!-- Content-->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 form-box">
                                <div class="form-top">
                                    <div class="panel panel-default head-assessment">
                                        <div class="row" style="padding: 10px;">
                                            <div class="col-md-6 text-left">
                                                <h3><?php echo $header->survey_name; ?></h3>
                                            </div>
                                            <div class="col-md-12">
                                                <?php
                                                    echo CHtml::decode($header->instructions);
                                                ?>
                                                <span style="margin-left:90px;"><?php //echo "5 = มากที่สุด, 4 = มาก, 3 = ปานกลาง, 2 = น้อย, 1 =  น้อยที่สุด"; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $form = $this->beginWidget('AActiveForm', array(
                                    'id' => 'questionnaire-form',
                                    'errorMessageCssClass' => 'label label-important',
                                    'htmlOptions' => array('class' => 'registration-form', 'style' => 'box-shadow: 0px 0px 11px rgb(131, 131, 131)'),
                                )); ?>

                                <?php
                                $page_start = 0;
                                foreach ($sections as $sectionKey => $sectionValue) {
                                    $page_start++;
                                    ?>
                                    <fieldset>
                                        <div class="form-bottom" style="padding-top: 25px;">
                                            <div>
                                    <h4><?php echo $sectionValue->section_title; ?></h4>
                                    <hr>
                                    <?php
                                    if(count($sectionValue->questions) > 0){
                                        foreach ($sectionValue->questions as $questionKey => $questionValue) {
                                            //input text
                                            if($questionValue->input_type_id == '1'){
                                                ?>
                                                <label style="font-size:20px;">
                                                    <div><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                                                    <input type="text" name="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" data-rule-required="true" data-msg-required="กรุณาตอบ">
                                                </label>
                                                <?php
                                                //radio
                                            }else if($questionValue->input_type_id == '2'){

                                                ?>
                                                <div style="font-size:20px;"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[radio][<?php echo $questionValue->question_id; ?>]" class="error"></label></div>
                                                <div>
                                                    <?php
                                                    if(count($questionValue->choices) > 0){
                                                        foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                            ?>

                                                            <label style="font-size:20px;">
                                                                <input style="margin:0px;" type="radio" name="choice[radio][<?php echo $questionValue->question_id; ?>]" value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                                                                <?php echo $choiceValue->option_choice_name; ?>
                                                                <?php
                                                                if($choiceValue->option_choice_type == 'specify'){
                                                                    ?>
                                                                    <input type="text" style="margin-left:10px;" name="choice[radioOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </label>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <br>
                                                <?php
                                                //checkbox
                                            }else if($questionValue->input_type_id == '3'){
                                                ?>
                                                <div style="font-size:20px;"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" class="error"></label></div>
                                                <div>
                                                    <?php
                                                    if(count($questionValue->choices) > 0){
                                                        foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                            ?>
                                                            <label style="font-size:20px;">
                                                                <input style="margin:0px;" type="checkbox" name="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                                                                <?php echo $choiceValue->option_choice_name; ?>
                                                                <?php
                                                                if($choiceValue->option_choice_type == 'specify'){
                                                                    ?>
                                                                    <input type="text" style="margin-left:10px;" name="choice[checkboxOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </label>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <br>
                                                <?php
                                                //contentment
                                            }else if($questionValue->input_type_id == '4'){
                                                ?>

                                                <div class="table-responsive">
                                                    <table class="table v-middle table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><?php echo $questionValue->question_name; ?></strong></th>
                                                            <?php
                                                            $scoreDetails = array('5' => 'มากที่สุด', '4' => 'มาก', '3' => 'ปายกลาง', '2' => 'น้อย', '1' => 'น้อยที่สุด');
                                                            for($i=5;$i>=1;$i--){
                                                                ?>
                                                                <th class="text-center" width="120"><strong><?php echo $i; ?></strong></th>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="responsive-table-body">
                                                        <?php
                                                        if(count($questionValue->choices) > 0){
                                                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                                ?>
                                                                <tr>
                                                                    <td <?php echo ($choiceKey%2==0)?'style="background-color:#d8d8d8"':''; ?>><?php echo $choiceValue->option_choice_name; ?><label for="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" class="error"></label></td>
                                                                    <?php
                                                                    $questAns=QQuestAns_course::model()->find('course_id='.$questionnaire->course_id.' AND user_id='.Yii::app()->user->id.' AND teacher_id ='.$questionnaire->teacher_id);
                                                                    $criteria=new CDbCriteria;
                                                                    $criteria->addCondition('user_id='.Yii::app()->user->id);
                                                                    //
                                                                    $criteria->addCondition('quest_ans_id='.$questAns->id);
                                                                    $criteria->addCondition('choice_id='.$choiceValue->option_choice_id);
                                                                    $qanswer=QAnswers_course::model()->find($criteria);
                                                                    // $qanswer->answer_numeric;
                                                                    for($i=5;$i>=1;$i--){
                                                                        ?>
                                                                        <td class="text-center" <?php echo ($choiceKey%2==0)?'style="background-color:#d8d8d8"':''; ?> ><input style="margin:0px;" type="radio" name="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" value="<?php echo $i; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ" disabled="disabled" <?php if($qanswer->answer_numeric==$i){ echo "checked='checked'"; } ?> ></td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                                <?php
                                                //text
                                            }else if($questionValue->input_type_id == '5'){
                                                ?>
                                                <label style="font-size:20px;">
                                                    <div><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                                                    <textarea disabled="disabled" data-rule-required="true" data-msg-required="กรุณาตอบ" name="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" rows="8" cols="100" style="width: 100% !important;">
                                                         <?php
                                                            $questAns=QQuestAns_course::model()->find('course_id='.$questionnaire->course_id.' AND user_id='.Yii::app()->user->id.' AND teacher_id ='.$questionnaire->teacher_id);
                                                            $criteria=new CDbCriteria;
                                                            $criteria->addCondition('user_id='.Yii::app()->user->id);
                                                            //
                                                            $criteria->addCondition('quest_ans_id='.$questAns->id);
                                                            $criteria->addCondition('choice_id='.$questionValue->choices[0]->option_choice_id);
                                                            $qanswer=QAnswers_course::model()->find($criteria);
                                                            if($qanswer){
                                                                echo $qanswer->answer_textarea;
                                                            }
                                                        ?>
                                                    </textarea>
                                                </label>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <?php
                                }
                                ?>
                                <?php $this->endWidget(); ?>

                            </div>
                        </div>
                    </div>

                    <div style="height: 100px;"></div>
                    <!-- Content-->
                </div>

                <?php
            }
        }
?>

    <?php Yii::app()->clientScript->registerScriptFile($path_theme .'assets/dist/sweetalert.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl .'/js/jquery-validation-1.14.0/dist/jquery.validate.min.js'); ?>


<script type="text/javascript">
    $(document).ready(function() {


        $("#questionnaire-form").validate();

    $('fieldset .form-bottom .finish').onclick = function () {
        swal({
            title: 'คุณแน่ใจหรือไม่ว่าจะส่งแบบสอบถาม',
            text: 'ถ้าต้องการส่งกด OK',
            type: 'info',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {
            setTimeout(function () {
                swal('ระบบทำการส่งแบบสอบถามเรียบร้อย');
            }, 2000);
        });
    };

    });
</script>



<!--<fieldset>-->
<!--    <div class="form-bottom" style="padding-top: 25px;">-->
<!--        <div class="panel panel-default">-->
<!--            Progress table -->
<!--            <div class="table-responsive">-->
<!--                <table class="table v-middle table-bordered">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th class="text-center" width="40%">-->
<!--                            ความคิดเห็นเกี่ยวกับสื่อการสอน-->
<!--                        </th>-->
<!--                        <th class="text-center" width="5%">5</th>-->
<!--                        <th class="text-center" width="5%">4</th>-->
<!--                        <th class="text-center" width="5%">3</th>-->
<!--                        <th class="text-center" width="5%">2</th>-->
<!--                        <th class="text-center" width="5%">1</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody id="responsive-table-body">-->
<!--                    <tr>-->
<!--                        <td>1) ข้อความในสื่อมีความถูกต้อง ครบถ้วน</td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio26" id="radio16" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio16"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio26" id="radio26" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio26"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio26" id="radio36" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio36"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio26" id="radio46" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio46"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio26" id="radio56" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio56"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>2) สื่อประกอบการบรรยายน่าสนใจ และไม่ล้าสมัย</td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio17" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio17"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio27" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio27"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio37" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio37"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio47" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio47"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio57" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio57"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>3) ความพร้อมของคอมพิวเตอร์และอุปกรณ์</td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio17" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio17"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio27" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio27"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio37" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio37"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio47" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio47"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio57" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio57"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>4) ระบบเสียง และภาพประกอบชัดเจน</td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio17" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio17"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio27" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio27"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio37" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio37"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio47" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio47"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <div class="radio radio-info">-->
<!--                                <input name="radio27" id="radio57" value="option2"-->
<!--                                       type="radio">-->
<!--                                <label for="radio57"></label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div style="padding-top: 30px;">-->
<!--            <h3>ข้อเสนอแนะเกี่ยวกับสื่อการสอน </h3>-->
<!--            <textarea name="test" rows="3" class="form-control">ทดสอบ</textarea>-->
<!--        </div>-->
<!--        <div style="text-align: center;padding-top: 15px;">-->
<!--            <button type="button" class="btn-mk btn-mk-success btn-previous">-->
<!--                หน้าก่อนหน้า-->
<!--            </button>-->
<!--            <button type="button" class="btn-mk btn-mk-success finish">ส่งแบบสอบถาม-->
<!--            </button>-->
<!--        </div>-->
<!--    </div>-->
<!--</fieldset>-->