<?php
///* @var $this List_newsController */
///* @var $dataProvider CActiveDataProvider */
//
//$this->breadcrumbs=array(
//	'News',
//);
//
//$this->menu=array(
//	array('label'=>'Create News', 'url'=>array('create')),
//	array('label'=>'Manage News', 'url'=>array('admin')),
//);
//?>
<!---->
<!--<h1>News</h1>-->
<!---->
<?php //$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); ?>
<!--<div class="parallax bg-white page-section">-->
<!--    <div class="container parallax-layer" data-opacity="true">-->
<!--        <div class="media v-middle">-->
<!--            <div class="media-body">-->
<!--                <h1 class="text-display-2 margin-none">ข่าวสาร</h1>-->
<!---->
<!--                <p class="text-light lead">รวมข่าวสารของ Brother</p>-->
<!--            </div>-->
<!--            <!-- <div class="media-right">-->
<!--                <div class="width-100 text-right">-->
<!--                    <div class="btn-group">-->
<!--                        <a class="btn btn-grey-900" href="website-directory-grid.html"><i class="fa fa-th"></i></a>-->
<!--                        <a class="btn btn-white" href="website-directory-list.html"><i class="fa fa-list"></i></a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div> -->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i class="fa fa-fw fa-newspaper-o"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">ข่าวสาร</h3>
                <p class="text-white text-subhead" style="font-size: 1.6rem;">รวมข่าวสารของ Brother</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-9">
                <?php
                $i = 0;
                foreach ($news_data as $news) {
                    $folder = explode("_", $news->cms_id);
                    $imageShow = Yii::app()->request->baseUrl . '/uploads/news/' . $folder[0] . '/thumb/' . $news->cms_picture;
//    $check_image = is_file('C:/AppServ/www/BrotherYii1/uploads/news/'. $folder[0] .'/thumb/' . $news->cms_picture);
                    ?>
                    <div class="panel panel-default paper-shadow" data-z="0.5" style="margin-bottom: 25px;">
                        <div class="panel-body">
                            <div class="media media-clearfix-xs">
                                <div class="media-left text-center">
                                    <div
                                        class="cover width-150 width-100pc-xs overlay cover-image-full hover margin-v-0-10">
                                        <?php if ($imageShow != "") { ?>
                                            <img src="<?=$imageShow;?>"/>
                                        <?php } else { ?>
                                            <img src="http://placehold.it/150x130"/>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h4 class="text-headline margin-v-5-0" style="font-size: 28px;"><a
                                            href="<?= Yii::app()->createUrl('news/index/', array('id' => $news->cms_id)); ?>"
                                            title="<?= $news->cms_title; ?>"><?= $news->cms_title; ?></a></h4>

                                    <p style="color: rgb(33, 33, 33);"><?= iconv_substr($news->cms_short_title, 0, 200, 'utf-8'); ?></p>
                                    <hr class="margin-v-8"/>
                                    <div class="media v-middle">
                                        <div class="media-body">
                                            <?php $user = Users::model()->findByPk($news->create_by); ?>
                                            <h6> posted by
                                                <i class="fa fa-fw fa-comment"
                                                   style="color:#42A5F5;"></i> <?= $user->username; ?> &nbsp; | <i
                                                    class="fa fa-fw fa-calendar"
                                                    style="color:#42A5F5;"></i> <?= $news->create_date; ?>
                                                <br/>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++;
                } ?>
                <div style="float: right;">
                <?php $this->widget('CLinkPager', array(
                    'pages' => $pages,
                    'header' => '',
                    'maxButtonCount' => 6,
                    'selectedPageCssClass' => 'active',
                    'htmlOptions' => array('class' => 'pagination margin-top-none'),
                )) ?>
                </div>
            </div>
            <div class="col-md-3">
                <?php echo CHtml::form();?>
                <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
                    <div class="panel-heading panel-collapse-trigger">
                        <h4 class="panel-title" style="font-weight: bold;">ค้นหา</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group input-group margin-none">
                            <div class="row margin-none">
                                <div class="col-xs-12 padding-none">
                                    <input class="form-control" type="text" id="search_text" name="search_text" placeholder="คำค้นหา"/>
                                </div>
                            </div>
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo CHtml::endForm();?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title" style="font-weight: bold;">ข่าวล่าสุด</h4>
                    </div>
                    <ul class="list-group list-group-menu">
                        <?php
                        $news_data = News::model()->findAll(array(
                            'condition' => 'active="y"',
                            'order' => 'create_date DESC',
                            'limit' => '5',
                        ));
                        if ($news_data) {
                            foreach($news_data as $news){
                                ?>
                                <li class="list-group-item">
                                    <a href="<?= Yii::app()->createUrl('news/index/', array('id' => $news->cms_id));?>"><i class="fa fa-chevron-right fa-fw"></i> <?=$news->cms_title;?></a>
                                </li>
                            <?php
                            } }?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
