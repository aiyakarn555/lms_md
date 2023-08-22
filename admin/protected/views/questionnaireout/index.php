<?php
$titleName = 'แบบสอบถามภายนอก';
$formNameModel = 'Questionnaire';
$this->breadcrumbs = array(
	'ระบบแบบสอบถามภายนอก'
);

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
	$.appendFilter("Questionnaire[news_per_page]", "news_per_page");

	$(document).on('click','.btn-sendmail',function() {
		var href_url = $(this).attr('href');
		$('#url').val(href_url);
		$('#myModal').modal();
		return false;
	});

	$(document).on('click','#sendmail',function() {
		var url = $('#url').val();

		// if($('#university').val() != ''){
		// 	url += '?university_id='+$('#university').val();
		// }
		// console.log(url);

		$.ajax({
		  method: "GET",
		  url: url,
		  data: { university_id: $('#university').val() }
		})
		.done(function( msg ) {
		    $('#myModal').modal('hide');
		});

		return false;
	});

EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
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
					'dataProvider'=>$header->searchout(),
					'filter'=>$header,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Questionnaire[news_per_page]");	
						InitialSortTable();
					}',
					'columns'=>array(
						// array(
						// 	'visible'=>Controller::DeleteAll(
						// 		array("Questionnaire.*", "Questionnaire.Delete", "Questionnaire.MultiDelete")
						// 	),
						// 	'class'=>'CCheckBoxColumn',
						// 	'id'=>'chk',
						// ),
						array(
							'name'=>'survey_name',
							'type'=>'html',
							'value'=>'CHtml::decode(UHtml::markSearch($data,"survey_name"))'
						),
						/*array(
							'header'=>'ส่งเมล',
					    	//'value'=>'CHtml::button("เลือกข้อสอบ (".$data->getCountTest("pre").")",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/FormLesson", array("id"=>$data->id,"type"=>"pre"))))',
					    	'value'=>'CHtml::link("ส่งเมล", array(
					      		"Questionnaireout/Sendmail",
					      		"id"=>$data->survey_header_id,
					      		), array(
								"class"=>"btn btn-primary btn-icon btn-sendmail"
						    )); ',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
					    ),*/
						array(
							'header'=>'link ทำแบบสอบถาม',
							'value'=>function($data){
								$url = Yii::app()->createAbsoluteUrl('questionnaire/out');
								$url = str_replace("admin/", "", $url);
//								$url = str_replace("index.php/", "index.php?r=", $url);
								$url = $url."?id=".$data->survey_header_id;
								return CHtml::textField("liketxt",$url,array("id"=>"liketxt"))." ".CHtml::button("Copy link", array(
									"class"=>"btn btn-primary btn-icon",
									"data-clipboard-text"=>$url
							    )); 
							},
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'300px'),
						),
					/*	array(
							'header'=>'รายงาน',
					    	'value'=>'CHtml::link("รายงาน", array(
					      		"Questionnaireout/report",
					      		"id"=>$data->survey_header_id,
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
					    ),*/
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Questionnaire.*", "Questionnaire.View", "Questionnaire.Update", "Questionnaire.Delete") 
							),
							'template'=>'{update} {delete}',
							'buttons' => array(
								// 'view'=> array( 
								// 	'visible'=>'Controller::PButton( array("Questionnaire.*", "Questionnaire.View") )' 
								// ),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Questionnaire.*", "Questionnaire.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Questionnaire.*", "Questionnaire.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Questionnaire.*", "Questionnaire.Delete", "Questionnaire.MultiDelete")) ) : ?>
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

<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>ส่งเมล</h3>
  </div>
  <div class="modal-body">
    <p>
    	<input type="hidden" value="" name="url" id="url">
    	<label class="span1">มหาวิทยาลัย</label>
	    <select name="university" class="span5" id="university">
	    	<option value=""> -- ทั้งหมด -- </option>
	    	<?php
	    	$university = TbUniversity::getUniversityOptions();
	    	foreach ($university as $key => $value) {
	    	?>
			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
	    	<?php
	    	}
	    	?>
	    </select>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn btn-default">ยกเลิก</a>
    <a href="#" id="sendmail" class="btn btn-primary">ส่ง</a>
  </div>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/clipboard.min.js"></script>
<script>
var clipboard = new Clipboard('.btn');

clipboard.on('success', function(e) {
    console.log(e);
});

clipboard.on('error', function(e) {
    console.log(e);
});
</script>