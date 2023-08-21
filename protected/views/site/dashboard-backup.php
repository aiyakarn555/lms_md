<style type="text/css">


.pull-right {
    font-size: 18px ;
}
#badgeone {
    background-color: #3c763d;
}
#badgetwo {
    background-color: #337ab7;
}
#badgethree {
    background-color: #a93232;
}
#badgefour {
    background-color: #989898;
}

.classic-title {
    padding-bottom: 4px;
    margin-bottom: 35px;
}
h2.classic-title span {
    font-size: 25px;
    font-weight: bold;
    padding-bottom: 5px;
    border-bottom: 3px solid #4a4a4a;
}
#table-responsive{
    max-height: 18em;
}
.table-responsive {
    min-height: .01%;
    overflow-x: auto;
}
.table-bordered>tbody>tr>td.bl-0 {
    border-left: 2px solid transparent;
}
.btn btn-success btn-sm {
    margin-right: 10px;
}
th.info{
    background-image: linear-gradient(120deg, #6a7477 0%, #6a7477 100%);
    color: #fff;
    text-align: center;
    border:2px solid #cccccc;
    position: relative;
    font-size: 17px;
    font-weight: 700;
}
.panel>.panel-collapse>.table, .panel>.table, .panel>.table-responsive>.table{
    font-size:17px;
    font-weight: 500;
}
.form-inline {
    margin-bottom: 15px;
}
.badge{
    padding: 10px 10px;
    font-size: 15px;
}
.form-inline .form-control{
    font-size: 16px;
}

.progress-title{
    font-size: 18px;
    font-weight: 700;
    font-style: italic; 
    color: #455493;
    margin: 0 0 20px;
}
.progress{
    height: 20px;
    /* top: 5px!important; */
    background: #f1f1f1!important;
    border-radius: 4px!important;
    box-shadow: none!important;
    margin-bottom: 30px!important;
    overflow: visible!important;
    /* padding: 0px 20px 0px 20px!important; */
    position: relative;
    top: 14px;
}
.progress .progress-bar{
    box-shadow: none!important; 
    border-radius: 4px!important;
    position: relative!important;
    -webkit-animation: animate-positive 2s!important;
    animation: animate-positive 2s!important;
    top: 0px!important;
    height: 20px!important;
}
.progress-bar-span{
    font-size: 14px;
    font-weight: 700;
    color: #6c6c6c;
}
thead th{
    background-color: #010c65 !important;
    color: #f8f8f8;
    vertical-align: middle !important;
}
</style>

<?php
// if(!empty($_GET['course']) || !empty($_GET['year']) ){
//     $course = CourseOnline::model()->findAllByAttributes(array(
//         'active' => 'y',
//         'status' => '1',
//         'lang_id' => '1'
//     ), array('order' => 'sortOrder ASC'));
//     if (is_numeric($_GET['course']) ) {
//         $course = CourseOnline::model()->findAllByAttributes(array(
//             'active' => 'y',
//             'course_id' => $_GET['course']
//         ));
//     }
// }else{
//     $course = CourseOnline::model()->findAllByAttributes(array(
//         'active' => 'y',
//         'status' => '1',
//         'lang_id' => '1'
//     ), array('order' => 'sortOrder ASC'));
// }


if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
}else{  
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
 function getYearsList() {
    $currentYear = date('Y');
    $yearFrom = 2013;
    $yearsRange = range($currentYear, $yearFrom);
    return array_combine($yearsRange, $yearsRange);
}

function CourseShowStatus($flag, $langId, $value, $gen_id){
    if(!$flag){
     $courseChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = '.$langId.' AND parent_id = ' . $value->course_id));
         if($courseChildren){
            $value->course_title = $courseChildren->course_title;
            $value->course_short_title = $courseChildren->course_short_title;
        }
    }
    $lesson = Lesson::model()->findAllByAttributes(array(
        'active' => 'y',
        'lang_id' => '1',
        'course_id' => $value->course_id
    ));
    $percent_learn_net = 0;
    foreach ($lesson as $key => $lessonList) {
        $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonList, 0, $gen_id);
        $checkPostTest = Helpers::checkHavePostTestInManage($lessonList->id);
        $lessonStatus = Helpers::lib()->checkLessonPass($lessonList, $gen_id);
        if ($checkPostTest) {
            $isPostTest = Helpers::isPosttestState($lessonList->id, $gen_id);
            if ($lessonStatus == 'pass') {
                if ($isPostTest) {
                    $percent_learn = $checkLessonPass->percent - 10;
                } else {
                    $percent_learn = $checkLessonPass->percent;
                }
            } else {
                $percent_learn = $checkLessonPass->percent;
            }
        } else {
            $percent_learn = $checkLessonPass->percent;
        }
        $percent_learn_net += $percent_learn;
    }
    $percent_learn_net = count($lesson) > 0 ? $percent_learn_net/count($lesson) : 0;
    //$percent_learn_net = 100;
    if($gen_id != "0"){
        $CourseGeneration = CourseGeneration::model()->findByPk($gen_id);
    }    
    ?>
    <tr>
        <td class="text-left" style="text-align: left;"><span class="text23"><?= $value->course_title ?> <?php if($gen_id != "0"){ if($langId != 1){echo "รุ่น "; }else{ echo "gen "; } echo $CourseGeneration->gen_title; if($langId != 1){echo " ".$CourseGeneration->gen_detail; }else{ echo " ".$CourseGeneration->gen_detail_en; } } ?></span></td>
        <td width="50%" style="border-right: none;">

         <div class="progress">
            <!-- <div class="progress-bar<?=($percent_learn_net == 100)? " full":"";?>" role="progressbar" data-percentage="<?= $percent_learn_net; ?>" style="width:<?= $percent_learn_net; ?>%;">
              <span class="progress-bar-span"><?= number_format($percent_learn_net,2); ?>%</span>
              <span class="sr-only"><?= number_format($percent_learn_net,2); ?>% Complete</span>
          </div> -->

          <div class="progress-bar<?=($percent_learn_net == 100)? " full":"";?>" role="progressbar" data-percentage="<?= $percent_learn_net; ?>" style="width:<?= Helpers::lib()->percent_CourseGen($value->course_id, $gen_id) ?>%;">
              <span class="progress-bar-span"><?= Helpers::lib()->percent_CourseGen($value->course_id, $gen_id) ?>%</span>
              <span class="sr-only"><?= Helpers::lib()->percent_CourseGen($value->course_id, $gen_id) ?>% Complete</span>
          </div>
      </div>
  </td>
</tr>
<?php
} //function CourseShowStatus()


