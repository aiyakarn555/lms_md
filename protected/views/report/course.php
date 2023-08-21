<style type="text/css">
    .form-control-danger {
        border-color: #d9534f;
        color: #d9534f;
        background-color: #f8d7da !important;
    }

    .form-control-danger:focus,
    .form-control-danger:hover {
        border-color: #d9534f;
    }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var num_chart = 0;
    var check_department = 1;
    var check_position = 1;
</script>
 <?php 
    $path_file_2 = Yii::app()->basePath;
    $path_file = "http:\\\\thorconn.com";

    $path_file_2 = explode("\\", $path_file_2);
    $path_file_2 = implode("\\\\", $path_file_2);
 ?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item">
                <a href="<?php echo $this->createUrl('/site/index'); ?>">
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                        echo "Home";
                    } else {
                        echo "หน้าแรก";
                    }
                    ?>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php
                if (Yii::app()->session['lang'] == 1) {
                    $name_report = "Overview of Training Course Report";
                } else{
                    $name_report = "รายงานภาพรวมการฝึกอบรม";
                }
                echo $name_report;
                ?>
            </li>
        </ol>
    </nav>
    <a class="btn btn-reportsearch" href="<?php echo $this->createUrl('/report/index'); ?>?target=course" style="margin-bottom: 0px; margin-left: 0px; background-color: #087fe4;">
        <i class="fas fa-angle-left"></i> <?php echo Yii::app()->session['lang'] == 1?'Back':' ย้อนกลับ'; ?>
    </a>
</div>


<section id="report-detail">
    <div class="container">
        <div class="search-collapse panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#report-search"><i class="fas fa-search"></i> <?php echo Yii::app()->session['lang'] == 1?'Search':' ค้นหา'; ?> <span class="pull-right"><i class="fas fa-chevron-down"></i></span></a>
                    </h4>
                </div>
                <div id="report-search" class="panel-collapse collapse in">
                    <form method="GET" accept-charset="UTF-8" id="form_search" action="<?php echo $this->createUrl('/report/course'); ?>">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_course_id">
                                        <?php 
                                            if(Yii::app()->session['lang'] != 1){
                                                echo "หลักสูตร";
                                            }else{
                                                echo "Course";
                                            }
                                        ?>                                             
                                    </label>
                                    <select class="form-control" name="search[course_id]" id="search_course_id" onchange="change_gen();">
                                        <option value="" selected>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกหลักสูตร";
                                                }else{
                                                    echo "Select Course";
                                                }
                                            ?>
                                        </option>
                                        <?php 
                                        foreach ($model_course as $key => $value) {
                                            if(Yii::app()->session['lang'] != 1){
                                                $value->course_id = $value->parent_id;
                                            }
                        ?> <option <?php if(isset($_GET["search"]["course_id"]) && $_GET["search"]["course_id"] == $value->course_id){ echo "selected"; } ?> value="<?= $value->course_id ?>"><?= $value->course_title ?></option> <?php
                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_gen_id">
                                         <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "รุ่น";
                                                }else{
                                                    echo "Gen";
                                                }
                                            ?>
                                    </label>
                                    <select class="form-control" name="search[gen_id]" id="search_gen_id">
                                        <option value="" selected>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกรุ่นของหลักสูตร";
                                                }else{
                                                    echo "Select Gen";
                                                }
                                            ?>
                                        </option>
<!-- <option value="">
    <?php 
        if(Yii::app()->session['lang'] != 1){
            echo "เลือกทั้งหมด";
        }else{
            echo "Select All";
        }
    ?>
    </option> -->
