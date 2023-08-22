<?php

/**
 * This is the model class for table "{{ship}}".
 *
 * The followings are the available columns in table '{{ship}}':
 * @property integer $ship_id
 * @property string $ship_name
 * @property string $ship_name_en
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Ship extends CActiveRecord
{
	public $news_per_page;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ship}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('ship_name, ship_name_en', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date, news_per_page', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('news_per_page, ship_id, ship_name, ship_name_en, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ship_id' => 'Ship',
			'ship_name' => 'ชื่อเรือ',
			'ship_name_en' => 'ชื่อเรือ(EN)',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
		);
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
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		else
		{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}

        return parent::beforeSave();
    }
    public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'ship',
				'order' => ' ship.ship_id DESC ',
				'condition' => ' ship.active = "y" ',
			);	
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'ship',
				'order' => ' ship.ship_id DESC ',
			);	
		}

		return $checkScopes;
	}

	public function scopes()
	{
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("ship.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'shipcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'shipcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				$scopes = array(
					'shipcheck'=>array(
						'alias' => 'ship',
						'order' => ' ship.ship_id DESC ',
						'condition' => ' ship.active = "y" ',
					),
				);
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

		$criteria->compare('ship_id',$this->ship_id);
		$criteria->compare('ship_name',$this->ship_name,true);
		$criteria->compare('ship_name_en',$this->ship_name_en,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));
		$poviderArray = array('criteria'=>$criteria);

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
	 * @return Ship the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
