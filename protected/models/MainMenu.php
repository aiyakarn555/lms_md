<?php

/**
 * This is the model class for table "main_menu".
 *
 * The followings are the available columns in table 'main_menu':
 * @property integer $id
 * @property string $title
 * @property integer $lang_id
 * @property string $status
 */
class MainMenu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'main_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			array('title, url, parent_id, lang_id, active', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, lang_id, status, url, parent_id, active', 'safe', 'on'=>'search'),
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
			'lang' => array(self::BELONGS_TO, 'Language', 'lang_id'),
			'parent' => array(self::BELONGS_TO, 'MainMenu', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'ชื่อเมนู',
			'lang_id' => 'ภาษา',
			'status' => 'แสดงผล',
			'parent_id' => 'เมนูหลัก'
		);
	}

	public function getMainMenuList(){
		$model = MainMenu::model()->findAllByAttributes(array('status'=>'y','parent_id' => '0'));
		return CHtml::listData($model,'id','title');
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
		$criteria->compare('active','y');
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('url',$this->url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MainMenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
