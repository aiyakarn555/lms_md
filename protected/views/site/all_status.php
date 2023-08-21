<style type="text/css">
	table > tbody > tr > td {
		text-align: center;
	}
	span{font-size: 13px;}
	.sidebar {
	margin-bottom: 0;
	}
	.sidebar .widget{
		min-height: 35em;
		max-height: 35em;
		overflow-y: auto;
	}
	.sidebar .widget-popular-posts .widget-thumb-right {
	float: right;
	margin-left: 8px;
		position: relative;
	}
	.list-unstyled {
	list-style: none !important;
	}
	.knob-label{text-align: center;}
	ul.status{
		margin-bottom: 0 !important;
	}
	.knob-label{text-align: center;}
	ul.status > li{
		border-bottom: none !important;
		margin-bottom: 2px !important;
	padding-bottom: 2px !important;
	}
	.widget-content{padding-right: 1em;}
		.sidebar .widget-popular-posts .widget-content h5 {
	font-weight: bold;
	font-size: 15px;
	}
		.sidebar .widget-popular-posts .widget-content h5 a {
	color: #4B2775;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    vertical-align: middle;
}
</style>
<?php 
	$course = CourseOnline::model()->findAllByAttributes(array(
		'active'=>'y',
	),array('order'=>'sortOrder ASC'));
	if(is_numeric($_GET['course'])){
		$course = CourseOnline::model()->findAllByAttributes(array(
			'active'=>'y',
			'course_id'=>$_GET['course']
		));
	}
?>
<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
    <div class="container">
        <h1>Dashboard
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>">หน้าแรก</a></li>/ 
                    <li><a href="<?php echo $this->createUrl('/site/dashboard'); ?>">Dashboard</a></li>
                </ul>
            </small>
        </h1>
    </div>
    <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
</div>	
<div id="content">
	<div class="container z-depth-5 bg-white">
		<div class="row pd-1em">
			<div class="col-md-12 bg-white">
				<!-- Classic Heading -->
				<h4 class="classic-title center"><span>สถานะทั้งหมด</span></h4>
				<!-- Toggle -->
				
				<div class="panel-group">
					<!-- Start Toggle 1 -->
					
				    <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							
							<a data-toggle="collapse" data-parent="#toggle" href="#collapse-<?= $i ?>" class="" aria-expanded="true">
								<i class="fa fa-angle-up control-icon"></i>
								<i class="fa fa-book"></i> สถานะทั้งหมด <span class="badge"></span>
							</a>
							</h4>
						</div>
						<div id="collapse-<?= $i ?>" class="panel-collapse collapse in" aria-expanded="true">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr class="active">
										    	<th>ลำดับ</th>
											    <th>หมวดวิชา</th>
											    <th>วิชา</th>
											    <th>สถานะ</th>
											</tr>
										</thead>
										<tbody>
										<?php 
											$criteria = new CDbCriteria;
								            $criteria->condition = 'active="y"';
											$category = category::model()->findAll($criteria);
											$i = 1;
											foreach ($category as $key => $value) {
												$criteria = new CDbCriteria;
									            $criteria->condition = 'active="y" AND status="1" AND cate_id="'.$value->cate_id.'"';
												$course = CourseOnline::model()->findAll($criteria);
											?>
											<tr>
												<td rowspan="<?= count($course) ?>"><?= $i ?></td>
												<td rowspan="<?= count($course) ?>"><?= $value->cate_title ?></td>
											<?php
												foreach ($course as $key => $data) {
													$checkLessonPass = Helpers::lib()->checkCourseLearnStatus($data->course_id);
													if($checkLessonPass == 'pass'){
														$status = '<span style="color:green">ผ่าน</span>';
													} else if($checkLessonPass == 'learning'){
														$status = '<span style="color:blue">กำลังเรียน</span>';
													} else if($checkLessonPass == 'notPass'){
														$logReset = LogResetLearn::model()->findByAttributes(array(
															'course_id'=>$data->course_id,
															'user_id'=>Yii::app()->user->id,
														));
														if($logReset){
															$status = '<span style="color:red">ยกเลิกการเรียน ('.Helpers::lib()->changeFormatDate($logReset->update_date).')</span>';
														} else {
															$status = '<span style="color:red">ไม่ได้เข้าเรียน</span>';
														}
													}
													?>
											<!-- <tr> -->
												<!-- <td>ฟหก</td> -->
												<td rowspan=""><?= $data->course_title ?></td>
												<td rowspan=""><?= $status ?></td>
											</tr>
													<?php
												}
											$i++; }
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Toggle -->
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(function () {
/* jQueryKnob */
$(".knob").knob({
draw: function () {
// "tron" case
if (this.$.data('skin') == 'tron') {
var a = this.angle(this.cv)  // Angle
, sa = this.startAngle          // Previous start angle
, sat = this.startAngle         // Start angle
, ea                            // Previous end angle
, eat = sat + a                 // End angle
, r = true;
this.g.lineWidth = this.lineWidth;
this.o.cursor
&& (sat = eat - 0.3)
&& (eat = eat + 0.3);
if (this.o.displayPrevious) {
ea = this.startAngle + this.angle(this.value);
this.o.cursor
&& (sa = ea - 0.3)
&& (ea = ea + 0.3);
this.g.beginPath();
this.g.strokeStyle = this.previousColor;
this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
this.g.stroke();
}
this.g.beginPath();
this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
this.g.stroke();
this.g.lineWidth = 2;
this.g.beginPath();
this.g.strokeStyle = this.o.fgColor;
this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
this.g.stroke();
return false;
}
}
});
/* END JQUERY KNOB */
});
</script>