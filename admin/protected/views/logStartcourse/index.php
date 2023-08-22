<?php
$formNameModel = 'LogStartcourse';
$titleName = 'การส่งอีเมล์แจ้งผู้เรียน';

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
	$.appendFilter("LogStartcourse[news_per_page]", "news_per_page");
EOD
    , CClientScript::POS_READY);
?>
    <!-- <div class="separator bottom form-inline small">
    <span class="pull-right">
        <label class="strong">แสดงแถว:</label>
        <?php echo $this->listPageShow($formNameModel);?>
    </span>
    </div> -->
<script type="text/javascript">
 $(document).ready(function(){
    $("#LogStartcourse_type_employee").change(function(){
            var employee_id = $("#LogStartcourse_type_employee option:selected").val();

            if(employee_id != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/LogStartcourse/ListTypeEmployee"); ?>',
                    data: ({
                        employee_id: employee_id,
                    }),
                    success: function(data) {
                        console.log(data);
                        if(data != ""){
                            $("#LogStartcourse_department_id").html(data);
                        }
                    }
                });
            }
        }); 
    $("#LogStartcourse_department_id").change(function(){
            var department_id = $("#LogStartcourse_department_id option:selected").val();

            if(department_id != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/LogStartcourse/ListDepartment"); ?>',
                    data: ({
                        department_id: department_id,
                    }),
                    success: function(data) {
    
                        if(data != ""){
                            $("#LogStartcourse_position_id").html(data);
                        }
                    }
                });
            }
        });
});
</script>
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
                        $.appendFilter("LogStartcourse[news_per_page]");
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
        //                 array(
        //     'header' => 'ลำดับ',
        //     // 'name' => 'cert_id',
        //     'sortable' => false,
        //     'htmlOptions' => array(
        //         'width' => '40px',
        //         'text-align' => 'center',
        //     ),
        //     'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        // ),
        array(
        // 'visible'=>Controller::DeleteAll(
        //         array("LogStartcourse.*", "LogStartcourse.sendMailMessage", "LogStartcourse.MultiSendMailMessages")
        //         ),
        'class'=>'CCheckBoxColumn',
        //'htmlOptions'=>array('style'=>'text-align: center; width:3%'),
        'id'=>'chk',
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
        array(
            'header' => 'รุ่น',
            'name'=>'gen_id',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                if ($data->gen->gen_title == null || $data->gen->gen_title == "") {
                    return "-";
                }else{
                    return $data->gen->gen_title;
                }
            }
        ),
        array(
            'header' => 'แผนก',
            'name'=>'department_id',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->mem->department->dep_title;
            }
        ),
        array(
            'header' => 'ตำแหน่ง',
            'name'=>'position_id',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->mem->position->position_title;
                //return $data->mem->profile->firstname;
            }
        ),
        // array(
        //     'header' => 'รหัสบัตรประชาชน - พาสปอร์ต',
        //     'name'=>'search_name',
        //     'type'=>'raw',
        //     'value'=>function($data){
        //         if ($data->mem->profile->identification  != null) {
        //           return $data->mem->profile->identification;
        //         }else{
        //           return $data->mem->profile->passport;
        //         }
        //     }
        // ),
        array(
            'header' => 'ชื่อ - นามสกุล',
            'name'=>'search_name',
            'type'=>'raw',
            'value'=>function($data){
                return $data->mem->profile->firstname_en . ' ' . $data->mem->profile->lastname_en;
            }
        ),
        
        array(
                'header'=>'ส่งเมลล์',
                'type' => 'raw',
                'visible' => Controller::PButton( array("LogStartcourse.*", "LogStartcourse.sendMailMessage") ),
                'htmlOptions'=>array('style'=>'text-align: center; width:20%'),
                'value' => function($data) {
                    return  CHtml::button("ส่งเมลล์",array('onclick'=>'sendMsg('.$data->id.')','class' => 'btn btn-danger','style'=>'font-size: 15px;'));
              },  
              ),
                    ),
                )); ?>
            </div>
        </div>
        <?php //if( Controller::DeleteAll(array("LogStartcourse.*", "LogStartcourse.sendMailMessage", "LogStartcourse.MultiSendMailMessages")) ) : ?>
        <!-- Options -->
        <div class="separator top form-inline small">
            <!-- With selected actions -->
            <div class="buttons pull-left">
                <?php echo CHtml::link("<i></i> ส่งเมลล์ทั้งหมด","#",array(
                    "class"=>"btn btn-primary btn-icon glyphicons circle_minus",
                    "onclick"=>"return MultiSendMailMessage('".$this->createUrl('//'.$formNameModel.'/MultiSendMailMessages')."','$formNameModel-grid');"
                )); ?>
            </div>
            <!-- // With selected actions END -->
            <div class="clearfix"></div>
        </div>
        <!-- // Options END -->
