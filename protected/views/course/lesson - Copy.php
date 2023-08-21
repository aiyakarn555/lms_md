<?php

$baseUrl = Yii::app()->baseUrl;

?>
    <link href="<?php echo $baseUrl; ?>/js/video-js/video-js.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $baseUrl; ?>/admin/css/prettyPhoto.css" rel="stylesheet" type="text/css">
    <!-- <link href="<?php echo $baseUrl; ?>/js/video-js/splitter/src/touchsplitter.css" rel="stylesheet"/> -->
    <!-- <script src="<?php echo $baseUrl; ?>/js/video-js/splitter/src/jquery.touchsplitter.js"></script> -->
    <script src="<?php echo $baseUrl; ?>/js/video-js/video.js"></script>
    <script src="<?php echo $baseUrl; ?>/admin/js/jquery.prettyPhoto.js"></script>
    <style type="text/css">

        .video-js {
            max-width: 100%
        }

        /* the usual RWD shebang */

        .video-js {
            width: auto !important; /* override the plugin's inline dims to let vids scale fluidly */
            height: auto !important;
        }

        .video-js video {
            position: relative !important;
        }

        /* The video should expand to force the height of the containing div.
        One in-flow element is good. As long as everything else in the container
        div stays `position: absolute` we're okay */
        /*.split-me>div{*/
        /*background: #444;*/
        /*}*/
        .split-me > div:first-child {
            background: #555;
        }

        .split-me > div:last-child {
            background: #666;
        }

        .vjs-progress-control {
            display: none;
        }

        .split-me-container {
            position: absolute;
            top: 3em;
            left: 1em;
            right: 1em;
            bottom: 1em;
            border-radius: 6px;
            overflow: hidden;
        }

        .splitter-bar {
            background: #333;
        }

        .showslidethumb {
        / / width : 600 px;
            /*height:200px;*/

            height: 144px;
            margin-top: 16px;
        / / margin : 100 px auto;
            background: #A3CBE0;
            border: 2px solid #000;
            overflow-x: auto;
            overflow-y: hidden;
            box-shadow: 0 0 10px #000;
        }

        /* article.blog-post .post-content .showslidethumb img {
            height: 108px;
            cursor: pointer;
        } */

        .showslidethumb ul {
            float: left;
            margin-right: -999em;
            white-space: nowrap;
            list-style: none;
        }

        .showslidethumb li {
            margin: 6px;
            text-align: center;
            float: left;
            display: inline;
        }

        .showslidethumb img {
            border: 0;
            display: block;
            border: 1px solid #A3CBE0;
            height: 108px;
            cursor: pointer;
        }

        .showslidethumb a:active img, .showslidethumb a:focus img, .showslidethumb a:hover img {
            border: 1px solid #000;
        }

        .showslidethumb a {
            text-decoration: none;
            font-weight: bold;
            color: #000;
        }

        .showslidethumb a:active, .showslidethumb a:focus, .showslidethumb a:hover {
            color: #FFF;
        }

        .showslidethumb span {
            padding: 5px 0 0;
            display: block;
        }

        /* ------------- Flexcroll CSS ------------ */
        .scrollgeneric {
            line-height: 1px;
            font-size: 1px;
            position: absolute;
            top: 0;
            left: 0;
        }

        .hscrollerbase {
            height: 17px;
            background: #A3CBE0;
        }

        .hscrollerbar {
            height: 12px;
            background: #000;
            cursor: e-resize;
            padding: 3px;
            border: 1px solid #A3CBE0;
        }

        .hscrollerbar:hover {
            background: #222;
            border: 1px solid #222;
        }

        .menu_li_padding {
            padding: 10px 15px !important;
        }


    </style>
    <!--[if IE 6]>
    <style type="text/css">
        .showslidethumb {
            position: relative;
        }

        .showslidethumb a {
            position: relative;
        }
    </style>
    <![endif]-->
    <script type="text/javascript">
        function isCanvasSupported() {
            var elem = document.createElement('canvas');
            return !!(elem.getContext && elem.getContext('2d'));
        }

        $(function () {
            if (!isCanvasSupported()) {
                alert('Browser คุณไม่ Support กรุณาใช้ Browser ที่ Support เช่น Chrome, Firefox, IE 9 ขึ้นไป เป็นต้น');
                $(".lessonContent").remove();
            }
        });
    </script>

    <div class="parallax bg-white page-section third">
        <div class="container parallax-layer" data-opacity="true">
            <div class="media v-middle media-overflow-visible">
                <div class="media-left">
                <span class="icon-block s30 bg-default"><img
                        src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course2.png" width="30"
                        class="img-responsive"></span>
                </div>
                <div class="media-body">
                    <div class="text-headline" style="font-size: 25px;"><?php echo $course->course_title; ?></div>
                </div>
                <div class="media-right">
                    <div class="dropdown">
                        <a class="btn btn-white dropdown-toggle" style="font-size: 22px;" data-toggle="dropdown"
                           href="#">หลักสูตร <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu pull-right">
                            <?php

                            $courseAll = CourseOnline::model()->findAll();
                            if (!empty($courseAll)) {
                                foreach ($courseAll as $courseAllKey => $courseAllValue) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $this->createUrl('course/detail', array('id' => $courseAllValue->course_id)); ?>"><?php echo $courseAllValue->course_title; ?></a>
                                    </li>
                                <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-section">
            <div class="row">
                <div class="col-md-9">
                    <?php if ($lessonCurrent) { ?>

                        <div class="page-section padding-top-none" style="padding-bottom: 0;">
                            <div class="media media-grid v-middle">
                                <div class="panel panel-default paper-shadow" data-z="0.5" data-hover-z="1"
                                     data-animated>
                                    <div class="panel-body" style="padding: 10px;">
                                        <div class="media-left">
                                            <!-- <span class="icon-block half bg-blue-300 text-white">2</span> -->
                                <span class="icon-block half bg-default text-white"><img
                                        src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course2.png"
                                        width="50" class="img-responsive"></span>
                                        </div>
                                        <div class="media-body">
                                            <h1 class="text-display-1 margin-none"><?php echo $lessonCurrent->title; ?></h1>
                                        </div>
                                    <br/>
                                    <p class="text-body-2">
                                        <?php echo CHtml::decode($lessonCurrent->content); ?>
                                        <?php if (count($lessonCurrent->fileDocs) > 0) {
                                            echo "<h4>ไฟล์ประกอบการเรียน</h4>";
                                            foreach ($lessonCurrent->fileDocs as $key => $filedoc) {
                                                echo "<a href='" . $this->createUrl('download', array('id' => $filedoc->id)) . "' target='_blank'>" . $filedoc->file_name . "</a><br>";
                                            }
                                        } ?>
                                    </p>

                                </div>
                                </div>
                            </div>
                            <div class="lessonContent">

                                <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                                    <?php
                                    $idx = 1;
                                    if (count($lessonCurrent->files)):
                                        $user = Yii::app()->getModule('user')->user();
                                        $uploadFolder = Yii::app()->getUploadUrl("lesson");

                                        foreach ($lessonCurrent->files as $file):
                                            $learnFiles = Helpers::lib()->checkLessonFile($file);

                                            if ($learnFiles == "notLearn") {
                                                $statusValue = CHtml::image(Yii::app()->baseUrl . '/images/icon_checkbox.png', 'ยังไม่ได้เรียน', array(
                                                    'title' => 'ยังไม่ได้เรียน',
                                                    'style' => 'margin-bottom: 8px;',
                                                ));
                                            } else if ($learnFiles == "learning") {
                                                $statusValue = CHtml::image(Yii::app()->baseUrl . '/images/icon_checklost.png', 'เรียนยังไม่ผ่าน', array(
                                                    'title' => 'เรียนยังไม่ผ่าน',
                                                    'style' => 'margin-bottom: 8px;',
                                                ));
                                            } else if ($learnFiles == "pass") {
                                                $statusValue = CHtml::image(Yii::app()->baseUrl . '/images/icon_checkpast.png', 'ผ่าน', array(
                                                    'title' => 'ผ่าน',
                                                    'style' => 'margin-bottom: 8px;',
                                                ));
                                            }

                                            $learnVdoModel = LearnFile::model()->find(array(
                                                'condition' => 'file_id=:file_id AND learn_id=:learn_id',
                                                'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id)
                                            ));
//          var_dump($learnVdoModel);
//          exit();
                                            ?>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab"
                                                     id="heading<?php echo $file->id; ?>">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion2"
                                                           href="#collapse<?php echo $file->id; ?>" aria-expanded="true"
                                                           aria-controls="collapse<?php echo $file->id; ?>">
                                                            <?php
                                                            if ($file->file_name == '') {
                                                                $fileNameCheck = '-';
                                                            } else {
                                                                $fileNameCheck = $file->file_name;
                                                            }
                                                            ?>
                                                            <?php echo '<div style="float: left;" id="imageCheck' . $file->id . '">' . $statusValue . '</div> ' . $fileNameCheck; ?>
                                                            : view <?= $file->views; ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse<?php echo $file->id; ?>"
                                                     class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>"
                                                     role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                                                    <div class="panel-body" style="background-color: #666;">
                                                        <div>
                                                            <div class="split-me" id="split-me<?php echo $idx; ?>">
                                                                <div class="col-md-6">
                                                                    <video id="example_video_<?php echo $idx; ?>"
                                                                           class="video-js vjs-default-skin" controls
                                                                           preload="none"
                                                                           data-setup="{}">
                                                                        <source
                                                                            src="<?php echo $uploadFolder . $file->filename; ?>"
                                                                            type='video/mp4'/>
                                                                        <!-- <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
                                                                        <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' /> -->
                                                                        <!-- <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track> -->
                                                                        <!-- Tracks need an ending tag thanks to IE9 -->
                                                                        <!-- <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track> -->
                                                                        <!-- Tracks need an ending tag thanks to IE9 -->
                                                                        <p class="vjs-no-js">To view this video please
                                                                            enable JavaScript, and consider upgrading to
                                                                            a
                                                                            web browser that <a
                                                                                href="http://videojs.com/html5-video-support/"
                                                                                target="_blank">supports HTML5 video</a>
                                                                        </p>
                                                                    </video>
                                                                </div>

                                                                <div class="col-md-6">

                                                                    <div class="col-md-12">
                                                                        <a href="#" id="showslide<?php echo $idx; ?>"
                                                                           rel="prettyPhoto">

                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 showslidethumb"
                                                                     id="showslidethumb<?php echo $idx; ?>"
                                                                     style="overflow-x:auto; padding:0;">
                                                                    <ul>
                                                                        <?php

                                                                        $imageSlide = ImageSlide::model()->findAll('file_id=:file_id AND image_slide_time != \'\'', array(':file_id' => $file->id));
                                                                        if (!empty($imageSlide)) {
                                                                            $learnFiles = $user->learnFiles(array('condition' => 'file_id=' . $file->id));

                                                                            foreach ($imageSlide as $key => $imageSlideItem) {
                                                                                $displayNone = "display:none;";
                                                                                if ($learnFiles[0]->learn_file_status != 'l' && $learnFiles[0]->learn_file_status != 's') {
                                                                                    if ($learnFiles[0]->learn_file_status > $key || $learnFiles[0]->learn_file_status == $key) {
                                                                                        $displayNone = "";
                                                                                    }
                                                                                } else if ($learnFiles[0]->learn_file_status == 's') {
                                                                                    $displayNone = "";
                                                                                }
                                                                                ?>
                                                                                <li><img
                                                                                        src="<?php echo Yii::app()->baseUrl . "/uploads/ppt/" . $file->id . "/slide-" . $imageSlideItem->image_slide_name . ".JPG"; ?>"
                                                                                        id="slide<?php echo $idx; ?>_<?php echo $key; ?>"
                                                                                        class="slidehide<?php echo $idx; ?> img-responsive"
                                                                                        style="<?php echo $displayNone; ?>"
                                                                                        data-time="<?php echo $imageSlideItem->image_slide_time; ?>">
                                                                                </li>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <script type="text/javascript">
                                                                function clearAllRun<?php echo $idx;?>() {
                                                                    <?php
                                                                    if(!empty($imageSlide)){
                                                                    foreach ($imageSlide as $key => $imageSlideItem) {
                                                                    ?>
                                                                    window.run<?php echo $idx;?>_<?php echo $key; ?> = false;
                                                                    <?php
                                                                    }
                                                                    }
                                                                    ?>
                                                                }
                                                                var myPlayer<?php echo $idx;?> = videojs('example_video_<?php echo $idx;?>');

                                                                $('.slidehide<?php echo $idx;?>').click(function (event) {
                                                                    /* Act on the event */
                                                                    clearAllRun<?php echo $idx;?>();
                                                                    $('#showslide<?php echo $idx;?>').attr('href', $(this).attr('src'));
                                                                    $('#showslide<?php echo $idx;?>').html($(this).clone());

                                                                    myPlayer<?php echo $idx;?>.currentTime($(this).attr('data-time'));
                                                                });
                                                                <?php
                                                                if($learnVdoModel->learn_file_status != 's'){
                                                                ?>
                                                                myPlayer<?php echo $idx;?>.on('play', function () {
                                                                    $.getJSON('<?php echo $this->createUrl("//Course/LearnVdo"); ?>', {
                                                                        id: <?php echo $file->id; ?>,
                                                                        learn_id: <?php echo $learn_id; ?>,
                                                                        counter: "counter"
                                                                    }, function (data) {
                                                                        //console.log(data);
                                                                        $('#imageCheck' + data.no).html(data.image);
                                                                    });
                                                                });

                                                                myPlayer<?php echo $idx;?>.on('ended', function () {

                                                                    $.getJSON('<?php echo $this->createUrl("//Course/LearnVdo"); ?>', {
                                                                        id: <?php echo $file->id; ?>,
                                                                        learn_id: <?php echo $learn_id; ?>,
                                                                        status: "success"
                                                                    }, function (data) {
                                                                        $('#imageCheck' + data.no).html(data.image);
                                                                    });
                                                                });
                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if(!empty($imageSlide)){
                                                                $countSlide = count($imageSlide);
                                                                foreach ($imageSlide as $key => $imageSlideItem) {
                                                                ?>
                                                                window.run<?php echo $idx;?>_<?php echo $key; ?> = false;
                                                                <?php
                                                                if ($learnVdoModel->learn_file_status != 's') {
                                                                    if ($countSlide == $key + 1) {
                                                                        $imageSlideLearnLast = ImageSlide::model()->find('file_id=:file_id AND image_slide_time != \'\' AND image_slide_name=:slide_name', array(':file_id' => $file->id, ':slide_name' => $learnVdoModel->learn_file_status));
                                                                        if ($imageSlideLearnLast) {
                                                                            echo 'myPlayer' . $idx . '.currentTime(' . $imageSlideLearnLast->image_slide_time . ');';
                                                                        }
                                                                    }
                                                                }
                                                                }
                                                                }
                                                                ?>

                                                                myPlayer<?php echo $idx;?>.on('timeupdate', function () {
                                                                    //console.log(myPlayer<?php echo $idx;?>.currentTime());
                                                                    <?php
                                                                    if(!empty($imageSlide)){
                                                                    foreach ($imageSlide as $key => $imageSlideItem) {
                                                                    ?>

                                                                    if (myPlayer<?php echo $idx;?>.currentTime() >= <?php echo ($imageSlideItem->image_slide_time) ? $imageSlideItem->image_slide_time : 0; ?>) {
                                                                        //console.log(myPlayer<?php echo $idx;?>.currentTime());
                                                                        if ($('#slide<?php echo $idx;?>_<?php echo $key; ?>').css('display') == 'none') {
                                                                            //$('#slide1').css('display','inline');
                                                                            $('#slide<?php echo $idx;?>_<?php echo $key; ?>').show('slow', function () {
                                                                                $('#showslide<?php echo $idx;?>').attr('href', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));
                                                                                $('#showslide<?php echo $idx;?>').html($('#slide<?php echo $idx;?>_<?php echo $key; ?>').clone());
                                                                                if ($('.pp_pic_holder').size() > 0) {
                                                                                    //$.prettyPhoto.close();
                                                                                    //$.prettyPhoto.open($('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'),'','');
                                                                                    $('#fullResImage').attr('src', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));
                                                                                }
                                                                                $('#showslidethumb<?php echo $idx;?>').scrollTop($('#showslidethumb<?php echo $idx;?>')[0].scrollHeight);

                                                                                <?php
                                                                                if($learnVdoModel->learn_file_status != 's'){
                                                                                ?>
                                                                                $.getJSON('<?php echo $this->createUrl("//Course/LearnVdo"); ?>', {
                                                                                    id: <?php echo $file->id; ?>,
                                                                                    learn_id: <?php echo $learn_id; ?>,
                                                                                    slide_number: <?php echo $key; ?>
                                                                                }, function (data) {

                                                                                });
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                            });
                                                                        } else {
                                                                            if (!run<?php echo $idx;?>_<?php echo $key; ?>) {
                                                                                $('#showslide<?php echo $idx;?>').attr('href', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));
                                                                                $('#showslide<?php echo $idx;?>').html($('#slide<?php echo $idx;?>_<?php echo $key; ?>').clone());
                                                                                if ($('.pp_pic_holder').size() > 0) {
                                                                                    $('#fullResImage').attr('src', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));
                                                                                }
                                                                            }
                                                                        }
                                                                        window.run<?php echo $idx;?>_<?php echo $key; ?> = true;
                                                                    }
                                                                    <?php
                                                                    }
                                                                    }
                                                                    ?>
                                                                });

                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $idx++;
                                        endforeach;
                                    endif;
                                    ?>
                                </div>


                            </div>
                            <script type="text/javascript">
                                $(document).ready(function () {

                                    // $('.container').attr('class', 'container-fluid');
                                    $(".video-js").each(function (videoIndex) {
                                        var videoId = $(this).attr("id");

                                        _V_(videoId).ready(function () {
                                            this.on("play", function (e) {
                                                //pause other video
                                                $(".video-js").each(function (index) {
                                                    if (videoIndex !== index) {
                                                        this.player.pause();
                                                    }
                                                });
                                            });

                                        });
                                    });
                                    $("a[rel^='prettyPhoto']").prettyPhoto({
                                        social_tools: false
                                    });
                                });
                            </script>
                        </div>

                    <?php } ?>
                    <!-- <h5 class="text-subhead-2 text-light">บทเรียน</h5> -->
                    <div class="panel panel-default curriculum open paper-shadow" data-z="0.5">
                        <div class="panel-heading panel-heading-gray" data-toggle="collapse"
                             data-target="#curriculum-1">
                            <div class="media">
                                <div class="media-left">
                                <span class="icon-block img-circle bg-orange-300 half text-white"><i
                                        class="fa fa-graduation-cap"></i></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="text-headline"><strong>บทเรียน</strong></h3>
                                </div>
                            </div>
                            <!-- <span class="collapse-status collapse-open">Open</span> -->
                            <!-- <span class="collapse-status collapse-close">Close</span> -->
                        </div>
                        <div class="list-group collapse in" id="curriculum-1">
                            <!-- <div class="list-group-item media" data-target="website-take-course.html">
                                <div class="media-left">
                                    <div class="text-crt">1.</div>
                                </div>
                                <div class="media-body">
                                    <i class="fa fa-fw fa-circle text-green-300"></i> Introduction
                                </div>
                                <div class="media-right">
                                    <div class="width-100 text-right text-caption">10:00 min</div>
                                </div>
                            </div>
                            <div class="list-group-item media active" data-target="website-take-course.html">
                                <div class="media-left">
                                    <div class="text-crt">2.</div>
                                </div>
                                <div class="media-body">
                                    <i class="fa fa-fw fa-circle text-blue-300"></i> Basic Specification and Line-up
                                </div>
                                <div class="media-right">
                                    <div class="width-100 text-right text-caption">20:00 min</div>
                                </div>
                            </div>
                            <div class="list-group-item media" data-target="website-take-course.html">
                                <div class="media-left">
                                    <div class="text-crt">3.</div>
                                </div>
                                <div class="media-body">
                                    <i class="fa fa-fw fa-circle text-grey-200"></i> Product features
                                </div>
                                <div class="media-right">
                                    <div class="width-100 text-right text-caption">40:00 min</div>
                                </div>
                            </div>
                            <div class="list-group-item media" data-target="website-take-course.html">
                                <div class="media-left">
                                    <div class="text-crt">4.</div>
                                </div>
                                <div class="media-body">
                                    <i class="fa fa-fw fa-circle text-grey-200"></i> Theory of operation
                                </div>
                                <div class="media-right">
                                    <div class="width-100 text-right text-caption">120:00 min</div>
                                </div>
                            </div> -->

                            <?php
                            foreach ($lessonList as $lessonListKey => $lessonListValue) {
                                ?>
                                <div
                                    class="list-group-item media <?php echo ($lessonListValue->id == $lessonCurrent->id) ? 'active' : ''; ?>"
                                    data-target="<?php echo $this->createUrl('course/lesson', array('id' => $course->course_id, 'lesson_id' => $lessonListValue->id)); ?>">
                                    <div class="media-left">
                                        <div class="text-crt"><?php echo $lessonListKey + 1; ?>.</div>
                                    </div>
                                    <div class="media-body">
                                        <?php
                                        if (Helpers::lib()->checkLessonPass($lessonListValue) == "notLearn") { ?>
                                            <i class="fa fa-fw fa-circle text-grey-300"></i>
                                        <?php
                                        } else if (Helpers::lib()->checkLessonPass($lessonListValue) == "learning") {
                                            ?>
                                            <i class="fa fa-fw fa-circle text-orange-300"></i>
                                        <?php
                                        } else if (Helpers::lib()->checkLessonPass($lessonListValue) == "pass") {
                                            if (Helpers::lib()->CheckTestCount('pass', $lessonListValue->id) == true) {
                                                ?>
                                                <i class="fa fa-fw fa-circle text-green-300"></i>
                                            <?php
                                            } else {
                                                ?>
                                                <i class="fa fa-fw fa-circle text-cyan-300"></i>
                                            <?php
                                            }
                                        }
                                        ?>
                                        <?php echo $lessonListValue->title; ?>
                                    </div>
                                    <!-- <div class="media-right">
                                        <div class="width-100 text-right text-caption">10:00 min</div>
                                    </div> -->
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <br/>
                    <br/>
                </div>
                <div class="col-md-3">
                    <?php
                    if (isset($_GET['lesson_id'])) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="<?= Yii::app()->createUrl('course/lesson', array('id' => $_GET['id'])) ?>"><h4
                                        class="panel-title">ย้อนกลับ</h4></a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="panel panel-primary" data-toggle="panel-collapse" data-open="true">
                        <div class="panel-heading panel-collapse-trigger">
                            <h4 class="panel-title" style="font-weight: bold;">หัวข้อเกี่ยวกับหลักสูตร</h4>
                        </div>
                        <div class="panel-body list-group">
                            <ul class="list-group list-group-menu">
                                <li class="list-group-item active"><a class="link-text-color"
                                                                      href="<?php echo $this->createUrl('course/lesson', array('id' => $course->course_id)); ?>">บทเรียน</a>
                                </li>
                                <li class="list-group-item"><a class="link-text-color"
                                                               href="<?php echo $this->createUrl('/forum'); ?>">เว็บบอร์ดของหลักสูตร</a>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <?php
                    if ($lessonCurrent) {
                        ?>


                        <div class="panel panel-primary" data-toggle="panel-collapse" data-open="true">
                            <div class="panel-heading panel-collapse-trigger">
                                <h4 class="panel-title" style="font-size: 22px;font-weight: bold;">สรปุผลการเรียน</h4>
                            </div>
                            <div class="panel-body list-group">
                                <ul class="list-group list-group-menu">


                                    <?php

                                    $_Score = 0;
                                    $scoreCheck = 0;
                                    $totalCheck = 0;
                                    $PassCoutCheck = 0;

                                    $CheckBuy = Helpers::lib()->CheckBuyItem($_GET['id']);

                                    $lessonModel = Lesson::model()->with('creater')->findAll(array(
                                        'condition' => 'course_id=:course_id AND (view_all="y" AND active="y")',
                                        'params' => array(':course_id' => $_GET['id'])
                                    ));


                                    $lessonStatus = Helpers::lib()->checkLessonPass($lessonCurrent);

                                    if ($lessonStatus == "notLearn") {
                                        $statusValue = '<span style="color:red;">ยังไม่ได้เรียน</span>';
                                    } else if ($lessonStatus == "learning") {
                                        $statusValue = '<span style="color:blue;">เรียนยังไม่ผ่าน</span>';
                                    } else if ($lessonStatus == "pass") {
                                        $statusValue = '<span style="color:green;">ผ่าน</span>';
                                        $linkformsurvey = '<a href="#">ทำแบบสอบถาม</a>';
                                    }


                                    $CheckTestPast = Helpers::lib()->CheckTestCount($lessonStatus, $lessonCurrent->id, false);

//                                    $lesson_new = TestAmount::model()->count("lesson_id=:lesson_id AND user_id:user_id AND type = 'post'",
//                                        array("lesson_id" => $id, "user_id" => Yii::app()->user->id));

                                    if ($CheckTestPast == false) {
                                        $checkPass = Helpers::lib()->CountTestIng($lessonStatus, $lessonCurrent->id, $lessonCurrent->cate_amount);
                                        $checkPass_reset = Helpers::lib()->CountTestIngTF($lessonStatus, $lessonCurrent->id, $lessonCurrent->cate_amount);
                                    } else {
                                        $checkPass = '-';
                                    }

                                    //========== เช็คว่าสอบครบทุกบทหรือยัง ==========//
                                    $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
                                        "user_id" => Yii::app()->user->id,
                                        "lesson_id" => $lessonCurrent->id
                                    ));
                                    if ($countScore >= "1") {
                                        $_Score = $_Score + 1;
                                    }
                                    //========== SUM ==========//
                                    $scoreSum = Helpers::lib()->ScorePercent($lessonCurrent->id);
                                    $scoreToTal = Helpers::lib()->ScoreToTal($lessonCurrent->id);

                                    if (!empty($scoreSum)) //ถ้ามีการคิดคะแนน
                                    {
                                        $CheckSumOK = $scoreSum;
                                    } else //ถ้าไม่มีการคิดคะแนน
                                    {
                                        $CheckSumOK = 0;
                                    }

                                    if (!empty($scoreToTal)) {
                                        $CheckToTalOK = $scoreToTal;
                                    } else {
                                        $CheckToTalOK = 0;
                                    }

                                    $totalCheck = $totalCheck + $CheckToTalOK;
                                    $scoreCheck = $scoreCheck + $CheckSumOK;

                                    if (Helpers::lib()->CheckTestCount($lessonStatus, $lessonCurrent->id, false, false) == true) {
                                        $PassCoutCheck = $PassCoutCheck + 1;
                                    }


                                    if ($CheckBuy) {
                                        ?>
                                        <li class="list-group-item menu_li_padding"
                                            style="font-size: 20px;font-weight: bold;">ผลการเรียน<br>

                                            <p style="font-weight: normal;color: #045BAB;"><?= $statusValue ?></p>
                                        </li>
                                        <?php

                                        if ($isPreTest) {
                                            ?>
                                            <li class="list-group-item"><a class="link-text-color"
                                                                           href="<?php echo $this->createUrl('question/index', array('course_id' => $_GET['id'], 'id' => $lessonCurrent->id)); ?>">ทำแบบทดสอบก่อนเรียน</a>
                                            </li>
                                        <?php
                                        } else {
                                            ?>
                                            <li class="list-group-item menu_li_padding"
                                                style="font-size: 20px;font-weight: bold;">
                                                ผลการสอบกอ่นเรียน,ผลการสอบหลังเรียน<br
                                                    >

                                                <p style="font-weight: normal;color: #045BAB;"><?= Helpers::lib()->CheckTestCount($lessonStatus, $lessonCurrent->id, true) ?>
                                                </p>

                                            </li>
                                        <?php
                                        }

                                        ?>
                                        <li class="list-group-item menu_li_padding"
                                            style="font-size: 20px;font-weight: bold;">สิทธิการทำแบบทดสอบ<br>

                                            <p style="font-weight: normal;color: #045BAB;"><?= $checkPass ?></p>
                                        </li>
                                        <li class="list-group-item menu_li_padding"
                                            style="font-size: 20px;font-weight: bold;">คะแนนที่ดีที่สุด<br>

                                            <p style="font-weight: normal;color: #045BAB;"><?= $scoreSum . ' / ' . $scoreToTal ?></p>
                                        </li>
                                        <?php
                                        if ($CheckTestPast === true) {

                                            $questAns = QQuestAns::model()->find("user_id='" . Yii::app()->user->id . "' AND lesson_id='" . $lessonCurrent->id . "' AND header_id='" . $lessonCurrent->header_id . "'");
                                            if (!$questAns) {
                                                ?>
                                                <li class="list-group-item menu_li_padding">แบบสอบถาม<br>

                                                    <p style="font-weight: normal;color: #045BAB;"><?= (($lessonCurrent->header_id != '') ? CHtml::link('ทำแบบสอบถาม', array('//questionnaire/index', 'id' => $lessonCurrent->id)) : '-') ?></p>
                                                </li>
                                            <?php
                                            } else {
                                                ?>
                                                <li class="list-group-item menu_li_padding"
                                                    style="font-size: 20px;font-weight: bold;">แบบสอบถาม<br>

                                                    <p style="font-weight: normal;color: #045BAB;">
                                                        คุณทำแบบสอบถามแล้ว</p>
                                                </li>
                                            <?php
                                            }
                                        } else {
                                            if ($lessonStatus == 'pass') {
                                                ?>
                                                <li class="list-group-item menu_li_padding">แบบสอบถาม<br>

                                                    <p style="font-weight: normal;color: #045BAB;"><?= (($lessonCurrent->header_id != '') ? CHtml::link('ทำแบบสอบถาม', array('//questionnaire/index', 'id' => $lessonCurrent->id)) : '-') ?></p>
                                                </li>
                                            <?php
                                            } else {
                                                ?>
                                                <li class="list-group-item menu_li_padding">แบบสอบถาม<br>

                                                    <p style="font-weight: normal;color: #045BAB;"><?= (($lessonCurrent->header_id != '') ? 'ต้องเรียนให้ผ่านก่อน' : '-') ?></p>
                                                </li>
                                            <?php
                                            }
                                        }
                                    }
                                    //                                $settings = Setting::model()->find();


                                    $sumTotal = $scoreCheck * 100;
                                    if (!empty($totalCheck)) {
                                        $sumTotal = $sumTotal / $totalCheck;
                                    }

                                    if ($CheckBuy) {
                                        // if( $sumTotal >= 60 || $CheckTestPast === true )
                                        // {
                                        //     if( $_Score === count($lessonModel) )
                                        //     {
                                        //         $sumTestingTxt = '<font color="green"><b> ผ่าน </b></font>';

                                        //     }
                                        //     else
                                        //     {
                                        //         $sumTestingTxt = '<font color="red"><b> ยังสอบไม่ครบ </b></font>';
                                        //     }
                                        // }
                                        // else
                                        // {
                                        //     $sumTestingTxt = '<font color="red"><b> ไม่ผ่าน </b></font>';
                                        // }
                                        ?>
                                        <li class="list-group-item menu_li_padding">
                                            <b>คะแนนผลการสอบ</b> <span
                                                style="color: #045BAB;"><?= number_format($sumTotal, 2) ?> %</span>
                                        </li>
                                    <?php
                                    }


                                    if (count($lessonModel) == false) {

                                        echo '<div colspan="9" bgcolor="#FCB847"><font color="red">ยังไม่มีบทเรียน</font></div>';

                                    }
                                    if ($lessonCurrent) {
                                        $model_score = Score::model()->find(array(
                                            'condition' => 'lesson_id=' . $lessonCurrent->id,
                                        ));

                                        if ($model_score) {
                                            $ModdelOnline = CourseOnline::model()->findByPk($model_score->Lessons->course_id);
                                            // var_dump($model_score);
                                            // exit();
                                            $sumPoint = number_format($model_score->score_number / $model_score->score_total * 100, 2);
                                            if ($model_score->score_past == 'n') {
                                                $textPast = '<font color="#CC0000"><b>ไม่ผ่าน</b></font>';
                                            } else {
                                                $textPast = '<font color="#00994D"><b>ผ่าน</b></font>';
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>


                    <?php
                    }
                    ?>


                    <div class="panel panel-primary" data-toggle="panel-collapse" data-open="true">
                        <div class="panel-heading panel-collapse-trigger">
                            <h4 class="panel-title" style="font-size: 22px;font-weight: bold;">ผู้สอน</h4>
                        </div>
                        <?php
                        $teacher = Teacher::model()->findByPk($course->course_lecturer);
                        $nameAdmin = Yii::app()->getModule('user')->user();
                        $registor = new RegistrationForm;
                        $registor->id = $nameAdmin->id;
                        $teacher->id = $teacher->teacher_id;
                        ?>

                        <div class="panel-body">
                            <div class="media v-middle">
                                <div class="media-left">
                                    <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $teacher, $teacher->teacher_picture, $registor, array('class' => 'img-circle width-40')); ?>                                </div>
                                <div class="media-body">
                                    <h4 class="text-title margin-none"><a href="#"><?= $teacher->teacher_name; ?></a>
                                    </h4>
                                    <span class="caption text-light">ชื่อวิทยากร</span>
                                </div>
                            </div>
                            <br/>

                            <div class="expandable expandable-indicator-white expandable-trigger">
                                <div class="expandable-content">
                                    <p><?= htmlspecialchars_decode($teacher->teacher_detail); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
//var_dump($lessonCurrent->id);
if ($checkPass_reset == 2) {

    $id = Yii::app()->user->id;
    $logstat = Logstat::model()->find(array(
        'condition' => 'user_id=' . $id,
    ));
    if ($logstat) {
        $logstat = Logstat::model()->findByPk($logstat->id);
        $logstat->notpass = $logstat->notpass + 1;
        $logstat->update();
    } else {
        $logstat = new Logstat;
        $logstat->user_id = $id;
        $logstat->notpass = 1;
        $logstat->save();
    }


    $model_Getlearn = Learn::model()->findAll(array(
        'condition' => 'user_id=' . $id . ' AND lesson_id=' . $lessonCurrent->id,
    ));

    foreach ($model_Getlearn as $getlearn) {
        $model_learnfile = LearnFile::model()->delete(array(
            'condition' => 'user_id_file=' . $id . ' AND learn_id=' . $getlearn->learn_id,
        ));
    }

    $model_learn = Learn::model()->deleteAll(array(
        'condition' => 'user_id=' . $id . ' AND lesson_id=' . $lessonCurrent->id,
    ));


    $model_Score = Score::model()->deleteAll(array(
        'condition' => 'user_id=' . $id . ' AND lesson_id=' . $lessonCurrent->id,
    ));

    $model_Logchoice = Logchoice::model()->deleteAll(array(
        'condition' => 'user_id=' . $id . ' AND lesson_id=' . $lessonCurrent->id,
    ));

    $model_Logques = Logques::model()->deleteAll(array(
        'condition' => 'user_id=' . $id . ' AND lesson_id=' . $lessonCurrent->id,
    ));

}
?>