<?php

/**
 * CToggleColumn class file.
 *
 * @author Nikola Trifunovic <johonunu@gmail.com>
 * @link http://www.trifunovic.me/
 * @copyright Copyright &copy; 2012 Nikola Trifunovic
 * @license http://www.yiiframework.com/license/
 */
class ToggleAction extends CAction {
	 
    public function run($id,$attribute,$check) {
		
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model = $this->controller->loadModel($id);
            if(isset($model->user_id))
            {
                $modelUser = User::model()->findByPk($model->user_id);
            }
            
            if($check == 'shop')
            {
                $dataProvider = new CActiveDataProvider('OrderDetail',array(
                    'criteria'=>array(
                        'condition'=>' order_id = '.$model->order_id.' ',
                        'with'=>array('shops')
                )));
                $pointSum = 0;
                foreach($dataProvider->getData() as $i=>$result){
                    $pointSum = $result->shops->shop_point+$pointSum;
                }
                $model->$attribute = ($model->$attribute==0)?1:0;
                if($model->$attribute == 1){
                    $model->order_point = $pointSum;
                    $sumUserPoint = $modelUser->point_user + $model->order_point;
                }else{
                    $model->order_point = 0;
                    $CheckDelPoint = $modelUser->point_user - $pointSum;
                    if($CheckDelPoint < 0){
                        $sumUserPoint = 0;
                    }else{
                        $sumUserPoint = $CheckDelPoint;
                    }
                }
                $model->save(false);
                User::model()->updateByPk($model->user_id,array('point_user'=>$sumUserPoint));
            }
            else if($check == 'ordercourse')
            {
                $dataProvider = new CActiveDataProvider('OrderDetailcourse',array(
                    'criteria'=>array(
                        'condition'=>' order_id = '.$model->order_id.' ',
                        'with'=>array('courses')
                )));
                $pointSum = 0;
                foreach($dataProvider->getData() as $i=>$result){
                    $pointSum = $result->courses->course_point+$pointSum;
                }
                $model->$attribute = ($model->$attribute==0)?1:0;
                if($model->$attribute == 1){
                    $model->order_point = $pointSum;
                    $sumUserPoint = $modelUser->point_user + $model->order_point;
                }else{
                    $model->order_point = 0;
                    $CheckDelPoint = $modelUser->point_user - $pointSum;
                    if($CheckDelPoint < 0){
                        $sumUserPoint = 0;
                    }else{
                        $sumUserPoint = $CheckDelPoint;
                    }
                }
                $model->save(false);
                User::model()->updateByPk($model->user_id,array('point_user'=>$sumUserPoint));
            }
            else if($check == 'orderonline')
            {
                //Check Date Ext 60
                $dateTime = date("Y-m-d H:i:s",time());
                $dateExp = ClassFunction::expdate($dateTime,60);
                $dateCheck = date("Y-m-d H:i:s",$dateExp);

                //////////
                $dataProvider = new CActiveDataProvider('OrderDetailonline',array(
                    'criteria'=>array(
                        'condition'=>' order_id = '.$model->order_id.' ',
                        'with'=>array('courses')
                )));
                $pointSum = 0;
                foreach($dataProvider->getData() as $i=>$result){
                    $pointSum = $result->courses->course_point+$pointSum;
                }
                $model->$attribute = ($model->$attribute==0)?1:0;

                if($model->$attribute == 1)
                {
                    $model->date_expire = $dateCheck;
                    $model->order_point = $pointSum;
                    $sumUserPoint = $modelUser->point_user + $model->order_point;
                }
                else
                {
                    $model->date_expire = null;
                    $model->order_point = 0;
                    $CheckDelPoint = $modelUser->point_user - $pointSum;
                    if($CheckDelPoint < 0)
                    {
                        $sumUserPoint = 0;
                    }
                    else
                    {
                        $sumUserPoint = $CheckDelPoint;
                    }
                }
                $model->save(false);
                User::model()->updateByPk($model->user_id,array('point_user'=>$sumUserPoint));
            }
            else
            {
                $model->$attribute = ($model->$attribute==0)?1:0;
                $model->save(false);
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
 
}

?>
