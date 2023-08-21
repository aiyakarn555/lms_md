<?php

/**
 * This is the model class for table "{{province}}".
 *
 * The followings are the available columns in table '{{province}}':
 * @property integer $pv_id
 * @property string $pv_name_th
 * @property string $pv_name_en
 */
class Province extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Province the static model class
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
		return '{{province}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pv_name_th, pv_name_en', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pv_id, pv_name_th, pv_name_en', 'safe', 'on'=>'search'),
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

	public function getProvinceList(){
		$model = Province::model()->findAll();
		$list = CHtml::listData($model,'pv_id','pv_name_th');
		return $list;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pv_id' => 'Pv',
			'pv_name_th' => 'Pv Name Th',
			'pv_name_en' => 'Pv Name En',
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

		$criteria->compare('pv_id',$this->pv_id);
		$criteria->compare('pv_name_th',$this->pv_name_th,true);
		$criteria->compare('pv_name_en',$this->pv_name_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}