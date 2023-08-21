<!DOCTYPE html>
<?php

if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));

    if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
        $langId = Yii::app()->session['lang'] = 1;
    } else {
        $langId = Yii::app()->session['lang'];
    }

    if($langId == 1)
    {
     $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
 }
 else{
   $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
}


$strMonthThai = $strMonthCut[$strMonth];
return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}
?>
<html lang="th">

<?php include './include/head.php'; ?>

<body>

    <?php include './include/header.php'; ?>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $label->label_imgslide ?></li>
            </ol>
        </nav>
    </div>

    <section class="content" id="banner-news">
        <div class="container">
            <div class="row">
                <?php
                $criteriaimg = new CDbCriteria;
                $criteriaimg->compare('active', y);
                $criteriaimg->compare('lang_id', $langId);
                $criteriaimg->order = 'update_date  DESC';
                $image = Imgslide::model()->findAll($criteriaimg);
                ?>
                <?php foreach ($image as $all) { 
                    ?>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="well">
                            <a href="<?php echo $this->createUrl('/banner/detail', array('id' => $all->imgslide_id)); ?>">
                                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/imgslide/' . $all->imgslide_id . '/thumb/' . $all->imgslide_picture)) { ?>
                                    <div class="news-img" style="background-image: url(<?php echo Yii::app()->baseUrl; ?>/uploads/imgslide/<?php echo $all->imgslide_id . '/thumb/' . $all->imgslide_picture; ?>);">
                                    <?php } else { ?>
                                        <div class="news-img" style="background-image: url('<?php echo Yii::app()->theme->baseUrl; ?>/images/slide-news.jpg');">
                                        <?php } ?>
                                        <?php if($all->update_date != null) {?>
                                            <span class="news-date"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo DateThai($all->update_date) ?></span>
                                        <?php }else{?>
                                         <span class="news-date"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo DateThai($all->create_date) ?></span>
                                     <?php } ?>

                                 </div>
                                 <div class="news-detail">
                                    <?php echo $all->imgslide_title; ?>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include './include/footer.php'; ?>

    <!-- Script -->
    <?php include './include/script.php'; ?>

</body>

</html>