<?php

$titleName = 'ระบบ Reset การเรียนและการสอบ';
$this->breadcrumbs=array('ระบบ Reset การเรียนและการสอบ'=>array('LearnReset/ResetUser'),
);


Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
        });
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('user-grid', {
                data: $(this).serialize()
                });
                return false;
                });
                ");

                ?>

                <div id="user" class="innerLR">

                    <?php $this->widget('AdvanceSearchForm', array(
                        'data'=>$model,
                        'route' => $this->route,
                        'attributes'=>array(
                            array('name'=>'searchname','type'=>'text'),
                        ),
                    ));?>

                    <div class="widget" style="margin-top: -1px;">
                        <div class="widget-head">
                            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> ระบบ Reset การเรียนและการสอบ</h4>
                        </div>

                        <div class="widget-body">
                            <div>

                                <h3 style="color: red;">
                                    * เมื่อทำการ <b><u>Reset การสอบวัดผล ก่อนเรียน</u></b> จะทำการ Reset ทุกอย่างเหมือนเรียนหลักสูตรใหม่ *
                                </h3>



                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id'=>'user-grid',
                                    'dataProvider'=>$model->searchReset(),
                                    'afterAjaxUpdate'=>'function(id, data){
                                        InitialResetLearn();
                                    }',
                                    'filter'=>$model,
                                    'columns'=>array(
                                        array(
                                            'header'=>'No.',
                                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                        ),
                                        array(
                                            'header' => 'เลขบัตรประชาชน/Passport',
                                            'type' => 'html',
                                            'value' => function($val) {
                                                $strName = $val->profile->identification;
                                                return $strName;
                                            },
                                        ),
                                        array(
                                            'header' => 'ชือ-นามสกุล',
                                            'type' => 'html',
                                            'value' => function($val) {
                                                $strName = $val->profile->firstname_en."  ".$val->profile->lastname_en;
                                                return $strName;
                                            },
                                        ),
                                        array(
                                            'header' => 'Reset การสอบวัดผล ก่อนเรียน',
                                            'type' => 'raw',
                                            'value' => function($val) {
                                                $examData = Coursescore::model()->find(array(
                                                    'condition' => 'user_id=:user_id AND type="pre" AND active="y"',
                                                    'params' => array(':user_id' => $val->profile->user_id)));
                                                if($examData){
                                                    $evntExam = 'reset_exam';
                                                    $btnClassExam = 'btn-danger';
                                                } else {
                                                    $evntExam = '';
                                                    $btnClassExam = '';
                                                }
                                                return CHtml::button("Reset",array('class' => 'btn '.$evntExam.' '.$btnClassExam.'','data-id' => $val->profile->user_id, 'type'=>'pre', 'style'=>'width: 66px;'));
                                            },'htmlOptions' => array(
                                                'style'=> "text-align: center;",
                                            ),
                                        ),


                                        array(
                                            'header' => 'Reset สอบก่อนเรียน',
                                            'type' => 'raw',
                                            'value' => function($val) {
                                                $examData = Score::model()->find(array(
                                                    'condition' => 'user_id=:user_id AND active="y" AND type="pre"',
                                                    'params' => array(':user_id' => $val->profile->user_id)));
                                                if($examData){
                                                    $evntExam = 'reset_pre';
                                                    $btnClassExam = 'btn-danger';
                                                } else {
                                                    $evntExam = '';
                                                    $btnClassExam = '';
                                                }
                                                return CHtml::button("Reset",array('class' => 'btn '.$evntExam.' '.$btnClassExam.'','data-id' => $val->profile->user_id));
                                            },'htmlOptions' => array(
                                                'style'=> "text-align: center;",
                                            ),
                                        ),

                                        array(
                                            'header' => 'Reset การเรียน',
                                            'type' => 'raw',
                                            'value' => function($val) {
                    //return $val->course_id;
                                                $criteria=new CDbCriteria;
                                                $criteria->with = array('les');
                                                $criteria->compare('user_id',$val->profile->user_id);

                                                $criteria->compare('lesson_active','y');
                                   // $criteria->addCondition('lesson_status IS NOT NULL');
                                    // $criteria->compare('lesson.type','vdo');

                                                $modelLearn = Learn::model()->find($criteria);
                                  //var_dump($modelLearn);exit();
                    //return $modelLearn->learn_id.'|'.$modelLearn->user_id.'|'.$modelLearn->course_id;
                                                if($modelLearn){
                                                    $evntLearn = 'reset_learn';
                                                    $btnClassLearn = 'btn-danger';
                                                } else {
                                                    $evntLearn = '';
                                                    $btnClassLearn = '';
                                                }
                                                return CHtml::button("Reset",array('class' => 'btn '.$btnClassLearn.' '.$evntLearn.'','data-id' => $val->profile->user_id));
                                            },'htmlOptions' => array(
                                                'style'=> "text-align: center;",
                                            ),
                                        ),
                    //         array(
                    //             'header' => 'Reset สอบก่อนเรียน',
                    //             'type' => 'raw',
                    //             'value' => function($val) {
                    // //return $val->course_id;
                    //                 $criteria=new CDbCriteria;
                    //                 // $criteria->with = array('score');
                    //                 $criteria->compare('user_id',$val->profile->user_id);

                    //                 // $criteria->compare('learn.active','y');
                    //                 $criteria->addCondition('active="y" AND type="pre"');
                    //                 // $criteria->compare('lesson.type','vdo');
                    //                 $modelLearn = Score::model()->find($criteria);
                    //                 //echo "<pre>";var_dump($modelLearn);


                    // //return $modelLearn->learn_id.'|'.$modelLearn->user_id.'|'.$modelLearn->course_id;
                    //                 if($modelLearn){
                    //                     $evntLearn = 'reset_pre';
                    //                     $btnClassLearn = 'btn-danger';
                    //                 } else {
                    //                     $evntLearn = '';
                    //                     $btnClassLearn = '';
                    //                 }
                    //                 return CHtml::button("Reset",array('class' => 'btn '.$btnClassLearn.' '.$evntLearn.'','data-id' => $val->profile->user_id));
                    //             },'htmlOptions' => array(
                    //                 'style'=> "text-align: center;",
                    //             ),
                    //         ),
                                        
                                        array(
                                            'header' => 'Reset สอบหลังเรียน',
                                            'type' => 'raw',
                                            'value' => function($val) {
                                                $examData = Score::model()->find(array(
                                                    'condition' => 'user_id=:user_id AND active="y" AND type="post"',
                                                    'params' => array(':user_id' => $val->profile->user_id)));
                                                if($examData){
                                                    $evntExam = 'reset_post';
                                                    $btnClassExam = 'btn-danger';
                                                } else {
                                                    $evntExam = '';
                                                    $btnClassExam = '';
                                                }
                                                return CHtml::button("Reset",array('class' => 'btn '.$evntExam.' '.$btnClassExam.'','data-id' => $val->profile->user_id));
                                            },'htmlOptions' => array(
                                                'style'=> "text-align: center;",
                                            ),
                                        ),                                        
                                        array(
                                            'header' => 'Reset การสอบวัดผล หลังเรียน',
                                            'type' => 'raw',
                                            'value' => function($val) {
                                                $examData = Coursescore::model()->find(array(
                                                    'condition' => 'user_id=:user_id AND type="post" AND active="y"',
                                                    'params' => array(':user_id' => $val->profile->user_id)));
                                                if($examData){
                                                    $evntExam = 'reset_exam';
                                                    $btnClassExam = 'btn-danger';
                                                } else {
                                                    $evntExam = '';
                                                    $btnClassExam = '';
                                                }
                                                return CHtml::button("Reset",array('class' => 'btn '.$evntExam.' '.$btnClassExam.'','data-id' => $val->profile->user_id, 'type'=>'post', 'style'=>'width: 66px;'));
                                            },'htmlOptions' => array(
                                                'style'=> "text-align: center;",
                                            ),
                                        ),
                                        array(
                                            'header' => 'หมายเหตุ',
                                            'type' => 'raw',
                                            'value' => function($val) {
                                              return CHtml::button("รายละเอียด",array('class' => 'btn btn-info reset_detail','data-id' => $val->profile->user_id));
                                          },'htmlOptions' => array(
                                            'style'=> "text-align: center;",
                                        ),
                                      ),
                                    ),
));
?>

