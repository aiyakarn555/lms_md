
<?php
$titleName = 'ระบบประเภทเอกสาร';
$formNameModel = 'DocumentType';

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
	$.appendFilter("DocumentType[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'dty_name','type'=>'text'),
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
					'loadProcessing' => true,
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(slash, care) {
						$.appendFilter("DocumentType[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
                        array(
							'visible'=>Controller::DeleteAll(
								array("DocumentType.*", "DocumentType.Delete", "DocumentType.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),

						array(
							'header'=>'ชื่อ',
							'type'=>'raw',
							'value'=> '$data->dty_name',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
                           	$width = (count($lang)*100) + 20;
					        foreach ($lang as $key => $value) {
					    		$menu = DocumentType::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->dty_id,'active'=>'1'));
					    		$str = ' (เพิ่ม)';
					    		$class = "btn btn-icon";
					    		$link = array("/Document/createtype","lang_id"=>$value->id,"parent_id"=>$val->dty_id);
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->dty_id : $val->dty_id;
					    			$str = ' (แก้ไข)';
					    			$class = "btn btn-success btn-icon";
					    			$link = array("/Document/update_type","id"=>$id,"lang_id" =>$value->id,"parent_id"=>$val->dty_id);
					    		} 
					            $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;'));
					        }
					        return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
                    	},
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
                		),
						array(
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton(
								array("DocumentType.*", "DocumentType.Update", "DocumentType.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("DocumentType.*", "DocumentType.View") )',
									'url' =>  'Yii::app()->createUrl("document/view_type", array("id"=>$data->dty_id))'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("DocumentType.*", "DocumentType.Update") )' ,
									'url' =>  'Yii::app()->createUrl("document/update_type", array("id"=>$data->dty_id))'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("DocumentType.*", "DocumentType.Delete") )',
									'url' =>'Yii::app()->createUrl("document/deletetype", array("id"=>$data->dty_id))',
								),
							),
						),
					),
				));
				?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("DocumentType.*", "DocumentType.Delete", "DocumentType.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//document/MultiDeletetype')."','$formNameModel-grid');"
				)); ?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
