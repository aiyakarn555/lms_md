<?php

/**
 * This is the model class for table "{{menu_course}}".
 *
 * The followings are the available columns in table '{{menu_course}}':
 * @property integer $id
 * @property string $label_course
 * @property string $label_homepage
 * @property string $label_back
 * @property string $label_search
 * @property string $label_cate
 * @property string $label_startLearn
 * @property string $label_DocsDowload
 * @property string $label_step
 * @property string $label_Content
 * @property string $label_gotoLesson
 * @property string $label_detail
 * @property string $label_courseName
 * @property string $label_statuslearn
 * @property string $label_testPre
 * @property string $label_testPost
 * @property string $label_point
 * @property string $label_DoTest
 * @property string $label_resultTestPre
 * @property string $label_survey
 * @property string $label_questionnaire
 * @property string $label_Doquestionnaire
 * @property string $label_resultTestPost
 * @property string $label_detailSurvey
 * @property string $label_surveyName
 * @property string $label_headerSurvey
 * @property string $label_SatisfactionLv
 * @property string $label_download
 * @property string $label_courseRec
 * @property string $label_notLearn
 * @property string $label_lessonPass
 * @property string $label_learning
 * @property string $label_learnPass
 * @property string $label_courseAll
 * @property string $label_courseViewAll
 * @property string $label_notInLearn
 * @property string $label_notTestPre
 * @property string $label_notTestPost
 * @property string $label_trainPass
 * @property string $label_trainFail
 * @property string $label_AssessSatisfaction
 * @property string $label_testCourse
 * @property string $label_printCert
 * @property string $label_cantPrintCert
 * @property string $label_resultFinal
 * @property string $label_Fail
 * @property string $label_Pass
 * @property string $label_testFinalTimes
 * @property string $label_save
 * @property string $label_surveyCourse
 * @property string $label_noSurveyCourse
 * @property string $label_AnsweredQuestions
 * @property string $label_dontAnsweredQuestions
 * @property string $label_startDoSurvey
 * @property string $label_cantDoSurvey
 * @property string $label_swal_checkLearn
 * @property string $label_swal_warning
 * @property string $label_swal_plsLearnPass
 * @property string $label_swal_plsTestPost
 * @property string $label_congratulations
 * @property string $label_thank
 * @property string $label_backToSurvey
 * @property string $label_noPermis
 * @property string $label_error
 * @property integer $lang_id
 * @property integer $parent_id
 */
