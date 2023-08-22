<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>-->

<?php

$titleName = 'ส่งเมลล์แจ้งเตือนผู้เรียน';
$formNameModel = 'LogStartcourse';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
    $('#SearchFormAjax').submit(function(){
       /* $.fn.yiiGridView.update('$formNameModel-grid', {
            data: $(this).serialize()
        });*/
        return true;
    });
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    /*$.updateGridView = function(gridID, name, value) {
        $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
        $.fn.yiiGridView.update(gridID, {data: $.param(
            $("#"+gridID+" input, #"+gridID+" .filters select")
        )});
    }
    $.appendFilter = function(name, varName) {
        var val = eval("$."+varName);
        $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
    }
    $.appendFilter("Report[news_per_page]", "news_per_page");*/

    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');
    $('#Report_dateRang').daterangepicker();

EOD
, CClientScript::POS_READY);
?>
<script type="text/javascript">
    $(document).ready(function(){
       $("#SendMailAlertCourse_type_employee").change(function(){
        var employee_id = $("#SendMailAlertCourse_type_employee option:selected").val();

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
                        $("#SendMailAlertCourse_department_id").html(data);
                    }
                }
            });
        }
    }); 
       $("#SendMailAlertCourse_department_id").change(function(){
        var department_id = $("#SendMailAlertCourse_department_id option:selected").val();

        if(department_id != ""){
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("/LogStartcourse/ListDepartment"); ?>',
                data: ({
                    department_id: department_id,
                }),
                success: function(data) {

                    if(data != ""){
                        $("#SendMailAlertCourse_position_id").html(data);
                    }
                }
            });
        }
    });
       $("#SendMailAlertCourse_course_id").change(function(){
        var course_id = $("#SendMailAlertCourse_course_id option:selected").val();

        if(course_id != ""){
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("/LogStartcourse/ListGen"); ?>',
                data: ({
                    course_id: course_id,
                }),
                success: function(data) {

                    if(data != ""){
                        $("#SendMailAlertCourse_gen_id").html(data);
                    }
                }
            });
        }
    });
   });