<?php //endif; ?>
    </div>

</div>

<script type="text/javascript">

    function MultiSendMailMessage(url, form) {
    var items = $.fn.yiiGridView.getSelection('' + form + '');
    if (items.length <= 0) {
        swal("กรุณาเลือกรายชื่อที่จะส่งเมลล์");
        return false;
    }
    bootbox.confirm('ยืนยันการส่งเมลล์ข้อมูลหรือไม่ ?', function (result) {
        if (!result) return false;
        jQuery('#' + form + '').yiiGridView('update', {
            type: 'post',
            url: url,
            data: {
                chk: items
            },
            success: function (data) {
                notyfy({
                    dismissQueue: false,
                    text: "ลบส่งเมลล์เรียบร้อย",
                    type: 'success'
                });
                jQuery('#' + form + '').yiiGridView('update');
            },
            error: function (XHR) {
                alert('เกินข้อผิดพลาดกรุณาทำข้อมูลไหม');
            }
        });
    });
    return false;
}

     function sendMsg(id){
      swal({
        title: "ต้องการแจ้งเตือนผู้เรียนหรือไม่",
        text: "เลือก",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "ใช่",
        cancelButtonText: "ไม่",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true
              },
              function(isConfirm){
                if (isConfirm) {
                   $.ajax({
                    type: "POST",
                    url: '<?php echo $this->createUrl('LogStartcourse/sendMailMessage'); ?>',
                    data: {
                        id: id
                    },
                    success: function (data) {
                        
                    if (data) {
                      swal({
                        type: "success",
                        title: "ระบบ",
                        text: "ทำรายการสำเร็จ",
                        timer: 500,
                         },
                    function() {
                      setTimeout(function(){
                        location.reload();
                      },500);
                    }
                    );
                    }else{
                        swal({
                        type: "error",
                        title: "ระบบ",
                        text: "ทำรายการตอบปัญหาไม่สำเร็จ",
                        timer: 500,
                         },
                             function() {
                      setTimeout(function(){
                        location.reload();
                      },500);
                    }
                    );
                    }
                    },
                  });
                 }
               });
    }
    // $("#LogEmail_type_employee").change(function() {
    //                 var id = $(this).val();
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: "<?= Yii::app()->createUrl('LogEmail/ListDepartment'); ?>",
    //                     data: {
    //                         id: id
    //                     },
    //                     success: function(data) {

    //                         $('#LogEmail_department_id').empty();
    //                         $('#LogEmail_department_id').append(data);
    //                     }
    //                 });
    //             });
    // $("#LogEmail_department_id").change(function() {
    //                 var id = $(this).val();
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: "<?= Yii::app()->createUrl('LogEmail/ListPosition'); ?>",
    //                     data: {
    //                         id: id
    //                     },
    //                     success: function(data) {

    //                         $('#LogEmail_position_id').empty();
    //                         $('#LogEmail_position_id').append(data);
    //                     }
    //                 });
    //             });
</script>