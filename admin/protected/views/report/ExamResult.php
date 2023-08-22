<?php
$title = 'รายงาน ผลการสอบ';
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
<style type="text/css">
    .text-white{
        color: white;
    }
</style>
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
            // if(value == 1){
            //     $(".CouTest").show();
            //     $(".MsTest").hide();
            //     $("#coursenumbers").prop('required',true);
            //     $("#msteamss").prop('required',false);

            // }else{
            //     $(".CouTest").hide();
            //     $(".MsTest").show();
            //     $("#msteamss").prop('required',true);
            //     $("#coursenumbers").prop('required',false);

            // }
            
        });

        <?php if(isset($_GET['type_cou'])){ ?>
            var chk = "<?=$_GET['type_cou']?>";

             if(chk == 1){
                $(".CouTest").show();
                $(".MsTest").hide();
                $("#coursenumbers").prop('required',true);
                $("#msteamss").prop('required',false);
                $("#msteamss").val(null);

            }else{
                $(".CouTest").hide();
                $(".MsTest").show();
                $("#msteamss").prop('required',true);
                $("#coursenumbers").prop('required',false);
                $("#coursenumbers").val(null);
            }



        <?php } ?>

        <?php if(isset($_GET["course_codenum"]) && $_GET["course_codenum"] != ""){ ?>
            $("#msteamss").prop('required',false);
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

    $criteria = new CDbCriteria;
    $criteria->compare('active','y');
    $criteria->compare('lang_id','1');
    //แสดงตาม Group
    $modelUser = Users::model()->findByPk(Yii::app()->user->id);
    $group = json_decode($modelUser->group);
    if (!in_array(1, $group)){
        $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
        $criteria->addInCondition('create_by', $groupUser);    
    }
    $criteria->order = "create_date DESC";
    $modelCourse = CourseOnline::model()->findAll($criteria);
    $listCourse = CHtml::listData($modelCourse,'course_id','course_title');

    $criteria = new CDbCriteria;
    //แสดงตาม Group
    $modelUser = Users::model()->findByPk(Yii::app()->user->id);
    $group = json_decode($modelUser->group);
    if (!in_array(1, $group)){
        $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
        $criteria->addInCondition('create_by', $groupUser);    
    }
    $criteria->order = "create_date DESC";
    $modelMsTeams = MsTeams::model()->findAll($criteria);
    $listMs = CHtml::listData($modelMsTeams,'id','name_ms_teams');
    $arr = array(1=> 'เรียนรู้ด้วยตัวเอง' , 2 => 'เรียนรู้ทางไกล');


    $currentYear = (date("Y")+543);
    $year = array();
    for ($i=0; $i <= 10; $i++) {
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
                        <dt><label>สถาบัน <b style="color: red"> *</b> : </label></dt>
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

                   <!--  <div class="form-group">
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
                    </div> -->

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


                    <div class="form-group">
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
                            <select style="width: 500px;" class="form-select " aria-label="Default select example" id="coursenumbers" name="course_number">
                                <option value="">--- เลือกหลักสูตร ---</option>
                                <?php
                                if($modelCourse) {
                                    foreach($modelCourse as $cous) {
                                        ?>
                                        <option <?= ( $_GET['course_number'] == $cous->course_id ? 'selected="selected"' : '' ) ?> value="<?= $cous->course_id ?>"><?= $cous->course_title ?> (<?=(Helpers::lib()->DateThaiNewNoTime($cous->course_date_start)." - ".Helpers::lib()->DateThaiNewNoTime($cous->course_date_end))?>)</option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="">ยังไม่มีหลักสูตร</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </dd>
                    </div>

                    <div class="form-group MsTest">
                        <dt><label>ห้องเรียนออนไลน์ <b style="color: red"> *</b> : </label></dt>
                        <dd>
                            <select style="width: 500px;" class="form-select " aria-label="Default select example" required id="msteamss" name="ms_teams_id">
                                <option value="">--- เลือกห้องเรียนออนไลน์ ---</option>
                                <!-- <?php
                                if($modelMsTeams) {
                                    foreach($modelMsTeams as $mss) {
                                        ?>
                                        <option <?= ( $_GET['ms_teams_id'] == $mss->id ? 'selected="selected"' : '' ) ?> value="<?= $mss->id ?>"><?=(( $mss->course_md_code != "" && $mss->course_md_code != null )?$mss->course_md_code: "ไม่พบรหัส")?> : <?= $mss->name_ms_teams ?> (<?=(Helpers::lib()->DateThaiNewNoTime($mss->start_date)." - ".Helpers::lib()->DateThaiNewNoTime($mss->end_date))?>)</option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="">ยังไม่มีห้องเรียนออนไลน์</option>
                                    <?php
                                }
                                ?> -->
                            </select>
                        </dd>
                    </div>

                    <div class="form-group GenTest" style="display: none">
                        <dt><label>รุ่นหลักสูตร : </label></dt>
                        <dd>
                            <select style="width: 500px;" class="form-select " aria-label="Default select example" id="gen_id" name="gen_id">
                            <?php if( $_GET['course_number'] == null && $_GET['ms_teams_id'] == null  && $_GET['gen_id'] == null) { ?>
                                    <option value="">ทั้งหมด</option>
                                <?php }else{ ?>
                                    <?php 
                                        $criteria = new CDbCriteria;
                                        $criteria->compare("active","y");
                                        if($_GET['course_number'] != null){
                                            $criteria->compare("course_id",$_GET['course_number']);
                                        }else{
                                            $criteria->compare("course_id",$_GET['ms_teams_id']);
                                        }
                                        $criteria->order = 'create_date DESC';
                                        $generation = CourseGeneration::model()->findAll($criteria);
                                        if($generation){ ?>
                                            <option value="">--- เลือกรุ่นหลักสูตร ---</option>
                                        <?php foreach ($generation as $gen) { ?>
                                            <option <?= ($_GET['gen_id'] == $gen->gen_id ? 'selected="selected"' : '') ?> value="<?= $gen->gen_id ?>"><?= "รุ่น ".$gen->gen_title ?>&nbsp;&nbsp;&nbsp;(<?= Helpers::lib()->CuttimeLang($gen->gen_period_start, 2)." - ".Helpers::lib()->CuttimeLang($gen->gen_period_end, 2) ?>)</option>
                                                <?php     
                                            }    
                                        }else { ?>
                                            <option value=''>--- ไม่พบรุ่นหลักสูตร ---</option>
                                    <?php } ?>
                            <?php } ?>
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

            $allUsersScore = array();

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
            $criteria->with = array('pro','gen');
            $criteria->addInCondition("ms_teams_id",$array_MsTeams);
            if (isset($_GET["gen_id"])) {
                $criteria->compare("gen.gen_id",$_GET["gen_id"]);
            }

            if(isset($_GET['idcard']) && $_GET['idcard'] != null){
                $criteria->compare('pro.identification',$_GET['idcard'],true);
            }

            if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
                $ex_fullname = explode(" ", $_GET['nameSearch']);
                if(isset($ex_fullname[0])){
                    $pro_fname = $ex_fullname[0];
                    if (!preg_match('/[^A-Za-z]/', $pro_fname))
                    {
                        $criteria->compare('pro.firstname_en', $pro_fname, true);
                        $criteria->compare('pro.lastname_en', $pro_fname, true, 'OR');
                    }else{
                        $criteria->compare('pro.firstname', $pro_fname, true);
                        $criteria->compare('pro.lastname', $pro_fname, true, 'OR');
                    }    
                }
    
                if(isset($ex_fullname[1])){
                    $pro_lname = $ex_fullname[1];
                    if (!preg_match('/[^A-Za-z]/', $pro_lname))
                    {
                        $criteria->compare('pro.lastname_en',$pro_lname,true);
                    }else{
                        $criteria->compare('pro.lastname',$pro_lname,true);
                    }    
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

            if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){
                $criteria->addCondition(  "DATE_FORMAT(t.start_date, '%Y-%m-%d') >= '".$_GET['datestr']."'");
                $criteria->addCondition(  "DATE_FORMAT(t.end_date, '%Y-%m-%d') <= '".$_GET['dateend']."'");
            }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){
                $criteria->addCondition(  "DATE_FORMAT(t.start_date, '%Y-%m-%d') >= '".$_GET['datestr']."'");
    
            }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){
                $criteria->addCondition(  "DATE_FORMAT(t.end_date, '%Y-%m-%d') <= '".$_GET['dateend']."'");
            }

            
            $allUsersLogStartCourse = LogStartMsTeams::model()->findAll($criteria);
            $resultArr = [];
            foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {       
                $resultArr [] = $valueByUser;
            }
            uasort($resultArr, function($a, $b) { return $a['id'] <=> $b['id']; });
            $result = array_column($resultArr, null, 'user_id');
            $result = array_filter($result, function($v) { return !empty($v['user_id']); });
    
            usort($result, function($a, $b) {
                return $a['id'] - $b['id'];
            });
    
            $allUsersLogStartCourse = $result;

            foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {
                
                $criteria = new CDbCriteria;
                $criteria->with = array('manages');
                $criteria->compare("manage.active","y");
                $criteria->compare("lessonteams.active","y");
                $criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
                $criteria->compare("lang_id","1");
                $criteria->order = "lesson_no ASC";
                $LessonMs = LessonMsTeams::model()->findAll($criteria);

                $allUsersScore[$keyByUser] = array(
                    "idCard"=>$valueByUser->pro->identification,
                    "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
                    "fName"=>$valueByUser->pro->firstname,
                    "lName"=>$valueByUser->pro->lastname,
                    "institutionName"=>$valueByUser->msteams->createby->institution->institution_name,
                    "courseTitle"=>$valueByUser->msteams->name_ms_teams,
                    "lessonScorePre"=>array(),
                    "lessonTotalPre"=>array(),
                    "lessonStatusPre"=>array(),
                    "lessonScorePost"=>array(),
                    "lessonTotalPost"=>array(),
                    "lessonStatusPost"=>array(),
                );
                if($LessonMs){
                    foreach ($LessonMs as $keyLessonMs => $valueLessonMs) {
                        if(count($valueLessonMs->manages) > 0){
                            foreach($valueLessonMs->manages as $manage){
                                if($manage->type == 'pre'){
                                    //preTest
                                    $criteria = new CDbCriteria;
                                    $criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
                                    $criteria->compare("lesson_teams_id",$valueLessonMs->id);
                                    $criteria->compare("user_id",$valueByUser->user_id);
                                    $criteria->compare("gen_id",$valueByUser->gen_id);
                                    $criteria->compare("type",'pre');
                                    $criteria->compare("active","y");
                                    $criteria->order = "score_id DESC";
                                    $ScoreMsPre = ScoreMsTeams::model()->find($criteria);

                                    $allUsersScore[$keyByUser]["lessonScorePre"][] = ($ScoreMsPre) ? $ScoreMsPre->score_number : "-";
                                    $allUsersScore[$keyByUser]["lessonTotalPre"][] = ($ScoreMsPre) ? $ScoreMsPre->score_total : "-";
                                    $allUsersScore[$keyByUser]["lessonStatusPre"][] = ($ScoreMsPre) ? $ScoreMsPre->score_past : "-";
                                    //preTes
                                }
                                if($manage->type == 'post'){
                                    //postTest
                                    $criteria = new CDbCriteria;
                                    $criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
                                    $criteria->compare("lesson_teams_id",$valueLessonMs->id);
                                    $criteria->compare("user_id",$valueByUser->user_id);
                                    $criteria->compare("gen_id",$valueByUser->gen_id);
                                    $criteria->compare("type",'post');
                                    $criteria->compare("active","y");
                                    $criteria->order = "score_id DESC";
                                    $ScoreMsPost = ScoreMsTeams::model()->find($criteria);
                                    $allUsersScore[$keyByUser]["lessonScorePost"][] = ($ScoreMsPost) ? $ScoreMsPost->score_number : "-";
                                    $allUsersScore[$keyByUser]["lessonTotalPost"][] = ($ScoreMsPost) ? $ScoreMsPost->score_total : "-";
                                    $allUsersScore[$keyByUser]["lessonStatusPost"][] = ($ScoreMsPre) ? $ScoreMsPre->score_past : "-";
                                    //postTest
                                }
                            }
                        }
                    }
                }
            }
           


            // ห้องเรียนออนไลน์


            // Import Pass MD
            // $criteria = new CDbCriteria;
            // $criteria->addInCondition("institution_id",$institution_array);
            // $criteria->compare("course_md_id",$MsTeam->course_md_code);

            // if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
            //     $ex_fullname = explode(" ", $_GET['nameSearch']);

            //     if(isset($ex_fullname[0])){
            //         $pro_fname = $ex_fullname[0];
            //         $criteria->compare('fname', $pro_fname, true);
            //         $criteria->compare('lname', $pro_fname, true, 'OR');
            //     }

            //     if(isset($ex_fullname[1])){
            //         $pro_lname = $ex_fullname[1];
            //         $criteria->compare('fname',$pro_lname,true);
            //         $criteria->compare('lname', $pro_lname, true, 'OR');
            //     }
            // }

            // if(isset($_GET['idcard']) && $_GET['idcard'] != null){
            //     $criteria->compare('idcard',$_GET['idcard'],true);
            // }

            // if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
            //     $criteria->compare('course_number',$_GET['course_codenum'],true);
            // }

            // // if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

            // //     $criteria->addCondition('startdate >= :date_str');
            // //     $criteria->params[':date_str'] = $_GET['datestr'];

            // //     $criteria->addCondition('enddate <= :date_end');
            // //     $criteria->params[':date_end'] = $_GET['dateend'];

            // // }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

            // //     $criteria->addCondition('startdate >= :date_str');
            // //     $criteria->params[':date_str'] = $_GET['datestr'];

            // // }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

            // //     $criteria->addCondition('enddate <= :date_end');
            // //     $criteria->params[':date_end'] = $_GET['dateend'];
            // // }

            // $PassCourseImport = ImportPassMd::model()->findAll($criteria);
            // foreach ($PassCourseImport as $keyByUser => $valueByUser) {
            //     $allUsersPassCourse[] =
            //         array(
            //             "idCard"=>$valueByUser->idcard,
            //             "title"=>$valueByUser->title,
            //             "fName"=>$valueByUser->fname,
            //             "lName"=>$valueByUser->lname,
            //             "institutionName"=>$valueByUser->institution->institution_name,
            //             "courseTitle"=>$valueByUser->mtcodemd->name_md,
            //             "courseNumber"=>$valueByUser->course_number,
            //             "startDate"=>$valueByUser->startdate,
            //             "endDate"=>$valueByUser->enddate,
            //             "note"=>($valueByUser->note != nulll) ? $valueByUser->note : "-"
            //         );
            // }

            // Import Pass MD
        }
    // }else if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != "" ){

    //     $allUsersPassCourse = array();

    //     if(isset($_GET['institution_id']) && $_GET['institution_id'] != "" && $_GET['institution_id'] != "all"){
    //         if($_GET['institution_id'] == "all"){
    //             $Institution = Institution::model()->findAll();
    //             $institution_array = [];
    //             foreach ($Institution as $keyInstitution => $valueInstitution) {
    //                 $institution_array[] = $valueInstitution->code;
    //             }
    //         }else{
    //             $institution_array = array($_GET['institution_id']);
    //         }

    //         $allUserAdminCreateCourse = array();
    //         $criteria = new CDbCriteria;
    //         $criteria->compare('superuser', 1);
    //         $criteria->addInCondition('institution_id', $institution_array);
    //         $UserAdmin = Users::model()->findAll($criteria);
    //         foreach ($UserAdmin as $keyUserAdmin => $valueUserAdmin) {
    //             $allUserAdminCreateCourse[] = $valueUserAdmin->id;
    //         }
    //         $criteria = new CDbCriteria;
    //         $criteria->addInCondition("create_by",$allUserAdminCreateCourse);
    //         $MsTeams = MsTeams::model()->findAll($criteria);

    //         $array_MsTeams = array();
    //         foreach ($MsTeams as $keyMsTeams => $valueMsTeams) {
    //             $array_MsTeams[] = $valueMsTeams->id;
    //         }

    //     }

    //     // ห้องเรียนออนไลน์
    //     $PasscoursLog = PasscoursLog::model()->find(array(
    //         'order'=>'pclog_number DESC',
    //         'condition' => 'cou_number=:course_codenum',
    //         'params' => array(':course_codenum' => $_GET['course_codenum'])
    //     ));

    //     if(!empty($PasscoursLog)){
    //         $criteria = new CDbCriteria;
    //         $criteria->with = array('pro');

    //         if(isset($_GET['idcard']) && $_GET['idcard'] != null){
    //             $criteria->compare('pro.identification',$_GET['idcard'],true);
    //         }

    //         if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
    //             $ex_fullname = explode(" ", $_GET['nameSearch']);
    //             if(isset($ex_fullname[0])){
    //                 $pro_fname = $ex_fullname[0];
    //                 if (!preg_match('/[^A-Za-z]/', $pro_fname))
    //                 {
    //                     $criteria->compare('pro.firstname_en', $pro_fname, true);
    //                     $criteria->compare('pro.lastname_en', $pro_fname, true, 'OR');
    //                 }else{
    //                     $criteria->compare('pro.firstname', $pro_fname, true);
    //                     $criteria->compare('pro.lastname', $pro_fname, true, 'OR');
    //                 }    
    //             }
    
    //             if(isset($ex_fullname[1])){
    //                 $pro_lname = $ex_fullname[1];
    //                 if (!preg_match('/[^A-Za-z]/', $pro_lname))
    //                 {
    //                     $criteria->compare('pro.lastname_en',$pro_lname,true);
    //                 }else{
    //                     $criteria->compare('pro.lastname',$pro_lname,true);
    //                 }    
    //             }
    //         }
    //         if(isset($array_MsTeams)){
    //             $criteria->addInCondition('ms_teams_id',$array_MsTeams);
    //         }else{
    //             $criteria->compare('ms_teams_id',$PasscoursLog->pclog_ms_teams);
    //         }

    //         $criteria->compare('t.user_id',$PasscoursLog->pclog_userid);
    //         $allUsersLogStartCourse = LogStartMsTeams::model()->findAll($criteria);

    //         foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {
    //             $criteria = new CDbCriteria;
    //             $criteria->with = array('manages');
    //             $criteria->compare("manage.active","y");
    //             $criteria->compare("lessonteams.active","y");
    //             $criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
    //             $criteria->compare("lang_id","1");
    //             $criteria->order = "lesson_no ASC";
    //             $LessonMs = LessonMsTeams::model()->findAll($criteria);

    //             $allUsersScore[$keyByUser] = array(
    //                 "idCard"=>$valueByUser->pro->identification,
    //                 "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
    //                 "fName"=>$valueByUser->pro->firstname,
    //                 "lName"=>$valueByUser->pro->lastname,
    //                 "institutionName"=>$valueByUser->msteams->createby->institution->institution_name,
    //                 "courseTitle"=>$valueByUser->msteams->name_ms_teams,
    //                 "lessonScorePre"=>array(),
    //                 "lessonTotalPre"=>array(),
    //                 "lessonStatusPre"=>array(),
    //                 "lessonScorePost"=>array(),
    //                 "lessonTotalPost"=>array(),
    //                 "lessonStatusPost"=>array(),
    //             );
                
    //             if($LessonMs){
    //                 foreach ($LessonMs as $keyLessonMs => $valueLessonMs) {
    //                     if(count($valueLesson->manages) > 0){
    //                         foreach($valueLesson->manages as $manage){
    //                             if($manage->type == 'pre'){
    //                                 //preTest
    //                                 $criteria = new CDbCriteria;
    //                                 $criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
    //                                 $criteria->compare("lesson_teams_id",$valueLessonMs->id);
    //                                 $criteria->compare("user_id",$valueByUser->user_id);
    //                                 $criteria->compare("gen_id",$valueByUser->gen_id);
    //                                 $criteria->compare("type",'pre');
    //                                 $criteria->compare("active","y");
    //                                 $criteria->order = "score_id DESC";
    //                                 $ScoreMsPre = ScoreMsTeams::model()->find($criteria);

    //                                 $allUsersScore[$keyByUser]["lessonScorePre"][] = ($ScoreMsPre) ? $ScoreMsPre->score_number : "-";
    //                                 $allUsersScore[$keyByUser]["lessonTotalPre"][] = ($ScoreMsPre) ? $ScoreMsPre->score_total : "-";
    //                                 $allUsersScore[$keyByUser]["lessonStatusPre"][] = ($ScoreMsPre) ? $ScoreMsPre->score_past : "-";
    //                                 //preTes
    //                             }else if($manage->type == 'post'){
    //                                 //postTest
    //                                 $criteria = new CDbCriteria;
    //                                 $criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
    //                                 $criteria->compare("lesson_teams_id",$valueLessonMs->id);
    //                                 $criteria->compare("user_id",$valueByUser->user_id);
    //                                 $criteria->compare("gen_id",$valueByUser->gen_id);
    //                                 $criteria->compare("type",'post');
    //                                 $criteria->compare("active","y");
    //                                 $criteria->order = "score_id DESC";
    //                                 $ScoreMsPost = ScoreMsTeams::model()->find($criteria);
    //                                 $allUsersScore[$keyByUser]["lessonScorePost"][] = ($ScoreMsPost) ? $ScoreMsPost->score_number : "-";
    //                                 $allUsersScore[$keyByUser]["lessonTotalPost"][] = ($ScoreMsPost) ? $ScoreMsPost->score_total : "-";
    //                                 $allUsersScore[$keyByUser]["lessonStatusPost"][] = ($ScoreMsPre) ? $ScoreMsPre->score_past : "-";
    //                                 //postTest
    //                             }
    //                         }
    //                     }
    //                 }
    //             }else{
    //                 unset($allUsersScore[$keyByUser]);
    //             }
    //         }
    //     }
    //     // ห้องเรียนออนไลน์

    //     //Import pass MD
    //     // $criteria = new CDbCriteria;
    //     // $criteria->addInCondition("institution_id",$institution_array);
    //     // if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
    //     //     $criteria->compare('course_number',$_GET['course_codenum'],true);
    //     // }

    //     // if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
    //     //     $ex_fullname = explode(" ", $_GET['nameSearch']);

    //     //     if(isset($ex_fullname[0])){
    //     //         $pro_fname = $ex_fullname[0];
    //     //         $criteria->compare('fname', $pro_fname, true);
    //     //         $criteria->compare('lname', $pro_fname, true, 'OR');
    //     //     }

    //     //     if(isset($ex_fullname[1])){
    //     //         $pro_lname = $ex_fullname[1];
    //     //         $criteria->compare('fname',$pro_lname,true);
    //     //         $criteria->compare('lname', $pro_lname, true, 'OR');
    //     //     }
    //     // }

    //     // if(isset($_GET['idcard']) && $_GET['idcard'] != null){
    //     //     $criteria->compare('idcard',$_GET['idcard'],true);
    //     // }
    //     // $PassCourseImport = ImportPassMd::model()->findAll($criteria);

    //     // foreach ($PassCourseImport as $keyByUser => $valueByUser) {
    //     //     $allUsersPassCourse[] =
    //     //     array(
    //     //         "idCard"=>$valueByUser->idcard,
    //     //         "title"=>$valueByUser->title,
    //     //         "fName"=>$valueByUser->fname,
    //     //         "lName"=>$valueByUser->lname,
    //     //         "institutionName"=>$valueByUser->institution->institution_name,
    //     //         "courseTitle"=>$valueByUser->mtcodemd->name_md,
    //     //         "courseNumber"=>$valueByUser->course_number,
    //     //         "startDate"=>$valueByUser->startdate,
    //     //         "endDate"=>$valueByUser->enddate,
    //     //         "note"=>($valueByUser->note != nulll) ? $valueByUser->note : "-"
    //     //     );
    //     // }
    //     //Import pass MD
    }else if($_GET["course_number"] != null && $_GET["course_number"] != ""){
        $allUsersScore = array();
        $course_id = $_GET['course_number'];
        $criteria = new CDbCriteria;
        $criteria->compare("course_id",$course_id);
        $courseOnline = CourseOnline::model()->find($criteria);

        $criteria = new CDbCriteria;
        $criteria->with = array('pro','course','gen');
        $criteria->compare("t.course_id",$course_id);

        if (isset($_GET["gen_id"])) {
            $criteria->compare("gen.gen_id",$_GET["gen_id"]);
        }

        if(isset($_GET['idcard']) && $_GET['idcard'] != null){
            $criteria->compare('pro.identification',$_GET['idcard'],true);
        }
        if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
            $ex_fullname = explode(" ", $_GET['nameSearch']);
            if(isset($ex_fullname[0])){
                $pro_fname = $ex_fullname[0];
                if (!preg_match('/[^A-Za-z]/', $pro_fname))
                {
                    $criteria->compare('pro.firstname_en', $pro_fname, true);
                    $criteria->compare('pro.lastname_en', $pro_fname, true, 'OR');
                }else{
                    $criteria->compare('pro.firstname', $pro_fname, true);
                    $criteria->compare('pro.lastname', $pro_fname, true, 'OR');
                }    
            }

            if(isset($ex_fullname[1])){
                $pro_lname = $ex_fullname[1];
                if (!preg_match('/[^A-Za-z]/', $pro_lname))
                {
                    $criteria->compare('pro.lastname_en',$pro_lname,true);
                }else{
                    $criteria->compare('pro.lastname',$pro_lname,true);
                }    
            }
        }

        // if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){
        //     $criteria->addCondition(  "DATE_FORMAT(t.start_date, '%Y-%m-%d') = '".$_GET['datestr']."'");
        // }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){
        //     $criteria->addCondition(  "DATE_FORMAT(t.start_date, '%Y-%m-%d') = '".$_GET['datestr']."'");
        // }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){
            
        // }

        if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){
            $criteria->addCondition(  "DATE_FORMAT(t.start_date, '%Y-%m-%d') >= '".$_GET['datestr']."'");
            $criteria->addCondition(  "DATE_FORMAT(t.end_date, '%Y-%m-%d') <= '".$_GET['dateend']."'");
        }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){
            $criteria->addCondition(  "DATE_FORMAT(t.start_date, '%Y-%m-%d') >= '".$_GET['datestr']."'");

        }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){
            $criteria->addCondition(  "DATE_FORMAT(t.end_date, '%Y-%m-%d') <= '".$_GET['dateend']."'");
        }



        if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != ""){
            $criteria->compare("courseonline.course_number",$_GET['course_codenum']);
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
            $criteria->addInCondition("t.user_id",$userAllPayment);
        }
        $criteria->compare("t.active",'y');
        $allUsersLogStartCourse = LogStartcourse::model()->findAll($criteria);
        $resultArr = [];
        foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {       
            $resultArr [] = $valueByUser;
        }
        uasort($resultArr, function($a, $b) { return $a['id'] <=> $b['id']; });
        $result = array_column($resultArr, null, 'user_id');
        $result = array_filter($result, function($v) { return !empty($v['user_id']); });

        usort($result, function($a, $b) {
            return $a['id'] - $b['id'];
        });

        $allUsersLogStartCourse = $result;
        foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {  
            if($_GET['institution_id'] != "all" && $_GET['institution_id'] == $valueByUser->course->usercreate->institution->id){
                $allUsersScore[$keyByUser] = array(
                    "id"=>$keyByUser+1,
                    "userId"=>$valueByUser->pro->user_id,
                    "idCard"=>$valueByUser->pro->identification,
                    "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
                    "fName"=>$valueByUser->pro->firstname,
                    "lName"=>$valueByUser->pro->lastname,
                    "institutionName"=>$valueByUser->course->usercreate->institution->institution_name,
                    "courseTitle"=>$valueByUser->course->course_title,
                    "lessonScorePre"=>array(),
                    "lessonTotalPre"=>array(),
                    "lessonStatusPre"=>array(),
                    "lessonScorePost"=>array(),
                    "lessonTotalPost"=>array(),
                    "lessonStatusPost"=>array(),
                    "courseScorePre"=>array(),
                    "courseTotalPre"=>array(),
                    "courseStatusPre"=>array(),
                    "courseScorePost"=>array(),
                    "courseTotalPost"=>array(),
                    "courseStatusPost"=>array(),
                );
    
                $courseManage = Coursemanage::Model()->findAll("id=:course_id AND active=:active ", array(
                    "course_id"=>$valueByUser->course_id, "active"=>"y"
                ));
                if(count($courseManage) > 0){
                    $checkCourse = true;
                    foreach ($courseManage as $keyCourseManage=> $valueCourseManage) {
                            if($valueCourseManage->type == 'pre'){
                                //preTest
                                $criteria = new CDbCriteria;
                                $criteria->compare("course_id",$valueByUser->course_id);
                                $criteria->compare("user_id",$valueByUser->user_id);
                                $criteria->compare("gen_id",$valueByUser->gen_id);
                                $criteria->compare("type",'pre');
                                $criteria->compare("active","y");
                                $criteria->order = "score_id DESC";
                                $ScorePre = Coursescore::model()->find($criteria);
                                $allUsersScore[$keyByUser]["courseScorePre"] = ($ScorePre) ? $ScorePre->score_number : "-";
                                $allUsersScore[$keyByUser]["courseTotalPre"] = ($ScorePre) ? $ScorePre->score_total : "-";
                                $allUsersScore[$keyByUser]["courseStatusPre"] = ($ScorePre) ? $ScorePre->score_past : "-";
                                //preTest
                            }else if($valueCourseManage->type == 'course'){
                                //postTest
                                    $criteria = new CDbCriteria;
                                    $criteria->compare("course_id",$valueByUser->course_id);
                                    $criteria->compare("user_id",$valueByUser->user_id);
                                    $criteria->compare("gen_id",$valueByUser->gen_id);
                                    $criteria->compare("type",'post');
                                    $criteria->compare("active","y");
                                    $criteria->order = "score_id DESC";
                                    $ScorePost = Coursescore::model()->find($criteria);
                                    $allUsersScore[$keyByUser]["courseScorePost"] = ($ScorePost) ? $ScorePost->score_number : "-";
                                    $allUsersScore[$keyByUser]["courseTotalPost"] = ($ScorePost) ? $ScorePost->score_total : "-";
                                    $allUsersScore[$keyByUser]["courseStatusPost"] = ($ScorePost) ? $ScorePost->score_past : "-";
                                // postTest
                            }
                    }
                }
    
                $criteria = new CDbCriteria;
                $criteria->compare("lesson.active","y");
                $criteria->compare("course_id",$valueByUser->course_id);
                $criteria->compare("lang_id","1");
                $criteria->order = "lesson_no ASC";
                $Lesson = Lesson::model()->findAll($criteria);
                if(count($Lesson) > 0){
                    $checkLesson = true;
                    foreach ($Lesson as $keyLesson => $valueLesson) {
                        $manages = Manage::Model()->findAll("id=:id AND active=:active ", array(
                            "id"=>$valueLesson->id, "active"=>"y"
                        ));
                        if(count($manages) > 0){
                            foreach($manages as $manage){
                                if($manage->type == 'pre'){
                                    //preTest
                                    $criteria = new CDbCriteria;
                                    $criteria->compare("course_id",$valueByUser->course_id);
                                    $criteria->compare("lesson_id",$valueLesson->id);
                                    $criteria->compare("user_id",$valueByUser->user_id);
                                    $criteria->compare("gen_id",$valueByUser->gen_id);
                                    $criteria->compare("type",'pre');
                                    $criteria->compare("active","y");
                                    $criteria->order = "score_id DESC";
                                    $ScorePre = Score::model()->find($criteria);
                                    $allUsersScore[$keyByUser]["lessonScorePre"][] = ($ScorePre) ? $ScorePre->score_number : "-";
                                    $allUsersScore[$keyByUser]["lessonTotalPre"][] = ($ScorePre) ? $ScorePre->score_total : "-";
                                    $allUsersScore[$keyByUser]["lessonStatusPre"][] = ($ScorePre) ? $ScorePre->score_past : "-";
                                    //preTest
                                }else if($manage->type == 'post'){
                                    //postTest
                                     $criteria = new CDbCriteria;
                                     $criteria->compare("course_id",$valueByUser->course_id);
                                     $criteria->compare("lesson_id",$valueLesson->id);
                                     $criteria->compare("user_id",$valueByUser->user_id);
                                     $criteria->compare("gen_id",$valueByUser->gen_id);
                                     $criteria->compare("type",'post');
                                     $criteria->compare("active","y");
                                     $criteria->order = "score_id DESC";
                                     $ScorePost = Score::model()->find($criteria);
                                     $allUsersScore[$keyByUser]["lessonScorePost"][] = ($ScorePost) ? $ScorePost->score_number : "-";
                                     $allUsersScore[$keyByUser]["lessonTotalPost"][] = ($ScorePost) ? $ScorePost->score_total : "-";
                                     $allUsersScore[$keyByUser]["lessonStatusPost"][] = ($ScorePost) ? $ScorePost->score_past : "-";
                                
                                    // postTest
                                }
                            }
                        }
                    }
                }
            }else if($_GET['institution_id'] == "all" ){
                $allUsersScore[$keyByUser] = array(
                    "id"=>$keyByUser+1,
                    "userId"=>$valueByUser->pro->user_id,
                    "idCard"=>$valueByUser->pro->identification,
                    "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
                    "fName"=>$valueByUser->pro->firstname,
                    "lName"=>$valueByUser->pro->lastname,
                    "institutionName"=>$valueByUser->course->usercreate->institution->institution_name,
                    "courseTitle"=>$valueByUser->course->course_title,
                    "lessonScorePre"=>array(),
                    "lessonTotalPre"=>array(),
                    "lessonStatusPre"=>array(),
                    "lessonScorePost"=>array(),
                    "lessonTotalPost"=>array(),
                    "lessonStatusPost"=>array(),
                    "courseScorePre"=>array(),
                    "courseTotalPre"=>array(),
                    "courseStatusPre"=>array(),
                    "courseScorePost"=>array(),
                    "courseTotalPost"=>array(),
                    "courseStatusPost"=>array(),
                );
    
                $courseManage = Coursemanage::Model()->findAll("id=:course_id AND active=:active ", array(
                    "course_id"=>$valueByUser->course_id, "active"=>"y"
                ));
                if(count($courseManage) > 0){
                    $checkCourse = true;
                    foreach ($courseManage as $keyCourseManage=> $valueCourseManage) {
                            if($valueCourseManage->type == 'pre'){
                                //preTest
                                $criteria = new CDbCriteria;
                                $criteria->compare("course_id",$valueByUser->course_id);
                                $criteria->compare("user_id",$valueByUser->user_id);
                                $criteria->compare("gen_id",$valueByUser->gen_id);
                                $criteria->compare("type",'pre');
                                $criteria->compare("active","y");
                                $criteria->order = "score_id DESC";
                                $ScorePre = Coursescore::model()->find($criteria);
                                $allUsersScore[$keyByUser]["courseScorePre"] = ($ScorePre) ? $ScorePre->score_number : "-";
                                $allUsersScore[$keyByUser]["courseTotalPre"] = ($ScorePre) ? $ScorePre->score_total : "-";
                                $allUsersScore[$keyByUser]["courseStatusPre"] = ($ScorePre) ? $ScorePre->score_past : "-";
                                //preTest
                            }else if($valueCourseManage->type == 'course'){
                                //postTest
                                    $criteria = new CDbCriteria;
                                    $criteria->compare("course_id",$valueByUser->course_id);
                                    $criteria->compare("user_id",$valueByUser->user_id);
                                    $criteria->compare("gen_id",$valueByUser->gen_id);
                                    $criteria->compare("type",'post');
                                    $criteria->compare("active","y");
                                    $criteria->order = "score_id DESC";
                                    $ScorePost = Coursescore::model()->find($criteria);
                                    $allUsersScore[$keyByUser]["courseScorePost"] = ($ScorePost) ? $ScorePost->score_number : "-";
                                    $allUsersScore[$keyByUser]["courseTotalPost"] = ($ScorePost) ? $ScorePost->score_total : "-";
                                    $allUsersScore[$keyByUser]["courseStatusPost"] = ($ScorePost) ? $ScorePost->score_past : "-";
                                // postTest
                            }
                    }
                }
    
                $criteria = new CDbCriteria;
                $criteria->compare("lesson.active","y");
                $criteria->compare("course_id",$valueByUser->course_id);
                $criteria->compare("lang_id","1");
                $criteria->order = "lesson_no ASC";
                $Lesson = Lesson::model()->findAll($criteria);
                if(count($Lesson) > 0){
                    $checkLesson = true;
                    foreach ($Lesson as $keyLesson => $valueLesson) {
                        $manages = Manage::Model()->findAll("id=:id AND active=:active ", array(
                            "id"=>$valueLesson->id, "active"=>"y"
                        ));
                        if(count($manages) > 0){
                            foreach($manages as $manage){
                                if($manage->type == 'pre'){
                                    //preTest
                                    $criteria = new CDbCriteria;
                                    $criteria->compare("course_id",$valueByUser->course_id);
                                    $criteria->compare("lesson_id",$valueLesson->id);
                                    $criteria->compare("user_id",$valueByUser->user_id);
                                    $criteria->compare("gen_id",$valueByUser->gen_id);
                                    $criteria->compare("type",'pre');
                                    $criteria->compare("active","y");
                                    $criteria->order = "score_id DESC";
                                    $ScorePre = Score::model()->find($criteria);
                                    $allUsersScore[$keyByUser]["lessonScorePre"][] = ($ScorePre) ? $ScorePre->score_number : "-";
                                    $allUsersScore[$keyByUser]["lessonTotalPre"][] = ($ScorePre) ? $ScorePre->score_total : "-";
                                    $allUsersScore[$keyByUser]["lessonStatusPre"][] = ($ScorePre) ? $ScorePre->score_past : "-";
                                    //preTest
                                }else if($manage->type == 'post'){
                                    //postTest
                                     $criteria = new CDbCriteria;
                                     $criteria->compare("course_id",$valueByUser->course_id);
                                     $criteria->compare("lesson_id",$valueLesson->id);
                                     $criteria->compare("user_id",$valueByUser->user_id);
                                     $criteria->compare("gen_id",$valueByUser->gen_id);
                                     $criteria->compare("type",'post');
                                     $criteria->compare("active","y");
                                     $criteria->order = "score_id DESC";
                                     $ScorePost = Score::model()->find($criteria);
                                     $allUsersScore[$keyByUser]["lessonScorePost"][] = ($ScorePost) ? $ScorePost->score_number : "-";
                                     $allUsersScore[$keyByUser]["lessonTotalPost"][] = ($ScorePost) ? $ScorePost->score_total : "-";
                                     $allUsersScore[$keyByUser]["lessonStatusPost"][] = ($ScorePost) ? $ScorePost->score_past : "-";
                                
                                    // postTest
                                }
                            }
                        }
                    }
                }
            }
         
        }
        foreach($allUsersScore as $key => $value){
			if(!$value["userId"]){
				unset($allUsersScore[$key]);
			}
		}
    }
