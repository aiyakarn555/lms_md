<?php
$titleName = 'Division';
$formNameModel = 'Orgchart';

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
	$.appendFilter("Orgchart[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">

	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<?php if (Controller::PButton(array($formNameModel.".Division_create"))) { ?>
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?= Yii::app()->controller->createUrl('Division_create'); ?>/" type="button" class="btn btn-danger"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม <?= $titleName ?></a>
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
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Orgchart[news_per_page]");
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
						// array(
						// 	'visible'=>Controller::DeleteAll(
						// 		array("$formNameModel.*", "$formNameModel.Delete", "$formNameModel.MultiDelete")
						// 	),
						// 	'class'=>'CCheckBoxColumn',
						// 	'id'=>'chk',
						// ),

						array(
							'name'=>'id',
							'value'=>'$data->id',
							'htmlOptions' => array(
			                   'style' => 'width:120px; text-align:center;',
			                ),
						),


						array(
							'name'=>'title',
							'value'=>'$data->title',
							// 'filter'=>CHtml::activeTextField($model,'cates_search'),  
						),

						

							array(
							'header'=>'จัดการ',
							'type'=>'raw',
							'htmlOptions' => array(
			                   'style' => 'width:120px',
			                ),
							'value'=>function($data){
								// $text = '
								// <a class="btn-action glyphicons eye_open btn-info" title="ดูรายละเอียด" href="'.Yii::app()->controller->createUrl('orgChart/orgview/'.$data->id).'"><i></i></a>
								// ';

								$text .= '
								<a class="btn-action glyphicons pencil btn-success" title="แก้ไข" href="'.Yii::app()->controller->createUrl('Orgmanage/Division_update/'.$data->id).'"><i></i></a>
								';

								// if($data->id >= 4){
								if ($data->id > 10 ){
									$text .= '
									<a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="'.Yii::app()->controller->createUrl('Orgmanage/Division_delete/'.$data->id).'" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i></i></a>
									';
								}

								return $text;
							},
						

						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array($formNameModel.".*", $formNameModel.".Delete", $formNameModel.".MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php 
				// echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
				// 	"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
				// 	"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','".$formNameModel."-grid');"
				// )); 
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>


</div>
