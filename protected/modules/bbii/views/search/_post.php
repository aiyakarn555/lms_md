<?php
/* @var $this SearchController */
/* @var $data BbiiPost */
?>
<li class="list-group-item">
	<div class="media v-middle">
		<div class="media-body">
			<h4 class="text-headline margin-none" style="font-size: 22px;"><?php echo CHtml::link(CHtml::encode($data->subject), array('forum/topic', 'id'=>$data->topic_id, 'nav'=>$data->id)); ?></h4>
			<p class="text-subhead text-light" style="font-size: 19px;">แสดงความคิดเห็นเกี่ยวกับหลักสูตร</p>
			posted by
			<a href="#">
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course2.png" alt="person" class="img-circle width-20" /> <?php echo '&nbsp;&raquo; ' . CHtml::encode($data->poster->member_name); ?></a><?=CHtml::link(CHtml::image($this->module->getRegisteredImage('next.png'), 'next', array('style'=>'margin-left:5px;')));?> &nbsp; | <i class="fa fa-calendar fa-fw"></i> <?php echo ' &raquo; ' . DateTimeCalculation::full($data->create_time); ?>
			<?php echo Yii::t('BbiiModule.bbii','in'); ?>
			<?php echo CHtml::link($data->forum->name, array('forum/forum', 'id'=>$data->forum_id)); ?>
			<?php echo $this->getSearchedString($data->content, 10); ?>
		</div>
	</div>
</li>
<li class="list-group-item">
	<div class="media v-middle">
		<div class="media-body">
			<?php echo CHtml::link(Yii::t('BbiiModule.bbii','View Topic'), array('forum/topic', 'id'=>$data->topic_id),array('class'=>'btn btn-primary')); ?>
		</div>
	</div>
</li>
