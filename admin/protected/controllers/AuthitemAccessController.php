<?php
class AuthitemAccessController extends Controller
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
		$model=new AuthitemAccess('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AuthitemAccess']))
			$model->attributes=$_GET['AuthitemAccess'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionAccessAjax($name,$number)
	{
		AuthitemAccess::model()->updateAll(array('access'=>$number)," name='".$name.".*' ");
	}

	public function loadModel($id)
	{
		$model=AuthitemAccess::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
