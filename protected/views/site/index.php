<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
if (Yii::app()->session['lang'] == 2) {
    $flag = false;
    $course = "ศึกษาด้วยตนเอง (e-Learning)";
    $doc_download = "เอกสารดาวน์โหลด";
    $txt_library = "ห้องสมุดออนไลน์";
    $txt_classroom_online = "เรียนรู้ทางไกล (Online)";
    $bookingcourse = "จองหลักสูตร";
    $txt_quiz = "จองสอบออนไลน์";
    $txt_roomquiz = "ห้องสอบออนไลน์";
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
    $onlineexam  = "ตารางสอบออนไลน์";
    $Recourse  = "หลักสูตรแนะนำ";
    $coursetext = "หลักสูตรของฉัน";
    $viewall = "ดูทั้งหมด";
    $new = "ข่าวประชาสัมพันธ์";
    $videotext = "วิดีโอแนะนำ";

    $Onlineexam = "ห้องสอบออนไลน์";
    $Onlinebooking = "จองสอบออนไลน์";
} else {
    $flag = true;
    $course = "Course";
    $doc_download = "Document download";
    $txt_library = "E-Library";
    $txt_classroom_online = "Classroom Online";
    $bookingcourse = "BookingCourse";
    $txt_quiz = "จองสอบออนไลน์";
    $txt_roomquiz = "ห้องสอบออนไลน์";
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
    $onlineexam  = "Online Exam Timetable";
    $Recourse  = "Recommended Course";
    $coursetext = "Course";
    $viewall = "View all";
    $new = "Press Release";
    $videotext = "Intro Video";

    $Onlineexam = "Online exam room";
    $Onlinebooking = "Online exam booking";
}

?>
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

<?php 
    if($useld != null){
        $this->redirect(array('/course/bookingcourse'));
    }
