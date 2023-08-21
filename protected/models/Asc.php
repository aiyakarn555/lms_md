<?php

class Asc extends AActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'asc';
	}

	public function rules()
	{
		return array(
			array('title', 'length', 'max'=>255),
			array('title', 'required'),
			array('title', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(

		);
	}

	public function attributeLabels()
	{
		return array(
			'title' => 'ชื่อหน่วยงาน',
		);
	}

	public function getAscList(){
		$model = Asc::model()->findAll();
		$list = CHtml::listData($model,'id','title');
		return $list;
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('title',$this->title);
			
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}
}
