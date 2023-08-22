<?php

/**
 * This is the model class for table "{{msteams_document}}".
 *
 * The followings are the available columns in table '{{msteams_document}}':
 * @property integer $id
 * @property integer $ms_teams_id
 * @property integer $ms_teams_temp_id
 * @property integer $user_id
 * @property string $file_name
 * @property string $file_address
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $active
 * @property integer $gen_id
 */
class MsteamsDocument extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{msteams_document}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ms_teams_id, ms_teams_temp_id, user_id, created_by, updated_by, gen_id', 'numerical', 'integerOnly'=>true),
			array('file_name, file_address', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ms_teams_id, ms_teams_temp_id, user_id, file_name, file_address, created_date, created_by, updated_date, updated_by, active, gen_id', 'safe', 'on'=>'search'),
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
			'ms_teams_id' => 'Ms Teams',
			'ms_teams_temp_id' => 'Ms Teams Temp',
			'user_id' => 'User',
			'file_name' => 'File Name',
			'file_address' => 'File Address',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'active' => 'Active',
			'gen_id' => 'Gen',
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
		$criteria->compare('ms_teams_id',$this->ms_teams_id);
		$criteria->compare('ms_teams_temp_id',$this->ms_teams_temp_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_address',$this->file_address,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('gen_id',$this->gen_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave() 
	{
		if(Yii::app()->user !== null && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 0;
		}
		

		if($this->isNewRecord)
		{
			$this->created_by = $id;
			$this->created_date = date("Y-m-d H:i:s");
		}
		else
		{
			$this->updated_by = $id;
			$this->updated_date = date("Y-m-d H:i:s");
		}

		return parent::beforeSave();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MsteamsDocument the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
