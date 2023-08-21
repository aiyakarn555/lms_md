<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
if (Yii::app()->session['lang'] == 2) {
    $validationprofile = "กรุณาเพิ่ม ภาพโปรไฟล์";
    $selecttitle = "กรุณาเลือกคำนำหน้า";
    $selectpv = "กรุณาเลือกจังหวัด";
    $selectdt = "กรุณาเลือกอำเภอ";
    $selectsdt = "กรุณาเลือกตำบล";
   
} else {
    $validationprofile = "Plase add your profile picture";
    $selecttitle = "Select Name Titles";
    $selectpv = "Select Province";
    $selectdt = "Select Districts";
    $selectsdt = "Select Sub-district";
}

?>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.css">
<style type="text/css">
    .error2 {
        color: red;
    }
    .rm-cursor{
        cursor: default
    }
</style>
<section class="content-page">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active"><a style="color: #757272"><?= $langId == 1 ? "Registeration Form" : "สมัครสมาชิก" ?></a></li>
            </ol>
        </nav>


        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'registration-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1', 'onsubmit' => 'return checkForm();'),
        ));
        ?>

        <div class="content-main mt-2 register-form">
            <div class="row justify-content-center ">
                <div class="col-lg-12">
                    <div class="card p-2 card-register">
                        <h2 class="text-center mt-1 mb-1"><?= $langId == 1 ? "Registeration Form" : "สมัครสมาชิก" ?></h2>
                        <div class="p-2">
                            <h3 class="text-register"><?= $langId == 1 ? "Profile Information" : "ข้อมูลส่วนตัว" ?></h3>
                            <div class="row mb-1">

                                <div class="col-lg-8 col-sm-12 col-xs-12">
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="typeregis" id="exampleRadios1" value="1" checked>
                                      <label class="form-check-label" for="exampleRadios1">
                                        <?= $langId == 1 ? "ID card number" : "เลขบัตรประจำตัวประชาชน" ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="typeregis" id="exampleRadios2" value="2">
                                  <label class="form-check-label" for="exampleRadios2">
                                      <?= $langId == 1 ? "Passport No." : "เลขพาสปอร์ต" ?>
                                </label>
                            </div>
                            <div class="cardhide">
                                <label for="exampleInputEmail1 "><?= $langId == 1 ? "ID card number" : "เลขบัตรประจำตัวประชาชน" ?></label>
                                <sup class="up-title ">*</sup>
                                <div class="form-group ">
                                    <div class="form-icon">
                                        <i class="far fa-id-card"></i>

                                        <?php echo $form->textField($profile, 'identification', array('class' => 'form-control required','id' => 'idcard', 'name' => 'idcard', 'maxlength' => '13', 'value' =>$profile->identification, 'onKeyPress' => 'return check_number();')); ?>
                                        <?php echo $form->error($profile, 'identification', array('class' => 'error2')); ?>
                                    </div>
                                </div>
                            </div>
                                    <div class="passhide" style="display: none">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Passport No." : "เลขพาสปอร์ต" ?></label>
                                    <sup class="up-title">*</sup>
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="far fa-id-card"></i>
                                            <?php echo $form->textField($profile, 'identification', array('class' => 'form-control ','id' => 'passport', 'name' => 'passport', 'value' =>$profile->identification,'onKeyPress'=>'checkLetterWithoutSpecial();')); ?>
                                            <?php echo $form->error($profile, 'identification', array('class' => 'error2')); ?>
                                        </div>
                                    </div>
                                    </div>

                                </div>


                            </div>
                            <?php
                            $criteria= new CDbCriteria;
                            // $criteria->condition='type=:type';
                            // $criteria->params=array(':type'=>'main');
                            $protitle = ProfilesTitle::model()->findAll($criteria);
                            $pro_title_en = array();
                            $pro_title_th = array();

                            $pro_title_en[""] = $selecttitle;
                            $pro_title_th[""] = $selecttitle;

                            foreach ($protitle as $key => $value) {
                                if($value->prof_title_en != null){
                                    $pro_title_en[$value->prof_id] = $value->prof_title_en;
                                }
                            
                                if($value->prof_title != null){
                                    $pro_title_th[$value->prof_id] = $value->prof_title;
                                }
                            }
                            $pro_title_th['other'] = 'อื่นๆ';
                            $pro_title_en['other'] = 'Other';

                            $provices = Province::model()->findAll(array(
                                'order' => 'pv_name_th',
                            ));
                            $provice_data = array();
                            $provice_data[""] = $selectpv;
                            foreach ($provices as $key => $value) {
                                $provice_data[$value->pv_id] = $value->pv_name_th;
                            }

                            $District = District::model()->findAll();
                            $District_data = array();
                            $District_data[""] = $selectdt;

                            foreach ($District as $key => $value) {
                                $District_data[$value->dt_id] = $value->dt_name_th;
                            }


                            $Subdistrict = Subdistrict::model()->findAll();
                            $Subdistrict_data = array();
                            $Subdistrict_data[""] = $selectsdt;

                            foreach ($Subdistrict as $key => $value) {
                                $Subdistrict_data[$value->sdt_id] = $value->sdt_name_th;
                            }

                            ?>

                            <div class="row mb-1">
                                <div id="prenameEN" class="col-lg-4 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Title(EN)" : "คำนำหน้า(อังกฤษ) " ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php
                                    $htmlOptions = array('class' => 'form-control','onchange'=>"checkPrefixEN()");
                                    echo $form->dropDownList($profile, 'prefix_en', $pro_title_en, $htmlOptions);

                                    echo $form->error($profile, 'prefix_en', array('class' => 'error2'));
                                    ?>
                                </div>
                                <div style="display:none" id="prenameOtherEN" class="col-lg-2 col-sm-6">
                                    <label for="exampleInputPreNameEN"><?= $langId == 1 ? "Specify(EN)" : "ระบุ(อังกฤษ) " ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php echo $form->textField($profile, 'prename_other_en', array('class' => 'form-control', 'aria-describedby' => '')); ?>
                                    <?php echo $form->error($profile, 'prename_other_en', array('class' => 'error2')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "FirstName(EN)" : "ชื่อ(อังกฤษ) " ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php echo $form->textField($profile, 'firstname_en', array('class' => 'form-control', 'aria-describedby' => '','onKeyPress'=>'checkLetterEN();')); ?>
                                    <?php echo $form->error($profile, 'firstname_en', array('class' => 'error2')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "LastName(EN)" : "นามสกุล(อังกฤษ)" ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php echo $form->textField($profile, 'lastname_en', array('class' => 'form-control', 'aria-describedby' => '','onKeyPress'=>'checkLetterEN();')); ?>
                                    <?php echo $form->error($profile, 'lastname_en', array('class' => 'error2')); ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div id="prenameTH" class="col-lg-4 col-sm-12 col-xs-12 mb-2">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Title(TH)" : "คำนำหน้า(ไทย) " ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php
                                    $htmlOptions = array('class' => 'form-control','onchange'=>'checkPrefixTH()');
                                    echo $form->dropDownList($profile, 'prefix_th', $pro_title_th, $htmlOptions);
                                    echo $form->error($profile, 'prefix_th', array('class' => 'error2'));
                                    ?> 
                                </div>
                                <div id="prenameOtherTH" style="display:none" class="col-lg-2 col-sm-6 col-xs-12 mb-1">
                                    <label for="exampleInputPreNameTH"><?= $langId == 1 ? "Specify(TH)" : "ระบุ(TH) " ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php echo $form->textField($profile, 'prename_other_th', array('class' => 'form-control', 'aria-describedby' => '')); ?>
                                    <?php echo $form->error($profile, 'prename_other_th', array('class' => 'error2')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12  mb-1">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "FirstName(TH)" : "ชื่อ(ไทย) " ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'aria-describedby' => '','onKeyPress'=>'checkLetterTH();')); ?>
                                    <?php echo $form->error($profile, 'firstname', array('class' => 'error2')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12  mb-1">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "LastName(TH)" : "นามสกุล(ไทย)" ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'aria-describedby' => '','onKeyPress'=>'checkLetterTH();')); ?>
                                    <?php echo $form->error($profile, 'lastname', array('class' => 'error2')); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "E-mail Address" : "อีเมล" ?></label>
                                    <!-- <sup class="up-title">*</sup> -->
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="fas fa-envelope"></i>
                                            <?php echo $form->textField($users, 'email', array('class' => 'form-control ', 'onCopy' => "return false", 'onDrag' => "return false", 'onDrop' => "return false", 'onPaste' => "return false", 'id' => "first_email")); ?>
                                            <?php //echo $form->error($users, 'email', array('class' => 'error2')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Telephone" : "เบอร์โทรศัพท์" ?></label>
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="fas fa-phone"></i>
                                            <?php echo $form->textField($profile, 'phone', array('class' => 'form-control', 'aria-describedby' => '', 'maxlength' => '10','onKeyPress' => 'return check_number();')); ?>
                                            <?php echo $form->error($profile, 'phone', array('class' => 'error2')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12 mb-1">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Date of Brith (A.D.)" : "วันเกิด วัน-เดือน-ปี (ค.ศ.)" ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php echo $form->textField($profile, 'birthday', array('class' => 'form-control default_datetimepicker', 'autocomplete' => 'off', 'value' => $profile->birthday)); ?>
                                    <?php echo $form->error($profile, 'birthday', array('class' => 'error2')); ?>

                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-4 col-sm-12 col-xs-12 mb-1">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Address" : "ที่อยู่" ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php echo $form->textField($profile, 'address', array('class' => 'form-control', 'aria-describedby' => '')); ?>
                                    <?php echo $form->error($profile, 'address', array('class' => 'error2')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12 mb-1">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Province" : "จังหวัด" ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php
                                    $htmlOptions_pro = array('class' => 'form-control', 'id' => 'pv_id');
                                    echo $form->dropDownList($profile, 'province', $provice_data, $htmlOptions_pro);
                                    ?>
                                    <?php echo $form->error($profile, 'province', array('class' => 'error2')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12 mb-1">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Districts" : "อำเภอ" ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php
                                    $htmlOptions_dis = array('class' => 'form-control', 'id' => 'district');
                                    echo $form->dropDownList($profile, 'district', $District_data, $htmlOptions_dis);
                                    ?>
                                    <?php echo $form->error($profile, 'district', array('class' => 'error2')); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-xs-12 mb-1">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Sub-district" : "ตำบล" ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php
                                    $htmlOptions_sub = array('class' => 'form-control', 'id' => 'subdistrict');
                                    echo $form->dropDownList($profile, 'subdistrict', $Subdistrict_data, $htmlOptions_sub);
                                    ?>
                                    <?php echo $form->error($profile, 'subdistrict', array('class' => 'error2')); ?>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-xs-12 mb-1">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "ZIP code" : "รหัสไปรษณีย์" ?></label>
                                    <sup class="up-title">*</sup>
                                    <?php
                                    $htmlOptions_zip = array('class' => 'form-control', 'id' => 'zipcode');
                                    echo $form->textField($profile, 'zipcode', $htmlOptions_zip);
                                    ?>
                                    <?php echo $form->error($profile, 'zipcode', array('class' => 'error2')); ?>
                                </div>
                            </div>
                        </div>

                        <?php if($users->isNewRecord){ ?>

                       
                        <div class="p-2">
                            <h3 class="text-register"><?= $langId == 1 ? "User Account" : "บัญชีผู้ใช้งาน" ?></h3>
                            <div class="row  mb-1">
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Username" : "ชื่อบัญชีผู้ใช้งาน" ?></label>
                                    <sup class="up-title">*</sup>
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="far fa-id-card"></i>
                                            <?php echo $form->textField($users, 'username', array('readonly'=> 'readonly' , 'class' => 'form-control')); ?>
                                            <?php echo $form->error($users, 'username', array('class' => 'error2')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Password" : "รหัสผ่าน" ?></label>
                                    <sup class="up-title">*</sup>
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="fas fa-key"></i>
                                            <?php echo $form->passwordField($users, 'password', array('class' => 'form-control')); ?>
                                            <?php echo $form->error($users, 'password', array('class' => 'error2')); ?>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1"><?= $langId == 1 ? "Password (Confirm)" : "ยืนยันรหัสผ่าน" ?></label>
                                    <sup class="up-title">*</sup>
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="fas fa-key"></i>
                                            <?php echo $form->passwordField($users, 'verifyPassword', array('class' => 'form-control')); ?>
                                            <?php echo $form->error($users, 'verifyPassword', array('class' => 'error2')); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                         <?php } ?>

                        <div class="p-2 " id="scripted">
                            <h3 class="text-register"><?= $langId == 1 ? "Profile Picture" : "รูปภาพโปรไฟล์" ?></h3>
                            <div class="row">
                                <div class="">
                                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/users/' . Yii::app()->user->id .'/'.$profile->profile_picture) && $profile->profile_picture != null) { ?>
                                            <label class="cabinet center-block">
                                                <figure>
                                                    <img src="<?= Yii::app()->homeUrl. 'uploads/users/' . Yii::app()->user->id .'/'.$profile->profile_picture ?>"  class="img-responsive img-thumbnail rm-cursor"/>
                                                </figure>
                                            </label>
                                        <?php }else{?>
                                            <label class="cabinet center-block">
                                                <figure>
                                                    <img src="https://user.gadjian.com/static/images/personnel_boy.png" class="img-responsive img-thumbnail" id="item-img-output" />
                                                    <figcaption><i class="fa fa-camera"></i></figcaption>
                                                </figure>
                                                <input type="file" id="UploadImages" class="item-img file center-block" accept="image/*" name="file_photo" />
                                                <input type="hidden" name="url_pro_pic" id="url_pro_pic">
                                            </label>
                                            <small class="text-danger ml-2"><i class="fas fa-info-circle"></i> <?= $langId == 1 ? "attach your picture with a suit" : "หมายเหตุ ให้แนบรูปที่สวมสูท" ?></small>
                                        <?php } ?>
                                </div>
                            </div>

                        </div>
                        <div class="row  justify-content-center mt-1 ">
                            <div class="col-lg-3 col-sm-12 col-xs-12">
                                <?php if($users->isNewRecord){ ?>
                                    <button type="submit" class="btn  btn-lg btn-block btn-register-now"><?= $langId == 1 ? "Confirm" : "ยืนยันการสมัคร" ?></button>
                                <?php }else{ ?>
                                    <button type="submit" class="btn  btn-lg btn-block btn-register-now"><?= $langId == 1 ? "Edit Profile" : "แก้ไขข้อมูล" ?></button>
                                  <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>

    </div>
    </div>
</section>

<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $langId == 1 ? "Crop" : "ครอบภาพ" ?> <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5>
            </div>
            <div class="modal-body text-center">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cropImageBtn" class="btn btn-primary"><?= $langId == 1 ? "Confirm Crop" : "ยืนยันครอบภาพ" ?> </button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $( document ).ready(function() {
        // checkPrefixEN();
        // checkPrefixTH();
    });

    function checkPrefixEN(){
            if($("#Profile_prefix_en").val() == "other"){
                $("#prenameEN").removeClass("col-lg-4 col-sm-12").addClass("col-lg-2 col-sm-6");
                $("#prenameOtherEN").show();
            }else{
                $("#prenameEN").removeClass("col-lg-2 col-sm-6").addClass("col-lg-4 col-sm-12");
                $("#prenameOtherEN").hide();
            }
        };

    function checkPrefixTH(){
        if($("#Profile_prefix_th").val() == "other"){
            $("#prenameTH").removeClass("col-lg-4 col-sm-12").addClass("col-lg-2 col-sm-6");
            $("#prenameOtherTH").show();
        }else{
            $("#prenameTH").removeClass("col-lg-2 col-sm-6").addClass("col-lg-4 col-sm-12");
            $("#prenameOtherTH").hide();
        }
    }
    

     <?php  if($profile->typeregis != null){ ?>
    var tyre = "<?=$profile->typeregis?>";
    if(tyre == 1){
        $('.cardhide').show();
        $('.passhide').hide();
        $("#passport").val(null);
        $("#idcard").prop('required',true);
        $("#passport").prop('required',false);
        $("#exampleRadios1").prop("checked", true);

    }else{

        $("#exampleRadios2").prop("checked", true);
        $('.passhide').show();
        $('.cardhide').hide();
        $("#idcard").val(null);
        $("#passport").prop('required',true);
        $("#idcard").prop('required',false);

    }

   <?php } ?>


  <?php  if($typeregis != null){ ?>
    var ty = "<?=$typeregis?>";
    if(ty == 1){
        $('.cardhide').show();
        $('.passhide').hide();
        $("#passport").val(null);
        $("#idcard").prop('required',true);
        $("#passport").prop('required',false);
        $("#exampleRadios1").prop("checked", true);

    }else{

        $("#exampleRadios2").prop("checked", true);
        $('.passhide').show();
        $('.cardhide').hide();
        $("#idcard").val(null);
        $("#passport").prop('required',true);
        $("#idcard").prop('required',false);

    }

   <?php } ?>





$('input[type=radio][name=typeregis]').change(function() {

    if(this.value == 1){
        $('.cardhide').show();
        $('.passhide').hide();
        $("#idcard").prop('required',true);
        $("#passport").prop('required',false);

    }else{
        $('.passhide').show();
        $('.cardhide').hide();
        $("#passport").prop('required',true);
        $("#idcard").prop('required',false);

    }
    // if (this.value == 'allot') {
    //     alert("Allot Thai Gayo Bhai");
    // }
    // else if (this.value == 'transfer') {
    //     alert("Transfer Thai Gayo");
    // }
});

      function checkForm() {
        <?php if($users->isNewRecord){ ?>
         if (document.getElementById("UploadImages").files.length == 0) {
            swal("<?= $validationprofile?>","","error");
            
            document.getElementById('scripted').focus();
            return false;
        }
    <?php } ?>
    

}

    function checkLetterWithoutSpecial(){
        e = event;
        var matched = (/^[a-z0-9]+$/i).test (String.fromCharCode(e.keyCode || e.which))
        if(matched){
            event.returnValue = true;
        }else{
            alert("ไม่สามารถใช้ตัวอักษรพิเศษได้ หรือท่านยังไม่เปลี่ยภาษา... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...");
            event.returnValue = false;
        }
    }

    function checkLetterEN(){
        e = event;
        var matched = (/^[a-z]+$/i).test (String.fromCharCode(e.keyCode || e.which))
        if(matched){
            event.returnValue = true;
        }else{
            alert("ไม่สามารถใช้ตัวอักษรพิเศษ และตัวเลขได้... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...");
            event.returnValue = false;
        }
    }

    function checkLetterTH(){
        e = event;
        let regex = new RegExp(/^[\u0E00-\u0E7F']+$/i);
        var matched = (regex).test (String.fromCharCode(e.keyCode || e.which))
        if(matched){
            event.returnValue = true;
        }else{
            alert("ไม่สามารถใช้ตัวอักษรพิเศษ และตัวเลขได้... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...");
            event.returnValue = false;
        }
    }



    function check_number() {
        e_k = event.keyCode
        if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
            event.returnValue = false;
            alert("ต้องเป็นตัวเลขเท่านั้น... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...");
        }
    }

    $("#pv_id").change(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/registration/loaddistrict"); ?>',
            data: ({
                pv_id: $(this).val()
            }),
            success: function(data) {
                $("#district").html(data);
            }
        });
    });
    $("#district").change(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/registration/loadsubdistrict"); ?>',
            data: ({
                dt_id: $(this).val()
            }),
            success: function(data) {
                $("#subdistrict").html(data);
            }
        });
    });


    $("#subdistrict").change(function() {
        $("#zipcode").val("");
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/registration/loadzipcode"); ?>',
            data: ({
                sdt_id: $(this).val(),
                TYPE: "zipcode"
            }),
            success: function(data) {
                $("#zipcode").val(data);
                // $('#zipcode').attr('readonly', true);
            }
        });
    });


    <?php if($users->isNewRecord){ ?>
    $("#idcard").change(function() {
        var id = $(this).val();
        if(id.length == 13){

          Swal.fire({
                title: 'Please Wait !',
                html: 'กำลังอัพโหลดข้อมูล',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

           $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/registration/loadidcard"); ?>',
            data: ({
                id_card: id
            }),

            success: function(data) {
                Swal.close();
                var obj = JSON.parse(data);
                $("#User_username").val(id);
                $("#Profile_firstname").val(obj[0].FirstNameTh);
                $("#Profile_lastname").val(obj[0].LastNameTh);
                $("#Profile_firstname_en").val(obj[0].FirstNameEn);
                $("#Profile_lastname_en").val(obj[0].LastNameEn);
                $("#Profile_birthday").val(obj[0].DateOfBirth);
                $("#Profile_phone").val(obj[0].TelNumber);
                $("#first_email").val(obj[0].Email);
                $("#passport").val(obj[0].Passport);
            }
        });


        }else{
            swal("กรุณากรอกเลขบัตรให้ครับ 13 หลัก");
        }

    });

    // $("#Profile_prefix_en").change(function(){
   

    $("#passport").change(function() {
        var id = $(this).val();

        

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/registration/loadPassport"); ?>',
            data: ({
                passport: id
            }),

            success: function(data) {
                
                var obj = JSON.parse(data);
                
                if(obj[0].idCard != null){
                    $("#User_username").val(obj[0].idCard);
                }else{
                    $("#User_username").val(id);
                }
                $("#Profile_firstname").val(obj[0].FirstNameTh);
                $("#Profile_lastname").val(obj[0].LastNameTh);
                $("#Profile_firstname_en").val(obj[0].FirstNameEn);
                $("#Profile_lastname_en").val(obj[0].LastNameEn);
                $("#Profile_birthday").val(obj[0].DateOfBirth);
                $("#Profile_phone").val(obj[0].TelNumber);
                $("#first_email").val(obj[0].Email);
                $("#idcard").val(obj[0].idCard);
                
            }
        });
    });
