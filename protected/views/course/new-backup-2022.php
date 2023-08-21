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
    $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
    //$strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

//	$strDate = "2008-08-14 13:42:44";
//	echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_news ?></li>
        </ol>
    </nav>
</div>


<section class="content" id="banner-news">
    <div class="container">
        <div class="row">
            <?php
            $criteria = new CDbCriteria;
            $criteria->compare('active', y);
            $criteria->compare('lang_id', $langId);
            $criteria->order = 'sortOrder  ASC';
            ?>
            <?php $news = News::model()->findAll($criteria); ?>
            <?php foreach ($news as $all) { ?>
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <div class="card news-card">
                        <?php
                        if (Yii::app()->session['lang'] == 1) { ?>
                            <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->cms_id)); ?>">
                            <?php } else { ?>
                                <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->parent_id)); ?>">
                                <?php  }
                                ?>

                                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' . $all->cms_id . '/' . $all->cms_picture)) { ?>
                                    <div class="news-img">
                                        <img src="<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $all->cms_id ?>/<?php echo $all->cms_picture ?>" alt="">
                                    <?php } else { ?>
                                        <div class="news-img">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/news.jpg" alt="">
                                        <?php } ?>
                                        <!-- <span class="news-date"><?php echo DateThai($all->update_date) ?></span> -->
                                         <!-- <span class="news-date"><?php echo Helpers::lib()->DateLang($all->update_date, Yii::app()->session['lang']); ?></span> -->
                                        </div>
                                        <div class="card-body" style="padding:10px;">
                                            <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->parent_id)); ?>" style="text-decoration: none">
                                                <h4 class="card-title  text-4 "><?php echo $all->cms_title ?></h4>
                                            </a>
                                            <div class="mb-1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/calendar-icon.png"><small>&nbsp;<?php echo DateThai($all->update_date) ?></small></div>
                                            <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->parent_id)); ?>" class="more-news pull-right mt-1" style="text-decoration: none"><small>Read More <i class="fas fa-chevron-right text-1 ms-1"></i></small> </a>
                                        </div>
                                      
                                </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>