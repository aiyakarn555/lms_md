
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
       <b>รายชื่อ</b><br>
      <table class="table table-bordered" id="user-list">
         <thead>
          <tr>
           <?php if($modelall){ ?>
            <th><input name="select_all" onclick="toggle(this);" value="1" id="example-select-all" type="checkbox" /></th>
          <?php } ?>
            <th>Name</th>
            <th>Email</th>


          </tr>
        </thead>
        <tbody>
          <?php 

          if($modelall){
          foreach ($modelall as $key => $userItem) {
           ?>
           <tr>
             <?php if($modelall){ ?>
            <td><input name="chk_<?php echo $userItem->id; ?>" value="<?php echo $userItem->id; ?>" type="checkbox" id="chk_id_test_<?php echo $userItem->id; ?>" class="chk_id" onchange="myFunction(<?= $userItem->id; ?>)"/></td>
             <?php } ?>
            <td><?= $userItem->profiles->firstname.' '.$userItem->profiles->lastname ?></td>
            <td><?= $userItem->email ?></td>

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
      <form enctype="multipart/form-data" id="frm-example" action="<?=$this->createUrl('OrgChart/CreateUser/')?>" method="post">

   <input type="hidden" name="org_id" value="<?= $_GET['orgchart_id'] ?>">
   <input type="hidden" name="course_id" value="<?= $_GET['id'] ?>">

      <?php foreach ($modelall as $key => $val) { ?>

      <input type="hidden" name="chk_val_[<?= $val->id ?>]"  class="chk_val_cl" id="chk_test<?= $val->id ?>"><br>

    <?php   } ?>
    <!-- onclick="Savenew()" -->
       <input type="Submit"  class="btn btn-info btn-lg center-block btn-rigis" value="บันทึกข้อมูล">
     </form>

      </p>
    <!-- </form> -->
      <b>รายชื่อ ที่เพิ่ม</b><br>
     <!--  <pre id="example-console">
      </pre> -->

       <table class="table table-bordered" id="user-list">
         <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>ลบ</th>

          </tr>
        </thead>
        <tbody>
          <?php 

          if($model){
          foreach ($model as $key => $userItem) {
           ?>
           <tr>
            <td><?= $userItem->profiles->firstname.' '.$userItem->profiles->lastname ?></td>
            <td><?= $userItem->email ?></td>
              <td class="center"><button type="button" class="btn btn-danger"  onclick="Deleteuser(<?= $userItem->id ?>);" ><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
          </tr>
          <?php  }

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

foreach ($model as $key => $userItem) { ?>
  <input type="hidden" name="user_id_all" class="user_id_all_cl" value="<?= $userItem->id ?>">
<?php  } ?>


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


function toggle(source , all) {
      
   var id = $("#chk_val_all").val();

    var all = document.getElementById("example-select-all");

    $(".chk_id").each(function (i, v) {

        var test_chk = document.getElementById("chk_id_test_"+$(this).val());
        if(all.checked){
          test_chk.checked = true;
          $("#chk_test"+$(this).val()).val($(this).val());
        }else{
          test_chk.checked = false;
           $("#chk_test"+$(this).val()).val(null);
        }

    });

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


       var id_arr= Array();
        $(".chk_val_cl").each(function (i, v) {
          alert($(this).val());
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