<style>
    .text-subhead {
        font-size: 1.50rem;
    }

    .text-caption {
        font-size: 1.2rem;
        font-weight: 400;
    }
    thead{
        background-color: #42A5F5;
    }
</style>
<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i
                        class="fa fa-tachometer"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">Dashboard</h3>
                <p class="text-white text-subhead" style="font-size: 1.6rem;">รวมหลักสูตร การทำงานของ Product ของ
                    Brother</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-12">
                <div class="row" data-toggle="isotope">
                    <div class="item col-xs-12 col-lg-6">
                        <!-- <h4 class="margin-none">ความเคลื่อนไหวเว็บบอร์ด</h4>

                        <p class="text-subhead text-light">Latest forum topics & comments</p> -->
                        <div class="panel panel-primary paper-shadow" data-z="0.5">
                            <div class="panel-heading">
                                <h4 class="margin-none" style="color: white;font-weight: bold;">เว็บบอร์ด</h4>

                                <p class="text-subhead text-light" style="color: white;">ความเคลื่อนไหวเว็บบอร์ด</p>
                            </div>
                        <ul class="list-group relative paper-shadow" data-hover-z="0.5" data-animated>
                            <?php
                            function dateDiv($t1, $t2)
                            { // ส่งวันที่ที่ต้องการเปรียบเทียบ ในรูปแบบ มาตรฐาน 2006-03-27 21:39:12
                                $t1Arr = splitTime($t1);
                                $t2Arr = splitTime($t2);
                                $Time1 = mktime($t1Arr["h"], $t1Arr["m"], $t1Arr["s"], $t1Arr["M"], $t1Arr["D"], $t1Arr["Y"]);
                                $Time2 = mktime($t2Arr["h"], $t2Arr["m"], $t2Arr["s"], $t2Arr["M"], $t2Arr["D"], $t2Arr["Y"]);
                                $TimeDiv = abs($Time2 - $Time1);
                                $Time["D"] = intval($TimeDiv / 86400); // จำนวนวัน
                                $Time["H"] = intval(($TimeDiv % 86400) / 3600); // จำนวน ชั่วโมง
                                $Time["M"] = intval((($TimeDiv % 86400) % 3600) / 60); // จำนวน นาที
                                $Time["S"] = intval(((($TimeDiv % 86400) % 3600) % 60)); // จำนวน วินาที
                                return $Time;
                            }

                            function splitTime($time)
                            { // เวลาในรูปแบบ มาตรฐาน 2006-03-27 21:39:12
                                $timeArr["Y"] = substr($time, 2, 2);
                                $timeArr["M"] = substr($time, 5, 2);
                                $timeArr["D"] = substr($time, 8, 2);
                                $timeArr["h"] = substr($time, 11, 2);
                                $timeArr["m"] = substr($time, 14, 2);
                                $timeArr["s"] = substr($time, 17, 2);
                                return $timeArr;
                            }

                            ?>
                            <?php
                            $i = 0;
                            foreach ($forum as $forum_data) {
                                ?>
                                <li class="list-group-item paper-shadow">
                                    <div class="media v-middle">
                                        <div class="media-left">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course2.png"
                                                 alt="person"
                                                 class="img-circle width-40"/>
                                        </div>
                                        <div class="media-body">
                                            <?php echo CHtml::link(CHtml::encode($forum_data->forum->name), array('forum/forum/forum', 'id' => $forum_data->forum->id, 'class' => 'link-text-color')); ?>

                                            <div class="text-light">
                                                Topic: <?php echo CHtml::link(CHtml::encode($forum_data->topic->title), array('forum/forum/topic', 'id' => $forum_data->topic->id), array('class' => $forum_data->topic->hasPostedClass())); ?>
                                                &nbsp;
                                                By: <a href="#"><?= $forum_data->poster->member_name; ?></a>
                                            </div>
                                        </div>
                                        <div class="media-right">
                                            <div class="width-100 text-right">
                                                <?php
                                                $t2 = date("Y-m-d H:i:s");
                                                $t1 = $forum_data->create_time;
                                                $time = dateDiv($t1, $t2);
                                                ?>
                                                <span class="text-caption text-light">
                                            <?php if ($time[D] != "") { ?>
                                                <?php echo $time[D]; ?> day
                                            <?php }
                                            if ($time[H] != "") { ?>
                                                <?php echo $time[H]; ?> hr
                                            <?php } ?>
                                                    <?php echo $time[M]; ?> min
                                          </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php $i++;
                            } ?>
                        </ul>
                    </div>
                    </div>
                    <div class="item col-xs-12 col-lg-6">
                        <div class="panel panel-primary paper-shadow" data-z="0.5">
                            <div class="panel-heading">
                                <h4 class="margin-none" style="color: white;font-weight: bold;">หลักสูตร</h4>

                                <p class="text-subhead text-light" style="color: white;">หลักสูตรทั้งหมดที่ต้องเรียน</p>
                            </div>
                            <ul class="list-group">
                                <?php

                                foreach ($course_online->getData() as $cs) {
                                    $lesson = Lesson::model()->findAll('course_id=' . $cs->course_id . ' AND active="y"');
                                    $count_lesson = count($lesson);

                                    $i = 1;
                                    $pass = 0;
                                    $learning = 0;
                                    $notlearn = 0;
                                    foreach ($lesson as $lessonCurrent) {
                                        $lessonStatus = Helpers::lib()->checkLessonPass($lessonCurrent);
//                                        $check = Helpers::lib()->CheckTestCount('pass', $lessonCurrent->id);
                                        if ($lessonStatus == "pass") {
                                            $pass = $pass + 1;
                                        }
                                        if ($lessonStatus == "learning") {
                                            $learning = $learning + 1;
                                        }
                                        if ($lessonStatus == "notLearn") {
                                            $notlearn = $notlearn + 1;
                                        }
                                        $i++;
                                    }
                                    $per = ($pass / $count_lesson) * 100;
                                    ?>
                                    <li class="list-group-item media v-middle">
                                        <div class="media-body">
                                            <a href="<?=Yii::app()->createUrl('course/detail',array('id'=>$cs->course_id))?>" class="text-subhead list-group-link">
                                                <?php echo $cs->course_title; ?> <?= $cs->getGen($cs->course_id); ?>
                                            </a>
                                            <br>
                                            <p style="font-size:18px;">เรียนแล้ว <label style="color: #00A000; font-weight: 600;"><?=$pass?></label> : ยังไม่เรียน <label style="color: red; font-weight: 600;"><?=$notlearn?> </label> : กำลังเรียน <label><?php echo $learning?></label></p>
                                        </div>

                                        <div class="media-right" align="center">
                                            <?php echo "<label style=\"color: #00A000; font-weight: 600;\">" . $pass . "</label> จาก <label style=\"color: #00A000; font-weight: 600;\">" . $count_lesson ."</label>"?>
                                            <div class="progress progress-mini width-100 margin-none">
                                                <div class="progress-bar progress-bar-green-300" role="progressbar"
                                                     aria-valuenow="<?php echo $per; ?>" aria-valuemin="0"
                                                     aria-valuemax="100"
                                                     style="width:45%;">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="margin-none" style="color: white;font-weight: bold;">ผลการเรียน</h4>
                        <p class="text-subhead text-light" style="color: white;">ผลการเรียน</p>
                    </div>
                </div>
                    <div class="panel-group" id="accordion" style="margin-top: 10px;">
                        <?php
                        $j=0;
                        foreach ($course_online->getData() as $cs) {
                        $j++;
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="col-md-10" style="padding-top: 12px;">
                                        <a class="" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapse<?=$j?>">
                                            <h4 class="panel-title panel-title-adjust">
                                                <!-- หลักสูตร: หลักสูตรการทำงานเป็นทีม -->
                                                หลักสูตร: <?php echo $cs->course_title; ?> <?= $cs->getGen($cs->course_id); ?>
                                            </h4>
                                        </a>
                                    </div>
                                    <!--    <div class="col-md-2" style="text-align: right;" id="btn_<?php //echo $cs->course_id; ?>">
                        <a href="survey.php" class="btn btn-success">ทำแบบประเมิน</a>
                    </div> -->
                                    <div class="clearfix"></div>
                                </div>
                                <div style="height: auto;" id="collapse<?=$j?>" class="panel-collapse collapse <?php echo $j==1?'in':'' ?>">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table v-middle table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">บทเรียน</th>
                                                    <th class="text-center">สถานะการเรียน</th>
                                                    <th class="text-center">แบบทดสอบ</th>
                                                    <th class="text-center">แบบสอบถาม</th>
                                                    <th class="text-center">ผลการสอบ(คะแนนที่ดีที่สุด)</th>
                                                </tr>
                                                </thead>
                                                <tbody id="responsive-table-body">
                                                <?php
                                                $_Score = 0;
                                                $scoreCheck = 0;
                                                $totalCheck = 0;
                                                $PassCoutCheck = 0;

                                                $lesson = Lesson::model()->findAll('course_id=' . $cs->course_id . ' AND active="y"');
                                                $count_lesson = count($lesson);
                                                $check = "pass";
                                                foreach ($lesson as $lessonCurrent) {

                                                    // echo $checkPass

                                                    //========== เช็คว่าสอบครบทุกบทหรือยัง ==========//
                                                    $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
                                                        "user_id"   => Yii::app()->user->id,
                                                        "lesson_id" => $lessonCurrent->id
                                                    ));
                                                    if( $countScore >= "1" )
                                                    {
                                                        $_Score = $_Score+1;
                                                    }
                                                    //========== SUM ==========//
                                                    $scoreSum   = Helpers::lib()->ScorePercent($lessonCurrent->id);
                                                    $scoreToTal = Helpers::lib()->ScoreToTal($lessonCurrent->id);

                                                    if(!empty($scoreSum)) //ถ้ามีการคิดคะแนน
                                                    {
                                                        $CheckSumOK = $scoreSum;
                                                    }
                                                    else //ถ้าไม่มีการคิดคะแนน
                                                    {
                                                        $CheckSumOK = 0;
                                                    }

                                                    if(!empty($scoreToTal))
                                                    {
                                                        $CheckToTalOK = $scoreToTal;
                                                    }
                                                    else
                                                    {
                                                        $CheckToTalOK = 0;
                                                    }

                                                    $totalCheck = $totalCheck+$CheckToTalOK;
                                                    $scoreCheck = $scoreCheck+$CheckSumOK;

                                                    if(Helpers::lib()->CheckTestCount($lessonStatus,$lessonCurrent->id,false,false) == true)
                                                    {
                                                        $PassCoutCheck = $PassCoutCheck+1;
                                                    }

                                                    $sumTotal = $scoreCheck*100;
                                                    if (!empty($totalCheck))
                                                    {
                                                        $sumTotal = $sumTotal/$totalCheck;
                                                    }

                                                    $model_score = Score::model()->find(array(
                                                        'condition' => 'lesson_id=' . $lessonCurrent->id,
                                                    ));
                                                    if ($model_score) {
                                                        $ModdelOnline = CourseOnline::model()->findByPk($model_score->Lessons->course_id);
                                                        $sumPoint = number_format($model_score->score_number / $model_score->score_total * 100, 2);
                                                        if ($model_score->score_past == 'n') {
                                                            $textPast = '<font color="#CC0000"><b>ไม่ผ่าน</b></font>';
                                                        } else {
                                                            $textPast = '<font color="#00994D"><b>ผ่าน</b></font>';
                                                        }
                                                    }

                                                    $lessonStatus = Helpers::lib()->checkLessonPass($lessonCurrent);

                                                    if($lessonStatus == "notLearn")
                                                    {
                                                        $statusValue = '<span style="color:red;">ยังไม่ได้เรียน</span>';
                                                    }
                                                    else if($lessonStatus == "learning")
                                                    {
                                                        $statusValue = '<span style="color:blue;">กำลังเรียน</span>';
                                                    }
                                                    else if($lessonStatus == "pass")
                                                    {
                                                        $statusValue = '<span style="color:green;">เรียนผ่าน</span>';
                                                    }


                                                    $CheckTestPast = Helpers::lib()->CheckTestCount($lessonStatus, $lessonCurrent->id, false);

                                                    if ($CheckTestPast == false) {
                                                        $checkPass = Helpers::lib()->CountTestIng($lessonStatus, $lessonCurrent->id, $lessonCurrent->cate_amount);
                                                        $checkPass_reset = Helpers::lib()->CountTestIngTF($lessonStatus, $lessonCurrent->id, $lessonCurrent->cate_amount);
                                                    } else {
                                                        $checkPass = '-';
                                                    }

                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?=Yii::app()->createUrl("course/lesson",array('id'=>$cs->course_id,'lesson_id'=>$lessonCurrent->id));?>"><?php echo $lessonCurrent->title; ?></a>
                                                            </td>
                                                        <td class="text-center"><a href="<?=Yii::app()->createUrl("course/lesson",array('id'=>$cs->course_id,'lesson_id'=>$lessonCurrent->id));?>"><?=$statusValue; ?></a></td>
                                                        <td class="text-center">
                                                            <?= Helpers::lib()->CheckTestCount($lessonStatus, $lessonCurrent->id, true) ?>
                                                        </td>


                                                        <td  class="text-center">
                                                            <?php
                                                            if ($CheckTestPast === true) {

                                                                $questAns = QQuestAns::model()->find("user_id='" . Yii::app()->user->id . "' AND lesson_id='" . $lessonCurrent->id . "' AND header_id='" . $lessonCurrent->header_id . "'");
                                                                if (!$questAns) {
                                                                    ?>
                                                                        <p style="font-weight: normal;color: #045BAB;"><?= (($lessonCurrent->header_id != '') ? CHtml::link('ทำแบบสอบถาม', array('//questionnaire/index', 'id' => $lessonCurrent->id),array('class'=>'btn btn-primary')) : '<label class="label label-warning" style="font-size: medium; letter-spacing: 2px !important;">ไม่มีแบบสอบถาม</label>') ?></p>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                            <label class="label label-success" style="font-size: medium; letter-spacing: 2px !important;">
                                                                            คุณทำแบบสอบถามแล้ว</label>
                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($lessonStatus == 'pass') {
                                                                    ?>
                                                                        <p style="font-weight: normal;color: #045BAB;"><?= (($lessonCurrent->header_id != '') ? CHtml::link('ทำแบบสอบถาม', array('//questionnaire/index', 'id' => $lessonCurrent->id),array('class'=>'btn btn-primary')) : '<label class="label label-warning" style="font-size: medium; letter-spacing: 2px !important;">ไม่มีแบบสอบถาม</label>') ?></p>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <p style="font-weight: normal;color: #045BAB;"><?= (($lessonCurrent->header_id != '') ? '<label class="label label-danger" style="font-size: medium; letter-spacing: 2px !important;">ต้องเรียนให้ผ่านก่อน</label>' : '<label class="label label-warning" style="font-size: medium; letter-spacing: 2px !important;">ไม่มีแบบสอบถาม</label>') ?></p>
                                                                    <?php
                                                                }
                                                            }

                                                            ?>

                                                        </td>

                                                        <td class="text-center"><?=$scoreSum.' / '.$scoreToTal?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>


                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--    <div class="panel panel-warning">
                                   <div class="panel-heading">
                                       <div class="col-md-10" style="padding-top: 12px;">
                                           <a class="" data-toggle="collapse" data-parent="#accordion"
                                              href="#collapse2">
                                               <h4 class="panel-title panel-title-adjust">
                                                   หลักสูตร: หลักสูตรการทำงานเป็นทีม
                                               </h4>
                                           </a>
                                       </div>
                                       <div class="col-md-2" style="text-align: right;">
                                           <button type="button" class="btn btn-danger" disabled="disabled">
                                               ทำแบบประเมิน
                                           </button>
                                       </div>
                                       <div class="clearfix"></div>
                                   </div>
                                   <div style="height: auto;" id="collapse2" class="panel-collapse collapse">
                                       <div class="panel-body">
                                           <div class="table-responsive">
                                               <table class="table v-middle table-bordered">
                                                   <thead>
                                                   <tr>
                                                       <th class="text-center" width="60%">บทเรียน</th>
                                                       <th class="text-center" width="20%">สถานะการเรียน</th>
                                                       <th class="text-center" width="20%">ผลการสอบ</th>
                                                   </tr>
                                                   </thead>
                                                   <tbody id="responsive-table-body">
                                                   <tr>
                                                       <td>บทที่ 1 แนะนำบทเรียน</td>
                                                       <td class="text-center"><span style="color: rgb(255, 180, 0);">กำลังเรียน</span>
                                                       </td>
                                                       <td class="text-center">-</td>
                                                   </tr>
                                                   <tr>
                                                       <td>บทที่ 2 บทที่หนึ่ง</td>
                                                       <td class="text-center">-</td>
                                                       <td class="text-center">-</td>
                                                   </tr>
                                                   <tr>
                                                       <td>บทที่ 2 บทที่สอง</td>
                                                       <td class="text-center">-</td>
                                                       <td class="text-center">-</td>
                                                   </tr>
                                                   </tbody>
                                               </table>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="panel panel-danger">
                                   <div class="panel-heading">
                                       <div class="col-md-10" style="padding-top: 12px;">
                                           <a class="" data-toggle="collapse" data-parent="#accordion"
                                              href="#collapse3">
                                               <h4 class="panel-title panel-title-adjust">
                                                   หลักสูตร: หลักสูตรการทำงานเป็นทีม
                                               </h4>
                                           </a>
                                       </div>
                                       <div class="col-md-2" style="text-align: right;">
                                           <button type="button" class="btn btn-danger" disabled="disabled">
                                               ทำแบบประเมิน
                                           </button>
                                       </div>
                                       <div class="clearfix"></div>
                                   </div>
                                   <div style="height: auto;" id="collapse3" class="panel-collapse collapse">
                                       <div class="panel-body">
                                           <div class="table-responsive">
                                               <table class="table v-middle table-bordered">
                                                   <thead>
                                                   <tr>
                                                       <th class="text-center" width="60%">บทเรียน</th>
                                                       <th class="text-center" width="20%">สถานะการเรียน</th>
                                                       <th class="text-center" width="20%">ผลการสอบ</th>
                                                   </tr>
                                                   </thead>
                                                   <tbody id="responsive-table-body">
                                                   <tr>
                                                       <td>บทที่ 1 แนะนำบทเรียน</td>
                                                       <td class="text-center">-</td>
                                                       <td class="text-center">-</td>
                                                   </tr>
                                                   <tr>
                                                       <td>บทที่ 2 บทที่หนึ่ง</td>
                                                       <td class="text-center">-</td>
                                                       <td class="text-center">-</td>
                                                   </tr>
                                                   <tr>
                                                       <td>บทที่ 2 บทที่สอง</td>
                                                       <td class="text-center">-</td>
                                                       <td class="text-center">-</td>
                                                   </tr>
                                                   </tbody>
                                               </table>
                                           </div>
                                       </div>
                                   </div>
                               </div> -->
                            <?php
                        }
                        ?>
                    </div>
            </div>
        </div>
    </div>
</div>
