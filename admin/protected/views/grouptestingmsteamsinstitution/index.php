
<?php
$titleName = 'ระบบคลังข้อสอบบทเรียนรู้ทางไกล(สถาบัน)';
$formNameModel = 'GrouptestingMsTeamsInstitution';

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
	$.appendFilter("GrouptestingMsTeamsInstitution[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'group_title','type'=>'text'),
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
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("GrouptestingMsTeamsInstitution[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("GrouptestingMsTeamsInstitution.*", "GrouptestingMsTeamsInstitution.Delete", "GrouptestingMsTeamsInstitution.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						// array(
						// 	'name'=>'lesson_id',
						// 	'value'=>'$data->lesson->title',
						// 	'filter'=>CHtml::activeTextField($model,'lesson_search'),
			   //              'htmlOptions' => array(
			   //                 'style' => 'width:230px',
			   //              ),  
						// ),
						array(
							'name'=>'group_title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"group_title")',
						),
						// array(
						// 	'name'=>'lang_id',
						// 	'type'=>'html',
						// 	'value'=>'UHtml::markSearch($data->lang,"language")',
						// ),
						array(
							'header'=>'จำนวนข้อ',
							'value'=>'$data->QuesCount2',
			                'htmlOptions' => array(
			                   'style' => 'width:65px;text-align:center',
			                ),  
						),
                        array(
                            'value'=>'CHtml::link("Import excel", array("questionmsteamsinstitution/import", "id"=>$data->group_id), array("class" => "btn btn-success btn-icon"))',
                            'type'=>'raw',
                            'htmlOptions'=>array('width'=>'120px'),
                        ),
                        array(
					      'value'=>'CHtml::link("Export Excel", array("questionmsteamsinstitution/export", "id"=>$data->group_id) , array("class" => "btn btn-warning btn-icon", "target"=>"blank_"))',
					      'type'=>'raw',
					      'htmlOptions'=>array('width'=>'100px'),
					    ),
         
					    array(
					      'value'=>'CHtml::link("เพิ่มข้อสอบ", array("questionmsteamsinstitution/create", "id"=>$data->group_id) , array("class" => "btn btn-primary btn-icon"))',
					      'type'=>'raw',
					      'htmlOptions'=>array('width'=>'100px'),
					    ),
					    array(
					      'value'=>'CHtml::link("จัดการข้อสอบ", array("questionmsteamsinstitution/index", "id"=>$data->group_id), array("class" => "btn btn-primary btn-icon"))',
					      'type'=>'raw',
					      'htmlOptions'=>array('width'=>'120px'),
					    ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("GrouptestingMsTeamsInstitution.*", "GrouptestingMsTeamsInstitution.View", "GrouptestingMsTeamsInstitution.Update", "GrouptestingMsTeamsInstitution.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("GrouptestingMsTeamsInstitution.*", "GrouptestingMsTeamsInstitution.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("GrouptestingMsTeamsInstitution.*", "GrouptestingMsTeamsInstitution.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("GrouptestingMsTeamsInstitution.*", "GrouptestingMsTeamsInstitution.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("GrouptestingMsTeamsInstitution.*", "GrouptestingMsTeamsInstitution.Delete", "GrouptestingMsTeamsInstitution.MultiDelete")) ) : ?>
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