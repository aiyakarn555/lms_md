<?php

/**
 * This is the model class for table "config_captcha".
 *
 * The followings are the available columns in table 'config_captcha':
 * @property integer $capid
 * @property string $capt_name
 * @property integer $capt_time_random
 * @property integer $capt_time_back
 * @property integer $capt_wait_time
 * @property integer $capt_times
 * @property string $capt_hide
 * @property string $capt_active
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class ConfigCaptcha extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'config_captcha';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('capt_name, capt_time_random, capt_time_back, capt_wait_time, capt_times,type', 'required'),
			array('capt_name, capt_wait_time, capt_times,type', 'required'),
			array('capt_time_random, capt_time_back, capt_wait_time, capt_times, created_by, updated_by,slide,prev_slide', 'numerical', 'integerOnly'=>true),
			array('capt_name', 'length', 'max'=>255),
			array('capt_hide, capt_active', 'length', 'max'=>1),
			array('created_date, updated_date,type', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('capid, capt_name, capt_time_random, capt_time_back, capt_wait_time, capt_times, capt_hide, capt_active, created_by, created_date, updated_by, updated_date,type', 'safe', 'on'=>'search'),
		);
	}

    protected function afterSave()
    {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        parent::afterSave();
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'capRelation' => array(self::BELONGS_TO, 'ConfigCaptchaCourseRelation', array('capid'=>'captid')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'capid' => 'Capid',
			'capt_name' => 'ชื่อเงื่อนไข',
			'capt_time_random' => 'ระยะเวลาการแสดงแคปช่า (ทุกๆนาที)',
			'capt_time_back' => 'กำหนดการเรียนย้อนหลัง',
			'capt_wait_time' => 'ระยะเวลาการตอบ',
			'capt_times' => 'จำนวนครั้งที่ตอบผิด',
			'capt_hide' => 'แสดงผล',
			'capt_active' => 'Capt Active',
			'created_by' => 'สร้าง',
			'created_date' => 'สร้างเมื่อ',
			'updated_by' => 'แก้ไข',
			'updated_date' => 'แก้ไขเมื่อ',
			'type' => 'ชนิด',
			'slide' => 'จำนวนสไลด์ที่เด้ง',
			'prev_slide' => 'จำนวนสไลด์ที่ย้อนกลับ',
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

		$criteria->compare('capid',$this->capid);
		$criteria->compare('capt_name',$this->capt_name,true);
		$criteria->compare('capt_time_random',$this->capt_time_random);
		$criteria->compare('capt_time_back',$this->capt_time_back);
		$criteria->compare('capt_wait_time',$this->capt_wait_time);
		$criteria->compare('capt_times',$this->capt_times);
		$criteria->compare('capt_hide',$this->capt_hide,true);
		$criteria->compare('capt_active',$this->capt_active,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'configcaptcha',
				'order' => ' configcaptcha.capid DESC ',
				'condition' => ' configcaptcha.capt_active = "y" ',
			);
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'configcaptcha',
				'order' => ' configcaptcha.capid DESC ',
			);
		}

		return $checkScopes;
	}

	public function scopes()
	{
		//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Faq.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);

		if($Access == true)
		{
			$scopes =  array(
				'configcaptchacheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array(
					'configcaptchacheck' => $this->checkScopes('scopes')
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'configcaptchacheck'=>array(
							'alias' => 'configcaptcha',
							'condition' => ' configcaptcha.capt_active = "y" ',
							'order' => ' configcaptcha.capid DESC ',
						),
					);
				}else{
					$scopes = array(
						'configcaptchacheck'=>array(
							'alias' => 'configcaptcha',
							'condition' => '  configcaptcha.create_by = "'.Yii::app()->user->id.'" AND configcaptcha.capt_active = "y" ',
							'order' => ' configcaptcha.capid DESC ',
						),
					);
				}
			}
		}

		return $scopes;
	}

	public function defaultScope()
	{
		$defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConfigCaptcha the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
