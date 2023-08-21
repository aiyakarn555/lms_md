<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item">
                <a href="<?php echo $this->createUrl('/site/index'); ?>">
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                        echo "Home";
                    } else {
                        echo "หน้าแรก";
                    }
                    ?>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php
                if (Yii::app()->session['lang'] == 1) {
                    echo "Register Report for Office Staff";
                } else {
                    echo "รายงานการสมัครสมาชิกพนักงานออฟฟิศ";
                }
                ?>
            </li>
        </ol>
    </nav>
    <a class="btn btn-reportsearch" href="<?php echo $this->createUrl('/report'); ?>" style="margin-bottom: 0px; margin-left: 0px; background-color: #087fe4;">
        <i class="fas fa-angle-left"></i><?php echo Yii::app()->session['lang'] == 1?'Back':' ย้อนกลับ'; ?>
    </a>
</div>
<section id="report-detail">
    <div class="container">
        <div class="search-collapse panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#report-search"><i class="fas fa-search"></i><?= Yii::app()->session['lang'] == 1?'Search':'ค้นหา'; ?>  <span class="pull-right"><i class="fas fa-chevron-down"></i></span></a>
                    </h4>
                </div>
                <div id="report-search" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row">
                             <?php
                            if($authority == 1){
                            ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for=""><?= Yii::app()->session['lang'] == 1?'Division':'ฝ่าย'; ?></label>
                                    <select class="form-control Department" name="" id="Department">
                                        <option value="" selected ><?= Yii::app()->session['lang'] == 1?'Select Division':'เลือกฝ่าย'; ?></option>
                                        <?php

                                        $criteria= new CDbCriteria;
                                        $criteria->compare('type_employee_id','2');
                                        $criteria->compare('active','y');
                                        if ($authority == 2 || $authority == 3) {
                                                if ($Department != "") {
                                                    $criteria->compare('id',$Department);
                                                }else{
                                                    $criteria->compare('id',0);
                                                }
                                                 
                                        }
                                        $criteria->order = 'dep_title ASC'; 
                                        $departmentModel = Department::model()->findAll($criteria);
                                        // $departmentModel = Department::model()->findAll(array(
                                        //     'condition'=>'active="y"',
                                        //     'order'=>'dep_title ASC',
                                        // ));
                                        foreach ($departmentModel as $key => $val) {
                                            $department_list = $departmentModel[$key]->attributes;
                                            ?>
                                            <option value="<?php echo $department_list['id']; ?>"><?php echo $department_list['dep_title']; ?></option>
                                            <?php   
                                        }                       
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($authority == 1 || $authority == 2 || $authority == 2 && $type_em == 2 ){   
                                   $arr_depart = [];
                                        $criteria= new CDbCriteria;
                                        $criteria->compare('type_employee_id','2');
                                        $criteria->compare('active','y');
                                        $DepartmentGroup = Department::model()->findAll($criteria);
                                        foreach ($DepartmentGroup as $key => $value) {
                                          $arr_depart[]  = $value->id;
                                        }
                                        //var_dump();
                                ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for=""><?= Yii::app()->session['lang'] == 1?'Department':'แผนก'; ?></label>
                                    <select class="form-control Position" name="" id="x">
                                        <option value="" selected ><?= Yii::app()->session['lang'] == 1?'Select Department':'เลือกแผนก'; ?></label></option>
                                        <?php
                                        $criteria= new CDbCriteria;
                                        if ($authority == 2) {
                                                if ($Department != "") {
                                                    $criteria->compare('department_id',$Department);
                                                }else{
                                                    $criteria->compare('department_id',0);
                                                }
                                                 
                                        }else{
                                            $criteria->compare('department_id',$arr_depart);
                                        }
                                        $criteria->compare('active','y');
                                        $criteria->order = 'position_title ASC'; 
                                        $PositionModel = Position::model()->findAll($criteria);
                                        // $PositionModel = Position::model()->findAll(array(
                                        //         'condition' => 'active="y"',
                                        //         'order'=>'position_title ASC',
                                        // ));
                                        foreach ($PositionModel as $key => $val) {
                                            $Position_list = $PositionModel[$key]->attributes;
                                            ?>
                                            <option value="<?php echo $Position_list['id']; ?>"><?php echo $Position_list['position_title']; ?></option>
                                            <?php   
                                        }                       
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($authority == 1 || $authority == 2 || $authority == 2 && $type_em == 2 || $authority == 3 && $type_em == 2){   ?>
                            <div class="col-sm-3 col-md-3 col-xs-12 tag_leval">
                                <div class="form-group">
                                    <label for=""><?= Yii::app()->session['lang'] == 1?'Level':'ระดับตำแหน่ง'; ?></label></label>
                                    <select class="form-control Leval" name="" id="x">
                                        <option value="" selected disabled><?= Yii::app()->session['lang'] == 1?'Select Level':'เลือกระดับตำแหน่ง'; ?></option>
                                        <?php
                                        $criteria= new CDbCriteria;
                                        if ($authority == 3) {
                                                if ($Position != "") {
                                                    $criteria->compare('position_id',$Position);
                                                }else{
                                                    $criteria->compare('position_id',0);
                                                }
                                                 
                                        }
                                        $criteria->compare('active','y');
                                        $criteria->order = 'sortOrder ASC';
                                        $BranchModel = Branch::model()->findAll($criteria);
                                        foreach ($BranchModel as $key => $val) {
                                            $Branch_list = $BranchModel[$key]->attributes;
                                            $i++;
                                            if ($i >= 10)  { break;}
                                            ?>
                                            <option value="<?php echo $Branch_list['id']; ?>"><?php echo $Branch_list['branch_name']; ?></option>
                                            <?php   
                                        }                       
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                   <div>
                                      <label for=""><?= Yii::app()->session['lang'] == 1?'Chart Type':'รูปแบบกราฟ'; ?></label>
                                  </div>
                                  <div class="checkbox checkbox-main checkbox-inline">
                                    <input class="accommodation" type="checkbox" name="accommodation" id="1" value="Bar_Graph" >
                                    <label for="1" class="text-black"><?= Yii::app()->session['lang'] == 1?'Column Chart':'Column Chart'; ?></label>
                                </div>
                                <div class="checkbox checkbox-main checkbox-inline">
                                    <input class="accommodation" type="checkbox" name="accommodation" id="2" value="Pie_Charts">
                                    <label for="2" class="text-black"><?= Yii::app()->session['lang'] == 1?'Pie Chart':'Pie Chart'; ?> </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group day-icon">
                                <i class="far fa-calendar-alt"></i>
                                <label><?= Yii::app()->session['lang'] == 1?'Start Date':'ช่วงเวลาเริ่มต้น'; ?></label>
                                <input class="form-control datetimepicker" autocomplete="off" placeholder="<?= Yii::app()->session['lang'] == 1?'Start Date':'ช่วงเวลาเริ่มต้น'; ?>" type="text" name="" id="datetime_start">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group day-icon">
                                <i class="far fa-calendar-alt"></i>
                                <label><?= Yii::app()->session['lang'] == 1?'End Date':'ช่วงเวลาสิ้นสุด'; ?></label>
                                <input class="form-control datetimepicker" autocomplete="off" placeholder="<?= Yii::app()->session['lang'] == 1?'End Date':'ช่วงเวลาสิ้นสุด'; ?>" type="text" name="" id="datetime_end">
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?= Yii::app()->session['lang'] == 1?'From Year':'ปีเริ่มต้น'; ?></label>
                                <select class="form-control Year_start" name="" id="x">
                                    <option value="" selected disabled><?= Yii::app()->session['lang'] == 1?'Select From Year':'ปีเริ่มต้น'; ?></option>
                                    <?php
                                        if (Yii::app()->session['lang'] == 1) {
                                            $starting_year  = 2019;
                                            $ending_year = date('Y');
                                                  if ($ending_year) {

                                                   for($starting_year; $starting_year <= $ending_year; $starting_year++) {?>
                                                         <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                                                  <?php   }                 
                                                 }
                                        }else{
                                           $starting_year  = 2562;
                                            $ending_year = date('Y')+543;
                                                  if ($ending_year) {

                                                   for($starting_year; $starting_year <= $ending_year; $starting_year++) {?>
                                                         <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                                                  <?php   }                 
                                                 } 
                                        }
                                        
                                       ?>
                           </select>
                       </div>
                   </div>
                   <div class="col-sm-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <label for=""><?= Yii::app()->session['lang'] == 1?'To Year':'ปีสิ้นสุด'; ?></label>
                        <select class="form-control Year_end" name="" id="x">
                            <option value="" selected disabled><?= Yii::app()->session['lang'] == 1?'Select To Year':'ปีสิ้นสุด'; ?></option>
                            <?php
                                        if (Yii::app()->session['lang'] == 1) {
                                            $starting_year  = 2019;
                                            $ending_year = date('Y');
                                                  if ($ending_year) {

                                                   for($starting_year; $starting_year <= $ending_year; $starting_year++) {?>
                                                         <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                                                  <?php   }                 
                                                 }
                                        }else{
                                           $starting_year  = 2562;
                                            $ending_year = date('Y')+543;
                                                  if ($ending_year) {

                                                   for($starting_year; $starting_year <= $ending_year; $starting_year++) {?>
                                                         <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                                                  <?php   }                 
                                                 } 
                                        }
                                        
                                       ?>
                   </select>
               </div>
           </div>
       </div>
       <div class="text-center">
        <button class="btn btn-reportsearch search" onclick="chk_form_search();"><i class="fas fa-search"></i> <?= Yii::app()->session['lang'] == 1?'Search':'ค้นหา'; ?> </button>
    </div>

</div>
</div>

</div>
</div>
<div class="divider">
    <i class="fas fa-chevron-down"></i>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 Graph_1">
        <div class="chart"></div>
        <h4></h4>
        <div style="width:100%">
            <div id="chart_div" style="width: auto; height: 400px;"></div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 Graph_2">
        <div class="chart"></div>
        <h4></h4>
        <div style="width:100%">
            <div id="chart_div2" style="width: auto; height: 400px;"></div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-sm-6 col-md-6 Graph_3">
        <div class="chart"></div>
        <div style="width:100%">
            <div id="chart_div3" style="width: auto; height: 400px;"></div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 Graph_4">
        <div class="chart"></div>
        <div style="width:100%">
            <div id="chart_div4" style="width: auto; height: 400px;"></div>
        </div>
    </div>
</div> 
<div class="dataTable"></div>
</div>

</section>
<script>
    $('.datetimepicker').datetimepicker({
        format: 'Y-m-d',
        step: 10,
        timepicker: false,
        timepickerScrollbar: false,
        yearOffset: 0
    });
     var lang_id = <?php echo Yii::app()->session['lang'] ?>;
    if (lang_id == 2) {
    $.datetimepicker.setLocale('th');
    $('.datetimepicker').datetimepicker({yearOffset: 543});
    }
    $('.Graph_1').hide();
    $('.Graph_2').hide();
    $('.Graph_3').hide();
    $('.Graph_4').hide();

    $(".Department").change(function() {
        var id = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('report/ListPosition'); ?>",
            data: {
                id: id
            },
            success: function(data) {
                
                $('.Position').empty();
                $('.Position').append(data);
                $('.Leval').val("");
            }
        });
    });
    $(document).ready(function(){
        $('.Leval').attr('disabled',true);
    $('.Department').on('change',function(){
        if($('.Department').val() != ''){
            // $('.Leval').attr('disabled',false);
            $('.Leval').attr('disabled',true);
        }else{
            $('.Leval').attr('disabled',true);
        }
    });
        $('.Position').on('change',function(){
        if($('.Position').val() != ''){
            $('.Leval').attr('disabled',false);
        }else{
            $('.Leval').attr('disabled',true);
        }
    });
    });
    $(document).ready(function(){
          $('#datetime_start').on('change',function(){
              /* console.log($("#datetime_start").val()); */
            //   $("#datetime_start").val();
            if($("#datetime_start").val() != ''){
            $('.Year_start').attr('disabled',true);
            $('.Year_end').attr('disabled',true);
            } 
           /*  $('.Year_start').attr('disabled',true);
            $('.Year_end').attr('disabled',true); */
        });
          $('#datetime_end').on('change',function(){
            if($("#datetime_end").val() != ''){
              $('.Year_start').attr('disabled',true);
              $('.Year_end').attr('disabled',true);
            }
        });
        $('.Year_start').on('change',function(){
            $('#datetime_start').attr('disabled',true);
            $('#datetime_end').attr('disabled',true);
        });
        $('.Year_end').on('change',function(){
            $('#datetime_start').attr('disabled',true);
            $('#datetime_end').attr('disabled',true);
        });
    });
    
    function chk_form_search(){
        var status_pass = 1;

        var start_year = $("#Year_start").val();
        var end_year = $("#Year_end").val();
        if(end_year != "" && start_year == ""){
            status_pass =2;
           if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("กรุณาเลือกช่วงปีเริ่มต้น");
            }else{
                swal("Please choose start range");                
            }
         }
        if(end_year == "" && start_year != ""){
            status_pass =2;
           if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("กรุณาเลือกช่วงปีสิ้นสุด");
            }else{
                swal("Please choose end range");                
            }
         }
        var start_date = $("#datetime_start").val();
        var end_date = $("#datetime_end").val();
        if(end_date != "" && start_date == ""){
            status_pass =2;
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("กรุณาเลือกช่วงเวลาเริ่มต้น");
            }else{
                swal("Please choose start range");                
            }
         }
        if(end_date == "" && start_date != ""){
            status_pass =2;
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("กรุณาเลือกช่วงเวลาสิ้นสุด");
            }else{
                swal("Please choose end range");                
            }
        }

        if(status_pass == 1){
            $(".search").submit();
        }
    }
    $("#datetime_start").change(function () {
        $("#datetime_end").val("");
        $("#Year_start").val("");
        $("#Year_end").val("");
    });
    $("#datetime_end").change(function () {
        var first = new Date($("#datetime_start").val());
        var current = new Date($(this).val());

        if (first.getTime() > current.getTime()) {
            if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("ไม่สามารถเลือกช่วงเวลาสิ้นสุดมากกว่าช่วงเวลาเริ่มต้นได้");
            }else{
                swal("Can't choose end range more than start range");                
            }
            $(this).val("");
        }
        $("#Year_start").val("");
        $("#Year_end").val("");
    });

    $("#Year_start").change(function () {
        $("#Year_end").val("");
        $("#datetime_start").val("");
        $("#datetime_end").val("");
    });
    $("#Year_end").change(function () {
        var first = $("#Year_start").val();
        var current = $(this).val();
        if (first >= current && current != "") {
             if(<?= Yii::app()->session['lang'] ?> == 2){
                swal("ไม่สามารถเลือกช่วงปีสิ้นสุดมากกว่าช่วงปีเริ่มต้นได้");
            }else{
                swal("Can't choose end range more than start range");                
            }            
            $(this).val("");
        }
        $("#datetime_start").val("");
        $("#datetime_end").val("");
    });


    $(".Position").change(function() {
        var id = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('report/ListLeval'); ?>",
            data: {
                id: id
            },
            success: function(data) {
                
                $('.Leval').empty();
                $('.Leval').append(data);
            }
        });
    });

    $(".search").click(function() {

        var Department = $(".Department").val();
        var Position = $(".Position").val();
        var Leval = $(".Leval").val(); 
            // var Chart = $("input[name='accommodation']:checked").val();
            var Chart = $('input[name="accommodation"]:checked').serialize();  
            var datetime_start = $("#datetime_start").val();
            var datetime_end = $("#datetime_end").val();
            var Year_start = $(".Year_start").val();
            var Year_end = $(".Year_end").val();

             var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
            // if (Department == '' || Department === null) {
            //     var DepartmentAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select Department type! ':'กรุณาเลือกประเภทฝ่ายพนักงาน!'; ?>";
            //     swal(alert_message,DepartmentAlert)
            //     return false; 
            // }
            if (datetime_start != null || datetime_end != null || datetime_start != "" || datetime_end != "") {
                    if ( datetime_start != "" &&  datetime_end === "") {
                              return false;
                        }

                    if (datetime_end != "" &&  datetime_start === "") {
                              return false;
                        }

                    }
            if (Year_start != null || Year_end != null) {
                        if (Year_start == null && Year_end != null) {
                                var year_startAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a Year start! ':'กรุณาเลือกช่วงปีเริ่มต้น!'; ?>";
                                swal(alert_message,year_startAlert)
                                  return false;
                        }
                          
                        if (Year_start != null && Year_end == null) {
                                    var year_endtAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a Year end! ':'กรุณาเลือกช่วงปีสิ้นสุด!'; ?>";
                                    swal(alert_message,year_endtAlert)
                                      return false;
                        }
                        if (Chart == "") {
                            var ChartAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a graph! ':'กรุณาเลือกรูปแบบกราฟ!'; ?>";
                                    swal(alert_message,ChartAlert)
                                      return false;
                        }
            }   

            $.ajax({
                type: 'POST',
                url: "<?= Yii::app()->createUrl('report/RegisterOfficeData'); ?>",
                data: {
                    Department: Department,
                    Position: Position,
                    Leval: Leval,
                    Chart: Chart,
                    datetime_start: datetime_start,
                    datetime_end: datetime_end,
                    Year_start: Year_start,
                    Year_end: Year_end,
                },
                success: function(data) {
                   if (Chart != "") {
                  if (typeof Year_start === 'undefined' || typeof Year_end === 'undefined' || Year_start === null || Year_end === null) {
                      
                    if (Chart === "accommodation=Bar_Graph") {
                      
                        $('.Graph_1').show();
                        $('.Graph_2').hide();
                        $('.Graph_3').hide();
                        $('.Graph_4').hide();

                    }else if (Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {
                        $('.Graph_1').show();
                        $('.Graph_2').show();
                        $('.Graph_3').hide();
                        $('.Graph_4').hide();

                    }else if (Chart === "accommodation=Pie_Charts") {
                        $('.Graph_1').hide();
                        $('.Graph_2').show();
                        $('.Graph_3').hide();
                        $('.Graph_4').hide();
                        
                    }
                }else{

                    if (Chart === "accommodation=Bar_Graph") {
                        $('.Graph_1').show();
                        $('.Graph_2').show();
                        $('.Graph_3').hide();
                        $('.Graph_4').hide();
                        
                    }else if (Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {
                        $('.Graph_1').show();
                        $('.Graph_2').show();
                        $('.Graph_3').show();
                        $('.Graph_4').show();

                    }else if (Chart === "accommodation=Pie_Charts") {
                        $('.Graph_1').show();
                        $('.Graph_2').show();
                        $('.Graph_3').hide();
                        $('.Graph_4').hide();
                        
                    }
                }
                }
                $(".dataTable").html(data);
            }
        });
        });

    </script>
    