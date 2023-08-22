<?php

class CourseTeacherController extends Controller
{
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
    
	public function actionIndex()
	{
		$this->render('index');
	}


	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
			$model = $this->loadModel($id);
			$model->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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


	public function loadModel($id)
	{
		$model=CourseTeacher::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='courseteacher-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
