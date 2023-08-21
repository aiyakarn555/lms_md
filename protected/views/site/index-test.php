<script type="text/javascript">
    $(window).load(function(){
        $('#modal-index').modal('show');
    });
</script>
<!-- <a class="btn btn-primary" data-toggle="modal" href='#modal-index'>Trigger modal</a> -->
<div class="modal fade" id="modal-index">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle text-white" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                 <?php include("themes/template2/include/slider-intro.php"); ?>
            </div>
        </div>
    </div>
</div>
<div class="btn-popup">
<a class="btn btn-system btn-lg" data-toggle="modal" href='#modal-index' title="Pop Up"><i class="fa fa-bullhorn" aria-hidden="true"></i></a>
</div>
<?php if(Yii::app()->user->hasFlash('error')) { ?>
    <div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>คำเตือน!</strong><?php echo CHtml::errorSummary(array($model,$form)); ?>
    </div>
<?php Yii::app()->user->setFlash('error', null); } ?>
<?php if(Yii::app()->user->hasFlash('recover')) { ?>
    <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>สำเร็จ! </strong><?php echo Yii::app()->user->getFlash('recover');  ?>
    </div>
<?php Yii::app()->user->setFlash('recover', null); } ?>
<?php if(Yii::app()->user->hasFlash('login')) { ?>
    <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>สำเร็จ! </strong><?php echo Yii::app()->user->getFlash('login');  ?>
    </div>
<?php Yii::app()->user->setFlash('login', null); } ?>

