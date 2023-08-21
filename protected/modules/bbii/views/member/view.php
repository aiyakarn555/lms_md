<?php
/* @var $this MemberController */
/* @var $model BbiiMember */
/* @var $dataProvider CActiveDataProvider BbiiPost */
/* @var $topicProvider CActiveDataProvider BbiiTopic*/
$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Members')=>array('member/index'),
	$model->member_name . Yii::t('BbiiModule.bbii', '\'s profile'),
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'), 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'โพส'), 'url'=>array('moderator/admin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
);

$df = Yii::app()->dateFormatter;
?>

<?php if(Yii::app()->user->hasFlash('notice')): ?>
<div class="flash-notice">
	<?php echo Yii::app()->user->getFlash('notice'); ?>
</div>
<?php endif; ?>

<style>
	.grid-view{
		padding: 0 !important;
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


				<div class="panel panel-default paper-shadow" data-z="0.5">
					<div class="panel-body">
						<div class="media media-clearfix-xs">
							<div class="media-left text-center">
								<div class="cover width-150 width-100pc-xs overlay cover-image-full hover margin-v-0-10">
									<?php echo CHtml::image((isset($model->avatar))?(Yii::app()->request->baseUrl . $this->module->avatarStorage . '/'. $model->avatar):$this->module->getRegisteredImage('empty.jpeg'), 'avatar'); ?>
								</div>
							</div>
							<div class="media-body">
								<h4 class="text-headline margin-v-5-0"><a href="website-course.html"><?php echo CHtml::encode($model->member_name) . Yii::t('BbiiModule.bbii', '\'s profile'); ?></a></h4>
								<div class="form-group">
									<br>
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Member since'); ?></label>
											<div class="input-group">
												<?php echo $df->formatDateTime($model->first_visit, 'long', 'medium'); ?>
											</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Last visit'); ?></label>
									<div class="input-group">
										<?php echo $df->formatDateTime($model->last_visit, 'long', 'medium'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Number of posts'); ?></label>
									<div class="input-group">
										<?php echo CHtml::encode($model->posts); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Reputation'); ?></label>
									<div class="input-group">
										<?php echo CHtml::encode($model->upvoted); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Group'); ?></label>
									<div class="input-group">
										<?php if(isset($model->group)) echo CHtml::encode($model->group->name); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Location'); ?></label>
									<div class="input-group">
										<?php echo (isset($model->location))?CHtml::encode($model->location):Yii::t('BbiiModule.bbii', 'Unknown'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Birthdate'); ?></label>
									<div class="input-group">
										<?php echo (isset($model->birthdate))?$df->formatDateTime($model->birthdate, 'long', null):Yii::t('BbiiModule.bbii', 'Unknown'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Gender'); ?></label>
									<div class="input-group">
										<?php echo (isset($model->gender))?(($model->gender)?Yii::t('BbiiModule.bbii', 'Female'):Yii::t('BbiiModule.bbii', 'Male')):Yii::t('BbiiModule.bbii', 'Unknown'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Presence on the internet'); ?></label>
									<div class="input-group">
										<?php
										if($model->contact_email && $this->module->userMailColumn){
										echo Chtml::link(CHtml::image($this->module->getRegisteredImage('User.png'), 'e-mail', array('title'=>Yii::t('BbiiModule.bbii', 'Contact user by e-mail'))), array('member/mail', 'id'=>$model->id));
										}
										if(($model->blogger)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Blogger.png'), 'Blogger', array('title'=>'Blogger')), $model->blogger, array('target'=>'_blank'));
										}
										if(($model->flickr)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Flickr.png'), 'Flickr', array('title'=>'Flickr')), $model->flickr, array('target'=>'_blank'));
										}
										if(($model->google)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Google.png'), 'Google', array('title'=>'Google')), $model->google, array('target'=>'_blank'));
										}
										if(($model->linkedin)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Linkedin.png'), 'Linkedin', array('title'=>'Linkedin')), $model->linkedin, array('target'=>'_blank'));
										}
										if(($model->metacafe)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Metacafe.png'), 'Metacafe', array('title'=>'Metacafe')), $model->metacafe, array('target'=>'_blank'));
										}
										if(($model->myspace)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Myspace.png'), 'Myspace', array('title'=>'Myspace')), $model->myspace, array('target'=>'_blank'));
										}
										if(($model->orkut)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Orkut.png'), 'Orkut', array('title'=>'Orkut')), $model->orkut, array('target'=>'_blank'));
										}
										if(($model->tumblr)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Tumblr.png'), 'Tumblr', array('title'=>'Tumblr')), $model->tumblr, array('target'=>'_blank'));
										}
										if(($model->twitter)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Twitter.png'), 'Twitter', array('title'=>'Twitter')), $model->twitter, array('target'=>'_blank'));
										}
										if(($model->website)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Globe.png'), 'Website', array('title'=>'Website')), $model->website, array('target'=>'_blank'));
										}
										if(($model->wordpress)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Wordpress.png'), 'Wordpress', array('title'=>'Wordpress')), $model->wordpress, array('target'=>'_blank'));
										}
										if(($model->yahoo)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Yahoo.png'), 'Yahoo', array('title'=>'Yahoo')), $model->yahoo, array('target'=>'_blank'));
										}
										if(($model->facebook)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Facebook.png'), 'Facebook', array('title'=>'Facebook')), $model->facebook, array('target'=>'_blank'));
										}
										if(($model->youtube)){
											echo Chtml::link(CHtml::image($this->module->getRegisteredImage('Youtube.png'), 'Youtube', array('title'=>'Youtube')), $model->youtube, array('target'=>'_blank'));
										}
										if(empty($model->blogger) && empty($model->facebook) && empty($model->flickr) && empty($model->google)
										&& empty($model->linkedin) && empty($model->metacafe) && empty($model->orkut) && empty($model->tumblr)
										&& empty($model->twitter) && empty($model->website) && empty($model->wordpress) && empty($model->yahoo)
										&& empty($model->youtube)){
											echo "Null";
										}
										?>

									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii', 'Personal text'); ?></label>
									<div class="input-group">
										<?php if(isset($model->personal_text)){
											echo CHtml::encode($model->personal_text);
										}else{
											echo "Null";
										}
										 ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"><?php echo Yii::t('BbiiModule.bbii','Recent Posts'); ?></label>
									<div class="input-group">
										<?php $this->widget('zii.widgets.CListView', array(
											'dataProvider'=>$dataProvider,
											'itemView'=>'_post',
											'summaryText'=>false,
										));
										?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4"></label>
									<div class="input-group">
										<?php if($topicProvider->getItemCount()) { $this->renderPartial('_watch', array('topicProvider'=>$topicProvider)); } ?>
									</div>
								</div>
								<hr class="margin-v-8" />
								<div class="media v-middle">
									<div class="media-right">
										<?php if($this->isModerator() || $model->id == Yii::app()->user->id): ?>
											<?php echo CHtml::htmlButton(Yii::t('BbiiModule.bbii', 'Edit profile'), array('class'=>'btn btn-primary', 'onclick'=>'js:document.location.href="' . $this->createAbsoluteUrl('member/update', array('id'=>$model->id)) .'"')); ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
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
