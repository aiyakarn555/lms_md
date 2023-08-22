<?php
$title = 'รายงาน ผู้ผ่านการเรียน';
$currentModel = 'Report';

ob_start();

$this->breadcrumbs = array($title);

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');
    $('#Report_type_cou').css('display','none');


EOD
, CClientScript::POS_READY);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<script type="text/javascript">
    $(function() {

        $(".chosen").chosen();
       

        $("#Report_period_start").datepicker({
                dateFormat:'yy-mm-dd',
                onSelect: function(selected) {
                $("#search_year").val(null);
                  $("#Report_period_end").datepicker("option","minDate", selected)
              }
          });
        $("#Report_period_end").datepicker({     
                dateFormat:'yy-mm-dd',
                onSelect: function(selected) {
                $("#search_year").val(null);
                 $("#Report_period_start").datepicker("option","maxDate", selected)
             }
         });     

        $("#search_year").change(function(){
            $("#Report_period_start").val(null);
            $("#Report_period_end").val(null);
        });

        endDate();
        startDate();


      // $("#Report_type_register").change(function(){
      //       var value = $("#Report_type_register option:selected").val();
      //       if(value != ""){
      //           $.ajax({
      //               type: 'POST',
      //               url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetdepartment"); ?>',
      //               data: ({
      //                   value: value,
      //               }),
      //               success: function(data) {
      //                   if(data != ""){
      //                       $("#Report_department").html(data);
      //                       $("#Report_position").html('<option value="">ทั้งหมด</option>');
      //                       $('.chosen').trigger("chosen:updated");
      //                   }
      //               }
      //           });
      //       }
      //   });
        

      $("#type_cous").change(function(){
        var value = $("#type_cous option:selected").val();
        GetList($("#search_year").val());
        typeChange(value);
    });

      

        <?php if(isset($_GET['type_cou'])){ ?>
            var chk = "<?=$_GET['type_cou']?>";

             if(chk == 1){
                $(".CouTest").show();
                $(".MsTest").hide();
                $("#course_id").prop('required',true);
                $("#msteamss").prop('required',false);
                $("#msteamss").val(null);

            }else{
                $(".CouTest").hide();
                $(".MsTest").show();
                $("#msteamss").prop('required',true);
                $("#course_id").prop('required',false);
                $("#course_id").val(null);
            }



        <?php } ?>

        <?php if(isset($_GET["course_codenum"]) && $_GET["course_codenum"] != ""){ ?>
            // $("#msteamss").prop('required',false);
        <?php } ?>
        


    });

    function startDate() {
        $('#passcoursStartDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function() {
                $("#passcoursEndDateBtn").datepicker("option","minDate", this.value);
            },
        });
    }
    function endDate() {
        $('#passcoursEndDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
        });
    }

    




    $('#Report_type_cou').val(2);

