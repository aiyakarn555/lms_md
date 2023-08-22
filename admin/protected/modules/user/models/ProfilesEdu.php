<?php

/**
 * This is the model class for table "{{profiles_edu}}".
 *
 * The followings are the available columns in table '{{profiles_edu}}':
 * @property integer $pro_edu_id
 * @property integer $user_id
 * @property integer $edu_id
 * @property string $created_date
 * @property string $created_by
 * @property string $update_date
 * @property string $update_by
 * @property string $active
 * @property string $institution
 * @property string $date_graduation
 */
class ProfilesEdu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{profiles_edu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, edu_id', 'numerical', 'integerOnly'=>true),
			array('created_by, update_by, institution', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('created_date, update_date, date_graduation', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pro_edu_id, user_id, edu_id, created_date, created_by, update_date, update_by, active, institution, date_graduation', 'safe', 'on'=>'search'),
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
			'user' => array(self::HAS_ONE, 'User', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pro_edu_id' => 'Pro Edu',
			'user_id' => 'User',
			'edu_id' => 'Edu',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'institution' => 'Institution',
			'date_graduation' => 'Date Graduation',
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

		$criteria->compare('pro_edu_id',$this->pro_edu_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('edu_id',$this->edu_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('institution',$this->institution,true);
		$criteria->compare('date_graduation',$this->date_graduation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProfilesEdu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
