<?php

/**
 * This is the model class for table "private_message_return".
 *
 * The followings are the available columns in table 'private_message_return':
 * @property integer $pmr_id
 * @property integer $pm_id
 * @property string $pmr_return
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $answer_by
 * @property integer $status_answer
 * @property string $all_file_return_pm
 */
class PrivateMessageReturn extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'private_message_return';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pm_id, create_by, update_by, answer_by, status_answer', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			array('all_file_return_pm', 'length', 'max'=>255),
			array('pmr_return, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pmr_id, pm_id, pmr_return, create_date, create_by, update_date, update_by, active, answer_by, status_answer, all_file_return_pm', 'safe', 'on'=>'search'),
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
			'pmr_id' => 'Pmr',
			'pm_id' => 'Pm',
			'pmr_return' => 'Pmr Return',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'answer_by' => 'Answer By',
			'status_answer' => 'Status Answer',
			'all_file_return_pm' => 'All File Return Pm',
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

		$criteria->compare('pmr_id',$this->pmr_id);
		$criteria->compare('pm_id',$this->pm_id);
		$criteria->compare('pmr_return',$this->pmr_return,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('answer_by',$this->answer_by);
		$criteria->compare('status_answer',$this->status_answer);
		$criteria->compare('all_file_return_pm',$this->all_file_return_pm,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PrivateMessageReturn the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
