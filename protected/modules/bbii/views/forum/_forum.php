<?php
/* @var $this ForumController */
/* @var $data BbiiForum */

	$image = 'forum';
	if(!isset($data->last_post_id) || $this->forumIsRead($data->id)) {
		$image .= '2';
	} else {
		$image .= '1';
	}
	if($data->locked) {
		$image .= 'l';
	}
	if($data->moderated) {
		$image .= 'm';
	}
	if(!$data->public) {
		$image .= 'h';
	}
?>

<?php if($data->type){ ?>

    <li class="list-group-item media v-middle">
        <div class="media-left">
            <div class="icon-block half img-circle bg-grey-300">
                <i class="fa fa-file-text text-white"></i>
            </div>
        </div>
        <div class="media-body">
            <h4 class="text-subhead margin-none" style="font-size: 22px;">
                <?php echo CHtml::link(Helpers::lib()->banKeyword(CHtml::encode($data->name)), array('forum', 'id'=>$data->id,'class'=>'link-text-color')); ?>
                <small><?php echo Helpers::lib()->banKeyword(CHtml::encode($data->subtitle)); ?></small>
            </h4>
            <?php if($data->last_post_id && $data->lastPost) { ?>
                <div class="text-light text-caption" style="font-size: 1.4rem;">
                    posted by
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course2.png" alt="person" class="img-circle width-20" /> <?=CHtml::encode($data->lastPost->poster->member_name);?><?=CHtml::link(CHtml::image($this->module->getRegisteredImage('next.png'), 'next', array('style'=>'margin-left:5px;')), array('topic', 'id'=>$data->lastPost->topic_id, 'nav'=>'last'));?> &nbsp; | <i class="fa fa-calendar fa-fw"></i> <?=DateTimeCalculation::long($data->lastPost->create_time);?>
                </div>
            <?php
            } else {
                echo Yii::t('BbiiModule.bbii', 'No posts');
            }
            ?>

        </div>
        <div class="media-right">
            <?php echo CHtml::link(CHtml::encode($data->num_posts),array('forum', 'id'=>$data->id,'class'=>'link-text-color'),array('class'=>'btn btn-white text-light'));?>
<!--            <a href="#" class="btn btn-white text-light"><i class="fa fa-comments fa-fw"></i> --><?php //echo CHtml::encode($data->num_posts); ?><!--</a href="#">-->
        </div>
        <div class="media-right">
            <?php echo CHtml::link(CHtml::encode($data->num_topics),array('forum', 'id'=>$data->id,'class'=>'link-text-color'),array('class'=>'btn btn-white text-light'));?>
<!--            <a href="#" class="btn btn-white text-light"><i class="fa fa-comments fa-fw"></i> --><?php //echo CHtml::encode($data->num_topics); ?><!--</a>-->
        </div>
    </li>

<?php }else{ ?>
<?php if($index > 0) { echo '</div>'; } ?>
<div class="panel panel-default paper-shadow" data-z="0.5">
	<div class="forum-category" onclick="BBii.toggleForumGroup(<?php echo $data->id; ?>,'<?php echo Yii::app()->createAbsoluteUrl($this->module->id.'/forum/setCollapsed'); ?>');">
        <ul class="list-group" style="margin-bottom: 10px;">
            <li class="list-group-item" style="border:none;">
                <div class="media v-middle">
                    <div class="media-body">
                        <h3 class="text-headline margin-none" style="font-size: 28px;"><?php echo Helpers::lib()->banKeyword(CHtml::encode($data->name)); ?></h3>
                        <p class="text-subhead text-light" style="font-size: 1.7rem;"><?php echo Helpers::lib()->banKeyword(CHtml::encode($data->subtitle)); ?></p>
                    </div>
                </div>
            </li>
        </ul>
	</div>
    <ul class="list-group">
<?php } ?>

<?php if($index == $lastIndex) { echo '</ul></div>'; } ?>
