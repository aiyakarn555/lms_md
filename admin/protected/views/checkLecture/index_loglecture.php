<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
 <!--Include Date Range Picker--> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<style>
    /*th {*/
        /*background-color: #5b2d90;*/
/*        color: white;*/
    /*}*/
</style>
<?php
$titleName = 'ประวัติการตรวจข้อสอบ';
$formNameModel = 'Logques';

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

<div class="innerLR">

    <?php
    /**  */
    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(

            array('name'=>'nameSearch','type'=>'text'),
            array('name'=>'dateRang','type'=>'text'),

        ),
    ));?>
    <?php
    if($model->nameSearch != '') {
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE status='1' AND ";
        $search = explode(" ",$model->nameSearch);
        $searchCount = count($search);
        $sqlUser .= "(";
        foreach ($search as $key => $searchText) {
            $sqlUser .= "(username LIKE '%" . trim($searchText) . "%' OR firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%')";
            if($searchCount != $key+1){
                $sqlUser .= " OR ";
            }
        }
        $sqlUser .= ")";
    
        $user = Yii::app()->db->createCommand($sqlUser)->queryAll();
        // var_dump($user[0]['id']);

        
        if (!empty($user)) {
            if(Yii::app()->user->isSuperuser == false) {
                // $userObj = Yii::app()->getModule('user')->user();
                // $model->typeOfUser = $userObj->authitem_name;
                // $owner_id = $userObj->id;
            }
            $logques = Logques::model()->findAll(array('condition' => 't.user_id = '.$user[0]['id'] .' and active = "y" and ques_type = 3 and t.check = 1','order'=>'user_id'));

            if($logques != null && count($logques) > 0){
           
            ?>
            <div class="widget-body">
                    <!-- Table -->
                    <h3 style="color: red;">บทเรียน</h3>
                    <!-- // Table END -->
            </div>
            <div class="div-table">
                <div class="widget" style="margin-top: -1px;">
                        <div class="widget-head">
                            <h4 class="heading glyphicons show_thumbnails_with_lines">
                                <i></i> <?php echo     $user[0][firstname] . " " . $user[0][lastname] ." | " ."ก่อนเรียน"; ?>
                            </h4>
                        </div>
                        <div class="widget-body">
                            <!-- Table -->
                            <table class="table table-bordered table-striped">

                                <!-- Table heading -->
                                <thead>
                                <tr>
                                    <!--                                <th class="center" style="width: 80px;">ลำดับ</th>-->
                                    <th style="width: 300px;background-color: #EF7124;color: white;" class="center">หลักสูตร</th>
                                    <th class="center" style="width: 300px;background-color: #EF7124;color: white;">บทเรียน</th>
                                    <th class="center" style="width: 200px;background-color: #EF7124;color: white;">โจทย์</th>
                                    <th class="center" style="width: 200px;background-color: #EF7124;color: white;">คำตอบ</th>
                               
                                    <th class="center" style="width: 200px;background-color: #EF7124;color: white;">คะแนน</th>
                                </tr>
                                </thead>
                                <!-- // Table heading END -->
                                 
                        <?php
                                 $scoreTotal = 0;
                                foreach ($logques as $key => $logquesItem) {
                                  
                                   
                
                                    if($logquesItem->test_type == "pre"){

                                ?>
                                <!-- Table body -->
                                <tbody>
                                    <!-- Table row -->
                                    <tr>
                                        <td ><?php echo $logquesItem->lesson->courseonlines->course_title; ?></td>
                                        <td class="center"><?php echo $logquesItem->lesson->title;?> </td>
                                        <td class="center"><?php echo $logquesItem->question->ques_title;?> </td>
                                        <td ><?php echo $logquesItem->logques_text;?> </td>
                                        <td class="center"><?php echo $logquesItem->result."/".$logquesItem->question->max_score;?> </td>
                                        <?php  $scoreTotal += $logquesItem->result; ?>
                                       
                                        <?php  
                                     }
                                    }
                                
                            ?>

                                    </tr>
                                    <tr>
                                        <td colspan="4">คะแนนรวม</td>
                                        <td class="center"><?php echo  $scoreTotal; ?></td>
                                    </tr>
                                    <!-- // Table row END -->
                                </tbody>

                                
                                <!-- // Table body END -->
                            </table>
                            <!-- // Table END -->
                        </div>
                    </div>
    
            </div>

            <div class="div-table">
                <div class="widget" style="margin-top: -1px;">
                        <div class="widget-head">
                            <h4 class="heading glyphicons show_thumbnails_with_lines">
                                <i></i> <?php echo     $user[0][firstname] . " " . $user[0][lastname] ." | " ."หลังเรียน"; ?>
                            </h4>
                        </div>
                        <div class="widget-body">
                            <!-- Table -->
                            <table class="table table-bordered table-striped">

                                <!-- Table heading -->
                                <thead>
                                <tr>
                                    <!--                                <th class="center" style="width: 80px;">ลำดับ</th>-->
                                    <th style="width: 300px;background-color: #EF7124;color: white;" class="center">หลักสูตร</th>
                                    <th class="center" style="width: 300px;background-color: #EF7124;color: white;">บทเรียน</th>
                                    <th class="center" style="width: 200px;background-color: #EF7124;color: white;">โจทย์</th>
                                    <th class="center" style="width: 200px;background-color: #EF7124;color: white;">คำตอบ</th>
                               
                                    <th class="center" style="width: 200px;background-color: #EF7124;color: white;">คะแนน</th>
                                </tr>
                                </thead>
                                <!-- // Table heading END -->
                                 
                        <?php
                            
                                foreach ($logques as $key => $logquesItem) {
    
                                    if($logquesItem->test_type == "post"){
                                ?>
                                <!-- Table body -->
                                <tbody>
                                    <!-- Table row -->
                                    <tr>
                                        <td ><?php echo $logquesItem->lesson->courseonlines->course_title; ?></td>
                                        <td class="center"><?php echo $logquesItem->lesson->title;?> </td>
                                        <td class="center"><?php echo $logquesItem->question->ques_title;?> </td>
                                        <td class="center"><?php echo $logquesItem->logques_text;?> </td>
                                        <td class="center"><?php echo $logquesItem->result."/".$logquesItem->question->max_score;?> </td>

                                        <?php  
                                     }
                                    }
                            ?>

                                    </tr>
                                    <!-- // Table row END -->
                                </tbody>

                                <!-- // Table body END -->
                            </table>
                            <!-- // Table END -->
                        </div>
                    </div>
    
            </div>


            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
            <?php
            }else {
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
                <h3 class="text-success">กรุณาใส่ ชื่อ - นามสกุล แล้วกด ปุ่มค้นหา</h3>
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
