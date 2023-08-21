<?php

/**
 * This is the model class for table "mt_code_md".
 *
 * The followings are the available columns in table 'mt_code_md':
 * @property integer $id
 * @property string $code_md
 * @property string $name_md
 * @property integer $type
 */
class MtCodeMd extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mt_code_md';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code_md', 'unique'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('code_md, name_md,code_gm', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('code_md, name_md, type,code_gm,note', 'required'),
			array('id, code_md, name_md, type,code_gm,note', 'safe', 'on'=>'search'),
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
			'code_md' => ' รหัสหลักสูตร กรมเจ้าท่า',
			'name_md' => 'ชื่อหลักสูตร',
			'type' => 'ประเภท',
			'code_gm' => 'รหัสหลักสูตร GM',
			'note' => 'หมายเหตุการแนบเอกสาร',
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
		$criteria->compare('code_md',$this->code_md,true);
		$criteria->compare('name_md',$this->name_md,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('code_gm',$this->code_gm);
		$criteria->compare('note',$this->note);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MtCodeMd the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
