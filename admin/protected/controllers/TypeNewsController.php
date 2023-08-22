<?php

class TypeNewsController extends Controller
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
    	$model = new TypeNews;

    	if(isset($_POST['TypeNews']))
    	{
    		$sort = TypeNews::model()->count(array(
	    		'condition'=>'active="y"'
	    	));
    		$time = date("dmYHis");
    		$model->attributes=$_POST['TypeNews'];
    		// $model->sortOrder = $sort+1;
    		$model->sortOrder = 1;
    		$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;

			if($model->lang_id == 2){
				$m_Typenews = TypeNews::model()->findByPk($model->parent_id);
				$model->sortOrder = $m_Typenews->sortOrder;
			}


    		if($model->validate())
    		{
    			if($model->save())
    			{	
    				if($model->lang_id == 1){

    					$model_main = TypeNews::model()->findAll(array(
    						'condition'=>'active="y" AND lang_id=1 AND cms_type_id!="'.$model->cms_type_id.'" AND parent_id!="'.$model->cms_type_id.'" ',
    						'order'=>'sortOrder ASC'
    					));

    					foreach ($model_main as $key => $value) {
    						$value->sortOrder = $value->sortOrder+1;
    						$value->save(false);

    						$mo_Typenews = TypeNews::model()->find("active='y' AND parent_id='".$value->cms_type_id."' ");
    						if($mo_Typenews){
    							$mo_Typenews->sortOrder = $value->sortOrder;
    							$mo_Typenews->save(false);
    						}

    					}
    				}



    				if(Yii::app()->user->id){
    					Helpers::lib()->getControllerActionId();
    				}
    				$langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
						if($model->parent_id == 0){
							$rootId = $model->cms_type_id;
						}else{
							$rootId = $model->parent_id;
						}
						
						foreach ($langs as $key => $lang) {
							# code...

							$new = TypeNews::model()->findByAttributes(array('lang_id'=> $lang->id, 'parent_id'=>$rootId));
							if(!$new){
								$TypenewsRoot = TypeNews::model()->findByPk($rootId);
								Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มหมวดข่าวสารและกิจกรรม '.$TypenewsRoot->cms_type_title .',ภาษา '.$lang->language);
					          	$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
					          	exit();
							}
						}

    				$this->redirect(array('view','id'=>$model->cms_type_id));
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


    	if(isset($_POST['TypeNews']))
    	{



    		$time = date("dmYHis");
    		$model->attributes=$_POST['TypeNews'];


			if($model->validate())
			{
				if($model->save())
				{


					if($model->lang_id == 1){

						$model_main = TypeNews::model()->findAll(array(
							'condition'=>'active="y" AND lang_id=1 AND cms_type_id!="'.$model->cms_type_id.'" AND parent_id!="'.$model->cms_type_id.'" AND sortOrder<="'.$model->sortOrder.'" ',
							'order'=>'sortOrder ASC'
						));

						$model->sortOrder = 1;
						$model->save(false);

						$model_sub = TypeNews::model()->find("active='y' AND parent_id='".$model->cms_type_id."' ");
						if($model_sub){
						$model_sub->sortOrder = $model->sortOrder;
						$model_sub->save(false);
					}

						foreach ($model_main as $key => $value) {
							$value->sortOrder = $value->sortOrder+1;
							$value->save(false);

							$mo_Typenews = TypeNews::model()->find("active='y' AND parent_id='".$value->cms_type_id."' ");
							if($mo_Typenews){
								$mo_Typenews->sortOrder = $value->sortOrder;
								$mo_Typenews->save(false);
							}

						}
					}


					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}


					$this->redirect(array('view','id'=>$model->cms_type_id));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		// $this->actionSort($model->sortOrder);
		$model->active = 'n';

		if($model->cms_picture != '')

		$modelChrilden = TypeNews::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $model->cms_type_id, ':active' => 'y')
              ));
		foreach ($modelChrilden as $key => $value) {
			// $this->actionSort($value->sortOrder);
			$value->active = 'n';

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
		$model=new TypeNews('search');
		$model->unsetAttributes();
		$model->active = 'y';
		if(isset($_GET['TypeNews']))
			$model->attributes=$_GET['TypeNews'];

		$this->render('index',array(
			'model'=>$model,
			));
	}

	public function loadModel($id)
	{
		$model=TypeNews::model()->typenewscheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Typenews-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	 public function actionSequence() {

    if (isset($_POST['items']) && is_array($_POST['items'])) {
       
            // Get all current target items to retrieve available sortOrders
        $cur_items = TypeNews::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
        
            // Check 1 by 1 and update if neccessary

        foreach ($cur_items as $keys => $values) {

            for ($i = 0; $i < count($_POST['items']); $i++) {
                $item = TypeNews::model()->findByPk($_POST['items'][$i]);

                if ($item->sortOrder != $cur_items[$i]->sortOrder) {
                    $item->sortOrder = $cur_items[$i]->sortOrder ;
                    $item->save(false);
                } 

                $modellang2 = TypeNews::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
                  //var_dump($modellang2->sortOrder);exit();
                
                if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
                    if ($modellang2->parent_id == '') {
                        $items = TypeNews::model()->findByPk($_POST['items'][$i]);
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
		$model = TypeNews::model()->findAll(array(
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
