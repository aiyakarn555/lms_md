<?php

/**
 * This is the model class for table "{{popup}}".
 *
 * The followings are the available columns in table '{{popup}}':
 * @property integer $id
 * @property string $name
 * @property string $detail
 * @property string $start_date
 * @property string $end_date
 * @property string $link
 * @property string $pic_file
 * @property string $create_date
 * @property string $create_by
 * @property string $update_date
 * @property string $update_by
 * @property string $active
 */
class Popup extends CActiveRecord
{
	const STATUS_ACTIVE="y";
	public $id;
	public $test;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{popup}}';
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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, start_date, end_date', 'required'),
			array('name, detail, link, create_by, update_by', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('start_date, end_date, create_date, update_date,lang_id,parent_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, detail, start_date, end_date, link, pic_file, create_date, create_by, update_date, update_by, active,lang_id,parent_id,del_status', 'safe', 'on'=>'search'),
			array('pic_file', 'file', 'types'=>'jpg, png, gif, jpeg','allowEmpty' => true, 'on'=>'insert'),
			array('pic_file', 'file', 'types'=>'jpg, png, gif, jpeg','allowEmpty' => true, 'on'=>'update'),
			// array('name', 'unique', 'message' => UserModule::t("This name already exists.")),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{		
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

public function defaultScope()
    {
        // return array(          
        //     'condition'=>'active="'.self::STATUS_ACTIVE.'"',        
        // );
    }


	public function getId(){
		return $this->id = $this->id;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		
		return array(
			'id' => 'Id Popup',
			'name' => 'name',
			'detail' => 'detail',
			'start_date' => 'start_date',
			'end_date' => 'end_date',
			'link' => 'Link',
			'pic_file' => 'image',
			'create_date' => 'create_date',
			'create_by' => 'create_by',
			'update_date' => 'update_date',
			'update_by' => 'update_by',
			'active' => 'active',
			'lang_id'=> 'language'
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('pic_file',$this->pic_file,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('lang_id',1);
		$criteria->compare('del_status',$this->del_status,true);
		$criteria->order = 'sortOrder ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Popup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
