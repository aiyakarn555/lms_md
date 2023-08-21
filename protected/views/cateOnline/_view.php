<div class="item col-xs-12 col-sm-6 col-lg-4">
    <div class="panel panel-default paper-shadow" data-z="0.5">
        <div class="cover overlay cover-image-full hover">

            <span class="img icon-block height-150 bg-default"></span>
            <a href="#" class="padding-none overlay overlay-full icon-block bg-default">
                                        <span class="v-center">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course.png">
            </span>
            </a>
            <a href="<?php echo $this->createUrl('course/detail'); ?>" class="overlay overlay-full overlay-hover overlay-bg-white">
                                        <span class="v-center">
                <span class="btn btn-circle btn-white btn-lg"><i class="fa fa-graduation-cap"></i></span>
                                        </span>
            </a>
        </div>
        <div class="panel-body height-100">
            <h5><?php echo CHtml::link($data->cate_title,array("//courseOnline/index","id"=>$data->cate_id))?></h5>
        </div>
        <hr class="margin-none" />
        <div class="panel-body">
            <div class="media v-middle">
                <div class="media-body">
                    <p style="text-align: right;"><?php echo $data->CountCourse; ?> บทเรียน</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!--<section id="pgc-21-1-0" class="flx-meet-team panel-grid-cell" style="float:left;">-->
<!--    <div class="list-carousel responsive" >-->
<!---->
<!--        <ul>-->
<!--            <li style="float: none;">-->
<!--                <article class="flx-team">-->
<!--                    <a class="team-avatar" href="#">-->
<!--                        --><?php
//                        $imageCateCourse = Controller::ImageShowIndex(Yush::SIZE_THUMB,$data,$data->cate_image,array());
//                        $imageCateCourseCheck = str_replace("cateonline","category",$imageCateCourse);
//                        echo CHtml::link($imageCateCourseCheck, array('//courseOnline/index','id'=>$data->cate_id),array(
//                            'class'=>'thumbnail'
//                        ));
//                        ?>
<!--                    </a>-->
<!--                    <div class="subj-course" style="line-height: 2.5; margin-top: 15px;">-->
<!--                        <h5>--><?php //echo CHtml::link($data->cate_title,array("//courseOnline/index","id"=>$data->cate_id))?><!--</h5>-->
<!--                        <span>--><?php //echo $data->CountCourse; ?><!-- บทเรียน</span>-->
<!--                        <div style="clear: both"></div>-->
<!--                        --><?php
//                        /*echo CHtml::link('รายละเอียดหลักสูตร',array("//courseOnline/index","id"=>$data->cate_id),array(
//                                    'class'=>'btn btn-success btn-icon glyphicons ok_2'
//                        ));*/
//                        // echo CHtml::link('รายละเอียดหลักสูตร',array('//cateOnline/view', 'id'=>$data->cate_id),array(
//                        // 			'class'=>'btn btn-success btn-icon glyphicons ok_2'
//                        // ));
//                        ?>
<!--                    </div>-->
<!---->
<!--                </article><!--end:flx-team-->
<!--            </li>-->
<!--        </ul><!--end:flx-team-slides-->
<!--    </div><!--end:list-carousel-->
<!--</section><!--end:flx-meet-team-->

