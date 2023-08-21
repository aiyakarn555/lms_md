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

<style>
    header,
    footer {
        display: none;
    }

    body {
        background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-login.png);
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        background-repeat: repeat;
        background-color: rgba(243, 243, 243, 1);
    }

    .main-content {
        margin: 0 !important;
    }
</style>

<div id="loader">
    <div class="spinner">
        <div class="dot1"></div>
        <div class="dot2"></div>
    </div>
</div>
<div class="form login-section">
  
    <form action="<?php echo $this->createUrl('login/index') ?>" method="POST" role="form" name='loginform'>

        <div class="row d-flex justify-content-center ">
            <div class="col-sm-6 col-md-5 col-lg-5 col-xs-12">
                <div class="login-page">
                    <div class="text-center mb-2">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" alt="">
                        <h3 class="mt-1"><?= $langId == 1 ? "Sign in" : "เข้าสู่ระบบ" ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-sm-12">
                            <?php
                            if (!empty($_GET['error'])) {
                                if (!empty($_GET['error']['status'])) {
                                    $error = $_GET['error']['status'][0];
                                } else if (!empty($_GET['error']['username'])) {
                                    $error = $_GET['error']['username'][0];
                                } else if (!empty($_GET['error']['password'])) {
                                    $error = $_GET['error']['password'][0];
                                }
                            ?>
                                <script>
                                    $(document).ready(function() {
                                        window.history.replaceState({}, 'error', '<?= $this->createUrl('site/index') ?>');
                                    });
                                </script>
                                <div class="form-group">
                                    <label for="" style="color: red"><?= $error ?></label>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <div class="floating-label">
                                    <input type="text" class="form-control" autocomplete="off" placeholder='<?= $langId == 1 ? "Identification Number" : "หมายเลขบัตรประจำตัวประชาชน" ?>' name="UserLogin[username]"  required>
                                    <label for=""><?= $langId == 1 ? "Identification Number" : "หมายเลขบัตรประจำตัวประชาชน" ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="floating-label">
                                    <input type="password" class="form-control" autocomplete="off" placeholder='<?= $langId == 1 ? "Password" : "รหัสผ่าน" ?>' name="UserLogin[password]" required>
                                    <label for=""><?= $langId == 1 ? "Password" : "รหัสผ่าน" ?></label>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex">
                                <!-- <div class="checkbox checkbox-info checkbox-circle"> -->
                                <!-- <input id="checkbox1" type="checkbox" name="UserLogin[checkbox]" value="on">
                                    <label for="checkbox1">
                                        <?= $label->label_header_remember ?>
                                    </label>-->
                                  
                                <div class="cap" style="width: 100%">

                                    <span class="pull-right">
                                        <a class="btn-forgot" href="<?php echo $this->createUrl('Forgot_password/index') ?>"><?= $langId == 1 ? "Forgot Password ?" : "ลืมรหัสผ่าน" ?></a>
                                        <!-- <a href="< ?php echo $this->createUrl('/registration/ShowForm'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?= $label->label_header_regis ?></a> -->
                                    </span>
                                </div>

                       


                            </div>
                            <button type="submit" class="btn btn-submit" id="submit" name="submit"><?= $langId == 1 ? "Sign in" : "เข้าสู่ระบบ" ?></button>
                            <?php 
                                $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
                                $chk_status_reg = $SettingAll['ACTIVE_REGIS'];
                                if ($chk_status_reg) { ?> 
                                 <div class="text-center text-muted mt-1 mb-1">
                                    <?= $langId == 1 ? "You don't have an account." : "ยังไม่มีบัญชีผู้ใช้งาน" ?>
                                </div>
                                    <a class="btn btn-register" href="<?php echo $this->createUrl('/registration/index'); ?>"><?= $langId == 1 ? "Register" : "สมัครสมาชิก" ?> </a>
                               
                            <?php } ?>

                     
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>

<?php
$msg = Yii::app()->user->getFlash('msg');
$icon = Yii::app()->user->getFlash('icon');
if (!empty($msg)) { ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
            title: "แจ้งเตือน",
            text: "<?= $msg ?>",
            icon: "<?= $icon  ?>",
            dangerMode: true,
        });
    </script>
<?php } ?>