</script>
<div class="innerLR">

  <?php

  $this->widget('AdvanceSearchForm', array(
      'data'=>$model,
      'route' => $this->route,
      'attributes'=>array(
        array('name'=>'type_employee','type'=>'list','query'=>TypeEmployee::getTypeEmployeeListNew()),
        array('name'=>'department_id','type'=>'list','query'=>Department::getDepartmentList()),
        array('name'=>'position_id','type'=>'list','query'=>Position::getPositionList()),
        array('name'=>'search_name','type'=>'text'),
        array('name'=>'course_id','type'=>'list','query'=>ReportProblem::getCourseOnlineListNew()),
        array('name'=>'gen_id','type'=>'list','query'=>$model::getGenList()),
        array('name'=>'status','type'=>'list','query'=>$model::getSatus()),

    ),

  ));

  ?>
  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
        <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
    </div>
    <div class="widget-body">
        <div class="separator bottom form-inline small">
               <!--  <span class="pull-right">
                    <label class="strong">แสดงแถว:</label>
                    <?php echo $this->listPageShow($formNameModel);?>
                </span>  -->
            </div>
            <div class="clear-div"></div>
            <div class="overflow-table">
                <?php

                if ($model->course_id != null) {

                    $course_id = $model->course_id;
                    
                    $criteria = new CDbCriteria;
                    if ($model->department_id != null) {
                        $criteria->compare('department_id',$model->department_id);
                    }
                    if ($model->position_id != null) {
                        $criteria->compare('position_id',$model->position_id);
                    }
                    $orgRoot = OrgChart::model()->find($criteria);

                    $criteria = new CDbCriteria;
                    if ($model->course_id != null) {
                        $criteria->compare('course_id',$model->course_id);
                    }
                    $criteria->compare('orgchart_id',$orgRoot->id);
                    $criteria->compare('active','y');
                    $OrgCourse = OrgCourse::model()->find($criteria);

                    if (!empty($OrgCourse)) {

                        if($orgRoot->branch_id != null || $orgRoot->position_id != null || $orgRoot->department_id != null ){
                            $criteria = new CDbCriteria; 
                            $criteria->compare('course_id',$OrgCourse->course_id);

                            if($orgRoot->branch_id != ""){ // branch
                                $criteria->compare('branch_id',$orgRoot->branch_id);
                            }elseif($orgRoot->position_id != ""){ // position
                                $criteria->compare('position_id',$orgRoot->position_id);
                            }elseif($orgRoot->department_id != ""){ // dept
                                $criteria->compare('department_id',$orgRoot->department_id);
                            }

                            $modelUsers_old = ChkUsercourse::model()->findAll($criteria);
                        }

                        $criteria = new CDbCriteria; 
                        $criteria->with = array('chk_usercourse');

                        if($orgRoot->branch_id != ""){ // branch
                            $criteria->compare('t.branch_id',$orgRoot->branch_id);

                        }elseif($orgRoot->position_id != ""){ // position
                            $criteria->compare('t.position_id',$orgRoot->position_id);

                        }elseif($orgRoot->department_id != ""){ // dept
                            $criteria->compare('t.department_id',$orgRoot->department_id);
                        }


                        if($model->search_name != ""){
                            $criteria->compare('CONCAT(profiles.firstname_en, " " , profiles.lastname_en , " "," ",profiles.firstname , " " , profiles.lastname)',$model->search_name,true);
                        }

                        $usersall_chk = Users::model()->with('profiles')->findAll($criteria);

                        if($modelUsers_old){
                            $criteria->compare('chk_usercourse.org_user_status',1);
                            $criteria->compare('chk_usercourse.course_id',$OrgCourse->course_id);
                        }

                        $usersall = Users::model()->with('profiles')->findAll($criteria);

                        $array_user = [];
                        foreach ($usersall as $key => $value) {
                         $array_user[] = $value->id;

                     }

                     $criteria = new CDbCriteria;
                     if ($model->course_id != null) {
                        $criteria->compare('course_id',$model->course_id);
                    }
                    if ($model->gen_id != null) {
                        $criteria->compare('gen_id',$model->gen_id);
                    }
                    $criteria->addInCondition('user_id',$array_user);
                    $criteria->compare('active','y');
                    $LogStartcourse = LogStartcourse::model()->findAll($criteria);
                        /////////////////////////////คนสมัครเข้าเรียน/////////////////////////////

                    $array_userAddin = [];
                    foreach ($LogStartcourse as $key => $value) {
                       $array_userAddin[] = $value->user_id;
                   }

                   $criteria = new CDbCriteria;
                   if ($model->course_id != null) {
                    $criteria->compare('course_id',$model->course_id);
                }
                if ($model->gen_id != null) {
                    $criteria->compare('gen_id',$model->gen_id);
                }
                $criteria->addInCondition('user_id',$array_userAddin);
                $criteria->compare('lesson_active','y');
                $Learn = Learn::model()->findAll($criteria);
                        /////////////////////////////คนกำลังเรียน////////////////////////////////

                $criteria = new CDbCriteria; 
                $criteria->with = array('chk_usercourse');

                        if($orgRoot->branch_id != ""){ // branch
                            $criteria->compare('t.branch_id',$orgRoot->branch_id);

                        }elseif($orgRoot->position_id != ""){ // position
                            $criteria->compare('t.position_id',$orgRoot->position_id);

                        }elseif($orgRoot->department_id != ""){ // dept
                            $criteria->compare('t.department_id',$orgRoot->department_id);
                        }


                        if($model->search_name != ""){
                            $criteria->compare('CONCAT(profiles.firstname_en, " " , profiles.lastname_en , " "," ",profiles.firstname , " " , profiles.lastname)',$model->search_name,true);
                        }

                        $usersall_chk = Users::model()->with('profiles')->findAll($criteria);

                        if($modelUsers_old){
                            $criteria->compare('chk_usercourse.org_user_status',1);
                            $criteria->compare('chk_usercourse.course_id',$OrgCourse->course_id);
                        }
                        $criteria->addNotInCondition('t.id',$array_userAddin);
                        $usersall_Notin = Users::model()->with('profiles')->findAll($criteria);
                        /////////////////////////////////คนยังไม่ได้เรียน///////////////////////////
                    }
                }
                if ($model->course_id != "" && $model->type_employee != "" &&  $model->gen_id != "" && $model->status != "") {
                  
                ?>
                <table class="table table-bordered" id="user-list">
                 <thead>
                  <tr>
                    <th></th>
                    <th>หลักสูตร</th>
                    <th>แผนก</th>
                    <th>ตำแหน่ง</th> 
                    <th>Name</th>
                    <th>ส่งเมลล์</th>           

                </tr>
            </thead>
            <tbody>
              <?php 
              if ($model->status == '3') {
                  if ($model->course_id != null) {
                      if($usersall_Notin){  
                        $arrayIDCourseSend = "";
                        foreach ($usersall_Notin as $key => $userItem) {
                           $arrayIDCourseSend = $userItem->chk_usercourse->Courses->course_id == null ? $OrgCourse->courses->course_id : $userItem->chk_usercourse->Courses->course_id;
                           ?>
                           <tr>
                            <td><input type="checkbox" id="UserItem<?= $userItem->id ?>" name="UserItem" value="<?= $userItem->id ?>" data="<?= $arrayIDCourseSend ?>"></td>
                            <td><?= $userItem->chk_usercourse->Courses->course_id == null ? $OrgCourse->courses->course_title : $userItem->chk_usercourse->Courses->course_title ?></td>
                            <td><?= $userItem->department->dep_title ?></td>
                            <td><?= $userItem->position->position_title ?></td>
                            <td><?= $userItem->profiles->firstname_en.' '.$userItem->profiles->lastname_en ?></td>
                            <td class="center"><button type="button" class="btn btn-danger" style='font-size: 15px;' onclick="sendMsg(<?= $userItem->id ?>,<?= $arrayIDCourseSend ?>);" >ส่งเมลล์</button></td>
                        </tr>
                    <?php } 

                }else{ ?>
                 <td colspan ="999">ไม่พบข้อมูล</td>
             <?php }

         }
     }else if ($model->status == '1') { 
        if ($LogStartcourse) {
            foreach ($LogStartcourse as $key => $userItem) {
                $arrayIDCourseSend = $userItem->course->course_id == null ? $OrgCourse->courses->course_id : $userItem->course->course_id;
                ?>
                <tr>
                    <td><input type="checkbox" id="UserItem<?= $userItem->user_id ?>" name="UserItem" value="<?= $userItem->user_id ?>" data="<?= $arrayIDCourseSend ?>"></td>
                    <td><?= $userItem->course->course_id == null ? $OrgCourse->courses->course_title : $userItem->course->course_title ?></td>
                    <td><?= $userItem->mem->department->dep_title ?></td>
                    <td><?= $userItem->mem->position->position_title ?></td>
                    <td><?= $userItem->pro->firstname_en.' '.$userItem->pro->lastname_en ?></td>
                    <td class="center"><button type="button" class="btn btn-danger" style='font-size: 15px;' onclick="sendMsg(<?= $userItem->user_id ?>,<?= $arrayIDCourseSend ?>);" >ส่งเมลล์</button></td>
                </tr>
                <?php
            }
        }else{ ?>
         <td colspan ="999">ไม่พบข้อมูล</td>
         <?php

     }
 }else if ($model->status == '2') {
    if ($Learn) {
       foreach ($Learn as $key => $userItem) {
        $arrayIDCourseSend = $userItem->course->course_id == null ? $OrgCourse->courses->course_id : $userItem->course->course_id;
        ?>
        <tr>
            <td><input type="checkbox" id="UserItem<?= $userItem->user_id ?>" name="UserItem" value="<?= $userItem->user_id ?>" data="<?= $arrayIDCourseSend ?>"></td>
            <td><?= $userItem->course->course_id == null ? $OrgCourse->courses->course_title : $userItem->course->course_title ?></td>
            <td><?= $userItem->User->department->dep_title ?></td>
            <td><?= $userItem->User->position->position_title ?></td>
            <td><?= $userItem->Profile->firstname_en.' '.$userItem->Profile->lastname_en ?></td>
            <td class="center"><button type="button" class="btn btn-danger" style='font-size: 15px;' onclick="sendMsg(<?= $userItem->user_id ?>,<?= $arrayIDCourseSend ?>);" >ส่งเมลล์</button></td>
        </tr>
    <?php  }
}else{ ?>
 <td colspan ="999">ไม่พบข้อมูล</td>
 <?php

}
}  

?>

</tbody>

</table>
<?php
}
?>
</div>
</div>
<?php  if ($usersall) {
        //if( Controller::DeleteAll(array("LogStartcourse.*", "LogStartcourse.sendMailMessage", "LogStartcourse.MultiSendMailMessages")) ) : ?>
        <!-- Options -->
        <div class="separator top form-inline small">
            <!-- With selected actions -->
            <div class="buttons pull-left">
                <?php echo CHtml::link("<i></i> ส่งเมลล์ทั้งหมด","#",array(
                    "class"=>"btn btn-primary btn-icon glyphicons circle_minus",
                    "onclick"=>"return MultiSendMailMessage('".$this->createUrl('//'.$formNameModel.'/MultiSendMailCourseMessages')."');"
                )); ?>
            </div>
            <!-- // With selected actions END -->
            <div class="clearfix"></div>
        </div>
        <!-- // Options END -->
    <?php }//endif; ?>
</div>

</div>

<script type="text/javascript">

function MultiSendMailMessage(url) {

  var items = new Array();
  var course = new Array();
 $('input[name=UserItem]').each(function() {
    var $this = $(this);
    if ($this.is(':checked')) {
        items.push($this.val());
        course.push($this.attr('data'));
    }
  });
// console.log(course);
  if (items.length <= 0 && course.length <= 0) {
        swal("กรุณาเลือกรายชื่อที่จะส่งเมลล์");
        return false;
    }
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
        $.ajax({
            type: 'post',
            url: url,
            data: {
                chk: items,
                course: course,
            },
            success: function (data) {
                console.log(data);
                notyfy({
                    dismissQueue: false,
                    text: "ลบส่งเมลล์เรียบร้อย",
                    type: 'success'
                });
                //location.reload();
            },
            error: function (XHR) {
                alert('เกินข้อผิดพลาดกรุณาทำข้อมูลไหม');
            }
        });
    });
    return false;
}

     function sendMsg(id,course_id){
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
                    url: '<?php echo $this->createUrl('LogStartcourse/sendMailMessageCourse'); ?>',
                    data: {
                        id: id,
                        course_id: course_id,
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

</script>