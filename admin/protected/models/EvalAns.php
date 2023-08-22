<?php

class EvalAns extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{eval_ans}}';
	}

	public function rules()
	{
		return array(
			array('course_id, eva_id, user_id, eval_answer, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			array('eval_user_id, course_id, eva_id, user_id, eval_answer, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'profile' => array(self::BELONGS_TO, 'Profile', 'user_id'),
			'eva' => array(self::BELONGS_TO, 'Evaluate', 'eva_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'eval_user_id' => 'รหัส',
			'course_id' => 'รหัสหลักสูตร',
			'eva_id' => 'รหัสความพึงพอใจ',
			'user_id' => 'รหัสผู้ทำ',
			'eval_answer' => 'คำตอบ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

	public function search($id=null,$ans=null)
	{
		$criteria=new CDbCriteria;

		if($id !== null)
		{
			$criteria->compare('user_id',$id);
		}

		if($ans !== null)
		{
			$criteria->compare('course_id',$ans);
		}

		$criteria->compare('eval_user_id',$this->eval_user_id,true);
		$criteria->compare('eva_id',$this->eva_id,true);
		$criteria->compare('eval_answer',$this->eval_answer,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getNameUser() 
    {
        return $this->profile->firstname.' '.$this->profile->lastname;
    }

    public function getTotal($id, $ans, $point)
    {
		$modelEvaluate = EvalAns::model()->findAll(array(
			'condition' => 'course_id = "'.$ans.'" AND user_id = "'.$id.'" '
		));
		$sum = 0;
		foreach ($modelEvaluate as $key => $value) 
		{
			if($value->eval_answer == $point)
			{
				$sum = $sum+1;
			}
		}

		return $sum;
    }

    public function getTotalAns($ans, $point)
    {
		$modelEvaluate = EvalAns::model()->findAll(array(
			'condition' => 'course_id = "'.$ans.'" '
		));
		$sum = 0;
		foreach ($modelEvaluate as $key => $value) 
		{
			if($value->eval_answer == $point)
			{
				$sum = $sum+1;
			}
		}

		return $sum;
    }
}