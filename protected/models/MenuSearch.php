<?php

/**
 * This is the model class for table "{{menu_search}}".
 *
 * The followings are the available columns in table '{{menu_search}}':
 * @property string $label_search_result
 * @property string $label_homepage
 * @property string $label_searchAll
 * @property string $label_list
 * @property string $label_result
 * @property integer $lang_id
 * @property integer $parent_id
 */
class MenuSearch extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_search}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('label_search_result, label_homepage,label_usability,label_news,label_courseOnline,label_vdo,label_document,label_imgslide', 'length', 'max'=>255),
			array('label_searchAll, label_list, label_result', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('label_search_result, label_homepage, label_searchAll, label_list, label_result,label_usability,label_news,label_courseOnline,label_vdo,label_document,label_imgslide, lang_id, parent_id', 'safe', 'on'=>'search'),
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
			'label_search_result' => 'Label Search Result',
			'label_homepage' => 'Label Homepage',
			'label_searchAll' => 'Label Search All',
			'label_list' => 'Label List',
			'label_result' => 'Label Result',
			'label_usability' => 'Label Usability',
			'label_news' => 'Label News',
			'label_courseOnline' => 'Label CourseOnline',
			'label_vdo' => 'Label Vdo',
			'label_document' => 'Label Document',
			'label_imgslide' => 'Label Lmgslide',
			'lang_id' => 'Lang',
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

		$criteria->compare('label_search_result',$this->label_search_result,true);
		$criteria->compare('label_homepage',$this->label_homepage,true);
		$criteria->compare('label_searchAll',$this->label_searchAll,true);
		$criteria->compare('label_list',$this->label_list,true);
		$criteria->compare('label_result',$this->label_result,true);
		$criteria->compare('label_usability',$this->label_usability,true);
		$criteria->compare('label_news',$this->label_news,true);
		$criteria->compare('label_courseOnline',$this->label_courseOnline,true);
		$criteria->compare('label_vdo',$this->label_vdo,true);
		$criteria->compare('label_document',$this->label_document,true);
		$criteria->compare('label_imgslide',$this->label_imgslide,true);
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
	 * @return MenuSearch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
