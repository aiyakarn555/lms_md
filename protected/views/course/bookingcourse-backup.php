<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
?>

<section class="content-page" id="">
    <div class="container-main">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $langId == 1 ? "Bookingcourse" : "จองหลักสูตร" ?></li>
            </ol>
        </nav>

        <section class="search-filter">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'registration-form',
                'htmlOptions' => array('class' => "form row", 'enctype' => 'multipart/form-data', 'name' => 'form1'),
            ));
            ?>
            <!-- <form class="form row" enctype="multipart/form-data" id="vdo-form" action="/lms_md/index.php/virtualclassroom/index" method="post">  -->
            <!-- <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group wrap-form-lable">
                    <select name="search[search_course_type]" class="form-control">
                        <option <?= $search_course_type == "theory" ? "selected" : "" ?> value="theory"><?= $langId == 1 ? "Theory" : "ศึกษาด้วยตนเอง (e-Learning)" ?></option>
                        <option <?= $search_course_type == "online" ? "selected" : "" ?> value="online"><?= $langId == 1 ? "Online" : "เรียนรู้ทางไกล (Online)" ?></option>
                    </select>
                    <label for="floatingSelect"><?= $langId == 1 ? "Course Type" : "ประเภทหลักสูตร" ?></label>
                </div>
            </div> -->
            <input type="hidden"  name="search[search_course_type]" />
            <div class="col-lg-3 col-md-2 col-sm-3 col-xs-12">
                <div class="wrapsearch">
                    <div class="form-group mx-sm-3">
                        <input type="text" value="<?= $search_course_code ?>" name="search[search_course_code]" class="form-control" placeholder="<?= $langId == 1 ? "Search for the course name." : "รหัสหลักสูตร" ?>">
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7 col-sm-9 col-xs-12">
                <div class=" ">
                    <div class="form-group mx-sm-3">
                        <input type="text" value="<?= $search_course_name ?>" name="search[search_course_name]" class="form-control" placeholder="<?= $langId == 1 ? "Search for the course name." : "ชื่อหลักสูตร" ?>">
                    </div>
                    <div class="wrap-btn-search">
                        <button type="submit" class="btn btn-primary btn-search"><i class="fas fa-search"></i><?= $langId == 1 ? "Search" : "ค้นหา" ?></button>
                    </div>
                </div>
            </div>
            <!-- </form> -->
            <?php $this->endWidget(); ?>
        </section>


        <div class="content">
            <div class="text-center title-page">
                <h3><?= $langId == 1 ? "Bookingcourse" : "จองหลักสูตร" ?></h3>
            </div>

            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-3 ">
                    <div id="filter-typecourse">
                        <button id="btn-all" class="btn-typecourse" onclick="filterSelection('all')"> ทั้งหมด</button>
                        <button id="btn-online" class="btn-typecourse" onclick="filterSelection('online')">เรียนรู้ทางไกล (Online)</button>
                        <button id="btn-theory" class="btn-typecourse" onclick="filterSelection('theory')">ศึกษาด้วยตนเอง (e-Learning)</button>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12 col-md-9">
                    <?php
                    foreach ($course as $keyrec => $recommend) {
                        $gen_id = $recommend->getGenID($recommend->course_id);
                        $id_course_picture = $recommend->course_id;
                        if (!$flag) {
                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $recommend->course_id, 'order' => 'course_id'));
                            if ($modelChildren) {
                                $recommend->course_title = $modelChildren->course_title;
                                $recommend->course_short_title = $modelChildren->course_short_title;
                                $recommend->course_detail = $modelChildren->course_detail;
                                $recommend->course_picture = $modelChildren->course_picture;
                                $id_course_picture = $modelChildren->course_id;
                            }
                        }
                    ?>
                        <div class="col-lg-4 col-sm-6 col-xs-12 filter-item theory">
                            <div class="card-course">
                                <?php
                                $CourseTemp = CourseTemp::model()->find(
                                    array(
                                        'condition' => 'course_id=:course_id AND user_id=:user_id AND gen_id=:gen_id  AND status=:status',
                                        'params' => array(':course_id' => $recommend->course_id, ':user_id' => Yii::app()->user->id, ':gen_id' => $gen_id, ':status' => 'n')
                                    )
                                );
                                if ($CourseTemp != null) {
                                    $link = "javascript:void(0)";
                                } else {
                                    $link = Yii::app()->createUrl('course/bookingdetail/', array('id' => $recommend->course_id));
                                }
                                ?>
                                <a href="<?= $link ?>">
                                    <div class="thumbmail-course">

                                        <span class="btn btn-course-theory"><?= $langId == 1 ? "Theory" : "ศึกษาด้วยตนเอง (e-Learning)" ?></span>
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $id_course_picture . '/thumb/' . $recommend->course_picture)) { ?>
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $id_course_picture ?>/thumb/<?= $recommend->course_picture ?>" alt="" class="w-100" alt="">
                                        <?php } else { ?>
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail.png" alt="" class="w-100" alt="">
                                        <?php } ?>

                                    </div>
                                    <div class="d-course">
                                        <h4><?= $recommend->course_title ?> <b class="float-id">รหัสหลักสูตร : <?= $recommend->course_number ?></b></h4>

                                        <span>
                                            <?= $langId == 1 ? (Helpers::lib()->DateEngNewNoTime($recommend->course_date_start) . " - " . Helpers::lib()->DateEngNewNoTime($recommend->course_date_end)) : (Helpers::lib()->DateThaiNewNoTime($recommend->course_date_start) . " - " . Helpers::lib()->DateThaiNewNoTime($recommend->course_date_end)) ?>
                                        </span>
                                        <?php if ($CourseTemp != null) { ?>
                                            <div class="text-center">
                                                <button class="btn btn-booking-action" disabled>
                                                    <?= $langId == 1 ? "Pending Approval" : "รออนุมัติ" ?>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="text-center">
                                                <a class="btn-detail" href="<?= Yii::app()->createUrl('course/bookingdetail/', array('id' => $recommend->course_id)) ?>">
                                                    <?= $langId == 1 ? "Details" : "ดูรายละเอียด" ?>
                                                </a>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        if ($recommend->price == 'y') {

                                            if ($recommend->course_price <= 0) {
                                                $price = $langId == 1 ? "Free" : "ฟรี";
                                            } else {
                                                $price = $recommend->course_price . " " . ($langId == 1 ? "Baht" : "บาท");
                                            }
                                        } else {
                                            $price = $langId == 1 ? "Free" : "ฟรี";
                                        }
                                        ?>
                                        <h6 class="course-payments"><?= $langId == 1 ? "Price" : "ราคา" ?>: <span class="price"><?= $price ?></span></h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>


                    <?php
                    foreach ($msteams as $keyte => $teams) {
                        $gen_id = 0;
                    ?>
                        <div class="col-lg-4 col-sm-6 col-xs-12 filter-item online">
                            <div class="card-course">
                                <?php
                                $TeamsTemp = MsteamsTemp::model()->find(
                                    array(
                                        'condition' => 'ms_teams_id=:ms_teams_id AND user_id=:user_id AND gen_id=:gen_id  AND status=:status',
                                        'params' => array(':ms_teams_id' => $teams->id, ':user_id' => Yii::app()->user->id, ':gen_id' => $gen_id, ':status' => 'n')
                                    )
                                );
                                if ($TeamsTemp != null) {
                                    if ($TeamsTemp->file_payment == null) {
                                        $link = Yii::app()->createUrl('course/bookingteamsdetail/', array('id' => $teams->id, 'tempoldid' => $TeamsTemp->id));
                                    } else {
                                        $link = "javascript:void(0)";
                                    }
                                } else {
                                    $link = Yii::app()->createUrl('course/bookingteamsdetail/', array('id' => $teams->id));
                                }
                                ?>
                                <a href="<?= $link ?>">
                                    <div class="thumbmail-course">
                                        <span class="btn btn-course-online"><?= $langId == 1 ? "Online" : "เรียนรู้ทางไกล (Online)" ?></span>
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/msteams/' . $teams->id . '/thumb/' . $teams->ms_teams_picture)) { ?>
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/msteams/<?= $teams->id ?>/thumb/<?= $teams->ms_teams_picture ?>" alt="" alt="">
                                        <?php } else { ?>
                                            <img src="//via.placeholder.com/280x200" alt="" class="w-100" alt="">
                                        <?php } ?>
                                    </div>
                                    <div class="d-course">
                                        <h4><?= $teams->name_ms_teams ?> <b class="float-id"> <?php if($teams->course_md_gm != null){ ?>รหัสหลักสูตร :<?= $teams->course_md_gm   ?><?php    } ?></b></h4>
                                        <span>
                                            <?= $langId == 1 ? (Helpers::lib()->DateEngNewNoTime($teams->start_date) . " - " . Helpers::lib()->DateEngNewNoTime($teams->end_date)) : (Helpers::lib()->DateThaiNewNoTime($teams->start_date) . " - " . Helpers::lib()->DateThaiNewNoTime($teams->end_date)) ?>
                                        </span>
                                        <?php if ($TeamsTemp != null) { ?>
                                            <?php if ($TeamsTemp->file_payment == null) { ?>
                                                <div class="text-center">
                                                    <a class="btn btn-booking-action" href="<?= Yii::app()->createUrl('course/bookingteamsdetail/', array('id' => $teams->id, 'tempoldid' => $TeamsTemp->id)) ?>">
                                                        <?= $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน" ?>
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <div class="text-center">
                                                    <button class="btn btn-booking-action" disabled>
                                                        <?= $langId == 1 ? "Pending Approval" : "รออนุมัติ" ?>
                                                    </button>
                                                </div>
                                            <?php } ?>


                                        <?php } else { ?>
                                            <div class="text-center">
                                                <a class="btn-detail" href="<?= Yii::app()->createUrl('course/bookingteamsdetail/', array('id' => $teams->id)) ?>">
                                                    <?= $langId == 1 ? "Details" : "ดูรายละเอียด" ?>
                                                </a>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        if ($teams->price == 'y') {

                                            if ($teams->ms_price <= 0) {
                                                $price = $langId == 1 ? "Free" : "ฟรี";
                                            } else {
                                                $price = $teams->ms_price . " " . ($langId == 1 ? "Baht" : "บาท");
                                            }
                                        } else {
                                            $price = $langId == 1 ? "Free" : "ฟรี";
                                        }
                                        ?>
                                        <h6 class="course-payments"><?= $langId == 1 ? "Price" : "ราคา" ?>: <span class="price"><?= $price ?></span></h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>

    </div>
</section>

<script>
     <?php if($search_course_type == 'online' || $search_course_type == '') { ?>
            $("#btn-online").trigger("click");
            $("#btn-online").addClass( "active-type");
     <?php }else if($search_course_type == 'theory') { ?>
            $("#btn-theory").trigger("click");
            $("#btn-theory").addClass( "active-type");
     <?php }else { ?>
            $("#btn-all").trigger("click");
            $("#btn-all").addClass( "active-type");
     <?php } ?>
     //filterSelection("online");




    function filterSelection(c) {
        $( "input[name='search[search_course_type]']" ).val(c);
        var x, i;
        x = document.getElementsByClassName("filter-item");
        if (c == "all") c = "";
        for (i = 0; i < x.length; i++) {
            w3RemoveClass(x[i], "show-course");
            if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show-course");
        }
    }

    function w3AddClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
            if (arr1.indexOf(arr2[i]) == -1) {
                element.className += " " + arr2[i];
            }
        }
    }

    function w3RemoveClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
            while (arr1.indexOf(arr2[i]) > -1) {
                arr1.splice(arr1.indexOf(arr2[i]), 1);
            }
        }
        element.className = arr1.join(" ");
    }

    var btnContainer = document.getElementById("filter-typecourse");
    var btns = btnContainer.getElementsByClassName("btn-typecourse");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active-type");
            current[0].className = current[0].className.replace(" active-type", "");
            this.className += " active-type";
        });
    }
</script>