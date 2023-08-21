<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $topic BbiiTopic */
/* @var $post BbiiPost */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	$forum->name => array('forum/forum', 'id'=>$forum->id),
	$topic->title => array('forum/topic', 'id'=>$topic->id),
	Yii::t('BbiiModule.bbii', 'Reply'),
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary'))
);
?>
<style>
	.list-view .summary{
		margin: 0!important;
	}
</style>
<div class="parallax bg-white page-section">
	<div class="container parallax-layer" data-opacity="true">
		<div class="media v-middle">
			<div class="media-body">
				<h1 class="text-display-2 margin-none">เว็บบอร์ด</h1>
				<p class="text-light lead">เว็บบอร์ดของหลักสูตร</p>
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
				<div class="panel panel-default">
					<div class="panel-body">

	<?php echo $this->renderPartial('_form', array('post'=>$post)); ?>
							<br/>
					</div>
					</div>
				<br/>
			</div>
			<?php
			//right Menu
			echo $this->renderPartial('_right'); ?>


		</div>
	</div>
</div>

</div>
