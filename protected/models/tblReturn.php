<?php

/**
 * This is the model class for table "{{return}}".
 *
 * The followings are the available columns in table '{{return}}':
 * @property integer $return_id
 * @property integer $user_id
 * @property integer $lesson_id
 */
class tblReturn extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{return}}';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('return_id, user_id, lesson_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('return_id, user_id, lesson_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'return_id' => 'Return',
			'user_id' => 'User',
			'lesson_id' => 'Lesson',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('return_id',$this->return_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('lesson_id',$this->lesson_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function defaultScope()
	{
	    return array(
	    	'alias'=>'return',
	    	'condition' => ' return.user_id = "'.Yii::app()->user->id.'" ',
	    );
	}

}