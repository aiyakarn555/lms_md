
<?php
$titleName = 'พิมพ์ใบสมัครสำหรับคนประจำเรือ';
$formNameModel = 'PrintMembership';

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
	$.appendFilter("PrintMembership[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

	<div id="user" class="innerLR">
		

		<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
				array('name'=>'position_id','type'=>'list','query'=>Position::getPositionListSearch()),
				array('name'=>'nameSearch','type'=>'text'),
		),
	));?>

<style type="text/css">
.coolContainer h4:first-of-type {
    float: left;
}
.coolContainer h4:last-of-type {
    float: left;
}

</style>

		<div class="widget" style="margin-top: -1px;">
			<div class="widget-head">
				<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php //echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Confirm Registration"); ?>พิมพ์ใบสมัครสำหรับคนประจำเรือ</h4>
			</div>
			<div class="widget-body">
				<div>
					<?php //echo Rights::t('core', 'ที่นี่คุณสามารถอนุมัติการสมัครสมาชิกให้กับผู้ใช้แต่ละราย'); ?>
				</div>
				<!-- <div class="coolContainer">
					<h4 class="name_pos"></h4><h4 class="num"> จำนวนผู้สมัคร <?= $model->searchmembership()->getItemCount(); ?> คน  จาก <?= $model->searchmembership()->getTotalItemCount(); ?> คน</h4>	
				</div> -->
				<div class="separator bottom form-inline small">
					<span class="pull-right">
						<label class="strong">แสดงแถว:</label>
						<?php echo $this->listPageShow($formNameModel);
						?>
					</span>
				</div>
				<div class="clear-div"></div>
				<div class="spacer"></div>
				<div>

					<!--  < ?php echo CHtml::link(UserModule::t('ค้นหาขั้นสูง'),'#',array('class'=>'search-button')); ?>
					<div class="search-form" style="display:none">
						< ?php $this->renderPartial('_search',array(
							'model'=>$model,
							)); ?>
						</div> --><!-- search-form -->					  
					<?php
					$this->widget('AGridView', array(
						'id'=>$formNameModel.'-grid',
						'dataProvider'=>$model->searchmembership(),
						'filter'=>$model,
						'selectableRows' => 2,
						'rowCssClassExpression'=>'"items[]_{$data->id}"',
						'htmlOptions' => array(
							'style'=> "margin-top: -1px;",
						),
						'afterAjaxUpdate'=>'function(id, data){
							$.appendFilter("PrintMembership[news_per_page]");
							InitialSortTable();	
						}',
					
							'columns'=>array(
								array(
									'header'=>'No.',
									'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
								),
								array(
									'name' => 'nameSearch',
									// 'header' => 'ชื่อ - นามสกุล',
									'type'=>'html',
									'value'=>function($data){
										return $data->profile->firstname_en . ' ' . $data->profile->lastname_en;
									}
								),
								array(
									// 'header' => 'ตำแหน่งที่สมัคร',
									'name' => 'position_id',
									'filter'=>Position::getPositionListSearch($model,'position_id'),
									'type'=>'html',
									'value'=>function($data){
										return $data->position->position_title;
									}
								),
								array(
									'header' => 'วันที่ลงทะเบียน',
									'type'=>'html',
									//'filter' => false,
									'value'=>function($data){
										return Helpers::changeFormatDate($data->create_at,'datetime');
									},
								),
								array(
									'header' => 'พิมพ์ใบสมัคร',
									'type' => 'raw',
									'value' => function($data) {
                                               //var_dump($data->id);
                                                //return CHtml::button("พิมพ์",array('class' => 'btn btn btn-success print_pdf','data-id' => $data->id));
										// return CHtml::button('พิมพ์ใบสมัคร', array('submit' => array('PrintMembership/Printpdf', 'id'=> $data->id),'class' => 'btn btn btn-success'));
										return CHtml::link("พิมพ์ใบสมัคร",array("/PrintMembership/Printpdf","id"=>$data->id), array("class"=>"btn btn-success"));
									},'htmlOptions' => array(
										'style'=> "text-align: center;",
									),
								),
						
								// array(
								// 	'class'=>'AButtonColumn',
								// 	'visible'=>Controller::PButton(
								// 		array("Admin.*", "Admin.View", "Admin.Update", "Admin.Delete")
								// 	),
								// 	'buttons' => array(
								// 		'view'=> array(
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.View") )'
								// 		),
								// 		// 'update'=> array(
								// 		// 	'visible'=>'false'
								// 		// ),
								// 		'update'=> array( 
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.Update") )' 
								// 		),
								// 		'delete'=> array(
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.Delete") )'
								// 		),
								// 	),
								// ),
							),
));

?>
<!-- modal message -->
<div class="modal fade" tabindex="-1" role="dialog" id="selectModal1">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">

		</div>
	</div>
</div>
<!-- end modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="selectModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #3C8DBC;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;font-size: 22px;">&times;</span></button>
				<h4 class="modal-title" style="font-size: 20px;color: #fff;padding: .3em;">ข้อความ</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer" style="background-color: #eee;">
				<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
				<button id="btnSubmit" type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
			</div>
		</div>
	</div>
</div>
						<script>

           // $(document).ready(function() {      
           // var e = document.getElementById("User_position_id");
           // var strUser = e.options[e.selectedIndex].text;
           // if (strUser === "ทั้งหมด") {
           //  $('.name_pos').hide();
           // }else{
           //      var format =  "ตำแหน่ง"+" "+strUser;
           //   $('.name_pos').text(format);
           // }
           //     var tex = $('.empty').text();
           //  if (tex) {
           //  	$('.name_pos').hide();
           //  	$('.num').text("จำนวนผู้สมัคร 0 คน จาก 0 คน")
           //  }else{
           //  	$('.num').show()            
           //  }
           // 	});

						</script>
					</div>

				</div><!-- form -->
			</div>
		</div>
	</div>
	<!-- END innerLR -->


