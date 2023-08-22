<?php

/**
 * This is the model class for table "{{point}}".
 *
 * The followings are the available columns in table '{{point}}':
 * @property integer $point_id
 * @property integer $id
 * @property double $point_money
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property integer $con_user
 * @property integer $con_admin
 * @property string $active
 */
class Point extends AActiveRecord
{
	public $type;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Point the static model class
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
		return '{{point}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id,  create_by, update_by, con_user, con_admin', 'numerical', 'integerOnly'=>true),
			array('point_money', 'numerical'),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date , news_per_page', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('point_id, id , userpoint.username , point_money, create_date, create_by, update_date, update_by, con_user, con_admin, active', 'safe', 'on'=>'search'),
		);
	}

	public function getShowIcon()
	{
		return $this->con_admin == '0';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        Yii::import('application.modules.user.models.*');
        return array(
            'userpoint' => array(self::BELONGS_TO, 'User', 'id'),
        );
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
	}

	public function defaultScope()
	{
	    return array(
	    	'order' => 't.point_id asc',
	    	'condition' => ' t.active = "y" AND t.con_user = "1"',
	    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ชื่อผู้โอน',
			'point_id' => 'Point',
			'point_money' => 'จำนวน Point',
			'create_date' => 'วันที่เติม Point',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'con_user' => 'ยืนยันการเติม Point',
			'con_admin' => 'อนุมัติการเติม Point',
			'active' => 'สถานะ',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.point_id',$this->point_id);
		$criteria->compare('t.point_money',$this->point_money,true);
		$criteria->compare('t.create_by',$this->create_by);
		$criteria->compare('t.update_date',$this->update_date,true);
		$criteria->compare('t.update_by',$this->update_by);
		$criteria->compare('t.con_user',$this->con_user);
		$criteria->compare('t.con_admin',$this->con_admin);
		$criteria->compare('t.active',$this->active,true);
		if (!empty($this->create_date)) {	
			$criteria->compare('t.create_date',ClassFunction::DateSearch($this->create_date),true);
		}

		$poviderArray = array(
			'criteria'=>$criteria,
		);

		if(isset($this->news_per_page))
			$poviderArray['pagination'] = array(
		        'pageSize'=> intval($this->news_per_page),
		    );

		return new CActiveDataProvider($this, $poviderArray);
	}
}