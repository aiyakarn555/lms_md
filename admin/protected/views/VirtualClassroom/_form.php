<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.css">

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dataTables.min.css"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet"/>
<style>
  .radio-inline{
    display: inline-block;
    margin: 5px;
  }
  .radio-inline input{
    height: 15px;
    width: 15px;
    margin: 0;
  }
  .table-importlearn{
   height: 400px;
   display: inline-block;
   width: 100%;
   overflow: auto;
 }
 .import-tablearn{
    font-size: 18px;
    padding-bottom: 10px;
    font-weight: 600;

 }
 .fullname-learn{
  padding: 8px 8px;
  width:100%;
  display: block;
  border-bottom: 1px solid #ddd;
 }
 .table-importlearn tr{
  font-size: 16px;
  display: block;
  width: 100%
 }
 .th-fullname{
  font-size:18px;
  text-align: left;
  padding: 10px 10px;
  background-color: rgba(0, 0, 0, 0.1);
 }
 .noti-date{
  background-color: #ddd;
  border-radius: 4px; 
  padding: 4px 6px;
 }
 #director_ids_chosen{
  width: auto;
 }
</style>


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script >


  function typeradio(val){
    if(val == '1') {
      $('.user_room').hide();
      $('.user-mail').hide();
      
    } 
    else if(val == '2'){
      $('.user_room').show();
      $('.user-mail').show();
    }
  }

  function typestatus(val){
    if(val == '1') {
      $('.user_room').hide();
    } 
    else if(val == '2'){
      $('.user_room').show();
    }
  }
//------------------------------------------- ผอ -------------------------------------------------//
$(document).ready(function() {
  
   $('.check-select').hide();

  var t2 =   $('#exampledirector').DataTable( {
    "columnDefs": [
    {
      "searchable": false,
      "orderable": false,
      "targets": 0
    },
    {
      "targets": [ 3 ],
      "visible": false,
      "searchable": false
    }
    ]
  } );


<?php if(!empty($_GET['id'])){ ?>
     $.ajax({
          type: 'POST',
          dataType: 'json',
          url: "<?= $this->createUrl('VirtualClassroom/getUser'); ?>",
          data : { id: <?= $_GET['id']; ?> },
          success: function(data) {
              t2.rows.add(data).draw();
          }  
        }); 
     <?php } ?>

  var counter = 0;

  t2.on( 'order.dt search.dt', function () {
    t2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
      cell.innerHTML = i+1;
    } );
  } ).draw();

  $("#director_ids").chosen().change(function(){
    values = $("#director_ids option:selected").text();
    var iddirector = $("#director_ids").chosen().val();
    var name = $("#director_ids_"+iddirector).attr("data-name");
    var firstname = $("#user_"+iddirector).attr("data-firstname");
    var lastname = $("#user_"+iddirector).attr("data-lastname");
    var prefix = $("#user_"+iddirector).attr("data-prefix");
    t2.row.add( [
      '',
      name,
      '<a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ"><i></i></a>',          
      iddirector,
      firstname,
      lastname,
      prefix
      ] ).draw( false );

    $("#director_ids option:selected").attr('disabled','disabled');
     $(".check-select").attr('style','display:block');

    $('#director_ids').trigger("chosen:updated");
        // counter++;
        var datadirector = t2.data().toArray();

        var num_learner = $('#VRoom_number_learn').val();
        if(num_learner == datadirector.length ){
          $('#director_ids_chosen').hide();
          $('.remove-cho').hide();
          
        }else{
         $('#director_ids_chosen').show();
         $('.remove-cho').show();
       }
     } );

  $('#check-learn').on( 'click', function () {
    var data = t2.data().toArray();
    var json_data = JSON.stringify(data);
    $.ajax({
      type: 'post',
      url: ' <?php echo CController::createUrl('checklearn') ?>',
      data: {
        'learn_num': json_data
      }, 
      success: function(data) {
        $("#check-leran-num").html(data);
      }
    });

  } );
    // ----------------------ดึงข้อมูลใน Table ลง Input เพื่อนำค่าไปบันทึก-------------------------//


    $("form").submit(function(){
      var data = t2.data().toArray();
      $('input:hidden[name=datasetdirector]').val(JSON.stringify(data)); 
    // alert("Submitted");
  });
    // ----------------------ดึงข้อมูลใน Table ลง Input เพื่อนำค่าไปบันทึก-------------------------//

    $('#exampledirector tbody').on( 'click', 'a', function () {
      $('#director_ids_chosen').show();
      $('.remove-cho').show();
      var data = t2.row( $(this).parents('tr') ).data();
      $("#director_ids option[value=" +data[3]+ "]").removeAttr('disabled');
      $('#director_ids').trigger("chosen:updated");
      t2.row( $(this).parents('tr') ).remove().draw( false );
    } );


    $('#exampledirector tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      }
      else {
        t2.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    } );

