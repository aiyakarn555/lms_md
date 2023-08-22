<?php

/**
 * This is the model class for table "{{library_file}}".
 *
 * The followings are the available columns in table '{{library_file}}':
 * @property integer $library_id
 * @property integer $sortOrder
 * @property integer $library_type_id
 * @property string $library_name
 * @property string $library_name_en
 * @property string $library_filename
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */


class LibraryFile extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{library_file}}';
	}

	public function beforeSave() 
	{
		if($this->isNewRecord){
			$this->created_by =  Yii::app()->user->id;
			$this->created_date = date("Y-m-d H:i:s");
		} else{
			$this->updated_by = Yii::app()->user->id;
			$this->updated_date = date("Y-m-d H:i:s");
		}

		return parent::beforeSave();
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(			
			// nameFunction on scenario
			array('library_name_en', 'validateCheckk', 'on' => 'validateCheckk'),
			array('library_type_id, library_name, library_name_en, status_ebook', 'required'),			
			array('sortOrder, library_type_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('library_name, library_name_en, library_filename', 'length', 'max'=>255),
			array('created_date, updated_date, active', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('library_id, sortOrder, library_type_id, library_name, library_name_en, library_filename, created_by, created_date, updated_by, updated_date, active, status_ebook', 'safe', 'on'=>'search'),
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
			'usercreate' => array(self::BELONGS_TO, 'User', 'created_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'updated_by'),
			'type' => array(self::BELONGS_TO, 'LibraryType', 'library_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'library_id' => 'Library',
			'sortOrder' => 'Sort Order',
			'library_type_id' => 'ประเภท',
			'library_name' => 'ชื่อไฟล์ (TH)',
			'library_name_en' => 'ชื่อไฟล์ (EN) ห้ามมีสัญลักษณ์พิเศษและช่องว่าง',
			'library_filename' => 'ไฟล์',
			'created_by' => 'ผู้สร้าง',
			'created_date' => 'วันที่สร้าง',
			'updated_by' => 'ผู้แก้ไข',
			'updated_date' => 'วันที่แก้ไข',
			'active' => 'active',
			'status_ebook' => 'เป็นไฟล์ E-Book'
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

		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('sortOrder',$this->sortOrder);
		$criteria->compare('library_type_id',$this->library_type_id);
		$criteria->compare('library_name',$this->library_name,true);
		$criteria->compare('library_name_en',$this->library_name_en,true);
		$criteria->compare('library_filename',$this->library_filename,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('status_ebook',$this->status_ebook,true);

		


		$criteria->order = 'sortOrder ASC';
		


		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($_GET['LibraryFile']['news_per_page']))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($_GET['LibraryFile']['news_per_page']) );
		}
		
		return new CActiveDataProvider($this, $poviderArray);

		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));
	}

	public function validateCheckk(){
		
		if($this->library_id != null){
			$model = LibraryFile::model()->findAll("active='y' AND library_name_en='".$this->library_name_en."' AND library_id!='".$this->library_id."'");
			if(!empty($model)){
				$this->addError('library_name_en', 'ชื่อไฟล์ (EN) ซ้ำ');
				return  false;
			}
		}else{
			$model = LibraryFile::model()->findAll("active='y' AND library_name_en='".$this->library_name_en."'");
			if(!empty($model)){
				var_dump("false");
				$this->addError('library_name_en', 'ชื่อไฟล์ (EN) ซ้ำ');
				return false;	
			}
		}
		return true;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibraryFile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
