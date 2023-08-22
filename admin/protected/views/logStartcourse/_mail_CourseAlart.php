<html>
<head>
	<title></title>
	<style type="text/css">
</style>
</head>
<body>
	<h4>เรียน : <?= $User->profile->firstname.' '.$User->profile->lastname; ?></h4>
	<h4>กรุณาเข้าเรียนหลักสูตร <?= $CourseOnline->course_title; ?> <?= $CourseGeneration != null ? "( รุ่น ".$CourseGeneration->gen_title.")" : ""; ?></h4>  
	<?php 
	$period_start = "";
	$period_end = "";
	if ($CourseGeneration != null) {
		$period_start = Helpers::lib()->changeFormatDate($CourseGeneration->gen_period_start,'datetime');
		$period_end = Helpers::lib()->changeFormatDate($CourseGeneration->gen_period_end,'datetime');
	} else {
		$period_start = Helpers::lib()->changeFormatDate($CourseOnline->course_date_start,'datetime');
		$period_end = Helpers::lib()->changeFormatDate($CourseOnline->course_date_end,'datetime');
	}
	?>
	<h4> ให้เสร็จภายในวันที่ ให้เสร็จภายในวันที่ <?= $period_start; ?> ถึง <?= $period_end; ?> </h4>

</body>
</html>