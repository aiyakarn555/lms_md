<?php

class DepartmentController extends Controller
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
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('view','MultiDeletes'),
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
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	// public function filters()
	// {
	// 	return array(
	// 		'accessControl', // perform access control for CRUD operations
	// 		'postOnly + delete', // we only allow deletion via POST request
	// 	);
	// }

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
		// public function accessRules()
		// {
		// 	return array(
		// 		array('allow',  // allow all users to perform 'index' and 'view' actions
		// 			'actions'=>array('index','view'),
		// 			'users'=>array('*'),
		// 		),
		// 		array('allow', // allow authenticated user to perform 'create' and 'update' actions
		// 			'actions'=>array('create','update'),
		// 			'users'=>array('@'),
		// 		),
		// 		array('allow', // allow admin user to perform 'admin' and 'delete' actions
		// 			'actions'=>array('admin','delete'),
		// 			'users'=>array('admin'),
		// 		),
		// 		array('deny',  // deny all users
		// 			'users'=>array('*'),
		// 		),
		// 	);
		// }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Department;

		if(isset($_POST['Department']))
		{

			if($_POST['Department'][type_employee_id] != null && $_POST['Department'][dep_title] != null){
				$type_employee_id = $_POST['Department'][type_employee_id];

				if($type_employee_id == 1){
					$type_employee_id = 4;
				}else{
					$type_employee_id = 5;
				}

			
				$dep_title = $_POST['Department'][dep_title];

				// $modelTypeEmp = TypeEmployee::model()->findByPk($type_employee_id);
				// $typeEmpName = $modelTypeEmp->type_employee_name;

				// $criteria = new CDbCriteria;
				// $criteria->compare('title',$typeEmpName);
				// $modelOrgChart = OrgChart::model()->findAll($criteria);

				// if($modelOrgChart){
				// 	foreach ($modelOrgChart as $value) {
				// 		$idOrgChart = $value->id;
				// 	}
				// }

				$newOrgChart = new OrgChart;
				$newOrgChart->title = $dep_title;
				$newOrgChart->parent_id = $type_employee_id;
				$newOrgChart->level = 4;
				$newOrgChart->active = 'y';
				$newOrgChart->save();
				$newOrgChart->sortOrder = $newOrgChart->id;
				$newOrgChart->save();


				$model->attributes=$_POST['Department'];
				if($model->save()){
					$newOrgChart->department_id = $model->id;
					$newOrgChart->save();

					$model->sortOrder = $model->id;
					$model->save();


					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
					$this->redirect(array('admin','id'=>$model->id));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$type_employee_id = $_POST['Department'][type_employee_id];
		$dep_titles = $_POST['Department'][dep_title];

		$modelTypeDep= Department::model()->findByPk($id);
		$typeDepName = $modelTypeDep->dep_title;

		if(isset($_POST['Department']))
		{
			if($type_employee_id == 1){
				$type_employee_id = 4;
			}else{
				$type_employee_id = 5;
			}

			$criteria = new CDbCriteria();
			$criteria->compare('department_id',$id);
			$criteria->compare('title',$typeDepName);
			$modelOrgChart = OrgChart::model()->findAll($criteria);
				foreach ($modelOrgChart as $key => $value) {
					$value->title = $dep_titles;
					$value->parent_id = $type_employee_id;
					$value->save();
				}
		}
		
		$model=$this->loadModel($id);
		if(isset($_POST['Department']))
		{
			$model->attributes=$_POST['Department'];
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->id);
				}
				$this->redirect(array('admin','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// $modelOrgChart = OrgChart::model()->deleteAll(array("condition"=>"department_id='$id'"));
		$modelOrgChart=OrgChart::model()->updateAll(
            array('active' => "n"), 
            'department_id ='.$id
            );

		/////// ลบ Position
		$model_Position = Position::model()->findAll(array(
			'condition' => 'active=:active AND department_id="'.$id.'"',
			'params' => array(':active'=>'y'),
		));

		if(!empty($model_Position)){
			foreach ($model_Position as $key_p => $value_p) {

				$modelOrgChart = OrgChart::model()->updateAll(
					array('active' => "n"), 
					'position_id ='.$value_p->id
				);

				/////////////////ลบ level ก่อน
				$model_Branch = Branch::model()->findAll(array(
					'condition' => 'active=:active AND position_id="'.$value_p->id.'"',
					'params' => array(':active'=>'y'),
				));

				if(!empty($model_Branch)){
					foreach ($model_Branch as $key_b => $value_b) {
						$modelOrgChart=OrgChart::model()->updateAll(
							array('active' => "n"), 
							'branch_id ='.$value_b->id
						);


						$model = $this->loadModel($value_b->id);
						$model->active = 'n';
						$model->save(false);

						$mmodell = Branch::model()->findAll(array(
							'condition' => 'active=:active',
							'params' => array(':active'=>'y'),
							'order' => 'sortOrder ASC',
						));
						foreach ($mmodell as $key => $value) {
							$model_edit = Branch::model()->findByPk($value->id);
							$model_edit->sortOrder = $key+1;
							$model_edit->save(false);
						}
					}
				}
				///////////////// จบ level

				$model = $this->loadModel($value_p->id);
				$model->active = 'n';
				$model->save(false);

				unset($mmodell);
				$mmodell = Position::model()->findAll(array(
					'condition' => 'active=:active',
					'params' => array(':active'=>'y'),
					'order' => 'sortOrder ASC',
				));
				foreach ($mmodell as $key => $value) {
					$model_edit = Position::model()->findByPk($value->id);
					$model_edit->sortOrder = $key+1;
					$model_edit->save(false);
				}
			}
		}
		//////////////  จบ position

		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save(false);

		$mmodell = Department::model()->findAll(array(
			'condition' => 'active=:active',
			'params' => array(':active'=>'y'),
			'order' => 'sortOrder ASC',
		));
		foreach ($mmodell as $key => $value) {
			$model_edit = Department::model()->findByPk($value->id);
			$model_edit->sortOrder = $key+1;
			$model_edit->save(false);
		}

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('Department');
		$dataProvider=new CActiveDataProvider('Department' ,array('criteria'=>array(
			'condition'=>'active="y"')));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Department('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Department']))
			$model->attributes=$_GET['Department'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {

			$cur_items = Department::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));

			$org_2 = array();
			foreach ($cur_items as $key => $value) {
				$org_2[] = OrgChart::model()->find(array(
					'condition' => 'active=:active AND department_id=:department_id AND position_id IS NULL AND branch_id IS NULL',
					'params' => array(':active' => 'y', ':department_id'=>$value->id),
					'order'=>'sortOrder'
				));
			}
			
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = Department::model()->findByPk($_POST['items'][$i]);
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {

					echo $item->sortOrder." ".$cur_items[$i]->sortOrder." || ";
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();

					$org_1 = OrgChart::model()->find(array(
					'condition' => 'active=:active AND department_id=:department_id AND position_id IS NULL AND branch_id IS NULL',
					'params' => array(':active' => 'y', ':department_id'=>$item->id),
				));
					
					echo $org_1->sortOrder." ".$org_2[$i]->sortOrder." || ";
					$org_1->sortOrder = $org_2[$i]->sortOrder;
					$org_1->save();
				}
			}
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Department the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Department::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Department $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='department-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
