
<style type="text/css">
  body{
    line-height:10.4 !important;
  }
  div{
     line-height:1;
     margin: 0;
     padding: 0;
  }
    .t-center{
      text-align: center;
    }
    .t-bold{
      font-weight: bold;
    }

    .f-22{
      font-size: 22px;
        line-height:10.4 !important;
    }
   
    .f-20{
      font-size: 20px;
        line-height:10.4 !important;
    }

    .f-14{
      font-size: 14px;
    }
    .w-100{
      width: 100%;
      display:block;
    }
    .mt-1{
      margin-top: 1em;
    }
    
    .border-main{
      /*border: 3px solid #000;*/
      padding: 1.5em;
      height: 100%;
      width: 100%;
    }
    .w-100 span{
      display: inline-block;
    }

    .clearfix::after {
      content: "";
      clear: both;
      display: table;
    }
    tr td{
      padding: 5px 0;
    }
table .t-edu {
/* page-break-after: always;*/
}

.license-block{
  position: relative;
}
  
</style>

<div class="border-main"> 

    
    <?php
 if ($user != null) {
   $head  = Yii::app()->basePath . "/../../admin/images/head.jpg";
  } else {
   $head  = Yii::app()->basePath . "/../../admin/images/head.jpg";                                            
  }
?>
 <img src="<?php echo $head; ?> " style="height:180px; padding-left: 20px;">

    <table style="width: 100%;">
            <tr class="clearfix" >
              <td width="80%" style="padding-top: 4em; padding-left: 10em; vertical-align: top; text-align: center;">
                <p class="t-bold f-20" >
                  JOB APPLICATION FORM 
                  <br>
                  ใบสมัครงาน
                </p>
                </td>
                <td  width="20%" style="padding-top: 30px; ">
                  <?php 
                if ($user['pic_user'] == null) {

                    $img  = Yii::app()->basePath . "/../../themes/template2/images/thumbnail-profile.png";
                } else {
                 
                    $img = Yii::app()->basePath . '/../../uploads/user/' . $user['id'] . '/thumb/' . $user['pic_user'];
                }


                ?>   
                    <img src="<?php echo $img; ?>" width="100" height="130" style="border: 1px solid #999; height: 130px;width: 100px;"> 
                </td>
            </tr>

          </table>
          <table style="width: 100%;page-break-after: always;">

           <tr>
              <td width="100%" style="padding-left:104px; padding-bottom:-19px; text-align:left; ">
                <p class="f-14"><?php if($profiles['firstname_en'] != ""){ echo $profiles['firstname_en'];?>&nbsp;&nbsp;
                <?php echo $profiles['lastname_en']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
              <tr>
                <td width="100%"  style="text-align:left; ">
                  <p class="f-14">Name : .....................................................................................................................................................</p>
                </td>
              </tr>
              <tr>
                <td width="100%" style="padding-left:104px; padding-bottom:-19px; text-align:left; ">
                  <p class="f-14"><?php if($profiles['firstname'] != ""){ echo $profiles['firstname'];?>&nbsp;&nbsp;
                  <?php echo $profiles['lastname']; }else{ echo "-"; } ?></p>
                </td>
              </tr>
              <tr>
                <td width="100%" style="text-align:left; ">
                  <p class="f-14">ชื่อ : ...........................................................................................................................................................</p>
                </td>
              </tr>

           <tr>
              <td  style="  padding-left:60px; padding-bottom:-28px;">
                <p class="f-14">
                  <?php if($profiles['sex'] != ""){if ($profiles['sex'] == 'Male') {
                    echo "ชาย";
                  }else{
                    echo "หญิง";
                  }}else{ echo "-"; } ?>
                </p>
              </td>
            </tr>

            <tr>
              <td style="  padding-left:180px;padding-bottom:-28px;">
                <p class="f-14">
                    <?php if($profiles['age'] != ""){ echo $profiles['age']; }else{ echo "-"; } ?>
                  </p>
              </td>
            </tr>
            <tr>
              <td style="  padding-left:310px;padding-bottom:-28px;">
                <p class="f-14">
                    <?php if($profiles['mouth_birth'] != ""){ echo $profiles['mouth_birth']; }else{ echo "-"; } ?>
                  </p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:480px; padding-bottom:-19px;">
                <p class="f-14">
                  <?php if($profiles['birthday'] != ""){
                   $birthday = Helpers::lib()->changeFormatDateNew($profiles['birthday']);
                   echo $birthday; }else{ echo "-"; } ?>
                  </p>
              </td>
            </tr>

            <tr width="100%">
              <td width="100%">
                <p class="f-14">
                  เพศ : .................... อายุ : .................... เดือน : ....................  วันเดือนปีเกิด : ...........................................
                </p>
              </td>
            </tr>
            <tr>
              <td  style="  padding-left:90px; padding-bottom:-27px;">
                <p class="f-14">
                  <?php if($profiles['place_of_birth'] != ""){ echo $profiles['place_of_birth']; }else{ echo "-"; } ?>
                </p>
              </td>
            </tr>

            <tr>
              <td style="  padding-left:330px;padding-bottom:-27px;">
                <p class="f-14">
                    <?php if($profiles['hight'] != ""){ echo $profiles['hight']; }else{ echo "-"; } ?>
                  </p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:450px; padding-bottom:-24px;">
                <p class="f-14">
                  <?php if($profiles['weight'] != ""){ echo $profiles['weight']; }else{ echo "-"; } ?>
                  </p>
              </td>
            </tr>
             <tr>
              <td style="text-align:left;  padding-left:570px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['blood'] != ""){ echo $profiles['blood']; }else{ echo "-"; } ?></p>
              </td>
            </tr>

            <tr width="100%">
              <td width="100%">
                <p class="f-14">
                  สถานที่เกิด : ................................................ ส่วนสูง : ............. น้ำหนัก : ............ กรุ๊ปเลือด : ....................
                </p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:90px; padding-bottom:-25px;">
                    <p class="f-14"><?php if($profiles['race'] != ""){ echo $profiles['race']; }else{ echo "-"; } ?></p>
              </td>
                  </p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:320px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['nationality'] != ""){ echo $profiles['nationality']; }else{ echo "-"; } ?></p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:550px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['religion'] != ""){ echo $profiles['religion']; }else{ echo "-"; } ?></p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left; ">
                <p class="f-14">
                   เชื้อชาติ : ..................................... สัญชาติ : ..........................................  ศาสนา : ......................................
                 </p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:180px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['identification'] != ""){ echo $profiles['identification']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:490px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['place_issued'] != ""){ echo $profiles['place_issued']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">บัตรประจำตัวประชาชน : ..................................................  สถานที่ออกบัตร : .............................................. </p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:190px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['date_issued'] != ""){
                  $date_issued = Helpers::lib()->changeFormatDateNew($profiles['date_issued']);
                 echo $date_issued; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['date_of_expiry'] != ""){
                 $date_of_expiry = Helpers::lib()->changeFormatDateNew($profiles['date_of_expiry']);
                 echo $date_of_expiry;
                 }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">วันที่ออกบัตร : ............................................................. วันหมดอายุ : ......................................................... </p>
              </td>
            </tr>
                
        <!--     <div style="page-break-after:always;"></div> -->

             <tr>
               <td style="text-align:left;  padding-left:180px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['passport'] != ""){ echo $profiles['passport']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:490px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['passport_place_issued'] != ""){ echo $profiles['passport_place_issued']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">หนังสือเดินทางเลขที่ : ..................................................... สถานที่ออกบัตร :  ...............................................</p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:140px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['passport_date_issued'] != ""){
                 $pass_expire = Helpers::lib()->changeFormatDateNew($profiles['passport_date_issued']);
                 echo $pass_expire; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['pass_expire'] != ""){
                 $pass_expire = Helpers::lib()->changeFormatDateNew($profiles['pass_expire']);
                 echo $pass_expire; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">วันที่ออกบัตร : ............................................................. วันหมดอายุ :  .........................................................</p>
              </td>
            </tr>
              <tr>
              <td style="text-align:left;  padding-left:190px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['seamanbook'] != ""){ echo $profiles['seamanbook']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['seaman_expire'] != ""){ 
                  $seaman_expire = Helpers::lib()->changeFormatDateNew($profiles['seaman_expire']);
                  echo $seaman_expire; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">หนังสือประจำตัวลูกเรือ : ...................................................... วันหมดอายุ : .................................................</p>
              </td>
           <!--  </tr>
              <tr>
              <td style="text-align:left;  padding-left:170px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['ss_card'] != ""){ echo $profiles['ss_card']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:520px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['tax_payer'] != ""){ echo $profiles['tax_payer']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">บัตรประกันสังคมเลขที่ : .................................... เลขที่บัตรประจำตัวผู้เสียภาษีอากร : ..................................</p>
              </td>
            </tr> -->
                <tr>
              <td style="text-align:left;  padding-left:220px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['status_sm'] != ""){ 
                  if ($profiles['status_sm'] == 's') {
                    echo "โสด";
                  }else{
                    echo "สมรส"; 
                  }
                }else{ 
                  echo "-"; 
                } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:520px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['number_of_children'] != ""){ echo $profiles['number_of_children']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">สถานภาพทางการสมรส : ....................................................... จำนวนบุตร : ................................................</p>
              </td>
            </tr>
            <tr>
                <td width="100%" style="padding-left:104px; padding-bottom:-26px; text-align:left; ">
                  <p class="f-14"><?php if($profiles['spouse_firstname'] != ""){ echo $profiles['spouse_firstname'];?>&nbsp;&nbsp;
                  <?php echo $profiles['spouse_lastname']; }else{ echo "-"; } ?></p>
                </td>
              </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-19px;">
                <p class="f-14"><?php if($profiles['occupation_spouse'] != ""){ echo $profiles['occupation_spouse']; }else{ echo "-"; } ?></p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left; ">
                <p class="f-14">
                   ชื่อคู่สมรส : .............................................................................. อาชีพ : .....................................................
                 </p>
              </td>
            </tr>
            <tr>
                <td width="100%" style="padding-left:104px; padding-bottom:-26px; text-align:left; ">
                  <p class="f-14"><?php if($profiles['father_firstname'] != ""){ echo $profiles['father_firstname'];?>&nbsp;&nbsp;
                  <?php echo $profiles['father_lastname']; }else{ echo "-"; } ?></p>
                </td>
              </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-19px;">
                <p class="f-14"><?php if($profiles['occupation_father'] != ""){ echo $profiles['occupation_father']; }else{ echo "-"; } ?></p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left; ">
                <p class="f-14">
                   ชื่อบิดา : ................................................................................... อาชีพ : .....................................................
                 </p>
              </td>
            </tr>
            <tr>
                <td width="100%" style="padding-left:104px; padding-bottom:-24px; text-align:left; ">
                  <p class="f-14"><?php if($profiles['mother_firstname'] != ""){ echo $profiles['mother_firstname'];?>&nbsp;&nbsp;
                  <?php echo $profiles['mother_lastname']; }else{ echo "-"; } ?></p>
                </td>
              </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-19px;">
                <p class="f-14"><?php if($profiles['occupation_mother'] != ""){ echo $profiles['occupation_mother']; }else{ echo "-"; } ?></p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left; ">
                <p class="f-14">
                   ชื่อมารดา : ............................................................................... อาชีพ : .....................................................
                 </p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:58px; padding-bottom:-21px;">
                <p class="f-14"><?php if($profiles['address'] != ""){ echo $profiles['address']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14" style="line-height:10px;">ที่อยู่ : ........................................................................................................................................................</p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:120px; padding-bottom:-21px;">
                <p class="f-14"><?php if($profiles['domicile_address'] != ""){ echo $profiles['domicile_address']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14" style="line-height:10px;">ที่อยู่ตามภูมิลำเนา : ....................................................................................................................................</p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:85px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['accommodation'] != ""){ 
                  if ($profiles['accommodation'] == 'own house') {
                    echo "ของตนเอง";
                  }else if ($profiles['accommodation'] == 'rent house'){
                    echo "บ้านเช่า"; 
                  }else if ($profiles['accommodation'] == 'with parents'){
                    echo "อาศัยอยู่กับบิดามารดา"; 
                  }else if ($profiles['accommodation'] == 'apartment'){
                    echo "อพาร์ทเม้นท์"; 
                  }else if ($profiles['accommodation'] == 'with relative'){
                    echo "อยู่กับญติ/เพื่อน"; 
                  }
                }else{ 
                  echo "-"; 
                } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:440px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['military'] != ""){
                  if ($profiles['military'] == 'enlisted') {
                    echo 'เกณฑ์แล้ว'; 
                  }else if ($profiles['military'] == 'not enlisted') {
                    echo 'ยังไม่ได้เกณฑ์';
                  }else if ($profiles['military'] == 'exempt') {
                    echo 'ได้รับการยกเว้น';
                  }   
               }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">บ้าน : ..................................................... สถานะการรับใช้ชาติ : .................................................................</p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:100px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['tel'] != ""){ echo $profiles['tel']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
              <tr>
              <td style="text-align:left;  padding-left:470px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['phone'] != ""){ echo $profiles['phone']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">มือถือ : ........................................................ เบอร์มือถือติดต่อฉุกเฉิน : ...................................................... </p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:180px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['name_emergency'] != ""){ echo $profiles['name_emergency']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:470px; padding-bottom:-19px;">
                <p class="f-14"><?php if($profiles['relationship_emergency'] != ""){ echo $profiles['relationship_emergency']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">ชื่อผู้ติดต่อฉุกเฉิน : ................................................................ ความสัมพันธ์ : .............................................</p>
              </td>
            </tr>
               <tr>
              <td style="text-align:left;  padding-left:58px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['line_id'] != ""){ echo $profiles['line_id']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:350px; padding-bottom:-19px;">
                <p class="f-14"><?php if($user['email'] != ""){ echo $user['email']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">ID-Line : .................................................... อีเมล : ...................................................................................</p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:190px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['history_of_illness'] != ""){ 
                  if ($profiles['history_of_illness'] == 'y') {
                    echo "เคย";
                  }else{
                    echo "ไม่เคย"; 
                  }
                }else{ 
                  echo "-"; 
                } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:450px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['sickness'] != ""){ echo $profiles['sickness']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">เคยเจ็บป่วยรุนแรงหรือไม่ : ..................................... ป่วยเป็นโรคอะไร : ......................................................</p>
              </td>
            </tr>
            
          </table>
     <table style="width: 100%;">
            <?php
              $department = Department::model()->find(array(
              'condition' => 'id=:department_id',
              'params' => array(':department_id'=>$user['department_id'])));
            $department = $department->attributes;
            ?>
            <?php
              $position = Position::model()->find(array(
              'condition' => 'id=:position_id',
              'params' => array(':position_id'=>$user['position_id'])));
            $position = $position->attributes;
            ?>
            <tr>
              <td style="text-align:left;  padding-left:60px; padding-bottom:-24px; ">
                <p class="f-14"><?php if($department['dep_title'] != ""){ echo $department['dep_title']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:400px; padding-bottom:-19px; ">
                <p class="f-14"><?php if($position['position_title'] != ""){ echo $position['position_title']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">แผนก : ........................................................ ตำแหน่งที่สมัคร : ..................................................................</p>
              </td>
            </tr>
              <tr>
              <td style="text-align:left;  padding-left:140px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['expected_salary'] != ""){ echo $profiles['expected_salary']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['start_working'] != ""){
                 $start_working = Helpers::lib()->changeFormatDateNew($profiles['start_working']);
                 echo $start_working; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">เงินเดือนที่คาดหวัง : ..................................บาท  &nbsp;&nbsp;&nbsp; พร้อมที่จะเริ่มงานเมื่อ : ...................................................</p>
              </td>
            </tr>  
  </table>
<!-- <table border="1" class="t-edu" style="border-collapse:collapse; overflow: wrap; width: 100%;margin-top: 3em;" >
  <thead>
    <tr style="background-color:#D3D3D3;">
      <td colspan="3" style="text-align:left;  font-weight: bold; padding:10px;">
        <p class="f-14">ประวัติการศึกษา</p>
      </td>
    </tr>
    <tr>
      <td width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14 ">ระดับการศึกษา</p>
      </td>
      <td width="45% " style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">สถาบันการศึกษา</p>
      </td>
      <td width="13%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14 ">ปี พ.ศ.</p>
      </td>
    </tr>
  </thead>
  <tbody>
    <?php 
      $user_id = $user['id'];
      $ProfilesEdu = ProfilesEdu::model()->findAll(array(
        'condition' => 'user_id=:user_id AND active=:active',
        'params' => array(':user_id'=>$user_id, ':active'=>'y')));
    
      if(!empty($ProfilesEdu)){ 
      foreach ($ProfilesEdu as $key => $value) {          

        $education_data = $ProfilesEdu[$key]->attributes;
        $edu_id = $education_data['edu_id'];
        $institution = $education_data['institution'];
        $date_graduation = $education_data['date_graduation'];
      
       $Education = Education::model()->findAll(array(
        'condition' => 'edu_id=:edu_id AND active=:active',
        'params' => array(':edu_id'=>$edu_id, ':active'=>'y')));
       $Education = $Education->attributes;
        $edu_name = $Education['edu_name'];
  
        ?>
        <tr>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($edu_id != ""){
            if($edu_id == 1) {
                             echo "มัธยมศึกษาตอนต้น(ม.3)";
            }else if($edu_id == 2){
                             echo "มัธยมศึกษาตอนปลาย(ม.6)"; 
            }else if($edu_id == 3){
                             echo "ประกาศนียบัตรวิชาชีพ(ปวช.)";
            }else if($edu_id == 4){
                             echo "ประกาศนียบัตรวิชาชีพชั้นสูง(ปวส.)";
            }else if($edu_id == 5){
                             echo "ประกาศนียบัตรวิชาชีพเทคนิค (ปวท.)";
            }else if($edu_id == 6){
                             echo "ปริญญาตรี";
            }else if($edu_id == 7){
                             echo "ปริญญาโท";
            }else if($edu_id == 8){
                           echo "ปริญญาเอก";
            }
                   
                     }else{ echo "-"; } ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($institution != ""){ echo $institution; }else{ echo "-"; } ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($date_graduation != ""){ echo 25; echo $date_graduation; }else{ echo "-"; } ?></p>
          </td>
        </tr>  
        <?php
      }
    }else{
      ?>
      <tr>
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>          
      </tr> 
      <?php
    }
    ?>
  </tbody>      
</table>   -->
<table border="1" class="t-edu" style="border-collapse:collapse; overflow: wrap; width: 100%;margin-top: 3em;">
  <thead>
    <tr style="background-color:#D3D3D3;">
      <td colspan="3" style="text-align:left;  font-weight: bold; padding:10px;">
        <p class="f-14">ประวัติการศึกษา</p>
      </td>
    </tr>
    <tr>
      <td width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14 ">ระดับการศึกษา</p>
      </td>
      <td width="45% " style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">สถาบันการศึกษา</p>
      </td>
      <td width="13%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14 ">ปี พ.ศ.</p>
      </td>
    </tr>
  </thead>
  <tbody>
    <?php 

       $Education = Education::model()->findAll(array(
        'condition' => 'active=:active',
        'params' => array(':active'=>'y')));
       
       if (isset($Education)) {

      
       foreach ($Education as $keys => $values) {
         $Education_datas = $Education[$keys]->attributes;
         $edu_id = $Education_datas['edu_id'];
          $edu_name = $Education_datas['edu_name'];
       
      $user_id = $user['id'];
      $ProfilesEdu = ProfilesEdu::model()->findAll(array(
        'condition' => 'user_id=:user_id AND active=:active AND edu_id=:edu_id',
        'params' => array(':user_id'=>$user_id, ':active'=>'y', ':edu_id'=>$edu_id)));

         $institution = array();
        $date_graduation = array();
       foreach ($ProfilesEdu as $key => $value) {          
        
         $education_data = $ProfilesEdu[$key]->attributes;
    
         $edu_ids = $education_data['edu_id'];
         $institution = $education_data['institution'];
         $date_graduation = $education_data['date_graduation'];
     
   }

   //   ?>
        <tr>
          <td style="text-align:left;padding-left: 10px; " valign="top">
            <p class="f-14"><?php echo $edu_name; ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php 
            if ($edu_id == $edu_ids) {
          echo  $institution;
            }else{
           echo "-";   
            }  
            ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php
        if ($edu_id == $edu_ids) {
         echo  $date_graduation;
            }else{
           echo "-";   
            }  
             ?></p>
          </td>
        </tr>  
       <?php 
     }  }else{ ?>
      <tr>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php echo "-"; ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php echo  "-"; ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php echo "-";?></p>
          </td>
        </tr>  
     <?php
      }
     ?>
    
  </tbody>      
</table>  

</table>
<table border="1" style="border-collapse:collapse; overflow: wrap; width: 100%;" class="mt-1">
  <thead >
    <tr style="background-color:#D3D3D3;">
      <td colspan="3" style="text-align:left;  font-weight: bold; padding:10px;">
        <p class="f-14">ประวัติการฝึกอบรม</p>
      </td>
    </tr>
    <tr>
      <td width="10%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">ลำดับ</p>
      </td>
      <td width="60%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">ชื่อการฝึกอบรม</p>
      </td>
      <td width="30%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">วันหมดอายุ</p>
      </td>
    </tr>
  </thead>
  <tbody>
    <?php 
      $user_id = $user['id'];
      $FileTraining = FileTraining::model()->findAll(array(
        'condition' => 'user_id=:user_id AND active=:active',
        'params' => array(':user_id'=>$user_id, ':active'=>'y')));
    $i = 1;
      if(!empty($FileTraining)){ 
      foreach ($FileTraining as $key => $value) {          

        $FileTraining_data = $FileTraining[$key]->attributes;
        $expire_date = $FileTraining_data['expire_date'];
        $expire_date_convert = Helpers::lib()->changeFormatDateNew($expire_date);
        $name_training = $FileTraining_data['name_training'];

        ?>
        <tr>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php echo $i++; ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($name_training != ""){ echo $name_training; }else{ echo "-"; } ?></p>
          </td> 
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($expire_date != ""){ echo $expire_date_convert; }else{ echo "-"; } ?></p>
          </td>        
        </tr>  
        <?php
      }
    }else{
      ?>
      <tr>
        
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>    
        <td style="text-align:center;  font-style:italic;">-</td>      
      </tr> 
      <?php
    }
    ?>
  </tbody>      
</table>

<table border="1" style="border-collapse:collapse; overflow: wrap; width: 100%;" class="mt-1">
  <thead >
    <tr style="background-color:#D3D3D3;">
      <td colspan="4" style="text-align:left;  font-weight: bold; padding:10px;">
        <p class="f-14">ประวัติการทำงาน</p>
      </td>
    </tr>
    <tr>
      <td width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">บริษัท</p>
      </td>
      <td width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">ตำแหน่ง</p>
      </td>
      <td width="13%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">ตั้งแต่</p>
      </td>
      <td width="43%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">สาเหตุที่ออก</p>
      </td>
    </tr>
  </thead>
  <tbody>
    <?php 
      $user_id = $user['id'];
      $ProfilesWorkHistory = ProfilesWorkHistory::model()->findAll(array(
        'condition' => 'user_id=:user_id AND active=:active',
        'params' => array(':user_id'=>$user_id, ':active'=>'y')));
    
      if(!empty($ProfilesWorkHistory)){ 
      foreach ($ProfilesWorkHistory as $key => $value) {          

        $WorkHistory_data = $ProfilesWorkHistory[$key]->attributes;
        $company_name = $WorkHistory_data['company_name'];
        $since_date = $WorkHistory_data['since_date'];
        $position_name = $WorkHistory_data['position_name'];
        $reason_leaving = $WorkHistory_data['reason_leaving'];
  
        ?>
        <tr>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($company_name != ""){ echo $company_name; }else{ echo "-"; } ?></p>
          </td>
         <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($position_name != ""){ echo $position_name; }else{ echo "-"; } ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($since_date != ""){
             $since_date_new = Helpers::lib()->changeFormatDateNew($since_date);
             echo $since_date_new; }else{ echo "-"; } ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($reason_leaving != ""){echo $reason_leaving; }else{ echo "-"; } ?></p>
          </td>
        </tr>  
        <?php
      }
    }else{
      ?>
      <tr>
        
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>          
      </tr> 
      <?php
    }
    ?>
  </tbody>      
</table>

 <table border="1" style="border-collapse:collapse; overflow: wrap; width: 100%;page-break-after: always;" class="mt-1">
                 <thead>
                     <tr style="background-color:#D3D3D3;">
                        <th colspan="2" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
                        <p class="f-14">ภาษา</p></th>
                        <th width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;"><p class="f-14">ดีมาก</p></th> 
                        <th width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;"><p class="f-14">ดี</p></th>
                        <th width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;"><p class="f-14">พอใช้ได้</p></th>
                        <th width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;"><p class="f-14">ใช้ไม่ได้</p></th>
                    </tr>
                </thead>
<?php 
 $ProfilesLanguage = ProfilesLanguage::model()->findAll(array(
        'condition' => 'user_id=:user_id AND active=:active',
        'params' => array(':user_id'=>$user_id, ':active'=>'y')));
    $i = 1;
   foreach ($ProfilesLanguage as $keylg => $vallg) {
   $i++;
   $p = 1;
   $m = 1;
    ?> 
    <tbody>
            <tr>
             <td rowspan="2" style="text-align:center;"><?php echo $vallg['language_name'] ?></td>
             <td style="text-align:center;">เขียน</td>
             <td style="text-align:center;">
                <div class="radio radio-danger ">
                    <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][writes]" id="lang_w-<?php echo $i;echo$p++; ?>" value="4"<?php if ($vallg["writes"] == "4") : ?> checked="checked" <?php endif ?>>
                    <label for="lang_w-<?php echo $i;echo $m++; ?>"></label>
                </div>
            </td>
            <td style="text-align:center;">
                <div class="radio radio-danger ">
                    <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][writes]" id="lang_w-<?php echo $i;echo $p++; ?>" value="3"<?php if ($vallg["writes"] == "3") : ?> checked="checked" <?php endif ?>>
                    <label for="lang_w-<?php echo $i;echo $m++; ?>"></label>
                </div>
            </td>
            <td style="text-align:center;">
                <div class="radio radio-danger ">
                    <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][writes]" id="lang_w-<?php echo $i;echo $p++; ?>" value="2"<?php if ($vallg["writes"] == "2") : ?> checked="checked" <?php endif ?>>
                    <label for="lang_w-<?php echo $i;echo $m++; ?>"></label>
                </div>
            </td>
            <td style="text-align:center;">
                <div class="radio radio-danger ">
                    <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][writes]" id="lang_w-<?php echo $i;echo $p++; ?>" value="1"<?php if ($vallg["writes"] == "1") : ?> checked="checked" <?php endif ?>>
                    <label for="lang_w-<?php echo $i;echo $m++; ?>"></label>
                </div>
            </td>
        </tr>
        <tr>
    
         <td style="text-align:center;">พูด</td>
         <td style="text-align:center;">
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][spoken]" id="lang_s-<?php echo $i;echo $p++; ?>" value="4"<?php if ($vallg["spoken"] == "4") : ?> checked="checked" <?php endif ?>>
                <label for="lang_s-<?php echo $i;echo $m++; ?>"></label>
            </div>
        </td>
        <td style="text-align:center;">
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][spoken]" id="lang_s-<?php echo $i;echo $p++; ?>" value="3"<?php if ($vallg["spoken"] == "3") : ?> checked="checked" <?php endif ?>>
                <label for="lang_s-<?php echo $i;echo $m++; ?>"></label>
            </div>
        </td>
        <td style="text-align:center;">
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][spoken]" id="lang_s-<?php echo $i;echo $p++; ?>" value="2"<?php if ($vallg["spoken"] == "2") : ?> checked="checked" <?php endif ?>>
                <label for="lang_s-<?php echo $i;echo $m++; ?>"></label>
            </div>
        </td>
        <td style="text-align:center;">
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][spoken]" id="lang_s-<?php echo $i;echo $p++; ?>" value="1"<?php if ($vallg["spoken"] == "1") : ?> checked="checked" <?php endif ?>>
                <label for="lang_s-<?php echo $i;echo $m++; ?>"></label>
            </div>
        </td>
    </tr>
