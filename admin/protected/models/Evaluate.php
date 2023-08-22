<?php

class Evaluate extends AActiveRecord
{
	public function tableName()
	{
		return '{{evaluate}}';
	}

	public function rules()
	{
		return array(
			array('course_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('eva_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('eva_title, course_id', 'required'),
			array('create_date, update_date, news_per_page', 'safe'),
			array('eva_id, eva_title, course_id, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'evalans' => array(self::HAS_MANY, 'EvalAns', 'eva_id'),
			'courseonline' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'eva_id' => 'Eva',
			'eva_title' => 'คำถามความพึงพอใจ',
			'course_id' => 'ชื่อหลักสูตร',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
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

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
			    'alias' => 'evaluates',
			    'order' => ' evaluates.eva_id DESC ',
		    	'condition' => ' evaluates.active ="y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
			    'alias' => 'evaluates',
			    'order' => ' evaluates.eva_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Evaluate.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'evaluatecheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'evaluatecheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'evaluatecheck'=>array(
			    		'alias' => 'evaluates',
			    		'condition' => ' evaluates.create_by = "'.Yii::app()->user->id.'" AND evaluates.active = "y" ',
			    		'order' => ' evaluates.eva_id DESC ',
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

	public function getId()
	{
		return $this->eva_id;
	}

	public function search($id=null)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('eva_id',$this->eva_id);
		$criteria->compare('eva_title',$this->eva_title);

		if($id !== null)
		{
			$criteria->compare('course_id',$id);
		}
		else
		{
			$criteria->compare('course_id',$this->course_id,true);
		}

		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

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
}
