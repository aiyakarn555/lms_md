<?php
/* @var $this ForumController */
/* @var $item array */
?>
		<?php if(!Yii::app()->user->isGuest): ?>
			<div class="bbii-profile-box">
			<?php echo CHtml::link(Yii::t('BbiiModule.bbii', 'Forum'), array('forum/index')); ?></div>
		<?php endif; ?>
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>$item,
				'htmlOptions'=>array(
					'class'=>'nav nav-pills',
				),
			)); ?>

	<?php if(isset($this->bbii_breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink'=>false,
			'links'=>$this->bbii_breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>