</tbody>
<?php
}
?>
</table>
 
<table style="border-collapse:collapse; width: 100%;margin-top: 3em; ">
    <tr> 
      <td style="padding-left:204px;text-align:right;">
        <p class="f-14">ลงชื่อผู้สมัคร : .............................................................</p>
      </td>
    </tr>

    <tr>
      <td style="padding-left:430px;text-align:left; padding-bottom:-18px;" >
        <p class="f-14"><?php if($profiles['firstname'] != ""){ echo $profiles['firstname'];?>&nbsp;&nbsp;
        <?php echo $profiles['lastname']; }else{ echo "-"; } ?></p>
      </td>
    </tr>

      <tr>
        <td style="padding-left:204px;text-align:right;" >
          <p class="f-14">(...................................................................)</p>
        </td>
      </tr>
    <tr>
      <td style="padding-left:430px;text-align:left; padding-bottom:-18px;" >
        <p class="f-14"><?php if($user['create_at'] != ""){
       // $date = strtotime(substr($user['create_at'],0,-9));    
       // $newformat = date('d-m-Y',$date);
       // echo $newformat; 
        $check = Helpers::lib()->changeFormatDate($user['create_at'],'datetime');
        $newformat = substr($check,0,-10);
        echo $newformat;    
           }else{ echo "-"; } ?></p>
      </td>
    </tr>
      <tr>
        <td style="padding-left:204px;text-align:right; ">
          <p class="f-14">วันที่ : ...................................................................</p>
        </td>
      </tr>
    
