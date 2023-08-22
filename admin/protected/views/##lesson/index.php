
<?php
$titleName = 'ระบบบทเรียน';
$formNameModel = 'Lesson';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("Lesson[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array(
				'type'=>'list',
				'name'=>'course_id',
				'query'=>CHtml::listData(CourseOnline::model()->findAll(),'course_id', 'course_title')
			),
			array('name'=>'title','type'=>'text'),
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
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->lessoncheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Lesson[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Lesson.*", "Lesson.Delete", "Lesson.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->image)',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'name'=>'course_id',
							'value'=>'$data->courseonlines->course_title',
							'filter'=>$this->listcourseOnline($model,'course_id'),
							'htmlOptions'=>array('style'=>'width: 150px;'),
						),
						array(
							'name'=>'title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"title")',
							'htmlOptions'=>array('style'=>'width: 250px;'),
						),
						array(
							'header'=>'จำนวนวีดีโอ',
							'value'=>'$data->CountFile',
							'htmlOptions'=>array('style'=>'width: 80px; text-align: center;'),
							'headerHtmlOptions'=>array('style'=>'text-align: center'),
						),
						array(
							'header'=>'จัดการวิดีโอ',
					        'value'=>'CHtml::link("จัดการวิดีโอ", array(
					      		"File/index",
					      		"id"=>"$data->id"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
							'type'=>'html',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'headerHtmlOptions'=>array('style'=>'text-align: center'),
						),
						array(
							'header'=>'ก่อนเรียน',
					    	'value'=>'CHtml::button("เลือกข้อสอบ",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"pre"))))',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'40px'),
					    ),
					    array(
					    	'header'=>'หลังเรียน',
					    	'value'=>'CHtml::button("เลือกข้อสอบ",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"post"))))',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'40px'),
					    ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Lesson.*", "Lesson.View", "Lesson.Update", "Lesson.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Lesson.*", "Lesson.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Lesson.*", "Lesson.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Lesson.*", "Lesson.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Lesson.*", "Lesson.Delete", "Lesson.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php 
				echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด",
					"#",
					array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
						"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');")); 
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
