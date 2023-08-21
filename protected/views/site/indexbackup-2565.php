<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}
if (Yii::app()->session['lang'] == 2) {
    $flag = false;
    $doc_download = "เอกสารดาวน์โหลด";
    $txt_library = "ห้องสมุดออนไลน์";
    $txt_classroom_online = "ห้องเรียนออนไลน์";
    $txt_course_plan = "แผนการเรียน";
    $txt_course_status = "สถานะหลักสูตร";
    $system_guide_and_others = "คู่มือระบบและอื่นๆ";
    $how_to_use = "วิธีการใช้งาน";
    $sys_eleaning = "ระบบการเรียนรู้";
    $QaA = "คำถามที่พบบ่อย";
    $problem_of_use = "ปัญหาการใช้งาน";
    $Number_of_website_visitors = "จำนวนผู้เข้าชมเว็บไซต์";
    $peple = "ครั้ง";
    $status = "สถานะ";
    $edu = "ยังไม่เรียน";
} else {
    $flag = true;
    $doc_download = "Document download";
    $txt_library = "E-Library";
    $txt_classroom_online = "Classroom Online";
    $txt_course_plan = "Course Plan";
    $txt_course_status = "Course Status";
    $system_guide_and_others = "System guide and others";
    $how_to_use = "How to use";
    $sys_eleaning = "E-Learning system";
    $QaA = "Question and answer";
    $problem_of_use = "Problem of use";
    $Number_of_website_visitors = "Website visitors";
    $peple = "Time";
    $status = "Status";
    $edu = "Not study";
}

?>
<!-- // -->
<?php if (Yii::app()->user->hasFlash('users') && !isset(Yii::app()->user->id)) {  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
                title: "<?= UserModule::t('confirm_regis'); ?> ",
                text: "Email :" + "<?= Yii::app()->user->getFlash('users'); ?>",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // $('#modal-login').modal('show');
                }
            });
    </script>
<?php
    Yii::app()->user->setFlash('profile', null);
    Yii::app()->user->setFlash('users', null);
}
?>

<?php if (Yii::app()->user->hasFlash('updateusers')) {  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
                title: "<?= UserModule::t('update_regis'); ?>",
                text: "Username :" + "<?= Yii::app()->user->getFlash('updateusers'); ?>",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // $('#modal-login').modal('show');
                }
            });
    </script>
<?php
    Yii::app()->user->setFlash('updateusers', null);
}
?>

<?php
$msg = Yii::app()->user->getFlash('msg');
$icon = Yii::app()->user->getFlash('icon');
if (!empty($msg) || !empty($_GET['msg'])) {
    $icon = !empty($icon) ? $icon : 'warning';
?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
            title: "<?= Yii::app()->user->getFlash('title') ?>",
            text: "<?= $msg; ?>",
            icon: "<?= $icon ?>",
            dangerMode: true,
        });
        $(document).ready(function() {
            window.history.replaceState({}, 'msg', '<?= $this->createUrl('site/index') ?>');
        });
    </script>
<?php
    Yii::app()->user->setFlash('title', null);
    Yii::app()->user->setFlash('msg', null);
    Yii::app()->user->setFlash('icon', null);
} ?>

<?php if (Yii::app()->user->id == null) { ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".course_site").attr("href", "JavaScript:void(0)")
            $(".course_site").click(function() {
                swal({
                    title: "<?= UserModule::t('Warning') ?>",
                    text: "<?= UserModule::t('regis_first') ?>",
                    icon: "warning",
                    dangerMode: true,
                }).then(function() {
                    $('#modal-login').modal('show');
                });

            });
        });
    </script>
<?php } ?>

<section class="banner-index">
    <div class="swiper" id="banner-main">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner-main.png" alt="" class="w-100">
            </div>
            <div class="swiper-slide">
                <img src="//via.placeholder.com/1149x467" alt="" class="w-100">
            </div>
            <div class="swiper-slide">
                <img src="//via.placeholder.com/1149x467" alt="" class="w-100">
            </div>
        </div>
        <div class="swiper-pagination"></div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <div class="swiper-scrollbar"></div>
    </div>
    <script>
        const swiper = new Swiper('#banner-main', {
            direction: 'horizontal',
            loop: true,

            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        });
    </script>

    <!-- <div id="carousel-id" class="banner-slide carousel slide main-slide" data-ride="carousel" data-interval="10000">

        <ol class="carousel-indicators">

            <?php if (!isset($image[0])) { ?>
                <li data-target="#carousel-id" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-id" data-slide-to="1" class=""></li>
                <li data-target="#carousel-i d" data-slide-to="2" class=""></li>
                <?php } else {
                foreach ($image as $key => $value) {
                ?>
                    <li data-target="#carousel-id" data-slide-to="<?= $key; ?>" class="<?php if ($key == 0) echo 'active'; ?>"></li>

            <?php
                }
            }
            ?>
        </ol>
        <?php
        $criteriaimg = new CDbCriteria;
        $criteriaimg->compare('active', 'y');
        $criteriaimg->compare('lang_id', Yii::app()->session['lang']);
        $criteriaimg->order = 'update_date  DESC';
        $image = Imgslide::model()->findAll($criteriaimg);
        ?>

        <div class="carousel-inner">
            <?php if (!empty($image)) {
                foreach ($image as $keyimage => $valueimage) {
                    if ($keyimage == 0) {
                        $active_image = "active";
                    } else {
                        $active_image = "";
                    }
                    if ($valueimage->imgslide_link != null) {
                        $link_image = $valueimage->imgslide_link;
                        $target = "target='_blank'";
                    } else {
                        $link_image = "javascript:void(0)";
                        $target = "";
                    }
            ?>
                    <div class="item <?= $active_image ?>">
                        <a href="<?= $link_image ?>" <?= $target ?>>
                            <img class="img-slide-show" src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/imgslide/<?= $valueimage->imgslide_id; ?>/<?= $valueimage->imgslide_picture; ?>" width="100%">
                        </a>
                    </div>
                <?php }
            } else { ?>
                <div class="item active">
                    <img class="img-slide-show" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner-01.png" width="100%">
                </div>
                <div class="item">
                    <img class="img-slide-show" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner-01.png" width="100%">
                </div>
                <div class="item">
                    <img class="img-slide-show" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner-01.png" width="100%">
                </div>
            <?php } ?>

        </div>
        <a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div> -->

    <!-- <div id="my-pics" class="carousel slide" data-ride="carousel" data-interval="9000" style="width:300px;margin:auto;">
        <ol class="carousel-indicators">
            <li data-target="#my-pics" data-slide-to="0" class="active"></li>
            <li data-target="#my-pics" data-slide-to="1"></li>
            <li data-target="#my-pics" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner" role="listbox">

            <div class="item active">
                <lottie-player src="<?php echo Yii::app()->theme->baseUrl; ?>/animation/banner-ascend-1.json" loop autoplay background="transparent" speed="1" style="width: 100%; height: auto;"></lottie-player>
            </div>

            <div class="item">
                <lottie-player src="<?php echo Yii::app()->theme->baseUrl; ?>/animation/banner-ascend-2.json" loop autoplay background="transparent" speed="1" style="width: 100%; height: auto;"></lottie-player>
            </div>

            <div class="item">
                <lottie-player src="<?php echo Yii::app()->theme->baseUrl; ?>/animation/banner-ascend-3.json" loop autoplay background="transparent" speed="1" style="width: 100%; height: auto;"></lottie-player>
            </div>

        </div>
        <a class="left carousel-control" href="#my-pics" data-slide="prev" style="background: none;"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <a class="right carousel-control" href="#my-pics" data-slide="next" style="background: none;"><span class="glyphicon glyphicon-chevron-right"></span></a>

    </div>
    </div> -->
