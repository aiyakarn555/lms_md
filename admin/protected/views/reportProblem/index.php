<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!--Include Date Range Picker--> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />
<?php
$titleName = 'จัดการปัญหาการใช้งาน';
$formNameModel = 'ReportProblem';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
    $('#SearchFormAjax').submit(function(){
        $.fn.yiiGridView.update('$formNameModel-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    $('#export').click(function(){
        window.location = '". $this->createUrl('//reportProblem/report')  . "?' + '&export=true';
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
    $.appendFilter("ReportProblem[news_per_page]", "news_per_page");

    $('#ReportProblem_report_date').attr('readonly','readonly');
    $('#ReportProblem_report_date').css('cursor','pointer');
    $('#ReportProblem_report_date').datepicker();
EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">
     <?php
    $this->widget('AdvanceSearchForm', array(
    'data'=>$model,
    'route' => $this->route,
    'attributes'=>array(
        array('name'=>'firstname','type'=>'text'),
        array('name'=>'report_date','type'=>'text'),
        array('name'=>'status','type'=>'list','query'=>ReportProblem::getSendList()),
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
                <span class="pull-left">
                    <?php 
                    // echo CHtml::tag('button',array(
                    //     'class' => 'btn btn-primary btn-icon glyphicons print',
                    //     'id'=> 'export',
                    // ),'<i></i>ออกรายงาน');
                     ?>
                </span>
            </div>
            <div class="clear-div"></div>
            <div class="overflow-table">
            <?php $this->widget('AGridView', array(
                'id'=>$formNameModel.'-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'afterAjaxUpdate'=>'function(id, data){
                                        $.appendFilter("ReportProblem[news_per_page]");
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
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),      
                    array(
                        'header'=>'วันที่ส่งปัญหา',
                        'type'=>'html',
                        'value'=>function($data){
                            return Helpers::changeFormatDate($data->report_date,'datetime');
                        },
                    ),      
                    array(
                        'header'=>'ชื่อ - สกุล',
                        'value'=>function($data){
                            return $data->firstname.' '.$data->lastname;
                        }
                    ),
                    
                    array(
                        'header'=>'อีเมล์',
                        'value'=>function($data){
                            return $data->email;
                            // $user = User::model()->findByAttributes(array(
                            //  'email' => $data->email,
                            // ));
                        
                            // if($user){
                            //  if($user->bookkeeper_id){
                            //      return $user->bookkeeper_id;
                            //  } else {
                            //      return $user->username;
                            //  }
                            // } else {
                            //  $user = Profile::model()->findByAttributes(array(
                            //      'firstname' => $data->firstname,
                            //  ));
                            //  if($user){
                            //      if($user->user->bookkeeper_id){
                            //          return $user->user->bookkeeper_id;
                            //      } else {
                            //          return $user->user->username;
                            //      }
                            //  } else {
                            //      return 'ไม่มีในระบบ';
                            //  }
                            // }
                            
                         },
                     ),
                    array(
                        'name'=>'tel',
                        'type'=>'html',
                        'value'=>'UHtml::markSearch($data,"tel")'
                    ),
                    
                    array(
                        'name'=>'report_type',
                        'filter'=>ReportProblem::getUsabilityListNew(),
                        'value'=>function($data){
                           return $data->usa->usa_title;
                        }
                        //'value'=>'UHtml::markSearch($data->usa,"usa_title")'
                        // 'value'=>function($data){
                        //     $Usability = Usability::model()->findByAttributes(array(
                        //         'usa_id' => $data->report_type,
                        //     ));
                        //    return $Usability->usa_title;
                        // },
                    ),
                    array(
                        'name'=>'report_course',
                        //'type'=>'html',
                        'filter'=>ReportProblem::getCourseOnlineListNew(),
                        'value'=>function($data){
                           return $data->course->course_title;
                        }
                        //'value'=>'UHtml::markSearch($data->usa,"usa_title")'
                        // 'value'=>function($data){
                        //     $Usability = Usability::model()->findByAttributes(array(
                        //         'usa_id' => $data->report_type,
                        //     ));
                        //    return $Usability->usa_title;
                        // },
                    ),
                    
                    array(
                        'name'=>'report_detail',
                        'type'=>'html',
                        // 'value'=>'UHtml::markSearch($data,"accept_report_date")'
                        'value'=>function($data){
                            $output = UHtml::markSearch($data,"report_detail");
                                return $output;
                        },
                    ),
                    array(
                        'header'=>'คำตอบ',
                        'type'=>'html',
                        'value'=>function($data){
                            if($data->status == 'success'){
                                $output = 'ตอบกลับแล้ว';
                                $color = 'green';
                            } else if($data->status == 'eject'){
                                $color = 'red';
                                $output = 'ยกเลิก';
                            }else if($data->status == 'wait'){
                                $color = 'red';
                                $output = 'ยังไม่ได้ตอบ';
                            }
                            return '<span style="color: '.$color.'">'.$output.'</span>';
                        },
                    ),
                    array(
                'header'=>'ส่งข้อความ',
                'type' => 'raw',
                'visible' => Controller::PButton( array("ReportProblem.*", "ReportProblem.sendMailMessage") ),
                'htmlOptions'=>array('style'=>'text-align: center; width:10%'),
                'value' => function($data) {
                    return  CHtml::button("ส่งข้อความ",array('onclick'=>'sendMsg('.$data->id.')','class' => 'btn btn-danger','style'=>'font-size: 8px;'));
              },  
              ),
                ),
            )); ?>
            </div>
        </div>
    </div>
</div>

<script>
    function sendMsg(id){
      swal({
        title: "ส่งข้อความ",
        //text: "ระบุข้อความ",
        type: "input",
        confirmButtonColor: "#DD6B55",
        showCancelButton: true,
                //allowEnterKey: true,
                closeOnConfirm: false,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก",
                animation: "slide-from-top",
                inputPlaceholder: "ข้อความ"
              },
              function(inputValue){
                if (inputValue === false) 
                  {return false;
                  } else {
                   swal({
                    title: "โปรดรอสักครู่",
                    text: "ระบบกำลังตรวจสอบ",
                    type: "info",
                    //confirmButtonText: "ตกลง",
                    showConfirmButton: false
                  });
       
                   $.ajax({
                    type: "POST",
                    url: '<?php echo $this->createUrl('reportProblem/sendMailMessage'); ?>',
                    data: {
                        inputValue: inputValue,
                        id: id
                    },
                    success: function (data) {

                    if (data === 'y') {
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

