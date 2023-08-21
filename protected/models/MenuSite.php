<?php

/**
 * This is the model class for table "{{menu_site}}".
 *
 * The followings are the available columns in table '{{menu_site}}':
 * @property integer $id
 * @property string $label_imgslide
 * @property string $label_vdo
 * @property string $label_courseOur
 * @property string $label_news
 * @property string $label_docs
 * @property string $label_linkall
 * @property string $label_statusLearn
 * @property string $label_homepage
 * @property string $label_statusCourse
 * @property string $label_status
 * @property string $label_resultLearn
 * @property string $label_search
 * @property string $label_course
 * @property string $label_courseSearch
 * @property string $label_gen
 * @property string $label_notLearn
 * @property string $label_learned
 * @property string $label_learning
 * @property string $label_printCert
 * @property string $label_lesson
 * @property string $label_result
 * @property string $label_test
 * @property string $label_testFinal
 * @property string $label_assessSatisfaction
 * @property string $label_testPre
 * @property string $label_testPost
 * @property string $label_learnPass
 * @property string $label_learnFail
 * @property string $label_DotestPre
 * @property string $label_NoPreTest
 * @property string $label_DotestPost
 * @property string $label_NoPostTest
 * @property string $label_haveNotTest
 * @property string $label_seeResult
 * @property string $label_alert_warning
 * @property string $label_swal_learnPass
 * @property string $label_header_login
 * @property string $label_header_dashboard
 * @property string $label_header_update
 * @property string $label_header_logout
 * @property string $label_header_msg
 * @property string $label_header_msgAll
 * @property string $label_header_regis
 * @property string $label_header_username
 * @property string $label_header_password
 * @property string $label_header_remember
 * @property string $label_header_forgotPass
 * @property string $label_header_yes
 * @property string $label_placeholder_search
 * @property integer $lang_id
 * @property integer $parent_id
 */
