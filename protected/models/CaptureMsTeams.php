<?php

/**
 * This is the model class for table "{{capture_ms_teams}}".
 *
 * The followings are the available columns in table '{{capture_ms_teams}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $ms_teams_id
 * @property string $file_name
 * @property string $active
 * @property string $create_date
 * @property string $update_date
 * @property string $type_noti
 */
class CaptureMsTeams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{capture_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, ms_teams_id', 'numerical', 'integerOnly'=>true),
			array('file_name, type_noti', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, ms_teams_id, file_name, active, create_date, update_date, type_noti', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'ms_teams_id' => 'Ms Teams',
			'file_name' => 'File Name',
			'active' => 'Active',
			'create_date' => 'Create Date',
			'update_date' => 'Update Date',
			'type_noti' => 'Type Noti',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('ms_teams_id',$this->ms_teams_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('type_noti',$this->type_noti,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CaptureMsTeams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
