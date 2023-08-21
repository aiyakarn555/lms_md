<?php

/**
 * This is the model class for table "{{knowledge}}".
 *
 * The followings are the available columns in table '{{knowledge}}':
 * @property integer $cms_id
 * @property string $cms_title
 * @property string $cms_short_title
 * @property string $cms_detail
 * @property string $cms_picture
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Knowledge extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Knowledge the static model class
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
		return '{{knowledge}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('cms_title', 'length', 'max'=>250),
			array('cms_picture', 'length', 'max'=>200),
			array('active', 'length', 'max'=>1),
			array('cms_short_title, cms_detail, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cms_id, cms_title, cms_short_title, cms_detail, cms_picture, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'cms_id' => 'รหัส',
			'cms_title' => 'ชื่อ',
			'cms_short_title' => 'รายละเอียดย่อ',
			'cms_detail' => 'เนื้อหา',
			'cms_picture' => 'รูปภาพ',
			'create_date' => 'สร้างเมื่อ',
			'create_by' => 'สร้างโดย',
			'update_date' => 'แก้ไขเมื่อ',
			'update_by' => 'แก้ไขโดย',
			'active' => 'สถานะ',
		);
	}

    public function afterFind() 
    {
    	$this->cms_title = CHtml::decode($this->cms_title);
    	$this->cms_short_title = CHtml::decode($this->cms_short_title);
    	$this->cms_detail = CHtml::decode($this->cms_detail);

        return parent::afterFind();
    }
    
	public function defaultScope()
	{
	    return array(
	    	'order' => 'cms_id desc',
	    	'condition' => ' active = "y" ',
	    );
	}

	public function getId()
	{
		return $this->cms_id;
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

		$criteria->compare('cms_id',$this->cms_id);
		$criteria->compare('cms_title',$this->cms_title,true);
		$criteria->compare('cms_short_title',$this->cms_short_title,true);
		$criteria->compare('cms_detail',$this->cms_detail,true);
		$criteria->compare('cms_picture',$this->cms_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}