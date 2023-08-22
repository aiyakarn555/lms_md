
<?php
$titleName = 'ระบบเอกสารเผยแพร่';
$formNameModel = 'Document';

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
	$.appendFilter("Document[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'dow_name','type'=>'text'),
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
						$.appendFilter("Document[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
                        array(
							'visible'=>Controller::DeleteAll(
								array("Document.*", "Document.Delete", "Document.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'หมวดเอกสาร',
							'type'=>'raw',
							'value'=> '$data->documentType->dty_name',
							'htmlOptions'=>array('width'=>'110')
						),

						array(
							'header'=>'ไฟล์',
							'type'=>'raw',
							'value'=> '$data->dow_address',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'header'=>'ชื่อ',
							'type'=>'raw',
							'value'=> '$data->dow_name',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
                           	$width = (count($lang)*100) + 20;
					        foreach ($lang as $key => $value) {
					    		$menu = Document::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->dow_id,'active'=>'1'));
					    		$str = ' (เพิ่ม)';
					    		$class = "btn btn-icon";
					    		$link = array("/Document/create","lang_id"=>$value->id,"parent_id"=>$val->dow_id);
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->dow_id : $val->dow_id;
					    			$str = ' (แก้ไข)';
					    			$class = "btn btn-success btn-icon";
					    			$link = array("/Document/update","id"=>$id,"lang_id" =>$value->id,"parent_id"=>$val->dow_id);
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
								array("Document.*", "Document.View", "Document.Update", "Document.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("Document.*", "Document.View") )'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("Document.*", "Document.Update") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("Document.*", "Document.Delete") )'
								),
							),
						),
					),
				));
				?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Document.*", "Document.Delete", "Document.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
				)); ?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
