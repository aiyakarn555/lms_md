
<?php
$titleName = 'ระบบข่าวสารและกิจกรรม';
$formNameModel = 'News';

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
	$.appendFilter("News[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'cms_title','type'=>'text'),
		array('name'=>'cms_short_title','type'=>'textArea'),
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
					'dataProvider'=>$model->newscheck()->search(),
					'filter'=>$model,
					'rowCssClassExpression'=>'"items[]_{$data->cms_id}"',
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("News[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("News.*", "News.Delete", "News.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndexLinux("news",$data->cms_id,$data->cms_picture)',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'name'=>'cms_title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"cms_title")'
						),
						array(          
					        'name'=>'cms_short_title',
					        'value'=> 'ClassFunction::textcut($data->cms_short_title,0,200)',
					        'htmlOptions'=>array('style'=>'width:450px; vertical-align:top;'),
					    ),

						array(          
					        'header'=>'ยอดวิว',
					        'value' => function($val) {
					        	$criteria = new CDbCriteria;
					        	$criteria->compare('cms_id', $val->cms_id);
					        	$count = CounterNews::model()->count($criteria);
                           
					        return $count;
                    	},
					        'htmlOptions'=>array('style'=>'width:70px; vertical-align:top;'),
					    ),

					   

					    array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
					        foreach ($lang as $key => $value) {
					    		$menu = News::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
					    		$str = ' (เพิ่ม)';
					    		$class = "btn btn-icon";
					    		$link = array("/News/create","lang_id"=>$value->id,"parent_id"=>$val->id);
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->id : $val->id;
					    			$str = ' (แก้ไข)';
					    			$class = "btn btn-success btn-icon";
					    			// $link = array("/News/update","id"=>$id);
					    			$link = array("/News/update","id"=>$id,"lang_id"=>$value->id,"parent_id"=>$val->id);
					    		} 
					            $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;border: 1px solid;'));
					        }
					        return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
                    	},
		                    'type'=>'raw',
		                    'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
		                ),
		                 array(
							'type'=>'html',
							'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
							'header' => 'ย้าย',
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("News.*", "News.View", "News.Update", "News.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("News.*", "News.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("News.*", "News.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("News.*", "News.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("News.*", "News.Delete", "News.MultiDelete")) ) : ?>
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