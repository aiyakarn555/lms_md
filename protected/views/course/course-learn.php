<?php 
$themeBaseUrl = Yii::app()->theme->baseUrl;
$uploadFolder = Yii::app()->getUploadUrl("lesson");
$uploadFolderScorm = Yii::app()->getUploadUrl("scorm");
// var_dump(Yii::app()->getBaseUrl(true).'/uploads/'.'scorm/1/'.'imsmanifest.xml');
// var_dump($uploadFolderScorm .'1/'.'imsmanifest.xml' );exit();
if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
  $langId = Yii::app()->session['lang'] = 1;
  $flag = true;

}else{
  $langId = Yii::app()->session['lang'];
  $flag = false;
  $modelLessonChildren  = Lesson::model()->find(array('condition' => 'lang_id = '.$langId.' AND parent_id = ' . $model->id));
  if($modelLessonChildren){
    $model->title = $modelLessonChildren->title;
  }

}
$pass_msg = UserModule::t('you_pass');
$next_step_msg = UserModule::t('next_step');
$ok_msg = UserModule::t('Ok');
$cancel_msg = UserModule::t('Cancel');
 $msg_learn_pass = $label->label_learnPass; //เรียนผ่าน
 $msg_learning = $label->label_learning; //กำลังเรียน
 $msg_notLearn = $label->label_notLearn; //ยังไม่ได้เรียน
 $msg_do_test = $label->label_DoTest;//ทำแบบทดสอบ
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
 <!-- audio -->
