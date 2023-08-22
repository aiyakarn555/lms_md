<?php

class EvalAnsController extends Controller
{
	public $_lastUser = null;

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

	public function actionView($id,$ans)
	{
		$modelCourseOnline = CourseOnline::model()->findByPk($ans);

		$modelEvaluate = EvalAns::model()->findAll(array(
			'condition' => 'course_id = "'.$ans.'" AND user_id = "'.$id.'" '
		));

		$model=new EvalAns('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EvalAns']))
			$model->attributes=$_GET['EvalAns'];

		$this->render('view',array(
			'modelCourseOnline'=>$modelCourseOnline,
			'modelEvaluate'=>$modelEvaluate,
			'model'=>$model,
			'id'=>$id,
			'ans'=>$ans
		));
	}

	public function actionReportUser($id,$ans)
	{
		$model=new EvalAns('search');
		$model->unsetAttributes();

        if(Yii::app()->user->getState('ReportOrder'))
        {
        	$model = Yii::app()->user->getState('ReportOrder');
        }

	    if (isset($_GET['export'])) 
	    {
	        $production = 'export';
	    } 
	    else 
	    {
	        $production = 'grid';
	    }

		$this->render('reportuser',array(
			'model'			=> $model,
			'production' 	=> $production,
			'id'			=> $id,
			'ans'			=> $ans,	
		));
	}

	public function actionReportUserAll($ans)
	{
		$model=new EvalAns('search');
		$model->unsetAttributes();

        if(Yii::app()->user->getState('ReportOrder'))
        {
        	$model = Yii::app()->user->getState('ReportOrder');
        }

	    if (isset($_GET['export'])) 
	    {
	        $production = 'export';
	    } 
	    else 
	    {
	        $production = 'grid';
	    }

		$this->render('reportuserall',array(
			'model'			=> $model,
			'production' 	=> $production,
			'ans'			=> $ans,	
		));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('EvalAns');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
    public function gridUser($data,$row)
    { 
        if($this->_lastUser != $data->user_id)
        {
            $this->_lastUser = $data->user_id;
            return $data->NameUser;
        }
        else
             return '';
    }   

	public function loadModel($id)
	{
		$model=EvalAns::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='eval-ans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
