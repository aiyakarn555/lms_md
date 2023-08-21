<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Face Verification</title>
</head>

<link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.js" rel="preload" as="script">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.css" rel="preload" as="style">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.js" rel="preload" as="script">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.css" rel="stylesheet">


<style type="text/css">
  #personFaceInput {
    /* TODO: Implement CSS for IOS HERE */
  }
  #video {
    display: block;
}

.id-frame {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("<?php echo Yii::app()->theme->baseUrl; ?>/idcard/img/face-d.png");
    background-size: 45%;
    background-position: center center;
    background-repeat: no-repeat;
}

#VideoBox {
    /* display: none; */
    width: fit-content;
    margin: auto;
    position: relative;
}

</style>
<section class="content-page">
  <div class="container-main m-login-face">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-sm-12 col-xs-12">
        <!-- NOTE: Add overflow hidden for hide overflow camera frame -->
        <div class="card p-3" style="overflow: hidden;">
          <h3 class="text-center mb-1"><?= $langId == 1 ? "Register your face" : "ลงทะเบียนภาพใบหน้าของคุณ" ?></h3>
          <br>
          <!-- <div class="steps">
                    <div class="step-item">
                        <button class="step-button step-one text-center" aria-expanded="true">
                            1
                        </button>
                        <div class="step-title">
                          <?= $langId == 1 ? "Please look straight ahead to capture straight faces." : "กรุณามองตรงเพื่อถ่ายภาพหน้าตรง" ?>
                        </div>
                    </div>
                    <div class="step-item">
                        <button class="step-button step-two text-center collapsed" type="button" aria-expanded="false">
                            2
                        </button>
                        <div class="step-title">
                           <?= $langId == 1 ? "Please turn your face to the left. " : "กรุณาหันหน้าไปทางซ้าย" ?>
                        </div>
                    </div>
                    <div class="step-item">
                        <button class="step-button step-three text-center collapsed" aria-expanded="false">
                            3
                        </button>
                        <div class="step-title">
                            <?= $langId == 1 ? "Please turn your face to the right. " : "กรุณาหันหน้าไปทางขวา" ?>
                        </div>
                    </div>
          </div> -->
          <div id="idcardWrapper" class="no-photo no-mobile">
            <div class="">
              <div class="">
                <div class="facelogin" id="cameraPhotoWrapper">
                  <!-- NOTE: Integrated interval face detection camera with frame -->
                 <div class="text-center">
                  <label for="face" class="mt-2 mb-2">Face Verification  <span class="current-text"><?= $langId == 1 ? "straight face " : "ภาพหน้าตรง" ?></span> </label>
                </div>
                  <div  class="face-scan" style="display: flex;align-content: center;justify-content: center; width: fit-content;margin: auto;position: relative;" id="cameraContainer">
                    <video  id="videos" width="520" height="360" controls="false" autoplay="autoplay" playsinline muted></video>
                    <canvas  width="520" height="360" class="preview-camera preview-main" style="display:none;"></canvas>
                    <div class="id-frame"></div>
                  </div>
     

                </div>
                <div class="mt-2 mb-4 pt-3 pb-4">
                  <div class="form-group text-center">
                    <label for="profile"><?= $langId == 1 ? "Name:" : "ชื่อ:" ?> <?= $profile ?> </label>
                    <br>
                    <br>
                    <?php
                    $form = $this->beginWidget(
                      'CActiveForm', 
                      array(
                        'id' => 'registration-form',
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1'),
                      ));
                    ?>
                    
                    <input type="file" accept="image/jpg"  name="face_image_1" id="face_image_1" style="display: none;">
                    <input type="file" accept="image/jpg"  name="face_image_2" id="face_image_2" style="display: none;">
                    <input type="file" accept="image/jpg"  name="face_image_3" id="face_image_3" style="display: none;">
                    <input type="hidden" name="UserId" id="UserId" value="<?= $users_id ?>">
                    <input type="file" name="fileregis" id="fileregis" style="display: none;">

                    <div id="face-warn" style="display: block;">
                    <?= $langId == 1 ? "Face detection. Please, move your face." : "กำลังตรวจจับใบหน้า กรุณาขยับใบหน้า" ?>  <span class="current-text"><?= $langId == 1 ? "straight face " : "ภาพหน้าตรง" ?></span>
                    </div>

                    <div class="col take-camera-desktop mt-1 mb-1">
                          <button id="capture-photo" class="btn btn-primary mx-2" type="button"> <i class="fas fa-camera"></i> ถ่ายภาพ</button>
                          <button type="button" id="clear-photo" class="btn btn-danger mx-2"> <i class="fa fa-repeat"></i> ถ่ายใหม่</button>
                          <button  onclick="login() ; return 0" type="button" class="take-camera-desktop take-photo btn btn-warning " id="submit-button" style="display: none;">
                                   <?= $langId == 1 ? "Confirm" : "ยืนยันภาพถ่าย" ?>
                          </button>
                    </div>

                    <!-- <div class="d-flex justify-content-center mt-1 mb-1">
                          <button class="btn btn-lg btn-default center-block mx-2" type="button" id="previous"
                              ><i class="fa fa-arrow-left"></i> ย้อนกลับ </button>
                          <button class="btn btn-lg btn-default center-block mx-2" type="button" id="next"
                              >ถัดไป <i class="fa fa-arrow-right"></i></button>
                      </div> -->
                    
                 
                    <!-- <div class="col" > 
                        <h3 id="preview">Preview</h3>
                        <img src="" id="capturePreview" alt=""/>
                    </div> -->
                    <br>
                    <div class="col take-camera-desktop">

                    <!-- <div class="preview-face row">
                      <div class=" col-12 col-sm-6 col-md-6 col-lg-4" >
                          <div class="preview-col mb-2">
                              <label class="mb-1">ตัวอย่างถ่ายภาพมุมตรง :</label>
                              <div class="canvas-bg"><canvas  class="canvas-box preview-box-main" width="300" height="400" ></canvas></div>
                          </div>
                      </div>
                      <div class="col-12 col-sm-6 col-md-6 col-lg-4" >
                          <div class="preview-col mb-2">
                              <label class="mb-1">ตัวอย่างถ่ายภาพมุมซ้าย :</label>
                              <div class="canvas-bg"><canvas  class="canvas-box preview-left" width="300" height="400"></canvas></div>
                          </div>
                      </div>
                      <div class=" col-12 col-sm-6 col-md-6 col-lg-4" >
                          <div class="preview-col mb-2">
                              <label class="mb-1">ตัวอย่างถ่ายภาพมุมขวา :</label>
                              <div class="canvas-bg"><canvas class="canvas-box preview-right" width="300" height="400"></canvas></div>
                          </div>
                      </div>
                  </div> -->
                  <!-- <div class="">
                        <button  onclick="login()" class="take-camera-desktop take-photo btn btn-warning mb-2" id="submit-button" disabled="true">
                                   <?= $langId == 1 ? "Confirm" : "ยืนยันภาพถ่าย" ?>
                        </button>
                  </div> -->

                    <!-- <button type="button" id="capture-photo" class="btn btn-primary">ถ่ายภาพ</button>
                    <button type="button" id="clear-photo" class="btn btn-danger">เริ่มใหม่</button>
                      <br><br>
                      <button 
                        onclick="login()" 
                        class="take-camera-desktop take-photo btn btn-warning mb-2" 
                        id="submit-button"
                        disabled="true" 
                      >
                        <i class="fas fa-camera"></i>
                        &nbsp;
                        <?= $langId == 1 ? "Confirm" : "ยืนยัน" ?>
                      </button> -->
                    </div>

                    <?php $this->endWidget(); ?>

                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
    <canvas id="myCanvas" width="400" height="350" hidden></canvas>
    <input type="text" id="numberpage" value="1" hidden>
  </div>

