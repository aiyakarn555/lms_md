<?php

class CourseOnlineController extends Controller
{
    public function init()
 {
  parent::init();
  $this->lastactivity();
  
 }
    //public $layout='//layouts/column2';
    //public $layout='//layouts/column2';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('view','cart','printpdf','point','guide'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('payment','paymentpoint','learn','learnvdo','renews','userbuy','index','download'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionPrintPDF($id)
    {
        $course_model = CourseOnline::model()->findByPk($id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        if(Helpers::lib()->CheckTestingPass($id,false,true) == true)
        {
            $CheckPasscoursCheck = Passcours::model()->find(array(
                'condition'=>'passcours_cours=:id AND passcours_user=:user AND gen_id=:gen_id',
                'params' => array(
                    ':id' => $id,
                    ':user' => Yii::app()->user->id, ':gen_id'=>$gen_id
                )
            ));
            if(!isset($CheckPasscoursCheck))
            {
                //////// Save PassCourseOnline //////////
                $modelPasscours = new Passcours;
                $modelPasscours->passcours_cours = $id;
                $modelPasscours->gen_id = $gen_id;
                $modelPasscours->passcours_user = Yii::app()->user->id;
                $modelPasscours->passcours_date = date("Y-m-d H:i:s");
                $modelPasscours->save();
            }
        }

        //$CheckPrint = Helpers::lib()->CheckTestingPassCourseOnline($id);
        $CheckPrint =  Helpers::lib()->CheckTestingPass($id,false,true);
        $CheckPasscours = Passcours::model()->find(array(
            'condition'=>'passcours_cours=:id AND passcours_user=:user AND gen_id=:gen_id',
            'params' => array(
                ':id' => $id,
                ':user' => Yii::app()->user->id, ':gen_id'=>$gen_id
            )
        ));

        ////////// Check Testing //////////
        if($CheckPrint == true && isset($CheckPasscours))
        {
            $mPDF1 = Yii::app()->ePdf->mpdf();
            $mPDF1->setDisplayMode('fullpage');
            $mPDF1->setAutoFont();
            $mPDF1->WriteHTML($this->renderPartial('PrintPDF', array('model'=>$CheckPasscours), true));
            $mPDF1->Output();
        }
        else
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }
    }

    public function actionCart($id=null,$cartdel = "add")
    {
        $cartCourse = Yii::createComponent(array(
            'class' => 'application.extensions.shopping.OShoppingCart'
        ));

        $cartCourse->init();

        if(Yii::app()->user->isGuest)
        {
            Yii::app()->user->setFlash('loginMessage',"กรุณา Login ด้วยครับ");
            $this->redirect(array('/user/login'));
        }

        if(isset($id))
        {
            $cartCourse->clear();
            $course = CourseOnline::model()->findByPk($id);
            if($course)
            {
                $cartCourse->remove($course->getId());

                if($cartdel == "add")
                {
                    Yii::app()->user->setState('getReturn', $course->cate_id);
                    Yii::app()->user->setFlash('BuyCart','สั่งซื้ออบรมออนไลน์เรียบร้อย');
                    //Yii::app()->shoppingCart->put($course,1);
                    $cartCourse->put($course);
                }
                else
                {
                    Yii::app()->user->setFlash('BuyCart','ลบหลักสูตรอบรมออนไลน์เรียบร้อย');
                    //Yii::app()->shoppingCart->remove($course->getId());
                    $cartCourse->remove($course->getId());
                }
            }
            $this->redirect(array('cart'));
        }

        $count = $cartCourse->getItemsCount();
        $CheckCourse = $cartCourse->getPositions();
        $cost = $cartCourse->getCost();

        $this->render('cart',array('CheckCourse'=>$CheckCourse,'cost'=>$cost,'count'=>$count));
    }

