<?php
Class ClassFunction
{
	// Text Css Error
	public static function CircleQuestionMark()
	{
		return '<span style="margin:0;" class="btn-action single glyphicons circle_question_mark" data-toggle="tooltip" data-placement="top" data-original-title="First name is mandatory"><i></i></span>';
	}

    public static function dateThaiShort($date) 
    {
        $strYear = date("Y", strtotime($date));
        $strMonth = date("n", strtotime($date));
        $strDay = date("j", strtotime($date));
        $strHour = date("H", strtotime($date));
        $strMinute = date("i", strtotime($date));
        $strSeconds = date("s", strtotime($date));
        $strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    // Date Thai
    public static function datethai($date) 
    {
        //$strYear = date("Y", strtotime($date)) + 543;
        $strYear = date("Y", strtotime($date));
        $strMonth = date("n", strtotime($date));
        $strDay = date("j", strtotime($date));
        $strHour = date("H", strtotime($date));
        $strMinute = date("i", strtotime($date));
        $strSeconds = date("s", strtotime($date));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    // Date Thai Time
    public static function datethaiTime($date) {
        if($date != null){
            $strYear = date("Y", strtotime($date));
            $strMonth = date("n", strtotime($date));
            $strDay = date("j", strtotime($date));
            $strHour = date("H", strtotime($date));
            $strMinute = date("i", strtotime($date));
            $strSeconds = date("s", strtotime($date));
            $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strMonthThai = $strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear $strHour:$strMinute"." น.";
        }else{
            return "Not set";
        }
    }

    public static function datePrint($date)
    {
        $CutTime = explode(' ', $date);
        $dateCheck = explode('-', $CutTime[0]);
        return $dateCheck[2].'/'.$dateCheck[1].'/'.$dateCheck[0];
    }

    public static function ThaiBahtConversion($amount_number)
    {
        $amount_number = number_format($amount_number, 2, ".","");
        $pt = strpos($amount_number , ".");
        $number = $fraction = "";
        if ($pt === false) 
            $number = $amount_number;
        else
        {
            $number = substr($amount_number, 0, $pt);
            $fraction = substr($amount_number, $pt + 1);
        }

        $ret = "";
        $baht = ClassFunction::ReadNumber($number);
        if ($baht != "")
            $ret .= $baht . "บาท";
        
        $satang = ClassFunction::ReadNumber($fraction);
        if ($satang != "")
            $ret .=  $satang . "สตางค์";
        else 
            $ret .= "ถ้วน";

        return $ret;
    }

    public static function ReadNumber($number)
    {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $ret = "";
        if ($number == 0) return $ret;
        if ($number > 1000000)
        {
            $ret .= ClassFunction::ReadNumber(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }
        
        $divider = 100000;
        $pos = 0;
        while($number > 0)
        {
            $d = intval($number / $divider);
            $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
            ((($divider == 10) && ($d == 1)) ? "" :
                ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
            $ret .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }
        return $ret;
    }
    
    public static function expdate($startdate,$datenum)
    {
        $startdatec = strtotime($startdate);
        $tod = $datenum*86400;
        $ndate = $startdatec+$tod;
        return $ndate;
    }
    // Cut Text
    public static function textcut($text,$min,$max)
    {
        return mb_strimwidth($text, $min, $max, " ...", "UTF-8");
    }
    // Choice Type 
    public static function ChoiceType($text,$check = false,$name,$i)
    {
    	if($check == 1) $checked = true; else $checked = false;
    	if($text == 'radio')
    		return CHtml::radioButton($name, $checked,array('onclick' => 'ReSetClick('.$i.');'));
    	else
    		return CHtml::checkBox($name, $checked);
    }
    
    // Date Search Model
    public static function is_date($dateCheck) 
    { 
        $DateSearch = explode('/', $dateCheck);

        if(isset($DateSearch[0])){ $DateSearch1 = $DateSearch[0]; }
        if(isset($DateSearch[1])){ $DateSearch2 = $DateSearch[1]; }
        if(isset($DateSearch[2])){ $DateSearch3 = $DateSearch[2]; }

        if(isset($DateSearch1) && isset($DateSearch2) && isset($DateSearch3))
        {
            $date = $DateSearch1.'-'.$DateSearch2.'-'.$DateSearch3;
            $date = str_replace(array('\'', '-', '.', ','), '/', $date); 
            $date = explode('/', $date); 
            if(count($date) == 1 // No tokens 
                and    is_numeric($date[0]) 
                and    $date[0] < 20991231 and 
                (    checkdate(substr($date[0], 4, 2) 
                    , substr($date[0], 6, 2) 
                    , substr($date[0], 0, 4))) 
            ) 
            { 
                return true; 
            }  
            if(    count($date) == 3 
                and    is_numeric($date[0]) 
                and    is_numeric($date[1]) 
                and is_numeric($date[2]) and 
                (    checkdate($date[0], $date[1], $date[2]) //mmddyyyy 
                or    checkdate($date[1], $date[0], $date[2]) //ddmmyyyy 
                or    checkdate($date[1], $date[2], $date[0])) //yyyymmdd 
            ) 
            { 
                return true; 
            } 
            return false; 
        }
        else
        {
            return false; 
        }
    } 
    public static function DateSearch($date)
    {    
        $check = ClassFunction::is_date($date);
        if($check == true){
            $DateSearch = explode('/', $date);
            $dateCheck = $DateSearch[2].'-'.$DateSearch[1].'-'.$DateSearch[0];
            return $dateCheck;
        }else{
            return '0000-00-00';
        } 
    }
    // Date Update
    public static function UpdateDate($date)
    {
        if(isset($date))
        {
            $check = explode('-', $date);
            return $check[2].'/'.$check[1].'/'.$check[0];
        }
    }

    public static function _CheckRadio($ans,$num)
    {
        if($ans == $num)
        {
            $check = true;
        }
        else
        {
            $check = false;
        }

        return $check;
    }

    public static function _CheckNewTab($data){
        $arr = json_decode($data->cms_link);
        $type = $arr[1] == '1' ? 'เปิด' : 'ปิด';
        return $type;
    }

    public static function _getLink($data){
        $arr = json_decode($data->cms_link);
        return $arr[0];
    }
}
?>