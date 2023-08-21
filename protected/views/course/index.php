<?php 
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;

} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;

}

if(Yii::app()->session['lang'] == 1)
{
    $textShow["theory"] = "Theory";

}else{
    $textShow["theory"] = "ศึกษาด้วยตนเอง (e-Learning)";
    
}

 ?>
<section class="content-page">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <!-- <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li> -->
                <li class="breadcrumb-item active"><a style="color: #757272" href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $label->label_course; ?></a></li>
            </ol>
        </nav>
        <div class="content-main">

             <section class="search-filter">
                <form class="form row" enctype="multipart/form-data" id="vdo-form" action="<?php echo $this->createUrl('/course/index'); ?>" method="post"> 

                    <div class="col-lg-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
                        <div class="wrapsearch">
                            <div class="form-group mx-sm-3">
                                <input type="text" value="<?=$textold?>" name="course_title" class="form-control" id="inputPassword2" placeholder="<?= $langId == 1 ? "Search for the course name." : "พิมพ์คำค้นหาชื่อหลักสูตร" ?>">

                            </div>
                            <div class="wrap-btn-search">
                                <button type="submit" class="btn btn-primary btn-search"><i class="fas fa-search"></i><?= $langId == 1 ? "Search" : "ค้นหา" ?> </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group wrap-form-lable">
                            <select id="inputState" name="sort" class="form-control">
                                <option <?=$sort == 1 ? "selected" : ""?> value="1"><?= $langId == 1 ? "Newest" : "ใหม่ล่าสุด" ?></option>
                                <option <?=$sort == 2 ? "selected" : ""?> value="2"><?= $langId == 1 ? "Oldest" : "เก่าสุด" ?></option>
                            </select>
                            <label for="floatingSelect"><?= $langId == 1 ? "Sort" : "จัดเรียง" ?></label>
                        </div>
                    </div>
                </form>
            </section>  

            <section class="all-course">
                <div class="wrap-title-content row">
                   <div class="col-md-8 col-xs-12">
                        <h3>
                            <?= $langId == 1 ? "All theory courses" : "หลักสูตร ศึกษาด้วยตนเอง (e-Learning) ทั้งหมด" ?>
                        </h3>
                   </div>
                    <div class="col-md-4 col-xs-12">
                        <a class="btn-link-course pull-right">
                            <span class="text-1"><?= $langId == 1 ? "Quantity" : "จำนวน" ?></span><span class="text-2"><?=count($Model)?></span><span class="text-1"><?= $langId == 1 ? "Course" : "หลักสูตร" ?></span>
                        </a>
                    </div>
                </div>

                <div class="show-course mt-2">
                    <div class="row">
                        <?php
                         foreach ($Model as $keyrec => $recommend) { 
                           $gen_id = $recommend->getGenID($recommend->course_id);
                           $percent_cou = Helpers::lib()->percent_CourseGen($recommend->course_id, $gen_id);

                           $id_course_picture = $recommend->course_id;
                           if (!$flag) {
                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $recommend->course_id, 'order' => 'course_id'));
                            if ($modelChildren) {
                                $recommend->course_title = $modelChildren->course_title;
                                $recommend->course_short_title = $modelChildren->course_short_title;
                                $recommend->course_detail = $modelChildren->course_detail;
                                $recommend->course_picture = $modelChildren->course_picture;
                                $id_course_picture = $modelChildren->course_id;
                            }
                        }

                        ?>
                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                  <?php 
                              if(date("Y-m-d H:i:s") >= $recommend->course_date_start){ ?>
                                 <a class="card-course" href="<?=Yii::app()->createUrl('course/detail/', array('id' => $recommend->course_id))?>">
                                <?php }else{ ?>
                                   <a href="javascript:void(0)" OnClick="alertCoursedate()">
                                   <?php } ?>
                                   

                                    <div class="thumbmail-course">
                                        <span class="btn btn-course-theory"><?=$textShow["theory"]?></span>
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $id_course_picture . '/thumb/' . $recommend->course_picture)) { ?>
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $id_course_picture ?>/thumb/<?= $recommend->course_picture ?>" alt="" class="w-100" alt="">
                                        <?php }else{ ?>
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail.png" alt="" class="w-100" alt="">
                                        <?php } ?>

                                    </div>
                                    <div class="d-course">
                                         <h5><?= $recommend->course_title ?>  <b class="float-id"><?= $recommend->course_number ?></b></h5>
                                        <div class="staus-course">
                                            <?php if($percent_cou >= 100){ ?>
                                                <span class="pg-success"><?= $langId == 1 ? "Completed" : "เรียนแล้ว" ?></span>
                                            <?php }?>

                                            <?php if($percent_cou > 0 && $percent_cou < 100){ ?>
                                                <span class="pg-waring"><?= $langId == 1 ? "Learning" : "กำลังเรียน" ?></span>
                                            <?php } ?>

                                            <?php if($percent_cou == 0){ ?>
                                                <span class="pg-primary"><?= $langId == 1 ? "Not Learning" : "ยังไม่ได้เรียน" ?></span>
                                            <?php } ?>
                                        </div>

                                        <div class="progress pg-line">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?=$percent_cou?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent_cou?>%;">
                                                <span class="sr-only"><?=$percent_cou?>% Complete</span>
                                            </div>
                                        </div>

                                        <div class="text-right percent-course">
                                         <?php if($percent_cou >= 100){?>
                                            <small><?= $langId == 1 ? "Progress" : "เรียนผ่านแล้ว" ?> 100%</small>
                                        <?php }else{ ?>
                                            <small><?= $langId == 1 ? "Progress" : "เรียนผ่านแล้ว" ?> <?=$percent_cou?>%</small>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            </div>

                         
                        <?php
                        }
                        ?>

                    </div>
                </div>

            </section>

        </div>
    </div>
</section>


<script type="text/javascript">
      function alertCoursedate() {
        Swal.fire({
            title: 'แจ้งเตือน!',
            text: "ยังไม่ถึงเวลาเรียนหลักสูตร",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
            }
        })
    }
</script>
