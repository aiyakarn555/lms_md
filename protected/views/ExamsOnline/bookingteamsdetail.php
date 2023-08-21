<?php 
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
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
                <a class="btn-back-page" href="<?php echo $this->createUrl('/examsonline/bookingcourse'); ?>">
                    <i class="fas fa-chevron-left"></i> <?= $langId == 1 ? "Retrospective" : "ย้อนกลับ" ?>
                </a>
            </div>
            <div class="course-preview">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="thumbmail-course">

                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/msonline/' . $teams->id . '/thumb/' . $teams->ms_teams_picture)) { ?>
                                <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/msonline/<?= $teams->id ?>/thumb/<?= $teams->ms_teams_picture ?>" alt="" class="w-100" alt="">
                        <?php }else{ ?>
                            <img src="//via.placeholder.com/280x200" alt="" class="w-100" alt="">
                        <?php } ?>

                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="d-course-booking">
                            <h3><?= $teams->name_ms_teams?></h3>
                            <p><?= $langId == 1 ? "Class type" : "ประเภทการเรียน" ?> : <span class="text-main"><?= $langId == 1 ? "Exam Online" : "สอบออนไลน์" ?></span></p>
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

                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/msonline/' . $teams->intro_video) && $teams->intro_video != null) { ?>
                                <a data-toggle="modal" data-target="#course-video" class="btn btn-booking-video"><i class="far fa-file-video"></i> ตัวอย่างหลักสูตร</a>

                            <?php }else{ ?>
                                <a class="btn btn-booking-video"><i class="far fa-file-video"></i> ไม่มีตัวอย่างหลักสูตร</a>
                            <?php } ?>

                            <?php if ($cou_pri) { ?>
                                <?php 
                                if($_GET['tempoldid'] != null){
                                $tex = $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน";
                                }else{
                                $tex = $langId == 1 ? "Bookingcourse" : "จองหลักสูตร";
                                }


                                 ?>
                                <a data-toggle="modal" data-target="#course-booking" class="btn btn-booking"><?= $tex ?></a>

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
<form action="<?php echo $this->createUrl('examsonline/bookingmsteamssave') ?>" id="frmsave" name="frmsave" method="post" 
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
                    <source src="<?php echo Yii::app()->baseUrl; ?>/uploads/msonline/<?= $teams->intro_video ?>">
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
                <div class="pay-course">
                    <h4>ช่องทางในการชำระเงิน</h4>
                    <div class="row row-pay align-items-center">
                        <img class="mx-2" src="https://s.isanook.com/mn/0/ud/150/754843/scb.jpg" width="80" alt="">
                        <h4 class="">เลขที่บัญชี : <span class="text-main">14564564210</span></h4>
                    </div>
                    <div class="row row-pay align-items-center">
                        <img class="mx-2" src="https://th1-cdn.pgimgs.com/agent/1401905/APHO.73466451.V300.jpg" width="80" alt="">
                        <h4 class="">เลขที่บัญชี : <span class="text-main">14564564210</span></h4>
                    </div>
                    <div class="row row-pay align-items-center">
                        <img class="mx-2" src="https://www.ceochannels.com/wp-content/uploads/2017/10/PromptPay.jpg" width="80" alt="">
                        <h4 class="">เลขที่บัญชี : <span class="text-main">06xxxxxxxx</span></h4>
                    </div>
                </div>

                <form action="<?php echo $this->createUrl('examsonline/bookingmsteamssave') ?>" id="frmsavepay" name="frmsavepay" method="post" 
                    class="needs-validation" enctype="multipart/form-data" >
                    <input type="hidden" name="course_id" value="<?= $teams->id ?>">
                    <input type="hidden" name="type_price" value="<?= $type_pri ?>">
                    <input type="hidden" name="tempoldid" value="<?= $_GET['tempoldid']; ?>">

                    
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