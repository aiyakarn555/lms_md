<?php

/**
 * This is the model class for table "{{lesson_ms_teams}}".
 *
 * The followings are the available columns in table '{{lesson_ms_teams}}':
 * The followings are the available model relations:
 * @property GrouptestingMsTeams[] $grouptestingMsTeams
 * @property MsTeams $msTeams
 */
class LessonMsTeamsInstitution extends CActiveRecord
{
	 public $image;
    public $period_start;
    public $period_end;
    public $labelState = false;

     public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lesson_ms_teams}}';
	}

	 public function beforeSave()
    {
        $this->title = CHtml::encode($this->title);
        $this->description = CHtml::encode($this->description);
        $this->content = CHtml::encode($this->content);

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
        $this->title = CHtml::decode($this->title);
        $this->description = CHtml::decode($this->description);
        $this->content = CHtml::decode($this->content);

        return parent::afterFind();
    }

    public function rules()
    {
        return array(
            array('ms_teams_id, title, cate_amount,cate_percent', 'required' ),
            array('ms_teams_id', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>255),
            // array('description', 'length', 'max'=>255),
            array('content, create_date, create_by, news_per_page, CountManage, time_test,type,lang_id,parent_id,sequence_id,status', 'safe'),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
            array('id, active , ms_teams_id, CountManage, title, description, content, time_test,lang_id,parent_id,sequence_id, status', 'safe', 'on'=>'search'),
        );
    }

    public function getConcatCourseLesson()
    {

        return $this->msteams->name_ms_teams."/".$this->title;

    }

    public function relations()
    {
        return array(
            'msteams' => array(self::BELONGS_TO, 'MsTeamsInstitution', 'ms_teams_id'),
            'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
            'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
            'manages'=>array(self::HAS_MANY, 'ManageMsTeams', 'id'),
            'lang' => array(self::BELONGS_TO, 'Language', 'lang_id'),
            'fileDocs'=> array(self::HAS_MANY, 'FileDoc', 'lesson_id'),
        );
    }

    public function attributeLabels()
    {
        if(!$this->labelState){
            $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        }
        // $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        $lang = Language::model()->findByPk($this->lang_id);
        $mainLang = $lang->language;
        $label_lang = ' (ภาษา '.$mainLang.' )';
        return array(
            'id'           => 'หมวดหมู่'.$label_lang,
            'ms_teams_id'    => 'หลักสูตรอบรมเรียนรู้ทางไกล',
            'title'        => 'ชื่อบทเรียน'.$label_lang,
            'description'  => 'รายละเอียดย่อ'.$label_lang,
            'content'      => 'เนื้อหา'.$label_lang,
            'image'        => 'รูปภาพ'.$label_lang,
            'cate_amount'  => 'จำนวนครั้งที่สามารถทำข้อสอบได้'.$label_lang,
            'cate_percent' => 'เปอร์เซ็นในการผ่านของบท (หลังเรียน)'.$label_lang,
            'create_date'  => 'วันที่เพิ่มข้อมูล'.$label_lang,
            'create_by'    => 'ผู้เพิ่มข้อมูล'.$label_lang,
            'update_date'  => 'วันที่แก้ไขข้อมูล'.$label_lang,
            'update_by'    => 'ผู้แก้ไขข้อมูล'.$label_lang,
            'active'       => 'สถานะ'.$label_lang,
            'CountGroup'   => 'จำนวนชุด'.$label_lang,
            'filename'     => 'ไฟล์บทเรียน (mp3,mp4)'.$label_lang,
            'doc'          => 'ไฟล์ประกอบบทเรียน (pdf,doc,docx,ppt,pptx)'.$label_lang,
            'time_test'    => 'เวลาในการทำข้อสอบ (ก่อนเรียนและหลังเรียน)'.$label_lang,
            'type'    => 'ชนิดไฟล์บทเรียน'.$label_lang,
            'view_all'     => 'สิทธิ์การดูบทเรียนนี้'.$label_lang,
            'status' => 'เปิด ปิด เฉลยข้อสอบ ',
            'parent_id' => 'เมนูหลัก',
            'lang_id' => 'ภาษา',
            'sequence_id' => 'ลำดับ',
        );
    }

    public function checkScopes($check = 'scopes')
    {
        if ($check == 'scopes')
        {
            $checkScopes =  array(
                'alias' => 'lessonteams',
                'order' => ' lessonteams.id DESC ',
                'condition' => ' lessonteams.active ="y"',// AND courseonlines.active ="y"

            );
        }
        else
        {
            $checkScopes =  array(
                'alias' => 'lessonteams',
                'order' => ' lessonteams.id DESC ',
            );
        }

        return $checkScopes;
    }

    public function scopes()
    {
        //========== SET Controller loadModel() ==========//

        $Access = Controller::SetAccess( array("LessonMsTeamsInstitution.*") );
        $user = User::model()->findByPk(Yii::app()->user->id);
        $state = Helpers::lib()->getStatePermission($user);
        if($Access == true)
        {
            $scopes =  array(
                'lessoncheck' => $this->checkScopes('scopes')
            );
        }
        else
        {
            if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
            {
                $scopes =  array(
                    'lessoncheck' => $this->checkScopes('scopes')
                );
            }
            else
            {
                if($state){
                    $scopes = array(
                        'lessoncheck'=>array(
                            'alias' => 'lessonteams',
                            'condition' => ' lessonteams.active="y"',
                            'order' => ' lessonteams.id DESC ',
                        ),
                    );
                }else{
                  $scopes = array(
                    'lessoncheck'=>array(
                        'alias' => 'lessonteams',
                        'condition' => ' lessonteams.create_by = "'.Yii::app()->user->id.'" AND lessonteams.active="y" ',
                        'order' => ' lessonteams.id DESC ',
                    ),
                );  
              }

               
          }
      }

      return $scopes;
  }

  public function defaultScope()
  {
    $defaultScope =  $this->checkScopes('defaultScope');

    return $defaultScope;
}


