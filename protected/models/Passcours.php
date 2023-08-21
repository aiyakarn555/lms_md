<?php

class Passcours extends AActiveRecord
{
	public $user_name;
	public $cours_name;
	public $cate_title;
	public $list_print;
	public $generation;
	public $search;
	public $period_start;
	public $period_end;
        public $cate_id;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{passcours}}';
	}

	public function beforeSave()
	{
		if($this->isNewRecord){
			$start = date("Y")."-01-01 00:00:00";
			$last = date("Y")."-12-31 23:59:59";
			$model_find = PasscourseNumber::model()->find(array(
				'condition' => 'course_id=:course_id AND (created_date<=:last) AND (created_date>=:start)',
				'params' => array(':course_id'=>$this->passcours_cours, ':start'=>$start, ':last'=>$last,),
				'order' => 'id DESC',
				// 'order' => 'created_date DESC',
			));
			if($model_find != ""){
				$run_number = sprintf('%04d', $model_find->code_number+1);
				$id_before = $model_find->id;
			}else{
				$run_number = sprintf('%04d',"1");
				$id_before = 0;
			}

			$model_number = new PasscourseNumber;
			// $model_number->passcourse_id = $this->passcours_id;
			$model_number->course_id = $this->passcours_cours;
			$model_number->gen_id = $this->gen_id;
			$model_number->user_id = $this->passcours_user;
			$model_number->code_number = $run_number;
			$model_number->passcourse_id = $id_before;
			$model_number->save();

			$user_id = base64_encode($this->passcours_user);
			$course_id = base64_encode($this->passcours_cours);
			$gen_id = base64_encode($this->gen_id);
			$name = $this->passcours_user."_".$this->passcours_cours."_".$this->gen_id;
			
			Yii::import('ext.qrcode.QRCode');
			$code=new QRCode("http://thorconn.com/site/ShowCer?user=".$user_id."&course=".$course_id."&gen=".$gen_id);
			$code->create('uploads/qrcode_cer/'.$name.'.png');
		}

		return parent::beforeSave();
	}


	public function rules()
	{
		return array(
			array('passcours_cours, passcours_user', 'numerical', 'integerOnly'=>true),
			array('passcours_date, user_name, cours_name, news_per_page', 'safe'),
			array('cate_title, cours_name, user_name, passcours_id, passcours_cours,passcours_cates, passcours_user, passcours_date, gen_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Profiles'=>array(self::BELONGS_TO, 'Profile', 'passcours_user'),
			'CourseOnlines'=>array(self::BELONGS_TO, 'CourseOnline', 'passcours_cours'),
			'Category'=>array(self::BELONGS_TO, 'Category', 'passcours_cates'),
			'user'=>array(self::BELONGS_TO, 'User', 'passcours_user'),
			'Period' => array(self::HAS_MANY, 'CoursePeriod', array( 'id_course' => 'passcours_cours' )),
		);
	}

	public function attributeLabels()
	{
		return array(
			'passcours_id' => 'Passcours',
			'passcours_cours' => 'ชื่อหลักสูตร',
			'passcours_cates' => 'ชื่อหลักสูตร',
			'passcours_user' => 'ชื่อผู้อบรม',
			'passcours_date' => 'วันที่สอบผ่าน',
			'gen_id' => 'gen_id',
		);
	}

	public function highsearch() {
		$criteria = new CDbCriteria;
		//join with relations
		$criteria->with = array('Profiles', 'CourseOnlines', 'user');

		//search text
		if(isset($this->search) && $this->search != null) {
			$criteria->compare('Profiles.firstname', $this->search, true);
			$criteria->compare('Profiles.lastname', $this->search, true, 'OR');
			$criteria->compare('user.bookkeeper_id', $this->search, true, 'OR');
		}

                //check course category type
		if(isset($this->cate_id) && $this->cate_id != null) {
			$criteria->compare('courseonline.cate_id', $this->cate_id, false, 'AND');
		}
                
		//check generation
		if(isset($this->generation) && $this->generation != null) {
			$criteria->compare('Profiles.generation', $this->generation, true, 'OR');
		}

		//check course id
		if(isset($this->passcours_cours) && $this->passcours_cours != null) {
			$criteria->addInCondition('passcours_cours', $this->passcours_cours, 'AND');
		}

		if(isset($this->gen_id) && $this->gen_id != null) {
			$criteria->addInCondition('gen_id', $this->gen_id, 'AND');
		}

		//check period start - end
		if(isset($this->period_start) && $this->period_start != null) {
			$criteria->addCondition('passcours_date >= "' . date('Y-m-d 00:00:00', strtotime($this->period_start)) . '"');
		}
		if(isset($this->period_end) && $this->period_end != null) {
			$criteria->addCondition('passcours_date <= "' . date('Y-m-d 23:59:59', strtotime($this->period_end)) . '"');
		}

		//provider array
		$poviderArray = array(
				'criteria' => $criteria
			);

		// Page
		if(isset($this->news_per_page)) {
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		//return
		return new CActiveDataProvider($this, $poviderArray);
	}

	public function search() {

		$criteria=new CDbCriteria;
		$criteria->with=array('Profiles','CourseOnlines');

		if (!empty($this->user_name)) {
			$criteria->addSearchCondition( 'CONCAT( Profiles.firstname, " ", Profiles.lastname )', $this->user_name);
		} else {
			$criteria->compare('Profiles.firstname', $this->user_name, true);
		}

		if (!empty($this->passcours_date)) {
			$criteria->compare('passcours_date', ClassFunction::DateSearch($this->passcours_date), true);
		}

		$criteria->compare('course_title', $this->cours_name, true);
		$criteria->compare('passcours_id', $this->passcours_id, true);
		$criteria->compare('gen_id', $this->gen_id, true);


		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page)) {
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

    public function getNameUser() 
    {
        return $this->Profiles->firstname.' '.$this->Profiles->lastname;
    } 

	public function getSaveFile()
	{
		echo CHtml::link('บันทึก', array('//Passcours/SaveFile',
			'id' => $this->passcours_cours,
			'user' => $this->passcours_user,
		),array(
			'class' => 'btn btn-primary',
			'target' => '_blank',
			'download' => 'PDF File',
			'disabled' => true,
			'onclick' => 'return false',
		)); 
	}

	public function getPrintCertificate() {
		//set variable
		$CourseSpecialType = $this->CourseOnlines->cates->special_category;
		$CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($CourseSpecialType === 'y') {
			$CertificateType = 'cpd';
		}
		//generate button
		echo CHtml::link('พิมพ์', 'javascript:void(0)', array(
				'submit' => array('//Passcours/Certificate/'),
				'params' => array(
					'CourseId' => $this->passcours_cours,
					'UserId' => $this->passcours_user,
					'CertificateType' => $CertificateType,
				),
				'target' => '_blank',
				'class' => 'btn btn-warning',
			));
	} 
        
        public function getPrintCertificatecpd() {
		//set variable
		$CourseSpecialType = $this->CourseOnlines->cates->special_category;
		$CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($CourseSpecialType === 'y') {
			$CertificateType = 'cpd';
		}
		//generate button
		echo CHtml::link('พิมพ์', 'javascript:void(0)', array(
				'submit' => array('//PassCpd/Certificate/'),
				'params' => array(
					'CourseId' => $this->passcours_cours,
					'UserId' => $this->passcours_user,
					'CertificateType' => $CertificateType,
				),
				'target' => '_blank',
				'class' => 'btn btn-warning',
			));
	} 
        
        public function getDownloadIDCard() {
		
		//check if this course is special (for cpd certificate)
		if($this->user->pic_cardid != '') {
			$idcard = $this->user->pic_cardid;
		//generate button
                $id_user = $this->user->id;
                $file = Yush::getUrl($this->user, Yush::SIZE_THUMB, $idcard);
//                var_dump($file) ;
		echo CHtml::link('Download', $file, array(
                                'download' => $id_user,
//				'submit' => array('//Passcours/Certificate/'),
//				'params' => array(
//					'CourseId' => $this->passcours_cours,
//					'UserId' => $this->passcours_user,
//					'CertificateType' => $CertificateType,
//				),
				'target' => '_blank',
				'class' => 'btn btn-warning',
			));
                }else{
                    echo '-';
                }

	} 

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'passcours',
		    	'order' => ' passcours.passcours_id DESC ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'passcours',
		    	'order' => ' passcours.passcours_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Passcours.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'passcourscheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'passcourscheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'passcourscheck'=>array(
				    	'alias' => 'passcours',
				    	'order' => ' passcours.passcours_id DESC ',
		            ),
			    );
			}
		}

		return $scopes;
    }

	// public function defaultScope()
	// {
	//     $defaultScope =  $this->checkScopes('defaultScope');

	// 	return $defaultScope;
	// }

	public function PrintFileStatic() {

		$sql = " select * from tbl_passcours_log";

		//check period start - end
		if(isset($this->period_start) && $this->period_start != null) {
			$sql .= ' where pclog_date >= "' . date('Y-m-d 00:00:00', strtotime($this->period_start)) . '"';
		}
		if(isset($this->period_end) && $this->period_end != null) {
			$sql .= ' and pclog_date <= "' . date('Y-m-d 23:59:59', strtotime($this->period_end)) . '"';
		}

		$query = Yii::app()->db->createCommand($sql)->queryAll();

        return new CArrayDataProvider($query, $poviderArray);

	}
}
