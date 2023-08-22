<?php

/**
 * This is the model class for table "{{formsurvey}}".
 *
 * The followings are the available columns in table '{{formsurvey}}':
 * @property string $fs_id
 * @property string $fs_head
 * @property string $fs_title
 * @property string $fs_type
 * @property string $startdate
 * @property string $enddate
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class FormSurvey extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormSurvey the static model class
	 */
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
		return '{{formsurvey}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fs_head', 'required'),
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('fs_head', 'length', 'max'=>255),
			array('fs_type', 'length', 'max'=>50),
			array('active', 'length', 'max'=>1),
			array('fs_title, startdate, enddate, create_date, update_date, lesson_search', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fs_id, fs_head, fs_title, fs_type, startdate, enddate, create_date, create_by, update_date, update_by, active, fg_id,lesson_search', 'safe', 'on'=>'search'),
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
			'FormSurveyHeader' => array(self::HAS_MANY, 'FormSurveyHeader', 'fs_id'),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fs_id' => 'Fs',
			'fs_head' => 'หัวข้อแบบสอบถาม',
			'fs_title' => 'หัวข้อ',
			'fs_type' => 'กลุ่มแบบสอบถาม',
			'startdate' => 'วันเริ่มต้น',
			'enddate' => 'วันที่สิ้นสุด',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'fg_id' => 'fg_id',
			'lesson_search' => 'lesson_search',
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
		$id=$_GET['id'];
		$criteria=new CDbCriteria;


		
		$criteria->compare('fs_id',$this->fs_id,true);
		$criteria->compare('fs_head',$this->fs_head,true);
		$criteria->compare('fs_title',$this->fs_title,true);
		$criteria->compare('fs_type',$this->fs_type,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('fg_id',$this->fg_id,true);
		$criteria->addCondition('fg_id ="'.$id.'"');

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

	public function searchExport()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$id=$_GET['id'];
		$criteria=new CDbCriteria;


		
		$criteria->compare('fs_id',$this->fs_id,true);
		$criteria->compare('fs_head',$this->fs_head,true);
		$criteria->compare('fs_title',$this->fs_title,true);
		$criteria->compare('fs_type',$this->fs_type,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('fg_id',$this->fg_id,true);
		$criteria->addCondition('fg_id ="'.$id.'"');

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

	public function getTypeElements()
	{

		$list = FormSurveyTypeans::model()->findAll();
		
		 $list = CHtml::listData($list,'fst_type', 'fst_title');
        // $list = array(
        // 	'checkbox'=>'คำตอบแบบเลือกได้หลายคำตอบ(Checkbox)',
        // 	'radio'=>'คำตอบแบบเลือกคำตอบเดียว(radio)',
        // 	'tablescore'=>'คำตอบแบบคะแนนความพึงพอใจ',
        // 	'textField'=>'คำตอบแบบบรรทัดเดียว',
        // 	'textArea'=>'คำตอบแบบหลายบรรทัด'
        // 		);

        return $list;

		
	}
	
	public function getCheckFormExcel($fsid){
		

		$userid=Yii::app()->user->id;

		$model = FormsurveyLog::model()->findAll(array(
			'condition' => 'fs_id = "'.$fsid.'"'
		));
			
			
		$model=count($model);
		if($model<"1"){
			echo "ยังไม่มีคนทำแบบสอบถาม";
		}
		else
		{
			//echo 
			//echo CHtml::link("ทำ",Yii::app()->createUrl("FormsurveyGroup/survey",array("id"=>$this->fs_id,"survey"=>$this->fg_id)), array("target"=>"_blank"));
			echo CHtml::button("ExportExcel",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("FormSurvey/ExportForm", array("id"=>$this->fs_id))));
		}

	}
		// Query List Lesson
	public function getListLesson()
	{

		$list = Lesson::model()->findAll(array(
		"condition"=>" active = 'y' ",'order'=>'id'));
		
		 $list = CHtml::listData($list,'id', 'title');
		
		return $list;
	}

	

	 public function beforeSave() 
    {
		if( !Yii::app()->user->isGuest )
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 1;
		}

		if($this->isNewRecord)
		{
			$this->create_by 	= $id;
			$this->create_date 	= date("Y-m-d H:i:s");
			$this->update_by 	= $id;
			$this->update_date 	= date("Y-m-d H:i:s");
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
		    	'alias' => 'formsurvey',
		    	'order' => ' formsurvey.fs_id DESC ',
		    	'condition' => 'formsurvey.active ="y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'formsurvey',
		    	'order' => 'formsurvey.fs_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("FormSurvey.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'formsurveycheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'formsurveycheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'teachercheck'=>array(
			    		'alias' => 'formsurvey',
			    		'order' => ' formsurvey.fs_id DESC ',
			    		'condition' => ' formsurvey.create_by = "'.Yii::app()->user->id.'" AND formsurvey.active ="y" ',
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





}