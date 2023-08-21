<?php

/**
 * This is the model class for table "{{course_online}}".
 *
 * The followings are the available columns in table '{{course_online}}':
 * @property integer $course_id
 * @property integer $cate_id
 * @property string $course_title
 * @property string $course_short_title
 * @property string $course_detail
 * @property integer $course_price
 * @property string $course_picture
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class CourseOnline extends CActiveRecord implements IECartPosition
{
	public $course_id_array;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CourseOnline the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    function getId()
    {
        return $this->course_id;
    }
 
    function getPrice()
    {
    	if(Yii::app()->controller->action->id == 'point' || Yii::app()->controller->action->id == 'PaymentPoint')
    		return $this->course_point;
    	else 
    		return $this->course_price;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_online}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cate_id, course_price, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('course_title, course_picture', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('course_short_title, course_detail, create_date, update_date,lang_id,parent_id,course_date_end,course_date_start', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('course_id, cate_id, course_title, course_short_title, course_lecturer, course_detail, course_price, course_picture, create_date, create_by, update_date, update_by, active, course_type, course_status, course_id_array,lang_id,parent_id,course_date_end,course_date_start', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'teachers' => array(self::BELONGS_TO, 'Teacher', 'course_lecturer'),
			'lessons' => array(self::HAS_MANY, 'Lesson', 'course_id'),
			'CourseGeneration' => array(self::HAS_MANY , 'CourseGeneration', 'course_id'),
			'lessonCount'=>array(self::STAT, 'Lesson', 'course_id'),
			'CategoryTitle' => array(self::BELONGS_TO, 'Category', 'cate_id'),
			// 'Schedules' => array(self::BELONGS_TO, 'Schedule', 'course_id'),
			'Schedules' => array(self::BELONGS_TO, 'Schedule', array( 'course_id' => 'course_id' )),
			'SchedulesAll' => array(self::HAS_MANY, 'Schedule', array( 'course_id' => 'course_id' )),
			'orgCourses' => array(self::HAS_MANY, 'OrgCourse', array('course_id' => 'course_id')),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'course_id' => 'รหัส',
			'course_number' => 'รหัสกลุ่มบทเรียน',
			'course_type' => 'ประเภทการเก็บชั่วโมง',
			'cate_id' => 'หมวดอบรมออนไลน์',
			'cates_search' => 'หมวดอบรมออนไลน์',
			'course_lecturer' => 'ชื่อวิทยากร',
			'course_title' => 'กลุ่มบทเรียน',
			'course_short_title' => 'รายละเอียดย่อ',
			'course_detail' => 'รายละเอียด',
			'course_price' => 'ราคา',
			'course_picture' => 'รูปภาพ',
			'course_book_number' => 'หนังสือกรมพัฒนาธุรกิจการค้าเลขที่',
			'course_book_date' => 'วันที่พัฒนาธุรกิจการค้า',
			'course_point'=> 'คะแนนสะสม',
			'course_rector_date' => 'หลักสูตรได้รับความเห็นชอบเมื่อวันที่',
			'course_hour' => 'การเก็บชั่วโมง (บัญชี)',
			'course_other' => 'การเก็บชั่วโมง (อื่นๆ)',
			'course_refer' => 'กำหนดอ้างถึงหนังสือ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
		);
	}

	public function getCateID($course_id){

		$model = CourseOnline::Model()->findByPk($course_id);
		return $model->cate_id;
	}

	public function getGen($course_id){

		$text_gen = "";		
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
				if(Yii::app()->session['lang'] != 1){
					$text_gen = " รุ่น ".$value->gen_title." ".$value->gen_detail;
				}else{
					$text_gen = " ( Gen ".$value->gen_title." ".$value->gen_detail_en." )";
				}
				break;
			}
		}

		return $text_gen;
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

	public function getGenName($gen_id){

		$text_gen = "";		

		$model = CourseGeneration::Model()->findByPk($gen_id);

		if(!empty($model)){
			if(Yii::app()->session['lang'] != 1){
				$text_gen = "(รุ่น: ".$model->gen_title.")";
			}else{
				$text_gen = " (Gen: ".$model->gen_title." )";
			}
		}else{
			if(Yii::app()->session['lang'] != 1){
				$text_gen = "(รุ่น: ไม่มีรุ่น)";
			}else{
				$text_gen = " (Gen: No Generation )";
			}
		}

		return $text_gen;
	}

	public function getNumGen($gen_id){

		$text_gen = 0;		
		$today = date("Y-m-d H:i:s");

		$model = CourseGeneration::Model()->findByPk($gen_id);

		if($model != ""){
			$text_gen = $model->gen_person;
		}

		return $text_gen;
	}

    public function getCountLesson()
    {
		$count = Lesson::Model()->count("course_id=:course_id AND active=:active", array(
			"course_id"=>$this->course_id,"active"=>"y"
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

        return parent::afterFind();
    }

	public function getCourseType()
	{
		if($this->course_type == 1)
		{
			$check = 'CPD: บัญชี '.$this->course_hour.' อื่นๆ '.$this->course_other;
		}
		else
		{
			$check = 'CPA: บัญชี '.$this->course_hour.' อื่นๆ '.$this->course_other;
		}

		return $check;
	}

	public function getEvaluate()
	{		
		if(Helpers::lib()->CheckTestingPass($this->course_id,false,true) === true)
		{
			$CountEvaluate = EvalAns::model()->countByAttributes(array(
	            'course_id'=> $this->id,
	            'user_id'=>Yii::app()->user->id
	        ));

			if($CountEvaluate == "0")
			{
				$link = CHtml::link('แบบสอบถาม',array(
					'//EvalAns/Create',
					'id'=>$this->id
				),array('target'=>'_blank'));
			}
			else
			{
				$link = CHtml::image(Yii::app()->baseUrl.'/images/icon_checkpast.png', 'ตอบแบบสอบถามแล้ว', array(
					'title'=>'ตอบแบบสอบถามแล้ว'
				));
			}

		}
		else
		{
			$link = '-';
		}

		return $link;
	}

	public function getArrow()
	{
		$link = '-';
		if(Helpers::lib()->CheckBuyItem($this->course_id) == true)
		{
			$link = CHtml::link('','',array(
				'class'=>'arrow up',
				'onclick'=>'ShowUp('.$this->course_id.')',
				'id'=>'Show'.$this->course_id
			));
		}

		return $link;
	}

	public function scopes()
    {
        return array(
            'courseshow'=>array(
                'condition'=>' course_status = 0',
            ),
        );
    }

	public function defaultScope()
	{
	    return array(
	    	'alias' => 'course',
	    	'order' => 'course.sortOrder desc',
	    	'condition' => 'course.active = "y"',
	    );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('course_id',$this->course_id);
		if($id !== null){
			$criteria->compare('cate_id',$id,false);
		}
		$criteria->compare('course_title',$this->course_title,true);
		$criteria->compare('course_short_title',$this->course_short_title,true);
		$criteria->compare('course_lecturer',$this->course_lecturer,true);
		$criteria->compare('course_detail',$this->course_detail,true);
		$criteria->compare('course_point',$this->course_point,true);
		$criteria->compare('course_price',$this->course_price,true);
		$criteria->compare('course_picture',$this->course_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('parent_id',0);
		$criteria->addInCondition('course_id',$this->course_id_array);
		$criteria->order = 'sortOrder ASC';

		$poviderArray = array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
		);

		return new CActiveDataProvider($this, $poviderArray);
	}


	public function searchBuy()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$chcecks = array();
    	$CheckCourseOnline = CourseOnline::model()->findAll();
    	foreach ($CheckCourseOnline as $key => $value)
    	{
    		$chcecks[] = $this->getCheckBuyItemAll($value->course_id);
    	}

    	$valueChecks = array();
    	foreach ($chcecks as $keyCheck => $valueCheck)
    	{
    		if(isset($valueCheck))
    		{
    			$valueChecks[] = $valueCheck;
    		}
    	}

		$criteria=new CDbCriteria;

		$criteria->addInCondition('course_id',$valueChecks);

		//$criteria->compare('course_id',$this->course_id);
		$criteria->compare('course_title',$this->course_title,true);
		$criteria->compare('course_short_title',$this->course_short_title,true);
		$criteria->compare('course_lecturer',$this->course_lecturer,true);
		$criteria->compare('course_detail',$this->course_detail,true);
		$criteria->compare('course_point',$this->course_point,true);
		$criteria->compare('course_price',$this->course_price,true);
		$criteria->compare('course_picture',$this->course_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		$poviderArray = array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
		);

		return new CActiveDataProvider($this, $poviderArray);
	}


    /*public function getCheckBuyItemAll($id)
    {
    	$courseArray = array();
		if(!Yii::app()->user->isGuest){
		    $user = Yii::app()->getModule('user')->user();
		    foreach ($user->ownerCourseOnline(array(
		    	'condition'=>'DATEDIFF(NOW(),date_expire)'
		    )) as $resultCourse) {
		        $courseArray[] = $resultCourse->course_id;
		    }
		}
		$countReturn = tblReturn::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
			"lesson_id"=>$id,"user_id"=>Yii::app()->user->id
		));

	    $OrderDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
	    	'order' => ' OrderDetailonlines.order_id DESC ',
			'condition'=>' OrderDetailonlines.shop_id="'.$id.'" AND OrderDetailonlines.active="y" ',
	    ));

		if(!in_array($id, $courseArray)){

				$link = false;
		}else{

			if($OrderDetailonline->date_expire != null){
				$d1 = new DateTime(date("Y-m-d H:i:s"));
				$d2 = new DateTime($OrderDetailonline->date_expire);
				if($d1 > $d2 ) { $CheckDate = false; } else { $CheckDate = true; }
			}else{
				$CheckDate = false;
			}

			if($CheckDate){
				$link = $id;
			}else{
				$link = false;
			}
		}
		return $link;
    }*/

    public function getCheckBuyItemAll($id)
    {
    	$courseArray = array();
		if(!Yii::app()->user->isGuest){
		    $user = Yii::app()->getModule('user')->user();
		    foreach ($user->ownerCourseOnline(array(
		    	'condition'=>'DATEDIFF(NOW(),date_expire)'
		    )) as $resultCourse) {
		        $courseArray[] = $resultCourse->course_id;
		    }
		}
		$countReturn = tblReturn::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
			"lesson_id"=>$id,"user_id"=>Yii::app()->user->id
		));

	    $OrderDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
	    	'order' => ' OrderDetailonlines.order_id DESC ',
			'condition'=>' OrderDetailonlines.shop_id="'.$id.'" AND OrderDetailonlines.active="y" ',
	    ));
		if(!in_array($id, $courseArray))
		{
			if(Helpers::lib()->CheckTestingPass($id,true) == 'new')
			{
				if($countReturn > 1)
				{
					$link = $id;
				}
				else
				{
					$link =  false;
				}
			}
			else
			{
				if(isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 0 && $OrderDetailonline->con_admin == 0)
				{
					$link = $id;
				}
				else if(isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 1 && $OrderDetailonline->con_admin == 0)
				{
					$link = $id;
				}
				else
				{
					$link =  false;
				}
			}

		}else{

			if($OrderDetailonline->date_expire != null)
			{
				$d1 = new DateTime(date("Y-m-d H:i:s"));
				$d2 = new DateTime($OrderDetailonline->date_expire);
				if($d1 > $d2 ) { $CheckDate = false; } else { $CheckDate = true; }
			}
			else
			{
				$CheckDate = false;
			}

			if(Helpers::lib()->CheckTestingPass($id,true) == 'new')
			{
				if($countReturn < 1)
				{
					$link = $id;
				}
				else
				{
					$link =  false;
				}
			}
			else
			{
				if($CheckDate)
				{
					$link = $id;
				}
				else
				{
					if(isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 0 && $OrderDetailonline->con_admin == 0)
					{
						$link = $id;
					}
					else if(isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 1 && $OrderDetailonline->con_admin == 0)
					{
						$link = $id;
					}
					else
					{
						$link =  false;
					}
				}
			}
		}
		return $link;
    }


}