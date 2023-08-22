<?php
$titleName = 'หลักสูตร';
$formNameModel = 'CourseOnline';
$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
    $('#SearchFormAjax').submit(function(){
        $.fn.yiiGridView.update('$formNameModel-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
if(isset($_GET['name'])){
  $all =true;
}else{
  $all =0;
}
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
    $.appendFilter("CourseOnline[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
    <?php $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'cates_search','type'=>'text'),
            array('name'=>'course_number','type'=>'text'),
            // array('name'=>'course_lecturer','type'=>'list','query'=>CHtml::listData(Teacher::model()->findAll(array(
            // "condition"=>" active = 'y' ")),'teacher_id', 'teacher_name')),
            array('name'=>'course_title','type'=>'text'),
            // array('name'=>'course_price','type'=>'text'),
            //array('name'=>'course_point','type'=>'text'),
        ),
    ));
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
                    'dataProvider'=>$model->courseonlinecheck()->search(),
                    'filter'=>$model,
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
              'header'=>'รูปภาพ',
              'type'=>'raw',
              'value'=> 'Controller::ImageShowIndex($data,$data->course_picture)',
              'htmlOptions'=>array('width'=>'110')
            ),
                        array(
                            'name'=>'course_title',
                            'type'=>'html',
                            'value'=>'UHtml::markSearch($data,"course_title")',
                            'htmlOptions' => array(
                               'style' => 'width:130px',
                            ), 
                        ),
                        array(
                            'name'=>'cate_id',
                            'value'=>'$data->cates->cate_title',
                            'filter'=>CHtml::activeTextField($model,'cates_search'),
                            'htmlOptions' => array(
                               'style' => 'width:130px',
                            ),  
                        ),
                     

                        array(
                          'header'=>'เพิ่ม / ลบ ผู้เรียน',
                    
                            'value'=>function($data){
                                $html = CHtml::link( '<i class=""></i> เพิ่ม / ลบ ผู้เรียน', 'javascript:void(0)', array( 'class' => 'btn btn-primary btn-icon', 'onclick' => 'getUser(' . $data->course_id . ')'));
                                // $html .= CHtml::link( '<i class="fa fa-envelope"></i> ส่งอีเมลไปยังผู้เรียน', 'javascript:void(0)', array( 'class' => 'btn btn-primary btn-icon', 'onclick' => 'sendmailUser(' . $data->course_id . ',"'.$data->course_title.'")'));
                                return $html;
                              },

                          'type'=>'raw',
                                'htmlOptions'=>array('style'=>'text-align: center;vertical-align: middle;','width'=>'100px'),
                              'headerHtmlOptions'=>array('style'=>'text-align: center'),
                          ),

                         // array(
                         //  'header'=>'ลบผู้เรียน',
                    
                         //    'value'=>function($data){
                         //        return CHtml::link( '<i class=""></i> ลบผู้เรียน', 'javascript:void(0)', array( 'class' => 'btn btn-primary btn-icon', 'onclick' => 'delUser(' . $data->course_id . ')'));
                         //      },
                              
                         //  'type'=>'raw',
                         //        'htmlOptions'=>array('style'=>'text-align: center;vertical-align: middle;','width'=>'100px'),
                         //      'headerHtmlOptions'=>array('style'=>'text-align: center'),
                         //  ),

                        // array(
                        //         'header' => 'จัดการสมาชิก',
                        //         'type' => 'raw',
                        //         'value' => function($data) {
                                    
                        //             return CHtml::button("จัดการสมาชิก",array('class' => 'btn btn-danger org_course','data-id' => $data->course_id));
                        //         },
                        //         'htmlOptions'=>array('style'=>'text-align: center;vertical-align: middle;'),
                        //         'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
                        //     ),
                    ),
                )); ?>
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


