<?php

class Profile extends CActiveRecord {

    /**
     * The followings are the available columns in table 'profiles':
     * @var integer $user_id
     * @var boolean $regMode
     */
    public $regMode = false;
    private $_model;
    private $_modelReg;
    private $_rules = array();
    public $file_user;
    public $id;
    public $prename_other_en;
    public $prename_other_th;


    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{profiles}}';
    }

    public function getNameUser($id = null) {
        $model = Profile::model()->findByPk($id);
        return $model->firstname;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array(
            array('prefix_th,prefix_en,firstname, lastname ,firstname_en, lastname_en , identification,birthday,address,province,district,subdistrict,zipcode', 'required', 'message' => UserModule::t("{attribute} ไม่ควรเป็นค่าว่าง")),
            // array('identification', 'numerical', 'integerOnly' => true),
            // array('phone', 'numerical', 'integerOnly' => true),
            // array('identification', 'length', 'max'=>13),
            array('identification', 'validateIdCard'),
            // array('identification', 'length', 'max' => 13,'min'=>13),
            array('title_id, firstname, lastname,face_amount', 'safe', 'on' => 'search'),
            array('identification', 'UniqueCard'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $relations = array(
            'user' => array(self::HAS_ONE, 'User', 'id'),
            'type_name' => array(self::BELONGS_TO, 'TypeUser', 'type_user'),
            'ProfilesEdu' => array(self::BELONGS_TO, 'ProfilesEdu', 'user_id'),
            'ProfilesTitleEn' => array(self::BELONGS_TO, 'ProfilesTitle', 'prefix_en'),
            'ProfilesTitleTH' => array(self::BELONGS_TO, 'ProfilesTitle', 'prefix_th'),

        );
        if (isset(Yii::app()->getModule('user')->profileRelations))
            $relations = array_merge($relations, Yii::app()->getModule('user')->profileRelations);
        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => UserModule::t('User ID'),
            'prefix_th' => "คำนำหน้า (ไทย)",
            'prefix_en' => "คำนำหน้า (อังกฤษ)",
            'firstname' => "ชื่อ (ไทย)",
            'lastname' => "นามสกุล (ไทย)",
            'firstname_en' => 'ชื่อ (อังกฤษ)',
            'lastname_en' => 'นามสกุล (อังกฤษ)',
            'identification' => 'เลขบัตรประจำตัวประชาชน',
            'birthday' => 'วันเกิด',
            'address' => "ที่อยู่",
            'province' => 'จังหวัด',
            'district' => 'อำเภอ',
            'subdistrict' => 'ตำบล',
            'zipcode' => 'รหัสไปรษณีย์',
            'phone' => "เบอร์โทรศัพท์",
            'face_amount'=>'รอบยืนยันตัวตน'
            

            
        );
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that 
        // should not be searched. 

        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('firstname_en', $this->firstname_en, true);
        $criteria->compare('lastname_en', $this->lastname_en, true);
        $criteria->compare('birthday', $this->birthday, true);
        $criteria->compare('prefix_th', $this->prefix_th, true);
        $criteria->compare('prefix_en', $this->prefix_en, true);
        $criteria->compare('identification', $this->identification, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function UniqueCard($attribute,$params){
        
        if($this->user_id == null){

            $chk = Profile::model()->find(array(
                'condition'=>'identification=:idcard ',
                'params' => array(':idcard' => $this->identification)
            ));
            if($chk != null){
                if($this->typeregis == 1){
                    $this->addError('identification', 'เลขบัตรประชาชนนี้ มีอยู่แล้วในระบบ');
                }else{
                    $this->addError('identification', 'เลขพาสปอร์ตนี้ มีอยู่แล้วในระบบ');
                }
            }
        }else{
         $chk = Profile::model()->find(array(
            'condition'=>'identification=:idcard and user_id != :user_id',
            'params' => array(':idcard' =>$this->identification ,':user_id' => $this->user_id )
        ));
           if($chk != null){
            if($this->typeregis == 1){
                $this->addError('identification', 'เลขบัตรประชาชนนี้ มีอยู่แล้วในระบบ');
            }else{
                $this->addError('identification', 'เลขพาสปอร์ตนี้ มีอยู่แล้วในระบบ');
            }

        }
    }
}

     public function validateIdCard($attribute,$params){

        if($this->typeregis == 1){

            $str = $this->identification;
            $chk = strlen($str);
            if($chk == "13"){
            $id = str_split(str_replace('-', '', $this->identification)); //ตัดรูปแบบและเอา ตัวอักษร ไปแยกเป็น array $id
            $sum = 0;
            $total = 0;
            $digi = 13;
            for ($i = 0; $i < 12; $i++) {
                $sum = $sum + (intval($id[$i]) * $digi);
                $digi--;
            }
            $total = (11 - ($sum % 11)) % 10;
            if ($total != $id[12]) { //ตัวที่ 13 มีค่าไม่เท่ากับผลรวมจากการคำนวณ ให้ add error
                $this->addError('identification', 'เลขบัตรประชาชนนี้ไม่ถูกต้อง ตามการคำนวณของระบบฐานข้อมูลทะเบียนราษฎร์*');
            }
        }
    }

    }

    private function rangeRules($str) {
        $rules = explode(';', $str);
        for ($i = 0; $i < count($rules); $i++)
            $rules[$i] = current(explode("==", $rules[$i]));
        return $rules;
    }

    static public function range($str, $fieldValue = NULL) {
        $rules = explode(';', $str);
        $array = array();
        for ($i = 0; $i < count($rules); $i++) {
            $item = explode("==", $rules[$i]);
            if (isset($item[0]))
                $array[$item[0]] = ((isset($item[1])) ? $item[1] : $item[0]);
        }
        if (isset($fieldValue))
            if (isset($array[$fieldValue]))
                return $array[$fieldValue];
            else
                return '';
        else
            return $array;
    }

    public function widgetAttributes() {
        $data = array();
        $model = $this->getFields();

        foreach ($model as $field) {
            if ($field->widget)
                $data[$field->varname] = $field->widget;
        }
        return $data;
    }

   /* public function chkIdentification($id){
        for($i=0, $sum=0; $i < 12;$i++){
            $sum += floatval($id[$i]);
        }
        if((11-$sum%11)%10 != floatval($id[12]))
            return false;
        return true;
    }
*/
    public function widgetParams($fieldName) {
        $data = array();
        $model = $this->getFields();

        foreach ($model as $field) {
            if ($field->widget)
                $data[$field->varname] = $field->widgetparams;
        }
        return $data[$fieldName];
    }

    public function getFields() {
        if ($this->regMode) {
            if (!$this->_modelReg)
                $this->_modelReg = ProfileField::model()->forRegistration()->findAll();
            return $this->_modelReg;
        } else {
            if (!$this->_model)
                $this->_model = ProfileField::model()->forOwner()->findAll();
            return $this->_model;
        }
    }

}
