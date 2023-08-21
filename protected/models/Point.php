<?php

/**
 * This is the model class for table "{{point}}".
 *
 * The followings are the available columns in table '{{point}}':
 * @property integer $point_id
 * @property integer $id
 * @property double $point_money
 * @property string $point_file
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property integer $con_user
 * @property integer $con_admin
 * @property string $active
 */
class Point extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Point the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{point}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, create_by, update_by, con_user, con_admin', 'numerical', 'integerOnly'=>true),
			array('point_money', 'numerical'),
			array('point_file', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			array('point_file', 'required', 'on'=>'update', 'message' => Controller::messageError("")),
			array('point_money', 'required' , 'message' => Controller::messageError("")),
			array('point_file', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'insert,update' ,'wrongType'=>Controller::messageError("img")),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('point_id, id, point_money, point_file, create_date, create_by, update_date, update_by, con_user, con_admin, active', 'safe', 'on'=>'search'),
		);
	}

	public function getCheckConfirm()
	{
		$get = 'update';
		$imageUrl = Yii::app()->request->baseUrl .'/images/';
		if($this->con_user == 0){
			$imageUrl .= 'coins.png';
			$link = CHtml::link(CHtml::image($imageUrl,'Accept'),array($get,'id'=>$this->point_id),array(
			    'click' => 'function(){}',
			   	'class' => 'imageIcon',
			));
		}else{
			if ($this->con_admin == 1) 
			  	$link = '<font color="#009933" style="font-weight:bold;">อนุมัติเรียบร้อย</font>';
			else
			  	$link = '<font color="#3333FF" style="font-weight:bold;">รอการตรวจสอบ</font>';
		}
		return $link;
	}

	public function getShowIcon()
	{
		return $this->con_admin == '0';
	}

	public function getShowIconEdit()
	{
		return $this->con_user == '1' && $this->con_admin == '0';
	}

	public function getConfirmViewUser()
	{
		if ($this->con_user == 1) 
			$link = '<font color="#009933" style="font-weight:bold;">ยืนยันการโอนเงินแล้ว</font>';
		else
			$link = '<font color="#991A00" style="font-weight:bold;">ยังไม่มีการยืนยันโอนเงิน</font>';
		return $link;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'point_id' => 'Point',
			'id' => 'ID',
			'Datailhead'=>'หัวข้อ',
			'point_money' => 'จำนวน Point ที่สั่ง',
			'create_date' => 'วันที่สั่งซื้อ',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'point_file' => 'รูปไฟล์เอกสาร',
			'con_user' => 'ยืนยันการโอนเงิน',
			'con_admin' => 'การอนุมัติ Point',
			'active' => 'Active',
		);
	}

   	public function beforeSave() 
    {
		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

		if($this->isNewRecord){
			$this->id = $id;
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}else{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
        return parent::beforeSave();
    }

    public function afterFind() 
    {
        return parent::afterFind();
    }

	public function defaultScope()
	{
	    return array(
	    	'order' => 'point_id desc',
	    	'condition' => ' active = "y" AND id = "'.Yii::app()->user->id.'" ',

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

		$criteria = new CDbCriteria;
		$criteria->compare('point_id',$this->point_id);
		$criteria->compare('id',$this->id);
		$criteria->compare('point_money',$this->point_money,true);
		$criteria->compare('point_file',$this->point_file,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('con_user',$this->con_user);
		$criteria->compare('con_admin',$this->con_admin);
		$criteria->compare('active',$this->active,true);

		if (!empty($this->create_date)) 
			$criteria->compare('create_date',ClassFunction::DateSearch($this->create_date),true);

		$poviderArray = array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
		);

		return new CActiveDataProvider($this, $poviderArray);
	}
}