<div class="modal fade" id="selectApplyCourseToUsers" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">เลือกผู้เรียน</h4>
            </div>
                <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
                    </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
         $('.org_course').on('click',function(){
            var id = this.getAttribute('data-id');
            var position_id = <?= $position_id ?>;
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('OrgChart/get_dialog_user');?>",
                data:{ position_id:position_id,course_id:id },
                success: function(data) {
                    $('#selectModal .modal-title').html('เลือกผู้เรียน');
                    $('#selectModal .modal-body').html(data);
                    $('#btnSubmit').css('display','');
                    $('#selectModal').modal('show');
                }
            })
        });

  });

    function selectUser(course_id) {
      // console.log(course_id);
        var position_id = <?= $position_id ?>;
          if(course_id != undefined && course_id!=null && position_id != undefined && position_id!=null) {
           $.post("<?= $this->createUrl('OrgChart/userModal') ?>", { position_id: position_id,course_id: course_id }, function(respon) {
            if(respon) {
             $('#selectApplyCourseToUsers .modal-body').html(respon);
             // var table = $('.user-list').DataTable();
             // table.draw();
             setTimeout(function() {
              $('#selectApplyCourseToUsers').modal({
               keyboard: false
             });
            }, 1000);
           }
         });
         }
    }

    function saveModal() {
              var course_id = $('input[name="course_id"]').val();
              var userCheckList = $('.userCheckList');
              var checkedList = [];

              if(userCheckList != undefined) {
               $.each(userCheckList, function(i, checkbox) {
                if(checkbox.value != null && checkbox.checked == true) {
                 checkedList.push(checkbox.value);
                  // checkedList[i] = checkbox.value;
                }
                console.log(checkedList);
              });
               if(checkedList!=null) {
                 $.post("<?= $this->createUrl('OrgChart/SaveUserModal') ?>", { checkedList: JSON.stringify(checkedList), course_id: course_id }, function(respon) {
                  if(respon) {
                    $('#selectApplyCourseToUsers').modal('hide');
                                  // $('#MtCourseType-grid').load(document.URL + ' #MtCourseType-grid');
                                  $.fn.yiiGridView.update('OrgChart-grid');
                               } else {
                                 alert('error');
                               }
                             });
               }
             }
    }

    function sendmailUser(course_id, course_title){

         swal({
            title: "ส่งอีเมลไปยังผู้เรียน",
            // text: "ขอขอบพระคุณเป็นอย่างสูง ที่ให้ความร่วมมือค่ะ",
            type: "info",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ส่ง",
            allowOutsideClick: true,
            closeOnConfirm: true
            },
            function(isConfirm){
                if(isConfirm) {
                    $.blockUI({message: '<h1>กำลังดำเนินการ</h1>'});
                    var url = '<?= Yii::app()->createUrl('OrgChart/sendmail/'); ?>'+'/'+course_id+'?orgchart_id='+<?= $_GET['id']; ?>+'&course_title='+course_title;
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function(data){
                            console.log(data);
                            setTimeout(function () {
                                swal("สำเร็จ", "อัปเดตสำเร็จ", "success");
                            }, 10000);
                            // location.reload();
                            
                        },
                        error: function(err){
                            // console.log(err);
                            $.unblockUI(); 
                            swal("ไม่สำเร็จ", "เกิดข้อผิดพลาด", "warning");
                        }
                    });
                }
            });
               
    }

    function getUser(course_id){
      window.location.href = '<?= Yii::app()->createUrl('OrgChart/CheckUser/'); ?>'+'/'+course_id+'?orgchart_id='+<?= $_GET['id']; ?>+'&all='+<?= $all; ?>; 
    }

    function delUser(course_id){
      window.location.href = '<?= Yii::app()->createUrl('OrgChart/DelUser/'); ?>'+'/'+course_id+'?orgchart_id='+<?= $_GET['id']; ?>+'&all='+<?= $all; ?>; 
    }

    function getUserTo(course_id){
      window.location.href = '<?= Yii::app()->createUrl('OrgChart/CheckUserTo/'); ?>'+'/'+course_id+'?orgchart_id='+<?= $_GET['id']; ?>+'&all='+<?= $all; ?>; 
    }

</script>