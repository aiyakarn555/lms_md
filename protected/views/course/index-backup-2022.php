<?php
if(empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    // $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
    $learnn = "Learn Lesson";
    $typeG = "General Course";
    $typeC = "Compulsory Course";
} else {
    // $langId = Yii::app()->session['lang'];
    $flag = false;
    $learnn = "สมัครเรียน";
    $typeG = "หลักสูตรทั่วไป";
    $typeC = "หลักสูตรบังคับ";
}
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

//  $strDate = "2008-08-14 13:42:44";
//  echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active"><a style="color: #757272" href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $label->label_course; ?></a></li>
        </ol>
    </nav>
</div>

<section class="content course-index" id="course">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3 col-xs-12">
                <!-- Search -->
                <!-- <form id="searchForm" action="<?php echo $this->createUrl('course/Search') ?>" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" name="text" placeholder='<?php echo $label->label_search; ?>'>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form> -->

                <!--end  Search -->

                <h4 class="text-center courseindex"><?php echo $label->label_cate; ?></h4>
                <div class="type-menu gallery">
                    <!-- <button class="btn btn-default filter-button btn-lg " data-filter="cate-all"><?php echo $label->label_courseAll; ?></button> -->
                    <!-- <?php
                    $CourseType = CourseType::model()->findAll(array('condition' => 'active = "y" AND lang_id=1'));
                    foreach ($CourseType as $keyType => $valueType) { ?>
                        <a class="btn btn-default filter-button btn-lg" href="<?php echo $this->createUrl('/course/index?type=' . $valueType->type_id); ?>">
                            <?php if ($langId == 2) {
                                $CourseType_th = CourseType::model()->find(array('condition' => 'active = "y" AND lang_id=2 AND parent_id = ' . $valueType->type_id));
                                if (isset($CourseType_th)) {
                                    echo $CourseType_th->type_name;
                                }
                            } else {
                                echo  $valueType->type_name;
                            } ?>
                        </a>
                    <?php } ?> -->
                    <a class="btn btn-default filter-button btn-lg" href="<?php echo $this->createUrl('/course/index?type=1'); ?>">
                        <?php echo $typeG; ?>
                    </a>
                    <a class="btn btn-default filter-button btn-lg" href="<?php echo $this->createUrl('/course/index?type=2'); ?>">
                        <?php echo $typeC; ?>
                    </a>

                    <!-- <?php
                    $arr_cate_id = [];
                    $cate_id_show = "";
                    // var_dump($model_cate); exit();
                    foreach ($model_cate as $m_c) {

                        if ($cate_id_show != $m_c->course->cate_id) {
                            $cate_id_show = $m_c->course->cate_id;

                            $m_c  = $m_c->course->CategoryTitle;

                            if (!in_array($m_c->cate_id, $arr_cate_id)) {
                                $arr_cate_id[] = $m_c->cate_id;
                            } else {
                                continue;
                            }

                            if (!$flag) {
                                $m_cChildren  = Category::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $m_c->cate_id, 'order' => 'cate_id'));
                                if ($m_cChildren) {
                                    $m_c->cate_title = $m_cChildren->cate_title;
                                    $m_c->cate_short_detail = $m_cChildren->cate_short_detail;
                                    $m_c->cate_detail = $m_cChildren->cate_detail;
                                    $m_c->cate_image = $m_cChildren->cate_image;
                                }
                            }
                            if ($m_c->lang_id != 1) {
                                $m_c->cate_id = $m_c->parent_id;
                            }
                    ?>
                            <button style="white-space: normal;" class="btn btn-default filter-button btn-lg" data-filter="<?= $m_c->cate_id ?>"><?= $m_c->cate_title ?></button>
                    <?php
                        }
                    }

                    ?>

                    <?php
                    if ($model_cate_tms) {
                        if ($model_cate_tms->lang_id != 1) {
                            $model_cate_tms->cate_id = $m_c->parent_id;
                        }
                    ?>
                        <button style="white-space: normal;" class="btn btn-default filter-button btn-lg" data-filter="<?= $model_cate_tms->cate_id ?>"><?= $model_cate_tms->cate_title ?></button>
                    <?php } ?> -->


                </div>
            </div>
            <div class="col-sm-8 col-md-9 col-xs-12 course-mb ">
                <div class="row">
                    <?php
                    if ($model_cate_tms) {
                        if ($model_cate_tms->lang_id != 1) {
                            $model_cate_tms->cate_id = $model_cate_tms->parent_id;
                        }
                    ?>
                        <!-- <div class="gallery_product col-sm-6 col-md-4 col-xs-12 filter cate-all course-filter">
                        <div class="well text-center">
                            <button class="filter-button" data-filter="<?= $model_cate_tms->cate_id ?>" style="border:0;background-color: transparent;width: 100%;box-shadow: none;">

                                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/category/' . $model_cate_tms->cate_id . '/thumb/' . $model_cate_tms->cate_image)) { ?>

                                    <div class="course-img" style="background-image: url(<?php echo Yii::app()->request->baseUrl; ?>/uploads/category/<?php echo $model_cate_tms->cate_id . '/thumb/' . $model_cate_tms->cate_image; ?>);"></div>
                                <?php } else { ?>
                                    <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png);"></div>
                                <?php } ?>
                                <div class="course-detail">
                                    <h4 class="text11"><?= $model_cate_tms->cate_title ?></h4>
                                    <p class="p"><?= $model_cate_tms->cate_short_detail ?></p>
                                </div>
                            </button>
                        </div>
                    </div> -->
                        <div class="gallery_product col-sm-6 col-md-4 col-xs-12 filter cate-all course-filter">
                            <div class="well text-center">
                                <button class="filter-button" data-filter="<?= $model_cate_tms->cate_id ?>" style="border:0;background-color: transparent;width: 100%;box-shadow: none;">

                                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/category/' . $model_cate_tms->cate_id . '/thumb/' . $model_cate_tms->cate_image)) { ?>

                                        <div class="course-img">
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/category/<?php echo $model_cate_tms->cate_id . '/thumb/' . $model_cate_tms->cate_image; ?>" alt="">
                                        </div>
                                    <?php } else { ?>
                                        <div class="course-img">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png" alt="">
                                        </div>
                                    <?php } ?>
                                    <div class="course-detail">
                                        <h4 class="text11"><?= $model_cate_tms->cate_title ?></h4>
                                        <p class="p"><?= $model_cate_tms->cate_short_detail ?></p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    <?php  } ?>

                    <?php $cate_id_show = ""; ?>
                    <?php
                    unset($arr_cate_id);
                    $arr_cate_id = [];
                    foreach ($model_cate as $m_c) {
                        if ($cate_id_show != $m_c->course->cate_id) {
                            $cate_id_show = $m_c->course->cate_id;

                            $cate_id_cate_id = $m_c->course->cate_id;
                            $m_c  = $m_c->course->CategoryTitle;
                            $m_c->cate_id = $cate_id_cate_id;
                            if (!in_array($m_c->cate_id, $arr_cate_id)) {
                                $arr_cate_id[] = $m_c->cate_id;
                            } else {
                                continue;
                            }

                            if ($m_c->lang_id != 1) {
                                $m_c->cate_id = $m_c->parent_id;
                            }

                    ?>

                            <div class="gallery_product col-sm-6 col-md-4 col-xs-12 filter cate-all course-filter">
                                <div class="well text-center">
                                    <!--                            <a href="course-detail.php-->

                                    <button class="filter-button" data-filter="<?= $m_c->cate_id ?>" style="border:0;background-color: transparent;width: 100%;box-shadow: none;">
                                        <?php

                                        if (!$flag) {
                                            $m_cChildren  = Category::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $m_c->cate_id, 'order' => 'cate_id'));
                                            if ($m_cChildren) {
                                                $m_c->cate_id = $m_cChildren->cate_id;
                                                $m_c->cate_title = $m_cChildren->cate_title;
                                                $m_c->cate_short_detail = $m_cChildren->cate_short_detail;
                                                $m_c->cate_detail = $m_cChildren->cate_detail;
                                                $m_c->cate_image = $m_cChildren->cate_image;
                                            }
                                        }
                                        ?>

                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/category/' . $m_c->cate_id . '/thumb/' . $m_c->cate_image)) {
                                        ?>
                                            <div class="course-img">
                                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/category/<?php echo $m_c->cate_id . '/thumb/' . $m_c->cate_image; ?>" alt="">
                                            </div>
                                        <?php } else { ?>
                                            <div class="course-img">
                                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png" alt="">
                                            </div>
                                        <?php } ?>
                                        <div class="course-detail">
                                            <h4 class="text11"><?= $m_c->cate_title ?></h4>
                                            
                                            <p class="p"><?= $m_c->cate_short_detail ?></p>
                                            <!-- <i class="fa fa-calendar"></i>&nbsp;<? php // echo DateThai($m_c->update_date); 
                                                                                        ?> -->
                                        </div>
                                    </button>
                                </div>
                            </div>
                    <?php  }
                    } ?>

                    <?php foreach ($modelCourseTms as $val) {
                        $model = $val->course;
                        $schedule = $val->schedule;
                        if ($model->lang_id != 1) {
                            $model->course_id = $model->parent_id;
                        }

                        if (!$flag) {
                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $model->course_id, 'order' => 'course_id'));
                            if ($modelChildren) {
                                // $model->course_id = $modelChildren->course_id;
                                $model->course_title = $modelChildren->course_title;
                                $model->course_short_title = $modelChildren->course_short_title;
                                $model->course_detail = $modelChildren->course_detail;
                                $model->course_picture = $modelChildren->course_picture;
                            }
                        }
                        $expireDate = Helpers::lib()->checkCourseExpireTms($schedule);
                        if ($expireDate) {
                            $evnt = '';
                            $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id, 'courseType' => 'tms', 'gen' => $model->getGenID($model->course_id)));
                        } else {
                            // $evnt = 'onclick="alertMsg(\'ระบบ\',\'หลักสูตรหมดอายุ\',\'error\')"';
                            if (date($schedule->training_date_start) > date("Y-m-d")) {
                                $evnt = 'onclick="alertMsgNotNow()"';
                                $url = 'javascript:void(0)';
                            } else {
                                $evnt = 'onclick="alertMsg()"';
                                $url = 'javascript:void(0)';
                            }
                        }
                    ?>

                        <div class="gallery_product col-sm-6 col-xs-12 col-md-4 filter <?= $model->cate_id ?>" style="display: none;">
                            <div class="well text-center">
                                <!--                            <a href="course-detail.php-->
                                <a href="<?= $url; ?>" <?= $evnt ?>>
                                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $model->course_id . '/thumb/' . $model->course_picture)) { ?>
                                        <div class="course-img" style="background-image: url(<?php echo Yii::app()->request->baseUrl; ?>/uploads/courseonline/<?php echo $model->course_id . '/thumb/' . $model->course_picture; ?>);"></div>
                                    <?php } else { ?>
                                        <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png);"></div>
                                    <?php } ?>
                                    <div class="course-detail">

                                        <?php
                                        $courseStatus = Helpers::lib()->checkCoursePass($model->id);

                                        if ($courseStatus == "notPass") {
                                            $statusLearnClass = 'muted';
                                        } else if ($courseStatus == "learning") {
                                            $statusLearnClass = 'warning';
                                        } else if ($courseStatus == "pass") {
                                            $statusLearnClass = 'success';
                                        }
                                        ?>


                                        <h4 class="text11"><i class="fa fa-trophy fa-sm text-<?= $statusLearnClass; ?>"></i> &nbsp <?= $model->course_title ?> <?= $model->getGen($model->course_id) ?></h4>

                                        <p class="p"><?= $model->course_short_title ?></p>
                                        <!-- <i class="fa fa-calendar"></i> -->
                                        <hr class="line-course">
                                        <p class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> <?= $label->label_dateStart ?> <?php echo Helpers::lib()->DateLangTms($schedule->training_date_start, Yii::app()->session['lang']); ?> </p>
                                        <p class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> <?= $label->label_dateExpire ?> <?php echo Helpers::lib()->DateLangTms($schedule->training_date_end, Yii::app()->session['lang']); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php  } ?>
                    <?php foreach ($Model as $model) {
                        // $model = $model->course;

                        if ($model->lang_id != 1) {
                            $model->course_id = $model->parent_id;
                        }

                        // var_dump(expression)

                        $chk_logtime = LogStartcourse::model()->find(array(
                            'condition' => 'course_id=:course_id and user_id=:user_id and active=:active and gen_id=:gen_id',
                            'params' => array(':course_id' => $model->course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $model->getGenID($model->course_id))
                        ));
                        $course_chk_time = CourseOnline::model()->findByPk($model->course_id);


                        if (!empty($chk_logtime)) {
                            // if ($chk_logtime->course_day != $course_chk_time->course_day_learn) {
                            //     $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));

                            //     $Endlearncourse = date("Y-m-d", $Endlearncourse);

                            //     $chk_logtime->end_date = $Endlearncourse;
                            //     $chk_logtime->course_day = $course_chk_time->course_day_learn;
                            //     $chk_logtime->save(false);
                            // }
                            if ($chk_logtime->end_date != $course_chk_time->course_date_end) {
                                $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));
                                $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                // $chk_logtime->end_date = $Endlearncourse;
                                $chk_logtime->end_date = $course_chk_time->course_date_end;
                                $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                $chk_logtime->save(false);
                            }
                        }


                        $chklearn = Helpers::lib()->getLearn($model->course_id);
                        $checkUserCourseExpire = Helpers::lib()->checkUserCourseExpire($model);


                        if ($chklearn) {

                            if (!$checkUserCourseExpire) {
                                $evnt = 'onclick="alertMsg()"';
                                $url = 'javascript:void(0)';
                                if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                                    $langId = Yii::app()->session['lang'] = 1;
                                    $learnn = 'Timeout Lesson';
                                    $btcl = 'btn-danger';
                                } else {
                                    $langId = Yii::app()->session['lang'];
                                    $learnn = 'หมดเวลาเรียน';
                                    $btcl = 'btn-danger';
                                }
                            } else {

                                if (date($model->course_date_start) > date("Y-m-d H:i:s")) {
                                    $evnt = 'onclick="alertMsgNotNow()"';
                                    $url = 'javascript:void(0)';
                                } else {
                                    $evnt = '';
                                    $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id, 'gen' => $model->getGenID($model->course_id)));
                                }
                                if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                                    $langId = Yii::app()->session['lang'] = 1;
                                    $learnn = 'Learn Lesson';
                                    $btcl = 'btn-success';
                                } else {
                                    $langId = Yii::app()->session['lang'];
                                    $learnn = 'เข้าสู่บทเรียน';
                                    $btcl = 'btn-success';
                                }
                            }
                        } else {
                            if (date($model->course_date_start) > date("Y-m-d H:i:s")) {
                                $evnt = 'onclick="alertMsgNotNow()"';
                                $url = 'javascript:void(0)';
                            } else {
                                $evnt = '';
                                $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id, 'gen' => $model->getGenID($model->course_id)));
                            }


                            if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                                $langId = Yii::app()->session['lang'] = 1;
                                $learnn = 'Register Lesson';
                                $btcl = 'btn-primary';
                            } else {
                                $langId = Yii::app()->session['lang'];
                                $learnn = 'สมัครเรียน';
                                $btcl = 'btn-primary';
                            }
                        }


                        // $expireDate = Helpers::lib()->checkCourseExpire($model);
                        // if ($expireDate) {
                        //     $evnt = '';
                        //     $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id));
                        // } else {
                        // // $evnt = 'onclick="alertMsg(\'ระบบ\',\'หลักสูตรหมดอายุ\',\'error\')"';
                        //     if (date($model->course_date_start) > date("Y-m-d")) {
                        //         $evnt = 'onclick="alertMsgNotNow()"';
                        //         $url = 'javascript:void(0)';
                        //     } else {
                        //         $evnt = 'onclick="alertMsg()"';
                        //         $url = 'javascript:void(0)';
                        //     }
                        // }
                        $expireDate = Helpers::lib()->checkCourseExpire($model);
                            if ($expireDate) {

                                $date_start = date("Y-m-d H:i:s", strtotime($model->course_date_start));
                                $dateStartStr = strtotime($date_start);
                                $currentDate = strtotime(date("Y-m-d H:i:s"));

                                if ($currentDate >= $dateStartStr) {

                                    $chk = Helpers::lib()->getLearn($model->course_id);
                                    if ($chk) {



                                        $chk_logtime = LogStartcourse::model()->find(array(
                                            'condition' => 'course_id=:course_id and user_id=:user_id and active=:active and gen_id=:gen_id',
                                            'params' => array(':course_id' => $model->course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $model->getGenID($model->course_id))
                                        ));
                                        $course_chk_time = CourseOnline::model()->findByPk($model->course_id);


                                        if (!empty($chk_logtime)) {
                                            // if ($chk_logtime->course_day != $course_chk_time->course_day_learn) {
                                            //     $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));

                                            //     $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                            //     $chk_logtime->end_date = $Endlearncourse;
                                            //     $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                            //     $chk_logtime->save(false);
                                            // }
                                            if ($chk_logtime->end_date != $course_chk_time->course_date_end) {
                                                $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));
                                                $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                // $chk_logtime->end_date = $Endlearncourse;
                                                $chk_logtime->end_date = $course_chk_time->course_date_end;
                                                $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                                $chk_logtime->save(false);
                                            }
                                        }





                                        $expireUser = Helpers::lib()->checkUserCourseExpire($model);
                                        if (!$expireUser) {

                                            $evnt = 'onclick="alertMsg(\'' . $label->label_swal_youtimeout . '\',\'\',\'error\')"';
                                            $url = 'javascript:void(0)';
                                        } else {

                                            $evnt = '';
                                            $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id));
                                        }
                                    } else {
                                        $evnt = 'data-toggle="modal"';
                                        $url = '#modal-startcourse' . $model->course_id;
                                        // $url = '#modal-login';

                                        // $evnt = '';
                                        //   $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                                    }
                                } else {

                                    $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                                    $url = 'javascript:void(0)';
                                }
                            } elseif ($expireDate == 3) {
                                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                                $url = 'javascript:void(0)';
                            } else {
                                $date_start=$model->course_date_start;
                                $date_start=date("d/m/y", strtotime($date_start));   
                                $evnt = 'onclick="alertMsg(\'' . $Time_out . '\',\'' . $Time_out_des . ''.$date_start.'\',\'error\')"';
                                $url = 'javascript:void(0)';
                            }

                            
                    ?>
                        <div class="gallery_product col-sm-6 col-md-4 col-xs-12 filter <?= $model->cate_id ?> course-filter" style="display: none;">
                            <div class="well">
                                <!--                            <a href="course-detail.php-->
                                <a href="<?= $url; ?>" <?= $evnt ?>>
                                    <?php
                                    if (!$flag) {
                                        $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $model->course_id, 'order' => 'course_id'));
                                        if ($modelChildren) {
                                            $model->course_id = $modelChildren->course_id;
                                            $model->course_title = $modelChildren->course_title;
                                            $model->course_short_title = $modelChildren->course_short_title;
                                            $model->course_detail = $modelChildren->course_detail;
                                            $model->course_picture = $modelChildren->course_picture;
                                        }
                                    }
                                    ?>
                                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $model->course_id . '/thumb/' . $model->course_picture)) { ?>
                                        <div class="course-img">
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/courseonline/<?php echo $model->course_id . '/thumb/' . $model->course_picture; ?>" alt="">
                                        </div>
                                    <?php } else { ?>
                                        <div class="course-img">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png" alt="">
                                        </div>
                                    <?php } ?>
                                    <div class="course-detail">

                                        <?php
                                        $courseStatus = Helpers::lib()->checkCoursePass($model->id);

                                        if ($courseStatus == "notPass") {
                                            $statusLearnClass = 'muted';
                                        } else if ($courseStatus == "learning") {
                                            $statusLearnClass = 'warning';
                                        } else if ($courseStatus == "pass") {
                                            $statusLearnClass = 'success';
                                        }
                                        ?>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?= Helpers::lib()->percent_CourseGen($model->course_id, $model->getGen($model->course_id)) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h5 class="text-muted text-left"><?= Helpers::lib()->percent_CourseGen($model->course_id, $model->getGen($model->course_id)) ?>%</h5>
                                        <h4 class="text11"><?= $model->course_title ?> <?= $model->getGen($model->course_id) ?></h4>
                                        <p class="p-detail"><?= $model->course_short_title ?></p>
                                        <div class="exp-course">
                                            <small class=""><span class="text-main"><i class="fa fa-calendar text-main"></i> <?= $label->label_dateStart ?> :</span> <?php echo Helpers::lib()->DateLangTms($model->course_date_start, Yii::app()->session['lang']); ?> - <?php echo Helpers::lib()->DateLangTms($model->course_date_end, Yii::app()->session['lang']); ?></small>
                                        </div>
                                        <!-- <div class="course-time">
                                            <small class="text-muted"><i class="fa fa-clock"></i> 1 hr 30 min.</small>
                                        </div> -->
                                         <div class="text-center mt-20">
                                            <a href="<?= $url; ?>" class="btn <?= $btcl ?> btn-regislearn " <?= $evnt ?>><?= $learnn ?></a>
                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php  } ?>
                    <?php foreach ($Model as $model) {
                        if ($model->status == 1) {
                            if ($langId != 1) {
                                $modelOld = CourseOnline::model()->findByPk($model->course_id);
                                $model->course_id = $modelOld->parent_id;
                            }
                            if (!$flag) {
                                $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $model->course_id, 'order' => 'course_id'));
                                if ($modelChildren) {
                                    $model->course_title = $modelChildren->course_title;
                                    $model->course_short_title = $modelChildren->course_short_title;
                                    $model->course_detail = $modelChildren->course_detail;
                                    $model->course_picture = $modelChildren->course_picture;
                                }
                            }
                            // if ($model->parent_id != 0) {
                            //     $model->course_id = $model->parent_id;
                            // }
                            $expireDate = Helpers::lib()->checkCourseExpire($model);
                            if ($expireDate) {
                                $date_start = date("Y-m-d H:i:s", strtotime($model->course_date_start));
                                $dateStartStr = strtotime($date_start);
                                $currentDate = strtotime(date("Y-m-d H:i:s"));
                                if ($currentDate >= $dateStartStr) {
                                    $chk = Helpers::lib()->getLearn($model->course_id);
                                    if ($chk) {


                                        $chk_logtime = LogStartcourse::model()->find(array(
                                            'condition' => 'course_id=:course_id and user_id=:user_id and active=:active and gen_id=:gen_id',
                                            'params' => array(':course_id' => $model->course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $model->getGenID($model->course_id))
                                        ));
                                        $course_chk_time = CourseOnline::model()->findByPk($model->course_id);


                                        if (!empty($chk_logtime)) {
                                            // if ($chk_logtime->course_day != $course_chk_time->course_day_learn) {
                                            //     $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));

                                            //     $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                            //     $chk_logtime->end_date = $Endlearncourse;
                                            //     $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                            //     $chk_logtime->save(false);
                                            // }
                                            if ($chk_logtime->end_date != $course_chk_time->course_date_end) {
                                                $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));
                                                $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                // $chk_logtime->end_date = $Endlearncourse;
                                                $chk_logtime->end_date = $course_chk_time->course_date_end;
                                                $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                                $chk_logtime->save(false);
                                            }
                                        }



                                        $expireUser = Helpers::lib()->checkUserCourseExpire($model);
                                        if (!$expireUser) {
                                            $evnt = 'onclick="alertMsg(\'' . $labelcourse->label_swal_youtimeout . '\',\'\',\'error\')"';
                                            $url = 'javascript:void(0)';
                                        } else {
                                            $evnt = '';
                                            $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id));
                                        }
                                    } else {
                                        $evnt = '';
                                        $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id));
                // $evnt = 'data-toggle="modal"';
                // $url = '#modal-startcourse'.$value->course_id;
                                    }
                                } else {

                                    $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                                    $url = 'javascript:void(0)';
                                }
                            } elseif ($expireDate == 3) {

                                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                                $url = 'javascript:void(0)';
                            } else {
                                
                                $date_start=$model->course_date_start;
                                $date_start=date("d/m/y", strtotime($date_start));   
                                $evnt = 'onclick="alertMsg(\'' . $Time_out . '\',\'' . $Time_out_des . ''.$date_start.'\',\'error\')"';
                                $url = 'javascript:void(0)';
                            }
                            $chk = Helpers::lib()->getLearn($model->course_id);

                            if (!$chk) {
                             ?>

                                <div class="modal fade" id="modal-startcourse<?= $model->course_id ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title"><?= $Title_popup ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-8 col-sm-offset-2 text-center">
                                                        <h3><?= (Yii::app()->user->id) ? $labelcourse->label_swal_regiscourse : $labelcourse->label_detail; ?></h3>
                                                        <h2>"<?= $model->course_title ?>"</h2>
                                                        <h3>(<?= $model->CategoryTitle->cate_title ?>)</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-success" href="<?= $url ?>" <?= $evnt ?>><?= UserModule::t("Ok") ?></a>
                                                <a class="btn btn-warning" href="#" class="close" data-dismiss="modal" aria-hidden="true"><?= UserModule::t("Cancel") ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php }
} //condition status
} ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    // function alertMsg() {

    //     var title = '<?= !empty($label->label_swal_warning) ? $label->label_swal_warning : ''; ?>';
    //     var message = '<?= !empty($label->label_alert_msg_expired) ? $label->label_alert_msg_expired : ''; ?>';
    //     var alert = 'error';

    //     swal(title, message, alert);
    // }
    function alertMsg(title, message, alert) {
        swal(title, message, alert);
    }

    function alertMsgNotNow() {
        <?php
        if ($langId == 1) {
            $strDate = "Comming soon!";
        } else {
            $strDate = "ยังไม่ถึงเวลาเรียน";
        }
        ?>
        var title = '<?= !empty($label->label_swal_warning) ? $label->label_swal_warning : ''; ?>';
        var message = '<?= !empty($strDate) ? $strDate : ''; ?>';
        var alert = 'error';

        swal(title, message, alert);
    }
</script>