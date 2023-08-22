<?php

/**
 * This is the model class for table "{{branch}}".
 *
 * The followings are the available columns in table '{{branch}}':
 * @property integer $id
 * @property string $branch_name
 * @property string $create_date
 * @property string $create_by
 * @property string $update_date
 * @property string $update_by
 * @property string $active
 * @property integer $position_id
 */
class Branch extends CActiveRecord
{
	public $department;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{branch}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position_id', 'numerical', 'integerOnly'=>true),
			array('branch_name, create_by, update_by', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			array('branch_name, position_id ', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, branch_name, create_date, create_by, update_date, update_by, lang_id, parent_id, active, position_id, sortOrder, department', 'safe', 'on'=>'search'),
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
			'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		if(empty($this->lang_id)){
			$this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		}else{
			$this->lang_id = $this->lang_id;
		}
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'id' => 'ID',
			'branch_name' => 'ชื่อเลเวล',
			'create_date' => 'สร้างวันที่',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'สถานะ',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
			'position_id' => 'ฝ่าย',
			'sortOrder' => 'ลำดับ',
			'department'=>'แผนก'
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
		$criteria->compare('branch_name',$this->branch_name,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('sortOrder',$this->sortOrder,true);



		if(isset($_GET['Branch']['position_id']) && $_GET['Branch']['position_id'] != ""){
			$criteria->compare('position_id',$this->position_id);
		}else{
			if(isset($_GET['Branch']['department']) && $_GET['Branch']['department'] != ""){

				$position = Position::model()->findAll("active='y' AND department_id=".$_GET['Branch']['department']);



				if(!empty($position)){
					$arr_posi = [];
					foreach ($position as $key => $value) {
						$arr_posi[] = $value->id;
					}

					$criteria->addIncondition('position_id', $arr_posi);
				}

			}else{
				$criteria->compare('position_id',$this->position_id);
			}
		}





		$criteria->compare('parent_id',0);
	    $criteria->compare('active',y);
		$criteria->order = 'sortOrder ASC';

		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));
		$poviderArray = array('criteria'=>$criteria);
		if(isset($_GET['Branch']['news_per_page'])) {
			$poviderArray['pagination'] = array( 'pageSize'=> intval($_GET['Branch']['news_per_page']) );
		}		
		return new CActiveDataProvider($this, $poviderArray);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Branch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

		if($this->isNewRecord){
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
		}else{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		return parent::beforeSave();
	}

	public function getBranchList($position_id = null){
		$strSql = $position_id != null ? ' AND position_id='.$position_id : '';
		$model = Branch::model()->findAll('active = "y"'.$strSql);
		$list = CHtml::listData($model,'id','branch_name');
		return $list;
	}

	public function getBranchListNew(){
		$model = Branch::model()->findAll('active = "y" AND lang_id = 1');
		$list = CHtml::listData($model,'id','branch_name');
		return $list;
	}

}
