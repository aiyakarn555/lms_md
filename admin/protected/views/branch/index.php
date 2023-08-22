
<?php
$titleName = 'จัดการเลเวล';
$formNameModel = 'Branch';

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
	$.appendFilter("Branch[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

	<script type="text/javascript">
		$(function() {


			

			$("#Branch_department").change(function(){
				var value = $("#Branch_department option:selected").val();
				if(value != ""){
					$.ajax({
						type: 'POST',
						url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetposition"); ?>',
						data: ({
							value: value,
						}),
						success: function(data) {
							if(data != ""){
								$("#Branch_position_id").html(data);
								$('.chosen').trigger("chosen:updated");
							}
						}
					});
				}
			});




		});
	</script>




<div class="innerLR">
	<?php 

	 $department = Department::model()->findAll(array(
        'condition' => 'type_employee_id = "2" AND active = "y"',
        'order' => 'dep_title ASC'
    ));
    $listdepartment = CHtml::listData($department,'id','dep_title');

    $Department_ID = [];
	$Department = Department::model()->findAll('active = "y" AND lang_id = 1 AND type_employee_id = 2');
	foreach ($Department as $key => $value) {
	$Department_ID[] = $value->id;
	}
	$criteria= new CDbCriteria;
	  $criteria->compare('active','y');
	  $criteria->compare('lang_id',1);
	  $criteria->addInCondition('department_id', $Department_ID);
	  $position = Position::model()->findAll($criteria);
    // $position = Position::model()->findAll(array(
    //     'condition' => 'active = "y"',
    //     'order' => 'position_title ASC'
    // ));
    $listposition = CHtml::listData($position,'id','position_title');


	$this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'branch_name','type'=>'text'),
			array('name'=>'department','type'=>'list','query'=>$listdepartment),
			array('name'=>'position_id','type'=>'list','query'=>$listposition),
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
						$.appendFilter("Branch[news_per_page]");
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
								array("Branch.*", "Branch.Delete", "Branch.MultiDelete")
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
							'header'=>'บุคคลากร',
							'value'=>'$data->position->dep->emp->type_employee_name',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:150px',
			                ),  
						),
						array(
							'header'=>'แผนก',
							'value'=>'$data->position->dep->dep_title',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:150px',
			                ),  
						),
						array(
							'header'=>'ตำแหน่ง',
							'value'=>'$data->position->position_title',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:150px',
			                ),  
						),
						array(
							'name'=>'branch_name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"branch_name")'
						),
						// array(
      //                   'header'=>'ภาษา',
      //                   'value' => function($val) {
      //                      	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
      //                      	$width = (count($lang)*100) + 20;
					 //        foreach ($lang as $key => $value) {
					 //    		$menu = Branch::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
					 //    		$str = ' (เพิ่ม)';
					 //    		$class = "btn btn-icon";
					 //    		$link = array("/Branch/create","lang_id"=>$value->id,"parent_id"=>$val->id);
					 //    		if($menu || $key == 0){
					 //    			$id = $menu ? $menu->id : $val->id;
					 //    			$str = ' (แก้ไข)';
					 //    			$class = "btn btn-success btn-icon";
					 //    			$link = array("/Branch/update","id"=>$id);
					 //    		} 
					 //            $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;border: 1px solid;'));
					 //        }
					 //        return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
      //               	},
      //               'type'=>'raw',
      //               'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
      //           		),
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
								array("Branch.*", "Branch.View", "Branch.Update", "Branch.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Branch.*", "Branch.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Branch.*", "Branch.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Branch.*", "Branch.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Branch.*", "Branch.Delete", "Branch.MultiDelete")) ) : ?>
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
