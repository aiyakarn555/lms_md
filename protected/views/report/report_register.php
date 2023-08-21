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
          echo "Overview of Register Report";
        } else {
          echo "รายงานภาพรวมการสมัครสมาชิก";
        }
        ?>
      </li>
    </ol>
  </nav>
  <a class="btn btn-reportsearch" href="<?php echo $this->createUrl('/report'); ?>" style="margin-bottom: 0px; margin-left: 0px; background-color: #087fe4;">
    <i class="fas fa-angle-left"></i><?php echo Yii::app()->session['lang'] == 1 ? 'Back' : 'ย้อนกลับ'; ?>
  </a>
</div>
<section id="report-detail">
  <div class="container">
    <div class="search-collapse panel-group">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" href="#report-search"><i class="fas fa-search"></i><?= Yii::app()->session['lang'] == 1 ? 'Search' : 'ค้นหา'; ?> <span class="pull-right"><i class="fas fa-chevron-down"></i></span></a>
          </h4>
        </div>
        <div id="report-search" class="panel-collapse collapse in">
          <div class="panel-body">
            <div class="row">
              <?php
              if ($authority == 1) {
              ?>
                <div class="col-sm-3 col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Employee Type' : 'ประเภทพนักงาน'; ?><font color="red">*</font></label>
                    <select class="form-control TypeEmployee" name="" id="TypeEmployee">
                      <option value="" selected> <?= Yii::app()->session['lang'] == 1 ? 'Select Type' : 'เลือกประเภท'; ?></option>
                      <?php
                      if ($authority == 2 && $type_em == 1) { ?>
                        <option value="1" selected> <?= Yii::app()->session['lang'] == 1 ? 'Ship Staff' : 'พนักงานประจำเรือ'; ?></option>
                      <?php
                      }
                      if ($authority == 2 && $type_em == 2) {
                      ?>
                        <option value="2" selected> <?= Yii::app()->session['lang'] == 1 ? 'Office Staff ' : 'พนักงานออฟฟิศ'; ?></option>
                      <?php
                      } else if ($authority == 1) { ?>
                        <option value="1"> <?= Yii::app()->session['lang'] == 1 ? 'Ship Staff' : 'พนักงานประจำเรือ'; ?></option>
                        <option value="2"> <?= Yii::app()->session['lang'] == 1 ? 'Office Staff ' : 'พนักงานออฟฟิศ'; ?></option>
                      <?php
                      }
                      ?>

                    </select>
                  </div>
                </div>
              <?php
              }

              if ($authority == 1) {
              ?>
                <div class="col-sm-3 col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="" class="DivisionLabel">
                      <?php
                      if ($authority == 1 && $type_em == 2) {
                        if (Yii::app()->session['lang'] == 1) {
                          echo "Division";
                        } else {
                          echo "ฝ่าย";
                        }
                      } else {

                        if (Yii::app()->session['lang'] == 1) {
                          echo "Department";
                        } else {
                          echo "แผนก";
                        }
                      }
                      ?>
                    </label>
                    <select class="form-control Department" name="" id="Department">
                      <option value="" selected disabled><?php
                                                          if ($authority == 1 && $type_em == 2) {
                                                            if (Yii::app()->session['lang'] == 1) {
                                                              echo "Select Division";
                                                            } else {
                                                              echo "เลือกฝ่าย";
                                                            }
                                                          } else {

                                                            if (Yii::app()->session['lang'] == 1) {
                                                              echo "Select Department";
                                                            } else {
                                                              echo "เลือกแผนก";
                                                            }
                                                          }
                                                          ?></option>
                      <?php

                      $criteria = new CDbCriteria;
                      if ($authority == 2 || $authority == 3) {
                        if ($Department != "") {
                          $criteria->compare('id', $Department);
                        } else {
                          $criteria->compare('id', 0);
                        }
                      }
                      $criteria->compare('active', 'y');
                      $criteria->order = 'sortOrder ASC';
                      $departmentModel = Department::model()->findAll($criteria);
                      foreach ($departmentModel as $key => $val) {
                        $department_list = $departmentModel[$key]->attributes;
                      ?>
                        <option value="<?php echo $department_list['id']; ?>"><?php echo $department_list['dep_title']; ?></option>
                      <?php  } ?>

                    </select>
                  </div>
                </div>
              <?php
              }
              ?>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <div>
                    <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Chart Type' : 'รูปแบบกราฟ'; ?></label>
                  </div>
                  <div class="checkbox checkbox-main checkbox-inline">
                    <input class="accommodation" type="checkbox" name="accommodation" id="1" value="Bar_Graph"><!-- checked -->
                    <label for="1" class="text-black"><?= Yii::app()->session['lang'] == 1 ? 'Column Chart' : 'Column Chart'; ?></label>
                  </div>
                  <div class="checkbox checkbox-main checkbox-inline">
                    <input class="accommodation" type="checkbox" name="accommodation" id="2" value="Pie_Charts">
                    <label for="2" class="text-black"><?= Yii::app()->session['lang'] == 1 ? 'Pie Chart' : 'Pie Chart'; ?> </label>
                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <?php if ($authority == 1 || $authority == 2 || $authority == 2 && $type_em == 2 || $authority == 2 && $type_em == 1) {   ?>
                <div class="col-sm-3 col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="" class="DepartmentLabel">
                      <?php
                      if ($authority == 2 && $type_em == 2) {
                        if (Yii::app()->session['lang'] == 1) {
                          echo "Department";
                        } else {
                          echo "แผนก";
                        }
                      } else {

                        if (Yii::app()->session['lang'] == 1) {
                          echo "Position";
                        } else {
                          echo "ตำแหน่ง";
                        }
                      }
                      ?>
                    </label>
                    <select class="form-control Position" name="" id="department_test">
                      <option value="" selected disabled> <?php
                                                          if ($authority == 2 && $type_em == 2) {
                                                            if (Yii::app()->session['lang'] == 1) {
                                                              echo "Select Department";
                                                            } else {
                                                              echo " เลือกแผนก";
                                                            }
                                                          } else {

                                                            if (Yii::app()->session['lang'] == 1) {
                                                              echo "Select Position";
                                                            } else {
                                                              echo "เลือกตำแหน่ง";
                                                            }
                                                          }
                                                          ?></label></option>
                      <?php

                      $criteria = new CDbCriteria;
                      if ($authority == 2) {
                        if ($Department != "") {
                          $criteria->compare('department_id', $Department);
                        } else {
                          $criteria->compare('department_id', 0);
                        }
                      }
                      $criteria->compare('active', 'y');
                      $criteria->order = 'sortOrder ASC';
                      $PositionModel = Position::model()->findAll($criteria);
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
              <?php
              }
              ?>
              <?php
              if ($authority == 1 || $authority == 2 || $authority == 3) {
                if ($authority == 2 && $type_em == 2 || $authority == 1 || $authority == 3 && $type_em == 2) {
              ?>
                  <div class="col-sm-3 col-md-3 col-xs-12 tag_leval">
                    <div class="form-group">
                      <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Level' : 'ระดับตำแหน่ง'; ?></label></label>
                      <select class="form-control Leval" name="" id="level_test">
                        <option value="" selected disabled><?= Yii::app()->session['lang'] == 1 ? 'Select Level' : 'เลือกระดับตำแหน่ง'; ?></option>
                        <?php
                        $criteria = new CDbCriteria;
                        if ($authority == 3) {
                          if ($Position != "") {
                            $criteria->compare('position_id', $Position);
                          } else {
                            $criteria->compare('position_id', 0);
                          }
                        }
                        $i = 0;
                        $criteria->compare('active', 'y');
                        $criteria->order = 'sortOrder ASC';
                        $BranchModel = Branch::model()->findAll($criteria);
                        foreach ($BranchModel as $key => $val) {
                          $Branch_list = $BranchModel[$key]->attributes;
                          $i++;
                          if ($i >= 10) {
                            break;
                          }
                        ?>
                          <option value="<?php echo $Branch_list['id']; ?>"><?php echo $Branch_list['branch_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
              <?php
              if ($authority == 1 || $authority == 2 || $authority == 3) {
                if ($authority == 2 && $type_em == 1 || $authority == 1 || $authority == 2 || $authority == 3 && $type_em == 1) {
              ?>
                  <div class="col-sm-3 col-md-3 col-xs-12 tag_status">
                    <div class="form-group">
                      <label for=""><?= Yii::app()->session['lang'] == 1 ? 'Status' : 'สถานะ'; ?><font color="red">*</font></label>
                      <select class="form-control status" name="" id="x">
                        <option value="" selected disabled><?= Yii::app()->session['lang'] == 1 ? 'Status' : 'เลือกสถานะ'; ?></option>
                        <option value="1"><?= Yii::app()->session['lang'] == 1 ? 'Approved' : 'อนุมัติ'; ?></option>
                        <option value="0"><?= Yii::app()->session['lang'] == 1 ? 'Disapproved' : 'ไม่อนุมัติ'; ?></option>
                        <option value="2"><?= Yii::app()->session['lang'] == 1 ? 'Suspension' : 'ระงับการใช้งาน'; ?></option>
                      </select>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
            </div>

            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group day-icon">
                  <i class="far fa-calendar-alt"></i>
                  <label><?= Yii::app()->session['lang'] == 1 ? 'Start Date' : 'ช่วงเวลาเริ่มต้น'; ?></label>
                  <input class="form-control datetimepicker" autocomplete="off" placeholder="<?= Yii::app()->session['lang'] == 1 ? 'Start Date' : 'ช่วงเวลาเริ่มต้น'; ?>" type="text" name="" id="datetime_start">
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group day-icon">
                  <i class="far fa-calendar-alt"></i>
                  <label><?= Yii::app()->session['lang'] == 1 ? 'End Date' : 'ช่วงเวลาสิ้นสุด'; ?></label>
                  <input class="form-control datetimepicker" autocomplete="off" placeholder="<?= Yii::app()->session['lang'] == 1 ? 'End Date' : 'ช่วงเวลาสิ้นสุด'; ?>" type="text" name="" id="datetime_end">
                </div>
              </div>
              <div class="col-sm-3 col-md-3 col-xs-12">
                <div class="form-group">
                  <label for=""><?= Yii::app()->session['lang'] == 1 ? 'From Year' : 'ปีเริ่มต้น'; ?></label>
                  <select class="form-control year_start" name="" id="Year_start">
                    <option value="" selected disabled><?= Yii::app()->session['lang'] == 1 ? 'Select From Year' : 'ช่วงปีเริ่มต้น'; ?></option>
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                      $starting_year  = 2019;
                      $ending_year = date('Y');
                      if ($ending_year) {

                        for ($starting_year; $starting_year <= $ending_year + 2; $starting_year++) { ?>
                          <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                        <?php   }
                      }
                    } else {
                      $starting_year  = 2562;
                      $ending_year = date('Y') + 543;
                      if ($ending_year) {

                        for ($starting_year; $starting_year <= $ending_year + 2; $starting_year++) { ?>
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
                  <label for=""><?= Yii::app()->session['lang'] == 1 ? 'To Year' : 'ปีสิ้นสุด'; ?></label>
                  <select class="form-control year_end" name="" id="Year_end">
                    <option value="" selected disabled><?= Yii::app()->session['lang'] == 1 ? 'Select To Year' : 'ช่วงปีสิ้นสุด'; ?></option>
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                      $starting_year  = 2019;
                      $ending_year = date('Y');
                      if ($ending_year) {

                        for ($starting_year; $starting_year <= $ending_year + 2; $starting_year++) { ?>
                          <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                        <?php   }
                      }
                    } else {
                      $starting_year  = 2562;
                      $ending_year = date('Y') + 543;
                      if ($ending_year) {

                        for ($starting_year; $starting_year <= $ending_year + 2; $starting_year++) { ?>
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
              <button class="btn btn-reportsearch search" onclick="chk_form_search();"><i class="fas fa-search"></i> <?= Yii::app()->session['lang'] == 1 ? 'Search' : 'ค้นหา'; ?> </button>
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
    $('.datetimepicker').datetimepicker({
      yearOffset: 543
    });
  }

  $('.Graph_1').hide();
  $('.Graph_2').hide();
  $('.Graph_3').hide();
  $('.Graph_4').hide();


  $(document).ready(function() {

    $('#datetime_start').on('change', function() {
      if ($("#datetime_start").val() != '') {
        $('#Year_start').attr('disabled', true);
        $('#Year_end').attr('disabled', true);
      }
    });

    $('#datetime_end').on('change', function() {
      if ($("#datetime_end").val() != '') {
        $('#Year_start').attr('disabled', true);
        $('#Year_end').attr('disabled', true);
      }
    });

    $('#Year_start').on('change', function() {
      $('#datetime_start').attr('disabled', true);
      $('#datetime_end').attr('disabled', true);
    });

    $('#Year_end').on('change', function() {
      $('#datetime_start').attr('disabled', true);
      $('#datetime_end').attr('disabled', true);
    });

    var TypeEmployee = $(".TypeEmployee").val();
    if (TypeEmployee == "") {
      $('.Department').empty();
      $('.Department').append(<?php echo Yii::app()->session['lang'] == 1 ? '"<option value >Select Division</option>"' : '"<option value >เลือกฝ่าย</option>"'; ?>);
      $('.Position').empty();
      $('.Position').append(<?php echo Yii::app()->session['lang'] == 1 ? '"<option value >Select Position</option>"' : '"<option value >เลือกแผนก</option>"'; ?>);
      $('.Leval').empty();
      $('.Leval').append(<?php echo Yii::app()->session['lang'] == 1 ? '"<option value >Select Level</option>"' : '"<option value >เลือกระดับ</option>"'; ?>);
    }
  });

  function chk_form_search() {
    var status_pass = 1;

    var start_year = $("#Year_start").val();
    var end_year = $("#Year_end").val();
 

    if (end_year != "" && start_year == "") {
      status_pass = 2;
      if (<?= Yii::app()->session['lang'] ?> == 2) {
        swal("กรุณาเลือกช่วงปีเริ่มต้น");
      } else {
        swal("Please choose start range");
      }
    }
    if (end_year == "" && start_year != "") {
      status_pass = 2;
      if (<?= Yii::app()->session['lang'] ?> == 2) {
        swal("กรุณาเลือกช่วงปีสิ้นสุด");
      } else {
        swal("Please choose end range");
      }
    }
    var start_date = $("#datetime_start").val();
    var end_date = $("#datetime_end").val();
    if (end_date != "" && start_date == "") {
      status_pass = 2;
      if (<?= Yii::app()->session['lang'] ?> == 2) {
        swal("กรุณาเลือกช่วงเวลาเริ่มต้น");
      } else {
        swal("Please choose start range");
      }
    }
    if (end_date == "" && start_date != "") {
      status_pass = 2;
      if (<?= Yii::app()->session['lang'] ?> == 2) {
        swal("กรุณาเลือกช่วงเวลาสิ้นสุด");
      } else {
        swal("Please choose end range");
      }
    }

    if (status_pass == 1) {
      $(".search").submit();
    }
  }
  $("#datetime_start").change(function() {
    $("#datetime_end").val("");
    $("#Year_start").val("");
    $("#Year_end").val("");
  });
  $("#datetime_end").change(function() {
    var first = new Date($("#datetime_start").val());
    var current = new Date($(this).val());

    if (first.getTime() > current.getTime()) {
      if (<?= Yii::app()->session['lang'] ?> == 2) {
        swal("ไม่สามารถเลือกช่วงเวลาสิ้นสุดมากกว่าช่วงเวลาเริ่มต้นได้");
      } else {
        swal("Can't choose end range more than start range");
      }
      $(this).val("");
    }
    $("#Year_start").val("");
    $("#Year_end").val("");
  });

  $("#Year_start").change(function() {
    $("#Year_end").val("");
    $("#datetime_start").val("");
    $("#datetime_end").val("");
  });
  $("#Year_end").change(function() {
    var first = $("#Year_start").val();
    var current = $(this).val();
    if (first > current && current != "") {
      if (<?= Yii::app()->session['lang'] ?> == 2) {
        swal("ไม่สามารถเลือกช่วงปีสิ้นสุดมากกว่าช่วงปีเริ่มต้นได้");
      } else {
        swal("Can't choose end range more than start range");
      }
      $(this).val("");
    }
    $("#datetime_start").val("");
    $("#datetime_end").val("");
  });

  $(".TypeEmployee").change(function() {
    var id = $(this).val();
    $.ajax({
      type: 'POST',
      url: "<?= Yii::app()->createUrl('report/ListDepartment'); ?>",
      data: {
        id: id
      },
      success: function(data) {

        $('.Department').empty();
        $('.Department').append(data);

        $('.Position').val("");
        $('.Leval').val("");

        var e = document.getElementById("TypeEmployee");
        var strUser = e.options[e.selectedIndex].value;
        if (strUser == '1') {
          var lang = <?php echo Yii::app()->session['lang'] ?>;
          if (lang == 1) {
            var DepartmentText = "Department";
            var DivisionText = "Division";
            var DepartmentLabel = "Position";
            var DepartmentList = "<option value >Select Position</option>";

          } else {
            var DepartmentText = "แผนก";
            var DivisionText = "ฝ่าย";
            var DepartmentList = "<option value >เลือกตำแหน่ง</option>";
          }
          $('#department_test').attr('disabled', false);
          $('#level_test').attr('disabled', false);
          $('.DivisionLabel').text(DepartmentText);
          $('.DepartmentLabel').text(DepartmentLabel);
          $('.Position').empty();
          $('.Position').append(DepartmentList);
          $('.tag_status').show();
          $('.tag_leval').hide();
        } else if (strUser == '2') {
          var lang = <?php echo Yii::app()->session['lang'] ?>;
          if (lang == 1) {
            var DepartmentText = "Department";
            var DivisionText = "Division";
            var DepartmentList = "<option value >Select Department</option>";
          } else {
            var DepartmentText = "แผนก";
            var DivisionText = "ฝ่าย";
            var DepartmentList = "<option value >เลือกแผนก</option>";
          }
          $('#department_test').attr('disabled', true);
          $('#level_test').attr('disabled', true);
          $('.DivisionLabel').text(DivisionText);
          $('.DepartmentLabel').text(DepartmentText);
          $('.Position').empty();
          $('.Position').append(DepartmentList);
          $('.tag_status').hide();
          $('.tag_leval').show();
        }
      }
    });
  });
  $(".Department").change(function() {
    var id = $(this).val();
    var Emp_id = $(".TypeEmployee").val();
    $.ajax({
      type: 'POST',
      url: "<?= Yii::app()->createUrl('report/ListPosition'); ?>",
      data: {
        id: id,
        Emp_id: Emp_id
      },
      success: function(data) {
        $('#department_test').attr('disabled', true);
        $('#level_test').attr('disabled', true);
        $('.Position').empty();
        $('.Position').append(data);
        $('.Leval').val("");
        $('#department_test').attr('disabled', false);
      }

    });
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
        $('#level_test').attr('disabled', false);
      }
    });
  });

  $(".search").click(function() {

    var TypeEmployee = $(".TypeEmployee").val();
    var Department = $(".Department").val();
    var Position = $(".Position").val();
    var Leval = $(".Leval").val();
    var status = $(".status").val();
    //var Chart = $("input[name='accommodation']:checked").val();
    var Chart = $('input[name="accommodation"]:checked').serialize();
    var datetime_start = $("#datetime_start").val();
    var datetime_end = $("#datetime_end").val();
    var Year_start = $(".year_start").val();
    var Year_end = $(".year_end").val();

    var alert_message = "<?php echo Yii::app()->session['lang'] == 1 ? 'Warning message! ' : 'ข้อความแจ้งเตือน!'; ?>";
    var authority = <?php echo $authority ?>;
    var type_em = <?php echo $type_em ?>;
    if (authority == 3 && type_em == 1 || authority == 2 && type_em == 1) {
      TypeEmployee = 1;
    } else if (authority == 3 && type_em == 2 || authority == 2 && type_em == 1) {
      TypeEmployee = 2;
    }
    if (TypeEmployee == '' || TypeEmployee === null || typeof TypeEmployee === 'undefined') {
      var TypeEmployeeAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please select staff type! ' : 'กรุณาเลือกประเภทพนักงาน!'; ?>";
      swal(alert_message, TypeEmployeeAlert)
      return false;
    }
    if (TypeEmployee === 1 || TypeEmployee === '1') {
      var status = $(".status").val();
      if (status === '' || status === null) {
        var statusAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please select an approval status! ' : 'กรุณาเลือกสถานะอนุมัติ!'; ?>";
        swal(alert_message, statusAlert)
        return false;
      }

    }


    // else if(Department == '' || Department === null) {
    //       var DepartmentAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please select department! ' : 'กรุณาเลือกฝ่าย!'; ?>";
    //       swal(alert_message,DepartmentAlert)
    //       return false; 
    // }
    // else if(typeof  Chart === 'undefined' || Chart === null) {
    //       var ChartAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please select Bar Graph or Pie Charts! ' : 'กรุณาเลือกBar Graph หรือ Pie Charts!'; ?>";
    //       swal(alert_message,ChartAlert)
    //       return false; 
    // }else if(datetime_start === '') {
    //       var datetime_startAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please choose a starting period! ' : 'กรุณาเลือกช่วงเวลาเริ่มต้น!'; ?>";
    //       swal(alert_message,datetime_startAlert)
    //       return false; 
    // }else if(datetime_end === '') {
    //       var datetime_endAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please select an end period! ' : 'กรุณาเลือกช่วงเวลาสิ้นสุด!'; ?>";
    //       swal(alert_message,datetime_endAlert)
    //       return false; 
    // }
    if (datetime_start != null || datetime_end != null || datetime_start != "" || datetime_end != "") {
      if (datetime_start != "" && datetime_end === "") {
        return false;
      }

      if (datetime_end != "" && datetime_start === "") {
        return false;
      }

    }

    if (Year_start != null || Year_end != null) {
      if (Year_start == null && Year_end != null) {
        var year_startAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please select a Year start! ' : 'กรุณาเลือกช่วงปีเริ่มต้น!'; ?>";
        swal(alert_message, year_startAlert)
        return false;
      }

      if (Year_start != null && Year_end == null) {
        var year_endtAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please select a Year end! ' : 'กรุณาเลือกช่วงปีสิ้นสุด!'; ?>";
        swal(alert_message, year_endtAlert)
        return false;
      }
      if (Chart == "") {
        var ChartAlert = "<?php echo Yii::app()->session['lang'] == 1 ? 'Please select a graph! ' : 'กรุณาเลือกรูปแบบกราฟ!'; ?>";
        swal(alert_message, ChartAlert)
        return false;
      }
    }
    $.ajax({
      type: 'POST',
      url: "<?= Yii::app()->createUrl('report/reportRegisterData'); ?>",
      data: {
        TypeEmployee: TypeEmployee,
        Department: Department,
        Position: Position,
        Leval: Leval,
        status: status,
        Chart: Chart,
        datetime_start: datetime_start,
        datetime_end: datetime_end,
        Year_start: Year_start,
        Year_end: Year_end,
        status: status,

      },
      success: function(data) {
        if (Chart != "") {
          if (typeof Year_start === 'undefined' || typeof Year_end === 'undefined' || Year_start === null || Year_end === null) {

            if (Chart === "accommodation=Bar_Graph") {

              $('.Graph_1').show();
              $('.Graph_2').hide();
              $('.Graph_3').hide();
              $('.Graph_4').hide();

            } else if (Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {
              $('.Graph_1').show();
              $('.Graph_2').show();
              $('.Graph_3').hide();
              $('.Graph_4').hide();

            } else if (Chart === "accommodation=Pie_Charts") {
              $('.Graph_1').hide();
              $('.Graph_2').show();
              $('.Graph_3').hide();
              $('.Graph_4').hide();

            }
          } else {

            if (Chart === "accommodation=Bar_Graph") {
              $('.Graph_1').show();
              $('.Graph_2').show();
              $('.Graph_3').hide();
              $('.Graph_4').hide();

            } else if (Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {
              $('.Graph_1').show();
              $('.Graph_2').show();
              $('.Graph_3').show();
              $('.Graph_4').show();

            } else if (Chart === "accommodation=Pie_Charts") {
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