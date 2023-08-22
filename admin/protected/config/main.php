<?php
ini_set('error_reporting', 'E_ALL & ~E_NOTICE');
ini_set('upload_max_filesize', '3072M');
ini_set('post_max_size', '3072M');
ini_set('max_input_time', 400); //400
ini_set('max_execution_time', 400); //400
header('Content-Type: text/html; charset=utf-8');
require_once( dirname(__FILE__) . '/params.php');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ระบบบริหารจัดการ E learning',
	'theme'=>'Adminkit',
	'timeZone' => 'Asia/Bangkok',
	'language'=>'en',
	'defaultController' => 'user/login',

	// preloading 'log' component
	'preload'=>array('log','booster'),

	// autoloading model and component classes
	'import'=>array(
		'zii.widgets.*',
		'zii.widgets.grid.*',
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
		'application.extensions.jtogglecolumn.*',
        'application.modules.user.components.*',
        'application.modules.user.UserModule',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.components.ERememberFiltersBehavior',
		'application.extensions.yush.*',
		'ext.giix.giix-components.*',
		'ext.chosen2.*',
	),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	 	'user'=>array(
            # encrypting method (php hash function)
            'hash'					=> 'md5',
            # send activation email
            'sendActivationMail' 	=> false,
            # allow access for non-activated users
            'loginNotActiv' 		=> false,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' 	=> true,
            # automatically login from registration
            'autoLogin' 			=> true,
            # registration path
            'registrationUrl' 		=> array('/user/registration'),
            # recovery password path
            'recoveryUrl' 			=> array('/user/recovery'),
            # login form path
            'loginUrl' 				=> array('/user/login'),
            # page after login
            'returnUrl' 			=> array('/site/index'),
            # page after logout
            'returnLogoutUrl' 		=> array('/user/login'),
        ),
        'rights' => array(
            'flashSuccessKey'       => 'success', // Key to use for setting success flash messages.
            'flashErrorKey'         => 'error', // Key to use for setting error flash messages.
            'layout'              	=> '//layouts/column2', // Layout to use for displaying Rights.
            'install'               => false, // Whether to enable installer.
			'enableBizRule' => false,
        ),
	),

	// application components
	'components'=>array(

		'cache'=>array( 
            'class'=>'system.caching.CDbCache'
        ),


		// ใช้ gii ให้ ปิด session

		// 'session' => array (
		// 	'class' => 'application.components.DbHttpSession',
		// 	'connectionID' => 'db',
		// 	'sessionTableName' => 'session',
		// 	'userTableName' => 'tbl_users'
		// ),


		/*'bigbluebutton'=>array(
            'class'=>'ext.bigbluebutton.BigBlueButton',

            //server and salt provided here are intended for BigBlueButton's testing server
            //do not use it in your real projects

            //security salt - required
            'salt'=>'d68be75fd1861179be09bcc694cf33b1',
            //API host - required
            'url'=>'http://192.168.1.60',
            //the rest parameters are optional
            //port is 80 by default
            //'port'=>80,
            //default path to API
            //'path'=>'/bigbluebutton/api/',

            //-you may set default passwords here or set
            // unique passwords for each conference
            //-or even use no passwords — BigBlueButton
            // will assign them randomly in that case

            //common moderator password for any conference
            //'moderatorPW'=>'12345',
            //common attendee password for any conference
            //'attendeePW'=>'123',

            //common url to redirect users after leaving conference,
            //which will be transmitted to Yii::app()->createAbsoluteUrl.
            //default is site root. you may set unique url for each conference.
            //'logoutUrl'=>'/',
        ),*/
		'mailer' => array(
			'class' => 'ext.mailer.EMailer',
//			'pathViews' => 'application.views.email',
//			'pathLayouts' => 'application.views.email.layouts'
		),
		'chosen' => array(
			'class' => 'ext.chosen.EChosenWidget',
		),
		'chosen2' => array(
			'class' => 'ext.chosen.EChosenWidget',
		),
        'user'=>array(
            // enable cookie-based authentication
			'loginUrl'=>array('/user/login'),
			'allowAutoLogin'=>true,
			'class' => 'RWebUser',
			'stateKeyPrefix'=>'f298d9729c7408c3d406db95a9639204',
			// 'class' => 'WebUser',
        ),
        'authManager' => array(
            'class'=>'RDbAuthManager',
            'connectionID'=>'db',
            'defaultRoles'=>array('Authenticated', 'Guest'),
        ),
		'yush' => array(
	        'class' => 'ext.yush.YushComponent',
	        'baseDirectory' => '../uploads',
	    ),
		'phpThumb'=>array(
		    'class'=>'ext.EPhpThumb.EPhpThumb',
		    'options'=>array()
		),
	    'jformvalidate' => array (
	    	'class' => 'application.extensions.jformvalidate.EJFValidate',
	     	'enable' => true
	    ),
		'messages'=>array(
            'basePath'=>Yiibase::getPathOfAlias('application.messages')
        ),
        'yexcel' => array(
		    'class' => 'ext.yexcel.Yexcel'
		),
        'file'=>array(
            'class'=>'ext.file.CFile',
        ),
        'booster' => array(
            'class' => 'ext.booster.components.Booster',
        ),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
		    'urlFormat'=>'path',
		    'rules'=>array(
                '<_m>/<_c:\w+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m>/<_c:\w+>/<id:\d+>/<_a:(update|delete)>' => '<_m>/<_c>/<_a>',
                '<_m>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
		    	'CourseOnline/PrintPDF/<id:\d+>/<user:\d+>'=>'CourseOnline/PrintPDF',
		    	'EvalAns/view/<id:\d+>/<ans:\d+>'=>'EvalAns/view',
		        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
		        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		    ),
   			//'showScriptName'=>false,
     		//'caseSensitive'=>false,
		),
		'clientScript' => array(
		    'class' => 'application.vendors.yii-EClientScript.EClientScript',
		    'combineScriptFiles' => false, // By default this is set to true, set this to true if you'd like to combine the script files
		    'combineCssFiles' => false, // By default this is set to true, set this to true if you'd like to combine the css files
		    'optimizeScriptFiles' => false, // @since: 1.1
		    'optimizeCssFiles' => false, // @since: 1.1
		    'optimizeInlineScript' => false, // @since: 1.6, This may case response slower
		    'optimizeInlineCss' => false, // @since: 1.6, This may case response slower
	    ),
		// uncomment the following to use a MySQL database

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
        'zip'=>array(
        'class'=>'application.extensions.zip.EZip',
        ),

		// 'request'=>array(
		// 	'class' => 'application.components.HttpRequest',
  //           'enableCsrfValidation' => true,
  //           'noCsrfValidationRoutes'=>array(
	 //            'user/LoginGoogle',
	 //            'user/login'
	 //        ),
  //       ),
