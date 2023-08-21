<?php

class Level extends AActiveRecord
{
	public function tableName()
	{
		return '{{level}}';
	}

	public function rules()
	{
		return array(
			array('level_status, level_login, level_create_by, level_update_by, level_show, level_active', 'numerical', 'integerOnly'=>true),
			array('level_name', 'length', 'max'=>255),
			array('level_create_date, level_update_date, news_per_page', 'safe'),
			array('level_name', 'required'),
			array('level_id, level_name, level_status, level_login, level_create_date, level_create_by, level_update_date, level_update_by, level_show, level_active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'level_create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'level_update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'level_id' => 'รหัส',
			'level_name' => 'ชื่อกลุ่มระดับ',
			'level_status' => 'เปิดการใช้งานกลุ่ม',
			'level_login' => 'อนุญาตให้เข้าสู่ระบบหลังบ้านหรือไม่',
			'level_create_date' => 'วันที่เพิ่มข้อมูล',
			'level_create_by' => 'ผู้เพิ่มข้อมูล',
			'level_update_date' => 'วันที่อัพเดทข้อมูล',
			'level_update_by' => 'ผู้แก้ไขข้อมูล',
			'level_show' => 'เปิดหรือปิดการแสดง',
			'level_active' => 'ข้อมูลที่โดนลบ',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('level_id',$this->level_id);
		$criteria->compare('level_name',$this->level_name,true);
		$criteria->compare('level_status',$this->level_status,true);
		$criteria->compare('level_login',$this->level_login,true);
		$criteria->compare('level_create_date',$this->level_create_date,true);
		$criteria->compare('level_create_by',$this->level_create_by);
		$criteria->compare('level_update_date',$this->level_update_date,true);
		$criteria->compare('level_update_by',$this->level_update_by);
		$criteria->compare('level_show',$this->level_show);
		$criteria->compare('level_active',$this->level_active);

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

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

		$this->level_name = CHtml::encode($this->level_name);

		if($this->isNewRecord)
		{
			$this->level_create_by = $id;
			$this->level_create_date = date("Y-m-d H:i:s");
			$this->level_update_by = $id;
			$this->level_update_date = date("Y-m-d H:i:s");
		}
		else
		{
			$this->level_update_by = $id;
			$this->level_update_date = date("Y-m-d H:i:s");
		}
        return parent::beforeSave();
    }

    public function afterFind() 
    {
		$this->level_name = CHtml::decode($this->level_name);

        return parent::afterFind();
    }

	public function scopes()
    {
        return array(
            'checkdelete'=>array(
                'condition'=>' levels.level_active = 1 ',
            ),
            'groupshow'=>array(
                'condition'=>' levels.level_show = 1 ',
            ),
            'groupuser'=>array(
                'condition'=>' levels.level_status = 3  ', 
                // ระดับการใช้งาน 1=SuperAdmin 2=User(ผู้ใช้) 3=General(ทั่วไปที่เพิ่มเข้ามา)
            ),
        );
    }

	public function defaultScope()
	{
	    return array(
	    	'alias' => 'levels',
	    	'order' => ' levels.level_name ASC ',
	    );
	}
	
	public function getId()
	{
		return $this->level_id;
	}

	public function getcheckVisible()
	{
		if($this->level_id == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
}
