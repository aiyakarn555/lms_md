<?php

/**
 * This is the model class for table "{{choice_ms_teams}}".
 *
 * The followings are the available columns in table '{{choice_ms_teams}}':
 * @property integer $choice_id
 * @property integer $ques_id
 * @property string $choice_detail
 * @property integer $choice_answer
 * @property string $choice_type
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $reference
 *
 * The followings are the available model relations:
 * @property QuestionMsTeams $ques
 */
class ChoiceMsTeams extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{choice_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('ques_id, choice_answer, reference', 'numerical', 'integerOnly'=>true),
			//array('choice_detail', 'length', 'max'=>255),
			array('choice_detail', 'required'),
			array('choice_id, ques_id, choice_detail, choice_answer', 'safe', 'on'=>'search'),
		);
	}

   	public function beforeSave() 
    {
    	$this->choice_detail = CHtml::encode($this->choice_detail);

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
		else
		{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}

        return parent::beforeSave();
    }

    public function afterFind() 
    {
    	$this->choice_detail = CHtml::decode($this->choice_detail);
        return parent::afterFind();
    }

	public function relations()
	{
		return array(
			//'question' => array(self::BELONGS_TO, 'Question', 'ques_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'choice_id' => 'Choice',
			'ques_id' => 'Ques',
			'choice_detail' => 'คำตอบช้อยส์',
			'choice_answer' => 'Choice Answer',
			'reference' => 'reference',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('choice_id',$this->choice_id);
		$criteria->compare('ques_id',$this->ques_id);
		$criteria->compare('choice_detail',$this->choice_detail,true);
		$criteria->compare('choice_answer',$this->choice_answer);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
