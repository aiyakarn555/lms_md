
<?php
$Department = $data['Department'];
$Position = $data['Position'];
$Leval = $data['Leval'];
$datetime_start = $data['datetime_start'];
$datetime_end = $data['datetime_end'];
// $Year_start = $data['Year_start'];
// $Year_end = $data['Year_end'];
$Chart = $data['Chart'];
// $start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
// $end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
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
	<div class="row">
		<h1>
		<?php
		if (Yii::app()->session['lang'] == 1) {
			echo "Report register office";
		}else{
			echo "รายงานภาพรวมการสมัครสมาชิก คนออฟฟิศ";
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
					if($Department){
						$criteria->compare('id',$Department);
					}
					if ($authority == 2 || $authority == 3) {
                                         
                        $criteria->compare('id',$user_Department);
                    }
					$criteria->compare('active','y');
					$criteria->compare('type_employee_id',2);
	
					$dep = Department::model()->findAll($criteria);
					$dep_arr = [];
					foreach ($dep as $key => $val_dep) {
						$dep_arr[] = $val_dep->id;
					}

					$criteria = new CDbCriteria;
					$criteria->addIncondition('department_id',$dep_arr);
					$criteria->order = 'position_title ASC';
					$criteria->compare('active','y');
					if($Position){
						$criteria->compare('id',$Position);
					}
					if ($authority == 3) {
                                         
                        $criteria->compare('id',$user_Position);
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
					$branch = Branch::model()->findAll($criteria);

					$branch_arr = [];
					foreach ($branch as $key => $val_branch) {
						$branch_arr[] = $val_branch->position_id;
					}
					$result_branch_arr = array_unique( $branch_arr );
					$result_pos_arr = array_unique( $posback_arr );

					$criteria = new CDbCriteria;
					$criteria->with = array('profile','department','position');
					$criteria->compare('user.department_id',$dep_arr);
					$criteria->compare('superuser',0);
					$criteria->compare('del_status',0);
					if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {
						$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
					}
					if($Position){
						$criteria->compare('position_id',$Position);
					}else{
						//$criteria->compare('position_id',$pos_arr);	
					}
					if ($Leval != "") {
						if ($Leval) {
							$criteria->compare('branch_id',$Leval);
						}
					}else{
						if ($authority == 3) {
                                         
        				$criteria->compare('branch_id',$user_Level);
    					}
					}
					$criteria->addCondition("profile.user_id=User.id");
					if($Position == "" && $Department == ""){
						if (Yii::app()->session['lang'] == 1) {
						$criteria->order = 'profile.firstname_en ASC';
						}else{
						$criteria->order = 'profile.firstname ASC';
						}
					}
					if($Department != "" || $Position != ""){
						if (Yii::app()->session['lang'] == 1) {
						$criteria->order = 'profile.firstname_en ASC,position.position_title ASC';
						}else{
						$criteria->order = 'profile.firstname ASC,position.position_title ASC';
						}
					}
					$User = User::model()->findAll($criteria);
	if ($Year_start == null && $Year_end == null) {
	?>
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

		<div class="report-table">
			<p style="text-align: right;"><?php echo Yii::app()->session['lang'] == 1?"No. of Staff":"จำนวนผู้สมัครทั้งหมด"; ?> <span style="font-weight:bold;"><?php echo count($User); ?></span> <?php echo Yii::app()->session['lang'] == 1?"People":"คน"; ?></p>
			<div class="table-responsive w-100 t-regis-language">
				<table class="table" style="border:1px solid #d8d8d8;border-collapse: collapse;width: 100%;">       
					<thead>
						<tr style="background: #010C65;color: #fff; border:1px solid #d8d8d8;padding: 8px;">
							<?php
							if (Yii::app()->session['lang'] == 1) { ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">No.</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Fullname</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Department</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Position</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Leval</th>
							<?php }else{ ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">ลำดับ</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">ชื่อ - สกุล</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">ฝ่าย</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">แผนก</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">ระดับตำแหน่ง</th>
						<?php	}
							?>
							
						</tr>
					</thead>
					<tbody>
						<?php
						if (!empty($User)) { 
							$i = 1;
						foreach ($User as $key => $value) { ?>	

							<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
								<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $i++; ?></td>
								<?php if (Yii::app()->session['lang'] == 1) { ?>
								<td style="border:1px solid #d8d8d8; padding: 8px;text-align: left;"><?php echo $value->profile->firstname_en; ?> <?php echo $value->profile->lastname_en; ?></td>
								<?php }else{ ?>
								<td style="border:1px solid #d8d8d8; padding: 8px;text-align: left;"><?php echo $value->profile->firstname; ?> <?php echo $value->profile->lastname; ?> 
								</td><?php } ?>
								<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $value->department->dep_title; ?></td>
								<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $value->position->position_title; ?></td>
								<?php if ($value->branch_id != "") { ?>
									<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $value->branch->branch_name; ?></td>
								<?php }else{ ?>
									<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo "-"; ?></td>
								<?php }

								?>
							</tr>

						<?php }
					}else{ ?>
							<tr>
								 <td colspan="4">
                                    <?php 
                                    if(Yii::app()->session['lang'] != 1){
                                        echo "ไม่มีข้อมูล";
                                    }else{
                                        echo "No data";
                                    }
                                    ?></td>
							</tr>

					<?php }  ?>

					</tbody>
				</table>
			</div>
		</div>
	<?php 
	}
	 ?>

</body>
</html>