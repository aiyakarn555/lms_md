<?php
$titleName = 'ระบบจัดการลิงค์แนะนำ';
$formNameModel = 'FeaturedLinks';

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
	$.appendFilter("FeaturedLinks[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'link_name','type'=>'text'),
		array('name'=>'link_url','type'=>'test'),
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
				'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("FeaturedLinks[news_per_page]");
						InitialSortTable();	
					}',
				'columns'=>array(
					array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->link_image)',
							'htmlOptions'=>array('width'=>'110')
						),
					array(
							'name'=>'link_name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"link_name")'
						),
					array(
							'name'=>'link_url',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"link_url")'
						),
					array(            
						'class'=>'AButtonColumn',
						'visible'=>Controller::PButton( 
							array("FeaturedLinks.*", "FeaturedLinks.View", "FeaturedLinks.Update", "FeaturedLinks.Delete") 
						),
						'buttons' => array(
							'view'=> array( 
								'visible'=>'Controller::PButton( array("FeaturedLinks.*", "FeaturedLinks.View") )' 
							),
							'update'=> array( 
								'visible'=>'Controller::PButton( array("FeaturedLinks.*", "FeaturedLinks.Update") )' 
							),
							'delete'=> array( 
								'visible'=>'Controller::PButton( array("FeaturedLinks.*", "FeaturedLinks.Delete") )' 
							),
						),
					),
				),
			)); ?>
			</div>
		</div>
	</div>
</div>