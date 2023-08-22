<?php

/**
 * This is the model class for table "{{course_generation}}".
 *
 * The followings are the available columns in table '{{course_generation}}':
 * @property integer $gen_id
 * @property integer $course_id
 * @property string $gen_period_start
 * @property string $gen_period_end
 * @property string $gen_title
 * @property integer $gen_person
 * @property string $status
 * @property string $active
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 */
class CourseGeneration extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_generation}}';
	}

	public function beforeSave()
	{
		if($this->isNewRecord){
			$this->create_by = Yii::app()->user->id;
			$this->create_date = date("Y-m-d H:i:s");
		}else{
			$this->update_by = Yii::app()->user->id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		return parent::beforeSave();
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gen_title, course_id', 'validateCheck', 'on' => 'validateCheck'),
			array('course_id, gen_person, gen_title, gen_period_start, gen_period_end', 'required'),
			array('course_id, gen_person, create_by, update_by, gen_title', 'numerical', 'integerOnly'=>true),
			// array('gen_title', 'length', 'max'=>255),
			array('status, active', 'length', 'max'=>1),
			array('gen_period_start, gen_period_end, create_date, update_date, gen_detail, gen_detail_en', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('gen_id, course_id, gen_period_start, gen_period_end, gen_title, gen_person, status, active, create_date, create_by, update_date, update_by, gen_detail, gen_detail_en', 'safe', 'on'=>'search'),
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
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id','condition'=>'active=:active','params'=>[':active'=>'y']),
			'create' => array(self::BELONGS_TO, 'User', 'create_by'),
			'update' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gen_id' => 'Gen',
			'course_id' => 'หลักสูตร',
			'gen_period_start' => 'เวลาเริ่มเรียน',
			'gen_period_end' => 'เวลาเรียนสิ้นสุด',
			'gen_title' => 'ชื่อรุ่น',
			'create_date' => 'วันที่สร้าง',
			'create_by' => 'ผู้สร้าง',
			'update_date' => 'วันที่แก้ไข',
			'update_by' => 'ผู้แก้ไข',
			'active' => 'active',
			'status' => 'สถานะ',
			'gen_person' => 'จำนวนคน',
			'gen_detail' => 'รายละเอียด (ภาษาไทย)',
			'gen_detail_en' => 'รายละเอียด (ภาษาอังกฤษ)',

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

		$criteria->compare('gen_id',$this->gen_id);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('gen_period_start',$this->gen_period_start,true);
		$criteria->compare('gen_period_end',$this->gen_period_end,true);
		$criteria->compare('gen_title',$this->gen_title,true);
		$criteria->compare('gen_person',$this->gen_person);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('gen_detail',$this->gen_detail,true);
		$criteria->compare('gen_detail_en',$this->gen_detail_en,true);

		$poviderArray = array('criteria'=>$criteria);

		// var_dump($this->news_per_page); exit();

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $poviderArray);



		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));
	}

	public function validateCheck() {
		// var_dump($this->gen_title); exit();

		if($this->gen_title != ""){
				$text = "";
			if($this->gen_id != null){
				$text = " AND gen_id!=".$this->gen_id;
			}
			$model = CourseGeneration::model()->findAll("course_id='".$this->course_id."' AND gen_title = '".$this->gen_title."' AND active='y'".$text);

			if(!empty($model)){
				$this->addError('gen_title', 'ชื่อรุ่นซ้ำ กรุณากรอกใหม่');
				return false;
			}
			return true;
		}else{
			return false;			
		}
		return true;
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseGeneration the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
