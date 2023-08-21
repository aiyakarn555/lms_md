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
			array('eva_id, course_id, eval_answer, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			array('eval_user_id, eva_id, course_id, eval_answer, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'eva' => array(self::BELONGS_TO, 'Evaluate', 'eva_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'eval_user_id' => 'Eval User',
			'eva_id' => 'Eva',
			'eval_answer' => 'Eval Answer',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('eval_user_id',$this->eval_user_id);
		$criteria->compare('eva_id',$this->eva_id);
		$criteria->compare('eval_answer',$this->eval_answer);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

   	public function beforeSave() 
    {
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

        return parent::beforeSave();
    }
}