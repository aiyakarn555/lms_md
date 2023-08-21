		<div class="container">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-main">
					<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $labelCourse->label_course; ?></a>
						<li class="breadcrumb-item active" aria-current="page"><?= $lesson->CourseOnlines->course_title; ?></li>
					</ol>
				</nav>
			</div> 

			<section class="content" id="pre-exams">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-sm-offset-2">
							<div class="well">
								<div class="exams-condition">
									<?php
								// $isPreTest = Helpers::isPretestState($lesson->id);
									$isPreTest = ($testType == "pre") ? true : false;
									$typeText = $isPreTest ? $labelCourse->label_testPre : $labelCourse->label_testPost;

									?>
									<h2 class="text-center"><?= $typeText; ?></h2>
									<h4 class="text-center"><?= UserModule::t('lesson_name')  ?> : <?= $lesson->title; ?></h4>
									<hr>
									<ul class="list-unstyled">
										<li><?= $labelCourse->label_totalTest  ?> <span class="pull-right"><?= $total_score; ?> <?= $labelCourse->label_list ?></span></li>
										<li><?= UserModule::t('timeTest') ?> <span class="pull-right"><?= $lesson->time_test; ?> <?= UserModule::t('Minutes') ?></span></li>
										<li><?= UserModule::t('totoal') ?> <span class="pull-right"><?php if($num_choice != 0){ echo $num_choice; }else{ echo $total_score; } ?> <?= $labelCourse->label_point ?></span></li>
									</ul>
									<div class="text-center">
										<a class="btn btn-default" href="<?php echo $this->createUrl('/question/index', array('id' => $lesson->id,'gen'=>$gen, 'type' => $testType)); ?>" role="button"><?= $labelCourse->label_DoTest ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>