?>

<?php if(count($allUsersScore) > 0){?>
  
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
                    <th class="center text-white" rowspan="2" >ลำดับ</th>
                    <th class="center text-white" rowspan="2" >เลขบัตรประชาชน</th>                            
                    <th class="center text-white" rowspan="2" >คำนำหน้าชื่อ</th>
                    <th class="center text-white" rowspan="2" >ชื่อ</th>
                    <th class="center text-white" rowspan="2" >นามสกุล</th>
                    <th class="center text-white" rowspan="2" >ชื่อสถาบันศึกษา</th>
                    <th class="center text-white" rowspan="2" >ชื่อหลักสูตร</th>
                    <?php if ($_GET['ms_teams_id'] == "") { ?>
                            <th class="center text-white" rowspan="2" >ก่อนเรียน</th>
                            <th class="center text-white" rowspan="2" >หลังเรียน</th>
                     <?php } ?>


                    <?php 
                    if(count($Lesson) > 0 ){
                        $LessonMs = $Lesson;
                    }
                    foreach ($LessonMs as $keyLessonMs => $valueLessonMs) { ?>
                        <th class="center text-white" colspan="2"><?= ($keyLessonMs+1).".".$valueLessonMs->title ?></th>
                    <?php } ?>
                </tr>
                <tr>
                <?php foreach ($LessonMs as $keyLessonMs => $valueLessonMs) { ?>
                     <th class="center text-white" rowspan="2" >ก่อนเรียน</th>
                     <th class="center text-white" rowspan="2" >หลังเรียน</th>
                 <?php } ?>
                   
                </tr>
         </thead>
            <tbody>
                <?php
                $getPages = $_GET['page'];
                if($getPages = $_GET['page']!=0 ){
                    $getPages = $_GET['page'] -1;
                }

                $start_cnt = $dataProvider->pagination->pageSize * $getPages;

                if(isset($allUsersScore) && count($allUsersScore) > 0){
                    foreach($allUsersScore as $i => $val) {
                    ?>
                        <tr>
                            <td ><?= $start_cnt+1?></td>
                            <td ><?= $val["idCard"] ?></td>
                            <td ><?= $val["title"] ?></td>
                            <td ><?= $val["fName"] ?></td>
                            <td ><?= $val["lName"] ?></td>
                            <td ><?= $val["institutionName"] ?></td>
                            <td ><?= $val["courseTitle"] ?></td>
                            
                            <?php 
                                if($_GET['ms_teams_id'] == ""){
                                    $statusPre = ($val["courseStatusPre"]=="y") ? "text-success":"text-danger" ;
                                    $statusPost = ($val["courseStatusPost"]=="y") ? "text-success":"text-danger" ;  ?>
                                      <td class="center" >
                                        <b><span class="<?=$statusPre?>"><?= count($val["courseScorePre"]) > 0 ? $val["courseScorePre"] :"-"  ?></span>
                                        /
                                        <?= count($val["courseTotalPre"]) > 0 ? $val["courseTotalPre"] :"-" ?></b>
                                    </td>
                                    <td class="center" >
                                            <b><span class="<?=$statusPost?>"><?= count($val["courseScorePost"]) > 0 ? $val["courseScorePost"] :"-"  ?></span>
                                        /
                                        <?= count($val["courseTotalPost"]) > 0 ? $val["courseTotalPost"] :"-" ?></b>
                                    </td>
                              <?php  } ?>
                          

                              
                            <?php 
                                if(count($Lesson) > 0 ){
                                    $LessonMs = $Lesson;
                                }
                            
                                foreach ($LessonMs as $keyLessonMs => $valueLessonMs) { ?>
                                <?php 
                                $statusPre = ($val["lessonStatusPre"][$keyLessonMs]=="y") ? "text-success":"text-danger" ;
                                $statusPost = ($val["lessonStatusPost"][$keyLessonMs]=="y") ? "text-success":"text-danger" ;
                                ?>
                                    <td class="center" >
                                        <?php if (count($val["lessonScorePre"][$keyLessonMs]) > 0 ) { ?>
                                                <b><span class="<?=$statusPre?>"><?= isset($val["lessonScorePre"][$keyLessonMs]) ? $val["lessonScorePre"][$keyLessonMs] :"-"  ?></span>
                                                /
                                                <?= isset($val["lessonTotalPre"][$keyLessonMs]) ? $val["lessonTotalPre"][$keyLessonMs] :"-" ?></b>
                                        <?php } else { ?>
                                                    <b> <span class="text-danger">-</span> / -</b>
                                        <?php } ?>
                                    </td>
                                            
                                    <td class="center" >
                                        <?php if (count($val["lessonScorePost"][$keyLessonMs]) > 0 ) { ?>
                                            <b><span class="<?=$statusPost?>"><?= isset($val["lessonScorePost"][$keyLessonMs]) ? $val["lessonScorePost"][$keyLessonMs] :"-"  ?></span>
                                        /
                                        <?= isset($val["lessonTotalPost"][$keyLessonMs]) ? $val["lessonTotalPost"][$keyLessonMs] :"-"  ?></b>
                                        <?php }else{ ?> 
                                                    <b> <span class="text-danger">-</span> / -</b>
                                        <?php }?>
                                    </td>
                            <?php } ?>
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
<?php }else{ ?>

<?php } ?>

<script type="text/javascript">
    $(document).ready( function () {
        <?php if (isset($allUsersScore) && count($allUsersScore) == 0) { ?>
                swal("หลักสูตรนี้ไม่มีข้อสอบ", "", "warning");
        <?php }?>
        // console.log(allScore);
        $(".div_search_year").hide();
        try{
            // $('#myTable').DataTable();
        }catch(error){
            console.log(error);
        }
        // GetListMsTeams(<?=(($_GET["search_year"]!="") ? $_GET["search_year"] : "null")?>,<?=(($_GET["ms_teams_id"]!="") ? $_GET["ms_teams_id"] : "null")?>);
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

        <?php if (isset($_GET["course_number"]) && $_GET["course_number"] !="") { ?>
            selected = <?=$_GET["course_number"]?>;
        <?php } ?>
        
        var type = $("#type_cous").val();
        typeChange(type);
        if (type == 2) {
            $("#msteamss").html("<option value=''>กรุณารอสักครู่</option>");
        }else if(type == 1){
            $("#coursenumbers").html("<option value=''>กรุณารอสักครู่</option>");
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
                        $("#gen_id").html("<option value=''>--- เลือกรุ่นหลักสูตร ---</option>");
                    }else if(type == 1){
                        $("#coursenumbers").html(data);
                        $("#gen_id").html("<option value=''>--- เลือกรุ่นหลักสูตร ---</option>");
                    }
                    if(selected != ""){
                        getGeneration(selected);
                    }
           
                }
            }
        });
    }

    function typeChange(value) {
        if(value == 1){
            $("#coursenumbers").val("");
            $("#msteamss").val("");
            $(".div_search_year").show();
            $(".CouTest").show();
            $(".MsTest").hide();
            $("#coursenumbers").prop('required',true);
            $("#msteamss").prop('required',false);
            $(".GenTest").show();

        }else if(value ==2){
            $("#coursenumbers").val("");
            $("#msteamss").val("");
            $(".div_search_year").show();
            $(".CouTest").hide();
            $(".MsTest").show();
            $("#msteamss").prop('required',true);
            $("#coursenumbers").prop('required',false);
            $(".GenTest").show();
        }else{
            $("#coursenumbers").val("");
            $("#msteamss").val("");
            $(".div_search_year").hide();
            $(".CouTest").hide();
            $(".MsTest").hide();
            $("#msteamss").prop('required',false);
            $("#coursenumbers").prop('required',false);
            $(".GenTest").hide();
        }
    }


    function getGeneration (id){
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/Report/GetGeneration"); ?>',
            data: ({
                course_id: id,
            }),
            success: function(data) {
                if(data != ""){
                    $("#gen_id").html(data);
                    <?php if($_GET["gen_id"] != ""){ ?>
                        $("#gen_id").val(<?=$_GET["gen_id"] ?>).change();
                    <?php } ?>
                }
            }
        });
    }
    $('#msteamss').on('change', function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/Report/GetGeneration"); ?>',
            data: ({
                course_id: this.value,
            }),
            success: function(data) {
                if(data != ""){
                    $("#gen_id").html(data);
                }
            }
        });
    });

    $('#coursenumbers').on('change', function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/Report/GetGeneration"); ?>',
            data: ({
                course_id: this.value,
            }),
            success: function(data) {
                if(data != ""){
                    $("#gen_id").html(data);
                }
            }
        });
    });


    // function GetListMsTeams(value,selected) {
    //     if(value === null){
    //         value = "";
    //     }
    //     if(selected === null){
    //         selected = "";
    //     }
    //     $("#msteamss").html("<option value=''>กรุณารอสักครู่</option>");
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?php echo Yii::app()->createAbsoluteUrl("/Report/GetListMsTeams"); ?>',
    //         data: ({
    //             value: value,
    //             selected: selected,
    //         }),
    //         success: function(data) {
    //             if(data != ""){
    //                 $("#msteamss").html(data);
    //             }
    //         }
    //     });
    // }
</script>

</div>
