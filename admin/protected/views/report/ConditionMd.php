
<?php
$title = 'รายงานเงื่อนไขตามประกาศกรมเจ้าท่า';
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
                onSelect: function(selected) {
                  $("#Report_period_end").datepicker("option","minDate", selected)
              }
          });
        $("#Report_period_end").datepicker({            
                onSelect: function(selected) {
                 $("#Report_period_start").datepicker("option","maxDate", selected)
             }
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

            if(value == 1){
                $(".CouTest").show();
                $(".MsTest").hide();
                $("#coursenumbers").prop('required',true);
                $("#msteamss").prop('required',false);
                $(".GenTest").show();

            }else{
                $(".CouTest").hide();
                $(".MsTest").show();
                $("#msteamss").prop('required',true);
                $("#coursenumbers").prop('required',false);
                $(".GenTest").show();

            }
            
        });

        <?php if(isset($_GET['type_cou'])){ ?>
            var chk = "<?=$_GET['type_cou']?>";

             if(chk == 1){
                $(".CouTest").show();
                $(".MsTest").hide();
                $("#coursenumbers").prop('required',true);
                $("#msteamss").prop('required',false);
                $("#msteamss").val(null);
                $(".GenTest").show();

            }else{
                $(".CouTest").hide();
                $(".MsTest").show();
                $("#msteamss").prop('required',true);
                $("#coursenumbers").prop('required',false);
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
                <dt><label>สถานบัน <b style="color: red"> *</b> : </label></dt>
                <dd>
                    <select required="" style="width: 500px;" class="form-select " aria-label="Default select example" name="institution_id">
                        <option value="">--- เลือกสถานบัน ---</option>
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
                    <dt></dt>
                    <dd><button type="submit" class="btn btn-primary btn-icon glyphicons search"><i></i> Search</button></dd>
                </div>
            </dl>
        </div>
    <?php $this->endWidget(); ?>
    </div>

</div>


    <?php
    if((isset($_GET['type_cou']) && $_GET['type_cou'] != "") && (isset($_GET['institution_id']) && $_GET['institution_id'] != "") ){

        $course_online = CourseOnline::model()->findByPk($_GET["course_number"]);
        $ms_teams = MsTeams::model()->findByPk($_GET["ms_teams_id"]);

        if($_GET['institution_id'] == 7){

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
                $criteria->compare('profile.firstname_en', $pro_fname, true);
                $criteria->compare('profile.lastname_en', $pro_fname, true, 'OR');
                $criteria->compare('profile.firstname', $pro_fname, true, 'OR');
                $criteria->compare('profile.lastname', $pro_fname, true, 'OR');
            }

            if(isset($ex_fullname[1])){
                $pro_lname = $ex_fullname[1];
                $criteria->compare('profile.lastname',$pro_lname,true);
                $criteria->compare('profile.lastname_en', $pro_lname, true, 'OR');
            }
        }

        if(isset($_GET['idcard']) && $_GET['idcard'] != null){
            $criteria->compare('profile.identification',$_GET['idcard'],true);
        }

        $criteria->compare('t.status','y');

        if($_GET['type_cou'] == 1){
            if(isset($_GET['course_number']) && $_GET['course_number'] != null){
                $criteria->compare('t.course_id',$_GET['course_number']);
            }
            $Temp = CourseTemp::model()->findAll($criteria);
        }else if($_GET['type_cou'] == 2){

            if(isset($_GET['ms_teams_id']) && $_GET['ms_teams_id'] != null){
                $criteria->compare('t.ms_teams_id',$_GET['ms_teams_id']);
            }

            $Temp = MsteamsTemp::model()->findAll($criteria);
        }
    }else{
        $cou_id = $course_online->course_md_code;
        $ms_id = $ms_teams->course_md_code;

        $criteria = new CDbCriteria;
        if($_GET['type_cou'] == 1){
            $criteria->compare('course_md_id',$cou_id);

        }else if($_GET['type_cou'] == 2){
            $criteria->compare('course_md_id',$ms_id);
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

        if(isset($_GET['institution_id']) && $_GET['institution_id'] != null){
            $criteria->compare('institution_id',$_GET['institution_id']);
        }

        $TempImport = ImportConditionMd::model()->findAll($criteria);

    }


    ?>

        <div class="widget" id="export-table33" >
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>ค้นหาโดยใช้ <?= ($_GET['type_cou'] == 1 ? "หลักสูตร" : "ห้องเรียนออนไลน์") ?></h4>
                </div>
            </div> 
            <div class="widget-body" >
                <table class="table table-bordered table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th class="center">ลำดับ</th>
                            <th class="center">เลขบัตรประชาชน</th>                            
                            <th class="center">คำนำหน้าชื่อ</th>
                            <th class="center">ชื่อ</th>
                            <th class="center">นามสกุล</th>
                            <th class="center">ชื่อสถาบันศึกษา</th>
                            <th class="center">ชื่อหลักสูตร</th>
                            <th class="center" width="150">วันที่เริ่ม (คศ)</th>
                            <th class="center" width="150">วันสุดท้าย (คศ)</th>
                            <th class="center" width="100">ชื่อผู้สอน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }

                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;

                            if($_GET['institution_id'] == 7){
                                foreach($Temp as $i => $val) { ?>
                                    <tr>
                                        <td class="center"><?= $start_cnt+1?></td>
                                        <td class="center"><?= $val->profile->identification ?></td>
                                        <td class="center"><?= $val->profile->ProfilesTitle->prof_title ?></td>
                                        <td class="center"><?= $val->profile->firstname ?></td>
                                        <td class="center"><?= $val->profile->lastname ?></td>
                                        <td class="center">โรงเรียนสุภาพบุรุษเดินเรือ</td>

                                        <?php  if($_GET['type_cou'] == 1){ ?>
                                            <td class="center"><?= $val->course->course_title ?></td>
                                            <td class="center"><?= Helpers::lib()->changeFormatDateNewEn($val->course->course_date_start ,'full')  ?></td>
                                            <td class="center"><?= Helpers::lib()->changeFormatDateNewEn($val->course->course_date_end ,'full')  ?></td>
                                            <td class="center"><?= $val->course->instructor_name ?></td>
                                        <?php }else if($_GET['type_cou'] == 2){ ?>
                                            <td class="center"><?= $val->teams->name_ms_teams ?></td>
                                            <td class="center"><?= Helpers::lib()->changeFormatDateNewEn($val->teams->start_date ,'full') ?></td>
                                            <td class="center"><?= Helpers::lib()->changeFormatDateNewEn($val->teams->end_date ,'full') ?></td>
                                            <td class="center"><?= $val->teams->instructor_name ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $start_cnt++;
                                }
                            }else{

                                foreach($TempImport as $ii => $value) { 

                                   $couOn = CourseOnline::model()->find(array(
                                    'condition' => 'course_md_code="' . $value->course_md_id . '"',
                                ));

                                   $MsOn = MsTeams::model()->find(array(
                                    'condition' => 'course_md_code="' . $value->course_md_id . '"',
                                ));

                                   $InsOn = Institution::model()->find(array(
                                    'condition' => 'code="' . $value->institution_id . '"',
                                ));
                                    ?>
                                    <tr>
                                        <td class="center"><?= $start_cnt+1?></td>
                                        <td class="center"><?= $value->idcard ?></td>
                                        <td class="center"><?= $value->title ?></td>
                                        <td class="center"><?= $value->fname ?></td>
                                        <td class="center"><?= $value->lname ?></td>
                                        <td class="center"><?= $InsOn->institution_name ?></td>

                                        <?php  if($_GET['type_cou'] == 1){ ?>
                                            <td class="center"><?= $couOn->course_title ?></td>
                                            <td class="center"><?= Helpers::lib()->changeFormatDateNewEn($couOn->course_date_start ,'full')  ?></td>
                                            <td class="center"><?= Helpers::lib()->changeFormatDateNewEn($couOn->course_date_end ,'full')  ?></td>
                                            <td class="center"><?= $couOn->instructor_name ?></td>
                                        <?php }else if($_GET['type_cou'] == 2){ ?>

                                            <td class="center"><?= $MsOn->name_ms_teams ?></td>
                                            <td class="center"><?= Helpers::lib()->changeFormatDateNewEn($MsOn->start_date ,'full') ?></td>
                                            <td class="center"><?= Helpers::lib()->changeFormatDateNewEn($MsOn->end_date ,'full') ?></td>
                                            <td class="center"><?= $MsOn->instructor_name ?></td>
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
                <a href="<?= $this->createUrl('report/genExcelConditionMd',array(
                'institution_id'=>$_GET['institution_id'],
                'type_cou'=>$_GET['type_cou'],
                'course_number'=>$_GET['course_number'],
                'ms_teams_id'=>$_GET['ms_teams_id'],
                'idcard'=>$_GET['idcard'],
                'nameSearch'=>$_GET['nameSearch']
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
