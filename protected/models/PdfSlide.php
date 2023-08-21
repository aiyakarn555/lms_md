<?php

/**
 * This is the model class for table "pdf_slide".
 *
 * The followings are the available columns in table 'pdf_slide':
 * @property integer $image_slide_id
 * @property integer $file_id
 * @property string $image_slide_name
 * @property string $image_slide_time
 */
class PdfSlide extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PdfSlide the static model class
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
		return 'pdf_slide';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_id', 'numerical', 'integerOnly'=>true),
			array('image_slide_name', 'length', 'max'=>255),
			array('image_slide_time', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('image_slide_id, file_id, image_slide_name, image_slide_time', 'safe', 'on'=>'search'),
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
			'image_slide_id' => 'Image Slide',
			'file_id' => 'File',
			'image_slide_name' => 'Image Slide Name',
			'image_slide_time' => 'Image Slide Time',
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

		$criteria->compare('image_slide_id',$this->image_slide_id);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('image_slide_name',$this->image_slide_name,true);
		$criteria->compare('image_slide_time',$this->image_slide_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}