<?php

$Department = $data['Department'];
$Position = $data['Position'];
$age = $data['age'];
$age2 = $data['age2'];
$status = $data['status'];
$datetime_start = $data['datetime_start'];
$datetime_end = $data['datetime_end'];
if ($data['Year_start'] != null && $data['Year_end'] != null) {
	if (Yii::app()->session['lang'] == 1) {
		$Year_start = $data['Year_start'];
		$Year_end = $data['Year_end'];
	}else{
		$Year_starts = $data['Year_start']-543;
		$Year_ends = $data['Year_end']-543;
		$Year_start = (string)$Year_starts;
		$Year_end = (string)$Year_ends;
	}
}else{
	$Year_start = $data['Year_start'];
	$Year_end = $data['Year_end'];
}
if ($datetime_start != null && $datetime_end != null) {
	if (Yii::app()->session['lang'] == 1) {
		$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
		$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
	}else{
		$start_dates = explode("-", $datetime_start);
		$start_dateExplode = $start_dates[0]-543;
		$start_dateImplode = $start_dateExplode."-".$start_dates[1]."-".$start_dates[2];

		$end_dates = explode("-", $datetime_end);
		$end_dateExplode = $end_dates[0]-543;
		$end_dateImplode = $end_dateExplode."-".$end_dates[1]."-".$end_dates[2];

		$start_date = date("Y-m-d", strtotime($start_dateImplode))." 00:00:00";
		$end_date = date("Y-m-d", strtotime($end_dateImplode))." 23:59:59";	
	}
}else{
	$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
	$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
}
$Chart = $data['Chart'];


