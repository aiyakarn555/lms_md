<?php
/* @var $this SearchController */
/* @var $dataProvider CActiveDataProvider */
/* @var $search String */
/* @var $choice Integer */
/* @var $type Integer */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Search'),
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'),'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'),'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'). ' (' . $approvals . ')', 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(),'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รายงาน'). ' (' . $reports . ')', 'url'=>array('moderator/report'), 'visible'=>$this->isModerator(),'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'โพส'), 'url'=>array('moderator/admin'), 'visible'=>$this->isModerator(),'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ไอพีที่ถูกบล็อค'), 'url'=>array('moderator/ipadmin'), 'visible'=>$this->isModerator(),'linkOptions'=>array('class'=>'btn btn-primary')),
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
			<div class="panel panel-default">
				<div class="panel-body">
					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'bbii-search-form',
						'action'=>array('search/index'),
						'enableAjaxValidation'=>false,
					));
					echo CHtml::textField('search', $search, array('size'=>80,'maxlength'=>100));
					echo CHtml::submitButton(Yii::t('BbiiModule.bbii','Search')) . '<br>';
					echo CHtml::radioButtonList('choice', $choice, array('1'=>Yii::t('BbiiModule.bbii','Subject'), '2'=>Yii::t('BbiiModule.bbii','Content'), '0'=>Yii::t('BbiiModule.bbii','Both')), array('separator'=>'&nbsp;'));
					echo ' | ';
					echo CHtml::radioButtonList('type', $type, array('1'=>Yii::t('BbiiModule.bbii','Any word'), '2'=>Yii::t('BbiiModule.bbii','All words'), '0'=>Yii::t('BbiiModule.bbii','Phrase')), array('separator'=>'&nbsp;'));
					$this->endWidget();
					?>
					<?php $this->widget('zii.widgets.CListView', array(
						'id'=>'bbii-search-result',
						'dataProvider'=>$dataProvider,
						'itemView'=>'_post',
					)); ?>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
