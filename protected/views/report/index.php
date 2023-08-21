<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-main">
			<li class="breadcrumb-item">
				<a href="<?php echo $this->createUrl('/site/index'); ?>">
					<?php
					if (Yii::app()->session['lang'] == 1) {
						echo "Home";
					} else {
						echo "หน้าแรก";
					}
					?>
				</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">
				<?php
				if (Yii::app()->session['lang'] == 1) {
					echo "Report";
				} else {
					echo "รายงาน";
				}
				?>
			</li>
		</ol>
	</nav>
</div>

<section id="report-main">
	<div class="container">

		<h2 class="text-center">
			<?php
			if (Yii::app()->session['lang'] == 1) {
				echo "Report";
			} else {
				echo "รายงาน";
			}
			?>
		</h2>

		<ul class="nav nav-tabs mt-1">
			<li <?php if(!isset($_GET["target"])){ echo 'class="active"'; } ?>><a data-toggle="tab" href="#first-report"><?php echo Yii::app()->session['lang'] == 1?'Register Report ':'รายงานการสมัครสมาชิก'; ?></a></li>
			<li <?php if(isset($_GET["target"]) && $_GET["target"] == "course"){ echo 'class="active"'; } ?>>
				<a data-toggle="tab" href="#second-report"><?php echo Yii::app()->session['lang'] == 1?'Training Report ':'รายงานการฝึกอบรม'; ?></a>
			</li>
			<li <?php if(isset($_GET["target"]) && $_GET["target"] == "assessment"){ echo 'class="active"'; } ?>><a data-toggle="tab" href="#third-report"><?php echo Yii::app()->session['lang'] == 1?'Training Evaluation Report ':'รายงานการประเมินผลการฝึกอบรม'; ?></a></li>
		</ul>

		<div class="tab-content">

			<div id="first-report" class="tab-pane fade <?php if(!isset($_GET["target"])){ echo 'in active'; } ?>">
				<div class="row d-flex justify-content-center">
					<?php if($authority == 1 || $authority == 2 || $authority == 3){ ?>
					<div class="col-sm-4 col-md-3">
						<a href="<?= $this->createUrl("report/report_register") ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-1.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Overview of Register Report ':'รายงานภาพรวมการสมัครสมาชิก'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php if($authority == 1 || $type_em == 1){ ?>
					<div class="col-sm-4 col-md-3 ">
						<a href="<?= $this->createUrl("report/registership") ?>">  
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-2.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Register Report for Ship Staff ':'รายงานการสมัครสมาชิกพนักงานประจำเรือ'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php
					}

					if($authority == 1 || $type_em == 2){
					?>
					<div class="col-sm-4 col-md-3">
						<a href="<?= $this->createUrl("report/registeroffice") ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-3.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Register Report for Office Staff ':'รายงานการสมัครสมาชิกพนักงานออฟฟิศ'; ?>
								</div>
							</div>
						</a>
					</div>
				</div>
				<?php
					}
				}
				?>
			</div>
			<div id="second-report" class="tab-pane fade <?php if(isset($_GET["target"]) && $_GET["target"] == "course"){ echo 'in active'; } ?>">
				<div class="row d-flex justify-content-center">
					<?php if($authority == 1 || $authority == 2 || $authority == 3){ ?>

					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/course'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-4.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Overview of Training Course Report ':'รายงานภาพรวมการฝึกอบรม'; ?>
								</div>
							</div>
						</a>
					</div>
					
					<?php if($authority == 1 || $type_em == 1){ ?>
					<div class="col-sm-4 col-md-3 ">
						<a href="<?php echo $this->createUrl('/report/courseCaptain'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-5.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Training Course Report For Ship Staff ':'รายงานการฝึกอบรมพนักงานประจำเรือ'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php } ?>

					<?php if($authority == 1 || $type_em == 2){ ?>
					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/courseOffice'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-6.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Training Course Report For Office Staff  ':'รายงานการฝึกอบรมพนักงานออฟฟิศ'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php } ?>

					<?php } // if($authority == 1 || $authority == 2) ?>
				</div>

				<div class="row d-flex justify-content-center">
					<div class="col-sm-4 col-md-3">
							<a href="<?php echo $this->createUrl('/report/courseall'); ?>">
	

							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-7.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Overview of Test Report ':'รายงานภาพรวมผลสอบ '; ?>
								</div>
							</div>
						</a>
					</div>
					<?php if($authority == 1 || $type_em == 1){ ?>
					<div class="col-sm-4 col-md-3 ">
						<a href="<?php echo $this->createUrl('/report/examShip'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-8.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Test Result Report For Ship Staff ':'รายงานผลการสอบพนักงานเรือ'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php } ?>
					<?php if($authority == 1 || $type_em == 2){ ?>
					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/examOffice'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-9.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Test Result Report for Office Staff':'รายงานผลการสอบพนักงานออฟฟิศ'; ?>
								</div>
							</div>
						</a>
					</div>
				<?php } ?>
				</div>
			</div>

			<div id="third-report" class="tab-pane fade <?php if(isset($_GET["target"]) && $_GET["target"] == "assessment"){ echo 'in active'; } ?>" >

				<div class="row d-flex justify-content-center">
					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/assessment'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-10.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Training Evaluation Report ':'รายงานการประเมินผลการฝึกอบรม'; ?>
								</div>
							</div>
						</a>
					</div>
				</div>

			</div>

		</div> <!-- tab-content -->

	</div> <!-- container -->
</section>