<?php

class Conditions extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{conditions}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('conditions_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('conditions_detail, create_date, update_date', 'safe'),
			array('conditions_id, conditions_title, conditions_detail, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'conditions_id' => 'Conditions',
			'conditions_title' => 'Conditions Title',
			'conditions_detail' => 'Conditions Detail',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('conditions_id',$this->conditions_id);
		$criteria->compare('conditions_title',$this->conditions_title,true);
		$criteria->compare('conditions_detail',$this->conditions_detail,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function afterFind()
	{
		$this->conditions_title 	= CHtml::decode($this->conditions_title);
		$this->conditions_detail 	= CHtml::decode($this->conditions_detail);

			return parent::afterFind();
	}

	public function defaultScope()
	{
		return array(
			'alias' => 'conditions',
			'order' => ' conditions.conditions_id DESC ',
			'condition' => ' conditions.active = "y" ',
		);
	}
}
