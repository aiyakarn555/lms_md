<?php
/* @var $this ForumController */
/* @var $data BbiiTopic */
?>
	<li class="list-group-item media v-middle">
		<div class="media-left">
			<div class="icon-block half img-circle bg-grey-300">
				<i class="fa fa-file-text text-white"></i>
			</div>
		</div>
		<div class="media-body">
			<h4 class="text-subhead margin-none" style="font-size: 22px;">
				<a href="<?php echo $this->createUrl('forum/detail'); ?>" class="link-text-color"><?php echo CHtml::link(Helpers::lib()->banKeyword(CHtml::encode($data->title)), array('topic', 'id'=>$data->id), array('class'=>$data->hasPostedClass())); ?></a>
			</h4>
			<div class="text-light text-caption" style="font-size: 18px;">
				posted by
				<a href="#">
					<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course2.png" alt="person" class="img-circle width-20" /> <?=CHtml::encode($data->starter->member_name);?></a><?=CHtml::link(CHtml::image($this->module->getRegisteredImage('next.png'), 'next', array('style'=>'margin-left:5px;')), array('topic', 'id'=>$data->lastPost->topic_id, 'nav'=>'last'));?> &nbsp; | <i class="fa fa-calendar fa-fw"></i> <?=DateTimeCalculation::medium($data->firstPost->create_time);?>
			</div>
		</div>
		<div class="media-right">
			<?php echo CHtml::link(CHtml::encode($data->num_replies),array('topic', 'id'=>$data->lastPost->topic_id),array('class'=>'btn btn-white text-light'));?>
		</div>
		<div class="media-right">
			<?php echo CHtml::link(CHtml::encode($data->num_views),array('topic', 'id'=>$data->lastPost->topic_id),array('class'=>'btn btn-white text-light'));?>
		</div>
	</li>
