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
<div class="page-banner">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2 class="text-white">Dashboard</h2>
				<p class="grey lighten-1">DBD Academy</p>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumbs">
					<li><a href="/lms_dbd/site/index">หน้าแรก</a></li>
					<li>Dashboard</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div id="content">
	<div class="container z-depth-5 bg-white">
		<div class="row">
			<div class="col-md-6 sidebar pd-1em text-center" style="padding-right: 2em;">
				<img class="img-thumbnail" style="width:100px;margin-bottom: 1em;" alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/avatar.png">
				<p><strong class="accent-color">ชื่อ :</strong> Rathanont Sukhapant</p>
				<p><strong class="accent-color">รหัสผ่าน :</strong> Abcd1234!@#$</p>
			</div>
			<div class="col-md-6 sidebar pd-1em" style="padding-left: 2em;">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr class="bg-dbd25">
								<th>วิชา</th>
								<th>สถานะ</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>วิชา 1</td>
								<td>
									<div class="skill">
										<!-- <p>Web Design</p> -->
										<div class="progress">
											<div class="progress-bar" role="progressbar" data-percentage="60" style="width: 60%;">
												<span class="progress-bar-span">60%</span>
												<span class="sr-only">60% Complete</span>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>วิชา 2</td>
								<td>
									<div class="skill">
										<!-- <p>Wordpress</p> -->
										<div class="progress">
											<div class="progress-bar" role="progressbar" data-percentage="80" style="width: 80%;">
												<span class="progress-bar-span">80%</span>
												<span class="sr-only">60% Complete</span>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>วิชา 3</td>
								<td>
									<div class="skill">
										<!-- <p>CSS 3</p> -->
										<div class="progress">
											<div class="progress-bar" role="progressbar" data-percentage="90" style="width: 90%;">
												<span class="progress-bar-span">90%</span>
												<span class="sr-only">60% Complete</span>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row pd-1em">
			<div class="col-md-12 bg-white">
				<!-- Classic Heading -->
				<h4 class="classic-title center"><span>ผลการเรียน</span></h4>
				<!-- Toggle -->
				<form class="form-inline text-center">
				<label for=""><strong>ค้นหา | </strong></label>
				  <div class="form-group">
				    <label for="exampleInputName2">วิชา</label>
				    <select class="form-control">
				  <option>-- วิชาที่ต้องการค้นหา --</option>
				  <option>Lorem ipsum dolor sit amet 1</option>
				  <option>Lorem ipsum dolor sit amet 2</option>
				  <option>Lorem ipsum dolor sit amet 3</option>
				  <option>Lorem ipsum dolor sit amet 4</option>
				  <option>Lorem ipsum dolor sit amet 5</option>
				  <option>-- วิชาทั้งหมด --</option>
				</select>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputName3">รุ่น</label>
				    <select class="form-control">
				  <option>1</option>
				  <option>2</option>
				  <option>3</option>
				  <option>4</option>
				  <option>5</option>
				</select>
				  </div>
				  <button type="submit" class="btn btn-default btn-sm" style="margin-top: 0;">ค้นหา</button>
				</form>
				<div class="panel-group">
					<!-- Start Toggle 1 -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#toggle" href="#collapse-7" class="" aria-expanded="true">
								<i class="fa fa-angle-up control-icon"></i>
								<i class="fa fa-book"></i> วิชา 1 | สถานะ : <span class="badge">เรียนแล้ว</span>
								<span class="pull-right"><button type="button" class="btn btn-danger btn-sm mr-1em"><i class="fa fa-ban" aria-hidden="true"></i> ยกเลิกการเรียน</button></span>
							</a>
							</h4>
						</div>
						<div id="collapse-7" class="panel-collapse collapse in" aria-expanded="true">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
										 <tr class="active">
										    <th rowspan="2">บทที่</th>
										    <th rowspan="2">ผลการเรียน</th>
										    <th colspan="2">สอบ</th>
										    <th rowspan="2">แบบทดสอบ Final</th>
										    <th rowspan="2">ประเมินความพึงพอใน</th>
										    <th rowspan="2">ใบประกาศ</th>
										  </tr>
										  
										  <tr>
										     <th>สอบก่อนเรียน</th>
										     <th>สอบหลังเรียน</th>
										  </tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td class="success">เรียนผ่าน</td>
												<td>5/10</td>
												<td>10/10</td>
												<td>30/50</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ดูผล</a></td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">พิมพ์ใบประกาศ</a></td>
											</tr>
											<tr>
												<td>1</td>
												<td class="danger">เรียนไม่ผ่าน</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำข้อสอบก่อนเรียน</a></td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำข้อสอบหลังเรียน</a></td>
												<td>30/50</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำแบบประเมิน</a></td>
												<td><a class="btn btn-default btn-sm disabled" href="#" role="button">พิมพ์ใบประกาศ</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- End Toggle 1 -->
					<!-- Start Toggle 2 -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#toggle" href="#collapse-8" class="collapsed" aria-expanded="false">
								<i class="fa fa-angle-down control-icon"></i>
								<i class="fa fa-book"></i> วิชา 2 | สถานะ : <span class="badge">กำลังเรียน</span>
								<span class="pull-right"><button type="button" class="btn btn-danger btn-sm mr-1em"><i class="fa fa-ban" aria-hidden="true"></i> ยกเลิกการเรียน</button></span>
							</a>
							</h4>
						</div>
						<div id="collapse-8" class="panel-collapse collapse" aria-expanded="false">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
										 <tr class="active">
										    <th rowspan="2">บทที่</th>
										    <th rowspan="2">ผลการเรียน</th>
										    <th colspan="2">สอบ</th>
										    <th rowspan="2">แบบทดสอบ Final</th>
										    <th rowspan="2">ประเมินความพึงพอใน</th>
										    <th rowspan="2">ใบประกาศ</th>
										  </tr>
										  
										  <tr>
										     <th>สอบก่อนเรียน</th>
										     <th>สอบหลังเรียน</th>
										  </tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td class="success">เรียนผ่าน</td>
												<td>5/10</td>
												<td>10/10</td>
												<td>30/50</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ดูผล</a></td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">พิมพ์ใบประกาศ</a></td>
											</tr>
											<tr>
												<td>1</td>
												<td class="danger">เรียนไม่ผ่าน</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำข้อสอบก่อนเรียน</a></td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำข้อสอบหลังเรียน</a></td>
												<td>30/50</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำแบบประเมิน</a></td>
												<td><a class="btn btn-default btn-sm disabled" href="#" role="button">พิมพ์ใบประกาศ</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- End Toggle 2 -->
					<!-- Start Toggle 3 -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#toggle" href="#collapse-9" class="collapsed">
								<i class="fa fa-angle-down control-icon"></i>
								<i class="fa fa-book"></i> วิชา 3 | สถานะ : <span class="badge">ยังไม่เรียน</span>
								<span class="pull-right"><button type="button" class="btn btn-danger btn-sm mr-1em"><i class="fa fa-ban" aria-hidden="true"></i> ยกเลิกการเรียน</button></span>
							</a>
							</h4>
						</div>
						<div id="collapse-9" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
										 <tr class="active">
										    <th rowspan="2">บทที่</th>
										    <th rowspan="2">ผลการเรียน</th>
										    <th colspan="2">สอบ</th>
										    <th rowspan="2">แบบทดสอบ Final</th>
										    <th rowspan="2">ประเมินความพึงพอใน</th>
										    <th rowspan="2">ใบประกาศ</th>
										  </tr>
										  
										  <tr>
										     <th>สอบก่อนเรียน</th>
										     <th>สอบหลังเรียน</th>
										  </tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td class="success">เรียนผ่าน</td>
												<td>5/10</td>
												<td>10/10</td>
												<td>30/50</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ดูผล</a></td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">พิมพ์ใบประกาศ</a></td>
											</tr>
											<tr>
												<td>1</td>
												<td class="danger">เรียนไม่ผ่าน</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำข้อสอบก่อนเรียน</a></td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำข้อสอบหลังเรียน</a></td>
												<td>30/50</td>
												<td><a class="btn btn-default btn-sm" href="#" role="button">ทำแบบประเมิน</a></td>
												<td><a class="btn btn-default btn-sm disabled" href="#" role="button">พิมพ์ใบประกาศ</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- End Toggle 3 -->
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