$('#remove-chosen').on( 'click', function () {
      $('.chosen-container-single').removeClass('chosen-container-active');
      $('.chosen-container-single').removeClass('chosen-with-drop');
    } );


  } );
function upload()
{
   var alert_message ="ข้อความแจ้งเตือน!"; 
  if ($('#VRoom_name').val() == "" ) {
            var picture = "กรุณากรอกชื่อ TH";
            swal(alert_message,picture)
            return false; 
            }
  if ($('#VRoom_name_EN').val() == "" ) {
            var picture = "กรุณากรอกชื่อ EN";
            swal(alert_message,picture)
            return false; 
            }
}


//-------------------------------------------ผู้บังคับบัญชา & ผอ -------------------------------------------------//
</script>

<!-- innerLR -->
<div class="innerLR">
  <div class="widget widget-tabs border-bottom-none">
    <div class="widget-head">
      <ul>
        <li class="active">
          <a class="glyphicons edit" href="#account-details" data-toggle="tab">
            <i></i><?php echo $formtext;?>
          </a>
        </li>
      </ul>
    </div>
    <div class="widget-body">
      <div class="form">
        <?php $form=$this->beginWidget('AActiveForm', array(
          'id'=>'course-form',
         'enableClientValidation'=>true,
         'clientOptions'=>array(
           'validateOnSubmit'=>true
         ),
         'errorMessageCssClass' => 'label label-important',
         'htmlOptions' => array('enctype' => 'multipart/form-data')
       )); ?>
       <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

       <div class="row">
         <?php echo $form->labelEx($model,'name'); ?>
         <?php echo $form->textField($model,'name',array('span8','class'=>'name_thai'));?><font color="red">*</font>
         <?php echo $this->NotEmpty();?>
         <?php echo $form->error($model,'name'); ?>
       </div>
        
       <div class="row">
         <?php echo $form->labelEx($model,'name_EN'); ?>
         <?php echo $form->textField($model,'name_EN',array('span8','class'=>'name_eng'));?><font color="red">*</font>
         <?php echo $this->NotEmpty();?>
         <?php echo $form->error($model,'name_EN'); ?>
       </div>

       <div class="row">
         <?php echo $form->labelEx($model,'welcomeMsg'); ?>
         <?php echo $form->textArea($model,'welcomeMsg',array('rows'=>6, 'cols'=>50, 'class'=>'span8 tinymce')); ?>
         <?php echo $form->error($model,'welcomeMsg'); ?>
       </div>




       <div class="row">
         <?php echo $form->labelEx($model,'start_learn_room'); ?>
         <?php echo $form->textField($model,'start_learn_room',array('class' => 'default_datetimepicker','autocomplete'=>'off')); ?>
         <?php echo $this->NotEmpty();?>
         <?php echo $form->error($model,'start_learn_room'); ?>
       </div>

       <div class="row">
         <?php echo $form->labelEx($model,'end_learn_room'); ?>
         <?php echo $form->textField($model,'end_learn_room',array('class' => 'default_datetimepicker','autocomplete'=>'off')); ?>
         <?php echo $this->NotEmpty();?>
         <?php echo $form->error($model,'end_learn_room'); ?>
       </div>

       <div class="row">
        <?php echo $form->labelEx($model,'number_learn'); ?>
        <?php echo $form->textField($model,'number_learn',array('class'=>'number')); ?>  คน
        <?php echo $form->error($model,'number_learn'); ?>
      </div>
      <div class="row">
        <?php
        if (!$model->isNewRecord) {
                $criteria = new CDbCriteria;
                $criteria->addCondition('id ='.$model->id);
                $VRoom = VRoom::model()->findAll($criteria);
                 foreach ($VRoom as $key => $value) {
                     if ($value->pic_vroom) {
                  ?>
                      <img src="<?= Yii::app()->request->baseUrl; ?>/../uploads/vroom/<?= $value->id; ?>/thumb/<?= $value->pic_vroom; ?>" width="400" height="400">                                  
                 <?php } 
               }
              }?>
      </div>
      <div class="row">
          <?php echo $form->labelEx($model,'pic_vroom'); ?>
          <div class="fileupload fileupload-new" data-provides="fileupload">
              <div class="input-append">
                <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 
                'pic_vroom'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
              </div>
          </div>
          <?php echo $form->error($model,'pic_vroom'); ?>
          <div class="row">
            <font color="#990000">
              <?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 358X300
            </font>
          </div>
          <?php if ($notsave == 1) { ?>
            <p class="note"><font color="red">*ขนาดของรูปภาพไม่ถูกต้อง </font></p>
             <?php }else{} ?> 
        </div>
      <div class="row">
        <?php //echo $form->labelEx($model,'status_key'); ?>
        <!-- <div class="toggle-button" data-toggleButton-style-enabled="success"> -->
          <?php //echo $form->checkBox($model,'status_key',array(
           // 'value'=>"1", 'uncheckValue'=>"0",'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini','id'=>"check_status"
           // )); ?>
          <!-- </div> -->
          <?php //echo $form->error($model,'status_key'); ?>
        </div>

        <!-- <hr class="sele_user"> -->
        <hr class="sele_userhr" >
        <div class="row sele_user" id="sele_user_id" >

          <label class="radio-inline">
            <input type="radio" name="optradio" value="1" id="opt1" onchange="typeradio(this.value)">
            <span>เลือกผู้เข้าเรียนหลักสูตรทั้งหมด</span>
          </label>
          <label class="radio-inline">
            <input type="radio" name="optradio" value="2" id="opt2" onchange="typeradio(this.value)">
            <span>เลือกผู้เข้าเรียนหลักสูตร</span>
          </label>


        </div>
        <hr class="sele_user">

        <?php $user = User::model()->findAll(); ?>
        <div id="director" class="user_room" style="display: none;">

          <label id="lable" align="left" for="director_id" class="required">เลือกผู้เข้าเรียนหลักสูตร <span class="required">*</span></label><br>
             <div class="row form-mb-1">
                    <div class="col-md-4">
          <select id="director_ids"  name="director_id[]" data-placeholder="เลือกชื่อ..."  class="chosen-select">
           <option > </option>
           <?php foreach ($user as $key => $value) { ?>
            <option 
            id="director_ids_<?= $value->id; ?>" 
            data-name="<?= $value->profile->firstname_en.' '.$value->profile->lastname_en; ?>"
            data-prefix="คุณ" 
            data-firstname="<?= $value->profile->firstname_en ?>"
            data-lastname="<?= $value->profile->lastname_en ?>"
            value="<?php echo $value->id ?>"><?php echo  $value->profile->firstname_en.' '.$value->profile->lastname_en;   ?></option>  
            <?php } ?></select>

          <!--   <span class="remove-cho"  style="cursor: pointer;">  
             <a id="remove-chosen" class="btn-action btn-danger remove_2">ปิด</a>
           </span> -->

              </div>
         
            </div>
            <!-- <hr class="soften" /> --><br><br>

            <!-- <a class="btn btn-icon btn-danger " id="Cut"><i class="icon-remove"></i> ลบผู้ตรวจสอบโครงการที่เลือก</a><br> <br> -->
            <table id="exampledirector" class="display" style="width:100%">
              <thead>
                <tr>
                 <th>ลำดับ</th> 
                 <th>ชื่อ-นามสกุล</th>
                 <th>จัดการ</th>
                 <th>id</th>
               </tr>
             </thead>
             <tbody>
               <tfoot>

               </tfoot>

             </tbody>

           </table><br>
           <hr class="soften" />
          <!--  <div class="row buttons" align="center">
            <a href="javascript:void(0)" id="check-learn" data-toggle="modal" data-target="#modal-check"  class="btn btn-warning" >ตรวจสอบข้อมูลผู้เข้าเรียน</a><i></i>
          </div> -->
          <input type="hidden" name="datasetdirector">
        </div>
        <br>
        <div class="row buttons">
         <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','onclick'=>"return upload();"),'<i></i>บันทึกข้อมูล');?>
       </div>
       <?php $this->endWidget(); ?>
       <?php if (!$model->isNewRecord) { ?>


    <?php $vroom_log = Vroomlogmail::model()->find(
                    'vroom__id=:vroom__id ',
                    array(':vroom__id'=>$model->id)
                    );

      $user_decode = json_decode($vroom_log->logmail_user); 
      $type = 'datetime';
      $date_update = Helpers::lib()->changeFormatDate($vroom_log->update_date,$type);

      ?>


       <div class="row buttons user-mail" align="center">
            <a href="javascript:void(0)" id="check-user" class="btn btn-primary" >ส่ง email</a><i></i>
          <div style="margin-top: 10px" id="check-send-mail">
             <span class="noti-date"><i class="fa fa-calendar" aria-hidden="true"></i> <?=$date_update; ?> </span> <span class="noti-date"><i class="fa fa-users" aria-hidden="true"></i> จำนวน  <b><?= count($user_decode); ?></b> คน</span>
          </div>
          </div>
            <?php   } ?>
     </div><!-- form -->
   </div>
 </div>
