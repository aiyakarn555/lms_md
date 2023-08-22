<?php

class Page extends AActiveRecord
{
	public function tableName()
	{
		return '{{page}}';
	}

	public function rules()
	{
		return array(
			array('page_num, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('create_date, update_date ,active, news_per_page', 'safe'),
			array('page_num', 'required'),
			array('page_id, page_num, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'page_id' => 'Page',
			'page_num' => 'แสดงการโชว์',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่อัพเดทข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'ข้อมูลที่โดนลบ',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('page_num',$this->page_num);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active);

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

   	public function beforeSave() 
    {
		if(Yii::app()->user !== null && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 0;
		}

		$this->page_num = CHtml::encode($this->page_num);

		if($this->isNewRecord)
		{
			$this->create_by = $id;
			$this->create_date =  date("Y-m-d H:i:s");
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

    public function afterFind() 
    {
		$this->page_num = CHtml::decode($this->page_num);

        return parent::afterFind();
    }

    public function checkScopes()
    {
	    $checkScopes =  array(
	    	'alias' => 'pages',
	    	'condition' => ' pages.active = "y" ',
	    	'order' => ' pages.page_num ASC ',
	    );

		return $checkScopes;
    }

	public function scopes()
    {
		$Access = Controller::SetAccess( array("Page.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'pagecheck' => $this->checkScopes() 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'pagecheck' => $this->checkScopes() 
				);
			}
			else
			{
			    $scopes = array(
		            'pagecheck'	=>array(
			    		'alias' => 'pages',
			    		'condition' => ' pages.create_by = "'.Yii::app()->user->id.'" AND  pages.active = "y" ',
			    		'order' => ' pages.page_num ASC ',
		            ),
			    );
			}
		}

		return $scopes;
    }

	public function defaultScope()
	{
	    $defaultScope =  $this->checkScopes();

		return $defaultScope;
	}

}
