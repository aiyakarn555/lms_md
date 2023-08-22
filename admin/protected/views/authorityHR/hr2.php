<?php
$titleName = 'จัดการ HR คนที่ 2';
$this->breadcrumbs=array($titleName);
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

       <h3>รายชื่อ HR คนที่ 2</h3>
       <table class="table table-bordered" id="user_board">
         <thead>
          <tr>
            <th width="5%" style="text-align: center;">ลำดับ</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ - นามสกุล</th>
             <th>Oracle Department</th>
            <th>Sub - Department</th>
            <th>Oracle Position</th>
            <th>Work Location</th>
            <th width="5%">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($user)){
            $no = 1;
            foreach ($user as $key => $value) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $no; $no++; ?></td>
                <td><?= $value->profile->staff_id ?></td>
                <td><?= $value->profile->firstname_en." ".$value->profile->lastname_en ?></td>
                <td><?= $value->division->div_title ?></td>
                <td><?= $value->dep->dep_title ?></td>
                <td><?= $value->posi->position_title ?></td>
                <td><?= $value->profile->worklo->work_location ?></td>
                <td>
                  <button type="button" class="btn btn-danger" onclick="if(confirm('แน่ใจว่าต้องการลบ <?= $value->profile->firstname." ".$value->profile->lastname ?> ?')){Deleteuser(<?= $value->id ?>);}else{ }" >
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                  </button>
                </td>
              </tr>
              <?php
            }
          }else{
            ?>
            <tr>
              <td colspan="3">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }
           ?>
         </tbody>
      </table>
      <hr><br><br>

      
      
     

      <h3>รายชื่อทั้งหมด</h3>
      <form action="<?= $this->createUrl('AuthorityHR/hr2') ?>" method="GET">
       <table class="table table-bordered" id="user_list">
         <thead>
          <tr>            
            <th width="5%"></th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ - นามสกุล</th>
             <th>Oracle Department</th>
            <th>Sub - Department</th>
            <th>Oracle Position</th>
            <th>Work Location</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($userAll)){
            foreach ($userAll as $key => $value) {
              ?>
              <tr>
                <td><input type="checkbox" name="user_list[]" value="<?= $value->id ?>"></td>
                <td><?= $value->profile->staff_id ?></td>
                <td><?= $value->profile->firstname_en." ".$value->profile->lastname_en ?></td>
                <td><?= $value->division->div_title ?></td>
                <td><?= $value->dep->dep_title ?></td>
                <td><?= $value->posi->position_title ?></td>
                <td><?= $value->profile->worklo->work_location ?></td>

              </tr>
              <?php
            }
          }else{
            ?>
            <tr>
              <td colspan="2">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }




           ?>
        </tbody>
      </table>
      <br>
      <button type="submit" class="btn btn-success">+ เพิ่ม HR คนที่ 2</button>
      </form>




    </div>
  </div>
</div>
<script type="text/javascript">
  
  function Deleteuser(user) {
    if(user != ""){
      $.ajax({
        type: 'POST',
        url: '<?= $this->createUrl('AuthorityHR/hr2') ?>',
        data: ({
          user_id:user,
        }),
        success: function(data) {
          if(data == "success"){
            location.reload();
          }         
       }
     });
    }
  }

</script>