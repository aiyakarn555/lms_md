<?php

class Grouptesting extends AActiveRecord
{
	public $lesson_search;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{grouptesting}}';
	}

	public function rules()
	{
		return array(
			array('lesson_id, step_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('group_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date,lesson_search, news_per_page', 'safe'),
			array('lesson_id, group_title', 'required'),
			array('group_id, lesson_search, lesson_id, group_title, step_id, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'QuesCount'=>array(self::STAT, 'Question', 'group_id'),
			'lesson' => array(self::BELONGS_TO, 'Lesson', 'lesson_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'lesson_search'=>'ชื่อบทเรียนออนไลน์',
			'group_id' => 'Group',
			'lesson_id' => 'ชื่อบทเรียนออนไลน์',
			'group_title' => 'ชื่อชุด',
			'step_id' => 'Step',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

	public function getTitleGroup()
	{
	    return $this->group_title.' || จำนวนข้อที่มี '.$this->QuesCount();
	}

	public static function getClients($id)
	{
		$dataManage = new CActiveDataProvider('Manage',array(
			'criteria'=>array(
				'condition'=>' id = "'.$id.'" AND active = "y" '.(($_GET['type'] != '')?'AND type = "'.$_GET['type'].'"':''),
			))
		);
		foreach ($dataManage->getData() as $i=>$value) {
			$group_id[] =  $value['group_id'];
		}

		$criteria = new CDbCriteria; 
		$criteria->condition  = ' active = "y" ';
		if(isset($group_id))
			$criteria->addNotInCondition('group_id',$group_id);
			$criteria->addSearchCondition('lesson_id',$id);
			
	    $Clients = GroupTesting::model()->findAll($criteria);
	    $list = CHtml::listData($Clients ,'group_id', 'TitleGroup');
	    return $list;
	}

   	public function beforeSave() 
    {
    	$this->group_title = CHtml::encode($this->group_title);

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
    	$this->group_title = CHtml::decode($this->group_title);

        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias'=>'group',
		    	'order' => 'group.group_id DESC',
		    	'condition' => 'group.active = "y"',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias'=>'group',
		    	'order' => 'group.group_id DESC',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Grouptesting.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'grouptestingcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'grouptestingcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'grouptestingcheck'=>array(
				    	'alias'=>'group',
				    	'order' => 'group.group_id DESC',
				    	'condition' => ' group.create_by = "'.Yii::app()->user->id.'" AND group.active = "y" ',
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

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('lesson');
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('lesson.title',$this->lesson_search,true);
		$criteria->compare('group_title',$this->group_title,true);
		$criteria->compare('step_id',$this->step_id);
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
}