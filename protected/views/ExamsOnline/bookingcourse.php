 <?php 
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
?>

<section class="content-page" id="">
    <div class="container-main">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $langId == 1 ? "Online exam booking" : "จองสอบออนไลน์" ?></li>
            </ol>
        </nav>


        <div class="content">
            <div class="text-center title-page">
                <h3><?= $langId == 1 ? "Online exam booking" : "จองสอบออนไลน์" ?></h3>
            </div>
            <div class="row">
         <?php
             foreach ($msteams as $keyte => $teams) { 
               $gen_id = 0;
            ?>
            <div class="col-md-3">
                <div class="card-course" href="">
                    <div class="thumbmail-course">
                       <span class="btn btn-course"><?= $langId == 1 ? "Exam Online" : "สอบออนไลน์" ?></span>
                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/msonline/' . $teams->id . '/thumb/' . $teams->ms_teams_picture)) { ?>
                            <img  src="<?php echo Yii::app()->baseUrl; ?>/uploads/msonline/<?= $teams->id ?>/thumb/<?= $teams->ms_teams_picture ?>" alt=""  alt="">
                        <?php }else{ ?>
                            <img src="//via.placeholder.com/280x200" alt="" class="w-100" alt="">
                        <?php } ?>
                    </div>
                    <div class="d-course">
                        <h4><?=$teams->name_ms_teams?></h4>

                        <?php 
                        $TeamsTemp = OnlineTemp::model()->find(
                            array(
                                'condition' => 'ms_teams_id=:ms_teams_id AND user_id=:user_id AND gen_id=:gen_id  AND status=:status',
                                'params' => array(':ms_teams_id'=>$teams->id, ':user_id'=>Yii::app()->user->id, ':gen_id'=>$gen_id, ':status'=>'n')
                            )
                        );
                        ?>

                        <?php if($TeamsTemp != null){ ?>
                            <?php if($TeamsTemp->file_payment == null){ ?>
                            <div class="text-center">
                                    <a class="btn btn-booking-action" href="<?=Yii::app()->createUrl('examsonline/bookingexamsdetail/', array('id' => $teams->id,'tempoldid' => $TeamsTemp->id))?>">
                                    <?= $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน" ?>
                                </a>
                            </div>
                            <?php }else{ ?>
                            <div class="text-center">
                                <button class="btn btn-booking-action" disabled>
                                    <?= $langId == 1 ? "Pending Approval" : "รออนุมัติ" ?>
                                </button>
                            </div>
                            <?php } ?>
                        

                        <?php }else{ ?>
                            <div class="text-center">
                                <a class="btn-detail" href="<?=Yii::app()->createUrl('examsonline/bookingexamsdetail/', array('id' => $teams->id))?>">
                                    <?= $langId == 1 ? "Details" : "ดูรายละเอียด" ?>
                                </a>
                            </div>
                        <?php } ?>

                        <?php 
                        if($teams->price == 'y'){

                            if($teams->ms_price <= 0){
                                $price = $langId == 1 ? "Free" : "ฟรี";
                            }else{
                            $price = $teams->ms_price." ".($langId == 1 ? "Baht" : "บาท");
                            }

                        }else{
                            $price = $langId == 1 ? "Free" : "ฟรี";
                        }
                         ?>
                        <h6 class="course-payments"><?= $langId == 1 ? "Price" : "ราคา" ?>: <span class="price"><?=$price?></span></h6>
                    </div>

                </div>
            </div>
        <?php } ?>


            </div>

        </div>

    </div>
</section>