<?php

/**
 * This is the model class for table "{{pricepoint}}".
 *
 * The followings are the available columns in table '{{pricepoint}}':
 * @property integer $pricepoint_id
 * @property integer $pricepoint_money
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Pricepoint extends AActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return pricepoint the static model class
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
		return '{{pricepoint}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pricepoint_money,pricepoint_point, create_by, update_by', 'numerical', 'integerOnly'=>true, 'message' => Controller::MessageError("int")),
			array('active', 'length', 'max'=>1),
			array('pricepoint_money , pricepoint_point', 'required', 'message' => Controller::messageError("")),
			array('create_date, update_date , news_per_page', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pricepoint_id, pricepoint_money, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

   	public function beforeSave() 
    {
		if(Yii::app()->user !== null && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

		$this->pricepoint_money = CHtml::encode($this->pricepoint_money);

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
    	$this->pricepoint_money = CHtml::decode($this->pricepoint_money);
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
			'pricepoint_id' => 'Pricepoint',
			'pricepoint_money' => 'จำนวนเงินที่แลก',
			'pricepoint_point' => 'จำนวน Point ที่ได้',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
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

		$criteria=new CDbCriteria;
		$criteria->condition = 'active="y"';
		$criteria->compare('pricepoint_id',$this->pricepoint_id);
		$criteria->compare('pricepoint_money',$this->pricepoint_money,true);
		$criteria->compare('pricepoint_point',$this->pricepoint_point,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		if(!isset($_GET['Pricepoint_sort']))
			$criteria->order = 'pricepoint_money asc';

		$poviderArray = array(
			'criteria'=>$criteria,
		);
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array(
		        'pageSize'=> intval($this->news_per_page),
		    );
		}
		return new CActiveDataProvider($this, $poviderArray);
	}
}