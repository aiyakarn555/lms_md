<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- <div class="span-19"> -->
	<div id="content">
		<?php if(isset($this->breadcrumbs)):?>
		    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
		        'links'=>$this->breadcrumbs,
		        'htmlOptions'=>array('class'=>'breadcrumb'),
		        'tagName'=>'ul', // will change the container to ul
		        'activeLinkTemplate'=>'<li><a href="{url}">{label}</a></li>', // will generate the clickable breadcrumb links 
		        'inactiveLinkTemplate'=>'<li>{label}</li>', // will generate the current page url : <li>News</li>
		        'homeLink'=>'<li><a href="'.Yii::app()->homeUrl.'">หน้าหลัก</a></li>' // will generate your homeurl item : <li><a href="/dr/dr/public_html/">Home</a></li>
		    )); ?><!-- breadcrumbs -->
		<?php endif?>
		<div class="separator bottom"></div>
		<?php echo $content; ?>
		<div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div><!-- content -->
<!-- </div> -->
<!-- <div class="span-5 last"> -->
<!-- </div> -->
<?php $this->endContent(); ?>