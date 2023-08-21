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

    article.blog-post .post-content .showslidethumb img {
        height: 108px;
        cursor: pointer;
    }

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
<script>
    videojs.options.flash.swf = "video-js.swf";
</script>
<?php
$cateOnlineModel = CateOnline::model()->findByPk($model->CourseOnlines->cate_id);
$this->breadcrumbs = array(
    'หลักสูตร' => array('//cateOnline/index'),
    $cateOnlineModel->cate_title => array('//courseOnline/index/' . $model->CourseOnlines->cate_id),
    $model->title,
);
?>
<style>
    /*.thumbnail { height: 430px; }*/
    .span216 {
        height: 450px;
        float: left;
        margin: 0 7px;
    }

    .btn {
        margin-right: 5px;
    }

    .jwplayer {
        width: 100% !important;
        height: 430px !important;
    }
</style>
<script type="text/javascript"
        src="<?php echo Yii::app()->baseUrl; ?>/js/jwplayer/jwplayer.js?var=<?php echo rand(1, 999); ?>"></script>
<script type="text/javascript">jwplayer.key = "J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
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
        $("label").click(function () {
            $(".jwplayer").each(function (index, element) {
                jwplayer(this.id).stop();
            });
        });
    });
</script>
<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i
                        class="fa fa-fw fa-book"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">หลักสูตร</h3>

                <p class="text-white text-subhead" style="font-size: 1.6rem;">รวมหลักสูตร การทำงานของ Product ของ
                    Brother</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="bs-example">
                <h5><?php echo $model->title; ?></h5>

                <div style="margin-top: 10px;">
                    <h4>รายละเอียดของบทเรียน</h4>
                    <?php echo $model->content; ?>
                    <?php if (count($model->fileDocs) > 0) {
                        echo "<h4>ไฟล์ประกอบการเรียน</h4>";
                        foreach ($model->fileDocs as $key => $filedoc) {
                            echo "<a href='" . $this->createUrl('download', array('id' => $filedoc->id)) . "' target='_blank'>" . $filedoc->file_name . "</a><br>";
                        }
                    } ?>
                </div>
                <br>

                <div class="lessonContent">

                    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                        <?php
                        $idx = 1;
                        if (count($model->files)):
                            $user = Yii::app()->getModule('user')->user();
                            $uploadFolder = Yii::app()->getUploadUrl("lesson");

                            foreach ($model->files as $file):
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

                                ?>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading<?php echo $file->id; ?>">
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
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse<?php echo $file->id; ?>"
                                         class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>"
                                         role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                                        <div class="panel-body" style="background-color: #666;">
                                            <div>
                                                <div class="split-me" id="split-me<?php echo $idx;?>">
                                                    <div class="col-md-6">
                                                        <video id="example_video_<?php echo $idx;?>"
                                                               class="video-js vjs-default-skin" controls preload="none"
                                                               data-setup="{}">
                                                            <source src="<?php echo $uploadFolder . $file->filename;?>"
                                                                    type='video/mp4'/>
                                                            <!-- <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
                                                            <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' /> -->
                                                            <!-- <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track> -->
                                                            <!-- Tracks need an ending tag thanks to IE9 -->
                                                            <!-- <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track> -->
                                                            <!-- Tracks need an ending tag thanks to IE9 -->
                                                            <p class="vjs-no-js">To view this video please enable
                                                                JavaScript, and consider upgrading to a web browser that
                                                                <a href="http://videojs.com/html5-video-support/"
                                                                   target="_blank">supports HTML5 video</a></p>
                                                        </video>
                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="col-md-12">
                                                            <a href="#" id="showslide<?php echo $idx;?>"
                                                               rel="prettyPhoto">

                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 showslidethumb"
                                                         id="showslidethumb<?php echo $idx;?>"
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
                                                                            class="slidehide<?php echo $idx; ?>"
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
//                if($('.pp_pic_holder').size() > 0){
//                    $.prettyPhoto.close();
//                    $.prettyPhoto.open($(this).attr('src'),'','');
//                }

                                                        myPlayer<?php echo $idx;?>.currentTime($(this).attr('data-time'));
                                                    });
                                                    <?php
                                                      if($learnVdoModel->learn_file_status != 's'){
                                                    ?>
                                                    myPlayer<?php echo $idx;?>.on('play', function () {
                                                        $.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>', {
                                                            id: <?php echo $file->id; ?>,
                                                            learn_id: <?php echo $learn_id; ?>
                                                        }, function (data) {
                                                            $('#imageCheck' + data.no).html(data.image);
                                                        });
                                                    });

                                                    myPlayer<?php echo $idx;?>.on('ended', function () {

                                                        $.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>', {
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
                                                            if($learnVdoModel->learn_file_status != 's'){
                                                                if($countSlide == $key+1){
                                                                    $imageSlideLearnLast = ImageSlide::model()->find('file_id=:file_id AND image_slide_time != \'\' AND image_slide_name=:slide_name', array(':file_id'=>$file->id,':slide_name'=>$learnVdoModel->learn_file_status));
                                                                    if($imageSlideLearnLast){
                                                                        echo 'myPlayer'.$idx.'.currentTime('.$imageSlideLearnLast->image_slide_time.');';
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

                                                        if (myPlayer<?php echo $idx;?>.currentTime() >= <?php echo ($imageSlideItem->image_slide_time)?$imageSlideItem->image_slide_time:0; ?>) {
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
                                                                    $.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>', {
                                                                        id: <?php echo $file->id; ?>,
                                                                        learn_id: <?php echo $learn_id; ?>,
                                                                        slide_number: <?php echo $key; ?>
                                                                    }, function (data) {

                                                                    });
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    // $.post('http://www.google.com', {}, function(data, textStatus, xhr) {
                                                                    //   /*optional stuff to do after success */
                                                                    // });
                                                                });
                                                            } else {
                                                                if (!run<?php echo $idx;?>_<?php echo $key; ?>) {
                                                                    //console.log('slide<?php echo $idx;?>_<?php echo $key; ?>');
                                                                    $('#showslide<?php echo $idx;?>').attr('href', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));
                                                                    $('#showslide<?php echo $idx;?>').html($('#slide<?php echo $idx;?>_<?php echo $key; ?>').clone());
                                                                    if ($('.pp_pic_holder').size() > 0) {
                                                                        //$.prettyPhoto.close();
                                                                        //$.prettyPhoto.open($('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'),'','');
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
                                                    //splitter<?php echo $idx;?> = $('#split-me<?php echo $idx;?>').touchSplit({orientation:"vertical",topMin:440, bottomMin:440,dock:"both"});
                                                </script>

                                                <!-- <div id="vdo<?php echo $idx;?>">Loading the player...</div>

                <script>
                var duration;
                var playerInstance<?php echo $idx; ?> = jwplayer("vdo<?php echo $idx; ?>").setup({
                //controls: false,
                // events: {
                //   onBeforePlay: false
                // },
                stretching: "exactfit",
                flashplayer: "<?php echo Yii::app()->baseUrl; ?>/js/jwplayer/jwplayer.flash.swf",
                height: 430,
                width: 300,
                events: {
                  onBuffer: function(event) {
                    //console.log(event);
                  }
                },
                title:'คลิกเพื่อเล่น',
                file: '<?php echo $uploadFolder . $file->filename;?>',
                });
                playerInstance<?php echo $idx; ?>.onReady(function() {
                  if(typeof $("#vdo<?php echo $idx; ?>").find("button").attr('onclick') == "undefined"){
                  $("#vdo<?php echo $idx; ?>").find("button").attr('onclick','return false');
                }
                });

                playerInstance<?php echo $idx; ?>.onPlay(function(callback) {
                    $('.jwsmooth').remove();
                    $.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>',{
                        id        : <?php echo $file->id; ?>,
                        learn_id  : <?php echo $learn_id; ?>
                      },function(data){
                        $('#imageCheck'+data.no).html(data.image);
                    });
                });

                playerInstance<?php echo $idx; ?>.onComplete(function(callback) {
                    $.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>',{
                        id        : <?php echo $file->id; ?>,
                        learn_id  : <?php echo $learn_id; ?>,
                        status    : "success"
                      },function(data){
                        $('#imageCheck'+data.no).html(data.image);
                    });
                });
                </script> -->
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
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('.container').attr('class', 'container-fluid');
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