<?php

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

//	$strDate = "2008-08-14 13:42:44";
//	echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>


<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/news/index'); ?>"><?php echo Yii::app()->session['lang'] == 1?'News':'ข่าวประชาสัมพันธ์'; ?> </a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $news_data->cms_title ?></li>
        </ol>
    </nav>
</div>
<?php
           
        ?>
<section class="content" id="banner-news-detail">
    <div class="container">
        <div class="well">
            <div class="news-detail-img">
                <?php
                // if (Yii::app()->session['lang'] == 1) {
                          
                ?>
                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' . $news_data->cms_id . '/' . $news_data->cms_picture)) { ?>
                    <img src="<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $news_data->cms_id ?>/<?php echo $news_data->cms_picture ?>" class="img-responsive center-block img-rounded" alt="">
                <?php } else { ?>
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/news.jpg" class="img-responsive center-block img-rounded" alt="">
                <?php } 
                
                ?>
            </div>
        </div>
        <div class="news-detail-content">
            <div class="content-header">
                <div class="pull-left">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/text-lines.png" alt="">
                </div>
                <h2><?php 
                echo $news_data->cms_title;
                 ?></h2>
                <ul class="list-inline">
                    <!-- <li><small><i class="fa fa-calendar"></i> <?php echo DateThai($news_data->update_date) ?></small></li> -->
                    <!-- <li><small><i class="fa fa-calendar"></i> <?php echo Helpers::lib()->DateLang($news_data->update_date, Yii::app()->session['lang']); ?></small></li> -->

                    <?php
                    $id = $news_data->create_by;
                    $create = Profile::model()->findbyPk($id);
                    ?>
                    <li><small><i class="fa fa-user"></i> <?= Yii::app()->session['lang'] == 1 ?$create->firstname_en." ".$create->lastname_en  : $create->firstname." ".$create->lastname; ?></small></li>
                    
                </ul>
            </div>
            <div class="content-detail">
                <?php echo htmlspecialchars_decode(htmlspecialchars_decode($news_data->cms_detail)); ?>
            </div>
            <hr>
            <?php
            if (!empty($news_data->cms_link)) {
                $arr = json_decode($news_data->cms_link);
                $link = $arr[0];
                $new_tab = ($arr[1] == '0') ? '' : 'target="_blank"';
            ?>
                <div class="content-detail">
                    <a href="<?php echo $link; ?>" <?= $new_tab ?>><?php echo Yii::app()->session['lang'] == 1?'More links':'ลิงค์เพิ่มเติม'; ?></a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>