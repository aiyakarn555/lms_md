<?php

/**
 * This is the model class for table "{{manage}}".
 *
 * The followings are the available columns in table '{{manage}}':
 * @property integer $manage_id
 * @property integer $id
 * @property integer $group_id
 * @property integer $manage_row
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Coursemanage extends AActiveRecord
{
	public $titleShow;
	public $stepShow;
	public $StepNameManage;
	public $group_search;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Manage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coursemanage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, group_id, manage_row, create_by, update_by', 'numerical', 'integerOnly'=>true, 'message' => Controller::MessageError("int")),
			array('active', 'length', 'max'=>1),
			array('id,group_id,manage_row', 'required', 'message' => Controller::messageError("") ),
			array('create_date, update_date,group_search, stepShow, titleShow, TitleGroup, news_per_page', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('manage_id, id, TitleGroup,group_search, titleShow, stepShow, group_id, manage_row, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

   	public function beforeSave() 
    {
		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

		if($this->isNewRecord){
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}else{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
        return parent::beforeSave();
    }

    public function afterFind() 
    {
        return parent::afterFind();
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'group' => array(self::BELONGS_TO, 'Coursegrouptesting', 'group_id'),
		);
	}

	public function getCountcourse()
	{
		return Coursequestion::model()->count(new CDbCriteria(array(
			"condition" => "group_id = :group_id",
			"params" => array(":group_id"=>$this->group_id)
		)));
	}  
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'บทเรียน',
			'stepShow'=>'ระดับ',
			'StepIDGroup'=>'ระดับ',
			'TitleGroup' => 'ชุดข้อสอบ',
			'titleShow'=>'ชุดข้อสอบ',
			'group_id' => 'ชุดข้อสอบ',
			'manage_row' => 'จำนวนข้อในการแสดง',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

	public function defaultScope()
	{
        return array(
        	'alias'=>'manage',
        	'order' => 'manage.manage_id desc',
            'condition'=>"manage.active='y'",
        );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('group');
		$criteria->compare('manage_id',$this->manage_id);
		if($id !== null){
			$criteria->compare('id',$id,false);
		}
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('group.group_title',$this->group_search,true);
		$criteria->compare('manage_row',$this->manage_row,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('type',$this->type);
		$criteria->compare('active',$this->active,true);

		$poviderArray = array('criteria'=>$criteria);

		if(isset($this->news_per_page))
			$poviderArray['pagination'] = array(
		        'pageSize'=> intval($this->news_per_page),
		    );

		return new CActiveDataProvider($this, $poviderArray);
	}
}