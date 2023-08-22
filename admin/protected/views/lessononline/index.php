
<?php
$titleName = 'ระบบบทสอบเรียนรู้ทางไกล';
$formNameModel = 'LessonOnline';

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
	$.appendFilter("LessonOnline[news_per_page]", "news_per_page");
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
				'name'=>'ms_teams_id',				
				'query'=>CHtml::listData(LessonOnline::model()->findAll("active='y' and create_by='".Yii::app()->user->id."'"),'ms_teams_id', 'name_ms_teams')
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
				'name'=>'ms_teams_id',				
				'query'=>CHtml::listData(MsOnline::model()->findAll("active='y'"),'ms_teams_id', 'name_ms_teams')
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
						$.appendFilter("LessonOnline[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("LessonOnline.*", "LessonOnline.Delete", "LessonOnline.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						
						array(
							'name'=>'ms_teams_id',
							// 'value'=>'$data->courseonlines->course_title',
							'value'=>function($data){
								return $data->msteams->name_ms_teams;
							},
							// 'filter'=>$this->listcourseOnline($model,'ms_teams_id'),
							'htmlOptions'=>array('style'=>'width: 150px;'),
						),
						array(
							'name'=>'title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"title")',
							'htmlOptions'=>array('style'=>'width: 250px;'),
						),
						
						array(
							'header'=>'ก่อนเรียน',
					    	//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("pre").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("LessonOnline/FormLessonOnline", array("id"=>$data->id,"type"=>"pre"))))',
					    	'value'=>'CHtml::link("เลือกข้อสอบ (".$data->getCountTest("pre").")", array(
					      		"LessonOnline/FormLessonMs",
					      		"id"=>$data->id,
					      		"type"=>"pre"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
					    ),

					     array(
							'type'=>'raw',
							'value'=>function($data){
								if($data->status_exams_pre == 1){
									return CHtml::link("เปิด",array("/LessonOnline/ActivePre","id"=>$data->id), array("class"=>"btn btn-success"));
								} else {
									return CHtml::link("ปิด",array("/LessonOnline/ActivePre","id"=>$data->id), array("class"=>"btn btn-danger"));
								}
							},
							'header' => 'เปิด/ปิด ข้อสอบก่อนเรียน',
							'htmlOptions'=>array('style'=>'text-align: center;'),
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
					     
					    array(
					    	'header'=>'หลังเรียน',
					    	//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("post").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("LessonOnline/FormLessonOnline", array("id"=>$data->id,"type"=>"post"))))',
					    	'value'=>'CHtml::link("เลือกข้อสอบ (".$data->getCountTest("post").")", array(
					      		"LessonOnline/FormLessonMs",
					      		"id"=>$data->id,
					      		"type"=>"post"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
					    ),

					   

						  array(
							'type'=>'raw',
							'value'=>function($data){
								if($data->status_exams_post == 1){
									return CHtml::link("เปิด",array("/LessonOnline/ActivePost","id"=>$data->id), array("class"=>"btn btn-success"));
								} else {
									return CHtml::link("ปิด",array("/LessonOnline/ActivePost","id"=>$data->id), array("class"=>"btn btn-danger"));
								}
							},
							'header' => 'เปิด/ปิด ข้อสอบหลังเรียน',
							'htmlOptions'=>array('style'=>'text-align: center;'),
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
					
						array(
							'header'=>'ภาษา',
							'value' => function($val) {
								   $lang = Language::model()->findAll(array('condition' =>'active ="y"'));
								   $width = (count($lang)*100) + 20;
								foreach ($lang as $key => $value) {
									$menu = LessonOnline::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
									$str = ' (เพิ่ม)';
									$class = "btn btn-icon";
									$link = array("/LessonOnline/create","lang_id"=>$value->id,"parent_id"=>$val->id);
									if($menu || $key == 0){
										$id = $menu ? $menu->id : $val->id;
										$str = ' (แก้ไข)';
										$class = "btn btn-success btn-icon";
										$link = array("/LessonOnline/update","id"=>$id,"lang_id"=>$value->id,"parent_id"=>$val->id);
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
								array("LessonOnline.*", "LessonOnline.View", "LessonOnline.Update", "LessonOnline.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("LessonOnline.*", "LessonOnline.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("LessonOnline.*", "LessonOnline.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("LessonOnline.*", "LessonOnline.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("LessonOnline.*", "LessonOnline.Delete", "LessonOnline.MultiDelete")) ) : ?>
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
