<style>
  #dakok-detect-video {
    height: 200px;
  }
</style>
<section class="content-page">
  <div class="container-main">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/idcard/css/idcard.css" />
    <link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-vendors.js" rel="preload" as="script">
    <link href="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.css" rel="preload" as="style">
    <link href="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.js" rel="preload" as="script">
    <link href="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.css" rel="stylesheet">

    <div class="content-main mt-2 register-form">
      <div class="row justify-content-center ">
        <div class="col-lg-8 ">
          <div class="card p-3">
            <h2 class="text-center mt-1 mb-1">ยืนยันภาพใบหน้าของคุณ</h2>
            <div id="idcardWrapper" class="no-photo no-mobile">
              <div class="">
                <div class="row">
                  <div class="col-auto mx-auto">
                    <div class="facelogin" id="cameraPhotoWrapper">
                      <!--   <img class="cam" src="<?php echo Yii::app()->theme->baseUrl; ?>/idcard/img/webcam.png" alt=""> 
                              <img class="face-check" src="<?php echo Yii::app()->theme->baseUrl; ?>/idcard/img/face-d.png">
                              <video id="video2" autoplay playsinline muted>Video stream not available.</video> -->
                      <dakok-detect></dakok-detect>
                    </div>

                    <div class="mt-2 mb-4 pt-3 pb-4">
                      <div class="form-group text-center">
                        <label for="profile">Name: <?= $profile ?> </label>
                        <br>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                          'id' => 'registration-form',
                          'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1', 'onsubmit' => 'return checkForm();'),
                        ));
                        ?>
                        <input type="text" accept="image/png" hidden name="current_image" id="current_image">
                        <input type="text" hidden name="userId" id="userId" value="<?= $userId ?>">
                        <input type="text" hidden name="use" id="use" value="<?= $use ?>">
                        <input type="text" hidden name="pas" id="pas" value="<?= $pas ?>">

                        <div class="col take-camera-desktop">
                          <button onclick="login()" class="take-camera-desktop btn btn-warning mb-2"><i class="fas fa-camera"></i> ยืนยัน</button>
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
      </div>
    </div>
    <canvas id="myCanvas" width="400" height="350" hidden></canvas>
  </div>
</section>

<script src="https://facesimilarity.static.dakok.net/dakok-detect/chunk-vendors.js"></script>
<script src="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.js"></script>
<script>
  function login() {

    const tmp = document.getElementById("dakok-detect-result");
    console.log(tmp.value == "")
    if (tmp.value == "") {

    } else {
      document.getElementById("current_image").value = tmp.value;
    }

  }
</script>