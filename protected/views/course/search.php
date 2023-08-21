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


<?php $Model = CourseOnline::model()->findAll(array('condition' => 'active="y"', )); ?>    

<?php  $model_cate = Category::model()->findAll(); ?>


<section class="content" id="course">
    <div class="container">
        <!--start total search-->
        <div class="text-center">
            <?php
            
            $search3 = CourseOnline::model()->findAll(array(
            'condition' => ' course_title LIKE "%' . $text . '%" '));
            
            $searchtotal3 = count($search3);
 
            $total = $searchtotal3;
            ?>
            <strong>ผลลัพธ์ทั้งหมด : <?php echo $total; ?> รายการ</strong>
            <br><br>
        </div>
        <!--end total search-->
        <?php if($total !== 0) { ?>
       
        <!-- start course search -->
        <?php
        $search3 = CourseOnline::model()->findAll(array(
            'condition' => ' course_title LIKE "%' . $text . '%" '));
        if ($search3 == null){
            
        } else {
            echo "<h2>หลักสูตร</h2>";
            echo '<br>';
        }
        ?>

                    <?php    foreach ($search3 as $mod) {
            $str = $mod->course_title;
            $keyword = $text; ?>
            <div class="col-sm-8 col-md-4">
                <div class="row">
                       <div class="well">
                            <a href="<?php echo $this->createUrl('/course/detail/'.$mod->course_id ); ?>">
                                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $mod->course_id.'/thumb/'.$mod->course_picture)) { ?>
                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->homeUrl; ?>/uploads/courseonline/<?php echo $mod->course_id.'/thumb/'.$mod->course_picture; ?>);"></div>
                                        <?php } else { ?>
                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                        <?php } ?> 

                                <div class="course-detail">
                                    <h4 class="text11"><?php echo str_ireplace($keyword, '<span class="bg-primary">' . $keyword . '</span>', $str); ?></h4>
                                    <p class="p"><?=$mod->course_short_title ?></p>
                                    <i class="fa fa-calendar"></i>&nbsp;<?php echo DateThai($mod->update_date); ?>
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
