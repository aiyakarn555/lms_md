<?php
///* @var $this FaqController */
///* @var $dataProvider CActiveDataProvider */
//
//$this->breadcrumbs=array(
//	'Faqs',
//);
//
//$this->menu=array(
//	array('label'=>'Create Faq', 'url'=>array('create')),
//	array('label'=>'Manage Faq', 'url'=>array('admin')),
//);
//?>
<!---->
<!--<h1>Faqs</h1>-->
<!---->
<?php //$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); ?>
<style>
    .panel {
        margin-bottom: 4px;
    }

    .panel-collapse-trigger.panel-heading::after {
        top: 15px;
    }

    .panel-default > .panel-heading:hover {
        color: #333;
        background-color: #F0F0F0;
        border-color: #E2E9E6;
    }
</style>
<div class="parallax overflow-hidden page-section bg-dbd-p">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-dbd-p text-white" style="height: 45px;"><i class="fa fa-fw fa-question-circle"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">คำถามที่พบบ่อย</h3>
<!--                <p class="text-white text-subhead" style="font-size: 1.6rem;">รวมข่าวสารของ Brother</p>-->
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="col-md-9" style="margin-bottom: 25px;">
            <?php
            foreach ($faq_type as $faq_type_data) {
                ?>
                <div class="panel panel-default paper-shadow" data-z="0.5" style="margin-bottom: 25px;">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="media v-middle">
                                <div class="media-body">
                                    <h4 class="text-headline margin-none"
                                        style="font-size: 26px;font-weight: bold;"><?= $faq_type_data->faq_type_title_TH; ?></h4>
                                    <!--                            <p class="text-subhead text-light">คำถามที่พบบ่อย</p>-->
                                </div>
                                <div class="media-right">
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item media v-middle">
                            <?php
                            foreach ($faq_data as $faq) {
                                if ($faq_type_data->faq_type_id == $faq->faq_type_id) {
                                    ?>
                                    <div class="panel panel-default" data-toggle="panel-collapse" data-open="false">
                                        <div class="panel-heading panel-collapse-trigger">
                                            <h3 class="panel-title" style="font-size: 22px;"><img
                                                    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/faq.png"
                                                    alt="person" style="width: 25px;"/> <?= $faq->faq_THtopic; ?></h3>
                                        </div>
                                        <div class="panel-body list-group">
                                            <ul class="list-group list-group-menu">
                                                <li class="list-group-item" style="padding-left: 15px;padding:10px;">
                                                    <?php echo htmlspecialchars_decode($faq->faq_THanswer)?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
            
                                <?php }
                            } ?>
                        </li>
                    </ul>
                </div>
            <?php } ?>
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
                                <input class="form-control" type="text" name="search_text" placeholder="คำค้นหา" value="<?=$_POST['search_text']?>" />
                            </div>
                        </div>
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo CHtml::endForm();?>
        </div>
    </div>
</div>

