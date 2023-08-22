
<?php
$titleName = 'ระบบรายชื่อธนาคารโอนเงิน';
$formNameModel = 'Bank';

$this->breadcrumbs=array('จัดการ'.$titleName);
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
	$.appendFilter("Bank[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'bank_name','type'=>'text'),
			array('name'=>'bank_branch','type'=>'text'),
			array('name'=>'bank_number','type'=>'text'),
			array('name'=>'bank_user','type'=>'text'),
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
					'dataProvider'=>$model->bankcheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Bank[news_per_page]");	
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Bank.*", "Bank.Delete", "Bank.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->bank_picture)',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'name'=>'bank_name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"bank_name")'
						),
						array(
							'name'=>'bank_branch',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"bank_branch")'
						),
						array(
							'name'=>'bank_number',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"bank_number")'
						),
						array(
							'name'=>'bank_user',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"bank_user")'
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Bank.*", "Bank.View", "Bank.Update", "Bank.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Bank.*", "Bank.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Bank.*", "Bank.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Bank.*", "Bank.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Bank.*", "Bank.Delete", "Bank.MultiDelete")) ) : ?>
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
