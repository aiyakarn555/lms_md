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
		array('name'=>'id_course','type'=>'text'),
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
						'name'=>'id_course',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data->course,"course_title")'
					),
					array(
						'name'=>'code',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data,"code")'
					),
					array(
						'name'=>'startdate',
						'type'=>'html',
						'value'=>function($data){
			                return Helpers::changeFormatDate($data->startdate);
			            },
					),
					array(
						'name'=>'enddate',
						'type'=>'html',
						'value'=>function($data){
			                return Helpers::changeFormatDate($data->enddate);
			            },
					),
					array(
						'header'=>'รายละเอียด',
						'type'=>'html',
						'value'=>function($data){
			                return CoursePeriod::detailHour($data->id);
			            },
					),
					// array(
					// 	'name'=>'active',
					// 	'value'=>'User::itemAlias("UserStatus",$data->active)',
					// 	'filter' => User::itemAlias("UserStatus"),
					// ),
					/*
					'pic_file',
					*/
					array(            
						'class'=>'AButtonColumn',
						'visible'=>Controller::PButton( 
							array("coursePeriod.*", "coursePeriod.View", "coursePeriod.Update", "coursePeriod.Delete") 
						),
						'buttons' => array(
							'view'=> array( 
								'visible'=>'Controller::PButton( array("coursePeriod.*", "coursePeriod.View") )' 
							),
							'update'=> array( 
								'visible'=>'Controller::PButton( array("coursePeriod.*", "coursePeriod.Update") )' 
							),
							'delete'=> array( 
								'visible'=>'Controller::PButton( array("coursePeriod.*", "coursePeriod.Delete") )' 
							),
						),
					),
				),
			)); ?>
			</div>
		</div>
	</div>
</div>
