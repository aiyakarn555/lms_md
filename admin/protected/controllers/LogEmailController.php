<?php

class LogEmailController extends Controller
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
	
    public function actionEmail()
    {
        $model=new LogEmail('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogEmail']))
            $model->attributes=$_GET['LogEmail'];

        $this->render('email',array(
            'model'=>$model,
        ));
    }

    public function actionListDepartment()
    {

         $model=Department::model()->findAll('type_employee_id=:type_employee_id',
            array(':type_employee_id'=>$_POST['id']));

         $data=CHtml::listData($model,'id','dep_title',array('empty' => 'แผนก'));
         $sub_list = 'เลือกแผนก';
         $data = '<option value ="">'.$sub_list.'</option>';
         foreach ($model as $key => $value) {
            $data .= '<option value = "'.$value->id.'"'.'>'.$value->dep_title.'</option>';
        }
        echo ($data);

    }

    public function actionListPosition()
    {

         $model=Position::model()->findAll('department_id=:department_id',
            array(':department_id'=>$_POST['id']));
         
         $data=CHtml::listData($model,'id','position_title',array('empty' => 'ตำแหน่ง'));
          if ($data) {     
         $sub_list = 'เลือกตำแหน่ง';
         $data = '<option value ="">'.$sub_list.'</option>';
         foreach ($model as $key => $value) {
            $data .= '<option value = "'.$value->id.'"'.'>'.$value->position_title.'</option>';
        }
        echo ($data);
        }else{
        echo '<option value = "">ไม่พบข้อมูล</option>';
            
         }

    }
}