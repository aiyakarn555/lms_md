<?php
$path_theme = Yii::app()->theme->baseUrl . '/';
?>
<!-- meta-->
<?php Yii::app()->clientScript->registerCssFile($path_theme . "css/form-elements.css") ?>
<?php Yii::app()->clientScript->registerCssFile($path_theme . "css/style.css") ?>

<!-- Header page -->
<!-- <div class="header-page" >
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
</div> -->

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
           <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $labelCourse->label_course; ?></a>
            <li class="breadcrumb-item active" aria-current="page"><?= $course->course_title; ?></li>
        </ol>
    </nav>
</div> 

<!-- Content -->
<section class="content" id="questionnaire">
 <div class="container">

   <div class="well well-question">

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
                <!-- <div class="container z-depth-5 bg-white50 pd-1em"> -->
                    <div class="page-content bg-white pd-1em">

                        <?php $form = $this->beginWidget('AActiveForm', array(
                            'id' => 'questionnaire-form',
                            'errorMessageCssClass' => 'label label-important',
                            'htmlOptions' => array('class' => 'registration-form'),
                        )); ?>
                        <!-- Classic Heading -->
                        <div class="form-group">

                            <h4 class="classic-title"><span><b><?php echo $header->survey_name; ?></b></span></h4>
                            <?php echo CHtml::decode($header->instructions); ?>
                        </div>

                        <hr>

                        <?php
                        $page_start = 0;
                        foreach ($sections as $sectionKey => $sectionValue) {
                            $page_start++;
                            ?>
                            <div class="form-bottom">
                                <div>
                                    <h4>ชื่อกลุ่ม <?php echo $sectionValue->section_title; ?></h4>

                                    <?php
                                    if (count($sectionValue->questions) > 0) {

                                        foreach ($sectionValue->questions as $questionKey => $questionValue) {
                                                //input text
                                            if ($questionValue->input_type_id == '1') {
                                                ?>
                                                <div class="form-group">
                                                    <label>
                                                        <div>
                                                            <strong><?php echo $questionValue->question_name; ?></strong><label
                                                            for="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]"
                                                            class="error"></label></div>
                                                            <input type="text"
                                                            class="form-control input-lg"
                                                            size="80"
                                                            name="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]"

                                                            data-rule-required="true" data-msg-required="กรุณาตอบ">
                                                        </label>
                                                    </div>

                                                    <?php
                                                    //radio
                                                } else if ($questionValue->input_type_id == '2') {

                                                    ?>
                                                    <div class="form-group">

                                                        <div>
                                                            <strong><?php echo $questionValue->question_name; ?></strong><label
                                                            for="choice[radio][<?php echo $questionValue->question_id; ?>]"
                                                            class="error"></label></div>
                                                            <div>
                                                                <?php
                                                                if (count($questionValue->choices) > 0) {
                                                                    foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                                        ?>
                                                                        <div class="radio radio-success">
                                                                            <input type="radio"
                                                                            name="choice[radio][<?php echo $questionValue->question_id; ?>]"
                                                                            id="choiceradio<?php echo $questionValue->question_id; ?><?php echo $choiceKey; ?>"
                                                                            value="<?php echo $choiceValue->option_choice_id; ?>"
                                                                            data-rule-required="true"
                                                                            data-msg-required="กรุณาเลือกคำตอบ">
                                                                            <label for="choiceradio<?php echo $questionValue->question_id; ?><?php echo $choiceKey; ?>">

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
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    //checkbox
                                                    } else if ($questionValue->input_type_id == '3') {
                                                        ?>
                                                        <div class="form-group">

                                                            <div>
                                                                <strong><?php echo $questionValue->question_name; ?></strong><label
                                                                for="choice[checkbox][<?php echo $questionValue->question_id; ?>][]"
                                                                class="error"></label></div>
                                                                <div>
                                                                    <?php
                                                                    if (count($questionValue->choices) > 0) {
                                                                        foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                                            ?>
                                                                            <div class="checkbox checkbox-success">

                                                                                <input type="checkbox"
                                                                                name="choice[checkbox][<?php echo $questionValue->question_id; ?>][]"
                                                                                id="choicecheckbox<?php echo $choiceKey; ?>"
                                                                                value="<?php echo $choiceValue->option_choice_id; ?>"
                                                                                data-rule-required="true"
                                                                                data-msg-required="กรุณาเลือกคำตอบ">
                                                                                <label for="choicecheckbox<?php echo $choiceKey; ?>">
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
                                                                            </div>
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

                                                            <div class="form-group">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-body question-box">
                                                                        <span> <?php //echo "5 = มากที่สุด, 4 = มาก, 3 = ปานกลาง, 2 = น้อย, 1 =  น้อยที่สุด"; ?></span>

                                                                        <!-- <div class="table-responsive"> -->
                                                                            <table style="background-color:white" class="table table-bordered question-table" >
                                                                                <thead class="head-question">
                                                                                    <tr>
                                                                                        <th width="30%" class="text-left">
                                                                                            <strong><?php echo $questionValue->question_name; ?></strong>
                                                                                        </th>
                                                                                        <?php
                                                                                        if($questionValue->question_range == 5){
                                                                                            $titleArray = array(
                                                                                                '1' => 'ไม่พอใจเลย',
                                                                                                '2' => 'เฉยๆอ่ะ',
                                                                                                '3' => 'พอใจ',
                                                                                                '4' => 'พอใจมาก',
                                                                                                '5' => 'พอใจมากที่สุด',
                                                                                            );
                                                                                        } else {
                                                                                            $titleArray = array(
                                                                                                '1' => '1',
                                                                                                '2' => '2',
                                                                                                '3' => '3',
                                                                                                '4' => '4',
                                                                                                '5' => '5',
                                                                                                '6' => '6',
                                                                                                '7' => '7',
                                                                                                '8' => '8',
                                                                                                '9' => '9',
                                                                                                '10' => '10',
                                                                                            );
                                                                                        }
                                                                                        if($questionValue->question_range > 0) {
                                                                                            $j = $questionValue->question_range;
                                                                                            for($i=1; $i <= $questionValue->question_range; $i++) {
                                                                                                ?>
                                                                                                <th class="text-center" width="120">
                                                                                                    <strong><?= $titleArray[$j] ?></strong>
                                                                                                </th>
                                                                                                <?php
                                                                                                $j--;
                                                                                            }
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
                                                                                                <td class="text-left" <?php echo ($choiceKey % 2 == 0) ? 'style="background-color:#FFFFFF"' : ''; ?>><?php echo $choiceValue->option_choice_name; ?>
                                                                                                <label
                                                                                                for="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]"
                                                                                                class="error"></label></td>
                                                                                                <?php
                                                                                                if($questionValue->question_range > 0) {
                                                                                                    $j = $questionValue->question_range;
                                                                                                    for($i=1; $i <= $questionValue->question_range; $i++) {
                                                                                                        ?>
                                                                                                        <td class="text-center" <?php echo ($choiceKey % 2 == 0) ? 'style="background-color:#FFFFFF"' : ''; ?> >
                                                                                                            <div class="radio radio-success">

                                                                                                                <input type="radio" required="required"
                                                                                                                id="choicecontentment<?php echo $choiceValue->option_choice_id.$j; ?>"
                                                                                                                name="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]"
                                                                                                                value="<?php echo $j; ?>" required >
                                                                                                                <label for="choicecontentment<?php echo $choiceValue->option_choice_id.$j; ?>">
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                        <?php
                                                                                                        $j--;
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- </div> -->
                                                                        </div>
                                                                    </div>
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
                                                <?php 
                                                if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                                                    $Save = "Save";
                                                }else{  
                                                    $Save = "บันทึกข้อมูล";
                                                }
                                                ?>
                                                <?php echo CHtml::tag('button', array('class' => 'btn btn-ci center-block'), $Save); ?>
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

                            <!-- </div> -->
                        </div>
                        <!-- Content-->
                    </div>

                    <?php
                }
            }
            ?>









						<!-- <form action="" method="POST" role="form">
							<div class="form-group">
								<label for="input" class="control-label">1. Lorem ipsum dolor sit amet</label>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit repellendus quia delectus, quos nemo tempora odio nobis id minima laudantium officia ea! Et facilis fugit temporibus, dolores illum, ipsam ullam.</p>
								<div class="radio radio-success">
	                                <input type="radio" name="radio1" id="radio1" value="option1">
	                                <label for="radio1">
	                                    ดีมาก
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio1" id="radio2" value="option2">
	                                <label for="radio2">
	                                    ดี
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio1" id="radio3" value="option3">
	                                <label for="radio3">
	                                    พอใช้
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio1" id="radio4" value="option4">
	                                <label for="radio4">
	                                    น้อย
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio1" id="radio5" value="option5">
	                                <label for="radio5">
	                                    น้อยมาก
	                                </label>
	                            </div>
							</div>




							<div class="form-group">
								<label for="input" class="control-label">2. Lorem ipsum dolor sit amet</label>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, mollitia! Eveniet ut explicabo vero aliquam nobis illum cupiditate, repellendus dolorem, rem, atque aspernatur inventore quae dignissimos! Quidem similique, voluptatum iure.</p>
								<div class="radio radio-success">
	                                <input type="radio" name="radio2" id="radio21" value="option1">
	                                <label for="radio21">
	                                    ดีมาก
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio2" id="radio22" value="option2">
	                                <label for="radio22">
	                                    ดี
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio2" id="radio23" value="option3">
	                                <label for="radio23">
	                                    พอใช้
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio2" id="radio24" value="option4">
	                                <label for="radio24">
	                                    น้อย
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio2" id="radio25" value="option5">
	                                <label for="radio25">
	                                    น้อยมาก
	                                </label>
	                            </div>
							</div>
							<div class="form-group">
								<label for="input" class="control-label">3. Lorem ipsum dolor sit amet</label>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, mollitia! Eveniet ut explicabo vero aliquam nobis illum cupiditate, repellendus dolorem, rem, atque aspernatur inventore quae dignissimos! Quidem similique, voluptatum iure.</p>
								<div class="radio radio-success">
	                                <input type="radio" name="radio3" id="radio31" value="option1">
	                                <label for="radio31">
	                                    ดีมาก
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio3" id="radio32" value="option2">
	                                <label for="radio32">
	                                    ดี
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio3" id="radio33" value="option3">
	                                <label for="radio33">
	                                    พอใช้
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio3" id="radio34" value="option4">
	                                <label for="radio34">
	                                    น้อย
	                                </label>
	                            </div>
	                            <div class="radio radio-success">
	                                <input type="radio" name="radio3" id="radio35" value="option5">
	                                <label for="radio35">
	                                    น้อยมาก
	                                </label>
	                            </div>
							</div>
							<div class="form-group">
								<label for="input" class="control-label">ข้อเสนอแนะ</label>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit repellendus quia delectus, quos nemo tempora odio nobis id minima laudantium officia ea! Et facilis fugit temporibus, dolores illum, ipsam ullam.</p>
								<textarea name="" id="input" class="form-control" rows="3"></textarea>
							</div>
							<button type="submit" class="btn btn-primary center-block">Submit</button>
						</form> -->
					</div>
				</div>
				
			</div>
		</section>		