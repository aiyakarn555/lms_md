<div class="parallax bg-white page-section">
    <div class="parallax-layer container" data-opacity="true">
        <div class="media v-middle">
            <div class="media-left">
                    <span class="icon-block s60 bg-default">
                    <?php echo Controller::ImageShowIndex(Yush::SIZE_SMALL, $course, $course->course_picture,
                        array('style' => 'height: 60px;', 'class' => 'img-responsive'),
                        'logo_course2.png'
                    ); ?>
                    </span>
            </div>
            <div class="media-body">
                <h1 class="text-display-1 margin-none"><?php echo $course->course_title; ?></h1>
            </div>
            <div class="media-right">
                <a class="btn btn-white" style="font-size: 22px;"
                   href="<?php echo $this->createUrl('course/index'); ?>">รวมหลักสูตร</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-9 col-md-8">
            <div class="page-section">
                <div class="panel panel-default paper-shadow" data-z="0.5" data-hover-z="1" data-animated>
                    <div class="panel-body">
                        <div class="width-300 width-250-md width-50pc-xs paragraph-inline">
                            <?php echo Controller::ImageShowIndex(Yush::SIZE_THUMB, $course, $course->course_picture,
                                array('class' => 'img-responsive')
                            ); ?>
                        </div>
                        <?php
                        echo CHtml::decode($course->course_detail);
                        ?>
                        <!-- <p class="margin-none">
                            <span class="label bg-gray-dark">Color</span>
                            <span class="label label-grey-200">Technologies</span>
                            <span class="label label-grey-200">ASCs</span>
                        </p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="page-section">
                <!-- .panel -->
                <div class="panel panel-primary paper-shadow" data-z="0.5" data-hover-z="1" data-animated>
                    <div class="panel-heading">
                        <h4 class="text-headline" style="font-size: 27px;font-weight: bold;">หลักสูตร</h4>
                    </div>
                    <div class="panel-body">
                        <p class="text-caption" style="font-size: 22px;">
                            <!-- <i class="fa fa-clock-o fa-fw"></i> 4 ชั่วโมง &nbsp; -->
                            <i class="fa fa-calendar fa-fw"></i> <?php echo Yii::app()->getDateFormatter()->format("dd/MM/yyyy", $course->create_date); ?>
                            <br/><br/>
                            <?php $teacher = Teacher::model()->findByPk($course->course_lecturer); ?>
                            <i class="fa fa-user fa-fw"></i> วิทยากร
                            : <?php echo (isset($teacher->teacher_name)) ? $teacher->teacher_name : '-'; ?>
                            <!-- <br/>
                            <i class="fa fa-mortar-board fa-fw"></i> จำนวนผู้เข้าเรียน : 50
                            <br/>
                            <i class="fa fa-check fa-fw"></i> จำนวนผู้เรียนผ่าน : 30 -->
                        </p>
                    </div>
                    <div class="panel-body">
                        <p class="text-caption" style="font-size: 20px;">
                            <!-- <i class="fa fa-clock-o fa-fw"></i> 4 ชั่วโมง &nbsp; -->
                            <strong>สถานะการเรียน</strong>
                            <?php
                            if (!Yii::app()->user->isGuest) {
                                $userObject = Yii::app()->getModule('user')->user();
                                if ($userObject->orgcourses) {

                                    //var_dump(Helpers::lib()->CheckCourseNextPass($course->id,$userObject->department_id));
                                    $status_course = Helpers::lib()->CheckCourseNextPass($course->id, $userObject->department_id);
                                    if ($status_course == "pass") {
                                        echo "<span style='color:green;'>ผ่านหลักสูตร</span>";
                                    } elseif ($status_course == "notLearn") {
                                        echo "<span style='color:blue;'>เริ่มหลักสูตร</span>";
                                    } elseif ($status_course == "canLearn") {
                                        echo "<span style='color:blue;'>เริ่มหลักสูตร</span>";
                                    } elseif ($status_course == "backLearn") {
                                        echo "<span style='color:red;'>ยังไม่สามารถเรียนหลักสูตรนี้ได้</span>";
                                    } else {
                                        echo "<span style='color:red;'>ยังไม่ได้เรียนหลักสูตร</span>";
                                    }


                                }
                            }
                            ?>
                        </p>
                    </div>
                    <hr class="margin-none"/>

                    <?php
                    if ($status_course == "pass" || $status_course == "notLearn" || $status_course == "canLearn" || is_null($status_course)) {
                        ?>
                        <div class="panel-body text-center">
                            <p><a class="btn btn-success btn-lg paper-shadow relative" data-z="1" data-hover-z="2"
                                  data-animated
                                  href="<?php echo $this->createUrl('course/lesson', array('id' => $course->course_id)); ?>">เริ่มหลักสูตร</a>
                            </p>
                        </div>
                    <?php
                    }
                    ?>





                    <!-- <ul class="list-group">
                        <li class="list-group-item">
                            <a href="#" class="text-light"><i class="fa fa-facebook fa-fw"></i> Share on facebook</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="text-light"><i class="fa fa-twitter fa-fw"></i> Tweet this course</a>
                        </li>
                    </ul> -->
                </div>
                <!-- // END .panel -->
                <!-- .panel -->
                <!-- <div class="panel panel-default paper-shadow" data-z="0.5" data-hover-z="1" data-animated>
                    <div class="panel-body">
                        <div class="media v-middle">
                            <div class="media-left">
                                <img src="images/people/110/guy-6.jpg" alt="About Adrian" width="60" class="img-circle" />
                            </div>
                            <div class="media-body">
                                <h4 class="text-title margin-none"><a href="#">Adrian Demian</a></h4>
                                <span class="caption text-light">Biography</span>
                            </div>
                        </div>
                        <br/>
                        <div class="expandable expandable-indicator-white expandable-trigger">
                            <div class="expandable-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus aut consectetur consequatur cum cupiditate debitis doloribus, error ex explicabo harum illum minima mollitia nisi nostrum officiis omnis optio qui quisquam saepe sit sunt totam vel velit voluptatibus? Adipisci ducimus expedita id nostrum quas quia!</p>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- // END .panel -->
            </div>
            <!-- // END .page-section -->
        </div>
    </div>
</div>