<?php 
if(isset($model_gen) && !empty($model_gen)){
    ?>   
    <option value="">
    <?php 
        if(Yii::app()->session['lang'] != 1){
            echo "เลือกทั้งหมด";
        }else{
            echo "Select All";
        }
    ?>
    </option>
    <option value="0">
        <?php 
        if(Yii::app()->session['lang'] != 1){
            echo "ไม่มีรุ่น";
        }else{
            echo "No Gen";
        }
        ?>
    </option> 
      
    <?php
    foreach ($model_gen as $key => $value) {
        ?>
        <option value="<?= $value->gen_id ?>" <?php if(isset($_GET["search"]["gen_id"]) && $_GET["search"]["gen_id"] == $value->gen_id){ echo "selected"; } ?> ><?= $value->gen_title ?></option>
        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div><label>
                                        <?php 
                                            if(Yii::app()->session['lang'] != 1){
                                                echo "รูปแบบกราฟแสดงผล";
                                            }else{
                                                echo "Chart Type";
                                            }
                                        ?>
                                    </label></div>
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input <?php if(isset($_GET["search"]["graph"]) && in_array("bar", $_GET["search"]["graph"])){ echo "checked"; } ?> type="checkbox" name="search[graph][]" id="search_graph_bar" value="bar">
                                        <label for="search_graph_bar" class="text-black">Column Chart</label>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <?php if($authority == 1){ ?>
                                <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_employee">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ประเภทพนักงาน";
                                        }else{
                                            echo "Employee Type";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[employee]" id="search_employee" onchange="change_department();">
                                        <option value="">
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกประเภทพนักงาน";
                                                }else{
                                                    echo "Select Type";
                                                }
                                            ?>
                                        </option>
                                        <option value="1" <?php if(isset($_GET['search']['employee']) && $_GET['search']['employee'] == 1){ echo "selected"; } ?>>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "พนักงานประจำเรือ";
                                                }else{
                                                    $ship = TypeEmployee::model()->findByPk(1);
                                                    echo $ship->type_employee_name;
                                                    // echo "MASTER / CAPTAIN";
                                                }
                                            ?>
                                        </option>
                                        <option value="2" <?php if(isset($_GET['search']['employee']) && $_GET['search']['employee'] == 2){ echo "selected"; } ?>>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "พนักงานออฟฟิศ";
                                                }else{
                                                    $office = TypeEmployee::model()->findByPk(2);
                                                    echo $office->type_employee_name;
                                                    // echo "Office";
                                                }
                                            ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($authority == 1){ ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group" >
                                    <label for="search_department" class="DepartmentLabel">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "แผนก";
                                        }else{
                                            echo "Department";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[department]" id="search_department" onchange="change_position();">
                                        <option value="" selected>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกแผนก";
                                                }else{
                                                    echo "Select Department";
                                                }
                                            ?>
                                        </option>