<!-- <link href="<?php echo $themeBaseUrl; ?>/css/audioplayer.css" rel="stylesheet" type="text/css">
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="<?php echo $themeBaseUrl; ?>/js/audioplayer.js" rel="stylesheet"></script> -->
<style type="text/css" media="screen">
  .vjs-play-control .vjs-control  .vjs-paused 
  {
    display: none;
  }
  body{background-color: #ddd;}
  header{display: none;}
  footer{display: none!important;}
</style>
<!-- fotorama.css & fotorama.js. -->
<script>
  $(function () {
    init_knob();
        // $('audio').audioPlayer();
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

     .contact-admin{
      right: 0 !important;
     }

     .video-js {
       width: auto !important; 
       height: auto !important;
     }

     @media screen and (min-width:1240px){
        .video-js {
         height: 75vh !important;
       }
     }

     .video-js video {
       position: relative !important;
     }

     .vjs-current-time-display{
       font-family: '';
     }

     .vjs-duration-display{
       font-family: '';
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
        background: #dddddd;
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
          font-size: 22px;
          color: #012060;
          background-color: rgba(0, 0, 0, 0.14);
          padding: 0 7px;
          border-radius: 5px;
          font-weight: 500;
        }

        .pageTime{
          position: fixed;
          z-index: 999999;
          background-color: #f2dede;
          bottom: 5%;
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

        .carousel-indicators-numbers li {
          text-indent: 0;
          margin: 0 2px;
          width: 30px;
          height: 30px;
          border: none;
          border-radius: 100%;
          line-height: 30px;
          color: #fff;
          background-color: #999;
          transition: all 0.25s ease;
        }
        .carousel-indicators-numbers li.active, .carousel-indicators-numbers li:hover {
          margin: 0 2px;
          width: 30px;
          height: 30px;
          background-color: #337ab7;
        }
        .list-scorm{
          font-size: 13px !important;
          background-color: #ededed;
          border-radius: 5px;
          padding: 10px;
        }
        .list-scorm table{
          margin: 3px 0;
        }
        .display-scorm{
          padding-right: 0;
        }
        @media screen and (min-width:1200px){
          #placeholder_contentIFrame  iframe{
            height: auto;
            min-height: 730px !important;
          }
        }

        .is-desktop .control-actions{
          transform: scale(1.5);
          margin-right: 4em;
        }
      }
      @media screen and (min-width:1024px){
        .carousel-indicators{
          bottom: -10%;
        }
      }
      @media screen and (max-width:1023px){
        .carousel-indicators{
          bottom: -15%;
        }
        @media screen and (max-width: 600){
          .carousel-indicators{
            bottom: -22%;
          }

          @media screen and (max-width: 400){
            .carousel-indicators{
              bottom: -25%;
            }
            
          }
        </style>
        <style>
          /*p { clear: both; }*/
          .audiojs{width:auto;}
          .audiojs { height: 40px; background: #404040;
           /* background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #444), color-stop(0.5, #555), color-stop(0.51, #444), color-stop(1, #444)); */
           /* background-image: -moz-linear-gradient(center top, #444 0%, #555 50%, #444 51%, #444 100%); */
           -webkit-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); -moz-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3);
           -o-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); }
           .audiojs .play-pause { border-right: 1px solid rgba(0, 0, 0, 0.3); width: 45px; height: 45px; padding: 8px 8px 0px 8px; }
           .audiojs p { width: 25px; height: 20px; margin: -3px 0px 0px -1px; }
           .audiojs .scrubber { background: #5a5a5a; width: 310px; height: 20px !important; margin: 10px; }
           .audiojs .progress { height: 20px !important; width: 0px; background: #ccc;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ccc), color-stop(0.5, #ddd), color-stop(0.51, #ccc), color-stop(1, #ccc));
            background-image: -moz-linear-gradient(center top, #ccc 0%, #ddd 50%, #ccc 51%, #ccc 100%); }
            .audiojs .loaded { height: 20px !important; background: #000;
             background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #222), color-stop(0.5, #333), color-stop(0.51, #222), color-stop(1, #222));
             background-image: -moz-linear-gradient(center top, #222 0%, #333 50%, #222 51%, #222 100%); }
             .audiojs .time { float: right; height: 25px; line-height: 25px; margin-top: 8px; border-left:1px solid rgba(0, 0, 0, 0.3);}

             .audiojs .time .duration {font-size: 12px;font-family: 'NotoSansThai',NotoSans,sans-serif;}
             .audiojs .error-message { height: 24px;line-height: 24px; }

             .track-details { clear: both; height: 20px; width: 448px; padding: 1px 6px; background: #eee; color: #222; font-family: monospace; font-size: 11px; line-height: 20px;
              -webkit-box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.15); -moz-box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.15); }
              .track-details:before { content: '♬ '; }
              .track-details em { font-style: normal; color: #999; }
            </style>
            <div id="course-learn">
              <div id="mySidenav" class="sidenav">
               <!-- <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a> -->
               <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified" role="tablist">
                <!-- <li role="presentation" class="active">
                    <a href="#video" aria-controls="video" role="tab" data-toggle="tab"><i class="fa fa-play" aria-hidden="true"></i></a>
                </li>
                <li role="presentation">
                    <a href="#comment" aria-controls="comment" role="tab" data-toggle="tab"><i class="fa fa-comments" aria-hidden="true"></i></a>
                  </li> -->
                  <li role="presentation">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa fa-bars" aria-hidden="true"></i></a>
                  </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="video">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title"><?= $model->title; ?></h3>
                      </div>
                      <div class="panel-body">
                        <ul class="section-list">
                          <?php
                          if ($lessonList) :
                            foreach ($lessonList as $key => $lessonListValue) { ?>
                             <?php 
                             if(!$flag){
                              $lessonChildren  = Lesson::model()->find(array('condition' => 'lang_id = '.$langId.' AND parent_id = ' . $lessonListValue->id));
                              if($lessonChildren){
                               $lessonListValue->title = $lessonChildren->title;
                             }
                           }

                           ?>
                           <li class="list-body"><?php echo $lessonListValue->title; ?></li>
                           <?php
                           $checkPreTest = Helpers::checkHavePreTestInManage($lessonListValue->id);
                           $checkPostTest = Helpers::checkHavePostTestInManage($lessonListValue->id);
                           $lessonStatus = Helpers::lib()->checkLessonPass($lessonListValue);
                           $lessonParentStatus = !empty($lessonListValue->parent_id) ? Helpers::lib()->checkLessonParentPass($lessonListValue->lessonParent) : true;
                           $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonListValue);
                           $prestatus = Helpers::lib()->CheckTest($lessonListValue, "pre");
                           $postStatus = Helpers::lib()->CheckTest($lessonListValue, "post");
                           $chk_test_type = Helpers::lib()->CheckTestCount('pass', $lessonListValue->id, true, false, "post");
                           ?>

                           <?php if ($checkPreTest): ?>
                            <?php
                            $questTypeArr = array("","3");
                            foreach ($questTypeArr as $key => $value) {
                             $questType = !empty($value) ? $value : 0 ;
                             $score = Score::model()->findAll(array(
                              'condition' => 't.lesson_id=:lesson_id AND t.active = "y" AND t.type ="pre" AND t.user_id=:user_id AND ques_type=:ques_type',
                              'params' => array(':lesson_id' => $lessonListValue->id,':user_id' => Yii::app()->user->id,':ques_type' => $questType)));
                             if(Helpers::isMultipleChoice($lessonListValue,'pre',$value)){
                              $isPreTest = Helpers::isTestState($lessonListValue->id,'pre',$value);
                              if($value != '3'){
                               $testTypeStr = 'ข้อสอบปรนัย';
                               $url = array('id' => $lessonListValue->id,'type' => 'pre');
                             } else {
                               $testTypeStr = 'ข้อสอบอัตนัย';
                               $url = array('id' => $lessonListValue->id,'type' => 'pre','quesType'=>'3');
                             }

                             if(!$lessonParentStatus){
                               $prelink = 'javascript:void(0);';
                               $preAlert = "alertMsg('คำเตือน','คุณต้องเรียน ".$lessonListValue->lessonParent->title."ให้ผ่านก่อน','error');";
                             } else {
                               $prelink = $this->createUrl('/question/preexams', $url);

                             }
                             if ($isPreTest && empty($score)) {
                               $prelearn = false;
                               ?>
                               <?php
                               if(Helpers::isMultipleChoice($lessonListValue,'pre',$value)){
                                $prelink = $this->createUrl('/question/preexams', $url);
                                ?>
                                <li class="list-body"  id="imageCheckBar">
                                 <div class="list-body">
                                  <a href="<?= $prelink; ?>" onclick="<?= $preAlert; ?>">
                                   <h6><!-- <?= $testTypeStr; ?> -->

                                    <span class="label label-default"><?= $msg_do_test; ?></span>

                                  </h6>
                                </a>
                                <div class="div-x"></div>
                              </li>

                              <?php
                            }
                          } else {
                            ?>


                            <?php
                            if ($score) {
                             $prelearn = true;
                             $flagPass = false;
                             foreach ($score as $key => $scoreValue) {
                              if($scoreValue->score_past == 'y'){
                               $flagPass = true;
                             }
                             $preStatus = Helpers::lib()->CheckTest_lerm($lessonListValue, "pre",$scoreValue,$value);
                             $status_pre = $preStatus->value["statusBoolean"] ? 'success' : 'warning';
                             ?>

                             <li class="<?=$status_pre?>" id="imageCheckBar">
                               <div class="list-body">
                                <a data-toggle="collapse" data-parent="#accordion2"
                                href="#collapse" aria-expanded="true"
                                aria-controls="collapse">
                                <h6><?= $label->label_resultTestPre ?> <!-- <?= $testTypeStr; ?>--> <?php if(count($score)>=1)echo ' '.($key+1); ?> 
                                <?= ($preStatus->value["text"] == "รอตรวจ")? $preStatus->value['text']:$preStatus->value['score'].'/'.$preStatus->value['total'].' '.$label->label_point?>
                              </h6>
                            </a>
                          </div>
                          <div class="div-x">
                          </div>
                        </li>
                        <?php
                      } ?>
                      <?php if (count($score) < $lessonListValue->cate_amount && !$flagPass) { ?>

                        <li class="list-body"  id="imageCheckBar">
                         <div class="list-body">
                          <a href="<?= $prelink; ?>" onclick="<?= $preAlert; ?>">
                           <h6><!-- <?= $testTypeStr; ?> -->

                            <span class="label label-default"><?= $msg_do_test ?> : <?=count($score)+1?></span>

                          </h6>
                        </a>
                        <div class="div-x"></div>
                      </li>

                    <?php } ?>

                    <?php
                  }

                }
              }
            }
          endif; //if ($checkPreTest) ?>

          <?php
          $learnModel = Learn::model()->find(array(
            'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status',
            'params'=>array(':lesson_id'=>$lessonListValue->id,':user_id'=>Yii::app()->user->id,':status'=>'y')
          ));
          if($lessonListValue->type == 'vdo'){
            foreach ($lessonListValue->files as $les) {
             if($learnModel->lesson_status == 'pass'){
              $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
              $learnalert = '';
            }else if(!$lessonParentStatus){ 
              $learnlink = 'javascript:void(0);';
              $learnalert = "alertMsg('คำเตือน','คุณต้องเรียน ".$lessonListValue->lessonParent->title."ให้ผ่านก่อน','error');";
            }else if(!$prelearn){
              $learnlink = 'javascript:void(0);';
              $learnalert = 'alertswalpretest();';
            }else{
              $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
              $learnalert = '';
            }
            $learnFiles = Helpers::lib()->checkLessonFile($les,$learnModel->learn_id);
            if ($learnFiles == "notLearn") {
              $statusValue = '<span class="label label-default" >'.$msg_notLearn.'</span>';
              $statuslearn = 'list-body';
            } else if ($learnFiles == "learning") {
              $statusValue = '<span class="label label-warning" >'.$msg_learning.'</span>';
              $statuslearn = 'primary';
            } else if ($learnFiles == "pass") {
              $statusValue = '<span class="label label-success" >'.$msg_learn_pass.'</span>';
              $statuslearn = 'success';
            }
            ?>

            <li class="<?=$statuslearn?>" id="imageCheckBar">
              <div class="list-body">
               <a href="<?=$learnlink?>" <?=(!empty($learnalert))? $learnalert:'';?>>
                <h6><?= $les->getRefileName(); ?> <?=$statusValue?></h6>
              </a>
            </div>
            <div class="div-x">
            </div>
          </li>
          <?php
        }
      }  else if($lessonListValue->type == 'pdf') {
        foreach ($lessonListValue->filePdf as $les) {
         if($learnModel->lesson_status == 'pass'){
          $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
          $learnalert = '';
        }else if(!$prelearn){
          $learnlink = 'javascript:void(0);';
          $learnalert = 'alertswalpretest();';
        } else{
          $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
          $learnalert = '';
        }
        $learnFiles = Helpers::lib()->checkLessonFile($les,$learnModel->learn_id);
        if ($learnFiles == "notLearn") {
          $statusValue = '<span class="label label-default" >'.$msg_notLearn.'</span>';
          $statuslearn = 'list-body';
        } else if ($learnFiles == "learning") {
          $statusValue = '<span class="label label-warning" >'.$msg_learning.'</span>';
          $statuslearn = 'primary';
        } else if ($learnFiles == "pass") {
          $statusValue = '<span class="label label-success" >'.$msg_learn_pass.'</span>';
          $statuslearn = 'sucess';
        }
        ?>
        <a href="<?=$learnlink?>"  <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?> >


          <li class="<?=$statuslearn?>" id="imageCheckBar">
           <div class="list-body">
            <a href="<?=$learnlink?>" <?=(!empty($learnalert))? $learnalert:'';?>>
             <h6><?= $les->getRefileName(); ?> <?=$statusValue?></h6>
           </a>
         </div>
         <div class="div-x">
         </div>
       </li>
       <?php
     }
   }
   ?>

   <?php if ($checkPostTest): ?>


     <?php
     $questTypeArr = array("","3");
     $flagPass_post = false;
     foreach ($questTypeArr as $key => $value) {
      $questType = !empty($value) ? $value : 0 ;
      $score = Score::model()->findAll(array(
       'condition' => 't.lesson_id=:lesson_id AND t.active = "y" AND t.type ="post" AND t.user_id=:user_id AND ques_type=:ques_type',
       'params' => array(':lesson_id' => $lessonListValue->id,':user_id' => Yii::app()->user->id,':ques_type' => $questType)));

      if(Helpers::isMultipleChoice($lessonListValue,'post',$value)){
       $isPostTest = Helpers::isTestState($lessonListValue->id,'post',$value);
       if($value != '3'){
        $testTypeStr = 'ข้อสอบปรนัย';
        $url = array('id' => $lessonListValue->id,'type' => 'post');
      } else {
        $testTypeStr = 'ข้อสอบอัตนัย';
        $url = array('id' => $lessonListValue->id,'type' => 'post','quesType'=>'3');
      }
      if ($isPostTest  && empty($score) && !$flagPass_post) {
        $prelearn = false;
        if($lessonStatus != 'pass'){
         $link = 'javascript:void(0);';
         $alert = 'alertswal();';
       } else {
         $link = $this->createUrl('/question/preexams', $url);
       }

       if(Helpers::isMultipleChoice($lessonListValue,'post',$value)){
         ?>
         <li class="list-body"  id="imageCheckBar">
          <div class="list-body">
           <a href="<?= $link; ?>" onclick="<?= $alert; ?>">
            <h6><!-- <?= $testTypeStr; ?> -->

             <span class="label label-default"><?= $msg_do_test; ?></span>

           </h6>
         </a>
         <div class="div-x"></div>
       </li>
       <?php
     }
   } else {
     if ($score) {
      $prelearn = true;
      foreach ($score as $key => $scoreValue) {
       $preStatus = Helpers::lib()->CheckTest_lerm($lessonListValue, "post",$scoreValue,$value);
       $status_pre = $preStatus->value["statusBoolean"] ? 'success' : 'warning';
       $passed = ($scoreValue->score_past == 'y')? true:false;
       ?>

       <li class="<?=$status_pre?>" id="imageCheckBar">
        <div class="list-body">
         <a data-toggle="collapse" data-parent="#accordion2"
         href="#collapse" aria-expanded="true"
         aria-controls="collapse">
         <h6><?= $label->label_resultTestPost ?> <!-- <?= $testTypeStr; ?> --><?php if(count($score)>=1)echo ' '.($key+1); ?>
         <?= ($preStatus->value["text"] == "รอตรวจ")? $preStatus->value['text']:$preStatus->value['score'].'/'.$preStatus->value['total'].' '.$label->label_point?>
       </h6>
     </a>
   </div>
   <div class="div-x">
   </div>
 </li>
 <?php
}

if (!$passed && count($score) < $lessonListValue->cate_amount) { ?>
 <?php 
 if($lessonStatus != 'pass'){
  $link = 'javascript:void(0);';
  $alert = 'alertswal();';
} else {
  $link = $this->createUrl('/question/preexams', $url);
}

?>
<li class="list-body"  id="imageCheckBar">
  <div class="list-body">
   <a href="<?= $link; ?>" onclick="<?= $alert; ?>">
    <h6><!-- <?= $testTypeStr; ?> -->

     <span class="label label-default"><?= $msg_do_test; ?> : <?=count($score)+1?></span>

   </h6>
 </a>
 <div class="div-x"></div>
</li>

<?php } ?>

<?php
}
}
}
}
                                                    endif; // end if ($checkPostTest):
                                                    ?>

                                                    <!-- <?php
                                                    if ($lessonListValue->header_id) :
                                                        if ($checkPostTest) {
                                                            if ($isPostTest) {
                                                                $link_questionnair = 'javascript:void(0);';
                                                                $alert_questionnair = 'alertswal_test();';
                                                            } else {
                                                                $link_questionnair = $this->createUrl('questionnaire/index', array('id' => $lessonListValue->id));
                                                                $alert_questionnair = '';
                                                            }
                                                        } else {
                                                            $isLearnPass = Helpers::checkLessonPass($lessonListValue);
                                                            if ($isLearnPass != 'pass') {
                                                                $link_questionnair = 'javascript:void(0);';
                                                                $alert_questionnair = 'alertswal();';
                                                            } else {
                                                                $link_questionnair = $this->createUrl('questionnaire/index', array('id' => $lessonListValue->id));
                                                                $alert_questionnair = '';
                                                            }
                                                        }
                                                        ?>

                                                        <li class="list-body" id="imageCheckBar">
                                                            <div class="list-body">
                                                                <a href="<?php echo $link_questionnair ?>" <?= $alert_questionnair != '' ? 'onclick="' . $alert_questionnair . '"' : ''; ?> >
                                                                    <h6><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ทำแบบสอบถาม</h6>
                                                                </a>
                                                            </div>
                                                            <div class="div-x">
                                                            </div>
                                                        </li>

                                                        <?php endif; // end if ($lessonListValue->header_id)?> -->

                                                        <?php
                                                        if($lessonListValue->fileDocs):
                                                          ?>
                                                          <?php foreach ($lessonListValue->fileDocs as $filesDoc => $doc) {
                                                           ?>

                                                           <li class="success" id="imageCheckBar">
                                                            <div class="list-body">
                                                             <a href="<?php echo $this->createUrl('/course/download', array('id' => $doc->id)); ?>">

                                                              <h6><?=$filesDoc+1?>. <?=$doc->getRefileName()?> <i class="fa fa-download" style="margin-left: 30px"></i> ดาวน์โหลด</h6>
                                                            </a>
                                                          </div>
                                                          <div class="div-x">
                                                          </div>
                                                        </li>
                                                        <?php
                                                      }
                                                    endif;  // end if($lessonListValue->fileDocs)
                                                    ?>

                                                    <?php
                                                  } //end foreach lessonlist ?>
                                                  <?php

                                                  $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$model->course_id));
                                                  if($CourseSurvey) : ?>
                                                    <li class="list-body"><?= $label->label_AssessSatisfaction ?></li>
                                                    <?php

                                                    foreach ($CourseSurvey as $i => $survey) {
                                                     $SurveyCourse = QHeader::model()->findByPk($survey->survey_header_id);
                                                     $checkAnswerYet = QQuestAns_course::model()->findByAttributes(array(
                                                      'user_id' => Yii::app()->user->id,
                                                      'header_id' => $survey->survey_header_id,
                                                      'course_id' => $model->course_id,
                                                    ));
                                                     if($SurveyCourse) {
                                                      ?>
                                                      <?php
                                                      if($checkAnswerYet) {
                                                       $Llink = 'javascript:void(0)';
                                                                // $Ltext = 'ทำแบบประเมินแล้ว';
                                                       $Ltext = $label->label_AnsweredQuestions;
                                                       $Lclick = '';
                                                       $Lstatus = 'success';
                                                     }else{
                                                       $teacher = Teacher::model()->findByPk($model_course->course_lecturer);
                                                       $checkLearnAll = Helpers::lib()->checkLearnAll_Questionnaire($lessonList,'pass');


                                                       $curLessonArray = array();
                                                       if($lessonList) {
                                                        foreach($lessonList as $list) {
                                                         array_push($curLessonArray, $list->id);
                                                       }
                                                     }

                                                     $PassedTestAfterLearn = false;
                                                     if ($checkLearnAll) {
                                                      $chkTAll = Helpers::lib()->ChkAllPostTestLesson($lessonList);
                                                      if ($chkTAll) {
                                                       $PassedTestAfterLearn = true;
                                                     }
                                                   }

                                                   if($PassedTestAfterLearn) {
                                                    $Llink = $this->createUrl('questionnaire_course/index', array('id' => $survey->id));
                                                    $Ltext = 'ทำแบบประเมิน';
                                                    $Lclick = '';
                                                    $Lstatus = 'primary';
                                                  }else{
                                                    $Llink = 'javascript:void(0)';
                                                    $Ltext = 'ไม่สามารถทำได้';
                                                    $Lclick = "alertMsg('ไม่สามารถทำได้', 'กรุณาตรวจสอบการเรียนรายวิชา !', 'error')";
                                                    $Lstatus = 'list-body';
                                                  }
                                                }
                                                ?>

                                                <li class="<?=$Lstatus?>" id="imageCheckBar">
                                                 <div class="list-body">
                                                  <a href="<?= $Llink; ?>" <?=(!empty($Lclick))? 'onclick="'.$Lclick.'"':''?> >
                                                   <h6><?=$Ltext;?></h6>
                                                 </a>
                                               </div>
                                               <div class="div-x">
                                               </div>
                                             </li>

                                             <?php
                                           }
                                         }
                                            endif; //if($CourseSurvey) :
                                            ?>

                                            <!-- สอบหลักสูตร -->
                                            <?php
                                            $finalTest = Helpers::lib()->checkHaveCourseTestInManage($model->course_id);
                                            $alert_question = '';
                                            if($finalTest){ ?>

                                             <li class="list-body"><?= $label->label_testCourse ?></li>
                                             <?php

                                             $PaQuest = false;
                                             if ($CourseSurvey) {
                                              $passQuest = QQuestAns_course::model()->find(array(
                                               'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $model->course_id . '"',
                                             ));

                                              if ($passQuest) {
                                               $PaQuest = true;
                                             }
                                           }else{
                                            $PaQuest = true;
                                          }
                                          if ($PaQuest) {
                                            $pathTest =  $this->createUrl('coursequestion/preexams', array('id' => $model->course_id));
                                            $strMsg = $msg_do_test;

                                          }else{
                                            $pathTest =  'javascript:void(0);';
                                            $strMsg = 'ไม่สามารถทำได้';
                                            $alert_question = "swal('ไม่สามารถทำได้', 'กรุณาทำแบบประเมินความพึงพอใจก่อน !', 'error')";
                                          }

                                        } else {
                                         $pathTest = 'javascript:void(0);';
                                         $strMsg = 'ไม่มีแบบทดสอบ';
                                                // $strMsg = $label->label_;
                                       }


                                       $passed = false;
                                       $criteria = new CDbCriteria;
                                       $criteria->condition = ' course_id="' . $model->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active = "y"';
                                            // $criteria->group = 'score_count';
                                       $criteria->order = 'create_date ASC';
                                       $allFinalTest = Coursescore::model()->findAll($criteria);
                                       if (empty($allFinalTest)) { ?>
                                        <li class="list-body" id="imageCheckBar">
                                         <div class="list-body">
                                          <a href="<?= $pathTest; ?>" <?=(!empty($alert_question))? 'onclick="'.$alert_question.'"':''?>>
                                           <h6><?=$strMsg?></h6>
                                         </a>
                                       </div>
                                       <div class="div-x">
                                       </div>
                                     </li>
                                   <?php }else{

                                     foreach($allFinalTest as $i => $FinalTest) {
                                      $coursestatus = 'warning';
                                      if($FinalTest->score_past == 'y') {
                                       $passed = true;
                                       $coursestatus = 'success';
                                     }

                                     $pathTest = 'javascript:void(0);';
                                     $strMsg = $label->label_result.' '.($i+1)."  ".$FinalTest->score_number.'/'.$FinalTest->score_total.' '.$label->label_point;
                                     ?>

                                     <li class="<?= $coursestatus;?>" id="imageCheckBar">
                                       <div class="list-body">
                                        <a href="<?= $pathTest; ?>">
                                         <h6><?=$strMsg?></h6>
                                       </a>
                                     </div>
                                     <div class="div-x">
                                     </div>
                                   </li>

                                   <?php
                                            } // end foreach $allFinalTest

                                            if (!$passed && count($allFinalTest) < $model_course->cate_amount) { ?>

                                             <li class="list-body" id="imageCheckBar">
                                              <div class="list-body">
                                               <a href="<?= $this->createUrl('coursequestion/preexams', array('id' => $model->course_id)) ?>">
                                                <h6><?= $msg_do_test ?> : <?= count($allFinalTest)+1 ?></h6>
                                              </a>
                                            </div>
                                            <div class="div-x">
                                            </div>
                                          </li>

                                          <?php
                                        }
                                    } //<!-- จบสอบหลักสูตร -->
                                    endif; // if lesson
                                    ?>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Use any element to open the sidenav -->
                      <!-- <span class="pull-right" onclick="openNav()">open</span> -->
                      <nav class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">                   
                          <div class="row">
                            <div class="col-sm-4 hidden-xs pl-0">
                              <a href="<?= Yii::app()->createUrl('course/detail/', array('id' => $model->course_id)); ?>" class="pull-left back"><i class="fa fa-home" aria-hidden="true"></i>  <?= $label->label_back; ?> </a>
                            </div>

                            <div class="col-xs-12 col-sm-4">
                              <p class="text-center nameheadcl"><?= $model->CourseOnlines->course_title; ?></p>
                            </div>

                            <div class="col-xs-6 visible-xs pl-0">
                              <a class="pull-left back" href="course-detail.php"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                            </div>

                            <div class="col-xs-6 col-sm-4 pr-0">
                              <a class="pull-right menu" href="javascript:void(0)" onclick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></a>
                            </div>
                          </div>
                        </div>
                      </nav>

                      <div id="main">
                        <div class="container-fluid">
                          <div class="row bg-mute pt-1 pb-1">
                            <div class="col-sm-10 col-sm-offset-1">
                              <?php 
                              $idx = 1;
                              if(count($model->files) && $model->type =='vdo'){
                                foreach ($model->files as $file):
                                  $learnFiles = Helpers::lib()->checkLessonFile($file,$learn_id);
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
                                  $imageSlide = ImageSlide::model()->findAll('file_id=:file_id AND image_slide_time != \'\'', array(':file_id' => $file->id));
                                  ?>
                                  <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                      <div class="panel-heading" role="tab" id="heading<?php echo $file->id; ?>">
                                        <h4 class="panel-title">
                                          <a id="a_slide<?php echo $file->id; ?>" data-toggle="collapse"
                                            data-parent="#accordion2"
                                            href="#collapse<?= $file->id;?>"
                                            aria-expanded="true"
                                            aria-controls="collapse<?php echo $file->id; ?>">
                                            <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck' . $file->id . '" >' . $statusValue . '</div> <label class="clname">' . $file->getRefileName() . '</label>'; ?></a>
                                          </h4>
                                        </div>
                                        <span style="color:red; font-weight: bold; font-size: 20px; " id="timeTest1"></span>
                                        <div id="collapse<?php echo $file->id; ?>" class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>" role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                                          <div class="panel-body" style="background-color: #ddd; padding: 4px;">
                                            <div>
                                              <div class="split-me" id="split-me<?php echo $idx; ?>">
                                                <div class="col-md-<?php echo empty($imageSlide) ? 12 : 6; ?>"
                                                  style="padding: 0;">
                                                  <video id="example_video_<?php echo $idx; ?>"
                                                    lesson_id="<?php echo $file->lesson_id; ?>"
                                                    index="<?php echo $idx; ?>"
                                                    fileId="<?php echo $file->id; ?>"
                                                    class="video-js vjs-default-skin"
                                                    controls
                                                    preload="none"
                                                    data-setup="{}">
                                                    <source src="<?php echo $uploadFolder . $file->filename;?>"
                                                      type='video/mp4'/>
                                                      <p class="vjs-no-js">To view this video please enable
                                                        JavaScript, and consider upgrading to a web browser that
                                                        <a href="http://videojs.com/html5-video-support/"
                                                        target="_blank">supports HTML5 video
                                                      </a>
                                                    </p>
                                                  </video>                                                    
                                                </div>
                                                <div class="col-md-6 " style="padding: 0px; background-color: #f8f8f8;">
                                                  <a href="#" id="showslide<?php echo $idx; ?>" rel="prettyPhoto"> </a>
                                                </div>
                                                <?php if (!empty($imageSlide)) { ?>
                                                 <div class="col-md-12 showslidethumb" id="showslidethumb<?php echo $idx; ?>" style="overflow-x: auto; overflow-y: auto;">
                                                  <div class="row">
                                                   <?php
                                                            // $learnFiles = $user->learnFiles(array('condition' => 'file_id=' . $file->id));
                                                   $learnFiles = LearnFile::model()->findAll(array('condition' => 'file_id =' . $file->id . ' AND user_id_file = '.Yii::app()->user->id));
                                                   foreach ($imageSlide as $key => $imageSlideItem) {
                                                    $displayNone = "display:none;";
                                                    if ($learnFiles[0]->learn_file_status != 'l' && $learnFiles[0]->learn_file_status != 's') {
                                                     if ($learnFiles[0]->learn_file_status > $key || $learnFiles[0]->learn_file_status == $key) {
                                                      $displayNone = "";
                                                    }
                                                  } else if ($learnFiles[0]->learn_file_status == 's') {
                                                   $displayNone = "";
                                                 }
                                                 if(count($imageSlide)==1){
                                                   $name = '';
                                                 } else {
                                                   $name = '-'.$imageSlideItem->image_slide_name;
                                                 }
                                                 ?>
                                                 <div class="col-md-2 col-xs-6" style="margin-top:10px; ">
                                                   <img src="<?php echo Yii::app()->baseUrl . "/uploads/ppt/" . $file->id . "/slide" . $name . ".jpg"; ?>"
                                                   id="slide<?php echo $idx; ?>_<?php echo $key; ?>"
                                                   class="slidehide<?php echo $idx; ?> img-responsive"
                                                   style="<?php echo $displayNone; ?>"
                                                   data-time="<?php echo $imageSlideItem->image_slide_time; ?>">
                                                 </div>
                                                 <?php 
                                               }
                                               ?>
                                             </div>
                                           </div>
                                           <?php 
                                         }
                                         ?>
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
                                 } else {
                                  if(is_numeric($learnVdoModel->learn_file_status)){
                                    $imageTimeLast = $learnVdoModel->learn_file_status;
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
                               if($learnVdoModel->learn_file_status != 's'){
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
                               } else {
                                 ?>
                                 myPlayer<?php echo $idx;?>.on("seeking", function(event) {
                                  clearAllRun<?php echo $idx;?>();
                                });
                                 <?php
                               } 
                               ?>

                               $('.slidehide<?php echo $idx;?>').click(function (event) {
                                 clearAllRun<?php echo $idx;?>();
                                 $('#showslide<?php echo $idx;?>').attr('href', $(this).attr('src'));
                                 $('#showslide<?php echo $idx;?>').html($(this).clone());

                                 myPlayer<?php echo $idx;?>.currentTime($(this).attr('data-time'));
                               });
                               <?php
                               if($learnVdoModel->learn_file_status != 's'){
                                 ?>
                                 myPlayer<?php echo $idx;?>.on('play', function () {
                                  $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                                   id: <?php echo $file->id; ?>,
                                   learn_id: <?php echo $learn_id; ?>
                                 }, function (data) {
                                   data = JSON.parse(data);
                                   $('#imageCheck' + data.no).html(data.image);
                                   $('#imageCheckBar' + data.no).removeClass();
                                   $('#imageCheckBar' + data.no).addClass(data.imageBar);
                                   init_knob();
                                 });
                                });

                                 myPlayer<?php echo $idx;?>.on('ended', function () {
                                  swal({
                                   title: "<?= $pass_msg ?>",
                                   text: "Waiting",
                                   type: "success",
                                   showConfirmButton: true,
                                   showCancelButton: false,
                                 });
                                  $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                                   id: <?php echo $file->id; ?>,
                                   learn_id: <?php echo $learn_id; ?>,
                                   status: "success"
                                 }, function (data) {
                                   data = JSON.parse(data);
                                   $('#imageCheck' + data.no).html(data.image);
                                   $('#imageCheckBar' + data.no).removeClass();
                                   $('#imageCheckBar' + data.no).addClass(data.imageBar);
                                   init_knob();
                                   if(data.imageBar == 'success'){
                                    swal({
                                     title: "<?= $pass_msg ?>",
                                     text: "<?= $next_step_msg ?>",
                                     type: "success",
                                     confirmButtonText: "<?= $ok_msg ?>",
                                     cancelButtonText: "<?= $cancel_msg ?>",
                                     showCancelButton: true,
                                     closeOnConfirm: true,
                                     closeOnCancel: true
                                   },
                                   function(isConfirm) {
                                     if (isConfirm) {
                                      window.location.href = "<?php echo $this->createUrl('course/detail'); ?>"+"/"+<?= $model->course_id; ?>;
                                    }
                                  }
                                  );
                                  }
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
                           myPlayer<?php echo $idx;?>.currentTime(currentTime<?php echo $idx;?>);
                           var nowPoint = 0;
                           myPlayer<?php echo $idx;?>.on('timeupdate', function () {
                             <?php
                             if(!empty($imageSlide)){
                              foreach ($imageSlide as $key => $imageSlideItem) {
                               ?>

                               if (myPlayer<?php echo $idx;?>.currentTime() >= <?php echo ($imageSlideItem->image_slide_time)?$imageSlideItem->image_slide_time:0; ?>) {
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
                                   $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
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
                       } else {
                         if($learnVdoModel->learn_file_status != 's'){
                           ?>
                           var currentTimeUpdate = parseInt(this.currentTime());
                           if(currentTimeUpdate % 180 == 0 && nowPoint != currentTimeUpdate){
                             $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                              id: <?php echo $file->id; ?>,
                              learn_id: <?php echo $learn_id; ?>,
                              slide_number: currentTimeUpdate
                            }, function (data) {

                            });
                             nowPoint = currentTimeUpdate;
                           }
                           <?php
                         }
                         ?>
                       <?php } ?>
                     });
                           var focused = true;
                           document.addEventListener("visibilitychange", function () {
                             focused = !focused;
                             if (!focused){
                              var myPlayer = videojs("example_video_<?php echo $idx; ?>");
                              myPlayer.pause();
                            }
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
               </div>
               <?php 
               $idx++;
             endforeach;
           }  else if(count($model->fileScorm) && $model->type =='scorm'){
             foreach ($model->fileScorm as $file):
              $learnFiles = Helpers::lib()->checkLessonFile($file,$learn_id);
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

             $imageTimeLast = 0;
             $pathMyHost = Yii::app()->getBaseUrl(true).'/uploads/scorm/'.$file->id.'/imsmanifest.xml';
             ?>
             <script type="text/javascript">
              $(document).ready(function () {
                InitPlayer();
              });
              function InitPlayer() {
                                     // PlayerConfiguration.Debug = true;
                                     PlayerConfiguration.StorageSupport = true;
                                     // PlayerConfiguration.BtnPrevious = false;
                                     // PlayerConfiguration.BtnContinueLabel = "Continue";
                                     // PlayerConfiguration.BtnExitLabel = "Exit";
                                     // PlayerConfiguration.BtnExitAllLabel = "Exit All";

                                     PlayerConfiguration.TreeMinusIcon = "<?= Yii::app()->getBaseUrl(true); ?>"+"/Img/minus.gif";
                                     PlayerConfiguration.TreePlusIcon = "<?= Yii::app()->getBaseUrl(true); ?>"+"/Img/plus.gif";
                                     PlayerConfiguration.TreeLeafIcon = "<?= Yii::app()->getBaseUrl(true); ?>"+"/Img/leaf.gif";
                                     PlayerConfiguration.TreeActiveIcon = "<?= Yii::app()->getBaseUrl(true); ?>"+"/Img/select.gif";

                                     // PlayerConfiguration.BtnPreviousLabel = "Previous";
                                     // PlayerConfiguration.BtnContinueLabel = "Continue";
                                     // PlayerConfiguration.BtnExitLabel = "Exit";
                                     // PlayerConfiguration.BtnExitAllLabel = "Exit All";
                                     // PlayerConfiguration.BtnAbandonLabel = "Abandon";
                                     // PlayerConfiguration.BtnAbandonAllLabel = "Abandon All";
                                     // PlayerConfiguration.BtnSuspendAllLabel = "Suspend All";

                                     //manifest by URL   
                                     //Run.ManifestByURL(manifest, true);
                                     Run.ManifestByURL("<?= $pathMyHost; ?>",true);
                                   }
                                   <?php if(empty($learnVdoModel)){ ?>
                                    $.post('<?php echo $this->createUrl("//course/LearnScorm"); ?>', {
                                      id: <?php echo $file->id; ?>,
                                      learn_id: <?php echo $learn_id; ?>
                                    }, function (data) {
                                      data = JSON.parse(data);
                                      $('#imageCheck' + data.no).html(data.image);
                                      $('#imageCheckBar' + data.no).removeClass();
                                      $('#imageCheckBar' + data.no).addClass(data.imageBar);
                                      init_knob();
                                    });
                                  <?php } ?>
                                  <?php if($learnVdoModel->learn_file_status != 's'){ ?>
                                    scorminterval = setInterval(function(){ 
                                      if(localStorage.learn_status == 'passed'){
                                        console.log(localStorage.learn_status); 
                                        localStorage.removeItem("learn_status");
                                        clearInterval(scorminterval);
                                        $.post('<?php echo $this->createUrl("//course/LearnScorm"); ?>', {
                                         id: <?php echo $file->id; ?>,
                                         learn_id: <?php echo $learn_id; ?>,
                                         status: "success"
                                       }, function (data) {
                                         data = JSON.parse(data);
                                         $('#imageCheck' + data.no).html(data.image);
                                         $('#imageCheckBar' + data.no).removeClass();
                                         $('#imageCheckBar' + data.no).addClass(data.imageBar);
                                         init_knob();
                                         if(data.imageBar == 'success'){
                                          swal({
                                           title: "<?= $pass_msg ?>",
                                           text: "<?= $next_step_msg ?>",
                                           type: "success",
                                           confirmButtonText: "<?= $ok_msg ?>",
                                           cancelButtonText: "<?= $cancel_msg ?>",
                                           showCancelButton: true,
                                           closeOnConfirm: true,
                                           closeOnCancel: true
                                         },
                                         function(isConfirm) {
                                           if (isConfirm) {
                                            window.location.href = "<?php echo $this->createUrl('course/detail'); ?>"+"/"+<?= $model->course_id; ?>;
                                          }
                                        }
                                        );
                                        }
                                      });
                                      }

                                    }, 3000);
                                  <?php } ?>
                                </script>
                                <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                                 <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="heading<?php echo $file->id; ?>">
                                   <h4 class="panel-title">
                                    <a id="a_slide<?php echo $file->id; ?>" data-toggle="collapse"
                                     data-parent="#accordion2"
                                     href="#collapse<?= $file->id;?>"
                                     aria-expanded="true"
                                     aria-controls="collapse<?php echo $file->id; ?>">
                                     <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck' . $file->id . '" >' . $statusValue . '</div> <label style="font-size: 22px;color: #000;">' . $model->title . '</label>'; ?></a>
                                   </h4>
                                 </div>
                                 <span style="color:red; font-weight: bold; font-size: 20px; " id="timeTest1"></span>
                                 <div id="collapse<?php echo $file->id; ?>" class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>" role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                                  <div class="panel-body" style="background-color: #ddd; padding: 4px;">
                                   <div>
                                    <div class="split-me" id="split-me<?php echo $idx; ?>">
                                      <div class="col-md-12" style="padding: 0;">
                                             <!-- <div class="col-md-3 col-sm-3 list-scorm">
                                                 <td valign="top" height="100%" style="padding-left:5px;">
                                                    <div id="placeholder_treeContainer" ></div>
                                                </td>
                                              </div> -->
                                              <div class="col-md-12 col-sm-12" display-scorm>
                                                <div width="100%" height="100%" valign="top">
                                                  <div id="placeholder_contentIFrame" ></div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php 
                                $idx++;
                              endforeach;
                            }else if( $model->type =='audio'){
                             $imageTimeLast = 0;
                             if($model->fileAudio) {
                              foreach ($model->fileAudio as $file):
                               $learnFiles = Helpers::lib()->checkLessonFile($file,$learn_id);
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
                              $imageSlide = AudioSlide::model()->findAll('file_id=:file_id AND image_slide_time != \'\'', array(':file_id' => $file->id));
                              ?>
                              <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                 <div class="panel-heading" role="tab" id="heading<?php echo $file->id; ?>">
                                  <h4 class="panel-title">
                                   <a id="a_slide<?php echo $file->id; ?>" data-toggle="collapse"
                                    data-parent="#accordion2"
                                    href="#collapse<?= $file->id;?>"
                                    aria-expanded="true"
                                    aria-controls="collapse<?php echo $file->id; ?>">
                                    <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck' . $file->id . '" >' . $statusValue . '</div> <label class="clname">' . $file->getRefileName() . '</label>'; ?></a>
                                  </h4>
                                </div>
                                <span style="color:red; font-weight: bold; font-size: 20px; " id="timeTest1"></span>
                                <div id="collapse<?php echo $file->id; ?>" class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>" role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                                 <div class="panel-body" style="background-color: #ddd; padding: 4px;">
                                  <div>
                                   <div class="split-me" id="split-me<?php echo $idx; ?>">

                                    <div class="col-md-12" style="padding: 0px 0px 0px 15px;">
                                     <a href="#" id="showslide<?php echo $idx; ?>" rel="prettyPhoto"> </a>
                                   </div>
                                   <div class="col-md-12 <?php echo empty($imageSlide) ? 12 : 6; ?>"
                                     style="padding: 0;">
                                     <audio id="audio-player<?= $idx; ?>" src="<?php echo $uploadFolder . $file->filename;?>" preload="auto" />
                                     </div>
                                     <?php if (!empty($imageSlide)) { ?>
                                       <div class="col-md-12 showslidethumb" id="showslidethumb<?php echo $idx; ?>" style="overflow-x: auto; overflow-y: auto;">
                                        <div class="row">
                                         <?php
                                                            // $learnFiles = $user->learnFiles(array('condition' => 'file_id=' . $file->id));
                                         $learnFiles = LearnFile::model()->findAll(array('condition' => 'file_id =' . $file->id . ' AND user_id_file = '.Yii::app()->user->id));
                                         foreach ($imageSlide as $key => $imageSlideItem) {
                                          $displayNone = "display:none;";
                                          if ($learnFiles[0]->learn_file_status != 'l' && $learnFiles[0]->learn_file_status != 's') {
                                           if ($learnFiles[0]->learn_file_status > $key || $learnFiles[0]->learn_file_status == $key) {
                                            $displayNone = "";
                                          }
                                        } else if ($learnFiles[0]->learn_file_status == 's') {
                                         $displayNone = "";
                                       }
                                       if(count($imageSlide)==1){
                                         $name = '';
                                       } else {
                                         $name = '-'.$imageSlideItem->image_slide_name;
                                       }
                                       ?>
                                       <div class="col-md-2 col-xs-6" style="margin-top:10px; ">
                                         <img src="<?php echo Yii::app()->baseUrl . "/uploads/ppt_audio/" . $file->id . "/slide" . $name . ".jpg"; ?>"
                                         id="slide<?php echo $idx; ?>_<?php echo $key; ?>"
                                         class="slidehide<?php echo $idx; ?> img-responsive"
                                         style="<?php echo $displayNone; ?> margin-right:auto;margin-left:auto;"
                                         data-time="<?php echo $imageSlideItem->image_slide_time; ?>">
                                       </div>
                                       <?php 
                                     }
                                     ?>
                                   </div>
                                 </div>
                                 <?php 
                               }
                               ?>
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

                           audiojs.events.ready(function() {
                             var as = audiojs.create($("#audio-player"+<?php echo $idx;?>));
                             var myPlayer<?php echo $idx;?> = document.getElementById("audio-player"+<?php echo $idx;?>);

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
                                 $imageSlideLearnLast = AudioSlide::model()->find('file_id=:file_id AND image_slide_time != \'\' AND image_slide_name=:slide_name', array(':file_id' => $file->id, ':slide_name' => $learnVdoModel->learn_file_status));
                                 if ($imageSlideLearnLast) {
                                  $imageTimeLast = $imageSlideLearnLast->image_slide_time;
                                  ?>
                                  myPlayer<?php echo $idx;?>.currentTime =<?= $imageSlideLearnLast->image_slide_time ?>;
                                  <?php
                                }
                              }
                            }
                          }
                        }
                        ?>

                        $('.vjs-seek-handle').attr('class','vjs-seek-handle<?php echo $idx;?> vjs-slider-handle');

                        if(<?= $imageTimeLast ?> > myPlayer<?php echo $idx;?>.currentTime){
                          var currentTime<?php echo $idx;?> =  <?= $imageTimeLast ?>;
                        } else {
                          var currentTime<?php echo $idx;?> =  (myPlayer<?php echo $idx;?>.currentTime);
                        }
                        element = '<div class="vjs-play-past<?php echo $idx;?>" style="background-color:red;height:100%">';
                        element += '<span class="vjs-control-text<?php echo $idx;?>">';
                        element += '</span>';
                        element += '</div>';
                        $(element).insertAfter( ".vjs-seek-handle<?php echo $idx;?>" );
                        $('.vjs-play-progress').css({"z-index":9999});
                        $('.vjs-play-past<?php echo $idx;?>').css({"opacity":0.3});

                        <?php
                        if($learnVdoModel->learn_file_status != 's'){
                          ?>
                          $("#audio-player"+<?php echo $idx;?>).on("seeking", function(event) {
                           if (currentTime<?php echo $idx;?> < myPlayer<?php echo $idx;?>.currentTime) {
                            myPlayer<?php echo $idx;?>.currentTime = currentTime<?php echo $idx;?>;
                          }
                          clearAllRun<?php echo $idx;?>();
                        });

                          setInterval(function() {
                           var timePlayed<?php echo $idx;?> = currentTime<?php echo $idx;?>;

                           var percenttimePlayed<?php echo $idx;?> = (myPlayer<?php echo $idx;?>.duration / 60);
                           percenttimePlayed<?php echo $idx;?> = (100 / percenttimePlayed<?php echo $idx;?>);
                           percenttimePlayed<?php echo $idx;?> = (timePlayed<?php echo $idx;?>/60) * percenttimePlayed<?php echo $idx;?>;

                           if(myPlayer<?php echo $idx;?>.currentTime > timePlayed<?php echo $idx;?>){
                            if (!myPlayer<?php echo $idx;?>.paused) {
                             currentTime<?php echo $idx;?> = myPlayer<?php echo $idx;?>.currentTime;
                           }
                         }                
                         $('.vjs-play-past<?php echo $idx;?>').css({"width":percenttimePlayed<?php echo $idx;?>+'%',"opacity":0.3});
                       }, 1000);
                          <?php
                        } else {
                          ?>
                          $("#audio-player"+<?php echo $idx;?>).on("seeking", function(event) {
                           clearAllRun<?php echo $idx;?>();
                         });
                          <?php
                        } 
                        ?>

                        <?php
                        if($learnVdoModel->learn_file_status != 's'){
                          ?>
                          $("#audio-player"+<?php echo $idx;?>).on('play', function () {
                           $.post('<?php echo $this->createUrl("//course/LearnAudio"); ?>', {
                            id: <?php echo $file->id; ?>,
                            learn_id: <?php echo $learn_id; ?>
                          }, function (data) {
                            data = JSON.parse(data);
                            $('#imageCheck' + data.no).html(data.image);
                            $('#imageCheckBar' + data.no).removeClass();
                            $('#imageCheckBar' + data.no).addClass(data.imageBar);
                            init_knob();
                          });
                         });

                          $("#audio-player"+<?php echo $idx;?>).on('ended', function () {
                            swal({
                             title: "<?= $pass_msg ?>",
                             text: "Waiting",
                             type: "success",
                             showConfirmButton: false,
                             showCancelButton: false,
                           });
                            $.post('<?php echo $this->createUrl("//course/LearnAudio"); ?>', {
                              id: <?php echo $file->id; ?>,
                              learn_id: <?php echo $learn_id; ?>,
                              status: "success"
                            }, function (data) {
                              data = JSON.parse(data);
                              $('#imageCheck' + data.no).html(data.image);
                              $('#imageCheckBar' + data.no).removeClass();
                              $('#imageCheckBar' + data.no).addClass(data.imageBar);
                              init_knob();
                              swal({
                                title: "<?= $pass_msg ?>",
                                text: "<?= $next_step_msg ?>",
                                type: "success",
                                confirmButtonText: "<?= $ok_msg ?>",
                                cancelButtonText: "<?= $cancel_msg ?>",
                                showCancelButton: true,
                                closeOnConfirm: true,
                                closeOnCancel: true
                              },
                              function(isConfirm) {
                                if (isConfirm) {
                                  window.location.href = "<?php echo $this->createUrl('course/detail'); ?>"+"/"+<?= $model->course_id; ?>;
                                }
                              }
                              );
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
                           if (myPlayer<?php echo $idx;?>.currentTime >= <?php echo ($imageSlideItem->image_slide_time)?$imageSlideItem->image_slide_time:0; ?>) {
                            if (!run<?php echo $idx;?>_<?php echo $key; ?>) {
                             $('#showslide<?php echo $idx;?>').attr('href', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));
                             $('#showslide<?php echo $idx;?>').html($('#slide<?php echo $idx;?>_<?php echo $key; ?>').clone());
                             if ($('.pp_pic_holder').size() > 0) {
                              $('#fullResImage').attr('src', $('#slide<?php echo $idx;?>_<?php echo $key; ?>').attr('src'));
                            }
                          }
                        }
                        <?php
                        if($learnVdoModel->learn_file_status != 's'){
                          if($countSlide == $key+1){
                           $imageSlideLearnLast = AudioSlide::model()->find('file_id=:file_id AND image_slide_time != \'\' AND image_slide_name=:slide_name', array(':file_id'=>$file->id,':slide_name'=>$learnVdoModel->learn_file_status));
                           if($imageSlideLearnLast){
                            echo 'myPlayer'.$idx.'.currentTime = '.$imageSlideLearnLast->image_slide_time.';';
                          }
                        }
                      }
                    }
                  }
                  ?>

                  $('.slidehide<?php echo $idx;?>').click(function (event) {
                    clearAllRun<?php echo $idx;?>();
                    $('#showslide<?php echo $idx;?>').attr('href', $(this).attr('src'));
                    $('#showslide<?php echo $idx;?>').html($(this).clone());

                    myPlayer<?php echo $idx;?>.currentTime = $(this).attr('data-time');
                  });

                  $("#audio-player"+<?php echo $idx;?>).on('timeupdate', function () {
                    <?php
                    if(!empty($imageSlide)){
                     foreach ($imageSlide as $key => $imageSlideItem) {
                      ?>
                      if (myPlayer<?php echo $idx;?>.currentTime >= <?php echo ($imageSlideItem->image_slide_time)?$imageSlideItem->image_slide_time:0; ?>) {
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
                          $.post('<?php echo $this->createUrl("//course/learnAudio"); ?>', {
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
                  var focused = true;
                  document.addEventListener("visibilitychange", function () {
                    focused = !focused;
                    if (!focused){
                     var myPlayer = videojs("example_video_<?php echo $idx; ?>");
                     myPlayer.pause();
                   }
                 });

                  function setTimeRollback<?php echo $idx;?>(time){
                    currentTime<?php echo $idx;?> = time;
                  }

                  function getCurrentTimeRollback<?php echo $idx;?>(){
                    return currentTime<?php echo $idx;?>;
                  }
                });



              </script>

            </div>
          </div>
        </div>
      </div>
    </div>
    <?php 
  endforeach;
}
$idx++;
}  else if(count($model->filePdf) && $model->type =='pdf'){
                        //$modelPdf = ControlVdo::getChilds($_GET['id'],0,$lessonCurrent->type);
  if($model->filePdf) {
   foreach ($model->filePdf as $key => $file) {
    $learnFiles = Helpers::lib()->checkLessonFile($file,$learn_id);
    if ($learnFiles == "notLearn") {
     $statusValue = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#F00" data-readonly="true"> ';
   } else if ($learnFiles == "learning") {
     $statusValue = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true"> ';
   } else if ($learnFiles == "pass") {
     $statusValue = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true"> ';
   }
   ?>
   <input type="hidden" value="<?= $_GET['file']; ?>" id="file_active">
   <div class="panel panel-default">
     <div class="panel-heading" role="tab"
     id="heading">
     <h4 class="panel-title">
      <?php
      if($learnFiles=="pass" || $fild_pdf->parent_id==0){
       ?>
       <a id="a_slide_<?php echo $file->id; ?>" data-toggle="collapse"
        data-parent="#accordion2"
        href="#collapsepdf_<?php echo $file->id; ?>"
        aria-expanded="true"
        onclick ="active_file(<?php echo $file->id.','.$learn_id; ?>)"
        aria-controls="collapsepdf_<?php echo $file->id; ?>" >
      <?php  } else { ?>
        <a id="a_slide_<?php echo $file->id; ?>" data-toggle="collapse"
         data-parent="#accordion2"
         href="#collapsepdf_<?php echo $file->id; ?>"
         aria-expanded="true"
         onclick ="active_file(<?php echo $file->id.','.$learn_id; ?>)"
         aria-controls="collapsepdf_<?php echo $file->id; ?>"
         onclick="getAlertMsg('<?= $learnPdfMsg ?>')">
         <?php
       }
       if ($file->RefileName == '') {
         $fileNameCheck = '-';
       } else {
         $fileNameCheck = $file->RefileName;
       }
       ?>
       <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck_' . $file->id . '" >' . $statusValue . '</div> <label style="font-size: 16px;color: #000;">' . $fileNameCheck . '</label>'; ?>
     </a>
   </h4>
 </div>
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
    <!-- Indicators --> 
    <?php 
    $modelLearnFilePdf = LearnFile::model()->find(array(
     'condition' => 'file_id=:file_id AND learn_id=:learn_id',
     'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id)
   ));

    if($modelLearnFilePdf->learn_file_status == 's'){

     $directory =  Yii::app()->basePath."/../uploads/pdf/".$file->id."/";
     $filecount = 0;
     $files = glob($directory . "*.{jpg}",GLOB_BRACE);
     if ($files){
      $filecount = count($files);
    }
    $filePdf = $filecount;
  }else{
   $filePdf = $modelLearnFilePdf->learn_file_status;
 }
 ?>
 <ol class="carousel-indicators carousel-indicators-numbers" id="indicators<?= $file->id; ?>" >
   <?php for ($x = 1; $x <= $filePdf; $x = $x + 5) { ?>
     <?php 

     if($x == $filePdf){
      $active = 'class="active"';
    }else{
      $active = 'class';
    }
    ?>
    <li data-target="#myCarousel<?= $file->id; ?>" data-slide-to="<?= $x-1 ?>" <?= $active ?>><?= $x-1 ?></li>
    <?php
  }  ?>
                                                <!--   <li data-target="#myCarousel<?= $file->id; ?>" data-slide-to="11">11</li>
                                                  <li data-target="#myCarousel<?= $file->id; ?>" data-slide-to="12">12</li> -->
                                                </ol>



                                                <!-- Wrapper for slides -->
                                                <div class="carousel-inner" id="carouselInner<?= $file->id; ?>">
                                                  <?php 
                                                // $modelLearnFilePdf = LearnFile::model()->find(array(
                                                //  'condition' => 'file_id=:file_id AND learn_id=:learn_id',
                                                //  'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id)
                                                // ));
                                                  if(is_numeric($modelLearnFilePdf->learn_file_status))$statSlide = true;
                                                  $modelFilePdf = PdfSlide::model()->findAll(array(
                                                    'condition' => 'file_id='.$file->id,
                                                    'order' => 'image_slide_time'));
                                                  foreach ($modelFilePdf as $keyFile => $value) {
                                                    $status = "";
                                                    if($statSlide){ 
                                                      if($keyFile==$modelLearnFilePdf->learn_file_status){
                                                        $status = 'active';
                                                        $timeCountDown = $value->image_slide_next_time;
                                                      } 
                                                    } else { 
                                                      if($keyFile==0){
                                                        $status = 'active';
                                                        $timeCountDown = $value->image_slide_next_time;
                                                      } 
                                                    }
                                                    if(count($modelFilePdf)==1){
                                                      $name = '';
                                                    } else {
                                                      $name = '-'.$value->image_slide_name;
                                                    }
                                                    ?>
                                                    <div class="item <?= $status ?> ">
                                                      <a href="<?= Yii::app()->baseUrl."/uploads/pdf/".$file->id."/slide".$name; ?>.jpg" rel="prettyPhoto">
                                                        <img src="<?= Yii::app()->baseUrl."/uploads/pdf/".$file->id."/slide".$name; ?>.jpg">
                                                      </a>
                                                      <p class="pageIndex"><?php echo ($keyFile+1)."/".count($modelFilePdf); ?></p>
                                                    </div>
                                                    <?php 
                                                  }?>

                                                </div>

                                                <!-- Left and right controls -->
                                                <a class="left carousel-control" href="#myCarousel<?= $file->id; ?>" data-slide="prev" id="prePageTag<?= $file->id; ?>" <?php //if($modelLearnFilePdf->learn_file_status!='s') echo 'style="display:none;"'; ?>>
                                                  <span class="glyphicon glyphicon-chevron-left"></span>
                                                  <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control" href="#myCarousel<?= $file->id; ?>" data-slide="next"  <?php if($modelLearnFilePdf->learn_file_status!='s') echo 'style="display:none;"'; ?> id="nextPageTag<?= $file->id; ?>" >
                                                  <span class="glyphicon glyphicon-chevron-right"></span>
                                                  <span class="sr-only">Next</span>
                                                </a>
                                              </div>

                                              <div class="pageTime" style="display: none" id="timeCountdownCarousel<?= $file->id; ?>">
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
                                      <?php if($modelLearnFilePdf->learn_file_status!='s') { ?>
                                        $("#nextPageTag<?= $file->id; ?>").css("display", "none");
                                        var $this = $(this);
                                        $this.children('.left.carousel-control').show();
                                        if($('#carouselInner<?= $file->id; ?> .item:first').hasClass('active')){
                                          $("#myCarousel<?= $file->id; ?>").children("#prePageTag<?= $file->id; ?>").hide();
                                        }

                                        var carouselData = $(this).data('bs.carousel');
                                        var currentIndex = carouselData.getItemIndex(carouselData.$element.find('.item.active'));
                                        setCurrentSlide(currentIndex);
                                        var slideFrom = $(this).find('.active').index();
                            //Captcha PDF

                            var checkSlide = <?= isset($time->captchaTime->slide)? $time->captchaTime->slide: 0; ?>;
                            var prev_slide = <?= isset($time->captchaTime->prev_slide)? $time->captchaTime->prev_slide: 0; ?>;
                            var course_id = <?= $model->course_id; ?>;
                            // var slideInDatabase = <?= $modelLearnFilePdf->learn_file_status; ?>;
                            var slideInDatabase = <?= isset($modelLearnFilePdf->learn_file_status)?$modelLearnFilePdf->learn_file_status: 0 ?>;
                            // $.post('<?php echo $this->createUrl("//course/GetSlide"); ?>', {
                            //  id: <?php echo $file->id; ?>,
                            //  learn_id: <?php echo $learn_id; ?>
                            // }, function (data) {
                            //  data = JSON.parse(data);
                            //   slideInDatabase  = parseInt(data.slide);
                            // });
                            <?php 
                            $checkType = in_array("2", json_decode($time->captchaTime->type));
                            if(!$checkType){
                              $checkType = 0;
                            }
                            ?>

                            var checkType = <?= $checkType ?>; //0 = dont have, 1 = have type PDF
                            console.log('currentIndex: '+currentIndex);
                            if(currentIndex%checkSlide == 0 && checkType ){
                              $.post('<?php echo $this->createUrl("//course/GetSlide"); ?>', {
                                id: <?php echo $file->id; ?>,
                                learn_id: <?php echo $learn_id; ?>
                              }, function (data) {
                                data = JSON.parse(data);
                                slideInDatabase  = parseInt(data.slide);
                                console.log('slideBase: '+slideInDatabase);
                                if(parseInt(currentIndex) > slideInDatabase){
                                  $('#ValidateCaptcha_verifyCode').val("");
                                  $('#newModal').modal({backdrop: 'static', keyboard: false});
                                        // $.ajax({
                                        //     url: "<?php echo Yii::app()->createUrl("course/saveCaptchaStart"); ?>",
                                        //     type: "POST",
                                        //     dataType: 'json',
                                        //     data: $("#validate-form").serialize(),
                                        //     success:function(data){
                                        //         setCurrentSlide(currentIndex);
                                        //         if(data.timeBack)time_test_start_pdf(data.timeBack,currentIndex);
                                        //     }
                                        // });
                                      }else{
                                        $.post('<?php echo $this->createUrl("//course/LearnPdf"); ?>', {
                                          id: <?php echo $file->id; ?>,
                                          learn_id: <?php echo $learn_id; ?>,
                                          slide: currentIndex
                                        }, function (data) {
                                          data = JSON.parse(data);
                                          if (typeof data.indicators !== 'undefined' && typeof data.no !== 'undefined') {
                                            $('#indicators'+data.no).append(data.indicators);
                                          }
                                          console.log(data.status);
                                          if(data.status){
                                            <?php 
                                            if(isset($_GET['file'])){
                                                            // $modelFilePdfCollapse = ControlVdo::model()->find(array('condition' => 'file_id='.$_GET['file']));
                                                            // $modelFilsChk = ControlVdo::model()->findAll(array('condition' => 'parent_id='.$modelFilePdfCollapse->id));
                                                            // foreach ($modelFilsChk as $key => $val) {
                                              ?>
                                                                // $('#ic_a_pdf_'+<?= $val->file_id; ?>).attr("href", "<?= $this->createUrl('learn/learning',array('id'=>$_GET['id'],'course_id' => $_GET['course_id'],'collapsepdf' => $val->file_id)); ?>");
                                                                // $('#ic_a_pdf_<?= $val->file_id; ?>').removeAttr("onclick");
                                                                // $("#a_slide_<?= $val->file_id; ?>").removeAttr("onclick");
                                                                // $("#a_slide_<?= $val->file_id; ?>").attr("href","#collapsepdf_<?php echo $val->file_id; ?>");
                                                                <?php
                                                            // }
                                                              }
                                                              ?>
                                                              $('#ic_pdf_'+data.no).addClass("o-view");


                                                            }

                                                        //if(data.camera)
                                                        $('#imageCheck_' + data.no).html(data.image);
                                                        if(data.timeNext) {
                                                          $("#nextPageTag<?= $file->id; ?>").css("display", "none");
                                                          countdownTime(data.timeNext,<?= $file->id; ?>,data.status);
                                                        } else {
                                                          clearInterval(interval);
                                                          $("#nextPageTag<?= $file->id; ?>").css("display", "block");
                                                          $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
                                                          if(data.learn_file_status == 's'){
                                                            swal({
                                                              title: "<?= $pass_msg ?>",
                                                              text: "<?= $next_step_msg ?>",
                                                              type: "success",
                                                              confirmButtonText: "<?= $ok_msg ?>",
                                                              cancelButtonText: "<?= $cancel_msg ?>",
                                                              showCancelButton: true,
                                                              closeOnConfirm: true,
                                                              closeOnCancel: true
                                                            },
                                                            function(isConfirm) {
                                                              if (isConfirm) {
                                                                window.location.href = "<?php echo $this->createUrl('course/detail'); ?>"+"/"+<?= $model->course_id; ?>;
                                                              }
                                                            }
                                                            );
                                                          }
                                                        } 
                                                        init_knob();
                                                    }); //end post course/LearnPdf
}
});

}else {
  $.post('<?php echo $this->createUrl("//course/LearnPdf"); ?>', {
    id: <?php echo $file->id; ?>,
    learn_id: <?php echo $learn_id; ?>,
    slide: currentIndex
  }, function (data) {
    data = JSON.parse(data);
    if (typeof data.indicators !== 'undefined' && typeof data.no !== 'undefined') {
      $('#indicators'+data.no).append(data.indicators);
    }
    console.log(data.status);
    if(data.status){
      <?php 
      if(isset($_GET['file'])){
                                            // $modelFilePdfCollapse = ControlVdo::model()->find(array('condition' => 'file_id='.$_GET['file']));
                                            // $modelFilsChk = ControlVdo::model()->findAll(array('condition' => 'parent_id='.$modelFilePdfCollapse->id));
                                            // foreach ($modelFilsChk as $key => $val) {
        ?>
                                                // $('#ic_a_pdf_'+<?= $val->file_id; ?>).attr("href", "<?= $this->createUrl('learn/learning',array('id'=>$_GET['id'],'course_id' => $_GET['course_id'],'collapsepdf' => $val->file_id)); ?>");
                                                // $('#ic_a_pdf_<?= $val->file_id; ?>').removeAttr("onclick");
                                                // $("#a_slide_<?= $val->file_id; ?>").removeAttr("onclick");
                                                // $("#a_slide_<?= $val->file_id; ?>").attr("href","#collapsepdf_<?php echo $val->file_id; ?>");
                                                <?php
                                            // }
                                              }
                                              ?>
                                              $('#ic_pdf_'+data.no).addClass("o-view");

                                            }

                                        //if(data.camera)
                                        $('#imageCheck_' + data.no).html(data.image);
                                        if(data.timeNext) {
                                          $("#nextPageTag<?= $file->id; ?>").css("display", "none");
                                          countdownTime(data.timeNext,<?= $file->id; ?>,data.status);
                                        } else {
                                          clearInterval(interval);
                                          $("#nextPageTag<?= $file->id; ?>").css("display", "block");
                                          $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
                                          if(data.learn_file_status == 's'){
                                            swal({
                                              title: "<?= $pass_msg ?>",
                                              text: "<?= $next_step_msg ?>",
                                              type: "success",
                                              confirmButtonText: "<?= $ok_msg ?>",
                                              cancelButtonText: "<?= $cancel_msg ?>",
                                              showCancelButton: true,
                                              closeOnConfirm: true,
                                              closeOnCancel: true
                                            },
                                            function(isConfirm) {
                                              if (isConfirm) {
                                                window.location.href = "<?php echo $this->createUrl('course/detail'); ?>"+"/"+<?= $model->course_id; ?>;
                                              }
                                            }
                                            );
                                          }
                                        } 
                                        init_knob();
                                    }); //end post course/LearnPdf
}
<?php } ?> 
});

</script>
<?php 
                                } //end for
                            } //end if
                          }
                          ?>
                          <!-- DEFAULT -->
                        </div>
                      </div>

                    </div>  
                  </div>
                </div>
                <div style="margin-top:150px; z-index: 99999; " class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="form">
                      <div class="row">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                          'id' => 'validate-form',
                          'enableClientValidation' => true,
                          'clientOptions' => array(
                            'validateOnSubmit' => true,
                          ),
                          'htmlOptions' => array(
                            'onsubmit' => 'return false',
                          ),
                        )); ?>
                        <div class="modal-content">
                          <?php if (CCaptcha::checkRequirements()): ?>
                           <div class="modal-header">
                            <?php echo $form->labelEx($modelCapt, 'verifyCode'); ?>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                             <div class="col-md-6">
                                            <!-- <input type="hidden" id="videoIdx" name="videoIdx" value="example_video_1">
                                            <input type="hidden" id="fileId" name="fileId" value="">
                                            <input type="hidden" id="index" name="index" value="">
                                            <input type="hidden" id="ValidateCaptcha_cnid" name="ValidateCaptcha[cnid]" value="<?= $model->course_id; ?>">
                                            <input type="hidden" id="ValidateCaptcha_lid" name="ValidateCaptcha[lid]" value=""> -->
                                            <?php $this->widget('CCaptcha'); ?>
                                            <?php echo $form->textField($modelCapt, 'verifyCode',array('class'=>'form-control ')); ?>
                                          </div>
                                          <div class="col-md-6" style="margin-top: 10px;">
                                            กรุณากรอกภายใน : <span style="color:red; font-weight: bold; font-size: 20px;" id="timeTest"></span>
                                            <div class="hint" style="margin-top: 10px;">กรุณากรอกรหัสยืนยันให้ตรงกับภาพที่แสดง
                                              <div class="clear"></div>
                                            </div> 
                                          </div>   
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <?php if($model->type == 'vdo'){ ?>
                                          <button type="button" id="yt0" class="btn btn-primary">ยืนยัน</button>
                                        <?php }else if($model->type == 'pdf'){ ?>
                                          <button type="button" id="yt1" class="btn btn-primary">ยืนยัน</button>
                                        <?php } ?>
                                      </div>
                                    <?php endif; ?>
                                  </div>
                                  <?php $this->endWidget(); ?>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div style="margin-top:150px; z-index: 99999; " class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="form">
                                <div class="row">
                                  <?php $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'validate-form-new',
                                    'enableClientValidation' => true,
                                    'clientOptions' => array(
                                      'validateOnSubmit' => true,
                                    ),
                                    'htmlOptions' => array(
                                      'onsubmit' => 'return false',
                                    ),
                                  )); ?>
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      Check
                                    </div>
                                    <div class="modal-body">
                                      <input type="hidden" id="videoIdx" name="videoIdx" value="example_video_1">
                                      <input type="hidden" id="fileId" name="fileId" value="">
                                      <input type="hidden" id="index" name="index" value="">
                                      <input type="hidden" id="ValidateCaptcha_cnid" name="ValidateCaptcha[cnid]" value="<?= $model->course_id; ?>">
                                      <input type="hidden" id="ValidateCaptcha_lid" name="ValidateCaptcha[lid]" value="">
                                      <div class="row">
                                        <div class="col-md-12">
                                          Please Click Confirm To Continue
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <?php if($model->type == 'vdo'){ ?>
                                        <button type="button" id="yt2" class="btn btn-primary">ยืนยัน</button>
                                      <?php }else if($model->type == 'pdf'){ ?>
                                        <button type="button" id="yt3" class="btn btn-primary">ยืนยัน</button>
                                      <?php } ?>
                                    </div>
                                  </div>
                                  <?php $this->endWidget(); ?>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="modal fade" id="stopLearn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="false">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
                                </div>
                                <div class="modal-body text-center">
                                  Please intend to study
                                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div> -->
                </div>
              </div>
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
             var current_slide
             function setCurrentSlide(current_slide){
               this.current_slide = current_slide;
             }
             function getCurrentSlide(){
               return current_slide;
             }
           </script>

           <script type="text/javascript">

            $(document).ready(function () {



             <?php if($model->type =='pdf'){ ?>
              function getSlideFromDatabase(){
               var slideInDatabase;
               $.post('<?php echo $this->createUrl("//course/GetSlide"); ?>', {
                id: <?php echo $file->id; ?>,
                learn_id: <?php echo $learn_id; ?>
              }, function (data) {
                data = JSON.parse(data);
                slideInDatabase  = parseInt(data.slide);
                console.log('slideBase: '+slideInDatabase);
              });
             }
           <?php } ?>
           var myVar;
           var width = $(document).width();
           var height = $(document).height();
           $(".video-js").each(function (videoIndex) {
            console.log(videoId);
            var videoId = $(this).attr("id");
            var lessonId = $(this).attr("lesson_id");
            var index = $(this).attr("index");
            var fileId = $(this).attr("fileId");
            var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

            var myPlayer = videojs(videoId);
                            //detect Click out bound video
                                var $win = $(window); // or $box parent container
                                var $box = $(".video-js");
                                $win.on("click.Bst", function(event){      
                                  if ( $box.has(event.target).length == 0  &&!$box.is(event.target) ){
                                                // alert('you clicked outside the video');
                                                myPlayer.pause(); 
                                              } 
                                            // else {
                                            //     console.log('you clicked inside the video');
                                            // }
                                          });
                                 //Detect key for stop video
                                 var keys = {};
                                 $(document).keydown(function (e) {
                                    // console.log(e.which);
                                        // 17 Ctrl, 18 Alt, 9 Tab
                                        if(e.which == 17 || e.which == 18 || e.which == 9){
                                          myPlayer.pause(); 
                                        }
                                      });

                                //Restore down (mini size browser)
                                $(window).bind('resize', function() {
                                    // alert('STOP');
                                    var current_width = $(document).width();
                                    var current_height = $(document).height();
                                    myPlayer.pause();
                                    if (current_width < width && current_height < height) {
                                      console.log('HIDE !!!!!!!!!!!');
                                        //vjs-paused
                                        $(".vjs-control-bar").css("display", "none");
                                        $("video").css("display", "none");
                                        $('video').click(function(){return false;});
                                        $('#stopLearn').modal({backdrop: 'static', keyboard: false});
                                        $('#stopLearn').modal('show');
                                        // $('video').click(false);
                                        myPlayer.pause();
                                      }else{
                                        $(".vjs-control-bar").css("display", "block");
                                        $("video").css("display", "block");
                                        $('video').click(function(){return false;});
                                        $('#stopLearn').modal('hide');
                                        // $('video').click(true);
                                      }
                                      
                                    });

                                window.onblur = function() { 
                                    // console.log('blur'); 
                                    myPlayer.pause();
                                  }

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

                                    var timeSetRandom = <?= $time->captchaTime->capt_time_random*60 ?>; 
                                    var myPlayer = videojs(videoId);
                                    var currentTime = myPlayer.currentTime();
                                    var modulus = currentTime%timeSetRandom;
                                    var time = timeSetRandom-modulus;
                                    var allTime = currentTime+time;
                                    var lengthOfVideo;
                                    lengthOfVideo = myPlayer.duration();
                                    <?php $checkType = in_array("1", json_decode($time->captchaTime->type));
                                    if(!$checkType){
                                     $checkType = 0;
                                   } 
                                   ?>
                                   <?php if($learnFiles->learn_file_status != 's' && $time && $checkType){ ?>
                                     clearTimeout(myVar);
                                     myVar = setTimeout(function() {
                                      checkTime();
                              },timeSetRandom*1000);//timeSetRandom
                                   <?php } ?>
                                   $(".video-js").each(function (index) {
                                    if (videoIndex !== index) {
                                     this.player.pause();
                                   }
                                 });
                                 });

                                  this.on("pause", function (e) {
                                    clearTimeout(myVar);
                                // clearInterval(interval);
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

<script>
 function hideImage(idx = 0,count,i){
  count = parseInt(count);
  i = parseInt(i);
  for (i; i < count; i++) {
   $("img#slide"+idx+"_"+i).css("display", "none");
 }
}

$(document).ready(function () {
  localStorage.removeItem("learn_status");
  <?php if($model->type == 'vdo' || $model->type == 'scorm') { ?>
   $("#collapse<?= $_GET['collapse'] ?>").addClass("collapse in");
 <?php } else { ?>
  $("#collapsepdf_<?= $_GET['file'] ?>").addClass("collapse in");
  if($('.carousel-inner .item:first').hasClass('active')) {
   $("#myCarousel<?= $_GET['file']; ?>").children('.left.carousel-control').hide();
 } else {
   $("#myCarousel<?= $_GET['file']; ?>").children('.left.carousel-control').show();
 }
 <?php if(!empty($timeCountDown) && $learnFiles != "pass"){ ?>
   var t = new Date();
   t.setSeconds(t.getSeconds() + <?= $timeCountDown; ?>);
   $("#myCarousel<?= $_GET['file']; ?>").children("#nextPageTag<?= $_GET['file']; ?>").hide();
   countdownTime(<?= $timeCountDown ?>,<?= $_GET['file']; ?>,'null',false);
 <?php } else { ?>
  $("#myCarousel<?= $_GET['file']; ?>").children("#nextPageTag<?= $_GET['file']; ?>").show();
  $("#myCarousel<?= $_GET['file']; ?>").children("#prePageTag<?= $_GET['file']; ?>").show();
<?php } 
} ?>

$('.carousel').carousel({
  interval: false
});
});
function openNav() {
  document.getElementById("mySidenav").style.width = "400px";
  document.getElementById("main").style.marginRight = "400px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginRight= "0";
}

function active_file(file_id,learn_id){
  $('#file_active').val(file_id);
  time_countdown_start_ajax(learn_id);     
}

function time_countdown_start_ajax(learn_pdf_id){
  var file_id = $('#file_active').val();
  $.ajax({
   url: "<?php echo Yii::app()->createUrl("course/CountdownAjax"); ?>",
   type: "POST",
   dataType: "JSON",
   data: {file_id:file_id,learn_pdf_id:learn_pdf_id},
   success:function(data){
    if(data.status!=false){
     if(data.idx != 1)$("#myCarousel"+file_id).children("#prePageTag"+file_id).show();
     $("#myCarousel"+file_id).children("#nextPageTag"+file_id).hide();
     countdownTime(data.dateTime,file_id,'null',false);
   } else {
     clearInterval(interval);
     $("#myCarousel"+file_id).children("#nextPageTag"+file_id).show();
   }
 }
});
}

var interval;

function countdownTime(time_down,file,type){
  var count = time_down;
  var minute = 0;
  var second = 0;
  var timeStr = '';
  clearInterval(interval);
  interval = setInterval(function() {
   count--;
   if(count >= 60){
    minute = parseInt(count/60) < 10 ? "0"+parseInt(count/60):parseInt(count/60);
    second = (count % 60) < 10 ? "0"+count % 60 : count % 60;
  } else {
    second = count < 10 ? '0'+count : count;
    minute = '00';
  }
  timeStr = 'หน้าถัดไป : '+minute+':'+second+'';
  $("#timeCountdownCarousel"+file).html(timeStr);
  $("#timeCountdownCarousel"+file).css("display", "block");
  if (count <= 0) {
    clearInterval(interval);
    $("#nextPageTag"+file).css("display", "block");
    $("#timeCountdownCarousel"+file).css("display", "none");
    if(type==true){
     swal({
      title: "<?= $pass_msg ?>",
      text: "<?= $next_step_msg ?>",
      type: "success",
      confirmButtonText: "<?= $ok_msg ?>",
      cancelButtonText: "<?= $cancel_msg ?>",
      showCancelButton: true,
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
                                    // window.location.href = "<?php echo $this->createUrl('course/courselearn'); ?>";
                                    window.location.href = "<?php echo $this->createUrl('course/detail'); ?>"+"/"+<?= $model->course_id; ?>;
                                  }
                                }
                                );
   }
 }
}, 1000);
}

<?php if($time){ ?>
  $("#yt0").click(function() {
   $.ajax({
    url: "<?= Yii::app()->createUrl("course/checkcaptcha"); ?>",
    type: "POST",
    dataType: 'json',
    data: $("#validate-form").serialize(),
    success:function(data){
     var videoId = document.getElementById("videoIdx").value;
     var times = <?php echo $time->captchaTime->capt_times; ?>;
     var timeBack = <?php echo $time->captchaTime->capt_wait_time*1000; ?>;
     $("#yw0_button").click();
     if(data.status == 1){
      var t = new Date();
      t.setSeconds(t.getSeconds() + 999999);
      time_test_start(t);
      swal({
       title: "ถูกต้อง!",
       text: "รหัสยืนยันถูกต้อง",
       type: "success",
       timer: 3000
     });
      $('#myModal').modal('toggle');
      var myPlayer = videojs(videoId);
      myPlayer.play(); 
    } else if(data.status == 2) {
      getRollBack(data.status);
    } else {
      $("#ValidateCaptcha_verifyCode").val('');
      swal("กรอกรหัสผิดผลาด", "คุณมีโอกาสตอบผิดอีกจำนวน "+(times-data.count)+" ครั้ง", "error");
    }
  }
});
 });

  $("#yt2").click(function() {
    var videoId = document.getElementById("videoIdx").value;
    $('#newModal').modal('toggle');
    var myPlayer = videojs(videoId);
    myPlayer.play(); 
  });

  $("#yt3").click(function(event) {
    var current_slide = getCurrentSlide();
    $.post('<?php echo $this->createUrl("//course/LearnPdf"); ?>', {
      id: <?php echo $file->id; ?>,
      learn_id: <?php echo $learn_id; ?>,
      slide: current_slide
    }, function (data) {
      data = JSON.parse(data);
      if (typeof data.indicators !== 'undefined' && typeof data.no !== 'undefined') {
        $('#indicators'+data.no).append(data.indicators);
      }

      if(data.status){
        $('#ic_pdf_'+data.no).addClass("o-view");
        swal({
          title: "<?= $pass_msg ?>",
          text: "<?= $next_step_msg ?>",
          type: "success",
          confirmButtonText: "<?= $ok_msg ?>",
          cancelButtonText: "<?= $cancel_msg ?>",
          showCancelButton: true,
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm) {
            window.location.href = "<?php echo $this->createUrl('course/detail'); ?>"+"/"+<?= $model->course_id; ?>;
          }
        }
        );

      }

      $('#imageCheck_' + data.no).html(data.image);
      if(data.timeNext) {
        $("#nextPageTag<?= $file->id; ?>").css("display", "none");
        countdownTime(data.timeNext,<?= $file->id; ?>,data.status);
      } else {
        clearInterval(interval);
        $("#nextPageTag<?= $file->id; ?>").css("display", "block");
        $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
      } 
      init_knob();
    }); 

    $('#newModal').modal('toggle');
  });

                //PDF
                $("#yt1").click(function() {
                  $.ajax({
                    url: "<?= Yii::app()->createUrl("course/checkcaptcha"); ?>",
                    type: "POST",
                    dataType: 'json',
                    data: $("#validate-form").serialize(),
                    success:function(data){
                      var times = <?= isset($time->captchaTime->capt_times)? $time->captchaTime->capt_times: 0; ?>;
                      var timeBack = <?= isset($time->captchaTime->capt_wait_time)?  $time->captchaTime->capt_wait_time*1000: 0; ?>;
                      $("#yw0_button").click();
                      if(data.status == 1){
                        var t = new Date();
                        t.setSeconds(t.getSeconds() + 999999);
                        time_test_start(t);
                        swal({
                          title: "ถูกต้อง!",
                          text: "รหัสยืนยันถูกต้อง",
                          type: "success",
                          timer: 3000
                        });
                        var current_slide = getCurrentSlide();
                        $.post('<?php echo $this->createUrl("//course/LearnPdf"); ?>', {
                          id: <?php echo $file->id; ?>,
                          learn_id: <?php echo $learn_id; ?>,
                          slide: current_slide
                        }, function (data) {
                          data = JSON.parse(data);
                          if (typeof data.indicators !== 'undefined' && typeof data.no !== 'undefined') {
                            $('#indicators'+data.no).append(data.indicators);
                          }

                          if(data.status){
                            <?php 
                            if(isset($_GET['file'])){
                                                // $modelFilePdfCollapse = ControlVdo::model()->find(array('condition' => 'file_id='.$_GET['file']));
                                                // $modelFilsChk = ControlVdo::model()->findAll(array('condition' => 'parent_id='.$modelFilePdfCollapse->id));
                                                // foreach ($modelFilsChk as $key => $val) {
                              ?>
                                                    // $('#ic_a_pdf_'+<?= $val->file_id; ?>).attr("href", "<?= $this->createUrl('learn/learning',array('id'=>$_GET['id'],'course_id' => $_GET['course_id'],'collapsepdf' => $val->file_id)); ?>");
                                                    // $('#ic_a_pdf_<?= $val->file_id; ?>').removeAttr("onclick");
                                                    // $("#a_slide_<?= $val->file_id; ?>").removeAttr("onclick");
                                                    // $("#a_slide_<?= $val->file_id; ?>").attr("href","#collapsepdf_<?php echo $val->file_id; ?>");
                                                    <?php
                                                // }
                                                  }
                                                  ?>
                                                  $('#ic_pdf_'+data.no).addClass("o-view");
                                                  swal({
                                                    title: "<?= $pass_msg ?>",
                                                    text: "<?= $next_step_msg ?>",
                                                    type: "success",
                                                    confirmButtonText: "<?= $ok_msg ?>",
                                                    cancelButtonText: "<?= $cancel_msg ?>",
                                                    showCancelButton: true,
                                                    closeOnConfirm: true,
                                                    closeOnCancel: true
                                                  },
                                                  function(isConfirm) {
                                                    if (isConfirm) {
                                                      window.location.href = "<?php echo $this->createUrl('course/detail'); ?>"+"/"+<?= $model->course_id; ?>;
                                                    }
                                                  }
                                                  );

                                                }

                                            //if(data.camera)
                                            $('#imageCheck_' + data.no).html(data.image);
                                            if(data.timeNext) {
                                              $("#nextPageTag<?= $file->id; ?>").css("display", "none");
                                              countdownTime(data.timeNext,<?= $file->id; ?>,data.status);
                                            } else {
                                              clearInterval(interval);
                                              $("#nextPageTag<?= $file->id; ?>").css("display", "block");
                                              $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
                                            } 
                                            init_knob();
                                          }); 

$('#myModal').modal('toggle');
} else if(data.status == 2) {
  getRollBackPdf(data.status);
} else {
  $("#ValidateCaptcha_verifyCode").val('');
  swal("กรอกรหัสผิดผลาด", "คุณมีโอกาสตอบผิดอีกจำนวน "+(times-data.count)+" ครั้ง", "error");
}
}
});
});

function time_test_start(time_down){
  var count = time_down;
  var minute = 0;
  var second = 0;
  var timeStr = '';
  clearInterval(interval);
  interval = setInterval(function() {
    count--;
    if(count >= 60){
      minute = parseInt(count/60) < 10 ? "0"+parseInt(count/60):parseInt(count/60);
      second = (count % 60) < 10 ? "0"+count % 60 : count % 60;
    } else {
      second = count < 10 ? '0'+count : count;
      minute = '00';
    }
    timeStr = minute+':'+second+'';
    $("#timeTest").html(timeStr);
    if (count <= 0) {
      clearInterval(interval);
      captchaTimeOut();
    }
  }, 1000);
}
                //PDF
                function time_test_start_pdf(time_down,current_slide){
                  var count = time_down;
                  var minute = 0;
                  var second = 0;
                  var timeStr = '';
                  clearInterval(interval);
                  interval = setInterval(function() {
                    count--;
                    if(count >= 60){
                      minute = parseInt(count/60) < 10 ? "0"+parseInt(count/60):parseInt(count/60);
                      second = (count % 60) < 10 ? "0"+count % 60 : count % 60;
                    } else {
                      second = count < 10 ? '0'+count : count;
                      minute = '00';
                    }
                    timeStr = minute+':'+second+'';
                    $("#timeTest").html(timeStr);
                    if (count <= 0) {
                      console.log('clearInterval active : '+interval);
                      clearInterval(interval);
                            // captchaTimeOutPdf(current_slide);
                          }
                        }, 1000);
                }

                function getRollBack(status){
                  if(status==2){
                    var fileId = document.getElementById("fileId").value;
                    var videoId = document.getElementById("videoIdx").value;
                    var index = document.getElementById("index").value;
                    var times = <?php echo $time->captchaTime->capt_times; ?>;
                    var timeSetRollback = <?php echo $time->captchaTime->capt_time_back; ?>;
                    var myPlayer = videojs(videoId);
                    var currentTime = window["getCurrentTimeRollback"+index]();
                    var allTime = currentTime-(timeSetRollback*60);
                    var course_id = <?= $model->course_id; ?>;
                    var lesson_id = <?= $model->id; ?>;
                    $.ajax({
                      url: "<?= Yii::app()->createUrl("course/checkcaptcha"); ?>",
                      type: "POST",
                      dataType: 'json',
                      data: {id:fileId,ctime:allTime,cnid:course_id,lid:lesson_id},
                      success:function(data){
                        if(data.state==1){
                          var i = 0;
                          if(data.fileIndex>0)i = data.fileIndex;
                          hideImage(index,data.count,i);
                        }
                      }
                    });
                    $('#ValidateCaptcha_verifyCode').val("");
                    $('#myModal').modal('toggle');
                    var t = new Date();
                    t.setSeconds(t.getSeconds() + 999999);
                    time_test_start(t);
                    swal({
                      title: "กรอกรหัสผิดผลาดครบ "+times+" ครั้ง",
                      text: "คุณถูกกำหนดให้กลับไปเรียน "+timeSetRollback+" นาทีก่อน",
                      type: "warning",
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "ตกลง",
                      closeOnConfirm: true,
                      closeOnCancel: false
                    },
                    function(isConfirm) {
                      if (isConfirm) {
                        window["setTimeRollback"+index](allTime);
                        myPlayer.currentTime(allTime);
                        myPlayer.play();
                      }
                    }
                    );
                  }
                }

                function getRollBackPdf(status){
                  console.log('getRollBackPdf active');
                  if(status==2){
                    var current_slide = getCurrentSlide();
                    var course_id = <?= $model->course_id; ?>;
                    var lesson_id = <?= $model->id; ?>;

                    var file_id = <?php echo $file->id; ?>;
                    var learn_id =  <?php echo $learn_id; ?>;
                    var rollback_slide = <?php  
                    if($time && isset($time->captchaTime->prev_slide)){
                      echo $time->captchaTime->prev_slide;
                    } else {
                      echo 9999999;
                    }
                    ?>;
                    var times = <?= isset($time->captchaTime->capt_times)? $time->captchaTime->capt_times : 0; ?>;
                    rollback_slide  = current_slide - rollback_slide;
                    if(rollback_slide <= 0){
                      rollback_slide = 1;
                    }
                        //Rollback slide into database
                        $.ajax({
                          url: "<?= Yii::app()->createUrl("course/checkcaptchaPdf"); ?>",
                          type: "POST",
                          dataType: 'json',
                          data: {file_id:file_id,lesson_id:lesson_id,learn_id:learn_id,slide:rollback_slide,staTime:'timeout',cnid:<?= $model->course_id; ?>,lid:<?= $model->id; ?>},
                          success:function(data){
                            if(data.state==1){
                              $('#myCarousel<?= $file->id; ?>').carousel(rollback_slide);
                            }
                          }
                        });
                        $('#ValidateCaptcha_verifyCode').val("");
                        $('#myModal').modal('toggle');
                        var t = new Date();
                        t.setSeconds(t.getSeconds() + 999999);
                        time_test_start(t);
                        swal({
                          title: "กรอกรหัสผิดผลาดครบ "+times+" ครั้ง",
                          text: "คุณถูกกำหนดให้ถอยกลับไปเรียน "+rollback_slide+" สไลด์",
                          type: "warning",
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: "ตกลง",
                          closeOnConfirm: true,
                          closeOnCancel: false
                        },
                        function(isConfirm) {
                          if (isConfirm) {
                                // window["setTimeRollback"+index](allTime);
                                // myPlayer.currentTime(allTime);
                                // myPlayer.play();
                              }
                            }
                            );
                      }
                    }

                    function checkTime() {
                      var videoId = document.getElementById("videoIdx").value;
                      var myPlayer = videojs(videoId);
                      if(myPlayer.isFullscreen()){
                        myPlayer.exitFullscreen();
                      }
                      var currentTime = myPlayer.currentTime();
                      var lengthOfVideo = myPlayer.duration();
                      var timeBack = <?php echo $time->captchaTime->capt_wait_time; ?>;
                      if(currentTime<lengthOfVideo){
                        myPlayer.pause(); 
                        $('#ValidateCaptcha_verifyCode').val("");
                        $('#newModal').modal({backdrop: 'static', keyboard: false});
                        // $.ajax({
                        //  url: "<?php echo Yii::app()->createUrl("course/saveCaptchaStart"); ?>",
                        //  type: "POST",
                        //  dataType: 'json',
                        //  data: $("#validate-form").serialize(),
                        //  success:function(data){
                        //      if(data.timeBack)time_test_start(data.timeBack);
                        //  }
                        // });
                      }                                                
                    }


                    function captchaTimeOut(){
                      var fileId = document.getElementById("fileId").value;
                      var videoId = document.getElementById("videoIdx").value;
                      var index = document.getElementById("index").value;                 
                      var timeSetRollback = <?php  
                      if($time && isset($time->captchaTime->capt_time_back)){
                        echo $time->captchaTime->capt_time_back;
                      } else {
                        echo 9999999;
                      }
                      ?>;
                      var myPlayer = videojs(videoId);
                      var currentTime = window["getCurrentTimeRollback"+index]();
                      var allTime = currentTime-(timeSetRollback*60);
                      $.ajax({
                        url: "<?php echo Yii::app()->createUrl("course/checkcaptcha"); ?>",
                        type: "POST",
                        dataType: 'json',
                        data: {id:fileId,ctime:allTime,staTime:'timeout',cnid:<?= $model->course_id; ?>,lid:<?= $model->id; ?>},
                        success:function(data){
                          if(data.state==1){
                            var i = 0;
                            if(data.fileIndex>0)i = data.fileIndex;
                            hideImage(index,data.count,i);
                          }
                        }
                      });
                      $('#ValidateCaptcha_verifyCode').val("");
                      $('#myModal').modal('hide');
                      swal({
                        title: "คุณไม่กรอกข้อมูลตามเวลาที่กำหนด",
                        text: "คุณถูกกำหนดให้กลับไปเรียน "+timeSetRollback+" นาทีก่อน",
                        type: "warning",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "ตกลง",
                        closeOnConfirm: true,
                        closeOnCancel: false
                      },
                      function(isConfirm) {
                        if (isConfirm) {
                          window["setTimeRollback"+index](allTime);
                          myPlayer.currentTime(allTime);
                          myPlayer.play();
                        }
                      }
                      );
                    }


                    function captchaTimeOutPdf(current_slide){
                      var file_id = <?php echo $file->id; ?>;
                      var learn_id =  <?php echo $learn_id; ?>;
                      var timeSetRollback = <?php  
                      if($time && isset($time->captchaTime->prev_slide)){
                        // echo $time->captchaTime->prev_slide;
                        echo  $time->captchaTime->prev_slide;
                      } else {
                        echo 9999999;
                      }
                      ?>;
                      var current_slide = current_slide;
                      var lesson_id = <?= $model->id; ?>;
                      var rollback_slide = <?php  
                      if($time && isset($time->captchaTime->prev_slide)){
                        echo $time->captchaTime->prev_slide;
                      } else {
                        echo 9999999;
                      }
                      ?>;
                      rollback_slide  = current_slide - rollback_slide;
                      $.ajax({
                        url: "<?php echo Yii::app()->createUrl("course/CheckCaptchaPdf"); ?>",
                        type: "POST",
                        dataType: 'json',
                        data: {file_id:file_id,lesson_id:lesson_id,learn_id:learn_id,slide:rollback_slide,staTime:'timeout',cnid:<?= $model->course_id; ?>,lid:<?= $model->id; ?>},
                        success:function(data){
                          if(data.state==1){
                            $('#myCarousel<?= $file->id; ?>').carousel(rollback_slide);
                          }
                        }
                      });
                      $('#ValidateCaptcha_verifyCode').val("");
                      $('#myModal').modal('hide');
                      swal({
                        title: "คุณไม่กรอกข้อมูลตามเวลาที่กำหนด",
                        text: "คุณถูกกำหนดให้ถอยกลับไปเรียน "+timeSetRollback+" สไลด์",
                        type: "warning",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "ตกลง",
                        closeOnConfirm: true,
                        closeOnCancel: false
                      },
                      function(isConfirm) {
                        if (isConfirm) {
                            //Rollback slide
                          }
                        }
                        );
                    }

                  <?php } ?>

                  $(document).on("contextmenu",function(e){
                    swal({
                      title: "แจ้งเตือน!",
                      text: "ไม่สามารถคลิ๊กขวาได้",
                      type: "warning",
                      timer: 1000
                    });
                    return false;
                  }); 
                  $(document).keydown(function(event){
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
                  });
                </script>
