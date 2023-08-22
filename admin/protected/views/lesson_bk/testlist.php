
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
						// array(
						// 	'visible'=>Controller::DeleteAll(
						// 		array("Lesson.*", "Lesson.Delete", "Lesson.MultiDelete")
						// 	),
						// 	'class'=>'CCheckBoxColumn',
						// 	'id'=>'chk',
						// ),
						/*array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->image)',
							'htmlOptions'=>array('width'=>'110')
						),*/
						/*array(
							'name'=>'course_id',
							'value'=>'$data->courseonlines->course_title',
							'filter'=>$this->listcourseOnline($model,'course_id'),
							'htmlOptions'=>array('style'=>'width: 150px;'),
						),*/
						array(
							'name'=>'title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"title")',
							'htmlOptions'=>array('style'=>'width: 200px;'),
						),
						array(
							'header'=>'ก่อนเรียน',
					    	//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("pre").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"pre"))))',
					    	'value'=>function($data){

					    		$str = '';
					    		$total = 0;
					    		if(count($data->manages(array('condition'=>"type='pre'"))) > 0){
					    			foreach ($data->manages(array('condition'=>"type='pre'")) as $manageKey => $manageValue) {
					    				$group = Grouptesting::Model()->find("group_id='".$manageValue->group_id."' AND lesson_id='".$manageValue->id."'");
					    				$str .= $group->group_title." จำนวน <strong>".$manageValue->manage_row."</strong> ข้อ<br>";
					    				$total += $manageValue->manage_row;
					    			}
					    		}

					    		return $str."<strong>รวมทั้งหมดจำนวน ".$total." ข้อ</strong>";
					    	},
					    	'type'=>'raw',
					    	'htmlOptions'=>array('width'=>'250px'),
					    ),
					    array(
							'header'=>'หลังเรียน',
					    	//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("pre").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"pre"))))',
					    	'value'=>function($data){

					    		$str = '';
					    		$total = 0;
					    		if(count($data->manages(array('condition'=>"type='post'"))) > 0){
					    			foreach ($data->manages(array('condition'=>"type='post'")) as $manageKey => $manageValue) {
					    				$group = Grouptesting::Model()->find("group_id='".$manageValue->group_id."' AND lesson_id='".$manageValue->id."'");
					    				$str .= $group->group_title." จำนวน <strong>".$manageValue->manage_row."</strong> ข้อ<br>";
					    				$total += $manageValue->manage_row;
					    			}
					    		}

					    		return $str."<strong>รวมทั้งหมดจำนวน ".$total." ข้อ</strong>";
					    	},
					    	'type'=>'raw',
					    	'htmlOptions'=>array('width'=>'250px'),
					    ),
						// array(            
						// 	'class'=>'AButtonColumn',
						// 	'visible'=>Controller::PButton( 
						// 		array("Lesson.*", "Lesson.View", "Lesson.Update", "Lesson.Delete") 
						// 	),
						// 	'buttons' => array(
						// 		'view'=> array( 
						// 			'visible'=>'Controller::PButton( array("Lesson.*", "Lesson.View") )' 
						// 		),
						// 		'update'=> array( 
						// 			'visible'=>'Controller::PButton( array("Lesson.*", "Lesson.Update") )' 
						// 		),
						// 		'delete'=> array( 
						// 			'visible'=>'Controller::PButton( array("Lesson.*", "Lesson.Delete") )' 
						// 		),
						// 	),
						// ),
					),
				)); ?>
			</div>
		</div>
	</div>

</div>
