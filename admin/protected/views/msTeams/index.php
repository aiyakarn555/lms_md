
<?php
$titleName = 'ห้องเรียนรู้ทางไกล';
$formNameModel = 'MsTeams';

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
$.appendFilter("MsTeams[news_per_page]", "news_per_page");
EOD
	, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array(
				'name'=>'name_ms_teams',
				'type'=>'text'
			),
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
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'selectableRows' => 2,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("MsTeams[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("MsTeams.*", "MsTeams.Delete", "MsTeams.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',

							'value'=> 'Controller::ImageShowIndex($data,$data->ms_teams_picture)',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'name'=>'name_ms_teams',
							'type'=>'html',
							'filter'=>CHtml::activeTextField($model,'name_ms_teams'),
							'value'=>'$data->name_ms_teams'
						),
						array(
							'header'=>'เช็คชื่อ',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'value'=>function($data){
								return CHtml::link("ส่งแจ้งเตือน App","javascript:void(0)",array('class'=>'btn btn-danger','onclick'=>'SendNotiByTeacher('.$data->id.','.Yii::app()->user->getId().','.sprintf('"%s"', $data->url_join_meeting).'); return false;'));	
                        	},
						),
						array(
							'header'=>'จัดการรูปภาพ',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'value'=>function($data){
								return CHtml::link("อัพโหลดรูปภาพ",array("/MsTeams/uploadzoom","id"=>"$data->id"), array("class"=>"btn btn-danger"));	
                            // if($data->url_join_meeting != null){
                            //  return '<a target="_blank" type="button" class="btn btn-danger" href="'.$data->url_join_meeting.'" >Join Meeting</a>';
                            // } 
                            
                        	},
						),
						array(
							'header'=>'สถานะห้องเรียน',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'value'=>function($data){
								if($data->status_ms_teams == 1){
									return '<input  id="toggle-event" type="checkbox" checked data-toggle="toggle" data-onstyle="success" value="'.$data->id.'">';
								}else{
									return '<input  id="toggle-event" type="checkbox" data-toggle="toggle" data-onstyle="success" value="'.$data->id.'">';
								} 
                        	},
						),

						// '$data->url_join_meeting'
						array(
							'header'=>'Link ห้องเรียนออนไลน์',
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'value'=>function($data){
                            if($data->url_join_meeting != null){
                             return '<a target="_blank" type="button" class="btn btn-danger" href="'.$data->url_join_meeting.'" >Join Meeting</a>';
                            } 
                            
                        },
						),


						array(
							'header'=>'วันเวลาที่เริ่มเข้าเรียน',
							'type'=>'raw',
							'value'=>'ClassFunction::datethaiTime($data->start_date)'
						),
						array(
							'header'=>'วันเวลาที่สิ้นสุดเข้าเรียน',
							'type'=>'raw',
							'value'=>'ClassFunction::datethaiTime($data->end_date)'
						),
						
						array(
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton(
								array("MsTeams.*", "MsTeams.Update", "MsTeams.Delete")
							),
							'buttons' => array(
								// 'view'=> array(
								// 	'visible'=>'Controller::PButton( array("MsTeams.*", "MsTeams.View") )'
								// ),
								'update'=> array(
									'visible'=>'Controller::PButton( array("MsTeams.*", "MsTeams.Update") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("MsTeams.*", "MsTeams.Delete") )'
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("MsTeams.*", "MsTeams.Delete", "MsTeams.MultiDelete")) ) : ?>
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



<script>
    $('[id^="toggle-event"]').change(function(e) {
		// console.log($(this).is(':checked'));
		let toggle = $(this);
		var id = this.value;
		swal({
			title: "คุณต้องการเปลี่ยนสถานะห้องเรียนใช่หรือไม่",
			text: "เลือก",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "ใช่",
			cancelButtonText: "ไม่",
			closeOnConfirm: true,
			closeOnCancel: true,
		}, function (isConfirm) {
			if(isConfirm) {
				$.ajax({
					url: "<?= $this->createUrl('MsTeams/StatusMsteam'); ?>", 
					type: "POST",
					data:  {id:id},
					success: function(data){
						swal("สำเร็จ", "", "success");
						$("#SearchFormAjax").yiiActiveForm('resetForm');
					}
				});
			}else{
				if (toggle.is(':checked')) {
					toggle.prop('checked', false).change();
				}else{
					toggle.prop('checked', true).change();
				}
			}
		});
    });

	function SendNotiByTeacher(course_id,user_id,zoom_url){
		swal({
			title: "คุณต้องการส่งแจ้งเตือนเช็คชื่อใช่หรือไม่",
			text: "เลือก",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "ใช่",
			cancelButtonText: "ไม่",
			closeOnConfirm: true,
			closeOnCancel: true,
		}, function (isConfirm) {
			if(isConfirm) {
				$.ajax({
					url: "<?= $this->createUrl('MsTeams/SendNotiByTeacher'); ?>", 
					type: "POST",
					data:  {course_id:course_id, zoom_url:zoom_url},
					success: function(data){
						swal("สำเร็จ", "", "success");
						$("#SearchFormAjax").yiiActiveForm('resetForm');
					}
				});
			}
		});
	}

</script>