<?php

/**
 * This is the model class for table "{{grouptesting_ms_teams}}".
 *
 * The followings are the available columns in table '{{grouptesting_ms_teams}}':
 * @property integer $group_id
 * @property integer $lesson_id
 * @property string $group_title
 * @property integer $step_id
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $lang_id
 * @property integer $parent_id
 *
 * The followings are the available model relations:
 * @property LessonMsTeams $lesson
 * @property QuestionMsTeams[] $questionMsTeams
 */
class GrouptestingMsTeamsInstitution extends CActiveRecord
{

	public $lesson_search;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{grouptesting_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('lesson_id, step_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('group_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date,lesson_search, news_per_page,lang_id,parent_id', 'safe'),
			array('group_title', 'required'),
			array('group_id, lesson_search, lesson_id, group_title, step_id, create_date, create_by, update_date, update_by, active,lang_id,parent_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'QuesCount2'=>array(self::STAT, 'QuestionMsTeams', 'group_id'),
			'lesson' => array(self::BELONGS_TO, 'LessonMsTeams', 'lesson_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			'lang' => array(self::BELONGS_TO, 'Language', 'lang_id'),
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
			'lang_id'=> 'ภาษา',
			'parent_id'=> 'แนวหลัก',
		);
	}

	public function getTitleGroup()
	{
	    return $this->group_title.' || จำนวนข้อที่มี '.$this->QuesCount2();
	}

	public static function getClients($id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare("id",$id);
		$criteria->compare("active","y");
		if($_GET['type'] != ""){
			$criteria->compare("type",$_GET['type']);
		}

		// if(null !== Yii::app()->user && isset(Yii::app()->user->id)){
		// 	$User=User::model()->findByPk(Yii::app()->user->id);
		// 	if($User){
		// 		$institution_id = $User->institution_id;

		// 		$criteriaInstituation =new CDbCriteria;
		// 		$criteriaInstituation->compare('institution_id',$institution_id);
		// 		$UserAll = User::model()->findAll($criteriaInstituation);
		// 		$user_array = array();
		// 		foreach ($UserAll as $key => $value) {
		// 			$user_array[] = $value->id;
		// 		}
		// 		$criteria->addInCondition('create_by',$user_array);

		// 	}
		// }else{
		// 	$criteria->compare('create_by',$this->create_by);
		// }

		$dataManage = new CActiveDataProvider('ManageMsTeamsInstitution',array(
			'criteria'=>$criteria)
	);
		foreach ($dataManage->getData() as $i=>$value) {
			$group_id[] =  $value['group_id'];
		}

		$criteria = new CDbCriteria; 
		$criteria->condition  = ' active = "y" ';
		if(isset($group_id))
			$criteria->addNotInCondition('group_id',$group_id);
			// $criteria->addSearchCondition('lesson_id',$id);
		// if(isset($user_array)){
		// 	$criteria->addInCondition('create_by',$user_array);
		// }
		$modelUser = Users::model()->findByPk(Yii::app()->user->id);
		$group = json_decode($modelUser->group);
		if (!in_array(1, $group)){
			$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
			$criteria->addInCondition('group.create_by', $groupUser);	
		}
		$criteria->compare('type_ms_teams',2);
		$Clients = GrouptestingMsTeamsInstitution::model()->findAll($criteria);
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
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);

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
				if($state){
					$scopes = array(
						'grouptestingcheck'=>array(
							'alias'=>'group',
							'order' => 'group.group_id DESC',
							'condition' => ' group.active = "y" ',
						),
					);
				}else{
					$scopes = array(
						'grouptestingcheck'=>array(
							'alias'=>'group',
							'order' => 'group.group_id DESC',
							'condition' => ' group.create_by = "'.Yii::app()->user->id.'" AND group.active = "y" ',
						),
					);
				}
			    
			    // $scopes = array(
		     //        'grouptestingcheck'=>array(
				   //  	'alias'=>'group',
				   //  	'order' => 'group.group_id DESC',
				   //  	'condition' => ' group.active = "y" ',
		     //        ),
			    // );
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
		$criteria->with=array('lesson','lesson.msteams');
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('lesson.title',$this->lesson_search,true);
		$criteria->compare('group_title',$this->group_title,true);
		$criteria->compare('step_id',$this->step_id);
		$criteria->compare('create_date',$this->create_date,true);

		// if(null !== Yii::app()->user && isset(Yii::app()->user->id)){
		// 	$User=User::model()->findByPk(Yii::app()->user->id);
		// 	if($User){
		// 		$institution_id = $User->institution_id;

		// 		$criteriaInstituation =new CDbCriteria;
		// 		$criteriaInstituation->compare('institution_id',$institution_id);
		// 		$UserAll = User::model()->findAll($criteriaInstituation);
		// 		$user_array = array();
		// 		foreach ($UserAll as $key => $value) {
		// 			$user_array[] = $value->id;
		// 		}
		// 		$criteria->addInCondition('group.create_by',$user_array);

		// 	}
		// }else{
			// $criteria->compare('create_by',$this->create_by);
		// }
		// $criteria->compare('msteams.type_ms_teams',2);
		$modelUser = Users::model()->findByPk(Yii::app()->user->id);
		$group = json_decode($modelUser->group);
		if (!in_array(1, $group)){
			$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
			$criteria->addInCondition('group.create_by', $groupUser);	
		}
		$criteria->compare('group.type_ms_teams',2);

		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('group.active','y');
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}
}