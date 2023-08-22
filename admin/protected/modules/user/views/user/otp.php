<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <html class="ie gt-ie8"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!-- <![endif]-->

<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!-- Meta -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />

    <?php
    $clientScript = Yii::app()->clientScript;
    ////////// CSS //////////
    //Bootstrap
    $clientScript->registerCssFile($this->assetsBase . '/bootstrap/css/bootstrap.css');
    $clientScript->registerCssFile($this->assetsBase . '/bootstrap/css/responsive.css');
    //Glyphicons Font Icons
    $clientScript->registerCssFile($this->assetsBase . '/theme/css/glyphicons.css');
    //Main Theme Stylesheet :: CSS
    $clientScript->registerCssFile($this->assetsBase . '/theme/css/style.min.css');
    $clientScript->registerCssFile($this->assetsBase . '/sweetalert/dist/sweetalert.css');
    ////////// JS //////////
    //JQuery
    $clientScript->registerScriptFile($this->assetsBase . '/theme/scripts/plugins/system/jquery.min.js', CClientScript::POS_END);
    //JQueryUI
    $clientScript->registerScriptFile($this->assetsBase . '/theme/scripts/plugins/system/jquery-ui/js/jquery-ui-1.9.2.custom.min.js', CClientScript::POS_END);
    //JQueryUI Touch Punch
    $clientScript->registerScriptFile($this->assetsBase . '/theme/scripts/plugins/system/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js', CClientScript::POS_END);
    //Modernizr
    $clientScript->registerScriptFile($this->assetsBase . '/theme/scripts/plugins/system/modernizr.js', CClientScript::POS_END);
    //Bootstrap
    $clientScript->registerScriptFile($this->assetsBase . '/bootstrap/js/bootstrap.min.js', CClientScript::POS_END);
    //SlimScroll Plugin
    $clientScript->registerScriptFile($this->assetsBase . '/theme/scripts/plugins/other/jquery-slimScroll/jquery.slimscroll.min.js', CClientScript::POS_END);
    //Common Demo Script
    $clientScript->registerScriptFile($this->assetsBase . '/theme/scripts/demo/common.js', CClientScript::POS_END);
    //Holder Plugin
    $clientScript->registerScriptFile($this->assetsBase . '/theme/scripts/plugins/other/holder/holder.js', CClientScript::POS_END);
    //Uniform Forms Plugin
    $clientScript->registerScriptFile($this->assetsBase . '/theme/scripts/plugins/forms/pixelmatrix-uniform/jquery.uniform.min.js', CClientScript::POS_END);
    //$clientScript->registerScript('basePath', "var basePath = '';");
    //
    //Sweet ALert
    $clientScript->registerScriptFile($this->assetsBase . '/sweetalert/dist/sweetalert.min.js', CClientScript::POS_END);
    ?>

    <style>
        body.login {
            background: none;
            position: relative !important;
            height: 100vh
        }

        .bg-top {
            position: absolute;
            top: 0;
            left: 0;
        }

        .bg-bottom {
            position: absolute;
            right: 0;
            bottom: 0;
        }

        @media (max-width:768px) {
            .bg-bottom{
                display: none;
            }

        }

        body.login #login .form-signin {
            position: relative;
            max-width: 500px;
            margin: 0 auto 20px;
            padding: 3em 1em;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 5px;
        }
        .form-control{
            background: #F8F8F8 !important;
            height: 45px !important;
            border-radius: 4px !important;
            max-width: 100%;
        }

        .btn-signin{
            width: 100%;
            padding: 12px;
            font-size: 16px;
        }
        .inner{
            margin-top: 1rem;
        }
        
    </style>
</head>

<body class="login">
    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/admin-login-1.png" alt="" class="bg-top">
    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/admin-login-2.png" alt="" class="bg-bottom">
    <?php
    $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login");
    $this->breadcrumbs = array(UserModule::t("Login"));
    ?>
    <!-- Wrapper -->
    <div id="login">
        <!-- Box -->
        <div class="form-signin">
            <!-- <h3>Sign in to Your Account</h3> -->
            <!-- Row -->
            <div class="text-center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo-login.png" alt=""></div>
            <div class="row-fluid row-merge">
                <?php echo CHtml::beginForm(); ?>
                <div class="">
                    <div class="inner">
                    <input type="hidden" name="username" value="<?php echo $model->username ?><?php if(isset($username)){ echo $username; } ?>">
                    <input type="hidden" name="password" value="<?php echo $model->password ?><?php if(isset($password)){ echo $password; } ?>">
                    <input type="text" value="" name="otp" class="input-block-level form-control" placeholder="You OTP" required>
                    <?php if (isset($otp)) { ?>
                        <div class="label label-important"><?php echo $otp; ?></div>
                    <?php } ?>
                        <br><br>
                        <div class="row-fluid">
                            <div class=" center">
                                <?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'btn btn-block btn-danger btn-signin')); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo CHtml::endForm(); ?>
            </div>
            <div class="ribbon-wrapper">
                <div class="ribbon danger">Admin</div>
            </div>
        </div>
    </div>
</body>

</html>