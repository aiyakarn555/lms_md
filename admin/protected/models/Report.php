<?php

class Report extends CFormModel {

    public $typeOfUser;
    public $typeuser;
    public $university;
    public $company;
    public $categoryUniversity;
    public $categoryCompany;
    public $dateRang;
    public $period_start;
    public $period_end;
    public $course;
    public $department;
    public $nameSearch;
    public $user_id;
    public $company_id;
    public $division_id;
    public $position_id;
    public $courseArray;
    public $course_id;
    public $learnStatus;
    public $generation;
    public $search;
    public $lesson_id;
    public $station;
    public $schedule_id;
    public $type_user;
    public $type_register;
    public $gen_id;
    public $position;
    public $level;
    public $status_learn;
    public $question;
    public $active;
    public $course_number;
    public $institution_id;
    public $ms_teams_id;
    public $idcard;
    public $type_cou;


    public function rules()
    {
        return array(
            array('period_start,period_end,typeOfUser,dateRang,course,nameSearch,university,company,categoryUniversity,categoryCompany,company_id,division_id,position_id,department,station,schedule_id,type_user,course_id, type_register, gen_id, position, level, status_learn, question, active, course_number', 'safe'),
        );
    }


    public function attributeLabels(){
        return array(
            'typeOfUser' => 'ประเภทของสมาชิก',
            'dateRang' => 'เลือกระยะเวลา',
            'course' => 'หลักสูตร',
            'nameSearch' => 'ชื่อ - นามสกุล',
            'company_id' => 'หน่วยงาน',
            'division_id' => 'ฝ่าย',
            'position_id' => 'ตำแหน่ง',
            'search' => 'ค้นหา ชื่อ-นามสกุล',
            'period_start' => 'วันที่เริ่มต้น',
            'period_end' => 'วันที่สิ้นสุด',
            'generation' => 'เลือกรุ่น',
            'course_id' => 'เลือกหลักสูตร (บังคับ)',
            'lesson_id' => 'เลือกบทเรียน',
            'station' => 'สถานี',
            'schedule_id' => 'ตารางเรียน',
            'type_user' => 'ประเภทผู้ใช้งาน',

            'type_register'=>'ประเภทพนักงาน',
            'gen_id' => 'รุ่น  (บังคับ)',
            'department' => 'ฝ่าย',
            'position' => 'แผนก',
            'level'=>'level',
            'status_learn'=>'สถานะเรียน',
            'question'=>'เลือกแบบสอบถาม',
            'active'=>'Employee Status',
            'course_number'=>'Course No.',

            'idcard'=>'ค้นหา เลขบัตรประชาชน',
            'institution_id'=>'สถานบัน',
            'ms_teams_id'=>'ห้องเรียนออนไลน์',
            'type_cou'=>'ประเภทหลักสูตร',
            
        );
    }

    /**
     * @return mixed
     */

    public function getAllQuestion(){
        $sql = '';
        $sql .= ' select * from q_survey_headers';
        $sql .= ' join q_survey_sections on q_survey_headers.survey_header_id = q_survey_sections.survey_header_id';
        $sql .= ' where q_survey_headers.active = "y"';
        $question = Yii::app()->db->createCommand($sql)->queryAll();
        $questionlist = CHtml::listData($question,'survey_header_id','survey_name');

        return $questionlist;
    }

    public function getAllOfUsers() {

        $sql = '';
        $sql .= 'select * from tbl_users';
        $sql .= ' inner join tbl_profiles on tbl_profiles.user_id = tbl_users.id';
        $sql .= ' left join tbl_profiles_title on tbl_profiles.title_id = prof_id';
        $sql .= ' left join tbl_type_user on tbl_type_user.id = tbl_profiles.type_user';
        $sql .= ' where tbl_users.superuser = "0" and tbl_users.status = "1"';
        $sql .= ' group by tbl_users.id';
        $sql .= ' order by tbl_profiles.firstname asc';

        $users = Yii::app()->db->createCommand($sql)->queryAll();

        return $users;

    }

    public function getTypeOfUserList()
    {
        $typeOfUserList = array(
            'company'=>'ผู้ประกอบวิชาชีพ',
            'university'=>'นิสิต/นักศึกษา'
        );
        return $typeOfUserList;
    }

    public function getUniversityList()
    {
        $university = TbUniversity::model()->findAll();
        $universityList = CHtml::listData($university,'id','name');

        return $universityList;
    }

    public function getCategoryUniiversityList()
    {
        $course = CourseOnline::model()->findAllByAttributes(array('active'=>'y'));
        $courseList = CHtml::listData($course,'course_id','course_title');

        return $courseList;
    }

    public function getDepartmentList()
    {
        $department = OrgChart::model()->findAll();
        $departmentList = CHtml::listData($department,'id','title');

        return $departmentList;
    }


    public function getCategoryCompanyList()
    {
        $category = Category::model()->findAllByAttributes(array('cate_type'=>'2'));
        $categoryList = CHtml::listData($category,'cate_id','cate_title');

        return $categoryList;
    }

    public function getCompanyList()
    {
        $companyList = Group::getList('company');

        return $companyList;
    }

    public function getCourseList()
    {
        $courseList = CHtml::listData(CourseOnline::model()->with('cates')->findAll('courseonline.active="y"'), 'course_id', 'CoursetitleConcat');
        return $courseList;
    }
    public function getCourseListFreedom()
    {
        $courseList = CHtml::listData(CourseOnline::model()->with('cates')->findAll('courseonline.active="y"'), 'course_id', 'course_title');
        return $courseList;
    }


    public function search()
    {
        $sql = " SELECT * FROM tbl_users ";
        $sql .= ' left join tbl_profiles on tbl_profiles.user_id = tbl_users.id';
        $sql .= ' left join tbl_type_user on tbl_type_user.id = tbl_profiles.type_user';
        $sql .= ' right join tbl_learn on tbl_learn.user_id = tbl_users.id';
        $sql .= " where tbl_users.status = '1'";
        
        if($this->user_id != null) {
            $sql .= ' and tbl_users.id = "' . $this->user_id . '"';
        }
        // print_r($this);exit();
        if($this->nameSearch != null) {
            $sql .= ' and (tbl_profiles.firstname like "%' . $this->nameSearch . '%" or tbl_profiles.lastname = "%' . $this->nameSearch . '%")';
        }
        if($this->typeuser != null) {
            $sql .= ' and tbl_profiles.type_user = "' . $this->typeuser . '"';
        }
    
        $sql .= ' group by tbl_users.id';

        $rawData = Yii::app()->db->createCommand($sql)->queryAll();
        
        return new CArrayDataProvider($rawData, $poviderArray);
        //return $rawData;
    }


    public function ByCourse() {

        $sql = " select * from tbl_course_online";
        $sql .= " where tbl_course_online.active = 'y'";

        if($this->course_id != null) {
            $sql .= " and tbl_course_online.course_id = '" . $this->course_id . "'";
        }

        if($this->nameSearch != null) {
            $sql .= " and tbl_course_online.course_title like '%" . $this->nameSearch. "%'";
        }

        $providerArray = array();

		// Page
		if(isset($this->news_per_page)) {
			$providerArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

        $query = Yii::app()->db->createCommand($sql)->queryAll();
        return new CArrayDataProvider($query, $providerArray);

    }


  
}