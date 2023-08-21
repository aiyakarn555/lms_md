<?php 
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
if (Yii::app()->session['lang'] == 2) {
    $courseconfirm = "ยืนยันการจองหลักสูตร";
    $confirm = "ยืนยัน";
    $cancel = "ยกเลิก";
   
} else {
    $courseconfirm = "Course Confirmation";
    $confirm = "Confirm";
    $cancel = "Cancel";
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
                <li class="breadcrumb-item active" aria-current="page"><?= $langId == 1 ? "Details" : "ดูรายละเอียด" ?></li>
            </ol>
        </nav>

        <div class="content">
            <div class="row p-2 back-page ">
                <a class="btn-back-page" href="<?php echo $this->createUrl('/course/bookingcourse'); ?>">
                    <i class="fas fa-chevron-left"></i> <?= $langId == 1 ? "Back" : "ย้อนกลับ" ?>
                </a>
            </div>
            <div class="course-preview">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="thumbmail-course-booking">

                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/msteams/' . $teams->id . '/thumb/' . $teams->ms_teams_picture)) { ?>
                                <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/msteams/<?= $teams->id ?>/thumb/<?= $teams->ms_teams_picture ?>" alt="" class="w-100" alt="">
                        <?php }else{ ?>
                            <img src="//via.placeholder.com/280x200" alt="" class="w-100" alt="">
                        <?php } ?>

                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="d-course-booking">
                            <h3><?= $teams->name_ms_teams?></h3>
                            <p><?= $langId == 1 ? "Class type" : "ประเภทการเรียน" ?> : <span class="text-main"><?= $langId == 1 ? "Online" : "ออนไลน์" ?></span></p>
                            <p><?= $langId == 1 ? "Quick details" : "รายละเอียดย่อ" ?>  <?php echo htmlspecialchars_decode($teams->detail_ms_teams); ?></p>

                            <?php 
                            $cou_pri = false;
                            $type_pri = 0;

                            if($teams->price == 'y'){

                                if($teams->ms_price <= 0){
                                    $price = $langId == 1 ? "Free" : "ฟรี";
                                }else{
                                    $cou_pri = true;
                                    $type_pri = 1;
                                    $price = $teams->ms_price." ".($langId == 1 ? "Baht" : "บาท");
                                }

                            }else{
                                $price = $langId == 1 ? "Free" : "ฟรี";
                            }
                            ?>
                            <h3 class="price-course"><?= $langId == 1 ? "Price" : "ราคา" ?> <span><?= $price ?></span></h3>

                        </div>


                        <div class="bar-booking">

                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/msteams/' . $teams->intro_video) && $teams->intro_video != null) { ?>
                                <a data-toggle="modal" data-target="#course-video" class="btn btn-booking-video"><i class="far fa-file-video"></i> </i> <?= $langId == 1 ? "Preview" : "ตัวอย่างหลักสูตร" ?></a>

                            <?php }else{ ?>
                                <a class="btn btn-booking-video"><i class="far fa-file-video"></i>  <?= $langId == 1 ? "No Preview" : "ไม่มีตัวอย่างหลักสูตร" ?></a>
                            <?php } ?>

                            <?php if ($cou_pri) { ?>
                                <?php 
                                if($_GET['tempoldid'] != null){
                                $tex = $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน";
                                }else{
                                $tex = $langId == 1 ? "Bookingcourse" : "จองหลักสูตร";
                                }
                                $link = Yii::app()->createUrl('course/confirmteams/', array('id' => $teams->id));

                                 ?>
                                
                                <a href="<?=$link?>" class="btn btn-booking"><?= $tex ?></a>

                            <?php }else{ ?>
                                <a onclick="mybooking()" class="btn btn-booking"><?= $langId == 1 ? "Confirmation of booking" : "ยืนยันการจอง" ?></a>
                            <?php } ?>



                        </div>
                    </div>
                </div>
            </div>

        </div>
