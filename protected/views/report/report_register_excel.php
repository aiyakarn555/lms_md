<?php
$strExcelFileName = "รายงานภาพรวมการสมัคร-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");

$datetime_start = $data['datetime_start'];
$datetime_end = $data['datetime_end'];
$status = $data['status'];

$TypeEmployee = $data['TypeEmployee'];
$Department = $data['Department'];
$Position = $data['Position'];
$Leval =  $data['Leval'];
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

$user_login = User::model()->findByPk(Yii::app()->user->id);
$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
$user_Level = $user_login->branch_id;
$user_Position = $user_login->position_id;
$user_Department = $user_login->department_id;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
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
	<div class="row">
		<h1><?php
		if (Yii::app()->session['lang'] == 1) {
			echo "Report overview register";
		}else{
			echo "รายงานภาพรวมการสมัครสมาชิก";
		}
		?></h1>
		<div class="col-sm-12">
			<?php
			if ($Chart != "") {
			?>
			<?php if ($Chart === "accommodation=Bar_Graph") { ?>
				<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint.png"; ?>" width="500" height="auto">
			<?php }else if($Chart === "accommodation=Pie_Charts"){ ?>
				<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint1.png"; ?>" width="500" height="auto"> 
			<?php }
			 ?>
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
	$user_login = User::model()->findByPk(Yii::app()->user->id);
					$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
					$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
					$user_Level = $user_login->branch_id;
					$user_Position = $user_login->position_id;
					$user_Department = $user_login->department_id;
					$criteria = new CDbCriteria;
					$criteria->compare('type_employee_id',$TypeEmployee);
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
					$criteria->addIncondition('department_id',$dep_arr);
					$criteria->compare('active','y');
					if ($Position != "") {
						if($Position){
							$criteria->compare('id',$Position);
						}
					}else{
						if ($authority == 2 || $authority == 3) {
							$criteria->compare('id',$user_Position);
						}
					}
					$pos = Position::model()->findAll($criteria);
					$pos_arr = [];
					$posback_arr = [];
					foreach ($pos as $key => $val_pos) {

						$pos_arr[] = $val_pos->id;
						$posback_arr[] = $val_pos->department_id;
					}
					$criteria = new CDbCriteria;
					$criteria->addIncondition('position_id',$pos_arr);
					$criteria->compare('active','y');
					if ($Leval != "") {
						if($Leval){
							$criteria->compare('id',$Leval);
						}
					}else{
						if ($authority == 3) {
							$criteria->compare('id',$user_Level);
						}
					}
					// $criteria->group = 'position_id';
					$criteria->order = 'sortOrder ASC';
					$branch = Branch::model()->findAll($criteria);
					// var_export($branch);


					$branch_arr = [];
					foreach ($branch as $key => $val_branch) {
						$branch_arr[] = $val_branch->position_id;
						$name_dep[] = $val_branch->Positions->Departments->id;
					    $names_dep[] = $val_branch->Positions->Departments->dep_title;
						$id_pos[] = $val_branch->Positions->id;
						$name_pos[] = $val_branch->Positions->position_title;
						$names_level[] = $val_branch->branch_name;
						$ids_level[] = $val_branch->id;
					}
			
					$result_dep_in = array_unique( $name_dep );
					$result_dep_not = array_unique( $name_dep_not );
					$result_pos_in = array_unique( $id_pos );
					$result_pos_not = array_unique( $name_pos );

					$result_branch_arr = array_unique( $branch_arr );
					$result_pos_arr = array_unique( $posback_arr );

					$criteria = new CDbCriteria;
					$criteria->addIncondition('department_id',$dep_arr);
					if ($Position != "") {
					if($Position){
							$criteria->compare('id',$Position);
						}
					}else{
						if ($authority == 2 || $authority == 3) {
							$criteria->compare('id',$user_Position);
						}
					}
					$criteria->addNotInCondition('id',$result_branch_arr);
					$criteria->compare('active','y');
					$criteria->order = 'sortOrder ASC';
					$pos_back = Position::model()->findAll($criteria);
					
					$criteria = new CDbCriteria;
					$criteria->compare('type_employee_id',$TypeEmployee);
					if($Department){
						$criteria->compare('id',$Department);
					}
					if ($authority == 2 || $authority == 3) {
						$criteria->compare('id',$user_Department);
					}
					$criteria->addNotInCondition('id',$result_pos_arr);
					$criteria->compare('active','y');
					$criteria->order = 'sortOrder ASC';
					$dep_back = Department::model()->findAll($criteria);
				//var_dump($ids_level);exit();
					$sumtotal = 0;
									foreach ($result_pos_in as $key => $value) {
										$var_result[] = $value;
									}		
												$criteria = new CDbCriteria;
												$criteria->compare('position_id',$var_result);
												if ($Leval != "") {
													$criteria->compare('branch_id',$id_level);
												}
												if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
												}
												$criteria->compare('superuser',0);
												$criteria->compare('del_status',0);
												$criteria->compare('status',1);
												$criteria->compare('register_status',1);
												$criteria->addCondition("user_id=id");
											$users_br = Users::model()->findAll($criteria);
											$total = count($users_br);
					
									foreach ($pos_back as $keypos_back => $valuepos_back) { 
									 		$position_pos[] = $valuepos_back->id;
									 		$departments_pos[] = $valuepos_back->Departments->id;
									}
										$criteria = new CDbCriteria;
										$criteria->with = array('profile');
										$criteria->compare('profile.type_employee',$TypeEmployee);
										$criteria->compare('position_id',$position_pos);
										$criteria->compare('department_id',$departments_pos);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
									if ($status != null) {

											/*if ($status != "1") {
												$criteria->compare('register_status',0);
												$criteria->compare('status',array(0,1));
											}else{
												$criteria->compare('register_status',array(0,1));
												$criteria->compare('status',array(0,1));
											} */
											$criteria->compare('register_status',array(0,1));
											$criteria->compare('status',array(0,1));
										}
										$criteria->addCondition('profile.user_id=user.id');
										$users_ps = Users::model()->findAll($criteria);
										$total_pos = count($users_ps);
									foreach ($dep_back as $keydep_back => $valuedep_back) { 
										$departments_dep[] = $valuedep_back->id;
									}
										$criteria = new CDbCriteria;
										$criteria->compare('department_id',$departments_dep);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										if($status != null){
											$criteria->compare('status',$status);		
										}
										$users_dm = Users::model()->findAll($criteria);
									
										$total_dep = count($users_dm);

										
									$i = 1;
									$people_total = Yii::app()->session['lang'] == 1?"No. of Staff:":"จำนวนผู้สมัครทั้งหมด";
									$people = Yii::app()->session['lang'] == 1?"persons":"คน";
									$datatable .= '<div class="report-table">';
									$datatable .= '<p style="text-align: right;">'.$people_total;
									$datatable .= ' <span style="font-weight:bold;"> ';	
									$total_new = 0;
									if ($TypeEmployee == 2 && $dep_back && $Department != "") {
										$datatable .= $total_dep;
										$total_new = $total_dep;
									}else if($TypeEmployee == 2 && $branch && $Department != ""){
										$datatable .= $total;
										$total_new = $total;
									}else if($TypeEmployee == 1 && $pos_back){
										$datatable .=  $total_pos;
										$total_new = $total_pos;
									}else if($TypeEmployee == 2 && $Department == ""){
										$datatable .=  $total_dep + $total;
										$total_new = $total_dep + $total;
									}

									$datatable .= '</span> ';
									$datatable .=  $people.'</p>';
									$datatable .= '<div class="table-responsive w-100 t-regis-language">';
									$datatable .= '<table class="table" style="border:1px solid #d8d8d8;border-collapse: collapse;width: 100%;	">';       
									$datatable .= '<thead>';
									$datatable .= '<tr>';
									if (Yii::app()->session['lang'] == 1) {
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">No.</th>';
									if($TypeEmployee != 1){
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Division</th>';
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Department</th>';
									
										if ($Leval != "" || $Position != "") {
											$datatable .= '<th>Level</th>';
										}
									}else{
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Department</th>';
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Position</th>';
									}
									if($TypeEmployee != 2){
										$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Total of Register</th>';
										if ($status != "") {
											if ($status == 1) {
												$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Total of Approved</th>';	
											}else if ($status == 0){
												$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Total of Disapproved</th>';	
											}else{
												$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Total of Suspension</th>';
											}
											
										}
										$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Status</th>';
									}else{
										$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Total</th>';
									}
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">Percent</th>';
									}else{
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">ลำดับ</th>';
									if($TypeEmployee != 1){
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">ฝ่าย</th>';
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">แผนก</th>';
									
										if ($Leval != "" || $Position != "") {
										$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">ระดับตำแหน่ง</th>';
										}
									}else{
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">ฝ่าย</th>';
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">แผนก</th>';	
									}
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">จำนวนผู้สมัคร</th>';
									if($TypeEmployee != 2){
										if ($status != "") {
											if ($status == 1) {
												$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">จำนวนผู้อนุมัติ</th>';	
											}else if ($status == 0){
												$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">จำนวนผู้ไม่อนุมัติ</th>';	
											}else{
												$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">จำนวนผู้ถูกระงับการใช้งาน</th>';
											}
										}
										$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">สถานะอนุมัติ</th>';
									}
									$datatable .= '<th style="border:1px solid #d8d8d8; padding: 8px;">คิดเป็นร้อยละ</th>';
									}
									$datatable .= '</tr>'; 
									$datatable .= '</thead>';
									$datatable .= '<tbody>';
									if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) {
									if ($TypeEmployee == 2) {   

											foreach ($ids_level as $key => $value) {
											$criteria = new CDbCriteria;
											$criteria->compare('branch_id',$value);
											if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
											}
											$criteria->compare('superuser',0);
											$criteria->compare('del_status',0);
											$criteria->compare('register_status',1);
											$criteria->addCondition('profile.user_id=id');
											$usersAll_end = Users::model()->findAll($criteria);		
											$cou_useAll_end = count($usersAll_end);
											$sumtotal_end += $cou_useAll_end;
											}
											if ($Position == ""){
											foreach ($result_pos_in as $key => $value) {		
												$criteria = new CDbCriteria;
												$criteria->compare('position_id',$value);
												if ($Leval != "") {
													$criteria->compare('branch_id',$id_level);
												}
												if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
												}
												$criteria->compare('superuser',0);
												$criteria->compare('del_status',0);
												$criteria->compare('status',1);
												$criteria->compare('register_status',1);
												$criteria->addCondition('profile.user_id=id');
												$users_count = Users::model()->findAll($criteria);
												$cou_use = count($users_count);	

											$criteria = new CDbCriteria;
											$criteria->compare('position_id',$value);
											if ($Leval != "") {
													$criteria->compare('branch_id',$id_level);
												}
											if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
											}
						
											$criteria->compare('superuser',0);
											$criteria->compare('del_status',0);
											$criteria->compare('register_status',1);
											$criteria->addCondition('profile.user_id=id');
											$usersAll = Users::model()->findAll($criteria);		
											$cou_useAll = count($usersAll);
											
											$sumtotal += $cou_useAll;
											$per_cen = ($cou_useAll * 100 ) / $total_new;
										
											$datatable .= '<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
											$datatable .= '<td>'.$i++.'</td>';
											$datatable .= '<td class="text-center">'.$names_dep[$key].'</td>';
											$datatable .= '<td class="text-center">'.$result_pos_not[$key].'</td>';
											if ($Leval != "" || $Position != "") {
												$datatable .= '<td class="text-center">'.$names_level[$key]
												.'</td>';
											}
											$datatable .= '<td class="text-center">'.$cou_use.'</td>';
											if($TypeEmployee != 2){
												if (Yii::app()->session['lang'] == 1) {		
												$datatable .= '<td class="text-center">';
													if($cou_use > 0){
														if ($status == 1) {
															$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;Approved</span>';
														}else if ($status == 0){
															$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Disapproval</span>';
														}else{
															$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Suspension</span>';
														}
													}else{
														$datatable .= '-';
													}
												
												$datatable .= '</td>';
												}else{
												$datatable .= '<td class="text-center">';
													if($cou_use > 0){
														if ($status == 1) {
															$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
														}else if ($status == 0){
															$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
														}else{
															$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ระงับการใช้งาน</span>';
														}
													}else{
														$datatable .= '-';
													}
													$datatable .= '</td>';
												}
												
											}
											if($cou_use > 0){
												$datatable .= '<td class="text-center">'.round($per_cen, 2).' %</td>';
											}else{
												$datatable .= '<td class="text-center">-</td>';
											}
											$datatable .= '</tr>';
										}
										}
										else{
											foreach ($ids_level as $key => $value) {		
												$criteria = new CDbCriteria;
												// $criteria->compare('position_id',$value);
												if ($Leval != "" || $Position != "") {
													$criteria->compare('branch_id',$value);
												}
												if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
												}
												$criteria->compare('superuser',0);
												$criteria->compare('del_status',0);
												$criteria->compare('status',1);
												$criteria->compare('register_status',1);
												$criteria->addCondition('profile.user_id=id');
												$users_count = Users::model()->findAll($criteria);
												
												$cou_use = count($users_count);	
											$criteria = new CDbCriteria;
											// $criteria->compare('position_id',$value);
											if ($Leval != "" || $Position != "") {
													$criteria->compare('branch_id',$value);
												}
											if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
											}
											
											$criteria->compare('superuser',0);
											$criteria->compare('del_status',0);
											$criteria->compare('register_status',1);
											$criteria->addCondition('profile.user_id=id');
											$usersAll = Users::model()->findAll($criteria);		
											$cou_useAll = count($usersAll);
											$sumtotal += $cou_useAll;
											// var_dump($sumtotal);
											$per_cen = ($cou_use * 100 ) / $sumtotal_end;

											
		
											$datatable .= '<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
											$datatable .= '<td class="text-center">'.$i++.'</td>';
											$datatable .= '<td class="text-center">'.$names_dep[$key].'</td>';
											$datatable .= '<td class="text-center">'.$name_pos[$key].'</td>';
											if ($Leval != "" || $Position != "") {
												$datatable .= '<td class="text-center">'.$names_level[$key]
												.'</td>';
											}
											if ($cou_use != 0) {
												$datatable .= '<td class="text-center">'.$cou_use.'</td>';
											}else{
												$datatable .= '<td class="text-center">-</td>';
											}
											
											if($TypeEmployee != 2){
												if (Yii::app()->session['lang'] == 1) {		
												$datatable .= '<td class="text-center">';
													if($cou_use > 0){
														if ($status == 1) {
															$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;Approved</span>';
														}else if ($status == 0){
															$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Disapproval</span>';
														}else{
															$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Suspension</span>';
														}
													}else{
														$datatable .= '-';
													}
												
												$datatable .= '</td>';
												}else{
												$datatable .= '<td class="text-center">';
													if($cou_use > 0){
														if ($status == 1) {
															$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
														}else if ($status == 0){
															$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
														}else{
															$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ระงับการใช้งาน</span>';
														}
													}else{
														$datatable .= '-';
													}
													$datatable .= '</td>';
												}
												
											}
											if($cou_use > 0){
												$datatable .= '<td class="text-center">'.round($per_cen, 2).' %</td>';
											}else{
												$datatable .= '<td class="text-center">-</td>';
											}
											$datatable .= '</tr>';
										}
										}
										
									}

									foreach ($pos_back as $keypos_back => $valuepos_back) { 	
										
										$criteria = new CDbCriteria;
										$criteria->with = array('profile');
										$criteria->compare('profile.type_employee',$TypeEmployee);
										$criteria->compare('position_id',$valuepos_back->id);
										$criteria->compare('department_id',$valuepos_back->Departments->id);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {


											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										
										if ($status != null) {

											if ($status == "1") {
												$criteria->compare('register_status',1);
												$criteria->compare('status',1);
											}
											if($status == "0"){
												$criteria->compare('register_status',0);
												//$criteria->compare('status',0);				
											}
											if ($status == "2") {
												$criteria->compare('register_status',1);
												$criteria->compare('status',0);
											}
										}

										$users = Users::model()->findAll($criteria);
										$criteria = new CDbCriteria;
										$criteria->compare('position_id',$valuepos_back->id);
										$criteria->compare('department_id',$valuepos_back->Departments->id);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {
											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										$criteria->compare('status',array(0,1));
										if ($_POST['status'] == 1){
											$criteria->compare('register_status',array(0,1));
										}else{
											$criteria->compare('register_status',array(0,1));
										}
	
										$criteria->compare('superuser',0);
										$criteria->addCondition('profile.user_id=id');
										$usersAll = Users::model()->findAll($criteria);
										$cou_use = count($users);
										$cou_useAll = count($usersAll);

										
										if ($cou_useAll > 0){
											$sumtotal += $cou_useAll;
											$SUM_user[] = $cou_use;
											$per_cen = ($cou_use * 100)/ $cou_useAll; 

											$datatable .= '<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
											$datatable .= '<td class="text-center">'.$i++.'</td>';
											$datatable .= '<td class="text-center">'.$valuepos_back->Departments->dep_title.'</td>';
											$datatable .= '<td class="text-center">'.$valuepos_back->position_title.'</td>';
											if($TypeEmployee != 1){
												$datatable .= '<td></td>';
											}
											$datatable .= '<td class="text-center">'.$cou_useAll.'</td>';
											
											if($TypeEmployee != 2){
												if ($status != 0){
													$datatable .= '<td class="text-center">'.$cou_use.'</td>';
												}else{
													$datatable .= '<td class="text-center">'.$cou_use.'</td>';
												}
													if (Yii::app()->session['lang'] == 1) {		
													$datatable .= '<td class="text-center">';
														if($cou_use > 0){
															if ($status == 1 ) {
																$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;Approved</span>';
															}else if ($status == 0 ){
																$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Disapproval</span>';
															}else{
																$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Suspension</span>';
															}
														}else{
															if ($status == 1){
																$datatable .= '-';
															}
														}
													
													$datatable .= '</td>';
													}else{
													$datatable .= '<td class="text-center">';
														if($cou_use > 0){
															if ($status == 1 ) {
																$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
															}else if ($status == 0 ){
																$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
															}else{
																$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ระงับการใช้งาน</span>';
															}
														}else{
															$datatable .= '-';
														}
														$datatable .= '</td>';
													}
													
												}	
											if($cou_use > 0){
												$datatable .= '<td class="text-center">'.round($per_cen, 2).' %</td>';
											}else{
												$datatable .= '<td class="text-center">-</td>';
											}
											$datatable .= '</tr>';
										}


									}  
									if ($TypeEmployee != 2) {
								
										if ($status == 1 ) {
											
											$per_cent_new = (array_sum($SUM_user) * 100) / $total_new;
										}else{
											$per_cent_new = (array_sum($SUM_user) * 100) / $total_new;
										}
										$datatable .= '<tr style="border:2px solid #8B8386;">';
											$datatable .= '<td class="text-center" colspan=3 style="text-align:right;border:2px;solid;#8B8386"><span style="font-weight:bold;">';
											if (Yii::app()->session['lang'] == 1) {
												$datatable .= "Total";
											}else{
												$datatable .= "รวม";
											}
											$datatable .= '</span></td>';
											

											$datatable .= '<td class="text-center" style="border:2px solid #8B8386;"><span style="font-weight:bold;">'.$total_new.'</span></td>';
											$datatable .= '<td class="text-center" style="border:2px solid #8B8386;"><span style="font-weight:bold;">'.array_sum($SUM_user).'</span></td>';
											$datatable .= '<td class="text-center" style="border:2px solid #8B8386;"></td>';
											$datatable .= '<td class="text-center" style="border:2px solid #8B8386;"><span style="font-weight:bold;">'.round($per_cent_new,2).'%</span></td>';
										$datatable .= '</tr>';	
									}

									foreach ($dep_back as $keydep_back => $valuedep_back) { 

										$criteria = new CDbCriteria;
										$criteria->compare('department_id',$valuedep_back->id);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										$criteria->compare('status',1);
										$criteria->compare('register_status',1);
										$users = Users::model()->findAll($criteria);
										 $criteria = new CDbCriteria;
										 $criteria->compare('department_id',$valuedep_back->id);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
				
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										$criteria->compare('register_status',1);
										$usersAll = Users::model()->findAll($criteria);

										$cou_use = count($users);
										$search_new = true;
										$cou_useAll = count($usersAll);
										$per_cen = ($cou_useAll * 100)/ $total_new;

										$datatable .= '<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
										$datatable .= '<td>'.$i++.'</td>';
										$datatable .= '<td>'.$valuedep_back->dep_title.'</td>';
										$datatable .= '<td class="text-center">-</td>';
										if ($Leval != "") {
										$datatable .= '<td class="text-center">-</td>';
										}
										$datatable .= '<td class="text-center">'.$cou_use.'</td>';
									if($cou_use > 0){
											$datatable .= '<td class="text-center">'.round($per_cen, 2).' %</td>';
										}else{
											$datatable .= '<td class="text-center">-</td>';
										}
										$datatable .= '</tr>';
									}  	
									if ($TypeEmployee == 2){
										if ($search_new){
											$sumtotal += $cou_useAll;
										}
										if ($Position == ""){
											$percent_new = ( $sumtotal * 100) / $total_new;
										}
										else{
										$percent_new = ( $sumtotal_end * 100) / $sumtotal_end;
									}
										if ($total_new <= 0){ $percent_new = 0;}
										if(Yii::app()->session['lang'] != 1){
											$txtgrand = "จำนวนทั้งหมด";
										}else{
											$txtgrand = "Grand Total";
										}
										if ($Leval != "" || $Position != ""){
											$datatable .= "<tr style='border:2px solid #8B8386;'><td colspan=4 style='text-align:right'><b>" .$txtgrand. "</b></td>";
										}else{
											$datatable .= "<tr style='border:2px solid #8B8386;'><td colspan=3 style='text-align:right'><b>" .$txtgrand. "</b></td>";
										}
										$datatable .= "<td class='text-center'><b>" .$sumtotal. "</b></td>";
										$datatable .= "<td class='text-center'><b>" .intval($percent_new). "%</b></td></tr>";
									}
								}else{
									$datatable .= '<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">';
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
					?>
</body>