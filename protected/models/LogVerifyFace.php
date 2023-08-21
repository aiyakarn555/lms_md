<?php

/**
 * This is the model class for table "{{log_verify_face}}".
 *
 * The followings are the available columns in table '{{log_verify_face}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $liveness_score
 * @property string $liveness_class
 * @property string $validated_class
 * @property string $validated_score
 * @property string $create_date
 * @property string $type
 * @property string $status
 */
class LogVerifyFace extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{log_verify_face}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('liveness_score, validated_score', 'length', 'max'=>18),
			array('liveness_class, validated_class, type, status', 'length', 'max'=>255),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, liveness_score, liveness_class, validated_class, validated_score, create_date, type, status', 'safe', 'on'=>'search'),
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
			'liveness_score' => 'Liveness Score',
			'liveness_class' => 'Liveness Class',
			'validated_class' => 'Validated Class',
			'validated_score' => 'Validated Score',
			'capture_id' => 'Capture',
			'create_date' => 'Create Date',
			'type' => 'Type',
			'status' => 'Status',
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
		$criteria->compare('capture_id',$this->capture_id);
		$criteria->compare('liveness_score',$this->liveness_score,true);
		$criteria->compare('liveness_class',$this->liveness_class,true);
		$criteria->compare('validated_class',$this->validated_class,true);
		$criteria->compare('validated_score',$this->validated_score,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogVerifyFace the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
