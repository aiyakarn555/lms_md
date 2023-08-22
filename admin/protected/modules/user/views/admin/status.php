<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>

<style>
    th {
        background-color: #E25F39;
        color: white;
    }
     .chosen-with-drop .chosen-drop{
    z-index:1000!important;
    position:static!important;
}
</style>
<?php
$titleName = 'รายงานสถานะของสมาชิก';
$formNameModel = 'Report';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');
	$('#Report_dateRang').daterangepicker();

EOD
, CClientScript::POS_READY);
?>

<script>
    $(document).ready(function(){
        
        $(".chosen").chosen();

        $("#ReportUser_date_start").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
              $("#ReportUser_date_end").datepicker("option","minDate", selected)
            }
        });
        $("#ReportUser_date_end").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
               $("#ReportUser_date_start").datepicker("option","maxDate", selected)
            }
        }); 
        $("#ReportUser_date_start_lastuse").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
              $("#ReportUser_date_end_lastuse").datepicker("option","minDate", selected)
            }
        });
        $("#ReportUser_date_end_lastuse").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
               $("#ReportUser_date_start_lastuse").datepicker("option","maxDate", selected)
            }
        }); 
});
</script>

<div class="innerLR">

    <?php
    /**  */
    $type_user[1] = 'บุคคลทั่วไป';
    $type_user[2] = 'พนักงาน';

    $divisiondata = Division::model()->getDivisionListNew(); 
    $departmentdata = Department::model()->getDepartmentListNew();
    $stationdata = Station::model()->getStationList();


    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            // array('name'=>'generation','type'=>'list','query'=>$model->getGenerationList()),
            // array('name'=>'identification','type'=>'text'),
            //array('name'=>'type_user','type'=>'list','query'=>$type_user),
            array('name' => 'employee_type', 'type' => 'list', 'query' => $model->getTypeEmployeeList()),
            array('name'=>'nameSearch','type'=>'text'),
            array('name'=>'status','type'=>'list','query'=>$model->getStatusUser()),
            array('name'=>'status_login','type'=>'list','query'=>$model->getStatusLogin()),

            // array('name'=>'type_user','type'=>'list','query'=>$model->getTypeuserList()),
            // array('name'=>'occupation','type'=>'list','query'=>$model->getOccupationList()),
            // array('name'=>'email','type'=>'text'),
            //array('name'=>'division_id','type'=>'listMultiple','query'=>$divisiondata),
          //  array('name'=>'department','type'=>'listMultiple','query'=>$departmentdata),
           // array('name'=>'station','type'=>'listMultiple','query'=>$stationdata),

            array('name'=>'date_start','type'=>'text'),
            array('name'=>'date_end','type'=>'text'),
            array('name'=>'date_start_lastuse','type'=>'text'),
            array('name'=>'date_end_lastuse','type'=>'text'),
            //array('name'=>'course_point','type'=>'text'),
        ),
    ));?>
    <?php
    if((($model->date_start != '') && ($model->date_end != '')) || (($model->date_start_lastuse != '') && ($model->date_end_lastuse != '')) || ($model->generation != '') || ($model->identification != '') || ($model->nameSearch != '') || ($model->department != '') || ($model->occupation != '') || ($model->email != '') || ($model->status_login != '') || (isset($model->employee_type))){
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id 
        WHERE del_status = 0 AND tbl_users.superuser = 0 ";//INNER JOIN tbl_type_user ON tbl_type_user.id = tbl_users.department_id 
            if(($model->date_start != '') && ($model->date_end != '')){
                $startDate = date("Y-m-d H:i:s", strtotime($model->date_start));
                $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
                    if($startDate == $endDate){
                        $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
                    }
                $sqlUser .= " AND tbl_users.create_at between '".$startDate."' and '".$endDate."' ";
                
            }
            if(($model->date_start_lastuse != '') && ($model->date_end_lastuse != '')){
                $startDate = date("Y-m-d H:i:s", strtotime($model->date_start_lastuse));
                $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end_lastuse));
                    if($startDate == $endDate){
                        $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end_lastuse));
                    }
                $sqlUser .= " AND tbl_users.lastvisit_at between '".$startDate."' and '".$endDate."' ";
                
            }
            // if($model->generation !='') {
            //     $sqlUser .= " AND tbl_profiles.generation = '".$model->generation."' ";      
            // }
            if($model->status !='') {
                $sqlUser .= " AND tbl_users.status = '".$model->status."' ";      
            }

            //type_user
            // if($model->type_user !='') {
            //     if($model->type_user == 1){ //General
            //         $sqlUser .= " AND tbl_users.type_register != '3' ";
            //     }else if($model->type_user == 2){ //Staff
            //         $sqlUser .= " AND tbl_users.type_register = '3' ";

            //     }
            //     // $sqlUser .= " AND tbl_profiles.type_user LIKE '".$model->type_user."' ";
            // }
            if ($model->employee_type != ''){
                $sqlUser .= " AND tbl_profiles.type_employee = " . $model->employee_type;
            }
            // if($model->department !='') {
            //     $sqlUser .= " AND tbl_users.department_id = '".$model->department."' ";   
            // }
            // if($model->occupation !='') {
            //     $sqlUser .= " AND tbl_profiles.occupation LIKE '".$model->occupation."' ";
                
            // }
            if($model->nameSearch !='') {
                $search = explode(" ",$model->nameSearch);
                foreach ($search as $key => $searchText) {
                    $sqlUser .= " AND (tbl_profiles.firstname_en LIKE '%". trim($searchText) ."%' OR tbl_profiles.lastname_en LIKE '%" . trim($searchText) . "%')";
                }
            }
            if($model->email !='') {
                $sqlUser .= " AND tbl_users.email LIKE '%".$model->email."%' ";
            }
            if($model->identification !='') {
                $sqlUser .= " AND tbl_profiles.identification LIKE '%".$model->identification."%' ";
            }
            if($model->status_login !='') {
                if($model->status_login == 0){
                    $sqlUser .= " AND tbl_users.lastvisit_at = 0";
                } else {
                    $sqlUser .= " AND tbl_users.lastvisit_at > 0";
                }
            }

            //Divsion
            if(!empty($model->division_id)){
                $divisionInarray =  implode(",",$model->division_id);
                $sqlUser .= " and tbl_users.division_id IN ( ".$divisionInarray." )";
            }
            //Department
            if(!empty($model->department)){
                $departmentInarray =  implode(",",$model->department);
                $sqlUser .= " and tbl_users.department_id IN ( ".$departmentInarray." )";
            }
            //Station
            // if(!empty($model->station)){
            //     $stationInarray =  implode(",",$model->station);
            //     $sqlUser .= " and tbl_users.station_id IN ( ".$stationInarray." )";
            // }
             // $sqlUser .= " ORDER BY tbl_profiles.type_employee DESC, tbl_profiles.firstname_en ASC";
            $sqlUser .= " ORDER BY tbl_profiles.firstname_en ASC";

        // $item_count = Yii::app()->db->createCommand($sqlUser)->queryScalar();

            // var_dump($sqlUser);
        $modelAll = Yii::app()->db->createCommand($sqlUser)->queryAll();
        $dataProvider=new CArrayDataProvider($modelAll, array(
                'pagination'=>array(
                  'pageSize'=>25
                ),
          ));
        $model = $dataProvider->getData();
        $model2 = $modelAll;
        $this->widget('CLinkPager',array(
            'pages'=>$dataProvider->pagination)
        );
        // $user = Yii::app()->db->createCommand($sqlUser)->queryAll();
        if (!empty($model)) {
            ?>
<div class="div-table">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> รายชื่อสมาชิก
            </h4>
        </div>
        <div class="widget-body" style=" overflow-x: scroll;">
            <!-- Table -->
            <table class="table table-bordered table-striped">
                <!-- Table heading -->
                <thead>
                <tr>
                    <th class="center">Number</th>
                    <th class="center">Employee Type</th>
                    <th class="center">Name - Surname</th>
                    <!-- <th class="center">บัตรประชาชน</th> -->
                    <!-- <th class="center">เบอร์</th> -->
                    <th class="center">Department</th>
                    <th class="center">Position</th>
                    <!--<th class="center">ฝ่าย</th>-->
                    <th class="center">Phone number</th>
                    <th class="center">Email</th>
                    <th class="center">Status</th>
                    <!-- <th class="center">ประเภทสมาชิก</th> -->
                    <!-- <th class="center">จังหวัด</th> -->
                    <!-- <th class="center">รุ่น</th> -->
                    <th class="center">Date of Register</th>
                    <th class="center">Last Login Date</th>
                </tr>
                </thead>
                <!-- // Table heading END -->
                <!-- Table body -->
                <tbody>
            <?php 
            $i = 1;
                foreach ($model as $key => $userItem) {
                    if($userItem[sex] == 'Male'){
                        $sex = 'ชาย';
                    } else if($userItem[sex] == 'Female'){
                        $sex = 'หญิง';
                    }

                    if($userItem[status]==0){
                        $status = "ระงับการใช้งาน";
                    }else{
                        $status = "เปิดการใช้งาน";
                    }
                    $type = TypeUser::model()->findByPk($userItem[type_user]);
                    $typeemployee = Profile::model()->findByPk($userItem['user_id']);
                    if ($typeemployee['type_employee'] == 1){
                        $typeemp = "Ship Staff";
                    }
                    if ($typeemployee['type_employee'] == 2){
                        $typeemp = "Office Staff";
                    }
                    $Dep = Department::model()->findByPk($userItem['department_id']);
                    $Pos = Position::model()->findByPk($userItem['position_id']);
                    //$Div = Division::model()->findByPk($userItem['division_id']);
                    if ($typeemployee['type_employee'] != ""){
            ?>
                <!-- Table row -->
                <tr>
                    <td class="center"><?= $i ?></td>
                    <td class="center"><?= $typeemp ?></td>
                    <td class="center"><?= $userItem[firstname_en] . " " . $userItem[lastname_en] ?></td>
                    <td class="center"><?= ($Dep->dep_title) ? $Dep->dep_title : '-'; ?></td>
                    <td class="center"><?= ($Pos->position_title) ? $Pos->position_title : '-'; ?></td>
                    <td class="center"><?= $userItem[tel] ?></td>

                    <!-- <td class="center"><?= $userItem[identification] ?></td> -->
                    <td class="center"><?= $userItem[email] ?></td>
                    <!-- <td class="center"><?= $type->name ?></td> -->
                    
                    <!-- <td class="center"><?= Province::getNameProvince($userItem[province]) ?></td> -->
                    <!-- <td class="center"><?= Generation::getNameGen($userItem[generation]) ?></td> -->
                    <td class="center"><?= $status ?></td>
                    <td class="center"><?= Helpers::changeFormatDate($userItem[create_at],'datetime'); ?></td>

                    <?php 
                    if ($userItem[lastvisit_at] == 0) {
                        $lastvisit_at = 'ยังไม่เข้าสู่ระบบ';
                    } else {
                        $lastvisit_at = $userItem[lastvisit_at];
                    }
                    ?>
                    <td class="center"><?= ($lastvisit_at == 'ยังไม่เข้าสู่ระบบ') ? $lastvisit_at : Helpers::changeFormatDate($lastvisit_at,'datetime'); ?></td>
                </tr>
                <!-- // Table row END -->
            <?php
            $i++;
                }}
            ?>
                </tbody>
            <!-- // Table body END -->
            </table>
            <!-- // Table END -->
        </div>      
    </div>
</div>

<!--<div class="div-table2 hidden">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> รายชื่อสมาชิก
            </h4>
        </div>
        <div class="widget-body">
             Table 
            <table class="table table-bordered table-striped">
                 Table heading 
                <thead>
                <tr>
                    <th class="center">ลำดับ</th>
                    <th class="center">ชื่อ</th>
                    <th class="center">นามสกุล</th>
                    <th class="center">บัตรประชาชน</th>
                    <th class="center">เบอร์</th>
                    <th class="center">อีเมล</th>
                    <th class="center">ประเภทสมาชิก</th>
                    <th class="center">จังหวัด</th>
                    <th class="center">รุ่น</th>
                    <th class="center">วันที่สมัคร</th>
                    <th class="center">สถานะ</th>
                    <th class="center">วันที่ใช้งาน</th>
                </tr>
                </thead>
                 // Table heading END 
                 Table body 
                <tbody>
            <?php 
            $i = 1;
                foreach ($model2 as $key => $userItem) {
                    if($userItem[sex] == 'Male'){
                        $sex = 'ชาย';
                    } else if($userItem[sex] == 'Female'){
                        $sex = 'หญิง';
                    }

                    if($userItem[status]==0){
                        $status = "ระงับการใช้งาน";
                    }else{
                        $status = "เปิดการใช้งาน";
                    }
            ?>
                 Table row 
                <tr>
                    <td class="center"><?= $i ?></td>
                    <td class="center"><?= $userItem[firstname] ?></td>
                    <td class="center"><?= $userItem[lastname] ?></td>
                    <td class="center"><?= $userItem[username] ?></td>
                    <td class="center"><?= $userItem[tel] ?></td>
                    <td class="center"><?= $userItem[email] ?></td>
                    <td class="center"><?= $userItem[name] ?></td>
                    <td class="center"><?= Province::getNameProvince($userItem[province]) ?></td>
                    <td class="center"><?= Generation::getNameGen($userItem[generation]) ?></td>
                    <td class="center"><?= Helpers::changeFormatDate($userItem[create_at],'datetime'); ?></td>
                    <td class="center"><?= $status ?></td>
                    <?php 
                    if ($userItem[lastvisit_at] == 0) {
                        $lastvisit_at = 'ยังไม่เข้าสู่ระบบ';
                    } else {
                        $lastvisit_at = $userItem[lastvisit_at];
                    }
                    ?>
                    <td class="center"><?= $lastvisit_at ?></td>
                </tr>
                 // Table row END 
            <?php
            $i++;
            }
            ?>
                </tbody>
             // Table body END 
            </table>
             // Table END 
        </div>      
    </div>
</div>-->
<?php 
if(!empty($_GET['ReportUser']['division_id'])){
    $queryDivision = '&';
    $queryDivision .= http_build_query(array('ReportUser[division_id]' => $_GET['ReportUser']['division_id']));
}

if(!empty($_GET['ReportUser']['department'])){
    $queryDepartment = '&';
    $queryDepartment .= http_build_query(array('ReportUser[department]' => $_GET['ReportUser']['department']));
}

if(!empty($_GET['ReportUser']['station'])){
    $queryStation ='&';
    $queryStation .= http_build_query(array('ReportUser[station]' => $_GET['ReportUser']['station']));
}


?>
<a href="Export_excel?
ReportUser[generation]=<?=$_GET['ReportUser']['generation']?>
&ReportUser[identification]=<?=$_GET['ReportUser']['identification']?>
&ReportUser[nameSearch]=<?=$_GET['ReportUser']['nameSearch']?>
&ReportUser[type_user]=<?=$_GET['ReportUser']['type_user']?>
&ReportUser[employee_type]=<?=$_GET['ReportUser']['employee_type']?>
&ReportUser[occupation]=<?=$_GET['ReportUser']['occupation']?>
&ReportUser[email]=<?=$_GET['ReportUser']['email']?>
&ReportUser[date_start]=<?=$_GET['ReportUser']['date_start']?>
&ReportUser[date_end]=<?=$_GET['ReportUser']['date_end']?>
&ReportUser[date_start_lastuse]=<?=$_GET['ReportUser']['date_start_lastuse']?>
&ReportUser[status_login]=<?=$_GET['ReportUser']['status_login']?>
<?=$queryDivision?>
<?=$queryDepartment?>
<?=$queryStation?>
" 
target="_blank"><button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button></a>

<!--<a href="Export_excel?ReportUser[generation]=<?=$_GET['ReportUser']['generation']?>&ReportUser[identification]=<?=$_GET['ReportUser']['identification']?>&ReportUser[nameSearch]=<?=$_GET['ReportUser']['nameSearch']?>&ReportUser[type_user]=<?=$_GET['ReportUser']['type_user']?>&ReportUser[occupation]=<?=$_GET['ReportUser']['occupation']?>&ReportUser[email]=<?=$_GET['ReportUser']['email']?>&ReportUser[date_start]=<?=$_GET['ReportUser']['date_start']?>&ReportUser[date_end]=<?=$_GET['ReportUser']['date_end']?>&ReportUser[date_start_lastuse]=<?=$_GET['ReportUser']['date_start_lastuse']?>&ReportUser[status_login]=<?=$_GET['ReportUser']['status_login']?>" target="_blank"><button type="submit" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> ส่งออกรายงาน (Excel)</button></a>-->

        <?php
        }else{
        ?>
            <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> </h4>
                </div>
                <div class="widget-body">
                    <!-- Table -->
                    <h3 style="color: red;">No data</h3>
                    <!-- // Table END -->
                </div>
            </div>
    <?php
        }
    }else{
        ?>
        <div class="widget" style="margin-top: -1px;">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines">
                    <i></i> </h4>
            </div>
            <div class="widget-body">
                <!-- Table -->
                <h3 class="text-success">กรุณาป้อนข้อมูลให้ถูกต้อง แล้วกด ปุ่มค้นหา</h3>
                <!-- // Table END -->
            </div>
        </div>
        <?php
    }

//Yii::app()->clientScript->registerScript('export', "
//
//  $(function(){
//      $('#btnExport').click(function(e) {
//        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table2').html()));
//        e.preventDefault();
//      });
//      $('.div-table a').attr('href','#');
//  });
//
//", CClientScript::POS_END);
    ?>
</div>