function CourseShowHistory($i, $value, $gen_id, $getcourse, $getyear, $label, $langId){
    $_GET['course'] = $getcourse;
    $_GET['year'] = $getyear;

    if($gen_id != "0"){
        $CourseGeneration = CourseGeneration::model()->findByPk($gen_id);
    }  

    $checkCourseGenCanStudy = Helpers::lib()->checkCourseGenCanStudy($value->course_id, $gen_id);

    $passCourse = Passcours::model()->find(array(
        'condition'=>'passcours_cours=:passcours_cours AND passcours_user=:passcours_user AND gen_id=:gen_id',
        'params' => array(':passcours_cours' => $value->course_id, ':passcours_user' => Yii::app()->user->id, ':gen_id'=>$gen_id)
    ));

    $state = true;
        if(empty($value->course_date_start)){
            $value->course_date_start = $value->Schedules->training_date_start;
        }
        
        if(empty($_GET['course'])){
            if(!empty($_GET['year'])){
                $now = $_GET['year'];
                $dateCurrent = DateTime::createFromFormat('Y-m-d H:i:s', $now.'-01-01 00:00:00');
                $dateCourse = DateTime::createFromFormat('Y-m-d H:i:s', $value->course_date_start);

                if( $dateCourse >= $dateCurrent){
                    $state = true;
                }else{
                    $state = false;
                }
            }
        }

        if($state){
        $lesson = Lesson::model()->findAllByAttributes(array(
            'active' => 'y',
            'course_id' => $value->course_id
        ));
        $checkStatus = true;
        $text_status_study = "";
        $text_status_study_class_id = "";
        $text_cursor_context_menu = 'style="cursor: context-menu;"';
        if($checkCourseGenCanStudy){
            $herf = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id,));
            $text_cursor_context_menu = '';
        }else{
            $text_status_study_class_id = "badgefour";
            // $text_status_study = "<font color='red'>ห้ามเรียน</font>";
            $herf = '#collapse-'.i;
            
        }
        
        $status =  $label->label_notLearn;
        $status_button = '<span class="badge" id="';
        if($text_status_study_class_id == ""){
            $status_button .= "badgethree";
        }else{
            $status_button .= $text_status_study_class_id;
        }
        $status_button .= '" '.$text_cursor_context_menu.'><i class="fa fa-graduation-cap"></i>&nbsp;'.$label->label_notLearn.'</span>';
        foreach ($lesson as $key => $lessonList) {
            if($lessonList->lang_id == 1){
            $checkLearn = Learn::model()->findByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'lesson_id' => $lessonList->id,
                'gen_id' => $gen_id,
            ));                     
            if ($checkLearn) {
                // var_dump($checkLearn->lesson_status); 
                if ($checkStatus) {
                    if ($checkLearn->lesson_status == 'pass' && Helpers::lib()->percent_CourseGen($lessonList->course_id, $gen_id) == 100) {
                        $status = $label->label_learned;
                        $checkStatus = true;
                        $herf = '#collapse-'.i;
                        $status_button = '<span class="badge" id="';
                        if($text_status_study_class_id == ""){
                            $status_button .= "badgeone";
                        }else{
                            $status_button .= $text_status_study_class_id;
                        }
                        $status_button .= '" '.$text_cursor_context_menu.'"><i class="fa fa-graduation-cap"></i>&nbsp;'.$label->label_learned.'</span>';
                    // }elseif($checkLearn->lesson_status == 'learning'){
                    }else{
                        $status = $label->label_learning;
                        $checkStatus = false;
                        $herf = '#collapse-'.i;
                        $status_button = '<span class="badge" id="';
                        if($text_status_study_class_id == ""){
                            $status_button .= "badgetwo";
                        }else{
                            $status_button .= $text_status_study_class_id;
                        }
                        $status_button .= '" '.$text_cursor_context_menu.'><i class="fa fa-graduation-cap"></i>&nbsp;'.$label->label_learning.'</span>';
                    } 
                    // else {
                    //     $status = $label->label_notLearn;
                    //     $checkStatus = false;
                    //     $herf = '#collapse-'.i;
                    //     $status_button = '<span class="badge" id="badgetwo" style="cursor: context-menu;"><i class="fa fa-graduation-cap"></i>&nbsp;'.$label->label_notLearn.'</span>';
                    // }
                }
            }else{
                $status = $label->label_learning;
                        $checkStatus = false;
                        $herf = '#collapse-'.i;
                        $status_button = '<span class="badge" id="';
                        if($text_status_study_class_id == ""){
                            $status_button .= "badgetwo";
                        }else{
                            $status_button .= $text_status_study_class_id;
                        }
                        $status_button .= '" '.$text_cursor_context_menu.'><i class="fa fa-graduation-cap"></i>&nbsp;'.$label->label_learning.'</span>';
            }
        } //lang 1
        }


        // var_dump($status_button); 
        // exit();    
        ?>
        <!-- 1 -->
    <div class="row">
        <div class="col-md-12 bg-white">
                <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                    <!--statr no loop -->
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="text1">
                                <a <?php echo $text_cursor_context_menu; ?> role="button" <?= (!$checkStatus)? 'data-toggle="collapse"':'' ?>  data-parent="#accordion2" href="<?= $herf; ?>" aria-expanded="false" aria-controls="collapseOne" class="">
                                <span class="head_titledash"><?= $status_button ?> <i class="fa fa-book"></i>  <?=  $label->label_course ?> <?= $value->course_title ?> <?php if($gen_id != "0"){ if($langId != 1){echo "รุ่น "; }else{ echo "gen "; } echo $CourseGeneration->gen_title; if($langId != 1){echo " ".$CourseGeneration->gen_detail; }else{ echo " ".$CourseGeneration->gen_detail_en; } } echo " ".$text_status_study; ?></span> <span class="pull-right"><i class="fa fa-angle-down" style="margin-top: 7px;"></i></span> <div class="pull-right" style="margin-right: 15px">
                                    <?php if(empty($data->CourseOnlines->Schedules) && $passCourse != null && Helpers::lib()->percent_CourseGen($value->course_id, $gen_id) == 100){
                                        // var_dump($passCourse); exit();
                                     ?>
                                        <!-- ../course/certificate/<?php echo $value->course_id; ?> -->
                                        <?php //echo $this->createUrl('Course/PrintCertificate', array('id' => $value->course_id, 'langId'=>1,'gen'=>$gen_id)); ?>
                                        <?php 
                                        $CheckHaveCer = Helpers::lib()->CheckHaveCer($value->course_id);
                                        if($CheckHaveCer){ 
                                            ?>
                                            <a class="btn btn-success btn-sm btn__printdashboard><?= $printCer ?>" href="../Course/PrintCertificate/<?php echo $value->course_id; ?>?langId=1&gen=<?php echo $gen_id; ?>" role="button"><i class="fa fa-print"></i> <?=  $label->label_printCert ?>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                                </div>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-<?= $i ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="true" style="">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="active">
                                        <th rowspan="2"><?=  $label->label_lesson ?></th>
                                        <th rowspan="2"><?=  $label->label_result ?></th>
                                        <th colspan="2"><?=  $label->label_test ?></th>
                                        <th rowspan="2"><?=  $label->label_testFinal ?></th>
                                        <th rowspan="2"><?=  $label->label_assessSatisfaction ?></th>
                                    </tr>

                                    <tr >
                                        <th><?=  $label->label_testPre ?></th>
                                        <th><?=  $label->label_testPost ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $x = 1;
                                        $y = 0;
                                        $z = 0;
                                        $lesson = Lesson::model()->findAll(array(
                                            'condition' => 'active=:active AND course_id=:course_id AND lang_id=:lang_id',
                                            'params' => array(':active' => 'y',':course_id' => $value->course_id, ':lang_id'=>$langId),
                                            'order' => 'lesson_no'));
                                        foreach ($lesson as $key => $data) { 
                                            if($langId != 1){
                                                $data->id = $data->parent_id;
                                            }
                                                $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($data, 0, $gen_id);
                                                $checkPreTest = Helpers::checkHavePreTestInManage($data->id);
                                                $checkPostTest = Helpers::checkHavePostTestInManage($data->id);
                                                $lessonStatus = Helpers::lib()->checkLessonPass($data, $gen_id);
                                                $isChecklesson = Helpers::Checkparentlesson($data->id, $gen_id);

                                        ?>
                                    <tr class="active text-center">
                                        <td class="text-left">
                                            <?php if($checkCourseGenCanStudy){ ?>
                                                <a href="<?= $isChecklesson ? "../course/detail/".$data->course_id."?lid=".$data->id.'#collapseles'.$data->id : 'javascript:void()'; ?>">
                                            <?php } ?>
                                                <?= $data->title  ?>
                                            <?php if($checkCourseGenCanStudy){ ?>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <?php if ($checkLessonPass->status == "pass") { ?>
                                        <td class="success"><?=  $label->label_learned ?></td>
                                        <?php }elseif($checkLessonPass->status == "learning"){
                                            ?>
                                            <td class="warning"><?=  $label->label_learning ?></td>
                                            <?php
                                        } else { ?>
                                        <td class="danger"><?=  $label->label_notLearn ?></td>
                                        <?php } ?>
                                        <td>
                                            <?php 
                                            if($checkPreTest){
                                                $isPreTest = Helpers::isPretestState($data->id, $gen_id);
                                                if($isPreTest && $checkCourseGenCanStudy) {
                                                ?>
                                                <div>
                                                <a href="../course/learning/<?php echo $value->course_id; ?>?lesson_id=<?php echo $data->id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>&nbsp;<?=  $label->label_DotestPre ?></a>
                                                </div>
                                            <?php
                                                } else {
                                                    $preStatus = Helpers::lib()->CheckTest($data,"pre", $gen_id); 
                                                    if($preStatus->value['score'] != null){
                                                        echo $preStatus->value['score'].'/'.$preStatus->value['total'];
                                                    }else{
                                                     ?>
                                                     <div>
                                                        <a href="javascript:void(0);" style="cursor: context-menu;" class=""><?=  $label->label_NoPreTest ?></a>
                                                    </div>
                                                    <?php 
                                                    }                                                    
                                                }
                                            } else {
                                            ?>
                                                <div>
                                                <a href="javascript:void(0);" style="cursor: context-menu;" class=""><?=  $label->label_NoPreTest ?></a>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                    <?php 
                                            if($checkPostTest) { 
                                                $isPostTest = Helpers::isPosttestState($data->id, $gen_id);
                                                if($isPostTest && $checkCourseGenCanStudy) {
                                                    if($lessonStatus != 'pass') {
                                                        $link = 'javascript:void(0);';
                                                        $alert = 'alertswal();';
                                                    } else {
                                                        $link = "question/index/".$data->id;
                                                        $alert = '';
                                                    }
                                                    ?>
                                                    <div>
                                                    <a href="<?= $link ?>" <?= $alert != '' ? 'onclick="'.$alert.'"' : ''; ?> class="btn btn-danger btn-sm"><i class="fa fa-pencil"></i>&nbsp;<?=  $label->label_DotestPost ?></a>
                                                    </div>
                                                            <?php
                                                } else {
                                                    $postStatus = Helpers::lib()->CheckTest($data,"post", $gen_id);
                                                    if($postStatus->value['score'] != null){
                                                        echo $postStatus->value['score'].'/'.$postStatus->value['total'];
                                                    }else{
                                                        ?>
                                                        <a href="javascript:void(0);" class="" style="cursor: context-menu;"><?=  $label->label_NoPostTest ?></a>
                                                        <?php
                                                    }
                                                }
                                            } else { 
                                        ?>
                                                <a href="javascript:void(0);" class="" style="cursor: context-menu;"><?=  $label->label_NoPostTest ?></a>
                                        <?php } ?>
                                        </td>
                                        <?php 
                                            $y++;
                                            if($y == 1){
                                                    echo '<td rowspan="'.count($lesson).'">';
                                                    $criteria = new CDbCriteria;
                                                    $criteria->condition = ' course_id="' . $data->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND gen_id="'.$gen_id.'" AND active="y" AND type="post"';
                                                    $criteria->order = 'create_date DESC';
                                                    $allFinalTest = Coursescore::model()->find($criteria);

                                                    $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$data->course_id));
                                                    $PaQuest = false;
                                                    if ($CourseSurvey) {
                                                        $passQuest = QQuestAns_course::model()->find(array(
                                                            'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $data->course_id . '" AND gen_id="'.$gen_id.'"',
                                                        ));
                                                        $countSurvey = count($passQuest);
                                                        if ($passQuest) {
                                                            $PaQuest = true;
                                                        }
                                                    }else{
                                                        $PaQuest = true;
                                                    }
                                                    
                                                    // var_dump($PaQuest); exit();
                                                    if($allFinalTest){ //&& $PaQuest

                                                        $printCer = '';
                                                        echo $allFinalTest->score_number.'/'.$allFinalTest->score_total;
                                                    } else {
                                                        $printCer = 'disabled';
                                                        echo $label->label_haveNotTest;
                                                    }
                                                                echo '</td>';
                                                        }
                                                        $z++;
                                                        if($z == 1){
                                        ?>
                                        <td rowspan="<?php echo count($lesson) ?>">
                                            <?php 
                                            $checkQuestionnaireDone = Helpers::lib()->checkQuestionnaireDone($value->course_id, $gen_id);
                                            if($checkQuestionnaireDone){ 
                                                ?>
                                                <a class="btn btn-info btn-sm" href="../course/questionnaire/<?php echo $value->course_id; ?>?gen=<?php echo $gen_id; ?>" role="button"><i class="fa fa-eye"></i> <?=  $label->label_seeResult ?></a>
                                            <?php } ?>
                                        </td>
                                        
                                        <?php
                                                }
                                        ?>
                                    </tr>
                                    <?php $x++; } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> 
                
        </div>
    </div>
    <?php
       
        } // if state

} // function CourseShowHistory()

