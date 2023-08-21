<?php

/**
 * This is the model class for table "{{profiles_title}}".
 *
 * The followings are the available columns in table '{{profiles_title}}':
 * @property integer $prof_id
 * @property string $prof_title
 */
class ProfilesTitle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfilesTitle the static model class
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
		return '{{profiles_title}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prof_title', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prof_id, prof_title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'profiles'=>array(self::HAS_MANY, 'Profile', 'id'),
		);
		return $relations;
	}

	public function getTitleList(){
		$model = ProfilesTitle::model()->findAll();
		$list = CHtml::listData($model,'prof_id','prof_title');
		return $list;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prof_id' => 'Prof',
			'prof_title' => 'คำนำหน้าชื่อ',
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

		$criteria->compare('prof_id',$this->prof_id);
		$criteria->compare('prof_title',$this->prof_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	private  $_id;
    public  function getId(){
        return $this->_id;

    }
}