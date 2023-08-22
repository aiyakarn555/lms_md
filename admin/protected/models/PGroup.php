<?php

/**
 * This is the model class for table "p_group".
 *
 * The followings are the available columns in table 'p_group':
 * @property integer $id
 * @property string $detail
 * @property string $group_name
 * @property string $create_date
 * @property string $create_by
 * @property string $update_date
 * @property string $update_by
 */
class PGroup extends CActiveRecord
{
    public $news_per_page;
    public $switch;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'p_group';
	}


    public function beforeSave()
    {
        if ($this->isNewRecord){
            $this->create_date= new CDbExpression('NOW()');
            $this->create_by= Yii::app()->user->id;
        }else{
            $this->update_date= new CDbExpression('NOW()');
            $this->update_by= Yii::app()->user->id;
        }
        return true;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('group_name', 'required'),
			array('group_name, create_by', 'length', 'max'=>255),
			array('news_per_page, create_date, update_date, update_by', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('news_per_page, id, group_name, create_date, create_by, update_date, update_by, priority', 'safe', 'on'=>'search'),
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
			'created' => array(self::BELONGS_TO, 'User', array('create_by' => 'id')),
			'updated' => array(self::BELONGS_TO, 'User', array('update_by' => 'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_name' => 'Group Name',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
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
		$criteria->compare('group_name',$this->group_name,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->addCondition('id != 1');

        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == "") {
                $criteria->order = 'priority ASC';
            }
        }

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
	 * @return PGroup the static model class
	 */
	public static function getGroupList(){
		$model = PGroup::model()->findAll(array('condition' => 'id != 1'));
		$list = CHtml::listData($model,'id','group_name');
		return $list;	
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
