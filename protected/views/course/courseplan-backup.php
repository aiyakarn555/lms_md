<?php 
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
?>


<!-- <div class="header-page parallax-window">
    <div class="container">
        <h1>
            <?php if($langId == 2){ ?>
                แผนการเรียน
            <?php }else{ ?>
                Plan
            <?php } ?>
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>">
                        <?php if($langId == 2){ ?>
                            หน้าแรก
                        <?php }else{ ?>
                            Home
                        <?php } ?>
                    </a></li> /
                    <li><span class="text-bc">
                        <?php if($langId == 2){ ?>
                            แผนการเรียน
                        <?php }else{ ?>
                            Plan
                        <?php } ?>
                    </span></li>
                </ul>
            </small>
        </h1>
    </div>
</div> -->

<div class="content" id="course-plan">
    <div class="container">
        <hr>

        <h3>
            <?php if($langId == 2){ ?>
                แผนการเรียน
            <?php }else{ ?>
                Plan
            <?php } ?>
        </h3>
        <?php 

        function courseplan($flag, $langId, $course_id, $type){

            $status = 1; 
            $link_course = "javascript:void(0)";
            $cursor_link = "cursor:auto;";          

            $criteria = new CDbCriteria;
            $criteria->with = array('CategoryTitle');
            $criteria->select = 'cate_id, course_title, course_date_start, course_date_end';
            $criteria->compare('course.active', 'y');
            $criteria->compare('course.status', '1');
            $criteria->compare('categorys.cate_show', '1');
            // $criteria->compare('categorys.type_id', '1');
            $criteria->compare('categorys.active', 'y');
            $criteria->compare('course_id', $course_id);
            $course_online = CourseOnline::model()->find($criteria);            

            $criteria = new CDbCriteria;
            $criteria->select = 'type_name';
            $criteria->compare('active', 'y');
            $criteria->compare('status', '1');
            if($langId == 2){
                $criteria->compare('parent_id', $course_online->CategoryTitle->type_id);
            }else{
                $criteria->compare('type_id', $course_online->CategoryTitle->type_id);
            }
            $type_course = CourseType::model()->find($criteria);

            if($langId == 2){
                $course_online_th = CourseOnline::model()->find(array(
                    'select'=>'course_title',
                    'condition'=>'lang_id=2 AND parent_id="'.$course_id.'" '
                ));
                $course_title = $course_online_th->course_title;
            }else{
                $course_title = $course_online->course_title;
            }



        if($type == "org" || $type == "regis" || $type == "general"){           

            $chk_start = Helpers::lib()->chk_logstartcourse($course_id);

            $LogStartcourse = LogStartcourse::model()->find(array(
                'select'=>'status_fake, start_date, end_date',
                'condition'=>'course_id="'.$course_id.'" AND id="'.$chk_start.'" AND user_id="'.Yii::app()->user->id.'" '
            ));

            if(date("Y",strtotime($LogStartcourse->start_date)) != date("Y") && date("Y",strtotime($LogStartcourse->end_date)) != date("Y")){
                $chk_start = 0;
                $status = 4; // หมดเวลาเรียน
            }           


            if($chk_start != 0){


                // ต้องมีหลักสูตรใน ORG และ กดสมัครแล้ว และยังไม่หมดอายุ ถึงมี link
                $chk_exp_learn_course = Helpers::lib()->checkUserCourseExpire($course_online);
                $chk_org_course_see = Helpers::lib()->chk_org_course_see(Yii::app()->user->id, $course_id);

                if($chk_org_course_see == true && $chk_exp_learn_course == true){                                                                
                    $link_course = Yii::app()->createUrl('course/detail').'/'.$course_id;
                    $cursor_link = "";
                    //font-weight: bold;
                }else{
                    $link_course = "javascript:void(0)";
                    $cursor_link = "cursor:auto;";
                }

                if($status == 1 && $course_online->course_date_end != ""){
                    if(strtotime(date("Y-m-d")) >= strtotime( date("Y-m-d", strtotime($course_online->course_date_start)) ) 
                    && strtotime(date("Y-m-d")) <= strtotime( date("Y-m-d", strtotime($course_online->course_date_end)) )  ){

                    }else{ // หลักสูตรหมดอายุ
                        $status = 4;
                    }
                }



            if($status == 1){
                if(strtotime(date("Y-m-d")) >= strtotime(date("Y-m-d",strtotime($LogStartcourse->start_date))) 
                && strtotime(date("Y-m-d")) <= strtotime(date("Y-m-d",strtotime($LogStartcourse->end_date))) ){

                }else{ // สมัครเรียน หมดอายุ
                    $status = 4;
                }
            }

            if($status == 1){
                $percent_course_status = Helpers::lib()->percent_CourseGen($course_id);
                $passCoursModel = Passcours::model()->find(array(
                    'select'=>'passcours_id',
                    'condition'=>'passcours_cours="'.$course_id.'" AND passcours_user="'.Yii::app()->user->id.'" AND startcourse_id="'.$chk_start.'"'
                ));
                if ($percent_course_status >= 100 && $passCoursModel) { //ผ่านหลักสูตร
                    $status = 3;
                }
            }

            if($status == 1){
                $StepCoursePass = Helpers::lib()->StepCoursePass($course_id);
                $learn = Learn::model()->find(array(
                    'select'=>'learn_id',
                    'condition'=>'startcourse_id="'.$chk_start.'" AND user_id="'.Yii::app()->user->id.'" AND course_id="'.$course_id.'" AND active="y" '
                ));
                if($StepCoursePass > 0 || $learn){
                    $status = 2;
                }
            }

            $start_regis_date = date("Y-m-d H:i:s", strtotime($LogStartcourse->start_date));
            if($course_online->course_date_end != "" && strtotime($course_online->course_date_end) <= strtotime($LogStartcourse->end_date)){
                $end_regis_date  = date("Y-m-d H:i:s", strtotime($course_online->course_date_end));
            }else{
                $end_regis_date  = date("Y-m-d H:i:s", strtotime($LogStartcourse->end_date));
            }

            


            if($type == "general" && $status != 4){
                $link_course = Yii::app()->createUrl('course/detail').'/'.$course_id;
                $cursor_link = "";
            }

        } // if($chk_start != 0)

        }elseif($type == "alert"){ // type

            $chk_start = Helpers::lib()->chk_logstartcourse($course_id);

            $LogStartcourse = LogStartcourse::model()->find(array(
                'select'=>'status_fake, start_date, end_date, alert_date',
                'condition'=>'course_id="'.$course_id.'" AND id="'.$chk_start.'" AND user_id="'.Yii::app()->user->id.'" '
            ));

            if($chk_start != 0){
                $start_regis_date = $LogStartcourse->alert_date;

                if($course_online->course_date_end != ""){
                    $end_regis_date = $course_online->course_date_end;
                }else{
                    $end_regis_date = date("Y")."-12-12 23:59:59";
                }

            }else{
                $LogStartcourse = LogStartcourse::model()->find(array(
                    'select'=>'status_fake, start_date, end_date, alert_date',
                    'condition'=>'course_id="'.$course_id.'" AND active="y" AND user_id="'.Yii::app()->user->id.'" ',
                    'order'=>'id DESC'
                ));

                $start_regis_date = $LogStartcourse->alert_date;

                if($course_online->course_date_end != ""){
                    $end_regis_date = $course_online->course_date_end;
                }else{
                    $end_regis_date = date("Y")."-12-12 23:59:59";
                }
            }

        }elseif($type == "training"){ // type
            $status = 3;

            $link_course = "javascript:void(0)";
            $cursor_link = "cursor:auto;";

            if($langId == 2){
                $type_course->type_name = "คำขอฝึกอบรม";
            }else{                
                $type_course->type_name = "Training";
            }

            $course_Training = TrainingRequest::model()->find(array(
                'select'=>'start_date, end_date',
                'condition'=>"active='y' 
                AND request_status='1' 
                AND user_id='" . Yii::app()->user->id . "' 
                AND start_date<='".date("Y-m-d")."' 
                AND end_date>='".date("Y-m-d")."' ",
            ));

            $start_regis_date = $course_Training->start_date;
            $end_regis_date = $course_Training->end_date;
          



        } // type



        if(date("Y", strtotime($start_regis_date)) !=  date("Y", strtotime($end_regis_date))){

            if(date("Y", strtotime($start_regis_date)) < date("Y")){
                $month_start = 1;
            }else{
                $month_start = date("m", strtotime($start_regis_date));
            }

            if(date("Y", strtotime($end_regis_date)) > date("Y")){
                $month_end = 12;
            }else{
                $month_end = date("m", strtotime($end_regis_date));
            }

        }else{
            $month_start = date("m", strtotime($start_regis_date));
            $month_end = date("m", strtotime($end_regis_date));
        }

        $month_start = $month_start*1;
        $month_end = $month_end*1;

            if($LogStartcourse->status_fake == 1){
                $col_status = "progress-plan-success";
                $txt_status = ($langId == 2) ? 'ผ่านการดำเนินการ' : 'Success';
                $link_course = "javascript:void(0)";
                $cursor_link = "cursor:auto;";

            }elseif ($status == 1){ //ยังไม่ดำเนินการ            
                $col_status = "progress-plan-info";
                $txt_status = ($langId == 2) ? 'ยังไม่ดำเนินการ' : 'Not proceed';

            } else if ($status == 2){ //กำลังดำเนินการ            
                $col_status = "progress-plan-warning";
                $txt_status = ($langId == 2) ? 'กำลังดำเนินการ' : 'In progress';

            } else if ($status == 3){ //ผ่านการดำเนินการ            
                $col_status = "progress-plan-success";
                $txt_status = ($langId == 2) ? 'ผ่านการดำเนินการ' : 'Success';

            } else if ($status == 4){ //หมดเวลา            
                $col_status = "progress-plan-danger";
                $txt_status = ($langId == 2) ? 'หมดเวลา' : 'Course expired';
                $link_course = "javascript:void(0)";
                $cursor_link = "cursor:auto;";
            }       




            ?> <tr> <?php
            ?>
                    <td>
                        <!-- <?= $status." ".$type ?> -->
                        <i class="fa fa-book"></i>
                        <a style="<?= $cursor_link ?>" href="<?= $link_course ?>">
                            <span style="color:#2222bb"> <?= $course_title ?></span>
                            <nobr><?= "[" . $type_course->type_name . "]" ?></nobr>
                        </a>
                    </td> 
            <?php


            if($chk_start != 0 || $type == "training" || $type == "alert"){

            for ($i=1; $i < $month_start; $i++) {
                ?> <td></td> <?php
            }

                ?> 
                <td colspan="<?= ($month_end-$month_start)+1 ?>" style="vertical-align: middle; cursor:auto; ">
                    <span style="width: 100%;" class="<?= $col_status ?>" data-toggle="tooltip" data-placement="left" title="<?= $txt_status ?>">‎</span>
                </td> 
                <?php
                for ($i=$month_end+1; $i <= 12; $i++) {
                    ?> <td></td> <?php
                }

            
        }else{
            for ($i=1; $i <=12; $i++) {
                ?> <td></td> <?php
            }
        }
    
        ?> </tr> <?php



        }

         ?>
        <table class="table table-hover table-responsive table-bordered  table-plan">
            <thead>
                <tr>
                    <th width="25%"><?= ($langId == 2) ? 'ชื่อหลักสูตร' : 'Course Name';?></th>
                    <th><?= ($langId == 2) ? 'ม.ค.' : 'Jan';?></th>
                    <th><?= ($langId == 2) ? 'ก.พ.' : 'Feb';?></th>
                    <th><?= ($langId == 2) ? 'มี.ค.' : 'Mar';?></th>
                    <th><?= ($langId == 2) ? 'เม.ย.' : 'Apr';?></th>
                    <th><?= ($langId == 2) ? 'พ.ค.' : 'May';?></th>
                    <th><?= ($langId == 2) ? 'มิ.ย.' : 'Jun';?></th>
                    <th><?= ($langId == 2) ? 'ก.ค.' : 'Jul';?></th>
                    <th><?= ($langId == 2) ? 'ส.ค.' : 'Aug';?></th>
                    <th><?= ($langId == 2) ? 'ก.ย.' : 'Sep';?></th>
                    <th><?= ($langId == 2) ? 'ต.ค.' : 'Oct';?></th>
                    <th><?= ($langId == 2) ? 'พ.ย.' : 'Nov';?></th>
                    <th><?= ($langId == 2) ? 'ธ.ค.' : 'Dec';?></th>
                </tr>
            </thead>
            <tbody>
                <?php


                    // หลักสูตรภายใน org chart
                    foreach ($id_course_orgchart as $key_c => $val_course) {
                        courseplan($flag, $langId, $val_course, "org");
                    }

                    // หลักสูตรภายใน org chart แจ้งเตือนในอนาคต
                    foreach ($id_course_alert as $key_c => $val_course) {
                        courseplan($flag, $langId, $val_course->course_id, "alert");
                    }

                    // หลักสูตรทั่วไป ที่สมัคร
                    foreach ($id_course_general as $key_c => $val_course) {
                        courseplan($flag, $langId, $val_course->course_id, "general");
                    }

                    // หลักสูตรภายใน ที่สมัคร ไม่มีใน org
                    foreach ($id_course_LogStartCourse as $key_c => $val_course) {
                        courseplan($flag, $langId, $val_course->course_id, "regis");
                    }

                    // ฝึกอบรม ปีปัจจุบัน ที่ผ่านอนุมัติแล้ว
                    foreach ($id_course_Training as $key_c => $val_course) {
                        courseplan($flag, $langId, $val_course->course_id, "training");
                    }



                ?>
            </tbody>
        </table>
        <div style="">
            <span class="progress-plan-info" style="position:relative;"><?= ($langId == 2) ? 'ยังไม่ดำเนินการ' : 'Not proceed';?></span>
            <span class="progress-plan-warning" style="position:relative;"><?= ($langId == 2) ? 'กำลังดำเนินการ' : 'In progress';?></span>
            <span class="progress-plan-success" style="position:relative;"><?= ($langId == 2) ? 'ผ่านการดำเนินการ' : 'Success';?></span>
            <span class="progress-plan-danger" style="position:relative;"><?= ($langId == 2) ? 'หมดเวลา' : 'Course expired';?></span>
        </div>
    </div>

</div>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>