<?php

/**
 * This is the model class for table "{{org_depart}}".
 *
 * The followings are the available columns in table '{{org_depart}}':
 * @property integer $id
 * @property integer $orgchart_id
 * @property integer $depart_id
 * @property integer $parent_id
 * @property integer $order
 * @property string $active
 */
class OrgDepart extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{org_depart}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orgchart_id, depart_id, parent_id, order', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orgchart_id, depart_id, parent_id, order, active', 'safe', 'on'=>'search'),
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
			'depart' => array(self::BELONGS_TO, 'Department', 'depart_id','foreignKey' => array('depart_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orgchart_id' => 'Orgchart',
			'depart_id' => 'Depart',
			'parent_id' => 'Parent',
			'order' => 'Order',
			'active' => 'Active',
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
		$criteria->compare('orgchart_id',$this->orgchart_id);
		$criteria->compare('depart_id',$this->depart_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('order',$this->order);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getChilds($parent) {
		$data = array();

		$OrgDepart = OrgDepart::model()->findAll('parent_id = '.$parent.' AND orgchart_id ='.$_GET['id']);
		foreach($OrgDepart as $model) {
			$row['text'] = $model->depart->dep_title;
			$row['data'] = $model->id;
			$row['children'] = OrgDepart::getChilds($model->id);
			$data[] = $row;
		}
		return $data;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrgDepart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
