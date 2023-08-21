<?php

/**
 * This is the model class for table "{{course}}".
 *
 * The followings are the available columns in table '{{course}}':
 * @property integer $course_id
 * @property string $course_title
 * @property string $course_lecturer
 * @property string $course_short_title
 * @property string $course_detail
 * @property string $course_location
 * @property integer $course_price
 * @property string $course_date
 * @property string $course_time
 * @property string $course_picture
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Course extends CActiveRecord implements IECartPosition
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
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
        return $this->course_price;
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_price, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('course_title, course_lecturer, course_location, course_picture', 'length', 'max'=>255),
			array('course_time', 'length', 'max'=>50),
			array('active', 'length', 'max'=>1),
			array('course_short_title, course_detail, course_date, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('course_id,cate_id, course_title, course_lecturer, course_short_title, course_detail, course_location, course_price, course_date, course_time, course_picture, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'OrderDetailcourse', 'shop_id'),
		);
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
    	
        return parent::afterFind();
    }

	public function defaultScope()
	{
	    return array(
	    	'alias' => 'course',
	    	'order' => 'course.course_id desc',
	    	'condition' => 'course.active = "y"',
	    );
	}

	public function getBuyItem()
	{
		$get = 'cart';
		$link = CHtml::link('สั่งซื้อ',array($get,'id'=>$this->course_id),array(
			'click' => 'function(){}',
			'class'=>'btn btn-primary btn-icon glyphicons ok_2'
		));
		return $link;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cate_id' => 'หมวดหลักสูตร',
			'course_id' => 'รหัสหลักสูตร',
			'course_number' => 'รหัสหลักสูตร',
			'course_title' => 'ชื่อหลักสูตร',
			'course_lecturer' => 'ชื่อวิทยากร',
			'course_short_title' => 'รายละเอียดย่อ',
			'course_detail' => 'รายละเอียด',
			'course_location' => 'สถานที่อบรมหลักสูตร',
			'course_price' => 'ราคา',
			'course_date' => 'วันที่อบรม',
			'course_time' => 'เวลาโดยประมาณ',
			'course_picture' => 'รูปภาพ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
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
		if($id !== null){
			$criteria->compare('cate_id',$id,false);
		}
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('course_title',$this->course_title,true);
		$criteria->compare('course_lecturer',$this->course_lecturer,true);
		$criteria->compare('course_short_title',$this->course_short_title,true);
		$criteria->compare('course_detail',$this->course_detail,true);
		$criteria->compare('course_location',$this->course_location,true);
		$criteria->compare('course_price',$this->course_price);
		$criteria->compare('course_date',$this->course_date,true);
		$criteria->compare('course_time',$this->course_time,true);
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
}