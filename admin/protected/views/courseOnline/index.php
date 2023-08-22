<?php
$titleName = 'หลักสูตร';
$formNameModel = 'CourseOnline';

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
	$.appendFilter("CourseOnline[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'cates_search','type'=>'text'),
			// array('name'=>'course_number','type'=>'text'),
			// array('name'=>'course_lecturer','type'=>'list','query'=>CHtml::listData(Teacher::model()->findAll(array(
			// "condition"=>" active = 'y' ")),'teacher_id', 'teacher_name')),
			array('name'=>'course_title','type'=>'text'),
			array('name'=>'course_md_code','type'=>'text'),
			
			// array('name'=>'course_price','type'=>'text'),
			//array('name'=>'course_point','type'=>'text'),
		),
	));?>
<div class="innerLR">
	
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
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("CourseOnline[news_per_page]");
						InitialSortTable();	
				        jQuery("#course_date").datepicker({
						   	"dateFormat": "dd/mm/yy",
						   	"showAnim" : "slideDown",
					        "showOtherMonths": true,
					        "selectOtherMonths": true,
				            "yearRange" : "-5+10", 
					        "changeMonth": true,
					        "changeYear": true,
				            "dayNamesMin" : ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
				            "monthNamesShort" : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
				                "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
					   })
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::PButton(array($formNameModel.".MultiDelete")),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->course_picture)',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'name'=>'cate_id',
							'value'=>'$data->cates->cate_title',
							'filter'=>CHtml::activeTextField($model,'cates_search'),
			                'htmlOptions' => array(
			                   'style' => 'width:130px',
			                ),  
						),

						'course_title',
						'course_md_code',
						
						// array(
						// 	'name'=>'course_title',
						// 	'type'=>'html',
						// 	// 'value'=>'UHtml::markSearch($data,"course_title")',
						// 	'value'=>function($data){
						// 		if(count($data->Schedules) > 0 || $data->cates->cate_id == 1){
						// 			$str = " (TMS)";
						// 		}else{
						// 			$str = " (LMS)";
						// 		}
						// 		return UHtml::markSearch($data,"course_title").$str;
						// 	},
						// ),						
						array(
							'header'=>'รุ่น',
							'value'=>'CHtml::link("จัดการรุ่น (".$data->getCountGen().")", array(
					      		"courseGeneration/index",
					      		"id"=>$data->course_id,
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
						),

						array(
							'header'=>'จัดเรียงบทเรียน',
							'value'=>'CHtml::link("จัดเรียงบท (".$data->getCountLesson().")", array(
					      		"CourseOnline/sortLesson",
					      		"id"=>$data->course_id
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
						),
						array(
							'header'=>'ก่อนเรียน',
							'value'=>'CHtml::link("เลือกข้อสอบ (".$data->getCountTest("pre").")", array(
					      		"CourseOnline/Formcourse",
					      		"id"=>$data->course_id,
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
							'value'=>'CHtml::link("เลือกข้อสอบ (".$data->getCountTest("course").")", array(
					      		"CourseOnline/Formcourse",
					      		"id"=>$data->course_id,
					      		"type"=>"course"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
						),
						array(
							'header'=>'แบบประเมิน',
							//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("post").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"post"))))',
							'value'=>'CHtml::link("เพิ่มแบบประเมิน (".$data->getCountTeacher().")", array(
					      		"CourseOnline/add_teacher",
					      		"id"=>$data->course_id,
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
						),

						// array(
						// 	'name'=>'course_number',
						// 	'type'=>'html',
						// 	'value'=>'UHtml::markSearch($data,"course_number")',
			   //              'htmlOptions' => array(
			   //                 'style' => 'width:85px',
			   //              ),  
						// ),
//						array(
//							'type'=>'html',
//							'name'=>'course_lecturer',
//							'value'=>'$data->teachers->teacher_name',
//							'filter'=>$this->listTeacher($model),
//							'htmlOptions' => array(
//								'width'=>'150',
//							),
//						),
						
						// array(
						// 	'name'=>'course_price',
						// 	'value'=>'number_format($data->course_price)',
			   //              'htmlOptions' => array(
			   //                 'style' => 'width:50px',
			   //              ),  
						// ),
						/*array(
							'name'=>'course_point',
							'value'=>'number_format($data->course_point)',
			                'htmlOptions' => array(
			                   'style' => 'width:80px',
			                ),  
						),*/
				        // array(
				        // 	'name'=>'course_status',
				        // 	'class'=>'JToggleColumn',
				        //     'filter' => array('0' => '-', '1' => 'ยอดนิยม'), // filter
				        //     'action'=>'toggle', // other action, default is 'toggle' action
				        //     'checkedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/check.png',  // Image,text-label or Html
				        //     'uncheckedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/delete.png', // Image,text-label or Html
				        //     'checkedButtonTitle'=>'Yes.Click to No', // tooltip
				        //     'uncheckedButtonTitle'=>'No. Click to Yes', // tooltip
				        //     'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
				        //     'htmlOptions'=>array('style'=>'text-align:center;width:60px;')
				        // ),
				        array(
							'type'=>'raw',
							'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
							'header' => 'ย้าย',
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
						array(
							'type'=>'raw',
							'value'=>function($data){
								if($data->status == 1){
									return CHtml::link("เปิด",array("/CourseOnline/active","id"=>$data->id), array("class"=>"btn btn-success"));
								} else {
									return CHtml::link("ปิด",array("/CourseOnline/active","id"=>$data->id), array("class"=>"btn btn-danger"));
								}
							},
							'header' => 'เปิด/ปิด การแสดงผล',
							'htmlOptions'=>array('style'=>'text-align: center;'),
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
						array(
							'header'=>'ภาษา',
							'value' => function($val) {
								   $lang = Language::model()->findAll(array('condition' =>'active ="y"'));
								foreach ($lang as $key => $value) {
									$menu = CourseOnline::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
									$str = ' (เพิ่ม)';
									$link = array("/CourseOnline/create","lang_id"=>$value->id,"parent_id"=>$val->id);
									$class = "btn btn-icon";
									if($menu || $key == 0){
										$id = $menu ? $menu->id : $val->id;
										$str = ' (แก้ไข)';
										$class = "btn btn-success btn-icon";
										$link = array("/CourseOnline/update","id"=>$id,"lang_id"=>$value->id,"parent_id"=>$val->id);
									}
									$langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;'));
								}
								return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
							},
								'type'=>'raw',
								'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px;'),
							),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("CourseOnline.*", "CourseOnline.View", "CourseOnline.Update", "CourseOnline.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("CourseOnline.*", "CourseOnline.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("CourseOnline.*", "CourseOnline.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("CourseOnline.*", "CourseOnline.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php //if( Controller::DeleteAll(array("CourseOnline.*", "CourseOnline.Delete", "CourseOnline.MultiDelete")) ) : ?>	
		<?php 		
		if(Controller::PButton(array($formNameModel.".MultiDelete"))) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
				)); ?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>


</div>
