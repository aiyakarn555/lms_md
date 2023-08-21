<?php
/* @var $this ForumController */
/* @var $model BbiiSetting */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Settings')=>array('setting/index'),
	Yii::t('BbiiModule.bbii', 'Moderators')
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'การตั้งค่า'), 'url'=>array('setting/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รูปแบบเว็บบอร์ด'), 'url'=>array('setting/layout'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'จัดกลุ่มสมาชิก'), 'url'=>array('setting/group'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ผู้ดูแลระบบ'), 'url'=>array('setting/moderator'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'Webspiders'), 'url'=>array('setting/spider'), 'linkOptions'=>array('class'=>'btn btn-primary')),
);
?>
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
	
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'bbii-member-grid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		'rowCssClassExpression'=>'(Yii::app()->authManager && Yii::app()->authManager->checkAccess("moderator", $data->id))?"moderator":(($row % 2)?"even":"odd")',
		'template' => '{items}{pager}',
		'htmlOptions'=>array(
			'class'=>'panel panel-default',
		),
		'itemsCssClass'=>'table v-middle',
		'columns'=>array(
			'member_name',
			array(
				'name'=>'group_id',
				'value'=>'$data->group->name',
				'filter'=>CHtml::listData(BbiiMembergroup::model()->findAll(), 'id', 'name'),
			),
			array(
				'name'=>'moderator',
				'value'=>'CHtml::checkBox("moderator", $data->moderator, array("onclick"=>"changeModeration(this,$data->id,\'' . $this->createAbsoluteUrl('setting/changeModerator') . '\')"))',
				'type'=>'raw',
				'filter'=>array('0'=>Yii::t('BbiiModule.bbii', 'No'), '1'=>Yii::t('BbiiModule.bbii', 'Yes')),
				'htmlOptions'=>array("style"=>"text-align:center"),
			),
			
		),
	)); ?>
				<br/>
			</div>




			<?php
			//right Menu
			echo $this->renderPartial('_right'); ?>


		</div>
	</div>
</div>