<script>

    function fillfield(val){
        $('#RegistrationForm_bookkeeper_id').val(val);
    }

<?php 
if($activeRegis=='1') { 
    if($genechk) { 
        if($model->username == '') { 
?>
    $(window).load(function(){
        $('#modal-condition').modal({backdrop: 'static', keyboard: false});
        $('#modal-condition').modal('show');
    });
<?php } } } ?>
    $(function(){
        $('.mem').hide();
        $('.bussiness').hide();
        $('#Profile_type_user').val('');
        $('#RegistrationForm_bookkeeper_id').val($('#RegistrationForm_username').val());
    });

    $(function() {
        enable_cb();
        $("#yes").click(enable_cb);
    });

    function enable_cb() {
        if (this.checked) {
            $("#enter").removeAttr("disabled");
        } else {
            $("#enter").attr("disabled", true);
        }
    }

function typemem(val){
    if(val == 1) {
        swal({
            title: "ท่านเลือกประเภทสมาชิกว่า <strong style='color: orange;'>'สมาชิกทั่วไป'</strong>",
            text: "<font style='font-size: 20px;'>ท่านจะนับชั่วโมง CPD <br />และแจ้งพัฒนาความรู้ต่อเนื่องทางวิชาชีพ<strong style='color: red;'>ไม่ได้</strong></font>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "แก้ไข",
            closeOnConfirm: true,
            html: true
        }, function(confirm) {
            if(confirm) {
                $('.mem').hide();
                // $('#bookkeeper').show();
                $('#RegistrationForm_card_id').val('');
                $('#RegistrationForm_auditor_id').val('');
                $('#RegistrationForm_bookkeeper_id').val('');
                $('#RegistrationForm_bookkeeper_id').val($('#RegistrationForm_username').val());
                $('#RegistrationForm_card_id').attr('required', false);
                $('#RegistrationForm_auditor_id').attr('required', false);
            } else {
                $('#Profile_type_user').val('');
            }
        });
    } else if(val == 2){
        $('.mem').hide();
        $('#bookkeeper').show();
        $('#pic_cardid').show();
        $('#RegistrationForm_card_id').val('');
        $('#RegistrationForm_auditor_id').val('');
        $('#RegistrationForm_bookkeeper_id').val('');
        $('#RegistrationForm_bookkeeper_id').val($('#RegistrationForm_username').val());
        $('#RegistrationForm_auditor_id').attr('required', false);
        $('#RegistrationForm_card_id').attr('required', true);
    } else if(val == 3){
        $('.mem').hide();
        $('#auditor').show();
        $('#pic_cardid').show();
        $('#RegistrationForm_card_id').val('');
        $('#RegistrationForm_auditor_id').val('');
        $('#RegistrationForm_bookkeeper_id').val('');
        $('#RegistrationForm_card_id').attr('required', true);
        $('#RegistrationForm_auditor_id').attr('required', true);
    } else if(val == 4){
        $('.mem').hide();
        $('#auditor').show();
        $('#bookkeeper').show();
        $('#pic_cardid').show();
        $('#RegistrationForm_card_id').val('');
        $('#RegistrationForm_auditor_id').val('');
        $('#RegistrationForm_bookkeeper_id').val('');
        $('#RegistrationForm_bookkeeper_id').val($('#RegistrationForm_username').val());
        $('#RegistrationForm_card_id').attr('required', true);
        $('#RegistrationForm_auditor_id').attr('required', true);
    } else {
        $('.mem').hide();
        $('#RegistrationForm_card_id').val('');
        $('#RegistrationForm_auditor_id').val('');
    }
}

function typeOccupation(val){
    if(val == 'ธุรกิจส่วนตัว/เจ้าของกิจการ') {
        $('.bussiness').show();
        $('#Profile_bussiness_model_id').attr('required', true);
        $('#Profile_bussiness_type_id').attr('required', true);
        $('#Profile_company').attr('required', true);
        $('#Profile_juristic').attr('required', true);
    } else {
        $('.bussiness').hide();
        $('#Profile_bussiness_model_id').attr('required', false);
        $('#Profile_bussiness_type_id').attr('required', false);
        $('#Profile_company').attr('required', false);
        $('#Profile_juristic').attr('required', false);
        $('#Profile_bussiness_model_id').val('');
        $('#Profile_bussiness_type_id').val('');
        $('#Profile_company').val('');
        $('#Profile_juristic').val('');
    }
}


