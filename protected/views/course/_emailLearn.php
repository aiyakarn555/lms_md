<html>
<head>
	<title></title>
	<style type="text/css">
		h4,h5, .md {
			/* color: #aaa; */
		}
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td, th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}
		th {
			background-color: #dddddd !important;
		}
		tr:nth-child(even) {
			background-color: #dddddd;
		}

		.pass{
			color: #00ff14 !important;
		}
		
		.learning{
			color: #9a9c0a !important;
		}

		.notLearn{
			color: #e42929 !important;
		}	
	</style>
</head>
<body>
	<h4>หัวข้อ : ผลการเรียน</h4>
	<h4>เรียน   : คุณ  <?= $modelUser->profile->firstname.' '.$modelUser->profile->lastname; ?></h4>
	<h4>ผลการเรียน หลักสูตร  : <?= $modelCourseName->course_title ?> </h4>
	<table>
		<tr>
			<th>ลำดับ</th>
			<th>บทเรียน</th>
			<th>สถานะ</th>
			<th>วัน/เดือน/ปี  เวลา</th>
			<?php  
			foreach ($learn as $key => $value) {
				$checkLessonPass = Helpers::lib()->checkLessonPass($value->LessonMapper);
				if($checkLessonPass == 'pass'){
					$statusLearn = '<b>เรียนผ่าน</b>';
				} else if($checkLessonPass == 'learning'){
					$statusLearn = '<b>กำลังเรียน</b>';
				} else {
					$statusLearn = '<b>ยังไม่ได้เรียน</b>';
				}
				?>
				<tr>
					<td><?= ($key+1)  ?></td>
					<td><?= $value->LessonMapper->title ?></td>
					<td class="<?= $checkLessonPass; ?>"><?= $statusLearn; ?></td>
					<td><?= $date = Helpers::lib()->changeFormatDate($value->learnfileDate->learn_file_date,'datetime') ?></td>
				</tr>
				<?php
			} 
			?>
		</table>
	</body>
	</html>