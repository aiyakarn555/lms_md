
<?php
$this->breadcrumbs=array(
	'ระบบบทเรียนออนไลน์'=>array('index'),
	'เลือกชุดข้อสอบ',
);

?>
<!-- innerLR -->
<div class="innerLR">

	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>เลือกชุดข้อสอบ
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
			<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'manage-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					  	'validateOnSubmit'=>true
				),
			)); ?>
			<div class="row">
				<?php echo $form->labelEx($Manage,'group_id'); ?>
				<?php echo $this->listGroupLessonMsTeams($Manage,$model->id,'span8');?>
				<?php echo ClassFunction::CircleQuestionMark();?>
				<?php echo $form->error($Manage,'group_id'); ?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($Manage,'manage_row'); ?>
				<?php echo $form->textField($Manage,'manage_row',array('class'=>'span8')); ?>
				<?php echo ClassFunction::CircleQuestionMark();?>
				<?php echo $form->error($Manage,'manage_row'); ?>
			</div>
			<div class="row buttons">
				<!-- <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?> -->
				<?php 
					echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-primary btn-icon  ok_2','id'=>'formSave','name' => 'submit'));
					?>
			</div>
			<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
<?php
Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#Manage-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("Manage[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<div class="widget">
	<div class="widget-head">
		<h4 class="heading">รายละเอียดข้อสอบที่เลือก</h4>
	</div>
	<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow('Manage');?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>'Manage-grid',
					'dataProvider'=>$ManageModel->search($pk),
					'filter'=>$ManageModel,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Manage[news_per_page]");
						InitialSortTable();		
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Manage.*", "Manage.Delete", "Manage.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'group_id',
							'value'=>'$data->group->group_title',
							'filter'=>CHtml::activeTextField($ManageModel,'group_search'),
						),
						array(
							'name'=>'manage_row',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"manage_row")'
						),
						array(
							'header'=>'จำนวนข้อสอบที่มี',
							'value'=>'$data->Count',
						),
						array(            
							'class'=>'AButtonColumn',
							/*'buttons'=>array(
							    'view' => array('visible'=>''),
								'update'=>array(
		                        	'url'=>'$this->grid->controller->createUrl("/Lesson/UpdateLesson", array("id"=>"$data->manage_id"))',
		                        ),
							),
							'deleteButtonUrl'=>'Yii::app()->createUrl("//manage/delete",array(
								"id"=>$data->manage_id
							))',*/

							'visible'=>Controller::PButton( 
								array("Lesson.*") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'false' 
								),
								'update'=> array( 
									'visible'=>'true',
									'url'=>function ($model) use ($type) {
							                return Yii::app()->createUrl("/lessonMsTeams/UpdateLessonMs", array("id"=>$model->manage_id,"type"=>$type));

							                // return $this->grid->controller->createUrl("/Lesson/UpdateLesson", array("id"=>$model->manage_id,"type"=>$type));
							            },

									
								),
								'delete'=> array( 
									'visible'=>'true',
									'url'=>'$this->grid->controller->createUrl("/manage/deleteteams", array("id"=>"$data->manage_id"))', 
								),
							),

						),
					),
				)); ?>
			</div>			
	</div>
</div>

	<?php if( Controller::DeleteAll(array("Manage.*", "Manage.Delete", "Manage.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php 
				echo CHtml::link("<i></i> ลบข้อสอบทั้งหมด",
					"#",
					array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
						"onclick"=>"return multipleDeleteNews('".$this->createUrl('//Manage/MultiDelete')."','Manage-grid');")); 
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>
	
</div>
<!-- END innerLR -->
<script type="text/javascript">

	$(function () {
		$('#manage-form').submit(function(){
			var manage_group_id = $('#Manage_group_id option:selected').val();
			var manage_manage_row = parseInt($('#Manage_manage_row').val());
			var state = Number.isInteger(manage_manage_row);
			if(manage_group_id != "" && manage_manage_row != "" && state){
				setTimeout(function () {
					document.getElementById('formSave').value = 'กำลังประมวล…';
					document.getElementById('formSave').disabled = true;
				}, 300);
			}
		});
	});

</script>
