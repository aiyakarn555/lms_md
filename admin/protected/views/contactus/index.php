
<?php
$formNameModel 	= 'contactus';
$titleName 		= 'ระบบติดต่อเรา';

$this->breadcrumbs=array(
	$titleName
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#contactus-grid').yiiGridView('update', {
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
	$.appendFilter("Contactus[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">

	<!-- <div class="widget" data-toggle="collapse-widget" data-collapse-closed="true">
		<div class="widget-head">
			<h4 class="heading  glyphicons search"><i></i>ค้นหาขั้นสูง</h4>
		</div>
		<div class="widget-body collapse" style="height: 0px;">
			<div class="search-form">
				<?php //$this->renderPartial('_search',array(
					//'model'=>$model,
				//)); ?>
			</div>
		</div>
	</div> -->

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
					'id'=>'contactus-grid',
					'dataProvider'=>$model->search(),
					'selectableRows' => 2,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array( 'style'=> "margin-top: -1px;" ),
	 				'afterAjaxUpdate'=>'function(id, data){
	 					$.appendFilter("Contactus[news_per_page]");
	 					InitialSortTable();
	 				}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Contactus.*", "Contactus.Delete", "Contactus.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header' => 'หัวข้อ',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"contac_subject")'
						),
						/*array(
							'header' => 'รายละเอียด',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"contac_detail")',
							'htmlOptions'=>array('style'=>'width:25%;'),
						),*/
						array(
							'header' => 'ชื่อผู้ส่ง',
							'type'=>'html',
							'value'=> function ($data){
								return $data->contac_by_name.' '.$data->contac_by_surname;
							},
							'htmlOptions'=>array('style'=>'width:25%;'),
						),
						/*array(
							'header' => 'นามสกุลผู้ส่ง',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"contac_by_surname")',
							'htmlOptions'=>array('style'=>'width:10%;')
						),*/
						array(
							'header' => 'สถานะ',
							'value'=> function ($data){
								if ($data->contac_answer == "y") {
									echo "ตอบเมล์แล้ว";
								}else
								{
									echo "ยังไม่ได้ตอบเมล์";
								}
							},
						),
						array(
							'header' => 'วันที่ส่ง',
							'value'=> 'ClassFunction::datethaiTime($data->create_date)'
						),
						array(
							'class'=>'AButtonColumn',
							'template'=>'{view}{delete}',
							'visible'=>Controller::PButton(
								array("Contactus.*", "Contactus.View", "Contactus.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("Contactus.*", "Contactus.View") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("Contactus.*", "Contactus.Delete") )'
								),
							),
						),
					),
				)); ?>

			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Contactus.*", "Contactus.Delete", "Contactus.MultiDelete")) ) : ?>
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
