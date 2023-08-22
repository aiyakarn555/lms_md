<?php
/* @var $this TestController */
/* @var $model User */

$titleName = 'ระบบ Reset การเรียนและการสอบ';
$formNameModel = 'Reset';
$this->breadcrumbs=array($titleName => array('Reset/index'));

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
        $("#reset-form").append('<input type="hidden" name="'+name+'" value="">');
    }
    $.appendFilter("Reset[news_per_page]", "news_per_page");
EOD
    , CClientScript::POS_READY);


?>
    
    <?php $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'searchValue','type'=>'text'),
        ),
    ));?>
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
                    'dataProvider'=>$model->search(),
                    // 'filter'=>$model,
                    'selectableRows' => 2,
                    'rowCssClassExpression'=>'"items[]_{$data->id}"',
                    'htmlOptions' => array(
                        'style'=> "margin-top: -1px;",
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        $.appendFilter("Reset[news_per_page]");
                        InitialResetLearn();
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
                ),
              // array(
              //   'header' => 'รหัสพาสปอร์ต',
              //   'value' => function($val) {
              //     return $val->profiles->identification."";
              // },
              // ),
              array(
                'header' => 'ชือ-นามสกุล',
                'type' => 'html',
                'value' => function($val) {
                    
                    return $val->profiles->firstname.' '.$val->profiles->lastname;
                   // return $val->profiles->getFullName();
               },
               ),
              array(
                'header' => 'Reset การเรียน',
                'type' => 'raw',
                'value' => function($val) {
                    $criteria = new CDbCriteria;
                    $criteria->with = array('Lessons','Lessons.courseonlines');
                    $criteria->compare('courseonline.active','y');
                    $criteria->compare('t.user_id',$val->id);
                    $criteria->compare('t.active','y');
                    $status = Score::model()->find($criteria);
                    if(!$status){
                        $criteria=new CDbCriteria;
                        $criteria->join = " INNER JOIN `tbl_lesson` AS les ON (les.`id`=t.`lesson_id`)";
                        $criteria->compare('user_id',$val->id);
                        $criteria->compare('lesson_active','y');
                        $criteria->compare('les.active','y');
                        $criteria->addCondition('lesson_status IS NOT NULL');
                        $status = Learn::model()->find($criteria);
                    }
                    if($status){
                        $evntLearn = 'reset_learn';
                        $btnClassLearn = 'btn-danger';
                    } else {
                        $evntLearn = '';
                        $btnClassLearn = '';
                    }
                    return CHtml::button("Reset",array('class' => 'btn '.$btnClassLearn.' '.$evntLearn.'','data-id' => $val->id));
                },'htmlOptions' => array(
                    'style'=> "text-align: center;",
                    ),
                ),
              array(
                'header' => 'Reset การข้อสอบหลักสูตร',
                'type' => 'raw',
                'value' => function($val) {
                    // $examData = Coursescore::model()->find(array(
                    //     'condition' => 'user_id=:user_id AND active="y"',
                    //     'params' => array(':user_id' => $val->id)));
                    $criteria = new CDbCriteria;
                    $criteria->join = " INNER JOIN `tbl_course_online` AS course ON (course.`course_id`=t.`course_id`)";
                    $criteria->compare('user_id',$val->id);
                    $criteria->compare('course.active','y');
                    $criteria->compare('t.active','y');
                    $criteria->group = 'course.course_id';
                    $criteria->order = 't.score_id ASC';
                     $examData = Coursescore::model()->find($criteria);
                    if($examData){
                        $evntExam = 'reset_exam';
                        $btnClassExam = 'btn-danger';
                    } else {
                        $evntExam = '';
                        $btnClassExam = '';
                    }
                    return CHtml::button("Reset",array('class' => 'btn '.$evntExam.' '.$btnClassExam.'','data-id' => $val->id));
                },'htmlOptions' => array(
                    'style'=> "text-align: center;",
                    ),
                ),
              array(
                'header' => 'หมายเหตุ',
                'type' => 'raw',
                'value' => function($val) {
                  return CHtml::button("รายละเอียด",array('class' => 'btn btn-info reset_detail','data-id' => $val->id));
              },'htmlOptions' => array(
                'style'=> "text-align: center;",
                ),
              ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>

<!-- modal message -->
<div class="modal fade" tabindex="-1" role="dialog" id="selectModal1" style="left: 40%">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- end modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="selectModal" style="left: 40%">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3C8DBC;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 25px;color: #fff;">ข้อความ</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer" style="background-color: #eee;">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button id="btnSubmit" type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
      InitialResetLearn();
  });


function InitialResetLearn() {
   $('.reset_learn').on('click',function(){
    var id = this.getAttribute('data-id');
    $.ajax({
        type: 'POST',
        url: "<?=Yii::app()->createUrl('Reset/get_dialog_learn');?>",
        data:{ user_id:id },
        success: function(data) {
            $('#selectModal .modal-title').html('Reset การเรียน');
            $('#selectModal .modal-body').html(data);
            $('#btnSubmit').css('display','');
            $('#selectModal').modal('show');
        }
    })
});

   $('.reset_exam').on('click',function(){
    var id = this.getAttribute('data-id');
    $.ajax({
        type: 'POST',
        url: "<?=Yii::app()->createUrl('Reset/get_dialog_exam');?>",
        data:{ user_id:id },
        success: function(data) {
            $('.modal-title').html('Reset การสอบ');
            $('.modal-body').html(data);
            $('#btnSubmit').css('display','');
            $('#selectModal').modal('show');
        }
    })
});

   $('.reset_detail').on('click',function(){
    var id = this.getAttribute('data-id');
    $.ajax({
        type: 'POST',
        url: "<?=Yii::app()->createUrl('Reset/resetdetail');?>",
        data:{ id:id },
        success: function(data) {
            $('.modal-title').html('รายละเอียดการ Reset');
            $('.modal-body').html(data);
            $('#btnSubmit').css('display','none');
            $('#selectModal').modal('show');
        }
    })
});
}

