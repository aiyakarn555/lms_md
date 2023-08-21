<?php

/**
 * This is the model class for table "{{menu_coursequestion}}".
 *
 * The followings are the available columns in table '{{menu_coursequestion}}':
 * @property integer $id
 * @property string $label_coursequestion
 * @property string $label_homepage
 * @property string $label_backToCourse
 * @property string $label_result
 * @property string $label_course
 * @property string $label_courseName
 * @property string $label_questionAll
 * @property string $label_timeTest
 * @property string $label_pointSum
 * @property string $label_point
 * @property string $label_choice
 * @property string $label_min
 * @property string $label_btn_startTest
 * @property string $label_preTest
 * @property string $label_postTest
 * @property string $label_lesson
 * @property string $label_timeToTest
 * @property string $label_typeQues
 * @property string $label_checkbox
 * @property string $label_radio
 * @property string $label_dropdown
 * @property string $label_section
 * @property string $label_dropdownChoose
 * @property string $label_btn_previous
 * @property string $label_btn_next
 * @property string $label_btn_sendQues
 * @property string $label_testing
 * @property string $label_useTimes
 * @property string $label_resultPoint
 * @property string $label_percent
 * @property string $label_alert_noTest
 * @property string $label_alert_error
 * @property string $label_alert_testPass
 * @property string $label_alert_testFail
 * @property integer $lang_id
 * @property integer $parent_id
 */
class MenuCoursequestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_coursequestion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('label_coursequestion', 'length', 'max'=>255),
			array('label_homepage, label_backToCourse, label_result, label_course, label_courseName, label_questionAll, label_timeTest, label_pointSum, label_point, label_choice, label_min, label_btn_startTest, label_preTest, label_postTest, label_lesson, label_typeQues, label_checkbox, label_radio, label_dropdown, label_section, label_dropdownChoose, label_btn_previous, label_btn_next, label_btn_sendQues, label_testing, label_useTimes, label_resultPoint, label_percent, label_alert_noPermisTest,label_alert_noTest, label_alert_error, label_alert_testPass, label_alert_testFail', 'length', 'max'=>100),
			array('label_timeToTest', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_coursequestion, label_homepage, label_backToCourse, label_result, label_course, label_courseName, label_questionAll, label_timeTest, label_pointSum, label_point, label_choice, label_min, label_btn_startTest, label_preTest, label_postTest, label_lesson, label_timeToTest, label_typeQues, label_checkbox, label_radio, label_dropdown, label_section, label_dropdownChoose, label_btn_previous, label_btn_next, label_btn_sendQues, label_testing, label_useTimes, label_resultPoint, label_percent,label_alert_noPermisTest, label_alert_noTest, label_alert_error, label_alert_testPass, label_alert_testFail, lang_id, parent_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label_coursequestion' => 'แบบทดสอบหลักสตูร',
			'label_homepage' => 'หน้าแรก',
			'label_backToCourse' => 'กลับหน้าหลักสูตร',
			'label_result' => 'ผลการสอบ',
			'label_course' => 'หลักสูตร',
			'label_courseName' => 'ชื่อหลักสูตร',
			'label_questionAll' => 'ข้อสอบทั้งหมด',
			'label_timeTest' => 'เวลาในการทำข้อสอบ',
			'label_pointSum' => 'คะแนนเต็ม',
			'label_point' => 'คะแนน',
			'label_choice' => 'ข้อ',
			'label_min' => 'นาที',
			'label_btn_startTest' => 'เริ่มทำข้อสอบ',
			'label_preTest' => 'แบบทดสอบก่อนเรียน',
			'label_postTest' => 'แบบทดสอบหลังเรียน',
			'label_lesson' => 'บทเรียน',
			'label_timeToTest' => 'เวลาในการทำแบบทดสอบ',
			'label_typeQues' => 'ข้อสอบแบบ',
			'label_checkbox' => 'เลือกได้หลายคำตอบ',
			'label_radio' => 'เลือกได้คำตอบเดียว',
			'label_dropdown' => 'คำตอบแบบจับคู่',
			'label_section' => 'ส่วนที่',
			'label_dropdownChoose' => 'เลือก',
			'label_btn_previous' => 'ข้อก่อนหน้า',
			'label_btn_next' => 'ข้อต่อไป',
			'label_btn_sendQues' => 'ส่งคำตอบ',
			'label_testing' => 'การทำข้อสอบ',
			'label_useTimes' => 'ใช้เวลาในการสอบ',
			'label_resultPoint' => 'คะแนนที่ได้',
			'label_percent' => 'คิดเป็นร้อยละ',
			'label_alert_noPermisTest' => 'คุณยังไม่มีสิทธิ์ทำแบบทดสอบ',
			'label_alert_noTest' => 'ขณะนี้ยังไม่มีข้อสอบ',
			'label_alert_error' => 'เกิดข้อผิดพลาด',
			'label_alert_testPass' => 'คุณสอบผ่านแล้ว',
			'label_alert_testFail' => 'คุณสอบไม่ผ่าน หมดสิทธิ์ทำแบบทดสอบ',
			'lang_id' => 'ภาษา',
			'parent_id' => 'Parent',
		);
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

		$criteria->compare('id',$this->id);
		$criteria->compare('label_coursequestion',$this->label_coursequestion,true);
		$criteria->compare('label_homepage',$this->label_homepage,true);
		$criteria->compare('label_backToCourse',$this->label_backToCourse,true);
		$criteria->compare('label_result',$this->label_result,true);
		$criteria->compare('label_course',$this->label_course,true);
		$criteria->compare('label_courseName',$this->label_courseName,true);
		$criteria->compare('label_questionAll',$this->label_questionAll,true);
		$criteria->compare('label_timeTest',$this->label_timeTest,true);
		$criteria->compare('label_pointSum',$this->label_pointSum,true);
		$criteria->compare('label_point',$this->label_point,true);
		$criteria->compare('label_choice',$this->label_choice,true);
		$criteria->compare('label_min',$this->label_min,true);
		$criteria->compare('label_btn_startTest',$this->label_btn_startTest,true);
		$criteria->compare('label_preTest',$this->label_preTest,true);
		$criteria->compare('label_postTest',$this->label_postTest,true);
		$criteria->compare('label_lesson',$this->label_lesson,true);
		$criteria->compare('label_timeToTest',$this->label_timeToTest,true);
		$criteria->compare('label_typeQues',$this->label_typeQues,true);
		$criteria->compare('label_checkbox',$this->label_checkbox,true);
		$criteria->compare('label_radio',$this->label_radio,true);
		$criteria->compare('label_dropdown',$this->label_dropdown,true);
		$criteria->compare('label_section',$this->label_section,true);
		$criteria->compare('label_dropdownChoose',$this->label_dropdownChoose,true);
		$criteria->compare('label_btn_previous',$this->label_btn_previous,true);
		$criteria->compare('label_btn_next',$this->label_btn_next,true);
		$criteria->compare('label_btn_sendQues',$this->label_btn_sendQues,true);
		$criteria->compare('label_testing',$this->label_testing,true);
		$criteria->compare('label_useTimes',$this->label_useTimes,true);
		$criteria->compare('label_resultPoint',$this->label_resultPoint,true);
		$criteria->compare('label_percent',$this->label_percent,true);
		$criteria->compare('label_alert_noPermisTest',$this->label_alert_noPermisTest,true);
		$criteria->compare('label_alert_noTest',$this->label_alert_noTest,true);
		$criteria->compare('label_alert_error',$this->label_alert_error,true);
		$criteria->compare('label_alert_testPass',$this->label_alert_testPass,true);
		$criteria->compare('label_alert_testFail',$this->label_alert_testFail,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuCoursequestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
