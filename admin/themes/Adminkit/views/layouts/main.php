<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <html class="ie gt-ie8"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!-- <![endif]-->

<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<!-- Meta -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<?php
	$path_theme = Yii::app()->theme->baseUrl . "/assets";
	$clientScript = Yii::app()->clientScript;
	////////// CSS //////////
	//Bootstrap
	$clientScript->registerCssFile($path_theme . '/bootstrap/css/bootstrap.css');
	$clientScript->registerCssFile($path_theme . '/bootstrap/css/responsive.css');
	//Glyphicons Font Icons
	?>
	<script src="https://use.fontawesome.com/a38616fc2a.js"></script>
	<?php
	$clientScript->registerCssFile($path_theme . '/theme/css/glyphicons.css');
	//Uniform Pretty Checkboxes
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/forms/pixelmatrix-uniform/css/uniform.default.css');
	//Bootstrap Extended
	$clientScript->registerCssFile($path_theme . '/bootstrap/extend/jasny-bootstrap/css/jasny-bootstrap.min.css');
	$clientScript->registerCssFile($path_theme . '/bootstrap/extend/jasny-bootstrap/css/jasny-bootstrap-responsive.min.css');
	$clientScript->registerCssFile($path_theme . '/bootstrap/extend/bootstrap-wysihtml5/css/bootstrap-wysihtml5-0.0.2.css');
	$clientScript->registerCssFile($path_theme . '/bootstrap/extend/bootstrap-select/bootstrap-select.css');
	$clientScript->registerCssFile($path_theme . '/bootstrap/extend/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css');
	//Select2 Plugin
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/forms/select2/select2.css');
	//DateTimePicker Plugin
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/forms/bootstrap-datetimepicker/css/datetimepicker.css');
	//JQueryUI
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/system/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.min.css');

	$clientScript->registerCssFile($path_theme . '/sweetalert/dist/sweetalert.css');
	$clientScript->registerCssFile($path_theme . '/codecanyon/css/slim.min.css');
	//MiniColors ColorPicker Plugin
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/color/jquery-miniColors/jquery.miniColors.css');
	//Notyfy Notifications Plugin
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.css');
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/notifications/notyfy/themes/default.css');
	//Gritter Notifications Plugin
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/notifications/Gritter/css/jquery.gritter.css');
	//Easy-pie Plugin
	$clientScript->registerCssFile($path_theme . '/css/jquery.datetimepicker.css');
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/charts/easy-pie/jquery.easy-pie-chart.css');
	//Google Code Prettify Plugin
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/other/google-code-prettify/prettify.css');
	//DataTables Plugin
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css');
	//Farbtastic Plugin
	$clientScript->registerCssFile($path_theme . '/theme/scripts/plugins/color/farbtastic/farbtastic.css');
	//Main Theme Stylesheet :: CSS
	$clientScript->registerCssFile($path_theme . '/theme/css/style.min.css');
	$clientScript->registerCssFile($path_theme . '/css/prettyPhoto.css');

	//Croppie
	$clientScript->registerCssFile($path_theme . '/css/croppie.css');


	//CUSTOM TEMPLATE
	$clientScript->registerCssFile($path_theme . '/theme/css/custom.css');

	////////// JS //////////
	//LESS.js Library
	$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/system/less.min.js', CClientScript::POS_HEAD);
	//JQuery
	$clientScript->coreScriptPosition = CClientScript::POS_HEAD;
	$clientScript->registerCoreScript('jquery');
	$clientScript->registerScriptFile($path_theme . '/js/croppie.js');
	$clientScript->registerScriptFile($path_theme . '/js/jquery.youtube-background.js');

	?>


</head>

