<?php
$titleName = 'ระบบแจ้งการโอนเงินอบรมออนไลน์';
$formNameModel = 'Orderonline';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
	$('#export').click(function(){
	        window.location = '". $this->createUrl('//Orderonline/ReportOrderonline')  . "?' + $(this).parents('form').serialize() + '&export=true';
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
	$.appendFilter("Orderonline[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'user_name','type'=>'text'),
			array(
				'type'=>'list',
				'name'=>'order_bank',
				'query'=>CHtml::listData(Bank::model()->findAll(),'bank_id', 'bank_name')
			),
			array('name'=>'order_countall','type'=>'text'),
			array('name'=>'order_cost','type'=>'text'),
			array('name'=>'order_date_add','type'=>'date','titleDate'=>'วันที่แจ้งการโอน'),
			array(
				'type'=>'list',
				'name'=>'con_admin',
				'query'=>array(
					'0'=>'ยังไม่อนุมัติ',
					'1'=>'อนุมัติแล้ว',
			)),
		),
	));?>
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">

				<?php if(Controller::PButton( array("Orderonline.*", "Orderonline.ReportOrderonline") ) == true): ?>
					<span class="pull-left">
						<?php echo CHtml::tag('button',array(
							'class' => 'btn btn-primary btn-icon glyphicons print',
							'id'=> 'export',
						),'<i></i>ออกรายงาน'); ?>
					</span>
				<?php endif; ?>

				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->orderonlinecheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Orderonline[news_per_page]");
						InitialSortTable();	
				        jQuery("#create_date,#update_date,#order_date_add").datepicker({
						   	"dateFormat": "dd/mm/yy",
						   	"showAnim" : "slideDown",
					        "showOtherMonths": true,
					        "selectOtherMonths": true,
				            "yearRange" : "-5+10", 
					        "changeMonth": true,
					        "changeYear": true,
				            "dayNamesMin" : ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
				            "monthNamesShort" : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
				                "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
					   })
					}',
					'columns'=>array(
						array(
							'header'=>'เลขใบสั่งซื้อ',
							'name'=>'order_id',
							'value'=>'$data->OrderId',
							'headerHtmlOptions' => array( 'style' => 'text-align:center;'), 
			                'htmlOptions' => array(
			                   'style' => 'width:85px;text-align:center;',
			                ),  
						),
						array(
							'name'=>'user_id',
							'value'=>'$data->NameUser',
							'filter'=>CHtml::activeTextField($model,'user_name'),
			                'htmlOptions' => array(
			                   'style' => 'width:115px',
			                ),  
						),
						/*array(
							'header'=>'จำนวนการจอง',
							'name'=>'order_countall',
							'value'=>'number_format($data->order_countall)',
			                'htmlOptions' => array(
			                   'style' => 'width:95px; text-align:center;',
			                ),  
						),*/
						array(
							'name'=>'order_bank',
							'filter'=>$this->listBankAll($model,'order_bank'),
							'type'=>'raw',
							'value'=>'$data->NameBankCheck',
			                'htmlOptions' => array(
			                   'style' => 'width:95px; text-align:center;',
			                ),  
						),
						array(
							'name'=>'order_cost',
							'value'=>'number_format($data->order_cost)',
			                'htmlOptions' => array(
			                   'style' => 'width:95px',
			                ),  
						),
						array(
							'header'=>'แจ้งการโอนเงิน',
							'name'=>'order_date_add',
							'type'=>'html',
			                'htmlOptions' => array(
			                   'style' => 'width:105px',
			                ), 
							'value'=>'$data->DateConfirm',
					           'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					               'model'=>$model,
					               'attribute'=>'order_date_add',
					               'htmlOptions' => array(
					                   'id' => 'order_date_add',
					                   'style' => 'width:105px',
					               ),  
					               'options' => array(
					                	'mode'=>'focus',
					                	'dateFormat'=>'dd/mm/yy',
					                   	'showAnim' => 'slideDown',
					            	   	'showOn' => 'focus', 
					            	   	'showOtherMonths' => true,
					            		'selectOtherMonths' => true,
					                   	'yearRange' => '-5+10', 
					            		'changeMonth' => true,
					            		'changeYear' => true,
					                   	'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
					                   	'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
					                    'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
					               )
					           ), true)
						),
						/*array(
							'name'=>'order_date_time',
							'type'=>'html',
							'value'=>'$data->TimeConfirm',
			                'htmlOptions' => array(
			                   'style' => 'width:105px; text-align:center;',
			                ),  
						),*/
						array(
							'header'=>'การโอนเงิน',
							'filter'=>false,
							'name'=>'order_file',
							'type'=>'html',
							'value'=>'$data->CheckFileUp',
			                'htmlOptions' => array(
			                   'style' => 'width:110px; text-align:center;',
			                ),  
						),
						/*array(
							'name'=>'order_point',
							'value'=>'number_format($data->order_point)',
			                'htmlOptions' => array(
			                   'style' => 'width:50px',
			                ),  
						),*/
				        array(
				        	'name'=>'con_admin',
				        	'checkPoint'=>'orderonline',
				        	'class'=>'JToggleColumn',
				            'filter' => array('0' => 'ยังไม่ได้ยืนยัน', '1' => 'ยืนยันแล้ว'), // filter
				            'action'=>'toggle', // other action, default is 'toggle' action
				            'checkedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/check.png',  // Image,text-label or Html
				            'uncheckedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/delete.png', // Image,text-label or Html
				            'checkedButtonTitle'=>'Yes.Click to No', // tooltip
				            'uncheckedButtonTitle'=>'No. Click to Yes', // tooltip
				            'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
				            'htmlOptions'=>array('style'=>'text-align:center;width:105px;')
				        ),
						array(            
							'class'=>'AButtonColumn',
			                'htmlOptions' => array(
			                   'style' => 'width:70px;text-align:center;',
			                ),  
							'visible'=>Controller::PButton( 
								array("Orderonline.*", "Orderonline.View", "Orderonline.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Orderonline.*", "Orderonline.View") )' 
								),
								'update'=> array( 
									'visible'=>'false' 
								),
								'delete'=> array( 
									'visible'=>'$data->ShowIcon',
									'style'=>'text-align:center;'
								),
							)),
						),
				)); ?>
			</div>
		</div>
	</div>
</div>