</table>
<div class="license-block">
  <div style="padding-left:0;padding-top: 50px;">
    <p class="f-14" >รับ : ............................................................</p>
    <p class="f-14" style="padding-left:70px; padding-bottom: -27px;" > <?php 
    if ($LogRegister->confirm_user != null) {
    $criteria= new CDbCriteria;
    $criteria->compare('user_id',$LogRegister->confirm_user);
    $Profile_admin = Profile::model()->findAll($criteria);
    foreach ($Profile_admin as $key => $value) {
       $firstname_admin = $value["firstname"]; 
       $lastname_admin = $value["lastname"];
    }
  }else{
      $firstname_admin = ""; 
       $lastname_admin = "";
  }
     echo $firstname_admin; ?>&nbsp;&nbsp;&nbsp;<?php echo $lastname_admin; ?> </p>
     <p class="f-14">(...................................................................)</p>
     <p class="f-14" style="padding-left:90px; padding-bottom: -27px;" >
      <?php if($LogRegister['confirm_date'] != ""){
        $check = Helpers::lib()->changeFormatDate($LogRegister['confirm_date'],'datetime');
        $newformat = substr($check,0,-10);
        echo $newformat;    
           }else{ echo "-"; } ?></p>
     <p class="f-14">วันที่ : .................................................................</p>
 </div>
  <div  style="padding-left:350px;padding-top: -105px;">
    <p class="f-14">ผู้อนุมัติ : ..........................................................</p>
     <p class="f-14" style="padding-left:70px; padding-bottom: -27px;" > <?php 
     if ($LogApprove->confirm_user != null) {
     
    $criteria= new CDbCriteria;
    $criteria->compare('user_id',$LogApprove->confirm_user);
    $Profile_super = Profile::model()->findAll($criteria);
    foreach ($Profile_super as $key => $value) {
       $firstname_super = $value["firstname"]; 
       $lastname_super = $value["lastname"];
    }
    }else{
      $firstname_super = ""; 
       $lastname_super = "";
    }
     echo $firstname_super; ?>&nbsp;&nbsp;&nbsp;<?php echo $lastname_super; ?> </p>
    
    <p class="f-14">(....................................................................)</p>
    <p class="f-14" style="padding-left:90px; padding-bottom: -27px;" >
      <?php if($LogApprove['confirm_date'] != ""){
        $check = Helpers::lib()->changeFormatDate($LogApprove['confirm_date'],'datetime');
        $newformat = substr($check,0,-10);
        echo $newformat;    
           }else{ echo "-"; } ?></p>
     <p class="f-14">วันที่ : ..............................................................</p>
  </div>
</div>


</div>