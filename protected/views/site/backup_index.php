<div class="page-section bg-white">
    <div class="container">
        <div class="text-center">
            <h3 class="text-display-1">หลักสูตร</h3>

            <p class="lead text-muted">หลักสูตร และหลักสูตรต่าง ๆ ในระบบ</p>
        </div>

        <br/>

        <div class="slick-basic slick-slider" data-items="4" data-items-lg="3" data-items-md="2" data-items-sm="1"
             data-items-xs="1">
            <?php
            $i = 0;
            foreach ($course_online as $course_online_data) {
                $folder = explode("_", $course_online_data->course_id);
                $imageShow = Yii::app()->request->baseUrl . '/uploads/courseonline/' . $folder[0] . '/small/' . $course_online_data->course_picture;
                ?>
                <div class="item">
                    <div class="panel panel-default paper-shadow box-course" data-z="0.5" data-hover-z="1"
                         data-animated>
                        <div class="panel-body">
                            <div class="media media-clearfix-xs">
                                <div class="media-left">
                                    <!--                                        -->
                                    <div class="cover width-90 width-100pc-xs overlay cover-image-full hover">
                                        <span class="img icon-block s90 bg-default"></span>
                                        <!--                                            -->
                                        <?php if ($course_online_data->course_picture != "") { ?>
                                            <span class="overlay overlay-full padding-none icon-block s90 bg-default">
                        <span class="v-center">
                           <img src="<?= $imageShow; ?>" class="img-responsive" style="height: 90px; width: 90px;">
                        </span>
                                        </span>
                                        <?php } else { ?>
                                            <span class="overlay overlay-full padding-none icon-block s90 bg-default">
                        <span class="v-center">
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course2.png"
                                 class="img-responsive">
                        </span>
                                        </span>
                                        <?php }?>
                                        <!--                                            -->
                                        <a href="<?php echo $this->createUrl('course/detail',array("id"=>$course_online_data->course_id)); ?>"
                                           class="overlay overlay-full overlay-hover overlay-bg-white">
                                            <span class="v-center">
                            <span class="btn btn-circle btn-white btn-lg"><i class="fa fa-graduation-cap"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                    <!--                                        -->
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading margin-v-5-3"><a
                                            href="<?php echo $this->createUrl('course/detail',array("id"=>$course_online_data->course_id)); ?>">
                                            <?= iconv_substr($course_online_data->course_title, 0, 100, 'utf-8'); ?>
                                        </a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++;
            } ?>
        </div>

        <div class="text-center">
            <br/>
            <a class="btn btn-lg btn-primary" href="<?php echo $this->createUrl('course/index'); ?>">หลักสูตรทั้งหมด</a>
        </div>
    </div>
</div>