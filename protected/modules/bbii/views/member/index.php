<?php
/* @var $this ForumController */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Members'),
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'). ' (' . $approvals . ')', 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รายงาน'). ' (' . $reports . ')', 'url'=>array('moderator/report'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'กรองคำหยาบ'), 'url'=>array('moderator/keywordadmin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'โพส'), 'url'=>array('moderator/admin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ไอพีที่ถูกบล็อค'), 'url'=>array('moderator/ipadmin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
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
	'id'=>'member-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'template' => '{items}{pager}',
	'htmlOptions'=>array(
		'class'=>'panel panel-default',
	),
	'itemsCssClass'=>'table v-middle',
	'columns'=>array(
		array(
			'header'=>'Avatar',
			'type'=>'image',
			'value'=>'(isset($data->avatar))?"'.Yii::app()->request->baseUrl . $this->module->avatarStorage . '/$data->avatar":"'.$this->module->getRegisteredImage('empty.jpeg').'"',
			'htmlOptions'=>array('class'=>'img30'),
		),
		array(
			'name' => 'member_name',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->member_name), array("member/view", "id"=>$data->id))',
		),
		array(
			'header' => Yii::t('BbiiModule.bbii', 'Joined'),
			'value' => 'DateTimeCalculation::full($data->first_visit)',
		),
		array(
			'header' => Yii::t('BbiiModule.bbii', 'Last visit'),
			'value' => 'DateTimeCalculation::full($data->last_visit)',
		),
		array(
			'name' => 'group_id',
			'filter' => CHtml::listData(BbiiMembergroup::model()->findAll(), 'id', 'name'),
			'value' => '(isset($data->group))?$data->group->name:""',
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