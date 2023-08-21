
<style type="text/css">
    #course .well .course-img{
        height: 180px;
    }
    #course .well{
        margin: 10px 10px 20px 10px;
    }
</style>

<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-main">
      <li class="breadcrumb-item">
        <a href="<?php echo $this->createUrl('/site/index'); ?>">
          <?php
          if (Yii::app()->session['lang'] == 1) {
            echo "Home";
          } else {
            echo "หน้าแรก";
          }
          ?>
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        <?php
        if (Yii::app()->session['lang'] == 1) {
          echo "Search";
        } else {
          echo "ค้นหา";
        }
        ?>
      </li>
    </ol>
  </nav>
</div>

<!-- Content -->
<section class="content" id="course">
    <div class="container">
        <!--start total search-->
        <div class="text-center">
            <?php
            $total = count($Model) + count($modelCourseTms);
            ?>
            <strong>ผลลัพธ์ทั้งหมด : <?php echo $total; ?> รายการ</strong>
            <br><br>
        </div>
        <!--end total search-->
        <?php if($total !== 0) { ?>
         <h2>หลักสูตร</h2>
         <br>
         <?php foreach ($modelCourseTms as $mod){
            $str = $mod->course->course_title;
            $schedule = $mod->schedule;
            $keyword = $text; 
            $expireDate = Helpers::lib()->checkCourseExpireTms($schedule);
            if($expireDate){
                $evnt = '';
                $url = Yii::app()->createUrl('course/detail/', array('id' => $mod->course_id,'courseType'=>'tms'));
            } else {
                if(date($schedule->training_date_start) > date("Y-m-d")){
                    $evnt = 'onclick="alertMsgNotNow()"';
                    $url = 'javascript:void(0)';
                }else{
                    $evnt = 'onclick="alertMsg()"';
                    $url = 'javascript:void(0)';
                }
            }
            ?>
            <div class="col-sm-8 col-md-4">
                <div class="row">
                   <div class="well">
                     <a href="<?= $url; ?>" <?= $evnt?>>
                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $mod->course->course_id.'/thumb/'.$mod->course->course_picture)) { ?>
                            <div class="course-img" style="background-image: url(<?php echo Yii::app()->homeUrl; ?>/uploads/courseonline/<?php echo $mod->course->course_id.'/thumb/'.$mod->course->course_picture; ?>);"></div>
                        <?php } else { ?>
                            <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                        <?php } ?> 

                        <div class="course-detail">
                            <h4 class="text11"><?php echo str_ireplace($keyword, '<span class="bg-primary">' . $keyword . '</span>', $str); ?></h4>
                            <p class="p"><?=$mod->course->course_short_title ?></p>
                            <i class="fa fa-calendar"></i>&nbsp;<?php echo DateThai($mod->course->update_date); ?>
                        </div>
                    </a>        
                </div>
            </div>
        </div>
    <?php } ?>
    <?php foreach ($Model as $mod){
        $str = $mod->course->course_title;
        $keyword = $text; 
        $expireDate = Helpers::lib()->checkCourseExpire($mod->course);
        if($expireDate){
            $evnt = '';
            $url = Yii::app()->createUrl('course/detail/', array('id' => $mod->course_id));
        } else {
            if(date($mod->course->course_date_start) > date("Y-m-d")){
                $evnt = 'onclick="alertMsgNotNow()"';
                $url = 'javascript:void(0)';
            }else{
                $evnt = 'onclick="alertMsg()"';
                $url = 'javascript:void(0)';
            }
        }
        ?>
        <div class="col-sm-8 col-md-4">
            <div class="row">
               <div class="well">
                <a href="<?= $url; ?>" <?= $evnt?>>
                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $mod->course->course_id.'/thumb/'.$mod->course->course_picture)) { ?>
                        <div class="course-img" style="background-image: url(<?php echo Yii::app()->homeUrl; ?>/uploads/courseonline/<?php echo $mod->course->course_id.'/thumb/'.$mod->course->course_picture; ?>);"></div>
                    <?php } else { ?>
                        <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                    <?php } ?> 

                    <div class="course-detail">
                        <h4 class="text11"><?php echo str_ireplace($keyword, '<span class="bg-primary">' . $keyword . '</span>', $str); ?></h4>
                        <p class="p"><?=$mod->course->course_short_title ?></p>
                        <i class="fa fa-calendar"></i>&nbsp;<?php echo DateThai($mod->course->update_date); ?>
                    </div>
                </a>        
            </div>
        </div>
    </div>
<?php } ?>
<!-- end course search -->
<?php }else{
    echo '<div class="well">';
    echo 'ไม่พบข้อมูลที่ต้องการค้นหา'  ;
    echo '</div>';
} ?>

</div>
</section>






<?php

function DateThai($strDate) {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

?>
<script type="text/javascript">
    function alertMsg() {

        var title = '<?= !empty($label->label_swal_warning)? $label->label_swal_warning :''; ?>';
        var message = '<?= !empty($label->label_alert_msg_expired)? $label->label_alert_msg_expired:''; ?>';
        var alert = 'error';

        swal(title, message, alert);
    }

    function alertMsgNotNow() {
        <?php 
        if($langId == 1){
            $strDate = "Comming soon!";
        }else{
            $strDate = "ยังไม่ถึงเวลาเรียน";
        }
        ?>
        var title = '<?= !empty($label->label_swal_warning)? $label->label_swal_warning :''; ?>';
        var message = '<?= !empty($strDate)? $strDate:''; ?>';
        var alert = 'error';

        swal(title, message, alert);
    }


</script>