<?php
$this->breadcrumbs=array(
	'จัดการข้อมูลผู้ผ่านการเรียนกรมเจ้าท่า',
);
$formNameModel = 'ImportPassMd';

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
	$.appendFilter("ImportPassMd[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);

				?>
				<div id="user" class="innerLR">

					<?php $this->widget('AdvanceSearchForm', array(
						'data'=>$model,
						'route' => $this->route,
						'attributes'=>array( 
							array('name'=>'idcard','type'=>'text'),
							array('name'=>'fullname','type'=>'text'),
						)
					));
					?>
					<div class="widget" style="margin-top: -1px;">
						<div class="widget-head">
							<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration"); ?></h4>
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
									'selectableRows' => 2,
									//'rowCssClassExpression'=>'"items[]_{$data->id}"',
									// 'htmlOptions' => array(
									// 	'style'=> "margin-top: -1px;width:200%;",
									// ),
									'afterAjaxUpdate'=>'function(id, data){
										$.appendFilter("ImportPassMd[news_per_page]");
										InitialSortTable();	
										jQuery("#course_date").datepicker({
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
											'header'=>'No.',
											'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
											'filterHtmlOptions'=>array('style'=>'width:1px;'), 
											'htmlOptions'=>array('style'=>'text-align: center;hight:5%;'),
										),

										array(
											'header'=>'รหัสบัตรประชาชน',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
												return $data->idcard;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
										),


										array(
											'header'=>'ชื่อ - นามสกุล',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
												return $data->fname . " " . $data->lname;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
										),

										array(
											'header'=>'Code หลักสูตร',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
												return $data->course_md_id;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
										),

										array(
											'header'=>'รหัสสถาบัน',
											'type'=>'html',
			// 'value'=>'UHtml::markSearch($data,"create_date")'
											'filter' => false,
											'value'=>function($data){
												return $data->institution_id;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											// 'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
											// 'headerHtmlOptions'=>array('style'=>'text-align:center;width:100%;'),
										),

										array(
											'header'=>'เลขที่ ปก.',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
													return $data->course_number;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
										),
									
									),
));

?>


</div><!-- form -->
</div>
</div>
</div>
<!-- END innerLR -->