<?php } ?>


    



    jQuery.datetimepicker.setLocale('th');
    $.datetimepicker.setLocale('th');
    $('.default_datetimepicker').datetimepicker({
        timepicker: false,
        closeOnDateSelect: true,
        format: 'd-m-Y',
        // yearOffset: 543,
        scrollMonth: false,
        scrollInput: false
    });

    // <?php //if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/users/' . Yii::app()->user->id .'/'.$profile->profile_picture) && $profile->profile_picture != null) { ?>
    // $(".gambar").attr("src", "<?php //Yii::app()->baseUrl . '/uploads/users/' . Yii::app()->user->id .'/'.$profile->profile_picture ?>");
    // <?php //}else{ ?>
    // $(".gambar").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
    // <?php //} ?>


    var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 150,
            height: 200,
        },
        enforceBoundary: false,
        enableExif: true
    });
    $('#cropImagePop').on('shown.bs.modal', function() {
        // alert('Shown pop');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function() {
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function() {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId);
        readFile(this);
    });
    $('#cropImageBtn').on('click', function(ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {
                width: 150,
                height: 200
            }
        }).then(function(resp) {
            $('#item-img-output').attr('src', resp);
            $('#cropImagePop').modal('hide');
            $('#url_pro_pic').val($('#item-img-output').attr('src'));
        });
    });
    // End upload preview image

    <?php if ($profile->birthday != null) { ?>

        var birthOld = "<?= $profile->birthday ?>";
        $('.default_datetimepicker').val(birthOld);

    <?php } ?>
</script>