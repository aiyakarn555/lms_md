<?php

/**
 * This is the model class for table "{{signature}}".
 *
 * The followings are the available columns in table '{{signature}}':
 * @property integer $sign_id
 * @property string $sign_title
 * @property string $sign_position
 * @property integer $sign_hide
 * @property string $sign_path
 * @property string $create_date
 * @property string $create_by
 * @property integer $active
 */
class Signature extends AActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{signature}}';
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

        if($this->isNewRecord)
        {
            $this->create_by = $id;
            $this->create_date = date("Y-m-d H:i:s");
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
			
			array('sign_title,sign_position', 'required'),
			array('sign_hide', 'numerical', 'integerOnly'=>true),
			array('sign_title, sign_position, sign_path, create_by', 'length', 'max'=>255),
			array('create_date, news_per_page', 'safe'),
			array('active', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sign_id, sign_title, sign_position, sign_hide, sign_path, create_date, create_by, active', 'safe', 'on'=>'search'),
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
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sign_id' => 'Sign',
			'sign_title' => 'ชื่อลายเซ็นต์',
			'sign_position' => 'ตำแหน่ง',
			'sign_hide' => 'เปิด/ปิด การแสดงผล (ไม่ได้ลบนะ ปิดเฉยๆ)',
			'sign_path' => 'รูปภาพ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'active' => '0=ลบ',
		);
	}

	public function afterFind()
	{
		$this->sign_title = CHtml::decode($this->sign_title);
		$this->sign_position = CHtml::decode($this->sign_position);
		$this->sign_path = CHtml::decode($this->sign_path);

		return parent::afterFind();
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

		$criteria->compare('sign_id',$this->sign_id);
		$criteria->compare('sign_title',$this->sign_title,true);
		$criteria->compare('sign_position',$this->sign_position,true);
		$criteria->compare('sign_hide',$this->sign_hide);
		$criteria->compare('sign_path',$this->sign_path,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);

		$poviderArray = array('criteria'=>$criteria);



        // Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

		return new CActiveDataProvider($this, $poviderArray);
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'signature',
				'order' => ' signature.sign_id DESC ',
				'condition' => ' signature.active ="y"',
			);
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'signature',
				'order' => ' signature.sign_id DESC ',
			);
		}

		return $checkScopes;
	}

	public function scopes(){
		$Access = Controller::SetAccess( array("Signature.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);

		if($Access == true)
		{
			$scopes =  array(
				'signaturecheck' => $this->checkScopes('scopes')
			);

		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
				{
					$scopes =  array(
						'signaturecheck' => $this->checkScopes('scopes')
					);

				}
				else
				{
					if($user->superuser == 1){
						$scopes = array(
							'signaturecheck'=>array(
								'alias' => 'signature',
								'condition' => 'signature.active="y" ',
								'order' => ' signature.sign_id DESC ',
							),
						);
					}else{
						$scopes = array(
							'signaturecheck'=>array(
								'alias' => 'signature',
								'condition' => ' signature.create_by = "'.Yii::app()->user->id.'" AND signature.active="y" ',
								'order' => ' signature.sign_id DESC ',
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

		public function getStatus(){
			if($this->sign_hide == 1){
				return "แสดงผล";
			} else {
				return "ปิดการแสดงผล";
			}
		}

		public function getId()
		{
			return $this->sign_id;
		}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Signature the static model class
	 */
}
