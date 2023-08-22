<?php
$titleName = 'จัดการ ผู้จัดการฝ่าย';
$this->breadcrumbs=array($titleName);
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

       <h3>รายชื่อ ผู้จัดการฝ่าย</h3>
       <table class="table table-bordered" id="user_division">
         <thead>
          <tr>
            <th width="5%" style="text-align: center;">ลำดับ</th>
            <th>ชื่อ - นามสกุล</th>
            <th width="12%">ประเภทพนักงาน</th>
            <th>ฝ่าย</th>
            <th>แผนก</th>
            <th width="5%">เลเวล</th>
            <th width="5%">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($user_division)){
            $no = 1;
            foreach ($user_division as $key => $value) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $no; $no++; ?></td>
                <td><?= $value->profile->firstname." ".$value->profile->lastname ?></td>
                <td>
                  <?php 
                  if($value->profile->type_employee == 1){
                    echo "คนเรือ";
                  }elseif($value->profile->type_employee == 2){
                    echo "คนออฟฟิศ";
                  }
                   ?>
                </td>
                <td><?= $value->department->dep_title ?></td>
                <td><?= $value->position->position_title ?></td>
                <td><?= $value->branch->branch_name ?></td>
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
              <td colspan="6">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }
           ?>
         </tbody>
      </table>
      <hr><br><br>

      <form action="<?= $this->createUrl('ReportAuthority/DivisionManager') ?>" method="GET">
        <h3 style="padding-left: 5px;">ค้นหา</h3>
        <div class="row">
         <p style="padding-left: 15px;">แผนก/ตำแหน่ง :</p>
          <div class="col-md-5"> 
            <select class="form-control" name="search[position]">
              <option value="">ทั้งหมด</option>
              <?php 
              $position = Position::model()->findAll(array(
                'condition'=>'active="y"',
                'order'=>'position_title ASC',
              ));
              if(!empty($position)){
                foreach ($position as $key => $value) {
                  ?>
                  <option <?php if(isset($_GET["search"]["position"]) && $_GET["search"]["position"] == $value->id){ echo "selected"; } ?> value="<?= $value->id ?>"><?= $value->position_title ?></option>
                  <?php
                }
              }
              ?>          
            </select>
          </div>
        </div>
        <div class="row">
         <p style="padding-left: 15px;">ชื่อ - นามสกุล :</p>
          <div class="col-md-5"> 
            <input type="text" class="form-control" name="search[fullname]" value="<?php if(isset($_GET["search"]["fullname"]) && $_GET["search"]["fullname"] != ""){ echo $_GET["search"]["fullname"]; } ?>">
          </div>
        </div>
        <button style="margin-left: 5px;" type="submit" class="btn btn-defualt">ค้นหา</button>
      </form>
     

      <h3>รายชื่อพนักงาน</h3>
      <form action="<?= $this->createUrl('ReportAuthority/DivisionManager') ?>" method="GET">
       <table class="table table-bordered" id="user_list">
         <thead>
          <tr>            
            <th></th>
            <th>ชื่อ - นามสกุล</th>
            <th>ประเภทพนักงาน</th>
            <th>ฝ่าย</th>
            <th>แผนก</th>
            <th>เลเวล</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($userAll)){
            foreach ($userAll as $key => $value) {
              ?>
              <tr>
                <td><input type="checkbox" name="user_list[]" value="<?= $value->id ?>"></td>
                <td><?= $value->profile->firstname." ".$value->profile->lastname ?></td>
                <td>
                  <?php 
                  if($value->profile->type_employee == 1){
                    echo "คนเรือ";
                  }elseif($value->profile->type_employee == 2){
                    echo "คนออฟฟิศ";
                  }
                   ?>
                </td>
                <td><?= $value->department->dep_title ?></td>
                <td><?= $value->position->position_title ?></td>
                <td><?= $value->branch->branch_name ?></td>
              </tr>
              <?php
            }
          }else{
            ?>
            <tr>
              <td colspan="6">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }




           ?>
        </tbody>
      </table>
      <br>
      <button type="submit" class="btn btn-success">+ เพิ่ม ผู้จัดการฝ่าย</button>
      </form>




    </div>
  </div>
</div>
<script type="text/javascript">
  
  function Deleteuser(user) {
    if(user != ""){
      $.ajax({
        type: 'POST',
        url: '<?= $this->createUrl('ReportAuthority/DivisionManager') ?>',
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