<?php

function DateThai($strDate) {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
 
//	$strDate = "2008-08-14 13:42:44";
//	echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>
<!-- Header page -->
<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
	<div class="container">
		<h1><?=$video_data->vdo_title ?>
		<small class="pull-right">
		<ul class="list-inline list-unstyled">
			<li><a href="<?php echo $this->createUrl('/site/index'); ?>">หน้าแรก</a></li>/
			<li><a href="<?php echo $this->createUrl('/video/index'); ?>">วิดีโอ</a></li>
			<li><a href="#"><?=$video_data->vdo_title ?></a></li>
		</ul>
		</small>
		</h1>
	</div>
	<div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
</div>
<!-- Content -->
<section class="content" id="video-detail">
	<div class="container">
		<div class="well">
			<!-- sty comment class="video-js"-->
			<?php 
            if($video_data->vdo_type == 'link'){
                $vdoName = $video_data->vdo_path;
                $new_link = str_replace("watch?v=", "embed/", $vdoName);
                $show = '<iframe class="embed-responsive-item" height="500" width="100%" src="'.$new_link.'" allowfullscreen></iframe>';
                echo $show;
            } else {
            ?>
            <video  controls preload="auto" height="100%" width="100%">
				<!-- video show-->
                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot').'/admin/uploads/'.$video_data->vdo_path)) { ?>
                    <source src="<?php echo Yii::app()->baseUrl; ?>/admin/uploads/<?php echo $video_data->vdo_path; ?>" type='video/mp4'>
                        <?php } else { ?> 
                    <source src="<?php echo Yii::app()->theme->baseUrl; ?>/vdo/mov_bbb.mp4" type='video/mp4'>
                        <?php } ?>
                <!-- video show-->
				<p class="vjs-no-js">
					To view this video please enable JavaScript, and consider upgrading to a web browser that
					<a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
				</p>
			</video>
            <?php
            }
            ?>
		</div>
		<div class="detail-content">
			<div class="content-header">
				<div class="pull-left">
					<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/youtube.png" alt="">
				</div>
				<h2> <?=$video_data->vdo_title ?></h2>
				<ul class="list-inline">
					<li><small><i class="fa fa-calendar"></i> <?php echo DateThai($video_data->update_date) ?></small></li>
					<li><small><i class="fa fa-user"></i> <?=$name->firstname .'&nbsp;'.$name->lastname?></small></li>
				</ul>						
			</div>
			<div class="detail">
                                    ยังไม่มีเนื้อหา
                                    
                                </div>
		</div>
	</div>
</section>		