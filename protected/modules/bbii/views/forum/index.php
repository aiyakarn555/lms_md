<?php
/* @var $this ForumController */
/* @var $dataProvider CArrayDataProvider */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum'),
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'). ' (' . $approvals . ')', 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รายงาน'). ' (' . $reports . ')', 'url'=>array('moderator/report'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
);
?>
<style>
    .list-view .summary{
        margin: 0!important;
    }
</style>
<!--<div class="parallax bg-white page-section">-->
<!--    <div class="container parallax-layer" data-opacity="true">-->
<!--        <div class="media v-middle">-->
<!--            <div class="media-body">-->
<!--                <h1 class="text-display-2 margin-none">เว็บบอร์ด</h1>-->
<!--                <p class="text-light lead">เว็บบอร์ดของหลักสูตร</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<div class="parallax overflow-hidden page-section bg-dbd-p">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-dbd-p text-white" style="height: 45px;"><i class="fa fa-fw fa-comments-o"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">เว็บบอร์ด</h3>
                <p class="text-white text-subhead" style="font-size: 1.6rem;">เว็บบอร์ดของหลักสูตร</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->renderPartial('_header', array('item'=>$item)); ?>
            </div>
            <div class="col-md-8 col-lg-9">
                        <?php $this->widget('zii.widgets.CListView', array(
                            'id'=>'bbiiForum',
                            'dataProvider'=>$dataProvider,
                            'itemView'=>'_forum',
                            'viewData'=>array('lastIndex'=>($dataProvider->totalItemCount - 1)),
                            'summaryText'=>false,
                        )); ?>
                <br/>
            </div>




            <?php
            //right Menu
            echo $this->renderPartial('_right'); ?>


        </div>
    </div>
</div>
<div id="bbii-wrapper">



	
	<?php //echo $this->renderPartial('_footer'); ?>
	<?php //if(!Yii::app()->user->isGuest) echo CHtml::link(Yii::t('BbiiModule.bbii','Mark all read'), array('forum/markAllRead')); ?>
</div>