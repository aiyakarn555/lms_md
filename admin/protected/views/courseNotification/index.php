<?php
$titleName = 'จัดการระบบแจ้งเตือนบทเรียน';
$formNameModel = 'CourseNotification';

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
		array('name'=>'course_id','type'=>'text'),
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
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'popup-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'columns'=>array(					
					array(
						'name'=>'course_id',
						'type'=>'html',
						'value'=>'$data->getCourseName($data->course_id)',
					),
					// array(
					// 	'name'=>'generation_id',
					// 	// 'type'=>'html',
					// 	'value'=>'UHtml::markSearch($data->generation,"name")'
					// ),
					array(
						'name'=>'notification_time',
						'type'=>'html',
						'value'=>'$data->getDay($data->notification_time)',
					),
					// array(
					// 	'name'=>'end_date',
					// 	'type'=>'html',
					// 	'value'=>'UHtml::markSearch($data,"end_date")'
					// ),
					// array(
					// 	'name'=>'create_date',
					// 	'type'=>'html',
					// 	'value'=>'UHtml::markSearch($data,"create_date")'
					// ),
					// array(
					// 	'name'=>'update_date',
					// 	'type'=>'html',
					// 	'value'=>'UHtml::markSearch($data,"update_date")'
					// ),
					array(
						'name'=>'active',
						'value'=>'User::itemAlias("UserStatus",$data->active)',
						'filter' => User::itemAlias("UserStatus"),
					),
					/*
					'pic_file',
					*/
					array(            
						'class'=>'AButtonColumn',
						'visible'=>Controller::PButton( 
							array("Popup.*", "Popup.View", "Popup.Update", "Popup.Delete") 
						),
						'buttons' => array(
							'view'=> array( 
								'visible'=>'Controller::PButton( array("Popup.*", "Popup.View") )' 
							),
							'update'=> array( 
								'visible'=>'Controller::PButton( array("Popup.*", "Popup.Update") )' 
							),
							'delete'=> array( 
								'visible'=>'Controller::PButton( array("Popup.*", "Popup.Delete") )' 
							),
						),
					),
				),
			)); ?>
			</div>
		</div>
	</div>
</div>
