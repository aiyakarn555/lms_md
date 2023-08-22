<?php

class FileAudio extends AActiveRecord
{
	public $pp_file;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{file_audio}}';
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

	public function rules()
	{

		return array(
			array('file_name', 'required'),
			array('filename', 'file', 'types'=>'mp4,mp3,mkv', 'allowEmpty'=>true),
			array('pp_file', 'file', 'types'=>'pptx,pdf', 'allowEmpty'=>true),
			array('lesson_id, file_position, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>80),
//			array('file_name', 'length', 'max'=>255),
			array('length', 'length', 'max'=>20),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date, news_per_page', 'safe'),

			array('id, lesson_id, filename, file_name, length, file_position, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'lesson' => array(self::BELONGS_TO, 'Lesson', 'lesson_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lesson_id' => 'Lesson',
			'filename' => 'ไฟล์บทเรียน (mp3,mp4,mkv)',
			'file_name' => 'ชื่อไฟล์เสียง',
			'pp_file' => 'ไฟล์ PDF (.pdf)',
			'length' => 'Length',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
		);
	}

	public function search($id = null)
	{
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
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('parent_id',0,true);

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
				'alias' => 'file',
				'order' => ' file.file_position DESC, file.id DESC ',
				'condition' => ' file.active ="y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
				'alias' => 'file',
				'order' => ' file.file_position DESC, file.id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("File.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'coursecheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'coursecheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'coursecheck'=>array(
						'alias' => 'file',
						'order' => ' file.file_position DESC, file.id DESC ',
						'condition' => ' file.create_by = "'.Yii::app()->user->id.'" AND file.active ="y" ',
		            ),
			    );
			}
		}

		return $scopes;
    }

	public function defaultScope()
	{
	    $defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

	public function getFileVdo()
	{
		$html = '
		<div>
	   		<div id="vdo'.$this->id.'" vdo="'.$this->filename.'">Loading the player...</div>
		</div>
		';
		return $html;
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