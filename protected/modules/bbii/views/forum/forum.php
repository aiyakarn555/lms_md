<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $dataProvider CArrayDataProvider */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	$forum->name,
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'). ' (' . $approvals . ')', 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(),'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รายงาน'). ' (' . $reports . ')', 'url'=>array('moderator/report'), 'visible'=>$this->isModerator(),'linkOptions'=>array('class'=>'btn btn-primary')),
);
?>
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
				<li class="list-group-item">
					<div class="media v-middle">
						<div class="media-body">
							<h1 class="text-headline margin-none" style="font-size: 42px;"><?php echo $forum->name; ?></h1>
							<p class="text-subhead text-light" style="font-size: 19px;">แสดงความคิดเห็นเกี่ยวกับหลักสูตร</p>
						</div>
					</div>
				</li>
				<ul class="list-group">
					<?php if(!(Yii::app()->user->isGuest || $forum->locked) || $this->isModerator()): ?>
					<li class="list-group-item">
						<div class="media v-middle">
							<div class="media-body">
								<?php $form=$this->beginWidget('CActiveForm', array(
									'id'=>'create-topic-form',
									'action'=>array('forum/createTopic'),
									'enableAjaxValidation'=>false,
								)); ?>
								<?php echo $form->hiddenField($forum, 'id'); ?>
								<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii','สร้างหัวข้อใหม่'), array('class'=>'btn btn-primary')); ?>
								<?php $this->endWidget(); ?>
							</div>
						</div>
					</li>
					<?php endif; ?>

						<?php $this->widget('zii.widgets.CListView', array(
							'id'=>'bbiiTopic',
							'dataProvider'=>$dataProvider,
							'itemView'=>'_topic',
							'template' => '{items}{pager}',
						)); ?>
					</ul>



				<br/>
			</div>
			<?php
			//right Menu
			echo $this->renderPartial('_right'); ?>


		</div>
	</div>
</div>

</div>
