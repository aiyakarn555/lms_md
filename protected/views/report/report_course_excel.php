<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var num_chart = 0;
</script>
 <?php 
    $path_file_2 = Yii::app()->basePath;
    $path_file = "http:\\\\thorconn.com";

    $path_file_2 = explode("\\", $path_file_2);
    $path_file_2 = implode("\\\\", $path_file_2);


 ?>
<?php
$strExcelFileName = "Training Course Report for Ship Staff-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");

if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');
        $this->redirect(array('site/index'));
        exit();
    }else{
    	$user_login = User::model()->findByPk(Yii::app()->user->id);
		$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
		$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

		if($authority == "" || ($type_em != 1 && $authority != 1)){
			$this->redirect(array('report/index'));
        	exit();
		}
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    	$langId = Yii::app()->session['lang'] = 1;
    }else{
    	$langId = Yii::app()->session['lang'];
    }

if (isset($search)) {

	$criteria = new CDbCriteria;

    	if($search["fullname"] != ""){
    		if (Yii::app()->session['lang'] == 1) {
    			$ex_fullname = explode(" ", $search["fullname"]);

	    		if(isset($ex_fullname[0])){    			
	    			$name = $ex_fullname[0];
	    			$criteria->compare('pro.firstname_en', $name, true);
	        		$criteria->compare('pro.lastname_en', $name, true, 'OR');
	    		}

	    		if(isset($ex_fullname[1])){
	    			$name = $ex_fullname[1];
	    			$criteria->compare('pro.lastname_en',$name,true, 'OR');
	    		}
    		}else{
    			$ex_fullname = explode(" ", $search["fullname"]);

	    		if(isset($ex_fullname[0])){    			
	    			$name = $ex_fullname[0];
	    			$criteria->compare('pro.firstname', $name, true);
	        		$criteria->compare('pro.lastname', $name, true, 'OR');
	    		}

	    		if(isset($ex_fullname[1])){
	    			$name = $ex_fullname[1];
	    			$criteria->compare('pro.lastname',$name,true, 'OR');
	    		}
    		}  		
    	}

    	$criteria->compare('t.active', 'y');
    	$criteria->compare('course.active', 'y');
    	$criteria->compare('pro.type_employee', 1); //1=เรือ 2=office
		$criteria->compare('user.superuser',0);

    	$criteria->addCondition('user.id IS NOT NULL');
    	$criteria->addCondition('t.course_id IS NOT NULL');

    	if($search["course_id"] != ""){
    		$criteria->compare('t.course_id', $search["course_id"]);

    		$model_gen = CourseGeneration::model()->findAll(array(
    			'condition' => 'active=:active AND course_id=:course_id',
    			'params' => array(':active'=>'y', ':course_id'=>$search["course_id"]),
    			'order' => 'gen_title ASC'    	
    		));

    		if($search["gen_id"] != ""){    			
    			$criteria->compare('t.gen_id', $search["gen_id"]);    			
    		}
    	}

    	if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
    		$search["department"] = $user_login->department_id;
    	}
    	if($search["department"] != ""){
    		$criteria->compare('user.department_id', $search["department"]);

$model_position = Position::model()->findAll(array(
	'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y',':department_id'=>$search["department"],':lang_id'=>1),
	'order' => 'position_title ASC'
));

    		if($authority == 3){ // ผู้จัดการแผนก
    			$search["position"] = $user_login->position_id;
    		}
    		if($search["position"] != ""){
    			$criteria->compare('user.position_id', $search["position"]);
    		}
    	}    	

    	$arr_count_course = [];
    	$arr_course_title = [];
    	if($search["start_date"] != "" && $search["end_date"] != ""){

    			if (Yii::app()->session['lang'] == 1) {
					if($search["start_date"] != ""){
						$criteria->compare('t.start_date', ">=".$search["start_date"]." 00:00:00");
					}
					if($search["end_date"] != ""){
						$criteria->compare('t.start_date', "<=".$search["end_date"]." 23:59:59");
					}
				}else{
				
					$start_date = explode("-", $search["start_date"]);
					$start_dateExplode = $start_date[0]-543;
					$start_dateImplode = $start_dateExplode."-".$start_date[1]."-".$start_date[2];
					
					$end_date = explode("-", $search["end_date"]);
					$end_dateExplode = $end_date[0]-543;
					$end_dateImplode = $end_dateExplode."-".$end_date[1]."-".$end_date[2];

					if($search["start_date"] != ""){
						$criteria->compare('t.start_date', ">=".$start_dateImplode." 00:00:00");
					}
					if($search["end_date"] != ""){
						$criteria->compare('t.start_date', "<=".$end_dateImplode." 23:59:59");
					}
				}

			if (Yii::app()->session['lang'] == 1) {
    			$criteria->order = 'course.course_title ASC, t.gen_id ASC, pro.firstname_en ASC , department.sortOrder ASC, position.sortOrder ASC';
    		}else{
    			$criteria->order = 'course.course_title ASC, t.gen_id ASC, pro.firstname ASC, department.sortOrder ASC, position.sortOrder ASC';
    		}
    		
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course", "mem.department", "mem.position")->findAll($criteria);

    		$criteria->order = 'course.course_title ASC';
    		$criteria->select ='t.course_id';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[$value->course_id] = $arr_count_course[$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}


    	}elseif($search["start_year"] != "" && $search["end_year"] != ""){
    		if (Yii::app()->session['lang'] != 1) {
				 $searchStart_year = $search["start_year"]-543;
				 $searchEnd_year = $search["end_year"]-543;
			}else{
				 $searchStart_year = $search["start_year"];
				 $searchEnd_year = $search["end_year"];	
			}
    		if($search["start_year"] != ""){
    			$criteria->compare('t.start_date', ">=".$searchStart_year."-01-01 00:00:00");
    		}
    		if($search["end_year"] != ""){
    			$criteria->compare('t.start_date', "<=".$searchEnd_year."-12-31 23:59:59");
    		}

    		// $criteria->order = 't.id ASC';
    		if (Yii::app()->session['lang'] == 1) {
    			$criteria->order = 'course.course_title ASC, t.gen_id ASC, pro.firstname_en ASC , department.sortOrder ASC, position.sortOrder ASC';
    		}else{
    			$criteria->order = 'course.course_title ASC, t.gen_id ASC, pro.firstname ASC, department.sortOrder ASC, position.sortOrder ASC';
    		}
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course", "mem.department", "mem.position")->findAll($criteria);

    		$criteria->order = 'course.course_title ASC';
    		$criteria->select ='t.start_date, t.course_id, YEAR(t.start_date) AS yearrrr';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}

    	}else{
    		if (Yii::app()->session['lang'] == 1) {
    			$criteria->order = 'course.course_title ASC, t.gen_id ASC, pro.firstname_en ASC , department.sortOrder ASC, position.sortOrder ASC';
    		}else{
    			$criteria->order = 'course.course_title ASC, t.gen_id ASC, pro.firstname ASC, department.sortOrder ASC, position.sortOrder ASC';//, department.sortOrder ASC, position.sortOrder ASC
    		}
    		
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course", "mem.department", "mem.position")->findAll($criteria);

    		$criteria->order = 'course.course_title ASC';
    		$criteria->select ='t.course_id';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		
    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[$value->course_id] = $arr_count_course[$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}
    	}
    	
}
?>
<?php if($search["start_year"] == "" && $search["end_year"] == ""){ // ไม่ค้นหา ช่วงเวลา ?>
<div class="row">
        <?php 
        if(isset($search["graph"]) && in_array("bar", $search["graph"])){
            ?>
            <div class="col-sm-6">
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
                            ["หลักสูตร", "ผู้สมัคร", { role: "style" } ],
                            <?php 
                            $color = Helpers::lib()->ColorCode();
                            $no_c = 0;
                            foreach ($arr_count_course as $key => $value) {
                                if(!isset($color[$no_c])){
                                    $color[$no_c] = "silver";
                                }
                                echo "['".$arr_course_title[$key]."', ".$value.", '".$color[$no_c]."'],";
                                $no_c++;
                            } 
                            ?>

                            ]);

                          var view = new google.visualization.DataView(data);
                          view.setColumns([0, 1,
                           { calc: "stringify",
                           sourceColumn: 1,
                           type: "string",
                           role: "annotation" },
                           2]);

                          var options = {
                            bar: {groupWidth: "95%"},
                            legend: { position: "none" },
                        };
                        var chart = new google.visualization.ColumnChart(document.getElementById("chart_bar"));
                        google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){
                                var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;                                
                                $("#result_search_graph").append("<img src='"+url_chart+"' >");
                                var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
                                $("#chart_graph").append("<img src='"+url_chart_2+"' >");
                            });
                            num_chart = num_chart+1;
                        });
                        chart.draw(view, options);
                    }
                </script>
                </div>
            </div>
            <?php
        }

        if(isset($search["graph"]) && in_array("pie", $search["graph"])){
        ?>
            <div class="col-sm-6">
                <div class="year-report">
                    <h4>Pie Chart</h4>
                    <div style="width:100%">
                        <div id="chart_pie"></div>
                    </div>
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['corechart']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                          ['หลักสูตร', 'ผู้สมัคร'],
                          <?php 
                            foreach ($arr_count_course as $key => $value) {
                                echo "['".$arr_course_title[$key]."', ".$value."],";
                            } 
                            ?>
                          ]);

                        var options = {
                          // title: 'Pie Chart'
                      };

                      var chart = new google.visualization.PieChart(document.getElementById('chart_pie'));
                      google.visualization.events.addListener(chart, 'ready', function () {

                        $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){
                            var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;
                            $("#result_search_graph").append("<img src='"+url_chart+"' >");
                            var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
                            $("#chart_graph").append("<img src='"+url_chart_2+"' >");
                        });
                        num_chart = num_chart+1;
                        console.log(num_chart);
                    });
                      chart.draw(data, options);
                  }
              </script>
                </div>
            </div>
        <?php
        }
        ?>
                 <?php if (isset($search["graph"])) {
								?>
								<!-- <div class="col-sm-12">
									<?php if(isset($search["graph"]) && in_array("bar", $search["graph"])) { ?>
										<img src="<?= Yii::app()->basePath."/../uploads/pic_chart/20210315171913_0.png"; ?>" width="500" height="auto">
									<?php } 
									if(isset($search["graph"]) && in_array("pie", $search["graph"])){ ?>
										<img src="<?= Yii::app()->basePath."/../uploads/pic_chart/20210315171913_1.png"; ?>" width="500" height="auto"> 
									<?php } ?>
								</div><br> -->
							</div> 
							<?php
							///if(isset($search["graph"]) && in_array("pie", $search["graph"])) { ?>
								<!-- <div class="row">
									<div class="col-sm-12">
										<img src="<?= Yii::app()->basePath."/../uploads/pic_chart/AttendPrint.png"; ?>" width="500" height="auto">
										<img src="<?= Yii::app()->basePath."/../uploads/pic_chart/AttendPrint1.png"; ?>" width="500" height="auto">
									</div><br>
								</div> -->
								<?php	
								// $f = 20;
								// for ($p=0; $p <= $f ; $p++) { 
								// 	echo "<br>";
								// }

							//}
							// if ($Year_start != null && $Year_end != null) {
							// 	if ($Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") { ?>
							 		<!-- <div class="row">
							 			<div class="col-sm-12">
							 				<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint3.png"; ?>" width="500" height="auto">
							 				<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint4.png"; ?>" width="500" height="auto">
							 			</div><br>
							 		</div> -->
							 		<?php
							// 	}
								$l = 10;
								for ($i=0; $i <= $l ; $i++) { 
									echo "<br>";
								}
							//}
						}
						?>
        </div>
        <style type="text/css">
        	div.count {
			  text-align: right;
			} 

        </style>
        <li class="breadcrumb-item active" aria-current="page">
            <center>
                <h3>
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                        $name_report = "Training Course Report for Ship Staff";
                    } else {
                        $name_report = "รายงานการฝึกอบรมพนักงานประจำเรือ";
                    }
                    echo $name_report;
                    ?>
                </h3>    
            </center>
        </li>
        <div class="row">
            <div class="col-md-12 text-right count" style="padding-right: 47px;">
                <p style="font-size: 18px; margin-bottom: 0px;">
                    <?php 

                    echo count($arr_count_course);
                    if(Yii::app()->session['lang'] != 1){
                        echo " หลักสูตร";
                    }else{
                        echo " Courses";
                    }
                    echo '<br>';
                    // $unique_val = Helpers::lib()->unique_multidim_array($model_search, 'user_id');
                    // echo count($arr_count_course);
                    echo count($model_search);
                    if(Yii::app()->session['lang'] != 1){
                        echo " คน";
                    }else{
                        echo " Persons";
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
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ลำดับ";
                            }else{
                                echo "No.";
                            }
                            ?></th>
                            <!-- <th>user_id</th> -->
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "หลักสูตร";
                            }else{
                                echo "Course";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "รุ่น";
                            }else{
                                echo "Gen";
                            }
                            ?></th> 
                            <th>
                            <?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ชื่อ - นามสกุล";
                            }else{
                                echo "Name - Surname";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "แผนก";
                            }else{
                                echo "Department";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ตำแหน่ง";
                            }else{
                                echo "Position";
                            }
                            ?></th>         
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        if(!empty($model_search)){
                            $no = 1;
                            foreach ($model_search as $key => $value) {
                                ?>  
                                <tr style="border: 1.5px solid #000;">
                                    <td><?php echo $no; $no++; ?></td>
                                    <!-- <td><?= $value->mem->id ?></td> -->
                                    <td class="text-left"><?= $value->course->course_title ?></td>
                                    <td>
                                        <?php 
                                        if($value->gen->gen_title == ""){
                                            echo "-";
                                        }else{
                                            echo $value->gen->gen_title;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-left">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo $value->pro->firstname." ".$value->pro->lastname;
                                        }else{
                                            echo $value->pro->firstname_en." ".$value->pro->lastname_en;
                                        }
                                        ?>
                                    </td>
                                    <!-- <td><?= $value->mem->department->dep_title ?></td>
                                    <td><?= $value->mem->position->position_title ?></td> -->
                                    <td><?php if($value->mem->department->dep_title != ""){ echo $value->mem->department->dep_title; }else{ echo "-"; } ?></td>
                                    <td><?php if($value->mem->position->position_title != ""){ echo $value->mem->position->position_title; }else{ echo "-"; } ?></td>      
                                </tr>
                                <?php
                            } // foreach search
                        }else{ // !empty
                            ?>  
                            <tr style="border: 1.5px solid #000;">
                                <td colspan="6">
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

</div>
<?php
}else{ ?>
<?php if(isset($search["graph"]) && !empty($search["graph"])){ ?>

                <div class="row">
                    <?php 
                    foreach ($arr_count_course as $key_y => $value_y) {                       
                        if(isset($search["graph"]) && in_array("bar", $search["graph"])){ ?>
                            <div class="col-sm-6">
                                <div class="year-report">
                                    <h4>ปี <?= $key_y ?></h4>
                                    <div style="width:100%">
                                        <div id="chart_bar"></div>
                                    </div>
                                    <script type="text/javascript">
                                        google.charts.load("current", {packages:['corechart']});
                                        google.charts.setOnLoadCallback(drawChart);
                                        function drawChart() {
                                          var data = google.visualization.arrayToDataTable([
                                            ["หลักสูตร", "ผู้สมัคร", { role: "style" } ],
                                            <?php 
                                            $color = Helpers::lib()->ColorCode();
                                            $no_c = 0;
                                            foreach ($value_y as $key => $value) {
                                                if(!isset($color[$no_c])){
                                                    $color[$no_c] = "silver";
                                                }
                                                echo "['".$arr_course_title[$key]."', ".$value.", '".$color[$no_c]."'],";
                                                $no_c++;
                                            } 
                                            ?>

                                            ]);

                                          var view = new google.visualization.DataView(data);
                                          view.setColumns([0, 1,
                                           { calc: "stringify",
                                           sourceColumn: 1,
                                           type: "string",
                                           role: "annotation" },
                                           2]);

                                          var options = {
                                            bar: {groupWidth: "95%"},
                                            legend: { position: "none" },
                                        };
                                        var chart = new google.visualization.ColumnChart(document.getElementById("chart_bar"));
                                        google.visualization.events.addListener(chart, 'ready', function () {
                                            $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){
                                                
                                                var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;
                                                $("#result_search_graph").append("<img src='"+url_chart+"' >");
                                                var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
                                                $("#chart_graph").append("<img src='"+url_chart_2+"' >");
                                            });
                                            num_chart = num_chart+1;
                                        });
                                        chart.draw(view, options);
                                    }
                                </script>
                            </div>
                        </div>
                       <?php } // in_array("bar",

                        if(isset($search["graph"]) && in_array("pie", $search["graph"])){ ?>
                            <div class="col-sm-6">
                                <div class="year-report">
                                    <h4>ปี <?= $key_y ?></h4>
                                    <div style="width:100%">
                                        <div id="chart_pie"></div>
                                    </div>
                                    <script type="text/javascript">
                                      google.charts.load('current', {'packages':['corechart']});
                                      google.charts.setOnLoadCallback(drawChart);

                                      function drawChart() {

                                        var data = google.visualization.arrayToDataTable([
                                          ['หลักสูตร', 'ผู้สมัคร'],
                                          <?php 
                                          foreach ($value_y as $key => $value) {
                                            echo "['".$arr_course_title[$key]."', ".$value."],";
                                        } 
                                        ?>
                                        ]);

                                        var options = { };

                                        var chart = new google.visualization.PieChart(document.getElementById('chart_pie'));
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
                     <?php   } // in_array("pie",
                    } //foreach ($arr_count_course
                     ?>
                </div>

             <div id="div_graph" style="display: none;">
                 <div id="chart_graph"></div> 
                 <div id="result_search_graph"></div> 
                 <div id="result_search"><table><tr><td></td></tr></table></div>
             </div>

        <?php } // !empty($search["graph"]) ?>
<?php
}
?>