<body>
	<style type="text/css">
		div#sidebar,
		a.search-button,
		div.form {
			margin-left: 30px;
		}

		div#lesson-grid {
			margin-left: 30px;
			margin-right: 30px;
		}

		#divLoadingPage {
			position:
				fixed;
			top: 0;
			left: 44%;
			width: 120px;
			text-align: center;
			background: #444;
			background: rgba(0, 0, 0, 0.7);
			color: #fff;
			font-size: 14px;
			padding: 3px 10px;
			-webkit-border-radius: 0 0 5px 5px;
			-moz-border-radius: 0 0 5px 5px;
			border-radius: 0 0 5px 5px;
			z-index: 10003;
		}
	</style>
	<script type="text/javascript">
		$(window).load(function() {
			$('#divLoadingPage').hide();
		});
		var countprofile = 0;

		$(function() {
			$("#profilemenu").click(function() {
				if (countprofile == 0) {
					// alert(countprofile);
					$("#profilemenu").addClass('account open');
					countprofile = 1;
				} else {
					// alert(countprofile);
					$("#profilemenu").removeClass("open");

					// $("#profilemenu").addClass('account');
					countprofile = 0;
				}
			});
		});

		$(function() {
			$("#manualmenu").click(function() {
				if (countprofile == 0) {
					// alert(countprofile);
					$("#manualmenu").addClass('account open');
					countprofile = 1;
				} else {
					// alert(countprofile);
					$("#manualmenu").removeClass("open");

					// $("#manualmenu").addClass('account');
					countprofile = 0;
				}
			});
		});
	</script>
	<div id="divLoadingPage">
		<?php echo CHtml::image(Yii::app()->baseUrl . '/images/ajax-loader.gif', 'Loading'); ?>
		Processing...
	</div>

	<!-- Main Container Fluid -->
	<div class="container-fluid fluid menu-left">

		<!-- Top navbar -->
		<div class="navbar main hidden-print nav-admin">

			<!-- Brand -->
			<!-- <?php echo CHtml::link('Admin', array('//site/index'), array('class' => 'appbrand')); ?> -->

			<img class="appbrand" src="<?= Yii::app()->request->baseUrl ?>/../themes/template2/images/logo-1.png" width="132px" alt="">

			<!-- Menu Toggle Button -->
			<button type="button" class="btn btn-navbar">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<!-- // Menu Toggle Button END -->

			<!-- Top Menu Right -->
			<!-- <span class="separator-nav pull-right"></span> -->

			<ul class="topnav pull-right text-center">

				<!-- Profile / Logout menu -->
				<li class="account book-dowload" id="manualmenu">
					<?php
					$nameAdmin = Yii::app()->getModule('user')->user();
					?>
					<?php echo CHtml::link('<span class="hidden-phone text">คู่มือการใช้งาน</span><i></i>', array(), array('data-toggle' => 'dropdown', 'class' => 'glyphicons book')); ?>
					<ul class="dropdown-menu pull-right">
						<li><?php echo CHtml::link('คู่มือสำหรับผู้ดูแลระบบ<i></i>', array('//Manualuser/Viewpdf/1'), array('class' => 'pull-right', 'target' => '_blank')); ?></li>
						<li><?php echo CHtml::link('คู่มือสำหรับผู้ใช้งาน<i></i>', array('//Manualuser/Viewpdf/2'), array('class' => 'pull-right', 'target' => '_blank')); ?></li>
					</ul>
				</li>
				<li class="account" id="profilemenu">
					<?php
					$nameAdmin = Yii::app()->getModule('user')->user();

					?>
					<?php echo CHtml::link('<span class="hidden-phone text">' . $nameAdmin->username . '</span><i></i>', array(), array('data-toggle' => 'dropdown', 'class' => 'glyphicons logout lock')); ?>
					<ul class="dropdown-menu pull-right">
						<li><?php echo CHtml::link('เปลี่ยนรหัสผ่าน <i></i>', array('//user/profile/changepassword'), array('class' => 'glyphicons keys')); ?></li>
						<li class="highlight profile">
							<span>
								<span class="heading">
									<?php echo UserModule::t("Profile"); ?>
									<?php echo CHtml::link(UserModule::t("Edit Profile"), array('//user/profile/edit'), array('class' => 'pull-right')); ?>
								</span>
								<span class="details">
									<?php
									if (!empty($nameAdmin)) {
										echo CHtml::link($nameAdmin->username, array('//user/profile'));
									}
									?>
								</span>
								<span class="clearfix"></span>
							</span>
						</li>
						<li>
							<span>
								<?php echo CHtml::link(UserModule::t("Logout"), array('//user/logout'), array('class' => 'btn btn-default btn-mini pull-right')); ?>
							</span>
						</li>
					</ul>
				</li>
				<!-- // Profile / Logout menu END -->
			</ul>
			<!-- // Top Menu Right END -->

			<!-- <ul class="topnav pull-right">
				
				<li class="account" id="manualmenu">
					<?php
					$nameAdmin = Yii::app()->getModule('user')->user();
					?>
					<?php echo CHtml::link('<span class="hidden-phone text">คู่มือการใช้งาน</span><i></i>', array(), array('data-toggle' => 'dropdown', 'class' => 'glyphicons book')); ?>
					<ul class="dropdown-menu pull-right">
						<li><?php echo CHtml::link('คู่มือสำหรับผู้ดูแลระบบ<i></i>', array('//Manualuser/Viewpdf/1'), array('class' => 'pull-right', 'target' => '_blank')); ?></li>
						<li><?php echo CHtml::link('คู่มือสำหรับผู้ใช้งาน<i></i>', array('//Manualuser/Viewpdf/2'), array('class' => 'pull-right', 'target' => '_blank')); ?></li>
					</ul>
				</li>
				<li class="account" id="profilemenu">
					<?php
					$nameAdmin = Yii::app()->getModule('user')->user();

					?>
					<?php echo CHtml::link('<span class="hidden-phone text">' . $nameAdmin->username . '</span><i></i>', array(), array('data-toggle' => 'dropdown', 'class' => 'glyphicons logout lock')); ?>
					<ul class="dropdown-menu pull-right">
						<li><?php echo CHtml::link('เปลี่ยนรหัสผ่าน <i></i>', array('//user/profile/changepassword'), array('class' => 'glyphicons keys')); ?></li>
						<li class="highlight profile">
							<span>
								<span class="heading">
									<?php echo UserModule::t("Profile"); ?>
									<?php echo CHtml::link(UserModule::t("Edit Profile"), array('//user/profile/edit'), array('class' => 'pull-right')); ?>
								</span>
								<span class="details">
									<?php
									if (!empty($nameAdmin)) {
										echo CHtml::link($nameAdmin->username, array('//user/profile'));
									}
									?>
								</span>
								<span class="clearfix"></span>
							</span>
						</li>
						<li>
							<span>
								<?php echo CHtml::link(UserModule::t("Logout"), array('//user/logout'), array('class' => 'btn btn-default btn-mini pull-right')); ?>
							</span>
						</li>
					</ul>
				</li>
				
			</ul> -->


		</div>
		<!-- Top navbar END -->

		<!-- Sidebar menu & content wrapper -->
		<div id="wrapper">

			<!-- Sidebar Menu -->
			<div id="menu" class="hidden-phone hidden-print">

				<!-- Scrollable menu wrapper with Maximum height -->
				<div class="slim-scroll" data-scroll-height="800px">
					<!-- Regular Size Menu -->
					<?php $this->widget('zii.widgets.CMenu', array(
						'activeCssClass' => 'active',
						'activateParents' => true,
						'encodeLabel' => false,
						'items' => MenuLeft::Menu()
					)); ?>

					<div class="clearfix"></div>

				</div>
				<!-- // Scrollable Menu wrapper with Maximum Height END -->

			</div>
			<!-- // Sidebar Menu END -->

			<!-- Content -->
			<?php echo $content; ?>
			<!-- // Content END -->

		</div>

		<div class="clearfix"></div>

		<div id="footer" class="hidden-print">

			<!--  Copyright Line -->
			<div class="copy">&copy; <?php echo date('Y'); ?> - Marine Department e-Learning System
				<!--  End Copyright Line -->

			</div>
		</div>
		<!-- // Main Container Fluid END -->

		<?php

		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/system/modernizr.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/bootstrap/js/bootstrap.min.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/other/jquery-slimScroll/jquery.slimscroll.min.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/demo/common.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/other/holder/holder.js', CClientScript::POS_END);
		//$clientScript->registerScriptFile($path_theme.'/theme/scripts/plugins/forms/pixelmatrix-uniform/jquery.uniform.min.js',CClientScript::POS_END);

		//Bootstrap Extended
		$clientScript->registerScriptFile($path_theme . '/bootstrap/extend/bootstrap-select/bootstrap-select.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/bootstrap/extend/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/bootstrap/extend/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/bootstrap/extend/jasny-bootstrap/js/jasny-bootstrap.min.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/bootstrap/extend/jasny-bootstrap/js/bootstrap-fileupload.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/bootstrap/extend/bootbox.js', CClientScript::POS_END);

		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/other/google-code-prettify/prettify.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/system/jquery-ui/js/jquery-ui-1.9.2.custom.min.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/system/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js', CClientScript::POS_END);
		//Gritter Notifications Plugin
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/notifications/Gritter/js/jquery.gritter.min.js', CClientScript::POS_END);

		//Notyfy Notifications Plugin
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/demo/notifications.js', CClientScript::POS_END);


		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/color/jquery-miniColors/jquery.miniColors.js', CClientScript::POS_END);

		//datetimepicker
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/forms/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/js/jquery.datetimepicker.full.min.js');

		//Cookie Plugin
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/system/jquery.cookie.js', CClientScript::POS_END);

		//Cookie Plugin
		$clientScript->registerScriptFile($path_theme . '/js/jquery.prettyPhoto.js', CClientScript::POS_END);

		//Sweet ALert
		$clientScript->registerScriptFile($path_theme . '/sweetalert/dist/sweetalert.min.js', CClientScript::POS_END);

		//Slim
		$clientScript->registerScriptFile($path_theme . '/codecanyon/js/slim.kickstart.min.js', CClientScript::POS_END);

		//Easy-pie Plugin
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/charts/easy-pie/jquery.easy-pie-chart.js', CClientScript::POS_END);

		//Sparkline Charts Plugin
		//$clientScript->registerScriptFile($path_theme.'/theme/scripts/plugins/charts/sparkline/jquery.sparkline.min.js',CClientScript::POS_END);

		//Ba-Resize Plugin
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/other/jquery.ba-resize.js', CClientScript::POS_END);

		//Select2 Plugin
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/forms/select2/select2.js', CClientScript::POS_END);

		//Form Elements Page Demo Script
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/demo/form_elements.js', CClientScript::POS_END);

		//DataTables Tables Plugin
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js', CClientScript::POS_END);

		//Tables Demo Script
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/demo/tables.js', CClientScript::POS_END);

		//Farbtastic Plugin
		$clientScript->registerScriptFile($path_theme . '/theme/scripts/plugins/color/farbtastic/farbtastic.js', CClientScript::POS_END);

		$clientScript->registerScriptFile($path_theme . '/js/jquery.bootstrap.wizard.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/js/wizard.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/js/tinymce-4.3.4/tinymce.min.js', CClientScript::POS_END);

		$clientScript->registerScriptFile($path_theme . '/js/date.js', CClientScript::POS_END);
		//Function All
		$clientScript->registerScriptFile($path_theme . '/js/function.js', CClientScript::POS_END);
		$clientScript->registerScriptFile($path_theme . '/js/jquery.blockUI.js', CClientScript::POS_END);

		//Croppie

		?>

		<!-- Optional Resizable Sidebars -->
		<!--[if gt IE 8]><!-->
		<script src="<?php echo $path_theme; ?>/theme/scripts/demo/resizable.js?1365412961"></script>
		<!--<![endif]-->

		<?php


		?>
		<!--<link rel="stylesheet" type="text/css" href="--><?php //echo Yii::app()->baseUrl; 
															?>
		<!--/../cometchat/cometchatcss.php">-->
		<!--<script type="text/javascript" src="--><?php //echo Yii::app()->baseUrl; 
													?>
		<!--/../cometchat/cometchatjs.php"></script>-->
</body>

</html>