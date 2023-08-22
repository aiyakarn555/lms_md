<?php

/**
 * This is the model class for table "{{learn}}".
 *
 * The followings are the available columns in table '{{learn}}':
 * @property integer $learn_id
 * @property integer $user_id
 * @property integer $lesson_id
 * @property string $learn_date
 */
class Learn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Learn the static model class
	 */
	public $search_value;
	public $news_per_page;
	public $searchname;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{learn}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lesson_id, learn_date', 'required'),
			array('user_id, lesson_id', 'numerical', 'integerOnly'=>true),
			array('lesson_active', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('learn_id, user_id, lesson_id, learn_date,create_date,search_value,searchname, lesson_active', 'safe', 'on'=>'search'),
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
			'les' => array(self::BELONGS_TO, 'Lesson', 'lesson_id','foreignKey' => array('lesson_id'=>'id')),
			'LessonMapper' => array(self::BELONGS_TO, 'lesson', 'lesson_id'),
			'User' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'Profile' => array(self::BELONGS_TO, 'Profiles', 'user_id'),
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
			'score' => array(self::BELONGS_TO, 'Score', 'course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'learn_id' => 'Learn',
			'user_id' => 'User',
			'lesson_id' => 'Lesson',
			'learn_date' => 'Learn Date',
			'create_date' => 'Create Date',
			'searchname' => 'ชื่อ-สกุล',
			'lesson_active' => 'active'
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

		$criteria=new CDbCriteria;

       
		$criteria->compare('learn_id',$this->learn_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('learn_date',$this->learn_date,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchReset(){
		$criteria = new CDbCriteria;
		$criteria->with = array('User','Profile');
		// $criteria->join .= ' LEFT JOIN tbl_learn AS learn ON learn.user_id = User.id';
		// /*$criteria->join .= ' LEFT JOIN tbl_coursescore AS coursescore ON coursescore.user_id = t.user_id ';*/
		$criteria->group = 't.user_id';
		// //$criteria->compare('t.course_id',$this->search_course);
		$criteria->addCondition("lesson_active = 'y'");
		$criteria->addCondition('User.del_status = "0"');
		$criteria->compare('CONCAT(User.username)',$this->search_value,true);
		$criteria->compare('concat(Profile.firstname," ",Profile.lastname)',$this->searchname,true);
		//$criteria->compare('search_course',$this->search_course);
       
		$poviderArray = array('criteria' => $criteria);


        // Page

		if (isset($this->news_per_page)) {
			$poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
		} else {
			$poviderArray['pagination'] = array('pageSize' => intval(20));
		}
		// $t = new CActiveDataProvider($this, $poviderArray);
		// echo "<pre>";var_dump($t->getData());exit();

		return new CActiveDataProvider($this, $poviderArray);
	}

    public function beforeSave()
    {
		if($this->isNewRecord)
		{
			$this->create_date = date("Y-m-d H:i:s");
		}
        return parent::beforeSave();
    }
}