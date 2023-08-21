<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage  ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_search_result ?></li>
        </ol>
    </nav>
</div> 

<section class="content" id="search">
    <div class="container">
        <!--start total search-->
        <div class="text-center">
            <?php

            $search1 = Usability::model()->findAll(array(
                'condition' => ' (usa_title LIKE "%' . $text . '%" OR usa_detail LIKE "%' . $text . '%" ) AND lang_id ="'.$lang_session.'"'));
            $search2 = News::model()->findAll(array(
                'condition' => ' (cms_title LIKE "%' . $text . '%" OR cms_detail LIKE "%' . $text . '%") AND lang_id ="'.$lang_session.'"'));
            $search3 = CourseOnline::model()->findAll(array(
                'condition' => ' (course_title LIKE "%' . $text . '%" OR course_short_title LIKE "%' . $text . '%" OR course_detail LIKE "%' . $text . '%" ) AND lang_id ="'.$lang_session.'"'));
            $search4 = Vdo::model()->findAll(array(
                'condition' => ' (vdo_title LIKE "%' . $text . '%") AND lang_id ="'.$lang_session.'"'));
            $search5 = Document::model()->findAll(array(
                'condition' => ' (dow_name LIKE "%' . $text . '%" OR dow_detail LIKE "%' . $text . '%" ) AND lang_id ="'.$lang_session.'"'));
            $search6 = Imgslide::model()->findAll(array(
                'condition' => ' (imgslide_title LIKE "%' . $text . '%" OR imgslide_detail LIKE "%' . $text . '%" )AND lang_id ="'.$lang_session.'"'));
            
            $searchtotal1 = count($search1);
            $searchtotal2 = count($search2);
            $searchtotal3 = count($search3);
            $searchtotal4 = count($search4);
            $searchtotal5 = count($search5);
            $searchtotal6 = count($search6);
            
            $total = $searchtotal1+$searchtotal2+$searchtotal3+$searchtotal4+$searchtotal5+$searchtotal6 ;
            ?>
            <strong>ผลลัพธ์ทั้งหมด : <?php echo $total; ?> รายการ</strong>
            <br><br>
        </div>
        <!--end total search-->
        <?php if($total > 0) { ?>
        <!-- start usability search -->
        <?php
        if (!empty($search1)){
            echo "<b>".$label->label_usability."</b> ".$label->label_result." ".$searchtotal1." ".$label->label_list."<br>";
        }
        foreach ($search1 as $mod) {
            $str = $mod->usa_title . CHtml::decode($mod->usa_detail);
            $keyword = $text;
            ?>
            <div class="well">
                <a  href="<?php echo $this->createUrl('/usability/index'); ?>">
                    <?php echo str_ireplace($keyword, '<span class="bg-success">' . $keyword . '</span>', $str); ?>
                </a>
            </div>
            <?php
        }
        ?>
        <!-- end usability search -->
        <!-- start news search -->
        <?php
        
        if (!empty($search2)){
            echo "<b>".$label->label_news."</b> ".$label->label_result." ".$searchtotal2." ".$label->label_list."<br>";
        }
        foreach ($search2 as $mod) {
            $str = $mod->cms_title.CHtml::decode($mod->cms_detail);
            $keyword = $text;
            ?>
            <div class="well">
            <a  href="<?php echo $this->createUrl('/news/detail/'.$mod->cms_id ); ?>">
                <?php echo str_ireplace($keyword, '<span class="bg-success">' . $keyword . '</span>', $str); ?>
            </a>
            </div>
            <?php
        }
        ?>
        <!-- end news search -->
        <!-- start course search -->
        <?php
        if (!empty($search3)){
            echo "<b>".$label->label_courseOnline."</b> ".$label->label_result." ".$searchtotal3." ".$label->label_list."<br>";
        }
        foreach ($search3 as $mod) {
            $str = $mod->course_title.$mod->course_short_title.CHtml::decode($mod->course_detail);
            $keyword = $text;
            ?>
            <div class="well">
            <a  href="<?php echo $this->createUrl('/course/detail/'.$mod->course_id ); ?>">
                <?php echo str_ireplace($keyword, '<span class="bg-success">' . $keyword . '</span>', $str); ?>
            </a>
            </div>
            <?php
        }
        ?>
        <!-- end course search -->
        <!-- start vdo search -->
        <?php

        if (!empty($search4)){
            echo "<b>".$label->label_vdo."</b> ".$label->label_result." ".$searchtotal4." ".$label->label_list."<br>";
        }
        foreach ($search4 as $mod) {
            $str = $mod->vdo_title;
            $keyword = $text;
            ?>
            <div class="well">
            <a  href="<?php echo $this->createUrl('/video/detail/'.$mod->vdo_id ); ?>">
                <?php echo str_ireplace($keyword, '<span class="bg-success">' . $keyword . '</span>', $str); ?>
            </a>
            </div>
            <?php
        }
        ?>
        <!-- end vdo search -->
        <!-- start document search -->
        <?php
        
        if (!empty($search5)){
            echo "<b>".$label->label_document."</b> ".$label->label_result." ".$searchtotal5." ".$label->label_list."<br>";
        }
        foreach ($search5 as $mod) {
            $str = $mod->dow_name.CHtml::decode($mod->dow_detail);
            $keyword = $text;
            ?>
            <div class="well">
            <a  href="<?= Yii::app()->baseUrl?> /admin/uploads/<?= $mod->dow_address ?>" download="<?= Yii::app()->baseUrl?> /admin/uploads/<?= $mod->dow_address ?>">
                <?php echo str_ireplace($keyword, '<span class="bg-success">' . $keyword . '</span>', $str); ?>
            </a>
            </div>
            <?php
        }
        ?>
        <!-- end document search -->
        <!-- start imageslide search -->
        <?php
        if (!empty($search6)){
            echo "<b>".$label->label_imgslide."</b> ".$label->label_result." ".$searchtotal6." ".$label->label_list."<br>";
        }
        foreach ($search6 as $mod) {
            $str = $mod->imgslide_title.CHtml::decode($mod->imgslide_detail);
            $keyword = $text;
            ?>
            <div class="well">
            <a  href="<?php echo $this->createUrl('/banner/detail',array('id'=> $mod->imgslide_id)); ?>">
                <?php echo str_ireplace($keyword, '<span class="bg-success">' . $keyword . '</span>', $str); ?>
            </a>
            </div>
            <?php
        }
        ?>
        <!-- end imageslide search -->
        <?php 
        } else {
            echo '<div class="well">';
            echo 'ไม่พบข้อมูลที่ต้องการค้นหา';
            echo '</div>';
        } ?>
        
    </div>
</section>