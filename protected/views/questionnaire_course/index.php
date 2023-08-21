<?php
$path_theme = Yii::app()->theme->baseUrl . '/';
?>
<title>แบบสอบถาม || MK Restaurant E-learning System</title>
<!-- meta-->
<?php Yii::app()->clientScript->registerCssFile($path_theme . "css/form-elements.css") ?>
<?php Yii::app()->clientScript->registerCssFile($path_theme . "css/style.css") ?>
<style type="text/css">
    
</style>
<div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2 class="text-white">แบบประเมินความพึงพอใจ</h2>
            <p class="grey lighten-1">DBD Academy</p>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="/lms_dbd/site/index">หน้าแรก</a></li>
              <li>แบบประเมินความพึงพอใจ</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
<?php
if (isset($questionnaire->q_header)) {
    $header = $questionnaire->q_header;
    if (count($header->sections) > 0) {
        $sections = $header->sections;
        ?>
        <!-- end top script -->
        <div id="container">
            <!-- <div class="page-header">
                <figure class="post-thumbnail">
                    <img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/about/about.jpg">
                </figure>
                <h1 class="title"><span class="line-title">แบบสอบถาม<i class="fa">&#xf111;</i></span></h1>
            </div> -->

            <!-- Content-->
            <div id="content">
                <div class="container z-depth-5 bg-white50 pd-1em">
                    <div class="page-content bg-white pd-1em">
                        <!-- Classic Heading -->
                        <h4 class="classic-title"><span><?php echo $header->survey_name; ?></span></h4>
                        <?php echo CHtml::decode($header->instructions); ?>
                        <?php //echo "5 = มากที่สุด, 4 = มาก, 3 = ปานกลาง, 2 = น้อย, 1 =  น้อยที่สุด"; ?>

                        <hr>

                        <?php $form = $this->beginWidget('AActiveForm', array(
                            'id' => 'questionnaire-form',
                            'errorMessageCssClass' => 'label label-important',
                            'htmlOptions' => array('class' => 'registration-form'),
                        )); ?>
                        <?php
                        $page_start = 0;
                        foreach ($sections as $sectionKey => $sectionValue) {
                            $page_start++;
                            ?>
                                <div class="form-bottom">
                                    <div>
                                        <h4><?php echo $sectionValue->section_title; ?></h4>
                                        <?php
                                        if (count($sectionValue->questions) > 0) {
                                            foreach ($sectionValue->questions as $questionKey => $questionValue) {
                                                //input text
                                                if ($questionValue->input_type_id == '1') {
                                                    ?>
                                                    <label>
                                                        <div>
                                                            <strong><?php echo $questionValue->question_name; ?></strong><label
                                                                for="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]"
                                                                class="error"></label></div>
                                                        <input type="text"
                                                               name="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]"
                                                               data-rule-required="true" data-msg-required="กรุณาตอบ">
                                                    </label>
                                                    <?php
                                                    //radio
                                                } else if ($questionValue->input_type_id == '2') {

                                                    ?>
                                                    <div>
                                                        <strong><?php echo $questionValue->question_name; ?></strong><label
                                                            for="choice[radio][<?php echo $questionValue->question_id; ?>]"
                                                            class="error"></label></div>
                                                    <div>
                                                        <?php
                                                        if (count($questionValue->choices) > 0) {
                                                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                                ?>

                                                                <label>
                                                                    <input type="radio"
                                                                           name="choice[radio][<?php echo $questionValue->question_id; ?>]"
                                                                           value="<?php echo $choiceValue->option_choice_id; ?>"
                                                                           data-rule-required="true"
                                                                           data-msg-required="กรุณาเลือกคำตอบ">
                                                                    <?php echo $choiceValue->option_choice_name; ?>
                                                                    <?php
                                                                    if ($choiceValue->option_choice_type == 'specify') {
                                                                        ?>
                                                                        <input type="text"
                                                                               name="choice[radioOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
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
                                                    <div>
                                                        <strong><?php echo $questionValue->question_name; ?></strong><label
                                                            for="choice[checkbox][<?php echo $questionValue->question_id; ?>][]"
                                                            class="error"></label></div>
                                                    <div>
                                                        <?php
                                                        if (count($questionValue->choices) > 0) {
                                                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                                ?>

                                                                <label>
                                                                    <input type="checkbox"
                                                                           name="choice[checkbox][<?php echo $questionValue->question_id; ?>][]"
                                                                           value="<?php echo $choiceValue->option_choice_id; ?>"
                                                                           data-rule-required="true"
                                                                           data-msg-required="กรุณาเลือกคำตอบ">
                                                                    <?php echo $choiceValue->option_choice_name; ?>
                                                                    <?php
                                                                    if ($choiceValue->option_choice_type == 'specify') {
                                                                        ?>
                                                                        <input type="text" 
                                                                               name="choice[checkboxOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
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
                                                } else if ($questionValue->input_type_id == '4') {
                                                    ?>

                                                    <div class="table-responsive">
                                                        <table class="table v-middle table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    <strong><?php echo $questionValue->question_name; ?></strong>
                                                                </th>
                                                                <?php
                                                                $scoreDetails = array('5' => 'มากที่สุด', '4' => 'มาก', '3' => 'ปายกลาง', '2' => 'น้อย', '1' => 'น้อยที่สุด');
                                                                for ($i = 5; $i >= 1; $i--) {
                                                                    ?>
                                                                    <th class="text-center" width="120">
                                                                        <strong><?php echo $i; ?></strong></th>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="responsive-table-body">
                                                            <?php
                                                            if (count($questionValue->choices) > 0) {
                                                                foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                                    ?>
                                                                    <tr>
                                                                        <td <?php echo ($choiceKey % 2 == 0) ? 'style="background-color:#d8d8d8"' : ''; ?>><?php echo $choiceValue->option_choice_name; ?>
                                                                            <label
                                                                                for="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]"
                                                                                class="error"></label></td>
                                                                        <?php
                                                                        for ($i = 5; $i >= 1; $i--) {
                                                                            ?>
                                                                            <td class="text-center" <?php echo ($choiceKey % 2 == 0) ? 'style="background-color:#d8d8d8"' : ''; ?> >
                                                                                <input type="radio"
                                                                                       name="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]"
                                                                                       value="<?php echo $i; ?>" required >
                                                                            </td>
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
                                                    <div class="clearfix"></div>
                                                    <?php
                                                    //text
                                                } else if ($questionValue->input_type_id == '5') {
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="control-label"><strong><?php echo $questionValue->question_name; ?></strong></label>
                                                        <div>
                                                            <textarea name="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <!-- <label>
                                                        <div>
                                                            <strong><?php echo $questionValue->question_name; ?></strong><label
                                                                for="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]"
                                                                class="error"></label></div>
                                                        <textarea name="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]"
                                                                  rows="3"></textarea>
                                                    </label> -->
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="text-center">
                                            <?php
                                            // if($page_start==1){
                                            ?>
                                            <!-- <button type="button" class="btn-mk btn-mk-success btn-next">
                                                หน้าถัดไป
                                            </button> -->
                                            <?php
                                            // }
                                            // if($page_start>1){
                                            ?>
                                            <!--  <button type="button" class="btn-mk btn-mk-success btn-previous">
                                                 หน้าก่อนหน้า
                                             </button> -->
                                            <?php
                                            // }
                                            if ($page_start == count($sections)) {
                                                ?>
                                                <?php echo CHtml::tag('button', array('class' => 'btn'), 'บันทึกข้อมูล'); ?>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                        ?>
                        <?php $this->endWidget(); ?>

                    </div>
                </div>
            </div>
            <!-- Content-->
        </div>

        <?php
    }
}
?>