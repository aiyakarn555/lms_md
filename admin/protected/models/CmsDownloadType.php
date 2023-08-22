<?php

/**
 * This is the model class for table "cms_download_type".
 *
 * The followings are the available columns in table 'cms_download_type':
 * @property integer $dty_id
 * @property string $dty_name
 * @property string $active
 * @property string $createby
 * @property string $createdate
 * @property string $updateby
 * @property string $updatedate
 * @property integer $lan_id
 * @property integer $reference
 */
class CmsDownloadType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_download_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lan_id, reference', 'numerical', 'integerOnly'=>true),
			array('dty_name, createby, updateby', 'length', 'max'=>100),
			array('active', 'length', 'max'=>1),
			array('createdate, updatedate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dty_id, dty_name, active, createby, createdate, updateby, updatedate, lan_id, reference', 'safe', 'on'=>'search'),
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
			'dty_id' => 'Dty',
			'dty_name' => 'Dty Name',
			'active' => 'Active',
			'createby' => 'Createby',
			'createdate' => 'Createdate',
			'updateby' => 'Updateby',
			'updatedate' => 'Updatedate',
			'lan_id' => 'Lan',
			'reference' => 'Reference',
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

		$criteria->compare('dty_id',$this->dty_id);
		$criteria->compare('dty_name',$this->dty_name,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('createby',$this->createby,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('updateby',$this->updateby,true);
		$criteria->compare('updatedate',$this->updatedate,true);
		$criteria->compare('lan_id',$this->lan_id);
		$criteria->compare('reference',$this->reference);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CmsDownloadType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
