<?php


$strExcelFileName = "Export-Data-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");
			
if(!empty($model) && $model['passcours_cours'] != null && $model['gen_id'] != null){ 

	$gen->gen_id = $model['gen_id'];
	if($model['gen_id'] != 0){
		$gen = CourseGeneration::model()->findByPk($model['gen_id']);
	}
				

	$get = $model;

	$course_array = (is_array($get['passcours_cours']))? implode(',', $get['passcours_cours']) : null;
	$period_start = ($get['period_start'])?date('Y-m-d 00:00:00', strtotime($get['period_start'])):null;
	$period_end = ($get['period_end'])?date('Y-m-d 23:59:59', strtotime($get['period_end'])):null;

	$coursesql = ($course_array!=null)?' and courseonline.course_id in (' . $course_array . ')':null;
	$startdate = ($period_start)?' and pclog_date >= "'. $period_start .'"':null;
	$enddate = ($period_end)?' and pclog_date <= "'. $period_end .'"':null;


?>
			<div class="widget-body">
				<table class="table table-bordered table-striped" id="export-excel">
					<thead>
						<tr>
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
						if($model['passcours_cours'] != null){
							$courseSearch = ' and courseonline.course_id = '.$model['passcours_cours'];
						}


						$userModel = Users::model()->findByPk(Yii::app()->user->id);
						$state = Helpers::lib()->getStatePermission($userModel);

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

								// $pass = Learn::model()->with('les')->findAll(array(
								// 	'condition' => 't.course_id = "' . $Course['course_id'] . '" and lesson_status = "pass" and lesson_active = "y"',
								// 	'group' => 'user_id'
								// ));

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
		<?php } ?>


	
	