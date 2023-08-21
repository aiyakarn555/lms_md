<!DOCTYPE html>
<style>
    .course-detail2{
        display: block;
        -webkit-margin-before: 1.33em;
        -webkit-margin-after: 1.33em;
        -webkit-margin-start: 0px;
        -webkit-margin-end: 0px;
    }
    .text11{
        color: #e32526;
        font-size: 22px;
        margin-bottom: 0px;
        text-align: center;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        height: 27px;
    }
    .p{
        /*font-size: 17px;*/
        /*margin-top: 10px;*/
        /*margin-bottom: 10px;*/
        text-align: center;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        height: 20px;
    }
</style>
<html lang="th">

    <!-- Head -->
    <?php include './include/head.php'; ?>

    <body>

        <!-- Header -->
        <?php include './include/header.php'; ?>

        <!-- Header page -->
        <div class="header-page parallax-window" >
    <div class="container">
        <h1><?= $label->label_linkall ?>  
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage ?></a></li> /
                    <li><span class="text-bc"><?= $label->label_linkall ?></span></li>
                </ul>
            </small>
        </h1>
    </div>
</div>


        <!-- Content -->
        <section class="content" id="link">
            <div class="container">
                <div class="row">
                    <?php
                    $criteria =new CDbCriteria;
                    $criteria->order = 'updatedate  DESC';
                    $criteria->condition='active = 1'; 
                     ?>
                    <?php $link = FeaturedLinks::model()->findAll($criteria); ?>
                    <?php foreach ($link as $all) { ?>
                        <div class="col-xs-12 col-sm-4 col-md-3">
                            <div class="well">
                                <a href="<?php echo $all->link_url; ?>">
                                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/featuredlinks/original/' . $all->link_image)) { ?>
                                        <div class="link-img" style="background-image: url(<?php echo Yii::app()->request->baseUrl; ?>/uploads/featuredlinks/original/<?php echo $all->link_image; ?>);"></div>
                                    <?php } else { ?>
                                        <div class="link-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/c3.png);"></div>
                                    <?php } ?>
                                        <h4 class="text11"><?php echo $all->link_name; ?></h4>
                                        <small class="p"><?php echo $all->link_url; ?></small>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>		

            <!-- Footer -->
            <?php include './include/footer.php'; ?>

            <!-- Script -->
            <?php include './include/script.php'; ?>

    </body>
</html>