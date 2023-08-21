<?php $keyrecaptcha = '6LdxRgocAAAAADrcEFCe2HcHeETOZdREexT52B6R'; ?>
<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>

<header id="header" class="main-header">

    <div class="header-left">
        <nav class="main-header-left"></nav>
        <nav class="header-right main-header-right"></nav>
    </div>


    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php
                if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                    $langId = Yii::app()->session['lang'] = 1;
                } else {
                    $langId = Yii::app()->session['lang'];
                }
                $label = MenuSite::model()->findByPk(array('lang_id' => $langId));
                if (!$label) {
                    $label = MenuSite::model()->findByPk(array('lang_id' => 1));
                }
                ?>
                <?php if (Yii::app()->user->id !== null) { ?>
                    <?php
                    $name = Profile::model()->findByPk(Yii::app()->user->getId());
                    $criteria1 = new CDbCriteria;
                    $criteria1->addCondition('create_by =' . $name->user_id);
                    $criteria1->order = 'update_date  ASC';
                    $criteria1->compare('status_answer', 1);
                    $PrivatemessageReturn = PrivateMessageReturn::model()->findAll($criteria1);
                    ?>
                    <div class="dropdown pull-right visible-xs visible-sm" style="margin: 25px 5px;">
                        <a href="#" class="dropdown-toggle" id="user-message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color: white"><i class="fa fa-envelope"></i></a>
                        <div class="dropdown-menu user-message" style="width: 235px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="pull-right"><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span><?= $label->label_header_msg  ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <?php for ($i = 0; $i <= 3; $i++) { ?>
                                        <?php if (!empty($PrivatemessageReturn[$i]->pmr_return)) { ?>
                                            <li>
                                                <span class="pull-right">
                                                    <?php echo $PrivatemessageReturn[$i]->update_date; ?>
                                                </span>
                                                <a href="<?php echo $this->createUrl('/privatemessage/index'); ?>">
                                                    <span class="img-send" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/user.png);">
                                                    </span>
                                                    <?php echo $PrivatemessageReturn[$i]->pmr_return; ?>
                                                </a>
                                            </li>
                                        <?php }
                                    } ?>

                                </ul>
                            </div>

                            <div class="panel-footer">
                                <a href="#" class="text-center"><?= $label->label_header_msgAll  ?></a>
                            </div>
                        </div>
                    </div>

                </div>
            <?php } else {
            } ?>
            <a class="navbar-brand hidden-xs" href="<?php echo $this->createUrl('/site/index'); ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" height="60px" alt=""></a>
            <a class="navbar-brand visible-xs" style="width: auto" href="<?php echo $this->createUrl('/site/index'); ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo-xs.png" height="35px" alt=""></a>
        </div>
        <div class="menu-header ">
            <?php
            $langauge = Language::model()->findAllByAttributes(array('status' => 'y', 'active' => 'y'));
            $currentlangauge = Language::model()->findByPk(Yii::app()->session['lang']);
            ?>
            <div class="changelg">
                <a class="btn dropdown-toggle selectpicker" type="button" data-toggle="dropdown"><img src="<?= Yii::app()->baseUrl . '/uploads/language/' . $currentlangauge->id . '/' . $currentlangauge->image; ?>" height="30px" alt="">
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu changelang">
                        <?php
                        foreach ($langauge as $key => $value) {
                            echo '<li><a href="?lang=' . $value->id . '"><img src="' . Yii::app()->baseUrl . '/uploads/language/' . $value->id . '/' . $value->image . '" height="30px" alt=""> '.$value->language.'</a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <?php $name = Profile::model()->findByPk(Yii::app()->user->getId()); ?>
                <?php if (Yii::app()->user->id == null) { ?>
                    <div>
                        <a class="btn-login" data-toggle="modal"  data-target="#modal-login">
                        <!-- <a class="btn-login " data-toggle="modal" href='https://login.microsoftonline.com/common/oauth2/authorize?client_id=2240fcc5-2667-4335-baff-3c8ebd602f1b&scope=openid+offline_access+group.read.all&redirect_uri=https://learn.ascendcorp.com/site/auth&response_type=code'> -->
                            <span class="d-none d-sm-inline"> <?= $label->label_header_login ?></span></a></d>
                        <?php } else { ?>
                            <div class="dropdown user-menu">
                                <?php

                                if (Yii::app()->user->id == null) {

                                    $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                } else {
                                    $criteria = new CDbCriteria;
                                    $criteria->addCondition('id =' . Yii::app()->user->id);
                                    $Users = Users::model()->findAll($criteria);
                                    foreach ($Users as $key => $value) {
                                        $img = Yii::app()->baseUrl . '/uploads/user/' . $value->id . '/thumb/' . $value->pic_user;
                                    }
                                }
                                ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="height: 100%;">
                                    <!-- <span class="photo" style="background-image: url('<?= $img ?>"></span> -->
                                    <span class="photo" style="background-image: url('<?php echo Yii::app()->theme->baseUrl; ?>/images/username-icon.png"></span>
                                    <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/username-icon.png" class="profile-account" alt=""> -->
                                    <?php if (Yii::app()->session['lang'] == 1) {
                                        echo  $name->firstname_en;
                                    } else {
                                        echo   $name->firstname;
                                    }
                                    ?>
                                    <i class="br-left las la-bars"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if (Yii::app()->user->id !== null) { ?>
                                        <li class="<?= $bar == 'site' && $bar_action == 'dashboard' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/site/dashboard'); ?>"><i class="fas fa-list-ul"></i><?= $label->label_header_dashboard ?></a></li>
                                    <?php } ?>

                                    <li>
                                        <?php
                                        $user = Users::model()->findByPk(Yii::app()->user->id);
                                        if ($user->type_register != 3) { ?>
                                            <li>
                                                <?php $url = Yii::app()->createUrl('registration/Update/'); ?>
                                                <a href="<?= $url ?>"><i class="fas fa-edit"></i><?= $label->label_header_update ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($user->superuser == 1) { ?>
                                            <li>
                                                <?php $url = Yii::app()->createUrl('admin'); ?>
                                                <a href="<?= $url ?>"><i class="fas fa-cog"></i><?= UserModule::t("backend"); ?></a>
                                            </li>
                                        <?php } ?>
                                        <li>
                                <!-- <a href="<?php //echo $this->createUrl('login/logout') 
                            ?>"> --><a href="javascript:void(0)" class="text-danger log-out" onclick="logout()"><i class="fas fa-sign-out-alt"></i><?= $label->label_header_logout ?></a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>

</nav>
<!--navbar navbar-inverse2 -->
<nav class="collapse navbar-collapse navbar-ex1-collapse navbar-inverse2 border-inverse2" role="navigation">
    <div class="container">
        <ul class="nav navbar-nav menu-active">
            <?php $bar = Yii::app()->controller->id ?>
            <?php $bar_action = Yii::app()->controller->action->id;
            if (Yii::app()->user->id == null) {
                $mainMenu = MainMenu::model()->findAllByAttributes(array('status' => 'y', 'active' => 'y', 'lang_id' => Yii::app()->session['lang']));
                if (!$mainMenu) {
                    $mainMenu = MainMenu::model()->findAllByAttributes(array('status' => 'y', 'active' => 'y', 'lang_id' => 1));
                }
                foreach ($mainMenu as $key => $value) {
                    $url = !empty($value->parent) ? $value->parent->url : $value->url;
                    $controller = explode('/', $url);
                    $controller[0] = strtolower($controller[0]);
                    if ($controller[0] != "registration" && $controller[0] != "privatemessage" && $controller[0] != "search" && $controller[0] != "forgot_password" && $controller[0] != "question" && $controller[0] != "virtualclassroom" && $controller[0] != "video") {
                        $clss =  $bar == $controller[0] && $bar_action == "index" ? "active" : '';
                        if ($controller[0] != "webboard") {
                            if ($controller[0] == "course" && Yii::app()->user->id == null) {
                                echo '<li class="' . $clss . '">

                                <a data-toggle="modal" class="btn-login-course" data-target="#modal-login" >' . $value->title . '</span></a>
                                </li>';
                                //<a data-toggle="modal" class="btn-login-course" href="https://login.microsoftonline.com/common/oauth2/authorize?client_id=2240fcc5-2667-4335-baff-3c8ebd602f1b&scope=openid+offline_access+group.read.all&redirect_uri=https://learn.ascendcorp.com/site/auth&response_type=code" >' . $value->title . '</span></a>
                            } else {
                                echo '<li class="' . $clss . '">
                                <a href="' . $this->createUrl($url) . '">' . $value->title . '</span></a>
                                </li>';
                            }
                        } else {
                            echo '<li class="' . $clss . '">
                            <a href="' . $this->createUrl($url) . '?lang=' . Yii::app()->session['lang'] . '">' . $value->title . '</span></a>
                            </li>';
                        }
                    }
                }
            } else {
                $mainMenu = MainMenu::model()->findAllByAttributes(array('status' => 'y', 'active' => 'y', 'lang_id' => Yii::app()->session['lang']));
                if (!$mainMenu) {
                    $mainMenu = MainMenu::model()->findAllByAttributes(array('status' => 'y', 'active' => 'y', 'lang_id' => 1));
                }

                $Profile_model = Profile::model()->findByPk(Yii::app()->user->id);

                foreach ($mainMenu as $key => $value) {
                    $url = !empty($value->parent) ? $value->parent->url : $value->url;
                    $controller = explode('/', $url);
                    $controller[0] = strtolower($controller[0]);
                    if ($controller[0] != "registration" && $controller[0] != "privatemessage" && $controller[0] != "search" && $controller[0] != "forgot_password" && $controller[0] != "question") {
                        $clss =  $bar == $controller[0] && $bar_action == "index" ? "active" : '';
                        if ($controller[0] != "webboard") {
                            if ($controller[0] == "course" && Yii::app()->user->id == null) {
                                echo '<li class="' . $clss . '">
                                <a data-toggle="modal" class="btn-login-course" data-target="#modal-login">' . $value->title . '</span></a>
                                </li>';
                                //<a data-toggle="modal" class="btn-login-course" href="https://login.microsoftonline.com/common/oauth2/authorize?client_id=2240fcc5-2667-4335-baff-3c8ebd602f1b&scope=openid+offline_access+group.read.all&redirect_uri=https://learn.ascendcorp.com/site/auth&response_type=code" >' . $value->title . '</span></a>
                            } 
                            else {
                                echo '<li class="' . $clss . '">
                                <a href="' . $this->createUrl($url) . '">' . $value->title . '</span></a>
                                </li>';
                            }
                        } else {
                            echo '<li class="' . $clss . '">
                            <a href="' . $this->createUrl($url) . '?lang=' . Yii::app()->session['lang'] . '">' . $value->title . '</span></a>
                            </li>';
                        }
                    }
                }
            }
            ?>

            <?php
            $key = "DR6564UFP5858BU58448HYYGYCFRVTVYBHCFCGHJ";
            if ($key) {
                ?>
                    <!-- <li class="">
                        <a href="<?= $this->createUrl("dashboard/terms") ?>">
                            <?php
                            if (Yii::app()->session['lang'] == 1) {
                                echo "Terms & Conditions";
                            } else {
                                echo "ข้อกำหนด & เงื่อนไข";
                            }
                            ?>
                        </a>
                    </li> -->
                <?php }

                if (Yii::app()->user->id) {
                    $user_login = User::model()->findByPk(Yii::app()->user->id);
                    $authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 
                    if ($authority == 1 || $authority == 2 || $authority == 3) {
                        ?>
                        <!-- <li class="">
                            <a href="<?= $this->createUrl("report/index") ?>">
                                <?php
                                if (Yii::app()->session['lang'] == 1) {
                                    echo "Report";
                                } else {
                                    echo "รายงาน";
                                }
                                ?>

                            </a>
                        </li> -->
                    <?php }
                } ?>




                <?php
                if (Yii::app()->user->id == null) {
                    $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
                    $chk_status_reg = $SettingAll['ACTIVE_REGIS'];
                    if ($chk_status_reg) {
                        ?>
                        <!-- <li><a class="btn-register" href="<?php echo $this->createUrl('/registration/ShowForm'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?= $label->label_header_regis ?></a></li> -->
                    <?php }
                } ?>

                <?php if (Yii::app()->user->id !== null) { ?>
                    <?php
                    // $name = Profile::model()->findByPk(Yii::app()->user->getId());

                    // $criteria = new CDbCriteria;
                    // $criteria->addCondition('create_by =' . $name->user_id);
                    // $criteria->order = 'update_date  ASC';
                    // $criteria->compare('status_answer', 1);
                    // $PrivatemessageReturn = PrivateMessageReturn::model()->findAll($criteria);
                    ?>
                    <!-- <li class="dropdown visible-md visible-lg">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="height: 100%;"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                        <div class="dropdown-menu user-message">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="pull-right"><a href="#"></a></span><?= $label->label_header_msg ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <?php for ($i = 0; $i <= 3; $i++) { ?>
                                        <?php if (!empty($PrivatemessageReturn[$i]->pmr_return)) {
                                        ?>
                                            <li>
                                                <span class="pull-right">
                                                    <?php echo $PrivatemessageReturn[$i]->update_date; ?>
                                                </span>
                                                <a href="<?php echo $this->createUrl('/privatemessage/index', array('id' => $PrivatemessageReturn[$i]->pm_id)); ?>">
                                                    <span class="img-send" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/user.png);">
                                                    </span>
                                                    <?php echo $PrivatemessageReturn[$i]->pmr_return; ?>
                                                </a>
                                            </li>
                                        <?php }
                                    } ?>

                                </ul>
                            </div>
                            <div class="panel-footer">
                                <a href="<?php echo $this->createUrl('/privatemessage/index'); ?>" class="text-center"><?= $label->label_header_msgAll ?></a>
                            </div>
                        </div>
                    </div>
                </li> -->

            <?php } else {
            } ?>
        </ul>
            <!-- <div class="box-search">
                <form id="searchForm" class="navbar-form" action="<?php echo $this->createUrl('Search/index') ?>">
                    <div class="simple-search input-group">
                        <input type="text" class="form-control" name="text" placeholder='<?= $label->label_placeholder_search ?>'>
                        <button class="btn" type="submit">
                            <i class="fas fa-search header-nav-top-icon"></i>
                        </button>
                    </div>
                </form>
            </div> -->
        </div>
    </div>

</header>

<!-- google login -->
<script src="https://apis.google.com/js/api:client.js"></script>
<script>
    var googleUser = {};
    var startApp = function() {
        gapi.load('auth2', function() {
            auth2 = gapi.auth2.init({
                client_id: '1064112749813-6gko5159s9sbkkva1jppnfsrbou43tgo.apps.googleusercontent.com',
                cookiepolicy: 'single_host_origin',
            });
            attachSignin(document.getElementById('customBtn'));
        });
    };

    function attachSignin(element) {
        auth2.attachClickHandler(element, {},
            function(googleUser) {
                onGoogleSignIn(googleUser);
            });
    }
</script>
<script type="text/javascript">
    // var tr = "<?= Yii::app()->createUrl('registration/Report_problem'); ?>";
    // $('.modal-body').load(tr);
</script>
<script>
    function onGoogleSignIn(googleUser) {
        var response = googleUser.getAuthResponse(true);
        console.log(response);
        var accessToken = response.access_token;
        $.ajax({
            type: "POST",
            url: "<?= Yii::app()->createUrl('login/LoginGoogle') ?>",
            dataType: "json",
            data: {
                token: accessToken
                //google: googleUser.getBasicProfile()
            },
            success: function(result) {
                $('#modal-login').modal('hide');

                if (result.result == true) {
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: result.msg,
                        showConfirmButton: true,
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            location.reload();
                        }
                    });
                } else {
                    swal({
                        position: 'top-end',
                        type: 'warning',
                        title: result.msg,
                        showConfirmButton: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            location.reload();
                        }
                    });
                }
            }
        });
    }

    function logout() {
        gapi.auth2.getAuthInstance().disconnect();
        window.location.href = "<?= $this->createUrl('login/logout'); ?>";
    }
