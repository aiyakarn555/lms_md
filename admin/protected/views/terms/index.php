
<?php
$formNameModel 	= 'terms';
$titleName 		= 'ระบบเงื่อนไขการใช้งาน';

$this->breadcrumbs=array(
	$titleName
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#terms-grid').yiiGridView('update', {
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
	$.appendFilter("terms[news_per_page]", "news_per_page");
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
					'id'=>'terms-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array( 'style'=> "margin-top: -1px;" ),
	 				'afterAjaxUpdate'=>'function(id, data){
	 					$.appendFilter("terms[news_per_page]");
	 					InitialSortTable();
	 				}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("terms.*", "terms.Delete", "terms.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'terms_title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"terms_title")'
						),
						array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
                           	$width = (count($lang)*100) + 20;
					        foreach ($lang as $key => $value) {
					    		$menu = terms::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->terms_id,'active'=>'y'));
					    		$str = ' (เพิ่ม)';
					    		$class = "btn btn-icon";
					    		$link = array("/terms/create","lang_id"=>$value->id,"parent_id"=>$val->terms_id);
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->id : $val->terms_id;
					    			$str = ' (แก้ไข)';
					    			$class = "btn btn-success btn-icon";
					    			$link = array("/terms/update","id"=>$id);
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
								array("terms.*", "terms.View", "terms.Update", "terms.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("terms.*", "terms.View") )'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("terms.*", "terms.Update") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("terms.*", "terms.Delete") )'
								),
							),
						),
					),
				)); ?>

			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("terms.*", "terms.Delete", "terms.MultiDelete")) ) : ?>
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