if (Yii::app()->user->id != null) {
	$user_login = User::model()->findByPk(Yii::app()->user->id);
					$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
					$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
					$user_Level = $user_login->branch_id;
					$user_Position = $user_login->position_id;
					$user_Department = $user_login->department_id; ?>
					<!DOCTYPE html>
					<html>
					<head>
						<title></title>
					</head>
					<body>
						<div class="row">
							<h1><?php
							if (Yii::app()->session['lang'] == 1) {
								echo "Report register ship";
							}else{
								echo "รายงานภาพรวมการสมัคร คนประจำเรือ";
							}
							?></h1>

							<?php
							if ($Chart != "") {
								?>
								<div class="col-sm-12">
									<?php if ($Chart === "accommodation=Bar_Graph") { ?>
										<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint.png"; ?>" width="500" height="auto">
									<?php }else if($Chart === "accommodation=Pie_Charts"){ ?>
										<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint1.png"; ?>" width="500" height="auto"> 
									<?php } ?>
								</div><br>
							</div>
							<?php
							if ($Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") { ?>
								<div class="row">
									<div class="col-sm-12">
										<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint.png"; ?>" width="500" height="auto">
										<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint1.png"; ?>" width="500" height="auto">
									</div><br>
								</div>
								<?php	$f = 20;
								for ($p=0; $p <= $f ; $p++) { 
									echo "<br>";
								}

							}
							if ($Year_start != null && $Year_end != null) {
								if ($Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") { ?>
									<div class="row">
										<div class="col-sm-12">
											<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint3.png"; ?>" width="500" height="auto">
											<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint4.png"; ?>" width="500" height="auto">
										</div><br>
									</div>
									<?php
								}
								$l = 20;
								for ($i=0; $i <= $l ; $i++) { 
									echo "<br>";
								}
							}
						}

						$criteria = new CDbCriteria;
						$criteria->compare('type_employee_id',1);
						if($Department){
							$criteria->compare('id',$Department);
						}
						if ($authority == 2 || $authority == 3) {
							$criteria->compare('id',$user_Department);
						}
						$criteria->compare('active','y');
						$dep = Department::model()->findAll($criteria);

						$dep_arr = [];
						foreach ($dep as $key => $val_dep) {
							$dep_arr[] = $val_dep->id;
						}

						$criteria = new CDbCriteria;
						$criteria->compare('department_id',$dep_arr);
						$criteria->order = 'position_title ASC';
						if($Position){
							$criteria->compare('id',$Position);
						}
						if ($authority == 3) {
							$criteria->compare('id',$user_Position);
						}
						$criteria->compare('active','y');
						$pos = Position::model()->findAll($criteria);
						$pos_arr = [];
						$posback_arr = [];
						foreach ($pos as $key => $val_pos) {
							$pos_arr[] = $val_pos->id;
							$posback_arr[] = $val_pos->department_id;
						}
						$result_pos_arr = array_unique( $pos_arr );
						$result_dep_arr = array_unique( $posback_arr );

						$criteria = new CDbCriteria;
						$criteria->with = array('profile','department','position');
						$criteria->compare('user.department_id',$result_dep_arr);
						$criteria->compare('superuser',0);
						$criteria->compare('del_status',0);

						if ($status != null) {

							if ($status == "1") {
								$criteria->compare('register_status', 1);
								$criteria->compare('status',1);	
							}
							if($status == "0"){
								$criteria->compare('register_status', 0);
								/* $criteria->compare('status', 0); */
							}
							if ($status == "2") {
								$criteria->compare('register_status',1);
								$criteria->compare('status',0);
							}						
						}
						if ($age != null && $age2 != null || $age != "" && $age2 != "") {
							$criteria->addBetweenCondition('age', $age, $age2, 'AND');
						}
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {
							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						if($Position){
							$criteria->compare('position_id',$Position);
						}else{
							$criteria->compare('position_id',$result_pos_arr);	
						}
						$criteria->addCondition("profile.user_id=User.id");
						if (Yii::app()->session['lang'] == 1) {
							$criteria->order = 'profile.firstname_en ASC,position.position_title ASC';
						}else{
							$criteria->order = 'profile.firstname ASC,position.position_title ASC';
						}
						$User = User::model()->findAll($criteria);

						if ($Year_start == "" && $Year_end == "") { ?>
							<style type="text/css">
								tr td,tr th{
									border:1px solid #d8d8d8;
									padding: 8px;
								}
								tr th{
									background: #010C65;
									color: #fff;
								}
								.text-center{
									text-align: center;
								}
							</style>
							<?php 
							$i = 1;
							$people_total = Yii::app()->session['lang'] == 1?"No. of Staff:":"จำนวนผู้สมัครทั้งหมด";
							$people = Yii::app()->session['lang'] == 1?"persons":"คน";
							$datatable .= '<div class="report-table">';
							$datatable .= '<p style="text-align: right;">'.$people_total.' <span style="font-weight:bold;">';
							$datatable .=  count($User);
							$datatable .= '</span> '.$people.'</p>';
							$datatable .= '<div class="table-responsive w-100 t-regis-language">';
							$datatable .= '<table class="table" class="table" style="border:1px solid #d8d8d8;border-collapse: collapse;width: 100%;">';       
							$datatable .= '<thead>';
							$datatable .= '<tr style="background: #010C65;color: #fff; border:1px solid #d8d8d8;padding: 8px;">';
							if (Yii::app()->session['lang'] == 1) {
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">No.</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Name - Surname</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Department</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Position</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Age</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Status</th>';
							}else{
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">ลำดับ</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">ชื่อ - สกุล</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">แผนก</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">ตำแหน่ง</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">อายุ</th>';
								$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">สถานะอนุมัติ</th>';	
							}

							$datatable .= '</tr>'; 
							$datatable .= '</thead>';
							$datatable .= '<tbody>';
							if (!empty($User)) {
								foreach ($User as $keypos_back => $valuepos_back) { 	

									$datatable .= '<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
									$datatable .= '<td style="border:1px solid #d8d8d8; padding: 8px;">'.$i++.'</td>';
									if (Yii::app()->session['lang'] == 1) {
										$datatable .= '<td style="border:1px solid #d8d8d8; padding: 8px;text-align: left;">'.$valuepos_back->profile->firstname_en."  ".$valuepos_back->profile->lastname_en.'</td>';
									}else{
										$datatable .= '<td style="border:1px solid #d8d8d8; padding: 8px;text-align: left;">'.$valuepos_back->profile->firstname."  ".$valuepos_back->profile->lastname.'</td>';	
									}
									$datatable .= '<td style="border:1px solid #d8d8d8; padding: 8px;">'.$valuepos_back->department->dep_title.'</td>';
									$datatable .= '<td style="border:1px solid #d8d8d8; padding: 8px;">'.$valuepos_back->position->position_title.'</td>';
									$datatable .= '<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
									if ($valuepos_back->profile->age) {
										$datatable .= $valuepos_back->profile->age;
									}else{
										$datatable .= "-";
									}

									$datatable .= '</td>';
									if (Yii::app()->session['lang'] == 1) {

										$datatable .= '<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
										if ($status == 1) {
											$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;Approved</span>';
										}else if($tatus == 0){
											$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Disapproval</span>';
										}else if ($status == 2) {
											$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Suspension</span>';
										}
										$datatable .= '</td>';
									}else{
										$datatable .= '<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
										if ($status == 1) {
											$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
										}else if($status == 0){
											$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
										}else if ($status == 2) {
											$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ระงับการใช้งาน</span>';
										}
										$datatable .= '</td>';
									}

									$datatable .= '</tr>';

								}  							
							}else{
								$datatable .= '<tr>';
								$datatable .= '<td colspan="6">';
								if(Yii::app()->session['lang'] != 1){
									$datatable .= 'ไม่มีข้อมูล';
								}else{
									$datatable .= 'No data';
								}
								$datatable .= '</td>';
								$datatable .= '</tr>';
							}

							$datatable .= '</tbody>';
							$datatable .= '</table>';
							$datatable .= '</div>';
							$datatable .= '</div>';

							echo $datatable;
						}

					}
?>
</body>