</script>
<script>
    startApp();
</script>

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

<div class="modal fade" id="modal-login">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $this->createUrl('login/index') ?>" method="POST" role="form" name='loginform'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-lock" aria-hidden="true"></i> <?= $label->label_header_login ?></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-xs-12">
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
                                <label for=""><?= $label->label_header_username ?></label>
                                <input type="text" class="form-control" placeholder='<?= $label->label_header_username ?>' name="UserLogin[username]" value="<?php echo Yii::app()->request->cookies['cookie_name']->value; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for=""><?= $label->label_header_password ?></label>
                                <input type="password" class="form-control" placeholder='<?= $label->label_header_password ?>' name="UserLogin[password]" required>
                            </div>
                            <div class="form-group" style="display: flex">
                                <!-- <div class="checkbox checkbox-info checkbox-circle"> -->
                                <!-- <input id="checkbox1" type="checkbox" name="UserLogin[checkbox]" value="on">
                                    <label for="checkbox1">
                                        <?= $label->label_header_remember ?>
                                    </label>
                                    <?php $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
                                    $chk_status_reg = $SettingAll['ACTIVE_REGIS'];
                                    if ($chk_status_reg) {
                                    ?> -->
                                    <div class="cap" style="width: 100%">

                                        <span class="pull-right">
                                            <a class="btn-forgot" href="<?php echo $this->createUrl('Forgot_password/index') ?>"><?= $label->label_header_forgotPass ?></a>
                                            <!-- <a href="< ?php echo $this->createUrl('/registration/ShowForm'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?= $label->label_header_regis ?></a> -->
                                        </span>
                                    </div>


                                    <!-- <?php } ?> -->

                                    <!-- </div> -->

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2 col-xs-12">
                                <button type="submit" class="btn btn-submit submit-login" id="submit" name="submit"><?= $label->label_header_yes ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="modal fade" id="user-report">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo $this->createUrl('/ReportProblem/ReportProblem'); ?>" method="POST" role="form" name='user-report' enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;<?= Yii::app()->session['lang'] == 2 ? 'แจ้งปัญหาการใช้งาน' : 'Report a problem'; ?> </h4>
                    </div>
                    <?php if (Yii::app()->user->id !== null) {
                        $criteria = new CDbCriteria;
                        $criteria->addCondition('user_id =' . Yii::app()->user->id);
                        $Profile = Profile::model()->findAll($criteria);
                        foreach ($Profile as $key => $value) {
                            ?>
                            <div class="modal-body">
                                <div class="row report-row">
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <label for=""><?= Yii::app()->session['lang'] == 2 ? 'ชื่อ' : 'Name'; ?></label>
                                        <input type="text" class="form-control" placeholder="<?= Yii::app()->session['lang'] == 2 ? 'ชื่อ' : 'Name'; ?>" name="ReportProblem[firstname]" value="<?php if (Yii::app()->session['lang'] == 2) {
                                            echo $value->firstname;
                                            } else {
                                                echo $value->firstname_en;
                                            } ?>">
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Last name' : 'นามสกุล'; ?></label>
                                            <input type="text" class="form-control" placeholder="<?= Yii::app()->session['lang'] == 1 ? 'Last name' : 'นามสกุล'; ?>" name="ReportProblem[lastname]" value="<?php if (Yii::app()->session['lang'] == 1) {
                                                echo $value->lastname_en;
                                                } else {
                                                    echo $value->lastname;
                                                } ?>">
                                            </div>
                                        </div>
                                        <?php }
                                        $criteria = new CDbCriteria;
                                        $criteria->addCondition('user_id =' . Yii::app()->user->id);
                                        $Users = Users::model()->findAll($criteria);
                                        foreach ($Users as $key => $value) {
                                            ?>
                                            <div class="col-md-6 col-xs-12 col-sm-6">
                                                <label for=""><?= Yii::app()->session['lang'] == 1 ? 'email' : 'อีเมล์'; ?></label>
                                                <input type="text" class="form-control" placeholder="<?= Yii::app()->session['lang'] == 1 ? 'email' : 'อีเมล์'; ?>" name="ReportProblem[email]" value="<?php echo $value->email; ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row report-row">
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Problem type' : 'ประเภทปัญหา'; ?></label>
                                            <select class="form-control d-inlineblock " name="ReportProblem[report_type]">
                                                <option value=""><?= Yii::app()->session['lang'] == 1 ? 'Problem type' : 'ไม่ระบุประเภท'; ?></option>
                                                <?php
                                                $criteria = new CDbCriteria;
                                                $criteria->addCondition('active ="y"');
                                                $criteria->addCondition('lang_id = 1');
                                                $Usability = Usability::model()->findAll($criteria);
                                                foreach ($Usability as $key => $value) {

                                                    ?>
                                                    <option value="<?php echo $value->usa_id; ?>"><?php echo $value->usa_title; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Course' : 'หลักสูตร'; ?></label>
                                            <select class="form-control d-inlineblock " name="ReportProblem[report_course]">
                                                <option value=""><?= Yii::app()->session['lang'] == 1 ? 'No course specified' : 'ไม่ระบุหลักสูตร'; ?></option>
                                                <?php
                                                $criteria = new CDbCriteria;
                                                $criteria->addCondition('active ="y"');
                                                $criteria->addCondition('lang_id = 1');
                                                $CourseOnline = CourseOnline::model()->findAll($criteria);
                                                foreach ($CourseOnline as $key => $value) {

                                                    ?>
                                                    <option value="<?php echo $value->course_id; ?>"><?php echo $value->course_title; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row report-row">
                                        <div class="col-md-12 col-xs-12">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'The message' : 'ข้อความ'; ?></label>
                                            <textarea name="ReportProblem[report_detail]" class="form-control" placeholder="<?php echo Yii::app()->session['lang'] == 1 ? 'Type your message in this box.' : 'พิมพ์ข้อความในช่องนี้'; ?>" id="" cols="30" rows="6"></textarea>
                                        </div>
                                    </div>


                                    <div class="row report-row">
                                        <div class="col-md-6 col-xs-12">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Upload photo' : 'อัปโหลดรูปภาพ'; ?></label>
                                            <input type="file" class="form-control" name="ReportProblem[report_pic]">
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="text-center"> <button type="submit" class="btn btn-submit btn-report" name=""><?= Yii::app()->session['lang'] == 1 ? 'Confirm' : 'ยืนยัน'; ?></button></div>
                                </div>
                            <?php } else { ?>
                                <div class="modal-body">
                                    <div class="row report-row">
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Name' : 'ชื่อ'; ?></label>
                                            <input type="text" class="form-control" placeholder="<?= Yii::app()->session['lang'] == 1 ? 'Name' : 'ชื่อ'; ?>" name="ReportProblem[firstname]">
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Last name' : 'นามสกุล'; ?></label>
                                            <input type="text" class="form-control" placeholder="<?= Yii::app()->session['lang'] == 1 ? 'Last name' : 'นามสกุล'; ?>" name="ReportProblem[lastname]">
                                        </div>
                                    </div>
                                    <div class="row report-row">
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Phone number' : 'เบอร์โทรศัพท์'; ?></label>
                                            <input type="text" class="form-control" placeholder="<?= Yii::app()->session['lang'] == 1 ? 'Phone number' : 'เบอร์โทรศัพท์'; ?>" name="ReportProblem[tel]">
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'email' : 'อีเมล์'; ?></label>
                                            <input type="text" class="form-control" placeholder="<?= Yii::app()->session['lang'] == 1 ? 'email' : 'อีเมล์'; ?>" name="ReportProblem[email]">
                                        </div>
                                    </div>

                                    <div class="row report-row">
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Problem type' : 'ประเภทปัญหา'; ?></label>
                                            <select class="form-control d-inlineblock " name="ReportProblem[report_type]">
                                                <option value=""><?= Yii::app()->session['lang'] == 1 ? 'Problem type' : 'ไม่ระบุประเภท'; ?></option>
                                                <?php
                                                $criteria = new CDbCriteria;
                                                $criteria->addCondition('active ="y"');
                                                $criteria->addCondition('lang_id =1');
                                                $Usability = Usability::model()->findAll($criteria);
                                                foreach ($Usability as $key => $value) {

                                                    ?>
                                                    <option value="<?php echo $value->usa_id; ?>"><?php echo $value->usa_title; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Course' : 'หลักสูตร'; ?></label>
                                            <select class="form-control d-inlineblock " name="ReportProblem[report_course]">
                                                <option value=""><?= Yii::app()->session['lang'] == 1 ? 'No course specified' : 'ไม่ระบุหลักสูตร'; ?></option>
                                                <?php
                                                $criteria = new CDbCriteria;
                                                $criteria->addCondition('active ="y"');
                                                $criteria->addCondition('lang_id =1');
                                                $CourseOnline = CourseOnline::model()->findAll($criteria);
                                                foreach ($CourseOnline as $key => $value) {

                                                    ?>
                                                    <option value="<?php echo $value->course_id; ?>"><?php echo $value->course_title; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row report-row">
                                        <div class="col-md-12 col-xs-12">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'The message' : 'ข้อความ'; ?></label>
                                            <textarea name="ReportProblem[report_detail]" class="form-control" placeholder="<?php echo Yii::app()->session['lang'] == 1 ? 'Type your message in this box.' : 'พิมพ์ข้อความในช่องนี้'; ?>" id="" cols="30" rows="6"></textarea>
                                        </div>
                                    </div>


                                    <div class="row report-row">
                                        <div class="col-md-6 col-xs-12">
                                            <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Upload photo' : 'อัปโหลดรูปภาพ'; ?></label>
                                            <input type="file" class="form-control" name="ReportProblem[report_pic]">
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="text-center"> <button type="submit" class="btn btn-submit btn-report" name=""><?= Yii::app()->session['lang'] == 1 ? 'Confirm' : 'ยืนยัน'; ?></button></div>
                                </div>
                            <?php } ?>
                            <div class="modal-footer">
                            </div>
                        </form>
                    </div>
                </div>
            </div>