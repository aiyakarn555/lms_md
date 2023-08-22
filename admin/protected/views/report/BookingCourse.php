
<?php
$title = 'รายงาน สถานะการจองหลักสูตร';
$currentModel = 'Report';

ob_start();

$this->breadcrumbs = array($title);

// Yii::app()->clientScript->registerScript('search', "
// 	$('#SearchFormAjax').submit(function(){
// 	    return true;
// 	});
// ");

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


        $("#type_cous").change(function(){
            var value = $("#type_cous option:selected").val();

            if(value == 1){
                $(".CouTest").show();
                $(".MsTest").hide();
                $(".GenTest").show();

            }else{
                $(".CouTest").hide();
                $(".MsTest").show();
                $(".GenTest").show();

            }
            
        });

        <?php if(isset($_GET['type_cou'])){ ?>
            var chk = "<?=$_GET['type_cou']?>";

             if(chk == 1){
                $(".CouTest").show();
                $(".MsTest").hide();
                $("#msteamss").val(null);
                $(".GenTest").show();

            }else{
                $(".CouTest").hide();
                $(".MsTest").show();
                $("#coursenumbers").val(null);
                $(".GenTest").show();
            }



        <?php } ?>
        
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
    $Booking = array(1=> 'ยังไม่ได้ดำเนินการชำระเงิน' ,2 =>'รอการอนุมัติจากผู้ดูแลระบบ' , 3 => 'ชำระเรียบร้อยแล้ว', 4 => 'ไม่ผ่านการอนุมัติ',5 => 'หลักสูตรฟรี'); // 1 = n , 2 = w , 3 = y , 4 = x ,5 = free
    $currentYear = (date("Y")+543);
    $year = array();
    for ($i=0; $i <= 10; $i++) {
        $year[(($currentYear)-$i) - 543] = $currentYear-$i;
    }

 ?>

 <div class="innerLR">
   <!--  <?php
    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'institution_id','type'=>'list','query'=>$listInstitution),
            array('name'=>'type_cou','type'=>'list','query'=>$arr),
            array('name'=>'course_id','type'=>'list','query'=>$listCourse),
            array('name'=>'ms_teams_id','type'=>'list','query'=>$listMs),
            array('name'=>'search','type'=>'text'),     
            array('name'=>'idcard','type'=>'text'),     
        ),
    ));
    ?> -->

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

            <div class="form-group CouTest" style="display: none">
                <dt><label>หลักสูตร <b style="color: red"> *</b> : </label></dt>
                <dd>
                    <select style="width: 500px;" class="form-select " aria-label="Default select example" id="coursenumbers" name="course_number">
                        <option value="">--- เลือกหลักสูตร ---</option>
                        <?php
                            if($modelCourse) {
                                foreach($modelCourse as $cous) {
                                    ?>
                                        <option <?= ( $_GET['course_number'] == $cous->course_id ? 'selected="selected"' : '' ) ?> value="<?= $cous->course_id ?>"><?= (( $cous->course_md_code != "" && $cous->course_md_code != null )?$cous->course_md_code: "ไม่พบรหัส")." : ".$cous->course_title ?></option>
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

           <div class="form-group CouTest" style="display: none">
                <dt><label>รหัสหลักสูตร : </label></dt>
                <dd>
                <input style="width: 500px;" name="coruse_code" type="text" class="form-control" placeholder="รหัสหลักสูตร" value="<?= $_GET['coruse_code'] ?>" > 
                </dd>
            </div> 


           <div class="form-group MsTest" style="display: none">
                <dt><label>ห้องเรียนออนไลน์ <b style="color: red"> *</b> : </label></dt>
                <dd>
                    <select style="width: 500px;" class="form-select " aria-label="Default select example" id="msteamss" name="ms_teams_id">
                        <option value="">--- เลือกห้องเรียนออนไลน์ ---</option>
                        <?php
                        if($modelMsTeams) {
                            foreach($modelMsTeams as $mss) {
                                ?>
                                <option <?= ( $_GET['ms_teams_id'] == $mss->id ? 'selected="selected"' : '' ) ?> value="<?= $mss->id ?>"><?=(( $mss->course_md_code != "" && $mss->course_md_code != null )?$mss->course_md_code: "ไม่พบรหัส")?> : <?= $mss->name_ms_teams ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="">ยังไม่มีห้องเรียนออนไลน์</option>
                            <?php
                        }
                        ?>
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
                <dt><label>วันที่เริ่ม : </label></dt>
                <dd>
                <input style="width: 500px;" id="Report_period_start" name="datestr" type="text" class="form-control" placeholder="วันที่เริ่ม" value="<?= $_GET['datestr'] ?>" > 
                </dd>
            </div> 

            <div class="form-group">
                <dt><label>วันที่จบ : </label></dt>
                <dd>
                <input style="width: 500px;" id="Report_period_end" name="dateend" type="text" class="form-control" placeholder="วันที่จบ" value="<?= $_GET['dateend'] ?>" > 
                </dd>
            </div> 

            <div class="form-group">
                <dt><label>สถานะการจอง  : </label></dt>
                <dd>
                    <select style="width: 500px;"  class="form-select " id="status_booking" aria-label="Default select example" name="status_booking">
                        <option value="">--- เลือกสถานะการจอง ---</option>
                        <?php
                                foreach($Booking as $keyss => $BB) {
                                    ?>
                                    <option <?= ( $_GET['status_booking'] == $keyss ? 'selected="selected"' : '' ) ?> value="<?= $keyss ?>"><?= $BB ?></option>
                                    <?php
                                }
                        ?>
                    </select>
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
    if(isset($_GET['type_cou']) && $_GET['type_cou'] != "" ){


        $criteria = new CDbCriteria;

        if($_GET['type_cou'] == 1){
            $criteria->with = array('profile', 'course');
        }else if($_GET['type_cou'] == 2){
            $criteria->with = array('profile', 'teams');
        }

        if (isset($_GET["gen_id"])) {
            $criteria->compare("t.gen_id",$_GET["gen_id"]);
        }

        if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
            $ex_fullname = explode(" ", $_GET['nameSearch']);
            if(isset($ex_fullname[0])){
                $pro_fname = $ex_fullname[0];
                if (!preg_match('/[^A-Za-z]/', $pro_fname))
                {
                    $criteria->compare('profile.firstname_en', $pro_fname, true);
                    $criteria->compare('profile.lastname_en', $pro_fname, true, 'OR');
                }else{
                    $criteria->compare('profile.firstname', $pro_fname, true);
                    $criteria->compare('profile.lastname', $pro_fname, true, 'OR');
                }    
            }

            if(isset($ex_fullname[1])){
                $pro_lname = $ex_fullname[1];
                if (!preg_match('/[^A-Za-z]/', $pro_lname))
                {
                    $criteria->compare('profile.lastname_en',$pro_lname,true);
                }else{
                    $criteria->compare('profile.lastname',$pro_lname,true);
                }    
            }
        }

        if(isset($_GET['idcard']) && $_GET['idcard'] != null){
            $criteria->compare('profile.identification',$_GET['idcard'],true);
        }

        if($_GET['type_cou'] == 1){

            if(isset($_GET['course_number']) && $_GET['course_number'] != null){
                $criteria->compare('courseonline.course_id',$_GET['course_number']);
            }

            if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
                $criteria->compare('courseonline.course_number',$_GET['course_codenum'],true);
            }

            if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

                // $criteria->addCondition('courseonline.course_date_start >= :date_str');
                // $criteria->params[':date_str'] = $_GET['datestr'];

                // $criteria->addCondition('courseonline.course_date_end <= :date_end');
                // $criteria->params[':date_end'] = $_GET['dateend'];
                $criteria->addCondition(  "DATE_FORMAT(courseonline.course_date_start, '%Y-%m-%d') >= '".$_GET['date_str']."'");
                $criteria->addCondition(  "DATE_FORMAT(courseonline.course_date_end, '%Y-%m-%d') <= '".$_GET['dateend']."'");

            }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){
                $criteria->addCondition(  "DATE_FORMAT(courseonline.course_date_start, '%Y-%m-%d') >= '".$_GET['date_str']."'");
                // $criteria->addCondition('courseonline.course_date_start >= :date_str');
                // $criteria->params[':date_str'] = $_GET['datestr'];

            }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){
                $criteria->addCondition(  "DATE_FORMAT(courseonline.course_date_end, '%Y-%m-%d') <= '".$_GET['dateend']."'");
                // $criteria->addCondition('courseonline.course_date_end <= :date_end');
                // $criteria->params[':date_end'] = $_GET['dateend'];
            }


            if(isset($_GET['status_booking']) && $_GET['status_booking'] != null){
                $sta = $_GET['status_booking']; // 1 = n , 2 = w , 3 = y , 4 = x
                if($sta == 1){
                    $criteria->compare('courseonline.price','y');
                    $criteria->compare('t.status_payment','n');
                    $criteria->addCondition('t.file_payment IS NULL');
                }else if($sta == 2){
                    $criteria->compare('courseonline.price','y');
                    $criteria->compare('t.status_payment','w');
                    // $criteria->addCondition('t.file_payment IS NOT NULL');
                }else if($sta == 3){
                    // $criteria->addCondition(  "t.status_payment = 'n' AND ");
                    $criteria->compare('t.status_payment','y');
                    // $criteria->addCondition('t.file_payment IS NOT NULL');
                }else if($sta == 4){
                    $criteria->compare('courseonline.price','y');
                    $criteria->compare('t.status_payment','x');
                    // $criteria->addCondition('t.file_payment IS NOT NULL');
                }else if($sta == 5){
                    $criteria->compare('courseonline.price','n');
                }
            }
            $Temp = CourseTemp::model()->findAll($criteria);

        }else if($_GET['type_cou'] == 2){
            $Temp = "";
            if(isset($_GET['ms_teams_id']) && $_GET['ms_teams_id'] != null){
                $criteria->compare('teams.id',$_GET['ms_teams_id']);
            }

            if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

                $criteria->addCondition('teams.start_date >= :date_str');
                $criteria->params[':date_str'] = $_GET['datestr'];

                $criteria->addCondition('teams.end_date <= :date_end');
                $criteria->params[':date_end'] = $_GET['dateend'];

            }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

                $criteria->addCondition('teams.start_date >= :date_str');
                $criteria->params[':date_str'] = $_GET['datestr'];

            }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

                $criteria->addCondition('teams.end_date <= :date_end');
                $criteria->params[':date_end'] = $_GET['dateend'];
            }


            if(isset($_GET['status_booking']) && $_GET['status_booking'] != null){
                $sta = $_GET['status_booking']; // 1 = n , 2 = w , 3 = y , 4 = x
                if($sta == 1){
                    $criteria->compare('teams.price','y');
                    $criteria->compare('t.status_payment','n');
                    $criteria->addCondition('t.file_payment IS NULL');
                }else if($sta == 2){
                    $criteria->compare('teams.price','y');
                    $criteria->compare('t.status_payment','w');
                    // $criteria->addCondition('t.file_payment IS NOT NULL');
                }else if($sta == 3){
                    $criteria->compare('teams.price','y');
                    $criteria->compare('t.status_payment','y');
                    // $criteria->addCondition('t.file_payment IS NOT NULL');
                }else if($sta == 4){
                    $criteria->compare('t.status_payment','x');
                    // $criteria->addCondition('t.file_payment IS NOT NULL');
                }else if($sta == 5){
                    $criteria->compare('teams.price','n');
                }
            }

            $Temp = MsteamsTemp::model()->findAll($criteria);
        }


    ?>

        <div class="widget" id="export-table33" >
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>ค้นหาโดยใช้ <?= ($_GET['type_cou'] == 1 ? "หลักสูตร" : "ห้องเรียนออนไลน์") ?></h4>
                </div>
            </div> 
            <div class="widget-body" >
                <table class="table table-bordered table-striped display" id="myTable"  style="width:100%">
                    <thead>
                        <tr>
                            <th class="center" >ลำดับ</th>
                            <?php if($_GET['type_cou'] == 1){ ?>
                                <th class="center" >รหัสหลักสูตร</th>
                            <?php } ?>
                            <th class="center" >เลขบัตรประชาชน</th>                            
                            <th class="center" >คำนำหน้าชื่อ</th>
                            <th class="center" >ชื่อ</th>
                            <th class="center" >นามสกุล</th>
                            <th class="center" >หลักสูตร</th>
                            <th class="center" width="150">วันที่เริ่ม</th>
                            <th class="center" width="150">วันที่จบ</th>
                            <th class="center" width="100">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }

                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;
                                foreach($Temp as $i => $val) {
                                    if($_GET['type_cou'] == 1){
                                        if($val->course->price == 'n'){
                                            $stus = "<b style='color:blue'>หลักสูตรฟรี</b>" ;
                                        }else{
                                            if($val->status_payment == "n" && $val->file_payment == null){
                                                $stus = "<b style='color:red'>ยังไม่ได้ดำเนินการชำระเงิน</b>"; 
                                             }else if($val->status_payment == "w"){
                                                $stus = "<b style='color:Orange'>รอการอนุมัติจากผู้ดูแลระบบ</b>" ;
                                             }else if($val->status_payment == "y"){
                                                $stus = "<b style='color:green'>ชำระเรียบร้อยแล้ว</b>" ;
                                             }else if($val->status_payment == "x"){
                                                 $stus = "<b style='color:red'>ไม่ผ่านการอนุมัติ</b>"; 
                                             }
                                        }
                                    }else{
                                        if($val->teams->price == 'n'){
                                            $stus = "<b style='color:blue'>หลักสูตรฟรี</b>" ;
                                        }else{
                                            if($val->status_payment == "n" && $val->file_payment == null){
                                                $stus = "<b style='color:red'>ยังไม่ได้ดำเนินการชำระเงิน</b>"; 
                                             }else if($val->status_payment == "w"){
                                                $stus = "<b style='color:Orange'>รอการอนุมัติจากผู้ดูแลระบบ</b>" ;
                                             }else if($val->status_payment == "y"){
                                                $stus = "<b style='color:green'>ชำระเรียบร้อยแล้ว</b>" ;
                                             }else if($val->status_payment == "x"){
                                                 $stus = "<b style='color:red'>ไม่ผ่านการอนุมัติ</b>"; 
                                             }
                                        }
                                    }
                                  
                                 ?>
                                    <tr>
                                        <td ><?= $start_cnt+1?></td>
                                        <?php if($_GET['type_cou'] == 1){ ?>
                                        <td ><?= $val->course->course_number ?></td>
                                        <?php } ?>

                                        <td ><?= $val->profile->identification ?></td>
                                        <td ><?= $val->profile->ProfilesTitle->prof_title ?></td>
                                        <td ><?= $val->profile->firstname ?></td>
                                        <td ><?= $val->profile->lastname ?></td>

                                        <?php if($_GET['type_cou'] == 1){ ?>
                                            <td ><?= $val->course->course_title ?></td>
                                            <td ><?= Helpers::lib()->changeFormatDateNewEn($val->course->course_date_start ,'full')  ?></td>
                                            <td ><?= Helpers::lib()->changeFormatDateNewEn($val->course->course_date_end ,'full')  ?></td>
                                        <?php }else if($_GET['type_cou'] == 2){ ?>
                                           <td ><?= $val->teams->name_ms_teams ?></td>
                                           <td ><?= Helpers::lib()->changeFormatDateNewEn($val->teams->start_date ,'full')  ?>
                                           </td>
                                           <td ><?= Helpers::lib()->changeFormatDateNewEn($val->teams->end_date ,'full')  ?>
                                           </td>
                                        <?php } ?>


                                        <td ><?=$stus?></td>
                                    </tr>
                                    <?php
                                    $start_cnt++;
                                }

                        ?>
                    </tbody>
                </table>
            </div>
            <div class="widget-body">
                <br>
                <br>
                <br>

                <a href="<?= $this->createUrl('report/genExcelBookingCourse',array(
                'type_cou'=>$_GET['type_cou'],
                'course_number'=>$_GET['course_number'],
                'coruse_code'=>$_GET['coruse_code'],
                'ms_teams_id'=>$_GET['ms_teams_id'],
                'idcard'=>$_GET['idcard'],
                'nameSearch'=>$_GET['nameSearch'],
                'datestr'=>$_GET['datestr'],
                'dateend'=>$_GET['dateend'],
                'status_booking'=>$_GET['status_booking']
                )); ?>" 
                target="_blank">
            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button></a>
            </div>

        </div>
        <?php 
        $this->widget('CLinkPager',array(
            'pages'=>$dataProvider->pagination
        )
    );
    ?>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>

       
    <?php } ?>

</div>
