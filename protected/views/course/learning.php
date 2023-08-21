<?php
$baseUrl = Yii::app()->baseUrl;
$themeBaseUrl = Yii::app()->theme->baseUrl;
$folder = explode("_", $course->course_id);
$imageShow = $baseUrl . '/uploads/courseonline/' . $folder[0] . '/original/' . $course->course_picture;
$teacher = Teacher::model()->findByPk($course->course_lecturer);
?>
<link href="<?php echo $themeBaseUrl; ?>/plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
<link href="<?php echo $themeBaseUrl; ?>/css/prettyPhoto.css" rel="stylesheet" type="text/css">
<link href="<?php echo $themeBaseUrl; ?>/css/jquery.wizard.css" rel="stylesheet" type="text/css">
<!-- <link href="<?php echo $themeBaseUrl; ?>/js/video-js/splitter/src/touchsplitter.css" rel="stylesheet"/> -->
<!-- <script src="<?php echo $themeBaseUrl; ?>/js/video-js/splitter/src/jquery.touchsplitter.js"></script> -->
<script src="<?php echo $themeBaseUrl; ?>/plugins/video-js/video.js"></script>
<script src="<?php echo $themeBaseUrl; ?>/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $themeBaseUrl; ?>/js/jquery.wizard.js"></script>
<script>
    $(function () {
        init_knob();
    });
</script>


