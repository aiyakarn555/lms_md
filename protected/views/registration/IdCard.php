<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
if (Yii::app()->session['lang'] == 2) {
    $idCardPath = 'ยืนยันบัตรประชาชน';
    $idCardBack = 'กลับหน้าแรก';
    $idCardOuradvice = 'คำแนะนำของเรา';
    $idCardAdvice = [
        0 => 'ถ่ายในที่ที่มีแสงสว่างเพียงพอ',
        1 => 'รูปถ่ายด้านหน้าบัตรประชาชนชัดเจน ไม่มีรอบขูดขีด',
        2 => 'หลีกเลี่ยงแสงสะท้อนบนบัตร.'
    ];
    $idCardFrontPic = 'ภาพด้านหน้าบัตรประชาชน';
    $idCardName = 'ชื่อ:';
    $idCardTakeAPhoto = 'ถ่ายภาพ';
    $idCardUpload = 'อัพโหลดไฟล์';
    $idCardRenew = 'เริ่มใหม่';
    $idCardConfirm = 'ยืนยัน';
} else {
    $idCardPath = 'ID card confirmation';
    $idCardBack = 'Back to homepage';
    $idCardAdvice = [
        0 => 'Shoot in a well-lit place.',
        1 => 'A clear photo of the front of the ID card no scratch.',
        2 => 'Avoid glare on the card.'
    ];
    $idCardFrontPic = 'Picture of the front of the ID card';
    $idCardName = 'Name:';
    $idCardTakeAPhoto = 'Take a photo';
    $idCardUpload = 'Upload files';
    $idCardRenew = 'Renew';
    $idCardConfirm = 'Confirm';
}

?>



