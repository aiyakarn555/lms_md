
<?php
$title = 'รายงานผู้เรียนตามรายหลักสูตร';
$currentModel = 'Report';
// require_once('mpdf/mpdf.php');
ob_start();



$this->breadcrumbs = array($title);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');

EOD
, CClientScript::POS_READY);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<script type="text/javascript">
    $(function() {
        // $('#courseSelectMulti').select2();
        $(".chosen").chosen();
        $(".widget-body").css("overflow","");
        $("#Report_period_start").datepicker({
                // numberOfMonths: 2,
                onSelect: function(selected) {
                  $("#Report_period_end").datepicker("option","minDate", selected)
              }
          });
        $("#Report_period_end").datepicker({
                // numberOfMonths: 2,
                onSelect: function(selected) {
                 $("#Report_period_start").datepicker("option","maxDate", selected)
             }
         }); 

        var selectedVal = $( "#Report_course_id option:selected" ).val();
        if(selectedVal != ''){
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('Report/ListSchedule');?>",
                data:{ course_id:selectedVal},
                success: function(data) {
                    $('#Report_schedule_id').empty(); 
                    $('#Report_schedule_id').append(data); 
                    $('.chosen').trigger("chosen:updated");
                }
            }); 
        }
        


        $("#Report_course_id").change(function(){
            var course_id =  $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('Report/ListSchedule');?>",
                data:{ course_id:course_id},
                success: function(data) {
                    $('#Report_schedule_id').empty(); 
                    $('#Report_schedule_id').append(data); 
                    $('.chosen').trigger("chosen:updated");
                }
            });
        });

        endDate();
        startDate();
      //   $('#btnExport').click(function(e) {
      //       window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2><?= $title ?></h2>'+$('#export-table').html()));
      //       e.preventDefault();
      //   });
      // $('.div-table a').attr('href','#')+" ";
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

</script>

