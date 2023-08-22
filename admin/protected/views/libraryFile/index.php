<?php
$titleName = 'ห้องสมุด';
$formNameModel = 'LibraryFile';

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
	$.appendFilter("LibraryFile[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<?php 
// $this->widget('AdvanceSearchForm', array(
// 		'data'=>$model,
// 		'route' => $this->route,
// 		'attributes'=>array(
// 			array('name'=>'cates_search','type'=>'text'),
// 			// array('name'=>'course_number','type'=>'text'),
// 			// array('name'=>'course_lecturer','type'=>'list','query'=>CHtml::listData(Teacher::model()->findAll(array(
// 			// "condition"=>" active = 'y' ")),'teacher_id', 'teacher_name')),
// 			array('name'=>'course_title','type'=>'text'),
// 			// array('name'=>'course_price','type'=>'text'),
// 			//array('name'=>'course_point','type'=>'text'),
// 		),
// 	));
	?>
<div class="innerLR">
	
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<?php if (Controller::PButton(array($formNameModel.".create"))) { ?>
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?= Yii::app()->controller->createUrl('create'); ?>/" type="button" class="btn btn-danger"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม<?= $titleName ?></a>
					</div>
				<?php } ?>

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
					'rowCssClassExpression'=>'"items[]_{$data->library_id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("LibraryFile[news_per_page]");
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
							'name'=>'library_type_id',
							'value'=>'$data->type->library_type_name_en',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:130px',
			                ),  
						),
						'library_name_en',											
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
								array("LibraryFile.*", "LibraryFile.View", "LibraryFile.Update", "LibraryFile.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("LibraryFile.*", "LibraryFile.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("LibraryFile.*", "LibraryFile.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("LibraryFile.*", "LibraryFile.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>		
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
