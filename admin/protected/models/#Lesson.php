<?php

class Lesson extends AActiveRecord
{
    public $image;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{lesson}}';
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
            array('course_id, title , description , content ,cate_amount,cate_percent, view_all', 'required' ),
            array('course_id', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>80),
            array('description', 'length', 'max'=>255),
            array('content, create_date, create_by, news_per_page, CountManage, time_test', 'safe'),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
            array('id, active , course_id, CountManage, title, description, content, time_test', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'courseonlines' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
            'fileCount'=>array(self::STAT, 'File', 'lesson_id'),
            'files' => array(self::HAS_MANY, 'File', 'lesson_id'),
            'documents' => array(self::HAS_MANY, 'Document', 'lesson_id'),
            'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
            'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id'           => 'หมวดหมู่',
            'course_id'    => 'หลักสูตรอบรมออนไลน์',
            'title'        => 'ชื่อบทเรียน',
            'description'  => 'รายละเอียดย่อ',
            'content'      => 'เนื้อหา',
            'image'        => 'รูปภาพ',
            'cate_amount'  => 'จำนวนครั้งที่สามารถทำข้อสอบได้',
            'cate_percent' => 'เปอร์เซ็นในการผ่านของบท',
            'create_date'  => 'วันที่เพิ่มข้อมูล',
            'create_by'    => 'ผู้เพิ่มข้อมูล',
            'update_date'  => 'วันที่แก้ไขข้อมูล',
            'update_by'    => 'ผู้แก้ไขข้อมูล',
            'active'       => 'สถานะ',
            'CountGroup'   => 'จำนวนชุด',
            'filename'     => 'ไฟล์บทเรียน (mp3,mp4)',
            'time_test'    => 'เวลาในการทำข้อสอบ',
            'view_all'     => 'สิทธิ์การดูบทเรียนนี้'
        );
    }

    public function checkScopes($check = 'scopes')
    {
        if ($check == 'scopes')
        {
            $checkScopes =  array(
                'alias' => 'lesson',
                'order' => ' lesson.id DESC ',
                'condition' => ' lesson.active ="y" ',
            );
        }
        else
        {
            $checkScopes =  array(
                'alias' => 'lesson',
                'order' => ' lesson.id DESC ',
            );
        }

        return $checkScopes;
    }

    public function scopes()
    {
        //========== SET Controller loadModel() ==========//

        $Access = Controller::SetAccess( array("Lesson.*") );
        
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
                    '' => $this->checkScopes('scopes')
                );
            }
            else
            {
                $scopes = array(
                    'lessoncheck'=>array(
                        'alias' => 'lesson',
                        'condition' => ' lesson.create_by = "'.Yii::app()->user->id.'" AND lesson.active="y" ',
                        'order' => ' lesson.id DESC ',
                    ),
                );
            }
        }

        return $scopes;
    }

    public function defaultScope()
    {
        $defaultScope =  $this->checkScopes('defaultScope');

        return $defaultScope;
    }

    public function getCountFile()
    {
        $count = File::Model()->count("lesson_id=:lesson_id AND active=:active", array(
            "lesson_id"=>$this->id,"active"=>"y"
        ));
        return $count;
    }

    public function getId()
    {
        return $this->id;
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        //$criteria->compare('id',$this->id,true);
        $criteria->compare('course_id',$this->course_id,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('content',$this->content,true);

        $poviderArray = array('criteria'=>$criteria);

        // Page
        if(isset($this->news_per_page))
        {
            $poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
        }

        return new CActiveDataProvider($this, $poviderArray);
    }
}
