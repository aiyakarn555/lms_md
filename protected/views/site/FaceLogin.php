<?php

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
  'Login',
);
?>

<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
  $langId = Yii::app()->session['lang'] = 1;
} else {
  $langId = Yii::app()->session['lang'];
}
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/idcard/css/idcard.css" />

<!--  NOTE: Import Dakok's Face Similarity APIs -->
<link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.js" rel="preload" as="script">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.css" rel="preload" as="style">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.js" rel="preload" as="script">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.css" rel="stylesheet">

<style type="text/css">
  #personFaceInput {
    /* TODO: Implement CSS for IOS HERE */
  }
</style>

<section class="content-page">
  <div class="container-main m-login-face">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-sm-12 col-xs-12">
        <!-- NOTE: Add overflow hidden for hide overflow camera frame -->
        <div class="card p-3" style="overflow: hidden;">
          <h3 class="text-center mb-1"><?= $langId == 1 ? "Verify your face" : "ยืนยันภาพใบหน้าของคุณ" ?></h3>
          <br>
          <div id="idcardWrapper" class="no-photo no-mobile">
            <div class="">
              <div class="">
                <div class="facelogin" id="cameraPhotoWrapper">
                  <!-- <img class="cam" src="<?php echo Yii::app()->theme->baseUrl; ?>/idcard/img/webcam.png" alt="">  -->
                  <!-- <img style="z-index: 10;" class="face-check" src="<?php echo Yii::app()->theme->baseUrl; ?>/idcard/img/face-d.png"> -->
                  <!-- <video id="video" autoplay playsinline muted>Video stream not available.</video> -->

                  <!-- NOTE: Integrated interval face detection camera with frame -->
                  <div style="display: flex;align-content: center;justify-content: center;" id="cameraContainer">
                    <dakok-detect></dakok-detect>                    
                  </div>

                  

                </div>
                <div class="mt-2 mb-4 pt-3 pb-4">
                  <div class="form-group text-center">
                    <label for="profile">Name: <?= $profile ?> </label>
                    <br>
                    <br>

                    <?php
                    $form = $this->beginWidget(
                      'CActiveForm', 
                      array(
                        'id' => 'registration-form',
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1', 'onsubmit' => 'return checkForm();'),
                      ));
                    ?>

                    <input type="hidden" name="current_image" id="current_image">
                    <input type="text" hidden name="userId" id="userId" value="<?= $userId ?>">
                    <input type="text" hidden name="use" id="use" value="<?= $use ?>">
                    <input type="text" hidden name="pas" id="pas" value="<?= $pas ?>">
                    <!-- <input type="file" id="file_image" name="file_image"> -->


                    <div id="face-warn" style="display: block;">
                      กำลังตรวจจับใบหน้า กรุณาขยับใบหน้า
                    </div>

                    <div class="col take-camera-desktop">
                      <button 
                        onclick="login()" 
                        class="take-camera-desktop btn btn-warning mb-2" 
                        id="submit-button"
                        disabled="true" 
                      >
                        <i class="fas fa-camera"></i>
                        &nbsp;
                        <?= $langId == 1 ? "Confirm" : "ยืนยัน" ?>
                      </button>
                    </div>
                    <?php
                      $this->endWidget();
                    ?>

                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
    <canvas id="myCanvas" width="400" height="350" hidden></canvas>
  </div>

</section>

<!-- Import Dakok's Face Similarity APIs -->
<script src="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.js"></script>
<script src="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
  //--------------------
  // GET USER MEDIA CODE
  //--------------------
  // let video = document.getElementById("video");
  // let canvas = document.getElementById("myCanvas");
  // let ctx = canvas.getContext('2d');

  // var localMediaStream = null;
  // var constraints = {
  //   video: {
  //     width: {
  //       max: 960
  //     },
  //     height: {
  //       max: 720
  //     }
  //   },
  //   audio: false
  // };
  // navigator.mediaDevices.getUserMedia(constraints)
  //   .then(function(stream) {
  //     video.srcObject = stream;
  //     localMediaStream = stream;
  //   })
  //   .catch(function(error) {
  //     console.log(error);
  //   });

  // function removeControls(video) {
  //   video.removeAttribute('controls');
  // }
  // window.onload = removeControls(video);

  /**
  * Note: `output`, `warn` and `btn` is a constraints for web elements. every 380 ms.
  * Fetch results from Dakok face detect camera,
  * if data exist update to output.
  **/
  const output = document.getElementById("current_image")
  const warn = document.getElementById("face-warn")
  const btn = document.getElementById("submit-button")
  const inputField = document.getElementById("iOSInput");


  const login = () => {

    // Draws current image from the video element into the canvas
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    const dataURL = canvas.toDataURL('image/png');
    document.getElementById("current_image").value = document.getElementById("dakok-detect-result").value;
  }



  setInterval(async () => {
    const result = document.getElementById("dakok-detect-result")
    if(result.value.length > 0){
      output.value = result.value
      warn.style.display = 'none';
      btn.disabled = false;
    }
  }, 380)


   // function dataURLtoFile(dataurl, filename) {
 
   //      var arr = dataurl.split(','),
   //          mime = arr[0].match(/:(.*?);/)[1],
   //          bstr = atob(arr[1]), 
   //          n = bstr.length, 
   //          u8arr = new Uint8Array(n);
            
   //      while(n--){
   //          u8arr[n] = bstr.charCodeAt(n);
   //      }
        
   //      return new File([u8arr], filename, {type:mime});
   //  }




 
  
</script>