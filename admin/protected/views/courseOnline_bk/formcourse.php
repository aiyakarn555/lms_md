
<?php
$this->breadcrumbs=array(
	'ระบบบทเรียน'=>array('index'),
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
				'id'=>'Coursemanage-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					  	'validateOnSubmit'=>true
				),
			)); ?>
			<div class="row">
				<?php echo $form->labelEx($Coursemanage,'group_id'); ?>
				<?php echo $this->listGroupCourse($Coursemanage,$model->course_id,'span8');?>
				<?php echo ClassFunction::CircleQuestionMark();?>
				<?php echo $form->error($Coursemanage,'group_id'); ?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($Coursemanage,'manage_row'); ?>
				<?php echo $form->textField($Coursemanage,'manage_row',array('class'=>'span8')); ?>
				<?php echo ClassFunction::CircleQuestionMark();?>
				<?php echo $form->error($Coursemanage,'manage_row'); ?>
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
	    $("#Coursemanage-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("Coursemanage[news_per_page]", "news_per_page");
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
					<?php echo $this->listPageShow('Coursemanage');?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>'Coursemanage-grid',
					'dataProvider'=>$CoursemanageModel->search($pk),
					'filter'=>$CoursemanageModel,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Coursemanage[news_per_page]");
						InitialSortTable();		
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Coursemanage.*", "Coursemanage.Delete", "Coursemanage.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'group_id',
							'value'=>'$data->group->group_title',
							'filter'=>CHtml::activeTextField($CoursemanageModel,'group_search'),
						),
						array(
							'name'=>'manage_row',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"manage_row")'
						),
						array(
							'header'=>'จำนวนข้อสอบที่มี',
							'value'=>'$data->Countcourse',
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
								array("CourseOnline.*")
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'false' 
								),
								'update'=> array( 
									'visible'=>'true',
									'url'=>'$this->grid->controller->createUrl("/CourseOnline/Updatecourse", array("id"=>"$data->manage_id","type"=>"course","course_id"=>$data->id))',
								),
								'delete'=> array( 
									'visible'=>'true',
									'url'=>'$this->grid->controller->createUrl("/Coursemanage/delete", array("id"=>"$data->manage_id"))',
								),
							),

						),
					),
				)); ?>
			</div>			
	</div>
</div>

	<?php if( Controller::DeleteAll(array("Coursemanage.*", "Coursemanage.Delete", "Coursemanage.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php 
				echo CHtml::link("<i></i> ลบข้อสอบทั้งหมด",
					"#",
					array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
						"onclick"=>"return multipleDeleteNews('".$this->createUrl('//Coursemanage/MultiDelete')."','Coursemanage-grid');"));
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
		$('#Coursemanage-form').submit(function(){
			var manage_group_id = $('#Coursemanage_group_id option:selected').val();
			var manage_manage_row = parseInt($('#Coursemanage_manage_row').val());
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