</div>
</div>

</div>
</div>




<!-- modal message -->
<div class="modal fade" tabindex="-1" role="dialog" id="selectModal1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- end modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="selectModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3C8DBC;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 25px;color: #fff;}">ข้อความ</h4>
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

    function toggle() {
     var ds = document.getElementById("display");
     if(ds.style.display == 'none')
        ds.style.display = 'block';
    else
        ds.style.display = 'none';
}

function InitialResetLearn() {
 $('.reset_learn').on('click',function(){
    var id = this.getAttribute('data-id');
    $.ajax({
        type: 'POST',
        url: "<?=Yii::app()->createUrl('LearnReset/get_dialog_learn');?>",
        data:{ user_id:id },
        success: function(data) {
            // console.log(data);
            $('#selectModal .modal-title').html('Reset การเรียน');
            $('#selectModal .modal-body').html(data);
            $('#btnSubmit').css('display','');
            $('#selectModal').modal('show');
        }
    })
});

 $('.reset_pre').on('click',function(){
    var id = this.getAttribute('data-id');
    $.ajax({
        type: 'POST',
        url: "<?=Yii::app()->createUrl('LearnReset/get_dialog_pre');?>",
        data:{ user_id:id },
        success: function(data) {
            $('#selectModal .modal-title').html('Reset สอบก่อนเรียน');
            $('#selectModal .modal-body').html(data);
            $('#btnSubmit').css('display','');
            $('#selectModal').modal('show');
        }
    })
});

 $('.reset_post').on('click',function(){
    var id = this.getAttribute('data-id');
    $.ajax({
        type: 'POST',
        url: "<?=Yii::app()->createUrl('LearnReset/get_dialog_post');?>",
        data:{ user_id:id },
        success: function(data) {
            $('#selectModal .modal-title').html('Reset สอบหลังเรียน');
            $('#selectModal .modal-body').html(data);
            $('#btnSubmit').css('display','');
            $('#selectModal').modal('show');
        }
    })
});

 $('.reset_exam').on('click',function(){
    var id = this.getAttribute('data-id');
    var type = this.getAttribute('type');
    $.ajax({
        type: 'POST',
        url: "<?=Yii::app()->createUrl('LearnReset/get_dialog_exam');?>",
        data:{ user_id:id, type:type },
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
        url: "<?=Yii::app()->createUrl('LearnReset/resetdetail');?>",
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
                } else if(type=='pre'){
                    var checkedList = $('.checkedLesson');
                } else if(type=='post'){
                    var checkedList = $('.checkedLesson');
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
                        url: "<?php echo Yii::app()->createUrl("learnReset/checkCourseAccept"); ?>",
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
                    text: "ยืนยันการ Reset กรุณากรอกรหัสผ่าน",
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
                            url : "<?php echo Yii::app()->createUrl("learnReset/confirmPass"); ?>",
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
                            // text: "ระบบกำลังส่งอีเมล",
                            text: "ระบบกำลังดำเนินการ",
                            type: "info",
                            showConfirmButton: false
                        });
                        var id = $('input[name="user_id"]').val();
                        var type = $('input[name="reset_type"]').val();
                        var type_test = $('input[name="type_test"]').val();
                        var checkLessonList = [];
                        var url = '';


                        if(type=='learn'){ // การเรียน
                            var checkedList = $('.checkedLesson');
                            url = "<?= $this->createUrl('learnReset/saveresetlearn') ?>";
                        } else if(type=='exam'){
                            var checkedList = $('.checkCourse');
                            url = "<?= $this->createUrl('learnReset/saveresetexam') ?>";
                        } else if(type=='pre'){
                            var checkedList = $('.checkedLesson');
                            url = "<?= $this->createUrl('learnReset/saveresetpre') ?>";
                        } else if(type=='post'){
                            var checkedList = $('.checkedLesson');
                            url = "<?= $this->createUrl('learnReset/saveresetpost') ?>";
                        }

                        if(checkedList != undefined) {
                            $.each(checkedList, function(i, checkbox) {
                                if(checkbox.value != null && checkbox.checked == true) {
                                    checkLessonList.push(checkbox.value);
                                }
                            });
                        }



                        if(checkLessonList!=null) {
                            $('#selectModal').modal('hide');
                            $.ajax({
                                type : 'POST',
                                url : url,
                                data: { checkedList:JSON.stringify(checkLessonList), id:id,reset_type:type, type_test:type_test,description:inputValue }
                                ,success:function(data){
                                    console.log(data);
                                    if(data=='learn'){
                                        swal({
                                            title: "ระบบ",
                                            text: "Reset การเรียนทั้งหมด เรียบร้อยแล้ว",
                                            type: "success",
                                            confirmButtonText: "ตกลง",
                                        });
                                        location.reload();
                                    } else if(data=='pre'){
                                       swal({
                                        title: "ระบบ",
                                        text: "Reset ผลสอบการสอบก่อนเรียนทั้ง เรียบร้อยแล้ว",
                                        type: "success",
                                        confirmButtonText: "ตกลง",
                                    });
                                       location.reload();
                                   } else if(data=='post'){
                                       swal({
                                        title: "ระบบ",
                                        text: "Reset ผลสอบการสอบหลังเรียนทั้ง เรียบร้อยแล้ว",
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