</section>
<!--  -->
<form action="<?php echo $this->createUrl('course/bookingmsteamssave') ?>" id="frmsave" name="frmsave" method="post" 
    class="needs-validation" enctype="multipart/form-data" >
    <input type="hidden" name="course_id" value="<?= $teams->id ?>">
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
                    <source src="<?php echo Yii::app()->baseUrl; ?>/uploads/msteams/<?= $teams->intro_video ?>">
                </video>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $langId == 1 ? "Close" : "ปิด" ?></button>
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

                <form action="<?php echo $this->createUrl('course/bookingmsteamssave') ?>" id="frmsavepay" name="frmsavepay" method="post" class="needs-validation" enctype="multipart/form-data" >
                    <div class="pay-course">
                        <h4>ธนาคารที่โอนเข้า</h4>
                        <?php
                        $modelbank = BankNameRelations::model()->findAll(array(
                            'condition' => 'ms_teams_id = "' . $teams->id . '"'
                        ));

                        if(isset($_GET['tempoldid'])){
                             $msOld = MsteamsTemp::model()->findByPk($_GET['tempoldid']);
                        }

                       foreach ($modelbank as $key => $valueb) {

                            ?>
                            <div class="row row-pay align-items-center">

                                <input <?= isset($_GET['tempoldid']) && $msOld->bank_id == $valueb->banks->id ?'checked' : "" ?>  <?= isset($_GET['tempoldid']) && $valueb->banks->id != null ? 'disabled' : "" ?> type="radio" id="test-<?= $valueb->banks->id ?>" name="chkbank" class="custom-control-input custom" value="<?= $valueb->banks->id ?>">
                                <img class="mx-2" src="<?php echo Yii::app()->baseUrl; ?>/uploads/bank/<?= $valueb->banks->id ?>/<?= $valueb->banks->bank_images ?>" width="80" alt="">

                                <div class="account-bank" >
                                <h4 class="">ธนาคาร : <span class="text-main"><?= $valueb->banks->bank_name ?></span></h4>
                                <h4 class="">ชื่อบัญชี : <span class="text-main"><?= $valueb->banks->account_name ?></span></h4>
                                <h4 class="">หมายเลขบัญชี : <span class="text-main"><?= $valueb->banks->account_number ?></span></h4>
                                
                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <input type="hidden" name="course_id" value="<?= $teams->id ?>">
                    <input type="hidden" name="type_price" value="<?= $type_pri ?>">
                    <input type="hidden" name="tempoldid" value="<?= $_GET['tempoldid']; ?>">

                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">จำนวนเงินที่โอน</label>
                                    <div class="input-group">
                                        <input <?= isset($_GET['tempoldid']) && $msOld->money != null ? 'disabled' : "" ?> type="text" value="<?= isset($_GET['tempoldid']) && $msOld->money != null ? $msOld->money : "" ?>" class="form-control" name="money" placeholder="">
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
                                    <?php if(isset($_GET['tempoldid']) && $msOld->date_slip != null){ ?>
                                <input type="text" value="<?=$msOld->date_slip?>" disabled class="form-control" name="date_slip" >
                                    <?php }else{ ?>
                                <input type="datetime-local" value="" class="form-control" name="date_slip" placeholder="">
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pay-course">
                        <h4>อัปโหลดหลักฐานการชำระเงิน</h4>
                        <input type="file" name="file_payment" id="file_payment" class="form-control" style="height:40px;">
                    </div>

                </form>

                <button type="button" onclick="mybooking('pay')" id="b3" class="btn btn-booking">ยืนยันการจอง</button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">

    function mybooking($type = null) {
        var cou_ti = "<?=$teams->name_ms_teams?>";
        Swal.fire({
            title: '<?=$courseconfirm?>',
            text: cou_ti,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?=$confirm?>',
            cancelButtonText: '<?=$cancel?>',
        }).then((result) => {
            if (result.value) {
                if($type != null){
                    
                    // if (document.getElementById("file_payment").files.length == 0) {
                    //     swal("กรุณาอัปโหลดหลักฐานการชำระเงิน","","error");
                    //     return false;
                    // }else{
                        document.getElementById("frmsavepay").submit();
                    // }
                
                }else{
                document.getElementById("frmsave").submit();
                }
            }
        })
    }
</script>