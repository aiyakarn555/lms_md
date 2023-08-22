<?php

/**
 * This is the model class for table "cms_download".
 *
 * The followings are the available columns in table 'cms_download':
 * @property integer $dow_id
 * @property string $dow_name
 * @property string $dow_address
 * @property integer $dow_count
 * @property integer $dow_show
 * @property string $dow_createday
 * @property string $dow_createby
 * @property string $dow_status
 * @property string $dow_datestart
 * @property string $dow_timestart
 * @property string $dow_dateend
 * @property string $dow_timeend
 * @property string $dow_detail
 * @property integer $dty_id
 * @property string $active
 * @property integer $createby_id
 * @property integer $createby_min
 * @property string $createby
 * @property string $createdate
 * @property string $updateby
 * @property string $updatedate
 * @property integer $lan_id
 * @property integer $reference
 * @property integer $dow_internet
 * @property integer $dow_intranet
 * @property integer $approve
 * @property string $category
 */
class Document extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_download';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dow_count, dow_show, dty_id, createby_id, createby_min, lang_id, reference, dow_internet, dow_intranet, approve', 'numerical', 'integerOnly'=>true),
			array('dow_name, dow_createby, createby, updateby', 'length', 'max'=>100),
			array('dow_address, dow_detail, category', 'length', 'max'=>255),
			array('dow_status, active', 'length', 'max'=>1),
			array('dow_name', 'required'),
			array('dow_createday, dow_datestart, dow_timestart, dow_dateend, dow_timeend, createdate, updatedate,lang_id,parent_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dow_id, dow_name, dow_address, dow_count, dow_show, dow_createday, dow_createby, dow_status, dow_datestart, dow_timestart, dow_dateend, dow_timeend, dow_detail, dty_id, active, createby_id, createby_min, createby, createdate, updateby, updatedate, lang_id, reference, dow_internet, dow_intranet, approve, category,parent_id', 'safe', 'on'=>'search'),
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
			'documentType' => array(self::BELONGS_TO, 'DocumentType', 'dty_id'),
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
			'dow_id' => 'รหัสการดาวน์โหลด',
			'dow_name' => 'ชื่อของไฟล์ดาวน์โหลด'.$label_lang,
			'dow_address' => 'ตำแหน่งที่ตั้งไฟล์'.$label_lang,
			'dow_count' => 'นับการดาวน์โหลด'.$label_lang,
			'dow_show' => 'นับจำนวนครั้งที่เข้าชม'.$label_lang,
			'dow_createday' => 'วันที่ทำการสร้าง'.$label_lang,
			'dow_createby' => 'ผู้ที่ทำการสร้าง'.$label_lang,
			'dow_status' => 'สถานะสิทธิ์การเข้าถึง
0 = ทั้งหมด
1 = บุคคลภายใน'.$label_lang,
			'dow_datestart' => 'วันที่ให้เริ่มการดาวน์โหลด'.$label_lang,
			'dow_timestart' => 'เวลาที่เริ่มดาวน์โหลด'.$label_lang,
			'dow_dateend' => 'วันที่สิ้นสุดการแสดงไฟล์'.$label_lang,
			'dow_timeend' => 'เวลาสิ้นสุดการดาวน์โหลด'.$label_lang,
			'dow_detail' => 'รายละเอียดไฟล์ดาวน์โหลด'.$label_lang,
			'dty_id' => 'รหัสประเภทของไฟล์'.$label_lang,
			'active' => 'สถานะของข้อมูล
1 = แสดงผล
2 = ไม่แสดงผล',
			'createby_id' => 'Createby',
			'createby_min' => 'Createby Min',
			'createby' => 'ผู้สร้างข้อมูล',
			'createdate' => 'วันที่ทำการสร้างข้อมูล',
			'updateby' => 'ผู้ทำการปรับปรุงข้อมูล',
			'updatedate' => 'วันที่ทำการปรับปรุงข้อมูล',
			'lang_id' => 'รหัสภาษา',
			'reference' => 'รหัสอ้างอิง',
			'dow_internet' => 'Dow Internet',
			'dow_intranet' => 'Dow Intranet',
			'approve' => 'Approve',
			'category' => 'Category',
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
        
        $criteria->with = array('documentType');
		$criteria->compare('dow_id',$this->dow_id);
		$criteria->compare('dow_name',$this->dow_name,true);
		$criteria->compare('dow_address',$this->dow_address,true);
		$criteria->compare('dow_count',$this->dow_count);
		$criteria->compare('dow_show',$this->dow_show);
		$criteria->compare('dow_createday',$this->dow_createday,true);
		$criteria->compare('dow_createby',$this->dow_createby,true);
		$criteria->compare('dow_status',$this->dow_status,true);
		$criteria->compare('dow_datestart',$this->dow_datestart,true);
		$criteria->compare('dow_timestart',$this->dow_timestart,true);
		$criteria->compare('dow_dateend',$this->dow_dateend,true);
		$criteria->compare('dow_timeend',$this->dow_timeend,true);
		$criteria->compare('dow_detail',$this->dow_detail,true);
		$criteria->compare('dty_id',$this->dty_id);
		$criteria->compare('t.active',1);
		$criteria->compare('createby_id',$this->createby_id);
		$criteria->compare('createby_min',$this->createby_min);
		// $criteria->compare('createby',$this->createby,true);
		$modelUser = Users::model()->findByPk(Yii::app()->user->id);
		$group = json_decode($modelUser->group);
		if (!in_array(1, $group)){
			$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
			$criteria->addInCondition('createby', $groupUser);	
		}
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('updateby',$this->updateby,true);
		$criteria->compare('updatedate',$this->updatedate,true);
		$criteria->compare('t.lang_id',$this->lang_id);
		$criteria->compare('reference',$this->reference);
		$criteria->compare('dow_internet',$this->dow_internet);
		$criteria->compare('dow_intranet',$this->dow_intranet);
		$criteria->compare('approve',$this->approve);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('t.parent_id',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Document the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getId()
	{
		return $this->dow_id;
	}

	public function beforeSave()
    {
    if(null !== Yii::app()->user && isset(Yii::app()->user->id))
       {
            $id = Yii::app()->user->id;
        }
            else
            {
                $id = 0;
            }


		// $profile = profile::model()->findpk('id'->$id);

		if($this->isNewRecord)
		{
			$this->createby = $id;
			$this->createdate = date("Y-m-d H:i:s");
			$this->updateby = $id;
			$this->updatedate = date("Y-m-d H:i:s");
		}
		else
		{
			$this->updateby = $id;
			$this->updatedate = date("Y-m-d H:i:s");
		}

        return parent::beforeSave();
    }

}
