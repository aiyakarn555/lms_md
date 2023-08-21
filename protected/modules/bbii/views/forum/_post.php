<?php
/* @var $this ForumController */
/* @var $data BbiiPost */
/* @var $postId integer */
?>
				<div class="panel panel-default">
					<div class="panel-body">
				<div class="page-section padding-top-none">
					<div class="media media-overflow-visible s-container">
						<div class="media-body">
							<h1 class="text-display-1 margin-top-none <?php echo (isset($postId) && $postId == $data->id)?' target':''; ?>"><?php echo Helpers::lib()->banKeyword(CHtml::encode($data->subject)); ?></h1>
							<p class="text-light text-caption" style="font-size: 18px;">
								posted by
								<a href="<?php echo Yii::app()->createUrl('forum/member/view',array('id'=>$data->poster->id))?>">
									<?php echo CHtml::image((isset($data->poster->avatar))?(Yii::app()->request->baseUrl . $this->module->avatarStorage . '/'. $data->poster->avatar):$this->module->getRegisteredImage('empty.jpeg'), 'avatar',array('class'=>'img-circle width-20')); ?>
									<?php echo CHtml::encode($data->poster->member_name); ?></a> &nbsp; | <?php echo DateTimeCalculation::full($data->create_time); ?>
								<?php echo ' &raquo; <span class="reputation" title="' . Yii::t('BbiiModule.bbii','Reputation') . '">' . $data->upvoted . '</span>'; ?>
							</p>
						</div>
						<div class="media-right">
							<?php if(!(Yii::app()->user->isGuest || $data->topic->locked) || $this->isModerator()): ?>
									<?php $form=$this->beginWidget('CActiveForm', array(
										'action'=>array('forum/quote', 'id'=>$data->id),
										'enableAjaxValidation'=>false,
									)); ?>
									<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii','Quote'), array('class'=>'btn btn-white paper-shadow relative')); ?>
									<?php $this->endWidget(); ?>
							<?php endif; ?>
						</div>
						<div class="media-right">
							<?php if(!($data->user_id != Yii::app()->user->id || $data->topic->locked) || $this->isModerator()): ?>
									<?php $form=$this->beginWidget('CActiveForm', array(
										'action'=>array('forum/update', 'id'=>$data->id),
										'enableAjaxValidation'=>false,
									)); ?>
									<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii','Edit'), array('class'=>'btn btn-white paper-shadow relative')); ?>
									<?php $this->endWidget(); ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="media s-container">
					<div class="media-left">
						<div class="width-70 text-center">
							<p>
								<a href="<?php echo Yii::app()->createUrl('forum/member/view',array('id'=>$data->poster->id))?>">
									<?php echo CHtml::image((isset($data->poster->avatar))?(Yii::app()->request->baseUrl . $this->module->avatarStorage . '/'. $data->poster->avatar):$this->module->getRegisteredImage('empty.jpeg'), 'avatar',array('class'=>'width-50')); ?>
								</a>
							</p>
							<p class="text-caption text-light" style="font-size: 15px;">
								<?php echo Yii::t('BbiiModule.bbii', 'Posts') . ': ' . CHtml::encode($data->poster->posts); ?>
								<br>
								<?php if(!Yii::app()->user->isGuest): ?>
									<?php echo CHtml::image($this->module->getRegisteredImage('warn.png'), 'warn', array('title'=>Yii::t('BbiiModule.bbii', 'Report post'), 'style'=>'cursor:pointer;', 'onclick'=>'reportPost(' . $data->id . ')')); ?>
									<?php echo CHtml::link( CHtml::image($this->module->getRegisteredImage('pm.png'), 'pm', array('title'=>Yii::t('BbiiModule.bbii', 'Send private message'))), array('message/create', 'id'=>$data->user_id) ); ?>
									<?php echo $this->showUpvote($data->id); ?>
								<?php endif; ?>
							</p>
						</div>
					</div>
					<div class="media-body">
						<div class="panel panel-default">
							<div class="panel-body">
								<p><?php echo Helpers::lib()->banKeyword($data->content); ?></p>
							</div>
						</div>
							<div class="text-right">
								<?php if($this->isModerator()): ?>
									<?php echo CHtml::link( CHtml::image($this->module->getRegisteredImage('warn.png'), 'warn', array('title'=>Yii::t('BbiiModule.bbii', 'Warn user'))), array('message/create', 'id'=>$data->user_id, 'type'=>1) ); ?>
									<?php echo CHtml::image($this->module->getRegisteredImage('delete.png'), 'delete', array('title'=>Yii::t('BbiiModule.bbii', 'Delete post'), 'style'=>'cursor:pointer;', 'onclick'=>'if(confirm("' . Yii::t('BbiiModule.bbii','Do you really want to delete this post?') . '")) { deletePost("' . $this->createAbsoluteUrl('moderator/delete', array('id'=>$data->id)) . '") } location.reload(); ')); ?>
									<?php echo CHtml::image($this->module->getRegisteredImage('ban.png'), 'ban', array('title'=>Yii::t('BbiiModule.bbii', 'Ban IP address'), 'style'=>'cursor:pointer;', 'onclick'=>'if(confirm("' . Yii::t('BbiiModule.bbii','Do you really want to ban this IP address?') . '")) { banIp(' . $data->id . ', "' . $this->createAbsoluteUrl('moderator/banIp') . '") }')); ?>
								<?php endif; ?>
							</div>
					</div>
				</div>
	</div>
</div>
