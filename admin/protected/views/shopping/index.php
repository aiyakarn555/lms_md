
<?php
$titleName = 'ระบบสินค้า';
$formNameModel = 'Shopping';

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
$.appendFilter("Shopping[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'shoptype_id','type'=>'list','query'=>CHtml::listData(Shoptype::model()->findAll(array(
			"condition"=>" active = 'y' ",'order'=>'shoptype_id')), 'shoptype_id', 'shoptype_name')),
			array('name'=>'shop_number','type'=>'text'),
			array('name'=>'shop_name','type'=>'text'),
			array('name'=>'price','type'=>'text'),
			array('name'=>'shop_unit','type'=>'text')
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
					'dataProvider'=>$model->shoppingcheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Shopping[news_per_page]");	
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Shopping.*", "Shopping.Delete", "Shopping.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->shop_picture)',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'name'=> 'shoptype.shoptype_name',
							'filter'=>Controller::listShopTypeShow($model),
							'htmlOptions' => array(
								'width'=>'100',
							),
						),
						array(
							'name'=>'shop_number',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"shop_number")'
						),
						array(
							'name'=>'shop_name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"shop_name")'
						),
						array(
							'name'=>'price',
							'value'=>'number_format($data->price)'
						),
						array(
							'header'=>'หน่วยเรียก',
							'name'=>'shop_unit',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"shop_unit")'
						),
				        array(
				        	'name'=>'shop_status',
				        	'class'=>'JToggleColumn',
				            'filter' => array('0' => '-', '1' => 'แนะนำ'), // filter
				            'action'=>'toggle', // other action, default is 'toggle' action
				            'checkedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/check.png',  // Image,text-label or Html
				            'uncheckedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/delete.png', // Image,text-label or Html
				            'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
				            'htmlOptions'=>array('style'=>'text-align:center;width:100px;')
				        ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Shopping.*", "Shopping.View", "Shopping.Update", "Shopping.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Shopping.*", "Shopping.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Shopping.*", "Shopping.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Shopping.*", "Shopping.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Shopping.*", "Shopping.Delete", "Shopping.MultiDelete")) ) : ?>
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
