<?php

/**
 * This is the model class for table "{{contactus_new}}".
 *
 * The followings are the available columns in table '{{contactus_new}}':
 * @property integer $con_id
 * @property string $con_firstname
 * @property string $con_lastname
 * @property string $con_firstname_en
 * @property string $con_lastname_en
 * @property string $con_position
 * @property string $con_tel
 * @property string $con_email
 * @property string $con_image
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class ContactusNew extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contactus_new}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by, sortOrder', 'numerical', 'integerOnly'=>true),
			array('con_firstname, con_lastname, con_firstname_en, con_lastname_en, con_position, con_email, con_tel, con_position_en', 'required'),
			array('con_firstname, con_lastname, con_firstname_en, con_lastname_en, con_position, con_email, con_image, con_position_en', 'length', 'max'=>255),
			array('con_tel', 'length', 'max'=>50),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			array('con_image','required', 'on'=>'insert'),
			array('con_image', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true, 'safe' => false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('con_id, con_firstname, con_lastname, con_firstname_en, con_lastname_en, con_position, con_tel, con_email, con_position_en, con_image, create_date, create_by, update_date, update_by, active, sortOrder, news_per_page', 'safe', 'on'=>'search'),
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
			'id' => 'Con',
			'con_firstname' => 'firstname TH',
			'con_lastname' => 'lastname TH',
			'con_firstname_en' => 'firstname EN',
			'con_lastname_en' => 'lastname EN',
			'con_position' => 'position TH',
			'con_position_en' => 'position EN',
			'con_tel' => 'phone',
			'con_email' => 'E-mail',
			'con_image' => 'image',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'sortOrder'=>'sortOrder',
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
		$criteria->compare('con_firstname',$this->con_firstname,true);
		$criteria->compare('con_lastname',$this->con_lastname,true);
		$criteria->compare('con_firstname_en',$this->con_firstname_en,true);
		$criteria->compare('con_lastname_en',$this->con_lastname_en,true);
		$criteria->compare('con_position',$this->con_position,true);
		$criteria->compare('con_position_en',$this->con_position_en,true);
		$criteria->compare('con_tel',$this->con_tel,true);
		$criteria->compare('con_email',$this->con_email,true);
		$criteria->compare('con_image',$this->con_image,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		//$criteria->compare('sortOrder',$this->sortOrder,true);
		$criteria->order = 'sortOrder DESC';
    //var_dump($criteria);
		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));
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
	 * @return ContactusNew the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'ContactusNews',
		    	'order' => ' ContactusNews.sortOrder ASC ',
		    	'condition' => ' ContactusNews.active = "y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'ContactusNews',
		    	'order' => ' ContactusNews.sortOrder ASC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("ContactusNew.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);
		if($Access == true)
		{
			$scopes =  array( 
				'ContactusNewcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'ContactusNewcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'ContactusNewcheck'=>array(
							'alias' => 'ContactusNews',
							'order' => ' ContactusNews.sortOrder ASC ',
							'condition' => 'ContactusNews.active = "y" ',
						),
					);
				}else{
					$scopes = array(
						'ContactusNewcheck'=>array(
							'alias' => 'ContactusNews',
							'order' => ' ContactusNews.sortOrder ASC ',
							'condition' => ' ContactusNews.create_by = "'.Yii::app()->user->id.'" AND ContactusNews.active = "y" ',
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

   	public function beforeSave() 
    {
    	// $this->vdo_title = CHtml::encode($this->vdo_title);
    	// $this->vdo_path = CHtml::encode($this->vdo_path);
    	// $this->vdo_thumbnail = CHtml::encode($this->vdo_thumbnail);

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
}
