<?php
class ExcelStudentFrom extends CFormModel
{
    public $excel_import_file;
    public $expire_date;
    public $group_name;

    public function rules()
    {
        return array(
            array('excel_import_file', 'file','allowEmpty'=>'false','mimeTypes'=>'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
            array('expire_date', 'numerical'),
            array('group_name', 'safe'),
        );


    }

    /**
     * Returns the attribute labels.
     * Attribute labels are mainly used in error messages of validation.
     * By default an attribute label is generated using {@link generateAttributeLabel}.
     * This method allows you to explicitly specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to
     * merge the parent labels with child labels using functions like array_merge().
     *
     * @return array attribute labels (name=>label)
     * @see generateAttributeLabel
     */
    public function attributeLabels()
    {
        return array(
            'excel_import_file' => 'ไฟล์ Excel',
            'expire_date' => 'จำนวนวันหมดอายุ',
            'group_name' => 'ชื่อกลุ่ม'
        );
    }
}