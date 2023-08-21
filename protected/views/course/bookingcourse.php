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

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.css">
<section class="content-page" id="">
    <div class="container-main">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $langId == 1 ? "Bookingcourse" : "จองหลักสูตร" ?></li>
            </ol>
        </nav>


        <div class="content">
            <div class="text-center title-page">
                <h3><?= $langId == 1 ? "Bookingcourse" : "จองหลักสูตร" ?></h3>
            </div>

            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-12 ">
                    <div class="panel panel-default">
                        <div class="panel-header p-2">
                            <div class="row">
                                <div class="col-sm-6" style="align-items: center; ">
                                    <h4 ><i class="fas fa-list"></i> รายการหลักสูตรที่จอง</h4> 
                                </div>  
                                <div class="col-sm-6">
                                    <span class="pull-right">
                                        <select class="form-control"  aria-label="" id="tableType">
                                            <option value="" selected disabled>เลือกประเภทหลักสูตร</option>
                                            <option value="0" selected>ทั้งหมด</option>
                                            <option value="2">ศึกษาด้วยตนเอง (e-Learning)</option>
                                            <option value="1">เรียนรู้ทางไกล (Online)</option>
                                            <option value="3">ห้องสอบออนไลน์ (Exam Room)</option>
                                        </select>
                                    </span>
                                </div>  
                            </div>
                        </div>
                        <div class="table-booking-list">
                            <table class="table table-condensed table-booking " id="myTable" >
                                <thead>
                                    <tr class="head-tb">
                                        <td width="100" rowspan="2">Code</td>
                                        <td width="100" rowspan="2"></td>
                                        <td style="white-space:nowrap;" rowspan="2">ชื่อหลักสูตร</td>
                                        <td width="400" colspan="2">สถานะ</td>
                                        <td width="200" rowspan="2">วันที่เริ่ม</td>
                                        <td width="200" rowspan="2">วันสิ้นสุด</td>
                                    </tr>
                                    <tr class="head-tb">
                                        <td width="200">การชำระเงิน</td>
                                        <td width="200">เอกสาร</td>
                                    </tr>
                                </thead>
                                <tbody class="tableAll" style="display:none">
                                <!--ทฤษฎี-->
                                <?php
                                        $criteria = new CDbCriteria;
                                        // $criteria->compare('status','y');
                                        $criteria->compare('user_id',Yii::app()->user->id);
                                        $criteria->order = 'id';
                                        $courseTempTable = CourseTemp::model()->findAll($criteria);
                                        $check = false;
                                        foreach($courseTempTable as $c){
                                            // เหลือ check เวลาจาก gen
                                            $check = true;
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('course.active','y');
                                            $criteria->compare('course_id',$c->course_id);
                                            $criteria->addCondition('course_date_end >= :date_now');
                                            $criteria->params[':date_now'] = date('Y-m-d H:i');
                                            $courseOnline = CourseOnline::model()->find($criteria);
                                            if(isset($courseOnline)){ ?>
                                                <tr>
                                                    <td><?= $courseOnline->course_number != null ? $courseOnline->course_number : "-" ?></td>
                                                    <td>
                                                    <?php 
                                                        // if($c->status_payment != "x"){
                                                            $join = "<a href=\"".Yii::app()->createUrl('course/detail/', array('id' => $courseOnline->course_id,'gen'=>$c->gen_id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                        // }else{
                                                        //     $join = "-";
                                                        // }
                                                        echo $join ;
                                                    ?>
                                                    </td>
                                                    <?php 
                                                        $courseGeneration = CourseGeneration::model()->findByPk($c->gen_id);

                                                        $criteria = new CDbCriteria;
                                                        $criteria->compare('active','y');
                                                        $criteria->compare('parent_id',$courseOnline->course_id);
                                                        $courseOnlineTh = CourseOnline::model()->find($criteria);
                                                    ?>
                                                    <td class="text-left"><?= $langId == 1 ? $courseOnline->course_title : isset($courseOnlineTh) ? $courseOnlineTh->course_title : $courseOnline->course_title  ?> (รุ่น : <?= isset($courseGeneration)? $courseGeneration->gen_title : "ไม่มีรุ่น" ?>)</td>
                                                    <td>
                                                    <?php 
                                                        if($courseOnline->price == "n"){
                                                            $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                        }else{
                                                            if($c->status_payment == "n" && $c->file_payment == null){
                                                                $status = "<span class=\"text-warning\"><i class=\"fas fa-money-bill\"></i> รอชำระเงิน</span"; 
                                                            }else if($c->status_payment == "w"){
                                                                $status = "<span class=\"text-primary\"><i class=\"fas fa-spinner\"></i> กำลังดำเนินการ</span></td>" ;
                                                            }else if($c->status_payment == "y"){
                                                                $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                            }else if($c->status_payment == "x"){
                                                                $status = "<span class=\"text-danger\"><i class=\"fas fa-times\"></i> ไม่ผ่านอนุมัติ</span>"; 
                                                            }
                                                        }
                                                        
                                                        echo $status;
                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?php 

                                                            $type_pri = 0;
                                                            if ($courseOnline->price == 'y') {
                                                                if ($courseOnline->course_price <= 0) {
                                                                    $type_pri = 0;
                                                                } else {
                                                                    $type_pri = 1;
                                                                }
                                                            } else {
                                                                $type_pri = 0;
                                                            }

                                                            if($courseOnline->price == "n"){
                                                                $slip = "-" ;
                                                            }else{
                                                                if($c->status_payment == "n" && $c->file_payment == null){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$courseOnline->course_id.','."'" . $courseOnline->course_title . "'".','.$type_pri.','.'\'course\''.','.$c->gen_id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }else if($c->status_payment == "w"){
                                                                    $slip = "-" ;
                                                                }else if($c->status_payment == "y"){
                                                                    $slip = "-" ;
                                                                }else if($c->status_payment == "x"){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$courseOnline->course_id.','."'" . $courseOnline->course_title . "'".','.$type_pri.','.'\'course\''.','.$c->gen_id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }

                                                            }
                                                            
                                                            echo $slip;
                                                            ?>
                                            
                                                    </td>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $courseOnline->course_date_start) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $courseOnline->course_date_start) ?>
                                                        </span>
                                                    </td>
                                                    <td>    
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $courseOnline->course_date_end) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $courseOnline->course_date_end) ?>
                                                    </td>
                                                
                                                </tr>
                                    
                                    <?php                 
                                            }
                                        }
                                    ?>

                                    <!--ออนไลน์-->
                                    <?php
                                        $criteria = new CDbCriteria;
                                        $criteria->compare('status','y');
                                        $criteria->compare('user_id',Yii::app()->user->id);
                                        $criteria->order = 'id';
                                        $msTeamsTempTable = MsteamsTemp::model()->findAll($criteria);
                                        $check = false;
                                        foreach($msTeamsTempTable as $m){ 
                                            $check = true;
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('active', 'y');
                                            $criteria->compare('type_ms_teams', 1); //ออนไลน์  2= ออนไลน์ สถาบัน
                                            $criteria->compare('id',$m->ms_teams_id);
                                            $criteria->addCondition('end_date >= :date_now');
                                            $criteria->params[':date_now'] = date('Y-m-d H:i');
                                            // $criteria->order = 'create_date DESC';
                                            $msTeams = MsTeams::model()->find($criteria);
                                            if(isset($msTeams)){  ?>
                                                <tr>
                                                    <td><?= $msTeams->course_md_gm != null ? $msTeams->course_md_gm : "-" ?></td>
                                                    <td>
                                                        <?php 
                                                            // if($msTeams->price == "n"){
                                                            //     $join = "<a href=\"".Yii::app()->createUrl('virtualclassroom/detail/', array('id' => $msTeams->id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                            // }else{
                                                            //     if($m->status_payment == "y"){
                                                                    $join = "<a href=\"".Yii::app()->createUrl('virtualclassroom/detail/', array('id' => $msTeams->id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                            //     }else{
                                                            //         $join = "-";
                                                            //     }
                                                            // }
                                                            echo $join ;
                                                        ?>
                                                    </td>
                                                    <?php 
                                                        $courseGeneration = CourseGeneration::model()->findByPk($m->gen_id);
                                                    ?>
                                                    <td class="text-left"><?= $msTeams->name_ms_teams ?> (รุ่น : <?= isset($courseGeneration)? $courseGeneration->gen_detail : "ไม่มีรุ่น" ?>)</td>
                                                    <td>
                                                        <?php 
                                                        if($msTeams->price == "n"){
                                                            $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                        }else{
                                                            if($m->status_payment == "n" && $m->file_payment == null){
                                                                $status = "<span class=\"text-warning\"><i class=\"fas fa-money-bill\"></i> รอชำระเงิน</span"; 
                                                            }else if($m->status_payment == "w"){
                                                                $status = "<span class=\"text-primary\"><i class=\"fas fa-spinner\"></i> กำลังดำเนินการ</span></td>" ;
                                                            }else if($m->status_payment == "y"){
                                                                $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                            }else if($m->status_payment == "x"){
                                                                $status = "<span class=\"text-danger\"><i class=\"fas fa-times\"></i> ไม่ผ่านอนุมัติ</span>"; 
                                                            }
                                                        }
                                                    
                                                        echo $status;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $type_pri = 0;
                                                            if ($msTeams->price == 'y') {
                                                                if ($msTeams->ms_price <= 0) {
                                                                    $type_pri = 0;
                                                                } else {
                                                                    $type_pri = 1;
                                                                }
                                                            } else {
                                                                $type_pri = 0;
                                                            }

                                                            if($msTeams->price == "n"){
                                                                $slip = "-" ;
                                                            }else{
                                                                if($m->status_payment == "n" && $m->file_payment == null){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking-online\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$msTeams->id.','."'" . $msTeams->name_ms_teams . "'".','.$type_pri.','.'\'msteams\''.','.$m->gen_id.','.$m->id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }else if($m->status_payment == "w"){
                                                                    $slip = "-" ;
                                                                }else if($m->status_payment == "y"){
                                                                    $slip = "-" ;
                                                                }else if($m->status_payment == "x"){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking-online\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$msTeams->id.','."'" . $msTeams->name_ms_teams . "'".','.$type_pri.','.'\'msteams\''.','.$m->gen_id.','.$m->id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }
                                                            }
                                                            
                                                            echo $slip;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $msTeams->start_date) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $msTeams->start_date) ?>
                                                        </span>
                                                    </td>
                                                    <td>    
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $msTeams->end_date) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $msTeams->end_date) ?>
                                                    </td>
                                                </tr>


                                <?php
                                            }
                                        }
                                ?>


                                <!--ห้องสอบออนไลน์-->
                                    <?php
                                        $criteria = new CDbCriteria;
                                        // $criteria->compare('status','y');
                                        $criteria->compare('user_id',Yii::app()->user->id);
                                        $criteria->order = 'id';
                                        $onlineTempTable = OnlineTemp::model()->findAll($criteria);
                                        $check = false;
                                        foreach($onlineTempTable as $o){
                                            $check = true;
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('active','y');
                                            $criteria->compare('id',$o->ms_teams_id);
                                            $criteria->addCondition('end_date >= :date_now');
                                            $criteria->params[':date_now'] = date('Y-m-d H:i');
                                            $msOnline = MsOnline::model()->find($criteria);
                                            if(isset($msOnline)){ ?>
                                                <tr>
                                                    <td>-</td>
                                                    <td>
                                                    <?php 
                                                        // if($msOnline->price == "n"){
                                                        //     $join = "<a href=\"".Yii::app()->createUrl('ExamsOnline/detail/', array('id' => $msOnline->id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                        // }else{
                                                        //     if($o->file_payment != null && $o->status == 'y'){
                                                                $join = "<a href=\"".Yii::app()->createUrl('ExamsOnline/detail/', array('id' => $msOnline->id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                        //     }else{
                                                        //         $join = "-";
                                                        //     }
                                                        // }
                                                        echo $join ;
                                                    ?>
                                                    </td>
                                                    <?php 
                                                        $courseGeneration = CourseGeneration::model()->findByPk($o->gen_id);

                                                        // $criteria = new CDbCriteria;
                                                        // $criteria->compare('active','y');
                                                        // $criteria->compare('parent_id',$msOnline->course_id);
                                                        // $courseOnlineTh = CourseOnline::model()->find($criteria);
                                                    ?>
                                                    <td class="text-left"><?= $langId == 1 ? $msOnline->name_ms_teams : $msOnline->name_ms_teams ?> (รุ่น : <?= isset($courseGeneration)? $courseGeneration->gen_title : "ไม่มีรุ่น" ?>)</td>
                                                    <td>
                                                    <?php 
                                                        if($msOnline->price == "n"){
                                                            $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                        }else{
                                                            if($o->status == "y" && $o->file_payment == null){
                                                                $status = "<span class=\"text-warning\"><i class=\"fas fa-money-bill\"></i> รอชำระเงิน</span"; 
                                                            }else if($o->status == "y" && $o->file_payment != null && $o->date_confirm == null){
                                                                $status = "<span class=\"text-primary\"><i class=\"fas fa-spinner\"></i> กำลังดำเนินการ</span></td>" ;
                                                            }else if($o->status == "y" && $o->file_payment != null && $o->date_confirm != null){
                                                                $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                            }else if($o->status == "x"){
                                                                $status = "<span class=\"text-danger\"><i class=\"fas fa-times\"></i> ไม่ผ่านอนุมัติ</span>"; 
                                                            }
                                                        }
                                                        
                                                        echo $status;
                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?php 

                                                            $type_pri = 0;
                                                            if ($msOnline->price == 'y') {
                                                                if ($msOnline->ms_price <= 0) {
                                                                    $type_pri = 0;
                                                                } else {
                                                                    $type_pri = 1;
                                                                }
                                                            } else {
                                                                $type_pri = 0;
                                                            }

                                                            if($msOnline->price == "n"){
                                                                $slip = "-" ;
                                                            }else{

                                                                if($o->status == "y" && $o->file_payment == null){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking-exam-room\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$msOnline->id.','."'" . $msOnline->name_ms_teams . "'".','.$type_pri.','.'\'examroom\''.','.$o->gen_id.','.$o->id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }else if($o->status == "y" && $o->file_payment != null && $o->date_confirm == null){
                                                                    $slip = "-" ;
                                                                }else if($o->status == "y" && $o->file_payment != null && $o->date_confirm != null){
                                                                    $slip = "-" ;
                                                                }else if($o->status == "x"){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking-exam-room\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$msOnline->id.','."'" . $msOnline->name_ms_teams . "'".','.$type_pri.','.'\'examroom\''.','.$o->gen_id.','.$o->id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>";
                                                                }
                                                            }
                                                            echo $slip;
                                                            ?>
                                            
                                                    </td>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $msOnline->start_date) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $msOnline->start_date) ?>
                                                        </span>
                                                    </td>
                                                    <td>    
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $msOnline->end_date) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $msOnline->end_date) ?>
                                                    </td>
                                                
                                                </tr>
                                    
                                    <?php                 
                                            }
                                        }
                                    ?>     
                        
                                    <?php if(!$check) { ?>
                                        <tr><td colspan="7">ไม่พบหลักสูตรที่จอง</td></tr>
                                    <?php } ?>
                                </tbody>
                                <tbody class="tableOnline" style="display:none">
                                <?php
                                        $criteria = new CDbCriteria;
                                        // $criteria->compare('status','y');
                                        $criteria->compare('user_id',Yii::app()->user->id);
                                        $criteria->order = 'id';
                                        $msTeamsTempTable = MsteamsTemp::model()->findAll($criteria);
                                        $check = false;
                                        foreach($msTeamsTempTable as $m){ 
                                            $check = true;
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('active', 'y');
                                            $criteria->compare('type_ms_teams', 1); //ออนไลน์  2= ออนไลน์ สถาบัน
                                            $criteria->compare('id',$m->ms_teams_id);
                                            $criteria->addCondition('end_date >= :date_now');
                                            $criteria->params[':date_now'] = date('Y-m-d H:i');
                                            // $criteria->order = 'create_date DESC';
                                            $msTeams = MsTeams::model()->find($criteria);
                                            if(isset($msTeams)){  ?>
                                                <tr>
                                                    <td><?= $msTeams->course_md_gm != null ? $msTeams->course_md_gm : "-" ?></td>
                                                    <td>
                                                        <?php 
                                                            // if($msTeams->price == "n"){
                                                            //     $join = "<a href=\"".Yii::app()->createUrl('virtualclassroom/detail/', array('id' => $msTeams->id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                            // }else{
                                                            //     if($m->status_payment == "y"){
                                                                    $join = "<a href=\"".Yii::app()->createUrl('virtualclassroom/detail/', array('id' => $msTeams->id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                            //     }else{
                                                            //         $join = "-";
                                                            //     }
                                                            // }
                                                            echo $join ;
                                                        ?>
                                                    </td>
                                                    <?php 
                                                        $courseGeneration = CourseGeneration::model()->findByPk($m->gen_id);
                                                    ?>
                                                    <td class="text-left"><?= $msTeams->name_ms_teams ?> (รุ่น : <?= isset($courseGeneration)? $courseGeneration->gen_detail : "ไม่มีรุ่น" ?>)</td>
                                                    <td>
                                                        <?php 
                                                        if($msTeams->price == "n"){
                                                            $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                        }else{
                                                            if($m->status_payment == "n" && $m->file_payment == null){
                                                                $status = "<span class=\"text-warning\"><i class=\"fas fa-money-bill\"></i> รอชำระเงิน</span"; 
                                                            }else if($m->status_payment == "w"){
                                                                $status = "<span class=\"text-primary\"><i class=\"fas fa-spinner\"></i> กำลังดำเนินการ</span></td>" ;
                                                            }else if($m->status_payment == "y"){
                                                                $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                            }else if($m->status_payment == "x"){
                                                                $status = "<span class=\"text-danger\"><i class=\"fas fa-times\"></i> ไม่ผ่านอนุมัติ</span>"; 
                                                            }
                                                        }
                                                    
                                                        echo $status;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $type_pri = 0;
                                                            if ($msTeams->price == 'y') {
                                                                if ($msTeams->ms_price <= 0) {
                                                                    $type_pri = 0;
                                                                } else {
                                                                    $type_pri = 1;
                                                                }
                                                            } else {
                                                                $type_pri = 0;
                                                            }

                                                            if($msTeams->price == "n"){
                                                                $slip = "-" ;
                                                            }else{
                                                                if($m->status_payment == "n" && $m->file_payment == null){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking-online\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$msTeams->id.','."'" . $msTeams->name_ms_teams . "'".','.$type_pri.','.'\'msteams\''.','.$m->gen_id.','.$m->id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }else if($m->status_payment == "w"){
                                                                    $slip = "-" ;
                                                                }else if($m->status_payment == "y"){
                                                                    $slip = "-" ;
                                                                }else if($m->status_payment == "x"){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking-online\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$msTeams->id.','."'" . $msTeams->name_ms_teams . "'".','.$type_pri.','.'\'msteams\''.','.$m->gen_id.','.$m->id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }
                                                            }
                                                            
                                                            echo $slip;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $msTeams->start_date) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $msTeams->start_date) ?>
                                                        </span>
                                                    </td>
                                                    <td>    
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $msTeams->end_date) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $msTeams->end_date) ?>
                                                    </td>
                                                </tr>


                                <?php
                                            }
                                        }
                                ?>
                                <?php if(!$check) { ?>
                                        <tr><td colspan="7">ไม่พบหลักสูตรที่จอง</td></tr>
                                <?php } ?>
                                </tbody>
                                <tbody class="tableCourse" style="display:none">
                                    <?php
                                        $criteria = new CDbCriteria;
                                        // $criteria->compare('status','y');
                                        $criteria->compare('user_id',Yii::app()->user->id);
                                        $criteria->order = 'id';
                                        $courseTempTable = CourseTemp::model()->findAll($criteria);
                                        $check = false;
                                        foreach($courseTempTable as $c){
                                            $check = true;
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('course.active','y');
                                            $criteria->compare('course_id',$c->course_id);
                                            $criteria->addCondition('course_date_end >= :date_now');
                                            $criteria->params[':date_now'] = date('Y-m-d H:i');
                                            $courseOnline = CourseOnline::model()->find($criteria);
                                            if(isset($courseOnline)){ ?>
                                                <tr>
                                                    <td><?= $courseOnline->course_number != null ? $courseOnline->course_number : "-" ?></td>
                                                    <td>
                                                    <?php 
                                                        // if($courseOnline->price == "n"){
                                                        //     $join = "<a href=\"".Yii::app()->createUrl('course/detail/', array('id' => $courseOnline->course_id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                        // }else{
                                                        //     if($c->status_payment == "y"){
                                                            $join = "<a href=\"".Yii::app()->createUrl('course/detail/', array('id' => $courseOnline->course_id,'gen'=>$c->gen_id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                        //     }else{
                                                        //         $join = "-";
                                                        //     }
                                                        // }
                                                        echo $join ;
                                                    ?>
                                                    </td>
                                                    <?php 
                                                        $courseGeneration = CourseGeneration::model()->findByPk($c->gen_id);

                                                        $criteria = new CDbCriteria;
                                                        $criteria->compare('active','y');
                                                        $criteria->compare('parent_id',$courseOnline->course_id);
                                                        $courseOnlineTh = CourseOnline::model()->find($criteria);
                                                    ?>
                                                    <td class="text-left"><?= $langId == 1 ? $courseOnline->course_title : $courseOnlineTh->course_title ?> (รุ่น : <?= isset($courseGeneration)? $courseGeneration->gen_title : "ไม่มีรุ่น" ?>)</td>
                                                    <td>
                                                    <?php 
                                                        if($courseOnline->price == "n"){
                                                            $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                        }else{
                                                            if($c->status_payment == "n" && $c->file_payment == null){
                                                                $status = "<span class=\"text-warning\"><i class=\"fas fa-money-bill\"></i> รอชำระเงิน</span"; 
                                                            }else if($c->status_payment == "w"){
                                                                $status = "<span class=\"text-primary\"><i class=\"fas fa-spinner\"></i> กำลังดำเนินการ</span></td>" ;
                                                            }else if($c->status_payment == "y"){
                                                                $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                            }else if($c->status_payment == "x"){
                                                                $status = "<span class=\"text-danger\"><i class=\"fas fa-times\"></i> ไม่ผ่านอนุมัติ</span>"; 
                                                            }
                                                        }
                                                        
                                                        echo $status;
                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?php 

                                                            $type_pri = 0;
                                                            if ($courseOnline->price == 'y') {
                                                                if ($courseOnline->course_price <= 0) {
                                                                    $type_pri = 0;
                                                                } else {
                                                                    $type_pri = 1;
                                                                }
                                                            } else {
                                                                $type_pri = 0;
                                                            }

                                                            if($courseOnline->price == "n"){
                                                                $slip = "-" ;
                                                            }else{
                                                                if($c->status_payment == "n" && $c->file_payment == null){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$courseOnline->course_id.','."'" . $courseOnline->course_title . "'".','.$type_pri.','.'\'course\''.','.$c->gen_id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }else if($c->status_payment == "w"){
                                                                    $slip = "-" ;
                                                                }else if($c->status_payment == "y"){
                                                                    $slip = "-" ;
                                                                }else if($c->status_payment == "x"){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$courseOnline->course_id.','."'" . $courseOnline->course_title . "'".','.$type_pri.','.'\'course\''.','.$c->gen_id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }

                                                            }
                                                            
                                                            echo $slip;
                                                            ?>
                                            
                                                    </td>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $courseOnline->course_date_start) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $courseOnline->course_date_start) ?>
                                                        </span>
                                                    </td>
                                                    <td>    
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $courseOnline->course_date_end) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $courseOnline->course_date_end) ?>
                                                    </td>
                                                
                                                </tr>
                                    
                                    <?php                 
                                            }
                                        }
                                    ?>

                                    <?php if(!$check) { ?>
                                        <tr><td colspan="7">ไม่พบหลักสูตรที่จอง</td></tr>
                                    <?php } ?>
                                </tbody>
                                <tbody class="tableExamRoom" style="display:none;">
                                <?php
                                        $criteria = new CDbCriteria;
                                        // $criteria->compare('status','y');
                                        $criteria->compare('user_id',Yii::app()->user->id);
                                        $criteria->order = 'id';
                                        $onlineTempTable = OnlineTemp::model()->findAll($criteria);
                                        $check = false;
                                        foreach($onlineTempTable as $o){
                                            $check = true;
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('active','y');
                                            $criteria->compare('id',$o->ms_teams_id);
                                            $criteria->addCondition('end_date >= :date_now');
                                            $criteria->params[':date_now'] = date('Y-m-d H:i');
                                            $msOnline = MsOnline::model()->find($criteria);
                                            if(isset($msOnline)){ ?>
                                                <tr>
                                                    <td>-</td>
                                                    <td>
                                                    <?php 
                                                        // if($msOnline->price == "n"){
                                                        //     $join = "<a href=\"".Yii::app()->createUrl('ExamsOnline/detail/', array('id' => $msOnline->id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                        // }else{
                                                        //     if($o->file_payment != null && $o->status == 'y'){
                                                                $join = "<a href=\"".Yii::app()->createUrl('ExamsOnline/detail/', array('id' => $msOnline->id))."\" class=\"btn btn-sm btn-primary\">เข้าเรียน&nbsp;<i class=\"fa fa-angle-right\"></i></a>" ;
                                                        //     }else{
                                                        //         $join = "-";
                                                        //     }
                                                        // }
                                                        echo $join ;
                                                    ?>
                                                    </td>
                                                    <?php 
                                                        $courseGeneration = CourseGeneration::model()->findByPk($o->gen_id);

                                                        // $criteria = new CDbCriteria;
                                                        // $criteria->compare('active','y');
                                                        // $criteria->compare('parent_id',$msOnline->course_id);
                                                        // $courseOnlineTh = CourseOnline::model()->find($criteria);
                                                    ?>
                                                    <td class="text-left"><?= $langId == 1 ? $msOnline->name_ms_teams : $msOnline->name_ms_teams ?> (รุ่น : <?= isset($courseGeneration)? $courseGeneration->gen_title : "ไม่มีรุ่น" ?>)</td>
                                                    <td>
                                                    <?php 
                                                        if($msOnline->price == "n"){
                                                            $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                        }else{
                                                            if($o->status == "y" && $o->file_payment == null){
                                                                $status = "<span class=\"text-warning\"><i class=\"fas fa-money-bill\"></i> รอชำระเงิน</span"; 
                                                            }else if($o->status == "y" && $o->file_payment != null && $o->date_confirm == null){
                                                                $status = "<span class=\"text-primary\"><i class=\"fas fa-spinner\"></i> กำลังดำเนินการ</span></td>" ;
                                                            }else if($o->status == "y" && $o->file_payment != null && $o->date_confirm != null){
                                                                $status = "<span class=\"text-success\"><i class=\"fas fa-check\"></i> อนุมัติ</span>" ;
                                                            }else if($o->status == "x"){
                                                                $status = "<span class=\"text-danger\"><i class=\"fas fa-times\"></i> ไม่ผ่านอนุมัติ</span>"; 
                                                            }
                                                        }
                                                        
                                                        echo $status;
                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?php 

                                                            $type_pri = 0;
                                                            if ($msOnline->price == 'y') {
                                                                if ($msOnline->ms_price <= 0) {
                                                                    $type_pri = 0;
                                                                } else {
                                                                    $type_pri = 1;
                                                                }
                                                            } else {
                                                                $type_pri = 0;
                                                            }

                                                            if($msOnline->price == "n"){
                                                                $slip = "-" ;
                                                            }else{

                                                                if($o->status == "y" && $o->file_payment == null){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking-exam-room\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$msOnline->id.','."'" . $msOnline->name_ms_teams . "'".','.$type_pri.','.'\'examroom\''.','.$o->gen_id.','.$o->id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>"; 
                                                                }else if($o->status == "y" && $o->file_payment != null && $o->date_confirm == null){
                                                                    $slip = "-" ;
                                                                }else if($o->status == "y" && $o->file_payment != null && $o->date_confirm != null){
                                                                    $slip = "-" ;
                                                                }else if($o->status == "x"){
                                                                    $slip = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#course-booking-exam-room\" class=\"btn btn-booking-outline \" onclick=\"paymentBooking(".$msOnline->id.','."'" . $msOnline->name_ms_teams . "'".','.$type_pri.','.'\'examroom\''.','.$o->gen_id.','.$o->id.")\"><i class=\"fas fa-file-invoice\"></i>&nbsp;แนบหลักฐาน</a>";
                                                                }
                                                            }
                                                            
                                                            echo $slip;
                                                            ?>
                                            
                                                    </td>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $msOnline->start_date) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_start : $msOnline->start_date) ?>
                                                        </span>
                                                    </td>
                                                    <td>    
                                                            <?= $langId == 1 ? Helpers::lib()->DateEngNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $msOnline->end_date) : Helpers::lib()->DateThaiNewNoTime(isset($courseGeneration ) ? $courseGeneration->gen_period_end : $msOnline->end_date) ?>
                                                    </td>
                                                
                                                </tr>
                                    
                                    <?php                 
                                            }
                                        }
                                    ?>

                                    <?php if(!$check) { ?>
                                        <tr><td colspan="7">ไม่พบหลักสูตรที่จอง</td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12 col-md-12">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'registration-form',
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1'),
                    ));
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-header p-2">
                            <h4><i class="fas fa-search"></i> ค้นหาหลักสูตรที่ต้องการ</h4>
                        </div>
                        <div class="p-2">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label for="search">ประเภทหลักสูตร <span class="text-danger">*</span></label>
                                        <select class="form-control"  aria-label="" name="search[search_course_type]" required>
                                            <option value="0" selected disabled>--- เลือกประเภทหลักสูตร ---</option>
                                            <option value="1">เรียนรู้ทางไกล (Online)</option>
                                            <option value="2">ศึกษาด้วยตนเอง (E-Learning)</option>
                                            <option value="3">ห้องสอบออนไลน์ (Exam Room)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label for="search">ชื่อหลักสูตร <span class="text-danger">*</span></label>
                                        
                                        <select class="form-control none"  aria-label="" required>
                                            <option value="0" selected disabled>--- เลือกชื่อหลักสูตร ---</option>
                                        </select>

                                        <select class="form-control online"  aria-label="" style="display:none;" required>
                                            <?php if(count($msteams)> 0){ ?>
                                                <option value="0" selected disabled>--- เลือกชื่อหลักสูตร ---</option>
                                                <?php foreach ($msteams as $keyte => $teams) { ?>
                                                            <option value="<?= $teams->id ;?>"> <?php if($teams->course_md_gm != null){ ?>(รหัสหลักสูตร : <?= $teams->course_md_gm ?>)<?php } ?> <?= $teams->name_ms_teams ;?></option>
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <option value="0" selected disabled>--- ไม่พบหลักสูตร ---</option>
                                            <?php } ?>
                                        </select>

                                        <select class="form-control theory"  aria-label="" style="display:none;" required>
                                        <?php if(count($course)> 0){ ?>
                                            <option value="0" selected disabled>--- เลือกชื่อหลักสูตร ---</option>
                                            <?php foreach ($course as $keyrec => $recommend) { 
                                                ?>
                                                    <option value="<?= $recommend->course_id ;?>"><?php if($recommend->course_number != null){ ?>(รหัสหลักสูตร : <?= $recommend->course_number ?>)<?php } ?> <?= $recommend->course_title ;?></option>                                                    
                                            <?php } ?>
                                        <?php }else { ?>
                                            <option value="0" selected disabled>--- ไม่พบหลักสูตร ---</option>
                                        <?php } ?>
                            
                                        </select>

                                        <select class="form-control examroom"  aria-label="" style="display:none;" required>
                                        <?php if(count($examrooms)> 0){ ?>
                                            <option value="0" selected disabled>--- เลือกชื่อหลักสูตร ---</option>
                                            <?php foreach ($examrooms as $keyrec => $exam) { 
                                                ?>
                                                    <option value="<?= $exam->id ;?>"> <?= $exam->name_ms_teams ;?></option>                                                    
                                            <?php } ?>
                                        <?php }else { ?>
                                            <option value="0" selected disabled>--- ไม่พบหลักสูตร ---</option>
                                        <?php } ?>
                            
                                        </select>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 col-md-12">
                                    <div class="form-group form-date">
                                        <label for="search">วันที่รุ่นหลักสูตร</label>
                                       <!-- <input type="date" class="form-control" name="search[search_date_start]"> -->
                                       <select class="form-control gen">
                                       <option value="0" selected disabled>--- เลือกวันที่รุ่นหลักสูตร ---</option>
                                       </select>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12 col-xs-12 col-md-6">
                                    <div class="form-group form-date">
                                        <label for="search">วันสิ้นสุดอบรม (ค.ศ.)</label>
                                       <input type="date" class="form-control" name="search[search_date_end]">
                                    </div>
                                </div> -->
                            </div>

                            <div class="submit-booking text-center">
                                <button type="button" class="btn btn-booking w-200" onclick="confirmBooking();" disabled id="btnsubmit"><i class="fas fa-check"></i> <?= $langId == 1 ? "Booking" : "จองหลักสูตร" ?></button>
                            </div>
                        </div>
                       
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>

        </div>

    </div>
</section>

<form action="<?php echo $this->createUrl('course/bookingsave') ?>" id="frmsaveCourse" name="frmsaveCourse" method="post" class="needs-validation" enctype="multipart/form-data">
    <input type="hidden" name="course_id" value="">
    <input type="hidden" name="type_price" value="">
    <input type="hidden" name="generation" value="0">
    <input type="hidden" name="type" value="booking">
</form>

<form action="<?php echo $this->createUrl('course/bookingmsteamssave') ?>" id="frmsaveMsteams" name="frmsaveMsteams" method="post" class="needs-validation" enctype="multipart/form-data">
     <input type="hidden" name="course_id" value="">
     <input type="hidden" name="type_price" value="">
     <input type="hidden" name="generation" value="0">
     <input type="hidden" name="type" value="booking">
 </form>

 <form action="<?php echo $this->createUrl('examsonline/bookingmsteamssave') ?>" id="frmsaveExamRooms" name="frmsaveExamRooms" method="post" class="needs-validation" enctype="multipart/form-data">
     <input type="hidden" name="course_id" value="">
     <input type="hidden" name="type_price" value="">
     <input type="hidden" name="generation" value="0">
     <input type="hidden" name="type" value="booking">
 </form>

 <!-- ทฤษฎี -->
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

                    <input type="hidden" name="course_id" value="">
                    <input type="hidden" name="type_price" value="">
                    <input type="hidden" name="type" value="booking">
                    <input type="hidden" name="title" value="">
                    <input type="hidden" name="generation" value="0">
                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">จำนวนเงินที่โอน</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="money" placeholder="" id="money">
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
                                    <input type="datetime-local" class="form-control" name="date_slip" placeholder="" id="date_slip">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <h4>อัพโหลดหลักฐานการชำระเงิน</h4>
                        <input type="file" name="file_payment" accept="image/png , image/jpg , image/jpeg" id="file_payment" class="form-control" style="height:40px;">
                    </div>

                </form>

                <button type="button" onclick="mybooking('course')" id="btnsubmitcourse" class="btn btn-booking">ยืนยันการจอง</button>
            </div>

        </div>
    </div>
</div>



<!--ออนไลน์-->
<div class="modal fade" id="course-booking-online" tabindex="-1" role="dialog" aria-labelledby="course-booking-online">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">จ่ายเงินเพื่อจองหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">

                <form action="<?php echo $this->createUrl('course/bookingmsteamssave') ?>" id="frmsavepayOnline" name="frmsavepayOnline" method="post" class="needs-validation" enctype="multipart/form-data">
                    <div class="pay-course">
                        <h4>ธนาคารที่โอนเข้า</h4>
                        <?php
                        $modelbank = BankNameRelations::model()->findAll(array(
                            'condition' => 'ms_teams_id = "' . $course->id . '"'
                        ));

                        if (isset($_GET['tempoldid'])) {
                            $msOld = MsteamsTemp::model()->findByPk($_GET['tempoldid']);
                        }

                        foreach ($modelbank as $key => $valueb) {

                        ?>
                            <div class="row row-pay align-items-center">

                                <input <?= isset($_GET['tempoldid']) && $msOld->bank_id == $valueb->banks->id ? 'checked' : "" ?> <?= isset($_GET['tempoldid']) && $valueb->banks->id != null ? 'disabled' : "" ?> type="radio" id="test-<?= $valueb->banks->id ?>" name="chkbank" class="custom-control-input custom" value="<?= $valueb->banks->id ?>">
                                <img class="mx-2" src="<?php echo Yii::app()->baseUrl; ?>/uploads/bank/<?= $valueb->banks->id ?>/<?= $valueb->banks->bank_images ?>" width="80" alt="">

                                <div class="account-bank">
                                    <h4 class="">ธนาคาร : <span class="text-main"><?= $valueb->banks->bank_name ?></span></h4>
                                    <h4 class="">ชื่อบัญชี : <span class="text-main"><?= $valueb->banks->account_name ?></span></h4>
                                    <h4 class="">หมายเลขบัญชี : <span class="text-main"><?= $valueb->banks->account_number ?></span></h4>

                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <input type="hidden" name="course_id" value="<?= $course->id ?>">
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
                                    <?php if (isset($_GET['tempoldid']) && $msOld->date_slip != null) { ?>
                                        <input type="text" value="<?= $msOld->date_slip ?>" disabled class="form-control" name="date_slip">
                                    <?php } else { ?>
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

                    <?php if (isset($courseTemp->note_payment) || $courseTemp->status_payment == 'x') { ?>
                        <div class="text-danger"><i class="fas fa-times-circle"></i>&nbsp;หมายเหตุ-ไม่ผ่านอนุมัติ : <?= isset($courseTemp->note_payment) ? $courseTemp->note_payment : 'การชำระเงินไม่ผ่าน - ไม่มีรายละเอียด' ?></div>
                    <?php } ?>

                </form>

                <button type="button" onclick="mybooking('msteams')" id="b3" class="btn btn-booking">ยืนยันการจอง</button>
            </div>

        </div>
    </div>
</div>


<!--ห้องสอบออนไลน์-->
<div class="modal fade" id="course-booking-exam-room" tabindex="-1" role="dialog" aria-labelledby="course-booking-exam-room">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">จ่ายเงินเพื่อจองหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">
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

                <form action="<?php echo $this->createUrl('examsonline/bookingmsteamssave') ?>" id="frmsavepayExamRoom" name="frmsavepayExamRoom" method="post" 
                    class="needs-validation" enctype="multipart/form-data" >
                    <input type="text" name="course_id" value="<?= $teams->id ?>">
                    <input type="text" name="type_price" value="<?= $type_pri ?>">
                    <input type="text" name="tempoldid" value="">

                    
                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">จำนวนเงินที่โอน</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="money" placeholder="" id="money">
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
                                    <input type="datetime-local" class="form-control" name="date_slip" placeholder="" id="date_slip">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <h4>อัพโหลดหลักฐานการชำระเงิน</h4>
                        <input type="file" name="file_payment" accept="image/png , image/jpg , image/jpeg" id="file_payment" class="form-control" style="height:40px;">
                    </div>

                </form>

                <button type="button" onclick="mybooking('examroom')" id="btnsubmitcourse" class="btn btn-booking">ยืนยันการจอง</button>
            </div>

        </div>
    </div>
</div>

<script>
$(".tableAll").css("display","");
let type = 0;
$("[name='search[search_course_type]']").on('change', function() {
    $(".none").css("display","none"); 
  if(this.value == 1){
    $(".online").css("display","");
    $(".theory").css("display","none");
    $(".examroom").css("display","none");
    $(".online").val(0).change();
  }else if( this.value == 2){
    $(".theory").css("display","");
    $(".online").css("display","none");
    $(".examroom").css("display","none");
    $(".theory").val(0).change();
  }else if(this.value == 3){
    $(".examroom").css("display","");
    $(".online").css("display","none");
    $(".theory").css("display","none");
    $(".examroom").val(0).change();
  }
  type = this.value;
  $(".gen").html("<option value=\"\" selected disabled>--- เลือกวันที่รุ่นหลักสูตร ---</option>");
  $("#btnsubmit").prop('disabled', true);
});

$(".theory").on('change', function() {
    if(this.value != 0){
        $("#frmsaveCourse input[name=course_id]").val(this.value);
        getGeneration(this.value,type);
        getPrice(this.value,type);
        $("#btnsubmit").prop('disabled', false);
    }
});

$(".online").on('change', function() {
    if(this.value != 0){
        $("#frmsaveMsteams input[name=course_id]").val(this.value);
        getGeneration(this.value,type);
        getPrice(this.value,type);
        $("#btnsubmit").prop('disabled', false);
    }
});

$(".examroom").on('change', function() {
    if(this.value != 0){
        $("#frmsaveExamRooms input[name=course_id]").val(this.value);
        getGeneration(this.value,type);
        getPrice(this.value,type);
        $("#btnsubmit").prop('disabled', false);
    }
});


$("#tableType").on('change', function() {
    if(this.value == 0){
        $(".tableAll").css("display","");
        $(".tableOnline").css("display","none");
       $(".tableCourse").css("display","none");
       $(".tableExamRoom").css("display","none");
    }else if(this.value == 1){
       $(".tableOnline").css("display","");
       $(".tableCourse").css("display","none");
       $(".tableAll").css("display","none");
       $(".tableExamRoom").css("display","none");
    }else if(this.value == 2){
       $(".tableCourse").css("display","");
       $(".tableOnline").css("display","none");
       $(".tableAll").css("display","none");
       $(".tableExamRoom").css("display","none");
    }else{
       $(".tableCourse").css("display","none");
       $(".tableOnline").css("display","none");
       $(".tableAll").css("display","none");
       $(".tableExamRoom").css("display","");
    }
});


$(".gen").on('change', function() {
    if(type == 1){
        $("#frmsaveMsteams input[name=generation]").val(this.value); 
    }else if(type == 2){
        $("#frmsaveCourse input[name=generation]").val(this.value); 
    }else{
        $("#frmsaveExamRooms input[name=generation]").val(this.value); 
    }
});

function getGeneration(id){
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createAbsoluteUrl("/Course/GetGeneration"); ?>',
        data: ({
            course_id: id,
        }),
        success: function(data) {
            if(data != ""){
                $(".gen").html(data);
            }
        }
    });
}

function getPrice(id,type){
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createAbsoluteUrl("/Course/GetPrice"); ?>',
        data: ({
            course_id: id,
            type:type
        }),
        success: function(price) {
            if(type == 1){
                $("#frmsaveMsteams input[name=type_price]").val(price);
            }else if(type == 2){
                $("#frmsaveCourse input[name=type_price]").val(price);
            }else{
                $("#frmsaveExamRooms input[name=type_price]").val(price);
            }
        }
    });
}