?>

<div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=  $label->label_statusLearn ?></li>
            </ol>
        </nav>
</div>

<section class="dashboard">
        <div class="container">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading headstat">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="font-weight-bold text-white text25"> <?=  $label->label_statusCourse ?></span> <span class="pull-right"><i class="fa fa-caret-down text-white" aria-hidden="true"></i></span></a>
                        </h4>
                    </div>
                <div id="collapseOne" class="panel-collapse collapse ">
                    <div class="panel-body dashboard-pd">
                         <table class="table table-bordered table-striped" >
                                <thead>
                                    <tr class="tr">
                                        <th class="info "><span class="text25"><?=  $label->label_course ?></span></th>
                                        <th class="info " width="50%" colspan="2"><span class="text25"><?=  $label->label_status ?></span></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    $arr_course_show_now = array();
                                    foreach ($course as $key => $value) {
                                        $CourseGeneration = CourseGeneration::model()->findAll(array(
                                            'condition' => 'active=:active AND course_id=:course_id',
                                            'params' => array(':active'=>'y', ':course_id'=>$value->course_id),
                                        ));
                                        if(!empty($CourseGeneration)){ // หลักสูตร มีรุ่น
                                            if(in_array($value->course_id, $arr_course_id)){ // มีรุ่น อยู่ใน org
                                                foreach ($CourseGeneration as $gen_key => $gen_value) {
                                                    if($gen_value->status == "1"){ // เปิดรุ่น เห็น
                                                        if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                                                            CourseShowStatus($flag, $langId, $value, $gen_value->gen_id);
                                                        }                                                        
                                                        $arr_course_show_now[] = $value;
                                                    }else{ // รุ่นปิด เช็ค ประวัติ
                                                        $logStartCourse_model = LogStartcourse::model()->find(array(
                                                            'condition' => 'user_id=:user_id AND active=:active AND course_id=:course_id AND gen_id=:gen_id',
                                                            'params' => array(':user_id'=>Yii::app()->user->id, ':active'=>'y', ':course_id'=>$value->course_id, ':gen_id'=>$gen_value->gen_id)
                                                        ));
                                                        if(!empty($logStartCourse_model)){
                                                            if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                                                                CourseShowStatus($flag, $langId, $value, $gen_value->gen_id);
                                                        }
                                                        $arr_course_show_now[] = $value;
                                                        }
                                                    }
                                                } // foreach ($CourseGeneration
                                                }else{ // มีรุ่น ไม่อยู่ใน org
                                                 foreach ($CourseGeneration as $gen_key => $gen_value) {
                                                    $logStartCourse_model = LogStartcourse::model()->find(array(
                                                        'condition' => 'user_id=:user_id AND active=:active AND course_id=:course_id AND gen_id=:gen_id',
                                                        'params' => array(':user_id'=>Yii::app()->user->id, ':active'=>'y', ':course_id'=>$value->course_id, ':gen_id'=>$gen_value->gen_id)
                                                    ));
                                                    if(!empty($logStartCourse_model)){
                                                        //*****โชว์ 1 หลักสูตร หลายรุ่น ที่เคยเรียน
                                                        if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                                                            CourseShowStatus($flag, $langId, $value, $gen_value->gen_id);
                                                        }
                                                        $arr_course_show_now[] = $value;
                                                    } //if(!empty($logStartCourse_model))
                                                } //foreach ($CourseGeneration 
                                            } //if(in_array($value->course_id, $arr_course_id)){
                                        }else{ //if(!empty($CourseGeneration)){ // หลักสูตร ไม่มีรุ่น
                                            if(in_array($value->course_id, $arr_course_id)){ //อยู่ใน org
                                                //*****โชว์ 1 หลักสูตร
                                                if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                                                    CourseShowStatus($flag, $langId, $value, "0");
                                                        }                                                
                                                $arr_course_show_now[] = $value;

                                            }else{ // ไม่อยู่ใน org
                                                $logStartCourse_model = LogStartcourse::model()->findAll(array(
                                                    'condition' => 'user_id=:user_id AND active=:active AND course_id=:course_id AND gen_id=:gen_id',
                                                    'params' => array(':user_id'=>Yii::app()->user->id, ':active'=>'y', ':course_id'=>$value->course_id, ':gen_id'=>'0')
                                                ));
                                                //*****โชว์ 1 หลักสูตร ที่เคยเรียน
                                                if(!empty($logStartCourse_model)){
                                                    if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                                                        CourseShowStatus($flag, $langId, $value, "0");
                                                        }                                                    
                                                    $arr_course_show_now[] = $value;
                                                }
                                            }
                                        } //if(!empty($CourseGeneration)){
                                        } // foreach ($course
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>



        <script type="text/javascript">
            $("#btn-seeall").click(function () {
                $("#table-responsive").toggleClass("height-100");
            });
        </script>
    </div>