<?php 
if(isset($model_department) && !empty($model_department)){
    foreach ($model_department as $key => $value) {
        ?>
        <option <?php if(isset($_GET["search"]["department"]) && $_GET["search"]["department"] == $value->id){ echo "selected"; $department = $_GET["search"]["department"];} ?> value="<?= $value->id?>"><?= $value->dep_title ?></option> 
        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($authority == 1 || $authority == 2){ ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_position" class="PositionLabel">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ตำแหน่ง";
                                        }else{
                                            echo "Position";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[position]" id="search_position" onchange="change_level();">
                                        <option value="" selected>
                                            <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "เลือกตำแหน่ง";
                                        }else{
                                            echo "Select Position";
                                        }
                                        ?>
                                        </option>
<?php 
if(isset($model_position) && !empty($model_position)){
    foreach ($model_position as $key => $value) {
        ?>
        <option value="<?= $value->id ?>" <?php if(isset($_GET["search"]["position"]) && $_GET["search"]["position"] == $value->id){ echo "selected"; } ?> ><?= $value->position_title ?></option>
        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
<?php if($authority == 1 || ( ($authority == 2 || $authority == 3) && $user_login->profile->type_employee == 2) ){ ?>
                            <div class="col-sm-3 col-md-3 col-xs-12" id="div_search_level">
                                <div class="form-group">
                                    <label for="search_level">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ระดับตำแหน่ง";
                                        }else{
                                            echo "Level";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[level]" id="search_level">
                                        <option value="" selected>
                                            <?php 
                                            if(Yii::app()->session['lang'] != 1){
                                                echo "เลือกระดับตำแหน่ง";
                                            }else{
                                                echo "Select Level";
                                            }
                                            ?>
                                        </option>
<?php 
if(isset($model_level) && !empty($model_level)){
    foreach ($model_level as $key => $value) {
        ?>
        <option value="<?= $value->id ?>" <?php if(isset($_GET["search"]["level"]) && $_GET["search"]["level"] == $value->id){ echo "selected"; } ?> ><?= $value->branch_name ?></option>
        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label for="search_start_date">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงเวลาเริ่มต้น";
                                        }else{
                                            echo "Start Date";
                                        }
                                        ?>
                                    </label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="<?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงเวลาเริ่มต้น";
                                        }else{
                                            echo "Start Date";
                                        }
                                        ?>" type="text" name="search[start_date]" id="search_start_date" value="<?php if(isset($_GET["search"]["start_date"])){ echo $_GET["search"]["start_date"]; } ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label for="search_end_date">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงเวลาสิ้นสุด";
                                        }else{
                                            echo "End Date";
                                        }
                                        ?>
                                    </label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="<?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงเวลาสิ้นสุด";
                                        }else{
                                            echo "End Date";
                                        }
                                        ?>" type="text" name="search[end_date]" id="search_end_date" value="<?php if(isset($_GET["search"]["end_date"])){ echo $_GET["search"]["end_date"]; } ?>">
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_start_year">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ปีเริ่มต้น";
                                        }else{
                                            echo "From Year";
                                        }
                                        ?>                                            
                                    </label>
                                    <select class="form-control" name="search[start_year]" id="search_start_year">
                                        <option value="">
                                            <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "เลือกปีเริ่มต้น";
                                        }else{
                                            echo "From Year";
                                        }
                                        ?>
                                        </option>
                                        <?php 
                                        for ($i=($year_start-2); $i<$year_end ; $i++) {
                                            ?> <option <?php if(isset($_GET["search"]["start_year"]) && $_GET["search"]["start_year"] == $i){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option> <?php
                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_end_year">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ปีสิ้นสุด";
                                        }else{
                                            echo "To Year";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[end_year]" id="search_end_year">
                                        <option value="">
                                            <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "เลือกปีสิ้นสุด";
                                        }else{
                                            echo "To Year";
                                        }
                                        ?>
                                        </option>
                                        <?php 
                                        for ($i=$year_start-1; $i<$year_end ; $i++) {
                                            ?> <option <?php if(isset($_GET["search"]["end_year"]) && $_GET["search"]["end_year"] == $i){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option> <?php
                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-reportsearch" type="button" onclick="chk_form_search();"><i class="fas fa-search"></i>
                                <?php 
                                if(Yii::app()->session['lang'] != 1){
                                    echo "ค้นหา";
                                }else{
                                    echo "Search";
                                }
                                ?>
                            </button>
                        </div>

                    </div>
                </form>
                </div>

            </div>
        </div>
        <div class="divider">
            <i class="fas fa-chevron-down"></i>
        </div>


        <?php if(isset($_GET["search"])){ ?>
        <?php if($_GET["search"]["start_year"] == "" && $_GET["search"]["end_year"] == ""){ // ไม่ค้นหา ช่วงเวลา ?>

        <!-- เริ่ม กราฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟ -->
        <div class="row">
        <?php 
        if(isset($_GET["search"]["graph"]) && in_array("bar", $_GET["search"]["graph"])){
            ?>
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="year-report">
                    <h4>Column Chart</h4>
                    <div style="width:100%">
                        <div id="chart_bar"></div>
                    </div>
                    <script type="text/javascript">

                        google.charts.load("current", {packages:['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                            ["หลักสูตร", "No. of Registration", "No. of Finished" ],
                            <?php 
                            // foreach ($model_graph as $key => $value) {
                            //     if($value["register"] > 0){
                            //         echo "['".$value["title"]."', ".$value["register"].", ".$value["pass"]." ],";
                            //     }
                            // } 
                            foreach ($model_search as $key_c => $value_c) {
                                $course = CourseOnline::model()->findByPk($value_c["course_id"]);
                             
                                if(!empty($value_c["gen"])){ // วนรุ่น
                                    foreach ($value_c["gen"] as $key_g => $value_g) {
                                     //   var_dump($value_g["gen_id"]);
                                        if($value_g["register"] > 0){
                                $gen_course = CourseGeneration::model()->findByPk($value_g["gen_id"]);


                                        if($gen_course == ""){
                                            $gen_course->gen_title = "-";
                                        }
                                        echo "['".$course->course_title." Gen ".$gen_course->gen_title."', ".$value_g["register"].", ".$value_g["pass"]." ],";
                                        }
                                    }
                                }
                            }
                            ?>
                          ]);

                          var options = {
                            seriesType: 'bars',
                            bar: {groupWidth: "50%"},
                            legend: { position: "right" },
                            chartArea:{ right:'15%' },
                        };

                        var chart = new google.visualization.ComboChart(document.getElementById('chart_bar'));

google.visualization.events.addListener(chart, 'ready', function () {
    $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){

        var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;
        $("#result_search_graph").append("<img src='"+url_chart+"' >");
        var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
        $("#chart_graph").append("<img src='"+url_chart_2+"' >");
    });
    num_chart = num_chart+1;
});

chart.draw(data, options);
                    }
                </script>
                </div>
            </div>
            <div class="col-sm-1"></div>
            <?php
        }

        
        ?>
        </div>
        <!-- จบ กราฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟ -->

        <li class="breadcrumb-item active" aria-current="page">
            <center>
                <h3>
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                        $name_report = "Overview of Training Course Report";
                    } else{
                        $name_report = "รายงานภาพรวมการฝึกอบรม";
                    }
                    echo $name_report;
                    ?>
                </h3>    
            </center>
        </li>
        <div class="row">
            <div class="col-md-12 text-right" style="padding-right: 47px;">
                <p style="font-size: 18px; margin-bottom: 0px;">
                    <?php 
                    if(Yii::app()->session['lang'] != 1){
                        echo "จำนวน ";
                    }else{
                        echo "";
                    }
                    
                    // foreach ($model_graph as $key => $value) {
                    //     if($value["register"] <= 0){
                    //         unset($model_graph[$key]);
                    //     }
                    // }

                    // echo count($model_graph);
                    echo count($model_search);

                    if(Yii::app()->session['lang'] != 1){
                        echo " หลักสูตร";
                    }else{
                        echo " Courses";
                    }
                    ?>              
                </p>
            </div>
        </div>
        <div id="div_graph" style="display: none;">
               <div id="chart_graph"></div> 
               <div id="result_search_graph"></div> 
        </div>
        <div id="result_search"> <!-- export excel -->            
        <div class="report-table">
            <div class="table-responsive w-100 t-regis-language" style="padding-top: 10px;">
                <table class="table" id="table_list">
                    <thead>
                        <tr style="background-color: #010C65; color: #fff; border: 1.5px solid #000;">
                            <th rowspan="2"><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ลำดับ";
                            }else{
                                echo "No.";
                            }
                            ?></th>
                            <!-- <th>user_id</th> -->
                            <th rowspan="2">
                            <?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "หลักสูตร";
                            }else{
                                echo "Course";
                            }
                            ?></th>
                            <th rowspan="2"><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "รุ่น";
                            }else{
                                echo "Gen";
                            }
                            ?></th>
                            <th rowspan="2"><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "จำนวนผู้ลงทะเบียน";
                            }else{
                                echo "Register";
                            }
                            ?></th>
                            <th colspan="3"><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ไม่สำเร็จ";
                            }else{
                                echo "Not Finish";
                            }
                            ?></th>
                            <th colspan="2"><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "สำเร็จ";
                            }else{
                                echo "Finished";
                            }
                            ?></th>
                           
                        </tr>
                        <tr  style="background-color: #010C65; color: #fff; border: 1.5px solid #000; text-align: center;">
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ยังไม่เรียน";
                            }else{
                                echo "Not Start";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "กำลังเรียน";
                            }else{
                                echo "On Process";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "(Percent)";
                            }else{
                                echo "(Percent)";
                            }
                            ?></th>


                              <th ><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "สำเร็จ";
                            }else{
                                echo "Finished";
                            }
                            ?></th>
                            <th ><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "(Percent)";
                            }else{
                                echo "(Percent)";
                            }
                            ?></th>


                        </tr>
                    </thead>

                    <tbody>
                        <?php                         
                        if(!empty($model_search)){

                            foreach ($model_search as $key_c => $value_c) {
                                if(count($value_c["gen"]) <= 0){
                                    unset($model_search[$key_c]);
                                }
                            }
                        }
                        // var_dump($model_search);exit();
                         if(!empty($model_search)){
                            $no = 1;

                            $course_arr = [];
                            foreach ($model_search as $key_c => $value_c) {

                                // var_dump(count($value_c["gen"]));
                                $course = CourseOnline::model()->findByPk($value_c["course_id"]);
                             
                                if(!empty($value_c["gen"])){ // วนรุ่น
                                    foreach ($value_c["gen"] as $key_g => $value_g) {
                                     //   var_dump($value_g["gen_id"]);
                                        if($value_g["register"] > 0){
                                $gen_course = CourseGeneration::model()->findByPk($value_g["gen_id"]);

                                        if($gen_course == ""){
                                            $gen_course->gen_title = "-";
                                        }

                                        ?>
                                        <tr style="border: 1.5px solid #000;">

                                           <?php if (!in_array($value_c["course_id"], $course_arr)){
                                            $course_arr[] = $value_c["course_id"]; ?>
                                            <td><?php echo $no; ?></td>
                                                <?php $no++; ?>
                                        <?php }else{ ?>
                                            <td></td>
                                        <?php }

                                        ?>  

                                            <td class="text-left"><?= $course->course_title ?></td>
                                            <td><?= $gen_course->gen_title ?></td>
                                            <td><?= $value_g["register"] ?></td>
                                            <td style="background-color: #ffb05f;"><?= $value_g["notlearn"] ?></td>
                                            <td style="background-color: #ffb05f;"><?= $value_g["learn"] ?></td>
                                            <td style="background-color: #ffb05f;">
                                                <?php if(is_nan($value_g["per_notpass"])){ echo "-"; }else{ echo number_format($value_g["per_notpass"], 2)."%"; } ?>                                                    
                                                </td>
                                            <td style="background-color: #5dff40;"><?= $value_g["pass"] ?></td>
                                            <td style="background-color: #5dff40;">
                                                <?php if(is_nan($value_g["per_pass"])){ echo "-"; }else{ echo number_format($value_g["per_pass"], 2)."%"; } ?>
                                            </td>
                                            <!-- <td><?= $value_g["user"] ?></td> -->
                                        </tr>
                                        <?php
                                    }
                                    }
                                }
                               // else{ // ไม่มีรุ่น หรือ รุ่นเดียว
                                    //if($model_search <= 1){  ?>  
                                    <!-- <tr>
                                        <td colspan="9">
                                            <?php 
                                            // if(Yii::app()->session['lang'] != 1){
                                            //     echo "ไม่มีข้อมูล";
                                            // }else{
                                            //     echo "No data";
                                            // }
                                            ?></td>
                                        </tr> -->
                                        <?php
                                    //}
                                //}                                                     
                            } // foreach search

                        }else{ // !empty
                            ?>  
                            <tr style="border: 1.5px solid #000;">
                                <td colspan="9">
                                    <?php 
                                    if(Yii::app()->session['lang'] != 1){
                                        echo "ไม่มีข้อมูล";
                                    }else{
                                        echo "No data";
                                    }
                                    ?></td>
                            </tr>
                            <?php
                        }

                         ?>
                    </tbody>

                </table>
            </div>
        </div>

