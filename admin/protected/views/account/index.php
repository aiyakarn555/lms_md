
<?php
$titleName = 'ระบบมุมคนบัญชี';
$formNameModel = 'Account';

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
	$.appendFilter("Account[news_per_page]", "news_per_page");
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
					'dataProvider'=>$model->accountcheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Account[news_per_page]");	
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Account.*", "Account.Delete", "Account.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->cms_picture)',
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
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Account.*", "Account.View", "Account.Update", "Account.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Account.*", "Account.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Account.*", "Account.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Account.*", "Account.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Account.*", "Account.Delete", "Account.MultiDelete")) ) : ?>
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
