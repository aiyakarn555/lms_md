<?php
Class MenuLeft extends Controller
{
	public static function SetSubMenu($Name = array(),$Set=true)
	{
		/*=============================================
		=             Check submenuOptions	          =
		=============================================*/
		$Sum = 0;
		$ControllerId = '';
		//Check SamePath CourseOnline
		if(strtolower(Yii::app()->controller->id) == strtolower('CourseOnline') 
		&& (
			strtolower(Yii::app()->controller->action->id) == strtolower('CourseTemp') 
			|| strtolower(Yii::app()->controller->action->id) == strtolower('MsteamsTemp') 
			|| strtolower(Yii::app()->controller->action->id) == strtolower('OnlineTemp')
			)
		){
			$ControllerId = 'CourseOnline2';
		}else{
			$ControllerId = Yii::app()->controller->id;
		}

		foreach ($Name as $value)
		{
			if(strtolower($ControllerId) == strtolower($value))
			{
				$Sum = $Sum+1;
			}
		}

		if($Set == true)
		{
			if($Sum >= 1) $check = ' in collapse ' ; else $check = ' collapse ';
		}
		else
		{
			if($Sum >= 1) $check = true ; else $check = false;
		}

		return $check;
	}

//	public static function PermissionsMenu( $menu = array() )
//	{
//		/*=============================================
//		=             Check Permissions	             =
//		=============================================*/
//		$sum = 0;
//		$countArray = count($menu);
//		if($countArray != 0)
//		{
//			foreach ($menu as $key => $value)
//			{
//				if(Yii::app()->user->checkAccess($value) === true)
//				{
//					$sum = $sum+1;
//				}
//			}
//		}
//
//		if($sum >= 1) $check = true; else $check = false;
//
//		return $check;
//	}

	public static function PermissionsMenu( $menu = array() )
	{

		/*=============================================
		=             Check Permissions	             =
		=============================================*/
		$sum = 0;
		$countArray = count($menu);
		$return = false;        

		if($countArray != 0)
		{
			foreach ($menu as $key => $value)
			{
				$val = explode('.',$value);
				$controller_name = strtolower($val[0]);

				// if($controller_name == "monthcheck"){
				// 	var_dump($val);
				// 	exit();
				// }
				$action_name = strtolower($val[1]);
				$check = AccessControl::check_access_action(strtolower($controller_name),strtolower($action_name));

				if($check){
					$return = true;
				}else{
					$return = false;
				}
			}
		}

		// if($controller_name == "monthcheck"){
		// 			var_dump($check);
		// 			exit();
		// 		}
		return $return;
	}

	public static function Menu()
	{	
		$lang = Language::model()->findByAttributes(1);
		$mainLang = $lang->language;
    	// $domain =  trim($_SERVER['SERVER_NAME'],"www.");

		return array(
			array(
				'label'=>'<i></i><span>หน้าหลัก</span>',
				'url'=>array('/site/index'),
				'itemOptions' => array('class' => 'glyphicons home'),
			),
			// array(
			// 	/*====== Check Permissions Language (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Language.*',
			// 		'Language.admin',
			// 		'Language.Create'
			// 	)),
			// 	'label'=>'<i></i><span>ภาษา</span>',
			// 	'url'=>'#Language',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('Language') ), 'id' => 'Language'),
			// 	'active' => self::SetSubMenu( array('Language') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Position (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Language.*',
			// 				'Language.Create'
			// 			)),
			// 			'label'=>'เพิ่มภาษา',
			// 			'url'=>array('//Language/create')
			// 		),
			// 		array(
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Language.*',
			// 				'Language.admin'
			// 			)),
			// 			'label'=>'จัดการภาษา',
			// 			'url'=>array('//Language/admin')
			// 		),
			// 	)
			// ),
			// array(
			// 	/*====== Check Permissions MainMenu (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'MainMenu.*',
			// 		'MainMenu.admin',
			// 		'MainMenu.Create'
			// 	)),
			// 	'label'=>'<i></i><span>เมนู</span>',
			// 	'url'=>'#MainMenu',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('MainMenu') ), 'id' => 'MainMenu'),
			// 	'active' => self::SetSubMenu( array('MainMenu') ,false),
			// 	'items'=>array(
			// 		array(
			// 			====== Check Permissions Position (1) ======
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'MainMenu.*',
			// 				'MainMenu.Create'
			// 			)),
			// 			'label'=>'เพิ่มเมนู'." (ภาษา ".$mainLang." )",
			// 			'url'=>array('//MainMenu/create')
			// 		),
			// 		array(
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'MainMenu.*',
			// 				'MainMenu.admin'
			// 			)),
			// 			'label'=>'จัดการเมนู',
			// 			'url'=>array('//MainMenu/admin')
			// 		),
			// 	)
			// ),
			// array(
			// 	'label'=>'<i></i><span>สถิติการใช้งาน</span>',
			// 	'url'=>array('/analytics/index'),
			// 	'itemOptions' => array('class' => 'glyphicons stats'),
			// ),
	        //====== END Menu Site ======//



//			array(
//				/*====== Check Permissions Page (2) ======*/
//				'visible'=>self::PermissionsMenu(array(
//					'Page.*',
//					'Page.Index',
//					'Page.Create'
//				)),
//				'label'=>'<i></i><span>ระบบจำนวนการแสดงผล</span>',
//				'url'=>'#Page',
//				'linkOptions' => array('data-toggle' => 'collapse'),
//				'itemOptions' => array('class' => 'hasSubmenu glyphicons show_thumbnails_with_lines'),
//				'submenuOptions' => array('class' => self::SetSubMenu( array('Page') ), 'id' => 'Page'),
//				'active' => self::SetSubMenu( array('Page') ,false),
//				'items'=>array(
//					array(
//						/*====== Check Permissions Sup-Page (1) ======*/
//						'visible'=>self::PermissionsMenu(array(
//							'Page.*',
//							'Page.Create'
//						)),
//						'label'=>'เพิ่มจำนวนการแสดงผล',
//						'url'=>array('//Page/create')
//					),
//					array(
//						/*====== Check Permissions Sup-Page (2) ======*/
//						'visible'=>self::PermissionsMenu(array(
//							'Page.*',
//							'Page.Index'
//						)),
//						'label'=>'จัดการจำนวนการแสดงผล',
//						'url'=>array('//Page/index')
//					),
//				)
//			),
			//====== END Menu Page ======//

			// array(
			// 	/*====== Check Permissions About (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'About.*',
			// 		'About.index'
			// 	)),
			// 	'label'=>'<i></i><span>ติดต่อเรา</span>',
			// 	'url'=>'#About',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('About') ), 'id' => 'About'),
			// 	'active' => self::SetSubMenu( array('About') ,false),
			// 	'items'=>array(

			// 		array(
			// 			/*====== Check Permissions Sup-About (2) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'About.*',
			// 				'About.index'
			// 			)),
			// 			'label'=>'จัดการติดต่อเรา',
			// 			'url'=>array('//About/index/')
			// 		),
					
			// 	)
			// ),
			//====== END Menu About ======//

			// array(
			// 	/*====== Check Permissions Conditions (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Conditions.*',
			// 		'Conditions.index'
			// 	)),
			// 	'label'=>'<i></i><span>เงื่อนไขการใช้งาน</span>',
			// 	'url'=>'#Conditions',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons cogwheel'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('Conditions') ), 'id' => 'Conditions'),
			// 	'active' => self::SetSubMenu( array('Conditions') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Sup-Conditions (2) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Conditions.*',
			// 				'Conditions.index'
			// 			)),
			// 			'label'=>'แก้ไขเงื่อนไขการใช้งาน',
			// 			'url'=>array('//Conditions/index')
			// 		),
					
			// 	)
			// ),

			array(
				/*====== Check Permissions Setting (1)  ======*/
				'visible'=>self::PermissionsMenu(array(
					'Setting.*',
					'Setting.Create'
				)),
				'label'=>'<i></i><span>ตั้งค่าระบบพื้นฐาน</span>',
				'url'=>'#Setting',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons cogwheel'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Setting') ) , 'id' => 'Setting'),
				'active' => self::SetSubMenu(array('Setting'),false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Setting (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Setting.*',
							'Setting.Create'
						)),
						'label'=>'ตั้งค่าระบบพื้นฐาน',
						'url'=>array('//Setting/create')
					),
				)
			),

			
				array(
				/*====== Check Permissions Contactus (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'About.*',
					'About.index'
				)),
				'label'=>'<i></i><span>ติดต่อเรา</span>',
				'url'=>'#About',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons adress_book'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('About') ), 'id' => 'About'),
				'active' => self::SetSubMenu( array('About') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Contactus (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'About.*',
							'About.index'
						)),
						'label'=>'จัดการติดต่อเรา',
						'url'=>array('//About/index')
					),
				)
			),
			//====== END Menu Contactus ======//

			array(
	        	//////// VDO ////////
	        	'visible'=>self::PermissionsMenu(array(
	        		'vdo.*',
	        		'vdo.Index',
	        		'vdo.Create'
	        	)),
	        	'label'=>'<span class="label label-primary"></span> <i></i><span>ระบบวีดีโอ</span>',
	        	'url'=>'#vdo',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons facetime_video'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('vdo') ), 'id' => 'vdo'),
	        	'active' => self::SetSubMenu( array('vdo') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Category (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'vdo.*',
	        				'vdo.Create'
	        			)),
	        			'label'=>'เพิ่มวีดีโอ'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//vdo/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Category (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'vdo.*',
	        				'vdo.Index'
	        			)),
	        			'label'=>'จัดการวีดีโอ',
	        			'url'=>array('//vdo/index')
	        		),
	        	)
	        ),

	        //====== END Menu Rights ======//
	        array(
	        	/*====== Check Permissions Category (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Document.*',
	        		'Document.Index',
	        		'Document.Create',
	        		'Document.CreateType', 
	        	)),
	        	'label'=>'<i></i><span>ระบบเอกสาร</span>',
	        	'url'=>'#Document',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_open'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Document') ), 'id' => 'Document'),
	        	'active' => self::SetSubMenu( array('Document') ,false),
	        	'items'=>array(

	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Document.*',
	        				'Document.CreateType'
	        			)),
	        			'label'=>'เพิ่มประเภทเอกสาร'." (ภาษา ".$mainLang." )",
	                	'url'=>array('//Document/createtype')//ชื่อ action
	                ),

	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Document.*',
	        				'Document.Index_type'
	        			)),
	        			'label'=>'จัดการประเภทเอกสาร',
	        			'url'=>array('//Document/Index_type')
	        		),

	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Document.*',
	        				'Document.Create'
	        			)),
	        			'label'=>'เพิ่มเอกสาร'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//Document/create')
	        		),


	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Document.*',
	        				'Document.Index'
	        			)),
	        			'label'=>'จัดการเอกสาร',
	        			'url'=>array('//Document/index')
	        		),
	        	)
	        ),


			array(
				/*====== Check Permissions News (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'News.*',
					'News.Index',
				)),
				'label'=>'<i></i><span>ระบบข่าวประชาสัมพันธ์</span>',
				'url'=>'#News',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('News') ), 'id' => 'News'),
				'active' => self::SetSubMenu( array('News') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-News (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'News.*',
							'News.Create'
						)),
						'label'=>'เพิ่มข่าวประชาสัมพันธ์'." (ภาษา ".$mainLang." )",
						'url'=>array('//News/create')
					),
					array(
						/*====== Check Permissions Sup-News (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'News.*',
							'News.Index'
						)),
						'label'=>'จัดการข่าวประชาสัมพันธ์',
						'url'=>array('//News/index')
					),
				)
			),
			//====== END Menu News ======//

			array(
				/*====== Check Permissions Category (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'Category.*',
					'Category.Index',
					'Category.Create'
				)),
				'label'=>'<span class="label label-primary">1</span> <i></i><span>ระบบหมวดหลักสูตร</span>',
				'url'=>'#Category',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_open'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Category') ), 'id' => 'Category'),
				'active' => self::SetSubMenu( array('Category') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Category (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Category.*',
							'Category.Create'
						)),
						'label'=>'เพิ่มหมวดหลักสูตร'." (ภาษา ".$mainLang." )",
						'url'=>array('//Category/create')
					),
					array(
						/*====== Check Permissions Sup-Category (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Category.*',
							'Category.Index'
						)),
						'label'=>'จัดการหมวดหลักสูตร',
						'url'=>array('//Category/index')
					),
				)
			),
			//====== END Menu Category ======//

			array(
				/*====== Check Permissions CourseOnline (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'CourseOnline.*',
					'CourseOnline.Index',
					'CourseOnline.Create'
				)),
				'label'=>'<span class="label label-primary">2</span> <i></i><span>ระบบจัดการหลักสูตร</span>',
				'url'=>'#CourseOnline',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons imac'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('CourseOnline') ), 'id' => 'CourseOnline'),
				'active' => self::SetSubMenu( array('CourseOnline') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-CourseOnline (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'CourseOnline.*',
							'CourseOnline.Create'
						)),
						'label'=>'เพิ่ม'." (ภาษา ".$mainLang." )",
						'url'=>array('//CourseOnline/create')
					),
					array(
						/*====== Check Permissions Sup-CourseOnline (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'CourseOnline.*',
							'CourseOnline.Index'
						)),
						'label'=>'จัดการ',
						'url'=>array('//CourseOnline/index')
					),
				)
			),
			//====== END Menu CourseOnline ======//

			array(
				/*====== Check Permissions Lesson (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'Lesson.*',
					'Lesson.Index',
					'Lesson.Create',
//	        		'Scorm.*',
//	        		'Scorm.Index',
//	        		'Scorm.Create',
				)),
				'label'=>'<span class="label label-primary">3</span> <i></i><span>ระบบจัดการเนื้อหาบทเรียน</span>',
				'url'=>'#Lesson',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons imac'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Lesson', 'File') ), 'id' => 'Lesson'),
				'active' => self::SetSubMenu( array('Lesson', 'File') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Lesson (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Lesson.*',
							'Lesson.Create'
						)),
						'label'=>'เพิ่มบทเรียน'." (ภาษา ".$mainLang." )",
						'url'=>array('//Lesson/create')
					),
					array(
						/*====== Check Permissions Sup-Lesson (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Lesson.*',
							'Lesson.Index'
						)),
						'label'=>'จัดการบทเรียน',
						'url'=>array('//Lesson/index')
					),
				)
			),
			//====== END Menu Lesson ======//

			array(
				/*====== Check Permissions Grouptesting (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'Grouptesting.*',
					'Grouptesting.Index',
					'Grouptesting.Create',
					'Coursegrouptesting.Index',
					'Coursegrouptesting.Create'
				)),
				'label'=>'<span class="label label-primary">4</span> <i></i><span>ระบบข้อสอบ</span>',
				'url'=>'#Grouptesting',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Grouptesting', 'Coursegrouptesting') ), 'id' => 'Grouptesting'),
				'active' => self::SetSubMenu( array('Grouptesting', 'Coursegrouptesting') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Grouptesting (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Grouptesting.*',
							'Grouptesting.Create'
						)),
						'label'=>'เพิ่มชุดข้อสอบ',
						'url'=>array('//Grouptesting/create')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Grouptesting.*',
							'Grouptesting.Index'
						)),
						'label'=>'จัดการชุดข้อสอบ',
						'url'=>array('//Grouptesting/index')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Coursegrouptesting.*',
							'Coursegrouptesting.Create'
						)),
						'label'=>'เพิ่มชุดข้อสอบหลักสูตร',
						'url'=>array('//Coursegrouptesting/create')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Coursegrouptesting.*',
							'Coursegrouptesting.Index'
						)),
						'label'=>'จัดการชุดข้อสอบหลักสูตร',
						'url'=>array('//Coursegrouptesting/index')
					),
				)
			),
			//====== END Menu Grouptesting ======//



            //array(
			/*====== Check Permissions FormSurveyGroup (2) ======*/
	        	/*'visible'=>self::PermissionsMenu(array(
	        		'Questionnaire.*',
	        		'Questionnaire.Index',
	        		'Questionnaire.Create'
	        	)),
	            'label'=>' <span class="label label-primary">5</span> <i></i><span>ระบบแบบสอบถาม</span>',
	            'url'=>'#Questionnaire',
	            'linkOptions' => array('data-toggle' => 'collapse'),
	            'itemOptions' => array('class' => 'hasSubmenu glyphicons notes'),
	            'submenuOptions' => array('class' => self::SetSubMenu( array('Questionnaire') ), 'id' => 'Questionnaire'),
	            'active' => self::SetSubMenu( array('Questionnaire') ,false),
	            'items'=>array(
	            array(*/
	            	/*====== Check Permissions Sup-Questionnaire (1) ======*/
	                	/*'visible'=>self::PermissionsMenu(array(
	                		'Questionnaire.*',
	                		'Questionnaire.Create'
	                	)),
	                	'label'=>'เพิ่มแบบสอบถาม',
	                	'url'=>array('//Questionnaire/create')
	                ),
	                array(*/
	                	/*====== Check Permissions Sup-Questionnaire (2) ======*/
	                	/*'visible'=>self::PermissionsMenu(array(
	                		'Questionnaire.*',
	                		'Questionnaire.Index'
	                	)),
	                	'label'=>'จัดการแบบสอบถาม',
	                	'url'=>array('//Questionnaire/index')
	                ),
	            )
	        ),*/

	        array(
	        	/*====== Check Permissions FormSurveyGroup (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Questionnaireout.*',
	        		'Questionnaireout.Index',
	        		'Questionnaireout.Create'
	        	)),
	        	/*'label'=>' <i></i><span>ระบบแบบสอบถาม (ไม่ผูกบทเรียน)</span>',*/
	        	'label'=>' <span class="label label-primary">5</span> <i></i><span>แบบประเมินผลการฝึกอบรม</span>',
	        	'url'=>'#Questionnaireout',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons notes'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Questionnaireout') ), 'id' => 'Questionnaireout'),
	        	'active' => self::SetSubMenu( array('Questionnaireout') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Questionnaireout (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Questionnaireout.*',
	        				'Questionnaireout.Create'
	        			)),
	        			'label'=>'เพิ่มแบบสอบถาม',
	        			'url'=>array('//Questionnaireout/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Questionnaireout (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Questionnaireout.*',
	        				'Questionnaireout.Index'
	        			)),
	        			'label'=>'จัดการแบบสอบถาม',
	        			'url'=>array('//Questionnaireout/index')
	        		),
	        	)
	        ),
	         array(
	        	/*====== Check Permissions AuthitemAccess (1) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'OrgChart.*',
	        		'OrgChart.Index',
	        	)),
	        	'label'=>'<span class="label label-primary">6</span><i></i><span> ระบบจัดการระดับชั้นการเรียน (Organization)</span>',
	        	'url'=>'#OrgChart',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons eye_open'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('OrgChart') ), 'id' => 'OrgChart'),
	        	'active' => self::SetSubMenu( array('OrgChart') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-AuthitemAccess (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'OrgChart.*',
	        				'OrgChart.Index'
	        			)),
						// 'label'=>'Organization chart',
	        			'label'=>'จัดการกลุ่มหลักสูตร',

	        			'url'=>array('//OrgChart/index')
	        		),
	        	)
	        ),


	         array(
               /*====== Check Permissions AuthitemAccess (1) ======*/
                'visible'=>self::PermissionsMenu(array(
                   'MsTeams.*',
                   'MsTeams.Index',
                )),
                'label'=>'<span class="label label-success">1</span><i></i><span> ห้องเรียนรู้ทางไกล</span>',
                                'url'=>'#MsTeams',
                'linkOptions' => array('data-toggle' => 'collapse'),
                'itemOptions' => array('class' => 'hasSubmenu glyphicons globe'),
                'submenuOptions' => array('class' => self::SetSubMenu( array('MsTeams') ), 'id' => 'MsTeams'),
                'active' => self::SetSubMenu( array('MsTeams') ,false),
                'items'=>array(
                    array(
                        /*====== Check Permissions Sup-AuthitemAccess (1) ======*/
                        'visible'=>self::PermissionsMenu(array(
                            'MsTeams.*',
                            'MsTeams.Create'
                        )),
                        'label'=>'เพิ่ม',
                        'url'=>array('//MsTeams/create')
                    ),
                    array(
	                	/*====== Check Permissions Sup-User (1) ======*/
	                	'visible'=>self::PermissionsMenu(array(
	                		'MsTeams.*',
	                		'MsTeams.Index'
	                	)),
	                	'label'=>'จัดการ',
	                	'url'=>array('//MsTeams/index')
	                ),
               )
            ),

	         array(
				/*====== Check Permissions Lesson (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'LessonMsTeams.*',
					'LessonMsTeams.Index',
					'LessonMsTeams.Create',
//	        		'Scorm.*',
//	        		'Scorm.Index',
//	        		'Scorm.Create',
				)),
				'label'=>'<span class="label label-success">2</span> <i></i><span> ระบบจัดการบทเรียนรู้ทางไกล</span>',
				'url'=>'#LessonMsTeams',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons imac'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('LessonMsTeams') ), 'id' => 'LessonMsTeams'),
				'active' => self::SetSubMenu( array('LessonMsTeams') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Lesson (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'LessonMsTeams.*',
							'LessonMsTeams.Create'
						)),
						'label'=>'เพิ่มบทเรียนรู้ทางไกล'." (ภาษา ".$mainLang." )",
						'url'=>array('//LessonMsTeams/create')
					),
					array(
						/*====== Check Permissions Sup-Lesson (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'LessonMsTeams.*',
							'LessonMsTeams.Index'
						)),
						'label'=>'จัดการบทเรียนรู้ทางไกล',
						'url'=>array('//LessonMsTeams/index')
					),
				)
			),


	         array(
				/*====== Check Permissions Grouptesting (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'GrouptestingMsTeams.*',
					'GrouptestingMsTeams.Index',
					'GrouptestingMsTeams.Create'
				)),
				'label'=>'<span class="label label-success">3</span> <i></i><span>ระบบข้อสอบเรียนรู้ทางไกล</span>',
				'url'=>'#GrouptestingMsTeams',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('GrouptestingMsTeams') ), 'id' => 'GrouptestingMsTeams'),
				'active' => self::SetSubMenu( array('GrouptestingMsTeams') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Grouptesting (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'GrouptestingMsTeams.*',
							'GrouptestingMsTeams.Create'
						)),
						'label'=>'เพิ่มชุดข้อสอบบทเรียน',
						'url'=>array('//GrouptestingMsTeams/create')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'GrouptestingMsTeams.*',
							'GrouptestingMsTeams.Index'
						)),
						'label'=>'จัดการข้อสอบบทเรียน',
						'url'=>array('//GrouptestingMsTeams/index')
					),
				)
			),



	          array(
               /*====== Check Permissions AuthitemAccess (1) ======*/
                'visible'=>self::PermissionsMenu(array(
                   'MsOnline.*',
                   'MsOnline.Index',
                )),
                'label'=>'<span class="label label-warning">1</span><i></i><span> ห้องสอบเรียนรู้ทางไกล</span>',
                                'url'=>'#MsOnline',
                'linkOptions' => array('data-toggle' => 'collapse'),
                'itemOptions' => array('class' => 'hasSubmenu glyphicons globe'),
                'submenuOptions' => array('class' => self::SetSubMenu( array('MsOnline') ), 'id' => 'MsOnline'),
                'active' => self::SetSubMenu( array('MsOnline') ,false),
                'items'=>array(
                    array(
                        /*====== Check Permissions Sup-AuthitemAccess (1) ======*/
                        'visible'=>self::PermissionsMenu(array(
                            'MsOnline.*',
                            'MsOnline.Create'
                        )),
                        'label'=>'เพิ่ม',
                        'url'=>array('//MsOnline/create')
                    ),
                    array(
	                	/*====== Check Permissions Sup-User (1) ======*/
	                	'visible'=>self::PermissionsMenu(array(
	                		'MsOnline.*',
	                		'MsOnline.Index'
	                	)),
	                	'label'=>'จัดการ',
	                	'url'=>array('//MsOnline/index')
	                ),
               )
            ),

	         array(
				/*====== Check Permissions Lesson (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'LessonOnline.*',
					'LessonOnline.Index',
					'LessonOnline.Create',
//	        		'Scorm.*',
//	        		'Scorm.Index',
//	        		'Scorm.Create',
				)),
				'label'=>'<span class="label label-warning">2</span> <i></i><span> ระบบบทเรียนสอบเรียนรู้ทางไกล</span>',
				'url'=>'#LessonOnline',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons imac'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('LessonOnline') ), 'id' => 'LessonOnline'),
				'active' => self::SetSubMenu( array('LessonOnline') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Lesson (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'LessonOnline.*',
							'LessonOnline.Create'
						)),
						'label'=>'เพิ่มบทเรียนรู้ทางไกล'." (ภาษา ".$mainLang." )",
						'url'=>array('//LessonOnline/create')
					),
					array(
						/*====== Check Permissions Sup-Lesson (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'LessonOnline.*',
							'LessonOnline.Index'
						)),
						'label'=>'จัดการบทเรียนรู้ทางไกล',
						'url'=>array('//LessonOnline/index')
					),
				)
			),


	         array(
				/*====== Check Permissions Grouptesting (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'GrouptestingOnline.*',
					'GrouptestingOnline.Index',
					'GrouptestingOnline.Create'
				)),
				'label'=>'<span class="label label-warning">3</span> <i></i><span>ระบบข้อสอบห้องสอบเรียนรู้ทางไกล</span>',
				'url'=>'#GrouptestingOnline',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('GrouptestingOnline') ), 'id' => 'GrouptestingOnline'),
				'active' => self::SetSubMenu( array('GrouptestingOnline') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Grouptesting (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'GrouptestingOnline.*',
							'GrouptestingOnline.Create'
						)),
						'label'=>'เพิ่มชุดข้อสอบบทเรียน',
						'url'=>array('//GrouptestingOnline/create')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'GrouptestingOnline.*',
							'GrouptestingOnline.Index'
						)),
						'label'=>'จัดการข้อสอบบทเรียน',
						'url'=>array('//GrouptestingOnline/index')
					),
				)
			),
	         array(
               /*====== Check Permissions AuthitemAccess (1) ======*/
                'visible'=>self::PermissionsMenu(array(
                   'MsTeamsInstitution.*',
                   'MsTeamsInstitution.Index',
                )),
                'label'=>'<span class="label label-important">1</span><i></i><span> ห้องเรียนรู้ทางไกล(สถาบัน)</span>',
                                'url'=>'#MsTeamsInstitution',
                'linkOptions' => array('data-toggle' => 'collapse'),
                'itemOptions' => array('class' => 'hasSubmenu glyphicons globe'),
                'submenuOptions' => array('class' => self::SetSubMenu( array('MsTeamsInstitution') ), 'id' => 'MsTeamsInstitution'),
                'active' => self::SetSubMenu( array('MsTeamsInstitution') ,false),
                'items'=>array(
                    array(
                        /*====== Check Permissions Sup-AuthitemAccess (1) ======*/
                        'visible'=>self::PermissionsMenu(array(
                            'MsTeamsInstitution.*',
                            'MsTeamsInstitution.Create'
                        )),
                        'label'=>'เพิ่ม',
                        'url'=>array('//MsTeamsInstitution/create')
                    ),
                    array(
	                	/*====== Check Permissions Sup-User (1) ======*/
	                	'visible'=>self::PermissionsMenu(array(
	                		'MsTeamsInstitution.*',
	                		'MsTeamsInstitution.Index'
	                	)),
	                	'label'=>'จัดการ',
	                	'url'=>array('//MsTeamsInstitution/index')
	                ),
               )
            ),

	         array(
				/*====== Check Permissions Lesson (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'LessonMsTeamsInstitution.*',
					'LessonMsTeamsInstitution.Index',
					'LessonMsTeamsInstitution.Create',
//	        		'Scorm.*',
//	        		'Scorm.Index',
//	        		'Scorm.Create',
				)),
				'label'=>'<span class="label label-important">2</span> <i></i><span> ระบบจัดการบทเรียนรู้ทางไกล(สถาบัน)</span>',
				'url'=>'#LessonMsTeamsInstitution',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons imac'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('LessonMsTeamsInstitution') ), 'id' => 'LessonMsTeamsInstitution'),
				'active' => self::SetSubMenu( array('LessonMsTeamsInstitution') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Lesson (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'LessonMsTeamsInstitution.*',
							'LessonMsTeamsInstitution.Create'
						)),
						'label'=>'เพิ่มบทเรียนรู้ทางไกล'." (ภาษา ".$mainLang." )",
						'url'=>array('//LessonMsTeamsInstitution/create')
					),
					array(
						/*====== Check Permissions Sup-Lesson (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'LessonMsTeamsInstitution.*',
							'LessonMsTeamsInstitution.Index'
						)),
						'label'=>'จัดการบทเรียนรู้ทางไกล',
						'url'=>array('//LessonMsTeamsInstitution/index')
					),
				)
			),


	         array(
				/*====== Check Permissions Grouptesting (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'GrouptestingMsTeamsInstitution.*',
					'GrouptestingMsTeamsInstitution.Index',
					'GrouptestingMsTeamsInstitution.Create'
				)),
				'label'=>'<span class="label label-important">3</span> <i></i><span>ระบบข้อสอบเรียนรู้ทางไกล(สถาบัน)</span>',
				'url'=>'#GrouptestingMsTeamsInstitution',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('GrouptestingMsTeamsInstitution') ), 'id' => 'GrouptestingMsTeamsInstitution'),
				'active' => self::SetSubMenu( array('GrouptestingMsTeamsInstitution') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Grouptesting (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'GrouptestingMsTeamsInstitution.*',
							'GrouptestingMsTeamsInstitution.Create'
						)),
						'label'=>'เพิ่มชุดข้อสอบบทเรียน',
						'url'=>array('//GrouptestingMsTeamsInstitution/create')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'GrouptestingMsTeamsInstitution.*',
							'GrouptestingMsTeamsInstitution.Index'
						)),
						'label'=>'จัดการข้อสอบบทเรียน',
						'url'=>array('//GrouptestingMsTeamsInstitution/index')
					),
				)
			),


	          array(
				/*====== Check Permissions Category (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'CourseOnline2.*',
					'CourseOnline2.CourseTemp',
					'CourseOnline2.MsteamsTemp',
					'CourseOnline2.OnlineTemp',
				)),
				'label'=>'<i></i><span>อนุมัติการจองหลักสูตร</span>',
				'url'=>'#CourseOnline2',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons check'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('CourseOnline2') ), 'id' => 'CourseOnline2'),
				'active' => self::SetSubMenu( array('CourseOnline2') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Category (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'CourseOnline2.*',
							'CourseOnline2.CourseTemp'
						)),
						'label'=>'หลักสูตรเรียนรู้ด้วยตัวเอง(ชำระเงิน)',
						'url'=>array('//CourseOnline/CourseTemp')
					),
					array(
						/*====== Check Permissions Sup-Category (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'CourseOnline2.*',
							'CourseOnline2.MsteamsTemp'
						)),
						'label'=>'หลักสูตรเรียนรู้ทางไกล(ชำระเงิน)',
						'url'=>array('//CourseOnline/MsteamsTemp')
					),
					array(
						/*====== Check Permissions Sup-Category (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'CourseOnline2.*',
							'CourseOnline2.OnlineTemp'
						)),
						'label'=>'ห้องสอบเรียนรู้ทางไกล',
						'url'=>array('//CourseOnline/OnlineTemp')
					),
				)
			),

	          array(
				/*====== Check Permissions Category (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'ConfirmDocument.*',
					// 'ConfirmDocument.CourseTemp',
					// 'ConfirmDocument.MsteamsTemp',
				)),
				'label'=>'<i></i><span>ตรวจสอบหลักฐานการสมัคร</span>',
				'url'=>'#ConfirmDocument',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons check'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('ConfirmDocument') ), 'id' => 'ConfirmDocument'),
				'active' => self::SetSubMenu( array('ConfirmDocument') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Category (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'ConfirmDocument.*',
							'ConfirmDocument.CourseTemp'
						)),
						'label'=>'หลักสูตรเรียนรู้ด้วยตัวเอง(เอกสารแนบ)',
						'url'=>array('//ConfirmDocument/CourseTemp')
					),
					array(
						/*====== Check Permissions Sup-Category (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'ConfirmDocument.*',
							'ConfirmDocument.MsteamsTemp'
						)),
						'label'=>'หลักสูตรเรียนรู้ทางไกล(เอกสารแนบ)',
						'url'=>array('//ConfirmDocument/MsteamsTemp')
					),
				)
			),

	          array(
				/*====== Check Permissions Category (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'HistoryRegis.*',
					'HistoryRegis.CourseDocumentTemp',
					'HistoryRegis.CoursePaymentTemp',
					'HistoryRegis.MsteamsDocumentTemp',
					'HistoryRegis.MsteamsPaymentTemp',
				)),
				'label'=>'<i></i><span>ประวัติการอนุมัติ</span>',
				'url'=>'#HistoryRegis',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons check'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('HistoryRegis') ), 'id' => 'HistoryRegis'),
				'active' => self::SetSubMenu( array('HistoryRegis') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Category (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'HistoryRegis.*',
							'HistoryRegis.CoursePaymentTemp'
						)),
						'label'=>'ประวัติอนุมัติหลักสูตรเรียนรู้ด้วยตัวเอง(ชำระเงิน)',
						'url'=>array('//HistoryRegis/CoursePaymentTemp')
					),
					array(
						/*====== Check Permissions Sup-Category (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'HistoryRegis.*',
							'HistoryRegis.MsteamsPaymentTemp'
						)),
						'label'=>'ประวัติอนุมัติหลักสูตรเรียนรู้ทางไกล(ชำระเงิน)',
						'url'=>array('//HistoryRegis/MsteamsPaymentTemp')
					),
					array(
						/*====== Check Permissions Sup-Category (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'HistoryRegis.*',
							'HistoryRegis.CourseDocumentTemp'
						)),
						'label'=>'ประวัติอนุมัติหลักสูตรเรียนรู้ด้วยตัวเอง(เอกสารแนบ)',
						'url'=>array('//HistoryRegis/CourseDocumentTemp')
					),
					array(
						/*====== Check Permissions Sup-Category (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'HistoryRegis.*',
							'HistoryRegis.MsteamsDocumentTemp'
						)),
						'label'=>'ประวัติอนุมัติหลักสูตรเรียนรู้ทางไกล(เอกสารแนบ)',
						'url'=>array('//HistoryRegis/MsteamsDocumentTemp')
					),
				)
			),


	           array(
				/*====== Check Permissions Category (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'BankBooking.*',
					'BankBooking.Index',
					'BankBooking.Create'
				)),
				'label'=>'<i></i><span>ธนาคารสำหรับจองหลักสูตร</span>',
				'url'=>'#BankBooking',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons bank'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('BankBooking') ), 'id' => 'BankBooking'),
				'active' => self::SetSubMenu( array('BankBooking') ,false),
				'items'=>array(
					
					array(
						/*====== Check Permissions Sup-Category (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'BankBooking.*',
							'BankBooking.Create'
						)),
						'label'=>'เพิ่มธนาคาร',
						'url'=>array('//BankBooking/Create')
					),

					array(
						/*====== Check Permissions Sup-Category (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'BankBooking.*',
							'BankBooking.Index'
						)),
						'label'=>'จัดการธนาคาร',
						'url'=>array('//BankBooking/Index')
					),
					
				)
			),

           array(
           	/*====== Check Permissions Category (2) ======*/
           	'visible'=>self::PermissionsMenu(array(
           		'mtcodemd.*',
           		'mtcodemd.Index',
           		'mtcodemd.Create'
           	)),
           	'label'=>'<i></i><span>ระบบรหัสหลักสูตร</span>',
           	'url'=>'#mtcodemd',
           	'linkOptions' => array('data-toggle' => 'collapse'),
           	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
           	'submenuOptions' => array('class' => self::SetSubMenu( array('mtcodemd') ), 'id' => 'mtcodemd'),
           	'active' => self::SetSubMenu( array('mtcodemd') ,false),
           	'items'=>array(

           		array(
           			/*====== Check Permissions Sup-Category (2) ======*/
           			'visible'=>self::PermissionsMenu(array(
           				'mtcodemd.*',
           				'mtcodemd.Create'
           			)),
           			'label'=>'เพิ่มรหัสหลักสูตร',
           			'url'=>array('//mtcodemd/Create')
           		),

           		array(
           			/*====== Check Permissions Sup-Category (1) ======*/
           			'visible'=>self::PermissionsMenu(array(
           				'mtcodemd.*',
           				'mtcodemd.Index'
           			)),
           			'label'=>'จัดการรหัสหลักสูตร',
           			'url'=>array('//mtcodemd/Index')
           		),

           	)
           ),






	         // array(
          //      /*====== Check Permissions AuthitemAccess (1) ======*/
          //       'visible'=>self::PermissionsMenu(array(
          //          'LogStartcourse.*',
          //          'LogStartcourse.Index',
          //       )),
          //       'label'=>'<i></i><span>ระบบส่งเมลล์แจ้งเตือนผู้เรียน</span>',
          //                       'url'=>'#LogStartcourse',
          //       'linkOptions' => array('data-toggle' => 'collapse'),
          //       'itemOptions' => array('class' => 'hasSubmenu glyphicons envelope'),
          //       'submenuOptions' => array('class' => self::SetSubMenu( array('LogStartcourse') ), 'id' => 'LogStartcourse'),
          //       'active' => self::SetSubMenu( array('LogStartcourse') ,false),
          //       'items'=>array(
          //        //    array(
	         //        // 	/*====== Check Permissions Sup-User (1) ======*/
	         //        // 	'visible'=>self::PermissionsMenu(array(
	         //        // 		'LogStartcourse.*',
	         //        // 		'LogStartcourse.Index'
	         //        // 	)),
	         //        // 	'label'=>'สมัครเข้าเรียนแล้ว',
	         //        // 	'url'=>array('//LogStartcourse/index')
	         //        // ),
	         //         array(
	         //        	/*====== Check Permissions Sup-User (1) ======*/
	         //        	'visible'=>self::PermissionsMenu(array(
	         //        		'LogStartcourse.*',
	         //        		'LogStartcourse.SendOrgChart'
	         //        	)),
	         //        	'label'=>'จัดการส่งเมลล์แจ้งเตือนผู้เรียน',
	         //        	'url'=>array('//LogStartcourse/SendOrgChart')
	         //        ),
	         //        //    array(
	         //        // 	/*====== Check Permissions Sup-User (1) ======*/
	         //        // 	'visible'=>self::PermissionsMenu(array(
	         //        // 		'MsTeams.*',
	         //        // 		'MsTeams.Logmeeting'
	         //        // 	)),
	         //        // 	'label'=>'Logmeeting',
	         //        // 	'url'=>array('//MsTeams/logmeeting')
	         //        // ),

          //      )
          //   ),
            array(
				
				'visible'=>self::PermissionsMenu(array(
					'CheckLecture.*',
					// 'CheckLecture.update',
				)),
				'label'=>'<i></i><span>ระบบตรวจข้อสอบบรรยาย</span>',
				'url'=>'#CheckLecture',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('CheckLecture') ), 'id' => 'CheckLecture'),
				'active' => self::SetSubMenu( array('CheckLecture') ,false),
				'items'=>array(
					array(
						
						'visible'=>self::PermissionsMenu(array(
							'CheckLecture.*',
							'CheckLecture.index'
						)),
						'label'=>'ตรวจข้อสอบบรรยายบทเรียน',
						'url'=>array('//CheckLecture/index')
					),
					array(
						
						'visible'=>self::PermissionsMenu(array(
							'Signature.*',
							'Signature.update'
						)),

						'label'=>'ตรวจข้อสอบบรรยายหลักสูตร',
						'url'=>array('//CheckLecture/coureCheck')
					),
				)
			),
             array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'Certificate.*',
	        		'CertificateMsTeams.*',

	        	)),
	        	'label'=>'<i></i><span>ระบบใบประกาศนียบัตร</span>',
	        	'url'=>'#Certificate',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Certificate', 'Signature','CertificateMsTeams') ), 'id' => 'Certificate'),
	        	'active' => self::SetSubMenu( array('Certificate', 'Signature','CertificateMsTeams') ,false),
	        	'items'=>array(
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Certificate.*',
	        				'Certificate.index'
	        			)),
	        			'label'=>'จัดการประกาศนียบัตร',
	        			'url'=>array('//Certificate/index')
	        		),

	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'CertificateMsTeams.*',
	        				'CertificateMsTeams.index'
	        			)),
	        			'label'=>'จัดการประกาศนียบัตรห้องเรียนรู้ทางไกล',
	        			'url'=>array('//CertificateMsTeams/index')
	        		),


	        		
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Signature.*',
	        				'Signature.index'
	        			)),
	        			'label'=>'จัดการลายเซนต์',
	        			'url'=>array('//Signature/index')
	        		),
	        	)
	        ),
			 // array(
	        	
	   //      	'visible'=>self::PermissionsMenu(array(
	   //      		'Captcha.*',
	   //      	)),
	   //      	'label'=>'<i></i><span>ระบบ Captcha</span>',
	   //      	'url'=>'#Captcha',
	   //      	'linkOptions' => array('data-toggle' => 'collapse'),
	   //      	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	   //      	'submenuOptions' => array('class' => self::SetSubMenu( array('Captcha') ), 'id' => 'Captcha'),
	   //      	'active' => self::SetSubMenu( array('Captcha') ,false),
	   //      	'items'=>array(
				// 	//set new menu
	   //      		array(
	        			
	   //      			'visible'=>self::PermissionsMenu(array(
	   //      				'Captcha.*',
	   //      			)),
	   //      			'label'=>'ตั้งค่าแคปช่า',
	   //      			'url'=>array('//Captcha/index')
	   //      		),
	   //      	)
	   //      ),
			 array(
	        	/*====== Check Permissions PopUp (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'LearnReset.*',
					// 'Reset.admin',
					// 'Reset.Create'
	        	)),
	        	'label'=>'<i></i><span>ระบบรีเซ็ตผลการเรียนการสอบ</span>',
	        	'url'=>array('//LearnReset/ResetUser'),
				//'url'=>array('//Reset/index'),
				//'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons refresh'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('LearnReset') ), 'id' => 'LearnReset'),
	        	'active' => self::SetSubMenu( array('LearnReset') ,false),
	        ),

			array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'ManageExamResult.*',
					'ManageExamResult.ManageCourse'
	        	)),
	        	'label'=>'<i></i><span>ระบบจัดการผลการสอบ</span>',
	        	'url'=>'#ManageExamResult',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons imac'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('ManageExamResult') ), 'id' => 'ManageExamResult'),
	        	'active' => self::SetSubMenu( array('ManageExamResult') ,false),
	        	'items'=>array(
					//set new menu	


	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'ManageExamResult.*',
							'ManageExamResult.ManageCourse'
	        			)),
	        			'label'=>'จัดการผลการสอบหลักสูตร',
	        			'url'=>array('//ManageExamResult/ManageCourse')
	        		),	

	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'ManageExamResult.*',
							'ManageExamResult.ManageLesson'
	        			)),
	        			'label'=>'จัดการผลการสอบบทเรียน',
	        			'url'=>array('//ManageExamResult/ManageLesson')
	        		)
					
	        	)
	        ),
			//====== END Menu PopUp ======//



			// array(
			// 	/*====== Check Permissions Position (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Problem_type.*',
			// 		'Problem_type.admin',
			// 		'Problem_type.Create'
			// 	)),
			// 	'label'=>'<i></i><span>ประเภทปัญหาการใช้งาน</span>',
			// 	'url'=>'#Problem_type',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('Problem_type') ), 'id' => 'Problem_type'),
			// 	'active' => self::SetSubMenu( array('Problem_type') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Position (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Problem_type.*',
			// 				'Problem_type.Create'
			// 			)),
			// 			'label'=>'เพิ่มประเภท',
			// 			'url'=>array('//Problem_type/create')
			// 		),
			// 		array(
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Problem_type.*',
			// 				'Problem_type.index'
			// 			)),
			// 			'label'=>'จัดการประเภท',
			// 			'url'=>array('//Problem_type/index')
			// 		),
			// 	)
			// ),
			//====== END Menu Position ======//

			//====== END Menu division ======//

	        // array(
	        // 	/*====== Check Permissions featuredlinks (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'FeaturedLinks.*',
	        // 		'FeaturedLinks.admin',
	        // 		'FeaturedLinks.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบจัดการหน่วยงานที่เกี่ยวข้อง</span>',
	        // 	'url'=>'#FeaturedLinks',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('FeaturedLinks') ), 'id' => 'FeaturedLinks'),
	        // 	'active' => self::SetSubMenu( array('FeaturedLinks') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-FeaturedLinks (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'FeaturedLinks.*',
	        // 				'FeaturedLinks.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มลิงค์แนะนำ',
	        // 			'url'=>array('//FeaturedLinks/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-FeaturedLinks (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'FeaturedLinks.*',
	        // 				'FeaturedLinks.admin'
	        // 			)),
	        // 			'label'=>'จัดการลิงค์แนะนำ',
	        // 			'url'=>array('//FeaturedLinks/admin')
	        // 		),
	        // 	)
	        // ),
			//====== END Menu FeaturedLinks ======//
			

	        array(
	        	/*====== Check Permissions Usability (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Usability.*',
	        		'Usability.Index',
	        		'Usability.Create'
	        	)),
	        	'label'=>'<i></i><span>ระบบวิธีการใช้งาน</span>',
	        	'url'=>'#Usability',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons wallet'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Usability') ), 'id' => 'Usability'),
	        	'active' => self::SetSubMenu( array('Usability') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Usability (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Usability.*',
	        				'Usability.Create'
	        			)),
	        			'label'=>'เพิ่มวิธีการใช้งาน'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//Usability/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Usability (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Usability.*',
	        				'Usability.Index'
	        			)),
	        			'label'=>'จัดการวิธีการใช้งาน',
	        			'url'=>array('//Usability/index')
	        		),
	        	)
	        ),
			//====== END Menu Usability ======//

	    //     array(
	    //     	/*====== Check Permissions Group Contactus (2) ======*/
	    //     	'visible'=>self::PermissionsMenu(array(
	    //     		'ReportProblem.*',
	    //     		'ReportProblem.index',
	    //     	)),
	    //     	'label'=>'<i></i><span>ระบบปัญหาการใช้งาน</span>',
	    //     	'url'=>'#ReportProblem',
	    //     	'linkOptions' => array('data-toggle' => 'collapse'),
	    //     	'itemOptions' => array('class' => 'hasSubmenu glyphicons adress_book'),
	    //     	'submenuOptions' => array('class' => self::SetSubMenu( array('ReportProblem','Maildetail') ), 'id' => 'ReportProblem'),
	    //     	'active' => self::SetSubMenu( array('ReportProblem','Maildetail') ,false),
	    //     	'items'=>array(
					// array(
	    //     			/*====== Check Permissions FAQ (2) ======*/
	    //     			'visible'=>self::PermissionsMenu(array(
	    //     				'Problem_type.*',
	    //     				'Problem_type.Index'
	    //     			)),
	    //     			'label'=>'ประเภทปัญหา'." (ภาษา ".$mainLang." )",
	    //     			'url'=>array('//Problem_type/index')
	    //     		),
	    //     		array(
	    //     			/*====== Check Permissions Sup-Contactus (2) ======*/
	    //     			'visible'=>self::PermissionsMenu(array(
	    //     				'ReportProblem.*',
	    //     				'ReportProblem.index'
	    //     			)),
	    //     			'label'=>'จัดการปัญหาการใช้งาน',
	    //     			'url'=>array('//ReportProblem/index')
	    //     		),
	    //     	)
	    //     ),


	        array(
	        	/*====== Check Permissions FAQ (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Faq.*',
	        		'Faq.Index',
	        		'Faq.Create'
					// 'Faqtype.*',
					// 'Faqtype.Index',
					// 'Faqtype.Create'
	        	)),
	        	'label'=>'<i></i><span>ระบบคำถามที่พบบ่อย</span>',
	        	'url'=>'#Faq',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons no-js circle_question_mark'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Faq') ), 'id' => 'Faq'),
	        	'active' => self::SetSubMenu( array('Faq') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions FAQ (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'faqType.*',
	        				'faqType.Index'
	        			)),
	        			'label'=>'หมวดคำถาม'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//faqType/index')
	        		),
	        		array(
	        			/*====== Check Permissions FAQ (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Faq.*',
	        				'Faq.index'
	        			)),
	        			'label'=>'คำถามที่พบบ่อย',
	        			'url'=>array('//Faq/index')
	        		)
	        	)
	        ),
			//====== END Menu FAQ ======//

			

	        

	        array(
	        	/*====== Check Permissions Rights (6) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'adminUser.*',
	        		'adminUser.Create',
	        	)) || 
	        	self::PermissionsMenu(array(
	        		'pGroup.*',
	        		'pGroup.Create',
	        	)) ,
	        	// self::PermissionsMenu(array(
	        	// 	'pController.*',
	        	// 	'pController.Create',
	        	// )),
	        	'label'=>'<i></i><span>ระบบการกำหนดสิทธิการใช้งาน</span>',
	        	'url'=>'#Rights',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons magic'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('authItem','assignment','Level') ), 'id' => 'Rights'),
	        	'active' => self::SetSubMenu( array('authItem','assignment','Level') ,false),
	        	'items'=>array(
					// array(
					// 	/*====== Check Permissions Sup-Rights (3) ======*/
					// 	'visible'=>Yii::app()->user->isSuperuser===true,
					// 	'label'=>Rights::t('core', 'Assignments'),
					// 	'url'=>array('//rights/assignment/view')
					// ),
	        		array(
	        			/*====== Check Permissions Sup-Rights (3) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'adminUser.*',
	        				'adminUser.Create'
	        			)),
	        			'label'=>'ข้อมูลผู้ดูแลระบบ',
	        			'url'=>array('//adminUser/index')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Rights (3) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'pGroup.*',
	        				'pGroup.Create'
	        			)),
	        			'label'=>'กลุ่มผู้ใช้งาน',
	        			'url'=>array('//pGroup/index')
	        		),
	        		// array(
	        		// 	/*====== Check Permissions Sup-Rights (3) ======*/
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'pController.*',
	        		// 		'pController.Create'
	        		// 	)),
	        		// 	'label'=>'เพิ่ม controller',
	        		// 	'url'=>array('//pController/index')
	        		// ),
	        	)
	        ),

	        // array(
	        // 	//////// print ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'printMembership.*',
	        // 		// 'printMembership.Index',
	        // 		// 'printMembership.Approve'
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>พิมพ์ใบสมัคร</span>',
	        // 	'url'=>'#printMembership',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_open'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('printMembership') ), 'id' => 'printMembership'),
	        // 	'active' => self::SetSubMenu( array('printMembership') ,false),
	        // 	'items'=>array(
	        // 		// array(
	        // 		// 	/*====== Check Permissions Sup-Category (1) ======*/
	        // 		// 	'visible'=>self::PermissionsMenu(array(
	        // 		// 		'printMembership.*',
	        // 		// 		'printMembership.Create'
	        // 		// 	)),
	        // 		// 	'label'=>'เพิ่มวีดีโอ'." (ภาษา ".$mainLang." )",
	        // 		// 	'url'=>array('//printMembership/create')
	        // 		// ),
	        // 		array(
	        // 			/*====== Check Permissions Sup-Category (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'printMembership.*',
	        // 				'printMembership.Index'
	        // 			)),
	        // 			'label'=>'สมัครอนุมัติการตรวจสอบ',
	        // 			'url'=>array('//printMembership/index')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-Category (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'printMembership.*',
	        // 				'printMembership.approve'
	        // 			)),
	        // 			'label'=>'อนุมัติการยืนยัน',
	        // 			'url'=>array('//printMembership/approve')
	        // 		),
	        // 	)
	        // ),
	         array(
	        	/*====== Check Permissions User (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'admin.*',
	        		// 'admin.admin',
	        		// 'admin.Create',
	        	)),
	        	'label'=>'<i></i><span>ระบบจัดการสมาชิก (สมาชิก)</span>',
	        	'url'=>'#admin',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons user_add'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('admin') ) , 'id' => 'admin'),
	        	'active' => self::SetSubMenu( array('admin') ,false),
	        	'items'=>array(
	        
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (1) ======*/
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'admin.*',
	        		// 		'admin.Excel'
	        		// 	)),
	        		// 	'label'=>'จัดการสมาชิกจาก Excel (HR)',
	        		// 	'url'=>array('//user/admin/indexExcel')
	        		// ),
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (1) ======*/
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'admin.*',
	        		// 		'admin.Excellocal'
	        		// 	)),
	        		// 	'label'=>'จัดการสมาชิกจาก Excel (local)',
	        		// 	'url'=>array('//user/admin/localExcel')
	        		// ),
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (1) ======*/
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'admin.*',
	        		// 		'admin.Create'
	        		// 	)),
	        		// 	'label'=>'เพิ่มสมาชิก',
	        		// 	'url'=>array('//user/admin/create')
	        		// ),
	        		
	        		
	        		array(
	        			/*====== Check Permissions Sup-User (2) ======*/
	        			'visible'=>true,
	        			'label'=>'รายชื่อสมาชิก',
	        			'url'=>array('//user/admin/general')
	        		),
	        		
	        	)
	        ),

	        //  array(
	        // 	//////// print ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'monthCheck.*',
	        // 		// 'monthCheck.admin',
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>ระบบตรวจสอบการใช้งาน</span>',
	        // 	'url'=>'#monthCheck',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_open'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('monthCheck') ), 'id' => 'monthCheck'),
	        // 	'active' => self::SetSubMenu( array('monthCheck') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-Category (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'monthCheck.*',
	        // 				'monthCheck.admin'
	        // 			)),
	        // 			'label'=>'กำหนดระยะเวลาในการเข้าใช้งานคนประจำเรือ',
	        // 			'url'=>array('//monthCheck/admin')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-Category (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'monthCheck.*',
	        // 				'monthCheck.approve'
	        // 			)),
	        // 			'label'=>'กำหนดระยะเวลาในการเข้าใช้งานบุคคลทั่วไป',
	        // 			'url'=>array('//monthCheck/personal')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-User (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'admin.*',
	        // 				'admin.Access'
	        // 			)),
	        // 			'label'=>'ระบบตรวจสอบการเข้าใช้งานคนประจำเรือ',
	        // 			'url'=>array('//user/admin/access')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-User (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'admin.*',
	        // 				'admin.AccessPersonal'
	        // 			)),
	        // 			'label'=>'ระบบตรวจสอบการเข้าใช้งานคนบุคคลทั่วไป',
	        // 			'url'=>array('//user/admin/accessPersonal')
	        // 		),
	        // 	)
	        // ),
            array(
	        	//////// SlideImg ////////
	        	'visible'=>self::PermissionsMenu(array(
	        		'imgslide.*',
	        		'imgslide.Index',
	        		'imgslide.Create'
	        	)),
	        	'label'=>'<span class="label label-primary"></span> <i></i><span>ระบบป้ายประชาสัมพันธ์</span>',
	        	'url'=>'#imgslide',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons bullhorn'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('imgslide') ), 'id' => 'imgslide'),
	        	'active' => self::SetSubMenu( array('imgslide') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Category (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'imgslide.*',
	        				'imgslide.Create'
	        			)),
	        			'label'=>'เพิ่มป้ายประชาสัมพันธ์'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//imgslide/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Category (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'imgslide.*',
	        				'imgslide.Index'
	        			)),
	        			'label'=>'จัดการป้ายประชาสัมพันธ์',
	        			'url'=>array('//imgslide/index')
	        		),
	        	)
	        ),

	        // array(
	        // 	//////// GalleryType ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'GalleryType.*',
	        // 		'GalleryType.Index',
	        // 		'GalleryType.Create'
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>ประเภทแกลลอรี่</span>',
	        // 	'url'=>'#GalleryType',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('GalleryType') ), 'id' => 'GalleryType'),
	        // 	'active' => self::SetSubMenu( array('GalleryType') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'GalleryType.*',
	        // 				'GalleryType.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มประเภทแกลลอรี่',
	        // 			'url'=>array('//GalleryType/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'GalleryType.*',
	        // 				'GalleryType.Index'
	        // 			)),
	        // 			'label'=>'จัดการประเภทแกลลอรี่',
	        // 			'url'=>array('//GalleryType/index')
	        // 		),
	        		
	        // 	)
	        // ),
	       

	        // // array(
	        // // 	//////// Gallery ////////
	        // // 	'visible'=>self::PermissionsMenu(array(
	        // // 		'Gallery.*',
	        // // 		'Gallery.Index',
	        // // 		'Gallery.Create'
	        // // 	)),
	        // // 	'label'=>'<span class="label label-primary"></span> <i></i><span>แกลลอรี่</span>',
	        // // 	'url'=>'#Gallery',
	        // // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
	        // // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Gallery') ), 'id' => 'Gallery'),
	        // // 	'active' => self::SetSubMenu( array('Gallery') ,false),
	        // // 	'items'=>array(

	        // // 		array(
	        // // 			'visible'=>self::PermissionsMenu(array(
	        // // 				'Gallery.*',
	        // // 				'Gallery.create'
	        // // 			)),
	        // // 			'label'=>'เพิ่มแกลลอรี่',
	        // // 			'url'=>array('//Gallery/create')
	        // // 		),
	        // // 		array(
	        // // 			'visible'=>self::PermissionsMenu(array(
	        // // 				'Gallery.*',
	        // // 				'Gallery.Index'
	        // // 			)),
	        // // 			'label'=>'จัดการแกลลอรี่',
	        // // 			'url'=>array('//Gallery/Index')
	        // // 		),
	        // // 	)
	        // // ),

	        // array(
	        // 	//////// Gallery ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'GalleryGroup.*',
	        // 		'GalleryGroup.Index',
	        // 		'GalleryGroup.Create'
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>แกลลอรี่</span>',
	        // 	'url'=>'#GalleryGroup',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('GalleryGroup') ), 'id' => 'GalleryGroup'),
	        // 	'active' => self::SetSubMenu( array('GalleryGroup') ,false),
	        // 	'items'=>array(

	        // 		// array(
	        // 		// 	'visible'=>self::PermissionsMenu(array(
	        // 		// 		'GalleryGroup.*',
	        // 		// 		'GalleryGroup.create'
	        // 		// 	)),
	        // 		// 	'label'=>'เพิ่มแกลลอรี่',
	        // 		// 	'url'=>array('//GalleryGroup/create')
	        // 		// ),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'GalleryGroup.*',
	        // 				'GalleryGroup.Index'
	        // 			)),
	        // 			'label'=>'จัดการแกลลอรี่',
	        // 			'url'=>array('//GalleryGroup/Index')
	        // 		),
	        // 	)
	        // ),

	        array(
	        	'visible'=>self::PermissionsMenu(array(
	        		'LibraryType.*',
	        		'LibraryFile.*',
	        	)),
	        	'label'=>'<span class="label label-primary"></span> <i></i><span>ระบบห้องสมุดอิเล็กทรอนิกส์</span>',
	        	'url'=>'#LibraryType',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('LibraryType', 'LibraryFile') ), 'id' => 'LibraryType'),
	        	'active' => self::SetSubMenu( array('LibraryType', 'LibraryFile') ,false),
	        	'items'=>array(
	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'LibraryType.Index'
	        			)),
	        			'label'=>'จัดการประเภทห้องสมุด',
	        			'url'=>array('//LibraryType/index')
	        		),
	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'LibraryFile.Index'
	        			)),
	        			'label'=>'จัดการห้องสมุด',
	        			'url'=>array('//LibraryFile/index')
	        		),
	        		// array(
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'LibraryFile.download'
	        		// 	)),
	        		// 	'label'=>'จัดการการอนุมัติการดาวน์โหลด',
	        		// 	'url'=>array('//LibraryFile/download')
	        		// ),
	        		
	        	)
	        ),

	        
	        

	        // array(
	        // 	//////// MainImage ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Mainimage.*',
	        // 		'Mainimage.Index',
	        // 		'Mainimage.Create'
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>รูปภาพโฆษณา</span>',
	        // 	'url'=>'#Mainimage',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons bullhorn'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Mainimage') ), 'id' => 'Mainimage'),
	        // 	'active' => self::SetSubMenu( array('Mainimage') ,false),
	        // 	'items'=>array(

	        // 		array(
	        // 			/*====== Check Permissions Sup-Category (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Mainimage.*',
	        // 				'Mainimage.Index'
	        // 			)),
	        // 			'label'=>'จัดการรูปภาพโฆษณา',
	        // 			'url'=>array('//Mainimage/index')
	        // 		),
	        // 	)
	        // ),

	       



			// array(
			// 	/*====== Check Permissions User (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Generation.*',
			// 		'Generation.Create',
			// 		'Generation.index',
			// 	)),
			// 	'label'=>'<i></i><span>ระบบจัดการรุ่นสมาชิก</span>',
			// 	'url'=>'#generation',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons user_add'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('generation') ) , 'id' => 'generation'),
			// 	'active' => self::SetSubMenu( array('generation') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Sup-User (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Generation.*',
			// 				'Generation.Create'
			// 			)),
			// 			'label'=>'สร้างรุ่น',
			// 			'url'=>array('//Generation/create')
			// 		),
			// 		array(
			// 			/*====== Check Permissions Sup-User (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Generation.*',
			// 				'Generation.index'
			// 			)),
			// 			'label'=>'จัดการรุ่น',
			// 			'url'=>array('//Generation/index')
			// 		),
			// 	)
			// ),

			// array(
			// 	/*====== Check Permissions Teacher (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Teacher.*',
			// 		'Teacher.Index',
			// 		'Teacher.Create'
			// 	)),
			// 	'label'=>'<i></i><span>ระบบรายชื่อวิทยากร</span>',
			// 	'url'=>'#Teacher',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons old_man'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('Teacher') ), 'id' => 'Teacher'),
			// 	'active' => self::SetSubMenu( array('Teacher') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Sup-Teacher (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Teacher.*',
			// 				'Teacher.Create'
			// 			)),
			// 			'label'=>'เพิ่มรายชื่อวิทยากร',
			// 			'url'=>array('//Teacher/create')
			// 		),
			// 		array(
			// 			/*====== Check Permissions Sup-Teacher (2) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Teacher.*',
			// 				'Teacher.Index'
			// 			)),
			// 			'label'=>'จัดการรายชื่อวิทยากร',
			// 			'url'=>array('//Teacher/index')
			// 		),
			// 	)
			// ),
			//====== END Menu Teacher ======//

			//====== END Menu Group Contactus ======//
			
	        // array(
	        // 	/*====== Check Permissions Setting (1)  ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'courseNotification.*',
	        // 		'courseNotification.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบตั้งค่าการแจ้งเตือนบทเรียน</span>',
	        // 	'url'=>'#courseNotification',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons cogwheel'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('courseNotification') ) , 'id' => 'courseNotification'),
	        // 	'active' => self::SetSubMenu(array('courseNotification'),false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-courseNotification (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'courseNotification.*',
	        // 				'courseNotification.Create'
	        // 			)),
	        // 			'label'=>'สร้างระบบแจ้งเตือนบทเรียน',
	        // 			'url'=>array('//courseNotification/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-courseNotification (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'courseNotification.*',
	        // 				'courseNotification.index'
	        // 			)),
	        // 			'label'=>'จัดการระบบแจ้งเตือนบทเรียน',
	        // 			'url'=>array('//courseNotification/index')
	        // 		),
	        // 	)
	        // ),
	        //  array(
	        // 	/*====== Check Permissions Department (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Ship.*',
	        // 		'Ship.index',
	        // 		'Ship.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>เรือ</span>',
	        // 	'url'=>'#Ship',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons anchor'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Ship') ), 'id' => 'Ship'),
	        // 	'active' => self::SetSubMenu( array('Ship') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Position (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Ship.*',
	        // 				'Ship.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มเรือ',
	        // 			'url'=>array('//Ship/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Ship.*',
	        // 				'Ship.index'
	        // 			)),
	        // 			'label'=>'จัดการเรือ',
	        // 			'url'=>array('//Ship/index')
	        // 		),
	        // 	)
	        // ),
         //    array(
	        // 	/*====== Check Permissions Department (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Department.*',
	        // 		'Department.admin',
	        // 		'Department.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>แผนก</span>',
	        // 	'url'=>'#Department',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Department') ), 'id' => 'Department'),
	        // 	'active' => self::SetSubMenu( array('Department') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Position (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Department.*',
	        // 				'Department.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มแผนก',
	        // 			'url'=>array('//Department/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Department.*',
	        // 				'Department.admin'
	        // 			)),
	        // 			'label'=>'จัดการแผนก',
	        // 			'url'=>array('//Department/admin')
	        // 		),
	        // 	)
	        // ),

	        // array(
	        // 	/*====== Check Permissions Position (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Position.*',
	        // 		'Position.admin',
	        // 		'Position.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>ตำแหน่ง</span>',
	        // 	'url'=>'#Position',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Position') ), 'id' => 'Position'),
	        // 	'active' => self::SetSubMenu( array('Position') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Position (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Position.*',
	        // 				'Position.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มตำแหน่ง',
	        // 			'url'=>array('//Position/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Position.*',
	        // 				'Position.index'
	        // 			)),
	        // 			'label'=>'จัดการตำแหน่ง',
	        // 			'url'=>array('//Position/index')
	        // 		),
	        // 	)
	        // ),

	        // array(
	        // 	/*====== Check Permissions Position (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Branch.*',
	        // 		'Branch.admin',
	        // 		'Branch.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>Level(ตำแหน่ง office)</span>',
	        // 	'url'=>'#Branch',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Branch') ), 'id' => 'Branch'),
	        // 	'active' => self::SetSubMenu( array('Branch') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Branch (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Branch.*',
	        // 				'Branch.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มLevel',
	        // 			'url'=>array('//Branch/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Branch.*',
	        // 				'Branch.index'
	        // 			)),
	        // 			'label'=>'จัดการLevel',
	        // 			'url'=>array('//Branch/index')
	        // 		),
	        // 	)
	        // ),
	        //  array(
	        	
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Passcours.*',
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบพิมพ์ใบประกาศนียบัตร</span>',
	        // 	'url'=>'#Passcours',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Passcours') ), 'id' => 'Passcours'),
	        // 	'active' => self::SetSubMenu( array('Passcours') ,false),
	        // 	'items'=>array(
	        // 		array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Passcours.*',
	        // 				'Passcours.index',
	        // 			)),
	        // 			'label'=>'รายงานผู้ขอรับใบประกาศนียบัตร',
	        // 			'url'=>array('//Passcours/request_cert')
	        // 		),
	        // 		array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Passcours.*',
	        // 				'Passcours.index',
	        // 			)),
	        // 			'label'=>'รายงานผู้ผ่านการเรียน',
	        // 			'url'=>array('//Passcours/index')
	        // 		),
	        // 	    array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Passcours.*',
	        // 				'Passcours.PasscoursLog',
	        // 			)),
	        // 			'label'=>'รายงานสถิติจำนวนผู้พิมพ์ใบประกาศฯ',
	        // 			'url'=>array('//Passcours/PasscoursLog')
	        // 		),
	        		
	        // 	)
	        // ),

	         
	        
            //====== END Menu FormSurveyGroup ======//
	        // array(
	        	
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Report.*',
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบ ติดตามผู้เรียน</span>',
	        // 	'url'=>'#ReportFollow',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Report') ), 'id' => 'ReportFollow'),
	        // 	'active' => self::SetSubMenu( array('Report') ,false),
	        // 	'items'=>array(
	        // 		array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Report.*',
	        // 			)),
	        // 			'label'=>'1.) ข้อมูลการฝึกอบรมของพนักงานรายบุคคล',
	        // 			'url'=>array('//Report/Status')
	        // 		),
	        // 		array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Report.*',
	        // 			)),
	        // 			'label'=>'2.) ค้นหาโดยใช้หลักสูตร',
	        // 			'url'=>array('//Report/ByCourse')
	        // 		),
	        // 		array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Report.*',
	        // 			)),
	        // 			'label'=>'3.) ค้นหาโดยใช้บทเรียน',
	        // 			'url'=>array('//Report/ByLesson')
	        // 		),
	        // 		// array(
	        			
	        // 		// 	'visible'=>self::PermissionsMenu(array(
	        // 		// 		'Report.*',
	        // 		// 	)),
	        // 		// 	'label'=>'4.) รายงานติดตามผู้เรียนรายบุคคล',
	        // 		// 	'url'=>array('//Report/ByUser')
	        // 		// ),
	        // 		// array(
	        // 		// 	
	        // 		// 	'visible'=>self::PermissionsMenu(array(
	        // 		// 		'Report.*',
	        // 		// 	)),
	        // 		// 	'label'=>'5.) รายงานผู้ประเมินระดับผู้เรียนรายบุคคล',
	        // 		// 	'url'=>array('//Report/Individual')
	        // 		// 	//'url'=>array('//Report/score')
	        // 		// ),

	        // 	)
	        // ),


	        // array(	        	
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'ReportAuthority.*'
	        // 	)),
	        // 	'label'=>'<i></i><span>กำหนดสิทธิ์ Report หน้าบ้าน</span>',
	        // 	'url'=>'#ReportAuthority',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons user_add'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('ReportAuthority', ) ), 'id' => 'ReportAuthority'),
	        // 	'active' => self::SetSubMenu( array('ReportAuthority', ) ,false),
	        // 	'items'=>array(
	        // 		array(	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'ReportAuthority.Board',
	        // 			)),
	        // 			'label'=>'จัดการ ผู้บริหาร',
	        // 			'url'=>array('//ReportAuthority/Board')
	        // 		),
	        // 		array(	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'ReportAuthority.DivisionManager',
	        // 			)),
	        // 			'label'=>'จัดการ ผู้จัดการฝ่าย',
	        // 			'url'=>array('//ReportAuthority/DivisionManager')
	        // 		),
	        // 		array(	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'ReportAuthority.DepartmentManager',
	        // 			)),
	        // 			'label'=>'จัดการ ผู้จัดการแผนก',
	        // 			'url'=>array('//ReportAuthority/DepartmentManager')
	        // 		),
	        // 	)
	        // ),



	        array(
	        	/*====== Check Permissions Position (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Institution.*',
	        		'Institution.Index',
	        		'Institution.Create'
	        	)),
	        	'label'=>'<i></i><span>สถาบัน</span>',
	        	'url'=>'#Institution',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Institution') ), 'id' => 'Institution'),
	        	'active' => self::SetSubMenu( array('Institution') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Position (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Institution.*',
	        				'Institution.Create'
	        			)),
	        			'label'=>'เพิ่มสถาบัน',
	        			'url'=>array('//Institution/create')
	        		),
	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Institution.*',
	        				'Institution.Index'
	        			)),
	        			'label'=>'จัดการสถาบัน',
	        			'url'=>array('//Institution/Index')
	        		),
	        	)
	        ),


	         array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'ImportData.*'
	        	)),
	        	'label'=>'<i></i><span>ระบบ Import</span>',
	        	'url'=>'#ImportData',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('ImportData') ), 'id' => 'ImportData'),
	        	'active' => self::SetSubMenu( array('ImportData') ,false),
	        	'items'=>array(
					//set new menu	

					array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'ImportData.ImportExcel',
	        			)),
	        			'label'=>'Import ข้อมูลสถาบันกรมเจ้าท่า',
	        			'url'=>array('//ImportData/ImportExcel')
	        		),

	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'ImportData.ImportExcelIndex',
	        			)),
	        			'label'=>'จัดการข้อมูลสถาบันกรมเจ้าท่า',
	        			'url'=>array('//ImportData/ImportExcelIndex')
	        		),


					array(

						'visible'=>self::PermissionsMenu(array(
							'ImportData.ImportExcelPass',
						)),
						'label'=>'Import ข้อมูลผู้ผ่านการเรียนกรมเจ้าท่า',
						'url'=>array('//ImportData/ImportExcelPass')
					),	
					
					array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'ImportData.ImportExcelPassIndex',
	        			)),
	        			'label'=>'จัดการข้อมูลผู้ผ่านการเรียนกรมเจ้าท่า',
	        			'url'=>array('//ImportData/ImportExcelPassIndex')
	        		),	

	        	)
	        ),

	          array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'CaptureScreen.*'
	        	)),
	        	'label'=>'<i></i><span>ระบบ จัดการภาพถ่าย</span>',
	        	'url'=>'#CaptureScreen',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('CaptureScreen') ), 'id' => 'CaptureScreen'),
	        	'active' => self::SetSubMenu( array('CaptureScreen') ,false),
	        	'items'=>array(
					array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'CaptureScreen.*',
							'CaptureScreen.ExportIndexTheory'
	        			)),
	        			'label'=>'จัดการ Export ภาพถ่ายศึกษาด้วยตนเอง',
	        			'url'=>array('//CaptureScreen/ExportIndexTheory')
	        		),	
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'CaptureScreen.*',
	        			)),
	        			'label'=>'จัดการ Export ภาพถ่ายเรียนรู้ทางไกล (zoom)',
	        			'url'=>array('//CaptureScreen/ExportIndex')
	        		),	
	        	)
	        ),




	        array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'Report.*'
	        	)),
	        	'label'=>'<i></i><span>ระบบ Report</span>',
	        	'url'=>'#Report',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Report') ), 'id' => 'Report'),
	        	'active' => self::SetSubMenu( array('Report') ,false),
	        	'items'=>array(
					//set new menu	


	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'รายงาน เงื่อนไขตามประกาศกรมเจ้าท่า',
	        			'url'=>array('//Report/ConditionMd')
	        		),	

	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'รายงาน ผู้ผ่านการเรียน',
	        			'url'=>array('//Report/LearningPass')
	        		),
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'รายงาน ผลการสอบ',
	        			'url'=>array('//Report/ExamResult')
	        		),

	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'รายงาน การจองหลักสูตร',
	        			'url'=>array('//Report/BookingCourse')
	        		),		

					
	        	)
	        ),


		


    //         array(
	   //      	/*====== Check Permissions PopUp (2) ======*/
	   //      	'visible'=>self::PermissionsMenu(array(
	   //      		'LogEmail.*',
	   //      		'LogEmail.email'
	   //      	)),
	   //      	'label'=>'<i></i><span>web service</span>',
	   //      	'url'=>array(),
				// //'linkOptions' => array('data-toggle' => 'collapse'),
	   //      	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	   //      	'submenuOptions' => array('class' => self::SetSubMenu( array('LogEmail') ), 'id' => 'LogEmail'),
	   //      ),
			// ====== END Menu Information ======//
	       

	        // array(
	        // 	
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Captcha.*',
	        // 		'Captcha.update',
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบ ตั้งค่า Captcha</span>',
	        // 	'url'=>'#Captcha',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Captcha') ), 'id' => 'Captcha'),
	        // 	'active' => self::SetSubMenu( array('Captcha') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Captcha.*',
	        // 				'Captcha.update'
	        // 			)),
	        // 			'label'=>'ตั้งค่า Captcha',
	        // 			'url'=>array('//Captcha/index')
	        // 		)
	        // 	)
			// ),

	        // array(
	        // 	/*====== Check Permissions Company (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Company.*',
	        // 		'Company.admin',
	        // 		'Company.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>ฝ่าย</span>',
	        // 	'url'=>'#Company',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Company') ), 'id' => 'Company'),
	        // 	'active' => self::SetSubMenu( array('Company') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-PopUp (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Company.*',
	        // 				'Company.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มฝ่าย'." (ภาษา ".$mainLang." )",
	        // 			'url'=>array('//Company/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-PopUp (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Company.*',
	        // 				'Company.admin'
	        // 			)),
	        // 			'label'=>'จัดการฝ่าย',
	        // 			'url'=>array('//Company/admin')
	        // 		),
	        // 	)
	        // ),
	        // array(
	        // 	/*====== Check Permissions Company (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Station.*',
	        // 		'Station.admin',
	        // 		'Station.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>สถานี</span>',
	        // 	'url'=>'#Station',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Station') ), 'id' => 'Station'),
	        // 	'active' => self::SetSubMenu( array('Station') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-PopUp (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Station.*',
	        // 				'Station.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มสถานี'." (ภาษา ".$mainLang." )",
	        // 			'url'=>array('//Station/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-PopUp (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Station.*',
	        // 				'Station.admin'
	        // 			)),
	        // 			'label'=>'จัดการสถานี',
	        // 			'url'=>array('//Station/admin')
	        // 		),
	        // 	)
	        // ),
	        // array(
	        // 	/*====== Check Permissions division (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'division.*',
	        // 		'division.admin',
	        // 		'division.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>กอง</span>',
	        // 	'url'=>'#division',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('division') ), 'id' => 'division'),
	        // 	'active' => self::SetSubMenu( array('division') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions division (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'division.*',
	        // 				'division.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มกอง'." (ภาษา ".$mainLang." )",
	        // 			'url'=>array('//division/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions division (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'division.*',
	        // 				'division.admin'
	        // 			)),
	        // 			'label'=>'จัดการกอง',
	        // 			'url'=>array('//division/admin')
	        // 		),
	        // 	)
	        // ),
			//====== END Menu Company ======//



	        // array(
	        	
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'LogAdmin.*',
	        // 		// 'LogAdmin.update',
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบเก็บ Log การใช้งานระบบ</span>',
	        // 	'url'=>'#LogAdmin',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('LogAdmin') ), 'id' => 'LogAdmin'),
	        // 	'active' => self::SetSubMenu( array('LogAdmin') ,false),
	        // 	'items'=>array(
	        // 		array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'LogAdmin.*',
	        // 				'LogAdmin.users'
	        // 			)),
	        // 			'label'=>'Log การใช้งานผู้เรียน',
	        // 			'url'=>array('//logAdmin/users')
	        // 		),
	        // 		array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'LogAdmin.*',
	        // 				'LogAdmin.index'
	        // 			)),
	        // 			'label'=>'Log การใช้งานผู้ดูแลระบบ',
	        // 			'url'=>array('//logAdmin/index')
	        // 		),
	        		
	        // 	)
	        // ),

	        // array(
	        	
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'student_photo.*',
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบการยืนยันการเข้าเรียนของผู้เรียน</span>',
	        // 	'url'=>'#student_photo',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons film'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('student_photo') ), 'id' => 'student_photo'),
	        // 	'active' => self::SetSubMenu( array('student_photo') ,false),
	        // 	'items'=>array(
	        // 		// array(
	        			
	        // 		// 	'visible'=>self::PermissionsMenu(array(
	        // 		// 		'student_photo.*',
	        // 		// 		'student_photo.index',
	        // 		// 	)),
	        // 		// 	'label'=>'จัดการการถ่ายภาพนักเรียน',
	        // 		// 	'url'=>array('//student_photo/index')
	        // 		// ),
	        // 	    array(
	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'capture.*',
	        // 				'capture.index',
	        // 			)),
	        // 			'label'=>'จัดการภาพถ่ายนักเรียน',
	        // 			'url'=>array('//capture/index')
	        // 		),
	        		
	        // 	)
	        // ),


	    );



}
}
