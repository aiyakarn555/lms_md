<?php

/**
 * This is the model class for table "{{formsurvey}}".
 *
 * The followings are the available columns in table '{{formsurvey}}':
 * @property string $fs_id
 * @property string $fs_head
 * @property string $fs_title
 * @property string $fs_type
 * @property string $startdate
 * @property string $enddate
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $fg_id
 */
class Formsurvey extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Formsurvey the static model class
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
		return '{{formsurvey}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by, fg_id', 'numerical', 'integerOnly'=>true),
			array('fs_head', 'length', 'max'=>255),
			array('fs_type', 'length', 'max'=>50),
			array('active', 'length', 'max'=>1),
			array('fs_title, startdate, enddate, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fs_id, fs_head, fs_title, fs_type, startdate, enddate, create_date, create_by, update_date, update_by, active, fg_id', 'safe', 'on'=>'search'),
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
			'FormSurveyHeader' => array(self::HAS_MANY, 'FormSurveyHeader', 'fs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fs_id' => 'Fs',
			'fs_head' => 'หัวข้อแบบสอบถาม',
			'fs_title' => 'แบบสอบถาม',
			'fs_type' => 'Fs Type',
			'startdate' => 'Startdate',
			'enddate' => 'Enddate',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'fg_id' => 'Fg',
		);
	}
	
	public function defaultScope()
	{
	    return array(
	    	'alias' => 'formsurvey',
	    	'order' => 'formsurvey.fs_id desc',
	    	'condition' => 'formsurvey.status_approve = "y"',
	    );
	}
	
	public function getCheckForm($fsid){
		$userid=Yii::app()->user->id;

		$model = FormsurveyLog::model()->findAll(array(
			'condition' => 'fs_id = "'.$fsid.'" AND user_id = "'.Yii::app()->user->id.'" '
		));
			
			
		$model=count($model);
		if($model>="1"){
			echo "คุณได้ทำแบบสอบถามแล้ว";
		}
		else
		{
			//echo 
			echo CHtml::link("ทำ",Yii::app()->createUrl("FormsurveyGroup/survey",array("id"=>$this->fs_id,"survey"=>$this->fg_id)), array("target"=>"_blank"));
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('fs_id',$this->fs_id,true);
		$criteria->compare('fs_head',$this->fs_head,true);
		$criteria->compare('fs_title',$this->fs_title,true);
		$criteria->compare('fs_type',$this->fs_type,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('fg_id',$this->fg_id);
		$criteria->addCondition('fg_id ="'.$id.'"');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}