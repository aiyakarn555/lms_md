<?php
/**
 * Created by PhpStorm.
 * User: nutti_000
 * Date: 7/5/2558
 * Time: 17:09
 */

class ReportInfor extends CFormModel {

    public $generation;
    public $province;
    public $create_at;
    public $education;
    public $occupation;
    public $contactfrom;
    public $BusinessType;
    public $BusinessModel;
    public $date_start;
    public $date_end;

    public function rules()
    {
        return array(
            array('generation, province, create_at, lastvisit_at, education, occupation, contactfrom, BusinessType, BusinessModel, date_start, date_end', 'safe'),
        );
    }


    public function attributeLabels(){
        return array(
            'province' => 'จังหวัด',
            'generation' =>'รุ่น',
            'create_at' =>'วันที่สมัคร',
            'education'=>'วุฒิการศึกษา',
            'occupation'=>'รายงานอาชีพ',
            'contactfrom'=>'ช่องทางการประชาสัมพันธ์',
            'BusinessType'=>'รายงานประเภทธุรกิจ',
            'BusinessModel'=>'รายงานรูปแบบธุรกิจ',
            'date_start'=>'วันที่เริ่มต้น',
            'date_end'=>'วันที่สิ้นสุด',
        );
    }

    /**
     * @return mixed
     */
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