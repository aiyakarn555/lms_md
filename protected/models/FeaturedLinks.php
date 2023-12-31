<?php

/**
 * This is the model class for table "{{featured_links}}".
 *
 * The followings are the available columns in table '{{featured_links}}':
 * @property integer $link_id
 * @property string $link_image
 * @property string $link_name
 * @property string $link_url
 * @property integer $active
 * @property string $createby
 * @property string $createdate
 * @property string $updateby
 * @property string $updatedate
 */
class FeaturedLinks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	const STATUS_ACTIVE=1;
	public $id;

	public function tableName()
	{
		return '{{featured_links}}';
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
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active', 'numerical', 'integerOnly'=>true),
			array('link_name, link_url, createby, updateby', 'length', 'max'=>255),
			array('createdate, updatedate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('link_id, link_image, link_name, link_url, active, createby, createdate, updateby, updatedate', 'safe', 'on'=>'search'),
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

	public function defaultScope()
    {
        return array(          
            'condition'=>'active="'.self::STATUS_ACTIVE.'"',        
        );
    }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'link_id' => 'Link',
			'link_image' => 'Link Image',
			'link_name' => 'Link Name',
			'link_url' => 'Link Url',
			'active' => 'Active',
			'createby' => 'Createby',
			'createdate' => 'Createdate',
			'updateby' => 'Updateby',
			'updatedate' => 'Updatedate',
		);
	}
	public function getId(){
		return $this->id = $this->link_id;
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

		$criteria->compare('link_id',$this->link_id);
		$criteria->compare('link_image',$this->link_image,true);
		$criteria->compare('link_name',$this->link_name,true);
		$criteria->compare('link_url',$this->link_url,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('createby',$this->createby,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('updateby',$this->updateby,true);
		$criteria->compare('updatedate',$this->updatedate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FeaturedLinks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
