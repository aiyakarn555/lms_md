<?php

class VideoController extends Controller{
    public function init()
 {
  parent::init();
  $this->lastactivity();
  
 }
    public function actionIndex(){


        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}
        $criteriavdo = new CDbCriteria;
        $criteriavdo->compare('active','y');
        if(isset($_POST["vdo_title"])){
        $criteriavdo->compare('vdo_title',$_POST["vdo_title"],true);
        }
        $criteriavdo->compare('lang_id',$langId);

        $criteriavdo->order = 'sortOrder ASC';

        if($_POST["sortvdo"] == 2){
        $criteriavdo->order = 'update_date ASC';
        }else if($_POST["sortvdo"] == 1) {
        $criteriavdo->order = 'update_date DESC';
        }

        $Video = Vdo::model()->findAll($criteriavdo);
//        var_dump($Vdo);        exit();
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
          	}

            $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));

            if(!$label){
                $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
            }
        
        $this->render('index',array(
            'Video'=>$Video,'label'=>$label,'textold'=>$_POST["vdo_title"],"sortvdo"=>$_POST["sortvdo"]
        ));
        
    }
    public function actionDetail($id)
	{
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$id = $_GET['id'];
		//vdo
		$video = Vdo::model()->findByAttributes(array(
//			'active'=>'y',
			'vdo_id'=>$id,
		));

		$name = Profile::model()->findByAttributes(array(
					'user_id'=>$video->create_by,
				));
                
               // var_dump($name->firstname);exit();
		
		$this->render('video-detail',array(
			'video_data'=>$video,
			'name'=>$name,
		));
	}

    public function actionLibrary()
    {
        if(Yii::app()->user->id){

            //2=DOC    1=Media

            // ทำ ค้นหา search
            if(isset($_GET["cate_1"]) && $_GET["cate_1"] != ""){
                $search_input = $_GET["cate_1"];

                $library_file_search = LibraryFile::model()->with('type')->findAll(array(
                'condition' => 't.active=:active AND type.library_cate=1 AND 
                ( (t.library_name LIKE :keyword) || (t.library_name_en LIKE :keyword) )
                ',
                'params' => array(':active' => 'y', ':keyword'=>"%$search_input%"),
                'order' => 't.sortOrder ASC'
            ));
            }elseif(isset($_GET["cate_2"]) && $_GET["cate_2"] != ""){
                $search_input = $_GET["cate_2"];

                $library_file_search = LibraryFile::model()->with('type')->findAll(array(
                'condition' => 't.active=:active AND type.library_cate=2 AND 
                ( (t.library_name LIKE :keyword) || (t.library_name_en LIKE :keyword) )
                ',
                'params' => array(':active' => 'y', ':keyword'=>"%$search_input%"),
                'order' => 't.sortOrder ASC'
            ));
            }else{
                $library_file_search = "";
            }

            // จบ ทำ ค้นหา search



            $library_file_1 = LibraryFile::model()->with('type')->findAll(array(
                'condition' => 't.active=:active AND type.library_cate=1',
                'params' => array(':active' => 'y'),
                'order' => 't.sortOrder ASC'
            ));
            $library_file_2 = LibraryFile::model()->with('type')->findAll(array(
                'condition' => 't.active=:active AND type.library_cate=2',
                'params' => array(':active' => 'y'),
                'order' => 't.sortOrder ASC'
            ));
            if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                $orders = "library_type_name_en ASC";
            }else{
                $orders = "library_type_name ASC";
            }
            $library_type_1 = LibraryType::model()->findAll(array(
                'condition' => 'active=:active AND library_cate=1',
                'params' => array(':active' => 'y'),
                'order' => $orders
            ));
             $library_type_2 = LibraryType::model()->findAll(array(
                'condition' => 'active=:active AND library_cate=2',
                'params' => array(':active' => 'y'),
                'order' => $orders
            ));
           
            if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                    $langId = Yii::app()->session['lang'] = 1;
            }else{
                    $langId = Yii::app()->session['lang'];
            }
            
            $label = MenuLibrary::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));

            if(!$label){
                $label = MenuLibrary::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
            }

            $this->render('library',array(
                'library_file_1'=>$library_file_1,
                'library_file_2'=>$library_file_2,
                'library_type_1'=>$library_type_1,
                'library_type_2'=>$library_type_2,
                'library_file_search'=>$library_file_search,
                'label'=>$label,
            ));

        }else{
            $this->redirect(array('site/index'));
        }
    }

    public function actionDownloadFile(){
        if(Yii::app()->user->id && isset($_POST['library'])){
            $library_model = LibraryFile::model()->findByPk($_POST['library']);
            if($library_model != ""){
                echo $this->createUrl('/uploads/LibraryFile/'.$library_model->library_filename);
                exit();
            }
            // var_dump($_POST['library']); exit();
        }
        echo "error";
    }
    public function actionDownloadRequest(){
        if(Yii::app()->user->id && isset($_POST['library'])){
            // var_dump($_POST['library']); exit();
            $LibraryRequest = LibraryRequest::model()->find(array(
                'condition' => 'active=:active AND user_id=:user_id AND library_id=:library_id',
                'params' => array(':active' => 'y', ':library_id'=>$_POST['library'], ':user_id'=>Yii::app()->user->id),
            ));
            if($LibraryRequest != ""){
                if($LibraryRequest->req_status == 1){ //รออนุมัติ -> ยกเลิกขอ
                    $LibraryRequest->active = 'n';
                    echo "cancel";
                }elseif($LibraryRequest->req_status == 2){ //ดาวโหลด
                    $library_model = LibraryFile::model()->findByPk($_POST['library']);                    
                    echo $this->createUrl('/uploads/LibraryFile/'.$library_model->library_filename);
                    exit();
                }elseif($LibraryRequest->req_status == 3){ //ปฏิเสธ -> ขอใหม่
                    $LibraryRequest->req_status = 1;
                    echo "request";
                }
            }else{
                $LibraryRequest = new LibraryRequest;
                $LibraryRequest->library_id = $_POST['library'];
                $LibraryRequest->user_id = Yii::app()->user->id;  
                echo "request";             
            }
            $LibraryRequest->save();
            exit(); 
        }
        echo "error";        
    }






    
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usability-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
?>