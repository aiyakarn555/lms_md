<?php

/**
 * This is the model class for table "{{file_pdf}}".
 *
 * The followings are the available columns in table '{{file_pdf}}':
 * @property integer $id
 * @property integer $lesson_id
 * @property string $file_name
 * @property string $filename
 * @property string $length
 * @property integer $file_position
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class FilePdf extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{file_pdf}}';
	}

	protected function beforeSave()
    {
        // convert to storage format
		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 0;
		}	

		// Max Number //
		$maxNumber = Yii::app()->db->createCommand()
		  ->select('MAX(file_position) as file_position')
		  ->from($this->tableName())
		  ->queryScalar();

		if($this->isNewRecord)
		{
			$this->file_position = $maxNumber + 1;
			$this->create_by = $id;
			$this->create_date = date('Y-m-d');
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


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('filename', 'required'),
			array('lesson_id, file_position, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('file_name', 'length', 'max'=>255),
			array('filename', 'file', 'types'=>'pdf,docx,pptx', 'allowEmpty'=>true),
			array('filename', 'length', 'max'=>80),
			array('length', 'length', 'max'=>20),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lesson_id, file_name, filename, length, file_position, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'fileSlide' => array(self::HAS_MANY, 'PdfSlide', array('file_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lesson_id' => 'Lesson',
			'file_name' => 'ชื่อ',
			'filename' => 'Filename',
			'length' => 'Length',
			'file_position' => 'File Position',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'pdf' => 'ไฟล์บทเรียน (pdf)',
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
	public function search($id = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

        if($id !== null)
        {
            $criteria->compare('lesson_id',$id);
        }
        else
        {
            $criteria->compare('lesson_id',$this->lesson_id);
        }

		$criteria->compare('id',$this->id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('file_position',$this->file_position);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('parent_id',0,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FilePdf the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getRefileName()
	{
		if($this->file_name  == '')
		{
			$check = $this->filename;
		}
		else
		{
			$check = $this->file_name;
		}

		return $check;
	}
}
