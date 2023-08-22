<?php

/**
 * This is the model class for table "{{ms_online}}".
 *
 * The followings are the available columns in table '{{ms_online}}':
 * @property integer $id
 * @property string $name_ms_teams
 * @property string $detail_ms_teams
 * @property string $start_date
 * @property string $end_date
 * @property string $active
 * @property integer $create_by
 * @property string $create_date
 * @property string $update_date
 * @property integer $update_by
 * @property string $ms_teams_picture
 * @property string $time_start_date
 * @property string $time_end_date
 * @property string $url_join_meeting
 * @property integer $ms_price
 * @property string $price
 * @property string $intro_video
 *
 * The followings are the available model relations:
 * @property LessonOnline[] $lessonOnlines
 */
class MsOnline extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ms_online}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_ms_teams,start_date,time_start_date,time_end_date', 'required'),
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('name_ms_teams', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('detail_ms_teams,url_join_meeting, start_date, end_date, create_date, update_date , ms_price, price', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name_ms_teams,url_join_meeting, detail_ms_teams, start_date, end_date, active, create_by, create_date, update_date, update_by, ms_price, price', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'name_ms_teams' => 'ชื่อห้องสอบเรียนรู้ทางไกล',
			'detail_ms_teams' => 'รายละเอียดห้องสอบเรียนรู้ทางไกล',
			'start_date' => 'วันที่เข้าสอบ',
			'end_date' => 'วันที่สิ้นสุดเข้าสอบ',
			'time_start_date' => 'เวลาเริ่มเข้าสอบ',
			'time_end_date' => 'เวลาสิ้นสุดเข้าสอบได้',
			'active' => 'สถานะ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'ms_teams_picture' => 'รูปภาพ',
			'price' => 'ห้องสอบเรียนรู้ทางไกลจ่ายเงิน',
			'ms_price' => 'ราคาหลักสูตร',
			'intro_video' => 'วิดีโอ ตัวอย่างหลักสูตร'

			
		);
	}

	public function beforeSave()
	{
		$this->name_ms_teams = CHtml::encode($this->name_ms_teams);

		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

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
		$criteria->compare('name_ms_teams',$this->name_ms_teams,true);
		$criteria->compare('detail_ms_teams',$this->detail_ms_teams,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('active','y',true);
		// $criteria->compare('create_by',$this->create_by);
		$modelUser = Users::model()->findByPk(Yii::app()->user->id);
		$group = json_decode($modelUser->group);
		if (!in_array(1, $group)){
			$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
			$criteria->addInCondition('create_by', $groupUser);	
		}

		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('url_join_meeting',$this->url_join_meeting,true);
        $criteria->order = 'create_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MsTeams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
