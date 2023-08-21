<?php
$my_org = '';
if (!Yii::app()->user->isGuest) {
    $my_org = json_decode($users->orgchart_lv2);
}
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}

$news_forms = $users->isNewRecord;
if ($news_forms) {
    $news_forms = 'y';
} else {
    $news_forms = 'n';
}

if(isset($_GET['type']) && $_GET['type'] == 'edit'){
  $disabled = "";
  $edit = 1;
}else{
  $edit = 0;
  $disabled = 'disabled';
}
 if($langId ==1){

             $fullname =  $profile->firstname_en.' - '.$profile->lastname_en;
          }else{

             $fullname =  $profile->firstname.' - '.$profile->lastname;

        } 

?>
<style type="text/css">
  #upload-profileimg {
    width: 250px;
    height: 250px;
    padding-bottom: 25px;
}

figure figcaption {
    color: #fff;
    width: 100%;
    padding-left: 9px;
    padding-bottom: 5px;
    margin-top: 10px;
}

.btn-uploadimg {
    font-size: 14px;
    padding: 10px 20px;
}

.clearfix {
    overflow: auto;
}
</style>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.css">
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.css">
<script src='https://www.google.com/recaptcha/api.js'></script>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uploadifive.css">
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Personal Information</li>
        </ol>
    </nav>
</div>
<section class="content" id="register">
    <div class="container">
        <div class="row g-0 position-relative">

            <div class=" col-md-3 col-lg-3 col-xs-12">
                <ul class="sidebar-account">
                    <li class="active">Personal Information</li>
                    <li class=""><a class="text-decoration-none" href="<?php echo $this->createUrl('/site/dashboard'); ?>">Course Status</a></p>
                </ul>
            </div>

            <div class="col col-md-9 col-lg-9">
                <div class="card card-profile mt-20">
                    <div class="row">
                        <div class="col col-md-10 col-lg-9">
                            <h3 class="title-account">Personal Information</h3>
                            <div class="row form-group">

                                <div class="col-md-6 col-xs-12">
                                    <div class="card card-profile-detail">
                                        <p>Firstname - Lastname <br> 
                                          <span>
                                            <input type="text" class="form-control" name="firstname" <?= $disabled ?> id="firstname" value="<?= $fullname ?>">
                                          </span></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xs-12">
                                    <div class="card card-profile-detail">
                                        <p>Employee ID <br>
                                          <span> 
                                            <input type="text" class="form-control" name="firstname" <?= $disabled ?> id="firstname" value="<?= $profile->user->employee_id ?>">
                                          </span></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="card card-profile-detail">
                                        <p>Section code <br><span><input type="text" class="form-control" <?= $disabled ?> name="firstname" id="firstname" value="<?= $profile->user->employee_id ?>">
                                        </span></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="card card-profile-detail">
                                        <p>Section name <br><span>
                                          <input type="text" class="form-control" name="firstname" <?= $disabled ?> id="firstname" value="<?= $profile->user->employee_id ?>">
                                        </span></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 ">
                                    <div class="card card-profile-detail">
                                        <p>Class level <br><span>
                                          <input type="text" class="form-control" name="firstname" <?= $disabled ?> id="firstname" value="<?= $profile->user->employee_id ?>">
                                        </span></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 ">
                                    <div class="card card-profile-detail">
                                        <p>Position Description <br><span>
                                          <input type="text" class="form-control" name="firstname" <?= $disabled ?> id="firstname" value="<?= $profile->user->employee_id ?>">
                                        </span></p>
                                    </div>
                                </div>
                                 
                            </div>
                            <?php if($edit==1){ ?>
                            <div class="text-center">
                                <a class="btn btn-warning btn-lg"  type="submit" name="sub-pro" >Submit</a>
                              </div>
                            <?php } ?>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <div class="pic-profile">
                                <!-- img class="pf-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/profile-image.png">
                                <div class="card-body text-center" style="padding:10px;">
                                    <button class="col-bt btn btn-main text-4 text-center" onclick="window.location.href='<?= Yii::app()->createUrl('registration/update?type=edit') ?>'" >edit</button>
                                </div> -->
                                 <div class="row form-mb-1 justify-content-center box-uploadimage">
                                      <!-- <div class="col-md-4 item-uploadimamge"> -->
                                          <!-- <div class="img-profile-setting"> -->
                                              <div class="text-center upload-img">
                                                  <label class="cabinet center-block">
                                                      <figure>
                                                          <?php
                                                          if ($profile->user->pic_user == null) {
                                                              $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                                          } else {
                                                              // $registor = new RegistrationForm;
                                                              // $registor->id = $users->id;
                                                              $img = Yii::app()->baseUrl . '/uploads/user/' . $users->id . '/thumb/' . $users->pic_user;
                                                          }
                                                          $url_pro_pic = $img;
                                                          ?>
                                                          <img src="<?php echo $url_pro_pic; ?>" class="gambar img-responsive img-thumbnail" name="item-img-output" id="item-img-output" />
                                                          <?php if($edit==1){ ?>

                                                          <?php }else{ ?>
                                                          <figcaption>
                                                              <div class="btn btn-default btn-uploadimg"><i class="fa fa-camera"></i> <?= Yii::app()->session['lang'] == 1?'Select picture':'เลือกรูป'; ?> </div>
                                                          </figcaption>
                                                      </figure>
                                                      <input type="hidden" name="url_pro_pic" id="url_pro_pic">
                                                      <input type="file" id="Profile_pro_pic" class="item-img file center-block d-none" name="Profile_pro_pic" />
                                                  </label>
                                                  <small class="text-danger"><font color="red">*</font><?= Yii::app()->session['lang'] == 1?'Image should be sized 2X2 inch':'รูปภาพควรมีขนาด 2X2 นิ้ว'; ?> </small>
                                              </div>
                                            <?php } ?>
                                          <!-- </div> -->
                                      <!-- </div> -->
                                  </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content crop-img">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php 
                    if(Yii::app()->session['lang'] == 1){
                        echo "Create image";                        
                    }else{
                        echo "สร้างรูปประจำตัว";
                    }
                    ?>
                 </h4>
            </div>
            <div class="modal-body">
                <div id="upload-profileimg" class="center-block"></div>
                <div class="text-center center-block mt-2">
                    <button class="rotate_btn rotate_left btn" data-deg="90"><i class="fas fa-undo"></i> 
                    <?php 
                    if(Yii::app()->session['lang'] == 1){
                        echo "Rotate Left";                        
                    }else{
                        echo "หมุนซ้าย";
                    }
                    ?></button>
                    <button class="rotate_btn rotate_right btn" data-deg="-90"><i class="fas fa-redo-alt"></i> 
                    <?php 
                    if(Yii::app()->session['lang'] == 1){
                        echo "Rotate Right";                        
                    }else{
                        echo "หมุนขวา";
                    }
                    ?></button>
                </div >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cropcancel" data-dismiss="modal">
                <?php 
                    if(Yii::app()->session['lang'] == 1){
                        echo "cancel";                        
                    }else{
                        echo "ยกเลิก";
                    }
                    ?>                        
                    </button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">
                <?php 
                    if(Yii::app()->session['lang'] == 2){
                        echo "บันทึกรูป";                                               
                    }else{
                        echo "Save";
                    }
                    ?>
                    </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // crop รูปภาพ
