<?php

/**
 * This is the model class for table "{{logchoice_ms_teams}}".
 *
 * The followings are the available columns in table '{{logchoice_ms_teams}}':
 * @property integer $logchoice_id
 * @property integer $gen_id
 * @property integer $lesson_teams_id
 * @property integer $user_id
 * @property integer $score_id
 * @property integer $ques_id
 * @property integer $choice_id
 * @property string $test_type
 * @property integer $ques_type
 * @property integer $logchoice_answer
 * @property string $is_valid_choice
 * @property integer $logchoice_select
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 *
 * The followings are the available model relations:
 * @property Lesson $lessonTeams
 */
class LogchoiceMsTeams extends CActiveRecord
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
		return '{{logchoice_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('score_id, choice_id, ques_id, user_id, create_by, update_by, ques_type', 'numerical', 'integerOnly'=>true),
            array('active', 'length', 'max'=>1),
            array('create_date, update_date, test_type, ques_type, is_valid_choice', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logchoice_id, score_id, choice_id, logchoice_select, ques_id, user_id, create_date, create_by, update_date, update_by, active, test_type, ques_type, is_valid_choice, gen_id', 'safe', 'on'=>'search'),
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
            'choices'=>array(self::BELONGS_TO, 'ChoiceMsTeams', 'choice_id'),
        );
    }

    public function beforeSave()
    {
        if(null !== Yii::app()->user && isset(Yii::app()->user->id))
            $id = Yii::app()->user->id;
        else
            $id = 0;

        if($this->isNewRecord){
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
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'logchoice_id'    => 'Logchoice',
            'score_id'        => 'Score',
            'choice_id'       => 'Choice',
            'ques_id'         => 'Ques',
            'user_id'         => 'User',
            'test_type'       => 'Test Type',
            'ques_type'       => 'Question Type',
            'is_valid_choice' => 'is valid choice',
            'create_date'     => 'Create Date',
            'create_by'       => 'Create By',
            'update_date'     => 'Update Date',
            'update_by'       => 'Update By',
            'active'          => 'Active',
            'gen_id'          => 'gen_id',

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

        $criteria=new CDbCriteria;

        $criteria->compare('logchoice_id',$this->logchoice_id);
        $criteria->compare('score_id',$this->score_id);
        $criteria->compare('choice_id',$this->choice_id);
        $criteria->compare('ques_id',$this->ques_id);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('test_type',$this->test_type,true);
        $criteria->compare('ques_type',$this->ques_type,true);
        $criteria->compare('is_valid_choice',$this->is_valid_choice,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('create_by',$this->create_by);
        $criteria->compare('update_date',$this->update_date,true);
        $criteria->compare('update_by',$this->update_by);
        $criteria->compare('active',$this->active,true);
        $criteria->compare('gen_id',$this->gen_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}