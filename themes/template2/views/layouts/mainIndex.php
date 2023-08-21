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
        $this->pageTitle = 'Marine Department e-Learning System ';
    }
    ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php include("themes/template2/include/css.php"); ?>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-167113577-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-167113577-2');
</script> -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172938689-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-172938689-1');
    </script>


</head>

<body>
    <!-- onload="init();" -->

    <div class="backtotop"><span><i class="fas fa-arrow-up"></i> <small>top</small></span></div>
    <?php //if(Yii::app()->user->id){ 
    ?>
    <!-- <a class="contact-admin" data-toggle="modal" href="#user-report">
        <?php
        if (Yii::app()->session['lang'] == 2) {
            $mascot_path = Yii::app()->createUrl('/themes/template2/images/mascot-report-th.png'); //ไทย
        } else {
            $mascot_path = Yii::app()->createUrl('/themes/template2/images/mascot-report-en.png'); //อังกฤษ
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

    <div id="loader">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#modal-news').modal('show');
        });
    </script>

    <?php
    $time = date("Y-m-d");
    $criteriapopup = new CDbCriteria;
    $criteriapopup->compare('active', 'y');
    $criteriapopup->condition = "start_date <= :time AND end_date >= :time";
    $criteriapopup->params = array(':time' => $time);
    $criteriapopup->addCondition('lang_id =' . Yii::app()->session['lang']);
    $criteriapopup->order = 'sortOrder  ASC';
    $popup = Popup::model()->findAll($criteriapopup);
    //$popup = null;

    ?>
    <?php
    if (isset(Yii::app()->session['popup']) && Yii::app()->session['popup'] == 1) {
        Yii::app()->session['popup'] = 2;
        if (!empty($popup)) {
            if (Yii::app()->user->id) {
                // $criteria = new CDbCriteria;
                // $criteria->addCondition('user_id ='.Yii::app()->user->id);
                // $User = User::model()->findAll($criteria);
                // foreach ($User as $key => $value) {
                //    $date_last  = $value->lastvisit_at;
                // }
                //if ($date_last === '0000-00-00 00:00:00') {
    ?>
                <div class="modal fade" id="modal-news">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><?= Yii::app()->session['lang'] == 1 ? 'The topic' : 'หัวข้อ'; ?></h4>
                            </div>
                            <div class="modal-body pd-0">
                                <div id="carousel-id2" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">

                                        <?php

                                        foreach ($popup as $key => $value) {
                                        ?>

                                            <li data-target="#carousel-id2" data-slide-to="<?= $key; ?>" class="<?php if ($key == 0) echo 'active'; ?>"></li>

                                        <?php
                                        } ?>


                                    </ol>
                                    <?php //$imgpopup = 'holder.js/900x500/auto/#666:#6a6a6a/text:First slide" alt="First slide" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI5MDAiIGhlaWdodD0iNTAwIj48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzY2NiI+PC9yZWN0Pjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjQ1MCIgeT0iMjUwIiBzdHlsZT0iZmlsbDojNmE2YTZhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjU2cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+U2Vjb25kIHNsaWRlPC90ZXh0Pjwvc3ZnPg=='; 
                                    ?>
                                    <div class="carousel-inner">

                                        <?php foreach ($popup as $key => $value) { ?>
                                            <div class="item <?php if ($key == 0) echo 'active'; ?>">
                                                <h3 align="center"><?= $value->name; ?></h3>
                                                <img alt="First slide" src="<?= Yii::app()->request->baseUrl; ?>/uploads/popup/<?= $value->id; ?>/<?= $value->pic_file; ?>">
                                                <div align="center">
                                                    <?= $value->detail; ?>
                                                </div>
                                                <p align="center">
                                                    <a class="btn btn-lg btn-primary" href="<?= $value->link; ?>" role="button">
                                                        <?= Yii::app()->session['lang'] == 2 ? ' ไปที่ลิงก์' : 'Go to Link'; ?>
                                                    </a>
                                                </p>
                                            </div>

                                        <?php } ?>

                                    </div>
                                    <a class="left carousel-control" href="#carousel-id2" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                    <a class="right carousel-control" href="#carousel-id2" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php
            }
            //   }
        }
    } ?>
    <?php
    // $rrrr = include_once("analyticstracking.php");
    ?>
</body>

</html>
<!-- Global site tag (gtag.js) - Google Analytics -->