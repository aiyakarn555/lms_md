<?php

/**
 * This is the model class for table "{{formsurvey_group}}".
 *
 * The followings are the available columns in table '{{formsurvey_group}}':
 * @property integer $fg_id
 * @property string $fg_title
 * @property integer $lesson_id
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class FormsurveyGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsurveyGroup the static model class
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
		return '{{formsurvey_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lesson_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('fg_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fg_id, fg_title, lesson_id, create_date, create_by, update_date, update_by, active, lesson_search', 'safe', 'on'=>'search'),
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
			'formsurvey'=>array(self::STAT, 'FormSurvey', 'fg_id'),
			'lesson' => array(self::BELONGS_TO, 'Lesson', 'lesson_id'),
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
			'fg_id' => 'Fg',
			'fg_title' => 'กลุ่มแบบสอบถาม',
			'lesson_id' => 'บทเรียน',
			'create_date' => 'วันทืี่สร้าง',
			'create_by' => 'สร้างโดย',
			'update_date' => 'วันที่อัพเดท',
			'update_by' => 'อัพเดทโดย',
			'active' => 'Active',
			'lesson_search'=>'ชื่อบทเรียนออนไลน์',
		);
	}

		public function beforeSave() 
    {
    	$this->fg_title = CHtml::encode($this->fg_title);

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

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('lesson');
		$criteria->compare('fg_id',$this->fg_id);
		$criteria->compare('fg_title',$this->fg_title,true);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('lesson.title',$this->lesson_search,true);

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
		    	'alias'=>'formsurveygroup',
		    	'order' => 'formsurveygroup.fg_id DESC',
		    	'condition' => 'formsurveygroup.active = "y"',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias'=>'formsurveygroup',
		    	'order' => 'formsurveygroup.fg_id DESC',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("FormsurveyGroup.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'formsurveygroupcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'formsurveygroupcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'formsurveygroupcheck'=>array(
				    	'alias'=>'formsurveygroup',
				    	'order' => 'formsurveygroup.fg_id DESC',
				    	'condition' => ' formsurveygroup.create_by = "'.Yii::app()->user->id.'" AND formsurveygroup.active = "y" ',
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