</div> <!-- export excel -->

<div class="pull-left ">
    <button class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
    <button class="btn btn-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
</div>
    <?php }else{ // ไม่ค้นหา ช่วงเวลา ?>
        <!-- ค้นหาแบบ ช่วงเวลา -->
        <?php if(isset($_GET["search"]["graph"]) && !empty($_GET["search"]["graph"])){ ?>

                <div class="row">
                    <?php 
                    foreach ($model_year as $key_y => $value_y) {                      

                        if(isset($_GET["search"]["graph"]) && in_array("bar", $_GET["search"]["graph"])){ ?>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="year-report">
                                    <h4>ปี <?= $key_y ?></h4>
                                    <div style="width:100%">
                                        <div id="chart_bar"></div>
                                    </div>
                                    <script type="text/javascript">
                                        google.charts.load("current", {packages:['corechart']});
                                        google.charts.setOnLoadCallback(drawChart);
                                        function drawChart() {
                                            <?php 
                                            $data_g =  '["หลักสูตร", "No. of Registration", "No. of Finished" ],';
                                            $color = Helpers::lib()->ColorCode();
                                            $no_c = 0;
                                            foreach ($value_y as $key => $value) {
                                                if($value["register"] > 0){
                                                    $course = CourseOnline::model()->findByPk($key);
                                                $data_g .=  "['".$course->course_title."', ".$value["register"].", ".$value["pass"]."],";
                                                
                                                }
                                            } 


                                            ?>
                                            var data_num = [<?= $data_g ?>].length;
                                            if(data_num > 1){
                                          var data = google.visualization.arrayToDataTable([
                                                <?= $data_g ?>

                                            ]);
                                      }
                                          // console.log([<?= $data_g ?>].length);

                                          var view = new google.visualization.DataView(data);
                                          view.setColumns([0, 1,
                                           { calc: "stringify",
                                           sourceColumn: 1,
                                           type: "string",
                                           role: "annotation" },
                                           2]);

                          var options = {
                            seriesType: 'bars',
                            bar: {groupWidth: "50%"},
                            legend: { position: "right" },
                            chartArea:{ right:'15%' },
                        };

var chart = new google.visualization.ComboChart(document.getElementById('chart_bar'));

google.visualization.events.addListener(chart, 'ready', function () {
    $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){

        var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;
        $("#result_search_graph").append("<img src='"+url_chart+"' >");
        var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
        $("#chart_graph").append("<img src='"+url_chart_2+"' >");
    });
    num_chart = num_chart+1;
});

chart.draw(data, options);
                                    }
                                </script>
                            </div>
                        </div>
                            <div class="col-sm-1"></div>

                       <?php } // in_array("bar",
                    } //foreach ($arr_count_course
                     ?>
                </div>

             <div id="div_graph" style="display: none;">
                 <div id="chart_graph"></div> 
                 <div id="result_search_graph"></div> 
                 <div id="result_search"><table><tr><td></td></tr></table></div>
             </div>

            <div class="pull-left ">
                <button class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
                <button class="btn btn-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
            </div>
        <?php } // !empty($_GET["search"]["graph"]) ?>

    <?php } // }else{ // ไม่ค้นหา ช่วงเวลา ?>
