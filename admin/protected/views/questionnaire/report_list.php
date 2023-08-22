<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<?php
$this->breadcrumbs=array(
	'รายงานแบบแสดงความคิดเห็นผู้เข้าเรียน'
);
?>
<!-- innerLR -->
<div class="innerLR">
	<?php 
	$userModel = Users::model()->findByPk(Yii::app()->user->id);
	$state = Helpers::lib()->getStatePermission($userModel);
	if($state){
		$modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
	}else{
		$modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
	}
	?>

<?php 
Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#courseteacher-form").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("CourseTeacher[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<style type="text/css">
	 .chosen-with-drop .chosen-drop{
    z-index:1000!important;
    position:static!important;
}
</style>
<script type="text/javascript">
	$( document ).ready(function() {
		//init
		$(".chosen").chosen();
		var selectedVal = $( "#CourseTeacher_course_id option:selected" ).val();
		if(selectedVal != ''){
			$.ajax({
				type: 'POST',
				url: "<?=Yii::app()->createUrl('Questionnaire/ListSchedule');?>",
				data:{ course_id:selectedVal},
				success: function(data) {
					$('#CourseTeacher_schedule_id').empty(); 
					$('#CourseTeacher_schedule_id').append(data);
					$('.chosen').trigger("chosen:updated");
				}
			});	
		}
		
		$(".of-out").addClass("in");

		$("#CourseTeacher_course_id").change(function(){
			var course_id =  $(this).val();
			$.ajax({
				type: 'POST',
				url: "<?=Yii::app()->createUrl('Questionnaire/ListSchedule');?>",
				data:{ course_id:course_id},
				success: function(data) {
					$('#CourseTeacher_schedule_id').empty(); 
					$('#CourseTeacher_schedule_id').append(data);
					$('.chosen').trigger("chosen:updated");
				}
			});
		});
	});
</script>
<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$teacher,
		'route' => $this->route,
		'attributes'=>array(
			// array('name'=>'title','type'=>'text'),
			array(
				'type'=>'list',
				'name'=>'course_id',
				'query'=>CHtml::listData($modelCourse,'course_id', 'course_title')
			),
			array(
				'type'=>'list',
				'name'=>'schedule_id',
				'query' => ''
				// 'query'=>CHtml::listData(Schedule::model()->findAll(),'schedule_id', 'CoursetitleConcat')
			),
			// array(
			// 	'type'=>'list',
			// 	'name'=>'survey_header_id',
			// 	'query'=>CHtml::listData(QHeader::model()->findAll(),'survey_header_id', 'survey_name')
			// ),
		),
	));?>
<div class="widget" style="margin-top: -1px;">
	<div class="widget-head">
		<h4 class="heading">รายละเอียดข้อสอบที่เลือก</h4>
	</div>
	<div class="widget-body div-table" style="overflow: auto;">
		<?php if(!empty($_GET['CourseTeacher'])){ ?>
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow('CourseTeacher');?>
				</span>
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>'courseteacher-form',
					'dataProvider'=>$teacher->search(),
					 'filter'=>$teacher,
					'selectableRows' => 2,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("CourseTeacher[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'header'=>'ลำดับ',
							'value'=>'$row+1',
							'htmlOptions'=>array('style'=>'text-align: center')
						),
						array(
							'name'=>'title',
							'value'=>'$data->title'
						),
						array(
							'name'=>'course_id',
							'value'=>'$data->course->course_title',
							'filter'=>$this->listcourseOnline($teacher,'course_id'),
						),
						array(
							'name'=>'survey_header_id',
							'value'=>'$data->q_header->survey_name',
							'filter'=>$this->listQheader($teacher,'survey_header_id'),
						),
						array(
							'header'=>'แบบสอบถาม',
							//'value'=>'CHtml::button("เลือกแบบสอบถาม",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/ChooseQuestionnaire")))',
							'value'=>function($data){
								if($data->survey_header_id != ""){
									if(empty($_GET['CourseTeacher']['schedule_id']) || $_GET['CourseTeacher']['schedule_id'] == 'ทั้งหมด'){
										$params = array(
											"Questionnaire/Report_course",
											"id"=>"$data->id"
										);
									}else{
										$params = array(
											"Questionnaire/Report_course",
											"id"=>"$data->id",
											"schedule_id" => $_GET['CourseTeacher']['schedule_id']
										);
									}
									$str = " ".CHtml::link("รายงาน", $params, array(
										"target"=>"_blank",
										"class"=>"btn btn-success btn-icon"
									));
								}

								return $str;
							},
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'160px'),
						),
					),
				)); ?>
			</div>
			<?php } else { ?>
				<h4>กรุณาเลือกหลักสูตร แล้วกด ปุ่มค้นหา</h4>
			<?php } ?>
	</div>
</div>


</div>
<!-- END innerLR -->