<style type="text/css">

    .video-js {
        max-width: 100%;
        width:100%;
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

    footer:before{content: none !important;}
    blockquote > footer{
        height: 10em;
        overflow-y: scroll;
    }
    p{color: #111;}




      


</style>
<?php
$pre = Helpers::lib()->isPretestState($lessonCurrent->id);
$lessonPass = Helpers::lib()->checkLessonPass($lessonCurrent);
$lessonFinal = Helpers::lib()->CheckTestCount($lessonPass, $lessonCurrent->id, false , true,"post");

$steponePass = ''; $steptwoPass = '';
$stepthreePass = ''; $stepfourPass = '';

if($lessonFinal){
    $stepthreePass = 'active';
} else if($lessonPass == 'pass'){
    $steptwoPass = 'active';
} else if(!$pre){
    $steponePass = 'active';
}
?>

<!-- Container -->
<div id="container">
    <!-- Start Page Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-white"><?= $lessonCurrent->title ?></h2>
                    <!-- <p class="grey lighten-1">โดย วิทยากร <a href="#"><?php echo (isset($teacher->teacher_name)) ? $teacher->teacher_name : '-'; ?></a></p> -->
                </div>
                <div class="col-md-6">
                    <ul class="breadcrumbs">
                        <li><a href="index.php">หน้าแรก</a></li>
                        <li><a href="<?php echo $this->createUrl('category/index'); ?>">หลักสูตร DBD Academy</a></li>
                        <li>รายละเอียดหลักสูตร</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Banner -->
    <!-- Start Content -->
    <div id="content">
        <div class="container bg-white">
            <!-- Start Step -->
            <div class="row bg-white pd-1em">
                    <div data-wizard-init>
                        <ul class="steps nav-justified">
                            <li data-step="1">สอบก่อนเรียน</li>
                            <li data-step="2" class="<?= $steponePass ?>">เรียน</li>
                            <li data-step="3" class="<?= $steptwoPass ?>">สอบหลังเรียน</li>
                            <li data-step="4" class="<?= $stepthreePass ?>">สอบ Final</li>
                            <li data-step="5" class="<?= $stepfourPass ?>">พิมพ์ใบประกาศ</li>
                        </ul>
                </div>
            </div>
            <!-- End Step -->
            <div class="row blog-post-page">
                <div class="col-md-12 blog-box bg-white pd-1em">

                    

                    <?php if ($lessonCurrent) {
                        $lessonStatus = Helpers::lib()->checkLessonPass($lessonCurrent);
                        $preStatus = Helpers::lib()->CheckTest($lessonCurrent,"pre");
                        $postStatus = Helpers::lib()->CheckTest($lessonCurrent,"post");
                        if ($lessonStatus == "notLearn") {
                            $statusIcon = '<i class="fa fa-times-circle fa-5x text-danger" aria-hidden="true" style="height: 71px;"></i>';
                            $statusValue = '<h1 class="text-danger">ไม่ผ่าน</h1>';
                        } else if ($lessonStatus == "learning") {
                            $statusIcon = '<i class="fa fa-check-circle fa-5x text-warning " aria-hidden="true" style="height: 71px;"></i>';
                            $statusValue = '<h1 class="text-warning">เรียนยังไม่ผ่าน</h1>';
                        } else if ($lessonStatus == "pass") {
                            $statusIcon = '<i class="fa fa-check-circle fa-5x text-success " aria-hidden="true" style="height: 71px;"></i>';
                            $statusValue = '<h1 class="text-success">ผ่าน</h1>';
                            $linkformsurvey = '<a href="#">ทำแบบสอบถาม</a>';
                        }
                        ?>
                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-responsive" src="<?php echo $imageShow; ?>">
                        </div>
                        <div class="col-md-8">
                            <blockquote>
                                <h1><?php echo $lessonCurrent->title; ?></h1>
                            <footer class="bg-tran" style="min-height: 312px;">
                            <div>
                            <?php echo CHtml::decode($lessonCurrent->content); ?>
                            <?php if (count($lessonCurrent->fileDocs) > 0) {
                            echo "<h4>ไฟล์ประกอบการเรียน</h4>";
                            foreach ($lessonCurrent->fileDocs as $key => $filedoc) {
                            echo "<a href='" . $this->createUrl('download', array('id' => $filedoc->id)) . "' target='_blank'>" . $filedoc->file_name . "</a><br>";
                            }
                            } ?>
                                </div>
                            </footer>
                        </blockquote>
                    </div>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12" style="padding-top: 50px; padding-bottom: 50px;">
                        <ul class="nav-justified nav-justified-learning center" style="padding: 0;">
                            <li style="background-color: rgba(91, 45, 144, 0.25);">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?=$statusIcon;?>
                                        <hr>
                                        <p>ผลการเรียน</p>
                                        <?=$statusValue;?>
                                    </div>
                                </div>
                            </li>
                            <li style="background-color: rgba(91, 45, 144, 0.35);">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="knob" value="<?=$preStatus->value['percent'];?>" data-skin="tron" data-thickness="0.2" data-width="65" data-height="65" data-fgColor="<?=$preStatus->option['color'];?>" data-readonly="true">
                                        <hr>
                                        <p>ผลการสอบก่อนเรียน</p>
                                        <?php
                                            if($preStatus->value['boolean']){
                                                ?>
                                        <!--h1 style="color: <?//=$preStatus->option['color'];?>"><?//=$preStatus->value['percent'];?> %</h1-->
                                        <p style="color: <?=$preStatus->option['color'];?> "><?= $preStatus->value['text']; ?></p>
                                        <?php
                                            }else{
                                                ?>
                                                <!--h1 style="color: <?//=$preStatus->option['color'];?>"><?//=$preStatus->value['percent'];?> %</h1-->
                                                <p style="color: <?=$preStatus->option['color'];?> "><?= $preStatus->value['text']; ?></p>
                                        <?php
                                            }
                                            ?>
                                    </div>
                                </div>
                            </li>
                            <li style="background-color: rgba(91, 45, 144, 0.25);">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="knob" value="<?=$postStatus->value['percent'];?>" data-skin="tron" data-thickness="0.2" data-width="65" data-height="65" data-fgColor="<?=$postStatus->option['color'];?>" data-readonly="true">
                                        <hr>
                                        <p>ผลการสอบหลังเรียน</p>
                                            <!--h1 style="color: <? //=$postStatus->option['color'];?>"><? //=$postStatus->value['percent'];?> %</h1-->
                                            <p style="color: <?=$postStatus->option['color'];?> "><?= $postStatus->value['text']; ?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="background-color: rgba(91, 45, 144, 0.35);">
                                <div class="row">
                                    <div class="col-md-12">
                                    <i class="fa fa-trophy fa-5x text-warning" aria-hidden="true" style="padding-bottom: 7px;"></i>
                                    <hr>
                                        <?= Helpers::lib()->CheckTestCount($lessonStatus, $lessonCurrent->id, true , true,"post") ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <?php
                if ($lessonCurrent) { ?>
                <div class="page-section padding-top-none" style="padding-bottom: 0;">
                    <div class="lessonContent">
                        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                            <?php
                            $isPreTest = Helpers::isPretestState($learn_id);
                            $testType = $isPreTest ? 'pre' : 'post';
                            $idx = 1;
                            if (count($lessonCurrent->files)):
                            $user = Yii::app()->getModule('user')->user();
                            $uploadFolder = Yii::app()->getUploadUrl("lesson");
                            foreach ($lessonCurrent->files as $file):
                            $learnFiles = Helpers::lib()->checkLessonFile($file);
                            if ($learnFiles == "notLearn") {
                            $statusValue = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#F00" data-readonly="true"> ';
                            } else if ($learnFiles == "learning") {
                            $statusValue = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true"> ';
                            } else if ($learnFiles == "pass") {
                            $statusValue = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true"> ';
                            }
                            $learnVdoModel = LearnFile::model()->find(array(
                            'condition' => 'file_id=:file_id AND learn_id=:learn_id',
                            'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id)
                            ));
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
                                        <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck' . $file->id . '" >'.$statusValue.'</div> <label style="font-size: 16px;color: #000;">' . $fileNameCheck.'</label>'; ?>
                                        : view <?= $file->views; ?>
                                    </a>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo $file->id; ?>"
                                    class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>"
                                    role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                                    <div class="panel-body" style="background-color: #666; padding: 4px;">
                                        <div>
                                            <div class="split-me" id="split-me<?php echo $idx; ?>">
                                                <div class="col-md-6" style="padding: 0;">
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
                                                    style="overflow-x: auto; overflow-y: auto;">
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
//                                            console.log(data);

                                            $('#imageCheck' + data.no).html(data.image);
                                                init_knob();
                                            });
                                            });
                                            myPlayer<?php echo $idx;?>.on('ended', function () {
                                            $.getJSON('<?php echo $this->createUrl("//Course/LearnVdo"); ?>', {
                                            id: <?php echo $file->id; ?>,
                                            learn_id: <?php echo $learn_id; ?>,
                                            status: "success"
                                            }, function (data) {

                                            $('#imageCheck' + data.no).html(data.image);
                                                init_knob();
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
//                                                console.log(myPlayer<?php //echo $idx;?>//.currentTime());
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
               <!--  <div class="row">
                    <div class="col-md-4">
                        <div class="img-teacher">
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/client-thumb/4.png" alt="" class="center-block">
                        </div>
                        <dl class="dl-horizontal">
                            <dt>ชื่อวิทยากร : </dt>
                            <dd>AAAAA BBBBB</dd>
                            <dt>ตำแหน่ง : </dt>
                            <dd>CCCCCCC</dd>
                        </dl>
                    </div>
                    <div class="col-md-8">
                        <div class="widget-categories">
                            <ul class="pd-1em">
                                <li><a href="#"><strong>บทที่ 1</strong> ทดสอบ<small class="text-success pull-right"> (กำลังเรียน)</small></a></li>
                                <li><a href="#"><strong>บทที่ 2</strong></a></li>
                                <li><a href="#"><strong>บทที่ 3</strong></a></li>
                                <li><a href="#"><strong>บทที่ 4</strong></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <nav aria-label="...">
                    <ul class="pager">
                        <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> กลับไปหน้าบทเรียน</a></li>
                    </ul>
                </nav> -->
                <?php }
                ?>
                
                <div class="row">
                </div>
                <!-- <div class="row">
                    <div class="col-md-12">
                        <h2><i class="fa fa-book"></i> หลักสูตรการเขียนจดหมายภาษาอังกฤษเพื่อธุรกิจ (Business Writing)</h2>
                        <ul class="post-meta">
                            <li>โดย วิทยากร <a href="#">-</a></li>
                            <li>27/01/2017</li>
                            <p><i class="fa fa-clock-o" aria-hidden="true"></i> 10:00 นาที</p>
                            <p class="text-indent">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia officia cum, minima, commodi vero et repudiandae incidunt hic voluptatibus, eius, quisquam ratione dolores cumque. Neque vel, fugiat eum quibusdam nulla.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia officia cum, minima, commodi vero et repudiandae incidunt hic voluptatibus, eius, quisquam ratione dolores cumque. Neque vel, fugiat eum quibusdam nulla.</p>
                        </ul>
                    </div>
                </div> -->
            </div>
            
        </div>
    </div>
</div>
<!-- End content -->
</div>
<!-- End Container -->
<!-- Go To Top Link -->
<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
<script>
function init_knob() {
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
}

    // Start Step

    // End Step
</script>