<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>IdCard Verification</title>
</head>
<?php var_dump('expression');exit(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/idcard2/css/idcard.css" />

<div role="main" class="main">

    <section class="page-header page-header-modern pb-3 mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 align-self-center p-static text-center mb-4">
                    <h1 class="text-light">ยืนยันบัตรประชาชน </h1>
                </div>
                <div class="col-md-12 align-self-center ">
                    <ul class="breadcrumb d-block">
                        <li>
                            <a href="#">หน้าแรก</a>
                        </li>
                        <li class="active">ยืนยันบัตรประชาชน </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div id="idcardWrapper" class="no-photo no-mobile">
        <div class="container">
            <div class="row header-row img-card-bg">
                <div class="col-lg-6 mx-auto p-0">
                    <img class="header-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/idcard2/img/card-id.png" width="100%">
                </div>
            </div>
        </div>
        

        <div class="container">
            <div class="row">
                <div class="col-auto mx-auto">
                    <div class="back mt-5 mb-5">
                        <a class="text-decoration-none" href="/"><i
                                class="fas fa-chevron-left text-1 me-1"></i>กลับหน้าแรก</a>
                    </div>
                    <h4 class="suggest-title">คำแนะนำของเรา</h4>
                    <div class="suggest-list">
                        <p>
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.5" cy="8.5" r="8.5" fill="#FECD22" />
                                <g clip-path="url(#clip0_321_2176)">
                                    <path
                                        d="M7.19801 11.9583L4.21451 8.97476C4.03527 8.79551 4.03527 8.50489 4.21451 8.32563L4.86362 7.6765C5.04286 7.49724 5.3335 7.49724 5.51274 7.6765L7.52257 9.68631L11.8274 5.3815C12.0066 5.20226 12.2973 5.20226 12.4765 5.3815L13.1256 6.03063C13.3049 6.20987 13.3049 6.50049 13.1256 6.67976L7.84714 11.9583C7.66788 12.1375 7.37725 12.1375 7.19801 11.9583V11.9583Z"
                                        fill="#2B4279" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_321_2176">
                                        <rect width="9.18" height="9.18" fill="white"
                                            transform="translate(4.08008 4.08008)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            ถ่ายในที่มีแสงสว่าง
                        </p>
                        <p>
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.5" cy="8.5" r="8.5" fill="#FECD22" />
                                <g clip-path="url(#clip0_321_2176)">
                                    <path
                                        d="M7.19801 11.9583L4.21451 8.97476C4.03527 8.79551 4.03527 8.50489 4.21451 8.32563L4.86362 7.6765C5.04286 7.49724 5.3335 7.49724 5.51274 7.6765L7.52257 9.68631L11.8274 5.3815C12.0066 5.20226 12.2973 5.20226 12.4765 5.3815L13.1256 6.03063C13.3049 6.20987 13.3049 6.50049 13.1256 6.67976L7.84714 11.9583C7.66788 12.1375 7.37725 12.1375 7.19801 11.9583V11.9583Z"
                                        fill="#2B4279" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_321_2176">
                                        <rect width="9.18" height="9.18" fill="white"
                                            transform="translate(4.08008 4.08008)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            รูปถ่ายด้านหน้าบัตรประชาชนชัดเจน ไม่มีรอบขูดขีด
                        </p>
                        <p>
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.5" cy="8.5" r="8.5" fill="#FECD22" />
                                <g clip-path="url(#clip0_321_2176)">
                                    <path
                                        d="M7.19801 11.9583L4.21451 8.97476C4.03527 8.79551 4.03527 8.50489 4.21451 8.32563L4.86362 7.6765C5.04286 7.49724 5.3335 7.49724 5.51274 7.6765L7.52257 9.68631L11.8274 5.3815C12.0066 5.20226 12.2973 5.20226 12.4765 5.3815L13.1256 6.03063C13.3049 6.20987 13.3049 6.50049 13.1256 6.67976L7.84714 11.9583C7.66788 12.1375 7.37725 12.1375 7.19801 11.9583V11.9583Z"
                                        fill="#2B4279" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_321_2176">
                                        <rect width="9.18" height="9.18" fill="white"
                                            transform="translate(4.08008 4.08008)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            หลีกเลี่ยงแสงสะท้อนบนบัตร
                        </p>
                    </div>
                    <hr>
                    <h4 class="suggest-title">ภาพด้านหน้าบัตรประชาชน</h4>
                    <div id="cameraPhotoWrapper">
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
                           <label for="profile">Name: <?= $profile ?> </label>
                           <br>
                           <br>

                         <div class="my-3 text-center camera-page">
                        <div class="row ">
                            <div class="col take-camera-desktop">
                                <button id="startCameraBtn" class="take-camera-desktop btn btn-warning mb-2"><i
                                        class="fas fa-camera"></i> ถ่ายภาพ</button>
                                <button id="clearphotoButton" class="take-camera-desktop btn btn-danger"><i
                                        class="far fa-trash-alt"></i> เริ่มใหม่</button>
                            </div>
                            <div class="col take-camera-mobile">
                                <label for="takeCameraMobile" class="take-camera-mobile-btn btn btn-warning mb-2">
                                    <i class="fas fa-camera"></i> ถ่ายภาพ
                                    <input onchange="onfileChange(this)" id="takeCameraMobile" name="takeCamera"
                                        class="d-none" type="file" accept="image/*" capture="camera">
                                </label>
                                <button id="clearCameraMobile" class="clear-camera-mobile-btn btn btn-danger"><i
                                        class="far fa-trash-alt"></i> เริ่มใหม่</button>
                            </div>
                            <div class="col">
                                <label for="uploadFile" class="btn btn-warning mb-2">
                                    <i class="far fa-image"></i> อัพโหลดไฟล์
                                    <input onchange="onfileChange(this)" id="uploadFile" name="uploadFile"
                                        class="d-none" type="file" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </div>
                              </div>
                            </div>
                            <hr class="mb-2">
                            <div class="mt-2 mb-4 pt-3 pb-4">
                              <div class="form-group text-center">
                               <?php
                               $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'registration-form',
                                'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1', 'onsubmit' => 'return checkForm();'),
                              ));
                              ?>
                              <input type="hidden" name="UserId" value="<?= $users_id ?>">
                              <input type="text" hidden name="idcard" id="idcard" value="">
                              <button style="width:200px" class="confirm-btn btn btn-block btn-success flex"
                              value="regis">ยืนยัน</button>
                              <?php $this->endWidget(); ?>
                            </div>
                          </div>

                </div>
            </div>

        </div>
    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/idcard2/js/idcard.js"></script>

