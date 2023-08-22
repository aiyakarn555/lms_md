<?php

class Passcours extends AActiveRecord
{
	public $user_name;
	public $cours_name;
	public $cate_title;
	public $list_print;
	public $generation;
	public $memtype;
	public $search;
	public $period_start;
	public $period_end;
    public $cate_id;
    public $page_false;
    public $division_id;
    public $department;
    public $position;
    public $station;
    public $type_register;
    public $gen_id;

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
			$code->create(Yii::app()->basePath.'/../../uploads/qrcode_cer/'.$name.'.png');
		}

		return parent::beforeSave();
	}



	public function rules()
	{
		return array(
			array('passcours_cours', 'required'),
			array('passcours_cours, passcours_user', 'numerical', 'integerOnly'=>true),
			array('passcours_date, user_name, cours_name, news_per_page,page_false', 'safe'),
			array('cate_title, cours_name, user_name, passcours_id, passcours_cours,passcours_cates, passcours_user, passcours_date,division_id,department, position,station,type_register, gen_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Profiles'=>array(self::BELONGS_TO, 'Profiles', 'passcours_user'),
			'profile'=>array(self::BELONGS_TO, 'profile', 'passcours_user'),
			'CourseOnlines'=>array(self::BELONGS_TO, 'CourseOnline', 'passcours_cours'),
			'Category'=>array(self::BELONGS_TO, 'Category', 'passcours_cates'),
			'user'=>array(self::BELONGS_TO, 'User', 'passcours_user'),
			'register'=>array(self::BELONGS_TO, 'RegistrationForm', 'passcours_user'),
			'Period' => array(self::HAS_MANY, 'CoursePeriod', array( 'id_course' => 'passcours_cours' )),
			'gen'=>array(self::BELONGS_TO, 'CourseGeneration', 'gen_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'passcours_id' => 'Passcours',
			'passcours_cours' => 'ชื่อหลักสูตร (บังคับ)',
			'passcours_cates' => 'ชื่อหลักสูตร',
			'passcours_user' => 'ชื่อผู้อบรม',
			'passcours_date' => 'วันที่สอบผ่าน',
			'generation' => 'เลือกรุ่น',
			'search' => 'ชื่อ – นามสกุล',
			'period_start' => 'วันที่เริ่มต้น',
			'period_end' => 'วันที่สิ้นสุด',
			'division_id' => 'ฝ่าย',
			'department' => 'ฝ่าย',
			'position' => 'แผนก',
			'station' => 'สถานี',
			'type_register' => 'ประเภทพนักงาน',
			'gen_id' => 'รุ่น (บังคับ)'

		);
	}

	public function highsearch() {

		$criteria = new CDbCriteria;

		$criteria->with = array('Profiles', 'CourseOnlines', 'user');

		//search text
		// if(isset($this->search) && $this->search != null) {
		// 	$criteria->compare('Profiles.firstname', $this->search, true);
		// 	$criteria->compare('Profiles.lastname', $this->search, true, 'OR');
		// 	$criteria->compare('user.bookkeeper_id', $this->search, true, 'OR');
		// }

		if(isset($this->search) && $this->search != null){
			// var_dump($this->search); exit();
        	$ex_fullname = explode(" ", $this->search);

        	if(isset($ex_fullname[0])){
        		$pro_fname = $ex_fullname[0];
        		$criteria->compare('Profiles.firstname_en', $pro_fname, true);
        		$criteria->compare('Profiles.lastname_en', $pro_fname, true, 'OR');

        		$criteria->compare('Profiles.firstname', $pro_fname, true, 'OR');
        		$criteria->compare('Profiles.lastname', $pro_fname, true, 'OR');
        	}
        	
        	if(isset($ex_fullname[1])){
        		$pro_lname = $ex_fullname[1];
        		$criteria->compare('Profiles.lastname',$pro_lname,true);
        		$criteria->compare('Profiles.lastname_en', $pro_lname, true, 'OR');
        	}
        }

        $criteria->compare('superuser',0);
		$criteria->addCondition('user.id IS NOT NULL');

        //check course id
		if(isset($this->passcours_cours) && $this->passcours_cours != null) {
			// var_dump($this->passcours_cours); exit();
			// $criteria->addInCondition('passcours_cours', $this->passcours_cours, 'AND');
			$criteria->compare('passcours_cours', $this->passcours_cours);
		}

		if(isset($this->gen_id) && $this->gen_id != null) {
			$criteria->compare('gen_id', $this->gen_id);
		}
		
		//check period start - end
		if(isset($this->period_start) && $this->period_start != null) {
			$criteria->compare('passcours_date >= "' . date('Y-m-d 00:00:00', strtotime($this->period_start)) . '"');
		}
		if(isset($this->period_end) && $this->period_end != null) {
			$criteria->compare('passcours_date <= "' . date('Y-m-d 23:59:59', strtotime($this->period_end)) . '"');
		}


		$criteria->order = 'passcours_date DESC';



		//provider array
		$poviderArray = array( 'criteria' => $criteria );

		// Page
		if(isset($_GET["Passcours"]["news_per_page"])) {

			$poviderArray['pagination'] = array( 'pageSize'=> intval($_GET["Passcours"]["news_per_page"]) );
		}

		
		//return
		return new CActiveDataProvider($this, $poviderArray);
	}







	public function search() {
		$criteria=new CDbCriteria;
		$criteria->with=array('Profiles','CourseOnlines','user');

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

		//set variable
		$CourseSpecialType = $this->CourseOnlines->cates->special_category;
		$CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($CourseSpecialType === 'y') {
			$CertificateType = 'cpd';
		}

		//generate button
		echo CHtml::link('ดาวน์โหลด', 'javascript:void(0)',array(
				'submit' => array('//Passcours/PrintCertificate/'),
				'params' => array(
					'CourseId' => $this->passcours_cours,
					'UserId' => $this->passcours_user,
					'gen_id' => $this->gen_id,
					'CertificateType' => $CertificateType,
					'Download' => true,
				),
				'target' => '_blank',
				'class' => 'btn btn-warning',
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
		return CHtml::link('พิมพ์', 'javascript:void(0)', array(
				'submit' => array('//Passcours/PrintCertificate/'),
				'params' => array(
					'CourseId' => $this->passcours_cours,
					'UserId' => $this->passcours_user,
					'gen_id' => $this->gen_id,
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
		return CHtml::link('พิมพ์', 'javascript:void(0)', array(
				'submit' => array('//PassCpd/PrintCertificate/'),
				'params' => array(
					'CourseId' => $this->passcours_cours,
					'gen_id' => $this->gen_id,
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
                    $id_user = $this->register->id;
                    $file = Yush::getUrl($this->register, Yush::SIZE_ORIGINAL, $idcard);
                    
//                    exit();
                    return CHtml::link('บัตรประชาชน', $file, array(
    //                                'download' => $id_user,
                                    'target' => '_blank',
                                    'class' => 'btn btn-warning',
                            ));
                }
                return '-';
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
				    	'condition' => 'lang_id = 1',
				    	'order' => ' passcours.passcours_id DESC ',
		            ),
			    );
			}
		}

		return $scopes;
    }

	public function defaultScope()
	{
	    $defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

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
