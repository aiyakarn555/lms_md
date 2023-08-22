<?php

/**
 * This is the model class for table "{{company}}".
 *
 * The followings are the available columns in table '{{company}}':
 * @property integer $company_id
 * @property string $company_title
 * @property string $create_date
 * @property string $active
 */
class Company extends CActiveRecord
{
	public $news_per_page;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{company}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_title', 'length', 'max'=>200),
			array('active', 'length', 'max'=>2),
			array('company_id,create_date, news_per_page,lang_id,parent_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('company_id, company_title, create_date, active,lang_id,parent_id', 'safe', 'on'=>'search'),
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
		if(empty($this->lang_id)){
			$this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		}else{
			$this->lang_id = $this->lang_id;
		}
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'company_id' => 'ฝ่าย',
			'company_title' => 'ชื่อฝ่าย'.$label_lang,
			'create_date' => 'Create Date'.$label_lang,
			'active' => 'Active',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
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

		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('company_title',$this->company_title,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('active',y);
		$criteria->compare('parent_id',0);
 		$poviderArray = array('criteria'=>$criteria);

        // Page
        if(isset($this->news_per_page))
        {
            $poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
        }
		return new CActiveDataProvider($this, $poviderArray);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Company the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	
	public function beforeSave()
    {
        if(null !== Yii::app()->user && isset(Yii::app()->user->id))
            $id = Yii::app()->user->id;
        else
            $id = 0;

        if($this->isNewRecord){
            // $this->create_by = $id;
            $this->create_date = date("Y-m-d H:i:s");
            // $this->update_by = $id;
            // $this->update_date = date("Y-m-d H:i:s");
        }else{
            // $this->update_by = $id;
            $this->create_date = date("Y-m-d H:i:s");
        }
        return parent::beforeSave();
    }
    
    public function getCompanyList(){
		$model = Company::model()->findAll('active = "y"');
		$list = CHtml::listData($model,'company_id','company_title');
		return $list;
	}
}
