<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
if (Yii::app()->session['lang'] == 2) {
    $termsConPath = 'ข้อกำหนด และเงื่อนไข';
    $termsConTitle = 'เงื่อนไขการให้บริการ และ นโยบายคุ้มครองข้อมูลส่วนบุคคล';
    $termsConDetail = 'ข้าพเจ้ายินยอมให้มีการเก็บรวมรวม ใช้ เปิดเผย และ/หรือโอนข้อมูลที่ละเอียดอ่อนของข้าพเจ้าภายในระบบงานขององค์กร เพื่อวัตถุประสงค์ที่กฎหมายกำหนดให้ต้องได้รับความยินยอม ตามที่ระบุไว้ในนโยบายความเป็นส่วนตัวด้านทรัพยากรบุคคล ของบริษัท ศูนย์อบรมมารีนเนอร์ไทย จำกัด';
    $termsConAgree = 'ยินยอม';
    $termsConDisagree = 'ไม่ยินยอม';
    $termsConConfirm = 'ยืนยัน';
    $termsConNote = 'กรณีที่ท่านไม่ให้ความยินยอม ท่านจะไม่สามารถ สมัครสมาชิก เข้าสู่ระบบเพื่อดำเนินการอบรม';
} else {
    $termsConPath = 'Terms and Conditions';
    $termsConTitle = 'Terms of Service and Privacy Policy';
    $termsConDetail = "I consent to the collection, use, disclosure and/or transfer of my sensitive information within the organization's systems. For purposes where consent is required by law As stated in the Human Resources Privacy Policy of the Thai Mariner Training Center Co., Ltd.";
    $termsConAgree = 'Agree';
    $termsConDisagree = 'Disagree';
    $termsConConfirm = 'Confirm';
    $termsConNote = 'In the event that you do not give consent You will not be able to register, log in to run the training.';
}

?>

<div class="container-main">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-main">
    <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
    <li class="breadcrumb-item active"><a style="color: #757272"><?= $termsConPath; ?></a></li>
    </ol>
  </nav>
</div>
<section class="content regis-form" id="about-us" >
  <div class="container-main">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="well">
            <div class="detail">
              <center>
                <h2><?= $termsConTitle; ?></h2>
              </center>
             
                <?= $termsConDetail ;?>
            </div>
            <center>

              <div class="condition">
                <div class="form-group">
                  <?php
                  $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'registration-form',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1', 'onsubmit' => 'return checkForm();'),
                  ));
                  ?>
                  <input type="hidden" name="UserId" value="<?= $users_id ?>">
                  <div class="radio-inline">
                    <input type="radio" class="radio-main" name="status" id="accept" value="1">
                    <label for="accept" class="bg-success text-black">
                      <?= $termsConAgree; ?>
                    </label>
                  </div>
                  <div class=" radio-inline">
                    <input type="radio" class="radio-danger"  name="status" id="reject" value="2">
                    <label for="reject" class="bg-danger text-black"> <?= $termsConDisagree; ?>
                    </label>
                  </div>
                    <div class="mt-1">
                      <button  class="btn btn-default btn-success btn-lg center-block mb-1" value="regis"><?= $termsConConfirm ;?></button>
                      <b style="color:red"><?= $termsConNote; ?></b>
                    </div>
                  <?php $this->endWidget(); ?>
                </div>
              </div>
            </center>
          </div>
      </div>  
    </div>
  </div>

</section>