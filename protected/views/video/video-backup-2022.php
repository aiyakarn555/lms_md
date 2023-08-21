<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_vdo ?></li>
        </ol>
    </nav>
</div>

<section class="content" id="video">
    <div class="container">
        <div class="row">
            <?php foreach ($Video as $vdo) { ?>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="well">
                        <?php
                        if ($vdo->vdo_type == 'link') {
                            $vdoName = $vdo->vdo_path;
                            $new_link = str_replace("watch?v=", "embed/", $vdoName);
                            $show = '<iframe class="embed-responsive-item" width="100%" height="55"  src="' . $new_link . '" allowfullscreen style="box-shadow:1px 4px 6px #767676"></iframe>';
                            echo $show;
                            $href = 'href="' . $vdo->vdo_path . '" target="_blank"';
                        } else {
                            $href = 'href="javascript:void(0)"';
                        ?>
                            <video class="video-js" poster="<?php echo Yii::app()->baseUrl . "/uploads/$vdo->vdo_thumbnail"; ?>" controls preload="auto" style="width: 100%; height: 176px;">
                                <!-- video show-->
                                <?php
                                if (file_exists(YiiBase::getPathOfAlias('webroot') . '/admin/uploads/' . $vdo->vdo_path)) {
                                    $file_name = Yii::app()->baseUrl . '/admin/uploads/' . $vdo->vdo_path;
                                } else {
                                    $file_name = Yii::app()->theme->baseUrl . '/vdo/mov_bbb.mp4';
                                }
                                $show = "<source src=" . $file_name . " type='video/mp4'>";
                                echo $show;
                                ?>
                                <!-- video show-->
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a web browser that
                                    <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                </p>
                            </video>
                        <?php
                        }
                        ?>

                        <a <?= $href ?>>
                            <div class="video-detail">
                                <?= $vdo->vdo_title ?>
                            </div>
                        </a>
                        <div class="detail-p">
                            <?php
                            $head_credit = "";
                            if (Yii::app()->session['lang'] == 1) {
                                $head_credit = "Credit :";
                            } else {
                                $head_credit = "ที่มา :";
                            }
                            if ($vdo->vdo_credit != null) {
                                echo "<b>";
                                echo $head_credit;
                                echo "</b>";
                                echo $vdo->vdo_credit;
                            }

                            ?>
                        </div>
                        <span class="news-date"><i class="fa fa-calendar"></i>&nbsp;<?php echo Helpers::lib()->DateLang($vdo->update_date, Yii::app()->session['lang']); ?></span>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</section>
<?php

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

//  $strDate = "2008-08-14 13:42:44";
//  echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>