//		'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//				array(
//					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning',
//				),
//				// uncomment the following to show log messages on web pages
//				/*
//				array(
//					'class'=>'CWebLogRoute',
//				),
//				*/
//			),
//		),
//		'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//				array(
//					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
//					'categories' => 'system.db.CDbCommand',
//					//'ipFilters'=>array('127.0.0.1','192.168.1.215'),
//				),
//			),
//		),
		'ePdf' => array(
        'class'         => 'ext.yii-pdf.EYiiPdf',
        'params'        => array(
            'mpdf'     => array(
                'librarySourcePath' => 'application.vendors.mpdf.*',
                'constants'         => array(
                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                ),
                'class'=>'mpdf', 
                'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                    'mode'              => '', //  This parameter specifies the mode of the new document.
                    'format'            => 'A4', // format A4, A5, ...
                    'default_font_size' => 0, // Sets the default document font size in points (pt)
                    'default_font'      => 'garuda', // Sets the default font-family for the new document.
                    // 'mgl'               => 25, // margin_left. Sets the page margins for the new document.
                    // 'mgr'               => 20, // margin_right
                    // 'mgt'               => 16, // margin_top
                    // 'mgb'               => 16, // margin_bottom
                    // 'mgh'               => 9, // margin_header
                    // 'mgf'               => 9, // margin_footer
                    // 'orientation'       => 'L', // landscape or portrait orientation
                )
            ),
        ),
    ),



		
	  //   'ePdf' => array(
			// 'class'         => 'ext.yii-pdf.EYiiPdf',
	  //       'params'        => array(
			// 	'mpdf'     	=> array(
   //              'librarySourcePath' => 'application.vendors.mpdf.mpdf.src.*',
   //              'constants'         => array(
   //                  '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
   //              ),
   //              'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
   //              'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
   //                  'mode'              => '', //  This parameter specifies the mode of the new document.
   //                  'format'            => 'A4', // format A4, A5, ...
   //                  'default_font_size' => 0, // Sets the default document font size in points (pt)
   //                  'default_font'      => '', // Sets the default font-family for the new document.
   //                  'mgl'               => 25, // margin_left. Sets the page margins for the new document.
   //                  'mgr'               => 20, // margin_right
   //                  'mgt'               => 16, // margin_top
   //                  'mgb'               => 16, // margin_bottom
   //                  'mgh'               => 9, // margin_header
   //                  'mgf'               => 9, // margin_footer
   //                  'orientation'       => 'L', // landscape or portrait orientation
   //              )
   //      	),
	  //       'HTML2PDF' => array(
	  //               'librarySourcePath' => 'application.vendors.html2pdf.*',
	  //               'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
	  //               'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
	  //                   'orientation' => 'P', // landscape or portrait orientation
	  //                   'format'      => 'A4', // format A4, A5, ...
	  //                   'language'    => 'en', // language: fr, en, it ...
	  //                   'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
	  //                   'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
	  //                   'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
	  //               )
	  //           )

	  //       ),
	  //   ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
