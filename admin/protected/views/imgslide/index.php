
<?php
$titleName = 'ระบบสไลด์รูปภาพ';
$formNameModel = 'Imgslide';

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
	$.appendFilter("Imgslide[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array( 
			array('name'=>'imgslide_title','type'=>'text'),
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
					'dataProvider'=>$model->imgslidecheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Imgslide[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Imgslide.*", "Imgslide.Delete", "Imgslide.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndexLinux("imgslide",$data->imgslide_id,$data->imgslide_picture)',
							'htmlOptions'=>array('width'=>'110')
						),
						// array(
						// 	'name'=>'imgslide_link',
						// 	'type'=>'html',
						// 	'value'=>'UHtml::markSearch($data,"imgslide_link")'
						// ),
						array(
							'name'=>'imgslide_title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"imgslide_title")'
						),
						array(
							'name'=>'imgslide_detail',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"imgslide_detail")'
						),
						array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
                           	$width = (count($lang)*100) + 20;
					        foreach ($lang as $key => $value) {
					    		$menu = Imgslide::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->imgslide_id,'active'=>'y'));
					    		$str = ' (เพิ่ม)';
					    		$class = "btn btn-icon";
					    		$link = array("/imgslide/create","lang_id"=>$value->id,"parent_id"=>$val->imgslide_id);
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->id : $val->imgslide_id;
					    			$str = ' (แก้ไข)';
					    			$class = "btn btn-success btn-icon";
					    			$link = array("/imgslide/update","id"=>$id,"lang_id"=>$value->id);
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
								array("Imgslide.*", "Imgslide.View", "Imgslide.Update", "Imgslide.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Imgslide.*", "Imgslide.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Imgslide.*", "Imgslide.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Imgslide.*", "Imgslide.Delete") )' 
								),
							),
						),
					),
				)); 
				?>
			</div>		
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Imgslide.*", "Imgslide.Delete", "Imgslide.MultiDelete")) ) : ?>
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
