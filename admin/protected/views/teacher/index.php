
<?php
$titleName = 'ระบบรายชื่อวิทยากร';
$formNameModel = 'Teacher';

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
	$.appendFilter("Teacher[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array( 
			array('name'=>'teacher_name','type'=>'text'),
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
					'loadProcessing' => true,
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->teachercheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(slash, care) { 
						$.appendFilter("Teacher[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Teacher.*", "Teacher.Delete", "Teacher.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->teacher_picture)',
							'htmlOptions'=>array('width'=>'110')
						), 
						array(
							'name'=>'teacher_name',
							'type'=>'raw',
							'value'=>'UHtml::markSearch($data,"teacher_name")',
						),
						array(
							'name'=>'teacher_position',
							'type'=>'raw',
							'value'=>'UHtml::markSearch($data,"teacher_position")',
						),
						// array(
						// 	'name'=>'teacher_type',
						// 	//'type'=>'raw',
						// 	'value'=>'$data->getTypesByKey($data->teacher_type)',
						// ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Teacher.*", "Teacher.View", "Teacher.Update", "Teacher.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Teacher.*", "Teacher.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Teacher.*", "Teacher.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Teacher.*", "Teacher.Delete") )' 
								),
							),
						),
					),
				)); 
				?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Teacher.*", "Teacher.Delete", "Teacher.MultiDelete")) ) : ?>
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
