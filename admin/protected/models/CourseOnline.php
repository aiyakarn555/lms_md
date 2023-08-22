<?php

class CourseOnline extends AActiveRecord
{
	public $cates_search;
	public $cate_type;
	public $period_start;
	public $period_end;
	public $labelState = false;
	public $org;
	public $searchCourse;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{course_online}}';
	}

	public function rules()
	{
		return array(
			array('cate_id,cate_course,time_test,cate_amount,percen_test, course_point,course_price, create_by, update_by, course_type', 'numerical', 'integerOnly'=>true),
			array('course_title, course_picture, course_hour, course_other,course_number, course_book_number,course_day_learn', 'length', 'max'=>255),
			array('course_picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true),
			array('active', 'length', 'max'=>1),
			//array('cate_id,course_title, course_lecturer ,course_point,course_price,course_short_title,course_detail,course_number,course_rector_date, course_type, course_book_number, course_book_date, course_tax, course_refer', 'required'),
			array('cate_id,time_test,cate_amount,percen_test,course_title,course_short_title,course_day_learn', 'required'),
			array('course_date_start, course_date_end, cates.cate_title, course_point, cates_search, course_number, course_lecturer, course_short_title, course_detail, create_date, update_date, news_per_page, course_rector_date, course_hour, course_other, course_type, course_book_number, course_book_date, course_status, course_tax, course_refer, course_note,recommend,price, lang_id, parent_id,course_day_learn,instructor_name,course_md_code,document_status,hidden_score', 'safe'),
			array('cate_type,cate_course,time_test,cate_amount,percen_test,cates.cate_title,course_point,cates_search,course_id, course_number, course_lecturer, cate_id, course_title, course_short_title, course_detail, course_price, course_picture, create_date, create_by, update_date, update_by, active, course_rector_date, course_hour, course_other, course_type, course_book_number, course_book_date, course_status, course_tax, course_refer, course_note,recommend,price, lang_id, parent_id,course_day_learn,instructor_name,course_md_code', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'EvaluateCount'=>array(self::STAT, 'Evaluate', 'course_id'),
			'cates' => array(self::BELONGS_TO, 'Category', 'cate_id'),
			'category' => array(self::BELONGS_TO, 'CategoryCourse', 'cate_course'),
			'teachers' => array(self::BELONGS_TO, 'Teacher', 'course_lecturer'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			'CourseRelateLesson' => array(self::HAS_MANY, 'Lesson', 'course_id'),
			'Schedules' => array(self::HAS_MANY, 'Schedule', 'course_id'),
		);
	}

	public function attributeLabels()
	{
		if(!$this->labelState){
			$this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		}
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'course_id' => 'รหัส',
			'course_number' => 'รหัสหลักสูตร'.$label_lang,
			'course_type' => 'ประเภทหลักสูตร'.$label_lang,
			'cate_id' => 'หมวดอบรมออนไลน์'.$label_lang,
			'cates_search' => 'หมวดอบรมออนไลน์'.$label_lang,
			'course_lecturer' => 'ชื่อวิยากร'.$label_lang,
			'course_title' => 'ชื่อหลักสูตรอบรมออนไลน์'.$label_lang,
			'course_short_title' => 'รายละเอียดย่อ'.$label_lang,
			'course_detail' => 'รายละเอียด'.$label_lang,
			'course_price' => 'ราคาหลักสูตร'.$label_lang,
			'course_picture' => 'รูปภาพ'.$label_lang,
			'course_book_number' => 'หนังสือกรมพัฒนาธุรกิจการค้าเลขที่'.$label_lang,
			'course_book_date' => 'วันที่พัฒนาธุรกิจการค้า'.$label_lang,
			'course_point'=> 'คะแนนสะสม'.$label_lang,
			'course_rector_date' => 'หลักสูตรได้รับความเห็นชอบเมื่อวันที่'.$label_lang,
			'course_hour' => 'การเก็บชั่วโมง (บัญชี)'.$label_lang,
			'course_status' => 'ยอดนิยม'.$label_lang,
			'course_other' => 'การเก็บชั่วโมง (อื่นๆ)'.$label_lang,
			'course_tax' => 'ประเภทการเสียภาษีหรือไม่'.$label_lang,
			'course_refer' => 'เปิด ปิด เฉลยข้อสอบ'.$label_lang,
			'course_note' => 'หมายเหตุ'.$label_lang,
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล'.$label_lang,
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล'.$label_lang,
			'active' => 'สถานะ',
			'recommend' => 'ปักหมุดหลักสูตรแนะนำ'.$label_lang,
			'cate_course' => 'กลุ่มหลักสูตร'.$label_lang,
			'time_test'=>'เวลาในการทำข้อสอบ'.$label_lang,
			'cate_amount' => 'จำนวนครั้งที่ทำข้อสอบได้'.$label_lang,
			'percen_test' => 'เกณฑ์การสอบผ่าน *เปอร์เซ็น'.$label_lang,
			'course_date_start' => 'วันที่เริ่มต้นการเรียน'.$label_lang,
			'course_date_end' => 'วันที่สิ้นสุดการเรียน'.$label_lang,
			'lang_id' => 'ภาษา',
			'parent_id' => 'แนวหลัก',
			'course_day_learn' => 'จำนวนวันที่เข้าเรียนได้ '.$label_lang,
			'price' => 'หลักสูตรจ่ายเงิน '.$label_lang,
			'intro_video' => 'วิดีโอ ตัวอย่างหลักสูตร '.$label_lang,
			'course_md_code' => 'รหัส Code กรมเจ้าท่า'.$label_lang,
			'instructor_name' => 'ชื่อผู้สอน'.$label_lang,
			'document_status' => 'แนบเอกสาร'.$label_lang,
			'hidden_score'	 => 'ซ่อนคะแนนสอบ'.$label_lang,
		);
	}

	public function report() {
		//by shinobu22
		//not yet
		$criteria = new CDbCriteria;

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

	public function getCoursetitleConcat()
	{
		if($this->cates->cate_type == 1){
			$coursetitle = $this->cates->cate_title." >> ".$this->course_title;
		}else{
			$coursetitle = $this->cates->cate_title." >> ".$this->course_title;
		}

		return $coursetitle;
	}

	public function beforeSave() 
	{
		$this->cate_id = CHtml::encode($this->cate_id);
		$this->course_number = CHtml::encode($this->course_number);
		$this->course_book_number = CHtml::encode($this->course_book_number);
		$this->course_title = CHtml::encode($this->course_title);
		$this->course_short_title = CHtml::encode($this->course_short_title);
		$this->course_detail = CHtml::encode($this->course_detail);
		$this->course_price = CHtml::encode($this->course_price);
		$this->course_hour = CHtml::encode($this->course_hour);
		$this->course_other = CHtml::encode($this->course_other);
		$this->course_refer = CHtml::encode($this->course_refer);
		$this->course_note = CHtml::encode($this->course_note);

		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 0;
		}

		if($this->isNewRecord)
		{
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		else
		{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}

		return parent::beforeSave();
	}

	public function getCountTest($type='course')
	{
		$count = Coursemanage::Model()->count("id=:course_id AND active=:active AND type=:type", array(
			"course_id"=>$this->course_id, "active"=>"y", "type"=>$type
		));
		return $count;
	}

	public function getCountLesson()
	{
		$count = Lesson::Model()->count("course_id=:course_id AND active=:active AND lang_id=:lang_id", array(
			"course_id"=>$this->course_id, "active"=>"y","lang_id" => 1
		));
		return $count;
	}

	public function getCountTeacher()
	{
		$count = CourseTeacher::Model()->count("course_id=:course_id", array(
			"course_id"=>$this->course_id,
		));
		return $count;
	}

	public function getCountGen()
	{
		$count = CourseGeneration::Model()->count("course_id=:course_id AND active='y'", array(
			"course_id"=>$this->course_id,
		));
		return $count;
	}

	public function afterFind() 
	{
		$this->course_title = CHtml::decode($this->course_title);
		$this->course_number = CHtml::decode($this->course_number);
		$this->course_book_number = CHtml::decode($this->course_book_number);
		$this->course_short_title = CHtml::decode($this->course_short_title);
		$this->course_detail = CHtml::decode($this->course_detail);
		$this->course_price = CHtml::decode($this->course_price);
		$this->course_hour = CHtml::decode($this->course_hour);
		$this->course_other = CHtml::decode($this->course_other);
		$this->course_refer = CHtml::decode($this->course_refer);
		$this->course_note = CHtml::decode($this->course_note);

		return parent::afterFind();
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'courseonline',
				'order' => ' courseonline.course_id DESC ',
				'condition' => ' courseonline.active ="y" ',
			);	
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'courseonline',
				'order' => ' courseonline.course_id DESC ',
			);	
		}

		return $checkScopes;
	}

	public function scopes()
	{
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("CourseOnline.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);
		if($Access == true)
		{
			$scopes =  array( 
				'courseonlinecheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{

			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'courseonlinecheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'courseonlinecheck'=>array(
							'alias' => 'courseonline',
							'condition' => ' courseonline.active = "y" ',
							'order' => ' courseonline.course_id DESC ',
						),
					);
				}else{
					$scopes = array(
						'courseonlinecheck'=>array(
							'alias' => 'courseonline',
							'condition' => ' courseonline.create_by = "'.Yii::app()->user->id.'" AND courseonline.active = "y" ',
							'order' => ' courseonline.course_id DESC ',
						),
					);
				}
				
			    // $scopes = array(
		     //        'courseonlinecheck'=>array(
			    // 		'alias' => 'courseonline',
			    // 		'condition' => ' courseonline.active = "y" ',
			    // 		'order' => ' courseonline.course_id DESC ',
		     //        ),
			    // );
			}
		}

		return $scopes;
	}

	public function defaultScope()
	{
		$defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

	public function getCourseType()
	{
		if($this->course_type == 1){
			$check = 'หลักสูตรเลือก';
		}else{
			$check = 'หลักสูตรบังคับ';
		}
		return $check;
	}

	public function getId()
	{
		return $this->course_id;
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('cates');
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('course_type',$this->course_type,true);
		$criteria->compare('course_number',$this->course_number,true);
		$criteria->compare('course_book_number',$this->course_book_number,true);
		$criteria->compare('course_book_date',$this->course_book_date,true);
		$criteria->compare('course_rector_date',$this->course_rector_date,true);
		$criteria->compare('cate_id',$this->cate_id,true);
		$criteria->compare('cate_type',$this->cate_type,true);
		$criteria->compare('categorys.cate_title',$this->cates_search,true);
		$criteria->compare('course_lecturer',$this->course_lecturer,true);
		$criteria->compare('course_title',$this->course_title,true);
		$criteria->compare('course_short_title',$this->course_short_title,true);
		$criteria->compare('course_detail',$this->course_detail,true);
		$criteria->compare('course_price',$this->course_price,true);
		$criteria->compare('course_point',$this->course_point,true);
		$criteria->compare('course_status',$this->course_status,true);
		$criteria->compare('course_tax',$this->course_tax,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('categorys.active','y');
		$criteria->compare('course_md_code',$this->course_md_code,true);
		
		

		////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
		// $check_user = User::model()->findByPk(Yii::app()->user->id);
		// $group = $check_user->group;
		// $group_arr = json_decode($group);
		// $see_all = 2;
		// if(in_array("1", $group_arr) || in_array("7", $group_arr)){
		// 	$see_all = 1;
		// }
        //     //////////////////
		// if($see_all != 1){
		// 	$criteria->compare('courseonline.create_by',Yii::app()->user->id);
		// }else{

		// }

		$modelUser = Users::model()->findByPk(Yii::app()->user->id);
		$group = json_decode($modelUser->group);
		if (!in_array(1, $group)){
			$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
			$criteria->addInCondition('courseonline.create_by', $groupUser);	
		}
		$criteria->compare('courseonline.active','y');
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('courseonline.lang_id',$this->lang_id,true);
		$criteria->compare('courseonline.parent_id',0);
		
		$criteria->order = 'sortOrder ASC';

		if (!empty($this->searchCourse))
		{
			$criteria->addIncondition('course_id',$this->org);
		}


		if (!empty($this->course_date))
		{
			$criteria->compare('course_date',ClassFunction::DateSearch($this->course_date),true);
		}
		
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $poviderArray);
	}


	public function getGenID($course_id){

		$text_gen = 0;		
		$today = date("Y-m-d H:i:s");

		$model = CourseGeneration::Model()->findAll([
			'condition' => "active=:active AND
			status=:status AND
			course_id=:course_id AND
			(  ((gen_period_start IS NULL) AND (gen_period_end IS NULL)) OR 
			((gen_period_start<=:today) AND (gen_period_end>=:today)) )",
			'params' => [':active'=>'y',':status'=>'1',':course_id'=>$course_id, ':today'=>DATE($today)],
		]);

		if(!empty($model)){
			foreach ($model as $key => $value) {
				$text_gen = $value->gen_id;
				break;
			}
		}

		return $text_gen;
	}


	public function getConcatCourseName(){
		$placeHolder = (( $this->course_md_code != "" && $this->course_md_code != null )?$this->course_md_code: "ไม่พบรหัส")." : ".$this->course_title." (".(Helpers::lib()->DateThaiNewNoTime($this->course_date_start)." - ".Helpers::lib()->DateThaiNewNoTime($this->course_date_end)).")";
		return  $placeHolder ;

	}
}
