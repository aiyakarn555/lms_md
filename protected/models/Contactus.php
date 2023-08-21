<?php

class Contactus extends CActiveRecord
{
	public $verifyCode;
	//public $mess = "Please fill in the information!";
	public $mess;
	public $messEmail;
	public $captcha;

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
		// if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
  //           $langId = Yii::app()->session['lang'] = 1;
  //           $message = "กรุณากรอกข้อมูล!";
  //           }else{
  //               $langId = Yii::app()->session['lang'];
		
  //               $message = "Please fill in the information!";
  //       }
        //$message = "Please fill in the information!";
        // var_dump($this->mess);exit();

		$rules = array(
			array('contac_by_name,contac_by_surname,contac_by_email,contac_by_tel,contac_subject,contac_detail', 'required','message'=>$this->mess),
			array('captcha', 'required','message' => "Please verify that you are not a robot."),
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('contac_by_email','email','message' => $this->messEmail),
			array('contac_by_name, contac_by_surname, contac_by_email, contac_type', 'length', 'max'=>255),
			array('contac_by_tel', 'length', 'max'=>15),
			array('contac_subject, contac_ans_subject', 'length', 'max'=>100),
			array('contac_answer, active', 'length', 'max'=>1),
			array('contac_detail, contac_ans_detail, create_date, update_date', 'safe'),
			//array('verifyCode', 'captcha', 'on'=>'captchaRequired'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contac_id, contac_by_name, contac_by_surname, contac_by_email, contac_by_tel, contac_subject, contac_detail, contac_ans_subject, contac_ans_detail, contac_answer, create_by, create_date, update_by, update_date, active,contac_type', 'safe', 'on'=>'search'),
		);
//		if (!(isset($_POST['ajax']) && $_POST['ajax']==='contact_form')) {
//			array_push($rules,array('verifyCode', 'captcha'));
//		}
		return $rules;
	}

	public function relations()
	{
		return array(
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
			'verifyCode' => 'รหัสป้องกัน',
			'contac_type' => 'ประเภท',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		if($this->isNewRecord)
		{
			$this->create_date=new CDbExpression('NOW()');
            $this->create_by= Yii::app()->user->id; //option by default
        }else{
        	$this->update_date=new CDbExpression('NOW()');
        	$this->update_by= Yii::app()->user->id;
        }
        return parent::beforeSave();

    }
}
