<?php
class UsabilityController extends Controller
{
    public function init()
    {
        // parent::init();
        // $this->lastactivity();
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
            // array('allow',  // allow all users to perform 'index' and 'view' actions
            // 	'actions' => array('index', 'view', 'update', 'delete', 'create'),
            // 	'users' => array('*'),
            // ),
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
    
    // public function init()
    // {
    // 	parent::init();
    // 	$this->lastactivity();

    // }
    // public function filters() 
    // {
    //     return array(
    //         'rights',
    //     );
    // }

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    	));
    }

    public function actionCreate()
    {
    	$model=new Usability;
       
        if(isset($_POST['Usability']))
        {
            $model->attributes=$_POST['Usability'];
            $model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
            $model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
            // $usa_address = CUploadedFile::getInstance($model, 'usa_address');

            // if(isset($usa_address)){
            //     $fileNamePicture = $time."_Files.".$usa_address->getExtensionName();
            //     $model->usa_address = $fileNamePicture;
            // }
            if($model->save()){
                $model->sortOrder = $model->usa_id;
                $model->save();
                // if(isset($usa_address))
                // {
                //         /////////// SAVE IMAGE //////////
                //     Yush::init($model);
                //     $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->usa_address);
                //     $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->usa_address);
                //     $usa_address->saveAs($originalPath);

                //     $thumbImage = Yii::app()->phpThumb->create($originalPath);
                //     $thumbImage->resize(225);
                //     $thumbImage->save($thumbPath);
                // }

                if ($_FILES['picture']['tmp_name'] != "") {
                    $tempFile   = $_FILES['picture'];
                    $path = "usability";
                    $model_id = $model->usa_id;
                    $base64_pic = $_POST["url_pro_pic"];
                    $filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
                    if ($filename) {
                        $model = $this->loadModel($model->usa_id);
                        $model->usa_address = $filename;
                        $model->save(false);
                    }
                }

                if(Yii::app()->user->id){
                    Helpers::lib()->getControllerActionId();
                }
            }

            $this->redirect(array('view','id'=>$model->usa_id));
        }

        $this->render('create',array(
         'model'=>$model,
     ));
    }

    public function actionUpdate($id)
    {
    	 $model=$this->loadModel($id);

      $imageShow = $model->usa_address;

      if(isset($_POST['Usability']))
      {
        $time = date("dmYHis");
        $model->attributes=$_POST['Usability'];
        // $usa_address = CUploadedFile::getInstance($model, 'usa_address');

        // if(isset($usa_address)){
        //     $fileNamePicture = $time."_Files.".$usa_address->getExtensionName();
        //     $model->usa_address = $fileNamePicture;
        // }else{
        //     $model->usa_address = $imageShow;
        // }

        if($model->save()){

            if ($_FILES['picture']['tmp_name'] != "") {
                $tempFile   = $_FILES['picture'];
                $path = "usability";
                $model_id = $model->usa_id;
                $base64_pic = $_POST["url_pro_pic"];
                $filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
                if ($filename) {
                    $model = $this->loadModel($model->usa_id);
                    $model->usa_address = $filename;
                    $model->save(false);
                }
            }

            // if(isset($usa_address))
            // {
            //             /////////// SAVE IMAGE //////////
            //     Yush::init($model);
            //     $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->usa_address);
            //     $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->usa_address);
            //     $usa_address->saveAs($originalPath);

            //     $thumbImage = Yii::app()->phpThumb->create($originalPath);
            //     $thumbImage->resize(225);
            //     $thumbImage->save($thumbPath);
            // }

            if(Yii::app()->user->id){
                Helpers::lib()->getControllerActionId();
            }

            $this->redirect(array('view','id'=>$model->usa_id));
        }
    }

    $this->render('update',array(
        'model'=>$model,
        'imageShow'=>$imageShow
    ));
    }

    public function actionDelete($id)
    {
    	$this->loadModel($id)->delete();

     
        $usability = Usability::model()->findByAttributes(array('parent_id'=>$id));
        if(isset($usability)){
            $usability->delete();
        }

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
    	$model=new Usability('search');
    	$model->unsetAttributes();
    	if(isset($_GET['Usability']))
    		$model->attributes=$_GET['Usability'];

    	$this->render('index',array(
    		'model'=>$model,
    	));
    }

    public function loadModel($id)
    {
    	$model=Usability::model()->findByPk($id);
    	if($model===null)
    		throw new CHttpException(404,'The requested page does not exist.');
    	return $model;
    }

    protected function performAjaxValidation($model)
    {
    	if(isset($_POST['ajax']) && $_POST['ajax']==='usability-form')
    	{
    		echo CActiveForm::validate($model);
    		Yii::app()->end();
    	}
    }

    public function actionSequence() {

    if (isset($_POST['items']) && is_array($_POST['items'])) {
       
            // Get all current target items to retrieve available sortOrders
        $cur_items = Usability::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
        
            // Check 1 by 1 and update if neccessary

        foreach ($cur_items as $keys => $values) {

            for ($i = 0; $i < count($_POST['items']); $i++) {
                $item = Usability::model()->findByPk($_POST['items'][$i]);

                if ($item->sortOrder != $cur_items[$i]->sortOrder) {
                    $item->sortOrder = $cur_items[$i]->sortOrder ;
                    $item->save(false);
                } 

                $modellang2 = Usability::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
                  //var_dump($modellang2->sortOrder);exit();
                
                if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
                    if ($modellang2->parent_id == '') {
                        $items = Usability::model()->findByPk($_POST['items'][$i]);
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
}
