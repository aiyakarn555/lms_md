<?php

class Course extends AActiveRecord
{
	public $cates_search;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{course}}';
	}

	public function rules()
	{
		return array(
			array('course_price, course_point,create_by, update_by, course_lecturer, course_type', 'numerical', 'integerOnly'=>true),
			array('course_title, course_location,course_picture, course_hour, course_other', 'length', 'max'=>255),
			array('course_number, course_book_number', 'length', 'max'=>20),
			array('course_time', 'length', 'max'=>50),
			array('course_picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'insert,update'),
			array('active', 'length', 'max'=>1),
			//array('cate_id,course_title,course_point,course_lecturer,course_location,course_price,course_date,course_time,course_short_title,course_detail, course_number, course_rector_date, course_book_number, course_book_date, course_type, course_hour, course_other', 'required'),
			array('cate_id,course_title,course_short_title,course_detail', 'required'),
			array('cates.cate_title,cates_search,course_short_title, course_detail, course_date, create_date, update_date, news_per_page, course_tax', 'safe'),
			array('cates.cate_title,cates_search,course_point,course_id,cate_id , course_title, course_lecturer, course_short_title, course_detail, course_location, course_price, course_date, course_time, create_date, create_by, update_date, update_by, active, course_number, course_rector_date, course_book_number, course_book_date, course_type, course_hour, course_other, course_tax', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'cates' => array(self::BELONGS_TO, 'Category', 'cate_id'),
			'teachers' => array(self::BELONGS_TO, 'Teacher', 'course_lecturer'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'course_id' => 'รหัส',
			'course_number' => 'รหัสหลักสูตร',
			'course_type' => 'ประเภทการเก็บชั่วโมง',
			'cate_id' => 'หมวดสัมมนา-อบรม',
			'course_title' => 'ชื่อหลักสูตรสัมมนา-อบรม',
			'course_lecturer' => 'ชื่อวิทยากร',
			'course_short_title' => 'รายละเอียดย่อ',
			'course_detail' => 'รายละเอียด',
			'course_location' => 'สถานที่อบรมหลักสูตร',
			'course_price' => 'ราคา',
			'course_date' => 'วันที่อบรม',
			'course_time' => 'เวลาโดยประมาณ',
			'course_picture' => 'รูปภาพ',
			'course_book_number' => 'หนังสือกรมพัฒนาธุรกิจการค้าเลขที่',
			'course_book_date' => 'วันที่พัฒนาธุรกิจการค้า',
			'course_point'=> 'คะแนนสะสม',
			'course_rector_date' => 'หลักสูตรได้รับความเห็นชอบเมื่อวันที่',
			'course_hour' => 'การเก็บชั่วโมง (บัญชี)',
			'course_other' => 'การเก็บชั่วโมง (อื่นๆ)',
			'course_tax' => 'ประเภทการเสียภาษีหรือไม่',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

   	public function beforeSave() 
    {
    	$this->cate_id = CHtml::encode($this->cate_id);
    	$this->course_number = CHtml::encode($this->course_number);
    	$this->course_book_number = CHtml::encode($this->course_book_number);
    	$this->course_title = CHtml::encode($this->course_title);
    	$this->course_lecturer = CHtml::encode($this->course_lecturer);
    	$this->course_short_title = CHtml::encode($this->course_short_title);
    	$this->course_detail = CHtml::encode($this->course_detail);
    	$this->course_location = CHtml::encode($this->course_location);
    	$this->course_price = CHtml::encode($this->course_price);
    	$this->course_date = CHtml::encode($this->course_date);
    	$this->course_time = CHtml::encode($this->course_time);
    	$this->course_hour = CHtml::encode($this->course_hour);
    	$this->course_other = CHtml::encode($this->course_other);

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
    	$this->course_title = CHtml::decode($this->course_title);
    	$this->course_number = CHtml::decode($this->course_number);
    	$this->course_lecturer = CHtml::decode($this->course_lecturer);
    	$this->course_book_number = CHtml::decode($this->course_book_number);
    	$this->course_short_title = CHtml::decode($this->course_short_title);
    	$this->course_detail = CHtml::decode($this->course_detail);
    	$this->course_location = CHtml::decode($this->course_location);
    	$this->course_price = CHtml::decode($this->course_price);
    	$this->course_date = CHtml::decode($this->course_date);
    	$this->course_time = CHtml::decode($this->course_time);
    	$this->course_hour = CHtml::decode($this->course_hour);
    	$this->course_other = CHtml::decode($this->course_other);

        return parent::afterFind();
    }
    
	public function getDateLocation()
	{
		return ClassFunction::datethai($this->course_date).' เวลา '.$this->course_time .' น.';
	}

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'course',
		    	'order' => ' course.course_id DESC ',
		    	'condition' => ' course.active ="y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'course',
		    	'order' => ' course.course_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Course.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'coursecheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'coursecheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'coursecheck'=>array(
			    		'alias' => 'course',
			    		'condition' => ' course.create_by = "'.Yii::app()->user->id.'" AND course.active = "y" ',
			    		'order' => ' course.course_id DESC ',
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

	public function getCourseType()
	{
		if($this->course_type == 1){
			$check = 'CPD';
		}else{
			$check = 'CPA';
		}
		return $check;
	}

	public function getId()
	{
		return $this->course_id;
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('cates');
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('course_type',$this->course_type,true);
		$criteria->compare('course_number',$this->course_number,true);
		$criteria->compare('course_book_number',$this->course_book_number,true);
		$criteria->compare('cate_id',$this->cate_id,true);
		$criteria->compare('course_book_date',$this->course_book_date,true);
		$criteria->compare('cates.cate_title',$this->cates_search,true); // That didn't work
		$criteria->compare('course_title',$this->course_title,true);
		$criteria->compare('course_lecturer',$this->course_lecturer,true);
		$criteria->compare('course_short_title',$this->course_short_title,true);
		$criteria->compare('course_detail',$this->course_detail,true);
		$criteria->compare('course_location',$this->course_location,true);
		$criteria->compare('course_price',$this->course_price,true);
		$criteria->compare('course_point',$this->course_point,true);
		$criteria->compare('course_time',$this->course_time,true);
		$criteria->compare('course_tax',$this->course_tax,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->order = 'sortOrder ASC';

		if (!empty($this->course_date))
		{
			$criteria->compare('course_date',ClassFunction::DateSearch($this->course_date),true);
		} 
			
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}
}
