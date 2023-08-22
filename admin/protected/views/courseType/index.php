<?php
$titleName = 'หลักสูตร';
$formNameModel = 'CourseType';

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
	$.appendFilter("CourseType[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<!-- <?php 
	// $this->widget('AdvanceSearchForm', array(
	// 	'data'=>$model,
	// 	'route' => $this->route,
	// 	'attributes'=>array(
	// 		array('name'=>'cates_search','type'=>'text'),
	// 		array('name'=>'course_number','type'=>'text'),
	// 		// array('name'=>'course_lecturer','type'=>'list','query'=>CHtml::listData(Teacher::model()->findAll(array(
	// 		// "condition"=>" active = 'y' ")),'teacher_id', 'teacher_name')),
	// 		array('name'=>'course_title','type'=>'text'),
	// 		// array('name'=>'course_price','type'=>'text'),
	// 		//array('name'=>'course_point','type'=>'text'),
	// 	),
	// ));
	?> -->
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
					'rowCssClassExpression'=>'"items[]_{$data->type_id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'columns'=>array(
						// array(
						// 	'visible'=>Controller::DeleteAll(
						// 		array("CourseType.*", "CourseType.Delete", "CourseType.MultiDelete")
						// 	),
						// 	'class'=>'CCheckBoxColumn',
						// 	'id'=>'chk',
						// ),
						array(
							'name'=>'type_name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"type_name")'
						),
						// array(
						// 	'type'=>'raw',
						// 	'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
						// 	'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
						// 	'header' => 'ย้าย',
						// 	'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						// ),
						// array(
						// 	'type'=>'raw',
						// 	'value'=>function($data){
						// 		if($data->status == 1){
						// 			return CHtml::link("เปิด",array("/CourseType/active","id"=>$data->id), array("class"=>"btn btn-success"));
						// 		} else {
						// 			return CHtml::link("ปิด",array("/CourseType/active","id"=>$data->id), array("class"=>"btn btn-danger"));
						// 		}
						// 	},
						// 	'header' => 'เปิด/ปิด การแสดงผล',
						// 	'htmlOptions'=>array('style'=>'text-align: center;'),
						// 	'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						// ),
						array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
					        foreach ($lang as $key => $value) {
					    		$menu = CourseType::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->type_id,'active'=>'y'));
					    		$str = ' (เพิ่ม)';
					    		$link = array("/CourseType/create","lang_id"=>$value->id,"parent_id"=>$val->type_id);
					    		$class = "btn btn-primary btn-icon";
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->type_id : $val->type_id;
					    			$str = ' (แก้ไข)';
					    			$link = array("/CourseType/update","id"=>$id,"lang_id"=>$value->id,"parent_id"=>$val->type_id);
					    		}
					            $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;'));
					        }
					        return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
                    	},
		                    'type'=>'raw',
		                    'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px;'),
						),
						// array(            
						// 	'class'=>'AButtonColumn',
						// 	'visible'=>Controller::PButton( 
						// 		array("CourseType.*", "CourseType.View", "CourseType.Update", "CourseType.Delete") 
						// 	),
						// 	'buttons' => array(
						// 		'view'=> array( 
						// 			'visible'=>'Controller::PButton( array("CourseType.*", "CourseType.View") )' 
						// 		),
						// 		'update'=> array( 
						// 			'visible'=>'Controller::PButton( array("CourseType.*", "CourseType.Update") )' 
						// 		),
						// 		// 'delete'=> array( 
						// 		// 	'visible'=>'Controller::PButton( array("CourseType.*", "CourseType.Delete") )' 
						// 		// ),
						// 	),
						// ),
					),
				)); ?>
			</div>
		</div>
	</div>

	<!-- <?php if( Controller::DeleteAll(array("CourseType.*", "CourseType.Delete", "CourseType.MultiDelete")) ) : ?>
		<div class="separator top form-inline small">
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
				)); ?>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php endif; ?> -->


</div>
