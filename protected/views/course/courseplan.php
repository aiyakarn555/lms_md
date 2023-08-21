<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
    $course_name = 'Course Name';
    $topic = 'Time Schedule of each Course';
    $date_now = date('Y');
    $mont = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $NotStarted = 'Not Started';
    $InProgress = 'In Progress';
    $Passed = 'Passed';
    $Expired = 'Expired';
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
    $course_name = 'ชื่อหลักสูตร';
    $topic = 'ตารางเวลาของแต่ละหลักสูตร';
    $date_now = date('Y') + 543;
    $mont = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    $NotStarted = 'ยังไม่ได้เรียน';
    $InProgress = 'กำลังเรียน';
    $Passed = 'เรียนผ่าน';
    $Expired = 'หมดเวลาเรียน';
}
?>


<section class="content-page">
<div class="container-main">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php if ($langId == 2) { ?>
                    แผนการเรียน
                <?php } else { ?>
                    Plan
                <?php } ?></li>
        </ol>
    </nav>
    <div class="py-5">
        <h4 class="topic" style="margin-bottom:1em;"><span> <?= $topic ?></span>
            <span class="pull-right">
                <select class="form-select select-year" aria-label="" onChange="MM_jumpMenu('parent',this,0)">
                    <?php
                   
                    for ($year=date("Y")+1; $year > 2018; $year--) { 

                        if(isset($_GET["year"])){
                            $now=$_GET["year"];
                        }else{
                            $now=date("Y");
                        }

                        if($year==$now){
                            $sel="selected";
                        }else{
                            $sel="";
                        }
                    ?>
                    <option <?php  echo $sel  ?> value="?year=<?php echo $year ?>"><?php 
                        if($langId == 1){ 
                            echo $year; 
                        }else{
                            echo $year+543;
                        }    ?></option>
                    <?php 
                    }
                    ?>
                </select>
            </span>
        </h4>
        <div class=" my-4">
            <div class="table-plan-container">
                <div id="table-plan" class="table-plan">
                    <div class="cell th"><?= $course_name ?></div>
                    <?php
                    foreach ($mont as $keyM => $valueM) {
                        echo "<div class='cell th'>" . $valueM . "</div>";
                    }
                    ?>
                    <?php $row = 2;
                    // if ($langId == 1) {
                        $models = $Model;
                    // } else {
                    //     foreach ($Model as $key_N => $value_N) {
                    //         // 'parent_id' => $value_N->course_id, 
                    //         $CourseOnline =  CourseOnline::model()->findByAttributes(['active' => 'y', 'lang_id' => 1]);
                    //         $CourseOnline->cate_id = $value_N->cate_id;
                    //         $models[]  = $CourseOnline;
                    //     }
                    // }
                    foreach ($models as $key_C => $M_C) {
                        $date_start = explode('-', $M_C->course_date_start);
                        $date_end = explode('-', $M_C->course_date_end);
                        // var_dump($M_C->course_date_end);exit();
                        if ($langId != 1) {
                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $M_C->course_id, 'order' => 'course_id'));
                            if ($modelChildren) {
                                $M_C->course_title = $modelChildren->course_title;
                               
                            }
                        }



                        if ($M_C->CategoryTitle->active == "y") {
                                $course_id = $M_C->course_id;
                                // var_dump($course_id);
                                // $course_id = $M_C->parent_id;
                            if ($langId == 2) {
                                $date_Course = Helpers::changeFormatDateTHshort($M_C->course_date_start) . ' - ' . Helpers::changeFormatDateTHshort($M_C->course_date_end);
                                // var_dump($M_C->course_id);exit();
                            } else {
                                $date_Course = Helpers::changeFormatDateENnew($M_C->course_date_start) . ' - ' . Helpers::changeFormatDateENnew($M_C->course_date_end);
                            }
                            $LogStartcourse = LogStartcourse::Model()->find(array('condition' => 'course_id =' . $course_id . ' AND user_id =' . Yii::app()->user->id));
                            $passcourse = Passcours::Model()->find(array('condition' => 'passcours_cours = ' . $course_id . ' AND passcours_user =' . Yii::app()->user->id));

                            // print_r($LogStartcourse);
                            // print_r($passcourse);die;
                            if (!empty($passcourse)) { // ผ่าน
                                $status_user = '#4BBC99'; // สีเขียว
                            } else if (date('Y-m-d H:i:s') > $M_C->course_date_end) { //ต่อให้เคยเรียน แต่ก็ให้ขึ้นหมดเวลา
                                $status_user = '#E64D3B'; //สีแดง
                            } else if (!empty($LogStartcourse) && empty($passcourse)) { //กำลังเรียน แต่ยังไม่ผ่าน
                                $status_user = '#FFA74A'; // สีส้ม
                            } else if (date('Y-m-d H:i:s') > $M_C->course_date_end && empty($passcourse)) { //หมดเวลาสมัครเรียน
                                $status_user = '#E64D3B'; //สีแดง
                            } else { // ยังไม่เริ่ม
                                $status_user = '#3A8DDD'; //สีน้ำเงิน
                            }



                            // if (date("Y", strtotime($M_C->course_date_start)) !=  date("Y", strtotime($M_C->course_date_end))) {

                            //     if (date("Y", strtotime($M_C->course_date_start)) < date("Y")) {
                            //         $month_start = 1;
                            //     } else {
                            //         $month_start = date("m", strtotime($M_C->course_date_start));
                            //     }

                            //     if (date("Y", strtotime($M_C->course_date_end)) > date("Y")) {
                            //         $month_end = 12;
                            //     } else {
                            //         $month_end = date("m", strtotime($M_C->course_date_end));
                            //     }
                            // } else {
                            //     $month_start = date("m", strtotime($M_C->course_date_start));
                            //     $month_end = date("m", strtotime($M_C->course_date_end));
                            // }

                            if (date("Y", strtotime($M_C->course_date_start)) !=  date("Y", strtotime($M_C->course_date_end))) {

                                if (date("Y", strtotime($M_C->course_date_start)) < $now) {
                                    $month_start = 1;
                                } else {
                                    $month_start = date("m", strtotime($M_C->course_date_start));
                                }

                                if (date("Y", strtotime($M_C->course_date_end)) > $now) {
                                    $month_end = 12;
                                } else {
                                    $month_end = date("m", strtotime($M_C->course_date_end));
                                }
                            } else {
                                $month_start = date("m", strtotime($M_C->course_date_start));
                                $month_end = date("m", strtotime($M_C->course_date_end));
                            }

                            // var_dump($date_start);exit();
                    ?>
                            <div class="cell" style="grid-row:<?= $row ?>;"><?= $M_C->course_title ?></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <section class="event row-plan<?= $row ?>" style="grid-row:<?= $row ?>; grid-column: 
                            <?= $month_start + 1 ?> / span <?= ($month_end - $month_start) + 1 ?> ;
                             background-color: <?= $status_user ?>"> <?= $date_Course ?></section>
                    <?php

                            $row++;
                        }
                    }
                    ?>



                    <!-- <section class="event row-plan2" style=" grid-column: 2 / span 4;"> 4 Jan - 28 Feb </section>
                        <section class="event row-plan3"> 1 Mar - 31 Apr </section>
                        <section class="event row-plan4"> 01 May 2564 </section>
                        <section class="event row-plan5"> 01 Sep - 31 Dec </section>
                        <section class="event row-plan6"> 01 Jan - 31 Dec </section>
                        <section class="event row-plan7"> 01 Jan - 31 Sep </section> -->

                </div>

                <div class="form-group mt-20">
                    <div class="btn-plan1 text-4 btn-plan py-2 my-4"><?= $NotStarted ?></div>
                    <div class="btn-plan2 text-4 btn-plan py-2 my-4"><?= $InProgress ?></div>
                    <div class="btn-plan3 text-4 btn-plan py-2 my-4"><?= $Passed ?> </div>
                    <div class="btn-plan4 text-4 btn-plan py-2 my-4"><?= $Expired ?></div>

                </div>


            </div>
        </div>
    </div>


</div>
</section>

<script type="text/javascript"><!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>