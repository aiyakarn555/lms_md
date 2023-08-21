<?php

/**
 * This is the model class for table "{{score_ms_teams}}".
 *
 * The followings are the available columns in table '{{score_ms_teams}}':
 * @property integer $score_id
 * @property integer $ms_teams_id
 * @property integer $gen_id
 * @property integer $user_id
 * @property integer $lesson_teams_id
 * @property string $type
 * @property integer $score_number
 * @property integer $score_total
 * @property string $score_past
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $ques_type
 * @property integer $confirm
 */
class ScoreMsTeams extends CActiveRecord
{
	 public $score_total;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Score the static model class
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
		return '{{score_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ms_teams_id, gen_id, user_id, lesson_teams_id, score_number, score_total, create_by, update_by, ques_type, confirm', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>4),
			array('score_past, active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('score_id, ms_teams_id, gen_id, user_id, lesson_teams_id, type, score_number, score_total, score_past, create_date, create_by, update_date, update_by, active, ques_type, confirm', 'safe', 'on'=>'search'),
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
            'Lessons'=>array(self::BELONGS_TO, 'LessonMsTeams', 'lesson_teams_id'),
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
            'score_id'     => 'Score',
            'lesson_teams_id'    => 'Lesson',
            'user_id'      => 'User',
            'type'         => 'type',
            'score_total'  => 'Score Totle',
            'score_number' => 'Score Number',
            'create_date'  => 'Create Date',
            'create_by'    => 'Create By',
            'update_date'  => 'Update Date',
            'update_by'    => 'Update By',
            'active'       => 'Active',
            'gen_id'       => 'gen_id',


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

        $criteria->compare('score_id',$this->score_id);
        $criteria->compare('lesson_teams_id',$this->lesson_teams_id);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('type',$this->type);
        $criteria->compare('score_total',$this->score_total);
        $criteria->compare('score_number',$this->score_number);
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
