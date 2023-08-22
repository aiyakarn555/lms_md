<?php

class CoursecontrolController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

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
        $model = new OrgCourse;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrgCourse'])) {
            $model->attributes = $_POST['OrgCourse'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }

        }

        $this->render('create', array(
            'model' => $model,
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrgCourse'])) {
            $model->attributes = $_POST['OrgCourse'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }

        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }

    }

    /**
     * Lists all models.
     */
    public function actionIndex($id)
    {
        $OrgCourse = OrgCourse::model()->findAll(array(
            'condition' => 'orgchart_id=' . $id,
        ));

        $chk_orgcourse = array();
        if ($OrgCourse) {
            foreach ($OrgCourse as $key => $value) {
                if (!in_array($value->course_id, $chk_orgcourse)) {
                    $chk_orgcourse[] = $value->course_id;
                }
            }

        }

       
        $CourseOnline = CourseOnline::model()->courseonlinecheck()->findAll(array(
            'condition' => 'courseonline.parent_id=:parent_id AND courseonline.active=:active AND courseonline.lang_id = 1',
            'params' => array(':parent_id' => 0, ':active' => 'y'),
        ));

        $chk_courseonline = array();
        if ($CourseOnline) {
            foreach ($CourseOnline as $key => $value) {
                $chk_courseonline[] = $value->course_id;
            }
        }

        // }

        // $result_orgcourse = array_diff($chk_orgcourse, $chk_courseonline);
        $result_courseonline = array_diff($chk_courseonline, $chk_orgcourse);

        $this->render('index', array(
            'result_courseonline' => $result_courseonline,
            'OrgCourse' => $OrgCourse,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new OrgCourse('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['OrgCourse'])) {
            $model->attributes = $_GET['OrgCourse'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function parseJsonArray($jsonArray, $parentID = 0)
    {
        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray['children'])) {
                $returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
            }
            $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }
        return $return;
    }

    public function actionSave_categories()
    {

        if (isset($_POST['categories'])) {

            $json = $_POST['categories'];
            $json2 = $_POST['categories2'];

            $data = json_decode($json, true);

            foreach (json_decode($json2, true) as $key => $value) {
                $orgc = OrgCourse::model()->findByPk($value['id']);
                $course_id_del = $orgc->course_id;
                if ($orgc) {
                    $orgc->delete();

                }
                // echo $_GET['id'];
                // if(isset($value['children'])){
                foreach ($value['children'] as $key_children => $value_children) {
                    $orgc2 = OrgCourse::model()->findByPk($value_children['id']);
                    if ($orgc2) {
                        $orgc2->delete();
                    }
                }

                $orgchart1 = OrgChart::model()->findAll(array(
                    'condition' => 'parent_id=:parent_id',
                    'params' => array(':parent_id' => $_POST['org_id']),
                ));

                if ($orgchart1) { //2
                    foreach ($orgchart1 as $key => $val) {
                        $orgc_del = OrgCourse::model()->find(array(
                            'condition' => 'orgchart_id=:orgchart_id AND course_id=:course_id',
                            'params' => array(':orgchart_id' => $val->id, ':course_id' => $course_id_del),
                        ));

                        if ($orgc_del) {
                            $orgc_del->delete();
                        }
                        foreach ($value['children'] as $key_children => $value_children) {
                            $orgc2 = OrgCourse::model()->findByPk($value_children['id']);
                            if ($orgc2) {
                                $orgc2->delete();
                            }
                        }

                        $orgchart22 = OrgChart::model()->findAll(array(
                            'condition' => 'parent_id=:parent_id',
                            'params' => array(':parent_id' => $val->id),
                        ));
                        if (!empty($orgchart22)) { // 3
                            foreach ($orgchart22 as $key2 => $val2) {
                                $orgc_del_2 = OrgCourse::model()->find(array(
                                    'condition' => 'orgchart_id=:orgchart_id AND course_id=:course_id',
                                    'params' => array(':orgchart_id' => $val2->id, ':course_id' => $course_id_del),
                                ));
                                if ($orgc_del_2) {
                                    $orgc_del_2->delete();
                                }

                                $orgchart33 = OrgChart::model()->findAll(array(
                                    'condition' => 'parent_id=:parent_id',
                                    'params' => array(':parent_id' => $val2->id),
                                ));
                                if (!empty($orgchart33)) { // 4
                                    foreach ($orgchart33 as $key3 => $val3) {
                                        $orgc_del_3 = OrgCourse::model()->find(array(
                                            'condition' => 'orgchart_id=:orgchart_id AND course_id=:course_id',
                                            'params' => array(':orgchart_id' => $val3->id, ':course_id' => $course_id_del),
                                        ));
                                        if ($orgc_del_3) {
                                            $orgc_del_3->delete();
                                        }

                                        $orgchart44 = OrgChart::model()->findAll(array(
                                            'condition' => 'parent_id=:parent_id',
                                            'params' => array(':parent_id' => $val3->id),
                                        ));
                                        if (!empty($orgchart44)) { // 5
                                            foreach ($orgchart44 as $key4 => $val4) {
                                                $orgc_del_4 = OrgCourse::model()->find(array(
                                                    'condition' => 'orgchart_id=:orgchart_id AND course_id=:course_id',
                                                    'params' => array(':orgchart_id' => $val4->id, ':course_id' => $course_id_del),
                                                ));
                                                if ($orgc_del_4) {
                                                    $orgc_del_4->delete();
                                                }

                                                $orgchart55 = OrgChart::model()->findAll(array(
                                                    'condition' => 'parent_id=:parent_id',
                                                    'params' => array(':parent_id' => $val4->id),
                                                ));
                                                if (!empty($orgchart55)) { // 6
                                                    foreach ($orgchart55 as $key5 => $val5) {
                                                        $orgc_del_5 = OrgCourse::model()->find(array(
                                                            'condition' => 'orgchart_id=:orgchart_id AND course_id=:course_id',
                                                            'params' => array(':orgchart_id' => $val5->id, ':course_id' => $course_id_del),
                                                        ));
                                                        if ($orgc_del_5) {
                                                            $orgc_del_5->delete();
                                                        }

                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                            }
                        }

                    }
                }

            }

            foreach ($this->parseJsonArray($data) as $key => $value) {

                $orgc = OrgCourse::model()->findByPk($value['id']);

                $orgchart = OrgChart::model()->findAll(array( // ภายใต้ 1 ขั้น
                    'condition' => 'parent_id=:parent_id',
                    'params' => array(':parent_id' => $_POST['org_id']),
                ));

                if ($orgc) {
                    // $course_online = CourseOnline::model()->findByPk($orgc->course_id);
                    $orgc->parent_id = $value['parentID'];
                    $orgc->save();
                    // echo $value['id'];
                } else {

                    $orgchart_checkkk = OrgCourse::model()->findAll(array(
                        'condition' => 'parent_id=:parent_id AND orgchart_id=:orgchart_id AND course_id=:course_id',
                        'params' => array(':parent_id' => $value['parentID'], ':orgchart_id' => $_POST['org_id'], ':course_id' => $value['id']),
                    ));

                    if (empty($orgchart_checkkk)) {
                        $orgc = new OrgCourse;
                        // $orgc->save();
                        // $course_online = CourseOnline::model()->findByPk($value['id']);
                        $orgc->orgchart_id = $_POST['org_id'];
                        $orgc->course_id = $value['id'];
                        $orgc->parent_id = $value['parentID'];
                        $orgc->active = 'y';
                        $orgc->save();
                    }

                    if ($orgchart) {

                        foreach ($orgchart as $key => $val) { // LEVEL 4

                            $orgchart_check = OrgCourse::model()->findAll(array(
                                'condition' => 'parent_id=:parent_id AND orgchart_id=:orgchart_id AND course_id=:course_id',
                                'params' => array(':parent_id' => 0, ':orgchart_id' => $val->id, ':course_id' => $value['id']),
                            ));

                            if (empty($orgchart_check)) {
                                $orgc = new OrgCourse;
                                $orgc->orgchart_id = $val->id;
                                $orgc->course_id = $value['id'];
                                $orgc->parent_id = 0;
                                // $orgc->parent_id = $_POST['org_id'];
                                $orgc->active = 'y';
                                $orgc->save();
                            }

                            $orgchart44 = OrgChart::model()->findAll(array(
                                'condition' => 'parent_id=:parent_id',
                                'params' => array(':parent_id' => $val->id),
                            ));

                            if (!empty($orgchart44)) {
                                foreach ($orgchart44 as $key4 => $value4) { // LEVEL 5
                                    $orgchart44_check = OrgCourse::model()->findAll(array(
                                        'condition' => 'parent_id=:parent_id AND orgchart_id=:orgchart_id AND course_id=:course_id',
                                        'params' => array(':parent_id' => 0, ':orgchart_id' => $value4->id, ':course_id' => $value['id']),
                                    ));
                                    if (empty($orgchart44_check)) {
                                        $orgc = new OrgCourse;
                                        $orgc->orgchart_id = $value4->id;
                                        $orgc->course_id = $value['id'];
                                        $orgc->parent_id = 0;
                                        // $orgc->parent_id = $val->id;
                                        $orgc->active = 'y';
                                        $orgc->save();
                                    }

                                    $orgchart55 = OrgChart::model()->findAll(array(
                                        'condition' => 'parent_id=:parent_id',
                                        'params' => array(':parent_id' => $value4->id),
                                    ));

                                    if (!empty($orgchart55)) {
                                        foreach ($orgchart55 as $key5 => $value5) { // LEVEL 6
                                            $orgchart55_check = OrgCourse::model()->findAll(array(
                                                'condition' => 'parent_id=:parent_id AND orgchart_id=:orgchart_id AND course_id=:course_id',
                                                'params' => array(':parent_id' => 0, ':orgchart_id' => $value5->id, ':course_id' => $value['id']),
                                            ));
                                            if (empty($orgchart55_check)) {
                                                $orgc = new OrgCourse;
                                                $orgc->orgchart_id = $value5->id;
                                                $orgc->course_id = $value['id'];
                                                $orgc->parent_id = 0;
                                                // $orgc->parent_id = $value4->id;
                                                $orgc->active = 'y';
                                                $orgc->save();
                                            }

                                            $orgchart66 = OrgChart::model()->findAll(array(
                                                'condition' => 'parent_id=:parent_id',
                                                'params' => array(':parent_id' => $value5->id),
                                            ));

                                            if (!empty($orgchart66)) {
                                                foreach ($orgchart66 as $key6 => $value6) {
                                                    $orgchart66_check = OrgCourse::model()->findAll(array(
                                                        'condition' => 'parent_id=:parent_id AND orgchart_id=:orgchart_id AND course_id=:course_id',
                                                        'params' => array(':parent_id' => 0, ':orgchart_id' => $value6->id, ':course_id' => $value['id']),
                                                    ));
                                                    if (empty($orgchart66_check)) {
                                                        $orgc = new OrgCourse;
                                                        $orgc->orgchart_id = $value6->id;
                                                        $orgc->course_id = $value['id'];
                                                        $orgc->parent_id = 0;
                                                        // $orgc->parent_id = $value5->id;
                                                        $orgc->active = 'y';
                                                        $orgc->save();
                                                    }
                                                }
                                            } //6
                                        }
                                    } //5
                                }
                            } // 4
                        }
                    }

                }

                echo $_GET['id'];
                if (isset($value['children'])) {
                    foreach ($value['children'] as $key_children => $value_children) {
                        $orgc2 = OrgCourse::model()->findByPk($value_children['id']);
                        if ($orgc2) {
                            // $course_online = CourseOnline::model()->findByPk($orgc2->course_id);
                            // $orgc->course_id = $course_online->course_id;
                            $orgc2->parent_id = $orgc->id;
                            $orgc2->save();
                            // echo $value_children['id'];
                        } else {

                            $orgchart_checkkk2 = OrgCourse::model()->findAll(array(
                                'condition' => 'parent_id=:parent_id AND orgchart_id=:orgchart_id AND course_id=:course_id',
                                'params' => array(':parent_id' => $orgc->id, ':orgchart_id' => $_POST['org_id'], ':course_id' => $value_children['id']),
                            ));
                            if (empty($orgchart_checkkk2)) {

                                $orgc2 = new OrgCourse;
                                // $orgc->save();
                                // $course_online = CourseOnline::model()->findByPk($value['id']);
                                $orgc2->orgchart_id = $_POST['org_id'];
                                $orgc2->course_id = $value_children['id'];
                                $orgc2->parent_id = $orgc->id;
                                $orgc2->active = 'y';
                                $orgc2->save();
                            }
                        }
                    }
                }

            }

        } else {
            echo "Noooooooo";
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return OrgCourse the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = OrgCourse::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param OrgCourse $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'org-course-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
