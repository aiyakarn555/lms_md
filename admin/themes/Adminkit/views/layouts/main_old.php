<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <html class="ie gt-ie8"> <![endif]-->
<!--[if !IE]><!--><html><!-- <![endif]-->
<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<!-- Meta -->
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	
	<?php 
	$clientScript = Yii::app()->clientScript;
	////////// CSS //////////
	//Bootstrap
	$clientScript->registerCssFile($this->assetsBase.'/bootstrap/css/bootstrap.css');
	$clientScript->registerCssFile($this->assetsBase.'/bootstrap/css/responsive.css');
	//Glyphicons Font Icons
	$clientScript->registerCssFile($this->assetsBase.'/theme/css/glyphicons.css');
	//Uniform Pretty Checkboxes
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/forms/pixelmatrix-uniform/css/uniform.default.css');
	//Bootstrap Extended
	$clientScript->registerCssFile($this->assetsBase.'/bootstrap/extend/jasny-bootstrap/css/jasny-bootstrap.min.css');
	$clientScript->registerCssFile($this->assetsBase.'/bootstrap/extend/jasny-bootstrap/css/jasny-bootstrap-responsive.min.css');
	$clientScript->registerCssFile($this->assetsBase.'/bootstrap/extend/bootstrap-wysihtml5/css/bootstrap-wysihtml5-0.0.2.css');
	$clientScript->registerCssFile($this->assetsBase.'/bootstrap/extend/bootstrap-select/bootstrap-select.css');
	$clientScript->registerCssFile($this->assetsBase.'/bootstrap/extend/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css');
	//Select2 Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/forms/select2/select2.css');
	//DateTimePicker Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/forms/bootstrap-datetimepicker/css/datetimepicker.css');
	//JQueryUI
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/system/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.min.css');
	//MiniColors ColorPicker Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/color/jquery-miniColors/jquery.miniColors.css');
	//Notyfy Notifications Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.css');
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/notifications/notyfy/themes/default.css');
	//Gritter Notifications Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/notifications/Gritter/css/jquery.gritter.css');
	//Easy-pie Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/charts/easy-pie/jquery.easy-pie-chart.css');
	//Google Code Prettify Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/other/google-code-prettify/prettify.css');
	//DataTables Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css');
	//Farbtastic Plugin
	$clientScript->registerCssFile($this->assetsBase.'/theme/scripts/plugins/color/farbtastic/farbtastic.css');
	//Main Theme Stylesheet :: CSS
	$clientScript->registerCssFile($this->assetsBase.'/theme/css/style.min.css');
	////////// JS //////////
	//LESS.js Library
	$clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/plugins/system/less.min.js', CClientScript::POS_HEAD);
	//JQuery
	$clientScript->coreScriptPosition = CClientScript::POS_HEAD;
	$clientScript->registerCoreScript('jquery');
	?>
	<!-- prettyPhoto -->
	<link href="<?php echo Yii::app()->baseUrl; ?>/css/prettyPhoto.css" rel="stylesheet">

