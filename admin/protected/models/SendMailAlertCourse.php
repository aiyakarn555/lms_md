<?php

class SendMailAlertCourse extends CFormModel {

    public $news_per_page;
    public $search_name;
    public $type_employee;
    public $position_id;
    public $department_id;
    public $course_id;
    public $status;
    public $gen_id;
    
    


    public function rules()
    {
        return array(
            // array('course_id', 'required'),
            array('news_per_page,search_name,type_employee , position_id, department_id,course_id,status,gen_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('search_name,type_employee , position_id, department_id,course_id,status,gen_id', 'safe', 'on'=>'search'),
        );
    }
    
    // public function relations()
    // {
    //     // NOTE: you may need to adjust the relation name and the related
    //     // class name for the relations automatically generated below.
    //     return array(
    //         'pro' => array(self::BELONGS_TO, 'Profile', 'user_id'),
    //         'mem' => array(self::BELONGS_TO, 'User', 'user_id','foreignKey' => array('user_id'=>'id')),
    //         'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
    //         'gen' => array(self::BELONGS_TO, 'CourseGeneration', 'gen_id'),
    //     );
    // }


    public function attributeLabels(){
        $color = '<font style="color:red">*</font>';
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'course_id' => 'Course'.$color,
            'type_employee' => 'ประเภทพนักงาน'.$color,
            'position_id' => 'ตำแหน่ง',
            'department_id' => 'แผนก'.$color,
            'search_name' => 'ชื่อ-สกุล',//, เลขบัตรประชาชน-พาสปอร์ต
            'status'=>'สถานะการเรียน'.$color,
            'gen_id'=>'รุ่น'.$color,
            
        );
    }

    public function getSatus(){
       $list = array(
        '1'=>'สมัครเข้าเรียนแล้ว',
        '2'=>'กำลังเรียน',
        '3'=>'ยังไม่ได้เข้าเรียน'
        );
        return $list;
    }

    public function getGenList(){

        $model = CourseGeneration::model()->findAll('active = "y"');
        $list = CHtml::listData($model,'gen_id','gen_title');
        return $list;
        
    }

}