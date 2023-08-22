<?php
class Controller extends RController
{
	private $_assetsBase;

	public $layout='//layouts/column2';

	public $menu = array();

	public $breadcrumbs=array();

	public $defaultAction = "index";
   
    public function getAssetsBase()
    {
        if($this->_assetsBase === null) 
        {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('webroot.themes.'.Yii::app()->theme->name.'.assets'),false,-1,false
            );
        }
        return $this->_assetsBase;
    }

    public function init()
    {
    	if(!Yii::app()->user->isGuest)
        {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $user->lastactivity = time();
            $user->last_activity = date('Y-m-d H:i:s');
            if($user->online_status == 0){
                $user->online_status = 1;
            }
            $user->update();

            //AccessControl::check_access_filemanager($user->superuser);

            // $chatstatus=CometchatStatus::model()->find('userid='.Yii::app()->user->id);
            // if(!$chatstatus){
            //     $chatstatus = new CometchatStatus;
            //     $chatstatus->userid =  Yii::app()->user->id;
            //     $chatstatus->status = "available";
            //     $chatstatus->save();
            // }
        }
        // if(!Yii::app()->user->isGuest)
        // {
        //     $nameAdmin = Yii::app()->getModule('user')->user();
        //     $modelLevel = Level::model()->findByPk($nameAdmin->superuser);
        //     if($modelLevel->level_login != "1")
        //     {
        //         Yii::app()->session->clear();
        //         Yii::app()->session->destroy();
        //         $this->redirect(array('/user/login'));
        //         Yii::app()->end();
        //     }
        // }

        if(Yii::app()->user->id != null){
				// $this->checkToken(Yii::app()->request->cookies['token_login']->value);
			}
    }

    private function checkToken($token){
		$logoutid = User::model()->findByPk(Yii::app()->user->id);
		if($logoutid->avatar != $token){
			$this->gotoLogout();
		}
	}

	private function gotoLogout()
	{
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		$logoutid = Users::model()->findByPk(Yii::app()->user->id);
		$logoutid->lastvisit_at = date("Y-m-d H:i:s",time()) ;
		$logoutid->online_status = '0';
		$logoutid->save(false);
		Yii::app()->user->logout();
		$this->redirect(array('site/index'));
	}

    // public static function PButton( $menu = array() )
    // {
    //     $Sum = 0;
    //     $countArray = count($menu);
    //     if($countArray != 0)
    //     {
    //         foreach ($menu as $key => $value) 
    //         {
    //             if(Yii::app()->user->checkAccess($value) === true)
    //             {
    //                 $Sum = $Sum+1; 
    //             }
    //         }
    //     }

    //     if($Sum >= 1) $check = true; else $check = false;

    //     return $check; 
    // }

    public static function PButton( $menu = array() )
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
                            $controller_name = $val[0];
                            $action_name = $val[1];
                            $check = AccessControl::check_access_action($controller_name,$action_name);
                            if($check){
                                $return = true;
                            }else{
                                $return = false;
                            }
			}
		}
		return $return;
    }

    public static function SetAccess($set=array())
    {
    	$Sum = 0;
        $access = false;
        $countArray = count($set);

        if ($countArray != 0)
        {
            foreach ($set as $key => $value) 
            {
            	$Explode = explode('*', $value);
            	$Index = $Explode[0].'Index';
		        // $modelAccess = AuthitemAccess::model()->find(array(
		        //     'select'=>'access','condition'=>' name = "'. $value .'" '
		        // )); 
		        $modelAccess = AuthitemAccess::model()->findByAttributes(array('name'=>$value)); 
		        if(isset($modelAccess))
		        {
		            if($modelAccess->access == "1" && Yii::app()->user->checkAccess($Index) === true )
		            {
		                $Sum = $Sum+1; 
		            }
		        }
            }
        }

        if($Sum >= 1) $access = true; else $access = false;

        return $access;
    }

 //    public static function PermissionsAdmin( $menu = array() )
 //    {
	// 	/*=============================================
	// 	=             Check Permissions	             =
	// 	=============================================*/
	// 	$sum = 0;
	// 	$countArray = count($menu);
	// 	$return = false;        

	// 	if($countArray != 0)
	// 	{
	// 		foreach ($menu as $key => $value)
	// 		{
	// 			$val = explode('.',$value);
	// 			$controller_name = $val[0];
	// 			$action_name = $val[1];
	// 			$check = AccessControl::check_access_admin($controller_name,$action_name);
	// 			if($check){
	// 				$return = true;
	// 			}else{
	// 				$return = false;
	// 			}
	// 		}
	// 	}
	// 	return $return;
	// }


    public static function DeleteAll( $menu = array() )
    {
        $Sum = 0;
        $countArray = count($menu);
        if($countArray != 0)
        {
            foreach ($menu as $key => $value) 
            {
                if(Yii::app()->user->checkAccess($value) === true)
                {
                    $Sum = $Sum+1; 
                }
            }
        }
        if($Sum >= 2) $check = true; else $check = false;

        return $check; 
    }

    public static function ImageShowUser($Yush,$data,$image,$data2,$array=array(),$noimgname='default-avatar.png')
	{
		if(@getimagesize(Yush::getUrl($data, $Yush, $image))){

			$imgCheck = CHtml::image(Yush::getUrl($data, $Yush, $image),$image,$array);

		}elseif (@getimagesize(Yush::getUrl($data2, $Yush, $image))) {
			
			$imgCheck = CHtml::image(Yush::getUrl($data2, $Yush, $image),$image,$array);

		}else{

			$imgCheck = CHtml::image(Yii::app()->theme->baseUrl.'/images/'.$noimgname, 'No Image', $array);

		}

		return $imgCheck;
	}

	public function listGroupCourse($model,$id,$class='')
	{
		return CHtml::activeDropDownList($model,'group_id',Coursegrouptesting::getClients($id) , array(
			'empty'=>'เลือกชื่อชุดข้อสอบ',
			'class'=>$class
		));
	}

	public function listTeacher_new($model,$class='',$field)
	{
		$list = CHtml::listData(Teacher::model()->findAll(array(
		"condition"=>" active = 'y' ")),'teacher_id', 'teacher_name');
		return CHtml::activeDropDownList($model,$field,$list , array(
			'empty'=>'กรุณาเลือก',
			'class'=>$class
		));
	}

	public function listQHeader_new($model,$class='',$field)
	{
		$list = CHtml::listData(QHeader::model()->findAll(),'survey_header_id', 'survey_name');
		return CHtml::activeDropDownList($model,$field,$list , array(
			'empty'=>'กรุณาเลือก',
			'class'=>$class
		));
	}

    // NotEmpty From Validate
    public static function NotEmpty()
    {
        return '<span style="margin:0;" class="btn-action single glyphicons circle_question_mark"><i></i></span>';
    }

	// Query List ShopType
	public function listCateType($model,$class='')
	{
		return CHtml::activeDropDownList($model,'cate_type',array(
			'1'=>'นิสิต/นักศึกษา','2'=>'ผู้ประกอบวิชาชีพ'
		), array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	// Query List courseOnline
	public function listcourseOnline($model,$name,$class='')
	{
		////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
	$check_user = User::model()->findByPk(Yii::app()->user->id);
	$group = $check_user->group;
	$group_arr = json_decode($group);
	$see_all = 2;
	if(in_array("1", $group_arr) || in_array("7", $group_arr)){
		$see_all = 1;
	}
                        //////////////////
	if($see_all != 1){
		$list = CHtml::listData(CourseOnline::model()->findAll( 
			array('condition' => "active='y' and lang_id = 1 and create_by='".Yii::app()->user->id."'",'order'=>'course_id')),
			'course_id', 'course_title');
	}else{
		$list = CHtml::listData(CourseOnline::model()->findAll( 
			array('condition' => "active='y' and lang_id = 1",'order'=>'course_id')),
			'course_id', 'course_title');
	}
		return CHtml::activeDropDownList($model,$name,$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class

		));
	}

        // Query List courseOnline
	public function listdocument($model,$name,$class='')
	{
		$list = CHtml::listData(CourseOnline::model()->findAll(),'dow_id', 'dow_name');
		return CHtml::activeDropDownList($model,$name,$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	// Query List ShopType
	public function listShopTypeShow($model,$class='')
	{
		$list = CHtml::listData(Shoptype::model()->findAll(array(
		"condition"=>" active = 'y' ",'order'=>'shoptype_id')),'shoptype_id', 'shoptype_name');
		return CHtml::activeDropDownList($model,'shoptype_id',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	// Query List Lesson
	public function listLesson($model,$class='')
	{
		$list = CHtml::listData(Lesson::model()->lessoncheck()->findAll(array(
		"condition"=>" active = 'y' and lang_id = 1",'order'=>'id')),'id', 'title');
		return CHtml::activeDropDownList($model,'lesson_id',$list , array(
			'empty'=>'--- กรุณาเลือกบทเรียน ---',
			'class'=>$class
		));
	}

	// Query List Page
	public function listPageShow($model)
	{
        $list = CHtml::listData(Page::model()->findAll(), 'page_num', 'page_num');
        return CHtml::DropDownList('per_page', '', $list, array(
            'empty' => 'default (10)',
            // 'class'=>'selectpicker',
            'data-style'=>'btn-default btn-small',
            'onchange'=>"$.updateGridView('".$model."-grid', 'per_page', this.value)"
        ));
	}

	public function listPageShowNonCss($model)
	{
        $list = CHtml::listData(Page::model()->findAll(), 'page_num', 'page_num');
        return CHtml::DropDownList('per_page', '', $list, array(
            'empty' => 'default (10)',
             'class'=>'form-control',
            'data-style'=>'btn-default btn-small',
            'onchange'=>"$.updateGridView('".$model."-grid', 'per_page', this.value)"
        ));
	}

	public function listPageShowUser($model)
	{
		$list = CHtml::listData(Page::model()->findAll(array(
		"condition"=>" active = 'y' ",'order'=>'page_num')), 'page_num', 'page_num');
		return CHtml::DropDownList('user_page_size', 'category_id', $list, array(
			'empty' => 'default',
			// 'class'=>'selectpicker',
			'data-style'=>'btn-default btn-small',
			'onchange'=>"$.updateGridView('".$model."-grid', 'user_page_size', this.value)"
		));
	}

	// Query List Group
	public function listGroupShow($model,$class='')
	{
		$list = CHtml::listData(Grouptesting::model()->findAll(array(
		"condition"=>" active = 'y' ",'order'=>'group_id')),'group_id', 'group_title');
		return CHtml::activeDropDownList($model,'group_id',$list , array(
			'empty'=>'เลือกชื่อชุดข้อสอบ',
			'class'=>$class
		));
	}

	public function listGroupLesson($model,$id,$class='')
	{
		return CHtml::activeDropDownList($model,'group_id',Grouptesting::getClients($id) , array(
			'empty'=>'เลือกชื่อชุดข้อสอบ',
			'class'=>$class
		));
	}

	public function listGroupLessonMsTeams($model,$id,$class='')
	{
		return CHtml::activeDropDownList($model,'group_id',GrouptestingMsTeams::getClients($id) , array(
			'empty'=>'เลือกชื่อชุดข้อสอบ',
			'class'=>$class
		));
	}

	public function listGroupLessonMsTeamsInstitution($model,$id,$class='')
	{
		return CHtml::activeDropDownList($model,'group_id',GrouptestingMsTeamsInstitution::getClients($id) , array(
			'empty'=>'เลือกชื่อชุดข้อสอบ',
			'class'=>$class
		));
	}

	public function listGroupLessonOnline($model,$id,$class='')
	{
		return CHtml::activeDropDownList($model,'group_id',GrouptestingOnline::getClients($id) , array(
			'empty'=>'เลือกชื่อชุดข้อสอบ',
			'class'=>$class
		));
	}


	public function listGroupIndex($model,$class='')
	{
		$list = CHtml::listData(Grouptesting::model()->findAll(array(
		"condition"=>" active = 'y' ")),'id', 'lessons.title');
		return CHtml::activeDropDownList($model,'id',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	public function listBankAll($model,$class='')
	{
		$list = CHtml::listData(Bank::model()->findAll(array(
			"condition"=>" active = 'y' ")),'bank_id', 'bank_name');
		$list2 = array("0" => "PaysBuy");
		$checklist = $list+$list2;
		return CHtml::activeDropDownList($model,'order_bank',$checklist , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	//================= Query List เอกสาร
	public function listTypeNewsShow($model,$id,$class='',$langId,$parentId)
	{
		 // $model = TypeNews::model()->find(array(
   //          'condition'=>'lang_id=:lang_id AND active=:active',
   //          'params' => array(':lang_id' => $langId, ':active' => '1')
   //            ));
		if($langId == 1){
			$list = CHtml::listData(TypeNews::model()->findAll(array(
		"condition"=>" active = 'y' and lang_id = ".$langId,'order'=>'cms_type_id')),'cms_type_id', 'cms_type_title');
			$attribute = array('class'=>$class,'onChange' => 'getState(this.value);');
		}else{
			$models = News::model()->find(array(
		"condition"=>" active = 'y' AND cms_id = '".$parentId."'",'order'=>'cms_type_id'));
			$list = CHtml::listData(TypeNews::model()->findAll(array(
		"condition"=>" active = 'y' and lang_id = '1' AND cms_type_id = '".$models->cms_type_id."'",'order'=>'cms_type_id')),'cms_type_id', 'cms_type_title');

			$attribute = array('class'=>$class,'onChange' => 'getState(this.value);','readonly' => true);
		}
		

		// var_dump($list); exit();
		// return CHtml::activeDropDownList($model,'dty_id',$list , array(
		// 	'empty'=>'ทั้งหมด',
		// 	'class'=>$class,
		// 	'onChange' => 'getState(this.value);'
		// ));
		return CHtml::activeDropDownList($model,'cms_type_id',$list , $attribute);
	}
	//================= Query List เอกสาร

	public function listGroupBuShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgGroupBu::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'group_bu_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}
	public function listBuShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgBu::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'bu_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}
	public function listOrgDepartmentShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgDepartment::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'department_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	public function listOrgDivisionShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgDivision::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'division_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	public function listOrgSectionShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgSection::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'section_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	public function listOrgCountryShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgCountry::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'country_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}
	public function listOrgCountryCompanyShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgCountryCompany::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'company_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	public function listOrgCountryDepartmentShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgCountryDepartment::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'department_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	public function listOrgCountryDivisionShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgCountryDivision::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'division_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	public function listOrgCountrysectionShow($model,$id,$class='')
	{

		$list = CHtml::listData(OrgCountrysection::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'name');
		
		return CHtml::activeDropDownList($model,'section_id',$list , array(
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	//================= Query List เอกสาร
	public function listDocShow($model,$id,$class='',$langId,$parentId)
	{
		 $model = DocumentType::model()->find(array(
            'condition'=>'lang_id=:lang_id AND active=:active',
            'params' => array(':lang_id' => $langId, ':active' => '1')
              ));
		if($langId == 1){
			$list = CHtml::listData(DocumentType::model()->findAll(array(
		"condition"=>" active = '1' and lang_id = ".$langId,'order'=>'dty_id')),'dty_id', 'dty_name');
			$attribute = array('empty'=>'ทั้งหมด','class'=>$class,'onChange' => 'getState(this.value);');
		}else{
			$models = Document::model()->find(array(
		"condition"=>" active = '1' AND dow_id = '".$parentId."'",'order'=>'dty_id'));
			$list = CHtml::listData(DocumentType::model()->findAll(array(
		"condition"=>" active = '1' and lang_id = '".$langId."' AND parent_id = '".$models->dty_id."'",'order'=>'dty_id')),'dty_id', 'dty_name');

			$attribute = array('class'=>$class,'onChange' => 'getState(this.value);','readonly' => true);
		}
		

		// var_dump($list); exit();
		// return CHtml::activeDropDownList($model,'dty_id',$list , array(
		// 	'empty'=>'ทั้งหมด',
		// 	'class'=>$class,
		// 	'onChange' => 'getState(this.value);'
		// ));
		return CHtml::activeDropDownList($model,'dty_id',$list , $attribute);
	}
	//================= Query List เอกสาร
	// public function listDocShow($model,$id,$class='')
	// {
	// 	$list = CHtml::listData(DocumentType::model()->findAll(array(
	// 	"condition"=>" active = '1'",'order'=>'dty_id')),'dty_id', 'dty_name');

	// 	// var_dump($list); exit();
	// 	return CHtml::activeDropDownList($model,'dty_id',$list , array(
	// 		'empty'=>'ทั้งหมด',
	// 		'class'=>$class,
	// 		'onChange' => 'getState(this.value);'
	// 	));
	// }
	//==============================================================


	//================= Query List ฝ่าย
	public function listcompanyShow($model,$id,$class='')
	{
		$list = CHtml::listData(Company::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'company_id')),'company_id', 'company_title');

		// var_dump($list); exit();
		return CHtml::activeDropDownList($model,'company_id',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}
//==============================================================

	//==============================================================
	//================= Query List กอง
	public function listdivisionShow($model,$id,$class='')
	{
		$list = CHtml::listData(Division::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'div_title');

		// var_dump($list); exit();
		return CHtml::activeDropDownList($model,'division_id',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	public function listlanguageShow($model,$id,$class='')
	{
		$list = CHtml::listData(Language::model()->findAll(array(
		"condition"=>" status = 'y'",'order'=>'id')),'id', 'language');

		// var_dump($list); exit();
		return CHtml::activeDropDownList($model,'lang_id',$list , array(
			'class'=>$class,
			'onChange' => 'getParentList(this.value);'
		));
	}

	public function listMainmenuShow($model,$id,$class='')
	{
		$list = CHtml::listData(MainMenu::model()->findAll(array(
		"condition"=>" status = 'y'",'order'=>'id')),'id', 'title');

		// var_dump($list); exit();
		return CHtml::activeDropDownList($model,'id',$list , array(
			'class'=>$class,
		));
	}

	public function listParentMainmenuShow($model,$id,$class='')
	{
		$list = CHtml::listData(MainMenu::model()->findAll(array(
		"condition"=>" status = 'y' AND parent_id = '0'",'order'=>'id')),'id', 'title');

		// var_dump($list); exit();
		return CHtml::activeDropDownList($model,'parent_id',$list , array(
			'class'=>$class,
		));
	}
//==============================================================


	//==============================================================
	//================= Query List แผนก
	public function listdepartmentShow($model,$id,$class='')
	{
		$list = CHtml::listData(Department::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'id')),'id', 'dep_title');

		// var_dump($list); exit();
		return CHtml::activeDropDownList($model,'department_id',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}
//==============================================================
	// Query List 
	public function listCateTypeShow2($model,$id,$class='',$readonly,$lang_id,$parent_id)
	{
		if($lang_id == 1){
			$modelList = Category::model()->findAll(array(
		"condition"=>" active = 'y' and lang_id = '".$lang_id."'"));
			$list = CHtml::listData($modelList,'cate_id', 'cate_title');
			$att = array('class'=>$class,'readonly' => $readonly,'onChange' => 'getState(this.value);');
		}else{
			$modelList = CourseOnline::model()->find(array(
		"condition"=>" active = 'y' and course_id = '".$parent_id."'"));
			
		// 	$list = CHtml::listData(Category::model()->findAll(array(
		// "condition"=>" active = 'y' and lang_id = '".$lang_id."' and parent_id = '".$modelList->cate_id."'")),'cate_id', 'cate_title');
			$list = CHtml::listData(Category::model()->findAll(array(
		"condition"=>" active = 'y' and cate_id = '".$modelList->cate_id."'")),'cate_id', 'cate_title');
			$att = array('class'=>$class,'readonly' => $readonly,'onChange' => 'getState(this.value);');
		}
		
		return CHtml::activeDropDownList($model,'cate_id',$list , $att);
	}

	public function listCateTypeShow($model,$id,$class='')
	{
		$list = CHtml::listData(Category::model()->findAll(array(
		"condition"=>" active = 'y'",'order'=>'cate_id')),'cate_id', 'cate_title');
		return CHtml::activeDropDownList($model,'cate_id',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class,
			'onChange' => 'getState(this.value);'
		));
	}

	public function listCateCourseTypeShow($model,$id,$class='',$chk=null)
	{
		if($chk != null){
			// var_dump($chk);exit();
			$list = CHtml::listData(CategoryCourse::model()->findAll(array(
		"condition"=>" active = '1' AND cate_id = '".$chk."'",'order'=>'cate_id')),'id', 'name');
		} else {
			$list = array();
		}
		return CHtml::activeDropDownList($model,'cate_course',$list , array(
			'empty'=>'กรุณาเลือกกลุ่มหลักสูตร',
			'class'=>$class
		));
	}


	
	// Query List Lesson
	public function listLessonShow($model,$id,$class='')
	{
		$list = CHtml::listData(Lesson::model()->findAll(array(
		"condition"=>$id,'order'=>'id')),'id', 'title');
		return CHtml::activeDropDownList($model,'id',$list , array(
			'empty'=>'กรุณาเลือกกลุ่มหลักสูตร',
			'class'=>$class
		));
	}

	// Query List CategoryLesson
	public function listCategoryLessonShow($model,$name,$class='')
	{
		$list = CHtml::listData(CategoryLesson::model()->findAll(),'id', 'title');
		return CHtml::activeDropDownList($model,$name,$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	// Query List Teacher
	public function listTeacher($model,$class='')
	{
		$list = CHtml::listData(Teacher::model()->findAll(array(
		"condition"=>" active = 'y' ")),'teacher_id', 'teacher_name');
		return CHtml::activeDropDownList($model,'course_lecturer',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}
        
        // Query List Teacher
	public function listQheader($model,$name,$class='')
	{
		$list = CHtml::listData(QHeader::model()->findAll(array(
		"condition"=>" active = 'y' ")),'survey_header_id', 'survey_name');
                return CHtml::activeDropDownList($model,$name,$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	// beforeRender Page To View
	protected function beforeRender($view)
	{
		$flashes = Yii::app()->user->getFlashes(true);
		if(count($flashes) > 0)
		{
			$messages = '';
			foreach($flashes as $key => $value)
			{	
				$msg = (!is_string($value) && isset($value['msg']))? $value['msg']:$value;
				$class_text = (!is_string($value) && isset($value['class']))? $value['class']:'information';
				$messages .= "
					notyfy(
					{
						dismissQueue: false,
						text: '$msg',
						type: '$class_text' // alert|error|success|information|warning|primary|confirm
					});";
			}
			Yii::app()->clientScript->registerScript('notifyView', $messages, CClientScript::POS_READY);
		}	
		return parent::beforeRender($view);
	}

	// Show Image Page Update
	public function ImageShowUpdate($model,$image)
	{
		if(!$model)
		{
$retuenImage = <<<IMG
			<div class="row">
			<br>
IMG;
			$retuenImage.= CHtml::image(Yii::app()->checkShowImage(null,$image),'',array("class"=>"thumbnail"));
$retuenImage.= <<<IMG
			</div>
IMG;
		return $retuenImage;
		} 		
	}
	
	public static function ImageShowIndex($data,$image)
	{

		if($image != null)
			$imgCheck = CHtml::image(Yush::getUrl($data, Yush::SIZE_SMALL, $image),$image);
		else
			$imgCheck = CHtml::image(Yii::app()->request->baseUrl.'/../themes/template2/images/thumbnail-course.png', 'No Image', array(
				'style'=>'width:110px;height:90px;'
			));

		return $imgCheck;
	}

	public static function ImageShowIndexLinux($path,$model_id,$image)
	{
		if($image != null){
			$imgCheck = CHtml::image(Yii::app()->request->baseUrl.'/../uploads/'.$path."/".$model_id.'/'.$image, 'Image '.$path, array(
			));
		}else{
			$imgCheck = CHtml::image(Yii::app()->request->baseUrl.'/../themes/template2/images/thumbnail-course.png', 'No Image', array(
				'style'=>'width:110px;height:90px;'
			));
		}

		return $imgCheck;
	}



	// MessageError
	public static function MessageError($type = "")
	{
		if($type == 'int') // type Int
			$messageText = Yii::t('yii','{attribute} must be a number.');
		else if($type == 'username')
			$messageText = UserModule::t("ชื่อผู้ใช้นี้เคยใช้แล้ว");
		else if($type == 'passold')
			$messageText = UserModule::t("รหัสผ่านเก่าไม่ถูกต้อง");
		else if($type == 'pattern')
			$messageText = 'ข้อมูลควรเป็น (A-z0-9)';
		else if($type == 'emailPk')
			$messageText = UserModule::t("E-mail นี้เคยใช้แล้ว");
		else if($type == 'email')
			$messageText = UserModule::t("รูปแบบการใช้ E-mail ผิด");
		else if($type == 'Retype')
			$messageText = UserModule::t("รหัสผ่านไม่ตรงกัน");
		else if($type == 'patternUser')
			$messageText = 'Username ต้องประกอบไปด้วยตัวอักษรผสมตัวเลขเท่านั้น';
		else if($type == 'patternPass')
			$messageText = 'Password ต้องประกอบไปด้วยตัวอักษรผสมตัวเลขเท่านั้น';
		else if($type == 'tooShort')
			$messageText = Yii::t("yii", "{attribute} is of the wrong length (should be {min} characters).");
		else if($type == 'min')
			$messageText = Yii::t("yii", "{attribute} is too short (minimum is {min} characters).");
		else if($type == 'max')
			$messageText = Yii::t('yii','{attribute} is too long (maximum is {max} characters).');
		else if($type == 'img')
			$messageText = Yii::t('yii', 'The file "{file}" cannot be uploaded. Only files with these extensions are allowed: {extensions}.');
		else
			$messageText = Yii::t('yii','{attribute} cannot be blank.');

		$messageError = "<p class='error help-block'><span class='label label-important'>".$messageText."</span></p>";
		return $messageError;
	}
	public function lastactivity()
	{
		if (!Yii::app()->user->isGuest) {
		
		$id = Yii::app()->user->id;
		$id_lastactivity = Users::model()->findByPk($id);
		$id_lastactivity->last_activity = date("Y-m-d H:i:s",time());
		$id_lastactivity->lastactivity = time();
		
		if ($id_lastactivity->save(false)) {
			
		}
		
		}
		
	}

	public static function Image_path($image,$path)
    {
        if($image != null)
            $imgCheck = CHtml::image(Yii::app()->request->baseUrl.'/../uploads/'.$path.'/'.$image,$image, array(
                'style'=>'width:110px;'
                ));
        else
            $imgCheck = CHtml::image(Yii::app()->request->baseUrl.'/images/logo_course.png', 'No Image', array(
                'style'=>'width:110px;height:90px;'
                ));

        return $imgCheck;
    }

    public static function getWidthColumnLang(){
		return $width = (count(Language::model()->findAll(array('condition' =>'status="y" and active = "y"')))*100) + 40;
    }

    public function listCourseTypeShow2($model,$id,$class='',$readonly,$lang_id,$parent_id)
	{
		if($lang_id == 1){
			$modelList = CourseType::model()->findAll(array(
		"condition"=>" active = 'y' and lang_id = '".$lang_id."'"));
			$list = CHtml::listData($modelList,'type_id', 'type_name');
			$att = array('class'=>$class,'readonly' => $readonly,'onChange' => 'getState(this.value);');
		}else{
			$modelList = Category::model()->find(array(
		"condition"=>" active = 'y' and cate_id = '".$parent_id."'"));
			
		// 	$list = CHtml::listData(Category::model()->findAll(array(
		// "condition"=>" active = 'y' and lang_id = '".$lang_id."' and parent_id = '".$modelList->cate_id."'")),'cate_id', 'cate_title');
			$list = CHtml::listData(CourseType::model()->findAll(array(
		"condition"=>" active = 'y' and type_id = '".$modelList->type_id."'")),'type_id', 'type_name');
			$att = array('class'=>$class,'readonly' => $readonly,'onChange' => 'getState(this.value);');
		}
		
		return CHtml::activeDropDownList($model,'type_id',$list , $att);
	}
}