</head>
<body>
	<style type="text/css">
	div#sidebar, a.search-button, div.form{ margin-left: 30px; }
	div#lesson-grid { margin-left: 30px; margin-right: 30px;}
	#divLoadingPage{
		position: 
		fixed;top: 0;
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
	<script type="text/javascript"> $( window ).load(function() { $('#divLoadingPage').hide(); }); </script>
	<div id="divLoadingPage">
		<?php echo CHtml::image(Yii::app()->baseUrl.'/images/ajax-loader.gif', 'Loading'); ?>
		Processing...
	</div>

	<!-- Main Container Fluid -->
	<div class="container-fluid fluid menu-left">
		
		<!-- Top navbar -->
		<div class="navbar main hidden-print">
		
			<!-- Brand -->
			<?php echo CHtml::link('Brother', array('//site/index'), array('class'=>'appbrand'));?>

			<!-- Menu Toggle Button -->
			<button type="button" class="btn btn-navbar">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<!-- // Menu Toggle Button END -->
						
			<!-- Top Menu -->
			<ul class="topnav pull-left tn1">
								<!-- Themer -->
				<li class="hidden-phone">
					<a href="#themer" data-toggle="collapse" class="glyphicons eyedropper"><i></i><span>Themer</span></a>
					<div id="themer" class="collapse">
						<div class="wrapper">
							<span class="close2">&times; close</span>
							<h4>Themer <span>color options</span></h4>
							<ul>
								<li>Theme: <select id="themer-theme" class="pull-right"></select><div class="clearfix"></div></li>
								<li>Primary Color: <input type="text" data-type="minicolors" data-default="#ffffff" data-slider="hue" data-textfield="false" data-position="left" id="themer-primary-cp" /><div class="clearfix"></div></li>
								<li>
									<span class="link" id="themer-custom-reset">reset theme</span>
									<span class="pull-right"><label>advanced <input type="checkbox" value="1" id="themer-advanced-toggle" /></label></span>
								</li>
							</ul>
							<div id="themer-getcode" class="hide">
								<hr class="separator" />
								<button class="btn btn-primary btn-small pull-right btn-icon glyphicons download" id="themer-getcode-less"><i></i>Get LESS</button>
								<button class="btn btn-inverse btn-small pull-right btn-icon glyphicons download" id="themer-getcode-css"><i></i>Get CSS</button>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</li>
				<!-- // Themer END -->
								
			</ul>
			<!-- // Top Menu END -->
						
			<!-- Top Menu Right -->
			<ul class="topnav pull-right">
				<!-- Profile / Logout menu -->
				<li class="account">
					<?php 
					$nameAdmin = Yii::app()->getModule('user')->user();
					?>
					<?php echo CHtml::link('<span class="hidden-phone text">'.$nameAdmin->levels->level_name.'</span><i></i>', array(), array('data-toggle'=>'dropdown','class'=>'glyphicons logout lock')); ?>
					<ul class="dropdown-menu pull-right">
						<li><?php echo CHtml::link('เปลี่ยนรหัสผ่าน <i></i>', array('//user/profile/changepassword'), array('class'=>'glyphicons keys')); ?></li>
						<li class="highlight profile">
							<span>
								<span class="heading">
									<?php echo UserModule::t("Profile"); ?> 
									<?php echo CHtml::link(UserModule::t("Edit Profile"), array('//user/profile/edit'), array('class'=>'pull-right')); ?>
								</span>
								<span class="details">	
									<?php
									if(!empty($nameAdmin))
									{
										echo CHtml::link($nameAdmin->NameUser, array('//user/profile'));
									}
									?>
								</span>
								<span class="clearfix"></span>
							</span>
						</li>
						<li>
							<span>
								<?php echo CHtml::link(UserModule::t("Logout"), array('//user/logout'),array('class'=>'btn btn-default btn-mini pull-right'));?>
							</span>
						</li>
					</ul>
				</li>
				<!-- // Profile / Logout menu END -->
			</ul>
			<!-- // Top Menu Right END -->
			
		</div>
		<!-- Top navbar END -->
		
		<!-- Sidebar menu & content wrapper -->
		<div id="wrapper">
		
		<!-- Sidebar Menu -->
		<div id="menu" class="hidden-phone hidden-print">
		
			<!-- Scrollable menu wrapper with Maximum height -->
			<div class="slim-scroll" data-scroll-height="800px">
			<!-- Regular Size Menu -->
			<?php $this->widget('zii.widgets.CMenu',array(
				'activeCssClass'=>'active',
				'activateParents'=>true,
			    'encodeLabel' => false,
				'items'=>MenuLeft::Menu()
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
			<div class="copy">&copy;  <?php echo date('Y'); ?> - Brother - All Rights Reserved. 
			<!--  End Copyright Line -->
	
		</div>
	</div>
	<!-- // Main Container Fluid END -->

	<!-- Modernizr -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/system/modernizr.js"></script>
	
	<!-- Bootstrap -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
	
	<!-- SlimScroll Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/other/jquery-slimScroll/jquery.slimscroll.min.js"></script>
	
	<!-- Common Demo Script -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/demo/common.js"></script>
	
	<!-- Holder Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/other/holder/holder.js"></script>
	
	<!-- Uniform Forms Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/forms/pixelmatrix-uniform/jquery.uniform.min.js"></script>

	<!-- Global -->
	<script>
	var basePath = '';
	</script>
	
	<!-- Bootstrap Extended -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/extend/bootstrap-select/bootstrap-select.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/extend/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/extend/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/extend/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/extend/jasny-bootstrap/js/bootstrap-fileupload.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/extend/bootbox.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/extend/bootstrap-wysihtml5/js/wysihtml5-0.3.0_rc2.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bootstrap/extend/bootstrap-wysihtml5/js/bootstrap-wysihtml5-0.0.2.js"></script>
	
	<!-- Google Code Prettify -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/other/google-code-prettify/prettify.js"></script>
	
	<!-- JQueryUI -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/system/jquery-ui/js/jquery-ui-1.9.2.custom.min.js"></script>
	
	<!-- JQueryUI Touch Punch -->
	<!-- small hack that enables the use of touch events on sites using the jQuery UI user interface library -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/system/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
	
	<!-- Gritter Notifications Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/notifications/Gritter/js/jquery.gritter.min.js"></script>
	
	<!-- Notyfy Notifications Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/demo/notifications.js"></script>
	
	<!-- MiniColors Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/color/jquery-miniColors/jquery.miniColors.js"></script>
	
	<!-- DateTimePicker Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/forms/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Cookie Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/system/jquery.cookie.js"></script>
	
	<!-- PrettyPhoto -->
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.prettyPhoto.js" type="text/javascript"></script>

	<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$("a[rel^='prettyPhoto']").prettyPhoto({
			social_tools: false,
			animationSpeed: 'normal', /* ลักษณะการแสดงแอนิเมชั่น fast/slow/normal */
			padding: 40, /* กำหนดระยะห่างระหว่างรูปภาพกับตัวบ้อก */
			opacity: 0.35, /* กำหนดค่าความโปร่งแสง  0 - 1 */
			showTitle: true, /* กำหนดให้แสดง title หรือไม่ true/false */
			allowresize: true, /* อนุญาติให้ยูสเซ่อร์ย่อหรือขยายหรือไม่ true/false */
			counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
			theme: 'light_rounded' /* ธีม light_rounded / dark_rounded / light_square / dark_square */
		});
	});
	</script>

	<!-- Function All -->
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/function.js"></script>

	<!-- Colors -->
	<script>
	var primaryColor = '#e25f39',
		dangerColor = '#bd362f',
		successColor = '#609450',
		warningColor = '#ab7a4b',
		inverseColor = '#45484d';
	</script>
	
	<!-- Themer -->
	<script>
	var themerPrimaryColor = primaryColor;
	</script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/demo/themer.js"></script>
		
	<!-- Easy-pie Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/charts/easy-pie/jquery.easy-pie-chart.js"></script>
	
	<!-- Sparkline Charts Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/charts/sparkline/jquery.sparkline.min.js"></script>
	
	<!-- Ba-Resize Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/other/jquery.ba-resize.js"></script>

	<!-- Select2 Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/forms/select2/select2.js"></script>
	
	<!-- Form Elements Page Demo Script -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/demo/form_elements.js"></script>
	
	<!-- DataTables Tables Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>
	
	<!-- Tables Demo Script -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/demo/tables.js"></script>

	<!-- Farbtastic Plugin -->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/theme/scripts/plugins/color/farbtastic/farbtastic.js"></script>

	<!-- Optional Resizable Sidebars -->
	<!--[if gt IE 8]><!--><script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/demo/resizable.js?1365412961"></script><!--<![endif]-->

</body>
</html>