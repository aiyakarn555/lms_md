<?php
$titleName = 'ระบบจัดการป๊อปอัพ';
$formNameModel = 'Popups';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#popup-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'pclog_event','type'=>'text'),
	),
	));?>

	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
			<?php $this->widget('AGridView', array(
				'id'=>'popup-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'columns'=>array(
					'Profiles.firstname',
					array(
						'header' => 'การกระทำ',
						'type' => 'html',
						'value' => function($data) {
							$eventArray = array(
								'Print' => 'พิมพ์ประกาศนียบัตร',
								'Download' => 'ดาวน์โหลดประกาศนียบัตร',
								);
							$iconArray = array(
								'Print' => 'print',
								'Download' => 'save',
								);
							return '<span class="glyphicons ' . $iconArray[$data->pclog_event]. ' btn-icon"><i></i>' . $eventArray[$data->pclog_event] . '</span>';
						}
					),
					array(
						'header' => 'ชื่อ - สกุลผู้เรียน',
						'value' => function($data) {
							return $data->Course->Profiles->fullname;
						}
					),
					'Course.CourseOnlines.course_title',
					array(
						'header' => 'วันที่',
						'value' => function($data) {
							return Helpers::lib()->changeFormatDate($data->pclog_date, 'datetime');
						}
					),
				),
			)); ?>
			</div>
		</div>
	</div>
</div>
