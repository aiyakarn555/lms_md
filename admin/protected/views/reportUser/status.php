<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
<?php
$titleName = 'รายงายการเรียนรายวิชา';
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
});
</script>

<div class="innerLR">

    <?php
    /**  */
    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'generation','type'=>'list','query'=>$model->getGenerationList()),
            array('name'=>'type_user','type'=>'list','query'=>$model->getTypeuserList()),
            array('name'=>'occupation','type'=>'list','query'=>$model->getOccupationList()),
            // array('name'=>'generation','type'=>'list','query'=>Company::getCompanyList()),
            // array('name'=>'division_id','type'=>'list','query'=>Division::getDivisionList()),
            // array('name'=>'position_id','type'=>'list','query'=>Position::getPositionList()),
//            array('name'=>'course','type'=>'list','query'=>$model->courseList),
            array('name'=>'date_start','type'=>'text'),
            array('name'=>'date_end','type'=>'text'),

            //array('name'=>'course_point','type'=>'text'),
        ),
    ));?>
    <?php
    if(($model->date_start != '') && ($model->date_end != '')){
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id";

        $startDate = date("Y-m-d H:i:s", strtotime($model->date_start));
        $endDate = date("Y-m-d H:i:s", strtotime($model->date_end));
            if($startDate == $endDate){
                $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
            }
        $sqlUser .= " AND tbl_users.create_at between '".$startDate."' and '".$endDate."' ";
            if($model->generation !='') {
                $sqlUser .= " AND tbl_profiles.generation = '".$model->generation."' ";
            }
            if($model->type_user !='') {
                $sqlUser .= " AND tbl_profiles.type_user LIKE '".$model->type_user."' ";
            }
            if($model->occupation !='') {
                $sqlUser .= " AND tbl_profiles.occupation LIKE '".$model->occupation."' ";
            }

        $user = Yii::app()->db->createCommand($sqlUser)->queryAll();
        if (!empty($user)) {
            ?>
<div class="div-table">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> รายชื่อสมาชิก
            </h4>
        </div>
        <div class="widget-body">
            <!-- Table -->
            <table class="table table-bordered table-striped">
                <!-- Table heading -->
                <thead>
                <tr>
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
                </tr>
                </thead>
                <!-- // Table heading END -->
                <!-- Table body -->
                <tbody>
            <?php 
                foreach ($user as $key => $userItem) {
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
                <!-- Table row -->
                <tr>
                    <td class="center"><?= $userItem[firstname] ?></td>
                    <td class="center"><?= $userItem[lastname] ?></td>
                    <td class="center"><?= $userItem[username] ?></td>
                    <td class="center"><?= $userItem[tel] ?></td>
                    <td class="center"><?= $userItem[email] ?></td>
                    <td class="center"><?= $userItem[type_user] ?></td>
                    <td class="center"><?= Province::getNameProvince($userItem[province]) ?></td>
                    <td class="center"><?= Generation::getNameGen($userItem[generation]) ?></td>
                    <td class="center"><?= $userItem[create_at] ?></td>
                    <td class="center"><?= $status ?></td>
                </tr>
                <!-- // Table row END -->
            <?php
            }
            ?>
                </tbody>
            <!-- // Table body END -->
            </table>
            <!-- // Table END -->
        </div>      
    </div>
</div>
<button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
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
                    <h3 style="color: red;">ไม่พบข้อมูล</h3>
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
                <h3 class="text-success">กรุณาป้อนข้อมูลให้ครบถ้วน แล้วกด ปุ่มค้นหา</h3>
                <!-- // Table END -->
            </div>
        </div>
        <?php
    }

Yii::app()->clientScript->registerScript('export', "

  $(function(){
      $('#btnExport').click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table').html()));
        e.preventDefault();
      });
      $('.div-table a').attr('href','#');
  });

", CClientScript::POS_END);
    ?>
</div>
