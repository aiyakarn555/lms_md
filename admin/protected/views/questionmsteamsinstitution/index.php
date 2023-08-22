<?php
$titleName = 'ระบบข้อสอบชุด(สถาบัน):'.$title_group;
$formNameModel = 'QuestionMsTeamsInstitution';
$this->breadcrumbs = array(
	'ระบบชุดข้อสอบบทเรียนออนไลน์(สถาบัน)'=>array('//GrouptestingMsTeamsInstitution/Index'),
	'ระบบข้อสอบ(สถาบัน)'
);

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
	$.appendFilter("QuestionMsTeamsInstitution[news_per_page]", "news_per_page");
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
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->questioncheck()->search($pk),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("QuestionMsTeamsInstitution[news_per_page]");	
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("QuestionMsTeamsInstitution.*", "QuestionMsTeamsInstitution.Delete", "QuestionMsTeamsInstitution.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'ques_title',
							'type'=>'html',
							'value'=>'CHtml::decode(UHtml::markSearch($data,"ques_title"))'
						),
                        array(
                            'name'=>'choices.choice_answer',
                            'value'=>function($data)
                            {
                                if($data){
                                    foreach($data->choices as $data_choices){
                                        if($data_choices->choice_answer==1){
                                            echo $data_choices->choice_detail;
                                        }
                                    }
                                }
                            },
                        ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("QuestionMsTeamsInstitution.*", "QuestionMsTeamsInstitution.View", "QuestionMsTeamsInstitution.Update", "QuestionMsTeamsInstitution.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("QuestionMsTeamsInstitution.*", "QuestionMsTeamsInstitution.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("QuestionMsTeamsInstitution.*", "QuestionMsTeamsInstitution.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("QuestionMsTeamsInstitution.*", "QuestionMsTeamsInstitution.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("QuestionMsTeamsInstitution.*", "QuestionMsTeamsInstitution.Delete", "QuestionMsTeamsInstitution.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php 
				echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด",
					"#",
					array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
						"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');")); 
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
