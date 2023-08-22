<?php

class PControllerController extends Controller
{
    // /**
    //  * @return array action filters
    //  */
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
        $model_c = new PController;
        $model_a = new PAction;

// Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model_c,$model_a);

        if (isset($_POST['PController']) && isset($_POST['PAction'])) {
            $model_c->attributes = $_POST['PController'];
            if ($model_c->save()){
                if ($model_c->priority == null) {
                   $model_c->priority = $model_c->id;   
                   $model_c->save();
                }
                if ($_POST['PAction']){
                    foreach ($_POST['PAction'] as $action_index=>$action_value){
                        $model_s = new PAction;
                        $model_s->attributes = $action_value;
                        $model_s->controller_id = $model_c->id;
                        $model_s->save();
                    }
                }
                $this->redirect(array('index', 'id' => $model_c->id));
            }

        }

        $this->render('create', array(
            'model_c' => $model_c,
            'model_a' => $model_a
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model_c = $this->loadModel($id);
        $model_a = PAction::model()->findAll(array(
            'condition' => 'controller_id='.$model_c->id,
        ));

        $model_t = new PAction;

//        $model_a = PAction::model()->findByPk($model_c->id);



// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model_c,$model_t);

        if (isset($_POST['PController'])) {
            $model_c->attributes = $_POST['PController'];
            if ($model_c->save()){
                if ($_POST['PAction']){
                    foreach ($_POST['PAction'] as $action_index=>$action_value){
                                $new_action[] = $action_value['action'];
                        $model_ss = PAction::model()->find('action="'.$action_value['action'].'" AND controller_id='.$model_c->id);

                        if ($model_ss){
                            $model_ss->attributes = $action_value;
                            $model_ss->controller_id = $model_c->id;
                           $model_ss->save();

                        }else{
                            $model_s = new PAction;
                            $model_s->attributes = $action_value;
                            $model_s->controller_id = $model_c->id;
                            $model_s->save();
                        }
                    }
                    ///// ลบแอคชั่นที่ไม่ได้ส่งมาออก
                        $model_del = PAction::model()->findAll(["select"=>"action",'condition'=>'controller_id='.$model_c->id]);
                        if($model_del){
                            foreach($model_del as $key => $val){
                                if(isset($new_action)){
                                    if(!in_array($val->action,$new_action)){
                                        $model_del_action = PAction::model()->find('action="'.$val->action.'" AND controller_id='.$model_c->id);
                                        $model_del_action->delete(false);
                                    }
                                }
                            }
                        }
                        /////// end ลบแอคชั่น
                }
                $this->redirect(array('index', 'id' => $model_c->id));
            }
        }

        $this->render('update', array(
            'model_c' => $model_c,
            'model_a' => $model_a,
            'model_t' => $model_t,
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

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
        $model = new PController('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PController']))
            $model->attributes = $_GET['PController'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new PController('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PController']))
            $model->attributes = $_GET['PController'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = PController::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model,$model_a)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pcontroller-grid') {
            echo CActiveForm::validate(array($model,$model_a));
            Yii::app()->end();
        }
    }
     public function actionPriority()
    {
        if (isset($_POST['items']) && is_array($_POST['items'])) {
       
            // Get all current target items to retrieve available sortOrders
        $cur_items = PController::model()->findAllByPk($_POST['items'], array('order'=>'priority'));
   
            // Check 1 by 1 and update if neccessary

       // foreach ($cur_items as $keys => $values) {

            for ($i = 0; $i < count($_POST['items']); $i++) {
                $item = PController::model()->findByPk($_POST['items'][$i]);
                if ($item->priority != $cur_items[$i]->priority) {
                    $item->priority = $cur_items[$i]->priority ;
                    $item->save(false);
                    echo "ok";
                }else{
                    echo "error";
                } 

              /*  $modellang2 = Usability::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
                 // var_dump($modellang2->sortOrder);exit();
                
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
                    
                } */
            }
      //  }        
    }
    }
}