<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/idcard2/css/idcard.css" />
<section class="content-page">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
            <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active"><a style="color: #757272"><?= $idCardPath; ?></a></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 align-self-center p-static text-center mb-4">
                <h2 class="text-light"><?= $idCardPath ;?> </h2>
            </div>
        </div>

        <div id="idcardWrapper" class="no-photo no-mobile">
            <div class="row header-row img-card-bg justify-content-center">
                <div class="col-lg-6 mx-auto p-0">
                    <img class="header-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/idcard/img/card-id.png" width="100%">
                </div>
            </div>

            <div class="back mt-2 mb-1">
                <a class="text-decoration-none" href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-chevron-left text-1 me-1"></i>&nbsp;<?= $idCardBack ;?></a>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8 mx-auto ">

                    <h4 class="suggest-title"><?= $idCardOuradvice ;?></h4>
                    <ul class="suggest-list">
                        <li>
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.5" cy="8.5" r="8.5" fill="#FECD22" />
                                <g clip-path="url(#clip0_321_2176)">
                                    <path d="M7.19801 11.9583L4.21451 8.97476C4.03527 8.79551 4.03527 8.50489 4.21451 8.32563L4.86362 7.6765C5.04286 7.49724 5.3335 7.49724 5.51274 7.6765L7.52257 9.68631L11.8274 5.3815C12.0066 5.20226 12.2973 5.20226 12.4765 5.3815L13.1256 6.03063C13.3049 6.20987 13.3049 6.50049 13.1256 6.67976L7.84714 11.9583C7.66788 12.1375 7.37725 12.1375 7.19801 11.9583V11.9583Z" fill="#2B4279" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_321_2176">
                                        <rect width="9.18" height="9.18" fill="white" transform="translate(4.08008 4.08008)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <?= $idCardAdvice[0]; ?>
                        </li>
                        <li>
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.5" cy="8.5" r="8.5" fill="#FECD22" />
                                <g clip-path="url(#clip0_321_2176)">
                                    <path d="M7.19801 11.9583L4.21451 8.97476C4.03527 8.79551 4.03527 8.50489 4.21451 8.32563L4.86362 7.6765C5.04286 7.49724 5.3335 7.49724 5.51274 7.6765L7.52257 9.68631L11.8274 5.3815C12.0066 5.20226 12.2973 5.20226 12.4765 5.3815L13.1256 6.03063C13.3049 6.20987 13.3049 6.50049 13.1256 6.67976L7.84714 11.9583C7.66788 12.1375 7.37725 12.1375 7.19801 11.9583V11.9583Z" fill="#2B4279" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_321_2176">
                                        <rect width="9.18" height="9.18" fill="white" transform="translate(4.08008 4.08008)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <?= $idCardAdvice[1]; ?>
                        </li>
                        <li>
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.5" cy="8.5" r="8.5" fill="#FECD22" />
                                <g clip-path="url(#clip0_321_2176)">
                                    <path d="M7.19801 11.9583L4.21451 8.97476C4.03527 8.79551 4.03527 8.50489 4.21451 8.32563L4.86362 7.6765C5.04286 7.49724 5.3335 7.49724 5.51274 7.6765L7.52257 9.68631L11.8274 5.3815C12.0066 5.20226 12.2973 5.20226 12.4765 5.3815L13.1256 6.03063C13.3049 6.20987 13.3049 6.50049 13.1256 6.67976L7.84714 11.9583C7.66788 12.1375 7.37725 12.1375 7.19801 11.9583V11.9583Z" fill="#2B4279" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_321_2176">
                                        <rect width="9.18" height="9.18" fill="white" transform="translate(4.08008 4.08008)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <?= $idCardAdvice[2]; ?>
                        </li>
                    </ul>
                    <hr>
                    <h4 class="suggest-title text-center mb-2"><?=  $idCardFrontPic ;?></h4>
                    <div id="cameraPhotoWrapper text-center">
                        <div class="camera-photo text-center">
                            <div id="VideoBox">
                                <video id="video" autoplay playsinline muted>Video stream not available.</video>
                                <canvas style="display: none" id="canvas"></canvas>
                                <div class="id-frame"></div>
                            </div>
                            <img id="photo" alt="">
                            <div class="camera-logo">
                                <i class="fas fa-camera icon"></i>
                                <p>camera</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 mb-4 pt-3 pb-4">
                        <div class="form-group text-center">
                            <label for="profile"><?= $idCardName ;?> <?= $profile ?> </label>
                            <br>
                            <br>

                            <div class="my-3 text-center camera-page">
                                <div class="row text-center justify-content-center">
                                    <div class="col take-camera-desktop text-center">
                                        <button id="startCameraBtn" class="take-camera-desktop btn btn-warning mb-2 font-size-20"><i class="fas fa-camera"></i> <?= $idCardTakeAPhoto; ?></button>
                                        <button id="clearphotoButton" class="take-camera-desktop btn btn-secondary font-size-20"><i class="far fa-trash-alt"></i> <?= $idCardRenew; ?></button>
                                    </div>
                                    <div class="col take-camera-mobile text-center mx-1">
                                        <label for="takeCameraMobile" class="take-camera-mobile-btn btn btn-warning mb-2">
                                            <i class="fas fa-camera"></i> <?= $idCardTakeAPhoto; ?>
                                            <input onchange="onfileChange(this)" id="takeCameraMobile" name="takeCamera" class="d-none" type="file" accept="image/*" capture="camera">
                                        </label>
                                        <button id="clearCameraMobile" class="clear-camera-mobile-btn btn btn-danger font-size-20"><i class="far fa-trash-alt"></i> <?= $idCardRenew; ?></button>
                                    </div>
                                    <div class="col mx-1" >
                                        <label for="uploadFile" class="btn btn-primary font-size-20">
                                            <i class="far fa-image"></i> <?= $idCardUpload; ?>
                                            <input onchange="onfileChange(this)" id="uploadFile" name="uploadFile" class="d-none" type="file" accept="image/*">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="">
                    <div class="mb-4 pt-3 pb-4">
                        <div class="form-group text-center">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'registration-form',
                                'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1', 'onsubmit' => 'return checkForm();'),
                            ));
                            ?>
                            <input type="hidden" name="UserId" id="UserId" value="<?= $users_id ?>">
                            <input type="hidden" name="idcard" id="idcard" value="">
                            <input type="file" name="fileidcard" id="fileidcard" style="display: none;">
                            <button  style="width:200px" class="confirm-btn btn btn-block btn-success flex font-size-20" value="regis" onClick="uploadIdCard()"><?= $idCardConfirm ;?></button>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>



    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/idcard2/js/idcard.js"></script>

<script>
    function uploadIdCard(){
        var file = dataURLtoFile(document.getElementById("idcard").value,<?= $users_id ?>);
        var fileInput = document.querySelector('#fileidcard')
        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        // Help Safari out
        if (fileInput.webkitEntries.length) {
            fileInput.dataset.file = `${dataTransfer.files[0].name}`;
        }
    }

    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), 
            n = bstr.length, 
            u8arr = new Uint8Array(n);
            
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        
        return new File([u8arr], filename, {type:mime});
 }
    
</script>