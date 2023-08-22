<?php
/* @var $this PointController */
/* @var $dataProvider CActiveDataProvider */
$titleName = 'อนุมัติ Point';
$formNameModel = 'Point';

$this->breadcrumbs=array('จัดการ'.$titleName);
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
$.appendFilter("Point[news_per_page]", "newsPerPage");
EOD
, CClientScript::POS_READY);
?>
<!-- Heading -->
<div class="heading-buttons">
	<h3>จัดการ<?php echo $titleName;?></h3>
</div>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'id','type'=>'list','query'=>CHtml::listData(User::model()->findAll(), 'id', 'username')),
		array('name'=>'point_money','type'=>'text'),
		array(
			'type'=>'list',
			'name'=>'con_admin',
			'query'=>array(
				'0'=>'ยังไม่อนุมัติ',
				'1'=>'อนุมัติแล้ว',
		)),
		//array('name'=>'create_date','type'=>'text'),
		// array('name'=>'description','type'=>'textArea'),
	),
	));?>
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> จัดการ<?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
		<?php $this->widget('GridView', array(
			'id'=>$formNameModel.'-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'selectableRows' => 2,	
			'htmlOptions' => array(
				'style'=> "margin-top: -1px;",
			),
			'afterAjaxUpdate'=>'function(slash, care) { 
				$.appendFilter("Point[news_per_page]");	
		        jQuery("#create_date").datepicker({
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
					'class'=>'CCheckBoxColumn',
					'id'=>'chk',
				),
				array(
                    'name'=>'id',
                    'filter'=>CHtml::listData(User::model()->findAll(), 'id', 'username'),
                    'value'=>'User::Model()->FindByPk($data->id)->username',
				),
				array(
					'name'=>'point_money',
					'value'=>'number_format($data->point_money)'
				),
				array(
					'name'=>'create_date',
					'value'=>'ClassFunction::datethaitime($data->create_date)',
			           'filter'=>$this->widget('zii.widgets.jui.CJuiDatepicker', array(
			               'model'=>$model,
			               'attribute'=>'create_date',
			               'htmlOptions' => array(
			                   'id' => 'create_date',
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
			                   	'dayNamesMin' => ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
			                   	'monthNamesShort' => ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
			                    'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
			               )
			           ), true)
				),
		        array(
		        	'name'=>'con_admin',
		        	'class'=>'JToggleColumn',
		            'filter' => array('0' => 'ยังไม่อนุมัติ', '1' => 'อนุมัติแล้ว'), // filter
		            'action'=>'toggle', // other action, default is 'toggle' action
		            'checkedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/check.png',  // Image,text-label or Html
		            'uncheckedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/delete.png', // Image,text-label or Html
		            'checkedButtonTitle'=>'Yes.Click to No', // tooltip
		            'uncheckedButtonTitle'=>'No. Click to Yes', // tooltip
		            'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
		            'htmlOptions'=>array('style'=>'text-align:center;min-width:60px;')
		        ),
				array(            
					'class'=>'AButtonColumn',
					'buttons'=>array(
						'delete' => array('visible'=>' $data->ShowIcon '),
						'update' => array('visible'=>'')
					))
				),
		)); ?>
		</div>
	</div>
	<!-- Options -->
	<div class="separator top form-inline small">
		<!-- With selected actions -->
		<div class="buttons pull-left">
			<?php 
			echo CHtml::link("<i></i> ลบข้อสอบทั้งหมด",
				"#",
				array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');")); 
			?>
		</div>
		<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
	<!-- // Options END -->
</div>