</section>

<!-- 
<section class="banner-main">
    <?php
    $criteriaimg = new CDbCriteria;
    $criteriaimg->compare('active', 'y');
    $criteriaimg->compare('lang_id', Yii::app()->session['lang']);
    $criteriaimg->order = 'update_date  DESC';
    $image = Imgslide::model()->findAll($criteriaimg);
    ?>
    <div id="carousel-banner" class="owl-carousel owl-theme owl-main">
        <?php
        foreach ($image as $key => $value) {
            $criteriaType = new CDbCriteria;
            $criteriaType->compare('active', 'y');
            $criteriaType->compare('gallery_type_id', $value->gallery_type_id);
            $criteriaType->order = 'id ASC';
            $galleryType = Gallery::model()->findAll($criteriaType);
        ?>
            <div class="item <?php if ($key == 0) echo 'active'; ?>">
                <?php
                if ($value->imgslide_link == "" && $value->gallery_type_id != null) {
                    foreach ($galleryType as $key_t => $data) {
                ?>
                        <a href="<?php echo Yii::app()->baseUrl; ?>/uploads/gallery/<?= $data->image; ?>" class="liquid-lp-read-more zoom fresco" data-fresco-group="ld-pf-1[<?= $value->id ?>]">
                            <?php if ($key_t == 0) {
                            ?>
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/main-bg.png" class="slide-main-thor" alt="">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/imgslide/<?= $value->imgslide_id; ?>/thumb/<?= $value->imgslide_picture; ?>" class="slide-main-thor" alt="">
                            <?php
                            }  ?>
                        </a>
                    <?php } ?>
                <?php } else if ($value->imgslide_link != "" && $value->gallery_type_id == null) { ?>
                    <a href="<?= $value->imgslide_link;  ?>" target="_blank">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/main-bg.png" class="slide-main-thor" alt="">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/imgslide/<?= $value->imgslide_id; ?>/thumb/<?= $value->imgslide_picture; ?>" class="slide-main-thor" alt="">
                    </a>
                <?php } else { ?>
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/main-bg.png" class="slide-main-thor" alt="">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/imgslide/<?= $value->imgslide_id; ?>/thumb/<?= $value->imgslide_picture; ?>" class="slide-main-thor" alt="">
                <?php } ?>

            </div>
        <?php } ?>

    </div>