?>
<section class="menu-slide">
    <div class="swiper learning-menu">
        <div class="swiper-wrapper col-12">

            <div class="swiper-slide item ">
                <div class="list-menu-owl">
                    <div class="nav-content text-center">
                        <a href="<?php echo $this->createUrl('/course/bookingcourse'); ?>">
                            <svg width="71" height="71" viewBox="0 0 71 71" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_331_4626)">
                                    <path d="M48.8127 0C38.21 0 29.5835 8.6265 29.5835 19.2292C29.5835 29.8318 38.21 38.4583 48.8127 38.4583C59.4153 38.4583 68.0418 29.8318 68.0418 19.2292C68.0418 8.6265 59.4153 0 48.8127 0ZM55.3417 25.7582C54.185 26.9149 52.3153 26.9149 51.1586 25.7582L46.7211 21.3207C46.165 20.7675 45.8543 20.0131 45.8543 19.2292V11.8333C45.8543 10.2003 47.1797 8.875 48.8127 8.875C50.4457 8.875 51.771 10.2003 51.771 11.8333V18.0044L55.3417 21.5751C56.4984 22.7318 56.4984 24.6015 55.3417 25.7582Z" fill="white" />
                                    <path d="M56.2085 43.2804C53.8714 43.9904 51.3864 44.375 48.8127 44.375C34.9381 44.375 23.6668 33.1037 23.6668 19.2292C23.6668 11.5375 27.1281 4.615 32.601 0H11.8335C6.95225 0 2.9585 3.99375 2.9585 8.875V51.7708C2.9585 54.67 6.9197 59.1667 11.8335 59.1667H20.7085V68.7812C20.7085 70.7101 23.0101 71.707 24.4064 70.4379L29.5835 65.8229L34.7606 70.4379C36.1096 71.6893 38.4585 70.7426 38.4585 68.7812V59.1667H53.2502C54.8773 59.1667 56.2085 57.8354 56.2085 56.2083C56.2085 46.934 56.2085 58.0602 56.2085 43.2804V43.2804ZM20.7085 53.25H11.8335C10.2064 53.25 8.87516 51.9187 8.87516 50.2917C8.87516 48.6646 10.2064 47.3333 11.8335 47.3333H20.7085V53.25ZM50.2918 53.25H38.4585V47.3333H50.2918V53.25Z" fill="white" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_331_4626">
                                        <rect width="71" height="71" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <p><?= $bookingcourse ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <!-- <div class="swiper-slide item">
                <div class="list-menu-owl">
                    <div class="nav-content text-center">
                        <a href="<?php //echo $this->createUrl('/examsonline/bookingexamsonline'); ?>">
                            <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M33.5903 51.6655H38.4093V56.4842H33.5903V51.6655Z" fill="white" />
                                <path d="M52.7954 51.6655H57.6141V56.4842H52.7954V51.6655Z" fill="white" />
                                <path d="M14.3857 33.5906H19.2047V38.4092H14.3857V33.5906Z" fill="white" />
                                <path d="M14.3857 51.6655H19.2047V56.4842H14.3857V51.6655Z" fill="white" />
                                <path d="M64.242 4.5187H62.6625V11.1469C62.6625 12.3119 61.7181 13.2563 60.5531 13.2563C59.3882 13.2563 58.4438 12.3119 58.4438 11.1469V4.5187V2.10938C58.4438 0.944437 57.4993 0 56.3344 0C55.1694 0 54.225 0.944437 54.225 2.10938V4.5187H49.1063V11.1469C49.1063 12.3119 48.1618 13.2563 46.9969 13.2563C45.8319 13.2563 44.8875 12.3119 44.8875 11.1469V4.5187V2.10938C44.8875 0.944437 43.9431 0 42.7781 0C41.6132 0 40.6688 0.944437 40.6688 2.10938V4.5187H35.55V11.1469C35.55 12.3119 34.6056 13.2563 33.4406 13.2563C32.2757 13.2563 31.3313 12.3119 31.3313 11.1469V4.5187V2.10938C31.3313 0.944437 30.3868 0 29.2219 0C28.0569 0 27.1125 0.944437 27.1125 2.10938V4.5187H21.9937V11.1469C21.9937 12.3119 21.0493 13.2563 19.8844 13.2563C18.7194 13.2563 17.775 12.3119 17.775 11.1469V4.5187V2.10938C17.775 0.944437 16.8306 0 15.6656 0C14.5007 0 13.5563 0.944437 13.5563 2.10938V4.5187H7.75772C3.48019 4.5187 0 7.99889 0 12.2766V18.075H72V12.2766C72 7.99889 68.5198 4.5187 64.242 4.5187V4.5187Z" fill="white" />
                                <path d="M0 64.2421C0 68.5198 3.48019 72 7.75772 72H64.242C68.5198 72 72 68.5198 72 64.2421V22.2937H0V64.2421ZM42.6281 58.5936C42.6281 59.7586 41.6836 60.703 40.5187 60.703H31.481C30.3161 60.703 29.3716 59.7586 29.3716 58.5936V49.5562C29.3716 48.3913 30.3161 47.4469 31.481 47.4469H40.5187C41.6836 47.4469 42.6281 48.3913 42.6281 49.5562V58.5936ZM48.5767 31.4813C48.5767 30.3164 49.5211 29.3719 50.686 29.3719H59.7234C60.8884 29.3719 61.8328 30.3164 61.8328 31.4813V40.5187C61.8328 41.6836 60.8884 42.6281 59.7234 42.6281H50.686C49.5211 42.6281 48.5767 41.6836 48.5767 40.5187V31.4813ZM48.5767 49.5562C48.5767 48.3913 49.5211 47.4469 50.686 47.4469H59.7234C60.8884 47.4469 61.8328 48.3913 61.8328 49.5562V58.5936C61.8328 59.7586 60.8884 60.703 59.7234 60.703H50.686C49.5211 60.703 48.5767 59.7586 48.5767 58.5936V49.5562ZM29.7157 34.5085C30.5394 33.6849 31.875 33.6849 32.6988 34.5085L34.4026 36.2122L39.3013 31.3134C40.1251 30.4897 41.4605 30.4895 42.2844 31.3134C43.1082 32.137 43.1082 33.4725 42.2845 34.2965L35.8944 40.6869C35.4988 41.0825 34.9622 41.3048 34.4028 41.3048C33.8434 41.3048 33.3069 41.0826 32.9113 40.6869L29.7159 37.4915C28.892 36.6678 28.892 35.3322 29.7157 34.5085V34.5085ZM10.167 31.4813C10.167 30.3164 11.1115 29.3719 12.2764 29.3719H21.3141C22.479 29.3719 23.4235 30.3164 23.4235 31.4813V40.5187C23.4235 41.6836 22.479 42.6281 21.3141 42.6281H12.2764C11.1115 42.6281 10.167 41.6836 10.167 40.5187V31.4813ZM10.167 49.5562C10.167 48.3913 11.1115 47.4469 12.2764 47.4469H21.3141C22.479 47.4469 23.4235 48.3913 23.4235 49.5562V58.5936C23.4235 59.7586 22.479 60.703 21.3141 60.703H12.2764C11.1115 60.703 10.167 59.7586 10.167 58.5936V49.5562Z" fill="white" />
                                <path d="M52.7954 33.5906H57.6141V38.4092H52.7954V33.5906Z" fill="white" />
                            </svg>

                            <p><?php //$Onlinebooking ?></p>
                        </a>
                    </div>
                </div>
            </div> -->

            <div class="swiper-slide item col-4">
                <div class="list-menu-owl-online">
                    <div class="nav-content text-center">
                        <a href="<?php echo (Yii::app()->user->id == null ? null : $this->createUrl('virtualclassroom/index')) ?>">
                            <svg width="75" height="75" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1047_2691)">
                                    <path d="M35.3242 29.5522L41.7569 25.2634L35.3242 20.9746V29.5522Z" fill="#fff" />
                                    <path d="M69.6592 11.0474C70.7709 11.0474 71.671 10.1473 71.671 9.03554C71.671 7.92378 70.7709 7.02369 69.6592 7.02369H39.3474V5.01185C39.3474 3.90009 38.4473 3 37.3355 3C36.2238 3 35.3237 3.90009 35.3237 5.01185V7.02369H5.01185C3.90009 7.02369 3 7.92378 3 9.03554C3 10.1473 3.90009 11.0474 5.01185 11.0474H7.02369V47.3947H5.01185C3.90009 47.3947 3 48.2948 3 49.4066C3 50.5183 3.90009 51.4184 5.01185 51.4184H11.3853C11.2522 50.7682 11.1815 50.0955 11.1815 49.4066C11.1815 43.8604 15.6945 39.3473 21.2407 39.3473C24.543 39.3473 27.4528 40.9684 29.2881 43.4334C31.1234 40.9684 34.0333 39.3473 37.3355 39.3473C40.6378 39.3473 43.5476 40.9684 45.3829 43.4334C47.2182 40.9684 50.128 39.3473 53.4303 39.3473C58.9765 39.3473 63.4895 43.8604 63.4895 49.4066C63.4895 50.0955 63.4188 50.7682 63.2857 51.4184H69.6592C70.7709 51.4184 71.671 50.5183 71.671 49.4066C71.671 48.2948 70.7709 47.3947 69.6592 47.3947H67.6473V11.0474H69.6592ZM46.4988 26.9383L34.4278 34.9857C33.8038 35.4012 33.0079 35.4321 32.363 35.0858C31.7086 34.7363 31.3 34.0542 31.3 33.3118V17.217C31.3 16.4747 31.7086 15.7925 32.363 15.4431C33.0132 15.091 33.809 15.1345 34.4278 15.5431L46.4988 23.5905C47.0589 23.9635 47.3947 24.5922 47.3947 25.2644C47.3947 25.9361 47.0589 26.5648 46.4988 26.9383Z" fill="#fff" />
                                    <path d="M27.2766 49.4047C27.2766 46.0767 24.569 43.3691 21.2411 43.3691C17.9132 43.3691 15.2056 46.0767 15.2056 49.4047C15.2056 52.7326 17.9132 55.4402 21.2411 55.4402C24.569 55.4402 27.2766 52.7326 27.2766 49.4047Z" fill="#fff" />
                                    <path d="M43.3714 49.4047C43.3714 46.0767 40.6638 43.3691 37.3358 43.3691C34.0079 43.3691 31.3003 46.0767 31.3003 49.4047C31.3003 52.7326 34.0079 55.4402 37.3358 55.4402C40.6638 55.4402 43.3714 52.7326 43.3714 49.4047Z" fill="#fff" />
                                    <path d="M27.2769 65.5006V69.6585C27.2769 70.7702 28.1769 71.6703 29.2887 71.6703H45.3835C46.4952 71.6703 47.3953 70.7702 47.3953 69.6585V65.5006C47.3953 59.9544 42.8823 55.4414 37.3361 55.4414C31.7899 55.4414 27.2769 59.9544 27.2769 65.5006Z" fill="#fff" />
                                    <path d="M59.4661 49.4047C59.4661 46.0767 56.7585 43.3691 53.4306 43.3691C50.1026 43.3691 47.395 46.0767 47.395 49.4047C47.395 52.7326 50.1026 55.4402 53.4306 55.4402C56.7585 55.4402 59.4661 52.7326 59.4661 49.4047Z" fill="#fff" />
                                    <path d="M51.4183 65.5006V69.6585C51.4183 70.3673 51.2732 71.0379 51.0479 71.6703H61.4775C62.5893 71.6703 63.4894 70.7702 63.4894 69.6585V65.5006C63.4894 59.9544 58.9764 55.4414 53.4302 55.4414C51.5776 55.4414 49.8623 55.98 48.3696 56.8576C50.25 59.2513 51.4183 62.2282 51.4183 65.5006Z" fill="#fff" />
                                    <path d="M11.1816 65.5006V69.6585C11.1816 70.7702 12.0817 71.6703 13.1935 71.6703H23.6231C23.3978 71.0379 23.2527 70.3673 23.2527 69.6585V65.5006C23.2527 62.2282 24.4211 59.2513 26.3014 56.8576C24.8088 55.98 23.0934 55.4414 21.2409 55.4414C15.6947 55.4414 11.1816 59.9544 11.1816 65.5006Z" fill="#fff" />
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

            <!-- <div class="swiper-slide item">
                <div class="list-menu-owl">
                    <div class="nav-content text-center">
                        <a href="<?php //echo $this->createUrl('/examsonline/index'); ?>">
                            <svg width="71" height="71" viewBox="0 0 71 71" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M64.6211 0H39.6602C36.2192 0 33.2812 3.07657 33.2812 6.51758V27.3184C33.2812 30.7594 36.2192 33.5586 39.6602 33.5586H64.6211C68.0621 33.5586 71 30.7594 71 27.3184V6.51758C71 3.07657 68.0621 0 64.6211 0ZM45.9004 23.1582C45.9004 24.3079 44.97 25.2383 43.8203 25.2383C42.6706 25.2383 41.7402 24.3079 41.7402 23.1582V18.998C41.7402 17.8483 42.6706 16.918 43.8203 16.918C44.97 16.918 45.9004 17.8483 45.9004 18.998V23.1582ZM54.2207 23.1582C54.2207 24.3079 53.2904 25.2383 52.1406 25.2383C50.9909 25.2383 50.0605 24.3079 50.0605 23.1582V14.8379C50.0605 13.6882 50.9909 12.7578 52.1406 12.7578C53.2904 12.7578 54.2207 13.6882 54.2207 14.8379V23.1582ZM62.541 23.1582C62.541 24.3079 61.6107 25.2383 60.4609 25.2383C59.3112 25.2383 58.3809 24.3079 58.3809 23.1582V10.6777C58.3809 9.52801 59.3112 8.59766 60.4609 8.59766C61.6107 8.59766 62.541 9.52801 62.541 10.6777V23.1582Z" fill="white" />
                                <path d="M16.6406 12.7578C12.0518 12.7578 8.32031 16.4893 8.32031 21.0781C8.32031 25.6669 12.0518 29.3984 16.6406 29.3984C21.2294 29.3984 24.9609 25.6669 24.9609 21.0781C24.9609 16.4893 21.2294 12.7578 16.6406 12.7578Z" fill="white" />
                                <path d="M23.9376 31.1575C21.8804 32.6512 19.3722 33.5587 16.6408 33.5587C13.9094 33.5587 11.4012 32.6512 9.34404 31.1575C4.53254 33.5278 0.992251 38.0992 0.179496 43.5933C0.0662008 44.3581 0.395546 45.0492 0.932068 45.5086C2.79124 40.948 7.25939 37.7189 12.4807 37.7189C17.599 37.7189 21.998 40.8212 23.9211 45.2393C25.3196 42.0266 28.0459 39.5589 31.3902 38.4265C29.7427 35.2877 27.1313 32.7307 23.9376 31.1575Z" fill="white" />
                                <path d="M12.4805 41.8789C7.89168 41.8789 4.16016 45.6104 4.16016 50.1992C4.16016 54.788 7.89168 58.5195 12.4805 58.5195C17.0693 58.5195 20.8008 54.788 20.8008 50.1992C20.8008 45.6104 17.0693 41.8789 12.4805 41.8789Z" fill="white" />
                                <path d="M35.3613 41.8789C30.7725 41.8789 27.041 45.6104 27.041 50.1992C27.041 54.788 30.7725 58.5195 35.3613 58.5195C39.9501 58.5195 43.8203 54.788 43.8203 50.1992C43.8203 45.6104 39.9501 41.8789 35.3613 41.8789Z" fill="white" />
                                <path d="M58.3809 41.8789C53.7921 41.8789 50.0605 45.6104 50.0605 50.1992C50.0605 54.788 53.7921 58.5195 58.3809 58.5195C62.9697 58.5195 66.8398 54.788 66.8398 50.1992C66.8398 45.6104 62.9697 41.8789 58.3809 41.8789Z" fill="white" />
                                <path d="M18.7207 66.8398C18.7207 64.3225 19.3169 61.9553 20.3321 59.8205C18.1806 61.5797 15.4701 62.6797 12.4805 62.6797C8.80636 62.6797 5.53204 61.0543 3.24603 58.5195C1.25027 60.7326 0 63.6318 0 66.8398V68.9199C0 70.0697 0.93035 71 2.08008 71H19.1039C18.8707 70.3462 18.7207 69.6527 18.7207 68.9199V66.8398Z" fill="white" />
                                <path d="M44.7344 58.5195C42.4484 61.0543 39.0354 62.6797 35.3613 62.6797C31.6872 62.6797 28.4129 61.0543 26.1269 58.5195C24.1311 60.7326 22.8809 63.6318 22.8809 66.8398V68.9199C22.8809 70.0697 23.8112 71 24.9609 71H45.9004C47.0501 71 47.9805 70.0697 47.9805 68.9199V66.8398C47.9805 63.6318 46.7302 60.7326 44.7344 58.5195Z" fill="white" />
                                <path d="M67.754 58.5195C65.468 61.0543 62.055 62.6797 58.3809 62.6797C55.3913 62.6797 52.6808 61.5797 50.5293 59.8205C51.5445 61.9553 52.1407 64.3225 52.1407 66.8398V68.9199C52.1407 69.6527 51.9906 70.3462 51.7575 71H68.92C70.0697 71 71 70.0697 71 68.9199V66.8398C71 63.6318 69.7498 60.7326 67.754 58.5195Z" fill="white" />
                            </svg>

                            <p><?php// $Onlineexam ?></p>
                        </a>
                    </div>
                </div>
            </div> -->
            <div class="swiper-slide item ">
                <div class="list-menu-owl-theory">
                    <div class="nav-content text-center">
                        <a href="<?php echo $this->createUrl('/course/index'); ?>">
                            <svg width="76" height="76" viewBox="0 0 76 76" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.93972 2.37354C3.98664 2.37354 2.3726 3.98054 2.3726 5.93362L2.37709 16.6235H73.6271L73.6226 5.93362C73.6219 3.98054 72.0155 2.37354 70.0624 2.37354H5.93972ZM10.692 7.1258C12.6455 7.1258 14.2522 8.73012 14.2522 10.6836C14.2522 12.637 12.6455 14.2531 10.692 14.2531C8.7386 14.2531 7.12492 12.637 7.12492 10.6836C7.12492 8.73012 8.7386 7.1258 10.692 7.1258ZM20.1851 7.1258C22.1385 7.1258 23.7546 8.73012 23.7546 10.6836C23.7546 12.637 22.1385 14.2531 20.1851 14.2531C18.2317 14.2531 16.6272 12.637 16.6272 10.6836C16.6272 8.73012 18.2317 7.1258 20.1851 7.1258ZM29.6874 7.1258C31.6408 7.1258 33.2476 8.73012 33.2476 10.6836C33.2476 12.637 31.6408 14.2531 29.6874 14.2531C27.734 14.2531 26.1296 12.637 26.1296 10.6836C26.1296 8.73012 27.734 7.1258 29.6874 7.1258ZM43.9328 14.2508C43.2806 14.2484 42.7525 13.7201 42.7499 13.0679V8.31784C42.7475 7.66202 43.277 7.1284 43.9328 7.1258H67.6804C68.3399 7.12342 68.8751 7.65839 68.8726 8.31784V13.0679C68.8732 13.6784 68.4108 14.1899 67.7419 14.2508H43.9328ZM2.37493 18.9984L2.37256 70.0656C2.37247 72.0187 3.9866 73.6235 5.93968 73.6235H70.0624C72.0155 73.6235 73.6226 72.0187 73.6226 70.0656L73.625 18.9984H2.37493ZM9.49993 22.5563H49.8749C50.5307 22.5587 51.0603 23.0926 51.0578 23.7485V54.6234C51.0601 55.2792 50.5307 55.8129 49.8749 55.8156H9.49993C8.84412 55.8132 8.31456 55.2792 8.31707 54.6234V23.7485C8.31469 23.0926 8.84412 22.5589 9.49993 22.5563ZM55.8101 22.5563H66.4952C67.1547 22.5538 67.6898 23.089 67.6874 23.7485V29.6837C67.6898 30.3432 67.1547 30.8781 66.4952 30.8758H55.8101C55.1543 30.8734 54.6248 30.3395 54.6272 29.6837V23.7485C54.6249 23.0926 55.1543 22.5587 55.8101 22.5563ZM29.2282 27.4037L14.9828 33.3389C14.0096 33.7455 14.0096 35.1242 14.9828 35.5306L29.2282 41.4729C29.5226 41.5968 29.8546 41.5968 30.149 41.4729L34.4374 39.6846V42.2568L31.0674 43.6622C30.1852 44.032 29.1897 44.032 28.3074 43.6622L17.8124 39.2856V43.936C17.81 44.3116 17.9857 44.6657 18.2856 44.8915C18.2856 44.8915 23.2679 48.6883 29.6804 48.6883C31.4059 48.6883 32.9947 48.3961 34.4351 47.9925V49.8758C34.4127 51.483 36.8342 51.483 36.8101 49.8758V47.1946H36.8124C36.813 43.7647 36.81 40.342 36.81 36.9131C36.8103 36.4334 36.5223 36.0005 36.0794 35.8159L30.1512 33.3435C28.6948 32.7334 29.5475 30.5187 31.0581 31.1494L36.9956 33.6288C38.3196 34.1795 39.1907 35.4773 39.1896 36.9154V37.7016L44.3942 35.5306C45.3675 35.124 45.3675 33.7453 44.3942 33.3389L30.1489 27.4037C29.8055 27.2606 29.492 27.2938 29.2281 27.4037H29.2282ZM55.8101 34.4337H66.4952C67.1556 34.4313 67.6909 34.9677 67.6874 35.628V41.561C67.685 42.2168 67.1511 42.7461 66.4952 42.7438H55.8101C55.1579 42.7414 54.6296 42.2131 54.6272 41.561V35.628C54.6237 34.9713 55.1534 34.436 55.8101 34.4337ZM41.5624 39.2856L39.1897 40.276V46.0813C40.3922 45.4196 41.0893 44.8915 41.0893 44.8915C41.3891 44.6657 41.5645 44.3114 41.5624 43.936V39.2856ZM55.7544 46.3132H66.4952C67.1511 46.3109 67.685 46.8404 67.6874 47.4962V53.4405C67.685 54.0963 67.1511 54.6258 66.4952 54.6234H55.8101C55.1579 54.621 54.6296 54.0927 54.6272 53.4405V47.4962C54.6266 46.8857 55.0901 46.3742 55.7544 46.3132V46.3132ZM55.8101 58.1813H66.4952C67.1547 58.1788 67.6897 58.714 67.6874 59.3735V65.3087C67.6897 65.9681 67.1547 66.5031 66.4952 66.5008H55.81C55.1542 66.4984 54.6248 65.9645 54.6272 65.3087V59.3735C54.6248 58.7176 55.1542 58.1837 55.81 58.1813H55.8101ZM9.50222 58.1837C9.70733 58.1847 9.91738 58.2407 10.1122 58.3578L16.0474 61.9157C16.8128 62.3776 16.8128 63.4878 16.0474 63.9497L10.1122 67.5169C9.32157 67.9896 8.31895 67.4222 8.31702 66.501V59.3736C8.31702 58.6592 8.88711 58.1808 9.50222 58.1839L9.50222 58.1837ZM36.7961 59.3573C37.462 59.3483 38.0041 59.8905 37.9976 60.5563V65.3087C38.0335 66.9266 35.5877 66.9266 35.6226 65.3087V64.1259H20.1851C18.6014 64.2022 18.4864 61.8269 20.1272 61.7508H35.6227V60.5563C35.6182 59.9014 36.1414 59.365 36.7963 59.3573H36.7961ZM41.5044 61.7508H49.8749C51.4586 61.7508 51.4586 64.1259 49.8749 64.1259H41.5647C39.9849 64.203 39.8641 61.8367 41.5045 61.7508H41.5044Z" fill="white" />
                            </svg>
                            <p><?= $course ?></p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<section class="banner-index">
    <div class="swiper" id="banner-main">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <?php
                if (Yii::app()->session['lang'] == 2) { ?>
                    <lottie-player src="<?php echo Yii::app()->theme->baseUrl; ?>/animation/banner-md-th.json" background="transparent" speed="1" style="width: 100%; height: auto;" loop autoplay></lottie-player>
                <?php
                } else { ?>
                    <lottie-player src="<?php echo Yii::app()->theme->baseUrl; ?>/animation/banner-md-en.json" background="transparent" speed="1" style="width: 100%; height: auto;" loop autoplay></lottie-player>
                <?php
                }
                ?>
            </div>
            <!-- <div class="swiper-slide">
                ไปคิวรี่ เพิ่ม
            </div> -->
        </div>
        <div class="swiper-pagination"></div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <div class="swiper-scrollbar"></div>
    </div>
    <script>
        const swiperBanner = new Swiper('#banner-main', {
            direction: 'horizontal',
            loop: false,

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
</section>

<?php $urlLogin = "https://login.microsoftonline.com/common/oauth2/authorize?client_id=2240fcc5-2667-4335-baff-3c8ebd602f1b&scope=openid+offline_access+group.read.all&redirect_uri=https://learn.ascendcorp.com/site/auth&response_type=code"; ?>


<?php if(Yii::app()->user->id){ ?>
<?php if (count($course_recommend) > 0) { ?>
    <section class="box-index">
        <div class="header-menu">
            <h4><span><?= $Recourse ?></span>
                <a href="<?= $this->createUrl('course/index') ?>" class="btn btn-viewall "><?= $viewall ?>
                    <i class="fas fa-angle-right"></i>
                </a>
            </h4>


            <div class="swiper course-slide">
                <div class="swiper-wrapper">
                    <?php foreach ($course_recommend as $keyrec => $recommend) {
                        $gen_id = $recommend->getGenID($recommend->course_id);

                        $percent_cou = Helpers::lib()->percent_CourseGen($recommend->course_id, $gen_id);

                        $id_course_picture = $recommend->course_id;
                        if (!$flag) {
                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $recommend->course_id, 'order' => 'course_id'));
                            if ($modelChildren) {
                                // $model->course_id = $modelChildren->course_id;
                                $recommend->course_title = $modelChildren->course_title;
                                $recommend->course_short_title = $modelChildren->course_short_title;
                                $recommend->course_detail = $modelChildren->course_detail;
                                $recommend->course_picture = $modelChildren->course_picture;
                                $id_course_picture = $modelChildren->course_id;
                            }
                        }
                    ?>
                        <div class="swiper-slide">

                            <?php
                            if (date("Y-m-d H:i:s") >= $recommend->course_date_start) { ?>
                                <a class="card-course" href="<?= Yii::app()->createUrl('course/detail/', array('id' => $recommend->course_id)) ?>">
                                <?php } else { ?>
                                    <a href="javascript:void(0)" OnClick="alertCoursedate()">
                                    <?php } ?>


                                    <div class="thumbmail-course">
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $id_course_picture . '/thumb/' . $recommend->course_picture)) { ?>
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $id_course_picture ?>/thumb/<?= $recommend->course_picture ?>" alt="" class="w-100" alt="">
                                    <?php } else { ?>
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $recommend->course_id. '/thumb/' . $recommend->course_picture)) {?>
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $recommend->course_id ?>/thumb/<?= $recommend->course_picture ?>" alt="" class="w-100" alt="">
                                        <?php }else {?>
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail.png" alt="" class="w-100" alt="">
                                        <?php }?>
                                    <?php } ?>
                                    </div>
                                    <div class="d-course">
                                        <h5><?= $recommend->course_title ?>  <b class="float-id"><?= $recommend->course_number ?></b></h5>

                                        <div class="staus-course">
                                            <?php if ($percent_cou >= 100) { ?>
                                                <span class="pg-success"><?= $langId == 1 ? "Completed" : "เรียนแล้ว" ?></span>
                                            <?php } ?>

                                            <?php if ($percent_cou > 0 && $percent_cou < 100) { ?>
                                                <span class="pg-waring"><?= $langId == 1 ? "Learning" : "กำลังเรียน" ?></span>
                                            <?php } ?>

                                            <?php if ($percent_cou == 0) { ?>
                                                <span class="pg-primary"><?= $langId == 1 ? "Not Learning" : "ยังไม่ได้เรียน" ?></span>
                                            <?php } ?>
                                        </div>


                                        <div class="progress pg-line">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?= $percent_cou ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent_cou ?>%;">
                                                <span class="sr-only"><?= $percent_cou ?>% Complete</span>
                                            </div>
                                        </div>


                                        <div class="text-right percent-course">
                                            <?php if ($percent_cou >= 100) { ?>
                                                <small><?= $langId == 1 ? "Progress" : "เรียนผ่านแล้ว" ?> 100%</small>
                                            <?php } else { ?>
                                                <small><?= $langId == 1 ? "Progress" : "เรียนผ่านแล้ว" ?> <?= $percent_cou ?>%</small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    </a>
                        </div>
                    <?php } ?>
                </div>

                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

        </div>
    </section>
