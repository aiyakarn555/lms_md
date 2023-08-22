<?php
/**
 * Created by PhpStorm.
 * User: nutti_000
 * Date: 7/5/2558
 * Time: 17:09
 */

class ReportUser extends CFormModel {

    public $typeOfUser;
    public $university;
    public $company;
    public $categoryUniversity;
    public $categoryCompany;
    public $dateRang;
    public $course;
    public $lesson;
    public $nameSearch;
    public $department;
    public $nameIdenSearch;
    public $company_id;
    public $division_id;
    public $position_id;
    public $generation;
    public $date_start;
    public $date_end;
    public $date_start_lastuse;
    public $date_end_lastuse;
    public $type_user;
    public $occupation;
    public $email;
    public $identification;
    public $status_login;
    public $status_learn;
    public $station;
    public $course_type;
    public $schedule_id;
    public $gen_id;
    public $employee_type;
    public $register_status;
    public $status;

    public function rules()
    {
        return array(
            array('generation,typeOfUser,dateRang,date_start,date_start_lastuse,date_end,date_end_lastuse,course,lesson,nameSearch,nameIdenSearch,university,company,categoryUniversity,categoryCompany,company_id,division_id,position_id,type_user,department,occupation,email,identification,status_login,status_learn,station,course_type,schedule_id, gen_id, employee_type, register_status, status', 'safe'),
        );
    }


    public function attributeLabels(){
        return array(
            'typeOfUser' => 'ประเภทของสมาชิก',
            'dateRang' => 'เลือกระยะเวลา',
            'course' => 'หลักสูตร',
            'nameSearch' => 'ชื่อ - นามสกุล',
            'company_id' => 'หน่วยงาน',
            'position_id' => 'ตำแหน่ง',
            'generation' => 'รุ่น',
            'date_start'=>'วันที่เริ่มต้น',
            'date_end'=>'วันที่สิ้นสุด',
            'date_start_lastuse'=>'วันที่เริ่มต้น(ล็อคอิน)',
            'date_end_lastuse'=>'วันที่สิ้นสุด(ล็อคอิน)',
            'type_user'=>'ประเภทสมาชิก',
            'occupation'=>'อาชีพ',
            'email'=>'อีเมล',
            'lesson'=>'บทเรียน',
            'identification' => 'รหัสบัตรประชาชน',
            'status_login'=>'สถานะล็อคอิน',
            'status_learn'=>'สถานะเรียน',
            'nameIdenSearch' => 'ชื่อ - นามสกุล / บัตรประชาชน',
            'division_id'=>'ฝ่าย',
            'department'=>'แผนก',
            'station'=>'สถานี',
            'course_type'=>'ประเภทหลักสูตร',
            'schedule_id' => 'ตารางเรียน',
            'gen_id' => 'รุ่น',
            'employee_type' => 'ประเภทพนักงาน', 
            'register_status' => 'สถานะ',
            'status' => 'สถานะการใช้งาน'
        );
    }

    /**
     * @return mixed
     */

    public function getTypeuserList(){
        $model = TypeUser::model()->findAll(array('condition'=>'active = 1'));
        $list = CHtml::listData($model,'id','name');
        return $list;
    }

    public function getStatusLogin()
    {
        $statusLogin = array(
            '1'=>'ล็อคอินแล้ว',
            '0'=>'ยังไม่ล็อคอิน'
        );
        return $statusLogin;
    }

    public function getStatusUser()
    {
        $statusUser = array(
            '1'=>'เปิดการใช้งาน',
            '0'=>'ระงับการใช้งาน'
        );
        return $statusUser;
    }

    public function getOccupationList(){
         $typeoccu = array('ธุรกิจส่วนตัว/เจ้าของกิจการ' => 'ธุรกิจส่วนตัว/เจ้าของกิจการ',
            'นักเรียน/นักศึกษา' => 'นักเรียน/นักศึกษา',
            'รับราชการ' => 'รับราชการ',
            'พนักงานรัฐวิสาหกิจ' => 'พนักงานรัฐวิสาหกิจ',
            'พนักงานเอกชน' => 'พนักงานเอกชน',
            'อื่น ๆ' => 'อื่น ๆ');
        return $typeoccu;
    }

    public function getGenerationList(){
        $model = Generation::model()->findAll();
        $list = CHtml::listData($model,'id_gen','name');
        return $list;
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

    // public function getDepartmentList()
    // {
    //     $department = OrgChart::model()->findAll();
    //     $departmentList = CHtml::listData($department,'id','title');

    //     return $departmentList;
    // }


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

    public function getTypeEmployeeList(){
        $model = TypeEmployee::model()->findAll(array('condition'=>'active = "y"'));
        $list = CHtml::listData($model,'id','type_employee_name');
        return $list;
    }

    public function getDivisionList(){
        $model = Department::model()->findAll(array('condition' => 'type_employee_id=2 and active="y"', 'order' => 'sortOrder'));
        $list = CHtml::listData($model, 'id', 'dep_title');
        return $list;
    }

    public function search()
    {
        $sql = " SELECT * FROM tbl_users ";
        $sql .= " WHERE status = '1' ";
        if($this->typeOfUser !='' ) {
            $sql .= " AND authitem_name = '" . $this->typeOfUser . "' ";
        }
//        if($this->dateRang !='') {
//            $sql .= " AND authitem_name = '" . $this->typeOfUser . "' ";
//        }
        $rawData = Yii::app()->db->createCommand($sql)->queryAll();
        //or use ->queryAll(); in CArrayDataProvider
//        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); //the count
        //$poviderArray = array('criteria'=>$criteria);

        /*$poviderArray = array( //or $model=new CArrayDataProvider($rawData, array(... //using with querAll...
            'keyField' => 'id',
            'totalItemCount' => $count,

            //if the command above use PDO parameters
            //'params'=>array(
            //':param'=>$param,
            //),


            'sort' => array(
                'attributes' => array(
                    'id','username', 'email'
                ),
                'defaultOrder' => array(
                    'id' => CSort::SORT_ASC, //default sort value
                ),
            )
        );

        if(isset($this->news_per_page))
        {
            $poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
        }*/

//        $model = new CSqlDataProvider($rawData, $poviderArray);

        return $rawData;
    }


}