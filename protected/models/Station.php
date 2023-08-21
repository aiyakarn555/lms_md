<?php

/**
 * This is the model class for table "{{station}}".
 *
 * The followings are the available columns in table '{{station}}':
 * @property integer $station_id
 * @property string $station_title
 * @property string $create_date
 * @property string $active
 */
class Station extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{station}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('station_id', 'required'),
			array('station_id', 'numerical', 'integerOnly'=>true),
			array('station_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date,lang_id,parent_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('station_id, station_title, create_date, active,lang_id,parent_id', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'station_id' => 'Station',
			'station_title' => 'ชื่อสถานี',
			'create_date' => 'Create Date',
			'active' => 'Active',
			'lang_id' => 'ภาษา'
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

		$criteria->compare('station_id',$this->station_id);
		$criteria->compare('station_title',$this->station_title,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('active','y',true);
		$criteria->compare('lang_id',$this->lang_id,true);
		$criteria->compare('parent_id',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Station the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeSave()
    {
        if(null !== Yii::app()->user && isset(Yii::app()->user->id))
            $id = Yii::app()->user->id;
        else
            $id = 0;

        if($this->isNewRecord){
            // $this->create_by = $id;
            $this->create_date = date("Y-m-d H:i:s");
            // $this->update_by = $id;
            // $this->update_date = date("Y-m-d H:i:s");
        }else{
            // $this->update_by = $id;
            $this->create_date = date("Y-m-d H:i:s");
        }
        return parent::beforeSave();
    }
    
    public function getStationList($langId){
		// $model = Station::model()->findAll('active = "y"');
		$model = Station::model()->findAll(array(
            'condition'=>'lang_id=:lang_id AND active=:active',
            'params' => array(':lang_id' => $langId, ':active' => 'y')
              ));
		if(!$mode){
			$model = Station::model()->findAll(array(
            'condition'=>'lang_id=:lang_id AND active=:active',
            'params' => array(':lang_id' => 1, ':active' => 'y')
              ));
		}
		// var_dump($model);exit();
		$list = CHtml::listData($model,'station_id','station_title');
		return $list;
	}
}
