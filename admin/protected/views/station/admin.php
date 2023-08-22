<?php
$titleName = 'ระบบจัดการสถานี';
$formNameModel = 'Station';

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
	$.appendFilter("Company[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'station_title','type'=>'text'),
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
						$.appendFilter("Station[news_per_page]");
						InitialSortTable();	
					}',
				'columns'=>array(
					
					array(
							'name'=>'station_title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"station_title")'
						),
					array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
                           	$width = (count($lang)*100) + 20;
					        foreach ($lang as $key => $value) {
					    		$menu = Station::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->station_id,'active'=>'y'));
					    		$str = ' (เพิ่ม)';
					    		$class = "btn btn-icon";
					    		$link = array("/Station/create","lang_id"=>$value->id,"parent_id"=>$val->station_id);
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->station_id : $val->station_id;
					    			$str = ' (แก้ไข)';
					    			$class = "btn btn-success btn-icon";
					    			$link = array("/Station/update","id"=>$id);
					    		} 
					            $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;border: 1px solid;'));
					        }
					        return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
                    	},
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
                		),
					
					array(            
						'class'=>'AButtonColumn',
						'visible'=>Controller::PButton( 
							array("Station.*", "Station.View", "Station.Update", "Station.Delete") 
						),
						'buttons' => array(
							'view'=> array( 
								'visible'=>'Controller::PButton( array("Station.*", "Station.View") )' 
							),
							'update'=> array( 
								'visible'=>'Controller::PButton( array("Station.*", "Station.Update") )' 
							),
							'delete'=> array( 
								'visible'=>'Controller::PButton( array("Station.*", "Station.Delete") )' 
							),
						),
					),
				),
			)); ?>
			</div>
		</div>
	</div>
</div>