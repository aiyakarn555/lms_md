<?php

/**
 * This is the model class for table "{{profiles}}".
 *
 * The followings are the available columns in table '{{profiles}}':
 * @property integer $user_id
 * @property string $lastname
 * @property string $firstname
 * @property string $identification
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Profiles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Profiles the static model class
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
		return '{{profiles}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lastname, firstname', 'length', 'max'=>50),
			array('identification', 'length', 'max'=>30),
			array('division_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, lastname, firstname, division_title, type_employee , identification', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'Province' => array(self::HAS_ONE, 'Province', array('pv_id'=>'province')),
			'Generation' => array(self::HAS_ONE, 'Generation', array('id_gen'=>'generation')),
			'ProfilesTitle'=>array(self::BELONGS_TO, 'ProfilesTitle', 'prefix_th'),
			'Type' => array(self::HAS_ONE, 'TypeUser', array('id' => 'type_user')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'lastname' => 'Lastname',
			'firstname' => 'Firstname',
			'identification' => 'Identification',			
		);
	}

	public function getEducationList(){
		$model = Profiles::model()->findAll();
		$list = CHtml::listData($model,'education','education');
		return $list;
	}

	private $fullname;

	public function getFullname() {
		if(!empty($this->firstname) && !empty($this->lastname)){
			$str = $this->firstname . ' ' . $this->lastname;
		}
		return $str;
	}

	public function getOccupationList(){
		$model = Profiles::model()->findAll();
		$list = CHtml::listData($model,'occupation','occupation');
		return $list;
	}

	public function getContactfromList(){
		$model = Profiles::model()->findAll();
		$list = CHtml::listData($model,'contactfrom','contactfrom');
		return $list;
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('identification',$this->identification,true);
	    $criteria->compare('type_employee',$this->type_employee,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}