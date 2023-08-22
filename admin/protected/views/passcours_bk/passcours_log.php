<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<?php
$title = 'รายงานสถิติจำนวนผู้พิมพ์ใบประกาศ';
$form_name_model = 'Passcours Report';

$this->breadcrumbs = array($title);

$get = $_GET['PasscoursLog'];

$course_array = (is_array($get['passcours_cours']))? implode(',', $get['passcours_cours']) : null;
$period_start = ($get['period_start'])?date('Y-m-d 00:00:00', strtotime($get['period_start'])):null;
$period_end = ($get['period_end'])?date('Y-m-d 23:59:59', strtotime($get['period_end'])):null;

$coursesql = ($course_array!=null)?' and courseonline.course_id in (' . $course_array . ')':null;
$startdate = ($period_start)?' and pclog_date >= "'. $period_start .'"':null;
$enddate = ($period_end)?' and pclog_date <= "'. $period_end .'"':null;

$divisiondata = Division::model()->getDivisionListNew(); 
$departmentdata = Department::model()->getDepartmentListNew();
$stationdata = Station::model()->getStationList();

$userModel = Users::model()->findByPk(Yii::app()->user->id);
$state = Helpers::lib()->getStatePermission($userModel);

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
EOD
, CClientScript::POS_READY);

