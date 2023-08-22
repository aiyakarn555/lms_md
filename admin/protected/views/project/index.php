<?php
/* @var $this ProjectController */
/* @var $model Project */

$titleName = 'ระบบโครงการ';
$formNameModel = 'Project';

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
	$.appendFilter("Project[news_per_page]", "news_per_page");
EOD
	, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'name','type'=>'text'),
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
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(slash, care) {
						$.appendFilter("Project[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Project.*", "Project.Delete", "Project.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'name',
							'type'=>'raw',
							'value'=>'UHtml::markSearch($data,"name")',
						),
						array(
							'name'=>'university_search',
							//'type'=>'raw',
							'value'=>function($data){
								$universityName = array();
								if(count($data->universities) > 0){
									foreach($data->universities as $university){
										$universityName[] = $university->name;
									}
								}
								return implode(", ",$universityName);
							},
							'filter'=>TbUniversity::getUniversityOptions(),
						),
						array(
							'name'=>'start_date',
							'type'=>'raw',
							'value'=>function($data){
								return ClassFunction::datethai($data->start_date);
							},
						),
						array(
							'name'=>'expire_date',
							'type'=>'raw',
							'value'=>function($data){
								return ClassFunction::datethai($data->expire_date);
							},
						),
						array(
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton(
								array("Project.*", "Project.View", "Project.Update", "Project.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("Project.*", "Project.View") )'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("Project.*", "Project.Update") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("Project.*", "Project.Delete") )'
								),
							),
						),
					),
				));
				?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Project.*", "Project.Delete", "Project.MultiDelete")) ) : ?>
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
