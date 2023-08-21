<div class="parallax overflow-hidden page-section bg-dbd-p">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block halfpanel panel-primary text-white" style="height: 45px;"><i
                        class="fa fa-fw fa-book"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">หลักสูตร</h3>

                <p class="text-white text-subhead" style="font-size: 1.6rem;">
                    รวมหลักสูตร DBD Academy
                </p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-9">
                <div class="row" data-toggle="isotope">
                    <?php
                    $i = 0;
                    foreach ($course_online->getData() as $course_online_data) {
                        $i++;
                        ?>
                        <div class="item col-xs-12 col-sm-6 col-lg-4">
                            <div class="panel panel-default paper-shadow" data-z="0.5"
                                 style="z-index:<?php echo '100' - $i; ?>;">
                                <div class="cover overlay cover-image-full hover">
                                    <span class="img icon-block height-150 bg-primary"></span>
                                    <a href="<?php echo $this->createUrl('course/detail', array('id' => $course_online_data->course_id)); ?>"
                                       class="padding-none overlay overlay-full icon-block bg-primary">
                                        <span class="v-center">
                                            <?php echo Controller::ImageShowIndex(Yush::SIZE_THUMB, $course_online_data, $course_online_data->course_picture, array('height' => '150px')); ?>
                                            <i class="fa fa-css3"></i>
            </span>
                                    </a>
                                    <a href="<?php echo $this->createUrl('course/detail', array('id' => $course_online_data->course_id)); ?>"
                                       class="overlay overlay-full overlay-hover overlay-bg-white">
                                        <span class="v-center">
                <span class="btn btn-circle btn-primary btn-lg"><i class="fa fa-graduation-cap"></i></span>
                                        </span>
                                    </a>
                                </div>
                                <div class="expandable expandable-indicator-white expandable-trigger">
                                    <div class="expandable-content">
                                        <div class="panel-body">
                                            <h4 class="text-headline margin-v-0-10" style="font-size: 23px;"><a
                                                    href="<?php echo $this->createUrl('course/detail', array('id' => $course_online_data->course_id)); ?>"><?= $course_online_data->course_title; ?></a> <?php if (Helpers::lib()->checkCoursePass($course_online_data->course_id) == "pass") { ?>
                                                    <i class="fa fa-check-circle text-success"></i><?php } ?>
                                            </h4>
                                        </div>
                                        <hr class="margin-none"/>
                                        <div class="panel-body">
                                            <p style="font-size: 1.5rem;color: rgb(20, 20, 20);"><?= iconv_substr($course_online_data->course_short_title, 0, 100, 'utf-8'); ?></p>

                                            <div class="media v-middle">
                                                <div class="media-left">
                                                    <?php $teacher = Teacher::model()->findByPk($course_online_data->course_lecturer);
                                                    $nameAdmin = Yii::app()->getModule('user')->user();
                                                    $registor = new RegistrationForm;
                                                    $registor->id = $nameAdmin->id;
                                                    $teacher->id = $teacher->teacher_id;
                                                    ?>
                                                    <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $teacher, $teacher->teacher_picture, $registor, array('class' => 'img-circle width-40')); ?>
                                                </div>
                                                <div class="media-body">
                                                    <h4><a href=""><?= $teacher->teacher_name; ?></a>
                                                        <br/>
                                                    </h4>
                                                    <span style="font-size: 19px;">ชื่อวิทยากร</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                </div>
                <br/>
                <br/>
            </div>
            <div class="col-md-3">
                <?php echo CHtml::form(Yii::app()->createUrl($this->route), 'post'); ?>
                <div class="panel panel-dbd" data-toggle="panel-collapse" data-open="true">
                    <div class="panel-heading panel-collapse-trigger">
                        <h4 class="panel-title" style="font-weight: bold;">ค้นหา</h4>
                    </div>
                    <div class="panel-body">
                        <!-- <div class="form-group input-group margin-none">
                            <div class="row margin-none">
                                <div class="col-xs-12 padding-none">
                                    <input class="form-control" type="text" name="search_text" placeholder="คำค้นหา"
                                           value="<?php echo $_POST['search_text']; ?>"/>
                                </div>
                            </div>
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div> -->
                        <div class="input-group">
      <input type="text" class="form-control" placeholder="คำค้นหา..." value="<?php echo $_POST['search_text']; ?>">
      <span class="input-group-btn">
        <button class="btn btn-warning" type="submit"><span class="fa fa-search"></span></button>
      </span>
    </div>
                    </div>
                </div>
                <?php echo CHtml::endForm(); ?>
                <h4 style="font-weight: bold;">หลักสูตรแนะนำ</h4>

                <div class="slick-basic slick-slider" data-items="1" data-items-lg="1" data-items-md="1"
                     data-items-sm="1"
                     data-items-xs="1">
                    <?php
                    if ($course_online->getData()) {
                        foreach ($course_online->getData() as $course_online_data) {
                            if ($course_online_data->recommend == "y") {
                                ?>

                                <div class="item">
                                    <div class="panel panel-default paper-shadow box-course" data-z="0.5"
                                         data-hover-z="1"
                                         data-animated>
                                        <div class="panel-body">
                                            <div class="media media-clearfix-xs">
                                                <div class="media-left">
                                                    <div
                                                        class="cover width-90 width-100pc-xs overlay cover-image-full hover">
                                                        <span class="img icon-block s90 bg-default"></span>
                                        <span class="overlay overlay-full padding-none icon-block s90 bg-default">
                                            <span class="v-center">
                                                <?php echo Controller::ImageShowIndex(Yush::SIZE_SMALL, $course_online_data, $course_online_data->course_picture,
                                                    array('style' => 'height: 90px; width: 90px;', 'class' => 'img-responsive'),
                                                    'logo_course2.png'
                                                ); ?>
                                            </span>
                                        </span>
                                                        <a href="<?php echo $this->createUrl('course/detail', array('id' => $course_online_data->course_id)); ?>"
                                                           class="overlay overlay-full overlay-hover overlay-bg-white">
                                            <span class="v-center">
                            <span class="btn btn-circle btn-white btn-lg"><i class="fa fa-graduation-cap"></i></span>
                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading margin-v-5-3"><a
                                                            href="<?php echo $this->createUrl('course/detail', array('id' => $course_online_data->course_id)); ?>"><?= iconv_substr($course_online_data->course_title, 0, 100, 'utf-8'); ?></a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php }
                        }
                    } ?>


                </div>
            </div>
        </div>
    </div>
</div>