?>
<style type="text/css">
	 .chosen-with-drop .chosen-drop{
    z-index:1000!important;
    position:static!important;
}
</style>
<script>
    $(document).ready(function(){
    	$(".form").css("height", "500px"); // select มันโดนกลืนอะ เลยต้องขยายช่อง


        $(".toggleairasia-table td button").click(function(){
            $(this).closest("tbody").next().toggle();
        });

        $(".chosen").chosen();

        $("#PasscoursLog_period_start").datepicker({
            onSelect: function(selected) {
              $("#PasscoursLog_period_end").datepicker("option","minDate", selected)
            }
        });
        $("#PasscoursLog_period_end").datepicker({
            onSelect: function(selected) {
               $("#PasscoursLog_period_start").datepicker("option","maxDate", selected)
            }
        }); 

        $("#PasscoursLog_type_register").change(function(){
            var value = $("#PasscoursLog_type_register option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetdepartment"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#PasscoursLog_department").html(data);
                            $("#PasscoursLog_position").html('<option value="">ทั้งหมด</option>');
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });
        $("#PasscoursLog_department").change(function(){
            var value = $("#PasscoursLog_department option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetposition"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#PasscoursLog_position").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });

        $("#PasscoursLog_passcours_cours").change(function(){
            var value = $("#PasscoursLog_passcours_cours option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetgenid"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#PasscoursLog_gen_id").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });


});
</script>
<div class="innerLR">
	<?php 

	if(!$state){
		$CourseOnline = CourseOnline::model()->findAll(array(
			'condition' => 'active = "y" and lang_id = 1 and create_by = "'.Yii::app()->user->id.'"',
			'order' => 'course_title ASC'
		)
	);
	}else{
		$CourseOnline = CourseOnline::model()->findAll(array(
			'condition' => 'active = "y" and lang_id = 1',
			'order' => 'course_title ASC'
		)
	);
	}
	$listCourse = CHtml::listData($CourseOnline,'course_id','course_title');


	$TypeEmployee = TypeEmployee::model()->findAll(array(
    	'condition' => 'active = "y"',
    	'order' => 'type_employee_name ASC'
    ));
    $listtype_user = CHtml::listData($TypeEmployee,'id','type_employee_name');



    $department = Department::model()->findAll(array(
    	'condition' => 'active = "y"',
    	'order' => 'dep_title ASC'
    ));
    $listdepartment = CHtml::listData($department,'id','dep_title');


    $position = Position::model()->findAll(array(
    	'condition' => 'active = "y"',
    	'order' => 'position_title ASC'
    ));
    $listposition = CHtml::listData($position,'id','position_title');

     if($get['passcours_cours'] != ""){
    	$arr_gen = CourseGeneration::model()->findAll(array(
    		'condition' => 'course_id=:course_id AND active=:active ',
    		'params' => array(':course_id'=>$get['passcours_cours'], ':active'=>"y"),
    		'order' => 'gen_title ASC',
    	));    	

    	if(empty($arr_gen)){
    		$arr_gen[0] = "ไม่มีรุ่น";
    	}else{
    		$arr_gen = CHtml::listData($arr_gen,'gen_id','gen_title');
    	}

    }else{
    	$arr_gen[""] = "กรุณาเลือกหลักสูตร";
    }


	$this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'passcours_cours','type'=>'list','query'=>$listCourse),
			array('name'=>'gen_id','type'=>'list','query'=>$arr_gen),	
			array('name'=>'type_register','type'=>'list','query'=>$listtype_user),
			array('name'=>'department','type'=>'list','query'=>$listdepartment),
			array('name'=>'position','type'=>'list','query'=>$listposition),			
			array('name'=>'period_start','type'=>'text'),
			array('name'=>'period_end','type'=>'text'),
	),

	));


		?>
		<div class="widget" id="export-table">
			<div class="widget-head">
				<h4 class="heading glyphicons search">
					<i></i> สถิติจำนวนผู้พิมพ์หนังสือรับรอง : วันที่ <?= Helpers::lib()->changeFormatDate($period_start) ?> ถึงวันที่ <?= Helpers::lib()->changeFormatDate($period_end) ?>
				</h4>
			</div>
			<?php 
			if(!empty($_GET["PasscoursLog"] && $_GET['PasscoursLog']['passcours_cours'] != null && $_GET['PasscoursLog']['gen_id'] != null)){ 

				$gen->gen_id = $_GET['PasscoursLog']['gen_id'];
				if($_GET['PasscoursLog']['gen_id'] != 0){
					$gen = CourseGeneration::model()->findByPk($_GET['PasscoursLog']['gen_id']);
				}

				?>
			<div class="widget-body">
				<table class="table table-bordered table-striped" id="export-excel">
					<thead>
						<tr>
							<!--<th class="center" style="width: 80px;">ลำดับ</th>-->
							<th style="min-width: 400px;" class="left">บทเรียน</th>
							<th class="center" style="width: 75x;">ผู้เรียนทั้งหมด</th>
							<th class="center" style="width: 75x;">เรียนผ่าน</th>
							<th class="center" style="width: 75x;">พิมพ์ใบประกาศ</th>
							<th class="center" style="width: 75x;">ไม่พิมพ์ใบประกาศ</th>
							<th class="center" style="width: 75x;">คิดเป็นร้อยละ</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(!empty($_GET['PasscoursLog']['passcours_cours'])){
							$courseSearch = ' and courseonline.course_id = '.$_GET['PasscoursLog']['passcours_cours'];
						}

						if(!$state){
							$allCurrentCourse = CourseOnline::model()->with('category')->findAll(array(
								'condition' => 'courseonline.lang_id = 1 and courseonline.active = "y"' . $coursesql.' and courseonline.create_by = "'.Yii::app()->user->id.'"'.$courseSearch,
								'order' => 'courseonline.course_title ASC',
							));
						}else{
							$allCurrentCourse = CourseOnline::model()->with('category')->findAll(array(
								'condition' => 'courseonline.lang_id = 1 and courseonline.active = "y"' . $coursesql.$courseSearch,
								'order' => 'courseonline.course_title ASC',
							));
						}
						
						$sumLearn = 0;
						$sumPass = 0;
						$sumPrint = 0;
						$sumNotPrint = 0;
						$count_pass = 0;
						if($allCurrentCourse) {
							$last_cate_id = null;
							$lastCategory = null;
							foreach($allCurrentCourse as $Course) {
								// $course_gen = CourseGeneration::model()->findAll(array(
								// 	'condition' => 'course_id=:course_id AND active=:active ',
								// 	'params' => array(':course_id'=>$Course['course_id'], ':active'=>"y"),
								// 	'order' => 'gen_title ASC',
								// ));
								// if(empty($course_gen)){
								// 	$course_gen[]->gen_id = 0;
								// }
								// foreach($course_gen as $key => $gen) {

								if($last_cate_id != $Course['cate_id']) { 
									$last_cate_id = $Course['cate_id'];
									?>
									<tr>
										<td colspan="6" style="color: white; background-color: #997eb9; font-weight: bold;"><?= $Course->cates->cate_title ?></td>
									</tr>
									<?php
								}
								if($lastCategory != $Course['cate_course'] && $Course['cate_course'] != null) {
									$lastCategory = $Course['cate_course'];
									?>
									<tr>
										<td colspan="6" style="padding-left: 40px; color: white; background-color: #5b2d90; font-weight: bold;"><?= $Course->category->name ?></td>
									</tr>
									<?php
								}
								$print = PasscoursLog::model()->with('Course', 'user')->findAll(array(
									'condition' => 'superuser="0" AND user.id IS NOT NULL AND passcours_cours = "' . $Course['course_id'] . '"' . $startdate . $enddate.' AND t.gen_id="'.$gen->gen_id.'"',
									'group' => 'pclog_target'
								));
								
								$allLearn = Learn::model()->with('les', 'User')->findAll(array(
									'condition' => 'superuser="0" AND User.id IS NOT NULL AND t.course_id = "' . $Course['course_id'] . '" and lesson_active = "y"'.' AND gen_id="'.$gen->gen_id.'"',
									'group' => 'user_id'
								));

								$pass = Passcours::model()->with('Profiles', 'CourseOnlines', 'user')->findAll(array(
									'condition' => 'superuser="0" AND user.id IS NOT NULL AND passcours_cours = "' . $Course['course_id'] . '" '.' AND gen_id="'.$gen->gen_id.'"',
									'group' => 'passcours_user'
								));


								$CurrentLesson = Lesson::model()->findAll(array(
									'condition' => 'course_id = "' . $Course['course_id'] . '" AND active ="y" AND lang_id = 1',
								));
						//count
								$count_learn = count($allLearn);
								$count_pass = count($pass);
								$count_print = count($print);

								$calNotPrint = $count_pass - $count_print;
								if($calNotPrint < 0){
									$calNotPrint = 0;
								}
								$count_notprint = $calNotPrint;
								$calPercentage = $count_print*100/$count_pass;


						//sum

								$sumLearn = $sumLearn + $count_learn;
								$sumPass = $sumPass + $count_pass;
								$sumPrint = $sumPrint + $count_print;
								$sumNotPrint = $sumNotPrint + $count_notprint;
								$sumPercentage = $sumPrint*100/$sumPass;
								
								$text_gen = "";
								if($gen->gen_id != 0){
									$text_gen = " รุ่น ".$gen->gen_title;
								}
								?>
								<tr>
									<td><span style="padding-left: 60px; "><?= $Course['course_title'].$text_gen ?></span></td>
									<td class="center"><?= $count_learn ?></td>
									<td class="center"><?= $count_pass ?></td>
									<td class="center"><?= $count_print ?></td>
									<td class="center"><?= ($calNotPrint>0)?$calNotPrint:0 ?></td>
									<td class="center"><?= ($calPercentage>0)?round($calPercentage, 2).'%':0 ?></td>
								</tr>
								<?php
							// } // gen
							}
						} else {
							echo 'no course yet.';
						}
						?>	
						<tr>
							<td class="right" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;">รวมทั้งสิ้น</td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $sumLearn ?></td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $sumPass ?></td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $sumPrint ?></td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $sumNotPrint ?></td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= ($sumPercentage>0)?round($sumPercentage, 2).'%':0 ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="widget-body">
			 <a href="<?= $this->createUrl('passcours/genExcelPasscoursLog',array(
			 'PasscoursLog[passcours_cours]'=> $_GET['PasscoursLog']['passcours_cours'],
			 'PasscoursLog[gen_id]' 		=> $_GET['PasscoursLog']['gen_id'],
			 'PasscoursLog[type_register]'	=> $_GET['PasscoursLog']['type_register'],
			 'PasscoursLog[department]'		=> $_GET['PasscoursLog']['department'],
			 'PasscoursLog[position]'		=> $_GET['PasscoursLog']['position'],
			 'PasscoursLog[period_start]'	=> $_GET['PasscoursLog']['period_start'],
			 'PasscoursLog[period_end]'	 => $_GET['PasscoursLog']['period_end'],
            )); ?>" 
            target="_blank">
					<button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
			</a>
			</div>


		<?php } else { ?>
			<div class="widget-body div-table" style="overflow: auto;">
				<h4>กรุณาเลือกหลักสูตร หรือข้อมูลที่ต้องการ แล้วกด ปุ่มค้นหา</h4>
			</div>
		<?php } ?>
	</div>
			 
		
	</div>
	<script type="text/javascript">
		$(function() {
        // $('#courseSelectMulti').select2();
        $(".chosen").chosen();
        endDate();
        startDate();
        // $('#btnExport').click(function(e) {
        // 	window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>"<?= $title ?>"</h2>'+$('#export-table').html()));
        // 	e.preventDefault();
        // });
        // $('.div-table a').attr('href','#');
    });
		function startDate() {
			$('#PasscoursLog_period_start').datepicker({
				dateFormat:'yy/mm/dd',
				showOtherMonths: true,
				selectOtherMonths: true,
				onSelect: function() {
					$("#PasscoursLog_period_end").datepicker("option","minDate", this.value);
				},
			});
		}
		function endDate() {
			$('#PasscoursLog_period_end').datepicker({
				dateFormat:'yy/mm/dd',
				showOtherMonths: true,
				selectOtherMonths: true,
			});
		}
	</script>