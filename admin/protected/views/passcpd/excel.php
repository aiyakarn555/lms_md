 <?php
 $strExcelFileName = "Export-Data-" . date('Ymd-His') . ".xls";
      header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
      header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
      header('Content-Type: text/plain; charset=UTF-8');
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Pragma:no-cache");
?>
            <table class="table table-bordered " >
                <!-- Table heading -->
                <thead>
                    <tr style="background-color: #b2d0e8;">
                        <th  style="vertical-align: middle;" class="center"><b>ลำดับที่</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>รหัสบัตรประชาชน</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>รหัสผู้ทำบัญชี</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>เลขทะเบียนผู้สอบบัญชีรับอนุญาต</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>คำนำหน้า</b></th>
                        <th  style="vertical-align: middle; width:7%;" class="center"><b>ชื่อ</b></th>
                        <th  style="vertical-align: middle; width:7%;" class="center"><b>นามสกุล</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>ประเภทสมาชิก</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่สมัครเป็นสมาชิก</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่เข้าอบรม</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่จบการอบรม</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่ผ่านการสอบ 60%</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>เวลาที่ผ่านการสอบ</b></th>
                        <th  style="vertical-align: middle; width:10%;" class="center"><b>ที่อยู่</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>เบอร์โทร</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>อีเมลล์</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>ชื่อวิชา</b></th>

                    </tr>
<!--                    <tr  style="background-color: #b2d0e8;">
                        <th class="center" style="width:5%;"><b>ครั้งที่1 คิดเป็นร้อยละ</b></th>
                        <th class="center" style="width:5%;"><b>ครั้งที่2 คิดเป็นร้อยละ</b></th>
                    </tr>-->
                </thead>
                <!-- // Table heading END -->

                <!-- Table body -->
                <tbody>
                <!-- Table row -->

                <?php

                $data_table = '';

            if($dataProvider_ex->getData()){
                foreach($dataProvider_ex->getData() as $index => $data){
                    $date_start_learn = Helpers::learn_date_from_course($data['course_id'], $data['user_id']);
                    if(empty($data['passcours_date']) || $data['passcours_date'] < $date_start_learn){
                        $data['passcours_date'] = Helpers::learn_end_date_from_course($data['course_id'], $data['user_id']);
                        if($data['passcours_date'] > $data['pass_60_date'] ){
                            $data['passcours_date'] = $data['pass_60_date'];
                        }
                    }
                    $start_cnt++;

                    $CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($data['special_category'] === 'y') {
			$CertificateType = 'cpd';
		}

                //---------------------------------------------
                $data_audit = (!empty($data['auditor_id']))? intval($data['auditor_id']):'-';
                if($data['type_user']==1){
                    $data_bookeeper_id = '-';
                    $color = '<font color="black">';
                }elseif($data['type_user']==3){
                    $data_bookeeper_id = '-';
                    $color = '<font color="blue">';
                }else{
                    $data_bookeeper_id = $data['username'];
                    if($data['type_user']==2){
                    $color = '<font color="red">';
                    }

                    if($data['type_user']==4){
                    $color = '<font color="green">';
                    }
                }

                if($data['title_id']){
                    $title = Helpers::title_name($data['title_id']);
                } else {
                    $title = 'คุณ';
                }
                $pv = ($data['province'])?' จ.'.Helpers::province_name($data['province']):"";
                
                $data_table .= "<tr>
                    <td>".$start_cnt."</td>
                    <td style='mso-number-format:\@;'>".$data['username']."</td>
                    <td style='mso-number-format:\@;'>".$data_bookeeper_id."</td>
                    <td style='mso-number-format:\@;'>".$data_audit."</td>
                    <td><center>".$title."</center></td>
                    <td>".$data['firstname']."</td>
                    <td>".$data['lastname']."</td>
                    <td>".$color.Helpers::lib()->changeTypeUser($data['id'])."</font></td>
                    <td>".Helpers::lib()->changeFormatDate($data['create_at'])."</td>
                    <td>".Helpers::lib()->changeFormatDate($date_start_learn)."</center></td>
                    <td>".Helpers::lib()->changeFormatDate($data['passcours_date'])."</center></td>
                    <td>".Helpers::lib()->changeFormatDate($data['pass_60_date'])."</center></td>
                    <td><center>".date("H:i",strtotime($data['pass_60_date'])).' น.'."</center></td>
                    <td>".$data['address'].$pv."</td>
                    <td style='mso-number-format:\@;'><center>".$data['phone']."</center></td>
                    <td style='max-width: 100px;overflow: overlay;white-space: nowrap;'>".$data['email']."</td>
                    <td style='max-width: 200px;overflow: overlay;white-space: nowrap;'>".Helpers::lib()->changeNameCourse($data['course_title'])."</td>
                </tr>
                ";

                 }
            }else{
                $data_table .= "<tr>
                    <td colspan=18><b>กรุณาเลือกหลักสูตร</b></td>
                        </tr>";
            }
                 echo $data_table;
                ?>
                </tbody>
                <!-- // Table body END -->

            </table>