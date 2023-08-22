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

class DocumentType extends CActiveRecord
{
	public $labelState = false;
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
			array('lang_id, reference', 'numerical', 'integerOnly'=>true),
			array('dty_name, createby, updateby', 'length', 'max'=>100),
			array('dty_name', 'required'),
			array('active', 'length', 'max'=>1),
			array('createdate, updatedate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dty_id, dty_name, active, createby, createdate, updateby, updatedate, lang_id,parent_id, reference', 'safe', 'on'=>'search'),
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
		if(!$this->labelState){
            $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        }
		// $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'dty_id' => 'รหัสประเภทไฟล์ดาวน์โหลด',
			'dty_name' => 'ชื่อประเภทการดาวน์โหลด'.$label_lang,
			'active' => 'สถานะของข้อมูล
1 = แสดงผล
2 = ไม่แสดงผล'.$label_lang,
			'createby' => 'ผู้สร้างข้อมูล',
			'createdate' => 'วันที่ทำการสร้างข้อมูล'.$label_lang,
			'updateby' => 'ผู้ทำการปรับปรุงข้อมูล',
			'updatedate' => 'วันที่ทำการปรับปรุงข้อมูล'.$label_lang,
			'lang_id' => 'รหัสภาษา',
			'reference' => 'รหัสอ้างอิง',
		);
	}

	public function defaultScope()
	{
	    $defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

	public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
			    'alias' => 'documenttype',
			    'order' => ' documenttype.dty_id DESC ',
		    	'condition' => ' documenttype.active = 1 ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
			    'alias' => 'documenttype',
			    'order' => ' documenttype.dty_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

    public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("DocumentType.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);

		if($Access == true)
		{
			$scopes =  array( 
				'documenttype' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'documenttype' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				if($user->superuser == 1){
					$scopes = array(
						'courseonlinecheck'=>array(
							'alias' => 'courseonline',
							'condition' => ' courseonline.active = "y" ',
							'order' => ' courseonline.course_id DESC ',
						),
					);
				}else{
					$scopes = array(
						'documenttype'=>array(
							'alias' => 'documenttype',
							'condition' => ' documenttype.createby = "'.Yii::app()->user->id.'" AND documenttype.active = 1 ',
							'order' => ' documenttype.dty_id DESC ',
						),
					);
				}
			    
			    // $scopes = array(
		     //        'courseonlinecheck'=>array(
			    // 		'alias' => 'courseonline',
			    // 		'condition' => ' courseonline.active = "y" ',
			    // 		'order' => ' courseonline.course_id DESC ',
		     //        ),
			    // );
			}
		}

		return $scopes;
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
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',0);
		$criteria->compare('reference',$this->reference);
		$criteria->compare('active',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DocumentType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
