<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php if ($langId == 2) { ?>
                    ประเมินหลักสูตร
                <?php } else { ?>
                    Course Evaluation
                <?php } ?></li>
        </ol>
    </nav>
    <div class="page-section">
        <h4 class="mb-0 topic"> Course Evaluation</h4>
        <div class="panel panel-default head-quiz">
            <div class="">

                <div class="bs-example">

                    <?php $form = $this->beginWidget('AActiveForm', array(
                        'id' => 'questionnaire-form',
                        'errorMessageCssClass' => 'label label-important',
                    )); ?>

                    <h2><?php echo $header->survey_name; ?></h2>
                    <input type="hidden" name="header_id" value="<?php echo $header->survey_header_id; ?>">
                    <?php echo CHtml::decode($header->instructions); ?>


                    <?php
                    if (count($header->sections) > 0) {
                        $sections = $header->sections;
                        foreach ($sections as $sectionKey => $sectionValue) {
                    ?>      
                            <h4 class="group-hr"><?php echo $sectionValue->section_title; ?></h4>
                            <?php
                            if (count($sectionValue->questions) > 0) {
                                foreach ($sectionValue->questions as $questionKey => $questionValue) {
                                    //input text
                                    if ($questionValue->input_type_id == '1') {
                            ?>
                                        <div class=" mtb-10 question-main">
                                            <label class="dp-block mg-1">
                                                <div class="dp-block">
                                                    <strong><?php echo $questionValue->question_name; ?></strong><label for="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label>
                                                </div>
                                                <input type="text" class="textip-question form-control" name="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" data-rule-required="true" data-msg-required="กรุณาตอบ">
                                            </label>
                                        </div>
                                    <?php
                                        //radio
                                    } else if ($questionValue->input_type_id == '2') {

                                    ?>
                                        <div class=" mtb-10 question-main">
                                            <div class="dp-block">
                                                <strong><?php echo $questionValue->question_name; ?></strong>
                                                <label for="choice[radio][<?php echo $questionValue->question_id; ?>]" class="error"></label>
                                            </div>
                                            <div>
                                            </div>
                                            <?php
                                            if (count($questionValue->choices) > 0) {
                                                foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                            ?>

                                                    <label>
                                                        <input class="mg-5-10" type="radio" name="choice[radio][<?php echo $questionValue->question_id; ?>]" value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                                                        <?php echo $choiceValue->option_choice_name; ?>
                                                        <?php
                                                        if ($choiceValue->option_choice_type == 'specify') {
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
                                    } else if ($questionValue->input_type_id == '3') {
                                    ?>
                                        <div class="  mtb-10 question-main">
                                            <div class="dp-block mg-1">
                                                <strong><?php echo $questionValue->question_name; ?></strong>
                                                <label for="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" class="error"></label>
                                            </div>

                                            <div>
                                                <?php
                                                if (count($questionValue->choices) > 0) {
                                                    foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                ?>

                                                        <label>
                                                            <input class="mg-5-10" type="checkbox" name="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                                                            <?php echo $choiceValue->option_choice_name; ?>
                                                            <?php
                                                            if ($choiceValue->option_choice_type == 'specify') {
                                                            ?>
                                                                <input type="text" class="mg-5-10" name="choice[checkboxOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    <?php
                                        //contentment
                                    } else if ($questionValue->input_type_id == '4') {
                                    ?>
                                        <div class=" mtb-10 question-main">
                                            <div class="mt-2-5">
                                                <table class="table table-bordered span10 topic-question" border="1">
                                                    <tr>
                                                        <th class="question-left"><strong><?php echo $questionValue->question_name; ?></strong></th>
                                                        <?php
                                                        if ($questionValue->question_range == "" || $questionValue->question_range == "5") {
                                                            $range = "5";
                                                            $scoreDetails = array('5' => 'มากที่สุด', '4' => 'มาก', '3' => 'ปานกลาง', '2' => 'น้อย', '1' => 'น้อยที่สุด');
                                                        } else {
                                                            $range = "10";
                                                            $scoreDetails = array('10' => 'มากที่สุด', '9' => '', '8' => '', '7' => '', '6' => '', '5' => 'ปานกลาง', '4' => '', '3' => '', '2' => '', '1' => 'น้อยที่สุด');
                                                        }
                                                        for ($i = $range; $i >= 1; $i--) {
                                                        ?>
                                                            <th class="text-center" width="80"><strong><?php echo $i . " " . $scoreDetails[$i]; ?></strong></th>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tr>
                                                    <?php
                                                    if (count($questionValue->choices) > 0) {
                                                        foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                    ?>
                                                            <tr>
                                                                <td class="question-left" <?php echo ($choiceKey % 2 == 0) ? 'style="background-color:#ececec"' : ''; ?>><?php echo $choiceValue->option_choice_name; ?><label for="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" class="error"></label></td>
                                                                <?php
                                                                for ($i = $range; $i >= 1; $i--) {
                                                                ?>
                                                                    <td class="text-center" <?php echo ($choiceKey % 2 == 0) ? 'style="background-color:#ececec"' : ''; ?>><input style="margin:0px;" type="radio" name="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" value="<?php echo $i; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ"></td>
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
                                    <?php
                                    } else if ($questionValue->input_type_id == '5') {
                                    ?>
                                        <div class="  mtb-10 question-main">
                                            <div class="dp-block">
                                                <label class="dp-block">
                                                    <div class="mtb-10"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                                                    <textarea class="warea100 form-control" data-rule-required="true" data-msg-required="กรุณาตอบ" name="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" rows="4" cols="50"></textarea>
                                                </label>
                                            </div>
                                        </div>
                </div>
    <?php
                                    }
                                }
                            }
    ?>
<?php
                        }
                    }

?>


<div class="  mt-40">
    <?php echo CHtml::tag('button', array('class' => 'btn btn-main text-decoration-none px-5'), 'บันทึกข้อมูล'); ?>
    <a href="<?= Yii::app()->createUrl('course/lesson', array('lesson_id' => $_GET['id'], 'id' => $lesson->course_id)) ?>" class="navbar-btn btn btn-primary">ยกเลิก</a>
</div>


<?php $this->endWidget(); ?>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    $("#questionnaire-form").validate();
                });

                $(document).ready(function() {
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-red',
                        radioClass: 'iradio_square-red'
                    });
                });
            </script>


        </div>
    </div>
</div>
</div>