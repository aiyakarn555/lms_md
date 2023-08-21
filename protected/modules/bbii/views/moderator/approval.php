<?php
/* @var $this ModeratorController */
/* @var $model BbiiPost */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Approval'),
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'). ' (' . $approvals . ')', 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รายงาน'). ' (' . $reports . ')', 'url'=>array('moderator/report'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'โพส'), 'url'=>array('moderator/admin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'กรองคำหยาบ'), 'url'=>array('moderator/keywordadmin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
    array('label'=>Yii::t('BbiiModule.bbii', 'ไอพีที่ถูกบล็อค'), 'url'=>array('moderator/ipadmin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ส่งเมล'), 'url'=>array('moderator/sendmail'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
);
?>
<style>
    .grid-view{
        padding: 0 !important;
    }
</style>
<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i class="fa fa-fw fa-comments-o"></i></span>
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
            <div class="col-md-12" style="padding-bottom: 15px;">

                <?php echo $this->renderPartial('_header', array('item'=>$item)); ?>

            </div>
            <div class="col-md-8 col-lg-9">


                <?php
                $dataProvider = $model->search();
                $dataProvider->setPagination(array('pageSize'=>10));
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'approval-grid',
                    'dataProvider'=>$dataProvider,
                    'template' => '{items}{pager}',
                    'htmlOptions'=>array(
                        'class'=>'panel panel-default',
                    ),
                    'itemsCssClass'=>'table v-middle',
                    'columns'=>array(
                        array(
                            'name'=>'user_id',
                            'value'=>'$data->poster->member_name'
                        ),
                        'subject',
                        'ip',
                        array(
                            'name' => 'create_time',
                            'value' => 'DateTimeCalculation::long($data->create_time)',
                        ),
                        array(
                            'header' => 'Action',
                            'class'=>'CButtonColumn',
                            'template'=>'{view}{approve}{delete}',
                            'buttons' => array(
                                'view' => array(
                                    'url'=>'$data->id',
                                    'imageUrl'=>$this->module->getRegisteredImage('view.png'),
                                    'click'=>'js:function() { viewPost($(this).attr("href"), "' . $this->createAbsoluteUrl('moderator/view') .'");return false; }',
                                ),
                                'approve' => array(
                                    'url'=>'array("approve", "id"=>$data->id)',
                                    'label'=>Yii::t('BbiiModule.bbii','Approve'),
                                    'imageUrl'=>$this->module->getRegisteredImage('approve.png'),
                                    'options'=>array('style'=>'margin-left:5px;'),
                                ),
                                'delete' => array(
                                    'imageUrl'=>$this->module->getRegisteredImage('delete.png'),
                                    'options'=>array('style'=>'margin-left:5px;'),
                                ),
                            )
                        ),
                    ),
                )); ?>




                <br/>
            </div>




            <?php
            //right Menu
            echo $this->renderPartial('_right'); ?>


        </div>
    </div>
</div>