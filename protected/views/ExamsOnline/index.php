
<?php 
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}

 ?>
<section class="content-page">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <!-- <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li> -->
                <li class="breadcrumb-item active"><a style="color: #757272" href="<?php echo $this->createUrl('/examsonline/index'); ?>"><?= $langId == 1 ? "Exam Online" : "สอบออนไลน์" ?> </a> </li>
            </ol>
        </nav>
        <div class="content-main">

             <section class="search-filter">
                <form class="form row" enctype="multipart/form-data" id="vdo-form" action="/lms_md/index.php/examsonline/index" method="post"> 

                    <div class="col-lg-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
                        <div class="wrapsearch">
                            <div class="form-group mx-sm-3">
                                <input type="text" value="<?=$textold?>" name="course_title" class="form-control" id="inputPassword2" placeholder="<?= $langId == 1 ? "Search for the course name." : "พิมพ์คำค้นหาชื่อหลักสูตร" ?>">
                            </div>
                            <div class="wrap-btn-search">
                                <button type="submit" class="btn btn-primary btn-search"><i class="fas fa-search"></i><?= $langId == 1 ? "Search" : "ค้นหา" ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group wrap-form-lable">
                            <select id="inputState" name="sort" class="form-control">
                                <option value="1"><?= $langId == 1 ? "Newest" : "ใหม่ล่าสุด" ?></option>
                                <option value="2"><?= $langId == 1 ? "Oldest" : "เก่าสุด" ?></option>
                            </select>
                            <label for="floatingSelect"><?= $langId == 1 ? "Sort" : "จัดเรียง" ?></label>
                        </div>
                    </div>
                </form>
            </section>

            <section class="all-course">
                <div class="wrap-title-content">
                    <h3 class=""><?= $langId == 1 ? "All online classrooms" : "ห้องเรียนออนไลน์ทั้งหมด" ?></h3>
                    <a href="" class="btn-link-course">
                        <span class="text-1"><?= $langId == 1 ? "Quantity" : "จำนวน" ?></span><span class="text-2"><?=count($MsTeams)?></span><span class="text-1"><?= $langId == 1 ? "Course" : "หลักสูตร" ?></span>
                    </a>
                </div>

                <div class="show-course mt-2">
                    <div class="row">
                        <?php
                         foreach ($MsTeams as $keyrec => $recommend) { 
                           $gen_id = 0;
                        ?>
                            <div class="col-lg-3 col-md-6">
                                
                                <?php 
                                if(date("Y-m-d H:i:s") >= $recommend->start_date){ ?>
 <a class="card-course" href="<?=Yii::app()->createUrl('examsonline/detail/', array('id' => $recommend->id))?>">
                                <?php }else{ ?>
 <a href="javascript:void(0)" OnClick="alertCoursedate()">
                               <?php } ?>
                               

                                    
                                    <div class="thumbmail-course">
                                        <span class="btn btn-course">ออนไลน์</span>
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/msonline/' . $recommend->id . '/thumb/' . $recommend->ms_teams_picture)) { ?>
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/msonline/<?= $recommend->id ?>/thumb/<?= $recommend->ms_teams_picture ?>" alt="" class="w-100" alt="">
                                        <?php }else{ ?>
                                            <img src="//via.placeholder.com/280x200" alt="" class="w-100" alt="">
                                        <?php } ?>

                                    </div>
                                    <div class="d-course">
                                        <h5><?=$recommend->name_ms_teams ?></h5>
                                        <div class="staus-course" style="font-size: 12px;">

                                        <p><?= Helpers::lib()->changeFormatDate($value->start_date) ." ". $value->time_start_date ?> </p>
                                        <p><?= Helpers::lib()->changeFormatDate($value->end_date) ." ". $value->time_end_date ?></p>

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
            text: "ยังไม่ถึงเวลาสอบ",
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