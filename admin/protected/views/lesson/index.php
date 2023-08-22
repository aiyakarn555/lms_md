
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
	<?php 
	////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
	$check_user = User::model()->findByPk(Yii::app()->user->id);
	$group = $check_user->group;
	$group_arr = json_decode($group);
	$see_all = 2;
	if(in_array("1", $group_arr) || in_array("7", $group_arr)){
		$see_all = 1;
	}
                        //////////////////
	if($see_all != 1){
	$this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array(
				'type'=>'list',
				'name'=>'course_id',				
				'query'=>CHtml::listData(CourseOnline::model()->findAll("active='y' and create_by='".Yii::app()->user->id."'"),'course_id', 'course_title')
			),
			array('name'=>'title','type'=>'text'),
		),
	));
}else{
	$this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array(
				'type'=>'list',
				'name'=>'course_id',				
				'query'=>CHtml::listData(CourseOnline::model()->findAll("active='y'"),'course_id', 'course_title')
			),
			array('name'=>'title','type'=>'text'),
		),
	));
}

	?>

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
					'dataProvider'=>$model->search(),
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
						/*array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->image)',
							'htmlOptions'=>array('width'=>'110')
						),*/
						// array(
						// 	'name'=>'course_id',
						// 	'value'=>'$data->courseonlines->course_title',
						// 	'filter'=>$this->listcourseOnline($model,'course_id'),
						// 	'htmlOptions'=>array('style'=>'width: 150px;'),
						// ),
						array(
							'name'=>'course_id',
							// 'value'=>'$data->courseonlines->course_title',
							'value'=>function($data){
								// if(count($data->courseonlines->Schedules) || $data->courseonlines->cate_id == 1){
								// 	$str = " (TMS)";
								// }else{
								// 	$str = " (LMS)";
								// }
								// return $data->courseonlines->course_title.$str;
								return $data->courseonlines->course_title;
							},
							'filter'=>$this->listcourseOnline($model,'course_id'),
							'htmlOptions'=>array('style'=>'width: 150px;'),
						),
						array(
							'name'=>'title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"title")',
							'htmlOptions'=>array('style'=>'width: 250px;'),
						),
						// array(
						// 	'header'=>'จำนวนวีดีโอ',
						// 	'value'=>'$data->CountFile',
						// 	'htmlOptions'=>array('style'=>'width: 80px; text-align: center;'),
						// 	'headerHtmlOptions'=>array('style'=>'text-align: center'),
						// ),
						// array(
						// 	'header'=>'แบบสอบถาม',
					 //    	//'value'=>'CHtml::button("เลือกแบบสอบถาม",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/ChooseQuestionnaire")))',
					 //    	'value'=>function($data){
						// 		$str = CHtml::link("เลือก", array(
						//       		"Questionnaire/Choose",
						//       		"id"=>"$data->id"
						//       		), array(
						// 			"class"=>"btn btn-primary btn-icon"
						// 	    ));
						// 		if($data->header_id != ""){
						// 			$str .= " ".CHtml::link("รายงาน", array(
						// 	      		"Questionnaire/Report",
						// 	      		"id"=>"$data->id"
						// 	      		), array(
						// 				"class"=>"btn btn-success btn-icon"
						// 		    ));
						// 		}

						// 		return $str;
					 //    	},
					 //    	'type'=>'raw',
					 //    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'160px'),
					 //    ),
						array(
							'header'=>'จัดการวิดีโอ',
					        'value' => function($data){
					        	if($data->type == 'pdf'){
					        		$str = 'จัดการ PDF';
					        		$count = count($data->filePdf);
					        		$path = 'FilePdf/index';
					        	} else if($data->type == 'vdo') {
					        		$str = 'จัดการ VDO';
					        		$count = count($data->files);
					        		$path = 'File/index';
					        	} else if($data->type == 'scorm'){
					        		$str = 'ไฟล์ Scorm';
					        		$count = count($data->fileScorm);
					        		$path = 'FileScorm/index';
					        	} else if($data->type == 'ebook'){
					        		$str = 'ไฟล์ Ebook';
					        		$count = count($data->fileebook);
					        		$path = 'FileEbook/index';
					        	} else if($data->type == 'audio'){
					        		$str = 'ไฟล์ Audio';
					        		$count = count($data->fileAudio);
					        		$path = 'FileAudio/index';
					        	} else if($data->type == 'youtube') {
					        		$str = 'จัดการ VDO';
					        		$count = count($data->files);
					        		$path = 'File/index';
					        	}
					        	return CHtml::link($str." (".$count.")", array(
					      		$path,
					      		"id"=>"$data->id"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    ));
					        },
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'headerHtmlOptions'=>array('style'=>'text-align: center'),
						),
						array(
							'header'=>'ก่อนเรียน',
					    	//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("pre").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"pre"))))',
					    	'value'=>'CHtml::link("เลือกข้อสอบ (".$data->getCountTest("pre").")", array(
					      		"Lesson/FormLesson",
					      		"id"=>$data->id,
					      		"type"=>"pre"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
					    ),
					    array(
					    	'header'=>'หลังเรียน',
					    	//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("post").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"post"))))',
					    	'value'=>'CHtml::link("เลือกข้อสอบ (".$data->getCountTest("post").")", array(
					      		"Lesson/FormLesson",
					      		"id"=>$data->id,
					      		"type"=>"post"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
					    ),
					 //    array(
						// 	'header'=>'ผู้สอน / แบบสอบถาม',
						// 	//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("post").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"post"))))',
						// 	'value'=>'CHtml::link("เพิ่มผู้สอน (".$data->getCountTeacher().")", array(
					 //      		"Lesson/add_teacher",
					 //      		"id"=>$data->id,
					 //      		), array(
						// 		"class"=>"btn btn-primary btn-icon"
						//     )); ',
						// 	'type'=>'raw',
						// 	'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
						// ),
						array(
							'header'=>'ภาษา',
							'value' => function($val) {
								   $lang = Language::model()->findAll(array('condition' =>'active ="y"'));
								   $width = (count($lang)*100) + 20;
								foreach ($lang as $key => $value) {
									$menu = Lesson::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
									$str = ' (เพิ่ม)';
									$class = "btn btn-icon";
									$link = array("/Lesson/create","lang_id"=>$value->id,"parent_id"=>$val->id);
									if($menu || $key == 0){
										$id = $menu ? $menu->id : $val->id;
										$str = ' (แก้ไข)';
										$class = "btn btn-success btn-icon";
										$link = array("/Lesson/update","id"=>$id,"lang_id"=>$value->id,"parent_id"=>$val->id);
									} 
									$langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;border: 1px solid;'));
								}
								return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
							},
						'type'=>'raw',
						'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px;'),
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
