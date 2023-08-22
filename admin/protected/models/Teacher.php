<?php

class Teacher extends AActiveRecord
{
	public $picture;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{teacher}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('teacher_name,teacher_position', 'length', 'max'=>100),
			array('teacher_picture', 'length', 'max'=>200),
			array('active', 'length', 'max'=>1),
			array('picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true),
			array('teacher_name,teacher_position', 'required' ),
			array('teacher_detail, create_date, update_date , news_per_page', 'safe'),
			array('teacher_id, teacher_name,teacher_position, teacher_detail, teacher_picture, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'teacher_id' => 'Teacher',
			'teacher_name' => 'ชื่อวิทยากร',
			'teacher_type' => 'ประเภท',
			'teacher_detail' => 'รายละเอียด',
			'teacher_picture' => 'รูปภาพวิทยากร',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
			'teacher_position'=>'ตำแหน่งวิทยากร',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('teacher_id',$this->teacher_id);
		$criteria->compare('teacher_name',$this->teacher_name,true);
		$criteria->compare('teacher_detail',$this->teacher_detail,true);
		$criteria->compare('teacher_picture',$this->teacher_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('teacher_position',$this->teacher_position,true);

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'teachers',
		    	'order' => ' teachers.teacher_id DESC ',
		    	'condition' => ' teachers.active ="y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'teachers',
		    	'order' => ' teachers.teacher_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Teacher.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'teachercheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'teachercheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'teachercheck'=>array(
			    		'alias' => 'teachers',
			    		'order' => ' teachers.teacher_id DESC ',
			    		'condition' => ' teachers.create_by = "'.Yii::app()->user->id.'" AND teachers.active ="y" ',
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

   	public function beforeSave() 
    {
    	$this->teacher_name = CHtml::encode($this->teacher_name);
    	$this->teacher_detail = CHtml::encode($this->teacher_detail);

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

    public function afterFind() 
    {
    	$this->teacher_name = CHtml::decode($this->teacher_name);
    	$this->teacher_detail = CHtml::decode($this->teacher_detail);

        return parent::afterFind();
    }

	public function getId()
	{
		return $this->teacher_id;
	}

	public function getTypes()
	{
		return array('0' => 'ประเภท 1', '1' => 'ประเภท 2');
	}

	public function getTypesByKey($key)
	{
		$types = array('0' => 'ประเภท 1', '1' => 'ประเภท 2');
		return $types[$key];
	}
}