function confirmBooking(){
    let cou_ti = "";
    if(type == 1){
         cou_ti = $(".online option:selected").text();
    }else if(type == 2){
         cou_ti = $(".theory option:selected").text();
    }else{
        cou_ti = $(".examroom option:selected").text();
    }
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
            if(type == 1){
                $("#frmsaveMsteams").submit();
            }else if(type == 2){
                $("#frmsaveCourse").submit();
            }else{
                $("#frmsaveExamRooms").submit();
            }
        }
    })
}

function mybooking(type) {
    if(type == 'msteams'){
        let title = $("#frmsavepayOnline input[name=title]").val();
        Swal.fire({
            title: 'ยืนยันการอัพโหลดหลักฐานการชำระเงิน',
            text: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.value) {
                $("#frmsavepayOnline").submit();
                $("#btnsubmitcourse").button('loading');
                $("#btnsubmitcourse").attr('disabled', 'disabled');
            }
        })
    }else if(type == 'course'){
        let title = $("#frmsavepay input[name=title]").val();
        Swal.fire({
            title: 'ยืนยันการอัพโหลดหลักฐานการชำระเงิน',
            text: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.value) {
                $("#frmsavepay").submit();
                $("#btnsubmitcourse").button('loading');
                $("#btnsubmitcourse").attr('disabled', 'disabled');
            }
        })

    }else{
        let title = $("#frmsavepayExamRoom input[name=title]").val();
        Swal.fire({
            title: 'ยืนยันการอัพโหลดหลักฐานการชำระเงิน',
            text: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.value) {
                $("#frmsavepayExamRoom").submit();
                $("#btnsubmitcourse").button('loading');
                $("#btnsubmitcourse").attr('disabled', 'disabled');
            }
        })
    }
   
}

function paymentBooking(id,title,type_price,type,gen,tempoldid = 0){
    if(type == 'msteams'){
        $("#frmsavepayOnline input[name=course_id]").val(id);
        $("#frmsavepayOnline input[name=type_price]").val(type_price);
        $("#frmsavepayOnline input[name=title]").val(title);
        // $("#frmsavepayOnline input[name=generation]").val(gen);
        $("#frmsavepayOnline input[name=tempoldid]").val(tempoldid);
    }else if(type == 'course'){
        $("#frmsavepay input[name=course_id]").val(id);
        $("#frmsavepay input[name=type_price]").val(type_price);
        $("#frmsavepay input[name=title]").val(title);
        $("#frmsavepay input[name=generation]").val(gen);
    }else{
        $("#frmsavepayExamRoom input[name=course_id]").val(id);
        $("#frmsavepayExamRoom input[name=type_price]").val(type_price);
        $("#frmsavepayExamRoom input[name=title]").val(title);
        $("#frmsavepayExamRoom input[name=tempoldid]").val(tempoldid);
    }

} 
</script>