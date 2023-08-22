<?php

/**
 * This is the model class for table "log_admin".
 *
 * The followings are the available columns in table 'log_admin':
 * @property integer $id
 * @property string $controller
 * @property string $action
 * @property string $parameter
 * @property string $module
 * @property integer $user_id
 * @property string $create_date
 */
class LogAdmin extends CActiveRecord
{
    public $news_per_page;
    public $search_name;
    public $search_passport;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('controller, action, parameter, module', 'length', 'max'=>255),
			array('news_per_page, create_date, search_name, search_passport', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('news_per_page, id, controller, action, parameter, module, user_id, create_date', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'Users', 'user_id'),
            'member'=>array(self::BELONGS_TO, 'Profiles', 'user_id'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'controller' => 'Controller',
			'action' => 'Action',
			'parameter' => 'Parameter',
			'module' => 'Module',
			'search_name' => 'ชื่อ - นามสกุล',
			'search_passport' => 'รหัสบัตรประชาชน - พาสปอร์ต',
			'user_id' => 'User',
			'create_date' => 'Create Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->with = array('user','member');
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('parameter',$this->parameter,true);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('user_id',$this->user_id);
		//$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('CONCAT(member.m_firstname_th , " " , member.m_lastname_th , " ", " ", username," ",member.m_firstname_en , " " , member.m_lastname_en)',$this->search_name,true);
		$criteria->compare('user.identification',$this->search_passport,true);
		$criteria->order = 't.create_date DESC';
//        $criteria->group = 'create_date';

        $poviderArray = array('criteria' => $criteria);

        // Page
        if (isset($this->news_per_page)) {
            $poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
        } else {
            $poviderArray['pagination'] = array('pageSize' => intval(20));
        }

        return new CActiveDataProvider($this, $poviderArray);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogAdmin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