class MenuCourse extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_course}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label_notInLearn', 'required'),
			array('lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('label_course, label_homepage, label_search, label_cate, label_startLearn, label_DocsDowload, label_step, label_Content, label_gotoLesson, label_detail, label_courseName, label_statuslearn, label_testPre, label_testPost, label_point, label_DoTest, label_resultTestPre, label_survey, label_questionnaire, label_Doquestionnaire, label_resultTestPost, label_detailSurvey, label_surveyName, label_headerSurvey, label_SatisfactionLv, label_download, label_courseRec, label_notLearn, label_lessonPass, label_learning, label_learnPass, label_courseAll, label_courseViewAll, label_notInLearn, label_notTestPre, label_notTestPost, label_trainPass, label_trainFail, label_AssessSatisfaction, label_testCourse,label_doNotQuestionnaire, label_printCert, label_cantPrintCert, label_resultFinal, label_testFinalTimes,label_testFinalTimes,label_permisToTestFinal,label_NoPermisToTestFinal, label_surveyCourse, label_noSurveyCourse,label_doNotSurveyCourse, label_AnsweredQuestions, label_dontAnsweredQuestions, label_startDoSurvey, label_cantDoSurvey, label_swal_checkLearn, label_swal_warning, label_swal_plsLearnPass, label_swal_plsTestPost, label_congratulations, label_thank, label_backToSurvey, label_noPermis, label_error,label_alert_msg_StartLearn,
				label_alert_msg_welcome,
				label_alert_msg_notFound,
				label_alert_msg_expired,
				label_alert_msg_plsLogin,
				label_alert_welcome,
				label_confirm,
				label_swal_system,
				label_percentage,
				label_passTest,
				label_notPassTest,
				label_haveCorrect,
				label_list,
				label_startTestCourse,
				label_doNotTestCourse,
				label_totalTest,
				label_dateTest,
				label_doSurveyCourse,
			label_mess_notPass', 'length', 'max'=>255),
			array('label_back, label_Fail, label_Pass, label_save', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_course, label_homepage, label_back, label_search, label_cate, label_startLearn, label_course_wait, label_DocsDowload, label_step, label_Content, label_gotoLesson, label_detail, label_courseName, label_statuslearn, label_testPre, label_testPost, label_point, label_DoTest, label_resultTestPre, label_survey, label_questionnaire, label_Doquestionnaire, label_resultTestPost, label_detailSurvey, label_surveyName, label_headerSurvey, label_SatisfactionLv, label_download, label_courseRec, label_notLearn, label_lessonPass, label_learning, label_learnPass, label_courseAll, label_courseViewAll, label_notInLearn, label_notTestPre, label_notTestPost, label_trainPass, label_trainFail, label_AssessSatisfaction, label_testCourse,label_doNotQuestionnaire, label_printCert, label_cantPrintCert, label_resultFinal, label_Fail, label_Pass, label_testFinalTimes,label_testFinalTimes,label_permisToTestFinal,label_NoPermisToTestFinal,label_save, label_surveyCourse, label_noSurveyCourse,label_doNotSurveyCourse, label_AnsweredQuestions, label_dontAnsweredQuestions, label_startDoSurvey, label_cantDoSurvey, label_swal_checkLearn, label_swal_warning, label_swal_plsLearnPass, label_swal_plsTestPost, label_congratulations, label_thank, label_backToSurvey, label_noPermis, label_error,label_alert_msg_StartLearn,
				label_alert_msg_welcome,
				label_alert_msg_notFound,
				label_alert_msg_expired,
				label_alert_msg_plsLogin,
				label_alert_welcome,
				label_confirm,
				label_swal_system,
				label_percentage,
				label_passTest,
				label_notPassTest,
				label_haveCorrect,
				label_list,
				label_startTestCourse,
				label_doNotTestCourse,
				label_totalTest,
				label_dateTest,
				label_doSurveyCourse,
				label_mess_notPass, lang_id, parent_id', 'safe', 'on'=>'search'),
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
			'label_course' => 'หลักสูตร',
			'label_homepage' => 'หน้าแรก',
			'label_cate' => 'หมวดหมู่หลักสูตร',
			'label_search' => 'ใส่ข้อความที่ต้องการค้นหา...',
			'label_startLearn' => 'เริ่มเรียน',
			'label_course_wait' => 'สถานะรอผลตรวจ ข้อสอบบรรยาย',
			'label_DocsDowload' => 'เอกสารดาวน์โหลด',
			'label_step' => 'ขั้นตอนที่... ',
			'label_Content' => 'เนื้อหาของคอร์สนี้',
			'label_gotoLesson' => 'เข้าสู่บทเรียน',
			'label_detail' => 'รายละเอียด',
			'label_courseName' => 'ชื่อหลักสูตร',
			'label_statuslearn' => 'สถานะการเรียน',
			'label_testPre' => 'แบบทดสอบก่อนเรียน',
			'label_testPost' => 'แบบทดสอบหลังเรียน',
			'label_point' => 'คะแนน',
			'label_DoTest' => 'ทำแบบทดสอบ',
			'label_resultTestPre' => 'ผลทดสอบก่อนเรียน',
			'label_survey' => 'ประเมินแบบสอบถาม',
			'label_questionnaire' => 'แบบสอบถาม',
			'label_Doquestionnaire' => 'ทำแบบสอบถาม',
			'label_resultTestPost' => 'ผลทดสอบหลังเรียน',
			'label_detailSurvey' => 'คลิกเพื่อดูรายละเอียด',
			'label_surveyName' => 'ชื่อแบบสอบถาม',
			'label_headerSurvey' => 'หัวข้อแบบสอบถาม',
			'label_SatisfactionLv' => 'ระดับความพึงพอใจ',
			'label_download' => 'ดาวน์โหลด',
			'label_courseRec' => 'หลักสูตรแนะนำ',
			'label_notLearn' => 'ยังไม่ได้เรียน',
			'label_lessonPass' => 'ผ่านบทเรียน',
			'label_learning' => 'กำลังเรียน',
			'label_learnPass' => 'เรียนผ่าน',
			'label_courseAll' => 'หลักสูตรทั้งหมด',
			'label_courseViewAll' => 'ภาพรวมหลักสูตร',
			'label_notInLearn' => 'ยังไมได้เข้าเรียน',
			'label_notTestPre' => 'ไม่มีข้อสอบก่อนเรียน',
			'label_notTestPost' => 'ไม่มีข้อสอบหลังเรียน',
			'label_trainPass' => 'ผ่านการอบรม',
			'label_trainFail' => 'ไม่ผ่านการอบรม',
			'label_AssessSatisfaction' => 'ประเมินความพึงพอใจ',
			'label_testCourse' => 'สอบหลักสูตร',
			'label_doNotQuestionnaire'=> 'ยังทำแบบสอบถามไม่ครบ',
			'label_printCert' => 'พิมพ์ใบประกาศนียบัตร',
			'label_cantPrintCert' => 'ท่านไม่สามารถพิมพ์ใบรับรองได้ในขณะนี้',
			'label_resultFinal' => 'ผลการสออบ Final',
			'label_Fail' => 'ไม่ผ่าน',
			'label_Pass' => 'ผ่าน',
			'label_testFinalTimes' => 'สอบ Final ครั้งที่',
			'label_permisToTestFinal' => 'คุณมีสิทธิ์สอบ Final',
			'label_NoPermisToTestFinal'=>'คุณยังไม่มีสิทธิ์สอบ Final',
			'label_save' => 'บันทึก',
			'label_surveyCourse' => 'แบบสำรวจประจำหลักสูตร',
			'label_noSurveyCourse' => 'ไม่มีแบบสอบถามหลักสูตร',
			'label_doNotSurveyCourse'=> 'ท่านยังไม่ได้ทำแบบสอบถามหลักสูตร',
			'label_AnsweredQuestions' => 'ตอบแบบสอบถามแล้ว',
			'label_dontAnsweredQuestions' => 'ไม่ได้ตอบแบบสอบถาม',
			'label_startDoSurvey' => 'เริ่มทำแบบสอบถาม',
			'label_cantDoSurvey' => 'ไม่สามารถทำได้',
			'label_swal_checkLearn' => 'กรุณาตรวจสอบการเรียนรายวิชา !',
			'label_swal_warning' => 'คำเตือน',
			'label_swal_plsLearnPass' => 'กรุณาเรียนให้ผ่านก่อน',
			'label_swal_plsTestPost' => 'กรุณาทำแบบทดสอบหลังเรียนก่อน',
			'label_congratulations' => 'ขอแสดงความยินดี',
			'label_thank' => 'ขอขอบพระคุณเป็นอย่างสูง ที่ให้ความร่วมมือค่ะ',
			'label_backToSurvey' => 'ไปยังแบบสอบถาม',
			'label_noPermis' => 'ท่านไม่มีสิทธิ์',
			'label_error' => 'เกิดข้อผิดพลาด',
			'label_alert_msg_StartLearn' => 'คุณเริ่มเรียนไปแล้วเมื่อ',
			'label_alert_msg_welcome' => 'ขอให้สนุกกับการเรียนนะคะ',
			'label_alert_msg_notFound' => 'ไม่พบหลักสูตรรายวิชานี้ กรุณาติดต่อเจ้าหน้าที่',
			'label_alert_msg_expired' => 'ข้อมูล Login ของท่านหมดอายุ กรุณา Login ใหม่อีกครั้ง',
			'label_alert_msg_plsLogin' => 'กรุณาเข้าสู่ระบบก่อน',
			'label_alert_welcome' => 'ยินดีต้อนรับ',
			'label_confirm' => 'ยืนยัน',
			'label_swal_system' => 'ระบบ',
			'label_percentage' => 'อัตราร้อยละ',
			'label_passTest' => 'ผ่านการสอบ',
			'label_notPassTest' => 'ไม่ผ่านการสอบ',
			'label_haveCorrect' => 'ได้จำนวน',
			'label_list' => 'ข้อ',
			'label_startTestCourse' => 'กดเพื่อเริ่มทำแบบทดสอบ Final',
			'label_doNotTestCourse' => 'ท่านยังไม่ได้ทำแบบทดสอบ Final',
			'label_totalTest' => 'จำนวนข้อสอบ',
			'label_dateTest' => 'วันที่ทำข้อสอบ',
			'label_doSurveyCourse' => 'ท่านยังไม่ได้ทำแบบสอบถามหลักสูตร',
			'label_mess_notPass' => 'หากผู้สอบ "ไม่ผ่านการสอบ"  และต้องการสอบใหม่ จำเป็นต้องเริ่มเรียนใหม่',
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
		$criteria->compare('label_course',$this->label_course,true);
		$criteria->compare('label_homepage',$this->label_homepage,true);
		$criteria->compare('label_back',$this->label_back,true);
		$criteria->compare('label_search',$this->label_search,true);
		$criteria->compare('label_cate',$this->label_cate,true);
		$criteria->compare('label_startLearn',$this->label_startLearn,true);
		$criteria->compare('label_course_wait',$this->label_course_wait,true);
		$criteria->compare('label_DocsDowload',$this->label_DocsDowload,true);
		$criteria->compare('label_step',$this->label_step,true);
		$criteria->compare('label_Content',$this->label_Content,true);
		$criteria->compare('label_gotoLesson',$this->label_gotoLesson,true);
		$criteria->compare('label_detail',$this->label_detail,true);
		$criteria->compare('label_courseName',$this->label_courseName,true);
		$criteria->compare('label_statuslearn',$this->label_statuslearn,true);
		$criteria->compare('label_testPre',$this->label_testPre,true);
		$criteria->compare('label_testPost',$this->label_testPost,true);
		$criteria->compare('label_point',$this->label_point,true);
		$criteria->compare('label_DoTest',$this->label_DoTest,true);
		$criteria->compare('label_resultTestPre',$this->label_resultTestPre,true);
		$criteria->compare('label_survey',$this->label_survey,true);
		$criteria->compare('label_questionnaire',$this->label_questionnaire,true);
		$criteria->compare('label_Doquestionnaire',$this->label_Doquestionnaire,true);
		$criteria->compare('label_resultTestPost',$this->label_resultTestPost,true);
		$criteria->compare('label_detailSurvey',$this->label_detailSurvey,true);
		$criteria->compare('label_surveyName',$this->label_surveyName,true);
		$criteria->compare('label_headerSurvey',$this->label_headerSurvey,true);
		$criteria->compare('label_SatisfactionLv',$this->label_SatisfactionLv,true);
		$criteria->compare('label_download',$this->label_download,true);
		$criteria->compare('label_courseRec',$this->label_courseRec,true);
		$criteria->compare('label_notLearn',$this->label_notLearn,true);
		$criteria->compare('label_lessonPass',$this->label_lessonPass,true);
		$criteria->compare('label_learning',$this->label_learning,true);
		$criteria->compare('label_learnPass',$this->label_learnPass,true);
		$criteria->compare('label_courseAll',$this->label_courseAll,true);
		$criteria->compare('label_courseViewAll',$this->label_courseViewAll,true);
		$criteria->compare('label_notInLearn',$this->label_notInLearn,true);
		$criteria->compare('label_notTestPre',$this->label_notTestPre,true);
		$criteria->compare('label_notTestPost',$this->label_notTestPost,true);
		$criteria->compare('label_trainPass',$this->label_trainPass,true);
		$criteria->compare('label_trainFail',$this->label_trainFail,true);
		$criteria->compare('label_AssessSatisfaction',$this->label_AssessSatisfaction,true);
		$criteria->compare('label_testCourse',$this->label_testCourse,true);
		$criteria->compare('label_doNotQuestionnaire',$this->label_doNotQuestionnaire,true);
		$criteria->compare('label_printCert',$this->label_printCert,true);
		$criteria->compare('label_cantPrintCert',$this->label_cantPrintCert,true);
		$criteria->compare('label_resultFinal',$this->label_resultFinal,true);
		$criteria->compare('label_Fail',$this->label_Fail,true);
		$criteria->compare('label_Pass',$this->label_Pass,true);
		$criteria->compare('label_testFinalTimes',$this->label_testFinalTimes,true);
		$criteria->compare('label_save',$this->label_save,true);
		$criteria->compare('label_surveyCourse',$this->label_surveyCourse,true);
		$criteria->compare('label_noSurveyCourse',$this->label_noSurveyCourse,true);
		$criteria->compare('label_doNotSurveyCourse',$this->label_doNotSurveyCourse,true);
		$criteria->compare('label_AnsweredQuestions',$this->label_AnsweredQuestions,true);
		$criteria->compare('label_dontAnsweredQuestions',$this->label_dontAnsweredQuestions,true);
		$criteria->compare('label_startDoSurvey',$this->label_startDoSurvey,true);
		$criteria->compare('label_cantDoSurvey',$this->label_cantDoSurvey,true);
		$criteria->compare('label_swal_checkLearn',$this->label_swal_checkLearn,true);
		$criteria->compare('label_swal_warning',$this->label_swal_warning,true);
		$criteria->compare('label_swal_plsLearnPass',$this->label_swal_plsLearnPass,true);
		$criteria->compare('label_swal_plsTestPost',$this->label_swal_plsTestPost,true);
		$criteria->compare('label_congratulations',$this->label_congratulations,true);
		$criteria->compare('label_thank',$this->label_thank,true);
		$criteria->compare('label_backToSurvey',$this->label_backToSurvey,true);
		$criteria->compare('label_noPermis',$this->label_noPermis,true);
		$criteria->compare('label_error',$this->label_error,true);
		$criteria->compare('label_alert_msg_StartLearn',$this->label_alert_msg_StartLearn,true);
		$criteria->compare('label_alert_msg_welcome',$this->label_alert_msg_welcome,true);
		$criteria->compare('label_alert_msg_notFound',$this->label_alert_msg_notFound,true);
		$criteria->compare('label_alert_msg_expired',$this->label_alert_msg_expired,true);
		$criteria->compare('label_alert_msg_plsLogin',$this->label_alert_msg_plsLogin,true);
		$criteria->compare('label_alert_welcome',$this->label_alert_welcome,true);
		$criteria->compare('label_confirm',$this->label_confirm,true);
		$criteria->compare('label_swal_system',$this->label_swal_system,true);
		$criteria->compare('label_percentage',$this->label_percentage,true);
		$criteria->compare('label_passTest',$this->label_passTest,true);
		$criteria->compare('label_notPassTest',$this->label_notPassTest,true);
		$criteria->compare('label_haveCorrect',$this->label_haveCorrect,true);
		$criteria->compare('label_list',$this->label_list,true);
		$criteria->compare('label_startTestCourse',$this->label_startTestCourse,true);
		$criteria->compare('label_doNotTestCourse',$this->label_doNotTestCourse,true);
		$criteria->compare('label_totalTest',$this->label_totalTest,true);
		$criteria->compare('label_dateTest',$this->label_dateTest,true);
		$criteria->compare('label_doSurveyCourse',$this->label_doSurveyCourse,true);
		$criteria->compare('label_mess_notPass',$this->label_mess_notPass,true);
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
	 * @return MenuCourse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
