<?php
class AActiveRecord extends CActiveRecord
{
	public $news_per_page = null;
	
	public function afterSave() 
    {
		if(count($this->errors) == 0 && !Yii::app()->session['NoFlash'])
		{
			if($this->isNewRecord)
			{		
				Yii::app()->user->setFlash('Save', array('msg'=>'บันทึกข้อมูลเรียบร้อย','class'=>'success'));
			}
			else
			{
				Yii::app()->user->setFlash('Save', array('msg'=>'แก้ไขข้อมูลเรียบร้อย','class'=>'success'));
			}	
		}
		else
		{
			if(!Yii::app()->session['NoFlash'])
			{
				Yii::app()->user->setFlash('Error', array('msg'=>'ไม่สามารถบันทึกข้อมูลได้','class'=>'error'));
			}
		}
		unset(Yii::app()->session['NoFlash']);
	    return parent::afterSave();
    }
}
?>