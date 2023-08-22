
<?php
$titleName = 'จัดการเมนู';
$formNameModel = 'MonthCheck';

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
	$.appendFilter("MonthCheck[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
<!-- 	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			//array('name'=>'MonthCheck','type'=>'text'),
		),
	));?> -->
	  <div class="col-md-9">
        <a href="<?= Yii::app()->createUrl('monthCheck/create'); ?>" type="button" class="btn btn-primary"><i
            class="fa fa-plus" aria-hidden="true"></i> 
            เพิ่มเดือน
        </a>
    </div>
    <br>
    <br>
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
					'dataProvider'=>$model->monthCheck()->searchship(),
					'filter'=>$model,
					//'selectableRows' => 3,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("MonthCheck.*", "MonthCheck.Delete", "MonthCheck.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'month',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"month")'
						),
						array(
							'type'=>'raw',
							'value'=>function($val){
								if($val->month_status == 'n'){
									return CHtml::link("ปิด",array("/monthCheck/active","id"=>$val->id), array("class"=>"btn btn-danger"));
								} else {
									return CHtml::link("เปิด",array("/monthCheck/active","id"=>$val->id), array("class"=>"btn btn-success"));
								}
							},
							'header' => 'เปิด/ปิด การแสดงผล',
							'htmlOptions'=>array('style'=>'text-align: center;width:100px;'),
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:100px;'),
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("MonthCheck.*", "MonthCheck.View", "MonthCheck.Update", "MonthCheck.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("MonthCheck.*", "MonthCheck.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("MonthCheck.*", "MonthCheck.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("MonthCheck.*", "MonthCheck.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("MonthCheck.*", "MonthCheck.Delete", "MonthCheck.MultiDelete")) ) : ?>
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