</script>
    <?php 
    $userModel = Users::model()->findByPk(Yii::app()->user->id);
    $Institution = Institution::model()->findAll();

    $listInstitution = CHtml::listData($Institution,'id','institution_name');

    $arr = array(1=> 'ทฤษฎี' , 2 => 'ออนไลน์');

    $currentYear = (date("Y")+543);
    $year = array();
    for ($i=0; $i <= 20; $i++) {
        $year[(($currentYear)-$i) - 543] = $currentYear-$i;
    }

    ?>

    <div class="innerLR">

        <div class="widget">
            <div class="widget-head">
                <h4 class="heading glyphicons search">
                    <i></i> ค้นหา:
                </h4>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm',
                array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                )
            );
            ?>
            <div class="widget-body">
                <dl class="dl-horizontal">
                    <div class="form-group">
                        <dt><label>สถานบัน <b style="color: red"> *</b> : </label></dt>
                        <dd>
                            <select <?php ($_GET["course_codenum"] == "" || $_GET["course_codenum"] == null) ? "required" : ""?> style="width: 500px;" class="form-select " aria-label="Default select example" id="institution_id" name="institution_id">
                                <option value="all">--- ทุกสถาบัน ---</option>
                                <?php
                                $Institution = Institution::model()->findAll();
                                if($Institution) {
                                    foreach($Institution as $ins) {
                                        ?>
                                        <option <?= ( $_GET['institution_id'] == $ins->code ? 'selected="selected"' : '' ) ?> value="<?= $ins->code ?>"><?= $ins->institution_name ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="">ยังไม่มีสถานบัน</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </dd>
                    </div>

                    <div class="form-group">
                        <dt><label>ประเภทหลักสูตร <b style="color: red"> *</b> : </label></dt>
                        <dd>
                            <select style="width: 500px;" required="" class="form-select " id="type_cous" aria-label="Default select example" name="type_cou">
                                <option value="">--- เลือกประเภทหลักสูตร ---</option>
                                <?php
                                foreach($arr as $key => $AA) {
                                    ?>
                                    <option <?= ( $_GET['type_cou'] == $key ? 'selected="selected"' : '' ) ?> value="<?= $key ?>"><?= $AA ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </dd>
                    </div>

                    <div class="form-group div_search_year" style="display: none">
                        <dt><label>ปี พ.ศ. <b style="color: red"> *</b> : </label></dt>
                        <dd>
                            <select style="width: 500px;"  class="form-select " id="search_year" aria-label="Default select example" onchange="GetList(this.value)" name="search_year">
                                <option value="">--- เลือกปี พ.ศ. ---</option>
                                <?php
                                foreach($year as $keys => $ya) {
                                    ?>
                                    <option <?= ( $_GET['search_year'] == $keys ? 'selected="selected"' : '' ) ?> value="<?= $keys ?>"><?= $ya ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </dd>
                    </div>

                    <div class="form-group CouTest" style="display: none">
                        <dt><label>หลักสูตร <b style="color: red"> *</b> : </label></dt>
                        <dd>
                            <select style="width: 500px;" class="form-select " aria-label="Default select example" id="course_id" name="course_id">
                                <option value="">--- เลือกหลักสูตร ---</option>
                            </select>
                        </dd>
                    </div>

                    <div class="form-group MsTest" style="display: none">
                        <dt><label>ห้องเรียนออนไลน์ <b style="color: red"> *</b> : </label></dt>
                        <dd>
                            <select style="width: 500px;" class="form-select " aria-label="Default select example" id="msteamss" name="ms_teams_id">
                                <option value="">--- เลือกห้องเรียนออนไลน์ ---</option>
                            </select>
                        </dd>
                    </div>


                    <div class="form-group">
                        <dt><label>เลขบัตรประชาชน : </label></dt>
                        <dd>
                            <input style="width: 500px;" name="idcard" type="text" class="form-control" placeholder="เลขบัตรประชาชน" value="<?= $_GET['idcard'] ?>" > 
                        </dd>
                    </div> 

                    <div class="form-group">
                        <dt><label>ชื่อ - นามสกุล : </label></dt>
                        <dd>
                            <input style="width: 500px;" name="nameSearch" type="text" class="form-control" placeholder="ชื่อ - นามสกุล" value="<?= $_GET['nameSearch'] ?>" > 
                        </dd>
                    </div> 

                    <div class="form-group">
                        <dt><label>วันที่เริ่มฝึกอบรม : </label></dt>
                        <dd>
                            <input style="width: 500px;" id="Report_period_start" name="datestr" type="text" class="form-control" placeholder="วันที่เริ่มฝึกอบรม" value="<?= $_GET['datestr'] ?>" > 
                        </dd>
                    </div> 

                    <div class="form-group">
                        <dt><label>วันที่สิ้นสุดฝึกอบรม : </label></dt>
                        <dd>
                            <input style="width: 500px;" id="Report_period_end" name="dateend" type="text" class="form-control" placeholder="วันที่สิ้นสุดฝึกอบรม" value="<?= $_GET['dateend'] ?>" > 
                        </dd>
                    </div> 

                    

                    <div class="form-group">
                        <dt><label>เลขที่ ปก. : </label></dt>
                        <dd>
                            <input style="width: 500px;" id="course_codenum" name="course_codenum" type="text" class="form-control" placeholder="เลขที่ ปก." value="<?= $_GET['course_codenum'] ?>" > 
                        </dd>
                    </div> 

                    <div class="form-group">
                        <dt></dt>
                        <dd><button type="submit" class="btn btn-primary btn-icon glyphicons search"><i></i> Search</button></dd>
                    </div>
                </dl>
            </div>
            <?php $this->endWidget(); ?>
        </div>

    </div>

    <?php
    if(isset($_GET['ms_teams_id']) && $_GET['ms_teams_id'] != "" ){
        $type = "virtual";
        if($type == "virtual"){
            if($_GET['institution_id'] == "all"){
                $Institution = Institution::model()->findAll();
                $institution_array = [];
                foreach ($Institution as $keyInstitution => $valueInstitution) {
                    $institution_array[] = $valueInstitution->code;
                }
            }else{
                $institution_array = array($_GET['institution_id']);
            }

            $allUserAdminCreateCourse = array();
            $criteria = new CDbCriteria;
            $criteria->compare('superuser', 1);
            $criteria->addInCondition('institution_id', $institution_array);
            $UserAdmin = Users::model()->findAll($criteria);
            foreach ($UserAdmin as $keyUserAdmin => $valueUserAdmin) {
                $allUserAdminCreateCourse[] = $valueUserAdmin->id;
            }


            $MsTeam = MsTeams::model()->find(array(
                'condition' => 'id="' . $_GET['ms_teams_id'] . '"',
            ));

            $allUsersPassCourse = array();

            // ห้องเรียนออนไลน์
            $criteria = new CDbCriteria;
            $criteria->compare('course_md_code', $MsTeam->course_md_code);
            $criteria->addInCondition("create_by",$allUserAdminCreateCourse);
            $MsTeams = MsTeams::model()->findAll($criteria);

            $array_MsTeams = array();
            foreach ($MsTeams as $keyMsTeams => $valueMsTeams) {
                $array_MsTeams[] = $valueMsTeams->id;
            }

            $criteria = new CDbCriteria;
            $criteria->addInCondition("ms_teams_id",$array_MsTeams);

            if(isset($_GET['idcard']) && $_GET['idcard'] != null){
                $criteria->compare('pro.identification',$_GET['idcard'],true);
            }

            if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
                $ex_fullname = explode(" ", $_GET['nameSearch']);

                if(isset($ex_fullname[0])){
                    $pro_fname = $ex_fullname[0];
                    $criteria->compare('pro.firstname_en', $pro_fname, true);
                    $criteria->compare('pro.lastname_en', $pro_fname, true, 'OR');
                    $criteria->compare('pro.firstname', $pro_fname, true, 'OR');
                    $criteria->compare('pro.lastname', $pro_fname, true, 'OR');
                }

                if(isset($ex_fullname[1])){
                    $pro_lname = $ex_fullname[1];
                    $criteria->compare('pro.lastname',$pro_lname,true);
                    $criteria->compare('pro.lastname_en', $pro_lname, true, 'OR');
                }
            }

            // if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

            //     $criteria->addCondition('passcours.cours_start_date >= :date_str');
            //     $criteria->params[':date_str'] = $_GET['datestr'];

            //     $criteria->addCondition('passcours.passcours_date <= :date_end');
            //     $criteria->params[':date_end'] = $_GET['dateend'];

            // }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

            //     $criteria->addCondition('passcours.cours_start_date >= :date_str');
            //     $criteria->params[':date_str'] = $_GET['datestr'];

            // }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

            //     $criteria->addCondition('passcours.passcours_date <= :date_end');
            //     $criteria->params[':date_end'] = $_GET['dateend'];
            // }

            $allUsersLogStartCourse = LogStartMsTeams::model()->findAll($criteria);

            

            foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {
                $percent = Helpers::lib()->percent_MsTeams($valueByUser->ms_teams_id,$valueByUser->gen_id,$valueByUser->user_id);
                if($percent == 100){
                    $status = true;
                    $PasscoursLog = PasscoursLog::model()->find(array(
                        'condition' => 'pclog_userid=:user_id AND pclog_event=:event AND pclog_ms_teams=:cou ',
                        'params' => array(':user_id' => $valueByUser->user_id,':event' => 'Print',':cou' => $valueByUser->ms_teams_id)
                    ));
                    if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
                        $status = (!empty($PasscoursLog) && $PasscoursLog->cou_number == $_GET['course_codenum']) ? true : false;
                    }
                    if($status){
                        $allUsersPassCourse[] =
                        array(
                            "idCard"=>$valueByUser->pro->identification,
                            "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
                            "fName"=>$valueByUser->pro->firstname,
                            "lName"=>$valueByUser->pro->lastname,
                            "institutionName"=>$valueByUser->msteams->createby->institution->institution_name,
                            "courseTitle"=>$valueByUser->msteams->name_ms_teams,
                            "courseNumber"=>(!empty($PasscoursLog)) ? $PasscoursLog->cou_number : "-",
                            "startDate"=>$valueByUser->start_date,
                            "endDate"=>(isset($valueByUser->passcours_date)) ? $valueByUser->passcours_date : $valueByUser->create_date,
                            "note"=>"-"
                        );
                    }
                    
                }
            }
            // ห้องเรียนออนไลน์


            // Import Pass MD
            $criteria = new CDbCriteria;
            $criteria->addInCondition("institution_id",$institution_array);
            $criteria->compare("course_md_id",$MsTeam->course_md_code);

            if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
                $ex_fullname = explode(" ", $_GET['nameSearch']);

                if(isset($ex_fullname[0])){
                    $pro_fname = $ex_fullname[0];
                    $criteria->compare('fname', $pro_fname, true);
                    $criteria->compare('lname', $pro_fname, true, 'OR');
                }

                if(isset($ex_fullname[1])){
                    $pro_lname = $ex_fullname[1];
                    $criteria->compare('fname',$pro_lname,true);
                    $criteria->compare('lname', $pro_lname, true, 'OR');
                }
            }

            if(isset($_GET['idcard']) && $_GET['idcard'] != null){
                $criteria->compare('idcard',$_GET['idcard'],true);
            }

            if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
                $criteria->compare('course_number',$_GET['course_codenum'],true);
            }

            // if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

            //     $criteria->addCondition('startdate >= :date_str');
            //     $criteria->params[':date_str'] = $_GET['datestr'];

            //     $criteria->addCondition('enddate <= :date_end');
            //     $criteria->params[':date_end'] = $_GET['dateend'];

            // }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

            //     $criteria->addCondition('startdate >= :date_str');
            //     $criteria->params[':date_str'] = $_GET['datestr'];

            // }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

            //     $criteria->addCondition('enddate <= :date_end');
            //     $criteria->params[':date_end'] = $_GET['dateend'];
            // }

            $PassCourseImport = ImportPassMd::model()->findAll($criteria);
            foreach ($PassCourseImport as $keyByUser => $valueByUser) {
                $allUsersPassCourse[] =
                    array(
                        "idCard"=>$valueByUser->idcard,
                        "title"=>$valueByUser->title,
                        "fName"=>$valueByUser->fname,
                        "lName"=>$valueByUser->lname,
                        "institutionName"=>$valueByUser->institution->institution_name,
                        "courseTitle"=>$valueByUser->mtcodemd->name_md,
                        "courseNumber"=>$valueByUser->course_number,
                        "startDate"=>$valueByUser->startdate,
                        "endDate"=>$valueByUser->enddate,
                        "note"=>($valueByUser->note != null) ? $valueByUser->note : "-"
                    );
            }

            // Import Pass MD
        }
    }else if(isset($_GET['course_id']) && $_GET['course_id'] != "" ){
        $allUsersPassCourse = array();

        $criteria = new CDbCriteria;
        $criteria->compare("course_id",$_GET['course_id']);
        $courseOnline = CourseOnline::model()->find($criteria);
        
        $criteria = new CDbCriteria;
        $criteria->compare("course_id",$_GET['course_id']);

        if(isset($_GET['idcard']) && $_GET['idcard'] != null){
            $criteria->compare('pro.identification',$_GET['idcard'],true);
        }

        if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
            $ex_fullname = explode(" ", $_GET['nameSearch']);

            if(isset($ex_fullname[0])){
                $pro_fname = $ex_fullname[0];
                $criteria->compare('pro.firstname_en', $pro_fname, true);
                $criteria->compare('pro.lastname_en', $pro_fname, true, 'OR');
                $criteria->compare('pro.firstname', $pro_fname, true, 'OR');
                $criteria->compare('pro.lastname', $pro_fname, true, 'OR');
            }

            if(isset($ex_fullname[1])){
                $pro_lname = $ex_fullname[1];
                $criteria->compare('pro.lastname',$pro_lname,true);
                $criteria->compare('pro.lastname_en', $pro_lname, true, 'OR');
            }
        }

        if($courseOnline->price == "y" || $courseOnline->document_status == "y"){
            $userAllPayment = array();
            $criteriaCourseTemp = new CDbCriteria;
            $criteriaCourseTemp->compare("course_id",$_GET['course_id']);
            if($courseOnline->price == "y"){
                $criteriaCourseTemp->compare("status_payment","y");
            }
            if($courseOnline->document_status == "y"){
                $criteriaCourseTemp->compare("status_document","y");
            }
            $CourseTemp = CourseTemp::model()->findAll($criteriaCourseTemp);
            foreach ($CourseTemp as $keyCourseTemp => $valueCourseTemp) {
                $userAllPayment[] = $valueCourseTemp->user_id;
            }
            $criteria->addInCondition("user_id",$userAllPayment);

        }

        $criteria->compare("active",'y');
        $allUsersLogStartCourse = LogStartcourse::model()->findAll($criteria);


        foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {
            $percent = Helpers::lib()->percent_CourseGen($valueByUser->course_id,$valueByUser->gen_id,$valueByUser->user_id);
            if($percent == 100){
                $Passcours = Passcours::model()->find(array(
                    'order'=>'passcours_number DESC',
                    'condition' => 'passcours_cours=:passcours_cours AND passcours_user=:user_id AND gen_id=:gen_id',
                    'params' => array(':passcours_cours' => $valueByUser->course_id,':user_id'=>$valueByUser->user_id,':gen_id'=>$valueByUser->gen_id)
                ));
                $allUsersPassCourse[] =
                array(
                    "idCard"=>$valueByUser->pro->identification,
                    "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
                    "fName"=>$valueByUser->pro->firstname,
                    "lName"=>$valueByUser->pro->lastname,
                    "institutionName"=>$valueByUser->course->usercreate->institution->institution_name,
                    "courseTitle"=>$valueByUser->course->course_title,
                    "courseNumber"=>(!empty($Passcours)) ? $Passcours->passcours_number : "-",
                    "startDate"=>$valueByUser->start_date,
                    "endDate"=>(!empty($Passcours)) ? $Passcours->passcours_date : $valueByUser->end_date,
                    "note"=>"-"
                );
            }
        }
    }else if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != "" ){

        $allUsersPassCourse = array();

        if(isset($_GET['institution_id']) && $_GET['institution_id'] != "" && $_GET['institution_id'] != "all"){
            if($_GET['institution_id'] == "all"){
                $Institution = Institution::model()->findAll();
                $institution_array = [];
                foreach ($Institution as $keyInstitution => $valueInstitution) {
                    $institution_array[] = $valueInstitution->code;
                }
            }else{
                $institution_array = array($_GET['institution_id']);
            }

            $allUserAdminCreateCourse = array();
            $criteria = new CDbCriteria;
            $criteria->compare('superuser', 1);
            $criteria->addInCondition('institution_id', $institution_array);
            $UserAdmin = Users::model()->findAll($criteria);
            foreach ($UserAdmin as $keyUserAdmin => $valueUserAdmin) {
                $allUserAdminCreateCourse[] = $valueUserAdmin->id;
            }
            $criteria = new CDbCriteria;
            $criteria->addInCondition("create_by",$allUserAdminCreateCourse);
            $MsTeams = MsTeams::model()->findAll($criteria);

            $array_MsTeams = array();
            foreach ($MsTeams as $keyMsTeams => $valueMsTeams) {
                $array_MsTeams[] = $valueMsTeams->id;
            }

        }

        // ห้องเรียนออนไลน์
        $PasscoursLog = PasscoursLog::model()->find(array(
            'order'=>'pclog_number DESC',
            'condition' => 'cou_number=:course_codenum',
            'params' => array(':course_codenum' => $_GET['course_codenum'])
        ));

        if(!empty($PasscoursLog)){
            $criteria = new CDbCriteria;

            if(isset($_GET['idcard']) && $_GET['idcard'] != null){
                $criteria->compare('pro.identification',$_GET['idcard'],true);
            }

            if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
                $ex_fullname = explode(" ", $_GET['nameSearch']);

                if(isset($ex_fullname[0])){
                    $pro_fname = $ex_fullname[0];
                    $criteria->compare('pro.firstname_en', $pro_fname, true);
                    $criteria->compare('pro.lastname_en', $pro_fname, true, 'OR');
                    $criteria->compare('pro.firstname', $pro_fname, true, 'OR');
                    $criteria->compare('pro.lastname', $pro_fname, true, 'OR');
                }

                if(isset($ex_fullname[1])){
                    $pro_lname = $ex_fullname[1];
                    $criteria->compare('pro.lastname',$pro_lname,true);
                    $criteria->compare('pro.lastname_en', $pro_lname, true, 'OR');
                }
            }
            if(isset($array_MsTeams)){
                $criteria->addInCondition('ms_teams_id',$array_MsTeams);
            }else{
                $criteria->compare('ms_teams_id',$PasscoursLog->pclog_ms_teams);
            }

            $criteria->compare('user_id',$PasscoursLog->pclog_userid);
            $allUsersLogStartCourse = LogStartMsTeams::model()->findAll($criteria);

            foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {
                $percent = Helpers::lib()->percent_MsTeams($valueByUser->ms_teams_id,$valueByUser->gen_id,$valueByUser->user_id);
                if($percent == 100){
                    $allUsersPassCourse[] =
                    array(
                        "idCard"=>$valueByUser->pro->identification,
                        "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
                        "fName"=>$valueByUser->pro->firstname,
                        "lName"=>$valueByUser->pro->lastname,
                        "institutionName"=>$valueByUser->msteams->createby->institution->institution_name,
                        "courseTitle"=>$valueByUser->msteams->name_ms_teams,
                        "courseNumber"=>(!empty($PasscoursLog)) ? $PasscoursLog->cou_number : "-",
                        "startDate"=>$valueByUser->start_date,
                        "endDate"=>(isset($valueByUser->passcours_date)) ? $valueByUser->passcours_date : $valueByUser->create_date,
                        "note"=>"-"
                    );
                }
            }
        }
        // ห้องเรียนออนไลน์

        //Import pass MD
        $criteria = new CDbCriteria;
        $criteria->addInCondition("institution_id",$institution_array);
        if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
            $criteria->compare('course_number',$_GET['course_codenum'],true);
        }

        if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
            $ex_fullname = explode(" ", $_GET['nameSearch']);

            if(isset($ex_fullname[0])){
                $pro_fname = $ex_fullname[0];
                $criteria->compare('fname', $pro_fname, true);
                $criteria->compare('lname', $pro_fname, true, 'OR');
            }

            if(isset($ex_fullname[1])){
                $pro_lname = $ex_fullname[1];
                $criteria->compare('fname',$pro_lname,true);
                $criteria->compare('lname', $pro_lname, true, 'OR');
            }
        }

        if(isset($_GET['idcard']) && $_GET['idcard'] != null){
            $criteria->compare('idcard',$_GET['idcard'],true);
        }
        $PassCourseImport = ImportPassMd::model()->findAll($criteria);

        foreach ($PassCourseImport as $keyByUser => $valueByUser) {
            $allUsersPassCourse[] =
            array(
                "idCard"=>$valueByUser->idcard,
                "title"=>$valueByUser->title,
                "fName"=>$valueByUser->fname,
                "lName"=>$valueByUser->lname,
                "institutionName"=>$valueByUser->institution->institution_name,
                "courseTitle"=>$valueByUser->mtcodemd->name_md,
                "courseNumber"=>$valueByUser->course_number,
                "startDate"=>$valueByUser->startdate,
                "endDate"=>$valueByUser->enddate,
                "note"=>($valueByUser->note != nulll) ? $valueByUser->note : "-"
            );
        }
        //Import pass MD
    }
