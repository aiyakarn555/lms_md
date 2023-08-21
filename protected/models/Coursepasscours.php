<?php

/**
 * This is the model class for table "{{passcours}}".
 *
 * The followings are the available columns in table '{{passcours}}':
 * @property integer $passcours_id
 * @property integer $passcours_cours
 * @property integer $passcours_user
 * @property string $passcours_date
 */
class Coursepasscours extends CActiveRecord
{
	public $user_name;
	public $cours_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Passcours the static model class
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
		return '{{coursepasscours}}';
	}

	public function defaultScope()
	{
	    return array(
	    	'order' => 'passcours_id desc',
	    	//'condition' => ' passcours_user = "'.Yii::app()->user->id.'" ',
	    );
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('passcours_cours, passcours_user', 'numerical', 'integerOnly'=>true),
			array('passcours_date, user_name, cours_name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cours_name, user_name, passcours_id, passcours_cours, passcours_user, passcours_date', 'safe', 'on'=>'search'),
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
			'Profiles'=>array(self::BELONGS_TO, 'Profile', 'passcours_user'),
			'CourseOnlines'=>array(self::BELONGS_TO, 'CourseOnline', 'passcours_cours'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'passcours_id' => 'Passcours',
			'passcours_cours' => 'ชื่อหลักสูตร',
			'passcours_user' => 'ชื่อผู้อบรม',
			'passcours_date' => 'วันที่สอบผ่าน',
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
		$criteria->with=array('Profiles','CourseOnlines');

		if (!empty($this->user_name)){
			$criteria->addSearchCondition( 'CONCAT( Profiles.first_name, " ", Profiles.last_name )', $this->user_name );
		}else{
			$criteria->compare('Profiles.first_name',$this->user_name,true);
		}

		if (!empty($this->passcours_date)){
			$criteria->compare('passcours_date',ClassFunction::DateSearch($this->passcours_date),true);
		}

		$criteria->compare('CourseOnlines.course_title',$this->cours_name,true);
		$criteria->compare('passcours_id',$this->passcours_id,true);
		//$criteria->compare('passcours_cours',$this->passcours_cours,true);
		//$criteria->compare('passcours_user',$this->passcours_user,true);
		//$criteria->compare('passcours_date',$this->passcours_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getNameUser() 
    {
        return $this->Profiles->first_name.' '.$this->Profiles->last_name;
    }
}