<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $Personal_Information = 'Personal Information';
    $Course_Status = 'Course Status';
    $Start = 'Start';
    $Stop = 'Stop';

    $textLang["number"] = "No";
    $textLang["lessonNumber"] = "Lesson No. ";
    $textLang["lesson"] = "Lesson";
    $textLang["resultPreExam"] = "Test results before training";
    $textLang["statusLearn"] = "Training status";
    $textLang["resultPostExam"] = "Test results after training";
    $textLang["Certificate"] = "Certificate";

    $textLang["Category"] = "Category";
    $textLang["CategoryAll"] = "Category All";
    $textLang["SearchText"] = "Input to search";
    $textLang["Search"] = "Search";


    $statusLearn["pass"] = "Pass";
    $statusLearn["notpass"] = "Not Pass";
    $statusTraning["pass"] = "Completed training";
    $statusTraning["notpass"] = "Failed training";
} else {
    $langId = Yii::app()->session['lang'];
    $Personal_Information = 'ข้อมูลส่วนบุคคล';
    $Course_Status = 'ข้อมูลหลักสูตร';
    $Start = 'วันเริ่มต้น';
    $Stop = 'วันสิ้นสุด';

    $textLang["number"] = "ลำดับ";
    $textLang["lessonNumber"] = "บทที่ ";
    $textLang["lesson"] = "บทเรียน";
    $textLang["resultPreExam"] = "ผลการทดสอบก่อนอบรม";
    $textLang["statusLearn"] = "สถานะการอบรม";
    $textLang["resultPostExam"] = "ผลการทดสอบหลังอบรม";
    $textLang["Certificate"] = "ใบประกาศหลักสูตร";

    $textLang["Category"] = "หมวดหลักสูตร";
    $textLang["CategoryAll"] = "หมวดหลักสูตรทั้งหมด";
    $textLang["SearchText"] = "พิมพ์คำค้นหา";
    $textLang["Search"] = "ค้นหา";

    $statusLearn["pass"] = "ผ่าน";
    $statusLearn["notpass"] = "ไม่ผ่าน";
    $statusTraning["pass"] = "สำเร็จ";
    $statusTraning["notpass"] = "อบรมไม่สำเร็จ";
}
?>