</div>
</div>

<div class="container">
    <h2 class="classic-title text-center"><span> History </span></h2>
    <form class="form-inline text-center" action="<?php echo $this->createUrl('/site/dashboard'); ?>" method="get">
        <!-- <div class="form-group">
            <label for="exampleInputName3"><?=  UserModule::t('year'); ?></label> -->
            <?php

            // $yearList = getYearsList();
            // echo CHtml::dropDownList('year', '', $yearList, array('class' => 'form-control', 'prompt' => UserModule::t('year')));
            ?>
        <!-- </div>  -->
        
        <label for=""><strong><?=  $label->label_search ?> | <?=  $label->label_course ?></strong></label>
        <div class="form-group">
            <?php
            $courses = CourseOnline::model()->findAllByAttributes(array(
                'active' => 'y',
                    ), array('order' => 'sortOrder ASC'));
            $courseList = CHtml::listData($arr_course_show_now, 'course_id', 'course_title');
            echo CHtml::dropDownList('course', '', $courseList, array('class' => 'form-control', 'prompt' => $label->label_courseSearch));
            ?>
        </div>
        <!-- <div class="form-group">
            <label for="exampleInputName3"><?=  $label->label_gen ?></label> -->
            <?php
            // $generation = Generation::model()->findAllByAttributes(array(
            //     'active' => '1',
            // ));
            // $genList = CHtml::listData($generation, 'id_gen', 'name');
            // echo CHtml::dropDownList('gen', '', $genList, array('class' => 'form-control'));
            ?>
        <!-- </div> --> 
        
        <button type="submit" class="btn btn-success btn-sm" style="margin-top: 0;"><i class="fa fa-search"></i> <?=  $label->label_search ?></button>
        <!--<a href="<?php echo $this->createUrl('/site/allStatus'); ?>" class="btn btn-primary btn-sm" style="margin-top: 0; margin-left: 25px;"><i class="fa fa-bars"></i> สถานะทั้งหมด</a>-->
    </form>

