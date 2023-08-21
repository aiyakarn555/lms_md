<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $topic BbiiTopic */
/* @var $dataProvider CActiveDataProvider */
/* @var $postId integer */

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getClientScript()->getCoreScriptUrl().'/jui/js/jquery-ui-i18n.min.js',CClientScript::POS_END);
$this->bbii_breadcrumbs=array(
//	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
//	$forum->name => array('forum/forum', 'id'=>$forum->id),
//	$topic->title,
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
);
?>
<div class="container">
	<div class="page-section">
		<div class="col-md-8 col-lg-9">
				<?php $this->widget('zii.widgets.CListView', array(
					'id'=>'bbiiPost',
					'dataProvider'=>$dataProvider,
					'itemView'=>'_post',
					'viewData'=>array('postId'=>$postId),
					'template'=>'{pager}{items}{pager}',
					'pager'=>array('firstPageCssClass'=>'previous', 'lastPageCssClass'=>'next', 'firstPageLabel'=>'<<', 'lastPageLabel'=>'>>'),
					'afterAjaxUpdate'=>'function(){$(window).scrollTop(0);}',
				));
				?>
				<?php if(Yii::app()->user->isGuest): ?>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="text-right">
								<div class="col-xs-12 text-center"><a href="<?php echo $this->createUrl('/user/login'); ?>" class="navbar-btn btn btn-primary"> เข้าสู่ระบบ</a></div>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if(!(Yii::app()->user->isGuest || $topic->locked) || $this->isModerator()): ?>
				<div class="panel panel-default">
					<div class="panel-body">
							<div class="text-right">
								<?php $form=$this->beginWidget('CActiveForm', array(
									'id'=>'create-post-form',
									'action'=>array('forum/reply', 'id'=>$topic->id),
									'enableAjaxValidation'=>false,
								)); ?>
									<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii','ตอบกลับ'), array('class'=>'btn btn-primary')); ?>
								<?php $this->endWidget(); ?>
							</div>
					</div>
				</div>
				<?php endif; ?>
				</div>
				<?php
				//right Menu
				echo $this->renderPartial('_right'); ?>
		</div>
	</div>
