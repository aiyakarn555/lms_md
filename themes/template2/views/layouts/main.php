<?php
$session = new CHttpSession;
$session->open();
$http = new CHttpRequest;
Yii::app()->user->returnUrl = $http->getUrl();
/*if ($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '112.121.150.4' && $_SERVER['HTTP_HOST'] != '127.0.0.1') {
  if($_SERVER['HTTPS'] != 'on'){
    $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header('Location:'.$redirect);
  }
} */
?>
<!doctype html>
<!--[if IE 8 ]>
  <html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]>
  <html lang="en" class="no-js"> <![endif]-->
<html lang="en">

<head>
  <?php if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $this->pageTitle = 'Marine Department e-Learning System ';
  } else {
    $langId = Yii::app()->session['lang'];
    $this->pageTitle = 'Marine Department e-Learning System  ';
  }
  ?>
  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
  <?php include("themes/template2/include/css.php"); ?>
</head>

<body>

  <div class="backtotop"><span><i class="fas fa-arrow-up"></i> <small>top</small></span></div>
  <?php //if(Yii::app()->user->id){ 
  ?>

  <!-- <a class="contact-admin" data-toggle="modal" href="#user-report">
    <?php
    if (Yii::app()->session['lang'] == 1) {
      $mascot_path = Yii::app()->createUrl('/themes/template2/images/mascot-report-en.png'); //อังกฤษ
    } else {
      $mascot_path = Yii::app()->createUrl('/themes/template2/images/mascot-report-th.png'); //ไทย
    }
    ?>
    <?php  ?>
    <div id="mascot-contact">
      <img src="<?php echo $mascot_path; ?>" alt="">
    </div>

  </a> -->


  <?php include("themes/template2/include/header.php"); ?>
  <div class="main-content">
    <?php echo $content; ?>
    <?php include("themes/template2/include/footer.php"); ?>
  </div>

  <?php include("themes/template2/include/javascript.php"); ?>

  <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jquery-validation/dist/jquery.validate.js"></script>
  <!-- <script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl; 
                                            ?>/js/moment.js"></script> -->
  <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/combodate.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"></script>
  <?php
  //include_once("analyticstracking.php");
  ?>
</body>

</html>