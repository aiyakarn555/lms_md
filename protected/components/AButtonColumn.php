<?php 
class AButtonColumn extends CButtonColumn
{
	// Overiding Public Properties
	public $deleteButtonImageUrl = false;
	public $deleteButtonLabel = 'ลบ';
	public $updateButtonImageUrl = false;
	public $updateButtonLabel = 'แก้ไข';
	public $viewButtonImageUrl = false;
	public $viewButtonLabel = 'ดูรายละเอียด';
	public $header = 'จัดการ';
	public $deleteConfirmation = 'ยืนยันการลบข้อมูลหรือไม่ ?';
	public $textAlertDelete = 'ลบข้อมูลเรียบร้อย';
}