</div>
<div class="container">
    <?php
    $i = 1;
    foreach ($course as $key => $value) {
        $CourseGeneration = CourseGeneration::model()->findAll(array(
            'condition' => 'active=:active AND course_id=:course_id',
            'params' => array(':active'=>'y', ':course_id'=>$value->course_id),
        ));
        if(!empty($CourseGeneration)){ // หลักสูตร มีรุ่น
            if(in_array($value->course_id, $arr_course_id)){ // มีรุ่น อยู่ใน org
                foreach ($CourseGeneration as $gen_key => $gen_value) {
                    if($gen_value->status == "1"){ // เปิดรุ่น เห็น
                        if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                        CourseShowHistory($i, $value, $gen_value->gen_id, $_GET['course'], $_GET['year'], $label, $langId);
                    }
                        $i++;
                    }else{ // รุ่นปิด เช็ค ประวัติ
                        $logStartCourse_model = LogStartcourse::model()->find(array(
                            'condition' => 'user_id=:user_id AND active=:active AND course_id=:course_id AND gen_id=:gen_id',
                            'params' => array(':user_id'=>Yii::app()->user->id, ':active'=>'y', ':course_id'=>$value->course_id, ':gen_id'=>$gen_value->gen_id)
                        ));
                        if(!empty($logStartCourse_model)){
                            if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                            CourseShowHistory($i, $value, $gen_value->gen_id, $_GET['course'], $_GET['year'], $label, $langId);
                        }
                        $i++;
                        }
                    }
                } // foreach ($CourseGeneration
                }else{ // มีรุ่น ไม่อยู่ใน org
               foreach ($CourseGeneration as $gen_key => $gen_value) {
                $logStartCourse_model = LogStartcourse::model()->find(array(
                    'condition' => 'user_id=:user_id AND active=:active AND course_id=:course_id AND gen_id=:gen_id',
                    'params' => array(':user_id'=>Yii::app()->user->id, ':active'=>'y', ':course_id'=>$value->course_id, ':gen_id'=>$gen_value->gen_id)
                ));

                if(!empty($logStartCourse_model)){
                        //*****โชว์ 1 หลักสูตร หลายรุ่น ที่เคยเรียน
                    if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                    CourseShowHistory($i, $value, $gen_value->gen_id, $_GET['course'], $_GET['year'], $label, $langId);
                }
                    $i++;
                    } //if(!empty($logStartCourse_model))
                } //foreach ($CourseGeneration 
            } //if(in_array($value->course_id, $arr_course_id)){
        }else{ //if(!empty($CourseGeneration)){ // หลักสูตร ไม่มีรุ่น
            if(in_array($value->course_id, $arr_course_id)){ //อยู่ใน org
                //*****โชว์ 1 หลักสูตร
                if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                CourseShowHistory($i, $value, "0", $_GET['course'], $_GET['year'], $label, $langId);
            }
                $i++;

            }else{ // ไม่อยู่ใน org
                $logStartCourse_model = LogStartcourse::model()->findAll(array(
                    'condition' => 'user_id=:user_id AND active=:active AND course_id=:course_id AND gen_id=:gen_id',
                    'params' => array(':user_id'=>Yii::app()->user->id, ':active'=>'y', ':course_id'=>$value->course_id, ':gen_id'=>'0')
                ));
                //*****โชว์ 1 หลักสูตร ที่เคยเรียน
                if(!empty($logStartCourse_model)){
                    if((isset($_GET['course']) && $value->course_id == $_GET['course']) || (!isset($_GET['course'])) || ($_GET['course'] == "")){
                    CourseShowHistory($i, $value, "0", $_GET['course'], $_GET['year'], $label, $langId);
                }
                    $i++;
                }
            }
        } //if(!empty($CourseGeneration)){
    } // foreach ($course

    ?>
