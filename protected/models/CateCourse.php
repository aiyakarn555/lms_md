<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $cate_id
 * @property integer $cate_type
 * @property string $cate_title
 * @property string $cate_short_detail
 * @property string $cate_detail
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class CateCourse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CateCourse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cate_type, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('cate_title, cate_short_detail', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('cate_detail, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cate_id, cate_type, cate_title, cate_short_detail, cate_detail, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

    public function afterFind() 
    {
    	$this->cate_title = CHtml::decode($this->cate_title);
    	$this->cate_short_detail = CHtml::decode($this->cate_short_detail);
    	$this->cate_detail = CHtml::decode($this->cate_detail);
        return parent::afterFind();
    }

    public function getCountCourse()
    {
		$count = Course::Model()->count("cate_id=:cate_id AND active=:active", array(
			"cate_id"=>$this->cate_id,"active"=>"y"
		));
		return $count;
    }

	public function getDetailCourse()
	{
		$get = '//course/index';
		$link = CHtml::link('<i class="icon-folder-open"></i> รายละเอียดหลักสูตร',array($get,'id'=>$this->cate_id),array(
			'click' => 'function(){}',
			'class'=>'btn btn-primary btn-icon glyphicons ok_2'
		));
		return $link;
	}

	public function getImageCheck()
	{
		$imageCateCourse = Controller::ImageShowIndex(Yush::SIZE_THUMB,$this,$this->cate_image,array());
		$imageCateCourseCheck = str_replace("catecourse","category",$imageCateCourse);
		return CHtml::link($imageCateCourseCheck, array('cateCourse/view', 'id'=>$this->cate_id),array(
			'class'=>'thumbnail'
		));
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

	public function defaultScope()
	{
	    return array(
	    	'alias' => 'cate',
	    	'order' => 'cate_id desc',
	    	'condition' => ' cate_type = "2" AND cate.cate_show = "1" AND cate.active = "y" ',
	    );
	}

	public function getId()
	{
		return $this->cate_id;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CountCourse'=>'จำนวนหลักสูตร',
			'Datailhead'=>'หัวข้อ',
			'cate_id' => 'Cate',
			'cate_type' => 'Cate Type',
			'cate_title' => 'ชื่อหมวดหลักสูตรสมัมนา-อบรม',
			'cate_short_detail' => 'รายละเอียดย่อ',
			'cate_image' => 'รูปภาพประกอบ',
			'cate_detail' => 'รายละเอียด',
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
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('cate_id',$this->cate_id);
		$criteria->compare('cate_type',$this->cate_type);
		$criteria->compare('cate_title',$this->cate_title,true);
		$criteria->compare('cate_short_detail',$this->cate_short_detail,true);
		$criteria->compare('cate_detail',$this->cate_detail,true);
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