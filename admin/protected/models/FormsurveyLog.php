<?php

/**
 * This is the model class for table "{{formsurvey_log}}".
 *
 * The followings are the available columns in table '{{formsurvey_log}}':
 * @property integer $fl_id
 * @property integer $fs_id
 * @property integer $fsh_id
 * @property string $fsl_value
 * @property integer $user_id
 * @property string $form_type
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 */
class FormsurveyLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsurveyLog the static model class
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
		return '{{formsurvey_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fs_id, fsh_id, user_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('fsl_value', 'length', 'max'=>255),
			array('form_type', 'length', 'max'=>50),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fl_id, fs_id, fsh_id, fsl_value, user_id, form_type, create_date, create_by, update_date, update_by', 'safe', 'on'=>'search'),
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
			'fl_id' => 'Fl',
			'fs_id' => 'Fs',
			'fsh_id' => 'Fsh',
			'fsl_value' => 'Fsl Value',
			'user_id' => 'User',
			'form_type' => 'Form Type',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
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

		$criteria->compare('fl_id',$this->fl_id);
		$criteria->compare('fs_id',$this->fs_id);
		$criteria->compare('fsh_id',$this->fsh_id);
		$criteria->compare('fsl_value',$this->fsl_value,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('form_type',$this->form_type,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

		public function beforeSave() 
    {
		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 0;
		}	

		if($this->isNewRecord)
		{
			$this->user_id = $id;
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		else
		{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}

        return parent::beforeSave();
    }

}