<?php } ?>

<section class="box-index">
    <div class="header-menu">

        <h4><span><?= $coursetext ?></span>
            <a href="<?= $this->createUrl('course/index') ?>" class="btn btn-viewall "><?= $viewall ?>
                <i class="fas fa-angle-right"></i>
            </a>
        </h4>

        <div class="swiper course-slide">
            <div class="swiper-wrapper">

                <?php foreach ($course_online as $keycou => $cou_val) {
                    $gen_id = $cou_val->getGenID($cou_val->course_id);

                    $percent_cou = Helpers::lib()->percent_CourseGen($cou_val->course_id, $gen_id);

                    $id_course_picture = $cou_val->course_id;
                    if (!$flag) {
                        $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $cou_val->course_id, 'order' => 'course_id'));
                        if ($modelChildren) {
                            // $model->course_id = $modelChildren->course_id;
                            $cou_val->course_title = $modelChildren->course_title;
                            $cou_val->course_short_title = $modelChildren->course_short_title;
                            $cou_val->course_detail = $modelChildren->course_detail;
                            $cou_val->course_picture = $modelChildren->course_picture;
                            $id_course_picture = $modelChildren->course_id;
                        }
                    }
                ?>

                    <div class="swiper-slide">
                        <?php
                        if (date("Y-m-d H:i:s") >= $cou_val->course_date_start) { ?>
                            <a class="card-course" href="<?= Yii::app()->createUrl('course/detail/', array('id' => $recommend->course_id)) ?>">
                            <?php } else { ?>
                                <a href="javascript:void(0)" OnClick="alertCoursedate()">
                                <?php } ?>


                                <div class="thumbmail-course">
                                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $id_course_picture . '/thumb/' . $cou_val->course_picture)) { ?>
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $id_course_picture ?>/thumb/<?= $cou_val->course_picture ?>" alt="" class="w-100" alt="">
                                    <?php } else { ?>
                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail.png" alt="" class="w-100" alt="">
                                    <?php } ?>
                                </div>
                                <div class="d-course">
                                    <h5><?= $cou_val->course_title ?>  <b class="float-id"><?= $cou_val->course_number ?></b></h5>

                                    <div class="staus-course">
                                        <?php if ($percent_cou >= 100) { ?>
                                            <span class="pg-success"><?= $langId == 1 ? "Completed" : "เรียนแล้ว" ?></span>
                                        <?php } ?>

                                        <?php if ($percent_cou > 0 && $percent_cou < 100) { ?>
                                            <span class="pg-waring"><?= $langId == 1 ? "Learning" : "กำลังเรียน" ?></span>
                                        <?php } ?>

                                        <?php if ($percent_cou == 0) { ?>
                                            <span class="pg-primary"><?= $langId == 1 ? "Not Learning" : "ยังไม่ได้เรียน" ?></span>
                                        <?php } ?>

                                    </div>

                                    <div class="progress pg-line">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?= $percent_cou ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent_cou ?>%;">
                                            <span class="sr-only"><?= $percent_cou ?>% Complete</span>
                                        </div>
                                    </div>
                                    <div class="text-right percent-course">
                                        <?php if ($percent_cou >= 100) { ?>
                                            <small><?= $langId == 1 ? "Progress" : "เรียนผ่านแล้ว" ?> 100%</small>
                                        <?php } else { ?>
                                            <small><?= $langId == 1 ? "Progress" : "เรียนผ่านแล้ว" ?> <?= $percent_cou ?>%</small>
                                        <?php } ?>

                                    </div>
                                </div>
                                </a>
                    </div>
                <?php } ?>
                <?php
                         foreach ($msTeams as $keyrec => $recommend) { 
                           $gen_id = 0;
                        ?>
                            <div class="col-lg-3 col-sm-6 col-xs-12">

                              <?php 
                              if(date("Y-m-d H:i:s") >= $recommend->start_date){ ?>
                                <a class="card-course" href="<?=Yii::app()->createUrl('virtualclassroom/detail/', array('id' => $recommend->id))?>">
                                <?php }else{ ?>
                                   <a href="javascript:void(0)" OnClick="alertCoursedate()">
                                   <?php } ?>

                                    <div class="thumbmail-course">
                                        <span class="btn btn-course-online">เรียนรู้ทางไกล (Online)</span>
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/msteams/' . $recommend->id . '/thumb/' . $recommend->ms_teams_picture)) { ?>
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/msteams/<?= $recommend->id ?>/thumb/<?= $recommend->ms_teams_picture ?>" alt="" class="w-100" alt="">
                                        <?php }else{ ?>
                                            <img src="//via.placeholder.com/280x200" alt="" class="w-100" alt="">
                                        <?php } ?>

                                    </div>
                                    <div class="d-course">
                                        <h5><?=$recommend->name_ms_teams ?></h5>
                                        <div class="staus-course" style="font-size: 12px;">

                                        <p><?= Helpers::lib()->changeFormatDate($recommend->start_date) ." ". $recommend->time_start_date ?> </p>
                                        <p><?= Helpers::lib()->changeFormatDate($recommend->end_date) ." ". $recommend->time_end_date ?></p>

                                        </div>

                                     
                                    </div>
                                </a>
                            </div>

                         
                        <?php
                        }
                        ?>

            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>