public function getCountTest($type='pre')
{
    $count = ManageMsTeams::Model()->count("id=:lesson_id AND active=:active AND type=:type", array(
        "lesson_id"=>$this->id, "active"=>"y", "type"=>$type
    ));
    return $count;
}


public function getId()
{
    return $this->id;
}

public static function getChilds($sequence_id)
{
    $data = array();

    $criteria = new CDbCriteria;
    $criteria->addCondition('ms_teams_id ="'.$_GET['id'].'"');
    $criteria->addCondition('sequence_id ='.$sequence_id);
    $criteria->addCondition('active = "y"');
    $criteria->addCondition('lang_id = 1');
    $criteria->order='lesson_no';
    $lessonList = LessonMsTeamsInstitution::model()->findAll($criteria);

    foreach($lessonList as $model) {

        $row['text'] = $model->title;
        $row['data'] = $model->id;
        $row['lesson'] = $model->id;
        $row['code'] = $model->id;
        $row['children'] = LessonMsTeamsInstitution::getChilds($model->id);
        $data[] = $row;
    }
    return $data;
}

public function search()
{
    $criteria=new CDbCriteria;
    // $criteria->with = 'courseonlines';
    $criteria->with=array('msteams');

        //$criteria->compare('id',$this->id,true);
    $criteria->compare('lessonteams.ms_teams_id',$this->ms_teams_id,true);
    $criteria->compare('lessonteams.title',$this->title,true);
    $criteria->compare('lessonteams.description',$this->description,true);
    $criteria->compare('lessonteams.type',$this->type);
    $criteria->compare('lessonteams.content',$this->content,true);
        // $criteria->compare('parent_id',0);
    $criteria->compare('lessonteams.lang_id',1);
    $criteria->compare('msteams.active','y');
    $criteria->compare('lessonteams.active','y');
    // if(null !== Yii::app()->user && isset(Yii::app()->user->id)){
    //     $User=User::model()->findByPk(Yii::app()->user->id);
    //     if($User){
    //         $institution_id = $User->institution_id;

    //         $criteriaInstituation =new CDbCriteria;
    //         $criteriaInstituation->compare('institution_id',$institution_id);
    //         $UserAll = User::model()->findAll($criteriaInstituation);
    //         $user_array = array();
    //         foreach ($UserAll as $key => $value) {
    //             $user_array[] = $value->id;
    //         }
    //         $criteria->addInCondition('lessonteams.create_by',$user_array);

    //     }
    // }else{
    //     $criteria->compare('lessonteams.create_by',$this->create_by);
    // }
    $criteria->compare('msteams.type_ms_teams',2);
    $modelUser = Users::model()->findByPk(Yii::app()->user->id);
    $group = json_decode($modelUser->group);
    if (!in_array(1, $group)){
        $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
        $criteria->addInCondition('msteams.create_by', $groupUser);	
    }

    $criteria->order = 'lessonteams.create_date DESC';
    $poviderArray = array('criteria'=>$criteria);

        // Page
    if(isset($this->news_per_page))
    {
        $poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
    }

    return new CActiveDataProvider($this, $poviderArray);
}

public function GetfileCount($id)
{
    $file = File::model()->count("lesson_id=:id AND active = 'y' AND lang_id = 1 ",
        array("id" => $id));
    return $file;
}


}