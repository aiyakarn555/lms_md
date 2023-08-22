<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<style>
    th {
        background-color: #5b2d90;
        color: white;
    }
</style>
<?php
$titleName = 'รายงานผู้เรียนตามรายจังหวัด';
$formNameModel = 'ReportInfor';

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
        $("#ReportInfor_date_start").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
              $("#ReportInfor_date_end").datepicker("option","minDate", selected)
            }
        });
        $("#ReportInfor_date_end").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
               $("#ReportInfor_date_start").datepicker("option","maxDate", selected)
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
            array('name'=>'generation','type'=>'list','query'=>Generation::getGenerationList()),
            array('name'=>'province','type'=>'list','query'=>Province::getProvinceList()),
            array('name'=>'date_start','type'=>'text'),
            array('name'=>'date_end','type'=>'text'),
        ),
    ));?>
    <?php
    if(($model->date_start != '') && ($model->date_end != '')){
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE status='1' and generation is not null ";
        $sqlUser .= 'GROUP BY generation';
        $user = Yii::app()->db->createCommand($sqlUser)->queryAll();
        if (!empty($user)) {
            ?>
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            <div class="div-table">
            <div class="widget" style="margin-top: -1px;">
            <?php
            foreach ($user as $key => $DataProvinceInfor) {

                $generationTitle = Generation::model()->findByPk($province['generation']);
            ?>
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> <?php echo $generationTitle['name']; ?>
                    </h4>
                </div>
                <div class="widget-body">
                    <!-- Table -->
                    <table class="table table-bordered table-striped">
                        <!-- Table heading -->
                        <thead>
                        <tr>
                            <th class="center" style="width: 33%;">ลำดับที่</th>
                            <th class="center" style="width: 33%;">จังหวัด</th>
                            <th class="center" style="width: 34%;">จำนวนผู้เรียน</th>
                        </tr>
                        </thead>
                        <!-- // Table heading END -->
                        <!-- Table body -->
                        <tbody>
                        <?php
                         $i=1;
                    if ($DataProvinceInfor != "") {
                        $sqlProvince = "SELECT *,count(tbl_profiles.firstname) as user FROM tbl_province 
                        LEFT JOIN tbl_profiles on tbl_province.pv_id= tbl_profiles.province 
                        Left JOIN tbl_users ON tbl_users.id = tbl_profiles.user_id 
                        ";
                        /*
                         */
                        if($model->generation !=''){
                            $sqlProvince .= "AND tbl_users.status='1' AND tbl_profiles.generation='".$DataProvinceInfor['generation']."'";
                        }

                        $startDate = date("Y-m-d H:i:s", strtotime($model->date_start));
                        $endDate = date("Y-m-d H:i:s", strtotime($model->date_end));
                            if($startDate == $endDate){
                                $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
                            }
                        $sqlProvince .= " AND tbl_users.create_at between '".$startDate."' and '".$endDate."' ";
                           if($model->province !='') {
                                $sqlProvince .= " AND tbl_profiles.province = '".$model->province."' ";
                            }

                            

                        $sqlProvince .= ' GROUP BY tbl_province.pv_name_th';

                        $provinceData = Yii::app()->db->createCommand($sqlProvince)->queryAll();


                        foreach ($provinceData as $key => $reprotPro) {
                            $provinceTitle = Province::model()->findByPk($reprotPro['pv_id']);
                            $data .= "['" . $provinceTitle['pv_name_th'] . "',   " . $reprotPro['user'] . "],";
                        ?>
                        <tr>
                            <td class="center"><?php echo $i; ?></td>
                            <td class="center"><?php echo $provinceTitle['pv_name_th']; ?></td>
                            <td class="center"><?php echo $reprotPro['user']; ?></td>

                        </tr>
                        <?php $i++; $sum += $reprotPro['user'];
                        }
                    }
                         ?>
                         <tr>
                             <td class="center" colspan="2"><strong>รวม</strong></td>
                             <td class="center"><strong><?= $sum; ?></strong></td>
                             <td class="center"></td>
                         </tr>
                        </tbody>
                        <!-- // Table body END -->
                    </table>
                    <!-- // Table END -->
                </div>
                <?php } ?>
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
?>
<?php

Yii::app()->clientScript->registerScript('chart', "

    // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.

      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'บทเรียน');
        data.addColumn('number', '%จำนวนผู้เรียนตามจังหวัด');
        data.addRows([
          ".$data."
        ]);

        // Set chart options
        var options = {
        'title':'%จำนวนผู้เรียนตามจังหวัด',
        'width':'%100',
        is3D: true,
        //'height':300
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('container'));

        google.visualization.events.addListener(chart, 'ready', function () {
            $.post('".$this->createUrl('report/saveChart')."',{name:'index',image_base64:chart.getImageURI()},function(json){
                var jsonObj = $.parseJSON( json );
            });
        });

        chart.draw(data, options);

    }

    $(function(){
      $('#btnExport').click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table').html()+'<br><img src=".Yii::app()->getBaseUrl(true).'/uploads/index.png'.">' ));
        e.preventDefault();
      });
    });

", CClientScript::POS_END);
    ?>
</div>