    public function actionPayment()
    {
        $cartCourse = Yii::createComponent(array('class' => 'application.extensions.shopping.OShoppingCart'));
        $cartCourse->init();

        $countItem = $cartCourse->getCount();
        if($countItem == 0)
        {
            Yii::app()->user->setFlash('BuyCart', "ไม่มีสินค้าในตะกร้า");
            $this->redirect(array('cart'));
        }
        else
        {
            $cost = $cartCourse->getCost(); // Sum Price
            $countNum = $cartCourse->getCount(); // // Count Num
            $countAll = $cartCourse->getItemsCount(); // Count Item All
            $userObject = Yii::app()->getModule('user')->user();
            //$point = $userObject->getPoint(); Price User No

            $orderModel = new Orderonline;
            $orderModel->user_id = $userObject->id;
            $orderModel->order_cost = $cost;
            $orderModel->order_countnum = $countNum;
            $orderModel->order_countall = $countAll;
            $orderModel->save();

            $positions = $cartCourse->getPositions(); // Loop Save
            foreach($positions as $cartShopping)
            {
                // Delete Learn
                $lessonModel = Lesson::model()->findAll(array(
                    'condition'=>'course_id=:course_id',
                        'params'=>array(':course_id'=>$cartShopping->id)
                ));
                foreach ($lessonModel as $key => $value){
                    $user = Yii::app()->getModule('user')->user();
                    $learnLesson = $user->learns(
                        array(
                            'condition'=>'lesson_id=:lesson_id',
                            'params' => array(':lesson_id' => $value->id)
                        )
                    );
                    //tblReturn
                    tblReturn::model()->deleteAllByAttributes(array(
                        'lesson_id'=>$cartShopping->id,
                        'user_id'=>Yii::app()->user->id
                    ));
                    if($value->fileCount != 0 && $learnLesson){
                        $lesson_model = Lesson::model()->findByPk($value->id);
                        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);
                        $lessonModel = Learn::model()->findAll(array(
                            'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND gen_id=:gen_id',
                                'params'=>array(':lesson_id'=>$value->id,':user_id'=>Yii::app()->user->id, ':gen_id'=>$gen_id)
                        ));
                        foreach ($lessonModel as $keylesson => $valuelesson) {
                            LearnFile::model()->deleteAllByAttributes(array(
                                'learn_id'=>$valuelesson->learn_id,
                                'user_id_file'=>Yii::app()->user->id,
                                'gen_id'=>$gen_id
                            ));
                        }
                        Learn::model()->deleteAllByAttributes(array(
                            'lesson_id'=>$value->id,
                            'user_id'=>Yii::app()->user->id,
                            'gen_id'=>$gen_id
                        ));
                        //Log
                        Logques::model()->deleteAllByAttributes(array(
                            'lesson_id'=>$value->id,
                            'user_id'=>Yii::app()->user->id,
                            'gen_id'=>$gen_id
                        ));
                        Logchoice::model()->deleteAllByAttributes(array(
                            'lesson_id'=>$value->id,
                            'user_id'=>Yii::app()->user->id,
                            'gen_id'=>$gen_id
                        ));
                        //Score
                        Score::model()->deleteAllByAttributes(array(
                            'lesson_id'=>$value->id,
                            'user_id'=>Yii::app()->user->id,
                            'gen_id'=>$gen_id
                        ));
                    }
                }
                $orderDetailModel = new OrderDetailonline;
                $orderDetailModel->order_id = $orderModel->order_id;
                $orderDetailModel->shop_id = $cartShopping->id;
                $orderDetailModel->price = $cartShopping->price;
                $orderDetailModel->count = $cartShopping->getQuantity();
                $orderDetailModel->save();
            }
            $userObject->removePoint($cost);
            $userObject->removePoint($countNum);
            $userObject->removePoint($countAll);
            $cartCourse->clear();

            Yii::app()->user->setFlash('BuyCart', "ยืนยันการสั่งซื้อหลักสูตรอบรมออนไลน์เรียบร้อย");
            $this->redirect(array('//orderonline/index'));
        }
    }

    //Point
    public function actionPoint($id=null,$cartdel = "add")
    {
        $cartCourse = Yii::createComponent(array('class' => 'application.extensions.shopping.PShoppingCart'));
        $cartCourse->init();

        if(Yii::app()->user->isGuest)
        {
            Yii::app()->user->setFlash('loginMessage',"กรุณา Login ด้วยครับ");
            $this->redirect(array('/user/login'));
        }

        if(isset($id)){
            $course = CourseOnline::model()->findByPk($id);
            if($course){
                $cartCourse->remove($course->getId());
                if($cartdel == "add"){
                    Yii::app()->user->setState('getReturn', $course->cate_id);
                    Yii::app()->user->setFlash('BuyCart','สั่งซื้ออบรมออนไลน์เรียบร้อย');
                    //Yii::app()->shoppingCart->put($course,1);
                    $cartCourse->put($course);
                }else{
                    Yii::app()->user->setFlash('BuyCart','ลบหลักสูตรอบรมออนไลน์เรียบร้อย');
                    //Yii::app()->shoppingCart->remove($course->getId());
                    $cartCourse->remove($course->getId());
                }
            }
            $this->redirect(array('point'));
        }

        $count = $cartCourse->getItemsCount();
        $CheckCourse = $cartCourse->getPositions();
        $cost = $cartCourse->getCost();

        $this->render('point',array('CheckCourse'=>$CheckCourse,'cost'=>$cost,'count'=>$count));
    }

    public function actionPaymentPoint()
    {
        $cartCourse = Yii::createComponent(array('class' => 'application.extensions.shopping.PShoppingCart'));
        $cartCourse->init();

        $countItem = $cartCourse->getCount();
        if($countItem == 0)
        {
            Yii::app()->user->setFlash('BuyCart', "ไม่มีสินค้าในตะกร้า");
            $this->redirect(array('point'));
        }
        else
        {
            $cost = $cartCourse->getCost(); // Sum Price

            $countNum = $cartCourse->getCount(); // // Count Num
            $countAll = $cartCourse->getItemsCount(); // Count Item All
            $userObject = Yii::app()->getModule('user')->user();
            //$point = $userObject->getPoint(); Price User No

            $orderModel = new Orderonline;
            $orderModel->user_id = $userObject->id;
            $orderModel->order_cost = $cost;
            $orderModel->order_countnum = $countNum;
            $orderModel->order_countall = $countAll;
            $orderModel->save();

            $positions = $cartCourse->getPositions(); // Loop Save
            foreach($positions as $cartShopping)
            {
                // Delete Learn
                $lessonModel = Lesson::model()->findAll(array(
                    'condition'=>'course_id=:course_id',
                        'params'=>array(':course_id'=>$cartShopping->id)
                ));
                foreach ($lessonModel as $key => $value){
                    $user = Yii::app()->getModule('user')->user();
                    $learnLesson = $user->learns(
                        array(
                            'condition'=>'lesson_id=:lesson_id',
                            'params' => array(':lesson_id' => $value->id)
                        )
                    );
                    //tblReturn
                    tblReturn::model()->deleteAllByAttributes(array(
                        'lesson_id'=>$cartShopping->id,
                        'user_id'=>Yii::app()->user->id
                    ));
                    if($value->fileCount != 0 && $learnLesson){
                        $lesson_model = Lesson::model()->findByPk($value->id);
                        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);
                        $lessonModel = Learn::model()->findAll(array(
                            'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND gen_id=:gen_id',
                                'params'=>array(':lesson_id'=>$value->id,':user_id'=>Yii::app()->user->id, ':gen_id'=>$gen_id)
                        ));
                        foreach ($lessonModel as $keylesson => $valuelesson) {
                            LearnFile::model()->deleteAllByAttributes(array(
                                'learn_id'=>$valuelesson->learn_id,
                                'user_id_file'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                            ));
                        }
                        Learn::model()->deleteAllByAttributes(array(
                            'lesson_id'=>$value->id,
                            'user_id'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                        ));
                        //Log
                        Logques::model()->deleteAllByAttributes(array(
                            'lesson_id'=>$value->id,
                            'user_id'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                        ));
                        Logchoice::model()->deleteAllByAttributes(array(
                            'lesson_id'=>$value->id,
                            'user_id'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                        ));
                        //Score
                        Score::model()->deleteAllByAttributes(array(
                            'lesson_id'=>$value->id,
                            'user_id'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                        ));
                    }
                }
                $orderDetailModel = new OrderDetailonline;
                $orderDetailModel->order_id = $orderModel->order_id;
                $orderDetailModel->shop_id = $cartShopping->id;
                $orderDetailModel->price = $cartShopping->price;
                $orderDetailModel->count = $cartShopping->getQuantity();
                $orderDetailModel->save();
            }
            $userObject->removePoint($cost);
            $userObject->removePoint($countNum);
            $userObject->removePoint($countAll);
            $cartCourse->clear();

            Yii::app()->user->setFlash('BuyCart', "ยืนยันการสั่งซื้อหลักสูตรอบรมออนไลน์เรียบร้อย");
            $this->redirect(array('//orderonline/index'));
        }
    }

    public function actionLearn($id)
    {
        $model = Lesson::model()->findByPk($id);
        $gen_id = $model->CourseOnlines->getGenID($model->course_id);
        if(Helpers::lib()->CheckBuyItem($model->course_id,false) == true && ! Helpers::isPretestState($id))
        {
            $learn_id = "";
            if($model->count() > 0)
            {
                $user = Yii::app()->getModule('user')->user();
                $learnModel = Learn::model()->find(array(
                    'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND gen_id=:gen_id',
                    'params'=>array(':lesson_id'=>$id,':user_id'=>$user->id, ':gen_id'=>$gen_id)
                ));
                if(!$learnModel)
                {
                    $learnLog = new Learn;
                    $learnLog->user_id = $user->id;
                    $learnLog->gen_id = $gen_id;
                    $learnLog->lesson_id = $id;
                    $learnLog->learn_date = new CDbExpression('NOW()');
                    $learnLog->save();
                    $learn_id = $learnLog->learn_id;
                }
                else
                {
                    $learnModel->learn_date = new CDbExpression('NOW()');
                    $learnModel->save();
                    $learn_id = $learnModel->learn_id;
                }
            }

            $this->render('learn',array(
                'model'=>$model,
                'learn_id'=>$learn_id,
            ));
        }
        else
        {
            Yii::app()->user->setFlash('CheckQues', array('msg'=>'เกิดข้อผิดพลาด','class'=>'error'));
            $this->redirect(array('//courseOnline/index','id'=>Yii::app()->user->getState('getLesson')));
        }
    }

    public function actionLearnVdo($id,$learn_id)
    {
        $model=File::model()->findByPk($id);
        $learn_model = Learn::model()->findByPk($learn_id);
        $gen_id = $learn_model->LessonMapper->CourseOnlines->getGenID($learn_model->LessonMapper->course_id);
        if($model->count() > 0){
            //$user = Yii::app()->getModule('user')->user();
            $learnVdoModel = LearnFile::model()->find(array(
                'condition'=>'file_id=:file_id AND learn_id=:learn_id AND gen_id=:gen_id',
                'params'=>array(':file_id'=>$id,':learn_id'=>$learn_id, ':gen_id'=>$gen_id)
            ));

            if(empty($learnVdoModel))
            {
                $learnLog = new LearnFile;
                $learnLog->learn_id = $learn_id;
                $learnLog->gen_id = $gen_id;
                $learnLog->user_id_file = Yii::app()->user->id;
                $learnLog->file_id = $id;
                $learnLog->learn_file_date = new CDbExpression('NOW()');
                $learnLog->learn_file_status = "l";
                $learnLog->save();

                $att['no']      = $id;
                $att['image']   = CHtml::image(Yii::app()->baseUrl.'/images/icon_checklost.png', 'เรียนยังไม่ผ่าน', array(
                  'title' => 'เรียนยังไม่ผ่าน',
                  'style' => 'margin-bottom: 8px;',
                ));

                echo json_encode($att);
            }
            else
            {
                $learnVdoModel->learn_file_date = new CDbExpression('NOW()');

                if($_GET['status'] == 'success' || $learnVdoModel->learn_file_status == 's')
                {
                    $learnVdoModel->learn_file_status = 's';

                    $att['no']      = $id;
                    $att['image']   = CHtml::image(Yii::app()->baseUrl.'/images/icon_checkpast.png', 'ผ่าน', array(
                      'title' => 'ผ่าน',
                      'style' => 'margin-bottom: 8px;',
                    ));

                    echo json_encode($att);
                }else if($_GET['slide_number'] != ''){
                    $learnVdoModel->learn_file_status = $_GET['slide_number'];
                }else{
                    $att['no']      = $id;
                    $att['image']   = CHtml::image(Yii::app()->baseUrl.'/images/icon_checklost.png', 'เรียนยังไม่ผ่าน', array(
                      'title' => 'เรียนยังไม่ผ่าน',
                      'style' => 'margin-bottom: 8px;',
                    ));

                    echo json_encode($att);
                }

                $learnVdoModel->save();

                // start update lesson status pass
                $lesson = Lesson::model()->findByPk($model->lesson_id);
                if($lesson){
                    $user = Yii::app()->getModule('user')->user();
                    $lessonStatus = Helpers::lib()->checkLessonPass($lesson);
                    $learnLesson = $user->learns(
                        array(
                            'condition' => 'lesson_id=:lesson_id AND gen_id=:gen_id',
                            'params' => array(':lesson_id' => $lesson->id, ':gen_id'=>$gen_id)
                        )
                    );

                    $learn = Learn::model()->findByPk($learnLesson[0]->learn_id);
                    $learn->lesson_status = $lessonStatus;
                    $learn->save();

                    $cateStatus = Helpers::lib()->checkCategoryPass($lesson->CourseOnlines->cate_id);
                    if($cateStatus == "pass"){
                        $passCoursModel = Passcours::model()->findByAttributes(array(
                            'passcours_cours'=>$lesson->course_id,
                            'gen_id'=>$gen_id,
                            'passcours_user'=>Yii::app()->user->id
                        ));
                        if(!$passCoursModel){
                            $modelPasscours = new Passcours;
                            $modelPasscours->passcours_cates = $lesson->CourseOnlines->cate_id;
                            $modelPasscours->passcours_cours = $lesson->course_id;
                            $modelPasscours->gen_id = $gen_id;
                            $modelPasscours->passcours_user = Yii::app()->user->id;
                            $modelPasscours->passcours_date = date("Y-m-d H:i:s");
                            $modelPasscours->save();
                        }
                    }
                }


                // end update lesson status pass

            }
        }
    }

    public function actionReNews($id)
    {
        // เช็คว่าเคยเรียนใหม่แล้วหรือยัง
        $countReturn = tblReturn::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
            "lesson_id"=>$id,"user_id"=>Yii::app()->user->id
        ));
        if($countReturn < 1)
        {
            //เอา ID ไปหาบทเรียนว่ามีบทอะไรบ้าง
            $lessonModel = Lesson::model()->findAll(array(
                'condition'=>'course_id=:course_id',
                'params'=>array(':course_id'=>$id)
            ));
            $scoreCheck = 0;
            $PassLearnCout = 0;
            foreach ($lessonModel as $key => $value)
            {
                $lessonStatus = Helpers::lib()->checkLessonPass($value);
                $scoreSum = Helpers::lib()->ScorePercent($value->id);
                if(!empty($scoreSum))
                    $CheckSumOK = $scoreSum;
                else
                    $CheckSumOK = 0;

                $scoreCheck = $scoreCheck+$CheckSumOK;

                if(Helpers::lib()->CheckTestCount($lessonStatus,$value->id,false,false) == true){
                    $PassLearnCout = $PassLearnCout+1;
                }
            }

            if(count($lessonModel) == true)
            {
                if($PassLearnCout == count($lessonModel))
                {
                    $CheckRename = Helpers::lib()->CheckBuyItem($id);

                    //+15 Day
                    if($CheckRename == true)
                    {
                        $modelUpdate = Orderonline::model()->with('OrderDetailonlines')->find(array(
                            'order' => ' OrderDetailonlines.order_detail_id DESC ',
                            'condition'=>' OrderDetailonlines.shop_id="'.$id.'" AND OrderDetailonlines.active="y" ',
                        ));
                        $PlusDate = Helpers::lib()->PlusDate($modelUpdate->date_expire,15);
                        Orderonline::model()->updateByPk($modelUpdate->order_id,array("date_expire"=> $PlusDate));
                    }

                    $model = new tblReturn;
                    if(isset($id))
                    {
                        $model->user_id = Yii::app()->user->id;
                        $model->lesson_id = $id;
                        $model->save();

                        // Delete Learn
                        $lessonModel = Lesson::model()->findAll(array(
                            'condition'=>'course_id=:course_id',
                                'params'=>array(':course_id'=>$id)
                        ));

                        foreach ($lessonModel as $key => $value)
                        {
                            $user = Yii::app()->getModule('user')->user();
                            $learnLesson = $user->learns(
                                array(
                                    'condition'=>'lesson_id=:lesson_id AND gen_id=:gen_id',
                                    'params' => array(':lesson_id' => $value->id, ':gen_id'=>$gen_id)
                                )
                            );
                            if($value->fileCount != 0 && $learnLesson){
                                $lessonModel = Learn::model()->findAll(array(
                                    'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND gen_id=:gen_id',
                                        'params'=>array(':lesson_id'=>$value->id,':user_id'=>Yii::app()->user->id, ':gen_id'=>$gen_id)
                                ));
                                foreach ($lessonModel as $keylesson => $valuelesson) {
                                    LearnFile::model()->deleteAllByAttributes(array(
                                        'learn_id'=>$valuelesson->learn_id,
                                        'user_id_file'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                                    ));
                                }
                                Learn::model()->deleteAllByAttributes(array(
                                    'lesson_id'=>$value->id,
                                    'user_id'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                                ));
                                //Log
                                Logques::model()->deleteAllByAttributes(array(
                                    'lesson_id'=>$value->id,
                                    'user_id'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                                ));
                                Logchoice::model()->deleteAllByAttributes(array(
                                    'lesson_id'=>$value->id,
                                    'user_id'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                                ));
                                //Score
                                Score::model()->deleteAllByAttributes(array(
                                    'lesson_id'=>$value->id,
                                    'user_id'=>Yii::app()->user->id, 'gen_id'=>$gen_id
                                ));
                            }
                        }
                        Yii::app()->user->setFlash('CheckQues', array('msg'=>'สามารถเรียนใหม่ได้แล้ว','class'=>'success'));
                    }
                }else{
                    Yii::app()->user->setFlash('CheckQues', array('msg'=>'เกิดข้อผิดพลาด','class'=>'error'));
                }
            }else{
                Yii::app()->user->setFlash('CheckQues', array('msg'=>'เกิดข้อผิดพลาด','class'=>'error'));
            }
        }else{
            Yii::app()->user->setFlash('CheckQues', array('msg'=>'คุณได้ทำการขอเรียนใหม่ไปแล้ว','class'=>''));
        }
        $this->redirect(array('//courseOnline/userbuy'));
    }


    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionIndex($id)
    {
        $modelCategory = CateOnline::model()->findByPk($id);

        if(isset($modelCategory) && $modelCategory != null)
        {
            $lessonCount=new CActiveDataProvider('CourseOnline',array(
                'criteria'=>array(
                    'with'=>'lessonCount',
                ),
            ));

            $model=new CourseOnline('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['CourseOnline']))
                $model->attributes=$_GET['CourseOnline'];

            Yii::app()->user->setState('getLesson', $id);
            $this->render('index',array(
                'model'=>$model,
                'lessonCount'=>$lessonCount,
                'pk'=>$id
            ));
        }
        else
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }

    }

    public function actionGuide()
    {
        $ImgslideCourse = ImgslideCourse::model()->findAll();

        $lessonCount=new CActiveDataProvider('CourseOnline',array(
            'criteria'=>array(
                'with'=>'lessonCount',
            ),
        ));
        $model=new CourseOnline('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CourseOnline']))
            $model->attributes=$_GET['CourseOnline'];

        $this->render('guide',array(
            'model'=>$model,
            'lessonCount'=>$lessonCount,
            'ImgslideCourse'=>$ImgslideCourse
        ));
    }

    public function actionUserbuy($id=null)
    {
        $lessonCount=new CActiveDataProvider('CourseOnline',array(
            'criteria'=>array(
                'with'=>'lessonCount',
            ),
        ));
        $model=new CourseOnline('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CourseOnline']))
            $model->attributes=$_GET['CourseOnline'];

        Yii::app()->user->setState('getLesson', $id);

        $this->render('userbuy',array(
            'model'=>$model,
            'lessonCount'=>$lessonCount,
            'pk'=>$id
        ));
    }

    public function actionDownload($id)
    {
        $fileDoc = FileDoc::model()->findByPK($id);
        if($fileDoc){
            $webroot = Yii::app()->getUploadPath('filedoc');
            $uploadDir = $webroot;
            $filename = $fileDoc->filename;
            $filename = $uploadDir.$filename;
            // var_dump($filename);
            // exit;
            if (file_exists($filename)) {
                return Yii::app()->request->sendFile($fileDoc->file_name, file_get_contents($filename));
            }else{
                throw new CHttpException(404, 'The requested page does not exist.');
            }

        }else{
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function loadModel($id)
    {
        $model=CourseOnline::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='course-online-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
