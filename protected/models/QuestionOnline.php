<?php

/**
 * This is the model class for table "{{question_online}}".
 *
 * The followings are the available columns in table '{{question_online}}':
 * @property integer $ques_id
 * @property integer $group_id
 * @property integer $ques_type
 * @property string $test_type
 * @property string $difficult
 * @property string $ques_title
 * @property string $ques_explain
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $max_score
 *
 * The followings are the available model relations:
 * @property ChoiceOnline[] $choiceOnlines
 * @property GrouptestingOnline $group
 */
class QuestionOnline extends CActiveRecord
{
	public $choiceAnswer;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{question_online}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	 public static function getTempData($id)
    {
        $Question            = new CDbCriteria;
        $Question->condition = " ques_id = '".$id."'  AND active = 'y' ";
        $Question->offset    = 0;
//        $Question->limit     = $limit;
//        $Question->order     = ' RAND() ';

        return QuestionOnline::model()->find($Question);
    }

    public static function getLimitData($id, $limit,$rand=0)
    {
        $Question            = new CDbCriteria;
        $Question->condition = " group_id = '".$id."'  AND active = 'y' ";
        $Question->offset    = 0;
        $Question->limit     = $limit;
        $Question->order     = ' RAND() ';

        return QuestionOnline::model()->findAll($Question);
    }

    public static function getCountLimit($id,$limit)
    {
        $count = QuestionOnline::model()->count(new CDbCriteria(array(
            "condition" => "group_id = :group_id AND active = :active ",
            "params"    => array(
                ":group_id" => $id,
                ":active"   => "y"
                )
            )));

        if($limit > $count)
        {
            return $count;
        }
        else
        {
            return $limit;
        }
    }

    public function relations()
    {
        return array(
            'chioce' => array(self::HAS_MANY, 'ChoiceOnline', 'ques_id'),
            );
    }

    public function attributeLabels()
    {
        return array(
            'ques_id'      => 'Ques',
            'group_id'     => 'Group',
            'ques_type'    => 'Ques Type',
            'ques_title'   => 'Ques Title',
            'create_date'  => 'Create Date',
            'create_by'    => 'Create By',
            'update_date'  => 'Update Date',
            'update_by'    => 'Update By',
            'active'       => 'Active',
            'choiceAnswer' => 'คำตอบ',
            'test_type'    => 'ประเภทข้อสอบ',
            );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('ques_id',$this->ques_id);
        $criteria->compare('group_id',$this->group_id);
        $criteria->compare('ques_type',$this->ques_type);
        $criteria->compare('ques_title',$this->ques_title,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('create_by',$this->create_by);
        $criteria->compare('update_date',$this->update_date,true);
        $criteria->compare('update_by',$this->update_by);
        $criteria->compare('active',$this->active,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            ));
    }

    public function afterFind()
    {
        $this->ques_title = CHtml::decode($this->ques_title);

        return parent::afterFind();
    }

    public function defaultScope()
    {
        return array(
            'alias'     => 'question',
            'order'     => ' question.ques_id DESC ',
            'condition' => ' question.active = "y" ',
            );
    }
}