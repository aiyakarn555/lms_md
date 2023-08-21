<?php 
$themeBaseUrl = Yii::app()->theme->baseUrl;
$uploadFolder = Yii::app()->getUploadUrl("lesson");
?>
<link href="<?php echo $themeBaseUrl; ?>/plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
<link href="<?php echo $themeBaseUrl; ?>/css/learn/prettyPhoto.css" rel="stylesheet" type="text/css">
<link href="<?php echo $themeBaseUrl; ?>/css/learn/jquery.wizard.css" rel="stylesheet" type="text/css">
<link href="<?php echo $themeBaseUrl; ?>/css/learn/pace-learn.css" rel="stylesheet" type="text/css">
<!-- <link href="<?php echo $themeBaseUrl; ?>/js/video-js/splitter/src/touchsplitter.css" rel="stylesheet"/> -->
<!-- <script src="<?php echo $themeBaseUrl; ?>/js/video-js/splitter/src/jquery.touchsplitter.js"></script> -->
<script src="<?php echo $themeBaseUrl; ?>/plugins/video-js/video.js"></script>
<script src="<?php echo $themeBaseUrl; ?>/js/library/jquery.prettyPhoto.js"></script>
<script src="<?php echo $themeBaseUrl; ?>/js/library/jquery.wizard.js"></script>

<script type="text/javascript" src="<?php echo $themeBaseUrl; ?>/plugins/knob/jquery.knob.js"></script>
<script src="<?php echo $themeBaseUrl; ?>/js/library/pace.js" rel="stylesheet"></script>
<script type='text/javascript' src='<?php echo $themeBaseUrl; ?>/js/library/jquery.countdown.min.js'></script>
<script type="text/javascript">
    window.timeEnd = false;
</script>
<script>
    $(function () {
        init_knob();
    });
</script>



