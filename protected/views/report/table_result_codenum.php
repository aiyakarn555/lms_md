<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $lang_id = Yii::app()->session['lang'] = 1;
} else {
    $lang_id = Yii::app()->session['lang'];
}

if($lang_id == 1){
	$number = "No.";
	$candidateName = "Candidate Name";
	$preName = "Prefix Name";
	$fName = "First Name";
	$lName = "Last Name";
	$course = "Course";
	$courseNumber = "Course Number";
	$passNumber = "Certificate Number";
	$startLearn = "Start Learn";
	$endLearn = "End Learn";
	$note = "Note";
}else{
	$number = "ลำดับ";
	$candidateName = "ชื่อสถาบันศึกษา";
	$preName = "คำนำหน้าชื่อ";
	$fName = "ชื่อ";
	$lName = "นามสกุล";
	$course = "ชื่อหลักสูตร";
	$courseNumber = "รหัสหลักสูตร";
	$passNumber = "เลขที่ ปก.";
	$startLearn = "ตั้งแต่วันที่";
	$endLearn = "ถึงวันที่";
	$note = "หมายเหตุ";
}

?>

<table class="table table-bordered table-striped" id="myTable">
	<thead>
		<tr>
			<th  class="center" ><?=$number?></th>
			<th  class="center" ><?=$candidateName?></th>
			<th  class="center" ><?=$preName?></th>
			<th  class="center" ><?=$fName?></th>
			<th  class="center" ><?=$lName?></th>
			<th  class="center" ><?=$course?></th>
			<th  class="center" ><?=$courseNumber?></th>
			<th  class="center" width="140"><?=$passNumber?></th>
			<th  class="center" width="150"><?=$startLearn?></th>
			<th  class="center" width="150"><?=$endLearn?></th>
			<th  class="center" width="100"><?=$note?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$getPages = $_GET['page'];
		if($getPages = $_GET['page']!=0 ){
			$getPages = $_GET['page'] -1;
		}

		$start_cnt = $dataProvider->pagination->pageSize * $getPages;

		if(count($PassCourses) > 0){
			foreach($PassCourses as $i => $val) { ?>
				<tr>
					<td ><?= $start_cnt+1?></td>
					<td >โรงเรียนสุภาพบุรุษเดินเรือ</td>
					<td ><?= $val->Profiles->ProfilesTitle->prof_title ?></td>
					<td ><?= $val->Profiles->firstname ?></td>
					<td ><?= $val->Profiles->lastname ?></td>
					<td ><?= $val->CourseOnlines->course_title ?></td>
					<td ><?= $val->CourseOnlines->course_number ?></td>
					<td ><?= $val->passcours_number ?></td>
					<td ><?= Helpers::lib()->changeFormatDateNewEn($val->cours_start_date ,'full')  ?></td>
					<td ><?= Helpers::lib()->changeFormatDateNewEn($val->passcours_date ,'full')  ?></td>
					<td >-</td>
				</tr>
				<?php
				$start_cnt++;
			}
		}else{

			foreach($PassCourseImport as $ii => $value) { 

				$couOn = CourseOnline::model()->find(array(
					'condition' => 'course_md_code="' . $value->course_md_id . '"',
				));

				$InsOn = Institution::model()->find(array(
					'condition' => 'code="' . $value->institution_id . '"',
				));
				?>
				<tr>
					<td ><?= $start_cnt+1?></td>
					<td ><?= $InsOn->institution_name ?></td>
					<td ><?= $value->title ?></td>
					<td ><?= $value->fname ?></td>
					<td ><?= $value->lname ?></td>
					<td ><?= $couOn->course_title ?></td>
					<td ><?= $couOn->course_number ?></td>
					<td ><?= $value->course_number ?></td>

					<td ><?= Helpers::lib()->changeFormatDateNewEn($value->startdate ,'full')  ?></td>
					<td ><?= Helpers::lib()->changeFormatDateNewEn($value->enddate ,'full')  ?></td>
					<td ><?= $value->note ?></td>

				</tr>
				<?php
				$start_cnt++;
			}

		}


		?>
	</tbody>
</table>