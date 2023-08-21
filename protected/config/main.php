<?php
ini_set('error_reporting', 'E_ALL & ~E_NOTICE');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Thoresen e-Learning',
    'theme'=>'template2',
    'language'=>'TH',
    'timezone'=>'Asia/Bangkok',
    'defaultController' => 'site/login',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'zii.widgets.*',
        'zii.widgets.grid.*',
        'application.models.*',
        'application.components.*',
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.extensions.yush.*',
        'application.modules.bbii.models.*',
        'ext.shopping.*',
        'ext.easyimage.EasyImage',
    ),

    'modules'=>array(
        // uncomment the following to enable the Gii tool

        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123456',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        'forum'=>array(
            'class'=>'application.modules.bbii.BbiiModule',
            'adminId'=>1,
            'userClass'=>'User',
            'userIdColumn'=>'id',
            'userNameColumn'=>'username',
        ),
        'user'=>array(
            # encrypting method (php hash function)
            'hash'                  => 'md5',
            # send activation email
            'sendActivationMail'    => false,
            # allow access for non-activated users
            'loginNotActiv'         => false,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister'   => true,
            # automatically login from registration
            'autoLogin'             => false,
            # registration path
            'registrationUrl'       => array('/user/registration'),
            # recovery password path
            'recoveryUrl'           => array('/user/recovery'),
            # login form path
            'loginUrl'              => array('/user/login'),
            # page after login
            'returnUrl'             => array('/category/index'),
            # page after logout
            'returnLogoutUrl'       => array('/user/login'),
        ),
        'rights'=>array(
            'superuserName'=>'Admin', // Name of the role with super user privileges.
            'authenticatedName'=>'Authenticated', // Name of the authenticated user role.
            'userIdColumn'=>'id', // Name of the user id column in the database.
            'userNameColumn'=>'username', // Name of the user name column in the database.
            'enableBizRule'=>true, // Whether to enable authorization item business rules.
            'enableBizRuleData'=>false, // Whether to enable data for business rules.
            'displayDescription'=>true, // Whether to use item description instead of name.
            'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages.
            'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages.
            'install'=>true, // Whether to install rights.
            'baseUrl'=>'/rights', // Base URL for Rights. Change if module is nested.
            'layout' => '//layouts/column2', // Layout to use for displaying Rights.
            //'appLayout'=>'application.views.layouts.main', // Application layout.
            'cssFile'=>'rights.css', // Style sheet file to use for Rights.
            'install'=>false, // Whether to enable installer.
            'debug'=>false, // Whether to enable debug mode.
        ),
    ),

    // application components
    'components'=>array(

//      'user'=>array(
//          // enable cookie-based authentication
//          'allowAutoLogin'=>true,
//      ),

        'session' => array (
            'timeout' => 7200,
            'class' => 'application.components.DbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'session',
            'userTableName' => 'tbl_users',
            'cookieParams' => array(
            'httponly' => TRUE
            )
        ),

        //prevent  XSS
        // 'session' => array(
        //    'cookieParams' => array(
        //     'httponly' => TRUE
        //     )
        //  ),


        'request'=>array(
            'enableCookieValidation'=>true,
        ),

        'mailer' => array(
            'class' => 'ext.mailer.EMailer',
//          'pathViews' => 'application.views.email',
//          'pathLayouts' => 'application.views.email.layouts'
        ),

        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage',
            //'driver' => 'GD',
            //'quality' => 100,
            //'cachePath' => '/assets/easyimage/',
            //'cacheTime' => 2592000,
            //'retinaSupport' => false,
        ),

        'yush' => array(
            'class' => 'ext.yush.YushComponent',
            'baseDirectory' => 'uploads',
        ),
        'phpThumb'=>array(
            'class'=>'ext.EPhpThumb.EPhpThumb',
            'options'=>array()
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,
            // 'caseSensitive'=>false,
             'rules'=>array(
                'post/<id:\d+>/<title:.*?>'=>'post/view',
                'register/<tag:.*?>'=>'post/index',
                // REST patterns
                array('api/list', 'pattern'=>'api/<model:\w+>', 'verb'=>'GET'),
                array('api/view', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'GET'),
                array('api/update', 'pattern'=>'api/<model:\w+>', 'verb'=>'PUT'),
                array('api/delete', 'pattern'=>'api/<model:\w+>', 'verb'=>'DELETE'),
                array('api/create', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'),
                array('api/loginlms', 'pattern'=>'api/<model:\w+>/<title:.*?>', 'verb'=>'GET'),

                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
             ),
        ),


        // database settings are configured in database.php
        'db'=>require(dirname(__FILE__).'/database.php'),

        'dbvod'=>require(dirname(__FILE__).'/database-vod.php'),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'user'=>array(
            // enable cookie-based authentication
            'loginUrl'=>array('/user/login'),
            'allowAutoLogin'=>true,
            'class' => 'RWebUser',
            'stateKeyPrefix'=>'f298d9729c7408c3d406db95a9639204',
            // 'class' => 'WebUser',
        ),
        // 'authManager'=>array(
        //     'class'=>'RDbAuthManager',
        //     'connectionID'=>'db',
        //     'defaultRoles'=>array('Authenticated','Guest'),
        //     'assignmentTable'=>'Authassignment',
        //     'itemChildTable'=>'authitemchild',
        //     'itemTable'=>'authitem',
        //     'rightsTable'=>'rights',
        // ),

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages

                // array(
                //     'class'=>'CWebLogRoute',
                // ),

            ),
        ),
        'ePdf' => array(
	        'class'         => 'ext.yii-pdf.EYiiPdf',
	        'params'        => array(
				'mpdf'     	=> array(
                'librarySourcePath' => 'application.vendors.mpdf.*',
                'constants'         => array(
                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                ),
                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                    'mode'              => '', //  This parameter specifies the mode of the new document.
                    'format'            => 'A4', // format A4, A5, ...
                    'default_font_size' => 0, // Sets the default document font size in points (pt)
                    'default_font'      => '', // Sets the default font-family for the new document.
                    'mgl'               => 25, // margin_left. Sets the page margins for the new document.
                    'mgr'               => 20, // margin_right
                    'mgt'               => 16, // margin_top
                    'mgb'               => 16, // margin_bottom
                    'mgh'               => 9, // margin_header
                    'mgf'               => 9, // margin_footer
                    'orientation'       => 'P', // landscape or portrait orientation
                )
        	),
	        'HTML2PDF' => array(
	                'librarySourcePath' => 'application.vendors.html2pdf.*',
	                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
	                'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
	                    'orientation' => 'P', // landscape or portrait orientation
	                    'format'      => 'A4', // format A4, A5, ...
	                    'language'    => 'en', // language: fr, en, it ...
	                    'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
	                    'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
	                    'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
	                )
	            )

	        ),
	    ),

    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
        'recaptcha' => array(
             'publicKey' => '6LcnyBQUAAAAAMshaSXcQfe-Ry7ujd02VHl1KsM-',
             'privateKey' => '6LcnyBQUAAAAAC8QBbg9Ic3f0A9XUZSzv_fN-lsc',
        ),
    ),
);
