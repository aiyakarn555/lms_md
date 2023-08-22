<?php

class AuthitemAccess extends AActiveRecord
{
	public function tableName()
	{
		return 'authitem';
	}

	public function rules()
	{
		return array(
			array('name, type', 'required'),
			array('type, access', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('description, bizrule, data, news_per_page', 'safe'),
			array('name, type, description, bizrule, data, access', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'name' => 'ชื่อระบบการเข้าถึงสิทธิ',
			'type' => 'Type',
			'description' => 'ชื่อที่ใช้เรียกกลุ่ม',
			'bizrule' => 'ลักษณะการตรวจสอบการเข้าถึง ( Code )',
			'data' => 'Data',
			'access' => 'การเข้าถึงสิทธิ์การแก้ไข',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('access',$this->access);

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes()
    {
        return array(
            'typecheck'=>array(
                'condition'=>' authitemaccess.type = 1 ',
            ),
        );
    }

	public function defaultScope()
	{
	    return array(
	    	'alias' => 'authitemaccess',
	    	//'order' => 'categoryproducts.cate_sequence DESC , categoryproducts.cate_id DESC',
	    );
	}

	public function getAccess()
	{
		$name = explode(".*", $this->name);

		if($this->access == 1)
		{
			$check = CHtml::tag('a',array(
				'onclick'=>'AccessAjax("'.$name[0].'","0");',
				'class' => 'btn btn-icon glyphicons remove_2'),'<i></i>ไม่อนุญาติ'
			);
		}
		else
		{
			$check = CHtml::tag('a',array(
				'onclick'=>'AccessAjax("'.$name[0].'","1");',
				'class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>อนุญาติ'
			);
		}
		
		return $check;
	}

	public function getNameCheck()
	{
		if($this->description != null)
		{
			$check = $this->description;
		}
		else
		{
			$check = $this->name;
		}

		return $check;
	}
}