var $uploadCrop,
tempFilename,
rawImg,
imageId;


function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.upload-profileimg').addClass('ready');
            $('#cropImagePop').modal('show');
            rawImg = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);

        console.log($("#Profile_pro_pic").val());
    } else {
        if(<?= Yii::app()->session['lang'] ?> == 2){
            swal("ท่านยังไม่ได้เลือกรูป");                      
        }else{
            swal("Please select image");
        }
        
        // swal("ขออภัย - เบราว์เซอร์ของคุณไม่รองรับ FileReader API");
    }
}

$uploadCrop = $('#upload-profileimg').croppie({
    viewport: {
        width: 120,
        height: 120,
    },
    showZoomer: true,
    enableOrientation: true,
    enforceBoundary: true,
    enableExif: true
});

// $('.rotate_left, .rotate_right').on('click', function (ev) {
//     imageCrop.croppie('rotate', parseInt($(this).data('deg')));
//     });

$('.rotate_btn').on('click', function(ev) {
        $uploadCrop.croppie('rotate', $(this).attr("data-deg"));
    });

$('#cropImagePop').on('shown.bs.modal', function() {
    $uploadCrop.croppie('bind', {
        url: rawImg,
        // orientation: 2
    }).then(function() {});
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
            height: 150
        }
    }).then(function(resp) {
        $('#item-img-output').attr('src', resp);
        $('#cropImagePop').modal('hide');
        $('#url_pro_pic').val($('#item-img-output').attr('src'));
    });
});

$('#cropcancel').on('click', function(ev) {
$("#Profile_pro_pic").val("");
    });
</script>