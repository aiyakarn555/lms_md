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


$criteria = new CDbCriteria;
$criteria->with = array('Profiles', 'CourseOnlines', 'user');

if($model->search != null){
	$ex_fullname = explode(" ", $model->search);

	if(isset($ex_fullname[0])){
		$pro_fname = $ex_fullname[0];
		$criteria->compare('Profiles.firstname_en', $pro_fname, true);
		$criteria->compare('Profiles.lastname_en', $pro_fname, true, 'OR');

		$criteria->compare('Profiles.firstname', $pro_fname, true, 'OR');
		$criteria->compare('Profiles.lastname', $pro_fname, true, 'OR');
	}

	if(isset($ex_fullname[1])){
		$pro_lname = $ex_fullname[1];
		$criteria->compare('Profiles.lastname',$pro_lname,true);
		$criteria->compare('Profiles.lastname_en', $pro_lname, true, 'OR');
	}
}

$criteria->compare('superuser',0);
$criteria->addCondition('user.id IS NOT NULL');

if($model->passcours_cours != null) {
	$criteria->compare('passcours_cours', $model->passcours_cours);
}

if(isset($model->gen_id) && $model->gen_id != null) {
	$criteria->compare('gen_id', $model->gen_id);
}

if($model->type_register != null) {
	$criteria->compare('Profiles.type_employee', $model->type_register);
}

if($model->department != null) {
	$criteria->compare('user.department_id',$model->department);
}

if($model->position != null) {
	$criteria->compare('user.position_id',$model->position);
}

if($model->period_start != null) {
	$criteria->compare('passcours_date >= "' . date('Y-m-d 00:00:00', strtotime($model->period_start)) . '"');
}
if($model->period_end != null) {
	$criteria->compare('passcours_date <= "' . date('Y-m-d 23:59:59', strtotime($model->period_end)) . '"');
}

$criteria->order = 'Profiles.type_employee ASC, Profiles.firstname_en ASC';


$Passcours = Passcours::model()->findAll($criteria);

// var_dump(count($Passcours)); exit();
?>

<h4>รายงานผู้ผ่านการเรียน</h4>
<br>
<table>
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th>ประเภทพนักงาน</th>
			<th>Name – Surname</th>
			<th>ชื่อ - นามสกุล</th>
			<th>รหัสบัตรประชาชน</th>
			<th>Passport No.</th>
			<th>Employee no.</th>
			<th>แผนก</th>
			<th>ตำแหน่ง</th>
			<th>หลักสูตร</th>
			<th>รุ่น</th>
			<th>วันที่สอบผ่าน</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(!empty($Passcours) && $model->passcours_cours != null && $model->gen_id != null){
			$no = 1;
			foreach ($Passcours as $key => $data) {
				?>
				<tr>
					<td><?php echo $no; $no++; ?></td>
					<td><?= $data->profile->typeEmployee->type_employee_name ?></td>
					<td><?= $data->Profiles->firstname_en." ".$data->Profiles->lastname_en ?></td>
					<td><?= $data->Profiles->firstname." ".$data->Profiles->lastname ?></td>
					<td><?= $data->user->identification ?></td>
					<td><?= $data->Profiles->passport ?></td>
					<td><?php if($data->profile->type_employee == 2){ echo $data->user->username; } ?></td>
					<td><?= $data->user->department->dep_title ?></td>
					<td><?= $data->user->position->position_title ?></td>
					<td><?= $data->CourseOnlines->course_title ?></td>
					<td><?php if($data->gen_id != 0){ echo "รุ่น ".$data->gen->gen_title; } ?></td>
					<td><?= Helpers::lib()->changeFormatDate($data->passcours_date, 'datetime') ?></td>
				</tr>
				<?php
			}
		}else{
			?>
			<tr><td colspan="12">ไม่มีข้อมูล</td></tr>
			<?php
		}

		 ?>		
	</tbody>
</table>