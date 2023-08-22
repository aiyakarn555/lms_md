<?php
$formNameModel = 'LogAdmin';
$titleName = 'Log การส่งอีเมล์';

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
	$.appendFilter("LogAdmin[news_per_page]", "news_per_page");
EOD
    , CClientScript::POS_READY);
?>
    <!-- <div class="separator bottom form-inline small">
    <span class="pull-right">
        <label class="strong">แสดงแถว:</label>
        <?php echo $this->listPageShow($formNameModel);?>
    </span>
    </div> -->
    <div class="innerLR">
            <?php $this->widget('AdvanceSearchForm', array(
            'data'=>$model,
            'route' => $this->route,
            'attributes'=>array(
            
                array('name'=>'type_employee','type'=>'list','query'=>TypeEmployee::getTypeEmployeeListNew()),
                array('name'=>'department_id','type'=>'list','query'=>Department::getDepartmentList()),
                array('name'=>'position_id','type'=>'list','query'=>Position::getPositionList()),
                array('name'=>'search_name','type'=>'text'),
                array('name'=>'course_id','type'=>'list','query'=>ReportProblem::getCourseOnlineListNew()),
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
                    //'filter'=>$model,
                    'selectableRows' => 2,
                    'rowCssClassExpression'=>'"items[]_{$data->id}"',
                    'htmlOptions' => array(
                        'style'=> "margin-top: -1px;",
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        $.appendFilter("CourseOnline[news_per_page]");
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
            'header' => 'ลำดับ',
            // 'name' => 'cert_id',
            'sortable' => false,
            'htmlOptions' => array(
                'width' => '40px',
                'text-align' => 'center',
            ),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        array(
            'header' => 'ประเภทพนักงาน',
            'name'=>'type_employee',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->user->profile->typeEmployee->type_employee_name;
            }
        ),
        array(
            'header' => 'แผนก',
            'name'=>'department_id',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->user->department->dep_title;
            }
        ),
        array(
            'header' => 'ตำแหน่ง',
            'name'=>'position_id',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->user->position->position_title;
            }
        ),
        array(
            'header' => 'รหัสบัตรประชาชน - พาสปอร์ต',
            'name'=>'search_name',
            'type'=>'raw',
            'value'=>function($data){
                if ($data->user->profile->identification  != null) {
                  return $data->user->profile->identification;
                }else{
                  return $data->user->profile->passport;
                }
            }
        ),
        array(
            'header' => 'ชื่อ - นามสกุล',
            'name'=>'search_name',
            'type'=>'raw',
            'value'=>function($data){
                return $data->user->profile->firstname . ' ' . $data->user->profile->lastname;
            }
        ),
        array(
            'header' => 'หลักสูตร',
            'name'=>'course_id',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->course->course_title;
            }
        ),
       /* array(
            'header' => 'รายละเอียด',
            'name'=>'action',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->message;
            }
        ),*/
        array(
            'header' => 'วันและเวลาที่ดำเนินการส่งอีเมล์',
            'name'=>'create_date',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->create_date;
            }
        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#LogEmail_type_employee").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('LogEmail/ListDepartment'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {

                            $('#LogEmail_department_id').empty();
                            $('#LogEmail_department_id').append(data);
                        }
                    });
                });
    $("#LogEmail_department_id").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('LogEmail/ListPosition'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {

                            $('#LogEmail_position_id').empty();
                            $('#LogEmail_position_id').append(data);
                        }
                    });
                });
</script>