?>

<?php if(isset($allUsersPassCourse)){ ?>
    <div class="widget" id="export-table33" >
        <div class="widget-head">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>ค้นหาโดยใช้ หลักสูตร</h4>
            </div>
        </div> 
        <div class="widget-body" >
         <table class="table table-bordered table-striped" id="myTable">
            <thead>
                <tr>
                    <th  class="center" >ลำดับ</th>
                    <th  class="center" >เลขบัตรประชาชน</th>                            
                    <th  class="center" >คำนำหน้าชื่อ</th>
                    <th  class="center" >ชื่อ</th>
                    <th  class="center" >นามสกุล</th>
                    <th  class="center" >ชื่อสถาบันศึกษา</th>
                    <th  class="center" >ชื่อหลักสูตร</th>
                    <th  class="center" width="140">เลขที่ ปก.</th>
                    <th  class="center" width="150">ตั้งแต่วันที่</th>
                    <th  class="center" width="150">ถึงวันที่</th>
                    <th  class="center" width="100">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getPages = $_GET['page'];
                if($getPages = $_GET['page']!=0 ){
                    $getPages = $_GET['page'] -1;
                }

                $start_cnt = $dataProvider->pagination->pageSize * $getPages;

                if(count($allUsersPassCourse) > 0){
                    foreach($allUsersPassCourse as $i => $val) {
                    ?>
                        <tr>
                            <td ><?= $start_cnt+1?></td>
                            <td ><?= $val["idCard"] ?></td>
                            <td ><?= $val["title"] ?></td>
                            <td ><?= $val["fName"] ?></td>
                            <td ><?= $val["lName"] ?></td>
                            <td ><?= $val["institutionName"] ?></td>
                            <td ><?= $val["courseTitle"] ?></td>
                            <td ><?= $val["courseNumber"] ?></td>
                            <td ><?= Helpers::lib()->changeFormatDateNewEn($val["startDate"] ,'full')  ?></td>
                            <td ><?= Helpers::lib()->changeFormatDateNewEn($val["endDate"] ,'full')  ?></td>
                            <td ><?= $val["note"] ?></td>
                        </tr>
                        <?php
                        $start_cnt++;
                    }
                }
            ?>
        </tbody>
    </table>
</div>
<div class="widget-body">
    <br>
    <br>
    <br>

    <a href="<?= $this->createUrl('report/genExcelLearningPass',array(
    'institution_id'=>$_GET['institution_id'],
    'course_number'=>$_GET['course_number'],
    'idcard'=>$_GET['idcard'],
    'nameSearch'=>$_GET['nameSearch'],
    'datestr'=>$_GET['datestr'],
    'dateend'=>$_GET['dateend'],
    'search_year'=>$_GET['search_year'],
    'course_codenum'=>$_GET['course_codenum']
    )); ?>" 
    target="_blank">
    <!-- <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button></a> -->
