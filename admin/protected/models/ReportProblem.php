<?php

/**
 * This is the model class for table "{{report_problem}}".
 *
 * The followings are the available columns in table '{{report_problem}}':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $tel
 * @property string $report_type
 * @property string $report_title
 * @property string $report_detail
 * @property string $report_pic
 */
class ReportProblem extends CActiveRecord
{
	const STATUS_NOSEND='wait';
	const STATUS_SEND='success';
	const STATUS_EJECT='eject';
	public $news_per_page;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{report_problem}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname, email, tel, report_type, report_title, report_detail, report_course', 'required'),
            array('firstname, lastname, email, tel, report_type, report_title, report_pic', 'length', 'max'=>255),
            array('status', 'length', 'max'=>7),
            array('report_date, accept_report_date, news_per_page,answer', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, firstname, lastname, email, tel, report_type, report_title, report_detail, report_pic, report_date, accept_report_date, status, answer, report_course', 'safe', 'on'=>'search'),
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
			'usa' => array(self::BELONGS_TO, 'Usability', 'report_type'),
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'report_course'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstname' => 'ชื่อ',
			'lastname' => 'นามสกุล',
			'email' => 'อีเมล์',
			'tel' => 'เบอร์โทรศัพท์',
			'report_type' => 'ประเภทปัญหา',
			'report_title' => 'หัวข้อ',
			'report_detail' => 'ข้อความ',
			'report_pic' => 'Report Pic',
			'answer' => 'คำตอบ',
			'report_date'=>'วันที่ส่งปัญหา',
			'accept_report_date' => 'วันที่ตอบกลับ',
			'report_course'=> 'ประเภทคอร์ส',
		);
	}

		public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOSEND => 'ยังไม่ตอบกลับ',
				self::STATUS_SEND => 'ตอบกลับสำเร็จ',
				self::STATUS_EJECT => 'ยกเลิก',
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        
        $criteria->with = array('usa','course');
		$criteria->compare('id',$this->id);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tel',$this->tel,true);
		if (empty($this->report_date)) {
		$criteria->compare('report_date',$this->report_date,true);	

		}else{
		$start_date = explode("/",$this->report_date);
		$start_dates = $start_date[2]."-".$start_date[0]."-".$start_date[1]; 
		$date_start = date('Y-m-d 00:00:00', strtotime($start_dates));
		$date_end = date('Y-m-d 23:59:59', strtotime($start_dates));
		$criteria->addBetweenCondition('report_date', $date_start, $date_end, 'AND');

		}
		$criteria->compare('report_type',$this->report_type,true);
		$criteria->compare('report_title',$this->report_title,true);
		$criteria->compare('report_detail',$this->report_detail,true);
		$criteria->compare('report_pic',$this->report_pic,true);
		$criteria->compare('t.status',$this->status,true);
		$criteria->compare('accept_report_date',$this->accept_report_date,true);	
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('report_course',$this->report_course,true);

		$criteria->order = 'report_date DESC';
		$poviderArray = array('criteria'=>$criteria);
		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

		return new CActiveDataProvider($this, $poviderArray);
	}

	// public function searchPrint()
	// {
	// 	// @todo Please modify the following code to remove attributes that should not be searched.

	// 	$criteria=new CDbCriteria;
        
 //        $criteria->with = array('usa');
	// 	$criteria->compare('id',$this->id);
	// 	$criteria->compare('firstname',$this->firstname,true);
	// 	$criteria->compare('lastname',$this->lastname,true);
	// 	$criteria->compare('email',$this->email,true);
	// 	$criteria->compare('tel',$this->tel,true);
	// 	$criteria->compare('report_date',$this->report_date,true);		
	// 	$criteria->compare('report_type',$this->report_type,true);
	// 	$criteria->compare('report_title',$this->report_title,true);
	// 	$criteria->compare('report_detail',$this->report_detail,true);
	// 	$criteria->compare('report_pic',$this->report_pic,true);
	// 	$criteria->compare('status',$this->status,true);
	// 	$criteria->compare('accept_report_date',$this->accept_report_date,true);	
	// 	$criteria->compare('answer',$this->answer,true);
	// 	$criteria->compare('report_course',$this->report_course,true);

	// 	$poviderArray = array('criteria'=>$criteria);
	// 	// Page
	// 	if(isset($this->news_per_page))
	// 	{
	// 		$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
	// 	}

	// 	return new CActiveDataProvider($this, $poviderArray);
	// }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReportProblem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		 public function getSendList()
    {
        $getregisstatusList = array(
            'success'=>'ตอบกลับแล้ว ',
            'eject'=>'ยกเลิก ',
            'wait'=>'ยังไม่ได้ตอบ'
        );
        return $getregisstatusList;
    }

    public function getUsabilityListNew(){

		$model = Usability::model()->findAll('active = "y" AND lang_id =1');
		$list = CHtml::listData($model,'id','usa_title');
		return $list;
		
	}

	public function getCourseOnlineListNew(){

		$model = CourseOnline::model()->findAll('active = "y" AND lang_id =1');
		$list = CHtml::listData($model,'id','course_title');
		return $list;
		
	}
}
