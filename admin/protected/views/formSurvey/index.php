
<?php
$titleName = 'ระบบสร้างแบบสอบถาม';
$formNameModel = 'FormSurvey';

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
	$.appendFilter("FormSurvey[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<script >
	function confirmApprove(){
		if(confirm("ต้องการยืนยันการเปิดใช้แบบสอบถามหรือไม่ "))
		{
			return false;
		}
		else
		{
			return false;
		}
		return false;
	}
	
</script>
<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'fs_head','type'=>'text'),
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
					'dataProvider'=>$model->formsurveycheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("FormSurvey[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("FormSurvey.*", "FormSurvey.Delete", "FormSurvey.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'fs_head',
							'header'=>'หัวข้อ',
							'headerHtmlOptions'=>array('style'=>'text-align:center'),
							'value'=>'$data->fs_head',
							'filter'=>CHtml::activeTextField($model,'fs_head'),
			                'htmlOptions' => array(
			                   'style' => 'width:230px',
			                ),  
						),
						array(
							'name'=>'fs_type',
							'header'=>'รูปแบบของแบบสอบถาม',
							'headerHtmlOptions'=>array('style'=>'text-align:center'),
							'value'=>'$data->fs_type',
							//'filter'=>CHtml::activeTextField($model,'fs_type'),
			                'htmlOptions' => array(
			                   'style' => 'width:230px',
			                ),  
						),
						array(
							'header'=>'สถานะยืนยัน',
							'value'=>'($data->status_approve=="y") ? "ยืนยันแล้ว":"ยังไม่ได้ยืนยัน" ',
			                'htmlOptions' => array(
			                   'style' => 'width:65px;text-align:center',
			                ),  
						),
						array(
					      'value'=>'($data->status_approve=="n") ? CHtml::button("ยืนยัน",  array("class" => "btn btn-primary btn-icon","onclick"=>"confirmApprove()" ,"submit" => Yii::app()->createUrl("FormSurvey/Approve", array("id"=>$data->fs_id)))):CHtml::button("ยืนยันแล้ว",  array("class" => "btn btn-primary btn-icon","onclick"=>"javascript(0)"))',
					      'type'=>'raw',
					      'htmlOptions'=>array('width'=>'40px','style'=>'text-align:center'),
					    ),
						array(
					      'value'=>'CHtml::button("FormPDF",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("FormSurvey/formPDF", array("id"=>$data->fs_id))))',
					      'type'=>'raw',
					      'htmlOptions'=>array('width'=>'40px','style'=>'text-align:center'),
					    ),
					    array(
					      /* 'value'=>'CHtml::button("ExportExcel",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("FormSurvey/ExportForm", array("id"=>$data->fs_id))))', */
					      'value'=>'$data->getCheckFormExcel($data->fs_id)',
					      'type'=>'raw',
					      'htmlOptions'=>array('width'=>'40px','style'=>'text-align:center'),
					    ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("FormSurvey.*", "FormSurvey.View", "FormSurvey.Update", "FormSurvey.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("FormSurvey.*", "FormSurvey.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("FormSurvey.*", "FormSurvey.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("FormSurvey.*", "FormSurvey.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("FormSurvey.*", "FormSurvey.Delete", "FormSurvey.MultiDelete")) ) : ?>
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