</div>
</section>
<script type="text/javascript">
function alertswal(){
// swal("คำเตือน", "กรุณาเรียนให้ผ่านก่อนสอบหลังเรียน", "error");
swal('<?=  $label->label_alert_warning ?>', '<?=  $label->label_swal_learnPass ?>', "error");
}

	$(function () {
/* jQueryKnob */
$(".knob").knob({
draw: function () {
// "tron" case
if (this.$.data('skin') == 'tron') {
var a = this.angle(this.cv)  // Angle
, sa = this.startAngle          // Previous start angle
, sat = this.startAngle         // Start angle
, ea                            // Previous end angle
, eat = sat + a                 // End angle
, r = true;
this.g.lineWidth = this.lineWidth;
this.o.cursor
&& (sat = eat - 0.3)
&& (eat = eat + 0.3);
if (this.o.displayPrevious) {
ea = this.startAngle + this.angle(this.value);
this.o.cursor
&& (sa = ea - 0.3)
&& (ea = ea + 0.3);
this.g.beginPath();
this.g.strokeStyle = this.previousColor;
this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
this.g.stroke();
}
this.g.beginPath();
this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
this.g.stroke();
this.g.lineWidth = 2;
this.g.beginPath();
this.g.strokeStyle = this.o.fgColor;
this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
this.g.stroke();
return false;
}
}
});
/* END JQUERY KNOB */
});
</script>

<script>
  function comfirmResetLearn(course_id){

  swal({
    html: true,
    title: "กรุณายืนยันการรีเซ็ตการเรียน",
    text: "คุณต้องการรีเซ็ตการเรียนหลักสูตรนี้ใช่หรือไม่ ?",
    showCancelButton: true,
    imageSize: "200x200",
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "ตกลง!",
    cancelButtonText: "ย้อนกลับ!",
    closeOnConfirm: false,
    closeOnCancel: true
  },
  function(isConfirm){
    if (isConfirm) {
      window.location.href = "<?= $this->createUrl('/course/resetLearn/'); ?>"+'/'+course_id+"?gen=";
      // swal("Deleted!", "Your imaginary file has been deleted.", "success");
    } else {
      return false;
    }

  });
}
</script>