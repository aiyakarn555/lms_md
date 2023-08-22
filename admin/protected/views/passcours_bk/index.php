<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/chosen.min.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>

<?php
$titleName = 'รายงานผู้ผ่านการเรียน';
$formNameModel = 'Passcours';

$this->breadcrumbs=array($titleName);
// Yii::app()->clientScript->registerScript('search', "
// 	$('#SearchFormAjax').submit(function(){
// 	    $.fn.yiiGridView.update('$formNameModel-grid', {
// 	        data: $(this).serialize()
// 	    });
// 	    return false;
// 	});
// ");

$passcours_cours = $passcours['passcours_cours'];
$gen_id = $passcours['gen_id'];
$search = $passcours['search'];
$type_register = $passcours['type_register'];
$department = $passcours['department'];
$position = $passcours['position'];
$period_start = $passcours['period_start'];
$period_end = $passcours['period_end'];

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);

	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});

	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');


	    $("#$formNameModel-grid").append('<input type="hidden" name="Passcours[passcours_cours]" value="$passcours_cours">');
	    $("#$formNameModel-grid").append('<input type="hidden" name="Passcours[gen_id]" value="$gen_id">');
	    $("#$formNameModel-grid").append('<input type="hidden" name="Passcours[search]" value="$search">');
	    $("#$formNameModel-grid").append('<input type="hidden" name="Passcours[type_register]" value="$type_register">');
	    $("#$formNameModel-grid").append('<input type="hidden" name="Passcours[department]" value="$department">');
	    $("#$formNameModel-grid").append('<input type="hidden" name="Passcours[position]" value="$position">');
	    $("#$formNameModel-grid").append('<input type="hidden" name="Passcours[period_start]" value="$period_start">');
	    $("#$formNameModel-grid").append('<input type="hidden" name="Passcours[period_end]" value="$period_end">');
	}
	$.appendFilter("Passcours[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<script>
    $(document).ready(function(){
    	$(".form").css("height", "500px"); // select มันโดนกลืนอะ เลยต้องขยายช่อง


        $(".toggleairasia-table td button").click(function(){
            $(this).closest("tbody").next().toggle();
        });

        $(".chosen").chosen();

        $("#Passcours_period_start").datepicker({
            onSelect: function(selected) {
              $("#Passcours_period_end").datepicker("option","minDate", selected)
            }
        });
        $("#Passcours_period_end").datepicker({
            onSelect: function(selected) {
               $("#Passcours_period_start").datepicker("option","maxDate", selected)
            }
        }); 

        $("#Passcours_type_register").change(function(){
            var value = $("#Passcours_type_register option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetdepartment"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Passcours_department").html(data);
                            $("#Passcours_position").html('<option value="">ทั้งหมด</option>');
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });
        $("#Passcours_department").change(function(){
            var value = $("#Passcours_department option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetposition"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Passcours_position").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });

        $("#Passcours_passcours_cours").change(function(){
            var value = $("#Passcours_passcours_cours option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetgenid"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Passcours_gen_id").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });


});
</script>



<div class="innerLR">
	<div class="widget">
	<?php 
	$userModel = Users::model()->findByPk(Yii::app()->user->id);
	$state = Helpers::lib()->getStatePermission($userModel);

	if(!$state){
		$CourseOnline = CourseOnline::model()->findAll(array(
			'condition' => 'active = "y" and lang_id = 1 and create_by = "'.Yii::app()->user->id.'"',
			'order' => 'course_title ASC'
    )); //LMS Only
	}else{
		$CourseOnline = CourseOnline::model()->findAll(array(
			'condition' => 'active = "y" and lang_id = 1',
			'order' => 'course_title ASC'
    )); //admin
	}	
    $listCourse = CHtml::listData($CourseOnline,'course_id','course_title');


    $TypeEmployee = TypeEmployee::model()->findAll(array(
    	'condition' => 'active = "y"',
    	'order' => 'type_employee_name ASC'
    ));
    $listtype_user = CHtml::listData($TypeEmployee,'id','type_employee_name');



    $department = Department::model()->findAll(array(
    	'condition' => 'active = "y"',
    	'order' => 'dep_title ASC'
    ));
    $listdepartment = CHtml::listData($department,'id','dep_title');


    $position = Position::model()->findAll(array(
    	'condition' => 'active = "y"',
    	'order' => 'position_title ASC'
    ));
    $listposition = CHtml::listData($position,'id','position_title');


    if($passcours_cours != ""){
    	$arr_gen = CourseGeneration::model()->findAll(array(
    		'condition' => 'course_id=:course_id AND active=:active ',
    		'params' => array(':course_id'=>$passcours_cours, ':active'=>"y"),
    		'order' => 'gen_title ASC',
    	));    	

    	if(empty($arr_gen)){
    		$arr_gen[0] = "ไม่มีรุ่น";
    	}else{
    		$arr_gen = CHtml::listData($arr_gen,'gen_id','gen_title');
    	}

    }else{
    	$arr_gen[""] = "กรุณาเลือกหลักสูตร";
    }
    


	$this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'passcours_cours','type'=>'list','query'=>$listCourse),	
			array('name'=>'gen_id','type'=>'list','query'=>$arr_gen),	
			array('name'=>'search','type'=>'text'),		
			array('name'=>'type_register','type'=>'list','query'=>$listtype_user),
			array('name'=>'department','type'=>'list','query'=>$listdepartment),
			array('name'=>'position','type'=>'list','query'=>$listposition),			
			array('name'=>'period_start','type'=>'text'),
			array('name'=>'period_end','type'=>'text'),
	),

	));
			?>
	</div>
<!-- search-form -->



	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<?php if(!empty($_GET) && $passcours_cours != null && $gen_id != null){ ?>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php
				$this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->passcourscheck()->highsearch(),
					'filter'=>false,
					// 'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Passcours[news_per_page]");	
						InitialSortTable();
						$("#passcours_date").datepicker({
						   	"dateFormat": "dd/mm/yy",
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
							'visible'=>Controller::PButton(array($formNameModel.".MultiDelete")),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header' => 'ลำดับ',
							'sortable' => false,
							'htmlOptions' => array(
								'width' => '40px',
								'text-align' => 'center',
							),
							'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
						),
						array(
							'header' => 'ประเภทพนักงาน',
							'filter'=>false,
							'type' => 'raw',
							'value' => function($data) {
								return $data->profile->typeEmployee->type_employee_name;
							},
						),
						array(
							'header' => 'Name – Surname',
							'filter'=>false,
							'type' => 'raw',
							'value' => function($data) {
								return $data->Profiles->firstname_en." ".$data->Profiles->lastname_en;
							},
						),
						array(
							'header' => 'ชื่อ - นามสกุล',
							'filter'=>false,
							// 'name'=>'passcours_user',
							// 'filter'=>CHtml::activeTextField($model,'user_name'),
							'type' => 'raw',
							'value'=>'$data->NameUser',
						    'htmlOptions' => array(
						    	'width'=>'120',
						  	),
						),
						array(
							'header' => 'รหัสบัตรประชาชน',
							'filter'=>false,
							'type' => 'raw',
							'value' => function($data) {
								return $data->user->identification;
							},
						),
						array(
							'header' => 'Passport No.',
							'filter'=>false,
							'type' => 'raw',
							'value' => function($data) {
								return $data->Profiles->passport;
							},
						),
						array(
							'header' => 'Employee no.',
							'filter'=>false,
							'type' => 'raw',
							'value' => function($data) {
								if($data->profile->type_employee == 2){
									return $data->user->username;
								}
								
							},
						),
						array(
							'header'=>'แผนก',
							'filter'=>false,
							'type' => 'raw',
							'value'=>'$data->user->department->dep_title',
							'htmlOptions' => array(
								'width' => '100',
							),
						),
						array(
							'header'=>'ตำแหน่ง',
							'filter'=>false,
							'type' => 'raw',
							'value'=>'$data->user->position->position_title',
							'htmlOptions' => array(
								'width' => '100',
							),
						),
						array(
							'header'=>'หลักสูตร',
							'filter'=>false,
							// 'name'=>'passcours_cours',
							// 'filter'=>CHtml::activeTextField($model,'cours_name'),
							'type' => 'raw',
							'value' => function($data) {
								$text_gen = "";
								if($data->gen_id != 0){
									$text_gen = " รุ่น ".$data->gen->gen_title;
								}


								return $data->CourseOnlines->course_title;
							},
							// 'value'=>'$data->CourseOnlines->course_title',
						),
						array(
							'header'=>'รุ่น',
							'filter'=>false,
							// 'name'=>'gen_id',
							'type' => 'raw',
							'value' => function($data) {
								$text_gen = "";
								if($data->gen_id != 0){
									$text_gen = "รุ่น ".$data->gen->gen_title;
								}


								return $text_gen;
							},
						),
						array(
							'header'=>'วันที่สอบผ่าน',
							'filter'=>false,
							// 'name'=>'passcours_date',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data->passcours_date, 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						//     'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						//     	'model'=>$model,
						//         'attribute'=>'passcours_date',
						//         'htmlOptions' => array(
						//         	'id' => 'passcours_date',
						//         ),  
						//         'options' => array(
						//         	'mode'=>'focus',
						//         	'dateFormat'=>'dd/mm/yy',
						//             'showOn' => 'focus', 
						//             'showOtherMonths' => true,
						//             'selectOtherMonths' => true,
						//             'yearRange' => '-5+10', 
						//             'changeMonth' => true,
						//             'changeYear' => true,
						//             'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
						//            	'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
						//            		'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
						// )), true)
						),
						array(
							'header'=>'พิมพ์ใบผ่านการอบรม',
							'name'=>'list_print',
							'filter'=>false,
							'type'=>'raw',
							// 'value'=>'$data->PrintCertificate',
							'value'=>function($data){
								$certIdModel = CertificateNameRelations::model()->find(array('condition' => 'course_id = '.$data->passcours_cours));
								if(empty($certIdModel)){
									return 'ไม่มีใบประกาศนียบัตร';
								}else{
									return $data->PrintCertificate;
								}
								
							},
						),
						array(
							'header'=>'บันทึกใบผ่านการประกาศนียบัตร',
							'name'=>'list_print',
							'filter'=>false,
							'type'=>'raw',
							// 'value'=>'$data->SaveFile',
							'value'=>function($data){
								$certIdModel = CertificateNameRelations::model()->find(array('condition' => 'course_id = '.$data->passcours_cours));
								if(empty($certIdModel)){
									return 'ไม่มีใบประกาศนียบัตร';
								}else{
									return $data->SaveFile;
								}
								
							},
						),
					),
				)); ?>
			</div>
		</div>


		<div class="row" style="margin-bottom: 20px;">
			<div class="col-md-12">
				<?php 
				$certIdModel = CertificateNameRelations::model()->find(array('condition' => 'course_id = '.$_GET['Passcours']['passcours_cours']));
					if($certIdModel){
				 ?>
				<button class="btn btn-warning" onclick="get_chkbox();">ดาวโหลดทั้งหมด</button>
				<?php } ?>
				<a target="blank_" href="<?= $this->createUrl('Passcours/ExcelIndex', array(

				'Passcours[passcours_cours]' => $passcours['passcours_cours'],
				'Passcours[gen_id]' 		 => $passcours['gen_id'],
				'Passcours[search]' 		 => $passcours['search'],
				'Passcours[type_register]'	 => $passcours['type_register'],
				'Passcours[department]'		 => $passcours['department'],
				'Passcours[position]'		 => $passcours['position'],
				'Passcours[period_start]'	 => $passcours['period_start'],
				'Passcours[period_end]'		 => $passcours['period_end'],

				)); ?>" class="btn btn-success">Export Excel</a>
			</div>
		</div>



		<?php } else { ?>
		    <div class="widget-body div-table" style="overflow: auto;">
		    	<h4>กรุณาเลือกหลักสูตร หรือข้อมูลที่ต้องการ แล้วกด ปุ่มค้นหา</h4>
		    </div>
    	<?php } ?>
	</div>
</div>


<script type="text/javascript">

	var arr_chkbox = [];

	function get_chkbox(){
		arr_chkbox = [];
		$('input[name ="chk[]"]').each(function( index ) {
			if($(this).prop("checked") == true){
				arr_chkbox.push($(this).val());
			}
		});

		if(arr_chkbox.length <= 0){
			alert("กรุณาเลือกรายการก่อน");
		}else{
			download_cer();
		}

		// console.log(arr_chkbox);
	}

	function download_cer(){
		var url = "<?= $this->createUrl('Passcours/DownloadIndex'); ?>";
		url += "?val="+arr_chkbox.join();;
		var win = window.open(url, '_blank');
  		win.focus();
	}

</script>