</div>

<div class="modal fade" id="modal-check" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body check-body">
        <div class="tab" role="tabpanel">
          <ul class="nav nav-tabs import-tablearn" role="tablist">
            <li role="presentation" class="active preview-user">
              ตรวจสอบข้อมูลผู้เข้าเรียน

              <button type="button" class="close" style="position: absolute; right: 10px;font-size: 30px;" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </li>
          </ul>
          <div class="tab-content" id="myModalLabel2">
            <div role="tabpanel" class="tab-pane fade in active" id="preview-users">
              <div class="subscribe wow fadeInUp" id="check-leran-num">
              </div>
              <br>
              <div class="text-center pull-right">
                <button  class="btn btn-warning "  data-dismiss="modal" aria-label="Close"><i class="fa fa-sign-in" ></i> ตกลง</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php if (!$model->isNewRecord) { ?>

 <script type="text/javascript">
<?php  if($model->status_key == 1){ ?>
 $('#sele_user_id').attr('style','display:block');
 $('.user-mail').show();
<?php }else{ ?>
$('.sele_user').hide();
$('.user-mail').hide();
<?php } ?>

<?php if($model->user_learn == 'all'){ ?>
$("#opt1").attr('checked', 'checked');
 $('.user_room').hide();
<?php }else{ ?>
$("#opt2").attr('checked', 'checked');
  $('.user_room').show();
<?php } ?>


   $('#check-user').on( 'click', function () {
     $.ajax({
      type: 'POST',
      url: "<?= $this->createUrl('VirtualClassroom/sendmailuser'); ?>",
      data : { id: <?= $_GET['id']; ?> },
      success: function(data) {
        $("#check-send-mail").html(data);

        swal({
          title: "ส่งemail สำเร็จ",
          text: '',
          icon: "success",
          buttons: [false, "ยืนยัน"],
        })
      }  
    }); 

   } );
 </script>
<?php   } ?>