class MenuSite extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_site}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('label_imgslide, label_vdo, label_courseOur, label_news, label_docs, label_linkall', 'length', 'max'=>200),
			array('label_statusLearn, label_homepage, label_statusCourse, label_status, label_resultLearn, label_search, label_course, label_courseSearch, label_gen, label_notLearn, label_learned, label_learning, label_printCert, label_lesson, label_result, label_test, label_testFinal, label_assessSatisfaction, label_testPre, label_testPost, label_learnPass, label_learnFail, label_DotestPre, label_NoPreTest, label_DotestPost, label_NoPostTest, label_haveNotTest, label_seeResult, label_alert_warning, label_swal_learnPass, label_header_login, label_header_dashboard, label_header_logout, label_header_msg, label_header_msgAll, label_header_regis, label_header_username, label_header_password, label_header_remember, label_header_forgotPass, label_header_yes', 'length', 'max'=>255),
			array('label_header_update, label_placeholder_search', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_imgslide, label_vdo, label_courseOur, label_news, label_docs, label_linkall,label_viewAll, label_statusLearn, label_homepage, label_statusCourse, label_status, label_resultLearn, label_search, label_course, label_courseSearch, label_gen, label_notLearn, label_learned, label_learning, label_printCert, label_lesson, label_result, label_test, label_testFinal, label_assessSatisfaction, label_testPre, label_testPost, label_learnPass, label_learnFail, label_DotestPre, label_NoPreTest, label_DotestPost, label_NoPostTest, label_haveNotTest, label_seeResult, label_alert_warning, label_swal_learnPass, label_header_login, label_header_dashboard, label_header_update, label_header_logout, label_header_msg, label_header_msgAll, label_header_regis, label_header_username, label_header_password, label_header_remember, label_header_forgotPass, label_header_yes, label_placeholder_search, lang_id, parent_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label_imgslide' => 'ป้ายประชาสัมพันธ์',
			'label_vdo' => 'วิดีโอแนะนำ',
			'label_courseOur' => 'หลักสูตรของเรา',
			'label_news' => 'ข่าวประชาสัมพันธ์',
			'label_docs' => 'เอกสารเผยแพร่',
			'label_linkall' => 'หน่วยงานที่เกี่ยวข้อง',
			'label_viewAll' => 'ดูทั้งหมด',
			'label_statusLearn' => 'สถานะการเรียน',
			'label_homepage' => 'หน้าแรก',
			'label_statusCourse' => 'สถานะของหลักสูตร',
			'label_status' => 'สถานะ',
			'label_resultLearn' => 'ผลการเรียน',
			'label_search' => 'ค้นหา',
			'label_course' => 'หลักสูตร',
			'label_courseSearch' => '-- หลักสูตรที่ต้องการค้นหา --',
			'label_gen' => 'รุ่น',
			'label_notLearn' => 'ยังไม่เรียน',
			'label_learned' => 'เรียนแล้ว',
			'label_learning' => 'กำลังเรียน',
			'label_printCert' => 'พิมพ์ใบประกาศ',
			'label_lesson' => 'บทที่',
			'label_result' => 'ผลการเรียน',
			'label_test' => 'สอบ',
			'label_testFinal' => 'แบบทดสอบ Final',
			'label_assessSatisfaction' => 'ประเมินความพึงพอใจ',
			'label_testPre' => 'สอบก่อนเรียน',
			'label_testPost' => 'สอบหลังเรียน',
			'label_learnPass' => 'เรียนผ่าน',
			'label_learnFail' => 'เรียนไม่ผ่าน',
			'label_DotestPre' => 'ทำข้อสอบก่อนเรียน',
			'label_NoPreTest' => 'ไม่มีข้อสอบก่อนเรียน',
			'label_DotestPost' => 'ทำข้อสอบหลังเรียน',
			'label_NoPostTest' => 'ไม่มีข้อสอบหลังเรียน',
			'label_haveNotTest' => 'ยังไม่ได้ทำแบบทดสอบ',
			'label_seeResult' => 'ดูผล',
			'label_alert_warning' => 'คำเตือน',
			'label_swal_learnPass' => 'กรุณาเรียนให้ผ่านก่อนสอบหลังเรียน',
			'label_header_login' => 'เข้าสู่ระบบ',
			'label_header_dashboard' => 'สถานะการเรียน',
			'label_header_update' => 'แก้ไขข้อมูล',
			'label_header_logout' => 'ออกจากระบบ',
			'label_header_msg' => 'กล่องข้อความ',
			'label_header_msgAll' => 'ข้อความทั้งหมด',
			'label_header_regis' => 'สมัครเรียน',
			'label_header_username' => 'ชื่อผู้ใช้',
			'label_header_password' => 'รหัสผ่าน',
			'label_header_remember' => 'จดจำบัญชีผู้ใช้งาน',
			'label_header_forgotPass' => 'ลืมรหัสผ่าน',
			'label_header_yes' => 'ตกลง',
			'label_placeholder_search' => 'ใส่ข้อความที่ต้องการค้นหา...',
			'lang_id' => 'ภาษา',
			'parent_id' => 'Parent',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('label_imgslide',$this->label_imgslide,true);
		$criteria->compare('label_vdo',$this->label_vdo,true);
		$criteria->compare('label_courseOur',$this->label_courseOur,true);
		$criteria->compare('label_news',$this->label_news,true);
		$criteria->compare('label_docs',$this->label_docs,true);
		$criteria->compare('label_linkall',$this->label_linkall,true);
		$criteria->compare('label_viewAll',$this->label_viewAll,true);
		$criteria->compare('label_statusLearn',$this->label_statusLearn,true);
		$criteria->compare('label_homepage',$this->label_homepage,true);
		$criteria->compare('label_statusCourse',$this->label_statusCourse,true);
		$criteria->compare('label_status',$this->label_status,true);
		$criteria->compare('label_resultLearn',$this->label_resultLearn,true);
		$criteria->compare('label_search',$this->label_search,true);
		$criteria->compare('label_course',$this->label_course,true);
		$criteria->compare('label_courseSearch',$this->label_courseSearch,true);
		$criteria->compare('label_gen',$this->label_gen,true);
		$criteria->compare('label_notLearn',$this->label_notLearn,true);
		$criteria->compare('label_learned',$this->label_learned,true);
		$criteria->compare('label_learning',$this->label_learning,true);
		$criteria->compare('label_printCert',$this->label_printCert,true);
		$criteria->compare('label_lesson',$this->label_lesson,true);
		$criteria->compare('label_result',$this->label_result,true);
		$criteria->compare('label_test',$this->label_test,true);
		$criteria->compare('label_testFinal',$this->label_testFinal,true);
		$criteria->compare('label_assessSatisfaction',$this->label_assessSatisfaction,true);
		$criteria->compare('label_testPre',$this->label_testPre,true);
		$criteria->compare('label_testPost',$this->label_testPost,true);
		$criteria->compare('label_learnPass',$this->label_learnPass,true);
		$criteria->compare('label_learnFail',$this->label_learnFail,true);
		$criteria->compare('label_DotestPre',$this->label_DotestPre,true);
		$criteria->compare('label_NoPreTest',$this->label_NoPreTest,true);
		$criteria->compare('label_DotestPost',$this->label_DotestPost,true);
		$criteria->compare('label_NoPostTest',$this->label_NoPostTest,true);
		$criteria->compare('label_haveNotTest',$this->label_haveNotTest,true);
		$criteria->compare('label_seeResult',$this->label_seeResult,true);
		$criteria->compare('label_alert_warning',$this->label_alert_warning,true);
		$criteria->compare('label_swal_learnPass',$this->label_swal_learnPass,true);
		$criteria->compare('label_header_login',$this->label_header_login,true);
		$criteria->compare('label_header_dashboard',$this->label_header_dashboard,true);
		$criteria->compare('label_header_update',$this->label_header_update,true);
		$criteria->compare('label_header_logout',$this->label_header_logout,true);
		$criteria->compare('label_header_msg',$this->label_header_msg,true);
		$criteria->compare('label_header_msgAll',$this->label_header_msgAll,true);
		$criteria->compare('label_header_regis',$this->label_header_regis,true);
		$criteria->compare('label_header_username',$this->label_header_username,true);
		$criteria->compare('label_header_password',$this->label_header_password,true);
		$criteria->compare('label_header_remember',$this->label_header_remember,true);
		$criteria->compare('label_header_forgotPass',$this->label_header_forgotPass,true);
		$criteria->compare('label_header_yes',$this->label_header_yes,true);
		$criteria->compare('label_placeholder_search',$this->label_placeholder_search,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuSite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