function isThaichar(str,obj){
    var orgi_text="ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
    var str_length=str.length;
    var str_length_end=str_length-1;
    var isThai=true;
    var Char_At="";
    for(i=0;i<str_length;i++){
        Char_At=str.charAt(i);
        if(orgi_text.indexOf(Char_At)==-1){
            isThai=false;
        }   
    }
    if(str_length>=1){
        if(isThai==false){
            obj.value=str.substr(0,str_length_end);
        }
    }
    return isThai; // ถ้าเป็น true แสดงว่าเป็นภาษาไทยทั้งหมด
}

</script>

<!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->

<style type="text/css">
.wizard-header{margin-bottom: 2em;}
.form-control{height: 40px;}
label{font-weight: bold;}
.card{padding: 1em;background-color: rgba(255, 255, 255, 0.5);}
.wizard-card .picture{width: 200px;height: 200px;border-radius: 0;}
.wizard-card.ct-wizard-orange .picture:hover {
    border-color: #26A69A;
}
.subscribe input.form-control{
        height: 34px;
}
</style>
<div class="modal fade" id="modal-condition">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
        <h4 class="modal-title center text-white">เงื่อนไขในการสมัครสมาชิกเพื่อใช้บริการทางอินเทอร์เน็ต</h4>
      </div>
      <div class="modal-body">
        <p class="text-indent">ผู้ขอสมัครสมาชิกซึงต่อไปนี้จะเรียกว่า 'ผู้สมัคร' และ กรมพัฒนาธุรกิจการค้า กระทรวงพาณิชย์ ซึ่งต่อไปนี้จะ เรียกว่า 'กรมพัฒนาธุรกิจการค้า' กรุณาอ่านข้อความตกลงด้านล่างนี้โดยละเอียดเพื่อรักษาสิทธิประโยชน์ในการเป็นสมาชิกของท่านเงื่อนไข</p>
        <ol>
          <li>การสมัครเรียน e-Learning ของกรมพัฒนาธุรกิจการค้า ไม่ต้องเสียค่าใช้จ่ายใดๆ ทั้งสิ้น</li>
          <li>ผู้สมัคร จะต้องกรอกข้อมูลรายละเอียดต่างๆ ตามจริงให้ครบถ้วน ทั้งนี้เพื่อประโยชน์แก่ตัวผู้สมัคร หากตรวจพบว่าข้อมูลของ ผู้สมัครไม่เป็นความจริง กรมพัฒนาธุรกิจการค้าจะระงับการใช้งานของผู้สมัครโดยไม่ต้องแจ้งให้ทราบล่วงหน้า</li>
          <li>เมื่อผู้สมัครทำการสมัครสมาชิกแล้ว กรมพัฒนาธุรกิจการค้าจะทำการส่ง รหัสยืนยันสมาชิก (Activate Code) ไปยัง e-mail ที่ผู้สมัครได้ระบุไว้ เพื่อทำการยืนยันความเป็นสมาชิก (Activate) ภายใน 30 วัน ผู้สมัครจึงจะสามารถใช้ Username และ Password เพื่อเข้าใช้ระบบ (Log in) มิฉะนั้นบัญชีของผู้สมัครจะถูกยกเลิกโดยมิต้องแจ้งให้ ทราบล่วงหน้า</li>
          <li>ผู้ใดแอบอ้าง หรือกระทำการใดๆ อันเป็นการละเมิดสิทธิส่วนบุคคล โดยใช้ข้อมูลของผู้อื่นมาแอบอ้างสมัครเรียน เพื่อให้ได้สิทธิ มาซึ่งการเรียน ถือเป็นความผิด ต้องรับโทษตามที่กฎหมายกำหนดไว้</li>
          <li>ข้อมูลส่วนบุคคลของผู้สมัครที่ได้ลงทะเบียน หรือผ่านการใช้งานของเว็บไซต์ของ กรมพัฒนาธุรกิจการค้าทั้งหมดนั้น ผู้สมัคร ยอมรับและตกลงว่าเป็นสิทธิของ กรมพัฒนาธุรกิจการค้า ซึ่งผู้สมัครต้องอนุญาตให้ กรมพัฒนาธุรกิจการค้า ใช้ข้อมูลของผู้สมัครเรียน ในงานที่เกี่ยวข้องกับ กรมพัฒนาธุรกิจการค้า</li>
          <li>กรมพัฒนาธุรกิจการค้า ขอรับรองว่าจะเก็บข้อมูลของผู้สมัครไว้เป็นความลับอย่างดีที่สุด โดยจะมินำไปเปิดเผยที่ใด และ/หรือ เพื่อประโยชน์ทางการค้า หรือประโยชน์ทางด้านอื่น ๆ โดยไม่ได้รับอนุญาต นอกจากจะได้รับหมายศาลหรือหนังสือทางราชการ ซึ่งขึ้นอยู่กับดุลพินิจของ กรมพัฒนาธุรกิจการค้า</li>
          <li>ผู้สมัครควรปฏิบัติตามข้อกำหนด และเงื่อนไขการให้บริการของเว็บไซต์ กรมพัฒนาธุรกิจการค้าโดยเคร่งครัดเพื่อความปลอดภัย ในข้อมูลส่วนบุคคลของผู้สมัคร ในกรณีที่ข้อมูลส่วนบุคคลดังกล่าวถูกโจรกรรมโดยวิธีการทางอิเล็กทรอนิกส์ หรือสูญหาย เสียหายอันเนื่องจากสาเหตุสุดวิสัยหรือไม่ว่ากรณีใด ๆ ทั้งสิ้น กรมพัฒนาธุรกิจการค้าขอสงวนสิทธิในการปฏิเสธความรับผิดจาก เหตุดังกล่าวทั้งหมด</li>
          <li>ผู้สมัครจะต้องรักษารหัสผ่าน หรือชื่อเข้าใช้งานในระบบ e-Learning เป็นความลับ และหากมีผู้อื่นสามารถเข้าใช้จากทางชื่อของผู้สมัครได้ ทางกรมพัฒนาธุรกิจการค้าจะไม่รับผิดชอบใดๆ ทั้งสิ้น</li>
          <li>ผู้สมัครยินยอมให้กรมพัฒนาธุรกิจการค้าตรวจสอบข้อมูลส่วนตัว และ/หรือข้อมูลอื่นใดที่ผู้สมัครระบุในการสมัครเรียน หาก กรมพัฒนาธุรกิจการค้าตรวจสอบว่าข้อมูลที่ท่านให้ไม่ชัดเจน และ/หรือเป็นเท็จทางกรมพัฒนาธุรกิจการค้า มีสิทธิในการยกเลิก การเรียนผ่านระบบ e-Learning ของผู้สมัครได้</li>
          <li>เมื่อสมัครเรียนเสร็จเรียบร้อยแล้ว ผู้สมัครจะได้รับข่าวสารประชาสัมพันธ์การเรียน e-Learning ของกรมพัฒนาธุรกิจการค้า จากทาง e-mail ที่กรมพัฒนาธุรกิจการค้าเห็นสมควร ทั้งนี้ทางกรมพัฒนาธุรกิจการค้าได้ทำการตรวจจับ Virus ก่อนการส่ง e-mail ข่าวสารไปยังท่านทุกครั้ง ดังนั้นถ้าเครื่องคอมพิวเตอร์ของท่านเกิดผิดปกติอันเนื่องมากจากติด Virus หรือ Spam mail ทางกรมพัฒนาธุรกิจการค้าไม่รับผิดชอบใดๆ ทั้งสิ้น</li>
        </ol>
        <p class="text-indent">ข้าพเจ้าผู้สมัคร ได้อ่านเงื่อนไขการสมัครเรียนแล้วและยินยอมให้ กรมพัฒนาธุรกิจการค้าตรวจสอบข้อมูลส่วนตัว และ/หรือข้อมูลอื่น ใดที่ผู้สมัครระบุในการสมัครเรียน ถ้าผู้สมัครตกลงยินยอมผูกพันและปฏิบัติตามข้อตกลงและเงื่อนไขต่างๆ ตามที่ระบุไว้ในข้อตกลง ดังกล่าว รวมทั้งข้อตกลงและเงื่อนไขอื่นๆ ที่ทางกรมพัฒนาธุรกิจการค้าเห็นสมควร แต่ถ้าไม่ตกลงกรุณากด 'ไม่ยอมรับ' เพื่อกลับไป หน้าหลัก</p>
      </div>
      <div class="modal-footer center">
        <div class="checkbox">
            <label class="text-white">
              <input type="checkbox" id="yes"> ยอมรับเงื่อนไข
            </label>
        </div>
    <a href="<?= $this->createUrl('/site/index') ?>" class="btn btn-sm btn-danger" style="color: black;">ยกเลิก</a>
    <button type="button" class="btn btn-sm btn-success" disabled data-dismiss="modal" id="enter">ตกลง</button>
      </div>

    </div>
  </div>