<script type="text/javascript">
  $('.default_datetimepicker').datetimepicker({
    // format:'Y-m-d',
    format:'Y-m-d H:i',
    step:10,
    timepickerScrollbar:false
  });
  $('.default_datetimepicker_time').datetimepicker({
    datepicker:false,
    format:'H:i'
  });
  $('#default_datetimepicker').datetimepicker({step:10});

  // $('.date').datepicker({
  //  multidate: true,
  //  clearBtn: true,
  //  format: "dd/mm/yyyy",
  //  setStartDate: "28/10/2018",
  //  language: "th"
  //  // datesDisabled: ['10/06/2018', '10/21/2018']
  //  // multidateSeparator: ";"
  //  });

</script>  
<script type="text/javascript">


/*  $("#check_status").on('change', function() {
    if ($(this).is(':checked')) {
      $('.sele_user').show();
      // $('.sele_user').hide();
      
    } else {
      $('.sele_user').hide();
    }
  });*/


  $("#VRoom_end_learn_room").change(function() {
    var first = new Date($("#VRoom_start_learn_room").val());
    var current = new Date($(this).val());
    if(first.getTime()>current.getTime()){
     alert("ไม่สามารถปรับเวลาสิ้นสุดมากกว่าวันเริ่มตั้นได้");
     $(this).val("");
   }
 });
</script>
<script>
  $(function () {
    init_tinymce();
  });
</script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/docsupport/prism.js"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/docsupport/init.js"></script>
 
 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dataTables.min.js"></script> 
<!-- END innerLR -->
