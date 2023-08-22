
<?php
$titleName = 'จัดการแผนก';
$formNameModel = 'Department';

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
	$.appendFilter("Department[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php 

	$TypeEmployee = TypeEmployee::model()->findAll(array(
        'condition' => 'active = "y"',
        'order' => 'type_employee_name ASC'
    ));
    $listtype_user = CHtml::listData($TypeEmployee,'id','type_employee_name');


	$this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'dep_title','type'=>'text'),
			array('name'=>'type_employee_id', 'type'=>'list', 'query'=>$listtype_user),
		),
	));
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
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Department[news_per_page]");
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
							'visible'=>Controller::DeleteAll(
								array("Department.*", "Department.Delete", "Department.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						// array(
						// 	'name'=>'sortOrder',
						// 	'filter'=>false,
						// 	'type'=>'html',
						// 	'value'=>'UHtml::markSearch($data,"sortOrder")',
						// 	'htmlOptions' => array(
			   //                 'style' => 'width:50px',
			   //              ),  
						// ),
						array(
							'name'=>'type_employee_id',
							// 'value'=>'$data->emp->title',
							'filter'=>false,
							'value'=>'$data->emp->type_employee_name',
			                'htmlOptions' => array(
			                   'style' => 'width:150px',
			                ),  
						),
						array(
							'name'=>'dep_title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"dep_title")'
						),
						// array(
      //                   'header'=>'ภาษา',
      //                   'value' => function($val) {
      //                      	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
					 //        foreach ($lang as $key => $value) {
					 //    		$menu = Department::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
					 //    		$str = ' (เพิ่ม)';
					 //    		$class = "btn btn-icon";
					 //    		$link = array("/Department/create","lang_id"=>$value->id,"parent_id"=>$val->id);
					 //    		if($menu || $key == 0){
					 //    			$id = $menu ? $menu->id : $val->id;
					 //    			$str = ' (แก้ไข)';
					 //    			$class = "btn btn-success btn-icon";
					 //    			$link = array("/Department/update","id"=>$id);
					 //    		} 
					 //            $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;border: 1px solid;'));
					 //        }
					 //        return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
      //               	},
      //               'type'=>'raw',
      //               'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
      //           ),
						array(
							'type'=>'raw',
							'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
							'header' => 'ย้าย',
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Department.*", "Department.View", "Department.Update", "Department.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Department.*", "Department.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Department.*", "Department.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Department.*", "Department.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Department.*", "Department.Delete", "Department.MultiDelete")) ) : ?>
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
