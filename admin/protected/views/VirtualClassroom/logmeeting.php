
<?php

$titleName = 'log การใช้ห้องประชุม';
$formNameModel = 'VRoomLogmeeting';

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
	$.appendFilter("VRoomLogmeeting[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array(
				'type'=>'list',
				'name'=>'v_room_id',
				'query'=>CHtml::listData(VRoom::model()->findAll(array(
		"condition"=>" active = 'y' ",'order'=>'name ASC')),'id', 'name')
			),
				

			array('name'=>'fullname','type'=>'text'),

			array(
				'type'=>'list',
				'name'=>'event',
				'query'=>array('login'=>'login','logout'=>'logout')
			),
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
					// 'filter'=>$model,
					'selectableRows' => 2,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("VRoomLogmeeting[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						// array(
						// 	'visible'=>Controller::DeleteAll(
						// 		array("VRoomLogmeeting.*", "VRoomLogmeeting.Delete", "VRoomLogmeeting.MultiDelete")
						// 	),
						// 	'class'=>'CCheckBoxColumn',
						// 	'id'=>'chk',
						// ),
						/*array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->image)',
							'htmlOptions'=>array('width'=>'110')
						),*/
						array(
							'name'=>'v_room_id',
							'value'=>'$data->VRooms->name',
							'filter'=>$this->listvRoom($model,'v_room_id'),
							'htmlOptions'=>array('style'=>'width: 150px;'),
						),
						array(
							'name'=>'fullname',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"fullname")',
							'htmlOptions'=>array('style'=>'width: 250px;'),
						),
						array(
							'name'=>'event',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"event")',
							'htmlOptions'=>array('style'=>'width: 250px;'),
						),
						array(
							'name'=>'time',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"time")',
							'htmlOptions'=>array('style'=>'width: 250px;'),
						),

					),
				)); ?>
			</div>
		</div>
	</div>

</div>