</section> -->
<?php $urlLogin = "https://login.microsoftonline.com/common/oauth2/authorize?client_id=2240fcc5-2667-4335-baff-3c8ebd602f1b&scope=openid+offline_access+group.read.all&redirect_uri=https://learn.ascendcorp.com/site/auth&response_type=code"; ?>
<section class="menu-slide">
    <div class="owl-carousel owl-theme learning-menu">
        <div class="item">
            <div class="list-menu-owl">
                <div class="nav-content text-center">
                    <a href="<?php echo (Yii::app()->user->id == null ? $urlLogin : $this->createUrl('virtualclassroom/index')) ?>">
                        <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/e-library-news.png"> -->
                        <svg width="75" height="75" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1047_2691)">
                                <path d="M35.3242 29.5522L41.7569 25.2634L35.3242 20.9746V29.5522Z" fill="#D2D711" />
                                <path d="M69.6592 11.0474C70.7709 11.0474 71.671 10.1473 71.671 9.03554C71.671 7.92378 70.7709 7.02369 69.6592 7.02369H39.3474V5.01185C39.3474 3.90009 38.4473 3 37.3355 3C36.2238 3 35.3237 3.90009 35.3237 5.01185V7.02369H5.01185C3.90009 7.02369 3 7.92378 3 9.03554C3 10.1473 3.90009 11.0474 5.01185 11.0474H7.02369V47.3947H5.01185C3.90009 47.3947 3 48.2948 3 49.4066C3 50.5183 3.90009 51.4184 5.01185 51.4184H11.3853C11.2522 50.7682 11.1815 50.0955 11.1815 49.4066C11.1815 43.8604 15.6945 39.3473 21.2407 39.3473C24.543 39.3473 27.4528 40.9684 29.2881 43.4334C31.1234 40.9684 34.0333 39.3473 37.3355 39.3473C40.6378 39.3473 43.5476 40.9684 45.3829 43.4334C47.2182 40.9684 50.128 39.3473 53.4303 39.3473C58.9765 39.3473 63.4895 43.8604 63.4895 49.4066C63.4895 50.0955 63.4188 50.7682 63.2857 51.4184H69.6592C70.7709 51.4184 71.671 50.5183 71.671 49.4066C71.671 48.2948 70.7709 47.3947 69.6592 47.3947H67.6473V11.0474H69.6592ZM46.4988 26.9383L34.4278 34.9857C33.8038 35.4012 33.0079 35.4321 32.363 35.0858C31.7086 34.7363 31.3 34.0542 31.3 33.3118V17.217C31.3 16.4747 31.7086 15.7925 32.363 15.4431C33.0132 15.091 33.809 15.1345 34.4278 15.5431L46.4988 23.5905C47.0589 23.9635 47.3947 24.5922 47.3947 25.2644C47.3947 25.9361 47.0589 26.5648 46.4988 26.9383Z" fill="#D2D711" />
                                <path d="M27.2766 49.4047C27.2766 46.0767 24.569 43.3691 21.2411 43.3691C17.9132 43.3691 15.2056 46.0767 15.2056 49.4047C15.2056 52.7326 17.9132 55.4402 21.2411 55.4402C24.569 55.4402 27.2766 52.7326 27.2766 49.4047Z" fill="#D2D711" />
                                <path d="M43.3714 49.4047C43.3714 46.0767 40.6638 43.3691 37.3358 43.3691C34.0079 43.3691 31.3003 46.0767 31.3003 49.4047C31.3003 52.7326 34.0079 55.4402 37.3358 55.4402C40.6638 55.4402 43.3714 52.7326 43.3714 49.4047Z" fill="#D2D711" />
                                <path d="M27.2769 65.5006V69.6585C27.2769 70.7702 28.1769 71.6703 29.2887 71.6703H45.3835C46.4952 71.6703 47.3953 70.7702 47.3953 69.6585V65.5006C47.3953 59.9544 42.8823 55.4414 37.3361 55.4414C31.7899 55.4414 27.2769 59.9544 27.2769 65.5006Z" fill="#D2D711" />
                                <path d="M59.4661 49.4047C59.4661 46.0767 56.7585 43.3691 53.4306 43.3691C50.1026 43.3691 47.395 46.0767 47.395 49.4047C47.395 52.7326 50.1026 55.4402 53.4306 55.4402C56.7585 55.4402 59.4661 52.7326 59.4661 49.4047Z" fill="#D2D711" />
                                <path d="M51.4183 65.5006V69.6585C51.4183 70.3673 51.2732 71.0379 51.0479 71.6703H61.4775C62.5893 71.6703 63.4894 70.7702 63.4894 69.6585V65.5006C63.4894 59.9544 58.9764 55.4414 53.4302 55.4414C51.5776 55.4414 49.8623 55.98 48.3696 56.8576C50.25 59.2513 51.4183 62.2282 51.4183 65.5006Z" fill="#D2D711" />
                                <path d="M11.1816 65.5006V69.6585C11.1816 70.7702 12.0817 71.6703 13.1935 71.6703H23.6231C23.3978 71.0379 23.2527 70.3673 23.2527 69.6585V65.5006C23.2527 62.2282 24.4211 59.2513 26.3014 56.8576C24.8088 55.98 23.0934 55.4414 21.2409 55.4414C15.6947 55.4414 11.1816 59.9544 11.1816 65.5006Z" fill="#D2D711" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1047_2691">
                                    <rect width="68.671" height="68.671" fill="white" transform="translate(3 3)" />
                                </clipPath>
                            </defs>
                        </svg>

                        <p><?= $txt_classroom_online ?></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="list-menu-owl">
                <div class="nav-content text-center">
                    <a href="<?= Yii::app()->createUrl('video/library'); ?>">
                        <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/e-library-news.png"> -->
                        <svg width="75" height="75" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1047_2690)">
                                <path d="M65.4126 50.1641C66.8126 50.1641 3.89409 50.1641 3.13759 50.1641C1.93965 50.1641 1 51.0942 1 52.3016C1 53.499 1.9402 54.4392 3.13759 54.4392C3.29958 54.7671 4.02658 54.8083 4.35779 56.5768H58.9999C60.1811 56.5768 61.1375 57.5332 61.1375 58.7144C61.1375 59.8956 60.1811 60.852 58.9999 60.852H4.35835C4.02714 62.62 3.30125 62.8014 3.13759 63.1321C1.9402 63.1321 1 64.0723 1 65.2697C1 66.4776 1.93965 67.4073 3.13759 67.4073H65.4126C70.1042 67.4073 73.963 63.4371 73.963 58.7144C73.963 54.1592 70.2489 50.1641 65.4126 50.1641Z" fill="#D2D711" />
                                <path d="M65.413 28.7881C66.813 28.7881 12.4449 28.7881 11.6884 28.7881C10.4904 28.7881 9.55078 29.7183 9.55078 30.9257C9.55078 32.1231 10.491 33.0633 11.6884 33.0633C11.8504 33.3911 12.5774 33.4323 12.9086 35.2008H59.0003C60.1815 35.2008 61.1379 36.1572 61.1379 37.3384C61.1379 38.5197 60.1815 39.476 59.0003 39.476H12.9091C12.5779 41.244 11.852 41.2829 11.6884 41.6136C10.491 41.6136 9.55078 42.5538 9.55078 43.7512C9.55078 44.9592 10.4904 45.8888 11.6884 45.8888H65.413C70.1046 45.8888 73.9634 42.0612 73.9634 37.3384C73.9634 32.7833 70.2493 28.7881 65.413 28.7881Z" fill="#D2D711" />
                                <path d="M65.413 7.41016C70.2493 7.41016 73.9634 11.4053 73.9634 15.9605C73.9634 20.6832 70.1046 24.5109 65.413 24.5109C64.5029 24.5109 28.4996 24.5109 28.9315 24.5109C27.7336 24.5109 26.7939 23.5812 26.7939 22.3733C26.7939 21.1759 27.7341 20.2357 28.9315 20.2357C29.0952 19.905 29.8205 19.8661 30.1523 18.0981H59.0003C60.1815 18.0981 61.1378 17.1417 61.1378 15.9605C61.1378 14.7793 60.1815 13.8229 59.0003 13.8229H30.1517C29.8205 12.0544 29.0935 12.0132 28.9315 11.6853C27.7341 11.6853 26.7939 10.7451 26.7939 9.54774C26.7939 8.34034 27.7336 7.41016 28.9315 7.41016C29.3134 7.41016 65.9953 7.41016 65.413 7.41016Z" fill="#D2D711" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1047_2690">
                                    <rect width="72.963" height="72.963" fill="white" transform="translate(1 1)" />
                                </clipPath>
                            </defs>
                        </svg>

                        <p><?= $txt_library ?></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="list-menu-owl">
                <div class="nav-content text-center">
                    <a href="<?= Yii::app()->createUrl('document'); ?>">
                        <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/analysis-nwe.png"> -->
                        <svg width="75" height="75" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1047_2689)">
                                <path d="M22.0698 8.10063H60.9748V3.30026C60.9748 2.02883 59.9574 0.998047 58.7025 0.998047H22.0698L22.0702 0.99889H22.0698V8.10063Z" fill="#D2D711" />
                                <path d="M17.7841 12.6307V3.43848L8.97119 13.1746H17.2471C17.5436 13.1747 17.7841 12.9311 17.7841 12.6307Z" fill="#D2D711" />
                                <path d="M58.8058 54.8181H60.9803C61.2296 54.8181 61.468 54.8635 61.6905 54.9428V50.1455C60.7597 50.4352 59.796 50.6479 58.8057 50.7734V54.8181H58.8058Z" fill="#D2D711" />
                                <path d="M43.7993 33.5362C43.7993 34.7938 43.9766 36.01 44.3063 37.1614C44.3895 37.3389 44.4495 37.5291 44.4825 37.7293C46.2094 42.8634 51.016 46.5666 56.6604 46.5666C73.7226 45.8508 73.7175 21.219 56.6603 20.5059C49.5688 20.5059 43.7993 26.3512 43.7993 33.5362V33.5362ZM62.5929 29.1814C63.4298 30.0291 63.4298 31.4039 62.5929 32.2518L57.027 37.8909C56.2375 38.6906 54.9769 38.7412 54.1281 38.0136L50.8595 35.2134C48.7613 33.2657 51.385 30.126 53.6267 31.8976L55.3902 33.4084L59.5623 29.1814C60.3992 28.3335 61.7561 28.3335 62.5929 29.1814V29.1814Z" fill="#D2D711" />
                                <path d="M54.9128 68.5995H58.4109C58.646 68.5995 58.8364 68.4065 58.8364 68.1684V59.5903C58.8364 59.3522 58.646 59.1592 58.4109 59.1592H54.9128C54.6778 59.1592 54.4873 59.3522 54.4873 59.5903V68.1684C54.4873 68.4065 54.6778 68.5995 54.9128 68.5995Z" fill="#D2D711" />
                                <path d="M22.0697 12.4434V15.3475C22.0697 16.5465 21.1103 17.5185 19.9268 17.5185H5.57471V70.6631C5.57471 71.9345 6.5921 72.9653 7.84702 72.9653L52.3439 72.9431C51.1604 72.9431 50.201 71.9711 50.201 70.7721V56.9896C50.201 55.7905 51.1604 54.8184 52.3439 54.8184H54.5184V50.7717C48.3477 49.9886 43.1855 45.8725 40.8516 40.2619H24.0274C21.1324 40.1549 21.0937 36.0582 23.9669 35.9196H39.6763C39.3931 33.8918 39.4861 31.7005 39.9306 29.727H24.0274C21.1324 29.62 21.0937 25.5233 23.9669 25.3847H41.5231C44.9331 18.5831 53.393 14.5877 60.9746 16.721V12.4434H22.0697ZM15.3783 61.332C14.1949 61.332 13.2355 60.36 13.2355 59.1608C13.3483 56.2808 17.409 56.2817 17.5213 59.1608C17.5212 60.3598 16.5618 61.332 15.3783 61.332V61.332ZM15.3783 50.7969C14.1949 50.7969 13.2355 49.8248 13.2355 48.6258C13.3483 45.7459 17.409 45.7467 17.5213 48.6258C17.5212 49.8248 16.5618 50.7969 15.3783 50.7969V50.7969ZM15.3783 40.2619C14.1949 40.2619 13.2355 39.2899 13.2355 38.0909C13.3484 35.2109 17.4088 35.2118 17.5213 38.0909C17.5212 39.2899 16.5618 40.2619 15.3783 40.2619V40.2619ZM15.3783 29.727C14.1949 29.727 13.2355 28.7549 13.2355 27.5558C13.3484 24.6758 17.4088 24.6767 17.5213 27.5558C17.5212 28.7549 16.5618 29.727 15.3783 29.727V29.727ZM31.9506 61.3318H23.9669C21.1236 61.2171 21.1257 57.1033 23.9669 56.9896H31.9506C34.7939 57.1044 34.7916 61.2183 31.9506 61.3318ZM23.9669 46.4546H36.4858C39.3291 46.5693 39.3268 50.6832 36.4858 50.7969H23.9669C21.1236 50.6822 21.1259 46.5683 23.9669 46.4546Z" fill="#D2D711" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1047_2689">
                                    <rect width="71.0323" height="71.967" fill="white" transform="translate(2 1)" />
                                </clipPath>
                            </defs>
                        </svg>
                        <p><?= $doc_download ?></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="list-menu-owl">
                <div class="nav-content text-center">
                    <a href="<?php echo (Yii::app()->user->id == null ? $urlLogin : $this->createUrl('course/courseplan')) ?>">
                        <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/course-new.png"> -->
                        <svg width="75" height="75" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.0347 47.6357H36.1908V56.7918H27.0347V47.6357Z" fill="#D2D711" />
                            <path d="M27.0347 36.1895H36.1908V45.3456H27.0347V36.1895Z" fill="#D2D711" />
                            <path d="M38.481 47.6357H47.6371V56.7918H38.481V47.6357Z" fill="#D2D711" />
                            <path d="M15.5894 47.6357H24.7455V56.7918H15.5894V47.6357Z" fill="#D2D711" />
                            <path d="M15.5894 36.1895H24.7455V45.3456H15.5894V36.1895Z" fill="#D2D711" />
                            <path d="M3 24.7471V67.094C3 69.6188 5.05326 71.6721 7.57805 71.6721H67.0927C69.6175 71.6721 71.6708 69.6188 71.6708 67.094V24.7471H3ZM61.3701 57.9379C61.3701 58.5697 60.8574 59.0824 60.2256 59.0824H14.4451C13.8134 59.0824 13.3006 58.5697 13.3006 57.9379V35.0477C13.3006 34.4159 13.8134 33.9032 14.4451 33.9032H60.2256C60.8574 33.9032 61.3701 34.4159 61.3701 35.0477V57.9379Z" fill="#D2D711" />
                            <path d="M38.481 36.1895H47.6371V45.3456H38.481V36.1895Z" fill="#D2D711" />
                            <path d="M49.9253 36.1895H59.0814V45.3456H49.9253V36.1895Z" fill="#D2D711" />
                            <path d="M49.9253 47.6357H59.0814V56.7918H49.9253V47.6357Z" fill="#D2D711" />
                            <path d="M3.00049 22.4567V12.1561C3.00049 9.63131 5.05374 7.57805 7.57854 7.57805H67.0932C69.618 7.57805 71.6712 9.63131 71.6712 12.1561V22.4567H3.00049ZM57.9371 14.4451V5.28903C57.9371 4.02319 56.9139 3 55.6481 3C54.3822 3 53.359 4.02319 53.359 5.28903V14.4451C53.359 15.711 54.3822 16.7342 55.6481 16.7342C56.9139 16.7342 57.9371 15.711 57.9371 14.4451ZM21.3127 14.4451V5.28903C21.3127 4.02319 20.2895 3 19.0237 3C17.7578 3 16.7346 4.02319 16.7346 5.28903V14.4451C16.7346 15.711 17.7578 16.7342 19.0237 16.7342C20.2895 16.7342 21.3127 15.711 21.3127 14.4451Z" fill="#D2D711" />
                        </svg>
                        <p><?= $txt_course_plan ?></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="list-menu-owl">
                <div class="nav-content text-center">
                    <a href="<?php echo (Yii::app()->user->id == null ? $urlLogin : $this->createUrl('site/dashboard')) ?>">
                        <svg width="75" height="75" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1047_2687)">
                                <path d="M13.2855 35.4836C14.9234 35.4836 16.4059 34.8264 17.5014 33.7711L23.5112 36.7758C23.481 37.0205 23.4366 37.2611 23.4366 37.5138C23.4366 40.8722 26.169 43.6045 29.5273 43.6045C32.8856 43.6045 35.618 40.8722 35.618 37.5138C35.618 36.5764 35.3875 35.6988 35.0073 34.9047L43.1599 26.752C43.954 27.1322 44.8317 27.3627 45.7691 27.3627C49.1274 27.3627 51.8598 24.6304 51.8598 21.272C51.8598 20.6397 51.7355 20.0417 51.5558 19.4681L58.6393 14.1567C59.6058 14.8023 60.7642 15.1814 62.0109 15.1814C65.3692 15.1814 68.1016 12.449 68.1016 9.09068C68.1016 5.73234 65.3692 3 62.0109 3C58.6526 3 55.9202 5.73234 55.9202 9.09068C55.9202 9.72301 56.0445 10.321 56.2242 10.8946L49.1406 16.206C48.1742 15.5604 47.0158 15.1814 45.7691 15.1814C42.4108 15.1814 39.6784 17.9137 39.6784 21.272C39.6784 22.2094 39.9089 23.0871 40.2891 23.8812L32.1365 32.0338C31.3423 31.6537 30.4647 31.4232 29.5273 31.4232C27.8894 31.4232 26.4069 32.0803 25.3114 33.1356L19.3016 30.131C19.3318 29.8862 19.3762 29.6456 19.3762 29.3929C19.3762 26.0346 16.6438 23.3023 13.2855 23.3023C9.92717 23.3023 7.19482 26.0346 7.19482 29.3929C7.19482 32.7513 9.92717 35.4836 13.2855 35.4836V35.4836Z" fill="#D2D711" />
                                <path d="M70.2681 68.2364H68.1026V25.331C68.1026 24.2091 67.1942 23.3008 66.0723 23.3008H57.9514C56.8295 23.3008 55.9212 24.2091 55.9212 25.331V68.2364H51.8608V37.5124C51.8608 36.3904 50.9524 35.4821 49.8305 35.4821H41.7096C40.5877 35.4821 39.6794 36.3904 39.6794 37.5124V68.2364H35.619V53.7541C35.619 52.6322 34.7106 51.7239 33.5887 51.7239H25.4678C24.3459 51.7239 23.4376 52.6322 23.4376 53.7541V68.2364H19.3772V45.6332C19.3772 44.5113 18.4688 43.603 17.3469 43.603H9.22602C8.10411 43.603 7.1958 44.5113 7.1958 45.6332V68.2364H5.03023C3.90831 68.2364 3 69.1447 3 70.2666C3 71.3885 3.90831 72.2969 5.03023 72.2969H70.2681C71.39 72.2969 72.2984 71.3885 72.2984 70.2666C72.2984 69.1447 71.39 68.2364 70.2681 68.2364Z" fill="#D2D711" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1047_2687">
                                    <rect width="69.2983" height="69.2983" fill="white" transform="translate(3 3)" />
                                </clipPath>
                            </defs>
                        </svg>
                        <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/course-status-new.png"> -->
                        <p><?= $txt_course_status ?></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div>
    <?php if (Yii::app()->user->id != null && $course_online != null) { ?>
        <section class="course">
            <div class="container">
                <h4 class="modal-title text-center course-recommanded-title-news">
                    <span><?= $label->label_courseOur ?></span>
                </h4>
                <div class="row ">
                    <?php foreach ($course_online as $key => $value) {
                        if ($value->status == 1) {

                            if ($value->lang_id != 1) {
                                $value->course_id = $value->parent_id;
                            }
                            if (!$flag) {
                                $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $value->course_id, 'order' => 'course_id'));
                                if ($modelChildren) {
                                    $value->course_title = $modelChildren->course_title;
                                    $value->course_short_title = $modelChildren->course_short_title;
                                    $value->course_detail = $modelChildren->course_detail;
                                    $value->course_picture = $modelChildren->course_picture;
                                }
                            }


                            if ($value->parent_id != 0) {
                                $value->course_id = $value->parent_id;
                            }


                            $expireDate = Helpers::lib()->checkCourseExpire($value);
                            if ($expireDate) {

                                $date_start = date("Y-m-d H:i:s", strtotime($value->course_date_start));
                                $dateStartStr = strtotime($date_start);
                                $currentDate = strtotime(date("Y-m-d H:i:s"));

                                if ($currentDate >= $dateStartStr) {

                                    $chk = Helpers::lib()->getLearn($value->course_id);
                                    if ($chk) {



                                        $chk_logtime = LogStartcourse::model()->find(array(
                                            'condition' => 'course_id=:course_id and user_id=:user_id and active=:active and gen_id=:gen_id',
                                            'params' => array(':course_id' => $value->course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $value->getGenID($value->course_id))
                                        ));
                                        $course_chk_time = CourseOnline::model()->findByPk($value->course_id);


                                        if (!empty($chk_logtime)) {
                                            if ($chk_logtime->course_day != $course_chk_time->course_day_learn) {
                                                $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));

                                                $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                                $chk_logtime->end_date = $Endlearncourse;
                                                $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                                $chk_logtime->save(false);
                                            }
                                        }

                                        $expireUser = Helpers::lib()->checkUserCourseExpire($value);
                                        if (!$expireUser) {

                                            $evnt = 'onclick="alertMsg(\'' . $label->label_swal_youtimeout . '\',\'\',\'error\')"';
                                            $url = 'javascript:void(0)';
                                        } else {

                                            $evnt = '';
                                            $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                                        }
                                    } else {
                                        $evnt = 'data-toggle="modal"';
                                        $url = '#modal-startcourse' . $value->course_id;
                                        // $url = '#modal-login';

                                        // $evnt = '';
                                        //   $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                                    }
                                } else {

                                    $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                                    $url = 'javascript:void(0)';
                                }
                            } elseif ($expireDate == 3) {
                                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                                $url = 'javascript:void(0)';
                            } else {
                                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_timeoutcourse . '\',\'error\')"';
                                $url = 'javascript:void(0)';
                            }
                    ?>


                            <div class="course-item col-md-3 col-sm-4">
                                <div class="item item-course-index">
                                    <div class="cours-card">
                                        <div class="card">
                                            <a href="<?= $url ?>" <?= $evnt ?> class="course_site">
                                                <?php $idCourse_img = (!$flag) ? $modelChildren->course_id : $value->course_id; ?>
                                                <?php if ($value->course_picture != null) { ?>
                                                    <div class="course-boximg" style="background-image:url(<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $idCourse_img ?>/thumb/<?= $value->course_picture ?>)"></div>
                                                <?php } else { ?>
                                                    <div class="course-boximg" style="background-image:url(<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png);"></div>
                                                <?php } ?>

                                                <div class="card-body">
                                                    <a href="<?= $url ?>" <?= $evnt ?>>
                                                        <h5 class="card-title"><?= $value->course_title; ?></h5>
                                                    </a>
                                                    <?php
                                                    $lessonList = Lesson::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND course_id=' . $value->course_id, 'order' => 'lesson_no'));

                                                    // foreach ($lessonList as $key => $lessonListValue) {

                                                    //    if(!$flag){
                                                    //        $lessonListChildren  = Lesson::model()->find(array('condition' => 'parent_id = ' . $lessonListValue->id, 'order' => 'lesson_no'));
                                                    //        if($lessonListChildren){
                                                    //         $lessonListValue->title = $lessonListChildren->title;
                                                    //         $lessonListValue->description = $lessonListChildren->description;
                                                    //         $lessonListValue->content = $lessonListChildren->content;
                                                    //         $lessonListValue->image = $lessonListChildren->image;
                                                    //     }

                                                    // }

                                                    // var_dump($lessonListValue);

                                                    // $checkLessonPass = Helpers::lib()->checkCourseStatus($value->course_id);

                                                    // var_dump($value->getGenID($value->course_id)); exit();
                                                    $status_course_gen = Helpers::lib()->StatusCourseGen($value->course_id, $value->getGenID($value->course_id));

                                                    // var_dump($checkLessonPass);

                                                    // if ($checkLessonPass->status == "notLearn") {
                                                    //     $colorTab = 'listlearn-danger';
                                                    //     $lessonStatusStr = $labelCourse->label_notLearn;
                                                    // } else if ($checkLessonPass->status == "learning") {
                                                    //     $colorTab = 'listlearn-warning';
                                                    //     $lessonStatusStr = $labelCourse->label_learning;
                                                    // } else if ($checkLessonPass->status == "pass") {
                                                    //     $colorTab = 'listlearn-success';
                                                    //     $lessonStatusStr =  $labelCourse->label_learnPass;
                                                    // }

                                                    if ($status_course_gen == "notLearn") {
                                                        $colorTab = 'listlearn-danger';
                                                        $lessonStatusStr = $labelCourse->label_notLearn;
                                                        $class = "defaultcourse";
                                                        $color = "#fff";
                                                    } else if ($status_course_gen == "learning") {
                                                        $colorTab = 'listlearn-warning';
                                                        $lessonStatusStr = $labelCourse->label_learning;
                                                        $class = "warningcourse";
                                                        $color = "#fff";
                                                    } else if ($status_course_gen == "pass") {
                                                        $colorTab = 'listlearn-success';
                                                        $lessonStatusStr =  $labelCourse->label_learnPass;
                                                        $class = "successcourse";
                                                        $color = "#fff";
                                                    }

                                                    ?>
                                                    <span class="card-text-1">
                                                        <?= $status ?> :
                                                        <a style="color: <?= $color ?>" class="<?= $class ?>">
                                                            <?= $lessonStatusStr ?>
                                                        </a>
                                                    </span>
                                                    <?php
                                                    //}

                                                    ?>
                                                    <!-- <div class="course-time">
                                                        <small class="text-muted"><i class="fa fa-clock"></i> 1 hr 30 min.</small>
                                                    </div>/ -->

                                                    <div class="card-footer">
                                                        <span class="text-card-footer">TITLE <br> COURSE</span>
                                                        <a href="" class="img-card-footer">
                                                            <img src="/lms_ascendmoney/themes/template2/images/btn-news.svg">
                                                        </a>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php

                        }
                    }
                    ?>
                </div>
                <div class="text-center">
                    <a class="btn btn-viewall" href="<?php echo $this->createUrl('/course/index'); ?>" role="button"><?= $label->label_viewAll ?><i class="fas fa-arrow-right arrow-right"></i></a>
                </div>
            </div>
        </section>
    <?php } ?>
    <?php foreach ($course_online as $key => $value) {

        if ($value->status == 1) {

            if ($value->lang_id != 1) {
                $value->course_id = $value->parent_id;
            }
            if (!$flag) {
                $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $value->course_id, 'order' => 'course_id'));
                if ($modelChildren) {
                    $value->course_title = $modelChildren->course_title;
                    $value->course_short_title = $modelChildren->course_short_title;
                    $value->course_detail = $modelChildren->course_detail;
                    $value->course_picture = $modelChildren->course_picture;
                }
            }
            if ($value->parent_id != 0) {
                $value->course_id = $value->parent_id;
            }
            $expireDate = Helpers::lib()->checkCourseExpire($value);
            if ($expireDate) {
                $date_start = date("Y-m-d H:i:s", strtotime($value->course_date_start));
                $dateStartStr = strtotime($date_start);
                $currentDate = strtotime(date("Y-m-d H:i:s"));
                if ($currentDate >= $dateStartStr) {
                    $chk = Helpers::lib()->getLearn($value->course_id);
                    if ($chk) {


                        $chk_logtime = LogStartcourse::model()->find(array(
                            'condition' => 'course_id=:course_id and user_id=:user_id and active=:active and gen_id=:gen_id',
                            'params' => array(':course_id' => $value->course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $value->getGenID($value->course_id))
                        ));
                        $course_chk_time = CourseOnline::model()->findByPk($value->course_id);


                        if (!empty($chk_logtime)) {
                            if ($chk_logtime->course_day != $course_chk_time->course_day_learn) {
                                $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));

                                $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                $chk_logtime->end_date = $Endlearncourse;
                                $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                $chk_logtime->save(false);
                            }
                        }



                        $expireUser = Helpers::lib()->checkUserCourseExpire($value);
                        if (!$expireUser) {
                            $evnt = 'onclick="alertMsg(\'' . $label->label_swal_youtimeout . '\',\'\',\'error\')"';
                            $url = 'javascript:void(0)';
                        } else {
                            $evnt = '';
                            $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                        }
                    } else {
                        $evnt = '';
                        $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                        // $evnt = 'data-toggle="modal"';
                        // $url = '#modal-startcourse'.$value->course_id;
                    }
                } else {
                    $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                    $url = 'javascript:void(0)';
                }
            } elseif ($expireDate == 3) {
                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                $url = 'javascript:void(0)';
            } else {
                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_timeoutcourse . '\',\'error\')"';
                $url = 'javascript:void(0)';
            }
            $chk = Helpers::lib()->getLearn($value->course_id);

            if (!$chk) { ?>

                <div class="modal fade" id="modal-startcourse<?= $value->course_id ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><?= $labelcourse->label_learnlesson ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2 text-center">
                                        <h3><?= (Yii::app()->user->id) ? $labelcourse->label_swal_regiscourse : $labelcourse->label_detail; ?></h3>
                                        <h2>"<?= $value->course_title ?>"</h2>
                                        <h3>(<?= $value->CategoryTitle->cate_title ?>)</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-success" href="<?= $url ?>" <?= $evnt ?>><?= UserModule::t("Ok") ?></a>
                                <a class="btn btn-warning" href="#" class="close" data-dismiss="modal" aria-hidden="true"><?= UserModule::t("Cancel") ?></a>
                            </div>
                        </div>
                    </div>
                </div>

    <?php }
        } //condition status
    } ?>

    <section class="video-list">
        <div class="wrap-video-list">
                <div class="row">
                    <div class="col-md-6 col-xs-12 video">
                        <h1 class="title-video-list">Video List</h1>
                        <div class="row list-video-recommanded">
                            <div class="col-md-8 col-xs-12 col-sm-12 card-video">

                                <div class="card mb-3 card-video">

                                    <?php
                                    $criteriavdo = new CDbCriteria;
                                    $criteriavdo->compare('active', 'y');
                                    $criteriavdo->compare('lang_id', Yii::app()->session['lang']);
                                    $criteriavdo->order = 'sortOrder DESC';
                                    $vdoshow = Vdo::model()->find($criteriavdo);
                                    ?>
                                    <?php
                                    if (!empty($vdoshow)) { ?>
                                        <div class="vdo">
                                            <?php
                                            if ($vdoshow->vdo_type == 'link') {
                                                $vdoName = $vdoshow->vdo_path;
                                                $new_link = str_replace("watch?v=", "embed/", $vdoName);
                                                $show = '<iframe class="embed-responsive-item" width="100%" height="60"  src="' . $new_link . '" allowfullscreen"></iframe>';
                                                echo $show;
                                                $href = 'href="' . $vdoshow->vdo_path . '" target="_blank"';
                                            } else {
                                            ?>
                                                <video class="video-js" controls preload="auto" style="width: 100%; height: 315;">
                                                    <!--  <source src="<?php echo Yii::app()->homeurl . '/../uploads/' . $vdoshow->vdo_path; ?>" type='video/mp4'> -->
                                                    <?php
                                                    if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/' . $vdoshow->vdo_path)) {
                                                        $file_name = Yii::app()->baseUrl . '/uploads/' . $vdoshow->vdo_path;
                                                    } else {
                                                        $file_name = Yii::app()->theme->baseUrl . '/vdo/mov_bbb.mp4';
                                                    }
                                                    ?>
                                                    <source src="<?php echo $file_name; ?>" type='video/mp4'>
                                                    <p class="vjs-no-js">
                                                        To view this video please enable JavaScript, and consider upgrading to a web browser that
                                                        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                                    </p>
                                                </video>
                                            <?php } ?>
                                        </div>
                                        <div class="wrap-text-recommanded">
                                            <p class="recommanded-content-head "><?= $vdoshow->vdo_title ?></p>
                                        </div>
                                    <?php } ?>

                                </div>

                            </div>

                            <div class="col-md-4 col-xs-12 col-sm-12 card-list-video">
                                <div class="card mb-3 card-playlist" style="height: 100%;">
                                    <h1 class="header-playlist-video">Playlist</h1>
                                    <div class="overflow-playlist">
                                        <?php
                                        $criteriavdo = new CDbCriteria;
                                        $criteriavdo->compare('active', 'y');
                                        if (!empty($vdoshow)) {
                                            $criteriavdo->AddNotInCondition("vdo_id", [$vdoshow->vdo_id]);
                                        }
                                        $criteriavdo->compare('lang_id', Yii::app()->session['lang']);
                                        $criteriavdo->order = 'sortOrder DESC';
                                        $vdoshowAll = vdo::model()->findAll($criteriavdo);
                                        ?>

                                        <?php foreach ($vdoshowAll as $keyVDO => $valueVDO) { ?>
                                            <?php
                                            if ($valueVDO->vdo_type == 'link') {
                                                $vdoName = $valueVDO->vdo_path;
                                                $new_link = str_replace("watch?v=", "embed/", $vdoName);
                                                $show = '<iframe class="embed-responsive-item" width="100%" height="40px" src="' . $new_link . '" allowfullscreen"></iframe>';
                                            } else {
                                                if (file_exists(YiiBase::getPathOfAlias('webroot') . '/admin/uploads/' . $valueVDO->vdo_path)) {
                                                    $file_name = Yii::app()->baseUrl . '/admin/uploads/' . $valueVDO->vdo_path;
                                                } else {
                                                    $file_name = Yii::app()->theme->baseUrl . '/vdo/mov_bbb.mp4';
                                                }
                                                $show = '<video class="video-js" controls preload="auto" style="width: 100%; height: 40px;">
                                        <source src="' . $file_name . '" type="video/mp4">
                                        <p class="vjs-no-js">
                                        To view this video please enable JavaScript, and consider upgrading to a web browser that
                                        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                        </p>
                                        </video>';
                                            ?>

                                            <?php } ?>
                                            <div class="row row-list">
                                                <div class="col-md-5 col-5">
                                                    <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/playlist-1.png" width="100%" height="40px"> -->
                                                    <?= $show ?>
                                                </div>
                                                <div class="col-md-7 col-7 playlist">
                                                    <div class="wrap-text">
                                                        <p class="list-video-title"><small><?= $valueVDO->vdo_title ?></small></p>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <div class="btn-playlist-video">
                                        <a class="viewall-video" href="<?= $this->createUrl('video/index') ?>">
                                            <?= $label->label_viewAll ?> <i class="fas fa-angle-right"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>
        </div>
    </section>

    <div class="section-bg-news">
        <section class="" id="news-group">
            <?php
            $criteria = new CDbCriteria;
            $criteria->compare('active', 'y');
            $criteria->compare('lang_id', $langId);
            $criteria->order = 'sortOrder ASC';
            $TypeNews = TypeNews::model()->findAll($criteria);
            ?>
            <h4 class="modal-title text-center modal-title-news"> <span><?= $label->label_news ?></span> </h4>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#" onclick="tab_cate(this, 0);">All</a>
                </li>
                <?php foreach ($TypeNews as $keyTypeNews => $valueTypeNews) {
                    if ($langId != 1) {
                        $criteria = new CDbCriteria;
                        $criteria->compare('cms_type_id', $valueTypeNews->parent_id);
                        $TypeNewsRoot = TypeNews::model()->find($criteria);
                        if ($TypeNewsRoot) {
                            $valueTypeNews->cms_type_id = $TypeNewsRoot->cms_type_id;
                        }
                    }

                ?>
                    <li>
                        <a data-toggle="tab" href="javascript:void(0)" onclick="tab_cate(this, <?= $valueTypeNews->cms_type_id ?>);"><?= $valueTypeNews->cms_type_title ?></a>
                    </li>
                <?php } ?>
            </ul>
        </section>

        <section class="container  mt-3">
            <?php
            $criteria = new CDbCriteria;
            $criteria->compare('active', 'y');
            $criteria->compare('lang_id', $langId);
            $criteria->order = 'sortOrder ASC';
            // $criteria->limit = 3;
            $news = News::model()->findAll($criteria);
            ?>
            <?php foreach ($news as $keynews => $valuenews) { ?>
                <?php
                $criteria = new CDbCriteria;
                $criteria->compare('cms_id', $valuenews->cms_id);
                $count = CounterNews::model()->count($criteria);
                ?>
                <div class="col-lg-3 col-md-6 tab-news news-id-<?= $valuenews->cms_type_id ?>" style="margin-top: 5rem">
                    <div class="card card-course">
                        <a href="<?= $this->createUrl('news/detail/', array('id' => $valuenews->cms_id)) ?>">
                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' . $valuenews->cms_id . '/' . $valuenews->cms_picture)) {
                                $image_file = Yii::app()->homeUrl . 'uploads/news/' . $valuenews->cms_id . '/' . $valuenews->cms_picture;
                            } else {
                                $image_file = Yii::app()->theme->baseUrl . '/images/news.jpg';
                            }
                            ?>
                            <img class="card-img-top" src="<?= $image_file; ?>">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title text-4 text-main "><a href="#"><?= $valuenews->cms_title ?></a></h4>
                            <p class="card-text text-secondary"><i class="fas fa-calendar-alt"></i>&nbsp;<?php echo Helpers::lib()->DateLangTms($valuenews->create_date, Yii::app()->session['lang']); ?></p>
                            <hr>
                            <span class="float-end"><i class="fas fa-eye text-secondary" style="margin-top: 10px;"></i> <span class="text-danger"><?= $count ?></span></span>
                            <a href="<?= $this->createUrl('news/detail/', array('id' => $valuenews->cms_id)) ?>" class="pull-right">
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/btn-news.svg">
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>

        <div class="viewall-news">
            <a href="<?= $this->createUrl('news/index') ?>"><?= $label->label_viewAll ?> <i class="fas fa-angle-right"></i></a>
        </div>
    </div>
</div>

</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script type="text/javascript">
    function alertMsg(title, message, alert) {
        swal(title, message, alert);
    }
</script>

<script>
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover();
    });
</script>

<script>
    function tab_cate(div, id) {
        if (id == 0) {
            $('.tab-news').each(function(i, obj) {
                $(obj).show();
            });
        } else {
            $('.tab-news').each(function(i, obj) {
                $(obj).hide();
            });
            $('.news-id-' + id).each(function(i, obj) {
                $(obj).show();
            });
        }
        // console.log(id);
    }
</script>