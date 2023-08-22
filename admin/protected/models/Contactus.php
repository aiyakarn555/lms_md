<?php

class Contactus extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{contactus}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('contac_by_name, contac_by_surname, contac_by_email', 'length', 'max'=>255),
			array('contac_by_tel', 'length', 'max'=>15),
			array('contac_subject, contac_ans_subject', 'length', 'max'=>100),
			array('contac_answer, active', 'length', 'max'=>1),
			array('contac_detail, contac_ans_detail, create_date, update_date,news_per_page, parent_id, lang_id', 'safe'),
			array('contac_id, contac_by_name, contac_by_surname, contac_by_email, contac_by_tel, contac_subject, contac_detail, contac_ans_subject, contac_ans_detail, contac_answer, create_by, create_date, update_by, update_date, active, parent_id, lang_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'contac_id' => 'รหัส',
			'contac_by_name' => 'ชื่อ',
			'contac_by_surname' => 'นามสกุล',
			'contac_by_email' => 'อีเมลล์',
			'contac_by_tel' => 'เบอร์โทรศัพท์',
			'contac_subject' => 'หัวข้อ',
			'contac_detail' => 'ข้อความ',
			'contac_ans_subject' => 'หัวข้อตอบกลับ',
			'contac_ans_detail' => 'ข้อความตอบกลับ',
			'contac_answer' => 'สถานะตอบกลับ',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'active' => 'สถานะ',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('contac_id',$this->contac_id);
		$criteria->compare('contac_by_name',$this->contac_by_name,true);
		$criteria->compare('contac_by_surname',$this->contac_by_surname,true);
		$criteria->compare('contac_by_email',$this->contac_by_email,true);
		$criteria->compare('contac_by_tel',$this->contac_by_tel,true);
		$criteria->compare('contac_subject',$this->contac_subject,true);
		$criteria->compare('contac_detail',$this->contac_detail,true);
		$criteria->compare('contac_ans_subject',$this->contac_ans_subject,true);
		$criteria->compare('contac_ans_detail',$this->contac_ans_detail,true);
		$criteria->compare('contac_answer',$this->contac_answer,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('parent_id',0);
                
		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		return new CActiveDataProvider($this, $poviderArray);
	}
		public function beforeSave()
	 {
		 $this->contac_ans_subject 		= CHtml::encode($this->contac_ans_subject);
		 $this->contac_ans_detail 	= CHtml::encode($this->contac_ans_detail);

	 if(null !== Yii::app()->user && isset(Yii::app()->user->id))
	 {
		 $id = Yii::app()->user->id;
	 }
	 else
	 {
		 $id = 1;
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

	//  public function afterFind()
	//  {
	// 	 $this->contac_ans_subject 		= CHtml::decode($this->contac_ans_subject);
	// 	 $this->contac_ans_detail 	= CHtml::decode($this->contac_ans_detail);
	//
	// 		 return parent::afterFind();
	//  }
	//
	//  public function checkScopes($check = 'scopes')
	//  {
	// 	 if ($check == 'scopes')
	// 	 {
	// 		 $checkScopes =  array(
	// 			 'order' => ' contac_id DESC ',
	// 			 'condition' => ' active = "y" ',
	// 		 );
	// 	 }
	// 	 else
	// 	 {
	// 		 $checkScopes =  array(
	// 			 'order' => ' contac_id DESC ',
	// 		 );
	// 	 }
	//
	//  return $checkScopes;
	//  }
	//
	// public function scopes()
	//  {
	// 	 //========== SET Controller loadModel() ==========//
	//
	//  $Access = Controller::SetAccess( array("Contactus.*") );
	//  if($Access == true)
	//  {
	// 	 $scopes =  array(
	// 		 'contactuscheck' => $this->checkScopes('scopes')
	// 	 );
	//  }
	//  else
	//  {
	// 	 if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
	// 	 {
	// 		 $scopes =  array(
	// 			 'contactuscheck' => $this->checkScopes('scopes')
	// 		 );
	// 	 }
	// 	 else
	// 	 {
	// 			 $scopes = array(
	// 						 'contactuscheck'=>array(
	// 					 'alias' => 'contactus',
	// 					 'condition' => '  contactus.create_by = "'.Yii::app()->user->id.'" AND contactus.active = "y" ',
	// 					 'order' => ' contactus.contac_id DESC ',
	// 						 ),
	// 			 );
	// 	 }
	//  }
	//
	//  return $scopes;
	//  }

	public function defaultScope()
	{
		return array(
				'order' => ' contac_id DESC ',
 				'condition'=>"active='y'",
 			);
	}

	public function getId()
	{
	 return $this->contac_id;
	}
}
