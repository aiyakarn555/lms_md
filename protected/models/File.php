<?php

class File extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{file}}';
	}

	public function rules()
	{
		return array(
			array('filename', 'required'),
			array('lesson_id, create_by, update_by,views', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>80),
			array('length', 'length', 'max'=>20),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date, encredit', 'safe'),
			array('id, lesson_id, filename, file_name, file_position, length, create_date, create_by, update_date, update_by, active,views, encredit', 'safe', 'on'=>'search'),
			);
	}

	public function relations()
	{
		return array(
			'lesson' => array(self::BELONGS_TO,'Lesson','lesson_id'),
			);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lesson_id' => 'Lesson',
			'filename' => 'Filename',
			'file_name' => 'ชื่อวิดีโอ',
			'length' => 'Length',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'views' => 'Views',
			'encredit' => 'encredit',

			);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('encredit',$this->encredit,true);
		$criteria->compare('views',$this->views);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			));
	}

	public function defaultScope()
	{
		$defaultScope =  array(
			'alias' => 'file',
			'order' => ' file.file_position DESC, file.id ASC ',
			'condition' => ' file.active ="y" ',
			);	

		return $defaultScope;
	}

	public function getRefileName()
	{
		if($this->file_name  == '')
		{
			$check = $this->filename;
		}
		else
		{
			$check = $this->file_name;
		}

		return $check;
	}

}