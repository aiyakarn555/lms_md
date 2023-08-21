<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langHeaderId = Yii::app()->session['lang'] = 1;
} else {
    $langHeaderId = Yii::app()->session['lang'];
}

?>
<header id="header" class="main-header fixed-header">
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
            <div class="header-flex ">
                <div class="logo-main">
                    <a class="navbar-brand hidden-xs" href="<?php echo $this->createUrl('/site/index'); ?>">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" height="60px" alt="">
                    </a>
                    <a class="navbar-brand visible-xs" style="width: auto" href="<?php echo $this->createUrl('/site/index'); ?>">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo-xs.png" height="35px" alt="">
                    </a>

                    <span class="menu-push">
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <span class="menu-hide">
                        <i class="fas fa-list-ul"></i>
                    </span>
                </div>

                <div class="menu-header">
                    <?php
                    $langauge = Language::model()->findAllByAttributes(array('status' => 'y', 'active' => 'y'));
                    $currentlangauge = Language::model()->findByPk($langHeaderId);
                    ?>
                    <div class="changelg">
                        <a class="btn dropdown-toggle selectpicker" type="button" data-toggle="dropdown"><img src="<?= Yii::app()->baseUrl . '/uploads/language/' . $currentlangauge->id . '/' . $currentlangauge->image; ?>" height="30px" alt="">
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu changelang">
                            <?php
                            $urlManager = explode("/", Yii::app()->urlManager->parseUrl(Yii::app()->request));
                            $bar = Yii::app()->controller->id;
                            $bar_action = Yii::app()->controller->action->id;
                            foreach ($langauge as $key => $value) { ?>
                                <form action="<?php echo $this->createUrl('Site/Changelanguage') ?>" method="POST" role="form" id='yourFormId<?= $value->id ?>'>
                                    <input type="hidden" name="lang" value="<?= $value->id ?>">

                                    <input type="hidden" name="url" value="<?= $_SERVER['REQUEST_URI'] ?>">

                                    <?php

                                    echo '<li><a onclick="Mychanglang(' . $value->id . ')"  href="javascript:void(0)">
                                        <img src="' . Yii::app()->baseUrl . '/uploads/language/' . $value->id . '/' . $value->image . '" height="30px" alt=""> ' . $value->language . '</a></li>'; ?>

                                </form>
                            <?php }
                            ?>
                        </ul>
                    </div>
                    <script type="text/javascript">
                        function Mychanglang(id) {
                            document.getElementById("yourFormId" + id).submit();

                        }
                    </script>

                    <?php

                    $name = Profile::model()->findByPk(Yii::app()->user->getId());
                    $SettingAll = Helpers::lib()->SetUpSetting();
                    $chk_regis = $SettingAll['ACTIVE_REGIS'];

                    ?>


                    <?php if (Yii::app()->user->id == null) { ?>
                        <div class="mobile-groupbtn">
                            <a class="btn btn-login-index" href="<?php echo $this->createUrl('/site/login'); ?>">
                                <img class="d-img-header" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/user-login.png" alt="">
                                <span class="d-none d-sm-inline">
                                    <?= $langHeaderId == 1 ? "Log On" : "เข้าสู่ระบบ" ?>
                                </span></a></d>
                            <?php if ($chk_regis) { ?>
                                <a class="btn btn-register-index" href='<?php echo $this->createUrl('/registration/index'); ?>'>
                                    <img class="d-img-header" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/user-regis.png" alt="">
                                    <span class="d-none d-sm-inline">
                                        <?= $langHeaderId == 1 ? "Register" : "สมัครสมาชิก" ?>
                                    </span></a></d>
                            <?php } ?>

                        <?php } else { ?>
                            <div class="dropdown user-menu">
                                <?php

                                if (Yii::app()->user->id == null) {
                                    $img  = Yii::app()->theme->baseUrl . "/images/username-icon.png";
                                } else {


                                    if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/users/' . Yii::app()->user->id . '/' . $name->profile_picture)) {
                                        $img = Yii::app()->baseUrl . '/uploads/users/' . Yii::app()->user->id . '/' . $name->profile_picture;
                                    } else {
                                        $img  = Yii::app()->theme->baseUrl . "/images/username-icon.png";
                                    }
                                }
                                ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="height: 100%;">
                                    <span class="photo" style="background-image: url('<?php echo $img ?>"></span>

                                    <span class="hidden-xs">
                                        <?php if ($langHeaderId == 2) {
                                            echo  $name->firstname;
                                        } else {
                                            echo   $name->firstname_en;
                                        }
                                        ?>
                                    </span>
                                    <i class="br-left fas fa-caret-down"></i>
                                </a>


                                <ul class="dropdown-menu dropdown-menu-right">
                                    <?php if (Yii::app()->user->id !== null) { ?>
                                        <?php $url = Yii::app()->createUrl('registration/Update/'); ?>
                                        <a href="<?= $url; ?>" class="text-muted">
                                            <div class="edit-profile">
                                                <span class="photo" style="background-image: url('<?php echo $img ?>"></span>
                                                <span>
                                                    <?php if ($langHeaderId == 2) {
                                                        echo  $name->firstname;
                                                    } else {
                                                        echo   $name->firstname_en;
                                                    }
                                                    ?>
                                                    <br>
                                                    <small><?= $langId == 1 ? "Profile" : "ข้อมูลส่วนตัว" ?></small>
                                                </span>
                                            </div>
                                        </a>
                                        <li class="<?= $bar == 'site' && $bar_action == 'dashboard' ? 'active' : '' ?>">
                                            <a href="<?php echo $this->createUrl('site/dashboard'); ?>"><i class="fas fa-list-ul"></i><?= $langId == 1 ? "Status" : "สถานะการเรียน" ?></a>
                                        </li>
                                        <!-- <li>
                                            <?php $url = Yii::app()->createUrl('virtualclassroom/index'); ?>
                                            <a href="<?= $url ?>"><i class="fas fa-chalkboard-teacher"></i><?= $langId == 1 ? "Classroom" : "ห้องเรียน" ?>
                                            </a>
                                        </li> -->
                                        <li>
                                            <?php $url = Yii::app()->createUrl('course/bookingcourse'); ?>
                                            <a href="<?= $url ?>"><i class="fas fa-chalkboard-teacher"></i><?= $langId == 1 ? "Book a course" : "จองหลักสูตร" ?>
                                            </a>
                                        </li>
                                        <li>
                                            <?php $url = Yii::app()->createUrl('course/courseplan'); ?>
                                            <a href="<?= $url ?>"><i class="far fa-calendar-alt"></i><?= $langId == 1 ? "Course Plan" : "แผนการเรียน" ?>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <li>
                                        <?php
                                        $user = Users::model()->findByPk(Yii::app()->user->id);
                                        if ($user->superuser == 1) { ?>
                                    <li class="br-top">
                                        <?php $url = Yii::app()->createUrl('admin'); ?>
                                        <a href="<?= $url ?>"><i class="fas fa-cog"></i><?= $langId == 1 ? "Setting System" : "ระบบจัดการระบบ" ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li>

                                    <?php $user = Users::model()->findByPk(Yii::app()->user->id); ?>
                                    <a href="<?php echo $this->createUrl('login/logout') ?>" class="text-danger log-out"><i class="fas fa-sign-out-alt"></i><?= $langId == 1 ? "Logout" : "ออกจากระบบ" ?>
                                    </a>
                                </li>
                                </ul>
                            </div>
                        <?php } ?>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        </div>
                </div>
            </div>
    </nav>

    <?php
    if ($langHeaderId == 2) {

        $home = "หน้าแรก";
        $course = "ศึกษาด้วยตนเอง (e-Learning)";
        $vroom = "เรียนรู้ทางไกล (Online)";
        $bookingcourse = "จองหลักสูตร";
        $library = "ห้องสมุดออนไลน์";
        $document = "เอกสารดาวน์โหลด";
        $video = "วิดีโอแนะนำ";
        $new = "ข่าวประชาสัมพันธ์";
        $faq = "คำถามที่พบบ่อย";
        $usa = "วิธีการใช้งาน";
        $contactus = "ติดต่อเรา";
        $txt_course_plan = "แผนการเรียน";

        $searchCertificate = "ค้นหาเลขที่ ปก.";
        $certificateNumber = "เลขที่ ปก.";
        $searchBTN = "ค้นหา";
        $placeHolderCerNum = "กรุณากรอกเลข ปก.";
        $errorCerNum = "กรุณากรอกตัวเลขก่อนกดค้นหา";
        $waitSearchCerNum = "กำลังตรวจสอบข้อมูล , กรุณารอสักครู่";

        $Onlineexam = "ห้องสอบออนไลน์";
        $Onlinebooking = "จองสอบออนไลน์";
    } else {

        $course = "Course";
        $vroom = "Classroom Online";
        $bookingcourse = "BookingCourse";
        $library = "E-Library";
        $document = "Document download";
        $video = "Intro Video";
        $new = "Press Release";
        $faq = "FAQ";
        $usa = "Usability";
        $contactus = "Contact Us";
        $home = "Home";
        $txt_course_plan = "Course Plan";

        $searchCertificate = "Search Certificate";
        $certificateNumber = "Certificate Number";
        $searchBTN = "Search";
        $placeHolderCerNum = "Please fill certificate number.";
        $errorCerNum = "Please fill certificate number,Before click search";
        $waitSearchCerNum = "Wait a minute";

        $Onlineexam = "Online exam room";
        $Onlinebooking = "Online exam booking";
    }
    ?>
    <nav id="menuleft" class="navbar-collapse navbar-ex1-collapse show-menu sidebar-left collapse" role="navigation">
        <div class="menu-nano main-show">
            <ul class="nav menu-active">
                <!--new -->
                <li class="<?= $bar == 'course'  && ($bar_action == 'bookingdetail' || $bar_action == 'bookingcourse')  ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/course/bookingcourse'); ?>" class=""><i class="fas fa-home"></i><span> <?= $home ?></span></a></li>
                <!--new -->
                <!-- <li class="<?= $bar == 'site' && $bar_action == 'index' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/site/index'); ?>" class=""><i class="fas fa-home"></i> <span><?= $home ?></span></a></li> -->
                <!-- <li class="<?= $bar == 'course' && ($bar_action != 'bookingdetail' && $bar_action != 'bookingcourse' && $bar_action != 'courseplan') ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/course/index'); ?>" class=""><i class="fas fa-book-open"></i><span> <?= $course ?></span></a></li> -->
                <!-- <li class="<?= $bar == 'virtualclassroom' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/virtualclassroom/index'); ?>" class=""><i class="fa fa-globe" aria-hidden="true"></i> <span><?= $vroom ?></span></a></li> -->
                <!-- <li class="<?= $bar == 'course'  && ($bar_action == 'bookingdetail' || $bar_action == 'bookingcourse')  ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/course/bookingcourse'); ?>" class=""><i class="fas fa-bookmark"></i><span> <?= $bookingcourse ?></span></a></li> -->
                <li class="<?= $bar == 'video'  && $bar_action == 'library' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/video/library'); ?>" class=""><i class="fas fa-book"></i> <span><?= $library ?></span></a></li>
                <li class="<?= $bar == 'course' && $bar_action == 'courseplan' ? 'active' : '' ?>"><a href="<?php echo (Yii::app()->user->id == null ? $urlLogin : $this->createUrl('course/courseplan')) ?>" class=""><i class="fas fa-calendar-alt"></i> <span><?= $txt_course_plan ?></span></a></li>
                <li class="<?= $bar == 'document' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/document/index'); ?>" class=""><i class="fas fa-file-download"></i> <span><?= $document ?></span></a></li>
                <li class="<?= $bar == 'video' && $bar_action == 'index' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/video/index'); ?>" class=""><i class="fas fa-play-circle"></i> <span><?= $video ?></span></a></li>
                <li class="<?= $bar == 'news' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/news/index'); ?>" class=""><i class="fas fa-newspaper"></i> <span> <?= $new ?></span></a></li>
                <li class="<?= $bar == 'faq' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/faq/index'); ?>" class=""><i class="fas fa-comments"></i> <span><?= $faq ?></span></a></li>
                <li class="<?= $bar == 'usability' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/usability/index'); ?>" class=""><i class="fas fa-exclamation-circle"></i></i><span> <?= $usa ?></span></a></li>
                <li class="<?= $bar == 'about' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/about/index'); ?>" class=""><i class="fas fa-phone-alt"></i> <span><?= $contactus ?></span></a></li>

                <li class="<?= $bar == 'searchCertificate' ? 'active' : '' ?>"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class=""><i class="fas fa-search"></i> <span><?= $searchCertificate ?></span></a></li>


                <!-- <li class="<?= $bar == 'examsonline'  && ($bar_action == 'bookingexamsonline' || $bar_action == 'bookingexamsonline')  ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/examsonline/bookingexamsonline'); ?>" class=""><i class="fas fa-bookmark"></i><span><?= $Onlinebooking ?></span></a></li>
                            <li class="<?= $bar == 'examsonline' ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('/examsonline/index'); ?>" class=""><i class="fa fa-graduation-cap" aria-hidden="true"></i><span><?= $Onlineexam ?></span></a></li> -->



            </ul>

        </div>
    </nav>



</header>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= $searchCertificate ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="course_codenum"><?= $certificateNumber ?></label>
                    <input type="text" class="form-control" id="course_codenum" placeholder="<?= $placeHolderCerNum ?>">
                    <small id="error_course_codenum" style="display:none;" class="text-danger"><?= $errorCerNum ?></small>
                </div>
                <a href="javascript:void(0)" id="submit_search_codenum" class="btn btn-primary"><i class="fas fa-search"></i><?= $searchBTN ?></a>
                <hr>
                <div id="result-table-search" class="table-responsive">

                </div>
            </div>
            <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> -->
        </div>
    </div>
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#submit_search_codenum").click(function() {
            $("#result-table-search").html("<?= $waitSearchCerNum ?>")
            $("#error_course_codenum").hide();
            if ($("#course_codenum").val() != "") {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/report/SearchCodenum"); ?>',
                    data: ({
                        course_codenum: $("#course_codenum").val(),
                    }),
                    success: function(data) {
                        if (data != "") {
                            $("#result-table-search").html(data)
                        } else {
                            $("#result-table-search").html("ไม่พบข้อมูล")
                        }
                    }
                });
            } else {
                $("#error_course_codenum").show();
                $("#result-table-search").html("");
            }
        });
    });
</script>