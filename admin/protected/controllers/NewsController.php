<?php

class NewsController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();

		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
		}
		
	}
	
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
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
            	'actions' => array('index', 'view','update','delete'),
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
	// 		'rights',
	// 		);
	// }

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    		));
    }

    public function actionCreate()
    {
    	$model = new News;

    	if(isset($_POST['News']))
    	{
    		$sort = News::model()->count(array(
	    		'condition'=>'active="y"'
	    	));
    		$time = date("dmYHis");
    		$model->attributes=$_POST['News'];
    		// $model->sortOrder = $sort+1;
    		$model->sortOrder = 1;
    		$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;

			if($model->lang_id == 2){
				$m_news = News::model()->findByPk($model->parent_id);
				$model->sortOrder = $m_news->sortOrder;
			}

    		// $cms_picture = CUploadedFile::getInstance($model, 'picture');

    		// if(!empty($cms_picture)){
    		// 	$fileNamePicture = $time."_Picture.".$cms_picture->getExtensionName();
    		// 	$model->cms_picture = $fileNamePicture;
    		// }

    		if($model->cms_type_display == '0'){
    			$model->cms_type_display = 'content';
    		} else {
    			$model->cms_type_display = 'url';
    		}

    		if($_POST['News']['cms_url']){
    			$arr = array();
    			$arr[] = $_POST['News']['cms_url'];
    			$arr[] = $_POST['News']['cms_tab'];
    			$model->cms_link = json_encode($arr);
    		}


    		// var_dump($model->cms_detail); exit();



    		if($model->validate())
    		{
    			if($model->save())
    			{	
    				if($model->lang_id == 1){

    					$model_main = News::model()->findAll(array(
    						'condition'=>'active="y" AND lang_id=1 AND cms_id!="'.$model->cms_id.'" AND parent_id!="'.$model->cms_id.'" ',
    						'order'=>'sortOrder ASC'
    					));

    					foreach ($model_main as $key => $value) {
    						$value->sortOrder = $value->sortOrder+1;
    						$value->save(false);

    						$mo_news = News::model()->find("active='y' AND parent_id='".$value->cms_id."' ");
    						if($mo_news){
    							$mo_news->sortOrder = $value->sortOrder;
    							$mo_news->save(false);
    						}

    					}
    				}

    				if ($_FILES['picture']['tmp_name'] != "") {
    					$tempFile   = $_FILES['picture'];
    					$path = "news";
    					$model_id = $model->cms_id;
    					$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
    					if ($filename) {
    						$model = $this->loadModel($model->cms_id);
    						$model->cms_picture = $filename;
    						$model->save();
    					}
    				}



    				if(Yii::app()->user->id){
    					Helpers::lib()->getControllerActionId();
    				}
    				$langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
						if($model->parent_id == 0){
							$rootId = $model->cms_id;
						}else{
							$rootId = $model->parent_id;
						}
						
						foreach ($langs as $key => $lang) {
							# code...

							$new = News::model()->findByAttributes(array('lang_id'=> $lang->id, 'parent_id'=>$rootId));
							if(!$new){
								$newsRoot = News::model()->findByPk($rootId);
								Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มข่าวประชาสัมพันธ์ '.$newsRoot->cms_short_title .',ภาษา '.$lang->language);
					          	$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
					          	exit();
							}
						}

    				$this->redirect(array('view','id'=>$model->cms_id));
    			}else{
    				var_dump($model->getErrors());exit();
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
    	// var_dump($model->cms_detail);

    	$model->cms_detail = htmlspecialchars_decode(htmlspecialchars_decode($model->cms_detail));

    	// var_dump($model->cms_detail);
    	// exit();

    	if(isset($model->cms_link)){
    		$arr = json_decode($model->cms_link);
    		$model->cms_url = $arr[0];
    		$model->cms_tab = $arr[1];
    	}


    	if($model->cms_type_display == 'content'){
    		$model->cms_type_display = '0';
    	} else {
    		$model->cms_type_display = '1';
    	}

    	$imageShow = $model->cms_picture;
    	if(isset($_POST['News']))
    	{


    	// $model->cms_detail = htmlspecialchars_decode($model->cms_detail);
    		$model->cms_detail = htmlspecialchars($model->cms_detail, ENT_QUOTES);



    		$time = date("dmYHis");
    		$model->attributes=$_POST['News'];

			$imageOld = $model->cms_picture; // Image Old

			$cms_picture = CUploadedFile::getInstance($model, 'picture');
			if(isset($cms_picture)){
				$fileNamePicture = $time."_Picture.".$cms_picture->getExtensionName();
				$model->cms_picture = $fileNamePicture;
			}

			if($_POST['News']['cms_url']){
				$arr = array();
				$arr[] = $_POST['News']['cms_url'];
				$arr[] = $_POST['News']['cms_tab'];
				$model->cms_link = json_encode($arr);
			} else {
				$model->cms_link = '';
			}

			if($model->cms_type_display == '0'){
				$model->cms_type_display = 'content';
			} else {
				$model->cms_type_display = 'url';
			}
			$model->update_by = Yii::app()->user->id;
			$model->update_date = date("Y-m-d H:i:s");

			if($model->validate())
			{
				if($model->save())
				{
					$parent_news = News::model()->findAll("active='y' AND parent_id='".$model->cms_id."' ");
					foreach ($parent_news as $key => $value) {
						$value->cms_type_id = $model->cms_type_id;
						// $value->update_by = Yii::app()->user->id;
						// $value->update_date = date("Y-m-d H:i:s");
						$value->save();
					}

					if($model->lang_id == 1){

						$model_main = News::model()->findAll(array(
							'condition'=>'active="y" AND lang_id=1 AND cms_id!="'.$model->cms_id.'" AND parent_id!="'.$model->cms_id.'" AND sortOrder<="'.$model->sortOrder.'" ',
							'order'=>'sortOrder ASC'
						));

						$model->sortOrder = 1;
						$model->save(false);

						$model_sub = News::model()->find("active='y' AND parent_id='".$model->cms_id."' ");
						if($model_sub){
						// $model_sub->update_by = Yii::app()->user->id;
						// $model_sub->update_date = date("Y-m-d H:i:s");


						$model_sub->sortOrder = $model->sortOrder;
						$model_sub->save(false);
					}

						foreach ($model_main as $key => $value) {
							$value->sortOrder = $value->sortOrder+1;
							$value->save(false);

							$mo_news = News::model()->find("active='y' AND parent_id='".$value->cms_id."' ");
							if($mo_news){
								$mo_news->sortOrder = $value->sortOrder;
								$mo_news->save(false);
							}

						}
					}

					if ($_FILES['picture']['tmp_name'] != "") {
						$tempFile   = $_FILES['picture'];
						$path = "news";
						$model_id = $model->cms_id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->cms_id);
							$model->cms_picture = $filename;
							$model->save();
						}
					}



					// if(isset($imageShow) && isset($cms_picture))
					// {
					// 	Yii::app()->getDeleteImageYush('news',$model->id,$imageShow);
					// }

					// if(isset($cms_picture))
					// {
					// 	/////////// SAVE IMAGE //////////
					// 	Yush::init($model);
					// 	$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->cms_picture);
					// 	$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->cms_picture);
					// 	$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->cms_picture);
			  //           // Save the original resource to disk
					// 	$cms_picture->saveAs($originalPath);

			  //           // Create a small image
					// 	$smallImage = Yii::app()->phpThumb->create($originalPath);
					// 	$smallImage->resize(110);
					// 	$smallImage->save($smallPath);

			  //           // Create a thumbnail
					// 	$thumbImage = Yii::app()->phpThumb->create($originalPath);
					// 	$thumbImage->resize(240);
					// 	$thumbImage->save($thumbPath);
					// }

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}


					$this->redirect(array('view','id'=>$model->cms_id));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow
			));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		// $this->actionSort($model->sortOrder);
		$model->active = 'n';

		if($model->cms_picture != '')
			Yii::app()->getDeleteImageYush('News',$model->id,$model->cms_picture);

		$model->cms_picture = null;

		$modelChrilden = News::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $model->cms_id, ':active' => 'y')
              ));
		foreach ($modelChrilden as $key => $value) {
			// $this->actionSort($value->sortOrder);
			$value->active = 'n';

			if($value->cms_picture != ''){
				Yii::app()->getDeleteImageYush('News',$value->id,$value->cms_picture);
			}
			$value->cms_picture = null;
			$value->save();
		}
		$model->save();

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}


		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{
		//header('Content-type: application/json');
		if(isset($_POST['chk']))
		{
			foreach($_POST['chk'] as $val)
			{
				$this->actionDelete($val);
			}
		}
	}

	public function actionIndex()
	{

		$model=new News('search');
		$model->unsetAttributes();
		$model->active = 'y';
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];

		$this->render('index',array(
			'model'=>$model,
			));
	}

	public function loadModel($id)
	{
		$model=News::model()->newscheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	 public function actionSequence() {

    if (isset($_POST['items']) && is_array($_POST['items'])) {
       
            // Get all current target items to retrieve available sortOrders
        $cur_items = News::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
        
            // Check 1 by 1 and update if neccessary

        foreach ($cur_items as $keys => $values) {

            for ($i = 0; $i < count($_POST['items']); $i++) {
                $item = News::model()->findByPk($_POST['items'][$i]);

                if ($item->sortOrder != $cur_items[$i]->sortOrder) {
                    $item->sortOrder = $cur_items[$i]->sortOrder ;
                    $item->save(false);
                } 

                $modellang2 = News::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
                  //var_dump($modellang2->sortOrder);exit();
                
                if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
                    if ($modellang2->parent_id == '') {
                        $items = News::model()->findByPk($_POST['items'][$i]);
                        $items->sortOrder = $cur_items[$i]->sortOrder ;
                        $items->save(false);
                        
                    }
                    if ($modellang2->parent_id != null) {
                        $modellang2->sortOrder = $cur_items[$i]->sortOrder ;
                        $modellang2->save(false);   
                    }
                    
                } 
            }
        }        
    }
}

	public function actionSort($sort){
		$model = News::model()->findAll(array(
	    		'condition'=>'sortOrder >= '.$sort.' AND active="y"',
	    		'order'=>'sortOrder ASC'
	    	));

		if ($model) {
			foreach ($model as $key => $value) {
				$value->sortOrder = ($key==0)? $sort:$sort++;
				$value->save(false);
			}
		}
	}

}