function saveModal() {
                //sendLogAndSaveReset();
                //var id = $('input[name="user_id"]').val();
                var type = $('input[name="reset_type"]').val();
                var checkLessonList = [];
                if(type=='learn'){
                    var checkedList = $('.checkedLesson');
                } else if(type=='exam'){
                    var checkedList = $('.checkCourse');
                }
                if(checkedList != undefined) {
                    $.each(checkedList, function(i, checkbox) {
                        if(checkbox.value != null && checkbox.checked == true) {
                            checkLessonList.push(checkbox.value);
                        }
                    });
                }
                if(checkLessonList.length){
                    $('#selectModal').modal('hide');
                    
                    $.ajax({
                                    url: "<?php echo Yii::app()->createUrl("Reset/checkCourseAccept"); ?>",
                                    type: "POST",
                                    dataType: 'json',
                                    data: { checkedList:JSON.stringify(checkLessonList),reset_type:type},
                                    success:function(data){
                                        if(data.status==true){
                                            checkConfirmPass()
                                        } else {
                                            swal({
                                                title: "คุณไม่มีสิทธิ Reset",
                                                text: "เนื่องจากหลักสูตร "+data.course+" ถูกอนุมัติแล้ว กรุณาติดต่อผู้ดูแลระบบ",
                                                type: "warning",
                                                confirmButtonText: "ตกลง",
                                            });
                                        }
                                    }
                                });
                } else {
                    swal({
                        title: "ระบบ",
                        text: "กรุณาเลือกข้อมูลที่ต้องการ Reset",
                        type: "warning",
                        confirmButtonText: "ตกลง",
                    });
                }

                
            }

            function checkConfirmPass() {
                swal({
                    title: "แจ้งเตือน",
                    text: "ยืนยันการ Reset กรุณากรอก Email",
                    type: "input",
                    inputType: "password",
                    showCancelButton: true,
                    allowEnterKey: true,
                    closeOnConfirm: false,
                    confirmButtonText: "ตกลง",
                    cancelButtonText: "ยกเลิก",
                    animation: "slide-from-top",
                },
                function (inputValue) {
                    if(inputValue != false){
                        $.ajax({ 
                            type : 'POST',
                            url : "<?php echo Yii::app()->createUrl("Reset/confirmPass"); ?>",
                            data: { passInput:inputValue }
                            ,success:function(data){
                                if(data){
                                    sendLogAndSaveReset();
                                } else {
                                    swal({
                                        title: "แจ้งเตือน",
                                        text: "รหัสผ่านไม่ถูกต้อง",
                                        type: "warning",
                                        confirmButtonText: "ตกลง",
                                    });
                                }
                            }
                        });
                    }
                }
                );
            }

            function sendLogAndSaveReset() {
                swal({
                    title: "รายละเอียด",
                    text: "กรุณากรอกข้อมูลอธิบายรายละเอียดการ Reset",
                    type: "input",
                    showCancelButton: true,
                    allowEnterKey: true,
                    closeOnConfirm: false,
                    confirmButtonText: "ตกลง",
                    cancelButtonText: "ยกเลิก",
                    animation: "slide-from-top",
                },

                function (inputValue) {
                    if(inputValue != false){
                    swal({
                        title: "โปรดรอสักครู่",
                        text: "ระบบกำลังส่งอีเมล",
                        type: "info",
                        showConfirmButton: false
                    });
                    var id = $('input[name="user_id"]').val();
                    var type = $('input[name="reset_type"]').val();
                    var checkLessonList = [];
                    var url = '';
                    if(type=='learn'){
                        var checkedList = $('.checkedLesson');
                        url = "<?= $this->createUrl('Reset/saveresetlearn') ?>";
                    } else if(type=='exam'){
                        var checkedList = $('.checkCourse');
                        url = "<?= $this->createUrl('Reset/saveresetexam') ?>";
                    }
                    if(checkedList != undefined) {
                        $.each(checkedList, function(i, checkbox) {
                            if(checkbox.value != null && checkbox.checked == true) {
                                checkLessonList.push(checkbox.value);
                            }
                        });
                    }

                    console.log(checkLessonList);

                    if(checkLessonList!=null) {
                        $('#selectModal').modal('hide');
                        $.ajax({ 
                            type : 'POST',
                            url : url,
                            data: { checkedList:JSON.stringify(checkLessonList), id:id,reset_type:type,description:inputValue }
                            ,success:function(data){
                                if(data=='learn'){
                                    swal({
                                        title: "ระบบ",
                                        text: "Reset การเรียนทั้งหมด เรียบร้อยแล้ว",
                                        type: "success",
                                        confirmButtonText: "ตกลง",
                                    });
                                    location.reload();
                                } else if(data=='exam'){
                                     swal({
                                        title: "ระบบ",
                                        text: "Reset ผลสอบทั้งหมด เรียบร้อยแล้ว",
                                        type: "success",
                                        confirmButtonText: "ตกลง",
                                    });
                                    location.reload();
                                }
                            }
                        });
                    }
                }
                }
                )
                ;
            }

        </script>