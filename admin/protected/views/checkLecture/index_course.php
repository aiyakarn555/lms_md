<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
 <!--Include Date Range Picker--> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<?php
$formNameModel = 'CheckLecture';
$titleName = 'ตรวจข้อสอบบรรยาย';

Yii::app()->clientScript->registerScript('search', "
    $('#SearchFormAjax').submit(function(){
        return true;
    });
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $('.collapse-toggle').click();
    $('#Courselogques_dateRang').attr('readonly','readonly');
    $('#Courselogques_dateRang').css('cursor','pointer');
    $('#Courselogques_dateRang').daterangepicker();

EOD
, CClientScript::POS_READY);


?>
<!-- <script>
    $(document).ready(function(){
        $("#Courselogques_period_start").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
              $("#Courselogques_period_end").datepicker("option","minDate", selected)
            }
        });
        $("#Courselogques_period_end").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
               $("#Courselogques_period_start").datepicker("option","maxDate", selected)
            }
        }); 
});
</script> -->

    <div class="innerLR">
        <?php
        $criteria = new CDbCriteria;
        $criteria->compare('active','y');
        $criteria->compare('lang_id','1');
        //แสดงตาม Group
        $modelUser = Users::model()->findByPk(Yii::app()->user->id);
        $group = json_decode($modelUser->group);
        if (!in_array(1, $group)){
            $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
            $criteria->addInCondition('create_by', $groupUser);    
        }
     //   $criteria->order = 'cate_id ASC, cate_course ASC, course_id ASC';
        $criteria->order = "create_date DESC";
        $CourseOnline = CourseOnline::model()->findAll($criteria);
        // $CourseOnline = CourseOnline::model()->findAll(array(
        //     'condition' => 'active = "y" AND lang_id=1',
        //     'order' => 'cate_id ASC, cate_course ASC, course_id ASC'
        // ));
        $listCourse = CHtml::listData($CourseOnline,'course_id','course_title');


        $this->widget('AdvanceSearchForm', array(
            'data'=>$model,
            'route' => $this->route,
            'attributes'=>array(
                array('name'=>'course_id','type'=>'list','query'=>$listCourse),
                array('name'=>'searchAll','type'=>'text'),
                array('name'=>'dateRang','type'=>'text'),
        ),
        ));
    ?>

    <?php 
    if(!empty($_GET) ){

     ?>
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
                    'rowCssClassExpression'=>'"items[]_{$data->logques_id}"',
                    'htmlOptions' => array(
                        'style'=> "margin-top: -1px;",
                    ),
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
                            'header' => 'หลักสูตร',
                            'type'=>'raw',
                            'value' => '$data->courseOnline->course_title',
                        ),   

                        array(
                            'header' => 'ผู้ใช้',
                            'type'=>'raw',
                            'value' => function($val){
                                $fullname = $val->member->firstname." ".$val->member->lastname;
                                return $fullname;
                            },
                        ), 
                        array(
                            'header'=>'ก่อนเรียน',
                            'value'=> function($val) {   
                                $type = "pre";
                                // if($val->check == 0){

                                //    return CHtml::button("ตรวจ",  array("class" => "btn btn-primary btn-icon","onclick" => "getExam('".$val->user_id."','".$val->course_id."')"));
                                // }else if($val->check == 1){
                                //     return CHtml::button("ดูคำตอบ",  array("class" => "btn btn-primary btn-icon","onclick" => "getExamResult('".$val->user_id."','".$val->course_id."')"));
                                // }
                            $logques = Courselogques::model()->with('Coursescore')->find(array(
                                'condition' => 't.user_id=:user_id and t.active = "y" and Coursescore.active = "y" and t.ques_type = 3 and t.course_id=:course_id and t.confirm = 0 and t.test_type=:test_type','order'=>'t.user_id',
                                'params' => array(':user_id' => $val->user_id,':course_id' => $val->course_id, ':test_type'=>$type),
                                'order'=>'logques_id DESC'
                            ));
                            $score = $logques->Coursescore->score_number;
                            $scoreTotal = $logques->Coursescore->score_total;
                            if($logques->check == '0'){
                            $score = '-';
                             return '<div class="row">'.$score.' / '.$scoreTotal.'</div>'.CHtml::button("ตรวจ",  array("class" => "btn btn-primary btn-icon","onclick" => "getExam('".$val->user_id."','".$val->course_id."')"));
                             } else if ($logques->confirm == '0'){
                                return 
                                '<div class="row">'.$score.' / '.$scoreTotal.'</div>'.
                                '<div class="btn-group" role="group" aria-label="Basic example">'.
                                CHtml::button("แก้ไข",  array("class" => "btn btn-primary btn-icon","onclick" => "getExam('".$val->user_id."','".$val->course_id."')")).
                                CHtml::button("ยืนยัน",  array("class" => "btn btn-primary btn-icon","onclick" => "getExamConfirm('".$val->user_id."','".$val->course_id."','".$type."')")).
                                '</div>';
                            } else if ($logques->confirm == '1') {
                                return '<div class="row">'.$score.' / '.$scoreTotal.'</div>'.CHtml::button("ตรวจแล้ว",  array("class" => "btn disabled btn-icon"));
                            } else {
                                return CHtml::button("ไม่มีข้อสอบ",  array("class" => "btn disabled btn-icon"));
                            }  
                               
                            },
                          
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align: center','width'=>'auto'),
                        ),
                       array(
                            'header'=>'หลังเรียน',
                            'value'=> function($val) {   
                                $type = "post";

                                // if($val->check == 0){

                                //    return CHtml::button("ตรวจ",  array("class" => "btn btn-primary btn-icon","onclick" => "getExam('".$val->user_id."','".$val->course_id."')"));
                                // }else if($val->check == 1){
                                //     return CHtml::button("ดูคำตอบ",  array("class" => "btn btn-primary btn-icon","onclick" => "getExamResult('".$val->user_id."','".$val->course_id."')"));
                                // }
                            $logques = Courselogques::model()->with('Coursescore')->find(array(
                                'condition' => 't.user_id=:user_id and t.active = "y" and Coursescore.active = "y" and t.ques_type = 3 and t.course_id=:course_id and t.confirm = 0 and t.test_type=:test_type','order'=>'t.user_id',
                                'params' => array(':user_id' => $val->user_id,':course_id' => $val->course_id, ':test_type'=>$type),
                                'order'=>'logques_id DESC'
                            ));
                            $score = $logques->Coursescore->score_number;
                            $scoreTotal = $logques->Coursescore->score_total;
                            if($logques->check == '0'){
                            $score = '-';
                             return '<div class="row">'.$score.' / '.$scoreTotal.'</div>'.CHtml::button("ตรวจ",  array("class" => "btn btn-primary btn-icon","onclick" => "getExam('".$val->user_id."','".$val->course_id."')"));
                             } else if ($logques->confirm == '0'){
                                return 
                                '<div class="row">'.$score.' / '.$scoreTotal.'</div>'.
                                '<div class="btn-group" role="group" aria-label="Basic example">'.
                                CHtml::button("แก้ไข",  array("class" => "btn btn-primary btn-icon","onclick" => "getExam('".$val->user_id."','".$val->course_id."')")).
                                CHtml::button("ยืนยัน",  array("class" => "btn btn-primary btn-icon","onclick" => "getExamConfirm('".$val->user_id."','".$val->course_id."','".$type."')")).
                                '</div>';
                            } else if ($logques->confirm == '1') {
                                return '<div class="row">'.$score.' / '.$scoreTotal.'</div>'.CHtml::button("ตรวจแล้ว",  array("class" => "btn disabled btn-icon"));
                            } else {
                                return CHtml::button("ไม่มีข้อสอบ",  array("class" => "btn disabled btn-icon"));
                            }  
                               
                            },
                          
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align: center','width'=>'auto'),
                        ),
                    )
                 )
                ); ?>

            </div>
        </div>
    </div>
