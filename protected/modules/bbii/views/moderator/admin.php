<?php
/* @var $this ModeratorController */
/* @var $model BbiiPost */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Posts'),
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'). ' (' . $approvals . ')', 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รายงาน'). ' (' . $reports . ')', 'url'=>array('moderator/report'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'โพส'), 'url'=>array('moderator/admin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'กรองคำหยาบ'), 'url'=>array('moderator/keywordadmin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ไอพีที่ถูกบล็อค'), 'url'=>array('moderator/ipadmin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ส่งเมล'), 'url'=>array('moderator/sendmail'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
);

Yii::app()->clientScript->registerScript('setAutocomplete', "
function setAutocomplete(id, data) {
    $('#BbiiPost_search').autocomplete({
		source: '" . $this->createUrl('member/members') . "',
		select: function(event,ui) {
			$('#BbiiPost_search').val(ui.item.label);
			$('#bbii-post-grid').yiiGridView('update', { data: $(this).serialize() });
			return false;
		},
		'minLength': 2,
		'delay': 200
	});
}
");

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
	<?php 
	$dataProvider = $model->search();
	$dataProvider->setPagination(array('pageSize'=>20));
	$dataProvider->setSort(array('defaultOrder'=>'create_time DESC'));
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'bbii-post-grid',
		'dataProvider'=>$dataProvider,
		'afterAjaxUpdate'=>'setAutocomplete',
		'template' => '{items}{pager}',
		'htmlOptions'=>array(
			'class'=>'panel panel-default',
		),
		'itemsCssClass'=>'table v-middle',
		'columns'=>array(
			array(
				'name' => 'forum_id',
				'value' => '$data->forum->name',
				'filter' => CHtml::listData(BbiiForum::getAllForumOptions(), 'id', 'name', 'group'),
			),
			'subject',
			array(
				'name' => 'search',
				'filter' =>$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
					'attribute'=>'search',
					'model'=>$model,
					'sourceUrl'=>array('member/members'),
					'theme'=>$this->module->juiTheme,
					'options'=>array(
						'minLength'=>2,
						'delay'=>200,
						'select'=>'js:function(event, ui) { 
							$("#BbiiPost_search").val(ui.item.label);
							$("#bbii-post-grid").yiiGridView("update", { data: $(this).serialize() });
							return false;
						}',
					),
					'htmlOptions'=>array(
						'style'=>'height:20px;',
					),
				), true),
				'value' => '$data->poster->member_name',
			),
			'ip',
			'create_time',
			array(
				'header' => 'Action',
				'class'=>'CButtonColumn',
				'template'=>'{view}{update}{delete}',
				'buttons' => array(
					'view' => array(
						'url'=>'array("forum/topic", "id"=>$data->topic_id, "nav"=>$data->id)',
						'imageUrl'=>$this->module->getRegisteredImage('view.png'),
					),
					'update' => array(
						'url'=>'array("forum/update", "id"=>$data->id)',
						'label'=>Yii::t('BbiiModule.bbii','Update'),
						'imageUrl'=>$this->module->getRegisteredImage('update.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
					'delete' => array(
						'imageUrl'=>$this->module->getRegisteredImage('delete.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
				)
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