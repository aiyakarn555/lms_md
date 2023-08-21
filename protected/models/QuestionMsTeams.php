
<?php
class QuestionMsTeams extends CActiveRecord
{
    public $choiceAnswer;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{question_ms_teams}}';
    }

    public function rules()
    {
        return array(
            array('group_id, ques_type, create_by, update_by', 'numerical', 'integerOnly'=>true),
            array('ques_title', 'length', 'max'=>255),
            array('active', 'length', 'max'=>1),
            array('create_date, update_date, choiceAnswer', 'safe'),
            array('ques_id, group_id, ques_type, ques_title, create_date, create_by, update_date, update_by, active, test_type, difficult', 'safe', 'on'=>'search'),
            array('choiceAnswer', 'required'),
            );
    }

    public static function getTempData($id)
    {
        $Question            = new CDbCriteria;
        $Question->condition = " ques_id = '".$id."'  AND active = 'y' ";
        $Question->offset    = 0;
//        $Question->limit     = $limit;
//        $Question->order     = ' RAND() ';

        return QuestionMsTeams::model()->find($Question);
    }

    public static function getLimitData($id, $limit,$rand=0)
    {
        $Question            = new CDbCriteria;
        $Question->condition = " group_id = '".$id."'  AND active = 'y' ";
        $Question->offset    = 0;
        $Question->limit     = $limit;
        $Question->order     = ' RAND() ';

        return QuestionMsTeams::model()->findAll($Question);
    }

    public static function getCountLimit($id,$limit)
    {
        $count = QuestionMsTeams::model()->count(new CDbCriteria(array(
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
            'chioce' => array(self::HAS_MANY, 'ChoiceMsTeams', 'ques_id'),
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