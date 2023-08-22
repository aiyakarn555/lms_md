<?php

class CourseOnlineController extends Controller
{
	public function init()
	{
		if(Yii::app()->user->id == null){
			$this->redirect(array('site/index'));
		}
		parent::init();
		if (isset($_GET['lang_id']) || isset($_GET['parent_id']) ) {

			$langId = $_GET['lang_id'];
			if($langId != 1){
			$lang = Language::model()->findByPk($langId);
			$parentId = $_GET['parent_id'];
			$Root = CourseOnline::model()->findByAttributes(array('course_id'=> $parentId,'active'=>'y'));
			$cateRoot = Category::model()->findByAttributes(array('parent_id'=> $Root->cate_id,'lang_id'=>$langId,'active'=>'y'));
			$cateMain = Category::model()->findByAttributes(array('cate_id'=> $Root->cate_id,'active'=>'y'));
			if(!$cateRoot){
				Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มหมวดหมู่'.$cateMain->cate_title .',ภาษา '.$lang->language);
				$this->redirect(array('Category/index'));
				exit();
			}
			}
		}
		$this->lastactivity();
	}

	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
			// 'rights- toggle, switch, qtoggle',
        );
	}

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
    	return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('index', 'view','edit_teacher','MultiDelete','save_categories','update','delete','create', 'Formcourse'),
            	'users' => array('*'),
            ),
            array('allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
            	'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
            	'expression' => 'AccessControl::check_access()',
            ),
            array('deny',  // deny all users
            	'users' => array('*'),
            ),
        );
    }
	// public function filters() 
	// {
	// 	return array(
	// 		'rights- toggle, switch, qtoggle',
	// 		);
	// }

    public function actions()
    {
    	return array(
    		'toggle'=>'ext.jtogglecolumn.ToggleAction',
    		'switch'=>'ext.jtogglecolumn.SwitchAction',
    		'qtoggle'=>'ext.jtogglecolumn.QtoggleAction',
    	);
    }

    public function actionSetNameCode()
	{
		$id = $_POST['code'];

		$code = MtCodeMd::model()->find(array(
            'condition'=>'code_md=:code_md ',
            'params' => array(':code_md' => $id)
        ));

		echo $code->name_md ;

	}

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    	));
    }

    public function actionSortLesson($id)
    {
    	$this->render('sort');
    }

    // public function actionSave_categories()
    // {
    // 	if (isset($_POST['categories'])) {

    // 		$json = $_POST['categories'];

    // 		$data = json_decode($json, true);
    // 		foreach ($data as $key => $value) {
    // 			$lesson = Lesson::model()->findByPk($value['id']);
    // 			$lesson->lesson_no = $key+1;
    // 			$lesson->update();
    // 		}

    // 	} else {
    // 		echo ".......";
    // 	}
    // }
    private function parseJsonArray($jsonArray, $parentID = 0)
    {

    	$return = array();
    	foreach ($jsonArray as $subArray) {
    		$returnSubSubArray = array();
    		if (isset($subArray['children'])) {
    			$returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
    		}
    		$return[] = array('id' => $subArray['id'], 'parentID' => $parentID,'fileid' =>$subArray['fileid']);
    		$return = array_merge($return, $returnSubSubArray);
    	}


    	return $return;
    }


    public function actionCourseTemp()
    {

    	$model=new CourseTemp('search');
        $model->unsetAttributes();  

        if(isset($_GET['CourseTemp']))
        	$model->attributes=$_GET['CourseTemp'];
			$model->courseTi=$_GET['CourseTemp']['courseTi'];
			$model->fullname=$_GET['CourseTemp']['fullname'];
			

    	$this->render('course_temp',array(
    		'model'=>$model
    	));

    }

    public function actionMsteamsTemp()
    {

    	$model=new MsteamsTemp('search');
        $model->unsetAttributes();  

        if(isset($_GET['MsteamsTemp']))
        	$model->attributes=$_GET['MsteamsTemp'];
			$model->courseTi=$_GET['MsteamsTemp']['courseTi'];
			$model->fullname=$_GET['MsteamsTemp']['fullname'];
			

    	$this->render('ms_teams_temp',array(
    		'model'=>$model
    	));

    }


    public function actionOnlineTemp()
    {

    	$model=new OnlineTemp('search');
        $model->unsetAttributes();  

        if(isset($_GET['OnlineTemp']))
        	$model->attributes=$_GET['OnlineTemp'];
			$model->courseTi=$_GET['OnlineTemp']['courseTi'];
			$model->fullname=$_GET['OnlineTemp']['fullname'];
			

    	$this->render('online_temp',array(
    		'model'=>$model
    	));

    }




    public function actionSave_categories()
    {
    	if (isset($_POST['categories'])) {

    		$json = $_POST['categories'];

    		$data = json_decode($json, true);
    		foreach ($this->parseJsonArray($data) as $key => $value) {
    			$lesson = Lesson::model()->findByPk($value['id']);
    			$lesson->lesson_no = $key+1;
    			$lesson->sequence_id = (!empty($value['parentID']))?$value['parentID']:'0';
    			$lesson->update();
    		}

    	} else {
    		echo ".....";
    	}
    }

    public function actionFormcourse($id,$type)
    {
    	$model = CourseOnline::model()->findByPk($id);
    	$Coursemanage = new Coursemanage;
		//Query Coursemanage
    	$dataCoursemanage = new CActiveDataProvider('Coursemanage',array('criteria'=>array('condition'=>' id = "'.$id.'" AND type = "'.$type.'" AND active="y"')));
    	$CoursemanageModel=new Coursemanage('search');
		$CoursemanageModel->unsetAttributes();  // clear any default values
		$CoursemanageModel->type = $_GET['type'];
		if(isset($_GET['Coursemanage']))
			$CoursemanageModel->attributes = $_GET['Coursemanage'];

		if(isset($_POST['Coursemanage']))
		{
			$Coursemanage->attributes = $_POST['Coursemanage'];
			$Coursemanage->type = $_GET['type'];
			$Coursemanage->id = $id;
			if ($_POST['Coursemanage']['manage_row']<=$Coursemanage->getCountcourse()){
                if($Coursemanage->save())
                    $this->redirect(array('formcourse','id'=>$id,'type'=>$type));
            }else {
                Yii::app()->user->setFlash('error', 'ไม่สามารถเพิ่มค่าได้ จำนวนข้อสอบที่จะแสดงมีมากกว่าข้อสอบ');
            }
			// if($Coursemanage->save())
			// 	$this->redirect(array('formcourse','id'=>$id,'type'=>$type));
		}

//		Yii::app()->user->setState('getCourse', $id);

		$this->render('formcourse',array(
			'model'=>$model,
			'CoursemanageModel'=>$CoursemanageModel,
			'Coursemanage'=>$Coursemanage,
			'dataCoursemanage'=>$dataCoursemanage,
			'pk'=>$id
		));
	}

	public  function actionEdit_teacher($id){
    // var_dump($id);
		$teacher = CourseTeacher::model()->findByPk($id);

		if(isset($_POST['CourseTeacher']))
		{
			$teacher->attributes = $_POST['CourseTeacher'];
			$teacher->course_id = $_GET['course_id'];
			if($teacher->save())
				$this->redirect(array('add_teacher','id'=>$_GET['course_id']));
		}

		$this->render('edit_teacher',array(
			'teacher'=>$teacher,
		));
	}

	public function actionUpdatecourse($id,$type,$course_id)
	{
		$Coursemanage = $this->loadCoursemanageModel($id);

		if(isset($_POST['Coursemanage']))
		{
			$Coursemanage->attributes = $_POST['Coursemanage'];
			if($Coursemanage->save())
				$this->redirect(array('formcourse','id'=>$course_id,'type'=>$type));
		}
		$this->render('updatecourse',array(
			'Coursemanage'=>$Coursemanage,
		));
	}

	public function loadCoursemanageModel($id)
	{
		$model = Coursemanage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public  function actionAdd_teacher($id){
		$teacher = new CourseTeacher('search');
		$teacher->course_id = $id;
		if(isset($_POST['CourseTeacher']))
		{
			$teacher->attributes = $_POST['CourseTeacher'];
			$teacher->course_id = $id;
			if($teacher->save())
				$this->redirect(array('add_teacher','id'=>$id));
		}

		$this->render('add_teacher',array(
			'teacher'=>$teacher,
		));
	}

	public function actionActive($id){
		$model = CourseOnline::model()->findByPk($id);
		$modelChildren = CourseOnline::model()->findAll(array(
            'condition'=>'parent_id=:parent_id',
            'params' => array(':parent_id' => $model->course_id)
              ));
            foreach ($modelChildren as $key => $value) {
                if($value->status == 1){
                    $value->status = 0;
                    $value->save(false);
                } else {
                    $value->status = 1;
                    $value->save(false);
                }
            }
		if($model->status == 1){
			$model->status = 0;
			$model->save(false);
		} else {
			$model->status = 1;
			$model->save(false);
		}
		$this->redirect(array('/CourseOnline/index'));
	}

	public function actionCourseAjax(){
		if(!empty($_POST["cate_id"])) {
			$html = '<option value="">กรุณาเลือกกลุ่มหลักสูตร</option>';
			$models = CategoryCourse::model()->findAll(array(
				"condition"=>" active = '1' AND cate_id = '".$_POST["cate_id"]."'",'order'=>'id'));
			foreach($models as $model) {
				$html .= '<option value="'.$model->id.'">'.$model->name.'</option>';
			}
			echo $html;
		} else {

		}
	}

	public function actionCreate()
	{
		$model = new CourseOnline;

		if(isset($_POST['CourseOnline']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['CourseOnline'];
			// $model->cate_id = $_POST['cate_id'];
			$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
			$course_picture = CUploadedFile::getInstance($model, 'course_picture');
			if(!empty($course_picture)){
				$fileNamePicture = $time."_Picture.".$course_picture->getExtensionName();
				$model->course_picture = $fileNamePicture;
			}

    		if($model->parent_id !=0){
    			$modelParent = CourseOnline::model()->findByPk($model->parent_id);
    			if($modelParent){
    				$model->document_status = $modelParent->document_status;
    			}
    		}

			$model->course_rector_date = ClassFunction::DateSearch($model->course_rector_date);
			$model->course_book_date = ClassFunction::DateSearch($model->course_book_date);

            $model->course_md_code = $_POST['CourseOnline']['course_md_code'];

			if($model->validate())
			{
                /*$model->course_date_start = Yii::app()->dateFormatter->format("y-M-d H:i:s",$model->course_date_start);
                $model->course_date_end = Yii::app()->dateFormatter->format("y-M-d H:i:s",$model->course_date_end);*/
                $model->course_date_start = date_format(date_create($model->course_date_start), "Y-m-d H:i");
                $model->course_date_end = date_format(date_create($model->course_date_end), "Y-m-d H:i");
                if($model->save())
                {  
					if($model->lang_id == 1){
						//เพิ่ม generation อัตโนมัติ
						$courseGeneration = new CourseGeneration();
						$courseGeneration->course_id = $model->course_id;
						$courseGeneration->gen_period_start = $model->course_date_start;
						$courseGeneration->gen_period_end = $model->course_date_end;
						$courseGeneration->gen_title = 1;
						$courseGeneration->gen_detail = "รุ่น 1";
						$courseGeneration->gen_detail_en = "Gen 1";
						$courseGeneration->gen_person = 50;
						$courseGeneration->status = 2;
						$courseGeneration->active = "y" ;
						$courseGeneration->create_date = date("Y-m-d H:i");
						$courseGeneration->create_by = Yii::app()->user->id;
						$courseGeneration->save();
						//เพิ่ม generation อัตโนมัติ
					}
				
    				$time = date("dmYHis");
                	$intro_video = CUploadedFile::getInstance($model, 'intro_video');
                	$uploadFile = CUploadedFile::getInstance($model, 'intro_video');

                	if (isset($uploadFile)) {
                		$beautifulName = $time.$model->course_id."_Cou.".$uploadFile->extensionName;
                		$model->intro_video = $beautifulName;
                	}

                	if(isset($intro_video))
                	{
                		$tempSave = CUploadedFile::getInstance($model, 'intro_video');
                		$fileName = $beautifulName;
                		$model->intro_video = $fileName;
                		$Pathuploadfile = Yii::app()->basePath.'/../../uploads/courseonline/'.$fileName;

						if(!empty($tempSave))  
						{
							$tempSave->saveAs($Pathuploadfile);
						} else {
							var_Dump($model->getErrors());
							exit();
						}
					}

                	if(Yii::app()->user->id){
                		Helpers::lib()->getControllerActionId();
                	}
					if($model->parent_id == 0){
						$model->sortOrder = Helpers::lib()->sortCreate('tbl_course_online','course_id',$model->course_id,'main'); 
					}else{
						$model->sortOrder = Helpers::lib()->sortCreate('tbl_course_online','course_id',$model->course_id,'parent',$model->parent_id);
					}

                	// $model->sortOrder = $model->course_id;
                	$model->save();

                	if(isset($course_picture))
                	{
						/////////// SAVE IMAGE //////////
                		Yush::init($model);
                		$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->course_picture);
                		$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->course_picture);
                		$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->course_picture);
			            // Save the original resource to disk
                		$course_picture->saveAs($originalPath);

			            // Create a small image
                		$smallImage = Yii::app()->phpThumb->create($originalPath);
                		$smallImage->resize(110);
                		$smallImage->save($smallPath);

			            // Create a thumbnail
                		$thumbImage = Yii::app()->phpThumb->create($originalPath);
                		$thumbImage->resize(250);
						$thumbImage->save($thumbPath);

						
                	}

                	$langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
						if($model->parent_id == 0){
							$rootId = $model->course_id;
						}else{
							$rootId = $model->parent_id;
						}
						
						foreach ($langs as $key => $lang) {
							$models = CourseOnline::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootId));
							if(!$models){
								$Root = CourseOnline::model()->findByPk($rootId);
								Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มหลักสูตร '.$Root->course_short_title .',ภาษา '.$lang->language);
					          	// $this->redirect(array('Category/index'));
					          	$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
					          	exit();
							}
						}

						$model = CourseOnline::model()->findByPk($rootId);
						$this->redirect(array('view','id'=>$model->course_id));
						
                	// $this->redirect(array('view','id'=>$model->id));
                }
            }
        }

        $this->render('create',array(
        	'model'=>$model
        ));
    }

    public function actionUpdate($id)
    {
    	$model = $this->loadModel($id);
    	$old_vdo_path = $model->intro_video;
    	// ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
        //     $check_user = User::model()->findByPk(Yii::app()->user->id);
        //     $group = $check_user->group;
        //     $group_arr = json_decode($group);
        //     $see_all = 2;
        //     if(in_array("1", $group_arr) || in_array("7", $group_arr)){
        //         $see_all = 1;
        //     }
        //     //////////////////

		//  //แสดงตาม Group
		//  $modelUser = Users::model()->findByPk(Yii::app()->user->id);
		//  $group = json_decode($modelUser->group);
		//  if (!in_array(1, $group)){
		// 	 $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
		//  }

        //     if(!in_array(1, $group) || $model->create_by == Yii::app()->user->id ||){

    	
    	$model->course_rector_date = ClassFunction::UpdateDate($model->course_rector_date);
    	$model->course_book_date = ClassFunction::UpdateDate($model->course_book_date);
    	$model->course_date_start = date_format(date_create($model->course_date_start), "Y-m-d H:i");
    	$model->course_date_end = date_format(date_create($model->course_date_end), "Y-m-d H:i");
    	
    	$imageShow = $model->course_picture;
    	if(isset($_POST['CourseOnline']))	
    	{
    		$time = date("dmYHis");
    		$model->attributes=$_POST['CourseOnline'];
    		$model->course_md_code = $_POST['CourseOnline']['course_md_code'];
    		// $model->cate_id = $_POST['cate_id'];
    		$criteria = new CDbCriteria;
			$criteria->condition='parent_id = '.$model->course_id; 
    		$modelchildren = CourseOnline::model()->findAll($criteria);
    		if($modelchildren){
    			CourseOnline::model()->updateAll(
	            array('cate_id' => $model->cate_id,'course_date_start'=>$_POST['CourseOnline']['course_date_start'],'percen_test'=>$_POST['CourseOnline']['percen_test'],'cate_amount'=>$_POST['CourseOnline']['percen_test'],'time_test'=>$_POST['CourseOnline']['time_test'],'recommend'=>$_POST['CourseOnline']['recommend'],'price'=>$_POST['CourseOnline']['price'],'document_status'=>$_POST['CourseOnline']['document_status']),'parent_id = '.$model->course_id
	            );
    		}
    		if($model->parent_id !=0){
    			$modelParent = CourseOnline::model()->findByPk($model->parent_id);
    			if($modelParent){
    				$model->document_status = $modelParent->document_status;
    			}
    		}
    		

			$imageOld = $model->course_picture; // Image Old

			$course_picture = CUploadedFile::getInstance($model, 'course_picture');
			if(!empty($course_picture)){
				$fileNamePicture = $time."_Picture.".$course_picture->getExtensionName();
				$model->course_picture = $fileNamePicture;
			} else {
				$model->course_picture = $imageShow;
			}

			$model->course_rector_date = ClassFunction::DateSearch($model->course_rector_date);
			$model->course_book_date = ClassFunction::DateSearch($model->course_book_date);
			/*$model->course_date_start = date_format(date_create($model->course_date_start), "Y-m-d H:i");
			$model->course_date_end = date_format(date_create($model->course_date_end), "Y-m-d H:i");*/

			if( !isset($_POST['CourseOnline'][intro_video]) ){
				$model->intro_video = $old_vdo_path;
			}

			$time = date("dmYHis");
			$intro_video = CUploadedFile::getInstance($model, 'intro_video');
			$uploadFile = CUploadedFile::getInstance($model, 'intro_video');

			if (isset($uploadFile)) {
				$beautifulName = $time.$model->course_id."_Cou.".$uploadFile->extensionName;
				$model->intro_video = $beautifulName;
			}

			if(isset($intro_video))
			{
				$tempSave = CUploadedFile::getInstance($model, 'intro_video');
				$fileName = $beautifulName;
				$model->intro_video = $fileName;
				$Pathuploadfile = Yii::app()->basePath.'/../../uploads/courseonline/'.$fileName;

				if(!empty($tempSave))  
				{
					$tempSave->saveAs($Pathuploadfile);
				} else {
					var_Dump($model->getErrors());
					exit();
				}
			}
			

			//day Count
			// $diff = strtotime($_POST['CourseOnline']['course_date_end']) - strtotime($_POST['CourseOnline']['course_date_start']);
			// $days = $diff / 60 / 60 / 24;
			// $model->course_day_learn = $days;

			if($model->update())
			{
				

				// if($model->save())
				// {
				if(isset($imageShow) && isset($course_picture))
				{
					Yii::app()->getDeleteImageYush('courseonline',$model->id,$imageShow);
				}

				if(isset($course_picture))
				{
						/////////// SAVE IMAGE //////////
					Yush::init($model);
					$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->course_picture);
					$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->course_picture);
					$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->course_picture);
			            // Save the original resource to disk
					$course_picture->saveAs($originalPath);

			            // Create a small image
					$smallImage = Yii::app()->phpThumb->create($originalPath);
					$smallImage->resize(110);
					$smallImage->save($smallPath);

			            // Create a thumbnail
					$thumbImage = Yii::app()->phpThumb->create($originalPath);
					$thumbImage->resize(250);
					$thumbImage->save($thumbPath);
				}
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->id);
				}

				//update All Children
				$parent_id = $model->course_id;
				
				$modelChildren = CourseOnline::model()->updateAll(array('course_rector_date'=>$model->course_rector_date,
					'cate_id'=>$model->cate_id,
					'course_book_date'=>$model->course_book_date,
					'course_date_start'=>$model->course_date_start,
					'course_date_end'=>$model->course_date_end,
					'course_day_learn'=>$model->course_day_learn,
					'course_number'=>$model->course_number,
					'percen_test'=>$model->percen_test,
					'cate_amount'=>$model->cate_amount,
					'time_test'=>$model->time_test,
					'recommend'=>$model->recommend
				),
				"parent_id='".$parent_id."'");

				$this->redirect(array('view','id'=>$model->id));
				// }
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow
		));
		// }
        $this->redirect(array('index'));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		// ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
        //     $check_user = User::model()->findByPk(Yii::app()->user->id);
        //     $group = $check_user->group;
        //     $group_arr = json_decode($group);
        //     $see_all = 2;
        //     if(in_array("1", $group_arr) || in_array("7", $group_arr)){
        //         $see_all = 1;
        //     }
        //     //////////////////
            // if($see_all == 1 || $model->create_by == Yii::app()->user->id){

		//$this->loadModel($id)->delete();
		

		$parent_id = $model->course_id;
        $modelChildren = CourseOnline::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => 'y')
              ));
        	foreach ($modelChildren as $key => $value) {
        		if($value->course_picture != '')
					Yii::app()->getDeleteImageYush('courseonline',$value->course_id,$value->course_picture);
				$value->course_picture = null;
				$value->active = 'n';
				$value->save(false);

				$orgcourseCh = OrgCourse::model()->updateAll(array('active'=>'n'),"course_id='".$value->course_id."'");
        	}
		$model->active = 'n';
		//var_dump($model);exit();
		if($model->course_picture != '')
			Yii::app()->getDeleteImageYush('courseonline',$model->id,$model->course_picture);

		$model->course_picture = null;
		$model->save(false);

		$orgcourse = OrgCourse::model()->updateAll(array('active'=>'n'),"course_id='".$id."'");

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));

		// }
        // $this->redirect(array('index'));
	}

	public function actionMultiDelete()
	{	
		//header('Content-type: application/json');
		if(isset($_POST['chk'])) {
			foreach($_POST['chk'] as $val) {
				$this->actionDelete($val);
			
			}
		}
	}

	public function actionIndex()
	{
		$model=new CourseOnline('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CourseOnline']))
			$model->attributes=$_GET['CourseOnline'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionPrintPDF($id,$user)
	{
		$CheckPasscours = Passcours::model()->find(array(
			'condition'=>'passcours_cours=:id AND passcours_user=:user','params' => array(
				':id' => $id,
				':user' => $user
			)
		));
		if(isset($CheckPasscours))
		{
			$mPDF1 = Yii::app()->ePdf->mpdf();
			$mPDF1->setDisplayMode('fullpage');
			$mPDF1->setAutoFont();
			$mPDF1->AddPage('L');
			$mPDF1->WriteHTML($this->renderPartial('PrintPDF', array('model'=>$CheckPasscours), true));
			$mPDF1->Output();
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function loadModel($id)
	{
		$model=CourseOnline::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-online-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = CourseOnline::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = CourseOnline::model()->findByPk($_POST['items'][$i]);
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save(false);
				}
			}
		}
	}


	public function actionConfirmCourse() {
		$type = $_POST['type'];
		$id = $_POST['id'];
		$description = $_POST['description'];

		$model=CourseTemp::model()->findByPk($id);
		if($model != null){
			// if($type == 1){
			// 	$model->status = 'y';
			// }else if($type == 2){
			// 	$model->status = 'x';
			// }
			if($type == 1){
				$model->status_payment = 'y';
			}else if($type == 2){
				$model->status_payment = 'x';
			}
			$model->note_payment = $description;
			$model->user_confirm = Yii::app()->user->id;
			$model->date_confirm = date("Y-m-d H:i:s");
			$model->date_confirm_payment = date("Y-m-d H:i:s");
			if($model->save(false)){
				echo 'pass';
			}

		}else{
			echo 'nopass';
		}
	}

	public function actionConfirmMsTeams() {
		$type = $_POST['type'];
		$id = $_POST['id'];
		$description = $_POST['description'];

		$model=MsteamsTemp::model()->findByPk($id);
		if($model != null){
			// if($type == 1){
			// 	$model->status = 'y';
			// }else if($type == 2){
			// 	$model->status = 'x';
			// }
			if($type == 1){
				$model->status_payment = 'y';
			}else if($type == 2){
				$model->status_payment = 'x';
			}
			$model->note_payment = $description;
			$model->user_confirm = Yii::app()->user->id;
			$model->date_confirm = date("Y-m-d H:i:s");
			$model->date_confirm_payment = date("Y-m-d H:i:s");
			if($model->save(false)){
				echo 'pass';
			}

		}else{
			echo 'nopass';
		}
	}


	public function actionConfirmOnline() {
		$type = $_POST['type'];
		$id = $_POST['id'];

		$model=OnlineTemp::model()->findByPk($id);
		if($model != null){
			if($type == 1){
				$model->status = 'y';
			}else if($type == 2){
				$model->status = 'x';
			}
			$model->user_confirm = Yii::app()->user->id;
			$model->date_confirm = date("Y-m-d H:i:s");
			if($model->save(false)){
				echo 'pass';
			}

		}else{
			echo 'nopass';
		}
	}

	



}
