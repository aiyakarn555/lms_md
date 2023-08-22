
<?php
$titleName = 'จัดการหลักสูตร';
$formNameModel = 'CourseOnline';

$this->breadcrumbs=array($titleName);
?>
<?php
                ?>
<!--  <form enctype="multipart/form-data" id="frm-example" action="<?=$this->createUrl('OrgChart/CheckUser/').'/'.$_GET['id']?>?orgchart_id=<?=$_GET['orgchart_id']?>&all=<?=$_GET['all']?>" method="post"><div class="container-fluid"> -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
       <b>รายชื่อ ที่ลบ</b><br>
      <table class="table table-bordered" id="user-list">
         <thead>
          <tr>
           <?php if($model){ ?>
            <th><input name="select_all" onclick="toggle(this , 'all');" value="1" id="example-select-all" type="checkbox" /></th>
          <?php } ?>
            <th>Identification</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <?php if($state == "personnel_office") { ?>
                <th>แผนก</th>
                <!-- <th>Department</th> -->
                <th>ตำแหน่ง</th>
                <!-- <th>Position</th> -->
                <th>Level</th>
            <?php }elseif ($state == "master_captain") { ?>
                <!-- <th>Department</th> -->
                <th>แผนก</th>
                <th>ตำแหน่ง</th>
                <!-- <th>Position</th> -->
            <?php }elseif ($state == "state_dep_office") { ?>
                <th>ตำแหน่ง</th>
                <!-- <th>Position</th> -->
                <th>Level</th>
            <?php }elseif ($state == "state_dep_captain") { ?>
                <th>ตำแหน่ง</th>
                 <!-- <th>Position</th> -->
            <?php }elseif ($state == "state_posi_office") { ?>
                <th>Level</th>
           <?php } ?>


          </tr>
        </thead>
        <tbody>
          <?php 

          if($model){
          foreach ($model as $key => $userItem) {
           ?>
           <tr>
             <?php if($model){ ?>
            <td><input name="chk_<?php echo $userItem->id; ?>" value="<?php echo $userItem->id; ?>" type="checkbox" class="chk_id" onchange="myFunction(<?= $userItem->id; ?>)"/></td>
             <?php } ?>
            <td><?= $userItem->identification ?></td>
            <td><?= $userItem->profiles->firstname.' '.$userItem->profiles->lastname ?></td>
            <td><?= $userItem->email ?></td>
            <td><?= $userItem->profiles->phone ?></td>

           <?php if($state == "personnel_office"){ ?>
              <td><?= $userItem->department->dep_title ?></td>
              <td><?= $userItem->position->position_title ?></td>
              <td><?= $userItem->branch->branch_name ?></td>
            <?php }elseif ($state == "master_captain") { ?>
              <td><?= $userItem->department->dep_title ?></td>
              <td><?= $userItem->position->position_title ?></td>
            <?php }elseif ($state == "state_dep_office") { ?>
              <td><?= $userItem->position->position_title ?></td>
              <td><?= $userItem->branch->branch_name ?></td>
            <?php }elseif ($state == "state_dep_captain") { ?>
              <td><?= $userItem->position->position_title ?></td>
            <?php }elseif ($state == "state_posi_office") { ?>
              <td><?= $userItem->branch->branch_name ?></td>
            <?php } ?>

          </tr>
          <?php }
          }else{?>
             <td colspan ="999">ไม่พบข้อมูล</td>
         <?php }
           ?>
          




        </tbody>

      </table>
      <hr>
      <!-- <p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p> -->
      <p>
      <input type="hidden" name="chk_val_all" id="chk_val_all">

      <!-- <button>Submit</button> -->
      <?php foreach ($model as $key => $val) { ?>

      <input type="hidden" name="chk_val_[<?= $val->id ?>]" class="chk_val_cl" id="chk_test<?= $val->id ?>"><br>

    <?php   } ?>
       
       <input type="button" onclick="Savenew()" class="btn btn-info btn-lg center-block btn-rigis" value="บันทึกข้อมูล">
      </p>
    <!-- </form> -->
      <b>รายชื่อ ที่เพิ่ม</b><br>
     <!--  <pre id="example-console">
      </pre> -->

       <table class="table table-bordered" id="user-list">
         <thead>
          <tr>
            <th>Identification</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <?php if($state == "personnel_office") { ?>
                <!-- <th>Department</th> -->
                <th>แผนก</th>
                <!-- <th>Position</th> -->
                <th>ตำแหน่ง</th>
                <th>Level</th>
            <?php }elseif ($state == "master_captain") { ?>
                <th>แผนก</th>
                <!-- <th>Department</th> -->
                <th>ตำแหน่ง</th>
                <!-- <th>Position</th> -->
            <?php }elseif ($state == "state_dep_office") { ?>
                <th>ตำแหน่ง</th>
                <!-- <th>Position</th> -->
                <th>Level</th>
            <?php }elseif ($state == "state_dep_captain") { ?>
                <th>ตำแหน่ง</th>
                 <!-- <th>Position</th> -->
            <?php }elseif ($state == "state_posi_office") { ?>
                <th>Level</th>
           <?php } ?>
            <th>ลบ</th>

          </tr>
        </thead>
        <tbody>
          <?php 

          if($modelall){
          foreach ($modelall as $key => $userItem) {
           ?>
           <tr>
            <td><?= $userItem->identification ?></td>
            <td><?= $userItem->profiles->firstname.' '.$userItem->profiles->lastname ?></td>
            <td><?= $userItem->email ?></td>
            <td><?= $userItem->profiles->phone ?></td>

           <?php if($state == "personnel_office"){ ?>
              <td><?= $userItem->department->dep_title ?></td>
              <td><?= $userItem->position->position_title ?></td>
              <td><?= $userItem->branch->branch_name ?></td>
            <?php }elseif ($state == "master_captain") { ?>
              <td><?= $userItem->department->dep_title ?></td>
              <td><?= $userItem->position->position_title ?></td>
            <?php }elseif ($state == "state_dep_office") { ?>
              <td><?= $userItem->position->position_title ?></td>
              <td><?= $userItem->branch->branch_name ?></td>
            <?php }elseif ($state == "state_dep_captain") { ?>
              <td><?= $userItem->position->position_title ?></td>
            <?php }elseif ($state == "state_posi_office") { ?>
              <td><?= $userItem->branch->branch_name ?></td>
            <?php } ?>
              <td class="center"><button type="button" class="btn btn-danger"  onclick="Deleteuser(<?= $userItem->id ?>);" ><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
          </tr>
          <?php } 

           }else{?>
             <td colspan ="999">ไม่พบข้อมูล</td>
         <?php }
           ?>

        </tbody>

      </table>





    </div>
  </div>