<section class="content-page">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $label->label_statusLearn ?></li>
            </ol>
        </nav>
        <div class="content-main  dashboard">

            <section class="search-filter">
                <form class="form row" enctype="multipart/form-data" id="vdo-form" action="<?php echo $this->createUrl('/site/dashboard'); ?>" method="get"> 
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group wrap-form-lable">
                            <select name="SearchCate" id="inputState" class="form-control">
                                <option <?=$SearchCate == 0 ? "selected":""?> value="0" selected><?=$textLang["CategoryAll"]?></option>
                                <?php foreach ($cate_coure_list as $key_cate => $cate) { ?>
                                    <option <?=$SearchCate == $cate->cate_id ? "selected":""?> value="<?=$cate->cate_id?>"><?=$cate->cate_title?></option>
                                <?php } ?>
                            </select>
                            <label for="floatingSelect"><?=$textLang["Category"]?></label>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="wrapsearch">

                            <div class="form-group mx-sm-3">
                                <label for="inputPassword2" class="sr-only">พิมพ์คำค้นหาชื่อหลักสูตร</label>
                                <input type="text" value="<?=$Search?>" name="Search" class="form-control" id="inputPassword2" placeholder="<?=$textLang["SearchText"]?>">
                            </div>

                            <div class="wrap-btn-search">
                                <button type="submit" class="btn btn-primary btn-search"><i class="fas fa-search mx-2"></i><?=$textLang["Search"]?></button>
                            </div>

                        </div>
                    </div>

                 
                </form>
            </section>

            <?php  ?>

            <?php foreach ($cate_coure as $key_cate => $cate) { 

            $criteria = new CDbCriteria;
            $criteria->addIncondition('course_id',$arr_log_course_id);
            $criteria->compare('cate_id',$cate->cate_id);
            $criteria->compare('active','y');
            $criteria->compare('lang_id','1');
            $course_show = CourseOnline::model()->findAll($criteria);
                ?>
              
            <section class="table-course-status">
                <div class="wrap-title-content mb-1">
                    <h3 class=""><?= $cate->cate_title ?></h3>
                </div>
                <div class="tb-toggle-main">
                    <div class="panel-group panel-main" id="accordion" role="tablist" aria-multiselectable="true">

                    <?php foreach ($course_show as $key_cou => $cou) { 

                        $course_model = CourseOnline::model()->findByPk($cou->course_id);
                        $gen_id = $course_model->getGenID($course_model->course_id);

                        $coruse_percents =  Helpers::lib()->percent_CourseGen($cou->course_id, $gen_id);
                        $checkpasscouse =  Helpers::lib()->checkpasscouse($coruse_percents,$cou->course_id, $gen_id); 
                        $criteria = new CDbCriteria;
                        $criteria->compare('course_id',$cou->course_id);
                        $criteria->compare('active','y');
                        $criteria->compare('lang_id','1');
                        $lesson_show = Lesson::model()->findAll($criteria);
                        ?>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <div class="img-panel-course d-flex">
                                    <img src="/lms_tokiomarine/themes/template2/images/course-list1.png" alt="" srcset="">
                                    <h4 class="accordion-lable"><?= $cou->course_title ?></h4>
                                </div>
                                <div class="d-flex">
                                    <?php 
                                    $CheckHaveCer = Helpers::lib()->CheckHaveCer($cou->course_id);
                                    $chkcer = 1;

                                   if($coruse_percents >= 100 && $CheckHaveCer){
                                       $pathPassed = $this->createUrl('Course/PrintCertificate', array('id' => $cou->course_id, 'langId' => 1));
                                   }else{
                                    $pathPassed = "javascript:void(0)";
                                    $chkcer = 0;
                                   }
                                   
                                     ?>
                                    <a  <?= $chkcer == 0 ? 'disabled' : 'target="_blank"'?>  class="btn btn-download-file text-white" href="<?=$pathPassed?>" type="button"><i class="fas fa-print"></i> <?=$textLang["Certificate"]?></a>
                                    <h4 class="text1" style="position: relative;">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?=$cate->cate_id?>" aria-expanded="true" aria-controls="collapseOne">
                                            &nbsp; <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div id="collapse-<?=$cate->cate_id?>" <?= count($lesson_show) == 0 ?'aria-expanded="false" class="collapse" style="height: 0px;"' : ''?> >

                                <div class="panel-body wrap-course-dashbord">
                                    <table class="table table-condensed table-document ">
                                        <thead>
                                            <tr class="head-tb">
                                                <td><?=$textLang["number"]?></td>
                                                <td width="150px"><?=$textLang["lesson"]?></td>
                                                <td><?=$textLang["resultPreExam"]?></td>
                                                <td><?=$textLang["statusLearn"]?></td>
                                                <td><?=$textLang["resultPostExam"]?></td>
                                                <!-- <td>แบบประเมินผลการอบรม</td> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($lesson_show as $key_les => $les) { 

                                        $chklearn = Helpers::lib()->checkLessonLearn($les->id);
                                        $checkLessonExamspre = Helpers::lib()->checkLessonExams($les->id,'pre');
                                        $checkLessonExamspost = Helpers::lib()->checkLessonExams($les->id,'post');

                                                $sta_learn = '<b style="color:red">'.$statusTraning["notpass"].'</b>';
                                                if($chklearn){
                                                    $sta_learn = '<b style="color:green">'.$statusTraning["pass"].'</b>';
                                                }

                                                $sta_scorepre = '<b style="color:red">'.$statusLearn["notpass"].'</b>';
                                                if($checkLessonExamspre){
                                                    $sta_scorepre = '<b style="color:green">'.$statusLearn["pass"].'</b>';
                                                }

                                                $sta_scorepost = '<b style="color:red">'.$statusLearn["notpass"].'</b>';
                                                if($checkLessonExamspost){
                                                    $sta_scorepost = '<b style="color:green">'.$statusLearn["pass"].'</b>';
                                                }
                                                
                                                ?>
                                            <tr>
                                                <td><?=$textLang["lessonNumber"]?><?=$key_les+1?></td>
                                                <td>
                                                    <div class="wrap-td-col">
                                                        <span><?= $les->title?></span>
                                                    </div>
                                                </td>

                                                <td><?=$sta_scorepre?></td>
                                                <td><?=$sta_learn?></td>
                                                <td><?=$sta_scorepost?></td>
                                                <!-- <td>ยังไม่ได้ประเมิน</td> -->
                                            </tr>
                                        <?php } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end show detail -->
                        </div>

                    <?php } ?>



                    </div>
                </div>
            </section>
            <?php } ?>     



        </div>
    </div>
</section>