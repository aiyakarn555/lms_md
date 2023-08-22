
<?php
$titleName = 'ระบบชุดแบบสอบถาม';
$formNameModel = 'FormSurveyGroup';

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
	$.appendFilter("FormSurveyGroup[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'lesson_search','type'=>'text'),
			array('name'=>'fg_title','type'=>'text'),
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
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->formsurveygroupcheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("FormSurveyGroup[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("FormsurveyGroup.*", "FormsurveyGroup.Delete", "FormsurveyGroup.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'lesson_search',
							'value'=>'$data->lesson->title',
							'filter'=>CHtml::activeTextField($model,'lesson_search'),
			                'htmlOptions' => array(
			                   'style' => 'width:230px',
			                ),  
						),
						array(
							'name'=>'fg_title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"fg_title")',
						),
						array(
							'header'=>'จำนวนแบบสอบถาม',
							'value'=>'$data->formsurvey',
			                'htmlOptions' => array(
			                   'style' => 'width:65px;text-align:center',
			                ),  
						),
					
					    array(
					      'value'=>'CHtml::button("เพิ่มแบบสอบถาม",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("FormSurvey/create", array("id"=>$data->fg_id))))',
					      'type'=>'raw',
					      'htmlOptions'=>array('width'=>'40px'),
					    ),
					    array(
					      'value'=>'CHtml::button("จัดการแบบสอบถาม",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("FormSurvey/index", array("id"=>$data->fg_id))))',
					      'type'=>'raw',
					      'htmlOptions'=>array('width'=>'40px'),
					    ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("FormsurveyGroup.*", "FormsurveyGroup.View", "FormsurveyGroup.Update", "FormsurveyGroup.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("FormsurveyGroup.*", "FormsurveyGroup.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("FormsurveyGroup.*", "FormsurveyGroup.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("FormsurveyGroup.*", "FormsurveyGroup.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("FormsurveyGroup.*", "FormsurveyGroup.Delete", "FormsurveyGroup.MultiDelete")) ) : ?>
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