<style type="text/css">
    body {
        padding-bottom: 0;
    }
    .video-js {
        max-width: 100%;
        width: 100%;
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

       /*  .vjs-progress-control {
           display: none;
       } */

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
     height: 144px;
     margin-top: 16px;
     /*margin: 100 px auto;*/
     background: #A3CBE0;
     border: 2px solid #000;
     overflow-x: auto;
     overflow-y: hidden;
     box-shadow: 0 0 10px #000;
 }

 .top-nav-list > li > a {
    min-width: 152px;
    padding: 0;
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

    footer:before {
        content: none !important;
    }

    blockquote > footer {
        height: 10em;
        overflow-y: scroll;
    }

    p {
        color: #111;
    }

    .pageIndex{
        position: absolute;
        z-index: 999;
        bottom: 2%;
        right: 4%;
        font-size: 25px;
        color: blue;
    }

    .pageTime{
        position: fixed;
        z-index: 999999;
        background-color: #f2dede;
        top: 45%;
        left: 0;
        padding: 10px 20px;
        font-size: 25px;
        color: red;
    }
    .carousel-inner > .item > img, 
    .carousel-inner > .item > a > img{
        width: 80%; /* use this, or not */
        margin: auto;
    }
    .cometchat_ccmobiletab_redirect {
        font-family: 'supermarket', 'supermarket' !important;
        font-size: 14px !important;
        color: rgb(255, 255, 255) !important;
        text-shadow: none !important;
        padding: 6px 14px !important;
        background: rgb(255, 164, 0) !important;
        border: none !important;
    }
</style>
<div id="page-wrap">

    <div class="top-nav">

        <h4 class="sm black bold"><?php echo 'ชื่อหลักสูตร'; ?></h4>

        <ul class="top-nav-list">
            <li class="outline-learn active">
                <a href="#"><i class="icon md-list"></i></a>
                <div class="list-item-body outline-learn-body">
                    <div class="section-learn-outline">
                        <h5 class="section-title">
                           บทที่ 1<br>
                           วันที่สามารถเรียนได้ : <?= $dateLearn; ?><br>
                           ช่วงเวลา : <?= $timeLearn; ?>
                       </h5>
                       <ul class="section-list">
                        <li class="o-view">
                            <div class="list-body">
                                <a href="<?= $linkPreTest; ?>" <?=$evntPreTest; ?>>
                                    <p style="color:blue;">
                                        แบบทดสอบก่อนเรียน : <?php echo 'ชื่อบทเรียน'; ?>
                                    </p>
                                </a>
                            </div>
                            <div class="div-x"><i class="icon md-check-2"></i></div>
                            <div class="line"></div>
                        </li>
                        <li class="o-view" id="<?= $fileLearnId; ?>">
                            <div class="list-body">
                                <a id="<?= $fileLearnLinkId; ?>" href="<?= $linkLearn; ?>" <?= $evntLearn; ?>>
                                    <p><?= 'บทเรียน'; ?></p>
                                </a>
                            </div>
                            <div class="div-x"><i class="icon md-check-2"></i></div>
                        </li>
                        <li class="o-view">
                            <div class="list-body">
                                <a id="ic_postest_<?= $value->lesson_id; ?>" href="<?= $linkPostTest; ?>" <?= $evntPostTest; ?> >
                                    <p style="color:blue;">แบบทดสอบหลังเรียน
                                        : <?= 'ชื่อบทเรียน';?>
                                    </p>
                                </a>
                            </div>
                            <div class="div-x"><i class="icon md-check-2"></i></div>
                            <div class="line"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="backpage">
            <a href="<?= $this->createUrl('course/courselearn', array('id' => $course->course_id,)); ?>"><i
                class="">กลับสู่บทเรียน</i></a>
            </li>
        </ul>
    </div>
    <section id="learning-section" class="learning-section learn-section">
        <div class="container">
            <div class="title-ct">

            </div>
            <div class="abc">
                <div id="container">
                    <!-- Start Content -->
                    <div id="content">
                        <div class="container bg-white">
                            <!-- Start Step -->
                            <?php 
                            $statusValue = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#F00" data-readonly="true"> '; 
                            $fileNameCheck = 'ทดสอบ 1';
                            ?>
                            <!-- End Step -->
                            <div class="row blog-post-page">
                                <div class="col-md-12 blog-box bg-white pd-1em">
                                    <div class="page-section padding-top-none" style="padding-bottom: 0;">
                                        <div class="lessonContent">
                                            <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="heading<?php echo $file->id; ?>">
                                                        <h4 class="panel-title">
                                                         <a id="a_slide<?php echo $file->id; ?>" data-toggle="collapse"
                                                            data-parent="#accordion2"
                                                            href="#collapse"
                                                            aria-expanded="true"
                                                            aria-controls="collapse<?php echo $file->id; ?>">
                                                            <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck' . $file->id . '" >' . $statusValue . '</div> <label style="font-size: 16px;color: #000;">' . $fileNameCheck . '</label>'; ?></a>
                                                        </h4>
                                                    </div>


                                                    <span style="color:red; font-weight: bold; font-size: 20px; " id="timeTest1"></span>
                                                    <div id="collapse<?php echo $file->id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                                                       <div class="panel-body" style="background-color: #666; padding: 4px;">
                                                           <div>
                                                               <div class="split-me" id="split-me<?php echo $idx; ?>">
                                                                <div class="col-md-<?php echo !empty($imageSlide) ? 6 : 12; ?>"
                                                                    style="padding: 0;">
                                                                    <video id="example_video_<?php echo $idx; ?>"
                                                                       lesson_id="<?php echo $file->lesson_id; ?>"
                                                                       index="<?php echo $idx; ?>"
                                                                       fileId="<?php echo $file->id; ?>"
                                                                       class="video-js vjs-default-skin"
                                                                       controls
                                                                       preload="none"
                                                                       data-setup="{}">
                                                                       <source src="<?php echo $uploadFolder . '292487017-1.mp4'; ?>" type='video/mp4'/>
                                                                           <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a
                                                                            href="http://videojs.com/html5-video-support/"
                                                                            target="_blank">supports
                                                                            HTML5 video</a>
                                                                        </p>
                                                                    </video>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="col-md-12">
                                                                        <a href="#" id="showslide<?php echo $idx; ?>" rel="prettyPhoto"> </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 showslidethumb" id="showslidethumb<?php echo $idx; ?>" style="overflow-x: auto; overflow-y: auto;">
                                                                    <div class="row">
                                                                        <div class="col-md-2 col-xs-6" style="margin-top:10px; ">
                                                                            <imgsrc="<?php echo Yii::app()->baseUrl . "/uploads/ppt/" . $file->id . "/slide" . $name . ".JPG"; ?>"
                                                                            id="slide<?php echo $idx; ?>_<?php echo $key; ?>"
                                                                            class="slidehide<?php echo $idx; ?> img-responsive"
                                                                            style="<?php echo $displayNone; ?>"
                                                                            data-time="<?php echo $imageSlideItem->image_slide_time; ?>">
                                                                        </div>
                                                                    </div>
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

                                                                <?php
                                                                $imageTimeLast = 0;
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
                                                                                    $imageTimeLast = $imageSlideLearnLast->image_slide_time;
                                                                                    ?>
                                                                                    myPlayer<?php echo $idx;?>.currentTime(<?= $imageSlideLearnLast->image_slide_time ?>);
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>

                                                                $('.vjs-seek-handle').attr('class','vjs-seek-handle<?php echo $idx;?> vjs-slider-handle');



                                                                if(<?= $imageTimeLast ?> > myPlayer<?php echo $idx;?>.currentTime()){
                                                                    var currentTime<?php echo $idx;?> =  <?= $imageTimeLast ?>;
                                                                } else {
                                                                    var currentTime<?php echo $idx;?> =  (myPlayer<?php echo $idx;?>.currentTime());
                                                                }

                                                                element = '<div class="vjs-play-past<?php echo $idx;?>" style="background-color:red;height:100%">';
                                                                element += '<span class="vjs-control-text<?php echo $idx;?>">';
                                                                element += '</span>';
                                                                element += '</div>';
                                                                $(element).insertAfter( ".vjs-seek-handle<?php echo $idx;?>" );
                                                                $('.vjs-play-progress').css({"z-index":9999});
                                                                $('.vjs-play-past<?php echo $idx;?>').css({"opacity":0.3});

                                                                <?php
                                                                if($learnFiles->learn_file_status != 's'){
                                                                  ?>

                                                                  myPlayer<?php echo $idx;?>.on("seeking", function(event) {
                                                                    if (currentTime<?php echo $idx;?> < myPlayer<?php echo $idx;?>.currentTime()) {
                                                                      myPlayer<?php echo $idx;?>.currentTime(currentTime<?php echo $idx;?>);
                                                                  }
                                                                  clearAllRun<?php echo $idx;?>();
                                                              });

                                                                  setInterval(function() {
                                                                      var timePlayed<?php echo $idx;?> = currentTime<?php echo $idx;?>;

                                                                      var percenttimePlayed<?php echo $idx;?> = (myPlayer<?php echo $idx;?>.duration() / 60);
                                                                      percenttimePlayed<?php echo $idx;?> = (100 / percenttimePlayed<?php echo $idx;?>);
                                                                      percenttimePlayed<?php echo $idx;?> = (timePlayed<?php echo $idx;?>/60) * percenttimePlayed<?php echo $idx;?>;

                                                                      if(myPlayer<?php echo $idx;?>.currentTime() > timePlayed<?php echo $idx;?>){
                                                                        if (!myPlayer<?php echo $idx;?>.paused()) {
                                                                          currentTime<?php echo $idx;?> = myPlayer<?php echo $idx;?>.currentTime();
                                                                      }
                                                                  }                
                                                                  $('.vjs-play-past<?php echo $idx;?>').css({"width":percenttimePlayed<?php echo $idx;?>+'%',"opacity":0.3});
                                                              }, 1000);
                                                                  <?php
                                                              } 
                                                              ?>

                                                              $('.slidehide<?php echo $idx;?>').click(function (event) {
                                                                clearAllRun<?php echo $idx;?>();
                                                                $('#showslide<?php echo $idx;?>').attr('href', $(this).attr('src'));
                                                                $('#showslide<?php echo $idx;?>').html($(this).clone());
                                                                myPlayer<?php echo $idx;?>.currentTime($(this).attr('data-time'));
                                                            });

                                                              myPlayer<?php echo $idx;?>.on('play', function () {
                                                                $.getJSON('<?php echo $this->createUrl("//Learn/LearnVdo"); ?>', {
                                                                    id: <?php echo $file->id; ?>,
                                                                    learn_id: <?php echo $learn_id; ?>,
                                                                    cnid: <?php echo $_GET['course_id']; ?>,
                                                                    counter: "counter"
                                                                }, function (data) {

                                                                    $('#imageCheck' + data.no).html(data.image);
                                                                    init_knob();
                                                                });
                                                            });
                                                              myPlayer<?php echo $idx;?>.on('ended', function () {
                                                                $.getJSON('<?php echo $this->createUrl("//Learn/LearnVdo"); ?>', {
                                                                    id: <?php echo $file->id; ?>,
                                                                    learn_id: <?php echo $learn_id; ?>,
                                                                    cnid: <?php echo $_GET['course_id']; ?>,
                                                                    status: "success"
                                                                }, function (data) {
                                                                    <?php
                                                                    if(isset($_GET['collapse'])){
                                                                        $modelFileCollapse = ControlVdo::model()->find(array('condition' => 'file_id='.$_GET['collapse']));
                                                                        $modelFilsChk = ControlVdo::model()->findAll(array('condition' => 'parent_id='.$modelFileCollapse->id));
                                                                        foreach ($modelFilsChk as $key => $value) {
                                                                            ?>
                                                                            $('#ic_a_'+<?= $value->file_id; ?>).attr("href", "<?php echo $this->createUrl('learn/learning',array('id'=>$_GET['id'],'course_id' => $_GET['course_id'],'collapse' => $value->file_id)); ?>");
                                                                            $('#ic_a_<?= $value->file_id; ?>').removeAttr("onclick");
                                                                            $("#a_slide<?= $value->file_id; ?>").removeAttr("onclick");
                                                                            $("#a_slide<?= $value->file_id; ?>").attr("href","#collapse<?php echo $value->file_id; ?>");
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    if(data.postest==1){
                                                                     $("#ic_postest_<?= $_GET['id']; ?>").removeAttr("onclick");
                                                                     $("#ic_postest_<?= $_GET['id']; ?>").attr("href","<?php echo $this->createUrl('question/index',array('id'=>$value->lesson_id,'course_id' => $_GET['course_id'],'type' => 'post'));?>");
                                                                 }
                                                                 $('#ic_'+data.no).addClass("o-view");
                                                                 $('#imageCheck' + data.no).html(data.image);
                                                                 if(data.camera==true){
                                                                    callcamera();
                                                                } else {
                                                                    var id = <?= $_GET['course_id']; ?>;
                                                                    swal({
                                                                        title: "คุณเรียนผ่านแล้ว",
                                                                        text: "ต้องการไปขั้นตอนต่อไปหรือไม่",
                                                                        type: "success",
                                                                        confirmButtonText: "ตกลง",
                                                                        cancelButtonText: "ยกเลิก",
                                                                        showCancelButton: true,
                                                                        closeOnConfirm: true,
                                                                        closeOnCancel: true
                                                                    },
                                                                    function(isConfirm) {
                                                                        if (isConfirm) {
                                                                            window.location.href = "<?php echo $this->createUrl('course/courselearn'); ?>"+'/'+id;
                                                                        }
                                                                    }
                                                                    );
                                                                }
                                                                init_knob();
                                                            });
});


myPlayer<?php echo $idx;?>.on('timeupdate', function () {
   <?php
   if(!empty($imageSlide)){
    foreach ($imageSlide as $key => $imageSlideItem) {
        ?>
        if (myPlayer<?php echo $idx;?>.currentTime() >= <?php echo ($imageSlideItem->image_slide_time) ? $imageSlideItem->image_slide_time : 0; ?>) {
            if ($('#slide<?php echo $idx;?>_<?php echo $key; ?>').css('display') == 'none') {
                $('#slide<?php echo $idx;?>_<?php echo $key; ?>').show('slow', function () {
                    $('#showslide<?php echo $idx;?>').attr('href', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));

                    $('#showslide<?php echo $idx;?>').html($('#slide<?php echo $idx;?>_<?php echo $key; ?>').clone());
                    if ($('.pp_pic_holder').size() > 0) {

                        $('#fullResImage').attr('src', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));
                    }
                    $('#showslidethumb<?php echo $idx;?>').scrollTop($('#showslidethumb<?php echo $idx;?>')[0].scrollHeight);
                    <?php
                    if($learnVdoModel->learn_file_status != 's'){
                        ?>
                        $.getJSON('<?php echo $this->createUrl("//Learn/LearnVdo"); ?>', {
                            id: <?php echo $file->id; ?>,
                            learn_id: <?php echo $learn_id; ?>,
                            cnid: <?php echo $_GET['course_id']; ?>,
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

function setTimeRollback<?php echo $idx;?>(time){
    currentTime<?php echo $idx;?> = time;
}

function getCurrentTimeRollback<?php echo $idx;?>(){
    return currentTime<?php echo $idx;?>;
}
</script>
</div>
</div>
</div>
</div>
<input type="hidden" value="<?= $_GET['collapsepdf']; ?>" id="file_active">

<div class="panel panel-default">
    <div class="panel-heading" role="tab"
    id="heading">
    <h4 class="panel-title">
        <a id="a_slide_<?php echo $file->id; ?>" data-toggle="collapse"
            data-parent="#accordion2"
            href="#collapsepdf_<?php echo $file->id; ?>"
            aria-expanded="true"
            onclick ="active_file(<?php echo $file->id.','.$learn_pdf_id; ?>)"
            aria-controls="collapsepdf_<?php echo $file->id; ?>" >
            <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck_' . $file->id . '" >' . $statusValue . '</div> <label style="font-size: 16px;color: #000;">' . $fileNameCheck . '</label>'; ?>
        </a>
    </h4>
</div>
<!-- PDF -->
<div id="collapsepdf_<?php echo $file->id; ?>"
    class="panel-collapse collapse"
    role="tabpanel"
    aria-labelledby="heading">
    <div class="panel-body"
    style="background-color: #666; padding: 4px;">
    <div>
        <div class="split-me"
        id="split-me<?= $file->id; ?>">
        <div class="col-md-12"
        style="padding: 0;">

        <!-- START Learn PDF -->
        <div id="myCarousel<?= $file->id; ?>" class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner" id="carouselInner<?= $file->id; ?>">

            <div class="item <?= $status ?> ">
                <a href="<?= Yii::app()->baseUrl."/uploads/pdf/".$file->id."/slide".$name; ?>.jpg" rel="prettyPhoto">
                    <img src="<?= Yii::app()->baseUrl."/uploads/pdf/".$file->id."/slide".$name; ?>.jpg">
                </a>
                <p class="pageIndex"><?php echo ($keyFile+1)."/".count($modelFilePdf); ?></p>
            </div>
            <div class="pageTime" style="display: none" id="timeCountdownCarousel<?= $file->id; ?>">
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel<?= $file->id; ?>" data-slide="prev" id="prePageTag<?= $file->id; ?>" <?php //if($modelLearnFilePdf->learn_file_status!='s') echo 'style="display:none;"'; ?>>
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel<?= $file->id; ?>" data-slide="next"  <?php if($modelLearnFilePdf->learn_file_status!='s') echo 'style="display:none;"'; ?> id="nextPageTag<?= $file->id; ?>">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- END Learn PDF -->

</div>
</div>
</div>
</div>
</div>
</div>
<script>
    $('#myCarousel<?= $file->id; ?>').on('slid.bs.carousel', '', function() {
        $("#nextPageTag<?= $file->id; ?>").css("display", "none");
        var $this = $(this);
        $this.children('.left.carousel-control').show();
        if($('#carouselInner<?= $file->id; ?> .item:first').hasClass('active')){
            $("#myCarousel<?= $file->id; ?>").children("#prePageTag<?= $file->id; ?>").hide();
        }
        var carouselData = $(this).data('bs.carousel');
        var currentIndex = carouselData.getItemIndex(carouselData.$element.find('.item.active'));
        var slideFrom = $(this).find('.active').index();
        $.getJSON('<?php echo $this->createUrl("//Learn/LearnPdf"); ?>', {
            id: <?php echo $file->id; ?>,
            learn_id: <?php echo $learn_pdf_id; ?>,
            cnid: <?php echo $_GET['course_id']; ?>,
            slide: currentIndex
        }, function (data) {
            if(data.postest==1){
             $("#ic_postest_<?= $_GET['id']; ?>").removeAttr("onclick");
             $("#ic_postest_<?= $_GET['id']; ?>").attr("href","<?php echo $this->createUrl('question/index',array('id'=>$file->lesson_id,'course_id' => $_GET['course_id'],'type' => 'post'));?>");
         }
         if(data.status){
            <?php 
            if(isset($_GET['collapsepdf'])){
                $modelFilePdfCollapse = ControlVdo::model()->find(array('condition' => 'file_id='.$_GET['collapsepdf']));
                $modelFilsChk = ControlVdo::model()->findAll(array('condition' => 'parent_id='.$modelFilePdfCollapse->id));
                foreach ($modelFilsChk as $key => $val) {
                    ?>
                    $('#ic_a_pdf_'+<?= $val->file_id; ?>).attr("href", "<?= $this->createUrl('learn/learning',array('id'=>$_GET['id'],'course_id' => $_GET['course_id'],'collapsepdf' => $val->file_id)); ?>");
                    $('#ic_a_pdf_<?= $val->file_id; ?>').removeAttr("onclick");
                    $("#a_slide_<?= $val->file_id; ?>").removeAttr("onclick");
                    $("#a_slide_<?= $val->file_id; ?>").attr("href","#collapsepdf_<?php echo $val->file_id; ?>");
                    <?php
                }
            }
            ?>
            $('#ic_pdf_'+data.no).addClass("o-view");

        }

        $('#imageCheck_' + data.no).html(data.image);
        if(data.timeNext) {
            $("#nextPageTag<?= $file->id; ?>").css("display", "none");
            countdownTime(data.timeNext,<?= $file->id; ?>,data.status,data.camera);
        } else {
            clearInterval(interval);
            $("#nextPageTag<?= $file->id; ?>").css("display", "block");
            $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
        } 
        init_knob();
    });
    });
</script>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var myVar;
        $(".video-js").each(function (videoIndex) {
            var videoId = $(this).attr("id");
            var lessonId = $(this).attr("lesson_id");
            var index = $(this).attr("index");
            var fileId = $(this).attr("fileId");
            var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

            _V_(videoId).ready(function () {
                if(iOS){
                    <?php if(!empty($imageSlideLearnLast->image_slide_time)){ ?>
                        swal({
                           title: "ระบบ!",
                           text: "คุณสามารถเลื่อนเวลาเพื่อดูวิดีโอได้",
                           type: "warning",
                       });
                        <?php } ?>
                    }
                    this.load();
                    this.on("play", function (e) {
                        $("#videoIdx").val(videoId);
                        $("#ValidateCaptcha_lid").val(lessonId);
                        $("#index").val(index);
                        $("#fileId").val(fileId);

                        var timeSetRandom = <?php echo $time->captchaTime->capt_time_random*60 ?>; 
                        var myPlayer = videojs(videoId);
                        var currentTime = myPlayer.currentTime();
                        var modulus = currentTime%timeSetRandom;
                        var time = timeSetRandom-modulus;
                        var allTime = currentTime+time;
                        var lengthOfVideo;
                        lengthOfVideo = myPlayer.duration();
                        <?php if($learnFiles->learn_file_status != 's' && $time){ ?>
                            clearTimeout(myVar);
                            myVar = setTimeout(function() {

                                checkTime();
                            },timeSetRandom*1000);
                            <?php } ?>
                            $(".video-js").each(function (index) {
                                if (videoIndex !== index) {
                                    this.player.pause();
                                }
                            });
                        });

                    this.on("pause", function (e) {
                        clearTimeout(myVar);
                        clearInterval(interval);
                    });


                });
        });

        $("a[rel^='prettyPhoto']").prettyPhoto({
            social_tools: false
        });

        $('.carousel').carousel({
            interval: false
        });
    });

</script>
</div>

<div class="row">
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</section>
</div>

<script>
    function init_knob() {
        $(".knob").knob({
            draw: function () {
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
</script>

<script>
    function getAlertMsg(msg){
        swal(
          'แจ้งเตือน',
          msg,
          'warning'
          )
    }

    window.onload = function(e){
                                                         /* $(document).on("contextmenu",function(e){
                                                            swal({
                                                               title: "แจ้งเตือน!",
                                                               text: "ไม่สามารถคลิ๊กขวาได้",
                                                               type: "warning",
                                                               timer: 1000
                                                           });
                                                            return false;
                                                        }); */
                                                         /* $(document).keydown(function(event){
                                                            if(event.keyCode==123){
                                                               swal({
                                                                   title: "แจ้งเตือน!",
                                                                   text: "ไม่สามารถเข้าถึงข้อมูลส่วนนี้ได้",
                                                                   type: "warning",
                                                                   timer: 1000
                                                               });
                                                               return false;
                                                           }
                                                           else if(event.ctrlKey && event.shiftKey && event.keyCode==73){  
                                                             swal({
                                                                 title: "แจ้งเตือน!",
                                                                 text: "ไม่สามารถเข้าถึงข้อมูลส่วนนี้ได้",
                                                                 type: "warning",
                                                                 timer: 1000
                                                             });      
                                                             return false;  
                                                         }
                                                     });*/
                                                 }
                                             </script>