</div>
<?php 
date_default_timezone_set("Asia/Bangkok");
?>
<!-- Start Page Banner -->
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2 class="text-white">สมัครเรียน</h2>
            <p class="grey lighten-1"></p>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="<?php echo $this->createUrl('/site/index'); ?>">หน้าแรก</a></li>
              <li>สมัครเรียน</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->
    <div style="background: url('themes/template2/images/bg/bg3.png');background-size: cover;">
<div class="container">
    <div id="content">
        <div class="row">
            <div class="col-md-12">
                    <?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
                    $this->breadcrumbs = array(
                    UserModule::t("Registration"),
                    );
                    ?>
                    <?php if (Yii::app()->user->hasFlash('registration')): ?>
                    <div class="success">
                        <div class="card wizard-card ct-wizard-orange" id="wizard">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo Yii::app()->user->getFlash('registration'); 
                                    if(Yii::app()->user->hasFlash('error')) {
                                        echo Yii::app()->user->getFlash('error'); 
                                    } else if (Yii::app()->user->hasFlash('contact')) {
                                        echo Yii::app()->user->getFlash('contact'); 
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php unset(Yii::app()->session['rule']); else: ?>
                    <div class="form">
                        <?php $form = $this->beginWidget('UActiveForm', array(
                        'id' => 'registration-form',
                        'enableAjaxValidation' => true,
                        // 'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                        'clientOptions' => array(
                        'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array('enctype' => 'multipart/form-data'),
                        )); ?>
                        <?php echo $form->errorSummary(array($model, $profile)); ?>
                        <div class="card wizard-card ct-wizard-orange" id="wizard">
                        <?php if($genechk && ($activeRegis=='1')) {?>
                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                            <div class="wizard-header">

                                <!-- Start Big Heading -->
                                <div class="big-title text-center" data-animation="fadeInDown" data-animation-delay="01">
                                  <h1><strong><?php echo UserModule::t("Registration"); ?></strong></h1>
                                </div>
                                <!-- End Big Heading -->

                                <!-- Some Text -->
                                <p class="text-center"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
                            </div>
                            <div class="row pd-1em">
                                <div class="col-md-5">
                                    <div class="picture-container">
                                        <h4>รูปภาพโปรไฟล์</h4>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;padding: 0.5em">
                                              <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/avatar.png" alt="..." style="opacity: 0.5;">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                            <div>
                                              <span class="btn btn-success btn-small btn-file"><span class="fileinput-new">เลือกรูปภาพ</span><span class="fileinput-exists">เปลี่ยน</span><?php echo $form->fileField($model, 'pic_user', array('id' => 'wizard-picture')); ?></span>
                                              <a href="#" class="btn btn-danger btn-small fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                            </div>
                                        </div>
                                        <h6>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'username'); ?> เป็นเลขที่บัตรประชาชน (ใช้ในการเข้าสู่ระบบ)</label>
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'ชื่อผู้ใช้','oninput' => 'fillfield(this.value)')); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'password'); ?></label>
                                                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ควรเป็น (A-z0-9) และมากกว่า 4 ตัวอักษร)')); ?>
                                                <?php echo $form->error($model, 'password'); ?>
                                                <!-- <p class="hint">
                                                    <?php //echo UserModule::t("Minimal password length 4 symbols."); ?>
                                                </p> -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'verifyPassword'); ?></label>
                                                <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน')); ?>
                                                <?php echo $form->error($model, 'verifyPassword'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'title_id'); ?></label>
                                        <?php echo $form->dropDownList($profile, 'title_id', ProfilesTitle::getTitleList(), array('empty' => '---เลือกคำนำหน้าชื่อ---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                        <?php echo $form->error($profile, 'title_id'); ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'firstname'); ?></label>
                                                <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => 'ชื่อจริง','onkeyup'=>'isThaichar(this.value,this)')); ?>
                                                <?php echo $form->error($profile, 'firstname'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'lastname'); ?></label>
                                                <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => 'นามสกุล','onkeyup'=>'isThaichar(this.value,this)')); ?>
                                                <?php echo $form->error($profile, 'lastname'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'type_user'); ?></label>
                                        <?php echo $form->dropDownList($profile, 'type_user', TypeUser::getTypeList(), array('empty' => '---เลือกประเภท---', 'class' => 'form-control', 'style' => 'width:100%','onchange'=>'typemem(this.value)')); ?>
                                        <?php echo $form->error($profile, 'type_user'); ?>
                                    </div>
                                    <div class="form-group mem" id="auditor">
                                        <label>เลขทะเบียนผู้สอบบัญชี <?php echo UserModule::t('star'); ?></label>
                                        <?php echo $form->textField($model, 'auditor_id', array('class' => 'form-control', 'placeholder' => 'เลขทะเบียนผู้สอบบัญชี')); ?>
                                        <?php echo $form->error($model, 'auditor_id'); ?>
                                    </div>
                                    <div class="form-group mem" id="bookkeeper">
                                        <label>รหัสผู้ทำบัญชี <?php echo UserModule::t('star'); ?></label>
                                        <?php echo $form->textField($model, 'bookkeeper_id', array('class' => 'form-control', 'placeholder' => 'รหัสผู้ทำบัญชี','readonly' => 'readonly')); ?>
                                        <?php echo $form->error($model, 'bookkeeper_id'); ?>
                                    </div>
                                    <div class="form-group mem" id="pic_cardid">
                                        <label>แนลไฟล์รูปภาพบัตรประชาชน <?php echo UserModule::t('star'); ?></label>
                                        <?php echo $form->fileField($model, 'card_id',array('class'=>'form-control')); ?>
                                        <?php echo $form->error($model, 'card_id'); ?>
                                        <label style="color: red"><strong>รองรับไฟล์นามสกุล jpg, png, gif เท่านั้น</strong></label>
                                    </div>
                                            <div class="form-group">
                                                <label for="input"><?php echo $form->labelEx($profile, 'birthday'); ?></label>
                                                <div>
                                                    <!-- <input type="date" name="" id="input" class="form-control" value="" required="required" title=""> -->
                                                    <?php //echo $form->textField($profile, 'birthday',array('data-format'=>'YYYY-MM-DD','data-template'=>'YYYY MMMM D','class' => 'form-control','id'=>'datepicker')); ?>
                                                    <?php 
                                                    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                        'name'=>'Profile[birthday]',
                                                        'options'=>array(
                                                            'showAnim'=>'fold',
                                                            'changeMonth'=>'true', 
                                                            'changeYear'=>'true', 
                                                            'yearRange'=>'1947:2012', 
                                                            'dateFormat'=>'yy-mm-dd',
                                                            'dayNamesMin' => array('อา','จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'),
                                                            'monthNamesShort' => array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'),
                                                            'beforeShow' => 'js:function(){  
                                                                if($(this).val() != ""){
                                                                    var arrayDate = $(this).val().split("-");     
                                                                    arrayDate[0] = parseInt(arrayDate[0]) - 543;
                                                                    $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
                                                                }
                                                                setTimeout(function(){
                                                                    $.each($(".ui-datepicker-year option"), function(j, k){
                                                                        var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
                                                                        $(".ui-datepicker-year option").eq(j).text(textYear);
                                                                    });             
                                                                },50);
                                                            }',
                                                            'onClose' => 'js:function(){
                                                                if($(this).val() != "" && $(this).val() == dateBefore){         
                                                                    var arrayDate = dateBefore.split("-");
                                                                    arrayDate[0] = parseInt(arrayDate[0]) + 543;
                                                                    $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);    
                                                                }       
                                                            }',
                                                            'onSelect' => 'js:function(dateText, inst){ 
                                                                dateBefore = $(this).val();
                                                                var arrayDate = dateText.split("-");
                                                                arrayDate[0] = parseInt(arrayDate[0]) + 543;
                                                                $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
                                                                    var dtToday = new Date();
                                                                    var Bday = document.getElementById("Profile_birthday").value;
                                                                    var year1 = dtToday.getFullYear();
                                                                    var newDate = new Date(Bday);
                                                                    var year2 = newDate.getFullYear()-543;
                                                                    var theBday = document.getElementById("Profile_age");
                                                                    var y = year1 - year2;
                                                                    theBday.value = y;
                                                            }',   
                                                            'onChangeMonthYear' => 'js:function(){ 
                                                                setTimeout(function(){
                                                                    $.each($(".ui-datepicker-year option"), function(j, k){
                                                                        var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
                                                                        $(".ui-datepicker-year option").eq(j).text(textYear);
                                                                    });             
                                                                },50);
                                                            }', 
                                                        ),
                                                        'htmlOptions'=>array(
                                                            'class'=>'form-control',
                                                            // 'onchange'=>'onAge()'
                                                        ),
                                                    )); 
                                                    ?>
                                                </div>
                                                <?php echo $form->error($profile, 'birthday'); ?>
                                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'sex'); ?></label>
                                                <?php
                                                $sex = array('1' => 'ชาย',
                                                '2' => 'หญิง',);
                                                echo $form->dropDownList($profile, 'sex', $sex, array('empty' => '---เลือกเพศ---', 'class' => 'form-control', 'style' => 'width:100%'));
                                                ?>
                                                <?php echo $form->error($profile, 'sex'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'age'); ?></label>
                                                <?php echo $form->textField($profile, 'age', array('class' => 'form-control', 'placeholder' => 'อายุ', 'readonly'=>'readonly')); ?>
                                                <?php echo $form->error($profile, 'age'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'education'); ?></label>
                                        <?php
                                        $education = array('ปวช' => 'ปวช',
                                        'ปวส' => 'ปวส',
                                        'ปริญญาตรี' => 'ปริญญาตรี',
                                        'ปริญญาโท' => 'ปริญญาโท',
                                        'ปริญญาเอก' => 'ปริญญาเอก',
                                        'อื่น ๆ' => 'อื่น ๆ',);
                                        echo $form->dropDownList($profile, 'education', $education, array('empty' => '---เลือกวุฒิการศึกษา---', 'class' => 'form-control', 'style' => 'width:100%'));
                                        ?>
                                        <?php echo $form->error($profile, 'education'); ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'occupation'); ?></label>
                                                <?php
                                                $typeoccu = array('ธุรกิจส่วนตัว/เจ้าของกิจการ' => 'ธุรกิจส่วนตัว/เจ้าของกิจการ',
                                                'นักเรียน/นักศึกษา' => 'นักเรียน/นักศึกษา',
                                                'รับราชการ' => 'รับราชการ',
                                                'พนักงานรัฐวิสาหกิจ' => 'พนักงานรัฐวิสาหกิจ',
                                                'พนักงานเอกชน' => 'พนักงานเอกชน',
                                                'อื่น ๆ' => 'อื่น ๆ');
                                                echo $form->dropDownList($profile, 'occupation', $typeoccu, array('empty' => '---เลือกอาชีพ---', 'class' => 'form-control', 'style' => 'width:100%','onchange'=>'typeOccupation(this.value)')); ?>
                                                <?php echo $form->error($profile, 'occupation'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo 'ตำแหน่งของท่าน *'; ?></label>
                                                <?php echo $form->textField($profile, 'position', array('class' => 'form-control', 'placeholder' => 'ชื่อตำแหน่ง')); ?>
                                                <?php echo $form->error($profile, 'position'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($profile, 'bussiness_model_id'); ?> <span class="required">*</span></label>
                                                <?php
                                                echo $form->dropDownList($profile, 'bussiness_model_id', BusinessModel::getTypeList(), array('empty' => '---รูปแบบธุรกิจ---', 'class' => 'form-control', 'style' => 'width:100%'));?>
                                                <?php echo $form->error($profile, 'bussiness_model_id'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($profile, 'bussiness_type_id'); ?> <span class="required">*</span></label>
                                                <?php
                                                echo $form->dropDownList($profile, 'bussiness_type_id', BusinessType::getTypeList(), array('empty' => '---ประเภทของธุรกิจ---', 'class' => 'form-control', 'style' => 'width:100%')); 
                                                ?>
                                                <?php echo $form->error($profile, 'bussiness_type_id'); ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($profile, 'company'); ?> <span class="required">*</span></label>
                                                <?php echo $form->textField($profile, 'company', array('class' => 'form-control', 'placeholder' => 'ชื่อหน่วยงาน/บริษัท ')); ?>
                                                <?php echo $form->error($profile, 'company'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($profile, 'juristic'); ?> <span class="required">*</span></label>
                                                <?php echo $form->textField($profile, 'juristic', array('class' => 'form-control', 'placeholder' => 'เลขทะเบียนนิติบุคคล')); ?>
                                                <?php echo $form->error($profile, 'juristic'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>ท่านมีเว็บไซต์หรือไม่</label>
                                        <div class="web">
                                            <?php echo CHtml::radioButton('webcheck',false,array('value'=>0,'class' => 'webcheck','id'=>'webcheck0')); ?>
                                            <label>ไม่มี</label>
                                            <?php echo CHtml::radioButton('webcheck',false,array('value'=>1,'class' => 'webcheck','id'=>'webcheck1')); ?>
                                            <label>มี</label>
                                            <?php echo $form->textField($profile, 'website', array('class' => 'form-control web', 'placeholder' => 'ชื่อเว็บไซต์ (ถ้ามี)','id'=>'web')); ?>
                                        </div>
                                        <?php echo $form->error($profile, 'website'); ?>
                                    </div>
                                    <script type="text/javascript">
                                    $(function(){
                                        $('input:radio[id="webcheck0"]').prop('checked', true);
                                    });
                                    $('.webcheck').click(function(){
                                    var isChecked = jQuery("input[name=webcheck]:checked").val();
                                        if(isChecked == 0){
                                            $(".web").blur();
                                            $('#web').val('');
                                            $('#web').attr('required', false);
                                        }else {
                                            $(".web").focus();
                                            $('#web').attr('required', true);
                                        }
                                    });
                                    
                                    $('#web').click(function(){
                                        $('input:radio[id="webcheck1"]').prop('checked', true);
                                        $('#web').attr('required', true);
                                    });
                                    </script>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'address'); ?></label>
                                        <?php echo $form->textArea($profile, 'address', array('class' => 'form-control')); ?>
                                        <?php echo $form->error($profile, 'address'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'province'); ?></label>
                                        <?php
                                        echo $form->dropDownList($profile, 'province', Province::getProvinceList(), array('empty' => '---เลือกจังหวัด---', 'class' => 'form-control', 'style' => 'width:100%'));
                                        ?>
                                        <?php echo $form->error($profile, 'province'); ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'tel'); ?> (02)</label>
                                                <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์')); ?>
                                                <?php echo $form->error($profile, 'tel'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'phone'); ?></label>
                                                <?php echo $form->textField($profile, 'phone', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์เคลื่อนที่')); ?>
                                                <?php echo $form->error($profile, 'phone'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'fax'); ?></label>
                                                <?php echo $form->textField($profile, 'fax', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรสาร')); ?>
                                                <?php echo $form->error($profile, 'fax'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'email'); ?></label>
                                                <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'ป้อนอีเมล')); ?>
                                                <?php echo $form->error($model, 'email'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>ท่านทราบข่าวนี้จากช่องทางใด <?php echo UserModule::t('star'); ?></label>
                                        <div class="channel">
                                            <?php
                                            $contactfrom = array('เว็บไซต์กรมพัฒนาธุรกิจการค้า' => 'เว็บไซต์กรมพัฒนาธุรกิจการค้า',
                                            'เว็บไซต์อื่นๆ' => 'เว็บไซต์อื่นๆ',
                                            'รับราชการ' => 'รับราชการ',
                                            'แผ่นพับ' => 'แผ่นพับ',
                                            'เพื่อน' => 'เพื่อน',
                                            'อื่น ๆ' => 'อื่น ๆ');
                                            echo $form->checkBoxList($profile, 'contactfrom', $contactfrom); ?>
                                            <?php echo $form->error($profile, 'contactfrom'); ?>
                                        </div>
                                    </div>
                                   <!--  <div class="form-group">
                                        <label>อัพโหลดเอกสาร PDF</label>
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">เลือกไฟล์</span><span class="fileinput-exists">เปลี่ยน</span><?php echo $form->fileField($profile, 'file_user',array('class'=>'wizard-picture')); ?></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                        </div> -->
                                        <!-- 
                                        <?php echo $form->error($profile, 'file_user'); ?> -->
                                    <!-- </div> -->
                                    <?php if (UserModule::doCaptcha('registration')): ?>
                                    <div class="form-group">
                                    <label style="color: red"><strong>กรุณาคลิ๊กที่ช่องด้านล่าง เพื่อยืนยันการสมัครสมาชิก</strong></label>
                                    <div class="g-recaptcha" data-sitekey="6LcnyBQUAAAAAMshaSXcQfe-Ry7ujd02VHl1KsM-"></div>
                                    <?php 
                                        // $this->widget('application.extensions.recaptcha.EReCaptcha',
                                        //    array('model'=>$model, 'attribute'=>'validation',
                                        //          'theme'=>'red', 'language'=>'en_US',
                                        //          'publicKey'=>Yii::app()->params['recaptcha']['publicKey']));
                                        // echo $form->error($model, 'validation');
                                    ?>
                                        <?php //echo $form->labelEx($model, 'verifyCode'); ?>
                                        <?php //$this->widget('CCaptcha'); ?>
                                        <?php //echo $form->textField($model, 'verifyCode', array('class' => 'form-control')); ?>
                                        <?php //echo $form->error($model, 'verifyCode'); ?>
                                       <!--  <p class="hint"
                                            style="margin-top:5px;"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
                                            <br/><?php echo UserModule::t("Letters are not case-sensitive."); ?>
                                        </p> -->
                                    </div>
                                    <?php endif; ?>
                                    <!-- <div class="form-group">
                                        <label>หน่วยงาน</label> -->
                                        <?php
                                        // $orgchart = OrgChart::model()->findAll(array(
                                        //     'condition' => 'level=2',
                                        // ));
                                        // $orgchart = CHtml::listData($orgchart, 'id', 'title');
                                        // if ($model->department_id != '') {
                                        //     $orgchart_select = OrgChart::model()->find(array(
                                        //         'condition' => 'id=' . $model->department_id,
                                        //     ));
                                        //     $model->orgchart_lv2 = $orgchart_select->parent_id;
                                        // }
                                        // echo $form->dropDownList($model, 'orgchart_lv2', $orgchart, array(
                                        //     'empty' => '---หน่วยงาน---',
                                        //     'class' => 'form-control',
                                        //     'ajax' =>
                                        //         array('type' => 'POST',
                                        //             'url' => CController::createUrl('/user/registration/sub_category'), //url to call.
                                        //             'update' => '#' . CHtml::activeId($model, 'department_id'), // here for a specific item, there should be different update
                                        //             'data' => array('orgchart_lv2' => 'js:this.value'),
                                        //         ))); ?>
                                        <?php // echo $form->error($model, 'orgchart_lv2'); ?>
                                    <!-- </div>
                                    <div class="form-group">
                                        <label>แผนก</label> -->
                                        <?php
                                        // if ($model->department_id != '') {
                                        //     $data = $this->loadDepartment($model->department_id);
                                        // } else {
                                        //     $data = array();
                                        // }
                                        // echo $form->dropDownList($model, 'department_id', $data, array('empty' => '---แผนก---', 'class' => 'form-control')); ?>
                                        <?php //echo $form->error($model, 'department_id'); ?>
                                    <!-- </div>
                                    <div class="form-group">
                                        <label>หน่วยงาน</label> -->
                                        <?php
                                        //                                             echo $form->dropDownList($model, 'company_id', Company::getCompanyList(), array(
                                        //                                                 'empty' => '---เลือกหน่วยงาน---',
                                        //                                                 'class' => 'form-control',
                                        //                                                 'style' => 'width:100%',
                                        //                                                 'ajax' =>
                                        //                                                     array('type' => 'POST',
                                        //                                                         'dataType' => 'json',
                                        //                                                         'url' => CController::createUrl('/user/registration/division'), //url to call.
                                        // //                                                    'update' => '#' . CHtml::activeId($model, 'division_id'), // here for a specific item, there should be different update
                                        //                                                         'success' => 'function(data){
                                        //                                                         $("#division_id").empty();
                                        //                                                         $("#division_id").append(data.data_dsivision);
                                        //                                                         $("#position_id").empty();
                                        //                                                         $("#position_id").append(data.data_position);
                                        //                                                     }',
                                        //                                                         'data' => array('company_id' => 'js:this.value'),
                                        //                                                     ))); ?>
                                        <?php //echo $form->error($model, 'company_id'); ?>
                                    <!-- </div>
                                    <div class="form-group">
                                        <label>ศูนย์/แผนก</label> -->
                                        <?php
                                        //                                        var_dump($model->division_id);
                                        //echo $form->dropDownList($model, 'division_id', Division::getDivisionList(), array('empty' => '---เลือก ศุนย์/แผนก---', 'class' => 'form-control', 'style' => 'width:100%', 'id' => 'division_id')); ?>
                                        <?php //echo $form->error($model, 'division_id'); ?>
                                    <!-- </div>
                                    <div class="form-group">
                                        <label>ตำแหน่ง</label> -->
                                        <?php
                                        //echo $form->dropDownList($model, 'position_id', Position::getPositionList(), array('empty' => '---เลือกตำแหน่ง---', 'class' => 'form-control', 'style' => 'width:100%','id'=>'position_id')); ?>
                                        <?php //echo $form->error($model, 'position_id'); ?>
                                        <!-- </div> -->
                                        <?php
                                        // $profileFields = $profile->getFields();
                                        // if ($profileFields) {
                                        //     foreach ($profileFields as $field) {
                                        ?>
                                        <?php // echo $form->labelEx($profile, $field->varname); ?>
                                        <?php
                                        // if ($widgetEdit = $field->widgetEdit($profile)) {
                                        //     echo $widgetEdit;
                                        // } elseif ($field->range) {
                                        //     echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                                        // } elseif ($field->field_type == "TEXT") {
                                        //     echo $form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50, 'class' => 'form-control'));
                                        // } else {
                                        //     echo $form->textField($profile, $field->varname, array('size' => 60, 'class' => 'form-control', 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                                        // }
                                        ?>
                                        <?php // echo $form->error($profile, $field->varname); ?>
                                        <!-- </div> -->
                                        <?php
                                        //     }
                                        // }
                                        ?>
                                        <div class="form-group" style="text-align: right;">
                                            <?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'btn btn-primary fz-20',)); ?>
                                        </div>
                                    </div>
                                </div>

                                <?php } else if(!$genechk && ($activeRegis=='0')){ ?>
                                    <?= $msg ?>และปิดระบบลงทะเบียน
                                <?php } else if($activeRegis == '0'){ ?>
                                    ปิดระบบสมัคร
                                <?php } else if(!$genechk){ ?>
                                    <?= $msg ?>
                                <?php } ?>
                            </div>
                            <?php $this->endWidget(); ?>
                                        
                            </div><!-- form -->

                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>