<?php } // if(isset($_GET["search"] ?>


   

</section>
</div>

<div style="display: none;">
    <form id="export_pdf" action="<?=$this->createUrl('report/ExportPDF')?>" target="blank_" method="POST">
        <input type="text" name="text_element1" id="text_element1" value="">
    </form>
</div>

<script type="text/javascript">
    $(document).ready( function () {

        $('.btn-pdf').click(function(e) {
            $("#text_element1").attr("value", encodeURIComponent("<h2><?= $name_report ?></h2>"+$('#chart_graph').html()+'<br>'+$('#result_search').html()) );
            $("#export_pdf").submit();
        });
      
        $('.btn-excel').click(function(e) {
            window.open('data:application/vnd.ms-excel;charset=UTF-8;,' + encodeURIComponent("<h2><?= $name_report ?></h2>"+$('#result_search_graph').html()+'<br><br><br><br><br><br><br><br><br><br><br><br><font color="white">ตาราง</font>'+$('#result_search').html() ));
            e.preventDefault();
        });

    });
    
    $('.datetimepicker').datetimepicker({
        format: 'Y-m-d',
        step: 10,
        timepicker: false,
        timepickerScrollbar: false,
        yearOffset: 0,
    });
    var lang_id = <?php echo Yii::app()->session['lang'] ?>;
    if (lang_id == 2) {
    $.datetimepicker.setLocale('th');
    $('.datetimepicker').datetimepicker({yearOffset: 543});
    }

    $("#search_start_date").change(function () {
        $("#search_end_date").val("");
        $("#search_start_year").val("");
        $("#search_end_year").val("");
    });
    $("#search_end_date").change(function () {
        var first = new Date($("#search_start_date").val());
        var current = new Date($(this).val());
        // console.log(first.getTime() +">"+ current.getTime());
        if (first.getTime() > current.getTime()) {
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("ไม่สามารถเลือกช่วงเวลาสิ้นสุดมากกว่าช่วงเวลาเริ่มต้นได้");
            }else{
                swal("Can't choose end range more than start range");                
            }
            // alert("ไม่สามารถเลือกช่วงเวลาสิ้นสุดมากกว่าช่วงเวลาเริ่มต้นได้");
            $(this).val("");
        }
        $("#search_start_year").val("");
        $("#search_end_year").val("");
    });

    $("#search_start_year").change(function () {
        $("#search_end_year").val("");
        $("#search_start_date").val("");
        $("#search_end_date").val("");
    });
    $("#search_end_year").change(function () {
        var first = $("#search_start_year").val();
        var current = $(this).val();
        if (first >= current && current != "") {
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("ไม่สามารถเลือกช่วงปีสิ้นสุดมากกว่าช่วงปีเริ่มต้นได้");
            }else{
                swal("Can't choose end range more than start range");                
            }
            // alert("ไม่สามารถเลือกช่วงปีสิ้นสุดมากกว่าช่วงปีเริ่มต้นได้");            
            $(this).val("");
        }
        $("#search_start_date").val("");
        $("#search_end_date").val("");
    });

    function change_gen(){
        var course_id = $("#search_course_id option:selected").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/report/getGenid"); ?>',
            data: ({
                course_id: course_id,
            }),
            success: function(data) {
                if(data != ""){
                    $("#search_gen_id").html(data);
                }
            }
        });
    }

    function change_department(){
        var employee_type = $("#search_employee option:selected").val();
        if(employee_type == 1){
            $("#div_search_level").hide();
        }else{
            $("#div_search_level").show();
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/report/getDepartment"); ?>',
            data: ({
                employee_type: employee_type,
            }),
            success: function(data) {
                if(data != ""){
                    $("#search_department").html(data);
                    //$("#search_position").html("<option value='' selected><?php if(Yii::app()->session['lang'] != 1){ echo "เลือกตำแหน่ง"; }else{ echo "Select Position"; } ?></option>");
                    $("#search_level").html("<option value='' selected><?php if(Yii::app()->session['lang'] != 1){ echo "เลือกระดับตำแหน่ง"; }else{ echo "Select Level"; } ?></option>");
                }
            }
        });
        if (employee_type == 1) {
                                    var lang = <?php echo Yii::app()->session['lang'] ?>;
                                    if (lang == 1) {
                                        var PositionLabel = "Position";
                                        var Position = "<option value >Select Position</option>";
                                        var DepartmentLabel = "Department";
                                        $('.PositionLabel').text(PositionLabel);
                                        $('#search_position').html(Position);
                                        $('.DepartmentLabel').text(DepartmentLabel);
                                    }else{
                                        var PositionLabel = "ตำแหน่ง";
                                        var Position = "<option value >เลือกตำแหน่ง</option>";
                                        var DepartmentLabel = "แผนก";
                                        $('.PositionLabel').text(PositionLabel);
                                        $('#search_position').html(Position);
                                        $('.DepartmentLabel').text(DepartmentLabel);
                                    }
                                }else{
                                    var lang = <?php echo Yii::app()->session['lang'] ?>;
                                    if (lang == 1) {
                                        var PositionLabel = "Department";
                                        var Position = "<option value >Select Department</option>";
                                        var DepartmentLabel = "Division";
                                        $('.PositionLabel').text(PositionLabel);
                                        $('#search_position').html(Position);
                                        $('.DepartmentLabel').text(DepartmentLabel);

                                    }else{
                                        var PositionLabel = "แผนก";
                                        var Position = "<option value >เลือกแผนก</option>";
                                        var DepartmentLabel = "ฝ่าย";
                                        $('.PositionLabel').text(PositionLabel);
                                        $('#search_position').html(Position);
                                        $('.DepartmentLabel').text(DepartmentLabel);
        
                                    }
                                }
    }

    function change_position(){
        if(check_department == 1 && "<?= $department ?>" != ""){
            var department_id = "<?= $department ?>";
            check_department = 2;
        }else{
            var department_id = $("#search_department option:selected").val();
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/report/getPosition"); ?>',
            data: ({
                department_id: department_id,
            }),
            success: function(data) {
                if(data != ""){
                    $("#search_position").html(data);
                    $("#search_level").html("<option value='' selected><?php if(Yii::app()->session['lang'] != 1){ echo "เลือกระดับตำแหน่ง"; }else{ echo "Select Level"; } ?></option>");
                }
            }
        });
    }

    function change_level(){      
    if(check_position == 1 && "<?= $position ?>" != ""){
        var position_id = "<?= $position ?>";
        check_position = 2;
    }else{  
        var position_id = $("#search_position option:selected").val();
    }
    
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/report/getLevel"); ?>',
            data: ({
                position_id: position_id,
            }),
            success: function(data) {
                if(data != ""){
                    $("#search_level").html(data);
                   // $("#search_level").html("<option value='' selected><?php if(Yii::app()->session['lang'] != 1){ echo "เลือกระดับตำแหน่ง"; }else{ echo "Select Level"; } ?></option>");
                }
            }
        });
    }

    function chk_form_search(){
        var status_pass = 1;

        var start_year = $("#search_start_year").val();
        var end_year = $("#search_end_year").val();
        if(end_year != "" && start_year == ""){
            status_pass =2;
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("กรุณาเลือกช่วงปีเริ่มต้น");
            }else{
                swal("Please choose start range");                
            }
            // alert("กรุณาเลือกช่วงปีเริ่มต้น");
            $("#search_start_year").addClass('form-control-danger');
        }else{
            $("#search_start_year").removeClass('form-control-danger');
        }
        if(end_year == "" && start_year != ""){
            status_pass =2;
            // alert("กรุณาเลือกช่วงปีสิ้นสุด");
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("กรุณาเลือกช่วงปีสิ้นสุด");
            }else{
                swal("Please choose end range");                
            }
            $("#search_end_year").addClass('form-control-danger');
        }else{
            $("#search_end_year").removeClass('form-control-danger');
        }


        var start_date = $("#search_start_date").val();
        var end_date = $("#search_end_date").val();
        if(end_date != "" && start_date == ""){
            status_pass =2;
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("กรุณาเลือกช่วงเวลาเริ่มต้น");
            }else{
                swal("Please choose start range");                
            }
            // alert("กรุณาเลือกช่วงเวลาเริ่มต้น");
            $("#search_start_date").addClass('form-control-danger');
        }else{
            $("#search_start_date").removeClass('form-control-danger');
        }
        if(end_date == "" && start_date != ""){
            status_pass =2;
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("กรุณาเลือกช่วงเวลาสิ้นสุด");
            }else{
                swal("Please choose end range");                
            }
            // alert("กรุณาเลือกช่วงเวลาสิ้นสุด");
            $("#search_end_date").addClass('form-control-danger');
        }else{
            $("#search_end_date").removeClass('form-control-danger');
        }

        if(status_pass == 1){
            $("#form_search").submit();
        }
    }

</script>