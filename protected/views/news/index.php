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



<section class="content-page" id="banner-news">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-main">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                    <!-- <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li> -->
                    <li class="breadcrumb-item active" aria-current="page"><?= $label->label_news ?></li>
                </ol>
            </nav>
        </nav>
        <div class="content-main">

            <section class="search-filter">
                <form class="form row" enctype="multipart/form-data" id="vdo-form" action="<?php echo $this->createUrl('/news/index'); ?>" method="post"> 
                    <div class="col-lg-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
                        <div class="wrapsearch">
                            <div class="form-group mx-sm-3">
                                <input type="text" value="<?=$textold?>" name="cms_title"  class="form-control" id="inputPassword2" placeholder="ค้นหาด้วยชื่อข่าวประชาสัมพันธ์">
                            </div>
                            <div class="wrap-btn-search">
                                <button type="submit" class="btn btn-primary btn-search"><i class="fas fa-search"></i>ค้นหา</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group wrap-form-lable">
                             <select id="inputState" name="sort" class="form-control">
                                <option <?=$sort == 1 ? "selected" : ""?> value="1">ใหม่ล่าสุด</option>
                                <option <?=$sort == 2 ? "selected" : ""?> value="2">เก่าสุด</option>
                            </select>
                            <label for="floatingSelect">จัดเรียง</label>
                        </div>
                    </div>
                </form>
            </section>

            <section class="all-course">
                <div class="row">
                    <?php foreach ($news as $all) { ?>
                        <?php 
                        $criteria = new CDbCriteria;
                        if($all->parent_id != 0){
                            $criteria->compare('cms_id', $all->parent_id);
                        }else{
                            $criteria->compare('cms_id', $all->cms_id);
                        }
                        $count = CounterNews::model()->count($criteria);
                         ?>
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="card news-card"> 
                                <?php
                                $arr = json_decode($all->cms_link);
                                $new_tab = ($arr[1] == '0') ? '' : 'target="_blank"';
                                if (Yii::app()->session['lang'] == 1) { ?>
                                      <?php if($all->cms_type_display == 'url' && $new_tab && $all->parent_id == 0) { ?>
                                                <a <?= $new_tab ?> href="<?php echo $arr[0]; ?>">
                                       <?php }else{ ?>
                                                <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->cms_id)); ?>">
                                       <?php } ?>
                                 
                                    <?php } else { ?>
                                        <?php if($all->cms_type_display == 'url' && $new_tab && $all->parent_id != 0) { ?>
                                                <a <?= $new_tab ?> href="<?php echo $arr[0]; ?>">
                                       <?php }else{ ?>
                                                <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->cms_id)); ?>">
                                       <?php } ?>
                                    <?php  } ?>

                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' . $all->cms_id . '/' . $all->cms_picture)) { ?>
                                            <div class="news-img">
                                                <img src="<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $all->cms_id ?>/<?php echo $all->cms_picture ?>" alt="">
                                            <?php } else { ?>
                                                <div class="news-img">
                                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/news.jpg" alt="">
                                                <?php } ?>
                                               
                                                </div>
                                                <div class="card-body" style="padding:10px;">
                                                  

                                                  <?php  if (Yii::app()->session['lang'] == 1) { ?>
                                                        <?php if($all->cms_type_display == 'url' && $new_tab && $all->parent_id == 0) { ?>
                                                            <a <?= $new_tab; ?> href="<?= $arr[0] ?>" style="text-decoration: none">
                                                                <h4 class="card-title  text-4 "><?php echo $all->cms_title ?></h4>
                                                            </a>
                                                        <?php }else{ ?>
                                                            <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->cms_id)); ?>" style="text-decoration: none">
                                                                <h4 class="card-title  text-4 "><?php echo $all->cms_title ?></h4>
                                                            </a>
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                        <?php if($all->cms_type_display == 'url' && $new_tab && $all->parent_id != 0) { ?>
                                                            <a <?= $new_tab; ?> href="<?= $arr[0] ?>" style="text-decoration: none">
                                                                <h4 class="card-title  text-4 "><?php echo $all->cms_title ?></h4>
                                                            </a>
                                                        <?php }else{ ?>
                                                            <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->cms_id)); ?>" style="text-decoration: none">
                                                                <h4 class="card-title  text-4 "><?php echo $all->cms_title ?></h4>
                                                            </a>
                                                        <?php } ?>

                                                    <?php } ?>
                                               
                                                    <div class="mb-1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/calendar-icon.png"><small>&nbsp;<?php echo DateThai($all->update_date) ?></small></div>
                                                    <div class="mb-1"><i class="fa fa-eye" aria-hidden="true"></i><small>&nbsp;&nbsp;<?= $count ?></small> </div>


                                                    <!-- <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->parent_id)); ?>" class="more-news pull-right mt-1" style="text-decoration: none"><small>Read More <i class="fas fa-chevron-right text-1 ms-1"></i></small> </a> -->
                                                </div>

                                        </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </section>

        </div>
    </div>
</section>