</section>

<script type="text/javascript">

var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

var isFirefox = typeof InstallTrigger !== 'undefined';

var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && window['safari'].pushNotification));

var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);

var isEdgeChromium = isChrome && (navigator.userAgent.indexOf("Edg") != -1);

var isBlink = (isChrome || isOpera) && !!window.CSS;

//--------------------
// GET USER MEDIA CODE
//--------------------

const output = document.getElementById("current_image")
const outputleft = document.getElementById("current_image_left")
const outputright = document.getElementById("current_image_right")
const warn = document.getElementById("face-warn")
const btn = document.getElementById("submit-button")
const inputField = document.getElementById("iOSInput");

let video = document.querySelector('video[id="videos"]');
let videoleft = document.querySelector('video[id="videos_left"]');
let videoright = document.querySelector('video[id="videos_right"]');
let click_button = document.querySelector("#capture-photo");
let canvas = document.querySelector(".preview-main");
let canvasBox = document.querySelector(".preview-box-main");
let canvasleft = document.querySelector(".preview-left");
let canvasright = document.querySelector(".preview-right");
let clear_button = document.querySelector("#clear-photo");
// $("#clear-photo").prop('disabled', true);
$("#preview").css("display", "none");
$("#next-one").prop('disabled', true);

var localMediaStream = null;
    var constraints = {
        video: true,
        video: {
            width: { max: 960 },
            height: { max: 720 }
        },
        audio: false
    };
    navigator.mediaDevices.getUserMedia(constraints)
        .then(function (stream) {
            video.play();
            cameraStarted = true;
            video.srcObject = stream;
            localMediaStream = stream;
        })
        .catch(function (error) {

            if (isChrome && !isEdgeChromium) {
                Swal.fire({
                    title: "คุณไม่มีสิทธิ์เข้าถึง กล้อง !",
                    text: "กรุณาตั้งค่าสิทธิ์ กล้อง บนบราวเซอร์ ",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ตกลง',
                    allowOutsideClick: false,

                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = 'https://support.google.com/chrome/answer/2693767?hl=en&co=GENIE.Platform%3DDesktop';
                    } else if (result.isDenied) {
                        window.location.href = 'https://support.google.com/chrome/answer/2693767?hl=en&co=GENIE.Platform%3DDesktop';
                    }
                });

            } else {
                Swal.fire({
                    title: "คุณไม่มีสิทธิ์เข้าถึง กล้อง บนบราวเซอร์นี้ !",
                    text: "กรุณาใช้งานบน บราวเซอร์ Chrome",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ตกลง',
                    allowOutsideClick: false,

                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = 'https://www.google.com/chrome/go-mobile/';
                    } else if (result.isDenied) {
                        window.location.href = 'https://www.google.com/chrome/go-mobile/';
                    }
                });
            }

        });
    function removeControls(video) {
        video.removeAttribute('controls');
    }
    window.onload = removeControls(video);

  let image_data_url = '';
  const login = () => {
    Swal.fire({
        title: "",
        text: "คุณต้องการยืนยันภาพใบหน้าของคุณหรือไม่",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false,

    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        console.log(result.value)
        if (result.value) {
            $("#registration-form").submit()
        }
    });
    // Draws current image from the video element into the canvas
    // ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    // const dataURL = canvas.toDataURL('image/png');
    // document.getElementById("current_image").value = document.getElementById("dakok-detect-result").value;

    // console.log($("#capturePreview").attr('src'));
    var file = dataURLtoFile(image_data_url,<?= $userId; ?>);
    var fileInput = document.querySelector('#fileregis')
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

  navigator.mediaDevices.getUserMedia({ video: true, audio: false })
  .then((stream) => {
    video.srcObject = stream;
    video.play();
  })
  .catch((err) => {
    console.error(`An error occurred: ${err}`);
  });


   // default Value & button
   let i = 1;
    if(i == 1){
        // $('#previous').prop('disabled', true);
        // $("#clear-photo").prop('disabled', true);
        $("#clear-photo").hide();
    }

    let faceImgData = {
        face_image_1:"", 
        face_image_2:"", 
        face_image_3:""
    };

    //Caputure Button
    $("#capture-photo").click(function() {
        $("#capture-photo").css("display", "none");
       $(".preview-main").css("display", ""); //show image in video
       $(".id-frame").css("display", "none"); 
       $("#clear-photo").show();
       // insert Image
       insertImageSet($("#numberpage").val());
    });

    //Clear Caputrue Button
    $("#clear-photo").click(function() {
        $("#capture-photo").css("display", "");
        $(".preview-main").css("display", "none");
        $("#clear-photo").css("display", "none");
       $(".id-frame").css("display", ""); // Open Vdo 
       //clearImage Insert
       clearImageSet($("#numberpage").val());
    });

    // $("#previous").click(function() {
    //     if($("#numberpage").val() > 1){
    //         $("#numberpage").val(--i);
    //         $('#next').prop('disabled', false);
    //     }
    //     if(i == 1 ){
    //         $('#previous').prop('disabled', true);
    //     }
    //     stepColor($("#numberpage").val());
    //     stepText($("#numberpage").val());
    //     showImageNumberPage($("#numberpage").val());
    // });

    // $("#next").click(function() {
    //     if($("#numberpage").val()  < 3){
    //         $("#numberpage").val(++i);//Page number
    //         $('#previous').prop('disabled', false); //previous button disabled
    //     }
    //     if(i == 3){
    //         $('#next').prop('disabled', true); //next button enabled
    //     }
    //     stepColor($("#numberpage").val());
    //     stepText($("#numberpage").val());
    //     showImageNumberPage($("#numberpage").val());
    // });

    // stepColor = (i) => {
    //      if(i== 1){
    //         $(".step-two").attr( 'aria-expanded', 'false');
    //         $(".step-three").attr( 'aria-expanded', 'false');
    //     }else if(i== 2){
    //         $(".step-two").attr( 'aria-expanded', 'true');
    //         $(".step-three").attr( 'aria-expanded', 'false');
    //     }else{
    //         $(".step-three").attr( 'aria-expanded', 'true');
    //     }
    // }

    //  stepText = (i) => {
    //      if(i== 1){
    //         $(".current-text").text( 'ภาพหน้าตรง');
    //     }else if(i== 2){
    //        $(".current-text").text( 'ภาพหน้าหันด้านซ้าย');
    //     }else{
    //        $(".current-text").text( 'ภาพหน้าหันด้านขวา');
    //     }
    // }
    // show Image Number Page
    showImageNumberPage = (i) => {
        var image = new Image();
        image.onload = () => { canvas.getContext('2d').drawImage(image, 0, 0) }
         if(i== 1 && faceImgData.face_image_1 != ""){
            image.src = faceImgData.face_image_1;
            $(".preview-main").css("display", "");
            $("#capture-photo").prop('disabled', true);//Capture button enabled
            $("#clear-photo").prop('disabled', false);//Capture button enabled
         }else{
            $(".preview-main").css("display", "none");
            $("#capture-photo").prop('disabled', false);//Capture button disabled
            $("#clear-photo").prop('disabled', false);//Capture button enabled
         }

       checkSubmitButton();
    }

    // showImageNumberPage = (i) => {
    //     var image = new Image();
    //     image.onload = () => { canvas.getContext('2d').drawImage(image, 0, 0) }
    //      if(i== 1 && faceImgData.face_image_1 != ""){
    //         image.src = faceImgData.face_image_1;
    //         $(".preview-main").css("display", "");
    //         $("#capture-photo").prop('disabled', true);//Capture button enabled
    //         $("#clear-photo").prop('disabled', false);//Capture button enabled
    //      }else if(i== 2 && faceImgData.face_image_2 != ""){
    //         image.src = faceImgData.face_image_2;
    //         $(".preview-main").css("display", "");
    //         $("#capture-photo").prop('disabled', true);//Capture button enabled
    //         $("#clear-photo").prop('disabled', false);//Capture button enabled
    //      }else if(i == 3 && faceImgData.face_image_3 != ""){
    //         image.src = faceImgData.face_image_3;
    //         $(".preview-main").css("display", "");
    //         $("#capture-photo").prop('disabled', true);//Capture button enabled
    //         $("#clear-photo").prop('disabled', false);//Capture button enabled
    //      }else{
    //         $(".preview-main").css("display", "none");
    //         $("#capture-photo").prop('disabled', false);//Capture button disabled
    //         $("#clear-photo").prop('disabled', false);//Capture button enabled
    //      }

    //    checkSubmitButton();
    // }

    // insertImage fn
    insertImageSet = (i) => {
      canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
      if(i== 1){
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            image = canvas.toDataURL("image/jpeg", 1.0);
            faceImgData.face_image_1 = image;
        }
        checkSubmitButton();
    }

    // insertImageSet = (i) => {
    //   canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    //   if(i== 1){
    //         canvasBox.getContext('2d').drawImage(video, 0, 0, canvasBox.width, canvasBox.height);
    //         image = canvas.toDataURL("image/jpeg", 1.0);
    //         faceImgData.face_image_1 = image;
    //     }else if(i== 2){
    //         canvasleft.getContext('2d').drawImage(video, 0, 0, canvasleft.width, canvasleft.height);
    //         image = canvas.toDataURL("image/jpeg", 1.0);
    //         faceImgData.face_image_2 = image;
    //     }else{
    //         canvasright.getContext('2d').drawImage(video, 0, 0, canvasright.width, canvasright.height);
    //         image = canvas.toDataURL("image/jpeg", 1.0);
    //         faceImgData.face_image_3 = image;
    //     }

    //     checkSubmitButton();
    // }

    clearImageSet = (i) => {
        if(i == 1){
            faceImgData.face_image_1 = "";
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        }
        checkSubmitButton();
    }

    //clear Image fn
    // clearImageSet = (i) => {
    //     if(i == 1){
    //         faceImgData.face_image_1 = "";
    //         canvasBox.getContext('2d').clearRect(0, 0, canvasBox.width, canvasBox.height);
    //     }else if(i == 2){
    //         faceImgData.face_image_2 = "";
    //         canvasleft.getContext('2d').clearRect(0, 0, canvasleft.width, canvasleft.height);
    //     }else{
    //         faceImgData.face_image_3 = "";
    //         canvasright.getContext('2d').clearRect(0, 0, canvasright.width, canvasright.height);
    //     }
    //     checkSubmitButton();
    // }


    checkSubmitButton = () => {
        console.log(faceImgData);
         if(faceImgData.face_image_1 != "" ){
            $("#submit-button").css("display",""); //submit button disabled
            dataURLtoFile(faceImgData.face_image_1,$("#UserId").val(),"#face_image_1");
            dataURLtoFile(faceImgData.face_image_1,$("#UserId").val(),"#face_image_2");
            dataURLtoFile(faceImgData.face_image_1,$("#UserId").val(),"#face_image_3");
        }else{
            $("#submit-button").css("display","none");
        }
    }


    function dataURLtoFile(dataurl, filename,id) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), 
            n = bstr.length, 
            u8arr = new Uint8Array(n);
            
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        
        var file =  new File([u8arr], filename, {type:mime});

        var fileInput = document.querySelector(id)
        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        // Help Safari out
        if (fileInput.webkitEntries.length) {
            fileInput.dataset.file = `${dataTransfer.files[0].name}`;
        }
    }




  </script>
</html>