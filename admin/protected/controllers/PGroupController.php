<?php

class PGroupController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    // public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
     public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array('index', 'view'),
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
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new PGroup;
        $model_p = new PGroupPermission;    
        $criteria = new CDbCriteria;
        $criteria->order = 'priority';
        $pController = PController::model()->findAll($criteria);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['PGroup'])) {
            $model->attributes = $_POST['PGroup'];
            if ($model->save()){
                $model_p->group_id = $model->id;
                $model_p->permission =  json_encode($_POST['PGroupPermission']);
                $model_p->save();
                $this->redirect(array('index', 'id' => $model->id));
            }
        }
        $this->render('create', array(
            'model' => $model,
            'model_p' => $model_p,
            'pController' => $pController
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model_p = PGroupPermission::model()->find(array(
            'condition' => 'group_id='.$model->id,
        ));
        $criteria = new CDbCriteria;
		$criteria->addCondition('id != 1'); //ปิดเมนูเงื่อนไขการใช้งาน
        $criteria->order = 'priority';
        $pController = PController::model()->findAll($criteria);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['PGroup'])) {
            $model->attributes = $_POST['PGroup'];
            if ($model->save()){
                $model_p->group_id = $model->id;
                $model_p->permission =  json_encode($_POST['PGroupPermission']);
                $model_p->save();
                $this->redirect(array('index', 'id' => $model->id));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'model_p' => $model_p,
            'pController' => $pController
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            if($id != 7){ // ไม่ให้ลบ ผูู้ดูแลระบบ
            $this->loadModel($id)->delete();
        }
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {           
        $model = new PGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PGroup'])){
            $model->attributes = $_GET['PGroup'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new PGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PGroup']))
            $model->attributes = $_GET['PGroup'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    public function actionActive()
    {
        // we only allow deletion via POST request
        $model = $this->loadModel($_GET['pk']);
        if ($model->active == 1) {
            $model->active = 0;
        } elseif ($model->active == 0) {
            $model->active = 1;
        }
        $model->update();
    }



    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = PGroup::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pgroup-grid') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
