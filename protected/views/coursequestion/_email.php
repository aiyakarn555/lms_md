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
			color: #05af13 !important;
		}
		
		.learning{
			color: #9a9c0a !important;
		}

		.notLearn{
			color: #e42929 !important;
		}	
		.box-email{
			    padding: 0px 0px 30px;
			    background-color: #fff;
		        box-shadow: -2px 3px 13px 0px #0000004f;
		}
		.box-email h4{
			padding-left: 20px;
			font-weight: 400;
		}

		.box-email h4 span{
			font-weight: 600;
		}

		.title-learn{
			background-color: #222;
		    padding: 20px 0 20px 20px;
		    color: #fff;
		}
		span.passorno{
			font-weight: 600;
		}
		span.exams-list{
		    padding-left: 40px;
		}
		h4.prepost_test span{
			border-bottom: 1px solid red;
   		 	padding-bottom: 4px;
		}

	</style>
</head>
<body>
	<div class="box-email">
		<!-- <h3 class='title-learn'>หัวข้อ : ผลการเรียน</h3> -->
		<h4>เรียน   : <span> <?= $modelUser->profile->firstname.' '.$modelUser->profile->lastname; ?></span></h4>
		<h4>หลักสูตร  : <span><?= $modelCourseName->course_title ?> </span></h4>
		
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
		<h4>ผลการเรียน บทที <span> <?= ($key+1) ?> </span> : <span>	<?= $value->LessonMapper->title ?> </span></h4>
		<h4>สถานะการเรียน : <span class="<?= $checkLessonPass; ?>"> <?= $statusLearn; ?></span> </h4>
		<!-- Pre test -->
		<?php 
		$criteria = new CDbCriteria;
		$criteria->compare('lesson_id', $value->LessonMapper->id);
		$criteria->compare('user_id',$user_id);
		$criteria->compare('active','y');
		$criteria->compare('type','pre');
		$criteria->order = 'score_id';
		$scorePre = Score::model()->findAll($criteria);
		?>
			<?php 
				if($scorePre){
					?>
					<h4  class="prepost_test"><span>ผลสอบก่อนเรียน</span> </h4>
					<span class="exams-list">
					<?php
					foreach ($scorePre as $key => $scoreP) {
						?>
					ผลสอบครั้งที่</span><span class="passorno"> <?= ($key+1); ?> :  <?= ($scoreP->score_number); ?>/  <?= ($scoreP->score_total); ?> (<?= ($scoreP->score_past == "y")? 'ผ่าน':'ไม่ผ่าน' ?>)</span><br>
						
						<?php
					}
				}
			 ?>
		<!-- Post test -->
		<?php 
		$criteria = new CDbCriteria;
		$criteria->compare('lesson_id', $value->LessonMapper->id);
		$criteria->compare('user_id',$user_id);
		$criteria->compare('active','y');
		$criteria->compare('type','post');
		$criteria->order = 'score_id';
		$scorePosts = Score::model()->findAll($criteria);
		?>
			<?php 
				if($scorePosts){
					?>
					<h4 class="prepost_test"><span>ผลสอบหลังเรียน</span> </h4>
					<span class="exams-list">
					<?php
					foreach ($scorePosts as $key => $scorePost) {
						?>
					ผลสอบครั้งที่</span>  <span class="passorno"><?= ($key+1); ?> :  <?= ($scorePost->score_number); ?>/  <?= ($scorePost->score_total); ?> (<?= ($scorePost->score_past == "y")? 'ผ่าน':'ไม่ผ่าน' ?>)</span><br>
						
						<?php
					}
				}
			 ?>

		<?php } ?>
		
		<?php 
		$criteria = new CDbCriteria;
		$criteria->compare('course_id', $modelCourseName->course_id);
		$criteria->compare('user_id',$user_id);
		$criteria->compare('active','y');
		$criteria->order = 'score_id';
		$score_course = Coursescore::model()->findAll($criteria);
		?>
		<?php 
		if($score_course){
			?>
			<h4  class="prepost_test"><span>ผลการทดสอบหลักสูตร</span></h4>
			
				<?php foreach ($score_course as $key => $scoreC) { ?>
					<span class="exams-list">
					ผลทดสอบครั้งที่  <span class="passorno"><?= ($key+1); ?> :  <?= ($scoreC->score_number); ?>/ <?= ($scoreC->score_total); ?> [<?= ($scoreC->score_past == "y")? 'ผ่าน':'ไม่ผ่าน' ?>]</span>
					</span>
					<br>
				<?php
					} 
			} 
		?>
		




		<br>
		<br>
		<br>
		<br>
		<h4>Dear   : <span> <?= $modelUser->profile->firstname_en.' '.$modelUser->profile->lastname_en; ?></span></h4>
		<h4>Course : <span><?= $modelCourseName->course_title ?> </span></h4>
		<?php 
		foreach ($learn as $key => $value) {
			$checkLessonPass = Helpers::lib()->checkLessonPass($value->LessonMapper);
			if($checkLessonPass == 'pass'){
				$statusLearn = '<b>Pass</b>';
			} else if($checkLessonPass == 'learning'){
				$statusLearn = '<b>Not Pass</b>';
			} else {
				$statusLearn = '<b>Not Learn</b>';
			}
		?>
		<h4>Chapter <span> <?= ($key+1) ?> </span> : <span>	<?= $value->LessonMapper->title ?> </span></h4>
		<h4>Study Situation : <span class="<?= $checkLessonPass; ?>"> <?= $statusLearn; ?></span> </h4>
		<!-- Pre test -->
		<?php 
		$criteria = new CDbCriteria;
		$criteria->compare('lesson_id', $value->LessonMapper->id);
		$criteria->compare('user_id',$user_id);
		$criteria->compare('active','y');
		$criteria->compare('type','pre');
		$criteria->order = 'score_id';
		$scorePre = Score::model()->findAll($criteria);
		?>
			<?php 
				if($scorePre){
					?>
					<h4  class="prepost_test"><span>Pre Test score</span> </h4>
					
					<?php
					foreach ($scorePre as $key => $scoreP) {
						?>
					<span class="exams-list">Pre Test <span class="passorno"> <?= ($key+1); ?> :  <?= ($scoreP->score_number); ?>/  <?= ($scoreP->score_total); ?> (<?= ($scoreP->score_past == "y")? 'Pass':'Fail' ?>)</span></span><br>
						
						<?php
					}
				}
			 ?>

		<?php 
		$criteria = new CDbCriteria;
		$criteria->compare('lesson_id', $value->LessonMapper->id);
		$criteria->compare('user_id',$user_id);
		$criteria->compare('active','y');
		$criteria->compare('type','post');
		$criteria->order = 'score_id';
		$scorePosts = Score::model()->findAll($criteria);
		?>
			<?php 
				if($scorePosts){
					?>
					<h4 class="prepost_test"><span>Test score</span> </h4>
					<span class="exams-list">
					<?php
					foreach ($scorePosts as $key => $scorePost) {
						?>
					<span class="exams-list">Test   <span class="passorno"><?= ($key+1); ?> :  <?= ($scorePost->score_number); ?>/  <?= ($scorePost->score_total); ?> (<?= ($scorePost->score_past == "y")? 'Pass':'Fail' ?>)</span></span><br>
						
						<?php
					}
				}
			 ?>

		<?php } ?>








		<?php 
		if($score_course){
			?>
<h4  class="prepost_test"><span>Exams score</span></h4>

<?php foreach ($score_course as $key => $scoreC) { ?>
<span class="exams-list">
Test  <span class="passorno"><?= ($key+1); ?> :  <?= ($scoreC->score_number); ?>/ <?= ($scoreC->score_total); ?> [<?= ($scoreC->score_past == "y")? 'Pass':'Fail' ?>]</span>
</span>
<br>
<?php }  
}  ?>

</div>
	</body>
	</html>