<!-- Full Body Container -->
<div id="container">

    <!-- Main Slider Section -->
    <?php include("themes/template2/include/slider.php"); ?>
    <!-- Main Slider Section End-->


    <!-- Start Test -->
    <!-- End Test -->

    <!-- Start Team Member Section -->
    <div class="section" style="background:#fff;">
        <div class="container">

            <!-- Start Big Heading -->
            <div class="big-title text-center" data-animation="fadeInDown" data-animation-delay="01">
                <h1>WELCOME <strong>DBD ACADEMY</strong></h1>
            </div>
            <!-- End Big Heading -->

            <!-- Some Text -->
            <p class="text-center" data-animation="fadeIn" data-animation-delay="02">
                เว็บไซต์ของกรมพัฒนาธุรกิจการค้า กระทรวงพาณิชย์
                เป็นศูนย์กลางแห่งการเรียนรู้ด้านการประกอบธุรกิจผ่านการเรียนการสอนออนไลน์
                เพื่อเพิ่มขีดความสามารถในการแข่งขันให้กับผู้ประกอบการ
                และตอบสนองความต้องการของผู้ประกอบการในการเข้าร่วมอบรมความรู้กับกรมพัฒนาธุรกิจการค้า ด้วย 8 หลักสูตร 25
                หัวข้อวิชา ดังนี้
            </p>

            <div class="recent-projects" data-animation="fadeIn" data-animation-delay="04">
                <h4 class="title"><span>DBD ACADEMY</span></h4>
                <div class="projects-carousel touch-carousel">
            <?php
            foreach ($course_online as $course_online_data) {
                $folder = explode("_", $course_online_data->course_id);
                $imageShow = Yii::app()->request->baseUrl . '/uploads/courseonline/' . $folder[0] . '/original/' . $course_online_data->course_picture;
                ?>
                    <div class="portfolio-item item">
                        <div class="team-member modern">
                            <!-- Memebr Photo, Name & Position -->
                            <div class="member-photo">
                                <img alt="" src="<?= $imageShow; ?>"/>
                                <div class="member-name"><?= $course_online_data->course_title ?> <span><?= $course_online_data->course_short_title ?></span>
                                </div>
                            </div>
                            <!-- Memebr Words -->
                            <div class="member-info">
                                <a href="<?php echo $this->createUrl('course/detail',array("id"=>$course_online_data->course_id)); ?>"> <?= $course_online_data->course_detail ?></a>
                            </div>
                        </div>
                    </div>

                <?php } ?>


                </div>
            </div>

        </div>
        <!-- .container -->
    </div>
    <!-- End Team Member Section -->

    <div id="parallax" data-stellar-background-ratio="0.6" class="parallax"
         style="background-image:url(<?php echo Yii::app()->theme->baseUrl; ?>/images/bg/bg1-01.jpg); background-size: cover;">
        <div class="parallax-text-container-1">
            <div class="parallax-text-item">
                <div class="container">
                    <div class="row">
                        <!-- Start Video Section Content -->
                        <div class="section-video-content text-center">
                            <!-- Start Big Heading -->
                <div class="big-title text-center">
                    <h2 class="text-white">VDO On Demand</h2>
                    <!-- <p class="title-desc text-white">Partners We Work With</p> -->
                </div>
                <!-- End Big Heading -->
                            <!-- Start Animations Text -->
                            <!-- <h1 class="fittext wite-text uppercase tlt texts">
                  <span class="texts" style="font-size: 20px;">
                    <span>หลักสูตรและเงื่อนไขการเรียน</span>
                  </span>
                            </h1> -->
                            <!-- End Animations Text -->

                            <!-- Start Buttons -->


                        </div>
                        <!-- End Section Content -->
                    </div>


                    <div class="recent-projects" data-animation="fadeIn" data-animation-delay="03">
                        <h4 class="title" style="border: none"><span></span></h4>
                        <div class="projects-carousel touch-carousel">

            <?php
            foreach ($coursevod as $course_vod) { 
                $course = CourseVod::model()->findByPk($course_vod->course_id);
            ?>
            
                            <div class="portfolio-item item">
                                <div class="portfolio-border">
                                    <div class="portfolio-thumb">
                                        <!-- <a class="lightbox" data-lightbox-type="ajax" href="https://vimeo.com/78468485"> -->
                                        <a href="http://vdo.dbdacademy.com/index.php/movie/index/<?= $course->id ?>">
                                            <div class="thumb-overlay"><i class="fa fa-play"></i></div>
                                            <img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/dbd.png"/>
                                        </a>
                                    </div>
                                    <div class="portfolio-details">
                                        <a href="http://vdo.dbdacademy.com/index.php/movie/index/<?= $course->id ?>">
                                            <h4><?= $course->name ?></h4>
                                            <!-- <span>Website</span>
                                            <span>Drawing</span> -->
                                        </a>
                                    </div>
                                </div>
                            </div>

            <?php } ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Start Services Section -->

    <div class="section service bg-white">
        <div class="container">
            <div class="row">
            <!-- Start Big Heading -->
                <div class="big-title text-center">
                    <h2>Audio Learning</h2>
                    <!-- <p class="title-desc">Partners We Work With</p> -->
                </div>
                <!-- End Big Heading -->

                <?php
            foreach ($courseaudit as $course_audit) { 
                $course = CourseVod::model()->findByPk($course_audit->course_id);
            ?>
                 <div class="col-md-3 col-sm-6 service-box service-center" data-animation="fadeIn"
                     data-animation-delay="01">
                    <div class="service-icon">
                        <a href="http://vdo.dbdacademy.com/index.php/audio/index/<?= $course->id ?>">
                        <i class="fa fa-play icon-large" aria-hidden="true"></i></a>
                    </div>
                    <div class="service-content">
                        <a href="http://vdo.dbdacademy.com/index.php/audio/index/<?= $course->id ?>"><h4><?= $course->name ?></h4></a>
                        <a href="http://vdo.dbdacademy.com/index.php/audio/index/<?= $course->id ?>"><p><?= $course_audit->name ?></p></a>

                    </div>
                </div>
            <?php } ?>

            </div>
            <!-- .row -->
        </div>
        <!-- .container -->

    </div>
    <!-- End Services Section -->


    <!-- Start Testimonials Section -->
    <div class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <!-- Start Recent Posts Carousel -->
                    <div class="latest-posts">
                        <h4 class="classic-title"><span>ข่าวประชาสัมพันธ์</span></h4>
                        <div class="latest-posts-classic custom-carousel touch-carousel" data-appeared-items="2">
                            
                            <?php 
                            $i = 0;
                            foreach ($news_data as $value) { 
                                $datetime = new DateTime($value->update_date);
                                $date = $datetime->format('Y-m-d');
                                $orderdate = explode('-', $date);
                                $year = $orderdate[0];
                                $month   = $orderdate[1];
                                $day  = $orderdate[2];

                                switch ($month) {
                                    case "1":
                                        $month  = "มกรา";
                                        break;
                                    case "2":
                                        $month  = "กุมภา";
                                        break;
                                    case "3":
                                        $month  = "มีนา";
                                        break;
                                    case "4":
                                        $month  = "เมษา";
                                        break;
                                    case "5":
                                        $month  = "พฤษภา";
                                        break;
                                    case "6":
                                        $month  = "มิถุนา";
                                        break;
                                    case "7":
                                        $month  = "กรกฎ";
                                        break;
                                    case "8":
                                        $month  = "สิงหา";
                                        break;
                                    case "9":
                                        $month  = "กันยา";
                                        break;
                                    case "10":
                                        $month  = "ตุลา";
                                        break;
                                    case "11":
                                        $month  = "พฤศจิ";
                                        break;
                                    case "12":
                                        $month  = "ธันวา";
                                        break;
                                    default:
                                        $month  = "ผิดพลาด";
                                }

                                $i++;
                            if($i == 1){
                                ?>
                                <div class="post-row item">
                                <?php
                            }
                            ?>

                                <div class="left-meta-post" style="margin-bottom: 24px;">
                                    <div class="post-type"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/portfolio-01.jpg" alt=""></div>
                                    <div class="post-date"><span class="day"><?= $day ?></span><span class="month"><?= $month ?></span>
                                    </div>
                                </div>
                                <h3 class="post-title"><a href="#"><?= iconv_substr($value->cms_title,0,25) ?>..</a></h3>
                                <div class="post-content">
                                    <?= iconv_substr($value->cms_detail,0,200) ?>.. <a class="read-more" href="<?= Yii::app()->createUrl('/news/index/', array('id' => $value->cms_id)); ?>"> อ่านต่อ...</a>
                                </div>
                                <div class="clearfix"></div>
                            <?php
                            if($i == 3){
                                ?>
                                </div>
                                <?php
                            $i = 0;}
                            if(( ($i != 3) && ($value == end($news_data)) )) {
                                        ?>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                            
                        </div>
                    </div>
                    <!-- End Recent Posts Carousel -->

                </div>
                <div class="col-md-4">
                <h4 class="classic-title"><span>Video Conference</span></h4>
                    <a class="center-block" target="_blank" href="http://vdo.dbdacademy.com/index.php/conference" role="button" style="padding-right: 20px;margin-bottom: 2em;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/vdo_conference.png" alt=""></a>
                    <h4 class="classic-title"><span>Facebook</span></h4>
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FDBDAcademy%2F&tabs=timeline&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="320" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>

                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials Section -->


    <div id="parallax-one" data-stellar-background-ratio="0.5" class="parallax"
         style="background-image:url(<?php echo Yii::app()->theme->baseUrl; ?>/images/patterns/7.png);">
        <div class="parallax-text-container-1">
            <div class="parallax-text-item">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="counter-item">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <div class="timer" id="item3" data-to="18745" data-speed="5000"></div>
                                <h2 class="text-black">ผู้เข้าชมเว็บไซต์ </h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="counter-item">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <div class="timer" id="item1" data-to="991" data-speed="5000"></div>
                                <h2 class="text-black">ช่องทางการเข้าถึงเว็บไซต์ </h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="counter-item">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                <div class="timer" id="item2" data-to="7394" data-speed="5000"></div>
                                <h2 class="text-black">สถิติการเข้าชมเนื้อหาเว็บไซต์ </h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="counter-item">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <div class="timer" id="item4" data-to="8423" data-speed="5000"></div>
                                <h2 class="text-black">การเข้าถึงเป้าหมายเว็บไซต์ของผู้ใช้งาน </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Start Client/Partner Section -->
    <div class="partner section bg-white" style="padding: 2em 0em;">
        <div class="container">
            <div class="row">

                <!-- Start Big Heading -->
                <h4 class="classic-title"><span>ลิงค์แนะนำ</span></h4>
                <!-- End Big Heading -->

                <!--Start Clients Carousel-->
                <div class="our-clients">
                    <div class="clients-carousel custom-carousel touch-carousel navigation-3" data-appeared-items="5"
                         data-navigation="true">
                        
                        <?php 
                        foreach ($featurelinks as $value) {    
                            $folder = explode("_", $value->link_id);
                            $imageShow = Yii::app()->request->baseUrl . '/uploads/featuredlinks/original/' . $value->link_image; 
                        ?>
                        <div class="client-item item">
                            <a href="<?= $value->link_url ?>"><img src="<?= $imageShow ?>" alt=""/></a>
                        </div>
                        <?php 
                            } 
                        ?>
                    </div>
                </div>
                <!-- End Clients Carousel -->
            </div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </div>
    <!-- End Client/Partner Section -->


    


</div>
<!-- End Full Body Container -->

<!-- Go To Top Link -->
<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>


<div id="loader">
    <div class="spinner">
        <div class="dot1"></div>
        <div class="dot2"></div>
    </div>
</div>

<?php
// // Load the Google API PHP Client Library.
// $googleapi = __DIR__ . '/google-api-php-client-2.1.1/vendor/autoload.php';
// // echo $googleapi;
// // exit();
// require_once $googleapi;

// // Start a session to persist credentials.
// session_start();

// // Create the client object and set the authorization configuration
// // from the client_secretes.json you downloaded from the developer console.
// $client = new Google_Client();
// $client->setAuthConfig(__DIR__ . '/client_secrets.json');
// $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);


// // If the user has already authorized this app then get an access token
// // else redirect to ask the user to authorize access to Google Analytics.
// if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
//   // Set the access token on the client.
//   $client->setAccessToken($_SESSION['access_token']);

//   // Create an authorized analytics service object.
//   $analytics = new Google_Service_Analytics($client);

//   // Get the first view (profile) id for the authorized user.
//   $profile = getFirstProfileId($analytics);

//   // Get the results from the Core Reporting API and print the results.
//   $results = getResults($analytics, $profile);
//   printResults($results);
// } else {
//   $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
//   header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
// }


// function getFirstProfileId($analytics) {
//   // Get the user's first view (profile) ID.

//   // Get the list of accounts for the authorized user.
//   $accounts = $analytics->management_accounts->listManagementAccounts();

//   if (count($accounts->getItems()) > 0) {
//     $items = $accounts->getItems();
//     $firstAccountId = $items[0]->getId();

//     // Get the list of properties for the authorized user.
//     $properties = $analytics->management_webproperties
//         ->listManagementWebproperties($firstAccountId);

//     if (count($properties->getItems()) > 0) {
//       $items = $properties->getItems();
//       $firstPropertyId = $items[0]->getId();

//       // Get the list of views (profiles) for the authorized user.
//       $profiles = $analytics->management_profiles
//           ->listManagementProfiles($firstAccountId, $firstPropertyId);

//       if (count($profiles->getItems()) > 0) {
//         $items = $profiles->getItems();

//         // Return the first view (profile) ID.
//         return $items[0]->getId();

//       } else {
//         throw new Exception('No views (profiles) found for this user.');
//       }
//     } else {
//       throw new Exception('No properties found for this user.');
//     }
//   } else {
//     throw new Exception('No accounts found for this user.');
//   }
// }

// function getResults($analytics, $profileId) {
//   // Calls the Core Reporting API and queries for the number of sessions
//   // for the last seven days.
//   return $analytics->data_ga->get(
//       'ga:' . $profileId,
//       '7daysAgo',
//       'today',
//       'ga:sessions');
// }

// function printResults($results) {
//   // Parses the response from the Core Reporting API and prints
//   // the profile name and total sessions.
//   if (count($results->getRows()) > 0) {

//     // Get the profile name.
//     $profileName = $results->getProfileInfo()->getProfileName();

//     // Get the entry for the first entry in the first row.
//     $rows = $results->getRows();
//     $sessions = $rows[0][0];

//     // Print the results.
//     print "<p>First view (profile) found: $profileName</p>";
//     print "<p>Total sessions: $sessions</p>";
//   } else {
//     print "<p>No results found.</p>";
//   }
// }

?>