</div>

</div>
<?php } ?>

<script type="text/javascript">
    $(document).ready( function () {
        $('#myTable').DataTable();
        GetList(<?=(($_GET["search_year"]!="") ? $_GET["search_year"] : "null")?>);
    } );
    $( "#course_codenum" ).change(function(event) {
        // if(event.target.value == null || event.target.value == ""){
        //     $('#msteamss').attr('required', 'required');
        // }else{
        //     $('#msteamss').removeAttr('required');
        // }
    });

    function GetList(year) {
        if(year === null){
            year = "";
        }
        var selected = "";
        <?php if (isset($_GET["ms_teams_id"]) && $_GET["ms_teams_id"] !="") { ?>
            selected = <?=$_GET["ms_teams_id"]?>;
        <?php } ?>

        <?php if (isset($_GET["course_id"]) && $_GET["course_id"] !="") { ?>
            selected = <?=$_GET["course_id"]?>;
        <?php } ?>
        
        var type = $("#type_cous").val();
        typeChange(type);
        if (type == 2) {
            $("#msteamss").html("<option value=''>กรุณารอสักครู่</option>");
        }else if(type == 1){
            $("#course_id").html("<option value=''>กรุณารอสักครู่</option>");
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/Report/GetList"); ?>',
            data: ({
                year: year,
                selected: selected,
                type:type
            }),
            success: function(data) {
                if(data != ""){
                    if (type == 2) {
                        $("#msteamss").html(data);
                    }else if(type == 1){
                        $("#course_id").html(data);
                    }
                }
            }
        });
    }

    function typeChange(value) {
        if(value == 1){
            $("#course_id").val("");
            $("#msteamss").val("");
            $(".div_search_year").show();
            $(".CouTest").show();
            $(".MsTest").hide();
            $("#course_id").prop('required',true);
            $("#msteamss").prop('required',false);

        }else if(value ==2){
            $("#course_id").val("");
            $("#msteamss").val("");
            $(".div_search_year").show();
            $(".CouTest").hide();
            $(".MsTest").show();
            $("#msteamss").prop('required',true);
            $("#course_id").prop('required',false);
        }else{
            $("#course_id").val("");
            $("#msteamss").val("");
            $(".div_search_year").hide();
            $(".CouTest").hide();
            $(".MsTest").hide();
            $("#msteamss").prop('required',false);
            $("#course_id").prop('required',false);
        }
    }

</script>

</div>
