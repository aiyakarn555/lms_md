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
class FeaturedLinks extends AActiveRecord
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
			array('link_name, link_url, link_image', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('link_name, link_url, createby, updateby', 'length', 'max'=>255),
			array('createdate, updatedate,news_per_page', 'safe'),
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
			'usercreate' => array(self::BELONGS_TO, 'User', 'createby'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'updateby'),
		);
	}

	// public function defaultScope()
 //    {
 //        return array(          
 //            'condition'=>'active="'.self::STATUS_ACTIVE.'"',        
 //        );
 //    }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'link_id' => 'Link',
			'link_image' => 'รูปภาพ',
			'link_name' => 'ชื่อ',
			'link_url' => 'ลิงค์',
			'active' => 'สถานะ',
			'createby' => 'ผู้เพิ่มข้อมูล',
			'createdate' => 'วันที่เพิ่มข้อมูล',
			'updateby' => 'ผู้แก้ไขข้อมูล',
			'updatedate' => 'วันที่แก้ไขข้อมูล',
		);
	}
	public function getId(){
		return $this->id = $this->link_id;
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
			    'alias' => 'featuredlinks',
			    'order' => ' featuredlinks.link_id DESC ',
		    	'condition' => ' featuredlinks.active = 1 ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
			    'alias' => 'featuredlinks',
			    'order' => ' featuredlinks.link_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("FeaturedLinks.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);
		
		if($Access == true)
		{
			$scopes =  array( 
				'featuredlinkscheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'featuredlinkscheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'featuredlinkscheck'=>array(
							'alias' => 'featuredlinks',
							'condition' => 'featuredlinks.active = 1 ',
							'order' => ' featuredlinks.link_id DESC ',
						),
					);
				}else{
					$scopes = array(
						'featuredlinkscheck'=>array(
							'alias' => 'featuredlinks',
							'condition' => ' featuredlinks.createby = "'.Yii::app()->user->id.'" AND featuredlinks.active = 1 ',
							'order' => ' featuredlinks.link_id DESC ',
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

		$criteria->compare('link_id',$this->link_id);
		$criteria->compare('link_image',$this->link_image,true);
		$criteria->compare('link_name',$this->link_name,true);
		$criteria->compare('link_url',$this->link_url,true);
		$criteria->compare('active',$this->active,1);
		$criteria->compare('createby',$this->createby,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('updateby',$this->updateby,true);
		$criteria->compare('updatedate',$this->updatedate,true);

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
	 * @return FeaturedLinks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