<div class="innerLR">

    <?php
    /**  */
    $type_user[1] = 'บุคลากรทั่วไป';
    $type_user[2] = 'บุคลากรภายใน';

    $divisiondata = Division::model()->getDivisionListNew(); 
    $departmentdata = Department::model()->getDepartmentListNew();
    $stationdata = Station::model()->getStationList();


    // $userModel = Users::model()->findByPk(Yii::app()->user->id);
    // $state = Helpers::lib()->getStatePermission($userModel);
    // if($state){
    //     $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    // }else{
    //     $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
    // }

    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            // array(
            //     'type'=>'list',
            //     'name'=>'course_id',
            //     'query'=>CHtml::listData($modelCourse,'course_id', 'course_title')
            // ),
            // array(
            //     'type'=>'list',
            //     'name'=>'schedule_id',
            //     'query'=> ''
            // ),
            // array('name'=>'type_user','type'=>'list','query'=>$type_user),
            // array('name'=>'search','type'=>'text','placeholder'=>'สามารถค้นหาด้วย ชื่อ, สกุล และอีเมลล์'),
        //array('name'=>'register_status','type'=>'list','query'=>User::getregisstatusList()),
           array('name'=>'position_id','type'=>'list','query'=>Position::getPositionList()),

            array('name'=>'period_start','type'=>'text'),
            array('name'=>'period_end','type'=>'text'),

        ),
    ));?>
	</div>
    <?php
       //  // $search = $_GET['ByCourse'];
       //  $search = $_GET['Report'];
       //  $textsearch = ($search['search']!=null)?'and email like "%'.$search['search'].'%" or profile.firstname like "%'.$search['search'].'%" or profile.lastname like "%'.$search['search'].'%"':null;

       //  //type_user
       //  $searchTyprUser = $search['type_user'];
       //  if( !empty($searchTyprUser)) {
       //          if($searchTyprUser == 1){ //General
       //              $texttype .= " AND type_register != '3' ";
       //          }else if($searchTyprUser == 2){ //Staff
       //              $texttype .= " AND type_register = '3' ";

       //          }
       //          // $sqlUser .= " AND tbl_profiles.type_user LIKE '".$model->type_user."' ";
       //      }

       //  $schedule_id  = $search['schedule_id'];
       //  if(!empty($schedule_id) && $schedule_id != 'ทั้งหมด'){
       //      $modelSch  = Schedule::model()->findByAttributes(array('schedule_id'=> $schedule_id));
       //      //period_Schedule
       //      $period_start_schedule = ($modelSch->training_date_start)?date('Y-m-d 00:00:00', strtotime($modelSch->training_date_start)):null;
       //      $period_end_schedule = ($modelSch->training_date_end)?date('Y-m-d 23:59:59', strtotime($modelSch->training_date_end)):null;

       //      $startdate_schedule = ($period_start_schedule)?' and learn.create_date >= "'. $period_start_schedule .'"':null;
       //      $enddate_schedule = ($period_end_schedule)?' and learn.create_date <= "'. $period_end_schedule .'"':null;
       //  }


       //  $searchCourse = $search['course_id'];
       //  if(!empty($searchCourse)){
       //     $searchCourseArray = implode(',', $searchCourse);
       //     $sqlCourseQuery = ($searchCourseArray!='')?' and course_id in ('.$searchCourseArray.')':null;
       //     $SQLsearchCourse = ' and course_id = '.$searchCourse;
       // }else{
       //      $SQLsearchCourse = '';
       // }
       

       //  $searchGeneration = $search['generation'];
       //  $gen = ($searchGeneration!='')?' and generation = "'. $searchGeneration . '"':null;

       //  //period
       //  $period_start = ($search['period_start'])?date('Y-m-d 00:00:00', strtotime($search['period_start'])):null;
       //  $period_end = ($search['period_end'])?date('Y-m-d 23:59:59', strtotime($search['period_end'])):null;
        
       //  $startdate = ($period_start)?' and learn.create_date >= "'. $period_start .'"':null;
       //  $enddate = ($period_end)?' and learn.create_date <= "'. $period_end .'"':null;

       //  $course_online = CourseOnline::model()->findAll(array(
       //      'condition' => 'lang_id = 1 and active = "y" and status = "1" '.$SQLsearchCourse,
       //      'order' => 'course_id ASC'
       //  ));
       //  $course_count = ($course_online)?count($course_online):0;
    ?>
	<!-- END HIGH SEARCH -->
    <div class="widget hidden" id="export-table" style=" overflow-x: scroll;">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title . ': ' .($period_start != null OR $period_end !=null)?Helpers::lib()->changeFormatDate($period_start) . ' ถึงวันที่ ' . Helpers::lib()->changeFormatDate($period_end):null ?></h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2">ตำแหน่งที่สมัคร</th>
                            <th rowspan="2">สถานะ</th>
                            <th rowspan="2">วันที่ลงทะเบียน</th>
                            <th rowspan="2">อนุมัติสมัครสมาชิก</th>
                            <th rowspan="2">ตรวจสอบข้อมูลการสมัคร</th>
                            <th rowspan="2">พิมพ์ใบสมัคร</th>
                            <th rowspan="2">ดาวน์โหลดเอกสารแนบ</th>
                            <th rowspan="2">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                             $user_Learn = Learn::model()->findAll(array(
                                    'condition' => 'course_id ="'. $course['course_id'] .'" and (lesson_status ="pass" or lesson_status ="learning")',
                                    'group'=>'user_id',
                                ));

                         $user_chk = array();
                         foreach ($user_Learn as $key => $val) {

                              $user_chk[] = $val->user_id;
                         }
                         if(count($user_chk) == 0){
                             $user_chk = array(0);
                        } 

                        if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){
                            $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1" and user.id IN ('.implode(",",$user_chk).')'  . $gen . $textsearch.$texttype,
                            ));
                        }else{
                           $allUsers = User::model()->with('profile')->findAll(array(
                            'condition' => 'status ="1"' . $gen . $textsearch .$texttype,
                        ));
                       }

                            $dataProvider=new CArrayDataProvider($allUsers, array(
                                'pagination'=>array(
                                'pageSize'=>25
                                ),
                        ));
                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }
                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;

                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {

                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->email ?>&nbsp;</td>
                                        <?php
                                           if($course_online) {
                                                foreach($course_online as $course) {
                                                    $statusLearn = Learn::model()->with('les')->find(array(
                                                        'condition' => 'user_id ="'.$user['id'].'" and learn.course_id ="'. $course['course_id'] .'"' . $startdate . $enddate . $startdate_schedule .$enddate_schedule,
                                                        'alias' => 'learn'
                                                    ));
                                                $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 
                                                        'pass' => '<b style="color: blue;">ผ่าน</b>',
                                                        'notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
                                                    ?>
                                                    <td class="center"><?= ($statusLearn['lesson_status']==null)?$statusArray['notlearn']:$statusArray[$statusLearn['lesson_status']] ?></td>
                                                    <?php
                                                }
                                           }
                                        ?>
                                    </tr>
                                    <?php
                                    $start_cnt++;

                                }
                            } else {
                                ?>
                                <tr>
                                    <strong>ไม่พบข้อมูล</strong>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div> 
        <?php 
                    $this->widget('CLinkPager',array(
                                    'pages'=>$dataProvider->pagination
                                    )
                                );
                ?>
        <div class="widget" id="export-table33" style=" overflow-x: scroll;">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title . ': ' .($period_start != null OR $period_end !=null)?Helpers::lib()->changeFormatDate($period_start) . ' ถึงวันที่ ' . Helpers::lib()->changeFormatDate($period_end):null ?></h4>
                </div>
            </div> 
            <?php
     // var_dump($user);
            ?>
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2">ตำแหน่งที่สมัคร</th>
                            <th rowspan="2">สถานะ</th>
                            <th rowspan="2">วันที่ลงทะเบียน</th>
                            <th rowspan="2">อนุมัติสมัครสมาชิก</th>
                            <th rowspan="2">ตรวจสอบข้อมูลการสมัคร</th>
                            <th rowspan="2">พิมพ์ใบสมัคร</th>
                            <th rowspan="2">ดาวน์โหลดเอกสารแนบ</th>
                            <th rowspan="2">หมายเหตุ</th>
    
                        </tr>
                        <tr>                      
                        </tr>
                    </thead>
                       <?php 
           $start_cnt = 1;
           $sqlAll = " SELECT * FROM tbl_users";
           $sqlAll .= ' left join tbl_position on tbl_position.id = tbl_users.position_id';
           $sqlAll .= " where tbl_users.status = '0' and tbl_users.del_status ='0'";
                        
          
                        // if($model->dateRang !='' ) {
                        //     list($start,$end) = explode(" - ",$model->dateRang);
                        //     $start = date("Y-m-d",strtotime($start))." 00:00:00";
                        //     $end = date("Y-m-d",strtotime($end))." 23:59:59";
                        //     $sqlAll .= " AND create_at BETWEEN '" . $start . "' AND '".$end."'";
                        // }

                        $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();
                        foreach ($allCount as $key => $value) {
                          echo $value->position_title;
                       
                       ?>
                    <tbody>
                         <tr>
                                        <td><?= $start_cnt++?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?php echo $value->position_title; ?></td>
                                        <td><?php if ($user->register_status == 1) {
                                            echo "อนุมัติ";
                                        }else if($user->register_status == 0){
                                            echo "รอตรวจสอบ";
                                        }else{
                                            echo "ไม่อนุมัติ";
                                        } ?></td>
                                        <td><?= $period_start ?></td>
                                        <td><?php
                                             if ($user->register_status == 1) {
                                            echo CHtml::button("อนุมัติ",array("class"=>"btn btn-success","data-id" => $user->id));
                                        }else if($user->register_status == 0){
                                            echo CHtml::button("รอการตรวจสอบ",array("class"=>"btn btn-info changeStatus","data-id" => $user->id));
                                        }else{
                                            echo CHtml::button("ไม่อนุมัติ",array("class"=>"btn btn btn-secondary","data-id" => $user->id));
                                        }
                                         ?></td>
                                        <td><?php echo CHtml::button("ตรวจสอบ",array("class"=>"btn btn-success Check_information","data-id" => $user->id)); ?></td>
                                        <td><?php echo CHtml::button('พิมพ์ใบสมัคร', array('submit' => array('admin/Printpdf', 'id'=> $user->id),'class' => 'btn btn btn-success')); ?></td>
                                        <td><?php echo CHtml::button('ดาวน์โหลดเอกสารแนบ', array('submit' => array('admin/Attach_load', 'id'=> $user->id),'class' => 'btn btn btn-success')); ?></td>
                                        <td><?php ?></td>            
                         </tr>
                    </tbody>
                    <?php
                 }
                    ?>
                </table>
       
            </div>
        </div>
  <script type="text/javascript">

    var x =  '<h2>'+'<?php echo $title; ?>'+'</h2>'+$('#export-table').html();
    $("#btnExportPdf").click(function() {
        $.ajax({
  url: "<?= Yii::app()->createUrl('report/genpdf'); ?>",
  type: "POST",
  data: {param:x},
  success: function(data){
    // alert(data);
  },
});
    });
</script>