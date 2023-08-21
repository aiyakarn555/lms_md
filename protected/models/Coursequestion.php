<?php


class Coursequestion extends AActiveRecord
{
	public $type = null;
    public $excel_file = null;

	public $choice_stored_ids = array();
	public $choice_ids = array();

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{coursequestion}}';
	}

	public function rules()
	{
		return array(
			array('group_id', 'numerical', 'integerOnly'=>true),
			//array('ques_title', 'length', 'max'=>255),
			array('news_per_page', 'safe'),
			array('ques_title', 'required'),
            //array('excel_file', 'required', 'on'=>'import'),
            array('excel_file', 'file', 'allowEmpty'=>false, 'types'=>'xls', 'on'=>'import'),
			array('ques_id, group_id, ques_title, ques_explain , ques_type', 'safe', 'on'=>'search')
		);
	}

	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			'group' => array(self::BELONGS_TO, 'Coursegrouptesting', 'group_id'),
			'choices' => array(self::HAS_MANY, 'Coursechoice', 'ques_id'),
		);
	}

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
	        	'alias'=>'ques',
	        	'order' => 'ques.ques_id desc',
	            'condition'=>" ques.active='y' ",
		    );
    	}
    	else
    	{
		    $checkScopes =  array(
	        	'alias'=>'ques',
	        	'order' => 'ques.ques_id desc',
	        	'condition'=>" ques.active='y' ",
		    );
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Coursequestion.*") );
		if($Access == true)
		{
			$scopes =  array(
				'questioncheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array(
					'questioncheck' => $this->checkScopes('scopes')
				);
			}
			else
			{
			    $scopes = array(
		            'questioncheck'=>array(
			        	'alias'=>'ques',
			        	'order' => 'ques.ques_id desc',
			            'condition'=>" ques.create_by = '".Yii::app()->user->id."' AND ques.active='y' ",
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

	public function attributeLabels()
	{
		return array(
			'ques_id' => 'Ques',
			'ques_type'=>'ประเภทข้อสอบ',
			'group_id' => 'ชุดข้อสอบ',
			'ques_title' => 'โจทย์ข้อสอบ',
            'excel_file' => 'ไฟล์ Excel Import',
		);
	}

   	public function beforeSave()
    {
    	$this->ques_title = CHtml::encode($this->ques_title);

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
    	$this->ques_title = CHtml::decode($this->ques_title);
        return parent::afterFind();
    }


	public function search($id=null)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('ques_id',$this->ques_id,true);
		$criteria->compare('ques_title',$this->ques_title,true);

		if($id !== null)
		{
			$criteria->compare('group_id',$id,false);
		}

		$criteria->compare('ques_type',$this->ques_type,true);

		if(!isset($_GET['Question_sort']))
		{
			$criteria->order = 'ques_id desc';
		}

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

		return new CActiveDataProvider($this, $poviderArray);
	}
        
        public static function getLimitData($id, $limit)
    {
        $Coursequestion = new CDbCriteria;
        $Coursequestion->addCondition("group_id=$id");
        $Coursequestion->addCondition("active='y'");
        // $Coursequestion->offset    = 0;
        $Coursequestion->limit     = $limit;
        $Coursequestion->order     = ' RAND() ';

        return Coursequestion::model()->findAll($Coursequestion);
    }

    public static function getTempData($id)
    {
        $Question            = new CDbCriteria;
        $Question->condition = " ques_id = '".$id."'  AND active = 'y' ";
        $Question->offset    = 0;
//        $Question->limit     = $limit;
//        $Question->order     = ' RAND() ';

        return Coursequestion::model()->find($Question);
    }
}
