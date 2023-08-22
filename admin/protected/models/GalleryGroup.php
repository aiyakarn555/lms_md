<?php

/**
 * This is the model class for table "{{gallery_group}}".
 *
 * The followings are the available columns in table '{{gallery_group}}':
 * @property integer $id
 * @property integer $gallery_type_name
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class GalleryGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gallery_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gallery_type_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gallery_type_name, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'gType' => array(self::BELONGS_TO, 'GalleryType', 'gallery_type_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			//'gallerycount'=>array(self::STAT, 'Gallery', 'gallery_type_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'gallery_type_id' => 'ประเภทรูปภาพ',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
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
	public function beforeSave() 
	{
		if(Yii::app()->user !== null && isset(Yii::app()->user->id))
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
				'alias' => 'gallerygroup',
				'order' => ' gallerygroup.id DESC ',
				'condition' => ' gallerygroup.active = "y" ',
			);	
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'gallerygroup',
				'order' => ' gallerygroup.id DESC ',
			);	
		}

		return $checkScopes;
	}

	public function scopes()
	{
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("gallerygroup.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'gallerygroupcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'gallerygroupcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				$scopes = array(
					'gallerygroupcheck'=>array(
						'alias' => 'gallerygroup',
						'order' => ' gallerygroup.id DESC ',
						'condition' => ' gallerygroup.active = "y" ',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        
        $criteria->with = array('gType');
		$criteria->compare('id',$this->id);
		$criteria->compare('gallery_type_id',$this->gallery_type_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

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
	 * @return GalleryGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
