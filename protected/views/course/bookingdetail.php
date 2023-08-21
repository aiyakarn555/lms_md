<?php
/*
Yii::app()->session['lang']
1 = EN
2 = TH
*/
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
?>
<?php
$id_course_picture = $course->course_id;
if (!$flag) {
    $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $course->course_id, 'order' => 'course_id'));
    if ($modelChildren) {
        $course->course_title = $modelChildren->course_title;
        $course->course_short_title = $modelChildren->course_short_title;
        $course->course_detail = $modelChildren->course_detail;
        $course->course_picture = $modelChildren->course_picture;
        $id_course_picture = $modelChildren->course_id;
    }
}

?>

<style type="text/css">
    .sweet-alert {
        z-index: 999999999999999999;

    }

    .swal2-container {

        z-index: 999999999999999999;

    }
</style>
<section class="content-page" id="">
    <div class="container-main">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"> <?= $langId == 1 ? "Course Detail" : "รายละเอียดหลักสูตร" ?></li>
            </ol>
        </nav>

        <div class="content">
            <div class="row p-2 back-page ">
                <button class="btn-back-page" onclick="history.back()">
                    <i class="fas fa-chevron-left"></i>  <?= $langId == 1 ? "Back" : "ย้อนกลับ" ?>
                </button>
            </div>
            <div class="course-preview">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="thumbmail-course">

                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $id_course_picture . '/thumb/' . $course->course_picture)) { ?>
                                <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $id_course_picture ?>/thumb/<?= $course->course_picture ?>" alt="" class="w-100" alt="">
                            <?php } else { ?>
                                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $course->course_id. '/thumb/' . $course->course_picture)) {?>
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $course->course_id ?>/thumb/<?= $course->course_picture ?>" alt="" class="w-100" alt="">
                                <?php }else {?>
                                    <img src="//via.placeholder.com/280x200" alt="" class="w-100" alt="">
                                <?php }?>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="d-course-booking">
                            <h3><?= $course->course_title ?></h3>
                            <p><?= $langId == 1 ? "Class type" : "ประเภทการเรียน" ?>: <span class="text-main"><?= $langId == 1 ? "Theory" : "ศึกษาด้วยตนเอง (e-Learning)" ?></span></p>
                            <p><?= $langId == 1 ? "Quick details" : "รายละเอียดย่อ" ?> <?php echo htmlspecialchars_decode($course->course_detail); ?></p>

                            <?php
                            $cou_pri = false;
                            $type_pri = 0;

                            if ($course->price == 'y') {
                                $baht = $langId == 1 ? ' Baht': ' บาท';
                                if ($course->course_price <= 0) {
                                    $price = 'ฟรี';
                                } else {
                                    $cou_pri = true;
                                    $type_pri = 1;
                                    $price = $course->course_price . $baht;
                                }
                            } else {
                                $price = 'ฟรี';
                            }
                            ?>
                            <h3 class="price-course"><?= $langId == 1 ? "Price" : "ราคา" ?> <span><?= $price ?></span></h3>

                        </div>

                        <div class="bar-booking">

                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $course->intro_video) && $course->intro_video != null) { ?>
                                <a data-toggle="modal" data-target="#course-video" class="btn btn-booking-video"><i class="far fa-file-video"> </i> <?= $langId == 1 ? "Preview" : "ตัวอย่างหลักสูตร" ?></a>

                            <?php } else { ?>
                                <a class="btn btn-booking-video"><i class="far fa-file-video"></i> <?= $langId == 1 ? "No Preview" : "ไม่มีตัวอย่างหลักสูตร" ?></a>
                            <?php } ?>

                            <?php if ($cou_pri) { ?>
                                <?php 
                                if($_GET['tempoldid'] != null){
                                $tex = $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน";
                                }else{
                                $tex = $langId == 1 ? "Bookingcourse" : "จองหลักสูตร";
                                }
                                $link = Yii::app()->createUrl('course/confirm/', array('id' => $course->course_id));

                                 ?>
                                
                                <a href="<?=$link?>" class="btn btn-booking"><?= $tex ?></a>
                                <!-- <a data-toggle="modal" data-target="#course-booking" class="btn btn-booking"><?= $langId == 1 ? "Booking Course" : "จองหลักสูตร" ?> </a> -->
                            <?php } else { ?>
                                <a onclick="mybooking()" class="btn btn-booking"> <?= $langId == 1 ? "Confirmation of booking" : "ยืนยันการจอง" ?> </a>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
</section>
<!--  -->
<form action="<?php echo $this->createUrl('course/bookingsave') ?>" id="frmsave" name="frmsave" method="post" class="needs-validation" enctype="multipart/form-data">
    <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
    <input type="hidden" name="type_price" value="<?= $type_pri ?>">
</form>

<div class="modal fade " id="course-video" tabindex="-1" role="dialog" aria-labelledby="course-video">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">ตัวอย่างหลักสูตร</h4>
            </div>
            <div class="modal-body">
                <video width="100%" muted controls preload="auto">
                    <source src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $course->intro_video ?>">
                </video>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="course-booking" tabindex="-1" role="dialog" aria-labelledby="course-booking">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">จ่ายเงินเพื่อจองหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">

                <form action="<?php echo $this->createUrl('course/bookingsave') ?>" id="frmsavepay" name="frmsavepay" method="post" class="needs-validation" enctype="multipart/form-data">

                    <div class="pay-course">
                        <h4>ธนาคารที่โอนเข้า</h4>
                        <?php
                        $modelbank = BankNameRelations::model()->findAll(array(
                            'condition' => 'course_id = "' . $course->course_id . '"'
                        ));
                        ?>

                        <?php foreach ($modelbank as $key => $valueb) {
                            ?>
                            <div class="row row-pay align-items-center">

                                <input type="radio" id="test-<?= $valueb->banks->id ?>" name="chkbank" class="custom-control-input custom" value="<?= $valueb->banks->id ?>">
                                <img class="mx-2" src="<?php echo Yii::app()->baseUrl; ?>/uploads/bank/<?= $valueb->banks->id ?>/<?= $valueb->banks->bank_images ?>" width="80" alt="">

                                <div class="account-bank" >
                                <h4 class="">ธนาคาร : <span class="text-main"><?= $valueb->banks->bank_name ?></span></h4>
                                <h4 class="">ชื่อบัญชี : <span class="text-main"><?= $valueb->banks->account_name ?></span></h4>
                                <h4 class="">หมายเลขบัญชี : <span class="text-main"><?= $valueb->banks->account_number ?></span></h4>
                                
                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
                    <input type="hidden" name="type_price" value="<?= $type_pri ?>">

                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">จำนวนเงินที่โอน</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="money" placeholder="">
                                        <div class="input-group-addon">บาท</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-4 col-xs-12">
                                <div class="form-group">
                                    <label for="">วันเวลาที่โอน</label>
                                    <input type="datetime-local" class="form-control" name="date_slip" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <h4>อัปโหลดหลักฐานการชำระเงิน</h4>
                        <input type="file" name="file_payment" accept="image/*" id="file_payment" class="form-control" style="height:40px;">
                    </div>

                </form>

                <button type="button" onclick="mybooking('pay')" id="b3" class="btn btn-booking">ยืนยันการจอง</button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    function mybooking($type = null) {
        var cou_ti = "<?= $course->course_title ?>";
        Swal.fire({
            title: 'ยืนยันการจองหลักสูตร',
            text: cou_ti,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.value) {
                if ($type != null) {
                    console.log(document.getElementById("file_payment").files.length == 0);
                    if (document.getElementById("file_payment").files.length == 0) {
                        swal("กรุณาอัปโหลดหลักฐานการชำระเงิน", "", "error");
                        return false;
                    } else {
                        document.getElementById("frmsavepay").submit();
                    }

                } else {
                    document.getElementById("frmsave").submit();
                }
            }
        })
    }
</script>