<?php } ?>


<section class="box-index-second">
    <div class="row ">
        <div class="col-lg-8 col-xs-12 col-sm-12">
            <div class="item-box">
                <div class="header-menu">

                    <h4><span><?= $new ?></span>
                        <a href="<?php echo $this->createUrl('news/index'); ?>" class="btn btn-viewall "><?= $viewall ?>
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </h4>
                </div>
                <div class="row mt-1">

                    <?php foreach ($news as $all) { ?>


                        <div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
                            <?php
                            if (Yii::app()->session['lang'] == 1) { ?>
                                <a class="card-main" href="<?php echo $this->createUrl('news/detail/', array('id' => $all->cms_id)); ?>">
                                <?php } else { ?>
                                    <a class="card-main" href="<?php echo $this->createUrl('news/detail/', array('id' => $all->parent_id)); ?>">
                                    <?php  } ?>
                                    <div class="thumbmail-main">
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' . $all->cms_id . '/' . $all->cms_picture)) { ?>
                                            <img src="<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $all->cms_id ?>/<?php echo $all->cms_picture ?>" class="w-100" alt="">
                                        <?php } else { ?>
                                            <img src="//via.placeholder.com/280x200" alt="" class="w-100" alt="">
                                        <?php } ?>
                                    </div>
                                    <div class="d-main">
                                        <h5></h5>
                                        <div class="date-main">
                                            <small><i class="far fa-calendar-alt"></i> <?= Helpers::lib()->changeFormatDate($all->update_date); ?> </small>
                                        </div>
                                    </div>
                                    </a>
                        </div>
                    <?php } ?>


                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <div class="item-box">
                <div class="header-menu">
                    <h4><span><?= $videotext ?></span>
                        <a href="<?php echo $this->createUrl('video/index'); ?>" class="btn btn-viewall "><?= $viewall ?>
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </h4>
                </div>
                <div class="video-trailer">
                    <?php if ($video->vdo_type == 'link') {
                        $vdoName = $video->vdo_path;
                        $new_link = str_replace("watch?v=", "embed/", $vdoName);
                        $show = '<iframe class="embed-responsive-item" width="100%" height="55"  src="' . $new_link . '" allowfullscreen style="box-shadow:1px 4px 6px #767676"></iframe>';
                        echo $show;
                        $href = 'href="' . $video->vdo_path . '" target="_blank"';
                    } else {
                        if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/' . $video->vdo_path)) {
                            $file_name = Yii::app()->baseUrl . '/uploads/' . $video->vdo_path;
                        } else {
                            $file_name = Yii::app()->theme->baseUrl . '/vdo/mov_bbb.mp4';
                        } ?>

                        <video width="100%" height="180" controls>
                            <source src="<?= $file_name ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php } ?>

                    <h4><?= $video->vdo_title ?></h4>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    const swiperCourse = new Swiper('.course-slide', {
        direction: 'horizontal',
        loop: false,
        spaceBetween: 0,
        pagination: {
            el: '.swiper-pagination',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
             1360: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
        },
    });
</script>


<script type="text/javascript">
    function alertMsg(title, message, alert) {
        swal(title, message, alert);
    }
</script>

<script>
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover();
    });

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
    }
</script>

<script type="text/javascript">
    function alertCoursedate() {
        Swal.fire({
            title: 'แจ้งเตือน!',
            text: "ยังไม่ถึงเวลาเรียนหลักสูตร",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {}
        })
    }
</script>