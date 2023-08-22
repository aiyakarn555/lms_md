
<?php
$formNameModel = 'page';
$titleName = 'ระบบจำนวนการแสดงผล';

$this->breadcrumbs=array(
	$titleName
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#page-grid').yiiGridView('update', {
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
	$.appendFilter("Page[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<div class="widget" data-toggle="collapse-widget" data-collapse-closed="true">
		<div class="widget-head">
			<h4 class="heading  glyphicons search"><i></i>ค้นหาขั้นสูง</h4>
		</div>
		<div class="widget-body collapse" style="height: 0px;">
			<div class="search-form">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
			</div>
		</div>
	</div>

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
					'dataProvider'=>$model->pagecheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array( 'style'=> "margin-top: -1px;" ),
	 				'afterAjaxUpdate'=>'function(id, data){
	 					$.appendFilter("Page[news_per_page]");	
	 					InitialSortTable();
	 				}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Page.*", "Page.Delete", "Page.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',  
						),
						array(
							'name'=>'page_num',
							'type'=>'raw',
							'value'=>'UHtml::markSearch($data,"page_num")',
						),
						array(
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Page.*", "Page.View", "Page.Update", "Page.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Page.*", "Page.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Page.*", "Page.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Page.*", "Page.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Page.*", "Page.Delete", "Page.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
			<?php 
			echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
				"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
				"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');")
			); 
			?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