</div>
 <?php
            
       
        }else if(count($user) == 0 && $model->searchAll != ""){


    ?>
    <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> </h4>
                </div>
                <div class="widget-body">
                    <!-- Table -->
                    <h3 style="color: red;">ไม่พบข้อมูล</h3>
                    <!-- // Table END -->
                </div>
            </div>
    <?php }else if(empty($_GET)){ 


        ?>
        <div class="widget" style="margin-top: -1px;">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines">
                    <i></i> </h4>
            </div>
            <div class="widget-body">
                <!-- Table -->
                <h3 class="text-success">กรุณาใส่ ชื่อ - นามสกุล แล้วกด ปุ่มค้นหา</h3>
                <!-- // Table END -->
            </div>
        </div>

    <?php

    } ?>
<div class="modal fade" tabindex="-1" role="dialog" id="selectModal" style="left: 40%">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3C8DBC;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="font-size: 14px;color: #fff;">ข้อความ</h4>
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
   function getExam(user_id,course_id){
               
                $.ajax({
                    type: 'POST',
                    url: "<?=Yii::app()->createUrl('CheckLecture/get_dialog_exam_course');?>",
                    data:{ user_id:user_id,course_id:course_id},
                    success: function(data) {
                        $('.modal-body').html(data);
                        $('#selectModal').modal('show');
                    }
                })
            }
    function getExamResult(user_id,course_id){
           
                $.ajax({
                    type: 'POST',
                    url: "<?=Yii::app()->createUrl('CheckLecture/get_dialog_resultCourse');?>",
                    data:{ user_id:user_id,course_id:course_id},
                    success: function(data) {
                        $('.modal-body').html(data);
                        $('#selectModal').modal('show');
                    }
                })
            }

             function getExamConfirm(user_id,course_id){
                var r = confirm("ยืนยันบันทึกข้อมูล!");
                if (r == true) {
                $.ajax({
                    type: 'POST',
                    url: "<?=Yii::app()->createUrl('CheckLecture/SaveCourseExamConfirm');?>",
                    data:{ user_id:user_id,course_id:course_id},
                    success: function(data) {
                      location.reload();
                    }
                })
                } 
            }

     function saveModal() {

                  var dataForm = $('#form-course').serialize();
                  // console.log(dataForm);

                  var check_status = 1;
                  $('input[type="number"]').each(function( index ) {
                    if(parseInt(this.value) > parseInt(this.getAttribute("max"))){
                        console.log(this.value+" > "+this.getAttribute("max"));
                        check_status = 2;                        
                    }
                });

                  if(check_status == 1){
                      $.ajax({
                        type: 'POST',
                        url: "<?=Yii::app()->createUrl('CheckLecture/saveExamCourse');?>",
                        data: dataForm,
                        success: function(data) {
                            location.reload();
                        }
                    });
                  }else{
                    alert("ไม่สามารถให้คะแนนมากกว่าคะแนนเต็มได้");
                }
            }
   
</script>