</div>

<?php 

  foreach ($modelall as $key => $userItem) { ?>
              <input type="hidden" name="user_id_all" class="user_id_all_cl" value="<?= $userItem->id ?>">
          <?php } ?>


<!-- </form> -->
<script>


function myFunction(val) {

   var id = $("#chk_test"+val).val();
  if(id == val){
  $("#chk_test"+val).val("");
  }else{
    $("#chk_test"+val).val(val);
  }



}

//   $( ".chk_id" ).change(function() {
//     var val = $(".chk_id").val();
// alert(val);
// });



function toggle(source , all) {
      
   var id = $("#chk_val_all").val();


    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }

    if(id == all){
      $("#chk_val_all").val("");
    }else{
      $("#chk_val_all").val(all);
    }
    
}

function Savenew() {
  var all = $("#chk_val_all").val();

  var org_id = <?= $_GET['orgchart_id'] ?>;
   var course_id = <?=  $_GET['id'] ?>;

  if(!all){
       var id_arr= Array();
  $(".chk_val_cl").each(function (i, v) {
   id_arr[i] = $(this).val();
 });

      $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl('OrgChart/CreateUser'); ?>',
            data: ({
              id_arr:id_arr,
              org_id:org_id,
              course_id:course_id

            }),
            success: function(data) {
           // swal("Good job!", "เพิ่มผู้ใช้งานสำเร็จ", "success");
            location.reload();
            }
        });


  }else{

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl('OrgChart/CreateUser'); ?>',
            data: ({
              all:all,
              org_id:org_id,
              course_id:course_id
            }),
            success: function(data) {
           // swal("Good job!", "เพิ่มผู้ใช้งานสำเร็จ", "success");
           location.reload();
            }
        });

  }

    
}



</script>
        <script type="text/javascript">

          function Deleteuser(id) {

           var id_arr= Array();
           $(".user_id_all_cl").each(function (i, v) {
            // if(id !=  $(this).val()){
             id_arr[i] = $(this).val();
            // }
           });

            var id_all = id_arr;
            var org_id = <?= $_GET['orgchart_id'] ?>;
            var course_id = <?=  $_GET['id'] ?>;
            var user_id = id;
           $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl('OrgChart/DelteUser'); ?>',
            data: ({
              user_id:user_id,
              org_id:org_id,
              course_id:course_id,
              id_all:id_all
            }),
            success: function(data) {
           // swal("Good job!", "ลบผู้ใช้งานสำเร็จ", "success");
           location.reload();
            }
        });
          }
        </script>