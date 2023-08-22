<?php

/**
 * This is the model class for table "session".
 *
 * The followings are the available columns in table 'session':
 * @property string $id
 * @property integer $expire
 * @property string $data
 * @property integer $user_id
 * @property string $last_activity
 * @property string $last_ip
 */
class Sess extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('expire, user_id', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>32),
			array('last_ip', 'length', 'max'=>255),
			array('data, last_activity', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, expire, data, user_id, last_activity, last_ip', 'safe', 'on'=>'search'),
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
			'expire' => 'Expire',
			'data' => 'Data',
			'user_id' => 'User',
			'last_activity' => 'Last Activity',
			'last_ip' => 'Last Ip',
		);
	}

	public static function chk_online($id,$expire)
	{
		if($id!=''){
			echo "<span style='color: #00A000;'>ออนไลน์</span>";
		}else{
			echo "<span style='color: #c6c6c6'>ออฟไลน์</span>";
		}
	}

	public static function str_time_diff($timestamp = null, $html = true, $days_before_full_date = 3)
	{
		// เราจะหาค่า "ช่วงห่างของเวลาปัจจุบันกับเวลาที่กำหนด"
		// โดยเวลาปัจจุบันนั้นหาได้จากฟังก์ชั่น time()
		// ซึ่งเวลาที่กำหนดนั้นก็จะอยู่ในตัวแปร $timestamp
		// ซึ่งทั้งหมดจะมีหน่วยเป็นวินาที ซึ่งจะเก็บไว้ในตัวแปร $diff
		// แต่ก่อนอื่นเราต้องตรวจว่า $timestamp เป็นตัวเลขหรือไม่
		if (is_numeric($timestamp)) {
			// ถ้าใช่ ก็เอาไปลบกับเวลาปัจจุบันเลย
			$diff = time() - $timestamp;
		} else {
			// ถ้าไม่ ก็อนุมานว่ามันเป็นสตริง เช่น 2013-03-07 07:57:12
			// ลองเอาไปแปลงเป็นวินาทีด้วย strtotime() แล้วลบกับเวลาปัจจุบัน
			$diff = time() - strtotime($timestamp);
		}
		// หากความต่างของเวลาปัจจุบันกับ $timestamp เป็น 0
		if (!$diff) {
			$str = "เมื่อกี้นี้เอง";
		}
		// หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 นาที
		elseif ($diff < 60) {
			$str = "เมื่อ $diff วินาทีที่แล้ว";
		}
		// หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 ชั่วโมง
		elseif ($diff < 3600) {
			$str = 'เมื่อ ' . (int)($diff / 60) . ' นาทีที่แล้ว';
		}
		// หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 วัน
		elseif ($diff < 86400) {
			$str = 'เมื่อ ' . (int)($diff / 3600) . ' ชั่วโมงที่แล้ว';
		}
		// หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่าจำนวนวันที่กำหนดไว้
		// ในตัวแปร $days_before_full_date ที่เราจะใช้เป็นตัวบอกว่า
		// ควรจะแสดงวันที่เต็มเมื่อช่วงห่างเกินกี่วัน
		elseif ($diff < 86400 * $days_before_full_date) {
			$str = 'เมื่อ ' . (int)($diff / 86400) . ' วันที่แล้ว';
		}
		// หากตัวแปร $html เป็นจริง
		// หรือตัวแปร $str ยังไม่ถูกสร้างขึ้น ซึ่งเป็นเพราะช่วงห่างไม่อยู่ในเงื่อนไขข้างต้นเลย
		if ($html || !isset($str)) {
			// ตัวแปรที่ใช้แสดงผลชื่อเดือนภาษาไทย
			static $months = array(
				// ให้ index เริ่มที่ 1
				1 => 'มกราคม',  'กุมภาพันธ์', 'มีนาคม',    'เมษายน',
				'พฤษภาคม', 'มิถุนายน',  'กรกฎาคม',  'สิงหาคม',
				'กันยายน',  'ตุลาคม',   'พฤศจิกายน', 'ธันวาคม'
			);
			// หาค่าส่วนต่างๆ ของวันที่ปัจจุบันที่ต้องการ ด้วย explode() สตริงที่สร้างจาก date()
			// สมมติ date('j n Y H:s') สร้างสตริงออกมาแบบนี้ '8 4 2013 04:29'
			// เมื่อ explode() สตริงดังกล่าวโดยมี "ช่องว่าง" เป็นตัวแบ่ง
			// ก็จะได้ array('8', '4', '2013', '04:29')
			// และเพราะ array ดังกล่าวเป็น indexed array
			// เราจึงสามารถแยกใส่ตัวแปรได้ด้วย list()
			list($day, $month, $year, $time) = explode(' ', date('j n Y H:s'));
			// ทำค.ศ.ให้เป็นพ.ศ.ด้วยการ +543
			$year += 543;
			// วันที่เต็ม ที่จะใช้แสดงแบบเต็ม หรือใช้ใน attribute title
			$full_str = "เมื่อวันที่ $day $months[$month] $year เวลา $time น.";
			// หาก $str ยังไม่ได้ถูกสร้างขึ้น แสดงว่าเราต้องแสดงวันที่แบบเต็ม
			if (!isset($str)) {
				// ทำให้ $str มีค่าเดียวกันกับ $full_str
				$str = $full_str;
			}
		}
		// คืนค่ากลับไป
		return $html
			// หากตัวแปร $html เป็นจริง ก็ส่งค่ากลับไปในรูปแบบ HTML
			// โดยให้ $str เป็นข้อความอยู่ใน tag <span>
			// และให้ $full_str เป็นค่าของ attribute title
			? "<span class=\"str-time-diff\" title=\"$full_str\">$str</span>"
			// แต่ถ้าไม่ ก็ส่งค่าของ $str กลับไปเฉยๆ
			: $str;
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('expire',$this->expire);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('last_activity',$this->last_activity,true);
		$criteria->compare('last_ip',$this->last_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}