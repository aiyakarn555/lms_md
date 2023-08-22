<?php

/**
 * This is the model class for table "{{menu_faq}}".
 *
 * The followings are the available columns in table '{{menu_faq}}':
 * @property integer $id
 * @property string $label_faq
 * @property string $label_homepage
 * @property string $label_ques
 * @property string $label_ans
 * @property integer $lang_id
 * @property integer $parent_id
 */
class MenuFaq extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_faq}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('label_faq, label_homepage', 'length', 'max'=>255),
			array('label_ques, label_ans', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_faq, label_homepage, label_ques, label_ans, lang_id, parent_id,label_noTopic,label_noDetail', 'safe', 'on'=>'search'),
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
			'label_faq' => 'ถาม-ตอบ',
			'label_homepage' => 'หน้าแรก',
			'label_ques' => 'ถาม',
			'label_ans' => 'ตอบ',
			'label_noTopic'=>'ยังไม่มีหัวข้อเนื้อหา',
			'label_noDetail'=>'ไม่มีเนื้อหา',
			'lang_id' => 'ภาษา',
			'parent_id' => 'Parent',
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
		$criteria->compare('label_faq',$this->label_faq,true);
		$criteria->compare('label_homepage',$this->label_homepage,true);
		$criteria->compare('label_ques',$this->label_ques,true);
		$criteria->compare('label_ans',$this->label_ans,true);
		$criteria->compare('label_noTopic',$this->label_ans,true);
		$criteria->compare('label_noDetail',$this->label_ans,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuFaq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
